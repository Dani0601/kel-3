<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['id_user'])){
    die("SESSION USER TIDAK DITEMUKAN");
}

$id = $_POST['id_laporan'];
$id_user = $_SESSION['id_user'];

$id_ruangan = $_POST['id_ruangan'];
$jenis = $_POST['jenis'];
$deskripsi = $_POST['deskripsi'];

$foto = $_POST['foto_lama'];

// =======================
// CEK UPLOAD FOTO BARU
// =======================
if(isset($_FILES['foto']) && !empty($_FILES['foto']['name'])){

    $nama_file = time() . "_" . $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $upload_path = "../upload/laporan/" . $nama_file;

    if(move_uploaded_file($tmp, $upload_path)){
        $foto = $nama_file;
    } else {
        die("UPLOAD FOTO GAGAL");
    }
}

// =======================
// UPDATE DATABASE
// =======================
$sql = $conn->query("
UPDATE laporan_fasilitas SET
id_ruangan = '$id_ruangan',
jenis = '$jenis',
deskripsi = '$deskripsi',
foto = '$foto'
WHERE id_laporan = '$id' AND id_user = '$id_user'
");

// cek error query
if(!$sql){
    die("QUERY ERROR: " . $conn->error);
}

// cek apakah benar ke-update
if($conn->affected_rows == 0){
    die("DATA TIDAK TERUPDATE (cek id_laporan / id_user)");
}

// =======================
// REDIRECT
// =======================
header("Location: ../index.php?menu=riwayat_laporan&success=edit");
exit;