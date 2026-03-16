<?php
require_once __DIR__ . "/../config/koneksi.php";

$prodi    = $_GET['prodi'] ?? '';
$semester = $_GET['semester'] ?? '';
$dosen    = $_GET['dosen'] ?? '';
$ruangan  = $_GET['ruangan'] ?? '';

$query = "
SELECT 
jadwal.hari,
jadwal.jam_mulai,
jadwal.jam_selesai,
mata_kuliah.nama_mk,
dosen.nama_dosen,
ruangan.nama_ruangan,
prodi.nama_prodi,
mk_prodi.semester

FROM jadwal

JOIN mk_prodi ON jadwal.id_mk_prodi = mk_prodi.id_mk_prodi
JOIN mata_kuliah ON mk_prodi.id_mk = mata_kuliah.id_mk
JOIN prodi ON mk_prodi.id_prodi = prodi.id_prodi
JOIN dosen ON jadwal.id_dosen = dosen.id_dosen
JOIN ruangan ON jadwal.id_ruangan = ruangan.id_ruangan

WHERE 1=1
";

if($prodi != ''){
$query .= " AND prodi.id_prodi='$prodi'";
}

if($semester != ''){
$query .= " AND mk_prodi.semester='$semester'";
}

if($dosen != ''){
$query .= " AND dosen.id_dosen='$dosen'";
}

if($ruangan != ''){
$query .= " AND ruangan.id_ruangan='$ruangan'";
}

$query .= " ORDER BY jadwal.hari, jadwal.jam_mulai";

$data = mysqli_query($conn,$query);

$jadwal = [];

while($row = mysqli_fetch_assoc($data)){
$key = $row['hari']."_".$row['jam_mulai'];
$jadwal[$key] = $row;
}

$prodi_data   = mysqli_query($conn,"SELECT * FROM prodi");
$dosen_data   = mysqli_query($conn,"SELECT * FROM dosen");
$ruangan_data = mysqli_query($conn,"SELECT * FROM ruangan");

$hari = ["Senin","Selasa","Rabu","Kamis","Jumat"];

$jam = [
"07:30:00",
"09:10:00",
"10:50:00",
"13:00:00",
"14:40:00"
];
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto p-6">

<h2 class="text-3xl font-bold mb-6 text-gray-800">
Jadwal Kuliah
</h2>

<!-- FILTER -->

<form method="GET" class="mb-6">

<input type="hidden" name="menu" value="jadwal">

<div class="grid md:grid-cols-4 gap-4">

<select name="prodi" onchange="this.form.submit()"
class="border rounded-lg p-2 shadow-sm focus:ring-2 focus:ring-blue-500">

<option value="">Semua Prodi</option>

<?php while($p = mysqli_fetch_assoc($prodi_data)){ ?>

<option value="<?= $p['id_prodi'] ?>" <?= ($prodi==$p['id_prodi'])?'selected':'' ?>>

<?= $p['nama_prodi'] ?>

</option>

<?php } ?>

</select>


<select name="semester" onchange="this.form.submit()"
class="border rounded-lg p-2 shadow-sm focus:ring-2 focus:ring-blue-500">

<option value="">Semua Semester</option>

<?php for($i=1;$i<=8;$i++){ ?>

<option value="<?= $i ?>" <?= ($semester==$i)?'selected':'' ?>>

Semester <?= $i ?>

</option>

<?php } ?>

</select>


<select name="dosen" onchange="this.form.submit()"
class="border rounded-lg p-2 shadow-sm focus:ring-2 focus:ring-blue-500">

<option value="">Semua Dosen</option>

<?php while($d = mysqli_fetch_assoc($dosen_data)){ ?>

<option value="<?= $d['id_dosen'] ?>" <?= ($dosen==$d['id_dosen'])?'selected':'' ?>>

<?= $d['nama_dosen'] ?>

</option>

<?php } ?>

</select>


<select name="ruangan" onchange="this.form.submit()"
class="border rounded-lg p-2 shadow-sm focus:ring-2 focus:ring-blue-500">

<option value="">Semua Ruangan</option>

<?php while($r = mysqli_fetch_assoc($ruangan_data)){ ?>

<option value="<?= $r['id_ruangan'] ?>" <?= ($ruangan==$r['id_ruangan'])?'selected':'' ?>>

<?= $r['nama_ruangan'] ?>

</option>

<?php } ?>

</select>

</div>

</form>

<!-- TABLE -->

<div class="bg-white shadow-lg rounded-xl overflow-hidden">

<table class="w-full text-sm text-center">

<thead class="bg-gray-800 text-white">

<tr>

<th class="p-3">Jam</th>

<?php foreach($hari as $h){ ?>

<th class="p-3"><?= $h ?></th>

<?php } ?>

</tr>

</thead>

<tbody>

<?php foreach($jam as $j){ ?>

<tr class="border-b hover:bg-gray-50">

<td class="font-semibold text-gray-700">

<?= date("H:i",strtotime($j)) ?>

</td>

<?php foreach($hari as $h){

$key = $h."_".$j;

?>

<td class="h-28 align-top p-2">

<?php

if(isset($jadwal[$key])){

$data = $jadwal[$key];

?>

<div class="bg-blue-50 border border-blue-200 rounded-lg p-2 hover:bg-blue-100 transition">

<div class="font-semibold text-blue-700">

<?= $data['nama_mk'] ?>

</div>

<div class="text-gray-700 text-xs">

<?= $data['nama_dosen'] ?>

</div>

<div class="text-gray-500 text-xs">

<?= $data['nama_ruangan'] ?>

</div>

</div>

<?php } ?>

</td>

<?php } ?>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>