<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_lahan extends CI_Model
{
	public function add($data)
	{
		$this->db->insert('tbl_lahan', $data);
	}

	public function get_all_data()
	{
		$this->db->select('*');
		$this->db->from('tbl_lahan');
		$this->db->order_by('id_lahan', 'desc');
		return $this->db->get()->result();
	}

	public function detail($id_lahan)
	{
		$this->db->select('*');
		$this->db->from('tbl_lahan');
		$this->db->where('id_lahan', $id_lahan);
		return $this->db->get()->row();
	}

	public function edit($data)
	{
		$this->db->where('id_lahan', $data['id_lahan']);
		$this->db->update('tbl_lahan', $data);
	}

	public function delete($data)
	{
		$this->db->where('id_lahan', $data['id_lahan']);
		$this->db->delete('tbl_lahan', $data);
	}

	//galleri

	public function get_all_galleri()
	{
		$this->db->select('tbl_lahan.*,count(tbl_galeri_lahan.id_lahan) as total_foto');
		$this->db->from('tbl_lahan');
		$this->db->join('tbl_galeri_lahan', 'tbl_galeri_lahan.id_lahan = tbl_lahan.id_lahan', 'left');
		$this->db->group_by('tbl_lahan.id_lahan');
		$this->db->order_by('id_lahan', 'desc');
		return $this->db->get()->result();
	}

	public function detail_galleri($id_lahan)
	{
		$this->db->select('*');
		$this->db->from('tbl_galeri_lahan');
		$this->db->where('id_lahan', $id_lahan);
		$this->db->order_by('id_lahan', 'desc');
		return $this->db->get()->result();
	}

	public function delete_foto($data)
	{
		$this->db->where('id_galeri_lahan', $data['id_galeri_lahan']);
		$this->db->delete('tbl_galeri_lahan', $data);
	}

	public function add_foto($data)
	{
		$this->db->insert('tbl_galeri_lahan', $data);
	}
}

/* End of file M_lahan.php */
