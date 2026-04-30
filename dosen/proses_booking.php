<?php
session_start();
include "../config/koneksi.php";

$id_user = $_SESSION['id_user'] ?? 0;

// ======================
// AMBIL DOSEN (FIX FK)
// ======================
$q = $conn->query("SELECT * FROM dosen WHERE id_user='$id_user'");
$dosen = $q->fetch_assoc();

if(!$dosen){
    header("Location: index.php?menu=booking&error=dosen");
    exit;
}

$id_dosen = $dosen['id_dosen'];

// ======================
$id_ruangan  = $_POST['id_ruangan'];
$hari        = $_POST['hari'];
$jam_mulai   = $_POST['jam_mulai'];
$id_mk       = $_POST['id_mk'];
$ket         = $_POST['keterangan'];
$tanggal_booking = date('Y-m-d');

// ======================
// AMBIL SKS
// ======================
$get = $conn->query("SELECT sks FROM mata_kuliah WHERE id_mk='$id_mk'");
$d = $get->fetch_assoc();

$durasi = $d['sks'] * 50;

// ======================
// HITUNG JAM SELESAI
// ======================
$mulai = new DateTime($jam_mulai);
$mulai->modify("+$durasi minutes");
$jam_selesai = $mulai->format("H:i");

// ======================
// VALIDASI JAM
// ======================
if($jam_selesai > "18:00"){
    header("Location: index.php?menu=booking&error=jam");
    exit;
}

// ======================
// AMBIL TAHUN AJAR AKTIF
// ======================
$ta = $conn->query("SELECT * FROM tahun_ajaran WHERE aktif=1")->fetch_assoc();

if(!$ta){
    header("Location: index.php?menu=booking&error=tahun");
    exit;
}

$id_ta = $ta['id_tahun_ajar'];

// ======================
// CEK BENTROK
// ======================
$cek = $conn->query("
SELECT 1 FROM booking_ruangan
WHERE id_ruangan='$id_ruangan'
AND tanggal_booking='$tanggal_booking'
AND NOT (
    jam_selesai <= '$jam_mulai' 
    OR jam_mulai >= '$jam_selesai'
)

UNION

SELECT 1 FROM jadwal
WHERE id_ruangan='$id_ruangan'
AND hari='$hari'
AND NOT (
    jam_selesai <= '$jam_mulai' 
    OR jam_mulai >= '$jam_selesai'
)
");

if($cek->num_rows > 0){
    header("Location: index.php?menu=booking&error=bentrok");
    exit;
}

// ======================
// AMBIL TAHUN AJAR AKTIF
// ======================
$ta = $conn->query("SELECT * FROM tahun_ajaran WHERE aktif=1")->fetch_assoc();

if(!$ta){
    header("Location: ".$_SERVER['HTTP_REFERER']."&notif=error_tahun");
    exit;
}

$id_ta = $ta['id_tahun_ajar'];

// ======================
// INSERT
// ======================
$conn->query("
INSERT INTO booking_ruangan
(id_dosen, id_ruangan, hari, tanggal_booking, jam_mulai, jam_selesai, keterangan)
VALUES
('$id_dosen','$id_ruangan','$hari','$jam_mulai','$jam_selesai','$ket', '$tanggal_booking')
");

// ======================
// BUAT NOTIFIKASI
// ======================
$judul = "Ruangan Dibooking";
$pesan = "Ruangan telah dibooking oleh dosen pada hari $hari jam $jam_mulai - $jam_selesai";

// simpan notifikasi utama
$conn->query("
INSERT INTO notifikasi (judul, pesan, created_at)
VALUES ('$judul','$pesan',NOW())
");

$id_notif = $conn->insert_id;

// kirim ke semua user
$users = $conn->query("SELECT id_user FROM users");

while($u = $users->fetch_assoc()){
    $conn->query("
    INSERT INTO notifikasi_user (id_notifikasi, id_user)
    VALUES ('$id_notif','".$u['id_user']."')
    ");
}

// ======================
header("Location: ../index.php?menu=booking_ruangan&success=1");