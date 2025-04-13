<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statistik_model extends CI_Model
{
    // Fungsi untuk mendapatkan data tanaman berdasarkan tahun dan jenis tanaman
    public function get_tanaman_per_tahun()
    {
        // Pilih tahun, jenis tanaman dan hitung jumlah lahan per jenis dan tahun
        $this->db->select('tahun, isi_lahan, COUNT(*) as jumlah');
        $this->db->from('tbl_lahan');
        $this->db->group_by(['tahun', 'isi_lahan']); // Kelompokkan berdasarkan tahun dan jenis tanaman
        $this->db->order_by('tahun', 'ASC');  // Urutkan berdasarkan tahun
        $this->db->order_by('jumlah', 'DESC'); // Urutkan berdasarkan jumlah terbanyak
        return $this->db->get()->result();  // Ambil hasil query
    }
}
