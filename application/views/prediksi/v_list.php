<div class="content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title m-0"><i class="fas fa-chart-pie mr-1"></i> Data Rekomendasi</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 20px;"></th> 
                                <th>Lahan</th>
                                <th>Tanaman</th>
                                <th>Akurasi</th>
                                <th class="text-right">Estimasi (Ton)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($prediksi)): foreach($prediksi as $row): 
                                $skor = $row['nilai_kesesuaian'];
                                $bar = ($skor == 100) ? 'bg-success' : (($skor >= 75) ? 'bg-info' : 'bg-warning');
                            ?>
                            <tr data-widget="expandable-table" aria-expanded="false" style="cursor: pointer;">
                                <td><i class="fas fa-caret-right fa-fw"></i></td>
                                <td><strong><?= $row['nama_lahan'] ?></strong></td>
                                <td><strong><?= ucfirst($row['tanaman']) ?></strong></td>
                                <td>
                                    <div class="progress progress-xs" style="height: 6px;"><div class="progress-bar <?= $bar ?>" style="width: <?= $skor ?>%;"></div></div>
                                    <small><?= $skor ?>%</small>
                                </td>
                                <td class="text-right font-weight-bold text-success"><?= number_format($row['estimasi_panen'], 2) ?> Ton</td>
                            </tr>
                            
                            <tr class="expandable-body d-none">
                                <td colspan="5">
                                    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-bold"><i class="fas fa-info-circle mr-1"></i> Analisis Perhitungan:</h6>
                                            <p class="text-sm mb-1">
                                                Skor <strong><?= $skor ?>%</strong> dihitung berdasarkan 4 parameter (Tanah, pH, Curah Hujan, Ketinggian).
                                            </p>
                                            <ul class="text-sm mb-0">
                                                <li>Status Kecocokan: <b><?= $row['status'] ?></b></li>
                                            </ul>
                                        </div>
                                        <a href="<?= base_url('home/detail_lahan/' . $row['id_lahan']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-map-marked-alt mr-1"></i> Lihat di Peta
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const expandableRows = document.querySelectorAll('[data-widget="expandable-table"]');
    
    expandableRows.forEach(row => {
        row.addEventListener('click', function() {
            const detailRow = this.nextElementSibling;
            const icon = this.querySelector('i.fas');
            
            if (detailRow && detailRow.classList.contains('expandable-body')) {
                detailRow.classList.toggle('d-none');
                
                if (detailRow.classList.contains('d-none')) {
                    icon.classList.replace('fa-caret-down', 'fa-caret-right');
                } else {
                    icon.classList.replace('fa-caret-right', 'fa-caret-down');
                }
            }
        });
    });
});
</script>