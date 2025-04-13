<?php
// Deteksi apakah variabel $isi atau $content yang tersedia
if (isset($isi)) {
    // Jika $isi ada, muat view yang ada di dalam variabel $isi
    $this->load->view($isi);
} elseif (isset($content)) {
    // Jika $isi tidak ada, dan $content ada, muat view yang ada di dalam variabel $content
    $this->load->view($content);
} else {
    // Jika tidak ada dari keduanya yang diset, tampilkan pesan peringatan
    echo "<div class='alert alert-warning'>Tidak ada konten yang dimuat.</div>";
}
?>
