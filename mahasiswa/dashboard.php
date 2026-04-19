<?php 
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

// ambil data mahasiswa + kelas + prodi
$mahasiswa = $conn->query("
SELECT m.*, k.nama_kelas, p.nama_prodi
FROM mahasiswa m
LEFT JOIN kelas k ON m.id_kelas = k.id_kelas
LEFT JOIN prodi p ON k.id_prodi = p.id_prodi
WHERE m.id_user = '$id_user'
")->fetch_assoc();

$id_kelas = $mahasiswa['id_kelas'] ?? null;

// ambil jadwal + ruangan
$data = $conn->query("
SELECT j.*, r.nama_ruangan
FROM jadwal j
LEFT JOIN ruangan r ON j.id_ruangan = r.id_ruangan
WHERE j.id_kelas = '$id_kelas'
ORDER BY 
FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),
j.jam_mulai ASC
");

// statistik laporan
$total = $conn->query("SELECT COUNT(*) as jml FROM laporan_fasilitas WHERE id_user='$id_user'")->fetch_assoc()['jml'] ?? 0;

$diproses = $conn->query("SELECT COUNT(*) as jml FROM laporan_fasilitas WHERE id_user='$id_user' AND status='proses'")->fetch_assoc()['jml'] ?? 0;

$selesai = $conn->query("SELECT COUNT(*) as jml FROM laporan_fasilitas WHERE id_user='$id_user' AND status='selesai'")->fetch_assoc()['jml'] ?? 0;
?>

<div class="p-6">

<!-- HEADER -->
<h2 class="text-2xl font-bold mb-6 text-gray-800">
Dashboard Mahasiswa 👋
</h2>

<!-- INFO USER -->
<div class="bg-white p-5 rounded-xl shadow mb-6 space-y-2">

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

<!-- STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

<div class="bg-gray-50 border border-gray-200 p-4 rounded-xl">
<p class="text-gray-500 text-sm">Total Laporan</p>
<h2 class="text-2xl font-bold text-gray-800"><?= $total ?></h2>
</div>

<div class="bg-blue-50 border border-blue-200 p-4 rounded-xl">
<p class="text-blue-600 text-sm">Diproses</p>
<h2 class="text-2xl font-bold text-blue-700"><?= $diproses ?></h2>
</div>

<div class="bg-green-50 border border-green-200 p-4 rounded-xl">
<p class="text-green-600 text-sm">Selesai</p>
<h2 class="text-2xl font-bold text-green-700"><?= $selesai ?></h2>
</div>

</div>

<!-- JADWAL -->
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