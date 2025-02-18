<div class="content">
	<div id="map" style="width: 100%; height: 600px;"></div>
</div>


<script>
	var gruplahan = L.layerGroup();
	var grupirigasi = L.layerGroup();

	var peta1 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://carto.com/attributions">CARTO</a>'
    });

	var peta2   =L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});


	var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

	var map = L.map('map', {
		center: [-6.805727985345288, 107.14074420601693],
		zoom: 30,
		layers: [peta2, gruplahan, grupirigasi]
	});

	var baseLayers = {
		"Grayscale": peta1,
		"Satelite": peta2,
		"Streets": peta3
	};

	var overlays = {
		"Lahan": gruplahan,
		"Irigasi": grupirigasi,
	};

	L.control.layers(baseLayers, overlays).addTo(map);

	<?php foreach ($lahan as $key => $value) { ?>
		var lahan = L.geoJSON(<?= $value->denah_geojson; ?>, {
			style: {
				color: 'white',
				dashArray: '3',
				lineCap: 'butt',
				lineJoin: 'miter',
				fillColor: '<?= $value->warna ?>',
				fillOpacity: 1.0,
			},
		}).addTo(gruplahan);
		lahan.eachLayer(function(layer) {
			layer.bindPopup("<p><img src='<?= base_url('gambar/' . $value->gambar) ?>' width='280px'><br><br>" +
				"Nama Lahan : <?= $value->nama_lahan ?></br>" +
				"Luas Lahan : <?= $value->luas_lahan ?></br>" +
				"Pemilik Lahan : <?= $value->luas_lahan ?></br>" +
				"Alamat Pemilik : <?= $value->alamat_pemilik ?></br>" +
				"Isi Lahan : <?= $value->isi_lahan ?></br></br>" +
				"<a href='<?= base_url('home/detail_lahan/' . $value->id_lahan) ?>' class='btn btn-sm btn-default btn-block'>Detail</a>" +
				"</p>");
		});
	<?php } ?>

	<?php foreach ($irigasi as $key => $value) { ?>
		var irigasi = L.geoJSON(<?= $value->jalur_geojson; ?>, {
			style: {
				color: "<?= $value->warna ?>",
				weight: <?= $value->ketebalan ?>,
			},
		}).addTo(grupirigasi);
		irigasi.eachLayer(function(layer) {
			layer.bindPopup("<p><img src='<?= base_url('gambar/' . $value->gambar) ?>' width='280px'><br><br>" +
				"Nama Irigasi : <?= $value->nama_irigasi ?></br>" +
				"Panjang Jalur : <?= $value->panjang_jalur ?></br>" +
				"Lebar Jalur : <?= $value->lebar_jalur ?></br>" +
				"<a href='<?= base_url('home/detail_irigasi/' . $value->id_irigasi) ?>' class='btn btn-sm btn-default btn-block'>Detail</a>" +
				"</p>");
		});
	<?php } ?>
</script>
