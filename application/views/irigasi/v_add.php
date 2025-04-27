<div class="content">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Input Data Irigasi</h3>
    </div>

    <div class="card-body">
      <div class="row">
        <div class="col-sm-7">
          <!-- Peta -->
          <div id="map" style="width: 100%; height: 600px;"></div>
        </div>

        <div class="col-sm-5">
          <?php
          echo validation_errors('<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-ban"></i> ', '</div>');

          if (isset($error_upload)) {
            echo '<div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fas fa-exclamation-triangle"></i> ' . $error_upload . '</div>';
          }

          if ($this->session->flashdata('sukses')) {
            echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fas fa-check"></i> ';
            echo $this->session->flashdata('sukses');
            echo '</div>';
          }

          echo form_open_multipart('irigasi/add');
          ?>

          <div class="form-group">
            <label>Nama Irigasi</label>
            <input type="text" name="nama_irigasi" class="form-control" placeholder="Nama Irigasi">
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Panjang Jalur</label>
                <input type="text" name="panjang_jalur" class="form-control" placeholder="Panjang Jalur">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Lebar Jalur</label>
                <input type="text" name="lebar_jalur" class="form-control" placeholder="Lebar Jalur">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Jalur GeoJSON</label>
            <textarea name="jalur_geojson" rows="4" class="form-control"></textarea>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Warna Jalur</label>
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
                <label>Ketebalan</label>
                <select name="ketebalan" class="form-control">
                  <option value="">--Pilih--</option>
                  <?php for ($i = 1; $i <= 10; $i++) { ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
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

<!-- Leaflet Map + Draw -->
<script>
  var gruplahan = L.layerGroup();
  var grupirigasi = L.layerGroup();

  var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    maxZoom: 19,
    attribution: 'Map data &copy; OpenStreetMap contributors & CARTO'
  });

  var peta2 = L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
    attribution: '&copy; OpenStreetMap contributors'
  });

  var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  });

  var map = L.map('map', {
    center: [-6.841019715671052, 107.14861675902371],
    zoom: 15,
    layers: [peta3, gruplahan, grupirigasi]
  });

  var baseLayers = {
    "Grayscale": peta1,
    "Satelite": peta2,
    "Streets": peta3
  };

  L.control.layers(baseLayers).addTo(map);

  var drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  var drawControl = new L.Control.Draw({
    draw: {
      polygon: false,
      marker: false,
      circle: false,
      circlemarker: false,
      rectangle: false,
      polyline: true
    },
    edit: {
      featureGroup: drawnItems
    }
  });
  map.addControl(drawControl);

  // Update textarea function
  function updateGeoJSON() {
    var data = drawnItems.toGeoJSON();
    $("[name=jalur_geojson]").val(JSON.stringify(data));
  }

  // Buat draw
  map.on('draw:created', function(event) {
    var layer = event.layer;
    drawnItems.addLayer(layer);
    updateGeoJSON();
  });

  // Edit draw
  map.on('draw:edited', function(e) {
    updateGeoJSON();
  });

  // Delete draw
  map.on('draw:deleted', function(e) {
    updateGeoJSON();
  });
</script>

<!-- Color Picker -->
<script>
  $(function () {
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
  })
</script>
