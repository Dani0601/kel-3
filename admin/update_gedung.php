<?php
require_once __DIR__ . '/../config/koneksi.php';

session_start();

if($_SESSION['role'] != 'admin'){
    exit("Akses ditolak");
}

$id = $_POST['id'];
$nama = trim($_POST['nama']);

if(empty($nama)){
    exit("Nama kosong");
}

mysqli_query($conn,"
UPDATE gedung SET nama_gedung='$nama'
WHERE id_gedung='$id'
");

echo "Berhasil update";