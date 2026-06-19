<form action="<?= base_url('produksi/save') ?>"
method="post">

<div class="card">

<div class="card-body">

<div class="form-group">

<label>Lahan</label>

<select name="id_lahan"
class="form-control"
required>

<?php foreach($lahan as $l){ ?>

<option value="<?= $l->id_lahan ?>">

<?= $l->nama_lahan ?>

</option>

<?php } ?>

</select>

</div>

<div class="form-group">

<label>Tahun</label>

<input type="number"
name="tahun"
value="<?= date('Y') ?>"
class="form-control"
required>

</div>

<div class="form-group">

<label>Tanaman</label>

<select name="tanaman"
class="form-control">

<option>Padi</option>
<option>Jagung</option>
<option>Kedelai</option>
<option>Cabai</option>
<option>Tomat</option>
<option>Singkong</option>

</select>

</div>

<div class="form-group">

<label>Hasil Panen (Ton)</label>

<input type="number"
step="0.01"
name="hasil_panen"
class="form-control"
required>

</div>

</div>

<div class="card-footer">

<button type="submit"
class="btn btn-success">

Simpan

</button>

<a href="<?= base_url('produksi') ?>"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</form>