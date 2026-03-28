<?php 
include "admin/notifikasi.php";
include "config/koneksi.php";

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    $conn->query("
        UPDATE notifikasi 
        SET status = 'dihapus'
        WHERE id_notifikasi = '$id'
    ");

    echo "<script>
        alert('Notifikasi dihapus');
        location='index.php?menu=notifikasi';
    </script>";
}
?>

<div class="max-w-4xl mx-auto mt-6">

<!-- FORM -->
<div class="bg-white shadow-md rounded-xl p-6 mb-6">

<h3 class="text-lg font-semibold mb-4">Kirim Notifikasi</h3>

<form method="POST">

    <input type="text" name="judul"
    class="w-full border rounded-lg px-3 py-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
    placeholder="Judul" required>

    <textarea name="pesan"
    class="w-full border rounded-lg px-3 py-2 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
    placeholder="Pesan" required></textarea>

    <select name="target"
    class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Semua User</option>
        <option value="dosen">Dosen</option>
        <option value="mahasiswa">Mahasiswa</option>
    </select>

    <button name="kirim"
    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    Kirim
    </button>

</form>

<?php
if(isset($_POST['kirim'])){
    tambah_notifikasi($conn, $_POST['judul'], $_POST['pesan'], $_POST['target']);
    echo "<div class='mt-3 p-2 bg-green-100 text-green-700 rounded'>Notifikasi terkirim</div>";
}
?>

</div>

<!-- RIWAYAT -->
<div class="bg-white shadow-md rounded-xl p-6">

<h4 class="text-lg font-semibold mb-4">Riwayat Notifikasi</h4>

<?php
$data = $conn->query("SELECT * FROM notifikasi ORDER BY id_notifikasi DESC");?>

<div class="space-y-4">

<?php while($d = $data->fetch_assoc()): ?>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition">

    <!-- HEADER -->
    <div class="flex justify-between items-start">

        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                <?= $d['judul'] ?>
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                <?= $d['pesan'] ?>
            </p>
        </div>

        <!-- STATUS -->
        <?php if($d['status'] == 'aktif'): ?>
            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                Aktif
            </span>
        <?php else: ?>
            <span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full">
                Dihapus
            </span>
        <?php endif; ?>

    </div>

    <!-- FOOTER -->
    <div class="flex justify-between items-center mt-4">

        <span class="text-xs text-gray-400">
            ID: <?= $d['id_notifikasi'] ?>
        </span>

        <?php if($d['status'] == 'aktif'): ?>
        <a href="index.php?menu=notifikasi&hapus=<?= $d['id_notifikasi'] ?>"
           onclick="return confirm('Hapus notifikasi ini?')"
           class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition">
            Hapus
        </a>
        <?php endif; ?>

    </div>

</div>

<?php endwhile; ?>

</div>

</div>

</div>