<?php
include "../config/koneksi.php";

$id = $_GET['id'];

$conn->query("DELETE FROM laporan_fasilitas WHERE id_laporan='$id'");

header("Location: ../index.php?menu=kelola_laporan");