<?php
include __DIR__ . '/../config/koneksi.php';

$id = $_GET['id'] ?? null;

if(!$id){
    die("ID tidak valid");
}

mysqli_query($conn,"DELETE FROM jadwal WHERE id_jadwal='$id'");

echo "<script>
alert('Berhasil dihapus');
window.location.href='../index.php?menu=kelola_jadwal';
</script>";
?>