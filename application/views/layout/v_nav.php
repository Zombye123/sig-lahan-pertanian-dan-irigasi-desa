<div class="collapse navbar-collapse order-3" id="navbarCollapse">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?= base_url() ?>" class="nav-link">Home</a>
		</li>

		<li class="nav-item dropdown">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Lahan</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<?php if ($this->session->userdata('username') <> "") { ?>
					<li><a href="<?= base_url('lahan/add')  ?>" class="dropdown-item">Input Lahan</a></li>
					<li><a href="<?= base_url('lahan/galleri') ?>" class="dropdown-item">Data Galeri Foto</a></li>
				<?php } ?>
				<li><a href="<?= base_url('lahan') ?>" class="dropdown-item">Data Lahan</a></li>

				<li><a href="<?= base_url('lahan/galeri_lahan') ?>" class="dropdown-item">Galeri Lahan</a></li>
			</ul>
		</li>

		<li class="nav-item dropdown">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Irigasi</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<?php if ($this->session->userdata('username') <> "") { ?>
					<li><a href="<?= base_url('irigasi/add')  ?>" class="dropdown-item">Input Irigasi</a></li>
				<?php } ?>
				<li><a href="<?= base_url('irigasi') ?>" class="dropdown-item">Data Irigasi</a></li>

			</ul>
		</li>

		<li class="nav-item">
			<a href="<?= base_url('home/about') ?>" class="nav-link">About</a>
		</li>


	</ul>


</div>

<!-- Right navbar links -->
<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">


	<li class="nav-item">
		<?php if ($this->session->userdata('username') == "") { ?>
			<a href="<?= base_url('auth/login') ?>">
    <i class="fa fa-arrow-left" aria-hidden="true"></i>
	<i class="fa fa-sign-in" aria-hidden="true"></i> Login</a>
	<?php } else { ?>


    <a><i class="fas fa-user"></i> <?= $this->session->userdata('nama_user') ?></a>
    <a href="<?= base_url('auth/logout') ?>">
	<i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a>
	<i class="fa fa-arrow-right" aria-hidden="true"></i><?php } ?>

	</li>
</ul>
</div>
</nav>
<!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Pemetaan Lahan Pertanian Dan Irigasi</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
