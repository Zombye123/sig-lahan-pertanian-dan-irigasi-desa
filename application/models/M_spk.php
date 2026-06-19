<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_spk extends CI_Model
{
    /*
    |--------------------------------------------------------------------------
    | Ambil Data Kriteria
    |--------------------------------------------------------------------------
    */
    public function get_kriteria()
    {
        return $this->db
            ->order_by('id_kriteria', 'ASC')
            ->get('tbl_kriteria')
            ->result();
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil Seluruh Alternatif (Lahan) - CLEAN FROM TBL_ANALISIS_IRIGASI
    |--------------------------------------------------------------------------
    */
    public function get_alternatif()
    {
        $this->db->select("
            tbl_lahan.id_lahan,
            tbl_lahan.nama_lahan,
            tbl_lahan.luas_lahan,
            tbl_lahan.luas_ha,
            tbl_lahan.pemilik_lahan,
            tbl_lahan.alamat_pemilik,
            tbl_lahan.tahun,
            tbl_lahan.denah_geojson,
            tbl_lahan.warna,
            tbl_lahan.latitude,
            tbl_lahan.longitude,
            tbl_lahan.gambar,

            tbl_produksi.tanaman,
            tbl_produksi.hasil_panen,
            tbl_produksi.produktivitas,

            tbl_kondisi_lahan.jenis_tanah,
            tbl_kondisi_lahan.ph_tanah,
            tbl_kondisi_lahan.curah_hujan,
            tbl_kondisi_lahan.ketinggian
        "); // <-- Kolom tbl_analisis_irigasi sudah dihapus total dari SELECT

        $this->db->from('tbl_lahan');

        $this->db->join(
            'tbl_produksi',
            'tbl_produksi.id_lahan = tbl_lahan.id_lahan',
            'left'
        );

        $this->db->join(
            'tbl_kondisi_lahan',
            'tbl_kondisi_lahan.id_lahan = tbl_lahan.id_lahan',
            'left'
        );

        // <-- LEFT JOIN ke tbl_analisis_irigasi di sini sudah dihapus total

        $this->db->group_by('tbl_lahan.id_lahan');
        $this->db->order_by('tbl_lahan.id_lahan', 'ASC');

        return $this->db->get()->result();
    }

    /*
    |--------------------------------------------------------------------------
    | Mengubah sumber_data menjadi nama field database
    |--------------------------------------------------------------------------
    */
    private function field_db($sumber_data)
    {
        $pecah = explode('.', $sumber_data);
        return end($pecah);
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Nilai Maksimum dan Minimum
    |--------------------------------------------------------------------------
    */
    private function get_min_max($alternatif, $kriteria)
    {
        $max = [];
        $min = [];

        foreach($kriteria as $k){
            $field = $this->field_db($k->sumber_data);
            $nilai = [];

            foreach($alternatif as $a){
                // Jika kriteria mengarah ke tabel irigasi yang tidak ada, beri nilai default 3
                if (strpos($k->sumber_data, 'tbl_analisis_irigasi') !== false || $field == 'jarak_meter') {
                    $nilai[] = 3;
                } else {
                    $nilai[] = isset($a->$field) ? floatval($a->$field) : 0;
                }
            }

            $max[$field] = (!empty($nilai)) ? max($nilai) : 0;
            $min[$field] = (!empty($nilai)) ? min($nilai) : 0;
            
            // Atasi kondisi khusus jika nilai min/max bernilai 0 agar tidak terjadi pembagian nol (division by zero)
            if($max[$field] <= 0) $max[$field] = 1;
            if($min[$field] <= 0) $min[$field] = 1;
        }

        return [
            'max' => $max,
            'min' => $min
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi SAW
    |--------------------------------------------------------------------------
    */
    private function normalisasi($nilai, $atribut, $max, $min)
    {
        $nilai = floatval($nilai);

        if ($nilai <= 0) {
            return 0;
        }

        if (strtolower($atribut) == 'benefit') {
            if ($max <= 0) return 0;
            return $nilai / $max;
        } else {
            if ($min <= 0) return 0;
            return $min / $nilai;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Hitung SAW
    |--------------------------------------------------------------------------
    */
    public function hitung_saw()
    {
        $alternatif = $this->get_alternatif();
        $kriteria   = $this->get_kriteria();
        $minmax     = $this->get_min_max($alternatif, $kriteria);
        $hasil      = [];

        foreach($alternatif as $a){
            $total  = 0;
            $detail = [];

            foreach($kriteria as $k){
                $field = $this->field_db($k->sumber_data);
                
                // Bypass nilai jika kriteria merujuk ke tabel irigasi yang tidak ada
                if (strpos($k->sumber_data, 'tbl_analisis_irigasi') !== false || $field == 'jarak_meter') {
                    $nilai = 3; 
                } else {
                    $nilai = isset($a->$field) ? floatval($a->$field) : 0;
                }

                $max_val = isset($minmax['max'][$field]) ? $minmax['max'][$field] : 1;
                $min_val = isset($minmax['min'][$field]) ? $minmax['min'][$field] : 1;

                $normalisasi = $this->normalisasi(
                    $nilai,
                    $k->atribut,
                    $max_val,
                    $min_val
                );

                $subtotal = $normalisasi * floatval($k->bobot);
                $total   += $subtotal;

                $detail[] = [
                    'id_kriteria'   => $k->id_kriteria,
                    'nama_kriteria' => $k->nama_kriteria,
                    'field'         => $field,
                    'nilai'         => $nilai,
                    'normalisasi'   => round($normalisasi, 4),
                    'bobot'         => $k->bobot,
                    'subtotal'      => round($subtotal, 4)
                ];
            }

            $hasil[] = [
                'id_lahan'          => $a->id_lahan,
                'nama_lahan'        => $a->nama_lahan,
                'pemilik_lahan'     => $a->pemilik_lahan,
                'alamat_pemilik'    => $a->alamat_pemilik,
                'luas_lahan'        => $a->luas_lahan,
                'luas_ha'           => $a->luas_ha,
                'hasil_panen'       => $a->hasil_panen,
                'produktivitas'     => $a->produktivitas,
                'ph_tanah'          => $a->ph_tanah,
                'curah_hujan'       => $a->curah_hujan,
                'jarak_meter'       => (isset($a->jarak_meter)) ? $a->jarak_meter : 0,
                'status_jangkauan'  => (isset($a->status_jangkauan)) ? $a->status_jangkauan : 'Sedang',
                'jenis_tanah'       => $a->jenis_tanah,
                'ketinggian'        => $a->ketinggian,
                'gambar'            => $a->gambar,
                'warna'             => $a->warna,
                'geojson'           => $a->denah_geojson,
                'latitude'          => $a->latitude,
                'longitude'         => $a->longitude,
                'nilai'             => round($total, 4),
                'detail'            => $detail
            ];
        }

        /* Urutkan nilai terbesar (Descending) */
        usort($hasil, function($a, $b){
            if($a['nilai'] == $b['nilai']) return 0;
            return ($a['nilai'] < $b['nilai']) ? 1 : -1;
        });

        /* Tambahkan Ranking & Prioritas Kelayakan */
        $ranking = 1;
        foreach($hasil as &$row){
            $row['ranking'] = $ranking;

            if($ranking <= 3){
                $row['prioritas'] = 'Sangat Tinggi';
            }elseif($ranking <= 6){
                $row['prioritas'] = 'Tinggi';
            }elseif($ranking <= 10){
                $row['prioritas'] = 'Sedang';
            }else{
                $row['prioritas'] = 'Rendah';
            }
            $ranking++;
        }

        return $hasil;
    }

    /*
    |--------------------------------------------------------------------------
    | Mengambil Ranking SPK
    |--------------------------------------------------------------------------
    */
    public function get_ranking()
    {
        return $this->hitung_saw();
    }

    /*
    |--------------------------------------------------------------------------
    | Data Untuk Peta Prioritas Bantuan
    |--------------------------------------------------------------------------
    */
    public function get_peta()
    {
        return $this->hitung_saw();
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Per Lahan
    |--------------------------------------------------------------------------
    */
    public function get_detail($id_lahan)
    {
        $hasil = $this->hitung_saw();

        foreach($hasil as $row){
            if($row['id_lahan'] == $id_lahan){
                return $row;
            }
        }
        return NULL;
    }

    /*
    |--------------------------------------------------------------------------
    | Statistik Dashboard
    |--------------------------------------------------------------------------
    */
    public function get_dashboard()
    {
        $hasil  = $this->hitung_saw();
        $tinggi = 0;
        $sedang = 0;
        $rendah = 0;

        foreach($hasil as $h){
            if($h['nilai'] >= 0.80){
                $tinggi++;
            }elseif($h['nilai'] >= 0.60){
                $sedang++;
            }else{
                $rendah++;
            }
        }

        return [
            'jumlah_lahan'     => count($hasil),
            'prioritas_tinggi' => $tinggi,
            'prioritas_sedang' => $sedang,
            'prioritas_rendah' => $rendah,
            'ranking'          => $hasil
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Top 5 Prioritas Bantuan
    |--------------------------------------------------------------------------
    */
    public function get_top5()
    {
        return array_slice($this->hitung_saw(), 0, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | Bottom 5 Prioritas
    |--------------------------------------------------------------------------
    */
    public function get_bottom5()
    {
        $hasil = array_reverse($this->hitung_saw());
        return array_slice($hasil, 0, 5);
    }
}