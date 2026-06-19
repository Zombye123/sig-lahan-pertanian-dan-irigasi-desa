<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_prediksi extends CI_Model {

    // 1. Perbaikan: Tambahkan Join agar nama lahan & tanaman muncul
    public function get_rekomendasi_tersimpan() {
        $this->db->select("
            tbl_rekomendasi_tanaman.*, 
            tbl_lahan.nama_lahan, 
            tbl_lahan.pemilik_lahan, 
            tbl_tanaman.nama_tanaman as tanaman
        ");
        $this->db->from('tbl_rekomendasi_tanaman');
        $this->db->join('tbl_lahan', 'tbl_lahan.id_lahan = tbl_rekomendasi_tanaman.id_lahan', 'left');
        $this->db->join('tbl_tanaman', 'tbl_tanaman.id_tanaman = tbl_rekomendasi_tanaman.id_tanaman', 'left');
        $this->db->order_by('tbl_rekomendasi_tanaman.nilai_kesesuaian', 'DESC'); // Opsional: Urutkan skor tertinggi di DB
        return $this->db->get()->result_array();
    }

    public function hitung_prediksi_lahan() {
        $this->db->select("tbl_lahan.*, tbl_kondisi_lahan.*");
        $this->db->from('tbl_lahan');
        $this->db->join('tbl_kondisi_lahan', 'tbl_kondisi_lahan.id_lahan = tbl_lahan.id_lahan', 'left');
        $lahan = $this->db->get()->result();

        $tanaman = $this->db->get('tbl_tanaman')->result();
        $hasil = [];

        foreach($lahan as $l){
            $terbaik = null;
            $skor_terbaik = -1;
            foreach($tanaman as $t){
                $skor = 0;
                if(!empty($l->jenis_tanah) && $l->jenis_tanah == $t->jenis_tanah) $skor += 25;
                if(isset($l->ph_tanah) && $l->ph_tanah >= $t->ph_min && $l->ph_tanah <= $t->ph_max) $skor += 25;
                if(isset($l->curah_hujan) && $l->curah_hujan >= $t->curah_min && $l->curah_hujan <= $t->curah_max) $skor += 25;
                if(isset($l->ketinggian) && $l->ketinggian >= $t->tinggi_min && $l->ketinggian <= $t->tinggi_max) $skor += 25;
                
                if($skor > $skor_terbaik){ $skor_terbaik = $skor; $terbaik = $t; }
            }
            if(!$terbaik) continue;

            $luas = (double) preg_replace('/[^0-9.]/', '', (!empty($l->luas_ha) ? $l->luas_ha : $l->luas_lahan));
            if ($luas <= 0) $luas = 1;
            
            $hasil[] = [
                'id_lahan' => $l->id_lahan,
                'nama_lahan' => $l->nama_lahan,
                'pemilik_lahan' => $l->pemilik_lahan,
                'luas_ha' => $luas,
                'id_tanaman' => $terbaik->id_tanaman,
                'nama_tanaman' => $terbaik->nama_tanaman,
                'skor' => $skor_terbaik,
                'prediksi' => round(($luas * 5) * ($skor_terbaik / 100), 2)
            ];
        }
        return $hasil;
    }
}