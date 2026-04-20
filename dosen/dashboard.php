<?php
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

// ======================
// JADWAL DOSEN
// ======================
$jadwal = $conn->query("
    SELECT COUNT(*) as total 
    FROM jadwal 
    WHERE id_dosen = '$id_user'
")->fetch_assoc();

// ======================
// NOTIFIKASI
// ======================
$notif = $conn->query("
    SELECT COUNT(*) as total 
    FROM notifikasi_user 
    WHERE id_user='$id_user' AND status_dibaca=0
")->fetch_assoc();

// ======================
// LAPORAN DOSEN
// ======================
$laporan = $conn->query("
    SELECT 
        COUNT(*) as total,
        SUM(status='pending') as pending,
        SUM(status='diproses') as diproses,
        SUM(status='selesai') as selesai
    FROM laporan_fasilitas
    WHERE id_user = '$id_user'
")->fetch_assoc();
?>

<div class="space-y-6">

<!-- HEADER -->
<div>
    <h1 class="text-2xl font-bold text-gray-800">
        Dashboard Dosen 👨‍🏫
    </h1>
    <p class="text-gray-500">
        Selamat datang, <?= $_SESSION['username']; ?>
    </p>
</div>

<!-- CARD -->
<div class="grid md:grid-cols-4 gap-6">

    <!-- JADWAL -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-gray-500 text-sm">Total Jadwal</h3>
        <p class="text-3xl font-bold text-blue-600 mt-2">
            <?= $jadwal['total'] ?? 0 ?>
        </p>
    </div>

    <!-- NOTIF -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-gray-500 text-sm">Notifikasi Baru</h3>
        <p class="text-3xl font-bold text-red-500 mt-2">
            <?= $notif['total'] ?? 0 ?>
        </p>
    </div>

    <!-- LAPORAN -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-gray-500 text-sm">Total Laporan</h3>
        <p class="text-3xl font-bold text-purple-600 mt-2">
            <?= $laporan['total'] ?? 0 ?>
        </p>
    </div>

    <!-- STATUS -->
    <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
        <h3 class="text-gray-500 text-sm">Status</h3>
        <p class="text-lg font-semibold text-green-600 mt-2">
            Aktif
        </p>
    </div>

</div>

<!-- STATUS LAPORAN -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-semibold mb-4">Status Laporan Saya</h3>

<div class="grid md:grid-cols-3 gap-4 text-center">

    <div class="bg-yellow-100 p-4 rounded-lg">
        <p class="text-sm text-gray-600">Pending</p>
        <p class="text-xl font-bold text-yellow-600">
            <?= $laporan['pending'] ?? 0 ?>
        </p>
    </div>

    <div class="bg-blue-100 p-4 rounded-lg">
        <p class="text-sm text-gray-600">Diproses</p>
        <p class="text-xl font-bold text-blue-600">
            <?= $laporan['diproses'] ?? 0 ?>
        </p>
    </div>

    <div class="bg-green-100 p-4 rounded-lg">
        <p class="text-sm text-gray-600">Selesai</p>
        <p class="text-xl font-bold text-green-600">
            <?= $laporan['selesai'] ?? 0 ?>
        </p>
    </div>

</div>

</div>

<!-- JADWAL TERDEKAT -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-semibold mb-4">Jadwal Mengajar</h3>

<?php
$data = $conn->query("
    SELECT * FROM jadwal 
    WHERE id_dosen = '$id_user'
    ORDER BY hari ASC, jam_mulai ASC
    LIMIT 5
");

if($data->num_rows > 0){
    while($d = $data->fetch_assoc()){
?>

<div class="border-b py-3 flex justify-between">

    <div>
        <p class="font-semibold"><?= $d['mata_kuliah'] ?></p>
        <p class="text-sm text-gray-500">
            <?= $d['ruangan'] ?>
        </p>
    </div>

    <div class="text-sm text-gray-400">
        <?= $d['tanggal'] ?>
    </div>

</div>

<?php } } else { ?>

<p class="text-gray-500">Belum ada jadwal</p>

<?php } ?>

</div>

<!-- NOTIF TERBARU -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-semibold mb-4">Notifikasi Terbaru</h3>

<?php
$notif_data = $conn->query("
    SELECT n.* 
    FROM notifikasi_user nu
    JOIN notifikasi n ON nu.id_notifikasi = n.id_notifikasi
    WHERE nu.id_user = '$id_user'
    ORDER BY n.id_notifikasi DESC
    LIMIT 3
");

if($notif_data->num_rows > 0){
    while($n = $notif_data->fetch_assoc()){
?>

<div class="border-b py-3">

    <p class="font-semibold"><?= $n['judul'] ?></p>
    <p class="text-sm text-gray-500"><?= $n['pesan'] ?></p>

</div>

<?php } } else { ?>

<p class="text-gray-500">Tidak ada notifikasi</p>

<?php } ?>

</div>

</div>