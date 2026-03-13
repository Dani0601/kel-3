<?php
$role = $_SESSION['role'] ?? "";
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
<div class="container">

<a class="navbar-brand" href="index.php">Smart Room</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav ms-auto">

<!-- BERANDA -->
<li class="nav-item">
<a class="nav-link" href="index.php">Beranda</a>
</li>


<!-- MANAJEMEN JADWAL -->
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
Manajemen Jadwal
</a>

<ul class="dropdown-menu">

<li>
<a class="dropdown-item" href="index.php?menu=jadwal">
Jadwal
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=status">
Status Ruangan
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=info_ruangan">
Info Ruangan
</a>
</li>

</ul>
</li>


<!-- INFORMASI -->
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
Informasi
</a>

<ul class="dropdown-menu">

<li>
<a class="dropdown-item" href="index.php?menu=pengumuman">
Pengumuman
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=panduan">
Panduan
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=kontak">
Kontak
</a>
</li>

</ul>
</li>


<!-- LAPORAN -->
<li class="nav-item">
<a class="nav-link" href="index.php?menu=laporan">
Laporan Fasilitas
</a>
</li>


<!-- ================= ADMIN ================= -->

<?php if($role == "admin"){ ?>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
Kelola Data
</a>

<ul class="dropdown-menu">

<li>
<a class="dropdown-item" href="index.php?menu=kelola_ruangan">
Kelola Ruangan
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=kelola_jadwal">
Kelola Jadwal
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=kelola_pengumuman">
Kelola Pengumuman
</a>
</li>

<li>
<a class="dropdown-item" href="index.php?menu=kelola_user">
Kelola User
</a>
</li>

</ul>
</li>

<?php } ?>


<!-- ================= DASHBOARD ROLE ================= -->

<?php if($role == "admin"){ ?>

<li class="nav-item">
<a class="nav-link" href="index.php?menu=dashboard_admin">
Dashboard
</a>
</li>

<?php } ?>


<?php if($role == "dosen"){ ?>

<li class="nav-item">
<a class="nav-link" href="index.php?menu=dashboard_dosen">
Dashboard Dosen
</a>
</li>

<?php } ?>


<?php if($role == "mahasiswa"){ ?>

<li class="nav-item">
<a class="nav-link" href="index.php?menu=dashboard_mahasiswa">
Dashboard Mahasiswa
</a>
</li>

<?php } ?>


<!-- ================= USER ================= -->

<?php if(isset($_SESSION['login'])){ ?>

<li class="nav-item dropdown">

<a class="nav-link dropdown-toggle text-warning" href="#" data-bs-toggle="dropdown">

<?php echo $_SESSION['username']; ?>

</a>

<ul class="dropdown-menu dropdown-menu-end">

<li>
<a class="nav-link text-danger" href="auth/logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</li>

</ul>

</li>

<?php } ?>

</ul>

</div>
</div>
</nav>