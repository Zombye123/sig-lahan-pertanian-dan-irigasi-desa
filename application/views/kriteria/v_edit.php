<form action="<?= base_url('kriteria/update') ?>"
      method="post">

<input type="hidden"
       name="id_kriteria"
       value="<?= $kriteria->id_kriteria ?>">

<div class="card">

    <div class="card-body">

        <div class="form-group">

            <label>Nama Kriteria</label>

            <input type="text"
                   name="nama_kriteria"
                   value="<?= $kriteria->nama_kriteria ?>"
                   class="form-control"
                   required>

        </div>

        <div class="form-group">

            <label>Bobot</label>

            <input type="number"
                   step="0.01"
                   name="bobot"
                   value="<?= $kriteria->bobot ?>"
                   class="form-control"
                   required>

        </div>

    </div>

    <div class="card-footer">

        <button type="submit"
                class="btn btn-success">

            Update

        </button>

        <a href="<?= base_url('kriteria') ?>"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

</form>