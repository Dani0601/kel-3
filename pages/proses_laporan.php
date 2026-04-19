<?php
session_start();
include "../config/koneksi.php";

// validasi
if(!isset($_POST['id_user'])){
    header("Location: ../index.php?menu=laporan&error=1");
    exit;
}

$id_user     = $_POST['id_user'];
$id_ruangan  = $_POST['id_ruangan'];
$jenis       = $_POST['jenis'];
$deskripsi   = $_POST['deskripsi'];

// ======================
// PATH FOLDER (FIX)
// ======================
$folder = "../upload/laporan/";

// ======================
// UPLOAD FOTO
// ======================
$nama_file = $_FILES['foto']['name'];
$tmp       = $_FILES['foto']['tmp_name'];

$nama_baru = time() . "_" . $nama_file;

if(!move_uploaded_file($tmp, $folder . $nama_baru)){
    header("Location: ../index.php?menu=laporan&error=upload");
    exit;
}

// ======================
// INSERT DATABASE
// ======================
$insert = $conn->query("
INSERT INTO laporan_fasilitas 
(id_user, id_ruangan, judul, deskripsi, status, tanggal, foto, jenis)
VALUES 
('$id_user','$id_ruangan','$jenis','$deskripsi','pending',NOW(),'$nama_baru','$jenis')
");

if(!$insert){
    die("ERROR QUERY: " . $conn->error);
}

// ======================
// SUKSES
// ======================
header("Location: ../index.php?menu=laporan&success=1");
exit;