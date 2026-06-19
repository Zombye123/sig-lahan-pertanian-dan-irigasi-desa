<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekomendasi extends CI_Model
{
    public function get_hasil()
    {
        $this->db->select('
            tbl_lahan.*,
            tbl_kondisi_lahan.jenis_tanah,
            tbl_kondisi_lahan.ph_tanah,
            tbl_kondisi_lahan.sumber_air,
            tbl_kondisi_lahan.curah_hujan,
            tbl_kondisi_lahan.ketinggian
        ');
        $this->db->from('tbl_lahan');
        $this->db->join('tbl_kondisi_lahan', 'tbl_kondisi_lahan.id_lahan = tbl_lahan.id_lahan', 'left');
        
        // FIX CRITICAL: Mengelompokkan hasil query agar tidak terjadi duplikasi lahan di dropdown dan map
        $this->db->group_by('tbl_lahan.id_lahan'); 
        
        $hasil = $this->db->get()->result();

        foreach ($hasil as $row) {
            $ranking = $this->get_ranking_tanaman($row);
            $row->rekomendasi = $ranking;

            if (!empty($ranking)) {
                $row->tanaman_terbaik = $ranking[0]['tanaman']; 
                $row->alasan_rekomendasi = 'Tanaman ' . $ranking[0]['tanaman'] . ' sangat direkomendasikan dengan tingkat kecocokan ' . $ranking[0]['skor'] . '% karena sesuai dengan kondisi ' . $ranking[0]['alasan'] . '.';
            } else {
                $row->tanaman_terbaik = 'Tidak Ada';
                $row->alasan_rekomendasi = 'Belum ada komoditas tanaman yang sesuai dengan parameter lahan saat ini.';
            }
        }
        return $hasil;
    }

    private function get_ranking_tanaman($lahan)
    {
        $tanaman = $this->db->get('tbl_tanaman')->result();
        $ranking = [];

        $clean = function($str) {
            return strtolower(trim(preg_replace('/\s+/', ' ', $str)));
        };

        foreach ($tanaman as $t) {
            $skor = 0;
            $alasan = [];

            // 1. Validasi Jenis Tanah
            $tanah_lahan = isset($lahan->jenis_tanah) ? $clean($lahan->jenis_tanah) : '';
            $tanah_aturan = isset($t->jenis_tanah) ? $clean($t->jenis_tanah) : '';
            if (!empty($tanah_lahan) && ($tanah_lahan == $tanah_aturan)) {
                $skor += 25;
                $alasan[] = 'Jenis Tanah (' . $t->jenis_tanah . ')';
            }

            // 2. Validasi pH Tanah
            $ph_lahan = isset($lahan->ph_tanah) ? (float)$lahan->ph_tanah : 0;
            $ph_min = isset($t->ph_min) ? (float)$t->ph_min : 0;
            $ph_max = isset($t->ph_max) ? (float)$t->ph_max : 0;
            if ($ph_lahan >= $ph_min && $ph_lahan <= $ph_max && $ph_lahan > 0) {
                $skor += 25;
                $alasan[] = 'pH Tanah';
            }

            // 3. Validasi Curah Hujan
            $hujan_lahan = isset($lahan->curah_hujan) ? (float)$lahan->curah_hujan : 0;
            $hujan_min = isset($t->curah_min) ? (float)$t->curah_min : 0;
            $hujan_max = isset($t->curah_max) ? (float)$t->curah_max : 0;
            if ($hujan_lahan >= $hujan_min && $hujan_lahan <= $hujan_max && $hujan_lahan > 0) {
                $skor += 25;
                $alasan[] = 'Curah Hujan';
            }

            // 4. Validasi Ketinggian Lahan
            $tinggi_lahan = isset($lahan->ketinggian) ? (float)$lahan->ketinggian : 0;
            $tinggi_min = isset($t->tinggi_min) ? (float)$t->tinggi_min : 0;
            $tinggi_max = isset($t->tinggi_max) ? (float)$t->tinggi_max : 0;
            if ($tinggi_lahan >= $tinggi_min && $tinggi_lahan <= $tinggi_max) {
                $skor += 25;
                $alasan[] = 'Ketinggian Lahan';
            }

            if ($skor > 0) {
                if ($skor >= 75) {
                    $kategori = 'Sangat Cocok';
                } elseif ($skor >= 50) {
                    $kategori = 'Cocok';
                } else {
                    $kategori = 'Cukup Cocok';
                }

                $ranking[] = [
                    'tanaman'  => $t->nama_tanaman,
                    'skor'     => $skor,
                    'kategori' => $kategori,
                    'alasan'   => implode(', ', $alasan)
                ];
            }
        }

        if (empty($ranking) && !empty($tanaman)) {
            $ranking[] = [
                'tanaman'  => $tanaman[0]->nama_tanaman . ' (Alternatif)',
                'skor'     => 0,
                'kategori' => 'Kurang Sesuai',
                'alasan'   => 'Kondisi fisik belum optimal'
            ];
        }

        usort($ranking, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        return $ranking;
    }
}