<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prediksi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_prediksi');
        // Tambahkan helper jika perlu
        $this->load->library('session');
    }

    public function index() {
        // PERBAIKAN: Mendefinisikan variabel title untuk v_nav
        $data['title'] = 'Rekomendasi Lahan Pertanian';
        
        $data['prediksi'] = $this->M_prediksi->get_rekomendasi_tersimpan();
        $data['isi'] = 'prediksi/v_list'; 
        $this->load->view('layout/v_wrapper', $data);
    }

    public function generate() {
        $list = $this->M_prediksi->hitung_prediksi_lahan();
        
        if (empty($list)) {
            $this->session->set_flashdata('error', 'Data lahan atau tanaman belum lengkap.');
            redirect('prediksi');
        }

        $this->db->trans_start();
        $this->db->truncate('tbl_rekomendasi_tanaman');
        
        $terpakai = [];
        foreach ($list as $p) {
            // Mencegah duplikasi id_lahan
            if (in_array($p['id_lahan'], $terpakai)) continue;
            
            $this->db->insert('tbl_rekomendasi_tanaman', [
                'id_lahan'         => $p['id_lahan'],
                'id_tanaman'       => $p['id_tanaman'],
                'nilai_kesesuaian' => $p['skor'],
                'status'           => ($p['skor'] == 100) ? 'Sangat Sesuai' : (($p['skor'] >= 75) ? 'Sesuai' : 'Cukup Sesuai'),
                'estimasi_panen'   => $p['prediksi'],
                'luas_ha'          => $p['luas_ha'],
                'tanggal'          => date('Y-m-d H:i:s')
            ]);
            $terpakai[] = $p['id_lahan'];
        }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menyimpan data ke database.');
        } else {
            $this->session->set_flashdata('sukses', 'Rekomendasi berhasil diperbarui.');
        }

        redirect('prediksi');
    }
}