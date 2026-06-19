<div class="col-12">
    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">
                Galeri <?= $lahan->nama_lahan ?>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php if (!empty($galleri)) { 
                    foreach ($galleri as $key => $value) { ?>
                        <div class="col-sm-3">
                            <a href="<?= base_url('foto/' . $value->foto) ?>" data-toggle="lightbox" data-title="<?= $value->ket ?>" data-gallery="gallery">
                                <img src="<?= base_url('foto/' . $value->foto) ?>" class="img-fluid mb-2" alt="Foto Lahan" />
                            </a>
                        </div>
                <?php } 
                } else { ?>
                    <div class="col-12">
                        <p>Belum ada foto untuk lahan ini.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        // Pastikan library filterizr sudah dimuat jika ingin menggunakannya
        if ($('.filter-container').length > 0) {
            $('.filter-container').filterizr({
                gutterPixels: 3
            });
        }
        
        $('.btn[data-filter]').on('click', function() {
            $('.btn[data-filter]').removeClass('active');
            $(this).addClass('active');
        });
    })
</script>