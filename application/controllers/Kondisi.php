<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kondisi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('M_kondisi');
        $this->load->model('M_lahan');
    }

    // ==========================
    // LIST DATA
    // ==========================
    public function index()
    {
        $data = [
            'title'   => 'Data Kondisi Lahan',
            'kondisi' => $this->M_kondisi->get_all_data(),
            'isi'     => 'kondisi/v_list'
        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    // ==========================
    // FORM TAMBAH
    // ==========================
    public function add()
    {
        $data = [
            'title' => 'Tambah Kondisi Lahan',
            'lahan' => $this->M_lahan->get_all_data(),
            'isi'   => 'kondisi/v_add'
        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    // ==========================
    // SIMPAN DATA
    // ==========================
    public function save()
    {
        $id_lahan = $this->input->post('id_lahan');

        // cek data kondisi sudah ada atau belum
        $cek = $this->M_kondisi->get_by_lahan($id_lahan);

        if ($cek) {

            $this->session->set_flashdata(
                'error',
                'Data kondisi lahan sudah ada!'
            );

            redirect('kondisi');
            return;
        }

        $data = [
            'id_lahan'     => $id_lahan,
            'jenis_tanah'  => $this->input->post('jenis_tanah'),
            'ph_tanah'     => $this->input->post('ph_tanah'),
            'sumber_air'   => $this->input->post('sumber_air'),
            'curah_hujan'  => $this->input->post('curah_hujan'),
            'ketinggian'   => $this->input->post('ketinggian')
        ];

        $this->M_kondisi->add($data);

        $this->session->set_flashdata(
            'success',
            'Data kondisi lahan berhasil disimpan'
        );

        redirect('kondisi');
    }

    // ==========================
    // FORM EDIT
    // ==========================
    public function edit($id_kondisi)
    {
        $data = [
            'title'   => 'Edit Kondisi Lahan',
            'kondisi' => $this->M_kondisi->detail($id_kondisi),
            'lahan'   => $this->M_lahan->get_all_data(),
            'isi'     => 'kondisi/v_edit'
        ];

        $this->load->view(
            'layout/v_wrapper',
            $data,
            FALSE
        );
    }

    // ==========================
    // UPDATE DATA
    // ==========================
    public function update()
    {
        $data = [
            'id_kondisi'   => $this->input->post('id_kondisi'),
            'id_lahan'     => $this->input->post('id_lahan'),
            'jenis_tanah'  => $this->input->post('jenis_tanah'),
            'ph_tanah'     => $this->input->post('ph_tanah'),
            'sumber_air'   => $this->input->post('sumber_air'),
            'curah_hujan'  => $this->input->post('curah_hujan'),
            'ketinggian'   => $this->input->post('ketinggian')
        ];

        $this->M_kondisi->edit($data);

        $this->session->set_flashdata(
            'success',
            'Data berhasil diupdate'
        );

        redirect('kondisi');
    }

    // ==========================
    // HAPUS DATA
    // ==========================
    public function delete($id_kondisi)
    {
        $this->M_kondisi->delete($id_kondisi);

        $this->session->set_flashdata(
            'success',
            'Data berhasil dihapus'
        );

        redirect('kondisi');
    }
}