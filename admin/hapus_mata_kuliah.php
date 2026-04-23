<?php
include __DIR__ . '/../config/koneksi.php';

$id = $_GET['id'];

/* HAPUS RELASI DULU */
mysqli_query($conn,"
    DELETE FROM mk_prodi WHERE id_mk='$id'
");

/* HAPUS MK */
mysqli_query($conn,"
    DELETE FROM mata_kuliah WHERE id_mk='$id'
");

echo "<script>alert('Data berhasil dihapus');location='index.php?menu=kelola_mata_kuliah';</script>";