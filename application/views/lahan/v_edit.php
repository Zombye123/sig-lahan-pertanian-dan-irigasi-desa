<div class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Data Lahan Pertanian</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Peta -->
                <div class="col-sm-7">
                    <div id="map" style="width: 100%; height: 600px;"></div>
                </div>

                <!-- Form input -->
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
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="icon fas fa-check"></i> ';
                        echo $this->session->flashdata('sukses');
                        echo '</div>';
                    }

                    echo form_open_multipart('lahan/edit/' . $lahan->id_lahan); 
                    ?>

                    <div class="form-group">
                        <label>Nama Lahan</label>
                        <input type="text" name="nama_lahan" value="<?= htmlspecialchars($lahan->nama_lahan) ?>" class="form-control" placeholder="Nama Lahan">
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Luas Lahan (m²)</label>
                                <input type="text" name="luas_lahan" value="<?= htmlspecialchars($lahan->luas_lahan) ?>" class="form-control" placeholder="Luas Lahan">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Luas (Ha)</label>
                                <input type="text" name="luas_ha" value="<?= !empty($lahan->luas_ha) ? number_format($lahan->luas_ha,2) : '' ?>" class="form-control" placeholder="Luas Ha">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Isi Lahan</label>
                        <select name="isi_lahan" class="form-control">
                            <option value="<?= htmlspecialchars($lahan->isi_lahan) ?>"><?= htmlspecialchars($lahan->isi_lahan) ?></option>
                            <option value="Padi">Padi</option>
                            <option value="Jagung">Jagung</option>
                            <option value="Cabe">Cabe</option>
                            <option value="Sawit">Sawit</option>
                            <option value="Kelapa">Kelapa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pemilik Lahan</label>
                        <input type="text" name="pemilik_lahan" value="<?= htmlspecialchars($lahan->pemilik_lahan) ?>" class="form-control" placeholder="Pemilik Lahan">
                    </div>

                    <div class="form-group">
                        <label>Alamat Pemilik</label>
                        <input type="text" name="alamat_pemilik" value="<?= htmlspecialchars($lahan->alamat_pemilik) ?>" class="form-control" placeholder="Alamat Pemilik">
                    </div>

                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="text" name="tahun" value="<?= htmlspecialchars($lahan->tahun) ?>" class="form-control" placeholder="Tahun">
                    </div>

                    <div class="form-group">
                        <label>Denah GeoJSON</label>
                        <textarea name="denah_geojson" rows="4" class="form-control"><?= htmlspecialchars($lahan->denah_geojson) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <?php if(!empty($lahan->gambar)) : ?>
                                <img src="<?= base_url('gambar/' . $lahan->gambar) ?>" width="200px" class="mb-2">
                            <?php endif; ?>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Warna Denah</label>
                                <div class="input-group my-colorpicker2">
                                    <input type="text" name="warna" value="<?= htmlspecialchars($lahan->warna) ?>" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-square"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ganti Gambar</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-warning">Reset</button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var drawnItems = L.geoJSON(<?= !empty($lahan->denah_geojson) ? $lahan->denah_geojson : '{}' ?>);
var map = L.map('map', {
    center: [-6.841, 107.149],
    zoom: 15,
    layers: [
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 22,
            attribution: '© OpenStreetMap contributors'
        }),
        drawnItems
    ]
});

var drawControl = new L.Control.Draw({
    draw: {
        polygon: true,
        marker: false,
        circle: false,
        circlemarker: false,
        rectangle: false,
        polyline: false
    },
    edit: {
        featureGroup: drawnItems
    }
});
map.addControl(drawControl);

map.on('draw:created', function(e) {
    var layer = e.layer;
    drawnItems.addLayer(layer);
    $("[name=denah_geojson]").val(JSON.stringify(drawnItems.toGeoJSON()));
});
map.on('draw:edited', function(e) {
    $("[name=denah_geojson]").val(JSON.stringify(drawnItems.toGeoJSON()));
});
map.on('draw:deleted', function(e) {
    $("[name=denah_geojson]").val(JSON.stringify(drawnItems.toGeoJSON()));
});

if(drawnItems.getLayers().length > 0){
    map.fitBounds(drawnItems.getBounds());
}

$(function() {
    $('.my-colorpicker2').colorpicker({ format: 'hex' });
    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
});
</script>