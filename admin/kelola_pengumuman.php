<?php
include __DIR__ . '/../config/koneksi.php';

$filter_tanggal = $_GET['tanggal'] ?? '';

$where = "";
if($filter_tanggal != ''){
    $where = "WHERE p.tanggal = '$filter_tanggal'";
}

# DATA + JOIN USER
$data = mysqli_query($conn,"
SELECT p.*, u.username 
FROM pengumuman p
LEFT JOIN users u ON p.id_user = u.id_user
$where
ORDER BY p.tanggal DESC
");

# CHART
$qChart = mysqli_query($conn,"
SELECT tanggal, COUNT(*) as total
FROM pengumuman
" . ($filter_tanggal ? "WHERE tanggal='$filter_tanggal'" : "") . "
GROUP BY tanggal
ORDER BY tanggal ASC
");

$tanggal = [];
$total = [];

while($c = mysqli_fetch_assoc($qChart)){
    $tanggal[] = $c['tanggal'];
    $total[] = $c['total'];
}

$total_pengumuman = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total FROM pengumuman
"))['total'];
?>

<div class="p-6">

<div class="flex justify-between items-center mb-6">
<div>
<h2 class="text-2xl font-bold">Kelola Pengumuman</h2>
<p class="text-sm text-gray-500">Manajemen informasi kampus</p>
</div>

<a href="index.php?menu=tambah_pengumuman"
class="bg-blue-500 text-white px-4 py-2 rounded">
+ Tambah Pengumuman
</a>
</div>

<form method="GET" class="mb-4 flex gap-2">
<input type="hidden" name="menu" value="kelola_pengumuman">

<input type="date" name="tanggal"
value="<?= $filter_tanggal ?>"
class="border p-2 rounded">

<button class="bg-green-500 text-white px-4 py-2 rounded">Cari</button>

<a href="index.php?menu=kelola_pengumuman"
class="bg-gray-400 text-white px-4 py-2 rounded">Reset</a>
</form>

<!-- CHART -->
<div class="grid md:grid-cols-2 gap-6 mb-6">

<div class="bg-white p-4 rounded shadow">
<h4 class="font-semibold mb-2">Pengumuman per Tanggal</h4>
<canvas id="chartPengumuman"></canvas>
</div>

<div class="bg-white p-4 rounded shadow flex items-center justify-center">
<div class="text-center">
<h1 class="text-3xl font-bold"><?= $total_pengumuman ?></h1>
<p>Total Pengumuman</p>
</div>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded shadow overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3">Tanggal</th>
<th class="p-3">Judul</th>
<th class="p-3">Isi</th>
<th class="p-3">Pembuat</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data) > 0){ ?>
<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr class="border-b">

<td class="p-3"><?= $row['tanggal'] ?></td>
<td class="p-3 font-semibold"><?= $row['judul'] ?></td>
<td class="p-3"><?= substr($row['isi'],0,80) ?>...</td>
<td class="p-3"><?= $row['username'] ?? '-' ?></td>

<td class="p-3 text-center">

<a href="index.php?menu=edit_pengumuman&id=<?= $row['id_pengumuman'] ?>">Edit</a> |

<a href="index.php?menu=hapus_pengumuman&id=<?= $row['id_pengumuman'] ?>"
onclick="return confirm('Hapus pengumuman ini?')"
class="text-red-500">
Hapus
</a>

</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="5" class="text-center p-6 text-gray-400">
Tidak ada data
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartPengumuman'), {
type: 'bar',
data: {
labels: <?= json_encode($tanggal) ?>,
datasets: [{
data: <?= json_encode($total) ?>
}]
}
});
</script>