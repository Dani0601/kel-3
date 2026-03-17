<?php
require_once dirname(__DIR__) . "/config/koneksi.php";

date_default_timezone_set("Asia/Jakarta");

$today = date("l");

$hariMap = [
"Monday"=>"Senin",
"Tuesday"=>"Selasa",
"Wednesday"=>"Rabu",
"Thursday"=>"Kamis",
"Friday"=>"Jumat",
"Saturday"=>"Sabtu",
"Sunday"=>"Minggu"
];

$hari = $hariMap[$today];

$selectedGedung = $_GET['gedung'] ?? "";

$where="";
if($selectedGedung!=""){
$where="WHERE ruangan.id_gedung='$selectedGedung'";
}

$gedungQuery = mysqli_query($conn,"SELECT * FROM gedung");

$ruangan = mysqli_query($conn,"
SELECT ruangan.*, gedung.nama_gedung
FROM ruangan
LEFT JOIN gedung ON ruangan.id_gedung = gedung.id_gedung
$where
ORDER BY ruangan.nama_ruangan
");

$jamList = [];

$start = strtotime("07:30");
$end = strtotime("18:00");

while($start < $end){

$time = date("H:i:s",$start);

$jamList[] = $time;

$start = strtotime("+50 minutes",$start);

if(date("H:i",$start) == "12:30"){
$start = strtotime("13:00");
}

}
?>

<div class="max-w-7xl mx-auto px-6 py-10">

<!-- Judul -->
<div class="mb-8 text-center">

<h2 class="text-3xl font-bold text-gray-800">
Jadwal Ruangan Hari Ini
</h2>

<p class="text-gray-500 mt-2">
(<?php echo $hari ?>)
</p>

<div class="w-20 h-1 bg-blue-600 mx-auto mt-3 rounded"></div>

</div>


<!-- Filter -->
<form method="GET" action="index.php" class="mb-6">

<input type="hidden" name="menu" value="status">

<div class="flex flex-wrap gap-4 justify-center">

<select name="gedung"
class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

<option value="">Semua Gedung</option>

<?php
while($g=mysqli_fetch_assoc($gedungQuery)){

$sel = ($selectedGedung==$g['id_gedung']) ? "selected":"";

echo "<option value='".$g['id_gedung']."' $sel>".$g['nama_gedung']."</option>";

}
?>

</select>

<button
class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">

Filter

</button>

</div>

</form>


<!-- Table -->
<div class="overflow-x-auto bg-white shadow rounded-xl">

<table class="min-w-full text-center border-collapse">

<thead class="bg-gray-800 text-white">

<tr>

<th class="p-3">Ruangan</th>

<?php
foreach($jamList as $jam){
echo "<th class='p-3'>".substr($jam,0,5)."</th>";
}
?>

</tr>

</thead>

<tbody>

<?php

while($r=mysqli_fetch_assoc($ruangan)){

echo "<tr class='border-b hover:bg-gray-50'>";

echo "<td class='p-3 font-semibold text-left'>
🏫 ".$r['nama_ruangan']."
<br>
<span class='text-sm text-gray-500'>".$r['nama_gedung']."</span>
</td>";

foreach($jamList as $jam){

$q=mysqli_query($conn,"
SELECT *
FROM jadwal
WHERE id_ruangan='".$r['id_ruangan']."'
AND hari='$hari'
AND '$jam' BETWEEN jam_mulai AND jam_selesai
");

if(mysqli_num_rows($q)>0){

echo "<td class='p-3'>
<span class='bg-green-500 text-white px-3 py-1 rounded-full text-sm'>
Dipakai
</span>
</td>";

}else{

echo "<td class='p-3'>
<span class='bg-gray-400 text-white px-3 py-1 rounded-full text-sm'>
Kosong
</span>
</td>";

}

}

echo "</tr>";

}

?>

</tbody>

</table>

</div>

</div>