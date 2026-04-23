<?php
include __DIR__ . '/../config/koneksi.php';

# ========================
# FILTER + SEARCH
# ========================
$filter_hari = $_GET['hari'] ?? '';
$search = $_GET['search'] ?? '';

# ========================
# PAGINATION
# ========================
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

# ========================
# WHERE DINAMIS
# ========================
$where = "WHERE 1=1";

if($filter_hari != ''){
    $where .= " AND j.hari = '$filter_hari'";
}

if($search != ''){
    $where .= " AND (
        mk.nama_mk LIKE '%$search%' 
        OR r.nama_ruangan LIKE '%$search%'
        OR j.hari LIKE '%$search%'
    )";
}

# ========================
# TOTAL DATA (PAGINATION)
# ========================
$total_data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
JOIN mk_prodi mp ON j.id_mk_prodi = mp.id_mk_prodi
JOIN mata_kuliah mk ON mp.id_mk = mk.id_mk
$where
"))['total'];

$total_page = ceil($total_data / $limit);

# ========================
# DATA TABEL
# ========================
$data = mysqli_query($conn, "
SELECT 
    j.*, 
    r.nama_ruangan,
    mk.nama_mk
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
JOIN mk_prodi mp ON j.id_mk_prodi = mp.id_mk_prodi
JOIN mata_kuliah mk ON mp.id_mk = mk.id_mk
$where
ORDER BY 
FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),
j.jam_mulai ASC
LIMIT $limit OFFSET $offset
");

# ========================
# CHART (TETAP SAMA)
# ========================
$qHari = mysqli_query($conn,"
SELECT hari, COUNT(*) as total 
FROM jadwal 
GROUP BY hari
ORDER BY FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
");

$hari_chart = [];
$total_chart = [];

while($h = mysqli_fetch_assoc($qHari)){
    $hari_chart[] = $h['hari'];
    $total_chart[] = $h['total'];
}

$qJam = mysqli_query($conn,"
SELECT jam_mulai, COUNT(*) as total 
FROM jadwal
GROUP BY jam_mulai
ORDER BY jam_mulai
");

$jam = [];
$total_jam = [];

while($j = mysqli_fetch_assoc($qJam)){
    $jam[] = $j['jam_mulai'];
    $total_jam[] = $j['total'];
}

$qRuang = mysqli_query($conn,"
SELECT r.nama_ruangan, COUNT(*) as total
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
GROUP BY j.id_ruangan
");

$ruang = [];
$total_ruang = [];

while($r = mysqli_fetch_assoc($qRuang)){
    $ruang[] = $r['nama_ruangan'];
    $total_ruang[] = $r['total'];
}
?>

<div class="p-6">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Kelola Jadwal</h2>
        <p class="text-sm text-gray-500">Manajemen jadwal ruangan</p>
    </div>

    <a href="index.php?menu=tambah_jadwal"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       + Tambah Jadwal
    </a>
</div>

<!-- FILTER + SEARCH -->
<form method="GET" class="mb-4 flex gap-2 flex-wrap">

<input type="hidden" name="menu" value="kelola_jadwal">

<!-- SEARCH -->
<input type="text" name="search"
placeholder="Cari mata kuliah / ruangan / hari..."
value="<?= $search ?>"
class="border p-2 rounded w-64">

<!-- FILTER HARI -->
<select name="hari" class="border p-2 rounded">
<option value="">-- Semua Hari --</option>
<?php 
$hari_list = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
foreach($hari_list as $h){
$selected = ($filter_hari == $h) ? 'selected' : '';
echo "<option $selected>$h</option>";
}
?>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">Cari</button>

<a href="index.php?menu=kelola_jadwal" class="bg-gray-400 text-white px-4 py-2 rounded">Reset</a>

</form>

<!-- CHART -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

<div class="bg-white p-4 rounded shadow">
<h4 class="font-semibold mb-2">Jadwal per Hari</h4>
<canvas id="chartHari"></canvas>
</div>

<div class="bg-white p-4 rounded shadow">
<h4 class="font-semibold mb-2">Jam Sibuk</h4>
<canvas id="chartJam"></canvas>
</div>

<div class="bg-white p-4 rounded shadow">
<h4 class="font-semibold mb-2">Ruangan</h4>
<canvas id="chartRuang"></canvas>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded shadow overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-3">Hari</th>
<th class="p-3">Jam</th>
<th class="p-3">Ruangan</th>
<th class="p-3">Mata Kuliah</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data) > 0){ ?>
<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr class="border-b">

<td class="p-3"><?= $row['hari'] ?></td>

<td class="p-3">
<?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?>
</td>

<td class="p-3"><?= $row['nama_ruangan'] ?></td>

<td class="p-3"><?= $row['nama_mk'] ?></td>

<td class="p-3 text-center">
<a href="index.php?menu=edit_jadwal&id=<?= $row['id_jadwal'] ?>">Edit</a> |
<a href="index.php?menu=hapus_jadwal&id=<?= $row['id_jadwal'] ?>"
   onclick="return confirm('Yakin hapus?')"
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

<!-- PAGINATION -->
<div class="flex justify-center mt-4 gap-2">

<?php for($i=1; $i<=$total_page; $i++) { ?>

<a href="index.php?menu=kelola_jadwal&page=<?= $i ?>&hari=<?= $filter_hari ?>&search=<?= $search ?>"
   class="px-3 py-1 border rounded 
   <?= ($i == $page) ? 'bg-blue-500 text-white' : '' ?>">
   <?= $i ?>
</a>

<?php } ?>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartHari'), {
type: 'bar',
data: {
labels: <?= json_encode($hari_chart) ?>,
datasets: [{ data: <?= json_encode($total_chart) ?> }]
}
});

new Chart(document.getElementById('chartJam'), {
type: 'line',
data: {
labels: <?= json_encode($jam) ?>,
datasets: [{ data: <?= json_encode($total_jam) ?> }]
}
});

new Chart(document.getElementById('chartRuang'), {
type: 'pie',
data: {
labels: <?= json_encode($ruang) ?>,
datasets: [{ data: <?= json_encode($total_ruang) ?> }]
}
});
</script>