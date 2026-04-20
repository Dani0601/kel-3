<?php
require_once dirname(__DIR__) . "/config/koneksi.php";

date_default_timezone_set("Asia/Jakarta");

/* ================= HARI ================= */

$hariMap = [
"Monday"=>"Senin",
"Tuesday"=>"Selasa",
"Wednesday"=>"Rabu",
"Thursday"=>"Kamis",
"Friday"=>"Jumat",
"Saturday"=>"Sabtu",
"Sunday"=>"Minggu"
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
        'start' => date("H:i",$start),
        'end'   => date("H:i",$next)
    ];

    $start = $next;
}

/* ================= GEDUNG ================= */

$gedung = mysqli_query($conn,"SELECT * FROM gedung");

?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto p-6">

<h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
Status Ruangan Hari Ini (<?= $hari ?>)
</h2>

<?php while($g = mysqli_fetch_assoc($gedung)){ ?>

<?php
$id_gedung = $g['id_gedung'];

/* ambil semua ruangan di gedung */
$ruangan = mysqli_query($conn,"
SELECT * FROM ruangan 
WHERE id_gedung='$id_gedung'
ORDER BY nama_ruangan
");
?>

<div class="mb-10">

<h3 class="text-xl font-bold mb-3 text-blue-700">
🏢 <?= $g['nama_gedung'] ?>
</h3>

<div class="bg-white shadow-lg rounded-xl overflow-x-auto">

<table class="w-full table-fixed text-sm text-center border">

<thead class="bg-gray-800 text-white">

<tr>
<th class="p-2 w-32">Ruangan</th>

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

<?php while($r = mysqli_fetch_assoc($ruangan)){ ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-2 font-semibold text-left bg-gray-100">
<?= $r['nama_ruangan'] ?>
</td>

<?php foreach($timeslots as $t){ 

$isNow = ($now >= $t['start'] && $now < $t['end']);

/* cek jadwal */
$q = mysqli_query($conn,"
SELECT * FROM jadwal
WHERE id_ruangan='".$r['id_ruangan']."'
AND hari='$hari'
AND (
    TIME('".$t['start']."') >= jam_mulai
    AND TIME('".$t['start']."') < jam_selesai
)
");

$dipakai = mysqli_num_rows($q) > 0;

/* warna */
$bg = "bg-gray-100";
$text = "Kosong";

if($dipakai){
    $bg = "bg-green-500 text-white";
    $text = "Dipakai";
}

/* highlight sekarang */
if($isNow){
    $bg = $dipakai ? "bg-yellow-500 text-black" : "bg-yellow-200";
}
?>

<td class="p-2 text-xs <?= $bg ?>">
<?= $text ?>
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

<!-- AUTO REFRESH -->
<script>
setTimeout(() => {
    location.reload();
}, 60000);
</script>