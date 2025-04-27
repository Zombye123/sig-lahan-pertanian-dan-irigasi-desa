<?php
class M_Lahan extends CI_Model
{
    // Tambah data lahan
    public function add($data)
    {
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
        // Ambil data foto dari database berdasarkan id_galeri_lahan
        $this->db->select('foto');
        $this->db->from('tbl_galeri_lahan');
        $this->db->where('id_galeri_lahan', $id_galeri_lahan);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $foto = $query->row()->foto;

            // Hapus file foto dari server
            $file_path = './foto/' . $foto;
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file foto dari server
            }

            // Hapus data foto dari database
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
        $this->db->select('tbl_lahan.id_lahan, tbl_lahan.nama_lahan, tbl_lahan.luas_lahan, tbl_lahan.isi_lahan, tbl_lahan.pemilik_lahan, tbl_lahan.gambar, COUNT(tbl_galeri_lahan.id_galeri_lahan) AS total_foto');
        $this->db->from('tbl_lahan');
        $this->db->join('tbl_galeri_lahan', 'tbl_lahan.id_lahan = tbl_galeri_lahan.id_lahan', 'left');
        $this->db->group_by('tbl_lahan.id_lahan');
        return $this->db->get()->result();
    }
}
?>
