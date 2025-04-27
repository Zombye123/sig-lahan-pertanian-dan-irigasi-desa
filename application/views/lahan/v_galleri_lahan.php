<!-- v_galleri_lahan.php -->
<div class="col-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Galeri Lahan</h3>
        </div>

        <div class="card-body">
            <div class="row">

                <?php foreach ($lahan as $key => $value) { ?>
                    <div class="col-md-3">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h5 class="card-title text-center"><?= $value->nama_lahan ?></h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body p-2">
                                <img src="<?= base_url('gambar/' . $value->gambar) ?>" class="img-fluid" style="height: 150px; object-fit: cover;">
                            </div>

                            <div class="card-footer text-center">
                                <a href="<?= base_url('lahan/view_galeri/' . $value->id_lahan) ?>" class="btn btn-primary btn-sm">
                                    Lihat Galeri
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
