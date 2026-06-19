<form action="<?= base_url('produksi/update') ?>"
method="post">

<input type="hidden"
name="id_produksi"
value="<?= $produksi->id_produksi ?>">

<div class="card">

<div class="card-body">

<div class="form-group">

<label>Lahan</label>

<select name="id_lahan"
class="form-control">

<?php foreach($lahan as $l){ ?>

<option value="<?= $l->id_lahan ?>"
<?= ($l->id_lahan==$produksi->id_lahan)?'selected':'' ?>>

<?= $l->nama_lahan ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Tahun</label>

<input type="number"
name="tahun"
value="<?= $produksi->tahun ?>"
class="form-control">

</div>

<div class="form-group">

<label>Tanaman</label>

<input type="text"
name="tanaman"
value="<?= $produksi->tanaman ?>"
class="form-control">

</div>

<div class="form-group">

<label>Hasil Panen</label>

<input type="number"
step="0.01"
name="hasil_panen"
value="<?= $produksi->hasil_panen ?>"
class="form-control">

</div>

</div>

<div class="card-footer">

<button type="submit"
class="btn btn-success">

Update

</button>

<a href="<?= base_url('produksi') ?>"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</form>