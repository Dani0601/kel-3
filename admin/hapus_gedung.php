<?php
require_once __DIR__ . '/../config/koneksi.php';

session_start();

if($_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM ruangan WHERE id_gedung='$id'");
mysqli_query($conn,"DELETE FROM gedung WHERE id_gedung='$id'");

header("Location: ../index.php?menu=kelola_ruangan");