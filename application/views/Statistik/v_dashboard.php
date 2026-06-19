<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner"><h3><?= $total_lahan ?></h3><p>Total Lahan</p></div>
                    <div class="icon"><i class="fas fa-map"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner"><h3><?= $total_irigasi ?></h3><p>Total Irigasi</p></div>
                    <div class="icon"><i class="fas fa-water"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner"><h3><?= $total_luas->luas_lahan ?? 0 ?></h3><p>Total Luas (Ha)</p></div>
                    <div class="icon"><i class="fas fa-chart-area"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner"><h3><?= $total_pemilik ?></h3><p>Total Pemilik</p></div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-info">
                    <div class="card-header"><h3 class="card-title"><i class="fas fa-tint mr-1"></i> Kondisi Irigasi</h3></div>
                    <div class="card-body">
                        <?php 
                        $total_irigasi_data = array_sum(array_column($kondisi_irigasi, 'jumlah'));
                        foreach($kondisi_irigasi as $k):
                            $persen = ($total_irigasi_data > 0) ? ($k->jumlah / $total_irigasi_data * 100) : 0;
                            $bg = ($k->kondisi == 'Baik') ? 'bg-success' : (($k->kondisi == 'Rusak Ringan') ? 'bg-warning' : 'bg-danger');
                        ?>
                            <div class="d-flex justify-content-between mb-1"><span><?= $k->kondisi ?></span><span><?= $k->jumlah ?> Lahan</span></div>
                            <div class="progress mb-3"><div class="progress-bar <?= $bg ?>" style="width: <?= $persen ?>%"><?= number_format($persen, 0) ?>%</div></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header"><h3 class="card-title"><i class="fas fa-seedling mr-1"></i> Ringkasan Hasil Panen (Ton)</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-striped">
                            <thead><tr><th>Tanaman</th><th class="text-right">Total Produksi</th></tr></thead>
                            <tbody>
                                <?php foreach($produksi as $p): ?>
                                <tr><td><?= $p->tanaman ?></td><td class="text-right font-weight-bold"><?= number_format($p->total_panen, 2) ?> Ton</td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Grafik Jenis Tanaman</h3></div>
                    <div class="card-body"><canvas id="tanamanChart" style="height:250px"></canvas></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Grafik Lahan Per Tahun</h3></div>
                    <div class="card-body"><canvas id="tahunChart" style="height:250px"></canvas></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Top 5 Pemilik Lahan</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <thead><tr><th>No</th><th>Pemilik</th><th>Jumlah</th></tr></thead>
                            <tbody><?php $no=1; foreach($pemilik as $row){ ?><tr><td><?= $no++ ?></td><td><?= $row->pemilik_lahan ?></td><td><?= $row->jumlah ?></td></tr><?php } ?></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Data Lahan Terbaru</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <thead><tr><th>Nama Lahan</th><th>Pemilik</th><th>Tahun</th></tr></thead>
                            <tbody><?php foreach($terbaru as $row){ ?><tr><td><?= $row->nama_lahan ?></td><td><?= $row->pemilik_lahan ?></td><td><?= $row->tahun ?></td></tr><?php } ?></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Jenis Tanaman
    new Chart(document.getElementById('tanamanChart'), {
        type: 'pie',
        data: {
            labels: [<?php foreach($tanaman as $row) echo "'$row->isi_lahan',"; ?>],
            datasets: [{ data: [<?php foreach($tanaman as $row) echo "$row->jumlah,"; ?>], backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'] }]
        },
        options: { maintainAspectRatio: false }
    });

    // Grafik Lahan Per Tahun
    new Chart(document.getElementById('tahunChart'), {
        type: 'bar',
        data: {
            labels: [<?php foreach($tahun as $row) echo "'$row->tahun',"; ?>],
            datasets: [{ label:'Jumlah Lahan', data:[<?php foreach($tahun as $row) echo "$row->jumlah,"; ?>], backgroundColor: '#3c8dbc' }]
        },
        options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
    });
</script>