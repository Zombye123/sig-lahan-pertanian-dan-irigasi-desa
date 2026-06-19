<div class="card">

    <div class="card-header">

        <a href="<?= base_url('kriteria/add') ?>"
           class="btn btn-primary">

            <i class="fas fa-plus"></i>
            Tambah Kriteria

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>
                    <th width="50">No</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th width="180">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php
                $no=1;
                foreach($kriteria as $row){
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $row->nama_kriteria ?></td>

                    <td><?= $row->bobot ?></td>

                    <td>

                        <a href="<?= base_url('kriteria/edit/'.$row->id_kriteria) ?>"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <a href="<?= base_url('kriteria/delete/'.$row->id_kriteria) ?>"
                           onclick="return confirm('Yakin hapus data?')"
                           class="btn btn-danger btn-sm">

                            Hapus

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>