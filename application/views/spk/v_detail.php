<div class="content">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <?php if(!empty($detail['gambar'])){ ?>
                                <img class="img-fluid rounded" src="<?= base_url('gambar/'.$detail['gambar']) ?>" alt="Foto Lahan" style="max-height: 200px; width: 100%; object-fit: cover;">
                            <?php } else { ?>
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php } ?>
                        </div>

                        <h3 class="profile-username text-center"><?= htmlspecialchars($detail['nama_lahan'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
                        <p class="text-muted text-center"><i class="fas fa-user"></i> Pemilik: <?= htmlspecialchars($detail['pemilik_lahan'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Luas Lahan</b> <a class="float-right"><?= !empty($detail['luas_ha']) ? $detail['luas_ha'] : ($detail['luas_lahan'] ?? '-') ?> Ha</a>
                            </li>
                            <li class="list-group-item">
                                <b>Nilai Akhir SAW</b> <a class="float-right text-primary"><b><?= isset($detail['nilai']) ? number_format($detail['nilai'], 4) : '0.0000' ?></b></a>
                            </li>
                            <li class="list-group-item">
                                <b>Peringkat (Rank)</b> <a class="float-right"><span class="badge badge-dark">#<?= $detail['ranking'] ?? '-' ?></span></a>
                            </li>
                            <li class="list-group-item">
                                <b>Status Prioritas</b> 
                                <a class="float-right">
                                    <?php
                                    $badge = 'badge-success';
                                    $prioritas = $detail['prioritas'] ?? '-';
                                    if($prioritas == 'Sangat Tinggi') $badge = 'badge-danger';
                                    elseif($prioritas == 'Tinggi') $badge = 'badge-warning';
                                    elseif($prioritas == 'Sedang') $badge = 'badge-info';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= $prioritas ?></span>
                                </a>
                            </li>
                        </ul>

                        <a href="<?= base_url('spk/peta') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-map-marked-alt"></i> <b>Lihat di Peta</b>
                        </a>
                        <a href="<?= base_url('spk') ?>" class="btn btn-default btn-block">
                            <i class="fas fa-list-ol"></i> Daftar Rangking Lahan
                        </a>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Kondisi Fisik Lahan</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td style="width: 40%; padding-left: 15px;"><b>Jenis Tanah</b></td>
                                    <td><?= !empty($detail['jenis_tanah']) ? $detail['jenis_tanah'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 15px;"><b>pH Tanah</b></td>
                                    <td><?= !empty($detail['ph_tanah']) ? $detail['ph_tanah'] : '-' ?> pH</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 15px;"><b>Curah Hujan</b></td>
                                    <td><?= !empty($detail['curah_hujan']) ? $detail['curah_hujan'] : '-' ?> mm/th</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 15px;"><b>Ketinggian</b></td>
                                    <td><?= !empty($detail['ketinggian']) ? $detail['ketinggian'] : '-' ?> mdpl</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calculator text-success"></i> 
                            Rincian Pembobotan & Normalisasi Simple Additive Weighting (SAW)
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th>Nama Kriteria</th>
                                        <th class="text-center">Nilai Asli</th>
                                        <th class="text-center">Normalisasi (R)</th>
                                        <th class="text-center">Bobot (W)</th>
                                        <th class="text-center">Subtotal (R × W)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    // Pengecekan multidimensi array kriteria hitung
                                    if(!empty($detail['detail']) && is_array($detail['detail'])){
                                        foreach($detail['detail'] as $kriteria){ 
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td>
                                                    <?= htmlspecialchars($kriteria['nama_kriteria'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                    <br><small class="text-muted">Field: <?= $kriteria['field'] ?? '-' ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-light px-2 py-1"><?= $kriteria['nilai'] ?? '0' ?></span>
                                                </td>
                                                <td class="text-center text-primary font-weight-bold">
                                                    <?= number_format($kriteria['normalisasi'] ?? 0, 4) ?>
                                                </td>
                                                <td class="text-center text-muted">
                                                    <?= number_format($kriteria['bobot'] ?? 0, 2) ?>
                                                </td>
                                                <td class="text-center font-weight-bold text-success">
                                                    <?= number_format($kriteria['subtotal'] ?? 0, 4) ?>
                                                </td>
                                            </tr>
                                    <?php 
                                        }
                                    } else { 
                                    ?>
                                        <tr>
                                            <td colspan="6" class="text-center p-3 text-muted">Data kriteria hitung kosong atau belum diproses.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="bg-light font-weight-bold">
                                    <tr>
                                        <td colspan="5" class="text-right">Total Nilai Preferensi (V):</td>
                                        <td class="text-center text-xl text-primary" style="font-size: 1.2rem;">
                                            <?= isset($detail['nilai']) ? number_format($detail['nilai'], 4) : '0.0000' ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border border-info fade show" role="alert">
                    <h5><i class="icon fas fa-info"></i> Catatan Rumus Analisis SPK</h5>
                    <p class="mb-0" style="font-size: 14px;">
                        Nilai preferensi akhir didapatkan dari rumus akumulasi penjumlahan perkalian matriks ternormalisasi ($R$) dengan bobot preferensi ($W$) masing-masing kriteria: 
                        <br>
                        <strong>$V_i = \sum (R_{ij} \times W_j)$</strong>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>