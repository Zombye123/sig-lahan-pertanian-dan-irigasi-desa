<form id="bulk-delete-form" method="post" action="<?= base_url('irigasi/bulk_delete'); ?>">
    <table class="table table-bordered text-sm" id="example1">
        <thead class="text-center">
            <tr>
                <th>
                    <input type="checkbox" id="select-all">
                    <label for="select-all" class="ml-1">Pilih Semua</label>
                </th>
                <th>No</th>
                <th>Nama Irigasi</th>
                <th>Panjang Jalur</th>
                <th>Lebar Jalur</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($irigasi)) {
                $no = 1;
                foreach ($irigasi as $value) { ?>
                    <tr id="row-<?= $value->id_irigasi; ?>">
                        <td>
                            <input type="checkbox" name="id_irigasi[]" class="check-item" value="<?= $value->id_irigasi; ?>">
                        </td>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($value->nama_irigasi); ?></td>
                        <td><?= htmlspecialchars($value->panjang_jalur); ?> m</td>
                        <td><?= htmlspecialchars($value->lebar_jalur); ?> m</td>
                        <td class="text-center">
                            <a href="<?= base_url('home/detail_irigasi/' . $value->id_irigasi); ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= base_url('irigasi/edit/' . $value->id_irigasi); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data irigasi tersedia.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-danger mt-2 ml-2" id="delete-selected" style="display: none;">
        <i class="fas fa-trash"></i> 
    </button>
</form>

<script>
    $(document).ready(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });

        // Checkbox Pilih Semua
        $("#select-all").click(function () {
            $(".check-item").prop("checked", this.checked);
            toggleDeleteButton();
        });

        // Cek setiap perubahan pada checkbox
        $(".check-item").change(function () {
            if ($(".check-item:checked").length == $(".check-item").length) {
                $("#select-all").prop("checked", true);
            } else {
                $("#select-all").prop("checked", false);
            }
            toggleDeleteButton();
        });

        // Fungsi untuk menampilkan tombol delete jika ada yang dicentang
        function toggleDeleteButton() {
            if ($(".check-item:checked").length > 0) {
                $("#delete-selected").show();
            } else {
                $("#delete-selected").hide();
            }
        }

        // Hapus Data Satuan dengan AJAX
        $(".delete-btn").click(function (e) {
            e.preventDefault();
            let id = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: "<?= base_url('irigasi/delete/'); ?>" + id,
                    type: "POST",
                    success: function (response) {
                        $("#row-" + id).fadeOut(); // Hapus baris tabel tanpa reload
                        alert("Data berhasil dihapus!");
                    },
                    error: function () {
                        alert("Gagal menghapus data!");
                    }
                });
            }
        });

        // Hapus Banyak Data dengan AJAX
        $("#bulk-delete-form").submit(function (e) {
            e.preventDefault();

            let selected = $(".check-item:checked").map(function () {
                return $(this).val();
            }).get();

            if (selected.length === 0) {
                alert("Silakan pilih data yang ingin dihapus!");
                return;
            }

            if (confirm("Apakah Anda yakin ingin menghapus data yang dipilih?")) {
                $.ajax({
                    url: "<?= base_url('irigasi/bulk_delete'); ?>",
                    type: "POST",
                    data: { id_irigasi: selected },
                    success: function (response) {
                        selected.forEach(id => {
                            $("#row-" + id).fadeOut(); // Hapus baris tabel tanpa reload
                        });
                        alert("Data yang dipilih berhasil dihapus!");
                    },
                    error: function () {
                        alert("Gagal menghapus data!");
                    }
                });
            }
        });
    });
</script>
