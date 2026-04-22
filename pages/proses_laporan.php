<?php
ob_start();
session_start();
include "../config/koneksi.php";

// ======================
// VALIDASI SESSION
// ======================
if(!isset($_SESSION['id_user'])){
    die("❌ Kamu belum login");
}

$id_user = $_SESSION['id_user'];

// ======================
// VALIDASI INPUT
// ======================
if(
    empty($_POST['id_ruangan']) ||
    empty($_POST['jenis']) ||
    empty($_POST['deskripsi'])
){
    header("Location: ../index.php?menu=laporan&error=1");
    exit;
}

$id_ruangan  = $_POST['id_ruangan'];
$jenis       = $_POST['jenis'];
$deskripsi   = $_POST['deskripsi'];

// ======================
// UPLOAD FOTO
// ======================
$folder = "../upload/laporan/";

if(!is_dir($folder)){
    mkdir($folder, 0777, true);
}

$nama_baru = null;

if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){

    $nama_file = $_FILES['foto']['name'];
    $tmp       = $_FILES['foto']['tmp_name'];

    $nama_baru = time() . "_" . $nama_file;

    if(!move_uploaded_file($tmp, $folder . $nama_baru)){
        die("❌ Gagal upload foto");
    }
}

// ======================
// INSERT DATABASE
// ======================
$query = "
INSERT INTO laporan_fasilitas 
(id_user, id_ruangan, judul, deskripsi, status, tanggal, foto, jenis)
VALUES 
('$id_user','$id_ruangan','$jenis','$deskripsi','pending',NOW(),'$nama_baru','$jenis')
";

$insert = $conn->query($query);

if(!$insert){
    die("❌ ERROR QUERY: " . $conn->error);
}

// ======================
// REDIRECT
// ======================
header("Location: ../index.php?menu=laporan&success=1");
exit;

ob_end_flush();