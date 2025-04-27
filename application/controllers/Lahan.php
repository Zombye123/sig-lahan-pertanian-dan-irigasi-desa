<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lahan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_lahan');
    }

    public function index()
    {
        $data = array(
            'title' => 'Data Lahan Pertanian',
            'lahan' => $this->m_lahan->get_all_data(),
            'isi'   => 'lahan/v_data'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function add()
    {
        $this->user_login->protek_halaman();
        $this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('isi_lahan', 'Isi Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('pemilik_lahan', 'Pemilik Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('alamat_pemilik', 'Alamat Pemilik Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('denah_geojson', 'Denah Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('warna', 'Warna Denah', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric', [
            'required' => '%s Harus Diisi !!!',
            'numeric'  => '%s Harus berupa angka !!!'
        ]);

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $data = array(
                    'title' => 'Input Data Lahan',
                    'error_upload' => $this->upload->display_errors(),
                    'isi'   => 'lahan/v_add'
                );
                $this->load->view('layout/v_wrapper', $data, FALSE);
            } else {
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);

                $data = array(
                    'nama_lahan'    => $this->input->post('nama_lahan'),
                    'luas_lahan'    => $this->input->post('luas_lahan'),
                    'isi_lahan'     => $this->input->post('isi_lahan'),
                    'pemilik_lahan' => $this->input->post('pemilik_lahan'),
                    'alamat_pemilik' => $this->input->post('alamat_pemilik'),
                    'denah_geojson' => $this->input->post('denah_geojson'),
                    'warna'         => $this->input->post('warna'),
                    'gambar'        => $upload_data['uploads']['file_name'],
                    'tahun'         => $this->input->post('tahun'),
                );

                $this->m_lahan->add($data);
                $this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
                redirect('lahan/add');
            }
        }

        $data = array(
            'title' => 'Input Data Lahan',
            'isi'   => 'lahan/v_add'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function galleri()
    {
        $data = array(
            'title'   => 'Galeri Foto',
            'galleri' => $this->m_lahan->get_galleri(),
            'isi'     => 'lahan/v_galleri'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function galeri_lahan()
    {
        $data = array(
            'title' => 'Galeri Lahan',
            'lahan' => $this->m_lahan->get_all_data(),
            'isi'   => 'lahan/v_galleri_lahan'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }
    
    public function view_galeri($id_lahan)
{
    // Ambil data lahan berdasarkan ID
    $data['lahan'] = $this->m_lahan->detail($id_lahan);
    $data['galeri'] = $this->m_lahan->detail_galleri($id_lahan); // Ambil galeri terkait

    // Menampilkan halaman galeri
    $data['title'] = 'Galeri Lahan';
    $data['isi'] = 'lahan/v_view_galeri'; // Halaman untuk tampilan galeri

    $this->load->view('layout/v_wrapper', $data);
}



    public function edit($id_lahan = null)
    {
        $this->user_login->protek_halaman();
        $this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('isi_lahan', 'Isi Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('pemilik_lahan', 'Pemilik Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('alamat_pemilik', 'Alamat Pemilik Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('denah_geojson', 'Denah Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('warna', 'Warna Denah', 'required', ['required' => '%s Harus Diisi !!!']);
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric', [
            'required' => '%s Harus Diisi !!!',
            'numeric'  => '%s Harus berupa angka !!!'
        ]);

        if ($this->form_validation->run() == TRUE) {
            $config['upload_path']          = './gambar/';
            $config['allowed_types']        = '|jpg|png|jpeg';
            $config['max_size'] = 20480; // 20MB dalam KB
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $data = array(
                    'title' => 'Edit Data Lahan',
                    'error_upload' => $this->upload->display_errors(),
                    'lahan' => $this->m_lahan->detail($id_lahan),
                    'isi'   => 'lahan/v_edit'
                );
                $this->load->view('layout/v_wrapper', $data, FALSE);
            } else {
                $upload_data = array('uploads' => $this->upload->data());
                $config['image_library'] = 'gd2';
                $config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
                $this->load->library('image_lib', $config);

                $data = array(
                    'id_lahan'       => $id_lahan,
                    'nama_lahan'     => $this->input->post('nama_lahan'),
                    'luas_lahan'     => $this->input->post('luas_lahan'),
                    'isi_lahan'      => $this->input->post('isi_lahan'),
                    'pemilik_lahan'  => $this->input->post('pemilik_lahan'),
                    'alamat_pemilik' => $this->input->post('alamat_pemilik'),
                    'denah_geojson'  => $this->input->post('denah_geojson'),
                    'warna'          => $this->input->post('warna'),
                    'gambar'         => $upload_data['uploads']['file_name'],
                    'tahun'          => $this->input->post('tahun'),
                );

                $this->m_lahan->edit($data);
                $this->session->set_flashdata('sukses', 'Data Berhasil Diedit !!!');
                redirect('lahan');
            }
        }

        $data = array(
            'title' => 'Edit Data Lahan',
            'lahan' => $this->m_lahan->detail($id_lahan),
            'isi'   => 'lahan/v_edit'
        );
        $this->load->view('layout/v_wrapper', $data, FALSE);
    }

    public function add_foto($id_lahan)
    {
        // Set form validation untuk keterangan foto
        $this->form_validation->set_rules('ket', 'Keterangan Foto', 'required', ['required' => '%s Harus Diisi !!!']);

        if ($this->form_validation->run() == TRUE) {
            // Konfigurasi upload foto
            $config['upload_path'] = './foto/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 20480; // 20MB dalam KB
            $this->upload->initialize($config);

            // Cek apakah upload berhasil
            if (!$this->upload->do_upload('foto')) {
                $data = array(
                    'title' => 'Tambah Foto Lahan',
                    'lahan' => $this->m_lahan->detail($id_lahan),
                    'galleri' => $this->m_lahan->detail_galleri($id_lahan),
                    'error_upload' => $this->upload->display_errors(),
                    'isi' => 'lahan/v_add_foto'
                );
                $this->load->view('layout/v_wrapper', $data, FALSE);
            } else {
                // Ambil data hasil upload
                $upload_data = $this->upload->data();

                // Simpan data foto ke database
                $data = array(
                    'id_lahan' => $id_lahan,
                    'ket' => $this->input->post('ket'),
                    'foto' => $upload_data['file_name'],
                );
                $this->m_lahan->add_foto($data);

                $this->session->set_flashdata('sukses', 'Foto Berhasil Disimpan!');
                redirect('lahan/add_foto/' . $id_lahan);
            }
        } else {
            // Jika validasi gagal
            $data = array(
                'title' => 'Tambah Foto Lahan',
                'lahan' => $this->m_lahan->detail($id_lahan),
                'galleri' => $this->m_lahan->detail_galleri($id_lahan),
                'isi' => 'lahan/v_add_foto'
            );
            $this->load->view('layout/v_wrapper', $data, FALSE);
        }
    }

    public function delete($id_lahan = null)
    {
        if ($id_lahan != null) {
            // Hapus data lahan di tabel lahan
            $this->m_lahan->delete($id_lahan);
            $this->session->set_flashdata('sukses', 'Data Lahan Berhasil Dihapus !!!');
        }
        redirect('lahan');
    }
    
    public function delete_foto($id_lahan, $id_galeri_lahan)
    {
        // Proses penghapusan foto
        $this->db->delete('tbl_galeri_lahan', array('id_galeri_lahan' => $id_galeri_lahan));
    
        // Redirect atau beri pesan sukses
        $this->session->set_flashdata('sukses', 'Foto berhasil dihapus');
        redirect('lahan/galleri/' . $id_lahan);
    }
    
    

    
}
