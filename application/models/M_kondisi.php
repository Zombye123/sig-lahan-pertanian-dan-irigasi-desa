<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kondisi extends CI_Model {

    public function get_all_data()
    {
        $this->db->select('
            tbl_kondisi_lahan.*,
            tbl_lahan.nama_lahan,
            tbl_lahan.pemilik_lahan
        ');

        $this->db->from('tbl_kondisi_lahan');

        $this->db->join(
            'tbl_lahan',
            'tbl_lahan.id_lahan = tbl_kondisi_lahan.id_lahan',
            'left'
        );

        $this->db->order_by(
            'tbl_kondisi_lahan.id_kondisi',
            'DESC'
        );

        return $this->db->get()->result();
    }

    public function detail($id_kondisi)
    {
        $this->db->where(
            'id_kondisi',
            $id_kondisi
        );

        return $this->db
            ->get('tbl_kondisi_lahan')
            ->row();
    }

    public function add($data)
    {
        return $this->db->insert(
            'tbl_kondisi_lahan',
            $data
        );
    }

    public function edit($data)
    {
        $this->db->where(
            'id_kondisi',
            $data['id_kondisi']
        );

        return $this->db->update(
            'tbl_kondisi_lahan',
            $data
        );
    }

    public function delete($id_kondisi)
    {
        $this->db->where(
            'id_kondisi',
            $id_kondisi
        );

        return $this->db->delete(
            'tbl_kondisi_lahan'
        );
    }

    public function get_by_lahan($id_lahan)
    {
        $this->db->where(
            'id_lahan',
            $id_lahan
        );

        return $this->db
            ->get('tbl_kondisi_lahan')
            ->row();
    }
}