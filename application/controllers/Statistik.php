<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statistik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Statistik_model');  // Load the model
    }

    public function index()
    {
        // Set title and data for the page
        $data['title'] = 'Statistik Tanaman';
        $data['grafik'] = $this->Statistik_model->get_tanaman_per_tahun();  // Fetch data for the table

        // Dynamically load the content for the page (statistik/index.php)
        $data['isi'] = $this->load->view('statistik/index', $data, TRUE);

        // Check if this is the Statistik page and load a separate wrapper for it
        $this->load->view('layout/v_wrapper_statistik', $data);  // Use a different wrapper for Statistik page
    }
}
