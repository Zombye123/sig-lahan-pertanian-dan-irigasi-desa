<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_irigasi extends CI_Model
{
	public function add($data)
	{
		$this->db->insert('tbl_irigasi', $data);
	}

	public function get_all_data()
	{
		$this->db->select('*');
		$this->db->from('tbl_irigasi');
		$this->db->order_by('id_irigasi', 'desc');
		return $this->db->get()->result();
	}

	public function detail($id_irigasi)
	{
		$this->db->select('*');
		$this->db->from('tbl_irigasi');
		$this->db->where('id_irigasi', $id_irigasi);
		return $this->db->get()->row();
	}

	public function edit($data)
	{
		$this->db->where('id_irigasi', $data['id_irigasi']);
		$this->db->update('tbl_irigasi', $data);
	}

	public function delete($data)
	{
		$this->db->where('id_irigasi', $data['id_irigasi']);
		$this->db->delete('tbl_irigasi', $data);
	}
}
