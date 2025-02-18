<div class="content">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">



			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Login User</h3>
				</div>
				<div class="card-body">

					<?php

					//notifikasi pesan validasi
					echo validation_errors('<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i> ', '</div>');


					//notifikasi pesan
					if ($this->session->flashdata('pesan')) {
						echo '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ';
						echo $this->session->flashdata('pesan');
						echo '</div>';
					}


					echo form_open('auth/login'); ?>
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="username" class="form-control" placeholder="Username">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" placeholder="Password">
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Login</button>
						<button type="reset" class="btn btn-warning">Reset</button>
					</div>

					<?php echo form_close() ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
</div>