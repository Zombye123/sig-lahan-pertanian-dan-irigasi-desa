<div class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Input Data Lahan Pertanian</h3>
        </div>
        <div class="card-body">
            <?php
            if ($this->session->flashdata('sukses')) {
                echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-check"></i>';
                echo $this->session->flashdata('sukses');
                echo '</div>';
            }
            ?>

            <form action="<?= base_url('lahan/bulk_delete') ?>" method="post">
                <table class="table table-bordered text-sm" id="example1">
                    <thead class="text-center">
                        <tr>
                            <?php if ($this->session->userdata('username')) { ?>
                                <th><input type="checkbox" id="select-all" name="select_all"> Pilih Semua</th>
                            <?php } ?>
                            <th>No</th>
                            <th>Nama Lahan</th>
                            <th>Luas Lahan</th>
                            <th>Isi Lahan</th>
                            <th>Pemilik Lahan</th>
                            <th>Alamat Pemilik</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($lahan as $key => $value) { ?>
                            <tr>
                                <?php if ($this->session->userdata('username')) { ?>
                                    <td><input type="checkbox" name="id_lahan[]" value="<?= $value->id_lahan ?>"></td>
                                <?php } ?>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($value->nama_lahan) ?></td>
                                <td><?= htmlspecialchars($value->luas_lahan) ?></td>
                                <td><?= htmlspecialchars($value->isi_lahan) ?></td>
                                <td><?= htmlspecialchars($value->pemilik_lahan) ?></td>
                                <td><?= htmlspecialchars($value->alamat_pemilik) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('home/detail_lahan/' . $value->id_lahan) ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($this->session->userdata('username')) { ?>
                                        <a href="<?= base_url('lahan/edit/' . $value->id_lahan) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <?php if ($this->session->userdata('username')) { ?>
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data yang Dipilih?')">
                        <i class="fas fa-trash"></i>
                    </button>
                <?php } else { ?>
                    <div class="alert alert-warning mt-2">Anda harus login terlebih dahulu untuk menghapus data.</div>
                <?php } ?>

            </form>
        </div>
    </div>
</div>

<script>
    // Checkbox "Select All" untuk memilih atau membatalkan semua checkbox dalam tabel
    $("#select-all").click(function() {
        $('input[name="id_lahan[]"]').prop('checked', this.checked);
    });
</script>
