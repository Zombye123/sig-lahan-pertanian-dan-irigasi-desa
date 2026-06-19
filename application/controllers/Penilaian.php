<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('M_penilaian');
        $this->load->library('session');
    }

    /* ============================================================
     * 1. DASHBOARD PENILAIAN & SPK
     * ============================================================
     */
    public function index()
    {
        $keyword = $this->input->get('keyword', TRUE);

        $data = array(
            'title'         => 'Dashboard Penilaian & SPK SAW',
            'keyword'       => $keyword,
            'statistik'     => $this->M_penilaian->get_statistik(),
            'rekap'         => $this->M_penilaian->get_rekap_penilaian($keyword),
            'grafik'        => $this->M_penilaian->grafik_penilaian(),
            'hasil_spk'     => $this->M_penilaian->get_hasil_spk(),
            'top10'         => $this->M_penilaian->top10_spk(),
            'bottom10'      => $this->M_penilaian->bottom10_spk(),
            'lahan_terbaik' => $this->M_penilaian->lahan_terbaik(),
            'isi'           => 'penilaian/v_list'
        );

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /* ============================================================
     * 2. PROSES HITUNG SPK SAW
     * ============================================================
     */
    public function hitung()
    {
        $proses = $this->M_penilaian->proses_spk();

        if ($proses['status'] == true) {
            $this->session->set_flashdata('pesan', $proses['message']);
        } else {
            $this->session->set_flashdata('error', $proses['message']);
        }

        redirect('penilaian');
    }

    /* ============================================================
     * 3. GENERATE PENILAIAN OTOMATIS (OPTIMASI BATCH INSERT)
     * ============================================================
     */
    public function generate()
    {
        $this->db->empty_table('tbl_penilaian');

        $lahan    = $this->M_penilaian->get_alternatif();
        $kriteria = $this->M_penilaian->get_kriteria();

        $batch_simpan = array();

        foreach ($lahan as $l) {
            foreach ($kriteria as $k) {
                $nilai = $this->get_nilai($l->id_lahan, $k);

                $batch_simpan[] = array(
                    'id_lahan'    => $l->id_lahan,
                    'id_kriteria' => $k->id_kriteria,
                    'nilai'       => $nilai
                );
            }
        }

        if (!empty($batch_simpan)) {
            $this->db->insert_batch('tbl_penilaian', $batch_simpan);
            $this->session->set_flashdata('pesan', 'Generate Penilaian Berhasil disimpan secara massal.');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat penilaian otomatis, periksa data master Anda.');
        }

        redirect('penilaian');
    }

    /* ============================================================
     * 4. LOGIKA PARAMETER PENILAIAN (SKALA UTAN / KATEGORISASI)
     * ============================================================
     */
    private function get_nilai($id_lahan, $kriteria)
    {
        switch ($kriteria->id_kriteria) {
            case 5:  return $this->nilai_luas($id_lahan);
            case 6:  return $this->nilai_produksi($id_lahan);
            case 7:  return $this->nilai_irigasi($id_lahan); // Memanggil fungsi bypass
            case 8:  return $this->nilai_ph($id_lahan);
            case 9:  return $this->nilai_curah($id_lahan);
            default: return 1;
        }
    }

    private function nilai_luas($id_lahan)
    {
        $row = $this->db->where('id_lahan', $id_lahan)->get('tbl_lahan')->row();
        if (!$row) return 1;

        $luas = floatval($row->luas_ha);
        if ($luas >= 5) return 5;
        if ($luas >= 3) return 4;
        if ($luas >= 2) return 3;
        if ($luas >= 1) return 2;
        return 1;
    }

    private function nilai_produksi($id_lahan)
    {
        $row = $this->db->where('id_lahan', $id_lahan)->order_by('tahun', 'DESC')->limit(1)->get('tbl_produksi')->row();
        if (!$row) return 1;

        $produktivitas = floatval($row->produktivitas);
        if ($produktivitas >= 8) return 5;
        if ($produktivitas >= 7) return 4;
        if ($produktivitas >= 6) return 3;
        if ($produktivitas >= 5) return 2;
        return 1;
    }

    // ====================================================
    // BYPASS: TIDAK MEMAKAI TABEL TBL_ANALISIS_IRIGASI
    // ====================================================
    private function nilai_irigasi($id_lahan)
    {
        // Langsung mengembalikan nilai konversi aman tanpa menyentuh database
        return 3; 
    }

    private function nilai_ph($id_lahan)
    {
        $row = $this->db->where('id_lahan', $id_lahan)->order_by('id_kondisi', 'DESC')->limit(1)->get('tbl_kondisi_lahan')->row();
        if (!$row) return 1;

        $ph = floatval($row->ph_tanah);
        if ($ph >= 6.5 && $ph <= 7.0) return 5;
        if ($ph >= 6.0) return 4;
        if ($ph >= 5.5) return 3;
        if ($ph >= 5.0) return 2;
        return 1;
    }

    private function nilai_curah($id_lahan)
    {
        $row = $this->db->where('id_lahan', $id_lahan)->order_by('id_kondisi', 'DESC')->limit(1)->get('tbl_kondisi_lahan')->row();
        if (!$row) return 1;

        $curah = floatval($row->curah_hujan);
        if ($curah >= 2500 && $curah <= 3500) return 5;
        if ($curah >= 2000) return 4;
        if ($curah >= 1500) return 3;
        if ($curah >= 1000) return 2;
        return 1;
    }
}