<div class="content">
<div class="container-fluid">

<div class="card">
<div class="card-header">
<h3 class="card-title">
Analisis Jangkauan Irigasi
</h3>
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Lahan</th>
<th>Irigasi Terdekat</th>
<th>Jarak (Meter)</th>
<th>Status</th>
</tr>

</thead>

<tbody>

<?php
$no=1;
foreach($hasil as $row){
?>

<tr>

<td><?= $no++ ?></td>

<td><?= $row['nama_lahan'] ?></td>

<td><?= $row['irigasi'] ?></td>

<td><?= $row['jarak'] ?></td>

<td>

<?php if($row['status']=="Terjangkau"){ ?>

<span class="badge badge-success">
Terjangkau
</span>

<?php } else { ?>

<span class="badge badge-danger">
Belum Terjangkau
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>

</div>
</div>