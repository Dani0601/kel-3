<?php
include "config/koneksi.php";

$id = $_GET['id'];
$id_user = $_SESSION['id_user'];

// tandai sudah dibaca saat dibuka
$conn->query("
UPDATE notifikasi_user 
SET status_dibaca=1
WHERE id_notifikasi='$id' AND id_user='$id_user'
");

// ambil data notif
$data = $conn->query("
SELECT * FROM notifikasi WHERE id_notifikasi='$id'
")->fetch_assoc();
?>

<div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">

<h3 class="text-xl font-semibold mb-2">
    <?= $data['judul'] ?>
</h3>

<p class="text-gray-700">
    <?= $data['pesan'] ?>
</p>

<a href="index.php?menu=notifikasi_user"
   class="inline-block mt-4 text-blue-600 hover:underline">
   ← Kembali
</a>

</div>