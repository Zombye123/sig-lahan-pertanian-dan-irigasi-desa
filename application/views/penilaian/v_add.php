<div class="container-fluid mt-4">
    <div class="mb-3">
        <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card card-primary shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-sync-alt"></i> Panel Generate Penilaian Otomatis SPK
            </h3>
        </div>

        <div class="card-body">
            <div class="alert alert-info border-left-info shadow-sm">
                <h5>
                    <i class="icon fas fa-info-circle"></i> Informasi Mekanisme Sistem
                </h5>
                <p class="mb-2">Nilai konversi parameter kriteria tidak diinput manual oleh operator atau admin.</p>
                <hr class="my-2" style="border-top: 1px solid rgba(255,255,255,0.3)">
                <p class="mb-2">Sistem secara otomatis mengalkulasi data spasial & tekstual dari tabel master berdasarkan indikator berikut:</p>
                <ul class="mb-2">
                    <li><strong>Luas Lahan</strong> (Diambil dari data hektar <code>tbl_lahan</code>)</li>
                    <li><strong>Produktivitas Panen</strong> (Diambil dari tren tahun terakhir <code>tbl_produksi</code>)</li>
                    <li><strong>Jarak Irigasi</strong> (Dihitung dari analisis spasial GIS <code>tbl_analisis_irigasi</code>)</li>
                    <li><strong>Kondisi Tanah (pH & Curah Hujan)</strong> (Diambil dari status terkini <code>tbl_kondisi_lahan</code>)</li>
                </ul>
                <p class="mb-0">Seluruh hasil konversi skala (1-5) akan disimpan secara massal ke dalam tabel: <span class="badge badge-dark">tbl_penilaian</span></p>
            </div>

            <h5 class="font-weight-bold mt-4 mb-3"><i class="fas fa-list"></i> Matriks Atribut Kriteria Aktif</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot Kriteria</th>
                            <th>Atribut Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        // Menggunakan $kriteria yang dipasok oleh fungsi $this->M_penilaian->get_kriteria() dari controller
                        if(!empty($kriteria)): 
                            foreach($kriteria as $k): 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><strong><?= $k->nama_kriteria ?></strong></td>
                                <td class="text-center"><?= $k->bobot ?></td>
                                <td class="text-center">
                                    <?php if(strtolower($k->atribut) == 'benefit'): ?>
                                        <span class="badge badge-success p-2 font-weight-bold">
                                            <i class="fas fa-trending-up"></i> Benefit
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger p-2 font-weight-bold">
                                            <i class="fas fa-trending-down"></i> Cost
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Data kriteria belum dikonfigurasi di database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="<?= base_url('penilaian') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            
            <a href="<?= base_url('penilaian/generate') ?>" 
               class="btn btn-success font-weight-bold shadow-sm"
               onclick="return confirm('PERINGATAN: Proses ini akan mengosongkan seluruh isi tabel tbl_penilaian lama dan mengisinya kembali dengan kalkulasi data terbaru. Lanjutkan?')">
                <i class="fas fa-cogs"></i> Mulai Proses Penilaian Otomatis
            </a>
        </div>
    </div>
</div>