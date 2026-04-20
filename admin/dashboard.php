<?php
$ruangan = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM ruangan"))['t'];
$jadwal  = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM jadwal"))['t'];
$user    = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM users"))['t'];
?>

<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-xl font-semibold mb-4">Dashboard Admin</h3>

<div class="grid md:grid-cols-3 gap-4">

<div class="bg-gray-50 p-4 rounded">
<p>Total Ruangan</p>
<h2 class="text-2xl text-blue-600 font-bold"><?= $ruangan ?></h2>
</div>

<div class="bg-gray-50 p-4 rounded">
<p>Total Jadwal</p>
<h2 class="text-2xl text-blue-600 font-bold"><?= $jadwal ?></h2>
</div>

<div class="bg-gray-50 p-4 rounded">
<p>Total User</p>
<h2 class="text-2xl text-blue-600 font-bold"><?= $user ?></h2>
</div>

</div>

</div>