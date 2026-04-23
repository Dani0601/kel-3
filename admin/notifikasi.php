<?php 
include "admin/tambah_notifikasi.php";
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

/* =========================
   PAGINATION SETTING
========================= */
$limit = 5; // jumlah data per halaman
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

/* =========================
   SEARCH
========================= */
$cari = $_GET['cari'] ?? '';
$cari_safe = mysqli_real_escape_string($conn, $cari);

/* =========================
   QUERY DATA
========================= */
$sql = "
SELECT * FROM notifikasi 
WHERE 1=1
";

if($cari != ''){
    $sql .= " AND (judul LIKE '%$cari_safe%' OR pesan LIKE '%$cari_safe%')";
}

$sql_count = $sql; // untuk hitung total data
$sql .= " ORDER BY id_notifikasi DESC LIMIT $start, $limit";

$data = $conn->query($sql);

/* =========================
   TOTAL PAGINATION
========================= */
$total_data = $conn->query($sql_count)->num_rows;
$total_page = ceil($total_data / $limit);

?>

<div class="max-w-4xl mx-auto mt-6">

<!-- FORM -->
<div class="bg-white shadow-md rounded-xl p-6 mb-6">

<h3 class="text-lg font-semibold mb-4">Kirim Notifikasi</h3>

<form method="POST">

    <input type="text" name="judul"
    class="w-full border rounded-lg px-3 py-2 mb-3"
    placeholder="Judul" required>

    <textarea name="pesan"
    class="w-full border rounded-lg px-3 py-2 mb-3"
    placeholder="Pesan" required></textarea>

    <select name="target"
    class="w-full border rounded-lg px-3 py-2 mb-3">
        <option value="">Semua User</option>
        <option value="dosen">Dosen</option>
        <option value="mahasiswa">Mahasiswa</option>
    </select>

    <button name="kirim"
    class="bg-blue-600 text-white px-4 py-2 rounded-lg">
    Kirim
    </button>

</form>

<?php
if(isset($_POST['kirim'])){
    tambah_notifikasi($conn, $_POST['judul'], $_POST['pesan'], $_POST['target']);
    echo "<div class='mt-3 p-2 bg-green-100 text-green-700 rounded'>
        Notifikasi terkirim
    </div>";
}
?>

</div>

<!-- SEARCH -->
<form method="GET" class="mb-4 flex gap-2">
    <input type="hidden" name="menu" value="notifikasi">

    <input type="text" name="cari"
        placeholder="Cari judul atau pesan..."
        value="<?= htmlspecialchars($cari) ?>"
        class="border p-2 rounded w-full">

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Cari
    </button>

    <a href="index.php?menu=notifikasi"
       class="bg-gray-400 text-white px-4 py-2 rounded">
       Reset
    </a>
</form>

<!-- LIST -->
<div class="bg-white shadow-md rounded-xl p-6">

<h4 class="text-lg font-semibold mb-4">Riwayat Notifikasi</h4>

<?php if($data && $data->num_rows > 0){ ?>

<div class="space-y-4">

<?php while($d = $data->fetch_assoc()): ?>

<div class="border rounded-xl p-5">

    <div class="flex justify-between">

        <div>
            <h3 class="font-semibold"><?= $d['judul'] ?></h3>
            <p class="text-sm text-gray-600">
                <?= $d['pesan'] ?>
            </p>
        </div>

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

</div>

<?php endwhile; ?>

</div>

<!-- ================= PAGINATION ================= -->
<div class="flex justify-center mt-6 space-x-2">

<?php for($i = 1; $i <= $total_page; $i++): ?>

<a href="index.php?menu=notifikasi&page=<?= $i ?>&cari=<?= urlencode($cari) ?>"
   class="px-3 py-1 border rounded 
   <?= ($i == $page) ? 'bg-blue-500 text-white' : '' ?>">
   <?= $i ?>
</a>

<?php endfor; ?>

</div>

<?php } else { ?>

<div class="text-center text-gray-400 py-10">
    Tidak ada data notifikasi
</div>

<?php } ?>

</div>

</div>