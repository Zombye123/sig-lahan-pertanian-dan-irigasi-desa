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
        $lahan = $this->M_lahan->get_all_geo();
        $irigasi = $this->M_irigasi->get_all_geo();

        $hasil = [];

        foreach($lahan as $lh){

            $centroid = $this->get_centroid($lh->denah_geojson);

            $jarak_terdekat = 999999;
            $nama_irigasi = '-';

            foreach($irigasi as $ir){

                $titik_irigasi = $this->get_midpoint_line(
                    $ir->jalur_geojson
                );

                $jarak = $this->haversine(
                    $centroid['lat'],
                    $centroid['lng'],
                    $titik_irigasi['lat'],
                    $titik_irigasi['lng']
                );

                if($jarak < $jarak_terdekat){

                    $jarak_terdekat = $jarak;
                    $nama_irigasi = $ir->nama_irigasi;
                }
            }

            $status = ($jarak_terdekat <= 500)
                ? 'Terjangkau'
                : 'Belum Terjangkau';

            $hasil[] = [
                'nama_lahan' => $lh->nama_lahan,
                'irigasi' => $nama_irigasi,
                'jarak' => round($jarak_terdekat,2),
                'status' => $status
            ];
        }

        $data = [
            'title' => 'Analisis Irigasi',
            'hasil' => $hasil,
            'isi' => 'analisis/v_irigasi'
        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    private function get_centroid($geojson)
    {
        $json = json_decode($geojson,true);

        $coords =
        $json['features'][0]
        ['geometry']['coordinates'][0];

        $lat=0;
        $lng=0;
        $count=count($coords);

        foreach($coords as $c){

            $lng += $c[0];
            $lat += $c[1];
        }

        return [
            'lat'=>$lat/$count,
            'lng'=>$lng/$count
        ];
    }

    private function get_midpoint_line($geojson)
    {
        $json = json_decode($geojson,true);

        $coords =
        $json['features'][0]
        ['geometry']['coordinates'];

        $mid =
        floor(count($coords)/2);

        return [
            'lng'=>$coords[$mid][0],
            'lat'=>$coords[$mid][1]
        ];
    }

    private function haversine(
        $lat1,
        $lon1,
        $lat2,
        $lon2
    ){

        $earth = 6371000;

        $dLat =
        deg2rad($lat2-$lat1);

        $dLon =
        deg2rad($lon2-$lon1);

        $a =
        sin($dLat/2)
        * sin($dLat/2)
        +
        cos(deg2rad($lat1))
        *
        cos(deg2rad($lat2))
        *
        sin($dLon/2)
        *
        sin($dLon/2);

        $c =
        2*atan2(
            sqrt($a),
            sqrt(1-$a)
        );

        return $earth*$c;
    }
}