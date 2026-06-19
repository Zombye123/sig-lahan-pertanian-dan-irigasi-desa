<div class="content">
    <div class="container-fluid">

        <?php
        $sangat_tinggi = 0;
        $tinggi = 0;
        $sedang = 0;
        $rendah = 0;

        // Menghitung jumlah status prioritas secara dinamis
        foreach($lahan as $row){
            if($row['ranking'] <= 3){
                $sangat_tinggi++;
            }elseif($row['ranking'] <= 6){
                $tinggi++;
            }elseif($row['ranking'] <= 10){
                $sedang++;
            }else{
                $rendah++;
            }
        }
        ?>

        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $sangat_tinggi ?></h3>
                        <p>Sangat Tinggi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $tinggi ?></h3>
                        <p>Tinggi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-fire"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $sedang ?></h3>
                        <p>Sedang</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-water"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $rendah ?></h3>
                        <p>Rendah</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Peta Prioritas Bantuan Metode SAW
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('spk') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-table"></i> Hasil SPK
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="alert alert-info alert-dismissible">
                    <h5><i class="icon fas fa-info-circle"></i> Informasi</h5>
                    Warna polygon menunjukkan prioritas bantuan berdasarkan hasil Sistem Pendukung Keputusan (SAW). Klik pada area lahan untuk memunculkan ringkasan informasi data.
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <select id="pilihLahan" class="form-control">
                            <option value="">-- Pilih Lahan --</option>
                            <?php foreach($lahan as $l){ ?>
                                <option value="<?= $l['id_lahan'] ?>">
                                    <?= htmlspecialchars($l['nama_lahan'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetMap" class="btn btn-secondary btn-block">
                            <i class="fas fa-sync"></i> Reset
                        </button>
                    </div>
                    <div class="col-md-6 text-right d-none d-md-block">
                        <span class="badge mb-1" style="background-color: #dc3545; color: white; padding: 6px 10px;">Sangat Tinggi</span>
                        <span class="badge mb-1" style="background-color: #fd7e14; color: white; padding: 6px 10px;">Tinggi</span>
                        <span class="badge mb-1" style="background-color: #ffc107; color: black; padding: 6px 10px;">Sedang</span>
                        <span class="badge mb-1" style="background-color: #28a745; color: white; padding: 6px 10px;">Rendah</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <div id="map" style="height: 600px; border: 1px solid #ddd; border-radius: 5px; z-index: 1;"></div>
                    </div>
                    <div class="col-md-3 mt-3 mt-md-0">
                        <div class="card card-secondary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><b>Legenda Warna</b></h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <td style="background:#dc3545; width:35px;"></td>
                                        <td>Sangat Tinggi (Rank 1-3)</td>
                                    </tr>
                                    <tr>
                                        <td style="background:#fd7e14;"></td>
                                        <td>Tinggi (Rank 4-6)</td>
                                    </tr>
                                    <tr>
                                        <td style="background:#ffc107;"></td>
                                        <td>Sedang (Rank 7-10)</td>
                                    </tr>
                                    <tr>
                                        <td style="background:#28a745;"></td>
                                        <td>Rendah (Rank >10)</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="alert alert-light border mt-2">
                            <small><b>Tips:</b> Anda bisa langsung memfokuskan peta ke wilayah tertentu menggunakan menu dropdown di atas.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
// Inisialisasi peta secara default
var map = L.map('map').setView([-6.92, 107.60], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19
}).addTo(map);

// Wadah objek referensi layer polygon koordinat GIS
var semuaPolygon = {};
var semuaLayer = [];

<?php foreach($lahan as $h){ ?>
    <?php
    // Mapping kode warna heksadesimal berdasarkan status kelayakan prioritas bantuan
    switch($h['prioritas']){
        case 'Sangat Tinggi': $warna = "#dc3545"; break;
        case 'Tinggi':        $warna = "#fd7e14"; break;
        case 'Sedang':        $warna = "#ffc107"; break;
        default:              $warna = "#28a745"; break;
    }
    ?>

    try {
        var geojsonRaw<?= $h['id_lahan']; ?> = <?= !empty($h['geojson']) ? (is_string($h['geojson']) ? $h['geojson'] : json_encode($h['geojson'])) : 'null'; ?>;

        if (geojsonRaw<?= $h['id_lahan']; ?> !== null) {
            
            var geojsonObj<?= $h['id_lahan']; ?> = (typeof geojsonRaw<?= $h['id_lahan']; ?> === 'string') ? JSON.parse(geojsonRaw<?= $h['id_lahan']; ?>) : geojsonRaw<?= $h['id_lahan']; ?>;

            var polygon<?= $h['id_lahan']; ?> = L.geoJSON(geojsonObj<?= $h['id_lahan']; ?>, {
                style: function(feature){
                    return {
                        color: '<?= $warna ?>',
                        fillColor: '<?= $warna ?>',
                        weight: 3,
                        fillOpacity: 0.65
                    };
                },
                onEachFeature: function(feature, layer){
                    var popupHtml = '<div style="min-width: 220px;">' +
                        '<table class="table table-sm table-bordered mb-0" style="font-size: 12px;">' +
                        '<tr><th class="bg-light" style="width: 40%;">Nama Lahan</th><td><?= addslashes($h['nama_lahan']) ?></td></tr>' +
                        '<tr><th class="bg-light">Pemilik</th><td><?= addslashes($h['pemilik_lahan']) ?></td></tr>' +
                        '<tr><th class="bg-light">Luas</th><td><?= $h['luas_ha'] ?> Ha</td></tr>' +
                        '<tr><th class="bg-light">Nilai SAW</th><td><b><?= number_format($h['nilai'], 4) ?></b></td></tr>' +
                        '<tr><th class="bg-light">Ranking</th><td><span class="badge badge-dark"><?= $h['ranking'] ?></span></td></tr>' +
                        '<tr><th class="bg-light">Prioritas</th><td><span class="badge style-font text-white" style="background-color: <?= $warna ?>;"><?= $h['prioritas'] ?></span></td></tr>' +
                        '</table>' +
                        '<div class="text-center mt-2">' +
                            '<a href="<?= base_url('spk/detail/'.$h['id_lahan']) ?>" class="btn btn-xs btn-primary btn-block text-white" style="font-size:11px;"><i class="fas fa-search"></i> Lihat Detail Analisis</a>' +
                        '</div>' +
                    '</div>';

                    layer.bindPopup(popupHtml);
                }
            }).addTo(map);

            semuaPolygon['<?= $h['id_lahan']; ?>'] = polygon<?= $h['id_lahan']; ?>;
            semuaLayer.push(polygon<?= $h['id_lahan']; ?>);
        }
    } catch(err) {
        console.error("Gagal melakukan rendering koordinat GeoJSON pada ID Lahan <?= $h['id_lahan']; ?>:", err);
    }
<?php } ?>

// Auto-zoom otomatis awal saat halaman dimuat (Menggunakan Smooth Animation)
if(semuaLayer.length > 0){
    var group = L.featureGroup(semuaLayer);
    map.fitBounds(group.getBounds(), { 
        padding: [40, 40],
        animate: true,
        duration: 1.5
    });
}

// PERBAIKAN: Handler Dropdown Interaktif dengan Transisi Zoom In Halus (Smooth)
document.getElementById('pilihLahan').addEventListener('change', function() {
    var id = this.value;
    if(id && semuaPolygon[id]) {
        var layerTarget = semuaPolygon[id];
        
        // Menggunakan opsi animasi transisi Leaflet
        map.fitBounds(layerTarget.getBounds(), { 
            padding: [80, 80], // Mengurangi kedekatan zoom-in sedikit agar estetika visual poligon pas di tengah layar
            animate: true,
            duration: 1.2      // Kecepatan pergerakan kamera (1.2 detik)
        });

        // Menunda kemunculan popup sedikit agar sinkron setelah kamera selesai bergerak mulus
        setTimeout(function(){
            layerTarget.openPopup();
        }, 1200);
    }
});

// PERBAIKAN: Handler Tombol Reset dengan Transisi Zoom Out Halus (Smooth)
document.getElementById('resetMap').addEventListener('click', function() {
    document.getElementById('pilihLahan').value = "";
    map.closePopup();

    if(semuaLayer.length > 0){
        var group = L.featureGroup(semuaLayer);
        map.fitBounds(group.getBounds(), { 
            padding: [40, 40],
            animate: true,
            duration: 1.5 // Durasi zoom out kembali melihat seluruh area (1.5 detik)
        });
    }
});
</script>