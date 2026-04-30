<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ========================
// AMBIL ID
// ========================
$id = $_GET['id'] ?? '';

if($id == ''){
    header("Location: index.php?menu=kelola_user&error=invalid");
    exit;
}

// ========================
// CEK DATA ADA / TIDAK
// ========================
$cek = mysqli_query($conn,"
    SELECT * FROM users WHERE id_user='$id'
");

if(mysqli_num_rows($cek) == 0){
    header("Location: index.php?menu=kelola_user&error=notfound");
    exit;
}

// ========================
// HAPUS DATA
// ========================
$sql = mysqli_query($conn,"
    DELETE FROM users WHERE id_user='$id'
");

if(!$sql){
    die("ERROR: " . mysqli_error($conn));
}

// ========================
// REDIRECT
// ========================
header("Location: index.php?menu=kelola_user&msg=hapus");
exit;