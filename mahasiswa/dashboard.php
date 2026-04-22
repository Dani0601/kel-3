<?php 
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

// ======================
// DATA MAHASISWA
// ======================
$mahasiswa = $conn->query("
SELECT m.*, k.nama_kelas, p.nama_prodi
FROM mahasiswa m
LEFT JOIN kelas k ON m.id_kelas = k.id_kelas
LEFT JOIN prodi p ON k.id_prodi = p.id_prodi
WHERE m.id_user = '$id_user'
")->fetch_assoc();

$id_kelas = $mahasiswa['id_kelas'] ?? null;

// ======================
// JADWAL
// ======================
$data = $conn->query("
SELECT j.*, r.nama_ruangan
FROM jadwal j
LEFT JOIN ruangan r ON j.id_ruangan = r.id_ruangan
WHERE j.id_kelas = '$id_kelas'
ORDER BY 
FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),
j.jam_mulai ASC
");

// ======================
// LAPORAN (TRACKING)
// ======================
$laporan = $conn->query("
SELECT 
COUNT(*) as total,
SUM(status='pending') as pending,
SUM(status='proses') as proses,
SUM(status='selesai') as selesai
FROM laporan_fasilitas
WHERE id_user = '$id_user'
")->fetch_assoc();

$total = $laporan['total'] ?? 0;
$pending = $laporan['pending'] ?? 0;
$proses = $laporan['proses'] ?? 0;
$selesai = $laporan['selesai'] ?? 0;

// progress %
$progress = ($total > 0) ? ($selesai / $total) * 100 : 0;
?>

<div class="p-6 space-y-6">

<!-- HEADER -->
<h2 class="text-2xl font-bold text-gray-800">
Dashboard Mahasiswa 👋
</h2>

<!-- ====================== -->
<!-- INFO USER -->
<!-- ====================== -->
<div class="bg-white p-5 rounded-xl shadow space-y-2">

<p><b>Nama:</b> <?= $_SESSION['username'] ?></p>

<?php if($mahasiswa && $mahasiswa['nama_kelas']){ ?>
<p>
<b>Kelas:</b> 
<span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">
🎓 <?= $mahasiswa['nama_prodi'] ?> - <?= $mahasiswa['nama_kelas'] ?>
</span>
</p>
<?php } else { ?>
<p class="text-red-500">⚠️ Kamu belum memiliki kelas</p>
<?php } ?>

</div>

<!-- ====================== -->
<!-- STATUS LAPORAN -->
<!-- ====================== -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-semibold mb-4">📊 Status Laporan Saya</h3>

<div class="grid md:grid-cols-4 gap-4 text-center">

    <div class="bg-gray-100 p-4 rounded-lg">
        <p>Total</p>
        <h2 class="text-xl font-bold"><?= $total ?></h2>
    </div>

    <div class="bg-yellow-100 p-4 rounded-lg">
        <p>Pending</p>
        <h2 class="text-xl font-bold text-yellow-600"><?= $pending ?></h2>
    </div>

    <div class="bg-blue-100 p-4 rounded-lg">
        <p>Diproses</p>
        <h2 class="text-xl font-bold text-blue-600"><?= $proses ?></h2>
    </div>

    <div class="bg-green-100 p-4 rounded-lg">
        <p>Selesai</p>
        <h2 class="text-xl font-bold text-green-600"><?= $selesai ?></h2>
    </div>

</div>

</div>

<!-- ====================== -->
<!-- PROGRESS BAR -->
<!-- ====================== -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="font-semibold mb-2">📈 Progress Laporan</h3>

<div class="w-full bg-gray-200 rounded-full h-4">
    <div class="bg-green-500 h-4 rounded-full"
    style="width: <?= $progress ?>%"></div>
</div>

<p class="text-sm text-gray-500 mt-2">
<?= round($progress) ?>% laporan selesai
</p>

</div>

<!-- ====================== -->
<!-- RIWAYAT LAPORAN -->
<!-- ====================== -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-semibold mb-4">📜 Riwayat Laporan</h3>

<?php
$list = $conn->query("
SELECT * FROM laporan_fasilitas
WHERE id_user='$id_user'
ORDER BY tanggal DESC
");
?>

<?php if($list->num_rows > 0){ ?>

    <?php while($d = $list->fetch_assoc()){ ?>

    <div class="border-b py-3 flex justify-between">

        <div>
            <p class="font-semibold"><?= $d['judul'] ?></p>
            <p class="text-sm text-gray-500">
                <?= $d['tanggal'] ?>
            </p>
        </div>

        <div>
            <span class="
            px-3 py-1 rounded-full text-sm
            <?= $d['status']=='pending'?'bg-yellow-100 text-yellow-600':'' ?>
            <?= $d['status']=='proses'?'bg-blue-100 text-blue-600':'' ?>
            <?= $d['status']=='selesai'?'bg-green-100 text-green-600':'' ?>
            ">
            <?= $d['status'] ?>
            </span>
        </div>

    </div>

    <?php } ?>

<?php } else { ?>

<p class="text-gray-500">Belum ada laporan</p>

<?php } ?>

</div>

<!-- ====================== -->
<!-- JADWAL -->
<!-- ====================== -->
<div class="bg-white shadow-lg rounded-xl p-6">

<h3 class="text-lg font-semibold mb-4">
📅 Jadwal Kuliah Kamu
</h3>

<div class="overflow-x-auto">
<table class="w-full text-sm border rounded-lg overflow-hidden">

<tr class="bg-gray-100 text-gray-700">
    <th class="p-3 border">Hari</th>
    <th class="p-3 border">Jam</th>
    <th class="p-3 border">Ruangan</th>
</tr>

<?php if($data && $data->num_rows > 0): ?>
    <?php while($d = $data->fetch_assoc()): ?>
    <tr class="hover:bg-gray-50 transition">
        <td class="p-3 border"><?= $d['hari'] ?></td>
        <td class="p-3 border">
            <?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?>
        </td>
        <td class="p-3 border">
            <?= $d['nama_ruangan'] ?? '-' ?>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="3" class="text-center p-4 text-gray-500">
            📭 Belum ada jadwal kuliah
        </td>
    </tr>
<?php endif; ?>

</table>
</div>

</div>

</div>