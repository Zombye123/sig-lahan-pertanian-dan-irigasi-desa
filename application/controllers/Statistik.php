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
        $data = array(
            'title'             => 'Dashboard Statistik',

            'total_lahan'       => $this->M_statistik->total_lahan(),
            'total_irigasi'     => $this->M_statistik->total_irigasi(),
            'total_luas'        => $this->M_statistik->total_luas(),
            'total_pemilik'     => $this->M_statistik->total_pemilik(),

            'tanaman'           => $this->M_statistik->statistik_tanaman(),
            'tahun'             => $this->M_statistik->statistik_tahun(),
            'pemilik'           => $this->M_statistik->top_pemilik(),
            'terbaru'           => $this->M_statistik->data_terbaru(),

            'isi'               => 'statistik/v_dashboard'
        );

        $this->load->view('layout/v_wrapper', $data, FALSE);
    }
}