<?php
include __DIR__ . '/../config/koneksi.php';

$search = $_GET['search'] ?? '';
$limit  = $_GET['limit'] ?? 10;
$page   = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

$where = "WHERE 1=1";

if($search != ''){
    $search = mysqli_real_escape_string($conn,$search);
    $where .= " AND (
        mk.kode_mk LIKE '%$search%' OR
        mk.nama_mk LIKE '%$search%'
    )";
}

/* ================= TOTAL ================= */
$total = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT COUNT(*) as total 
    FROM mata_kuliah mk
    $where
"))['total'];

$total_page = ceil($total / $limit);

/* ================= DATA ================= */
$data = mysqli_query($conn,"
SELECT 
    mk.*,
    COUNT(mp.id_mk_prodi) as total_relasi
FROM mata_kuliah mk
LEFT JOIN mk_prodi mp ON mk.id_mk = mp.id_mk
$where
GROUP BY mk.id_mk
ORDER BY mk.id_mk DESC
LIMIT $limit OFFSET $offset
");
?>

<div class="p-6">

<!-- HEADER -->
<div class="flex justify-between mb-4">
    <h2 class="text-2xl font-bold">Kelola Mata Kuliah</h2>

    <a href="index.php?menu=tambah_mata_kuliah"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       + Tambah
    </a>
</div>

<!-- FILTER -->
<form method="GET" class="flex gap-2 mb-4">
<input type="hidden" name="menu" value="kelola_mata_kuliah">

<input type="text" name="search"
value="<?= $search ?>"
placeholder="Cari kode / nama MK..."
class="border p-2 rounded w-64">

<select name="limit" class="border p-2 rounded">
<?php foreach([5,10,20,50] as $l){ ?>
<option value="<?= $l ?>" <?= ($limit==$l?'selected':'') ?>>
<?= $l ?>
</option>
<?php } ?>
</select>

<button class="bg-green-500 text-white px-4 py-2 rounded">
Filter
</button>
</form>

<!-- TABLE -->
<div class="bg-white shadow rounded overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3">Kode</th>
<th class="p-3">Nama</th>
<th class="p-3">SKS</th>
<th class="p-3">Relasi</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data)>0){ ?>
<?php while($d = mysqli_fetch_assoc($data)){ ?>

<tr class="border-b align-top">

<td class="p-3"><?= $d['kode_mk'] ?></td>
<td class="p-3"><?= $d['nama_mk'] ?></td>
<td class="p-3"><?= $d['sks'] ?></td>

<td class="p-3">

<?php
$relasi = mysqli_query($conn,"
    SELECT p.nama_prodi, mp.semester
    FROM mk_prodi mp
    JOIN prodi p ON mp.id_prodi = p.id_prodi
    WHERE mp.id_mk='".$d['id_mk']."'
");
?>

<?php if(mysqli_num_rows($relasi)>0){ ?>
<?php while($r = mysqli_fetch_assoc($relasi)){ ?>

<div class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded mb-1 inline-block">
<?= $r['nama_prodi'] ?> (S<?= $r['semester'] ?>)
</div>

<?php } ?>
<?php } else { ?>

<span class="text-gray-400 text-xs">Belum ada</span>

<?php } ?>

</td>

<td class="p-3 text-center">

<a href="index.php?menu=edit_mata_kuliah&id=<?= $d['id_mk'] ?>">
Edit
</a> |

<a href="index.php?menu=hapus_mata_kuliah&id=<?= $d['id_mk'] ?>"
onclick="return confirm('Hapus MK beserta relasi?')"
class="text-red-500">
Hapus
</a>

</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="5" class="text-center p-4 text-gray-400">
Tidak ada data
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- PAGINATION -->
<div class="flex justify-center mt-4 gap-2">
<?php for($i=1;$i<=$total_page;$i++){ ?>
<a href="index.php?menu=kelola_mata_kuliah&page=<?= $i ?>&limit=<?= $limit ?>&search=<?= $search ?>"
class="px-3 py-1 border rounded <?= ($i==$page?'bg-blue-500 text-white':'') ?>">
<?= $i ?>
</a>
<?php } ?>
</div>

</div>