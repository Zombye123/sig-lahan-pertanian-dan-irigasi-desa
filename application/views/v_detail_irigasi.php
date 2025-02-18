<div class="content">
	<div class="row">

		<div class="col-sm-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Irigasi</h3>
				</div>
				<div class="card-body">
					<div id="map" style="width: 100%; height: 400px;"></div>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Data Irigasi</h3>
				</div>
				<div class="card-body">
					<table class="table">
						<tr>
							<th width="150px">Nama Irigasi</th>
							<th width="50px">:</th>
							<td><?= $irigasi->nama_irigasi ?></td>
						</tr>
						<tr>
							<th>Panjang Jalur</th>
							<th>:</th>
							<td><?= $irigasi->panjang_jalur ?></td>
						</tr>
						<tr>
							<th>Lebar Jalur</th>
							<th>:</th>
							<td><?= $irigasi->lebar_jalur ?></td>
						</tr>
						<tr>
							<th>Gambar</th>
							<th>:</th>
							<td><img src="<?= base_url('gambar/' . $irigasi->gambar) ?>" width="100%"></td>
						</tr>

					</table>
				</div>
			</div>
		</div>




	</div>
</div>


<script>
	var grupirigasi = L.layerGroup();
	var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11'
	});


	var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/satellite-v9'
	});

	var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

	var map = L.map('map', {
		center: [-1.974050, 100.888755],
		zoom: 15,
		layers: [peta3, grupirigasi]
	});

	var baseLayers = {
		"Grayscale": peta1,
		"Satelite": peta2,
		"Streets": peta3
	};

	var overlays = {
		"Irigasi": grupirigasi,
	};

	L.control.layers(baseLayers, overlays).addTo(map);

	var irigasi = L.geoJSON(<?= $irigasi->jalur_geojson; ?>, {
		style: {
			color: "<?= $irigasi->warna ?>",
			weight: <?= $irigasi->ketebalan ?>,
		},
	}).addTo(grupirigasi);
	irigasi.eachLayer(function(layer) {
		layer.bindPopup("<p><img src='<?= base_url('gambar/' . $irigasi->gambar) ?>' width='280px'><br><br>" +
			"Nama Irigasi : <?= $irigasi->nama_irigasi ?></br>" +
			"Panjang Jalur : <?= $irigasi->panjang_jalur ?></br>" +
			"Lebar Jalur : <?= $irigasi->lebar_jalur ?></br>" +
			"<a href='<?= base_url('home/detail_irigasi/' . $irigasi->id_irigasi) ?>' class='btn btn-sm btn-default btn-block'>Detail</a>" +
			"</p>");
	});

	map.fitBounds(irigasi.getBounds());
</script>
