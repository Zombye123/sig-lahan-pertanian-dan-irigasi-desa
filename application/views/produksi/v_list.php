<div class="card">

<div class="card-header">

<a href="<?= base_url('produksi/add') ?>"
class="btn btn-primary">

<i class="fas fa-plus"></i>
Tambah Produksi

</a>

</div>

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>No</th>
<th>Lahan</th>
<th>Tahun</th>
<th>Tanaman</th>
<th>Hasil Panen (Ton)</th>
<th width="150">Aksi</th>

</tr>

</thead>

<tbody>

<?php
$no=1;

foreach($produksi as $row){
?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row->nama_lahan ?></td>

<td><?= $row->tahun ?></td>

<td><?= $row->tanaman ?></td>

<td><?= $row->hasil_panen ?></td>

<td>

<a href="<?= base_url('produksi/edit/'.$row->id_produksi) ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="<?= base_url('produksi/delete/'.$row->id_produksi) ?>"
onclick="return confirm('Yakin hapus data?')"
class="btn btn-danger btn-sm">

Hapus

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>