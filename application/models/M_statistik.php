<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_statistik extends CI_Model
{
    public function total_lahan()
    {
        return $this->db->count_all('tbl_lahan');
    }

    public function total_irigasi()
    {
        return $this->db->count_all('tbl_irigasi');
    }

    public function total_luas()
    {
        return $this->db
            ->select_sum('luas_lahan')
            ->get('tbl_lahan')
            ->row();
    }

    public function total_pemilik()
    {
        return $this->db
            ->select('pemilik_lahan')
            ->group_by('pemilik_lahan')
            ->get('tbl_lahan')
            ->num_rows();
    }

    public function statistik_tanaman()
    {
        return $this->db
            ->select('isi_lahan, COUNT(*) as jumlah')
            ->group_by('isi_lahan')
            ->get('tbl_lahan')
            ->result();
    }

    public function statistik_tahun()
    {
        return $this->db
            ->select('tahun, COUNT(*) as jumlah')
            ->group_by('tahun')
            ->order_by('tahun','ASC')
            ->get('tbl_lahan')
            ->result();
    }

    public function top_pemilik()
    {
        return $this->db
            ->select('pemilik_lahan, COUNT(*) as jumlah')
            ->group_by('pemilik_lahan')
            ->order_by('jumlah','DESC')
            ->limit(5)
            ->get('tbl_lahan')
            ->result();
    }

    public function data_terbaru()
    {
        return $this->db
            ->order_by('id_lahan','DESC')
            ->limit(5)
            ->get('tbl_lahan')
            ->result();
    }
}