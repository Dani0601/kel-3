<?php
$menu = $_GET['menu'] ?? 'home';
$role = $_SESSION['role'] ?? '';

switch($menu){

/* ================= UMUM ================= */

case "home":
include "pages/home.php";
break;

case "jadwal":
include "pages/jadwal.php";
break;

case "info_ruangan":
include "pages/info_ruangan.php";
break;

case "status":
include "pages/status.php";
break;

case "pengumuman":
include "pages/pengumuman.php";
break;

case "panduan":
include "pages/panduan.php";
break;

case "kontak":
include "pages/kontak.php";
break;


/* ================= LAPORAN ================= */

case "laporan":

    if($role == "admin"){
        include "admin/laporan.php";
    }
    elseif($role == "dosen"){
        include "dosen/laporan.php";
    }
    elseif($role == "mahasiswa"){
        include "mahasiswa/laporan.php";
    }
    else{
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;


/* ================= ADMIN ================= */

case "dashboard_admin":

    if($role == "admin"){
        include "admin/dashboard.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "kelola_ruangan":

    if($role == "admin"){
        include "admin/kelola_ruangan.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "kelola_jadwal":

    if($role == "admin"){
        include "admin/kelola_jadwal.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "kelola_pengumuman":

    if($role == "admin"){
        include "admin/kelola_pengumuman.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "kelola_user":

    if($role == "admin"){
        include "admin/kelola_user.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "notifikasi":

    if($role == "admin"){
        include "admin/notifikasi.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;


/* ================= DOSEN ================= */

case "dashboard_dosen":

    if($role == "dosen"){
        include "dosen/dashboard.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;


/* ================= MAHASISWA ================= */

case "dashboard_mahasiswa":

    if($role == "mahasiswa"){
        include "mahasiswa/dashboard.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "tambah_laporan":

    if($role == "mahasiswa"){
        include "pages/tambah_laporan.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;


/* ================= DEFAULT ================= */

default:
include "pages/home.php";
break;

}
?>