<?php
include __DIR__ . '/../config/koneksi.php';

/* ========================
   FILTER + SEARCH
======================== */
$filter_tanggal = $_GET['tanggal'] ?? '';
$search = $_GET['search'] ?? '';

/* ========================
   PAGINATION
======================== */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* ========================
   WHERE DINAMIS
======================== */
$where = "WHERE 1=1";

if ($filter_tanggal != '') {
    $filter_tanggal = mysqli_real_escape_string($conn, $filter_tanggal);
    $where .= " AND p.tanggal = '$filter_tanggal'";
}

if ($search != '') {
    $search = mysqli_real_escape_string($conn, $search);
    $where .= " AND (
        p.judul LIKE '%$search%' 
        OR p.isi LIKE '%$search%'
        OR u.username LIKE '%$search%'
    )";
}

/* ========================
   TOTAL DATA (PAGINATION)
======================== */
$total_data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM pengumuman p
LEFT JOIN users u ON p.id_user = u.id_user
$where
"))['total'];

$total_page = ceil($total_data / $limit);

/* ========================
   DATA TABLE
======================== */
$data = mysqli_query($conn,"
SELECT p.*, u.username 
FROM pengumuman p
LEFT JOIN users u ON p.id_user = u.id_user
$where
ORDER BY p.tanggal DESC
LIMIT $limit OFFSET $offset
");

/* ========================
   CHART (SUDAH IKUT FILTER)
======================== */
$qChart = mysqli_query($conn,"
SELECT p.tanggal, COUNT(*) as total
FROM pengumuman p
LEFT JOIN users u ON p.id_user = u.id_user
$where
GROUP BY p.tanggal
ORDER BY p.tanggal ASC
");

$tanggal = [];
$total = [];

while ($c = mysqli_fetch_assoc($qChart)) {
    $tanggal[] = $c['tanggal'];
    $total[] = $c['total'];
}

/* ========================
   TOTAL PENGUMUMAN (FILTERED)
======================== */
$total_pengumuman = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM pengumuman p
LEFT JOIN users u ON p.id_user = u.id_user
$where
"))['total'];
?>

<div class="p-6">

<!-- HEADER -->
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

<!-- FILTER -->
<form method="GET" class="mb-4 flex gap-2 flex-wrap">

<input type="hidden" name="menu" value="kelola_pengumuman">

<input type="text" name="search"
placeholder="Cari judul / isi / pembuat..."
value="<?= htmlspecialchars($search) ?>"
class="border p-2 rounded w-64">

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

<div style="height: 250px;">
<canvas id="chartPengumuman"></canvas>
</div>
</div>

<div class="bg-white p-4 rounded shadow flex items-center justify-center">
<div class="text-center">
<h1 class="text-3xl font-bold"><?= $total_pengumuman ?></h1>
<p>Total Pengumuman</p>
</div>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
   <div class="p-4 border-b">
      <h3 class="font-semibold text-gray-700">Data Pengumuman</h3>
   </div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 text-xs uppercase text-gray-600">
<tr>
<th class="px-4 py-3">Tanggal</th>
<th class="px-4 py-3">Judul</th>
<th class="px-4 py-3">Isi</th>
<th class="px-4 py-3">Pembuat</th>
<th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y text-gray-700">

<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr class="hover:bg-gray-50 transition">

<td class="px-4 py-3"><?= $row['tanggal'] ?></td>

<td class="px-4 py-3 font-semibold">
<?= htmlspecialchars($row['judul']) ?>
</td>

<td class="px-4 py-3 text-gray-600">
<?= htmlspecialchars(substr($row['isi'],0,80)) ?>...
</td>

<td class="px-4 py-3">
<?= $row['username'] ?? '-' ?>
</td>

<td class="p-3 text-center">
<div class="flex justify-center gap-2">

<a href="index.php?menu=edit_pengumuman&id=<?= $row['id_pengumuman'] ?>"
class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs hover:bg-yellow-200 transition">
Edit
</a>

<a href="#"
onclick="openDeleteModal('index.php?menu=hapus_pengumuman&id=<?= $row['id_pengumuman'] ?>', 'Hapus Pengumuman?')"
class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
Hapus
</a>

</div>
</td>


</tr>

<?php } ?>

</tbody>
</table>
</div>
</div>

<!-- PAGINATION -->
<div class="flex justify-center mt-4 gap-2">

<?php for($i=1; $i<=$total_page; $i++) { ?>

<a href="index.php?menu=kelola_pengumuman&page=<?= $i ?>&tanggal=<?= $filter_tanggal ?>&search=<?= $search ?>"
class="px-3 py-1 border rounded 
<?= ($i == $page) ? 'bg-blue-500 text-white' : '' ?>">
<?= $i ?>
</a>

<?php } ?>

</div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartPengumuman'), {
type: 'bar',
data: {
labels: <?= json_encode($tanggal) ?>,
datasets: [{
label: 'Jumlah Pengumuman',
data: <?= json_encode($total) ?>,
backgroundColor: '#3b82f6'
}]
},
options: {
responsive: true,
maintainAspectRatio: false
}
});
</script>