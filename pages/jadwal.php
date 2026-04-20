<?php
require_once __DIR__ . "/../config/koneksi.php";

date_default_timezone_set("Asia/Jakarta");

$prodi    = $_GET['prodi'] ?? '';
$semester = $_GET['semester'] ?? '';
$dosen    = $_GET['dosen'] ?? '';
$ruangan  = $_GET['ruangan'] ?? '';
$kelas    = $_GET['kelas'] ?? '';

/* ================= QUERY ================= */

$query = "
SELECT 
jadwal.hari,
jadwal.jam_mulai,
jadwal.jam_selesai,
mata_kuliah.nama_mk,
dosen.nama_dosen,
ruangan.nama_ruangan,
prodi.nama_prodi,
mk_prodi.semester,
kelas.nama_kelas

FROM jadwal
JOIN mk_prodi ON jadwal.id_mk_prodi = mk_prodi.id_mk_prodi
JOIN mata_kuliah ON mk_prodi.id_mk = mata_kuliah.id_mk
JOIN prodi ON mk_prodi.id_prodi = prodi.id_prodi
JOIN dosen ON jadwal.id_dosen = dosen.id_dosen
JOIN ruangan ON jadwal.id_ruangan = ruangan.id_ruangan
JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
WHERE 1=1
";

if($prodi != '')    $query .= " AND prodi.id_prodi='$prodi'";
if($semester != '') $query .= " AND mk_prodi.semester='$semester'";
if($dosen != '')    $query .= " AND dosen.id_dosen='$dosen'";
if($ruangan != '')  $query .= " AND ruangan.id_ruangan='$ruangan'";
if($kelas != '')    $query .= " AND kelas.id_kelas='$kelas'";

$query .= " ORDER BY jadwal.hari, jadwal.jam_mulai";

$data = mysqli_query($conn,$query);

/* ================= SUSUN DATA ================= */

$jadwal = [];

while($row = mysqli_fetch_assoc($data)){
    $key = $row['hari']."_".$row['jam_mulai'];
    $jadwal[$key][] = $row;
}

$jadwal_per_kelas = [];

foreach($jadwal as $items){
    foreach($items as $j){
        $kelas_nama = $j['nama_kelas'];
        $jadwal_per_kelas[$kelas_nama][] = $j;
    }
}

/* ================= MASTER DATA ================= */

$prodi_data   = mysqli_query($conn,"SELECT * FROM prodi");
$dosen_data   = mysqli_query($conn,"SELECT * FROM dosen");
$ruangan_data = mysqli_query($conn,"SELECT * FROM ruangan");

/* FILTER KELAS DINAMIS */
if($prodi != ''){
    $kelas_data = mysqli_query($conn,"
        SELECT kelas.* 
        FROM kelas
        JOIN prodi ON kelas.id_prodi = prodi.id_prodi
        WHERE prodi.id_prodi='$prodi'
    ");
}else{
    $kelas_data = mysqli_query($conn,"SELECT * FROM kelas");
}

$hari = ["Senin","Selasa","Rabu","Kamis","Jumat"];

/* ================= TIMESLOT ================= */

$start = strtotime("07:30");
$end   = strtotime("18:00");

$timeslots = [];

while($start < $end){

    $next = strtotime("+50 minutes", $start);

    // skip istirahat
    if(date("H:i",$start) == "12:30"){
        $start = strtotime("13:00");
        continue;
    }

    $timeslots[] = [
        'start' => date("H:i",$start),
        'end'   => date("H:i",$next)
    ];

    $start = $next;
}

/* ================= JAM SEKARANG ================= */

$now = date("H:i");

?>

<script src="https://cdn.tailwindcss.com"></script>

<style>
td, th {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>

<div class="max-w-7xl mx-auto p-6">

<h2 class="text-3xl font-bold mb-6 text-gray-800">
Jadwal Kuliah
</h2>

<!-- FILTER -->
<form method="GET" class="mb-6">
<input type="hidden" name="menu" value="jadwal">

<div class="grid md:grid-cols-5 gap-4">

<select name="prodi" onchange="this.form.submit()" class="border rounded-lg p-2">
<option value="">Semua Prodi</option>
<?php while($p = mysqli_fetch_assoc($prodi_data)){ ?>
<option value="<?= $p['id_prodi'] ?>" <?= ($prodi==$p['id_prodi'])?'selected':'' ?>>
<?= $p['nama_prodi'] ?>
</option>
<?php } ?>
</select>

<select name="semester" onchange="this.form.submit()" class="border rounded-lg p-2">
<option value="">Semua Semester</option>
<?php for($i=1;$i<=8;$i++){ ?>
<option value="<?= $i ?>" <?= ($semester==$i)?'selected':'' ?>>
Semester <?= $i ?>
</option>
<?php } ?>
</select>

<select name="dosen" onchange="this.form.submit()" class="border rounded-lg p-2">
<option value="">Semua Dosen</option>
<?php while($d = mysqli_fetch_assoc($dosen_data)){ ?>
<option value="<?= $d['id_dosen'] ?>" <?= ($dosen==$d['id_dosen'])?'selected':'' ?>>
<?= $d['nama_dosen'] ?>
</option>
<?php } ?>
</select>

<select name="ruangan" onchange="this.form.submit()" class="border rounded-lg p-2">
<option value="">Semua Ruangan</option>
<?php while($r = mysqli_fetch_assoc($ruangan_data)){ ?>
<option value="<?= $r['id_ruangan'] ?>" <?= ($ruangan==$r['id_ruangan'])?'selected':'' ?>>
<?= $r['nama_ruangan'] ?>
</option>
<?php } ?>
</select>

<select name="kelas" id="kelasSelect" onchange="this.form.submit()"
class="border rounded-lg p-2"
<?= ($prodi==''?'disabled':'') ?>>

<option value="">Semua Kelas</option>
<?php while($k = mysqli_fetch_assoc($kelas_data)){ ?>
<option value="<?= $k['id_kelas'] ?>" <?= ($kelas==$k['id_kelas'])?'selected':'' ?>>
<?= $k['nama_kelas'] ?>
</option>
<?php } ?>
</select>

</div>
</form>

<!-- TABEL -->
<?php foreach($jadwal_per_kelas as $kelas_nama => $list_jadwal){ ?>

<div class="mb-10">

<h3 class="text-xl font-bold mb-3 text-gray-700">
Kelas <?= $kelas_nama ?>
</h3>

<div class="bg-white shadow-lg rounded-xl overflow-x-auto">

<table class="w-full table-fixed text-sm text-center border">

<thead class="bg-gray-800 text-white">
<tr>

<th class="p-2 w-28">Hari</th>

<?php foreach($timeslots as $t){ 
$isNow = ($now >= $t['start'] && $now < $t['end']);
?>

<th class="p-2 text-xs w-24 <?= $isNow ? 'bg-yellow-400 text-black' : '' ?>">
<?= $t['start'] ?><br>-<br><?= $t['end'] ?>
</th>

<?php } ?>

</tr>
</thead>

<tbody>

<?php foreach($hari as $h){ ?>

<tr class="border-b">

<td class="font-semibold bg-gray-100 w-28">
<?= $h ?>
</td>

<?php
$i = 0;

while($i < count($timeslots)){

$slot = $timeslots[$i];
$found = false;
$isNow = ($now >= $slot['start'] && $now < $slot['end']);

foreach($list_jadwal as $data){

$mulai = strtotime($data['jam_mulai']);
$selesai = strtotime($data['jam_selesai']);

$slot_start = strtotime($slot['start']);
$slot_end   = strtotime($slot['end']);

if(
    $data['hari'] == $h &&
    $mulai >= $slot_start &&
    $mulai < $slot_end
){

$durasi = 0;

foreach($timeslots as $ts){

    $ts_start = strtotime($ts['start']);
    $ts_end   = strtotime($ts['end']);

    // cek overlap
    if($mulai < $ts_end && $selesai > $ts_start){
        $durasi++;
    }

}
if($durasi == 0) $durasi = 1;
?>

<td colspan="<?= $durasi ?>" 
class="h-24 border p-2 <?= $isNow ? 'bg-yellow-300' : 'bg-blue-100' ?>">

<div class="truncate font-semibold text-sm">
<?= $data['nama_mk'] ?>
</div>

<div class="text-xs"><?= $data['nama_dosen'] ?></div>
<div class="text-xs text-gray-500"><?= $data['nama_ruangan'] ?></div>
<div class="text-xs text-purple-600">S<?= $data['semester'] ?></div>

</td>

<?php

$i += $durasi;
$found = true;
break;

}

}

if(!$found){
echo '<td class="h-24 border '.($isNow?'bg-yellow-100':'').'"></td>';
$i++;
}

}
?>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<?php } ?>

</div>

<!-- RESET KELAS SAAT GANTI PRODI -->
<script>
document.querySelector('select[name="prodi"]').addEventListener('change', function(){
    document.getElementById('kelasSelect').value = "";
});
</script>