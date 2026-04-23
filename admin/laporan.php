<?php
include "config/koneksi.php";

/* ========================
   FILTER
======================== */
$cari = $_GET['cari'] ?? '';
$status_filter = $_GET['status'] ?? '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

/* ========================
   WHERE
======================== */
$where = "WHERE 1=1";

if (!empty($cari)) {
    $cari = mysqli_real_escape_string($conn, $cari);
    $where .= " AND l.judul LIKE '%$cari%'";
}

if (!empty($status_filter)) {
    $status_filter = mysqli_real_escape_string($conn, $status_filter);
    $where .= " AND l.status='$status_filter'";
}

/* ========================
   DATA
======================== */
$data = $conn->query("
SELECT l.*, u.username, r.nama_ruangan 
FROM laporan_fasilitas l
LEFT JOIN users u ON l.id_user = u.id_user
LEFT JOIN ruangan r ON l.id_ruangan = r.id_ruangan
$where
ORDER BY l.tanggal DESC
LIMIT $limit OFFSET $offset
");

/* ========================
   TOTAL DATA
======================== */
$totalData = $conn->query("
SELECT COUNT(*) as total 
FROM laporan_fasilitas l
$where
")->fetch_assoc()['total'];

$totalPage = ceil($totalData / $limit);

/* ========================
   STATISTIK
======================== */
$laporan = $conn->query("
SELECT 
COUNT(*) as total,
SUM(status='pending') as pending,
SUM(status='proses') as proses,
SUM(status='selesai') as selesai
FROM laporan_fasilitas
")->fetch_assoc();
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Kelola Laporan</h2>

<!-- ================= STATISTIK ================= -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Total</p>
        <h2 class="text-2xl font-bold"><?= $laporan['total'] ?></h2>
    </div>

    <div class="bg-blue-100 p-5 rounded-xl">
        <p class="text-blue-600">Proses</p>
        <h2 class="text-2xl font-bold"><?= $laporan['proses'] ?></h2>
    </div>

    <div class="bg-green-100 p-5 rounded-xl">
        <p class="text-green-600">Selesai</p>
        <h2 class="text-2xl font-bold"><?= $laporan['selesai'] ?></h2>
    </div>

</div>

<!-- ================= FILTER (FIX UTAMA ADA DI SINI) ================= -->
<form method="GET" class="mb-4 flex gap-2 flex-wrap">

<!-- 🔥 PENTING: INI YANG HILANG SEBELUMNYA -->
<input type="hidden" name="menu" value="kelola_laporan">

<input type="text" name="cari"
value="<?= htmlspecialchars($cari) ?>"
placeholder="Cari judul..."
class="border p-2 rounded">

<select name="status" class="border p-2 rounded">
    <option value="">Semua Status</option>
    <option value="pending" <?= $status_filter=='pending'?'selected':'' ?>>Pending</option>
    <option value="proses" <?= $status_filter=='proses'?'selected':'' ?>>Proses</option>
    <option value="selesai" <?= $status_filter=='selesai'?'selected':'' ?>>Selesai</option>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Cari
</button>

<a href="index.php?menu=kelola_laporan"
class="bg-gray-400 text-white px-4 py-2 rounded">
Reset
</a>

</form>

<!-- ================= TABLE ================= -->
<div class="bg-white shadow rounded-lg overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-200">
<tr>
<th class="p-2">No</th>
<th>Judul</th>
<th>User</th>
<th>Ruangan</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $no = $offset + 1; ?>

<?php if($data->num_rows > 0){ ?>
<?php while($d = $data->fetch_assoc()){ ?>

<tr class="border-t">

<td class="p-2"><?= $no++ ?></td>
<td><?= htmlspecialchars($d['judul']) ?></td>
<td><?= $d['username'] ?></td>
<td><?= $d['nama_ruangan'] ?></td>

<td>
<span class="
<?= $d['status']=='pending'?'text-yellow-500':'' ?>
<?= $d['status']=='proses'?'text-blue-500':'' ?>
<?= $d['status']=='selesai'?'text-green-500':'' ?>
">
<?= $d['status'] ?>
</span>
</td>

<td class="space-x-2">

<a href="?menu=detail_laporan&id=<?= $d['id_laporan'] ?>"
class="text-green-500">Detail</a>

<button 
onclick="openEditModal(
'<?= $d['id_laporan'] ?>',
'<?= htmlspecialchars($d['judul']) ?>',
'<?= htmlspecialchars($d['deskripsi']) ?>',
'<?= $d['status'] ?>'
)"
class="text-blue-500">
Edit
</button>

<a href="admin/hapus_laporan.php?id=<?= $d['id_laporan'] ?>"
onclick="return confirm('Hapus data?')"
class="text-red-500">
Hapus
</a>

</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="6" class="text-center p-6 text-gray-400">
Tidak ada data
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- ================= PAGINATION ================= -->
<div class="mt-4 flex gap-2">
<?php for($i=1;$i<=$totalPage;$i++): ?>
<a href="index.php?menu=kelola_laporan&page=<?= $i ?>&cari=<?= $cari ?>&status=<?= $status_filter ?>"
class="px-3 py-1 border rounded <?= $i==$page?'bg-blue-500 text-white':'' ?>">
<?= $i ?>
</a>
<?php endfor; ?>
</div>

</div>

<!-- ================= MODAL ================= -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

<div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg">

<h2 class="text-xl font-bold mb-4">Edit Laporan</h2>

<form action="admin/update_laporan.php" method="POST">

<input type="hidden" name="id_laporan" id="edit_id">

<div class="mb-3">
<label class="block text-sm">Judul</label>
<input type="text" id="edit_judul"
class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
</div>

<div class="mb-3">
<label class="block text-sm">Deskripsi</label>
<textarea id="edit_deskripsi"
class="w-full border px-3 py-2 rounded bg-gray-100" readonly></textarea>
</div>

<div class="mb-4">
<label class="block text-sm">Status</label>
<select name="status" id="edit_status"
class="w-full border px-3 py-2 rounded">
<option value="pending">Pending</option>
<option value="proses">Proses</option>
<option value="selesai">Selesai</option>
</select>
</div>

<div class="flex justify-end gap-2">

<button type="button" onclick="closeModal()"
class="px-4 py-2 bg-gray-400 text-white rounded">
Batal
</button>

<button type="submit"
class="px-4 py-2 bg-blue-600 text-white rounded">
Simpan
</button>

</div>

</form>

</div>
</div>

<script>
function openEditModal(id, judul, deskripsi, status){
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_judul').value = judul;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_status').value = status;

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('editModal').classList.add('hidden');
}
</script>