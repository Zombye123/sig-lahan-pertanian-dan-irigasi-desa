<div class="col-12">
	<div class="card card-primary">
		<div class="card-header">
			<div class="card-title">
				Galleri Lahan
			</div>
		</div>
		<div class="card-body">
			<div class="row">

				<?php foreach ($galeri as $key => $value) { ?>
					<div class="col-md-3">
						<div class="card card-outline card-primary">
							<div class="card-header">
								<h3 class="card-title"><?= $value->nama_lahan ?></h3>

								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
									</button>
								</div>
								<!-- /.card-tools -->
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<img src="<?= base_url('gambar/' . $value->gambar) ?>" width="100%" height="150">
							</div>
							<div class="card-footer text-center">
								<a href="<?= base_url('lahan/view_galeri/' . $value->id_lahan) ?>">View Galleri</a>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
</div>