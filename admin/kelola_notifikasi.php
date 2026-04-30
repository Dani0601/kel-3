<?php 
include "admin/tambah_notifikasi.php";
include "config/koneksi.php";

$conn->query("
DELETE FROM notifikasi
WHERE status='dihapus'
AND created_at < NOW() - INTERVAL 30 DAY
");

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    $conn->query("
        UPDATE notifikasi 
        SET status = 'dihapus'
        WHERE id_notifikasi = '$id'
    ");

    header("Location: index.php?menu=notifikasi&msg=hapus");
    exit;
}

if(isset($_GET['restore'])){
    $id = $_GET['restore'];

    $conn->query("
        UPDATE notifikasi 
        SET status = 'aktif'
        WHERE id_notifikasi = '$id'
    ");

    header("Location: index.php?menu=notifikasi&msg=restore");
    exit;
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
$status_filter = $_GET['status'] ?? 'semua';
$cari_safe = mysqli_real_escape_string($conn, $cari);

/* =========================
   QUERY DATA
========================= */
$sql = "SELECT * FROM notifikasi WHERE 1=1";

if($status_filter == 'aktif'){
    $sql .= " AND status='aktif'";
}
else if($status_filter == 'dihapus'){
    $sql .= " AND status='dihapus'";
}

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

<div class="p-6 space-y-6">

<div>
    <h2 class="text-2xl font-bold text-gray-800">
        Kelola Notifikasi
    </h2>
    <p class="text-sm text-gray-500">
        Manajemen notifikasi sistem dan informasi pengguna
    </p>
</div>

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

    <select name="status" class="border p-2 rounded">
        <option value="semua" <?= $status_filter=='semua'?'selected':'' ?>>Semua</option>
        <option value="aktif" <?= $status_filter=='aktif'?'selected':'' ?>>Aktif</option>
        <option value="dihapus" <?= $status_filter=='dihapus'?'selected':'' ?>>Dihapus</option>
    </select>

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

<div class="border rounded-xl p-5 hover:shadow-md transition">

    <div class="flex justify-between items-start">

        <div>
            <h3 class="font-semibold text-gray-800">
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

    <!-- ACTION -->
    <div class="flex justify-end mt-4">

        <?php if($d['status'] == 'aktif'): ?>

        <a href="#"
            onclick="openDeleteModal('index.php?menu=notifikasi&hapus=<?= $d['id_notifikasi'] ?>', 'Hapus Notifikasi?')"
            class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs">
            Hapus
        </a>

        <?php else: ?>

        <a href="index.php?menu=notifikasi&restore=<?= $d['id_notifikasi'] ?>"
        class="bg-blue-100 text-blue-600 px-3 py-1 rounded text-xs">
        Restore
        </a>

        <?php endif; ?>

    </div>

</div>

<?php endwhile; ?>

</div>

<!-- ================= PAGINATION ================= -->
<div class="flex justify-center mt-4 gap-2">

<?php for($i = 1; $i <= $total_page; $i++): ?>

<a href="index.php?menu=notifikasi&page=<?= $i ?>&cari=<?= urlencode($cari) ?>&status=<?= $status_filter ?>"
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
</div>