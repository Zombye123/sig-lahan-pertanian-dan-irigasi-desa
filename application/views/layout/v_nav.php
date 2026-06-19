<div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="<?= base_url() ?>" class="nav-link <?= ($this->uri->segment(1) == '') ? 'active' : '' ?>">Home</a>
        </li>

        <?php $username = $this->session->userdata('username'); ?>

        <?php if ($username <> "") { 
            // Logika Parent Active untuk menu Analisis
            $list_analisis = ['statistik', 'analisis', 'rekomendasi', 'spk', 'kondisi', 'produksi', 'kriteria', 'penilaian', 'prediksi'];
        ?>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenuAnalisis" href="#" data-toggle="dropdown" 
               class="nav-link dropdown-toggle <?= in_array($this->uri->segment(1), $list_analisis) ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Analisis & SPK
            </a>
            <ul class="dropdown-menu border-0 shadow">
                <li class="dropdown-header">Dashboard</li>
                <li><a href="<?= base_url('statistik') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'statistik') ? 'active' : '' ?>">Dashboard Statistik</a></li>
                <li class="dropdown-divider"></li>
                <li class="dropdown-header">Analisis SIG</li>
                <li><a href="<?= base_url('analisis') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'analisis') ? 'active' : '' ?>">Peta Analisis Irigasi</a></li>
                <li><a href="<?= base_url('rekomendasi/peta') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'rekomendasi' && $this->uri->segment(2) == 'peta') ? 'active' : '' ?>">Peta Rekomendasi Tanaman</a></li>
                <li><a href="<?= base_url('spk/peta') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'spk' && $this->uri->segment(2) == 'peta') ? 'active' : '' ?>">Peta Prioritas Bantuan</a></li>

                <?php if($username == 'admin'){ ?>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-header">Data Pendukung</li>
                    <li><a href="<?= base_url('kondisi') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'kondisi') ? 'active' : '' ?>">Data Kondisi Lahan</a></li>
                    <li><a href="<?= base_url('produksi') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'produksi') ? 'active' : '' ?>">Data Produksi</a></li>
                    <li><a href="<?= base_url('kriteria') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'kriteria') ? 'active' : '' ?>">Data Kriteria</a></li>
                    <li><a href="<?= base_url('penilaian') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'penilaian') ? 'active' : '' ?>">Data Penilaian</a></li>
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-header">Sistem Pendukung Keputusan</li>
                    <li><a href="<?= base_url('rekomendasi') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'rekomendasi' && $this->uri->segment(2) != 'peta') ? 'active' : '' ?>">Rekomendasi Tanaman</a></li>
                    <li><a href="<?= base_url('prediksi') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'prediksi') ? 'active' : '' ?>">Prediksi Hasil Panen</a></li>
                    <li><a href="<?= base_url('spk') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'spk' && $this->uri->segment(2) != 'peta') ? 'active' : '' ?>">SPK Prioritas Bantuan</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
               class="nav-link dropdown-toggle <?= ($this->uri->segment(1) == 'lahan') ? 'active' : '' ?>">Lahan</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <?php if ($username <> "") { ?>
                    <li><a href="<?= base_url('lahan/add') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'lahan' && $this->uri->segment(2) == 'add') ? 'active' : '' ?>">Input Lahan</a></li>
                    <li><a href="<?= base_url('lahan/galleri') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'lahan' && $this->uri->segment(2) == 'galleri') ? 'active' : '' ?>">Data Galeri Foto</a></li>
                <?php } ?>
                <li><a href="<?= base_url('lahan') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'lahan' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : '' ?>">Data Lahan</a></li>
                <li><a href="<?= base_url('lahan/galeri_lahan') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'lahan' && $this->uri->segment(2) == 'galeri_lahan') ? 'active' : '' ?>">Galeri Lahan</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
               class="nav-link dropdown-toggle <?= ($this->uri->segment(1) == 'irigasi') ? 'active' : '' ?>">Irigasi</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                <?php if ($username <> "") { ?>
                    <li><a href="<?= base_url('irigasi/add') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'irigasi' && $this->uri->segment(2) == 'add') ? 'active' : '' ?>">Input Irigasi</a></li>
                <?php } ?>
                <li><a href="<?= base_url('irigasi') ?>" class="dropdown-item <?= ($this->uri->segment(1) == 'irigasi' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : '' ?>">Data Irigasi</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('home/about') ?>" class="nav-link <?= ($this->uri->segment(2) == 'about') ? 'active' : '' ?>">About</a>
        </li>
    </ul>
</div>

<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
    <li class="nav-item">
        <?php if ($username == "") { ?>
            <a href="<?= base_url('auth/login') ?>" class="nav-link"><i class="fa fa-sign-in"></i> Login</a>
        <?php } else { ?>
            <span class="nav-link"><i class="fas fa-user"></i> <?= $this->session->userdata('nama_user') ?></span>
            <a href="<?= base_url('auth/logout') ?>" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a>
        <?php } ?>
    </li>
</ul>
</nav>