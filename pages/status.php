<?php
require_once dirname(__DIR__) . "/config/koneksi.php";

date_default_timezone_set("Asia/Jakarta");

/* ================= TAHUN AJAR AKTIF ================= */
$tahun_aktif = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM tahun_ajaran WHERE aktif=1 LIMIT 1
"));

$id_tahun_aktif = $tahun_aktif['id_tahun_ajar'] ?? 0;

if(!$id_tahun_aktif){
    die("Tidak ada tahun ajar aktif");
}

/* ================= HARI ================= */
$hariMap = [
"Monday"=>"Senin","Tuesday"=>"Selasa","Wednesday"=>"Rabu",
"Thursday"=>"Kamis","Friday"=>"Jumat","Saturday"=>"Sabtu","Sunday"=>"Minggu"
];

$hari = $hariMap[date("l")];
$now  = date("H:i");

/* ================= TIMESLOT ================= */
$start = strtotime("07:30");
$end   = strtotime("18:00");

$timeslots = [];

while($start < $end){

    if(date("H:i",$start) == "12:30"){
        $start = strtotime("13:00");
        continue;
    }

    $next = strtotime("+50 minutes",$start);

    $timeslots[] = [
        'start'=>date("H:i",$start),
        'end'=>date("H:i",$next)
    ];

    $start = $next;
}

/* ================= GEDUNG ================= */
$gedung = mysqli_query($conn,"SELECT * FROM gedung");
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto p-6 space-y-6">

<h2 class="text-3xl font-bold text-gray-800 text-center">
📊 Status Ruangan (<?= $hari ?>)
</h2>

<!-- FILTER -->
<div class="bg-white p-4 rounded-xl shadow flex flex-wrap gap-3 items-center">

<select id="filterGedung" class="border p-2 rounded-lg">
<option value="">Semua Gedung</option>
<?php 
mysqli_data_seek($gedung,0);
while($g = mysqli_fetch_assoc($gedung)){ ?>
<option value="<?= $g['id_gedung'] ?>">
<?= $g['nama_gedung'] ?>
</option>
<?php } ?>
</select>

<select id="filterLantai" class="border p-2 rounded-lg">
<option value="">Semua Lantai</option>
<?php for($i=1;$i<=10;$i++){ ?>
<option value="<?= $i ?>">Lantai <?= $i ?></option>
<?php } ?>
</select>

<input type="text" id="search"
placeholder="🔍 Cari ruangan..."
class="border p-2 rounded-lg w-60">

<select id="show" class="border p-2 rounded-lg">
<option value="5">5</option>
<option value="10" selected>10</option>
<option value="20">20</option>
</select>

</div>

<?php 
mysqli_data_seek($gedung,0);
while($g = mysqli_fetch_assoc($gedung)){ 
$id_gedung = $g['id_gedung'];

$ruangan = mysqli_query($conn,"
SELECT * FROM ruangan 
WHERE id_gedung='$id_gedung'
ORDER BY lantai, nama_ruangan
");
?>

<div class="gedungBox mb-8" data-gedung="<?= $id_gedung ?>">

<h3 class="text-xl font-bold mb-2 text-blue-600 flex items-center gap-2">
🏢 <?= $g['nama_gedung'] ?>
</h3>

<div class="bg-white shadow rounded-xl overflow-x-auto border">

<table class="w-full text-sm text-center">

<thead class="bg-gray-900 text-white sticky top-0 z-10">
<tr>
<th class="p-3 text-left w-40">Ruangan</th>
<th class="p-3 w-16">Lt</th>

<?php foreach($timeslots as $t){
$isNow = ($now >= $t['start'] && $now < $t['end']);
?>
<th class="p-2 text-xs <?= $isNow?'bg-yellow-400 text-black':'' ?>">
<?= $t['start'] ?><br><?= $t['end'] ?>
</th>
<?php } ?>

</tr>
</thead>

<tbody>

<?php while($r = mysqli_fetch_assoc($ruangan)){ ?>

<tr class="rowData border-b hover:bg-gray-50 transition"
data-lantai="<?= $r['lantai'] ?>"
data-nama="<?= strtolower($r['nama_ruangan']) ?>">

<td class="p-2 text-left font-semibold bg-gray-50">
<?= $r['nama_ruangan'] ?>
</td>

<td>
<span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">
<?= $r['lantai'] ?>
</span>
</td>

<?php foreach($timeslots as $t){

$isNow = ($now >= $t['start'] && $now < $t['end']);

/* ================= CEK STATUS ================= */
$q = mysqli_query($conn,"
SELECT 1 FROM jadwal
WHERE id_ruangan='".$r['id_ruangan']."'
AND id_tahun_ajar='$id_tahun_aktif'
AND hari='$hari'
AND TIME('".$t['start']."') >= jam_mulai
AND TIME('".$t['start']."') < jam_selesai

UNION

SELECT 1 FROM booking_ruangan
WHERE id_ruangan='".$r['id_ruangan']."'
AND DATE(tanggal) = CURDATE()
AND hari='$hari'
AND TIME('".$t['start']."') >= jam_mulai
AND TIME('".$t['start']."') < jam_selesai
");

$dipakai = mysqli_num_rows($q) > 0;

/* ================= WARNA ================= */
$bg = $dipakai 
    ? "bg-green-500 text-white" 
    : "bg-gray-100";

if($isNow){
    $bg = $dipakai 
        ? "bg-yellow-500 text-black" 
        : "bg-yellow-200";
}
?>

<td class="p-2 text-xs <?= $bg ?> rounded">
<?= $dipakai ? "Terpakai" : "Tersedia" ?>
</td>

<?php } ?>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<?php } ?>

</div>

<script>
const fGedung = document.getElementById("filterGedung");
const fLantai = document.getElementById("filterLantai");
const search = document.getElementById("search");
const show = document.getElementById("show");

function applyFilter(){

let g = fGedung.value;
let l = fLantai.value;
let s = search.value.toLowerCase();
let limit = parseInt(show.value);

document.querySelectorAll(".gedungBox").forEach(box=>{

let idGedung = box.dataset.gedung;

if(g && g != idGedung){
    box.style.display="none";
    return;
}else{
    box.style.display="";
}

let rows = box.querySelectorAll(".rowData");
let visible = [];

rows.forEach(r=>{
let matchLantai = !l || r.dataset.lantai == l;
let matchSearch = r.dataset.nama.includes(s);

if(matchLantai && matchSearch){
    visible.push(r);
}
});

rows.forEach(r=>r.style.display="none");

visible.forEach((r,i)=>{
if(i < limit){
    r.style.display="";
}
});

});

}

fGedung.onchange = applyFilter;
fLantai.onchange = applyFilter;
search.onkeyup = applyFilter;
show.onchange = applyFilter;

applyFilter();
</script>

<!-- AUTO REFRESH -->
<script>
setTimeout(()=>location.reload(),60000);
</script>