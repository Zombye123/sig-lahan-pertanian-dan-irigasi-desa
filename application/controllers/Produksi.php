<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_produksi');
        $this->load->model('M_lahan');
    }

    public function index()
    {
        $data = [

            'title' => 'Data Produksi',

            'produksi' =>
            $this->M_produksi->get_all_data(),

            'isi' => 'produksi/v_list'

        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    public function add()
    {
        $data = [

            'title' => 'Tambah Produksi',

            'lahan' =>
            $this->M_lahan->get_all_data(),

            'isi' => 'produksi/v_add'

        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    public function save()
    {
        $data = [

            'id_lahan' =>
            $this->input->post('id_lahan'),

            'tahun' =>
            $this->input->post('tahun'),

            'tanaman' =>
            $this->input->post('tanaman'),

            'hasil_panen' =>
            $this->input->post('hasil_panen')

        ];

        $this->M_produksi->add($data);

        redirect('produksi');
    }

    public function edit($id_produksi)
    {
        $data = [

            'title' => 'Edit Produksi',

            'produksi' =>
            $this->M_produksi->detail($id_produksi),

            'lahan' =>
            $this->M_lahan->get_all_data(),

            'isi' => 'produksi/v_edit'

        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    public function update()
    {
        $data = [

            'id_produksi' =>
            $this->input->post('id_produksi'),

            'id_lahan' =>
            $this->input->post('id_lahan'),

            'tahun' =>
            $this->input->post('tahun'),

            'tanaman' =>
            $this->input->post('tanaman'),

            'hasil_panen' =>
            $this->input->post('hasil_panen')

        ];

        $this->M_produksi->edit($data);

        redirect('produksi');
    }

    public function delete($id_produksi)
    {
        $data = [
            'id_produksi' => $id_produksi
        ];

        $this->M_produksi->delete($data);

        redirect('produksi');
    }
}