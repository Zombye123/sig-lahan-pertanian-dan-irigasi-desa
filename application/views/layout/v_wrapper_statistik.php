<?php
// Wrapper khusus untuk halaman Statistik

// Memuat bagian-bagian umum seperti head, header, navigation, dan footer
require_once('v_head.php');
require_once('v_header.php');
require_once('v_nav.php');

// Menampilkan isi halaman Statistik yang dimuat dari controller
echo $isi;  // This will display the content passed from the controller (statistik/index.php)

require_once('v_footer.php');
?>
