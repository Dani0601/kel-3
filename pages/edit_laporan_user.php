<?php
include "config/koneksi.php";

$id = $_GET['id'] ?? 0;
$id_user = $_SESSION['id_user'];

// ambil data laporan
$data = $conn->query("
SELECT * FROM laporan_fasilitas 
WHERE id_laporan='$id' AND id_user='$id_user'
")->fetch_assoc();

if(!$data){
    echo "<div class='text-red-500 text-center mt-10'>Data tidak ditemukan</div>";
    exit;
}

// ambil ruangan
$ruangan = $conn->query("SELECT * FROM ruangan");
?>

<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg">

<h2 class="text-2xl font-bold mb-6 text-center">
✏️ Edit Laporan
</h2>

<form action="pages/proses_edit_laporan.php" method="POST" enctype="multipart/form-data" class="space-y-5">

<!-- WAJIB -->
<input type="hidden" name="id_laporan" value="<?= $data['id_laporan'] ?>">
<input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">

<!-- RUANGAN -->
<div>
<label class="block mb-1">Ruangan</label>
<select name="id_ruangan" class="w-full border px-3 py-2 rounded-lg">
<?php while($r = $ruangan->fetch_assoc()){ ?>
<option value="<?= $r['id_ruangan'] ?>"
<?= $r['id_ruangan']==$data['id_ruangan']?'selected':'' ?>>
<?= $r['nama_ruangan'] ?>
</option>
<?php } ?>
</select>
</div>

<!-- JENIS -->
<div>
<label class="block mb-1">Jenis</label>
<input type="text" name="jenis"
value="<?= $data['jenis'] ?>"
class="w-full border px-3 py-2 rounded-lg">
</div>

<!-- DESKRIPSI -->
<div>
<label class="block mb-1">Deskripsi</label>
<textarea name="deskripsi" class="w-full border px-3 py-2 rounded-lg"><?= $data['deskripsi'] ?></textarea>
</div>

<!-- FOTO LAMA -->
<div>
<label class="block mb-1">Foto Lama</label>

<?php if($data['foto']){ ?>
    <img src="./upload/laporan/<?= $data['foto'] ?>" class="w-40 mb-2 rounded shadow">
<?php } else { ?>
    <p class="text-gray-500 text-sm">Tidak ada foto</p>
<?php } ?>

</div>

<!-- FOTO BARU -->
<div>
<label class="block mb-1">Upload Foto Baru (opsional)</label>
<input type="file" name="foto" class="w-full border px-3 py-2 rounded-lg">
</div>

<!-- BUTTON -->
<div class="text-center">
<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
Update
</button>
</div>

</form>

</div>