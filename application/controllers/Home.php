<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('m_lahan');
		$this->load->model('m_irigasi');
	}

	public function index()
	{
		$data = array(
			'title' => 'Pemetaan',
			'lahan'	=> $this->m_lahan->get_all_data(),
			'irigasi'	=> $this->m_irigasi->get_all_data(),
			'isi'	=> 'v_home'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function detail_lahan($id_lahan)
	{
		$data = array(
			'title' => 'Lahan Pertanian',
			'lahan'	=> $this->m_lahan->detail($id_lahan),
			'foto'	=> $this->m_lahan->detail_galleri($id_lahan),
			'isi'	=> 'v_detail_lahan'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function detail_irigasi($id_irigasi)
	{
		$data = array(
			'title' => 'Irigasi Pertanian',
			'irigasi'	=> $this->m_irigasi->detail($id_irigasi),
			'isi'	=> 'v_detail_irigasi'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}

	public function about()
	{
		$data = array(
			'title' => 'About',

			'isi'	=> 'v_about'
		);
		$this->load->view('layout/v_wrapper', $data, FALSE);
	}
}

/* End of file Home.php */
