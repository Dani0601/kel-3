<?php
include "../config/koneksi.php";

$id = $_POST['id_laporan'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$status = $_POST['status'];

$conn->query("
UPDATE laporan_fasilitas 
SET judul='$judul',
    deskripsi='$deskripsi',
    status='$status'
WHERE id_laporan='$id'
");

header("Location: ../index.php?menu=kelola_laporan");
exit;
?>