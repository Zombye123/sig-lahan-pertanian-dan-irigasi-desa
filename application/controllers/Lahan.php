<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lahan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('m_lahan');
	}

	// List all your items
	public function index()
	{
		$data = array(
			'title' => 'Data Lahan Pertanian',
			'lahan'	=> $this->m_lahan->get_all_data(),
			'isi'	=> 'lahan/v_data'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	// Add a new item
	public function add()
	{
		$this->user_login->protek_halaman();
		$this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('isi_lahan', 'Isi Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('pemilik_lahan', 'Pemilik Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('alamat_pemilik', 'Alamat Pemilik Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('denah_geojson', 'Denah Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('warna', 'Warna Denah', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']          = './gambar/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar')) {
				$data = array(
					'title' => 'Input Data Lahan',
					'error_upload' => $this->upload->display_errors(),
					'isi'	=> 'lahan/v_add'
				);
				$this->load->view('layout/v_wrapper', $data, FALSE);
			} else {
				$upload_data = array('uploads' => $this->upload->data());
				$config['image_library'] = 'gd2';
				$config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);
				$data = array(
					'nama_lahan' => $this->input->post('nama_lahan'),
					'luas_lahan' => $this->input->post('luas_lahan'),
					'isi_lahan' => $this->input->post('isi_lahan'),
					'pemilik_lahan' => $this->input->post('pemilik_lahan'),
					'alamat_pemilik' => $this->input->post('alamat_pemilik'),
					'denah_geojson' => $this->input->post('denah_geojson'),
					'warna' => $this->input->post('warna'),
					'gambar' => $upload_data['uploads']['file_name'],
				);
				$this->m_lahan->add($data);
				$this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
				redirect('lahan/add');
			}
		}
		$data = array(
			'title' => 'Input Data Lahan',
			'isi'	=> 'lahan/v_add'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function edit($id_lahan = null)
	{
		$this->user_login->protek_halaman();
		$this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('isi_lahan', 'Isi Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('pemilik_lahan', 'Pemilik Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('alamat_pemilik', 'Alamat Pemilik Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('denah_geojson', 'Denah Lahan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('warna', 'Warna Denah', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']          = './gambar/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar')) {
				$data = array(
					'title' => 'Input Data Lahan',
					'error_upload' => $this->upload->display_errors(),
					'lahan' => $this->m_lahan->detail($id_lahan),
					'isi'	=> 'lahan/v_edit'
				);
				$this->load->view('layout/v_wrapper', $data, FALSE);
			} else {
				// jika ada pergantian diganti
				$upload_data = array('uploads' => $this->upload->data());
				$config['image_library'] = 'gd2';
				$config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);
				$data = array(
					'id_lahan'	=> $id_lahan,
					'nama_lahan' => $this->input->post('nama_lahan'),
					'luas_lahan' => $this->input->post('luas_lahan'),
					'isi_lahan' => $this->input->post('isi_lahan'),
					'pemilik_lahan' => $this->input->post('pemilik_lahan'),
					'alamat_pemilik' => $this->input->post('alamat_pemilik'),
					'denah_geojson' => $this->input->post('denah_geojson'),
					'warna' => $this->input->post('warna'),
					'gambar' => $upload_data['uploads']['file_name'],
				);
				$this->m_lahan->edit($data);
				$this->session->set_flashdata('sukses', 'Data Berhasil Diedit !!!');
				redirect('lahan');
			}
			// jika foto tidak diganti
			$data = array(
				'id_lahan'	=> $id_lahan,
				'nama_lahan' => $this->input->post('nama_lahan'),
				'luas_lahan' => $this->input->post('luas_lahan'),
				'isi_lahan' => $this->input->post('isi_lahan'),
				'pemilik_lahan' => $this->input->post('pemilik_lahan'),
				'alamat_pemilik' => $this->input->post('alamat_pemilik'),
				'denah_geojson' => $this->input->post('denah_geojson'),
				'warna' => $this->input->post('warna'),
			);
			$this->m_lahan->edit($data);
			$this->session->set_flashdata('sukses', 'Data Berhasil Diedit !!!');
			redirect('lahan');
		}
		$data = array(
			'title' => 'Input Data Lahan',
			'lahan' => $this->m_lahan->detail($id_lahan),
			'isi'	=> 'lahan/v_edit'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	//Delete one item
	public function delete($id_lahan)
	{
		$this->user_login->protek_halaman();
		$data = array('id_lahan' => $id_lahan);
		$this->m_lahan->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus !!!');
		redirect('lahan');
	}

	// galleri foto lahan

	public function galleri()
	{
		$data = array(
			'title' => 'Galleri Lahan',
			'galleri' => $this->m_lahan->get_all_galleri(),
			'isi'	=> 'lahan/v_galleri'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function add_foto($id_lahan = null)
	{
		$this->user_login->protek_halaman();
		$this->form_validation->set_rules('ket', 'Keterangan', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']          = './foto/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('foto')) {
				$data = array(
					'title' => 'Galleri Lahan',
					'lahan' => $this->m_lahan->detail($id_lahan),
					'foto' => $this->m_lahan->detail_galleri($id_lahan),
					'error_upload' => $this->upload->display_errors(),
					'isi'	=> 'lahan/v_add_foto'
				);
				$this->load->view('layout/v_wrapper', $data, FALSE);
			} else {
				$upload_data = array('uploads' => $this->upload->data());
				$config['image_library'] = 'gd2';
				$config['source_image'] = './foto/' . $upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);
				$data = array(
					'id_lahan' => $id_lahan,
					'ket' => $this->input->post('ket'),
					'foto' => $upload_data['uploads']['file_name'],
				);
				$this->m_lahan->add_foto($data);
				$this->session->set_flashdata('sukses', 'Foto Berhasil Tambahkan !!!');
				redirect('lahan/add_foto/' . $id_lahan);
			}
		}
		$data = array(
			'title' => 'Galleri Lahan',
			'lahan' => $this->m_lahan->detail($id_lahan),
			'foto' => $this->m_lahan->detail_galleri($id_lahan),
			'isi'	=> 'lahan/v_add_foto'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function delete_foto($id_lahan, $id_galeri_lahan)
	{
		$this->user_login->protek_halaman();
		$data = array(
			'id_galeri_lahan' => $id_galeri_lahan,
		);

		$this->m_lahan->delete_foto($data);
		$this->session->set_flashdata('sukses', 'Foto Berhasil Dihapus !!!');
		redirect('lahan/add_foto/' . $id_lahan);
	}

	public function galeri_lahan()
	{
		$data = array(
			'title' => 'Galleri Lahan',
			'galeri' => $this->m_lahan->get_all_galleri(),
			'isi'	=> 'lahan/v_galleri_lahan'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function view_galeri($id_lahan = null)
	{
		$data = array(
			'title' => 'View Galleri Lahan',
			'lahan' => $this->m_lahan->detail($id_lahan),
			'foto' => $this->m_lahan->detail_galleri($id_lahan),
			'isi'	=> 'lahan/v_view_galeri'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}
}

/* End of file Controllername.php */
