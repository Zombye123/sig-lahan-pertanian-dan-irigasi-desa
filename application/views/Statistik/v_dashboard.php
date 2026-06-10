<div class="content">
<div class="container-fluid">

<div class="row">

    <div class="col-lg-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $total_lahan ?></h3>
                <p>Total Lahan</p>
            </div>
            <div class="icon">
                <i class="fas fa-map"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $total_irigasi ?></h3>
                <p>Total Irigasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-water"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $total_luas->luas_lahan ?></h3>
                <p>Total Luas Lahan</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-area"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $total_pemilik ?></h3>
                <p>Total Pemilik</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

</div>

<div class="row">

<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Grafik Jenis Tanaman</h3>
</div>
<div class="card-body">
<canvas id="tanamanChart"></canvas>
</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Grafik Per Tahun</h3>
</div>
<div class="card-body">
<canvas id="tahunChart"></canvas>
</div>
</div>
</div>

</div>

<div class="row">

<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Top Pemilik Lahan</h3>
</div>
<div class="card-body">

<table class="table table-bordered">
<thead>
<tr>
<th>No</th>
<th>Pemilik</th>
<th>Jumlah Lahan</th>
</tr>
</thead>

<tbody>

<?php $no=1; foreach($pemilik as $row){ ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $row->pemilik_lahan ?></td>
<td><?= $row->jumlah ?></td>
</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>
</div>

<div class="col-md-6">
<div class="card">
<div class="card-header">
<h3 class="card-title">Data Lahan Terbaru</h3>
</div>
<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>Nama Lahan</th>
<th>Pemilik</th>
<th>Tahun</th>
</tr>
</thead>

<tbody>

<?php foreach($terbaru as $row){ ?>

<tr>
<td><?= $row->nama_lahan ?></td>
<td><?= $row->pemilik_lahan ?></td>
<td><?= $row->tahun ?></td>
</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>
</div>

</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

var ctx1 = document.getElementById('tanamanChart');

new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: [
            <?php foreach($tanaman as $row){ ?>
            '<?= $row->isi_lahan ?>',
            <?php } ?>
        ],
        datasets: [{
            data: [
                <?php foreach($tanaman as $row){ ?>
                <?= $row->jumlah ?>,
                <?php } ?>
            ]
        }]
    }
});

var ctx2 = document.getElementById('tahunChart');

new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: [
            <?php foreach($tahun as $row){ ?>
            '<?= $row->tahun ?>',
            <?php } ?>
        ],
        datasets: [{
            label:'Jumlah Lahan',
            data:[
                <?php foreach($tahun as $row){ ?>
                <?= $row->jumlah ?>,
                <?php } ?>
            ]
        }]
    }
});

</script>