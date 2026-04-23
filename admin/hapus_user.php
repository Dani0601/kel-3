<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ========================
// AMBIL ID
// ========================
$id = $_GET['id'] ?? '';

if($id == ''){
    echo "<script>alert('ID tidak valid');history.back();</script>";
    exit;
}

// ========================
// CEK DATA ADA / TIDAK
// ========================
$cek = mysqli_query($conn,"
    SELECT * FROM users WHERE id_user='$id'
");

if(mysqli_num_rows($cek) == 0){
    echo "<script>alert('Data tidak ditemukan');history.back();</script>";
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
echo "<script>
alert('User berhasil dihapus');
location='index.php?menu=kelola_user';
</script>";
?>