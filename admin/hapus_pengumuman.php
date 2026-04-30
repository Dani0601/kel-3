<?php
include __DIR__ . '/../config/koneksi.php';

// AMBIL ID DENGAN AMAN
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// VALIDASI ID
if($id <= 0){
    header("Location: index.php?menu=kelola_pengumuman&error=notfound");
    exit;
}

// CEK DATA ADA ATAU TIDAK
$cek = mysqli_query($conn,"
    SELECT * FROM pengumuman WHERE id_pengumuman='$id'
");

if(mysqli_num_rows($cek) == 0){
    header("Location: index.php?menu=kelola_pengumuman&error=gagal");
    exit;
}

// HAPUS DATA
$hapus = mysqli_query($conn,"
    DELETE FROM pengumuman
    WHERE id_pengumuman='$id'
");

if(!$hapus){
    header("Location: ../index.php?menu=kelola_pengumuman&notif=error");
    exit;
}

// SUKSES
header("Location: ../index.php?menu=kelola_pengumuman&notif=hapus_sukses");
exit;