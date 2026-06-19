<div class="content">
<div class="container-fluid">

<?php if($this->session->flashdata('success')){ ?>

<div class="alert alert-success alert-dismissible fade show">

    <?= $this->session->flashdata('success') ?>

    <button type="button"
            class="close"
            data-dismiss="alert">

        <span>&times;</span>

    </button>

</div>

<?php } ?>

<?php if($this->session->flashdata('error')){ ?>

<div class="alert alert-danger alert-dismissible fade show">

    <?= $this->session->flashdata('error') ?>

    <button type="button"
            class="close"
            data-dismiss="alert">

        <span>&times;</span>

    </button>

</div>

<?php } ?>

<div class="card card-primary">

    <div class="card-header">

        <h3 class="card-title">

            Data Kondisi Lahan

        </h3>

    </div>

    <div class="card-body">

        <a href="<?= base_url('kondisi/add') ?>"
           class="btn btn-primary mb-3">

            <i class="fas fa-plus"></i>
            Tambah Data

        </a>

        <div class="table-responsive">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="60">No</th>

                    <th>Nama Lahan</th>

                    <th>Pemilik</th>

                    <th>Jenis Tanah</th>

                    <th>PH</th>

                    <th>Sumber Air</th>

                    <th>Curah Hujan</th>

                    <th>Ketinggian</th>

                    <th width="150">Aksi</th>

                </tr>

            </thead>

            <tbody>

            <?php
            $no = 1;

            foreach($kondisi as $row){
            ?>

            <tr>

                <td><?= $no++ ?></td>

                <td><?= $row->nama_lahan ?></td>

                <td><?= $row->pemilik_lahan ?></td>

                <td><?= $row->jenis_tanah ?></td>

                <td><?= $row->ph_tanah ?></td>

                <td><?= $row->sumber_air ?></td>

                <td>

                    <?= !empty($row->curah_hujan)
                        ? number_format($row->curah_hujan).' mm/tahun'
                        : '-' ?>

                </td>

                <td>

                    <?= !empty($row->ketinggian)
                        ? number_format($row->ketinggian).' mdpl'
                        : '-' ?>

                </td>

                <td>
                    <a href="<?= base_url('kondisi/edit/'.$row->id_kondisi) ?>" 
                       class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>

<a href="<?= base_url('home/detail_lahan/'.$row->id_lahan) ?>" 
   class="btn btn-outline-primary btn-sm" 
   title="Detail Lahan">
    <i class="fas fa-map-marked-alt"></i> 
</a>

                    <a href="<?= base_url('kondisi/delete/'.$row->id_kondisi) ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Yakin hapus data ini ?')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>

            </tr>

            <?php } ?>

            </tbody>

        </table>

        </div>

    </div>

</div>

</div>
</div>