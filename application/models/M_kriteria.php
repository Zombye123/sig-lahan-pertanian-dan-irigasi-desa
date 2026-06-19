<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kriteria extends CI_Model {

    public function get_all_data()
    {
        $this->db->order_by('id_kriteria','ASC');
        return $this->db->get('tbl_kriteria')->result();
    }

    public function detail($id_kriteria)
    {
        $this->db->where('id_kriteria',$id_kriteria);
        return $this->db->get('tbl_kriteria')->row();
    }

    public function add($data)
    {
        return $this->db->insert(
            'tbl_kriteria',
            $data
        );
    }

    public function edit($data)
    {
        $this->db->where(
            'id_kriteria',
            $data['id_kriteria']
        );

        return $this->db->update(
            'tbl_kriteria',
            $data
        );
    }

    public function delete($id_kriteria)
    {
        $this->db->where(
            'id_kriteria',
            $id_kriteria
        );

        return $this->db->delete(
            'tbl_kriteria'
        );
    }
}