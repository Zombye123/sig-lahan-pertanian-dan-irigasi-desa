<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_penilaian extends CI_Model
{
    /* ============================================================
     * 1. DASHBOARD & STATISTIK
     * ============================================================
     */

    public function get_statistik()
    {
        $data = new stdClass();

        // Total data master
        $data->total_lahan     = $this->db->count_all('tbl_lahan');
        $data->total_penilaian = $this->db->count_all('tbl_penilaian');
        $data->total_kriteria  = $this->db->count_all('tbl_kriteria');

        // Agregasi nilai mentah pada tabel penilaian
        $this->db->select('
            ROUND(AVG(nilai), 2) as rata_nilai,
            IFNULL(MAX(nilai), 0) as nilai_tertinggi,
            IFNULL(MIN(nilai), 0) as nilai_terendah
        ');
        $query = $this->db->get('tbl_penilaian')->row();

        $data->rata_nilai      = $query ? $query->rata_nilai : 0;
        $data->nilai_tertinggi = $query ? $query->nilai_tertinggi : 0;
        $data->nilai_terendah  = $query ? $query->nilai_terendah : 0;

        return $data;
    }

    public function get_total_per_kriteria()
    {
        return $this->db
            ->select('k.nama_kriteria, COUNT(p.id_penilaian) as jumlah')
            ->from('tbl_kriteria k')
            ->join('tbl_penilaian p', 'p.id_kriteria = k.id_kriteria', 'left')
            ->group_by('k.id_kriteria')
            ->order_by('k.id_kriteria', 'ASC')
            ->get()
            ->result();
    }

    public function grafik_penilaian()
    {
        return $this->db
            ->select('k.nama_kriteria, ROUND(AVG(p.nilai), 2) as rata')
            ->from('tbl_penilaian p')
            ->join('tbl_kriteria k', 'k.id_kriteria = p.id_kriteria')
            ->group_by('k.id_kriteria')
            ->order_by('k.id_kriteria', 'ASC')
            ->get()
            ->result();
    }

    /* ============================================================
     * 2. REKAP & DETAIL PENILAIAN (SEARCH & FILTER)
     * ============================================================
     */

    public function get_rekap_penilaian($keyword = null)
    {
        // Menggunakan teknik PIVOT dinamis (kondisional CASE WHEN) berbasis ID Kriteria 
        $this->db->select("
            l.id_lahan,
            l.nama_lahan,
            l.pemilik_lahan,
            l.luas_ha,
            IFNULL(SUM(p.nilai), 0) as total_nilai,
            IFNULL(MAX(CASE WHEN p.id_kriteria = 5 THEN p.nilai END), 0) as luas,
            IFNULL(MAX(CASE WHEN p.id_kriteria = 6 THEN p.nilai END), 0) as produksi,
            IFNULL(MAX(CASE WHEN p.id_kriteria = 7 THEN p.nilai END), 0) as irigasi,
            IFNULL(MAX(CASE WHEN p.id_kriteria = 8 THEN p.nilai END), 0) as ph,
            IFNULL(MAX(CASE WHEN p.id_kriteria = 9 THEN p.nilai END), 0) as hujan
        ");
        $this->db->from('tbl_lahan l');
        $this->db->join('tbl_penilaian p', 'p.id_lahan = l.id_lahan', 'left');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('l.nama_lahan', $keyword);
            $this->db->or_like('l.pemilik_lahan', $keyword);
            $this->db->group_end();
        }

        $this->db->group_by('l.id_lahan');
        $this->db->order_by('total_nilai', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_detail_penilaian($id_lahan)
    {
        return $this->db
            ->select('p.*, k.nama_kriteria, k.bobot, k.atribut, l.nama_lahan, l.pemilik_lahan, l.luas_ha, l.gambar')
            ->from('tbl_penilaian p')
            ->join('tbl_kriteria k', 'k.id_kriteria = p.id_kriteria')
            ->join('tbl_lahan l', 'l.id_lahan = p.id_lahan')
            ->where('p.id_lahan', $id_lahan)
            ->order_by('k.id_kriteria', 'ASC')
            ->get()
            ->result();
    }

    /* ============================================================
     * 3. OPTIMASI METODE SAW (ANTI N+1 QUERY)
     * ============================================================
     */

    public function get_kriteria()
    {
        return $this->db->order_by('id_kriteria', 'ASC')->get('tbl_kriteria')->result();
    }

    public function get_alternatif()
    {
        return $this->db->order_by('id_lahan', 'ASC')->get('tbl_lahan')->result();
    }

    /**
     * Mengambil matriks keputusan dengan memuat seluruh data ke memori sekaligus (Eager Loading)
     * Solusi permanen untuk mematikan Loop Query N+1.
     */
    public function get_matriks()
    {
        $matriks = array();
        
        // Tarik seluruh baris penilaian dalam 1x eksekusi query tunggal
        $semua_nilai = $this->db->get('tbl_penilaian')->result();
        
        // Mapping koleksi ke struktur array multi-dimensi [ID_LAHAN][ID_KRITERIA]
        foreach ($semua_nilai as $n) {
            $matriks[$n->id_lahan][$n->id_kriteria] = (float) $n->nilai;
        }
        
        return $matriks;
    }

    public function get_max_min()
    {
        // Menghitung batas Max dan Min seluruh kriteria dalam satu instruksi query terpadu
        $this->db->select('id_kriteria, MAX(nilai) as maks, MIN(nilai) as mins');
        $this->db->group_by('id_kriteria');
        $query = $this->db->get('tbl_penilaian')->result();
        
        $bounds = array('max' => array(), 'min' => array());
        foreach ($query as $row) {
            $bounds['max'][$row->id_kriteria] = (float) $row->maks;
            $bounds['min'][$row->id_kriteria] = (float) $row->mins;
        }
        return $bounds;
    }

    /* ============================================================
     * 4. PROSES INTI SPK SAW (SATU PINTU & TRANSAKSIONAL)
     * ============================================================
     */

public function proses_spk()
    {
        // 1. Memulai ACID Transaction Database
        $this->db->trans_begin();

        try {
            $kriteria   = $this->get_kriteria();
            $alternatif = $this->get_alternatif();
            $matriks    = $this->get_matriks();
            $bounds     = $this->get_max_min();

            if (empty($alternatif) || empty($kriteria)) {
                throw new Exception("Data parameter master alternatif atau kriteria kosong.");
            }

            // 2. Validasi Kelengkapan Nilai Kriteria Lahan (Mencegah Partial Matrix)
            $total_kriteria_wajib = count($kriteria);
            foreach ($alternatif as $alt) {
                $jumlah_kriteria_terisi = isset($matriks[$alt->id_lahan]) ? count($matriks[$alt->id_lahan]) : 0;
                if ($jumlah_kriteria_terisi < $total_kriteria_wajib) {
                    throw new Exception("Lahan '{$alt->nama_lahan}' belum memiliki penilaian yang lengkap untuk semua kriteria!");
                }
            }

            // 3. Perhitungan Normalisasi, Pembobotan, dan Preferensi Akhir
            $nilai_preferensi = array();
            foreach ($alternatif as $alt) {
                $total_v = 0;
                foreach ($kriteria as $krit) {
                    $x_ij = $matriks[$alt->id_lahan][$krit->id_kriteria];
                    $r_ij = 0;

                    // Rumus Normalisasi SAW
                    if ($krit->atribut == 'benefit') {
                        $max_j = $bounds['max'][$krit->id_kriteria] ?? 0;
                        $r_ij  = ($max_j > 0) ? ($x_ij / $max_j) : 0;
                    } else { // cost
                        $min_j = $bounds['min'][$krit->id_kriteria] ?? 0;
                        $r_ij  = ($x_ij > 0) ? ($min_j / $x_ij) : 0;
                    }

                    // Akumulasi Bobot W_j * R_ij
                    $total_v += ($r_ij * (float) $krit->bobot);
                }
                $nilai_preferensi[$alt->id_lahan] = round($total_v, 6);
            }

            // 4. Pengurutan Nilai Descending untuk Mendapatkan Urutan Ranking
            arsort($nilai_preferensi);

            // 5. Pembersihan Sinkronisasi Data Hasil Tabel Lama
            $this->db->empty_table('tbl_hasil_spk');

            // 6. Penyusunan Data Hasil Akhir & Pencarian Lahan Terbaik
            $batch_hasil   = array();
            $tanggal_kini  = date('Y-m-d H:i:s');
            $rank          = 1;
            $id_lahan_terbaik = null;

            foreach ($nilai_preferensi as $id_lahan => $v_i) {
                // Ambil ID Lahan peringkat 1 untuk dijadikan acuan riwayat utama
                if ($rank === 1) {
                    $id_lahan_terbaik = $id_lahan;
                }

                // Klasifikasi Status Kepatuhan Kelayakan Kelompok Lahan
                if ($v_i >= 0.90) { $status = 'Sangat Layak'; }
                elseif ($v_i >= 0.75) { $status = 'Layak'; }
                elseif ($v_i >= 0.60) { $status = 'Cukup Layak'; }
                else { $status = 'Tidak Layak'; }

                // Masuk ke tabel hasil detail (TOP 10 / BOTTOM 10)
                $batch_hasil[] = array(
                    'id_lahan'         => $id_lahan,
                    'nilai_preferensi' => $v_i,
                    'ranking'          => $rank,
                    'status'           => $status,
                    'tanggal_hitung'   => $tanggal_kini
                );

                $rank++;
            }

            // 7. Simpan Ringkasan Utama ke tbl_riwayat_spk (Diseragamkan dengan Kolom Database Anda)
            $data_riwayat = array(
                'id_lahan'        => $id_lahan_terbaik, // Mengisi kolom id_lahan dengan peringkat terbaik
                'tanggal'         => $tanggal_kini,
                'jumlah_lahan'    => count($alternatif),
                'jumlah_kriteria' => count($kriteria),
                'keterangan'      => 'Kalkulasi SPK Metode SAW Otomatis Berhasil.'
            );

            // Eksekusi Simpan ke Database
            if (!empty($batch_hasil)) {
                $this->db->insert_batch('tbl_hasil_spk', $batch_hasil);
                $this->db->insert('tbl_riwayat_spk', $data_riwayat);
            }

            // Periksa integritas query transaksi
            if ($this->db->trans_status() === FALSE) {
                throw new Exception("Kegagalan internal query SQL saat menulis data hasil.");
            }

            // Selesai & Commit permanen data
            $this->db->trans_commit();
            return array('status' => true, 'message' => 'Perhitungan SPK SAW Berhasil diperbarui secara massal.');

        } catch (Exception $e) {
            // Rollback jika terjadi kegagalan atau data tidak valid
            $this->db->trans_rollback();
            return array('status' => false, 'message' => $e->getMessage());
        }
    }

    /* ============================================================
     * 5. DASHBOARD SPK, DATA DISPLAY, TOP & BOTTOM 10
     * ============================================================
     */

    public function get_hasil_spk()
    {
        return $this->db
            ->select('h.*, l.nama_lahan, l.pemilik_lahan, l.luas_ha, l.gambar')
            ->from('tbl_hasil_spk h')
            ->join('tbl_lahan l', 'l.id_lahan = h.id_lahan')
            ->order_by('h.ranking', 'ASC')
            ->get()
            ->result();
    }

    public function top10_spk()
    {
        return $this->db
            ->select('h.*, l.nama_lahan, l.pemilik_lahan, l.luas_ha')
            ->from('tbl_hasil_spk h')
            ->join('tbl_lahan l', 'l.id_lahan = h.id_lahan')
            ->order_by('h.ranking', 'ASC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function bottom10_spk()
    {
        return $this->db
            ->select('h.*, l.nama_lahan, l.pemilik_lahan, l.luas_ha')
            ->from('tbl_hasil_spk h')
            ->join('tbl_lahan l', 'l.id_lahan = h.id_lahan')
            ->order_by('h.ranking', 'DESC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function lahan_terbaik()
    {
        return $this->db
            ->select('h.*, l.nama_lahan, l.pemilik_lahan')
            ->from('tbl_hasil_spk h')
            ->join('tbl_lahan l', 'l.id_lahan = h.id_lahan')
            ->where('h.ranking', 1)
            ->get()
            ->row();
    }

    public function detail_hasil($id_lahan)
    {
        return $this->db
            ->select('h.*, l.*')
            ->from('tbl_hasil_spk h')
            ->join('tbl_lahan l', 'l.id_lahan = h.id_lahan')
            ->where('h.id_lahan', $id_lahan)
            ->get()
            ->row();
    }

    /* ============================================================
     * 6. LAPORAN & RIWAYAT PERHITUNGAN
     * ============================================================
     */

    public function get_list_riwayat()
    {
        // Mengelompokkan log kalkulasi berdasarkan token kode_batch unik
        return $this->db
            ->select('kode_batch, tanggal_hitung, COUNT(id_lahan) as jumlah_lahan, MAX(nilai_preferensi) as nilai_tertinggi')
            ->from('tbl_riwayat_spk')
            ->group_by('kode_batch')
            ->order_by('tanggal_hitung', 'DESC')
            ->get()
            ->result();
    }

    public function get_detail_riwayat($kode_batch)
    {
        return $this->db
            ->select('r.*, l.nama_lahan, l.pemilik_lahan')
            ->from('tbl_riwayat_spk r')
            ->join('tbl_lahan l', 'l.id_lahan = r.id_lahan')
            ->where('r.kode_batch', $kode_batch)
            ->order_by('r.ranking', 'ASC')
            ->get()
            ->result();
    }
}