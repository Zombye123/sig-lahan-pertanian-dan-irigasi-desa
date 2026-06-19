<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_irigasi extends CI_Model
{
    // Menambah data irigasi
    public function add($data)
    {
        $this->db->insert('tbl_irigasi', $data);
    }

    // Mengambil semua data irigasi
    public function get_all_data()
    {
        return $this->db->select('*')
                        ->from('tbl_irigasi')
                        ->order_by('id_irigasi', 'DESC')
                        ->get()
                        ->result();
    }

    // Mengambil detail berdasarkan ID
    public function detail($id_irigasi)
    {
        return $this->db->select('*')
                        ->from('tbl_irigasi')
                        ->where('id_irigasi', $id_irigasi)
                        ->get()
                        ->row();
    }

    // Edit data irigasi
    public function edit($data)
    {
        $this->db->where('id_irigasi', $data['id_irigasi']);
        $this->db->update('tbl_irigasi', $data);
    }

    // Hapus data irigasi
    public function delete($id_irigasi)
    {
        $this->db->where('id_irigasi', $id_irigasi);
        $this->db->delete('tbl_irigasi');
    }

    // Mengambil semua data untuk kebutuhan pemetaan (GeoJSON)
    public function get_all_geo()
    {
        return $this->db->get('tbl_irigasi')->result();
    }

    // FUNGSI TAMBAHAN: Filter berdasarkan kondisi
    public function get_by_kondisi($kondisi)
    {
        return $this->db->select('*')
                        ->from('tbl_irigasi')
                        ->where('kondisi', $kondisi)
                        ->order_by('id_irigasi', 'DESC')
                        ->get()
                        ->result();
    }
}