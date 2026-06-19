<div class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Input Data Lahan Pertanian</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-7">
                    <div id="map" style="width: 100%; height: 600px;"></div>
                </div>

                <div class="col-sm-5">
                    <?php
                    echo validation_errors('<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-ban"></i> ', '</div>');

                    if (isset($error_upload)) {
                        echo '<div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-exclamation-triangle"></i> ' . $error_upload . '</div>';
                    }

                    if ($this->session->flashdata('sukses')) {
                        echo '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ' . $this->session->flashdata('sukses') . '</div>';
                    }

                    echo form_open_multipart('lahan/add'); ?>

                    <div class="form-group">
                        <label>Nama Lahan</label>
                        <input type="text" name="nama_lahan" class="form-control" placeholder="Nama Lahan" required>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Luas Lahan</label>
                                <input type="text" name="luas_lahan" class="form-control" placeholder="Luas Lahan">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Luas (Ha)</label>
                                <input type="number" name="luas_ha" class="form-control" placeholder="Contoh: 5">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Isi Lahan</label>
                        <select name="isi_lahan" class="form-control">
                            <option value="Padi">Padi</option>
                            <option value="Jagung">Jagung</option>
                            <option value="Cabe">Cabe</option>
                            <option value="Sawit">Sawit</option>
                            <option value="Kelapa">Kelapa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pemilik Lahan</label>
                        <input type="text" name="pemilik_lahan" class="form-control" placeholder="Pemilik Lahan">
                    </div>

                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="text" name="tahun" class="form-control" placeholder="Contoh: 2025">
                    </div>

                    <div class="form-group">
                        <label>Alamat Pemilik</label>
                        <input type="text" name="alamat_pemilik" class="form-control" placeholder="Alamat Pemilik">
                    </div>

                    <div class="form-group">
                        <label>Denah GeoJSON</label>
                        <textarea name="denah_geojson" rows="4" class="form-control" readonly></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Warna Denah</label>
                                <div class="input-group my-colorpicker2">
                                    <input type="text" name="warna" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Gambar</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning" onclick="drawnItems.clearLayers(); $('[name=denah_geojson]').val('');">Reset</button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var map = L.map('map', {
        center: [-6.805674719157868, 107.14074957043474],
        zoom: 20,
        layers: [L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {subdomains: ['mt0','mt1','mt2','mt3']})]
    });

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    var drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            marker: false,
            circle: false,
            circlemarker: false,
            rectangle: false,
            polyline: false,
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    map.addControl(drawControl);

    // Fungsi pembaruan GeoJSON
    function updateGeoJSON() {
        var data = drawnItems.toGeoJSON();
        $("[name=denah_geojson]").val(JSON.stringify(data));
    }

    map.on('draw:created', function(e) {
        drawnItems.addLayer(e.layer);
        updateGeoJSON();
    });

    map.on('draw:edited', function(e) {
        updateGeoJSON();
    });

    map.on('draw:deleted', function(e) {
        updateGeoJSON();
    });
</script>

<script>
    $(function() {
        $('.my-colorpicker2').colorpicker({ format: 'rgba' });
        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toRgbString());
        });
    });
</script>