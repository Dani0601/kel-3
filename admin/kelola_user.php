<?php
include __DIR__ . '/../config/koneksi.php';

/* ========================
   FILTER
======================== */
$cari = $_GET['cari'] ?? '';
$role_filter = $_GET['role'] ?? '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

/* ========================
   WHERE BUILDER
======================== */
$where = "WHERE 1=1";

if (!empty($cari)) {
    $cari = mysqli_real_escape_string($conn, $cari);
    $where .= " AND username LIKE '%$cari%'";
}

if (!empty($role_filter)) {
    $role_filter = mysqli_real_escape_string($conn, $role_filter);
    $where .= " AND role='$role_filter'";
}

/* ========================
   DATA USER
======================== */
$data = mysqli_query($conn, "
SELECT * FROM users
$where
ORDER BY FIELD(role,'admin','dosen','mahasiswa'), id_user ASC
LIMIT $limit OFFSET $offset
");

/* ========================
   TOTAL DATA
======================== */
$totalData = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) as total FROM users $where
"))['total'];

$totalPage = ceil($totalData / $limit);

/* ========================
   TOTAL USER (FILTER)
======================== */
$total_user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total FROM users
$where
"))['total'];

/* ========================
   CHART ROLE (FIXED ORDER + COLOR)
======================== */
$roles = ['admin', 'dosen', 'mahasiswa'];
$colors = [
    'admin' => '#3b82f6',      // biru
    'dosen' => '#ef4444',      // merah
    'mahasiswa' => '#f97316'   // oranye
];

$role_count = [
    'admin' => 0,
    'dosen' => 0,
    'mahasiswa' => 0
];

$qRole = mysqli_query($conn,"
SELECT role, COUNT(*) as total
FROM users
$where
GROUP BY role
");

while ($r = mysqli_fetch_assoc($qRole)) {
    $role_count[$r['role']] = $r['total'];
}

/* ========================
   DATA UNTUK CHART
======================== */
$chart_labels = [];
$chart_data = [];
$chart_colors = [];

foreach ($roles as $r) {
    $chart_labels[] = $r;
    $chart_data[] = $role_count[$r];
    $chart_colors[] = $colors[$r];
}
?>

<div class="p-6">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Kelola User</h2>
        <p class="text-sm text-gray-500">Manajemen pengguna sistem</p>
    </div>

    <a href="index.php?menu=tambah_user"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       + Tambah User
    </a>
</div>

<!-- FILTER -->
<form method="GET" class="mb-4 flex gap-2 flex-wrap">

<input type="hidden" name="menu" value="kelola_user">

<input type="text" name="cari"
       value="<?= htmlspecialchars($cari) ?>"
       placeholder="Cari username..."
       class="border p-2 rounded">

<select name="role" class="border p-2 rounded">
    <option value="">Semua Role</option>
    <option value="admin" <?= $role_filter=='admin'?'selected':'' ?>>Admin</option>
    <option value="dosen" <?= $role_filter=='dosen'?'selected':'' ?>>Dosen</option>
    <option value="mahasiswa" <?= $role_filter=='mahasiswa'?'selected':'' ?>>Mahasiswa</option>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">Cari</button>

<a href="index.php?menu=kelola_user"
   class="bg-gray-400 text-white px-4 py-2 rounded">Reset</a>

</form>

<!-- CHART -->
<div class="grid md:grid-cols-2 gap-6 mb-6">

<div class="bg-white p-4 rounded shadow">
    <h4 class="font-semibold mb-2">Distribusi Role</h4>

    <div style="max-width: 260px; height: 220px; margin:auto;">
        <canvas id="chartUser"></canvas>
    </div>
</div>

<div class="bg-white p-4 rounded shadow flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-3xl font-bold"><?= $total_user ?></h1>
        <p>Total User</p>
    </div>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="p-4 border-b">
      <h3 class="font-semibold text-gray-700">Data User</h3>
   </div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 text-xs uppercase text-gray-600">
<tr>
<th class="px-4 py-3">No</th>
<th class="px-4 py-3">Username</th>
<th class="px-4 py-3">Role</th>
<th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y text-gray-700">

<?php $no=$offset+1; ?>
<?php while($u = mysqli_fetch_assoc($data)) { ?>

<tr class="hover:bg-gray-50 transition">

<td class="px-4 py-3"><?= $no++ ?></td>

<td class="px-4 py-3 font-medium">
<?= htmlspecialchars($u['username']) ?>
</td>

<td class="px-4 py-3">
<span class="px-2 py-1 rounded-full text-xs 
<?= $u['role']=='admin'?'bg-blue-100 text-blue-600':'' ?>
<?= $u['role']=='dosen'?'bg-red-100 text-red-600':'' ?>
<?= $u['role']=='mahasiswa'?'bg-orange-100 text-orange-600':'' ?>">
<?= $u['role'] ?>
</span>
</td>

<td class="p-3 text-center">
<div class="flex justify-center gap-2">

<a href="index.php?menu=edit_user&id=<?= $u['id_user'] ?>"
class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs hover:bg-yellow-200 transition">

Edit
</a>

<a href="index.php?menu=hapus_user&id=<?= $u['id_user'] ?>"
onclick="return confirm('Yakin hapus?')"
class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
Hapus
</a>

</div>
</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>
</div>
<!-- PAGINATION -->
<div class="mt-4 flex gap-2">
<?php for($i=1;$i<=$totalPage;$i++): ?>
<a href="index.php?menu=kelola_user&page=<?= $i ?>&cari=<?= $cari ?>&role=<?= $role_filter ?>"
   class="px-3 py-1 border rounded <?= $i==$page?'bg-blue-500 text-white':'' ?>">
   <?= $i ?>
</a>
<?php endfor; ?>
</div>

</div>

<!-- CHART SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartUser'), {
    type: 'pie',
    data: {
        labels: <?= json_encode($chart_labels) ?>,
        datasets: [{
            data: <?= json_encode($chart_data) ?>,
            backgroundColor: <?= json_encode($chart_colors) ?>
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>