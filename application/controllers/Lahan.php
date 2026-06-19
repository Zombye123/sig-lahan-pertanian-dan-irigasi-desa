<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lahan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_lahan');
        $this->load->library('upload'); 
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Lahan Pertanian', 
            'lahan' => $this->m_lahan->get_all_data(), 
            'isi'   => 'lahan/v_data'
        ];
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function add()
    {
        $this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required');
        
        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']   = './gambar/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2000;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $data = ['title' => 'Input Data Lahan', 'error_upload' => $this->upload->display_errors(), 'isi' => 'lahan/v_add'];
                $this->load->view('layout/v_wrapper', $data, FALSE);
            } else {
                $upload_data = $this->upload->data();
                $luas = preg_replace('/[^0-9]/', '', $this->input->post('luas_lahan'));
                
                $data = [
                    'nama_lahan'     => $this->input->post('nama_lahan'),
                    'luas_lahan'     => $this->input->post('luas_lahan'),
                    'luas_ha'        => $this->input->post('luas_ha'), 
                    'isi_lahan'      => $this->input->post('isi_lahan'),
                    'pemilik_lahan'  => $this->input->post('pemilik_lahan'),
                    'alamat_pemilik' => $this->input->post('alamat_pemilik'),
                    'tahun'          => $this->input->post('tahun'),
                    'denah_geojson'  => $this->input->post('denah_geojson'),
                    'warna'          => $this->input->post('warna'),
                    'gambar'         => $upload_data['file_name']
                ];
                $this->m_lahan->add($data);
                $this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
                redirect('lahan');
            }
        } else {
            $data = ['title' => 'Input Data Lahan', 'isi' => 'lahan/v_add'];
            $this->load->view('layout/v_wrapper', $data, FALSE);
        }
    }

    public function edit($id_lahan)
    {
        $this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required');
        
        if ($this->form_validation->run() == TRUE) {
            $data = [
                'id_lahan'       => $id_lahan,
                'nama_lahan'     => $this->input->post('nama_lahan'),
                'luas_lahan'     => $this->input->post('luas_lahan'),
                'luas_ha'        => $this->input->post('luas_ha'),
                'isi_lahan'      => $this->input->post('isi_lahan'),
                'pemilik_lahan'  => $this->input->post('pemilik_lahan'),
                'alamat_pemilik' => $this->input->post('alamat_pemilik'),
                'tahun'          => $this->input->post('tahun'),
                'denah_geojson'  => $this->input->post('denah_geojson'),
                'warna'          => $this->input->post('warna')
            ];

            // Cek jika ada gambar baru yang diupload
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './gambar/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 2000;
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('gambar')) {
                    $gambar = $this->upload->data('file_name');
                    $data['gambar'] = $gambar;
                }
            }
            
            $this->m_lahan->edit($data);
            $this->session->set_flashdata('sukses', 'Data Berhasil Diedit !!!');
            redirect('lahan');
        }
        
        $data = [
            'title' => 'Edit Data Lahan', 
            'lahan' => $this->m_lahan->detail($id_lahan), 
            'isi'   => 'lahan/v_edit'
        ];
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function galleri()
    {
        $data = ['title' => 'Galeri Foto', 'galleri' => $this->m_lahan->get_galleri(), 'isi' => 'lahan/v_galleri'];
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function add_foto($id_lahan)
    {
        $this->form_validation->set_rules('ket', 'Keterangan Foto', 'required');
        if ($this->form_validation->run() == TRUE) {
            $config['upload_path'] = './foto/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $this->m_lahan->add_foto([
                    'id_lahan' => $id_lahan,
                    'ket'      => $this->input->post('ket'),
                    'foto'     => $this->upload->data('file_name')
                ]);
                $this->session->set_flashdata('sukses', 'Foto Berhasil Disimpan!');
                redirect('lahan/add_foto/' . $id_lahan);
            }
        }
        $data = [
            'title'   => 'Tambah Foto Lahan',
            'lahan'   => $this->m_lahan->detail($id_lahan),
            'galleri' => $this->m_lahan->detail_galleri($id_lahan),
            'isi'     => 'lahan/v_add_foto'
        ];
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }


public function galeri_lahan()
{
    // Gunakan fungsi yang sudah terbukti ada di model, yaitu get_all_data()
    $data = array(
        'title' => 'Galeri Lahan',
        'lahan' => $this->m_lahan->get_all_data(), // Ubah dari get_all_lahan ke get_all_data
        'isi'   => 'lahan/v_galleri_lahan'
    );
    
    $this->load->view('layout/v_wrapper', $data, FALSE);
}

public function view_galeri($id_lahan)
{
    $detail = $this->m_lahan->detail($id_lahan);
    
    if ($detail) {
        $data = [
            'title'   => 'Galeri Lahan: ' . $detail->nama_lahan,
            'lahan'   => $detail,
            'galleri' => $this->m_lahan->detail_galleri($id_lahan), // Pastikan ini 'galleri'
            'isi'     => 'lahan/v_view_galeri'
        ];
        $this->load->view('layout/v_wrapper', $data, FALSE);
    } else {
        redirect('lahan/galeri_lahan');
    }
}

    public function delete($id_lahan = null)
    {
        if ($id_lahan != null) {
            $this->m_lahan->delete($id_lahan);
            $this->session->set_flashdata('sukses', 'Data Lahan Berhasil Dihapus !!!');
        }
        redirect('lahan');
    }
    
    public function delete_foto($id_lahan, $id_galeri_lahan)
    {
        $this->m_lahan->delete_foto($id_lahan, $id_galeri_lahan);
        $this->session->set_flashdata('sukses', 'Foto berhasil dihapus');
        redirect('lahan/add_foto/' . $id_lahan);
    }

    public function bulk_delete()
    {
        $id_list = $this->input->post('id_lahan');
        if (!empty($id_list)) {
            $this->m_lahan->bulk_delete($id_list);
            $this->session->set_flashdata('sukses', 'Data lahan terpilih berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Tidak ada data yang dipilih!');
        }
        redirect('lahan');
    }
}