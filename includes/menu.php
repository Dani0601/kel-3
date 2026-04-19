<?php

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit();
}

$menu = $_GET['menu'] ?? "";
$role = $_SESSION['role'] ?? "";


/* ===== MENU UMUM ===== */

switch($menu){

    case "info_ruangan":
        require_once "pages/info_ruangan.php";
    break;

    case "jadwal":
        require_once "pages/jadwal.php";
    break;

    case "status":
        require_once "pages/status.php";
    break;

    case "pengumuman":
        require_once "pages/pengumuman.php";
    break;

    case "panduan":
        require_once "pages/panduan.php";
    break;

    case "kontak":
        require_once "pages/kontak.php";
    break;

    case "detail_notif":
        require_once "pages/detail_notif.php";
    break;

    case 'notifikasi_user':
        include "pages/notifikasi_user.php";
    break;

    case "tambah_laporan":
        require_once "pages/tambah_laporan.php";
    break;


    /* ===== LAPORAN ===== */

    case "laporan":

        if($role == "admin"){
            require_once "admin/laporan.php";
        }

        else if($role == "dosen"){
            require_once "dosen/laporan.php";
        }

        else if($role == "mahasiswa"){
            require_once "mahasiswa/laporan.php";
        }

        else{
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    /* ===== ADMIN ===== */

    case "dashboard_admin":

        if($role == "admin"){
            require_once "admin/dashboard.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    case "kelola_ruangan":

        if($role == "admin"){
            require_once "admin/kelola_ruangan.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    case "kelola_jadwal":

        if($role == "admin"){
            require_once "admin/kelola_jadwal.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    case "kelola_pengumuman":

        if($role == "admin"){
            require_once "admin/kelola_pengumuman.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    case "kelola_user":

        if($role == "admin"){
            require_once "admin/kelola_user.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;

    case "notifikasi":

        if($role == "admin"){
            require_once "admin/notifikasi.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    /* ===== DOSEN ===== */

    case "dashboard_dosen":

        if($role == "dosen"){
            require_once "dosen/dashboard.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    /* ===== MAHASISWA ===== */

    case "dashboard_mahasiswa":

        if($role == "mahasiswa"){
            require_once "mahasiswa/dashboard.php";
        } else {
            echo "<div class='alert alert-danger'>Akses ditolak</div>";
        }

    break;


    /* ===== DEFAULT ===== */

    default:
        require_once "pages/home.php";
    break;

}

?>