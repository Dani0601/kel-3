<?php
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

// ======================
// AMBIL DATA DOSEN
// ======================
$dosen = $conn->query("
    SELECT d.*, p.nama_prodi
    FROM dosen d
    LEFT JOIN prodi p ON d.id_prodi = p.id_prodi
    WHERE d.id_user = '$id_user'
")->fetch_assoc();

$id_dosen = $dosen['id_dosen'] ?? 0;

// ======================
// JADWAL DOSEN
// ======================
$jadwal = $conn->query("
    SELECT j.*, r.nama_ruangan
    FROM jadwal j
    LEFT JOIN ruangan r ON j.id_ruangan = r.id_ruangan
    WHERE j.id_dosen = '$id_dosen'
    ORDER BY j.hari, j.jam_mulai
    LIMIT 5
");

// ======================
// NOTIFIKASI
// ======================
$notif = $conn->query("
    SELECT COUNT(*) as total 
    FROM notifikasi_user 
    WHERE id_user='$id_user' AND status_dibaca=0
")->fetch_assoc();
?>

<div class="space-y-6">

<!-- HEADER -->
<h2 class="text-2xl font-bold mb-6 text-gray-800">
Dashboard Dosen 👋
</h2>

<!-- IDENTITAS (SAMAKAN DENGAN MAHASISWA) -->
<div class="bg-white p-6 rounded-2xl shadow">
    <p><b>Nama:</b> <?= $dosen['nama_dosen']; ?></p>
    <p>
        <b>Prodi:</b> 
        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg">
            🎓 <?= $dosen['nama_prodi']; ?>
        </span>
    </p>
</div>

<!-- JADWAL MENGAJAR -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-semibold mb-4">Jadwal Mengajar</h3>

<?php if($jadwal->num_rows > 0){ 
    while($j = $jadwal->fetch_assoc()){ ?>

<div class="border-b py-3 flex justify-between">

    <div>
        <p class="font-semibold">
            <?= $j['hari']; ?>
        </p>
        <p class="text-sm text-gray-500">
            <?= $j['jam_mulai']; ?> - <?= $j['jam_selesai']; ?>
        </p>
    </div>

    <div class="text-sm text-gray-600">
        <?= $j['nama_ruangan']; ?>
    </div>

</div>

<?php } } else { ?>

<p class="text-gray-500">Belum ada jadwal</p>

<?php } ?>

</div>