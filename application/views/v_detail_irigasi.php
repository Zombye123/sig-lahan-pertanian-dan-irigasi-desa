<div class="content">
    <div class="row">

        <div class="col-sm-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Peta Jalur Irigasi</h3>
                </div>
                <div class="card-body">
                    <div id="map" style="width: 100%; height: 400px; border: 1px solid #ccc; border-radius: 4px;"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Atribut Irigasi</h3>
                </div>
                <div class="card-body">
<table class="table table-bordered table-striped">
    <tr>
        <th width="150px">Nama Irigasi</th>
        <th width="20px">:</th>
        <td><?= htmlspecialchars($irigasi->nama_irigasi, ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Panjang Jalur</th>
        <th>:</th>
        <td>
            <?php 
            // Membersihkan karakter non-angka
            $panjang = preg_replace('/[^0-9.]/', '', $irigasi->panjang_jalur);
            echo !empty($panjang) ? number_format((float)$panjang, 0, ',', '.') : '0'; 
            ?> Meter
        </td>
    </tr>
    <tr>
        <th>Lebar Jalur</th>
        <th>:</th>
        <td>
            <?php 
            // Membersihkan karakter non-angka
            $lebar = preg_replace('/[^0-9.]/', '', $irigasi->lebar_jalur);
            echo !empty($lebar) ? number_format((float)$lebar, 1, ',', '.') : '0'; 
            ?> Meter
        </td>
    </tr>
    <tr>
        <th>Foto Dokumentasi</th>
        <th>:</th>
        <td>
            <?php if(!empty($irigasi->gambar)){ ?>
                <img src="<?= base_url('gambar/' . $irigasi->gambar) ?>" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: cover;">
            <?php } else { ?>
                <span class="text-muted">Tidak ada gambar</span>
            <?php } ?>
        </td>
    </tr>
</table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // ========================================================
    // LAYER BASEMAP (Menggunakan Esri & OSM Standard)
    // ========================================================
    // Catatan: Memperbaiki layer Mapbox lama yang sering memicu kegagalan muat tiles
    var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 22
    });

    var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri - World Imagery',
        maxZoom: 22
    });

    var grupirigasi = L.featureGroup(); // Mengubah layerGroup menjadi featureGroup agar kalkulasi getBounds() lebih presisi

    // ========================================================
    // INITIALIZE MAP INSTANCE
    // ========================================================
    var map = L.map('map', {
        center: [-1.974050, 100.888755], // Pusat default koordinat cadangan
        zoom: 15,
        layers: [peta1, grupirigasi] // Peta jalan (peta1) dijadikan basemap utama default
    });

    var baseLayers = {
        "Peta Jalan (OSM)": peta1,
        "Citra Satelit (Esri)": peta2
    };

    var overlays = {
        "Jalur Irigasi": grupirigasi
    };

    L.control.layers(baseLayers, overlays).addTo(map);

    // ========================================================
    // INJEKSI DATA GEOMETRI JALUR GEOJSON
    // ========================================================
    try {
        var geojsonData = <?= $irigasi->jalur_geojson; ?>;

        var irigasiLayer = L.geoJSON(geojsonData, {
            style: {
                color: "<?= !empty($irigasi->warna) ? $irigasi->warna : '#0066ff' ?>",
                weight: <?= !empty($irigasi->ketebalan) ? $irigasi->ketebalan : 4 ?>,
                opacity: 0.9
            }
        }).addTo(grupirigasi);

        // Pasang Popup Informasi interaktif saat elemen garis diklik
        irigasiLayer.bindPopup(
            '<div style="min-width:200px; max-width:280px">' +
            '<h6><b><?= addslashes($irigasi->nama_irigasi) ?></b></h6>' +
            '<hr style="margin:5px 0;">' +
            '<b>Panjang:</b> <?= $irigasi->panjang_jalur ?> m<br>' +
            '<b>Lebar:</b> <?= $irigasi->lebar_jalur ?> m<br>' +
            '<?php if(!empty($irigasi->gambar)){ ?>' +
            '<img src="<?= base_url("gambar/" . $irigasi->gambar) ?>" class="img-fluid rounded mt-2" style="width:100%; max-height:120px; object-fit:cover;">' +
            '<?php } ?>' +
            '</div>'
        );

        // Autofokus kamera peta langsung melompat mengunci seluruh area jalur irigasi tersebut
        if (grupirigasi.getLayers().length > 0) {
            map.fitBounds(grupirigasi.getBounds(), {
                padding: [40, 40],
                maxZoom: 18
            });
        }

    } catch (error) {
        console.error("Gagal melakukan render data GeoJSON Irigasi:", error);
    }

    // ========================================================
    // ASYNC FIX: MEMAKSA RENDERING ULANG UKURAN CONTAINER PETA
    // ========================================================
    // Solusi mutakhir mengatasi bug peta macet, blank abu-abu, atau terpotong setengah saat load
    setTimeout(function() {
        map.invalidateSize();
        if (typeof irigasiLayer !== 'undefined') {
            map.fitBounds(grupirigasi.getBounds(), { padding: [40, 40] });
        }
    }, 450);

});
</script>