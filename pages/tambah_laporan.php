<?php
include "config/koneksi.php";
$ruangan = $conn->query("SELECT * FROM ruangan");
?>

<div class="p-6">
<h2 class="text-xl font-bold mb-4">📝 Buat Laporan</h2>

<form action="pages/proses_laporan.php" method="POST">

<input type="text" name="judul" placeholder="Judul laporan"
class="w-full border p-2 mb-3 rounded" required>

<textarea name="deskripsi" placeholder="Deskripsi"
class="w-full border p-2 mb-3 rounded" required></textarea>

<!-- PILIH RUANGAN -->
<select name="id_ruangan" class="w-full border p-2 mb-3 rounded" required>
<option value="">-- Pilih Ruangan --</option>
<?php while($r = $ruangan->fetch_assoc()){ ?>
<option value="<?= $r['id_ruangan'] ?>">
<?= $r['nama_ruangan'] ?>
</option>
<?php } ?>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Kirim Laporan
</button>

</form>
</div>