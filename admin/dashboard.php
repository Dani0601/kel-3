<?php

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

include __DIR__ . "/../config/koneksi.php";

/* BASE URL DINAMIS */
$base_url = '/' . explode('/', trim($_SERVER['REQUEST_URI'], '/'))[0] . '/';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f5f7fb;
}

/* SIDEBAR */
.sidebar {
    height: 100vh;
    background: white;
    box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    padding-top: 20px;
}

.sidebar h4 {
    color: #4a6cf7;
    font-weight: 600;
}

.sidebar a {
    color: #555;
    display: block;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 10px;
    margin: 5px 10px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #4a6cf7;
    color: white;
}

/* CONTENT */
.content {
    padding: 30px;
}

h3 {
    font-weight: 600;
}

/* CARD */
.card-stat {
    border: none;
    border-radius: 15px;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
}

.card-stat:hover {
    transform: translateY(-5px);
}

.card-stat h2 {
    color: #4a6cf7;
    font-weight: 600;
}

/* BUTTON */
.btn {
    border-radius: 10px;
}

/* TABLE */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    background: #4a6cf7 !important;
    color: white;
    border-radius: 10px 10px 0 0 !important;
}

/* FIX NAVBAR (hapus garis bawah) */
nav a {
    text-decoration: none !important;
}
</style>
</head>

<body>
<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-2 sidebar">
<h4 class="text-center">Smart Room</h4>
<hr>

<a href="dashboard.php">Dashboard</a>
<a href="kelola_jadwal.php">Manajemen Jadwal</a>
<a href="kelola_ruangan.php">Ruangan</a>
<a href="kelola_pengumuman.php">Pengumuman</a>
<a href="kelola_user.php">User</a>
<a href="laporan.php">Laporan</a>

<hr>

<!-- LOGOUT -->
<a href="auth/logout.php" class="text-danger"
   onclick="return confirm('Yakin ingin logout?')">
   Logout
</a>
</div>

<!-- CONTENT -->
<div class="col-md-10 content">
<h3>Dashboard Admin</h3>
<p class="text-muted">Selamat datang di sistem Smart Room Monitoring</p>

<?php
$ruanganResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM ruangan");
$jadwalResult  = mysqli_query($conn, "SELECT COUNT(*) as total FROM jadwal");
$usersResult   = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");

$ruangan = $ruanganResult ? mysqli_fetch_assoc($ruanganResult)['total'] : 0;
$jadwal  = $jadwalResult  ? mysqli_fetch_assoc($jadwalResult)['total']  : 0;
$users   = $usersResult   ? mysqli_fetch_assoc($usersResult)['total']   : 0;
?>

<!-- STATISTIK -->
<div class="row mt-4">
<div class="col-md-4">
<div class="card card-stat p-4 mb-3">
<h6>Total Ruangan</h6>
<h2><?= $ruangan ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card card-stat p-4 mb-3">
<h6>Total Jadwal</h6>
<h2><?= $jadwal ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card card-stat p-4 mb-3">
<h6>Total User</h6>
<h2><?= $users ?></h2>
</div>
</div>
</div>

<!-- QUICK ACTION -->
<div class="row mt-3">
<div class="col-md-3">
<a href="kelola_jadwal.php" class="btn btn-primary w-100 mb-3">+ Jadwal</a>
</div>
<div class="col-md-3">
<a href="kelola_ruangan.php" class="btn btn-success w-100 mb-3">+ Ruangan</a>
</div>
<div class="col-md-3">
<a href="kelola_user.php" class="btn btn-warning w-100 mb-3">+ User</a>
</div>
<div class="col-md-3">
<a href="kelola_pengumuman.php" class="btn btn-danger w-100 mb-3">+ Pengumuman</a>
</div>
</div>

<!-- AKTIVITAS -->
<div class="card shadow mt-4">
<div class="card-header">
Aktivitas Terbaru
</div>

<div class="card-body">
<table class="table table-hover">
<thead>
<tr>
<th>No</th>
<th>Kegiatan</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>
<tr>
<td>1</td>
<td>Admin menambahkan jadwal baru</td>
<td>2026-03-26</td>
</tr>

<tr>
<td>2</td>
<td>User login ke sistem</td>
<td>2026-03-26</td>
</tr>
</tbody>
</table>
</div>
</div>

</div>
</div>
</div>

</body>
</html>