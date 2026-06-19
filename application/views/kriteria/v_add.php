<form action="<?= base_url('kriteria/save') ?>"
      method="post">

<div class="card">

    <div class="card-body">

        <div class="form-group">

            <label>Nama Kriteria</label>

            <input type="text"
                   name="nama_kriteria"
                   class="form-control"
                   required>

        </div>

        <div class="form-group">

            <label>Bobot</label>

            <input type="number"
                   step="0.01"
                   name="bobot"
                   class="form-control"
                   required>

            <small class="text-muted">
                Contoh: 0.30
            </small>

        </div>

    </div>

    <div class="card-footer">

        <button type="submit"
                class="btn btn-success">

            Simpan

        </button>

        <a href="<?= base_url('kriteria') ?>"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

</form>