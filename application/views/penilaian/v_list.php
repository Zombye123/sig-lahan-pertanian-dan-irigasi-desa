<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-calculator"></i> <?php echo $title; ?></h1>
        <div>
            <a href="<?php echo base_url('penilaian/generate'); ?>" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin melakukan generate ulang semua nilai kriteria? Data penilaian lama akan di-reset.')">
                <i class="fas fa-sync"></i> Generate Penilaian Otomatis
            </a>
            <a href="<?php echo base_url('penilaian/hitung'); ?>" class="btn btn-primary ml-2">
                <i class="fas fa-cogs"></i> Hitung & Update SPK SAW
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> <?php echo $this->session->flashdata('pesan'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal Perhitungan!</strong> <?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Lahan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statistik->total_lahan; ?> Lahan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Rata-rata Skor Kriteria</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statistik->rata_nilai; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Skor Tertinggi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $statistik->nilai_tertinggi; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rekomendasi Terbaik</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 text-truncate">
                                <?php echo $lahan_terbaik ? $lahan_terbaik->nama_lahan : '-'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="spkTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="hasil-tab" data-toggle="tab" href="#hasil" role="tab"><i class="fas fa-trophy text-primary"></i> Rekomendasi & Ranking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="rekap-tab" data-toggle="tab" href="#rekap" role="tab"><i class="fas fa-table text-success"></i> Matriks Nilai Alternatif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="analisis-tab" data-toggle="tab" href="#analisis" role="tab"><i class="fas fa-chart-bar text-info"></i> Analisis Grafik & Distribusi</a>
                </li>
            </ul>
        </div>
        
        <div class="card-body">
            <div class="tab-content" id="spkTabContent">
                
                <div class="tab-pane fade show active" id="hasil" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-success font-weight-bold"><i class="fas fa-arrow-up"></i> TOP 10 LAHAN POTENSIAL</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-sm">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Rank</th>
                                            <th>Nama Lahan</th>
                                            <th>Pemilik</th>
                                            <th>Nilai Preferensi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($top10)): foreach($top10 as $t): ?>
                                        <tr class="<?php echo $t->ranking == 1 ? 'table-warning font-weight-bold' : ''; ?>">
                                            <td><?php echo $t->ranking; ?></td>
                                            <td><?php echo $t->nama_lahan; ?></td>
                                            <td><?php echo $t->pemilik_lahan; ?></td>
                                            <td><strong><?php echo $t->nilai_preferensi; ?></strong></td>
                                            <td><span class="badge badge-success"><?php echo $t->status; ?></span></td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                            <tr><td colspan="5" class="text-center">Belum ada data hasil perhitungan. Silakan klik tombol "Hitung SPK SAW".</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="text-danger font-weight-bold"><i class="fas fa-arrow-down"></i> BOTTOM 10 LAHAN</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover table-sm">
                                    <thead class="bg-danger text-white">
                                        <tr>
                                            <th>Rank</th>
                                            <th>Nama Lahan</th>
                                            <th>Pemilik</th>
                                            <th>Nilai Preferensi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($bottom10)): foreach($bottom10 as $b): ?>
                                        <tr>
                                            <td><?php echo $b->ranking; ?></td>
                                            <td><?php echo $b->nama_lahan; ?></td>
                                            <td><?php echo $b->pemilik_lahan; ?></td>
                                            <td><strong><?php echo $b->nilai_preferensi; ?></strong></td>
                                            <td><span class="badge badge-secondary"><?php echo $b->status; ?></span></td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                            <tr><td colspan="5" class="text-center">Belum ada data hasil perhitungan.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="rekap" role="tabpanel">
                    <form method="GET" action="<?php echo base_url('penilaian'); ?>" class="form-inline mb-3 justify-content-end">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Cari nama lahan/pemilik..." value="<?php echo isset($keyword) ? $keyword : ''; ?>">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                                <?php if(!empty($keyword)): ?>
                                    <a href="<?php echo base_url('penilaian'); ?>" class="btn btn-secondary">Reset</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th rowspan="2" class="align-middle">No</th>
                                    <th rowspan="2" class="align-middle text-left">Nama Lahan</th>
                                    <th rowspan="2" class="align-middle text-left">Pemilik</th>
                                    <th colspan="5">Kriteria Penilaian Lahan (Skor Skala)</th>
                                    <th rowspan="2" class="align-middle">Total Skor</th>
                                </tr>
                                <tr>
                                    <th>C5 (Luas)</th>
                                    <th>C6 (Produksi)</th>
                                    <th>C7 (Irigasi)</th>
                                    <th>C8 (pH)</th>
                                    <th>C9 (Hujan)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($rekap)): $no=1; foreach($rekap as $r): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="text-left"><?php echo $r->nama_lahan; ?></td>
                                    <td class="text-left"><?php echo $r->pemilik_lahan; ?></td>
                                    <td><span class="badge badge-light p-2 w-70"><?php echo $r->luas; ?></span></td>
                                    <td><span class="badge badge-light p-2 w-70"><?php echo $r->produksi; ?></span></td>
                                    <td><span class="badge badge-light p-2 w-70"><?php echo $r->irigasi; ?></span></td>
                                    <td><span class="badge badge-light p-2 w-70"><?php echo $r->ph; ?></span></td>
                                    <td><span class="badge badge-light p-2 w-70"><?php echo $r->hujan; ?></span></td>
                                    <td class="bg-light font-weight-bold"><?php echo $r->total_nilai; ?></td>
                                </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="9" class="text-center">Data kosong atau kata kunci pencarian tidak ditemukan.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="analisis" role="tabpanel">
                    <div class="row">
                        <div class="col-md-7">
                            <h5 class="font-weight-bold mb-3">Grafik Rata-rata Skor per Kriteria</h5>
                            <div style="position: relative; height:300px;">
                                <canvas id="chartEvaluasi"></canvas>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h5 class="font-weight-bold mb-3">Keterangan Atribut Parameter</h5>
                            <ul class="list-group">
                                <?php foreach($grafik as $g): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $g->nama_kriteria; ?>
                                    <span class="badge badge-info badge-pill">Avg: <?php echo $g->rata; ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('chartEvaluasi').getContext('2d');
        
        // Mempersiapkan data dari PHP loop ke dalam array JavaScript
        const labelsKriteria = [
            <?php foreach($grafik as $g) { echo '"' . $g->nama_kriteria . '",'; } ?>
        ];
        const dataRata = [
            <?php foreach($grafik as $g) { echo $g->rata . ','; } ?>
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labelsKriteria,
                datasets: [{
                    label: 'Rata-rata Nilai Mentah Kriteria',
                    data: dataRata,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5
                    }
                }
            }
        });
    });
</script>