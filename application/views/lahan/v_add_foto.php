<div class="col-12">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">
                Galleri <?= htmlspecialchars($lahan->nama_lahan) ?>
            </div>
        </div>
        <div class="card-body">
            <?php
            // Notifikasi pesan validasi
            echo validation_errors('<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i> ', '</div>');

            // Notifikasi gagal upload
            if (isset($error_upload)) {
                echo '<div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-exclamation-triangle"></i> ' . htmlspecialchars($error_upload) . '</div>';
            }

            // Notifikasi sukses simpan data
            if ($this->session->flashdata('sukses')) {
                echo '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ';
                echo $this->session->flashdata('sukses');
                echo '</div>';
            }

            echo form_open_multipart('lahan/add_foto/' . $lahan->id_lahan) ?>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Keterangan Foto</label>
                        <input type="text" name="ket" placeholder="Keterangan Foto" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="foto" class="form-control" id="foto" required>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-primary">Simpan Foto1</button>
                    </div>
                </div>
            </div>

            <?php echo form_close(); ?>
            <hr>
            <div class="row">
                <?php foreach ($galleri as $value) { ?>
                    <div class="col-sm-3">
                        <a href="<?= base_url('foto/' . $value->foto) ?>" data-toggle="lightbox" data-title="<?= htmlspecialchars($value->ket) ?>" data-gallery="gallery">
                            <img src="<?= base_url('foto/' . $value->foto) ?>" class="img-fluid mb-2" alt="Gambar tidak tersedia" />
                        </a>
                        <br>
                        <a href="<?= base_url('lahan/delete_foto/' . $value->id_lahan . '/' . $value->id_galeri_lahan) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                            <i class="fas fa-trash"></i>
                        </a>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const allowedExtensions = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!allowedExtensions.includes(file.type)) {
                alert('Hanya file dengan format PNG, JPG, atau JPEG yang diperbolehkan!');
                event.target.value = ''; // Reset input file jika tidak sesuai
            }
        }
    });

    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
    });
</script>
