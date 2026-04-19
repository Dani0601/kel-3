<?php 
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

// data mahasiswa
$mhs = $conn->query("
SELECT * FROM mahasiswa WHERE id_user='$id_user'
")->fetch_assoc();

// data ruangan
$ruangan = $conn->query("SELECT * FROM ruangan ORDER BY nama_ruangan ASC");
?>

<div class="p-6 mt-20 max-w-3xl mx-auto">

<h2 class="text-2xl font-bold text-gray-800 mb-6">
Laporan Fasilitas Rusak
</h2>

<!-- SUCCESS -->
<?php if(isset($_GET['success'])){ ?>
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
    ✅ Laporan berhasil dikirim!
</div>
<?php } ?>

<!-- ERROR -->
<?php if(isset($_GET['error'])){ ?>
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
    ❌ Gagal mengirim laporan!
</div>
<?php } ?>

<form action="pages/proses_laporan.php" method="POST" enctype="multipart/form-data"
class="bg-white shadow-xl rounded-2xl p-6 space-y-5">

<!-- DATA MAHASISWA -->
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="text-sm text-gray-500">Nama</label>
        <div class="bg-gray-100 p-2 rounded-lg">
            <?= $mhs['nama_mahasiswa'] ?>
        </div>
    </div>

    <div>
        <label class="text-sm text-gray-500">NIM</label>
        <div class="bg-gray-100 p-2 rounded-lg">
            <?= $mhs['nim'] ?>
        </div>
    </div>
</div>

<input type="hidden" name="id_user" value="<?= $id_user ?>">

<!-- RUANGAN -->
<div>
    <label class="text-sm text-gray-500">Ruangan</label>
    <select name="id_ruangan"
    class="w-full mt-1 border border-gray-300 rounded-xl p-2 bg-gray-50 focus:ring-2 focus:ring-blue-400"
    required>

        <option value="">-- Pilih Ruangan --</option>

        <?php while($r = $ruangan->fetch_assoc()){ ?>
        <option value="<?= $r['id_ruangan'] ?>">
            <?= $r['nama_ruangan'] ?>
        </option>
        <?php } ?>

    </select>
</div>

<!-- JENIS -->
<div>
    <label class="text-sm text-gray-500">Jenis Fasilitas</label>
    <select name="jenis"
    class="w-full mt-1 border border-gray-300 rounded-xl p-2 bg-gray-50 focus:ring-2 focus:ring-blue-400"
    required>
        <option value="">Pilih jenis</option>
        <option>Proyektor</option>
        <option>AC</option>
        <option>Kursi</option>
        <option>Meja</option>
        <option>Papan Tulis</option>
        <option>Lampu</option>
        <option>Lainnya</option>
    </select>
</div>

<!-- DESKRIPSI -->
<div>
    <label class="text-sm text-gray-500">Deskripsi</label>
    <textarea name="deskripsi" rows="4"
    class="w-full mt-1 border border-gray-300 rounded-xl p-2 focus:ring-2 focus:ring-blue-400"
    required></textarea>
</div>

<!-- FOTO -->
<div>
    <label class="text-sm text-gray-500">Upload Foto</label>
    <input type="file" name="foto"
    class="w-full mt-1 border border-gray-300 rounded-xl p-2 bg-gray-50"
    required>
</div>

<!-- BUTTON -->
<button type="submit"
class="w-full bg-gradient-to-r from-red-400 to-red-500 hover:from-red-500 hover:to-red-600 text-white font-semibold py-2 rounded-xl shadow-md transition">
Kirim Laporan
</button>

</form>

</div>