<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_lahan');
        $this->load->model('M_irigasi');
    }

    public function index()
    {
        $lahan   = $this->M_lahan->get_all_geo();
        $irigasi = $this->M_irigasi->get_all_geo();

        $hasil = [];

        foreach($lahan as $lh){

            $titikLahan = $this->get_polygon_points($lh->denah_geojson);

            if(empty($titikLahan)){
                continue;
            }

            $jarakTerdekat = PHP_INT_MAX;
            $namaIrigasi   = '-';

            foreach($irigasi as $ir){

                $titikIrigasi = $this->get_line_points($ir->jalur_geojson);

                if(empty($titikIrigasi)){
                    continue;
                }

                foreach($titikLahan as $pl){

                    foreach($titikIrigasi as $pi){

                        $jarak = $this->haversine(
                            $pl['lat'],
                            $pl['lng'],
                            $pi['lat'],
                            $pi['lng']
                        );

                        if($jarak < $jarakTerdekat){
                            $jarakTerdekat = $jarak;
                            $namaIrigasi   = $ir->nama_irigasi;
                        }
                    }
                }
            }

            // ========================================================
            // PENYESUAIAN KATEGORI STATUS & WARNA MAP
            // ========================================================
            // Diselaraskan dengan komponen View agar tetap sinkron.
            // Jika jarak <= 500 meter dianggap Terjangkau, sisanya Belum Terjangkau.
            if($jarakTerdekat <= 500){
                $status = 'Terjangkau';
                $warna  = '#28a745'; // Hijau (bg-success)
            } else {
                $status = 'Belum Terjangkau';
                $warna  = '#dc3545'; // Merah (bg-danger)
            }

            $hasil[] = [
                'id_lahan'       => $lh->id_lahan,
                'nama_lahan'     => $lh->nama_lahan,
                'pemilik_lahan'  => $lh->pemilik_lahan,
                'irigasi'        => $namaIrigasi,
                'jarak'          => round($jarakTerdekat,2),
                'status'         => $status,
                'warna'          => $warna
            ];
        }

        $data = [
            'title'   => 'Analisis Jangkauan Irigasi',
            'hasil'   => $hasil,
            'lahan'   => $lahan,
            'irigasi' => $irigasi,
            'isi'     => 'analisis/v_irigasi'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    // ====================================================
    // AMBIL SEMUA TITIK POLYGON LAHAN
    // ====================================================
    private function get_polygon_points($geojson)
    {
        $json = json_decode($geojson, true);

        $hasil = [];

        if(!isset($json['features'][0]['geometry'])){
            return [];
        }

        $geometry = $json['features'][0]['geometry'];

        if($geometry['type'] == 'Polygon'){
            foreach($geometry['coordinates'][0] as $coord){
                $hasil[] = [
                    'lng' => $coord[0],
                    'lat' => $coord[1]
                ];
            }
        }

        if($geometry['type'] == 'MultiPolygon'){
            foreach($geometry['coordinates'] as $poly){
                foreach($poly[0] as $coord){
                    $hasil[] = [
                        'lng' => $coord[0],
                        'lat' => $coord[1]
                    ];
                }
            }
        }

        return $hasil;
    }

    // ====================================================
    // AMBIL SEMUA TITIK JALUR IRIGASI
    // ====================================================
    private function get_line_points($geojson)
    {
        $json = json_decode($geojson, true);

        $hasil = [];

        if(!isset($json['features'][0]['geometry'])){
            return [];
        }

        $geometry = $json['features'][0]['geometry'];

        if($geometry['type'] == 'LineString'){
            foreach($geometry['coordinates'] as $coord){
                $hasil[] = [
                    'lng' => $coord[0],
                    'lat' => $coord[1]
                ];
            }
        }

        if($geometry['type'] == 'MultiLineString'){
            foreach($geometry['coordinates'] as $line){
                foreach($line as $coord){
                    $hasil[] = [
                        'lng' => $coord[0],
                        'lat' => $coord[1]
                    ];
                }
            }
        }

        return $hasil;
    }

    // ====================================================
    // RUMUS HAVERSINE (MENGHITUNG JARAK DALAM SATUAN METER)
    // ====================================================
    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earth = 6371000; // Radius bumi dalam meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earth * $c;
    }
}
// Kata 'perbaiki' yang merusak sintaks di ujung file sudah dibuang.