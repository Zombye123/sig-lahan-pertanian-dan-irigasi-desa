<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Irigasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_irigasi');
	}

	// List all your items
	public function index($offset = 0)
	{
		$data = array(
			'title' => 'Data Irigasi',
			'irigasi'	=> $this->m_irigasi->get_all_data(),
			'isi'	=> 'irigasi/v_data'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	// Add a new item
	public function add()
	{
		$this->user_login->protek_halaman();
		$this->form_validation->set_rules('nama_irigasi', 'Nama Irigasi', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('panjang_jalur', 'Panjang Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('lebar_jalur', 'Lebar Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('jalur_geojson', 'Jalur Geojson', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('warna', 'Warna Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('ketebalan', 'Ketebalan Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));

		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']          = './gambar/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar')) {
				$data = array(
					'title' => 'Input Data Irigasi',
					'error_upload' => $this->upload->display_errors(),
					'isi'	=> 'irigasi/v_add'
				);
				$this->load->view('layout/v_wrapper', $data, FALSE);
			} else {
				$upload_data = array('uploads' => $this->upload->data());
				$config['image_library'] = 'gd2';
				$config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);
				$data = array(
					'nama_irigasi' => $this->input->post('nama_irigasi'),
					'panjang_jalur' => $this->input->post('panjang_jalur'),
					'lebar_jalur' => $this->input->post('lebar_jalur'),
					'jalur_geojson' => $this->input->post('jalur_geojson'),
					'ketebalan' => $this->input->post('ketebalan'),
					'warna' => $this->input->post('warna'),
					'gambar' => $upload_data['uploads']['file_name'],
				);
				$this->m_irigasi->add($data);
				$this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
				redirect('irigasi/add');
			}
		}
		$data = array(
			'title' => 'Input Data Irigasi',
			'isi'	=> 'irigasi/v_add'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function edit($id_irigasi)
	{
		$this->user_login->protek_halaman();
		$this->form_validation->set_rules('nama_irigasi', 'Nama Irigasi', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('panjang_jalur', 'Panjang Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('lebar_jalur', 'Lebar Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('jalur_geojson', 'Jalur Geojson', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('warna', 'Warna Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));
		$this->form_validation->set_rules('ketebalan', 'Ketebalan Jalur', 'required', array(
			'required' => '%s Harus Diisi !!!'
		));

		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']          = './gambar/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar')) {
				$data = array(
					'title' => 'Input Data Irigasi',
					'error_upload' => $this->upload->display_errors(),
					'irigasi'	=> $this->m_irigasi->detail($id_irigasi),
					'isi'	=> 'irigasi/v_edit'
				);
				$this->load->view('layout/v_wrapper', $data, FALSE);
			} else {
				$upload_data = array('uploads' => $this->upload->data());
				$config['image_library'] = 'gd2';
				$config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);
				$data = array(
					'id_irigasi' => $id_irigasi,
					'nama_irigasi' => $this->input->post('nama_irigasi'),
					'panjang_jalur' => $this->input->post('panjang_jalur'),
					'lebar_jalur' => $this->input->post('lebar_jalur'),
					'jalur_geojson' => $this->input->post('jalur_geojson'),
					'ketebalan' => $this->input->post('ketebalan'),
					'warna' => $this->input->post('warna'),
					'gambar' => $upload_data['uploads']['file_name'],
				);
				$this->m_irigasi->edit($data);
				$this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
				redirect('irigasi');
			}
			$data = array(
				'id_irigasi' => $id_irigasi,
				'nama_irigasi' => $this->input->post('nama_irigasi'),
				'panjang_jalur' => $this->input->post('panjang_jalur'),
				'lebar_jalur' => $this->input->post('lebar_jalur'),
				'jalur_geojson' => $this->input->post('jalur_geojson'),
				'ketebalan' => $this->input->post('ketebalan'),
				'warna' => $this->input->post('warna'),

			);
			$this->m_irigasi->edit($data);
			$this->session->set_flashdata('sukses', 'Data Berhasil Disimpan !!!');
			redirect('irigasi');
		}
		$data = array(
			'title' => 'Input Data Irigasi',
			'irigasi'	=> $this->m_irigasi->detail($id_irigasi),
			'isi'	=> 'irigasi/v_edit'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	//Delete one item
	public function delete($id_irigasi = NULL)
	{
		$this->user_login->protek_halaman();
		$data = array('id_irigasi' => $id_irigasi);
		$this->m_irigasi->delete($data);
		$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus !!!');
		redirect('irigasi');
	}
}

/* End of file Irigasi.php */
