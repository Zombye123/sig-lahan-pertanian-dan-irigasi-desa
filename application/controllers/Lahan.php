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
			'lahan'	=> $this->m_lahan->get_all_data(),
			'isi'	=> 'lahan/v_data'
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
			'numeric' => '%s Harus berupa angka !!!'
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
					'tahun' => $this->input->post('tahun'),
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
		$this->form_validation->set_rules('nama_lahan', 'Nama Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('luas_lahan', 'Luas Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('isi_lahan', 'Isi Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('pemilik_lahan', 'Pemilik Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('alamat_pemilik', 'Alamat Pemilik Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('denah_geojson', 'Denah Lahan', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('warna', 'Warna Denah', 'required', ['required' => '%s Harus Diisi !!!']);
		$this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric', [
			'required' => '%s Harus Diisi !!!',
			'numeric' => '%s Harus berupa angka !!!'
		]);

		if ($this->form_validation->run() == TRUE) {
			$config['upload_path']          = './gambar/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2000;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('gambar')) {
				$data = array(
					'title' => 'Edit Data Lahan',
					'error_upload' => $this->upload->display_errors(),
					'lahan' => $this->m_lahan->detail($id_lahan),
					'isi'	=> 'lahan/v_edit'
				);
				$this->load->view('layout/v_wrapper', $data, FALSE);
			} else {
				$upload_data = array('uploads' => $this->upload->data());
				$config['image_library'] = 'gd2';
				$config['source_image'] = './gambar/' . $upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);
				$data = array(
					'id_lahan' => $id_lahan,
					'nama_lahan' => $this->input->post('nama_lahan'),
					'luas_lahan' => $this->input->post('luas_lahan'),
					'isi_lahan' => $this->input->post('isi_lahan'),
					'pemilik_lahan' => $this->input->post('pemilik_lahan'),
					'alamat_pemilik' => $this->input->post('alamat_pemilik'),
					'denah_geojson' => $this->input->post('denah_geojson'),
					'warna' => $this->input->post('warna'),
					'gambar' => $upload_data['uploads']['file_name'],
					'tahun' => $this->input->post('tahun'),
				);
				$this->m_lahan->edit($data);
				$this->session->set_flashdata('sukses', 'Data Berhasil Diedit !!!');
				redirect('lahan');
			}

			$data = array(
				'id_lahan' => $id_lahan,
				'nama_lahan' => $this->input->post('nama_lahan'),
				'luas_lahan' => $this->input->post('luas_lahan'),
				'isi_lahan' => $this->input->post('isi_lahan'),
				'pemilik_lahan' => $this->input->post('pemilik_lahan'),
				'alamat_pemilik' => $this->input->post('alamat_pemilik'),
				'denah_geojson' => $this->input->post('denah_geojson'),
				'warna' => $this->input->post('warna'),
				'tahun' => $this->input->post('tahun'),
			);
			$this->m_lahan->edit($data);
			$this->session->set_flashdata('sukses', 'Data Berhasil Diedit !!!');
			redirect('lahan');
		}

		$data = array(
			'title' => 'Edit Data Lahan',
			'lahan' => $this->m_lahan->detail($id_lahan),
			'isi'	=> 'lahan/v_edit'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function bulk_delete()
	{
		$this->user_login->protek_halaman();
		$selected_ids = $this->input->post('id_lahan');
		if (!empty($selected_ids)) {
			foreach ($selected_ids as $id_lahan) {
				$data = array('id_lahan' => $id_lahan);
				$this->m_lahan->delete($data);
			}
			$this->session->set_flashdata('sukses', 'Data Berhasil Dihapus !!!');
		} else {
			$this->session->set_flashdata('error', 'Tidak ada data yang dipilih !!!');
		}
		redirect('lahan');
	}
}
