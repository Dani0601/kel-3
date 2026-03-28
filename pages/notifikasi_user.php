<?php
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

// ambil notifikasi untuk user ini
$data = $conn->query("
    SELECT n.* 
    FROM notifikasi n
    JOIN notifikasi_user nu ON n.id_notifikasi = nu.id_notifikasi
    WHERE nu.id_user = '$id_user'
    AND n.status = 'aktif'
    ORDER BY n.id_notifikasi DESC
");

// tandai sudah dibaca
$conn->query("
    UPDATE notifikasi_user 
    SET status_dibaca = 1 
    WHERE id_user = '$id_user'
");
?>

<div class="space-y-4">

<?php while($d = $data->fetch_assoc()){ ?>

<div class="bg-white p-4 rounded-xl shadow">

    <h3 class="font-semibold">
        <?= $d['judul'] ?>
    </h3>

    <p class="text-sm text-gray-600">
        <?= $d['pesan'] ?>
    </p>

</div>

<?php } ?>

</div>