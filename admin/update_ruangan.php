<?php
require_once __DIR__ . '/../config/koneksi.php';

$id = $_POST['id'];
$kapasitas = $_POST['kapasitas'];

mysqli_query($conn,"
UPDATE ruangan
SET kapasitas='$kapasitas'
WHERE id_ruangan='$id'
");

header("Location: ../index.php?menu=kelola_ruangan");