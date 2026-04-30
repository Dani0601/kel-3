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

<div class="p-6 space-y-6">

<!-- HEADER -->
<div>
    <h2 class="text-2xl font-bold text-gray-800">
        Kelola Laporan
    </h2>
    <p class="text-sm text-gray-500">Monitoring dan pengelolaan laporan fasilitas dari pengguna</p>
</div>

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

<!-- ================= TABLE ================= -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="p-4 border-b">
        <h3 class="font-semibold text-gray-700">Data Laporan</h3>
    </div>

    <!-- ================= FILTER (FIX UTAMA ADA DI SINI) ================= -->
    <div class="bg-white p-4 rounded-2xl shadow flex flex-wrap gap-3">
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
    </div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 text-xs uppercase text-gray-600">
<tr>
<th class="px-4 py-3">No</th>
<th class="px-4 py-3">Judul</th>
<th class="px-4 py-3">User</th>
<th class="px-4 py-3">Ruangan</th>
<th class="px-4 py-3">Status</th>
<th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y text-gray-700">

<?php $no=$offset+1; ?>
<?php while($d = $data->fetch_assoc()){ ?>

<tr class="hover:bg-gray-50 transition">

<td class="px-4 py-3"><?= $no++ ?></td>

<td class="px-4 py-3 font-medium">
<?= htmlspecialchars($d['judul']) ?>
</td>

<td class="px-4 py-3"><?= $d['username'] ?></td>
<td class="px-4 py-3"><?= $d['nama_ruangan'] ?></td>

<td class="px-4 py-3">
<span class="text-xs px-2 py-1 rounded-full
<?= $d['status']=='pending'?'bg-yellow-100 text-yellow-600':'' ?>
<?= $d['status']=='proses'?'bg-blue-100 text-blue-600':'' ?>
<?= $d['status']=='selesai'?'bg-green-100 text-green-600':'' ?>">
<?= $d['status'] ?>
</span>
</td>

<td class="px-4 py-3 text-center space-x-2">

<button 
onclick="openEditModal(
'<?= $d['id_laporan'] ?>',
'<?= htmlspecialchars($d['judul']) ?>',
'<?= htmlspecialchars($d['deskripsi']) ?>',
'<?= $d['status'] ?>',
'<?= $d['foto'] ?>'
)"
class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-xs hover:bg-blue-200 transition">
Edit
</button>

<button 
onclick="openDeleteModal('index.php?menu=hapus_laporan&id=<?= $d['id_laporan'] ?>', 'Hapus Laporan?')"
class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
Hapus
</button>

</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>
</div>
<!-- ================= PAGINATION ================= -->
<div class="flex justify-center mt-4 gap-2">
<?php for($i=1;$i<=$totalPage;$i++): ?>
<a href="index.php?menu=kelola_laporan&page=<?= $i ?>&cari=<?= $cari ?>&status=<?= $status_filter ?>"
class="px-3 py-1 border rounded <?= $i==$page?'bg-blue-500 text-white':'' ?>">
<?= $i ?>
</a>
<?php endfor; ?>
</div>

</div>

<!-- ================= MODAL ================= -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">

    <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg max-h-[90vh] overflow-y-auto">

        <h2 class="text-xl font-bold mb-4">Edit Laporan</h2>

        <form action="admin/update_laporan.php" method="POST">

            <input type="hidden" name="id_laporan" id="edit_id">

            <div class="mb-3">
                <label class="block text-sm">Judul</label>
                <input type="text" name="judul" id="edit_judul"
                class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
            </div>

            <div class="mb-3">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi"
                class="w-full border px-3 py-2 rounded bg-gray-100" readonly></textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm">Foto</label>

                <img id="edit_foto"
                class="w-full max-w-xs rounded-lg shadow border hidden">

                <div id="no_foto" class="text-gray-400 text-sm">
                    Tidak ada foto
                </div>
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

function openEditModal(id, judul, deskripsi, status, foto){

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_judul').value = judul;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_status').value = status;

    let img = document.getElementById('edit_foto');
    let noFoto = document.getElementById('no_foto');

    if(foto && foto !== ''){
        img.src = 'upload/laporan/' + foto;

        // fallback kalau beda folder
        img.onerror = function(){
            this.src = 'uploads/laporan/' + foto;
        };

        img.classList.remove('hidden');
        noFoto.style.display = 'none';
    } else {
        img.classList.add('hidden');
        noFoto.style.display = 'block';
    }

    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('editModal').classList.add('hidden');
}
</script>