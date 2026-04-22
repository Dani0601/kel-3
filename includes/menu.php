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

    case "proses_laporan":
        require_once "pages/proses_laporan.php";
    break;


/* ================= LAPORAN ================= */

case "laporan":

    if($role == "admin"){
        include "admin/laporan.php";
    }
    else if($role == "dosen"){
        require_once "pages/laporan.php";
    }
    else if($role == "mahasiswa"){
        require_once "pages/laporan.php";
    }
    else{
        echo "<div class='alert alert-danger'>Akses ditolak</div>";
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
case "notifikasi_user":

    if($role == "admin"){
        include "admin/notifikasi.php";
    }
    else if($role == "dosen"){
        require_once "pages/notifikasi_user.php";
    }
    else if($role == "mahasiswa"){
        require_once "pages/notifikasi_user.php";
    }
    else{
        echo "<div class='alert alert-danger'>Akses ditolak</div>";
    }

break;

case "tambah_jadwal":

    if($role == "admin"){
        include "admin/tambah_jadwal.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "edit_jadwal":

    if($role == "admin"){
        include "admin/edit_jadwal.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "tambah_ruangan":

    if($role == "admin"){
        include "admin/tambah_ruangan.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "edit_ruangan":

    if($role == "admin"){
        include "admin/edit_ruangan.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "tambah_pengumuman":

    if($role == "admin"){
        include "admin/tambah_pengumuman.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "edit_pengumuman":

    if($role == "admin"){
        include "admin/edit_pengumuman.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "tambah_gedung":

    if($role == "admin"){
        include "admin/tambah_gedung.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "edit_laporan":

    if($role == "admin"){
        include "admin/edit_laporan.php";
    } else {
        echo "<div class='text-red-500'>Akses ditolak</div>";
    }

break;

case "detail_laporan":

    if($role == "admin"){
        include "admin/detail_laporan.php";
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