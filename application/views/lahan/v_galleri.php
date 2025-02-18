<div class="content">
	<!-- general form elements -->
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Input Data Lahan Pertanian</h3>
		</div>
		<!-- /.card-header -->
		<!-- form start -->
		<div class="card-body">
			<?php
			//notifikasi sukses simpan data
			if ($this->session->flashdata('sukses')) {
				echo '<div class="alert alert-success alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ';
				echo $this->session->flashdata('sukses');
				echo '</div>';
			}
			?>
			<table class="table table-bordered text-sm" id="example1">
				<thead class="text-center">
					<tr>
						<th>No</th>
						<th>Nama Lahan</th>
						<th>Luas Lahan</th>
						<th>Isi Lahan</th>
						<th>Pemilik Lahan</th>
						<th>Cover Galleri</th>
						<th>Action</th>


					</tr>
				</thead>
				<tbody>
					<?php $no = 1;
					foreach ($galleri as $key => $value) { ?>
						<tr>
							<td><?= $no++ ?></td>
							<td><?= $value->nama_lahan ?></td>
							<td><?= $value->luas_lahan ?></td>
							<td><?= $value->isi_lahan ?></td>
							<td><?= $value->pemilik_lahan ?></td>
							<td class="text-center"><img src="<?= base_url('gambar/' . $value->gambar) ?>" width="200px" height="120px"><br>
								<span class="right badge badge-primary"><?= $value->total_foto ?> Foto</span>
							</td>
							<td class="text-center">
								<a href="<?= base_url('lahan/add_foto/' . $value->id_lahan) ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add Foto</a>
							</td>

						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>
</div>



<script>
	$(function() {
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
		});
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});
	});
</script>
