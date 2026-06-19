<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produksi extends CI_Model
{
    public function get_all_data()
    {
        $this->db->select('tbl_produksi.*, tbl_lahan.nama_lahan');
        $this->db->from('tbl_produksi');
        $this->db->join(
            'tbl_lahan',
            'tbl_lahan.id_lahan = tbl_produksi.id_lahan'
        );
        $this->db->order_by('tahun','DESC');

        return $this->db->get()->result();
    }

    public function detail($id_produksi)
    {
        $this->db->where('id_produksi',$id_produksi);
        return $this->db->get('tbl_produksi')->row();
    }

    public function add($data)
    {
        $this->db->insert('tbl_produksi',$data);
    }

    public function edit($data)
    {
        $this->db->where(
            'id_produksi',
            $data['id_produksi']
        );

        $this->db->update(
            'tbl_produksi',
            $data
        );
    }

    public function delete($data)
    {
        $this->db->where(
            'id_produksi',
            $data['id_produksi']
        );

        $this->db->delete(
            'tbl_produksi'
        );
    }
}