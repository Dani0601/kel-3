<?php
include "config/koneksi.php";

$id = $_GET['id'] ?? 0;

$data = $conn->query("
SELECT l.*, u.username, r.nama_ruangan 
FROM laporan_fasilitas l
LEFT JOIN users u ON l.id_user = u.id_user
LEFT JOIN ruangan r ON l.id_ruangan = r.id_ruangan
WHERE l.id_laporan='$id'
")->fetch_assoc();

// ===== FIX FOTO (ANTI ERROR SEMUA KASUS) =====
$foto_db = $data['foto'] ?? '';
$foto = trim($foto_db);
$foto = basename($foto);

// kemungkinan path
$path1 = "upload/laporan/" . $foto;
$path2 = "uploads/laporan/" . $foto;

// cek mana yang ada
if(!empty($foto) && file_exists($path1)){
    $final_path = $path1;
}
elseif(!empty($foto) && file_exists($path2)){
    $final_path = $path2;
}
else{
    $final_path = "";
}
?>

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4">Detail Laporan</h2>

    <p><b>Judul:</b> <?= $data['judul'] ?></p>
    <p><b>Pelapor:</b> <?= $data['username'] ?></p>
    <p><b>Ruangan:</b> <?= $data['nama_ruangan'] ?></p>
    <p><b>Status:</b> <?= $data['status'] ?></p>
    <p class="mb-4"><b>Deskripsi:</b><br><?= $data['deskripsi'] ?></p>

    <!-- FOTO -->
    <?php if($final_path != ""){ ?>
        <img src="<?= $final_path ?>" class="w-64 rounded-lg shadow">
    <?php } else { ?>
        <div class="text-red-500 font-semibold">
            Foto tidak ditemukan
        </div>
    <?php } ?>

    <div class="mt-6">
        <a href="index.php?menu=laporan" 
        class="bg-gray-500 text-white px-4 py-2 rounded">
        Kembali
        </a>
    </div>

</div>