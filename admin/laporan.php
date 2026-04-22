<?php
include "config/koneksi.php";

$data = $conn->query("
SELECT l.*, u.username, r.nama_ruangan 
FROM laporan_fasilitas l
LEFT JOIN users u ON l.id_user = u.id_user
LEFT JOIN ruangan r ON l.id_ruangan = r.id_ruangan
ORDER BY l.tanggal DESC
");

// statistik
$laporan = $conn->query("
SELECT 
COUNT(*) as total,
SUM(status='pending') as pending,
SUM(status='proses') as proses,
SUM(status='selesai') as selesai
FROM laporan_fasilitas
")->fetch_assoc();
?>

<h2 class="text-xl font-bold mb-4">Kelola Laporan</h2>

<!-- STATISTIK -->
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

<!-- TABLE -->
<table class="w-full bg-white shadow rounded-lg">
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
<?php $no=1; while($d=$data->fetch_assoc()){ ?>
<tr class="border-t">
<td class="p-2"><?= $no++ ?></td>
<td><?= $d['judul'] ?></td>
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

<!-- DETAIL -->
<a href="?menu=detail_laporan&id=<?= $d['id_laporan'] ?>" 
class="text-green-500">Detail</a>

<!-- EDIT (MODAL) -->
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

<!-- HAPUS -->
<a href="admin/hapus_laporan.php?id=<?= $d['id_laporan'] ?>" 
onclick="return confirm('Hapus data?')" 
class="text-red-500">Hapus</a>

</td>

</tr>
<?php } ?>
</tbody>
</table>


<!-- ================= MODAL EDIT ================= -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg">

        <h2 class="text-xl font-bold mb-4">Edit Laporan</h2>

        <form action="admin/update_laporan.php" method="POST">

            <input type="hidden" name="id_laporan" id="edit_id">

            <!-- JUDUL -->
            <div class="mb-3">
                <label class="block text-sm">Judul</label>
                <input type="text" name="judul" id="edit_judul"
                class="w-full border px-3 py-2 rounded-lg">
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-3">
                <label class="block text-sm">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi"
                class="w-full border px-3 py-2 rounded-lg"></textarea>
            </div>

            <!-- STATUS -->
            <div class="mb-4">
                <label class="block text-sm">Status</label>
                <select name="status" id="edit_status"
                class="w-full border px-3 py-2 rounded-lg">
                    <option value="pending">Pending</option>
                    <option value="proses">Proses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()"
                class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                Batal
                </button>

                <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Simpan
                </button>
            </div>

        </form>

    </div>

</div>


<!-- ================= JS ================= -->
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