<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_kriteria');
    }

    public function index()
    {
        $data = array(
            'title' => 'Data Kriteria',
            'kriteria' => $this->M_kriteria->get_all_data(),
            'isi' => 'kriteria/v_list'
        );

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    public function add()
    {
        $data = array(
            'title' => 'Tambah Kriteria',
            'isi' => 'kriteria/v_add'
        );

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    public function save()
    {
        $data = array(
            'nama_kriteria' => $this->input->post('nama_kriteria'),
            'bobot' => $this->input->post('bobot')
        );

        $this->M_kriteria->add($data);

        redirect('kriteria');
    }

    public function edit($id_kriteria)
    {
        $data = array(
            'title' => 'Edit Kriteria',
            'kriteria' => $this->M_kriteria->detail($id_kriteria),
            'isi' => 'kriteria/v_edit'
        );

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    public function update()
    {
        $data = array(
            'id_kriteria' => $this->input->post('id_kriteria'),
            'nama_kriteria' => $this->input->post('nama_kriteria'),
            'bobot' => $this->input->post('bobot')
        );

        $this->M_kriteria->edit($data);

        redirect('kriteria');
    }

    public function delete($id_kriteria)
    {
        $this->M_kriteria->delete($id_kriteria);

        redirect('kriteria');
    }
}