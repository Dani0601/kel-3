<?php
include __DIR__ . '/../config/koneksi.php';

# ========================
# TOTAL DATA
# ========================
$ruangan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM ruangan"))['t'];
$jadwal  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM jadwal"))['t'];
$user    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM users"))['t'];

# ========================
# CHART 1: PER HARI (FIX URUTAN)
# ========================
$q1 = mysqli_query($conn,"
SELECT hari, COUNT(*) as total 
FROM jadwal 
GROUP BY hari
ORDER BY FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
");

$hari = [];
$total_hari = [];

while ($d = mysqli_fetch_assoc($q1)) {
    $hari[] = $d['hari'];
    $total_hari[] = $d['total'];
}

# ========================
# CHART 2: PER RUANGAN
# ========================
$q2 = mysqli_query($conn,"
SELECT r.nama_ruangan, COUNT(*) as total
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
GROUP BY j.id_ruangan
");

$ruang = [];
$total_ruang = [];

while ($d = mysqli_fetch_assoc($q2)) {
    $ruang[] = $d['nama_ruangan'];
    $total_ruang[] = $d['total'];
}

# ========================
# CHART 3: JAM SIBUK
# ========================
$q3 = mysqli_query($conn,"
SELECT jam_mulai, COUNT(*) as total 
FROM jadwal 
GROUP BY jam_mulai
ORDER BY jam_mulai
");

$jam = [];
$total_jam = [];

while ($d = mysqli_fetch_assoc($q3)) {
    $jam[] = $d['jam_mulai'];
    $total_jam[] = $d['total'];
}

# ========================
# CHART 4: TOP RUANGAN
# ========================
$q4 = mysqli_query($conn,"
SELECT r.nama_ruangan, COUNT(*) as total
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
GROUP BY j.id_ruangan
ORDER BY total DESC
LIMIT 5
");

$top_ruang = [];
$total_top = [];

while ($d = mysqli_fetch_assoc($q4)) {
    $top_ruang[] = $d['nama_ruangan'];
    $total_top[] = $d['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100">

<div class="p-6">

<!-- HEADER -->
<div class="mb-6">
<h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
<p class="text-sm text-gray-500">Statistik penggunaan ruangan dan aktivitas sistem secara keseluruhan</p>
</div>

<!-- CARD -->
<div class="grid md:grid-cols-3 gap-6">

<div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-5 rounded-xl shadow-lg">
    <p>Total Ruangan</p>
    <h2 class="text-3xl font-bold"><?= $ruangan ?></h2>
</div>

<div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-5 rounded-xl shadow-lg">
    <p>Total Jadwal</p>
    <h2 class="text-3xl font-bold"><?= $jadwal ?></h2>
</div>

<div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-5 rounded-xl shadow-lg">
    <p>Total User</p>
    <h2 class="text-3xl font-bold"><?= $user ?></h2>
</div>

</div>

<!-- CHART -->
<div class="grid md:grid-cols-2 gap-6 mt-8">

<!-- PER HARI -->
<div class="bg-white p-5 rounded-xl shadow">
<h4 class="font-semibold mb-4 text-gray-700">Jadwal per Hari</h4>
<canvas id="chartHari"></canvas>
</div>

<!-- PER RUANGAN -->
<div class="bg-white p-5 rounded-xl shadow">
<h4 class="font-semibold mb-4 text-gray-700">Penggunaan Ruangan</h4>
<canvas id="chartRuangan"></canvas>
</div>

<!-- JAM SIBUK -->
<div class="bg-white p-5 rounded-xl shadow">
<h4 class="font-semibold mb-4 text-gray-700">Jam Sibuk</h4>
<canvas id="chartJam"></canvas>
</div>

<!-- TOP RUANGAN -->
<div class="bg-white p-5 rounded-xl shadow">
<h4 class="font-semibold mb-4 text-gray-700">Top 5 Ruangan Terpadat</h4>
<canvas id="chartTop"></canvas>
</div>

</div>

</div>

<script>
new Chart(document.getElementById('chartHari'), {
type: 'bar',
data: {
labels: <?= json_encode($hari); ?>,
datasets: [{
label: 'Jumlah Jadwal',
data: <?= json_encode($total_hari); ?>,
borderRadius: 6
}]
},
options: {
plugins: { legend: { display: false }},
scales: { y: { beginAtZero: true }}
}
});

new Chart(document.getElementById('chartRuangan'), {
type: 'pie',
data: {
labels: <?= json_encode($ruang); ?>,
datasets: [{
data: <?= json_encode($total_ruang); ?>
}]
}
});

new Chart(document.getElementById('chartJam'), {
type: 'line',
data: {
labels: <?= json_encode($jam); ?>,
datasets: [{
data: <?= json_encode($total_jam); ?>
}]
}
});

new Chart(document.getElementById('chartTop'), {
type: 'bar',
data: {
labels: <?= json_encode($top_ruang); ?>,
datasets: [{
data: <?= json_encode($total_top); ?>
}]
}
});
</script>

</body>
</html>