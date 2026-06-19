<div class="content">
<div class="container-fluid">

<?php
$terjangkau = 0;
$belum = 0;

foreach($hasil as $h){
    if($h['status'] == 'Terjangkau'){
        $terjangkau++;
    } else {
        $belum++;
    }
}
?>

<div class="row">
    <div class="col-lg-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $terjangkau ?></h3>
                <p>Lahan Terjangkau Irigasi</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $belum ?></h3>
                <p>Lahan Belum Terjangkau</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="form-group row mb-0 align-items-center">
            <label for="filterLahan" class="col-sm-2 col-form-label"><b>Cari / Fokus Lahan:</b></label>
            <div class="col-sm-10">
                <select id="filterLahan" class="form-control select2">
                    <option value="">-- Pilih Lahan Pertanian --</option>
                    <?php foreach($lahan as $lh){ ?>
                        <option value="<?= $lh->id_lahan ?>"><?= htmlspecialchars($lh->nama_lahan, ENT_QUOTES, 'UTF-8') ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Peta Analisis Jangkauan Irigasi</h3>
    </div>
    <div class="card-body">
        <div id="map" style="height:600px;"></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Hasil Analisis Datatables</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Lahan</th>
                    <th>Irigasi Terdekat</th>
                    <th>Jarak (Meter)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach($hasil as $row){
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_lahan'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['irigasi'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= number_format($row['jarak'], 2, ',', '.') ?></td>
                    <td>
                        <?php if($row['status'] == "Terjangkau"){ ?>
                            <span class="badge badge-success">Terjangkau</span>
                        <?php } else { ?>
                            <span class="badge badge-danger">Belum Terjangkau</span>
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

<script>
document.addEventListener("DOMContentLoaded", function(){

    // ==========================
    // BASEMAP TILES
    // ==========================
    var osm = L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 22
        }
    );

    var satelit = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        {
            attribution: '© Esri',
            maxZoom: 22
        }
    );

    // ==========================
    // LAYER GROUPS
    // ==========================
    var grupLahan = L.featureGroup();
    var grupIrigasi = L.featureGroup();
    var layerLahanDict = {}; 

    // ==========================
    // INITIALIZE MAP
    // ==========================
    var map = L.map('map', {
        center: [-6.838794592277381, 107.1396653663789],
        zoom: 15,
        layers: [osm, grupLahan, grupIrigasi]
    });

    // ==========================
    // LOOP JARINGAN IRIGASI (POLYLINE)
    // ==========================
    <?php foreach($irigasi as $ir){ ?>
    try {
        var irigasiGeojson = <?= $ir->jalur_geojson ?>;

        L.geoJSON(irigasiGeojson, {
            style: {
                color: '#0066ff',
                weight: 5,
                opacity: 1
            }
        })
        .addTo(grupIrigasi)
        .bindPopup('<b><?= addslashes(json_encode($ir->nama_irigasi)) ?></b>'.replace(/^"|"$/g, ''));

    } catch(err) {
        console.log('Error Irigasi ID: <?= $ir->id_irigasi ?? "" ?>', err);
    }
    <?php } ?>

    // ==========================
    // LOOP LAHAN PERTANIAN (POLYGON)
    // ==========================
    <?php
    foreach($lahan as $lh){
        $status = 'Belum Terjangkau';
        $jarak = 0;
        $namaIrigasi = '-';

        foreach($hasil as $h){
            if($h['id_lahan'] == $lh->id_lahan){
                $status = $h['status'];
                $jarak = $h['jarak'];
                $namaIrigasi = $h['irigasi'];
                break;
            }
        }

        $warna = ($status == 'Terjangkau') ? '#28a745' : '#dc3545';
    ?>

    try {
        var lahanGeojson = <?= $lh->denah_geojson ?>;

        var geojsonLayer = L.geoJSON(lahanGeojson, {
            style: {
                color: '#ffffff', 
                weight: 1,        
                fillColor: '<?= $warna ?>',
                fillOpacity: 0.75
            }
        })
        .addTo(grupLahan)
        .bindPopup(
            '<div style="min-width:250px">' +
            '<h5><b><?= addslashes(json_encode($lh->nama_lahan)) ?></b></h5>'.replace(/^"|"$/g, '') +
            '<hr style="margin: 8px 0;">' +
            '<b>Pemilik :</b><br>' + '<?= addslashes(json_encode($lh->pemilik_lahan)) ?>'.replace(/^"|"$/g, '') + '<br><br>' +
            '<b>Luas Lahan :</b><br>' + '<?= addslashes(json_encode($lh->luas_lahan)) ?>'.replace(/^"|"$/g, '') + '<br><br>' +
            '<b>Irigasi Terdekat :</b><br>' + '<?= addslashes(json_encode($namaIrigasi)) ?>'.replace(/^"|"$/g, '') + '<br><br>' +
            '<b>Jarak terdekat :</b><br>' + '<?= number_format($jarak, 2, ",", ".") ?> Meter<br><br>' +
            '<b>Status Akses :</b><br>' +
            '<?= ($status == "Terjangkau") ? "<span class=\"badge badge-success\">Terjangkau</span>" : "<span class=\"badge badge-danger\">Belum Terjangkau</span>" ?>' +
            '</div>'
        );

        // Petakan layer ke objek array assosiatif JavaScript
        layerLahanDict['<?= $lh->id_lahan ?>'] = geojsonLayer;

    } catch(err) {
        console.log('Error Lahan ID: <?= $lh->id_lahan ?>', err);
    }
    <?php } ?>

    // ========================================================
    // EVENT FILTER SELECTION (HIGHLIGHT & ANIMATION FLY)
    // ========================================================
    var filterSelect = document.getElementById('filterLahan');
    filterSelect.addEventListener('change', function() {
        var idLahanTerpilih = this.value;
        
        // 1. Kembalikan semua style border poligon lahan ke warna asal (Putih)
        for (var id in layerLahanDict) {
            if (layerLahanDict.hasOwnProperty(id)) {
                layerLahanDict[id].setStyle({
                    color: '#ffffff', 
                    weight: 1        
                });
            }
        }

        // 2. Jika ada opsi lahan yang dipilih, lakukan highlight
        if (idLahanTerpilih && layerLahanDict[idLahanTerpilih]) {
            var targetLayer = layerLahanDict[idLahanTerpilih];
            var bounds = targetLayer.getBounds();
            
            targetLayer.setStyle({
                color: '#ffcc00', // Ubah border menjadi Kuning Stabilo
                weight: 4         // Tebalkan border
            });
            
            targetLayer.bringToFront();

            // Pindah kamera peta secara smooth menuju objek poligon
            map.flyToBounds(bounds, {
                padding: [50, 50],
                duration: 1.2 
            });
        }
    });

    // ==========================
    // AUTO BOUNDS ACCUMULATION
    // ==========================
    var semuaObjek = L.featureGroup();

    grupLahan.eachLayer(function(layer){
        semuaObjek.addLayer(layer);
    });
    grupIrigasi.eachLayer(function(layer){
        semuaObjek.addLayer(layer);
    });

    if(semuaObjek.getLayers().length > 0){
        map.fitBounds(semuaObjek.getBounds(), { 
            padding: [30, 30] 
        });
    }

    // ==========================
    // CONTROLLER MAP LAYERS
    // ==========================
    var baseMaps = {
        "OpenStreetMap": osm,
        "Satelit": satelit
    };

    var overlayMaps = {
        "Lahan Pertanian": grupLahan,
        "Jaringan Irigasi": grupIrigasi
    };

    L.control.layers(baseMaps, overlayMaps).addTo(map);

    // ==========================
    // FLOATING MAP LEGEND
    // ==========================
    var legend = L.control({ position: 'bottomright' });

    legend.onAdd = function(){
        var div = L.DomUtil.create('div', 'info legend');
        div.style.background = '#fff';
        div.style.padding = '12px';
        div.style.borderRadius = '8px';
        div.style.boxShadow = '0 0 10px rgba(0,0,0,.2)';

        div.innerHTML =
            '<h6 class="mb-2"><b>Keterangan</b></h6>' +
            '<div style="margin-bottom:5px;">' +
            '<span style="display:inline-block;width:18px;height:18px;background:#28a745;margin-right:8px;vertical-align:middle;border-radius:2px;"></span>' +
            'Lahan Terjangkau' +
            '</div>' +
            '<div style="margin-bottom:5px;">' +
            '<span style="display:inline-block;width:18px;height:18px;background:#dc3545;margin-right:8px;vertical-align:middle;border-radius:2px;"></span>' +
            'Lahan Belum Terjangkau' +
            '</div>' +
            '<div>' +
            '<span style="display:inline-block;width:18px;height:4px;background:#0066ff;margin-right:8px;vertical-align:middle;"></span>' +
            'Jaringan Irigasi' +
            '</div>';

        return div;
    };

    legend.addTo(map);

    // Mencegah peta tidak merender ubin (grey tiles) secara penuh di awal load
    setTimeout(function(){
        map.invalidateSize();
    }, 500);

});
</script>