<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model penunjang perhitungan SAW dan pengolahan data lahan GIS
        $this->load->model('M_spk');
        $this->load->model('M_lahan');
    }

    /*
    |--------------------------------------------------------------------------
    | Hasil SPK SAW (Halaman Utama)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data = [
            'title' => 'SPK Prioritas Bantuan',
            'hasil' => $this->M_spk->get_ranking(),
            'isi'   => 'spk/v_hasil'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /*
    |--------------------------------------------------------------------------
    | Ranking Lahan
    |--------------------------------------------------------------------------
    */
    public function ranking()
    {
        $data = [
            'title' => 'Ranking Prioritas Bantuan',
            'hasil' => $this->M_spk->get_ranking(),
            'isi'   => 'spk/v_ranking'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /*
    |--------------------------------------------------------------------------
    | Peta Prioritas Bantuan (Leaflet GIS)
    |--------------------------------------------------------------------------
    */
    public function peta()
    {
        $data = [
            'title' => 'Peta Prioritas Bantuan',
            'lahan' => $this->M_spk->get_peta(), // Memanggil data SAW dinamis yang bersih dari tbl_analisis_irigasi
            'isi'   => 'spk/v_peta'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Per Lahan
    |--------------------------------------------------------------------------
    */
    public function detail($id_lahan = null)
    {
        // Validasi parameter: Mencegah error sql injection atau blank page jika ID kosong/bukan angka
        if (!$id_lahan || !is_numeric($id_lahan)) {
            show_404();
        }

        $detail = $this->M_spk->get_detail($id_lahan);

        if (!$detail) {
            show_404();
        }

        $data = [
            'title'  => 'Detail Hasil SPK',
            'detail' => $detail,
            'isi'    => 'spk/v_detail'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard Statistik SPK
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard SPK',
            'stat'  => $this->M_spk->get_dashboard(),
            'isi'   => 'spk/v_dashboard'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /*
    |--------------------------------------------------------------------------
    | Top 5 Prioritas Bantuan
    |--------------------------------------------------------------------------
    */
    public function top5()
    {
        $data = [
            'title' => 'Top 5 Prioritas Bantuan',
            'hasil' => $this->M_spk->get_top5(),
            'isi'   => 'spk/v_top5'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    /*
    |--------------------------------------------------------------------------
    | Bottom 5 Prioritas Bantuan
    |--------------------------------------------------------------------------
    */
    public function bottom5()
    {
        $data = [
            'title' => 'Bottom 5 Prioritas Bantuan',
            'hasil' => $this->M_spk->get_bottom5(),
            'isi'   => 'spk/v_bottom5'
        ];

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }
}