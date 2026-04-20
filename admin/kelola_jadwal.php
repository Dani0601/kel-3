<?php
include __DIR__ . '/../config/koneksi.php';

# ========================
# FILTER
# ========================
$filter_hari = $_GET['hari'] ?? '';

$where = "";
if($filter_hari != ''){
    $where = "WHERE j.hari = '$filter_hari'";
}

# ========================
# DATA TABEL
# ========================
$data = mysqli_query($conn, "
SELECT j.*, r.nama_ruangan 
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
$where
ORDER BY 
FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),
j.jam_mulai ASC
");

# ========================
# CHART HARI
# ========================
$qHari = mysqli_query($conn,"
SELECT hari, COUNT(*) as total 
FROM jadwal 
" . ($filter_hari ? "WHERE hari='$filter_hari'" : "") . "
GROUP BY hari
ORDER BY FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
");

$hari_chart = [];
$total_chart = [];

while($h = mysqli_fetch_assoc($qHari)){
    $hari_chart[] = $h['hari'];
    $total_chart[] = $h['total'];
}

# ========================
# CHART JAM
# ========================
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

# ========================
# CHART RUANGAN
# ========================
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
        <h2 class="text-2xl font-bold text-gray-800">Kelola Jadwal</h2>
        <p class="text-sm text-gray-500">Manajemen jadwal ruangan</p>
    </div>

    <a href="index.php?menu=tambah_jadwal" 
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
       + Tambah Jadwal
    </a>
</div>

<!-- FILTER -->
<form method="GET" action="index.php" class="mb-4 flex gap-2">

<input type="hidden" name="menu" value="kelola_jadwal">

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

<button class="bg-green-500 text-white px-4 py-2 rounded">
Cari
</button>

<a href="index.php?menu=kelola_jadwal" class="bg-gray-400 text-white px-4 py-2 rounded">
Reset
</a>

</form>

<!-- CHART -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

<div class="bg-white p-4 rounded-xl shadow">
<h4 class="font-semibold mb-2">Jadwal per Hari</h4>
<canvas id="chartHari"></canvas>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h4 class="font-semibold mb-2">Jam Sibuk</h4>
<canvas id="chartJam"></canvas>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h4 class="font-semibold mb-2">Penggunaan Ruangan</h4>
<canvas id="chartRuang"></canvas>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Hari</th>
<th class="p-3 text-left">Jam</th>
<th class="p-3 text-left">Ruangan</th>
<th class="p-3 text-left">MK</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data) > 0){ ?>
<?php while($row = mysqli_fetch_assoc($data)) { 

$cek = mysqli_query($conn,"
SELECT * FROM jadwal 
WHERE hari='{$row['hari']}'
AND id_ruangan='{$row['id_ruangan']}'
AND id_jadwal!='{$row['id_jadwal']}'
AND (
    jam_mulai < '{$row['jam_selesai']}'
    AND jam_selesai > '{$row['jam_mulai']}'
)
");

$bentrok = mysqli_num_rows($cek) > 0;
?>

<tr class="<?= $bentrok ? 'bg-red-100' : '' ?> border-b">

<td class="p-3"><?= $row['hari'] ?></td>

<td class="p-3">
<?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?>
</td>

<td class="p-3"><?= $row['nama_ruangan'] ?></td>

<td class="p-3"><?= $row['id_mk_prodi'] ?></td>

<td class="p-3 text-center">
<a href="index.php?menu=edit_jadwal&id=<?= $row['id_jadwal'] ?>">Edit</a> |
<a href="admin/hapus_jadwal.php?id=<?= $row['id_jadwal'] ?>"
   onclick="return confirm('Yakin hapus jadwal ini?')"
   class="text-red-500">
   Hapus
</a>
</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="5" class="text-center text-gray-400 p-6">
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