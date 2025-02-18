<div class="content">
	<div class="row">

		<div class="col-sm-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Lahan</h3>
				</div>
				<div class="card-body">
					<div id="map" style="width: 100%; height: 400px;"></div>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Data Lahan</h3>
				</div>
				<div class="card-body">
					<table class="table">
						<tr>
							<th width="150px">Nama Lahan</th>
							<th width="50px">:</th>
							<td><?= $lahan->nama_lahan ?></td>
						</tr>
						<tr>
							<th>Luas Lahan</th>
							<th>:</th>
							<td><?= $lahan->luas_lahan ?></td>
						</tr>
						<tr>
							<th>Isi Lahan</th>
							<th>:</th>
							<td><?= $lahan->isi_lahan ?></td>
						</tr>
						<tr>
							<th>Pemilik Lahan</th>
							<th>:</th>
							<td><?= $lahan->pemilik_lahan ?></td>
						</tr>
						<tr>
							<th>Alamat Pemilik </th>
							<th>:</th>
							<td><?= $lahan->alamat_pemilik ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Foto</h3>
				</div>
				<div class="card-body">

					<div class="row">
						<div class="col-sm-3">
							<a href="<?= base_url('gambar/' . $lahan->gambar) ?>" data-toggle="lightbox" data-title="<?= $lahan->nama_lahan ?>" data-gallery="gallery">
								<img src="<?= base_url('gambar/' . $lahan->gambar) ?>" class="img-fluid mb-2" alt="white sample" />
							</a>
						</div>

						<?php foreach ($foto as $key => $value) { ?>
							<div class="col-sm-3">
								<a href="<?= base_url('foto/' . $value->foto) ?>" data-toggle="lightbox" data-title="<?= $value->ket ?>" data-gallery="gallery">
									<img src="<?= base_url('foto/' . $value->foto) ?>" class="img-fluid mb-2" alt="white sample" />
								</a>

							</div>
						<?php } ?>
					</div>


				</div>
			</div>
		</div>



	</div>
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
		center: [-6.841019715671052, 107.14861675902371],
		zoom: 15,
		layers: [peta2, gruplahan, grupirigasi]
	});
	
	var baseLayers = {
		"Grayscale": peta1,
		"Satelite": peta2,
		"Streets": peta3
	};

	var overlays = {
		"Lahan": gruplahan,
	};

	L.control.layers(baseLayers, overlays).addTo(map);

	var lahan = L.geoJSON(<?= $lahan->denah_geojson; ?>, {
		style: {
			color: 'white',
			dashArray: '3',
			lineCap: 'butt',
			lineJoin: 'miter',
			fillColor: '<?= $lahan->warna ?>',
			fillOpacity: 1.0,
		},
	}).addTo(gruplahan);
	lahan.eachLayer(function(layer) {
		layer.bindPopup("<p><img src='<?= base_url('gambar/' . $lahan->gambar) ?>' width='280px'><br><br>" +
			"Nama Lahan : <?= $lahan->nama_lahan ?></br>" +
			"Luas Lahan : <?= $lahan->luas_lahan ?></br>" +
			"Pemilik Lahan : <?= $lahan->luas_lahan ?></br>" +
			"Alamat Pemilik : <?= $lahan->alamat_pemilik ?></br>" +
			"Isi Lahan : <?= $lahan->isi_lahan ?></br></br>" +
			"<a href='<?= base_url('home/detail_lahan/' . $lahan->id_lahan) ?>' class='btn btn-sm btn-default btn-block'>Detail</a>" +
			"</p>");
	});

	map.fitBounds(lahan.getBounds());
</script>

<!-- Page specific script -->
<script>
	$(function() {
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox({
				alwaysShowClose: true
			});
		});

		$('.filter-container').filterizr({
			gutterPixels: 3
		});
		$('.btn[data-filter]').on('click', function() {
			$('.btn[data-filter]').removeClass('active');
			$(this).addClass('active');
		});
	})
</script>
