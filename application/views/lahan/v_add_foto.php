<div class="col-12">
	<div class="card card-primary">
		<div class="card-header">
			<div class="card-title">
				Galleri <?= $lahan->nama_lahan ?>
			</div>
		</div>
		<div class="card-body">
			<?php
			//notifikasi pesan validasi
			echo validation_errors('<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i> ', '</div>');

			//notifikasi gagal upload
			if (isset($error_upload)) {
				echo '<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-exclamation-triangle"></i> ' . $error_upload . '</div>';
			}

			//notifikasi sukses simpan data
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
						<div class="input-group my-colorpicker2">
							<input type="text" name="ket" placeholder="Keterangan Foto" class="form-control">
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="form-group">
						<label>Gambar</label>
						<input type="file" name="foto" class="form-control">
					</div>
				</div>

				<div class="col-sm-4">
					<div class="form-group">
						<br>
						<button type="submit" class="btn btn-primary">Simpan Foto</button>
					</div>
				</div>
			</div>


			<?php echo form_open() ?>
			<hr>
			<div class="row">
				<?php foreach ($foto as $key => $value) { ?>
					<div class="col-sm-3">
						<a href="<?= base_url('foto/' . $value->foto) ?>" data-toggle="lightbox" data-title="<?= $value->ket ?>" data-gallery="gallery">
							<img src="<?= base_url('foto/' . $value->foto) ?>" class="img-fluid mb-2" alt="white sample" />
						</a>
						<br>
						<a href="<?= base_url('lahan/delete_foto/' . $value->id_lahan . '/' . $value->id_galeri_lahan) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda Yakin Ingin Hapus Data ini..?')">Delete</a>
					</div>
				<?php } ?>


			</div>
		</div>
	</div>
</div>




<!-- Page specific script -->
<script>
	$(function() {
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox({
				alwaysShowClose: true
			});
		});

		$('.filter-container').filterizr({
			gutterPixels: 3
		});
		$('.btn[data-filter]').on('click', function() {
			$('.btn[data-filter]').removeClass('active');
			$(this).addClass('active');
		});
	})
</script>