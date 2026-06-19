<div class="card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-trophy text-warning"></i> Hasil Ranking Prioritas SAW
        </h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr class="text-center">
                    <th style="width: 100px;">Peringkat</th>
                    <th class="text-left">Nama Lahan Pertanian</th>
                    <th>Pemilik Lahan</th>
                    <th>Nilai Preferensi</th>
                    <th>Status Kelayakan</th>
                    <th>Aksi</th> </tr>
            </thead>
            <tbody>
                <?php if(!empty($hasil)) { ?>
                    <?php foreach($hasil as $h) { ?>
                        <tr class="text-center">
                            <td>
                                <?php if($h['ranking'] == 1) { ?>
                                    <span class="badge badge-danger" style="font-size: 14px;"><i class="fas fa-medal text-warning"></i> Rank 1</span>
                                <?php } elseif($h['ranking'] == 2) { ?>
                                    <span class="badge badge-warning" style="font-size: 13px;">Rank 2</span>
                                <?php } elseif($h['ranking'] == 3) { ?>
                                    <span class="badge badge-info" style="font-size: 13px;">Rank 3</span>
                                <?php } else { ?>
                                    <span class="badge badge-secondary">Rank <?= $h['ranking'] ?></span>
                                <?php } ?>
                            </td>
                            <td class="text-left">
                                <b><?= htmlspecialchars($h['nama_lahan'], ENT_QUOTES, 'UTF-8') ?></b>
                            </td>
                            <td><?= htmlspecialchars($h['pemilik_lahan'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <strong class="text-primary"><?= number_format($h['nilai'], 5) ?></strong>
                            </td>
                            <td>
                                <?php if($h['prioritas'] == 'Sangat Layak') { ?>
                                    <span class="badge bg-danger px-3 py-2">Sangat Layak</span>
                                <?php } else { ?>
                                    <span class="badge bg-warning px-3 py-2 text-dark">Layak</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="<?= base_url('home/detail_lahan/' . $h['id_lahan']) ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-map-marked-alt"></i> Lihat di Peta
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center p-4 text-muted">Belum ada data hasil perhitungan SPK di database.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>