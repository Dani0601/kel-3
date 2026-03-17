<?php
include __DIR__ . '/../config/koneksi.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$gedung_filter = isset($_GET['gedung']) ? mysqli_real_escape_string($conn, $_GET['gedung']) : '';

$query = mysqli_query($conn, "
SELECT 
ruangan.nama_ruangan,
ruangan.kapasitas,
gedung.nama_gedung
FROM ruangan
JOIN gedung 
ON ruangan.id_gedung = gedung.id_gedung
WHERE ruangan.nama_ruangan LIKE '%$search%'
AND gedung.nama_gedung LIKE '%$gedung_filter%'
");

$total_ruangan = mysqli_num_rows($query);

$gedung = mysqli_query($conn, "SELECT * FROM gedung");
?>

<div class="max-w-7xl mx-auto px-6 py-10">

<!-- Judul -->
<div class="text-center mb-10">

<h2 class="text-3xl font-bold text-gray-800">
Informasi Ruangan
</h2>

<div class="w-20 h-1 bg-blue-600 mx-auto mt-3 rounded"></div>

</div>


<!-- Statistik -->
<div class="grid md:grid-cols-3 gap-6 mb-10">

<!-- Total Ruangan -->
<div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-xl transition">

<p class="text-gray-500">Total Ruangan</p>

<h3 class="text-3xl font-bold text-blue-600 mt-2">
<?= $total_ruangan ?>
</h3>

</div>


<!-- Total Gedung -->
<div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-xl transition">

<p class="text-gray-500">Total Gedung</p>

<h3 class="text-3xl font-bold text-green-600 mt-2">

<?php
$g = mysqli_query($conn,"SELECT COUNT(*) as total FROM gedung");
$d = mysqli_fetch_assoc($g);
echo $d['total'];
?>

</h3>

</div>


<!-- Kapasitas Maks -->
<div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-xl transition">

<p class="text-gray-500">Kapasitas Maks</p>

<h3 class="text-3xl font-bold text-red-500 mt-2">

<?php
$k = mysqli_query($conn,"SELECT MAX(kapasitas) as max FROM ruangan");
$m = mysqli_fetch_assoc($k);
echo $m['max'];
?>

</h3>

</div>

</div>


<!-- Search Filter -->
<form method="GET" action="index.php" class="mb-10">

<input type="hidden" name="menu" value="info_ruangan">

<div class="grid md:grid-cols-12 gap-4">

<div class="md:col-span-6">

<input
type="text"
name="search"
value="<?= $search ?>"
placeholder="Cari nama ruangan..."
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

</div>


<div class="md:col-span-4">

<select
name="gedung"
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

<option value="">Semua Gedung</option>

<?php while($g = mysqli_fetch_assoc($gedung)): ?>

<option
value="<?= $g['nama_gedung'] ?>"
<?= $g['nama_gedung'] == $gedung_filter ? 'selected' : '' ?>>

<?= $g['nama_gedung'] ?>

</option>

<?php endwhile; ?>

</select>

</div>


<div class="md:col-span-2">

<button
class="w-full bg-blue-600 text-white rounded-lg py-2 hover:bg-blue-700 transition">

Cari

</button>

</div>

</div>

</form>


<!-- Card Ruangan -->
<div class="grid md:grid-cols-3 gap-6">

<?php while($data = mysqli_fetch_assoc($query)): ?>

<div class="bg-white rounded-2xl shadow p-6 hover:shadow-2xl hover:-translate-y-2 transition duration-300">

<h3 class="text-lg font-semibold text-gray-800 mb-2">

🏫 <?= $data['nama_ruangan']; ?>

</h3>

<p class="text-gray-500 mb-2">

📍 <?= $data['nama_gedung']; ?>

</p>

<div class="mt-3">

<span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm">

👥 Kapasitas <?= $data['kapasitas']; ?> orang

</span>

</div>

</div>

<?php endwhile; ?>

</div>
</div>