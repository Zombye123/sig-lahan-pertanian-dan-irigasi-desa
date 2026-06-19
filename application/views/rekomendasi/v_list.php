<div class="content">
    <div class="container-fluid">

        <?php

        $total_lahan = count($hasil);

        $total_padi = 0;
        $total_jagung = 0;
        $total_cabai = 0;
        $total_kedelai = 0;
        $total_lainnya = 0;

        foreach($hasil as $h){

            $tanaman = strtolower($h->tanaman_terbaik);

            if($tanaman == 'padi'){
                $total_padi++;
            }
            elseif($tanaman == 'jagung'){
                $total_jagung++;
            }
            elseif($tanaman == 'cabai'){
                $total_cabai++;
            }
            elseif($tanaman == 'kedelai'){
                $total_kedelai++;
            }
            else{
                $total_lainnya++;
            }
        }

        ?>

        <div class="row">

            <div class="col-lg-2 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $total_lahan ?></h3>
                        <p>Total Lahan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-map"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $total_padi ?></h3>
                        <p>Padi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_jagung ?></h3>
                        <p>Jagung</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $total_cabai ?></h3>
                        <p>Cabai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-pepper-hot"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_kedelai ?></h3>
                        <p>Kedelai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-spa"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?= $total_lainnya ?></h3>
                        <p>Lainnya</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tree"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Hasil Rekomendasi Tanaman
                </h3>

                <div class="card-tools">

                    <a href="<?= base_url('rekomendasi/peta') ?>"
                       class="btn btn-success btn-sm">

                        <i class="fas fa-map-marked-alt"></i>
                        Lihat Peta

                    </a>

                </div>

            </div>

            <div class="card-body">

                <table id="tabelRekomendasi"
                       class="table table-bordered table-striped table-hover">

                    <thead>

                    <tr>

                        <th width="5%">No</th>
                        <th>Nama Lahan</th>
                        <th>Jenis Tanah</th>
                        <th>PH</th>
                        <th>Curah Hujan</th>
                        <th>Ketinggian</th>
                        <th>Tanaman Terbaik</th>
                        <th>Top 5 Rekomendasi</th>
                        <th>Alasan</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    foreach($hasil as $row){
                    ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>
                            <b><?= $row->nama_lahan ?></b>
                        </td>

                        <td>
                            <?= $row->jenis_tanah ?>
                        </td>

                        <td>
                            <?= $row->ph_tanah ?>
                        </td>

                        <td>
                            <?= number_format($row->curah_hujan,0) ?>
                        </td>

                        <td>
                            <?= number_format($row->ketinggian,0) ?> mdpl
                        </td>

                        <td>

                            <span class="badge badge-success p-2">

                                <?= $row->tanaman_terbaik ?>

                            </span>

                        </td>

                        <td>

                            <?php
                            if(!empty($row->rekomendasi)){

                                foreach($row->rekomendasi as $r){

                                    if($r['skor'] >= 90){

                                        $warna = 'success';

                                    }elseif($r['skor'] >= 70){

                                        $warna = 'primary';

                                    }elseif($r['skor'] >= 50){

                                        $warna = 'warning';

                                    }else{

                                        $warna = 'danger';
                                    }
                            ?>

                            <div style="margin-bottom:5px;">

                                <span class="badge badge-<?= $warna ?>">

                                    <?= $r['tanaman'] ?>

                                    (<?= $r['skor'] ?>)

                                </span>

                            </div>

                            <?php
                                }
                            }
                            ?>

                        </td>

                        <td>

                            <small>

                                <?= $row->alasan_rekomendasi ?>

                            </small>

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

<script>

$(function(){

    $('#tabelRekomendasi').DataTable({

        responsive:true,
        autoWidth:false,

        language:{

            search:"Cari Lahan : ",
            lengthMenu:"Tampilkan _MENU_ data",
            zeroRecords:"Data tidak ditemukan",
            info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate:{
                first:"Awal",
                last:"Akhir",
                next:"›",
                previous:"‹"
            }

        }

    });

});

</script>