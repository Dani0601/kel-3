<?php
include __DIR__ . '/../config/koneksi.php';

# ========================
# FILTER
# ========================
$cari = $_GET['cari'] ?? '';

$where = "";
if($cari != ''){
    $where = "WHERE username LIKE '%$cari%'";
}

# ========================
# DATA USER (FIX URUTAN ROLE)
# ========================
$data = mysqli_query($conn,"
SELECT * FROM users
$where
ORDER BY FIELD(role,'admin','dosen','mahasiswa'), id_user ASC
");

# ========================
# CHART ROLE
# ========================
$qRole = mysqli_query($conn,"
SELECT role, COUNT(*) as total
FROM users
GROUP BY role
");

$role = [];
$total_role = [];

while($r = mysqli_fetch_assoc($qRole)){
    $role[] = $r['role'];
    $total_role[] = $r['total'];
}

# ========================
# TOTAL USER
# ========================
$total_user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total FROM users
"))['total'];
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
<form method="GET" class="mb-4 flex gap-2">

<input type="hidden" name="menu" value="kelola_user">

<input type="text" name="cari"
       value="<?= $cari ?>"
       placeholder="Cari username..."
       class="border p-2 rounded">

<button class="bg-green-500 text-white px-4 py-2 rounded">
Cari
</button>

<a href="index.php?menu=kelola_user"
   class="bg-gray-400 text-white px-4 py-2 rounded">
Reset
</a>

</form>

<!-- CHART -->
<div class="grid md:grid-cols-2 gap-6 mb-6">

<div class="bg-white p-4 rounded shadow">
<h4 class="font-semibold mb-2">Distribusi Role</h4>
<canvas id="chartUser"></canvas>
</div>

<div class="bg-white p-4 rounded shadow flex items-center justify-center">
<div class="text-center">
<h1 class="text-3xl font-bold"><?= $total_user ?></h1>
<p>Total User</p>
</div>
</div>

</div>

<!-- TABLE -->
<div class="bg-white rounded shadow overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3">No</th>
<th class="p-3">Username</th>
<th class="p-3">Role</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php $no=1; ?>
<?php if(mysqli_num_rows($data)>0){ ?>
<?php while($u = mysqli_fetch_assoc($data)){ ?>

<tr class="border-b">

<td class="p-3"><?= $no++ ?></td>

<td class="p-3"><?= $u['username'] ?></td>

<td class="p-3">
<span class="
px-2 py-1 rounded
<?= $u['role']=='admin' ? 'bg-red-200' : '' ?>
<?= $u['role']=='dosen' ? 'bg-blue-200' : '' ?>
<?= $u['role']=='mahasiswa' ? 'bg-green-200' : '' ?>
">
<?= $u['role'] ?>
</span>
</td>

<td class="p-3 text-center">

<a href="index.php?menu=edit_user&id=<?= $u['id_user'] ?>">
Edit
</a> |

<a href="index.php?menu=hapus_user&id=<?= $u['id_user'] ?>"
   onclick="return confirm('Yakin hapus user?')"
   class="text-red-500">
Hapus
</a>

</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="4" class="text-center p-6 text-gray-400">
Tidak ada data
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartUser'), {
type: 'pie',
data: {
labels: <?= json_encode($role) ?>,
datasets: [{
data: <?= json_encode($total_role) ?>
}]
}
});
</script>