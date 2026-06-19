<?php
class M_Lahan extends CI_Model
{
    // Tambah data lahan
    public function add($data)
    {
        // Luas HA langsung diambil dari nilai yang sudah dibersihkan dari form
        return $this->db->insert('tbl_lahan', $data);
    }

    // Edit data lahan
    public function edit($data)
    {
        return $this->db->update('tbl_lahan', $data, array('id_lahan' => $data['id_lahan']));
    }

    // Tambah foto ke galeri lahan
    public function add_foto($data)
    {
        return $this->db->insert('tbl_galeri_lahan', $data);
    }

    // Hapus data lahan
    public function delete($id_lahan)
    {
        $this->db->where('id_lahan', $id_lahan);
        return $this->db->delete('tbl_lahan');
    }

    // Hapus foto dari galeri lahan dan file foto dari server
    public function delete_foto($id_lahan, $id_galeri_lahan)
    {
        $this->db->select('foto');
        $this->db->from('tbl_galeri_lahan');
        $this->db->where('id_galeri_lahan', $id_galeri_lahan);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $foto = $query->row()->foto;
            $file_path = './foto/' . $foto;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $this->db->where('id_galeri_lahan', $id_galeri_lahan);
            $this->db->delete('tbl_galeri_lahan');
        }
    }

    // Ambil semua data lahan
    public function get_all_data()
    {
        return $this->db->get('tbl_lahan')->result();
    }

    // Ambil detail data lahan berdasarkan ID
    public function detail($id_lahan)
    {
        $this->db->where('id_lahan', $id_lahan);
        return $this->db->get('tbl_lahan')->row();
    }

    // Ambil galeri foto berdasarkan ID lahan
    public function detail_galleri($id_lahan)
    {
        $this->db->where('id_lahan', $id_lahan);
        return $this->db->get('tbl_galeri_lahan')->result();
    }

    // Ambil semua data galeri beserta data lahan
public function get_galleri()
{
    // Tambahkan 'tbl_lahan.luas_lahan' ke dalam daftar select
    $this->db->select('tbl_lahan.id_lahan, tbl_lahan.nama_lahan, tbl_lahan.luas_lahan, tbl_lahan.luas_ha, tbl_lahan.isi_lahan, tbl_lahan.pemilik_lahan, tbl_lahan.gambar, COUNT(tbl_galeri_lahan.id_galeri_lahan) AS total_foto');
    $this->db->from('tbl_lahan');
    $this->db->join('tbl_galeri_lahan', 'tbl_lahan.id_lahan = tbl_galeri_lahan.id_lahan', 'left');
    $this->db->group_by('tbl_lahan.id_lahan');
    return $this->db->get()->result();
}

    // Ambil semua data geojson lahan
    public function get_all_geo()
    {
        return $this->db->get('tbl_lahan')->result();
    }



    // Menghapus banyak data sekaligus
    public function bulk_delete($id_list)
    {
        // Menggunakan where_in untuk menghapus semua ID yang ada di dalam array
        $this->db->where_in('id_lahan', $id_list);
        return $this->db->delete('tbl_lahan');
    }
}
?>