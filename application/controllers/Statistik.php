<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_statistik');
    }

    public function index()
    {
        // Mengumpulkan semua data statistik ke dalam array
        $data = array(
            'title'           => 'Dashboard Statistik',

            // Statistik Utama
            'total_lahan'     => $this->M_statistik->total_lahan(),
            'total_irigasi'   => $this->M_statistik->total_irigasi(),
            'total_luas'      => $this->M_statistik->total_luas(),
            'total_pemilik'   => $this->M_statistik->total_pemilik(),

            // Data Grafik & Tabel
            'tanaman'         => $this->M_statistik->statistik_tanaman(),
            'tahun'           => $this->M_statistik->statistik_tahun(),
            'pemilik'         => $this->M_statistik->top_pemilik(),
            'terbaru'         => $this->M_statistik->data_terbaru(),

            // Data Baru (Irigasi & Produksi)
            'kondisi_irigasi' => $this->M_statistik->get_kondisi_irigasi(),
            'produksi'        => $this->M_statistik->get_produksi_per_tanaman(),
            
            // Layout
            'isi'             => 'statistik/v_dashboard'
        );

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }
}