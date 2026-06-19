<div class="content">
    <div class="container-fluid">

        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marked-alt text-success"></i>
                    Peta Rekomendasi Komoditas Tanaman
                </h3>
                <div class="card-tools">
                    <a href="<?= base_url('rekomendasi') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-5">
                        <div class="form-group mb-0">
                            <label class="mb-1"><b>Pilih Lokasi Lahan :</b></label>
                            <select id="pilihLahan" class="form-control">
                                <option value="">-- Fokuskan ke Lahan Pertanian --</option>
                                <?php foreach($dataLahan as $item){ ?>
                                    <option value="<?= $item->id_lahan ?>">
                                        <?= htmlspecialchars($item->nama_lahan, ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($item->pemilik_lahan, ENT_QUOTES, 'UTF-8') ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <button id="resetView" class="btn btn-default btn-block">
                            <i class="fas fa-expand-arrows-alt"></i> Reset View
                        </button>
                    </div>
                </div>

                <div id="map" style="height: 650px; border: 1px solid #ccc; border-radius: 8px; z-index: 1;"></div>
            </div>
        </div>

        <div class="alert alert-dark border shadow-sm d-inline-block py-2 px-3">
            <i class="fas fa-layer-group text-success mr-1"></i> Total Lahan Terbaca: <b><?= isset($dataLahan) ? count($dataLahan) : 0 ?> Bidang</b>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // Layer jalan standart openstreetmap
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 22
    });

    // Layer citra satelit bumi esri
    var satelit = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri Real World Imagery',
        maxZoom: 22
    });

    // Deklarasi container peta utama
    var map = L.map('map', {
        center: [-6.92, 107.60],
        zoom: 12,
        layers: [satelit] // Default maps rendering menggunakan mode Satelit Esri
    });

    var groupLahan = L.featureGroup().addTo(map);
    
    // Parsing data array objek tanaman bentukan CI dari backend ke JavaScript json
    var dataLahan = <?= json_encode($dataLahan, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    var layerLahan = {};

    dataLahan.forEach(function(item){
        if(!item.denah_geojson) return;

        try {
            var geojsonObj = (typeof item.denah_geojson === 'string') ? JSON.parse(item.denah_geojson) : item.denah_geojson;
            var warnaAsli = item.warna || '#6f42c1';

            var layer = L.geoJSON(geojsonObj, {
                style: {
                    color: '#ffffff',
                    weight: 2,
                    fillColor: warnaAsli,
                    fillOpacity: 0.7,
                    warnaTanaman: warnaAsli // Menyimpan referensi property warna bawaan
                }
            }).addTo(groupLahan);

            // Template pop-up info detail kriteria kondisi tanah saat polygon diklik
           // Ganti potongan template popupContent Anda di bagian ini:
var popupContent = `
    <div style="min-width:250px; font-size:12px;">
        <h6 class="text-success border-bottom pb-1 mb-2"><b><i class="fas fa-seedling"></i> Lahan: ${item.nama_lahan}</b></h6>
        <table class="table table-bordered table-sm mb-2">
            <tr><th class="bg-light" width="45%">Pemilik</th><td>${item.pemilik_lahan || '-'}</td></tr>
            <tr><th class="bg-light">Luas Lahan</th><td>${item.luas_ha || item.luas_lahan || '-'} Ha</td></tr>
            <tr><th class="bg-light">pH Tanah</th><td>${item.ph_tanah || '-'} pH</td></tr>
            <tr><th class="bg-light">Jenis Tanah</th><td>${item.jenis_tanah || '-'}</td></tr>
            <tr><th class="bg-light">Komoditas Utama</th><td><span class="badge badge-success px-2 py-1">${item.tanaman_terbaik || item.tanaman || '-'}</span></td></tr>
        </table>
        <div class="text-muted small mb-2"><em>*${item.alasan_rekomendasi || ''}</em></div>
        <a href="<?= base_url('spk/detail/') ?>${item.id_lahan}" class="btn btn-xs btn-primary btn-block text-white">
            <i class="fas fa-search-plus"></i> Buka Detail Matriks Analisis
        </a>
    </div>
`;

            layer.bindPopup(popupContent);

            // Efek interaksi hover kursor mouse masuk daerah poligon
            layer.on('mouseover', function(){
                this.setStyle({
                    color: '#00ffff',
                    weight: 4,
                    fillOpacity: 0.85
                });
            });

            // Efek interaksi hover kursor mouse keluar meninggalkan daerah poligon
            layer.on('mouseout', function(){
                if (document.getElementById('pilihLahan').value != item.id_lahan) {
                    this.setStyle({
                        color: '#ffffff',
                        weight: 2,
                        fillOpacity: 0.7
                    });
                }
            });

            // Trigger dropdown sinkron ketika polygon di klik langsung di dalam peta
            layer.on('click', function(){
                document.getElementById('pilihLahan').value = item.id_lahan;
            });

            // Daftarkan ke list koleksi layer local storage
            layerLahan[item.id_lahan] = layer;

        } catch(err) {
            console.error('Gagal memproses parsing data GeoJSON pada Lahan ID: ' + item.id_lahan, err);
        }
    });

    // Auto fit boundary kamera agar langsung mengarah ke seluruh sebaran bidang tanah desa
    if(groupLahan.getLayers().length > 0){
        var bounds = groupLahan.getBounds();
        if(bounds.isValid()){
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 16 });
        }
    }

    // Navigasi kontrol layer maps pojok kanan atas
    L.control.layers({
        'Satelit Google Earth': satelit,
        'Peta Jalan (OSM)': osm
    }).addTo(map);

    // FIXED & SMOOTHING: Handler Event Dropdown Menggunakan flyToBounds
    document.getElementById('pilihLahan').addEventListener('change', function(){
        var id = this.value;

        // Reset semua style border polygon ke mode default putih tipis
        Object.keys(layerLahan).forEach(function(key){
            var baseColor = layerLahan[key].options.style.warnaTanaman;
            layerLahan[key].setStyle({
                color: '#ffffff',
                weight: 2,
                fillColor: baseColor,
                fillOpacity: 0.7
            });
        });

        var layerTerpilih = layerLahan[id];
        if(layerTerpilih){
            // Highlight bidang tanah terpilih dengan border cyan menyala
            layerTerpilih.setStyle({
                color: '#00ffff',
                weight: 5,
                fillOpacity: 0.9
            });

            // Efek perpindahan kamera halus (Smooth Transition Camera)
            map.flyToBounds(layerTerpilih.getBounds(), {
                padding: [50, 50],
                maxZoom: 18,
                duration: 1.5,   // Kecepatan durasi animasi transisi (detik)
                easeLinearity: 0.25
            });

            // Otomatis menembakkan/membuka balon informasi popup detail data
            setTimeout(function(){
                layerTerpilih.openPopup();
            }, 1200);
        }
    });

    // Tombol reset view kamera ke default awal seluruh batas desa
    document.getElementById('resetView').addEventListener('click', function(){
        document.getElementById('pilihLahan').value = "";
        
        Object.keys(layerLahan).forEach(function(key){
            var baseColor = layerLahan[key].options.style.warnaTanaman;
            layerLahan[key].setStyle({ color: '#ffffff', weight: 2, fillColor: baseColor, fillOpacity: 0.7 });
        });

        if(groupLahan.getLayers().length > 0){
            map.flyToBounds(groupLahan.getBounds(), { padding: [40, 40], duration: 1.2 });
        }
        map.closePopup();
    });

    // Fix peta patah jika dimuat di dalam tabs/card adminlte bootstrap
    setTimeout(function(){
        map.invalidateSize();
    }, 400);
});
</script>