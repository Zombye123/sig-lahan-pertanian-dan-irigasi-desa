<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Irigasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_irigasi');
    }

    public function index($offset = 0)
    {
        $data = array(
            'title' => 'Data Irigasi',
            'irigasi'   => $this->m_irigasi->get_all_data(),
            'isi'   => 'irigasi/v_data'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function add()
    {
        $this->user_login->protek_halaman();
        $this->form_validation->set_rules('nama_irigasi', 'Nama Irigasi', 'required');
        $this->form_validation->set_rules('kondisi', 'Kondisi Irigasi', 'required');

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path'] = './gambar/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = 2000;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                // Saat error upload, tetap kirim data agar peta bisa dimuat
                $data = array(
                    'title' => 'Input Data Irigasi', 
                    'error_upload' => $this->upload->display_errors(), 
                    'irigasi' => $this->m_irigasi->get_all_data(),
                    'isi' => 'irigasi/v_add'
                );
                $this->load->view('layout/v_wrapper', $data, FALSE);
            } else {
                $upload_data = $this->upload->data();
                $data = array(
                    'nama_irigasi'  => $this->input->post('nama_irigasi'),
                    'panjang_jalur' => $this->input->post('panjang_jalur'),
                    'lebar_jalur'   => $this->input->post('lebar_jalur'),
                    'jalur_geojson' => $this->input->post('jalur_geojson'),
                    'ketebalan'     => $this->input->post('ketebalan'),
                    'warna'         => $this->input->post('warna'),
                    'kondisi'       => $this->input->post('kondisi'),
                    'gambar'        => $upload_data['file_name'],
                );
                $this->m_irigasi->add($data);
                $this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
                redirect('irigasi/add');
            }
        } else {
            // Data irigasi dikirim ke v_add agar bisa di-render di peta
            $data = array(
                'title' => 'Input Data Irigasi', 
                'irigasi' => $this->m_irigasi->get_all_data(),
                'isi' => 'irigasi/v_add'
            );
            $this->load->view('layout/v_wrapper', $data, FALSE);
        }
    }

    public function edit($id_irigasi)
    {
        $this->user_login->protek_halaman();
        $this->form_validation->set_rules('nama_irigasi', 'Nama Irigasi', 'required');

        if ($this->form_validation->run() == TRUE) {
            $data_post = array(
                'id_irigasi'    => $id_irigasi,
                'nama_irigasi'  => $this->input->post('nama_irigasi'),
                'panjang_jalur' => $this->input->post('panjang_jalur'),
                'lebar_jalur'   => $this->input->post('lebar_jalur'),
                'jalur_geojson' => $this->input->post('jalur_geojson'),
                'ketebalan'     => $this->input->post('ketebalan'),
                'warna'         => $this->input->post('warna'),
                'kondisi'       => $this->input->post('kondisi'),
            );

            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path'] = './gambar/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2000;
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $data_post['gambar'] = $upload_data['file_name'];
                }
            }

            $this->m_irigasi->edit($data_post);
            $this->session->set_flashdata('sukses', 'Data Berhasil Diupdate !!!');
            redirect('irigasi');
        }

        $data = array(
            'title'   => 'Edit Data Irigasi',
            'irigasi' => $this->m_irigasi->detail($id_irigasi),
            'isi'     => 'irigasi/v_edit'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function delete($id_irigasi)
    {
        $this->m_irigasi->delete($id_irigasi);
        $this->session->set_flashdata('sukses', 'Data Berhasil Dihapus !!!');
        redirect('irigasi');
    }
}

