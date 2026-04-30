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
<div class="flex justify-between items-center mb-4">

    <!-- KIRI -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Kelola Mata Kuliah
        </h2>
        <p class="text-sm text-gray-500">
            Manajemen data mata kuliah dan informasi akademik
        </p>
    </div>

    <!-- KANAN -->
    <a href="index.php?menu=tambah_mata_kuliah"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       + Tambah
    </a>

</div>

<!-- TABLE -->
<div class="bg-white rounded-2xl shadow overflow-hidden">

    <div class="p-4 border-b">
        <h3 class="font-semibold text-gray-700">Data Mata Kuliah</h3>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-4 rounded-2xl shadow flex flex-wrap gap-3">
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
    </div>

    <div class="overflow-x-auto">
    <table class="min-w-full text-sm">

        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
        <tr>
            <th class="px-4 py-3 text-left">Kode</th>
            <th class="px-4 py-3 text-left">Nama</th>
            <th class="px-4 py-3 text-left">SKS</th>
            <th class="px-4 py-3 text-left">Relasi</th>
            <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
        </thead>

        <tbody class="divide-y text-gray-700">

        <?php if(mysqli_num_rows($data)>0){ ?>
        <?php while($d = mysqli_fetch_assoc($data)){ ?>

        <tr class="hover:bg-gray-50 transition">

            <td class="px-4 py-3"><?= $d['kode_mk'] ?></td>
            <td class="px-4 py-3 font-medium"><?= $d['nama_mk'] ?></td>
            <td class="px-4 py-3"><?= $d['sks'] ?></td>

            <td class="px-4 py-3 flex flex-wrap gap-1">

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
                        <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-600">
                            <?= $r['nama_prodi'] ?> (S<?= $r['semester'] ?>)
                        </span>
                    <?php } ?>
                <?php } else { ?>
                    <span class="text-gray-400 text-xs">Belum ada</span>
                <?php } ?>

            </td>

            <td class="px-4 py-3 text-center">
                <div class="flex justify-center gap-2">

                    <a href="index.php?menu=edit_mata_kuliah&id=<?= $d['id_mk'] ?>"
                    class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs hover:bg-yellow-200 transition">
                        Edit
                    </a>

                    <a href="#"
                        onclick="openDeleteModal('index.php?menu=hapus_mata_kuliah&id=<?= $d['id_mk'] ?>', 'Hapus Mata Kuliah?')"
                        class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs hover:bg-red-200 transition">
                        Hapus
                    </a>

                </div>
            </td>

        </tr>

        <?php } ?>
        <?php } else { ?>

        <tr>
            <td colspan="5" class="text-center py-6 text-gray-400">
                Tidak ada data
            </td>
        </tr>

        <?php } ?>

        </tbody>
    </table>
    </div>

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