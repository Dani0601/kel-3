<?php
include __DIR__ . '/../config/koneksi.php';

# ========================
# FILTER
# ========================
$filter_gedung = $_GET['gedung'] ?? '';

$where = "";
if($filter_gedung != ''){
    $where = "WHERE r.id_gedung = '$filter_gedung'";
}

# ========================
# DATA TABEL
# ========================
$data = mysqli_query($conn, "
SELECT r.*, g.nama_gedung
FROM ruangan r
JOIN gedung g ON r.id_gedung = g.id_gedung
$where
ORDER BY g.nama_gedung ASC
");

# ========================
# FILTER LIST GEDUNG
# ========================
$gedung_list = mysqli_query($conn,"SELECT * FROM gedung");

# ========================
# CHART GEDUNG
# ========================
$qGedung = mysqli_query($conn,"
SELECT g.nama_gedung, COUNT(r.id_ruangan) as total
FROM ruangan r
JOIN gedung g ON r.id_gedung = g.id_gedung
" . ($filter_gedung ? "WHERE r.id_gedung='$filter_gedung'" : "") . "
GROUP BY r.id_gedung
");

$gedung = [];
$total_gedung = [];

while($g = mysqli_fetch_assoc($qGedung)){
    $gedung[] = $g['nama_gedung'];
    $total_gedung[] = $g['total'];
}

# ========================
# CHART KAPASITAS
# ========================
$qKapasitas = mysqli_query($conn,"
SELECT kapasitas, COUNT(*) as total
FROM ruangan
GROUP BY kapasitas
ORDER BY kapasitas
");

$kapasitas = [];
$total_kapasitas = [];

while($k = mysqli_fetch_assoc($qKapasitas)){
    $kapasitas[] = $k['kapasitas'];
    $total_kapasitas[] = $k['total'];
}

# ========================
# TOTAL RUANGAN PER GEDUNG (PIE)
# ========================
$qPie = mysqli_query($conn,"
SELECT g.nama_gedung, COUNT(r.id_ruangan) as total
FROM ruangan r
JOIN gedung g ON r.id_gedung = g.id_gedung
GROUP BY r.id_gedung
");

$pie_label = [];
$pie_data = [];

while($p = mysqli_fetch_assoc($qPie)){
    $pie_label[] = $p['nama_gedung'];
    $pie_data[] = $p['total'];
}
?>

<div class="p-6">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Kelola Ruangan</h2>
        <p class="text-sm text-gray-500">Manajemen ruangan gedung</p>
    </div>

    <a href="index.php?menu=tambah_ruangan"
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
       + Tambah Ruangan
    </a>
</div>

<!-- FILTER -->
<form method="GET" action="index.php" class="mb-4 flex gap-2">

<input type="hidden" name="menu" value="kelola_ruangan">

<select name="gedung" class="border p-2 rounded">
<option value="">-- Semua Gedung --</option>
<?php while($g = mysqli_fetch_assoc($gedung_list)){ ?>
<option value="<?= $g['id_gedung'] ?>"
<?= $filter_gedung == $g['id_gedung'] ? 'selected' : '' ?>>
<?= $g['nama_gedung'] ?>
</option>
<?php } ?>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Cari
</button>

<a href="index.php?menu=kelola_ruangan" class="bg-gray-400 text-white px-4 py-2 rounded">
Reset
</a>

</form>

<!-- CHART -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

<div class="bg-white p-4 rounded-xl shadow">
<h4 class="font-semibold mb-2">Ruangan per Gedung</h4>
<canvas id="chartGedung"></canvas>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h4 class="font-semibold mb-2">Kapasitas Ruangan</h4>
<canvas id="chartKapasitas"></canvas>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h4 class="font-semibold mb-2">Distribusi Gedung</h4>
<canvas id="chartPie"></canvas>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Gedung</th>
<th class="p-3 text-left">Nama Ruangan</th>
<th class="p-3 text-left">Kapasitas</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data) > 0){ ?>
<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr class="border-b">

<td class="p-3"><?= $row['nama_gedung'] ?></td>

<td class="p-3"><?= $row['nama_ruangan'] ?></td>

<td class="p-3"><?= $row['kapasitas'] ?></td>

<td class="p-3 text-center">

<a href="index.php?menu=edit_ruangan&id=<?= $row['id_ruangan'] ?>">
Edit
</a> |

<a href="index.php?menu=hapus_ruangan&id=<?= $row['id_ruangan'] ?>"
   onclick="return confirm('Yakin hapus ruangan ini?')"
   class="text-red-500">
   Hapus
</a>

</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="4" class="text-center text-gray-400 p-6">
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
new Chart(document.getElementById('chartGedung'), {
type: 'bar',
data: {
labels: <?= json_encode($gedung) ?>,
datasets: [{ data: <?= json_encode($total_gedung) ?> }]
}
});

new Chart(document.getElementById('chartKapasitas'), {
type: 'line',
data: {
labels: <?= json_encode($kapasitas) ?>,
datasets: [{ data: <?= json_encode($total_kapasitas) ?> }]
}
});

new Chart(document.getElementById('chartPie'), {
type: 'pie',
data: {
labels: <?= json_encode($pie_label) ?>,
datasets: [{ data: <?= json_encode($pie_data) ?> }]
}
});
</script>