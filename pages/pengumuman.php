<?php
include __DIR__ . '/../config/koneksi.php';
include __DIR__ . '/../includes/navbar.php';

$query = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengumuman</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto px-4 mt-24">

<!-- Header -->
<div class="mb-8">
<h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
📢 Pengumuman Smart Room
</h1>
<p class="text-gray-500">Informasi terbaru sistem smart room</p>
</div>

<div class="grid md:grid-cols-2 gap-6">

<?php
if(mysqli_num_rows($query) > 0){
while($data = mysqli_fetch_assoc($query)){
?>

<!-- Card -->
<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 p-6 border border-gray-100">

<h2 class="text-xl font-semibold text-blue-600 mb-2">
<?php echo $data['judul']; ?>
</h2>

<p class="text-sm text-gray-400 mb-3">
📅 <?php echo date('d F Y H:i', strtotime($data['tanggal'])); ?>
</p>

<div class="border-t pt-3 text-gray-700 leading-relaxed">
<?php echo $data['isi']; ?>
</div>

</div>

<?php
}
}else{
?>

<div class="col-span-2">

<div class="bg-blue-100 text-blue-700 p-4 rounded-lg">
Belum ada pengumuman
</div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>