<div class="content">
<div class="container-fluid">

<form action="<?= base_url('kondisi/update') ?>" method="post">

<input type="hidden"
       name="id_kondisi"
       value="<?= $kondisi->id_kondisi ?>">

<div class="card card-warning">

    <div class="card-header">
        <h3 class="card-title">
            Edit Kondisi Lahan
        </h3>
    </div>

    <div class="card-body">

        <!-- LAHAN -->
        <div class="form-group">

            <label>Nama Lahan</label>

            <select name="id_lahan"
                    class="form-control"
                    required>

                <?php foreach($lahan as $l){ ?>

                <option value="<?= $l->id_lahan ?>"
                    <?= ($l->id_lahan == $kondisi->id_lahan) ? 'selected' : '' ?>>

                    <?= $l->nama_lahan ?>

                </option>

                <?php } ?>

            </select>

        </div>

        <!-- JENIS TANAH -->
        <div class="form-group">

            <label>Jenis Tanah</label>

            <select name="jenis_tanah"
                    class="form-control"
                    required>

                <?php
                $tanah = [
                    'Lempung',
                    'Liat',
                    'Berpasir',
                    'Humus',
                    'Aluvial'
                ];

                foreach($tanah as $t){
                ?>

                <option value="<?= $t ?>"
                    <?= ($kondisi->jenis_tanah == $t) ? 'selected' : '' ?>>

                    <?= $t ?>

                </option>

                <?php } ?>

            </select>

        </div>

        <!-- PH -->
        <div class="form-group">

            <label>PH Tanah</label>

            <input
                type="number"
                step="0.1"
                min="0"
                max="14"
                name="ph_tanah"
                class="form-control"
                value="<?= $kondisi->ph_tanah ?>"
                required>

            <small class="text-muted">
                Contoh: 6.5
            </small>

        </div>

        <!-- SUMBER AIR -->
        <div class="form-group">

            <label>Sumber Air</label>

            <select name="sumber_air"
                    class="form-control"
                    required>

                <?php
                $air = [
                    'Irigasi',
                    'Sungai',
                    'Sumur',
                    'Tadah Hujan',
                    'Embung'
                ];

                foreach($air as $a){
                ?>

                <option value="<?= $a ?>"
                    <?= ($kondisi->sumber_air == $a) ? 'selected' : '' ?>>

                    <?= $a ?>

                </option>

                <?php } ?>

            </select>

        </div>

        <!-- CURAH HUJAN -->
        <div class="form-group">

            <label>Curah Hujan (mm/tahun)</label>

            <input
                type="number"
                name="curah_hujan"
                class="form-control"
                value="<?= $kondisi->curah_hujan ?>">

            <small class="text-muted">
                Contoh: 2000
            </small>

        </div>

        <!-- KETINGGIAN -->
        <div class="form-group">

            <label>Ketinggian (mdpl)</label>

            <input
                type="number"
                name="ketinggian"
                class="form-control"
                value="<?= $kondisi->ketinggian ?>">

            <small class="text-muted">
                Contoh: 450
            </small>

        </div>

    </div>

    <div class="card-footer">

        <button type="submit"
                class="btn btn-success">

            <i class="fas fa-save"></i>
            Update

        </button>

        <a href="<?= base_url('kondisi') ?>"
           class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

</form>

</div>
</div>