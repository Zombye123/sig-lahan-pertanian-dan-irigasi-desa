<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_login
{
	protected $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('m_login');
	}

	public function login($username, $password)
	{
		$cek = $this->ci->m_login->login($username, $password);
		if ($cek) {
			$nama_user = $cek->nama_user;
			$username = $cek->username;
			//buat session			
			$this->ci->session->set_userdata('nama_user', $nama_user);
			$this->ci->session->set_userdata('username', $username);
			redirect('home');
		} else {
			$this->ci->session->set_flashdata('pesan', 'Username Atau Password Tidak Ditemukan !!');
			redirect('auth/login');
		}
	}

	public function protek_halaman()
	{
		if ($this->ci->session->userdata('username') == "") {
			$this->ci->session->set_flashdata('pesan', 'Anda Belum Login, Silahkan Login Dulu !!!');
			redirect('auth/login');
		}
	}

	public function logout()
	{
		$this->ci->session->unset_userdata('nama_user');
		$this->ci->session->unset_userdata('username');
		$this->ci->session->set_flashdata('pesan', 'Anda Berhasil Logout !!');
		redirect('auth/login');
	}
}

/* End of file User_login.php */
