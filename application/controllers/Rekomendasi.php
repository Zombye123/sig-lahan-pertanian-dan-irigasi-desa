<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekomendasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat model rekomendasi dan model lahan
        $this->load->model('M_rekomendasi');
        $this->load->model('M_lahan');
    }

    // ==================================================
    // DAFTAR REKOMENDASI (HALAMAN INDEX LIST)
    // ==================================================
    public function index()
    {
        $hasil = $this->M_rekomendasi->get_hasil();
        $statistik = [];

        foreach($hasil as $h){
            if(!empty($h->tanaman_terbaik)){
                if(!isset($statistik[$h->tanaman_terbaik])){
                    $statistik[$h->tanaman_terbaik] = 0;
                }
                $statistik[$h->tanaman_terbaik]++;
            }
        }

        $data = [
            'title'     => 'Rekomendasi Tanaman',
            'hasil'     => $hasil,
            'statistik' => $statistik,
            'isi'       => 'rekomendasi/v_list'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    // ==================================================
    // PETA REKOMENDASI (SUDAH DIPERBAIKI FULL DATA)
    // ==================================================
    public function peta()
    {
        // Ambil data lahan yang sudah dilengkapi dengan skor rekomendasi komoditas tanaman
        $hasil_rekomendasi = $this->M_rekomendasi->get_hasil();

        $data = [
            'title'     => 'Peta Rekomendasi Tanaman',
            'hasil'     => $hasil_rekomendasi,
            // PERBAIKAN CRITICAL: Ganti get_all_geo() menjadi hasil perhitungan model rekomendasi
            'dataLahan' => $hasil_rekomendasi, 
            'isi'       => 'rekomendasi/v_peta'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    // ==================================================
    // DETAIL REKOMENDASI
    // ==================================================
    public function detail($id_lahan = null)
    {
        if(!$id_lahan){
            redirect('rekomendasi');
        }

        $hasil = $this->M_rekomendasi->get_hasil();
        $detail = null;

        foreach($hasil as $h){
            if($h->id_lahan == $id_lahan){
                $detail = $h;
                break;
            }
        }

        if(!$detail){
            show_404();
        }

        $data = [
            'title'  => 'Detail Rekomendasi',
            'detail' => $detail,
            'isi'    => 'rekomendasi/v_detail'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }
}