<form action="<?= base_url('kondisi/save') ?>" method="post">

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Input Kondisi Lahan
        </h3>
    </div>

    <div class="card-body">

        <!-- LAHAN -->
        <div class="form-group">
            <label>Nama Lahan</label>

            <select name="id_lahan"
                    class="form-control"
                    required>

                <option value="">
                    -- Pilih Lahan --
                </option>

                <?php foreach($lahan as $l){ ?>

                <option value="<?= $l->id_lahan ?>">
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

                <option value="">
                    -- Pilih Jenis Tanah --
                </option>

                <option value="Lempung">
                    Lempung
                </option>

                <option value="Liat">
                    Liat
                </option>

                <option value="Berpasir">
                    Berpasir
                </option>

                <option value="Humus">
                    Humus
                </option>

                <option value="Aluvial">
                    Aluvial
                </option>

            </select>

            <small class="text-muted">
                Contoh: Lempung sangat cocok untuk padi.
            </small>
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
                placeholder="Contoh : 6.5"
                required>

            <small class="text-muted">
                Rentang normal pertanian: 5.5 - 7.5
            </small>

        </div>

        <!-- SUMBER AIR -->
        <div class="form-group">

            <label>Sumber Air</label>

            <select name="sumber_air"
                    class="form-control"
                    required>

                <option value="">
                    -- Pilih Sumber Air --
                </option>

                <option value="Irigasi">
                    Irigasi
                </option>

                <option value="Sungai">
                    Sungai
                </option>

                <option value="Sumur">
                    Sumur
                </option>

                <option value="Tadah Hujan">
                    Tadah Hujan
                </option>

                <option value="Embung">
                    Embung
                </option>

            </select>

        </div>

        <!-- CURAH HUJAN -->
        <div class="form-group">

            <label>Curah Hujan (mm/tahun)</label>

            <input
                type="number"
                name="curah_hujan"
                class="form-control"
                placeholder="Contoh : 2000">

            <small class="text-muted">
                Contoh: 1500 - 3000 mm/tahun
            </small>

        </div>

        <!-- KETINGGIAN -->
        <div class="form-group">

            <label>Ketinggian (mdpl)</label>

            <input
                type="number"
                name="ketinggian"
                class="form-control"
                placeholder="Contoh : 450">

            <small class="text-muted">
                Meter di atas permukaan laut
            </small>

        </div>

    </div>

    <div class="card-footer">

        <button type="submit"
                class="btn btn-success">

            <i class="fas fa-save"></i>
            Simpan

        </button>

        <a href="<?= base_url('kondisi') ?>"
           class="btn btn-secondary">

           Kembali

        </a>

    </div>

</div>

</form>