<?php
include __DIR__ . '/../config/koneksi.php';

# ========================
# TAMBAH TAHUN AJAR
# ========================
if(isset($_POST['tambah_tahun'])){
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);

    if($tahun == '' || $semester == ''){
        echo "<script>alert('Data tidak boleh kosong');</script>";
    }else{

        $cek = mysqli_query($conn,"
            SELECT * FROM tahun_ajaran 
            WHERE tahun='$tahun' AND semester='$semester'
        ");

        if(mysqli_num_rows($cek) > 0){
            echo "<script>alert('Tahun ajar sudah ada');</script>";
        }else{
            mysqli_query($conn,"
                INSERT INTO tahun_ajaran (tahun, semester, aktif)
                VALUES('$tahun','$semester',0)
            ");

            echo "<script>alert('Berhasil ditambahkan');location='index.php?menu=kelola_jadwal';</script>";
            exit;
        }
    }
}

# ========================
# KELOLA TAHUN AJAR
# ========================
$tahun_list = mysqli_query($conn,"
    SELECT * FROM tahun_ajaran ORDER BY id_tahun_ajar DESC
");

if(isset($_GET['aktifkan_tahun'])){
    $id = $_GET['aktifkan_tahun'];

    mysqli_query($conn,"UPDATE tahun_ajaran SET aktif=0");
    mysqli_query($conn,"UPDATE tahun_ajaran SET aktif=1 WHERE id_tahun_ajar='$id'");

    echo "<script>location='index.php?menu=kelola_jadwal';</script>";
    exit;
}

$tahun_aktif = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM tahun_ajaran WHERE aktif=1
"));

$id_tahun_aktif = $tahun_aktif['id_tahun_ajar'] ?? 0;

if(!$id_tahun_aktif){
    echo "<div class='p-6 text-red-500'>❌ Tidak ada tahun ajar aktif</div>";
    return;
}

# ========================
# FILTER + SEARCH
# ========================
$filter_hari = $_GET['hari'] ?? '';
$search = $_GET['search'] ?? '';

# ========================
# PAGINATION
# ========================
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

# ========================
# WHERE
# ========================
$where = "WHERE j.id_tahun_ajar='$id_tahun_aktif'";

if($filter_hari != ''){
    $where .= " AND j.hari = '$filter_hari'";
}

if($search != ''){
    $search = mysqli_real_escape_string($conn, $search);
    $where .= " AND (
        mk.nama_mk LIKE '%$search%' 
        OR r.nama_ruangan LIKE '%$search%'
        OR j.hari LIKE '%$search%'
    )";
}

# ========================
# TOTAL DATA
# ========================
$total_data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
JOIN mk_prodi mp ON j.id_mk_prodi = mp.id_mk_prodi
JOIN mata_kuliah mk ON mp.id_mk = mk.id_mk
$where
"))['total'];

$total_page = ceil($total_data / $limit);

# ========================
# DATA
# ========================
$data = mysqli_query($conn, "
SELECT 
    j.*, 
    r.nama_ruangan,
    mk.nama_mk
FROM jadwal j
JOIN ruangan r ON j.id_ruangan = r.id_ruangan
JOIN mk_prodi mp ON j.id_mk_prodi = mp.id_mk_prodi
JOIN mata_kuliah mk ON mp.id_mk = mk.id_mk
$where
ORDER BY 
FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),
j.jam_mulai ASC
LIMIT $limit OFFSET $offset
");
?>

<div class="p-6">

<!-- ================= TAHUN AJAR ================= -->
<div class="bg-white p-4 rounded shadow mb-6">

<h3 class="font-bold text-lg mb-3">Kelola Tahun Ajar</h3>

<!-- FORM TAMBAH -->
<form method="POST" class="mb-4 flex gap-2 flex-wrap">

<input type="text" name="tahun"
placeholder="Contoh: 2025/2026"
class="border p-2 rounded" required>

<select name="semester" class="border p-2 rounded" required>
<option value="">Pilih Semester</option>
<option value="Ganjil">Ganjil</option>
<option value="Genap">Genap</option>
</select>

<button name="tambah_tahun"
class="bg-green-500 text-white px-4 py-2 rounded">
+ Tambah
</button>

</form>

<!-- TABEL -->
<table class="w-full text-sm border">
<thead class="bg-gray-100">
<tr>
<th class="p-2 border">Tahun</th>
<th class="p-2 border">Semester</th>
<th class="p-2 border">Status</th>
<th class="p-2 border text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php while($t = mysqli_fetch_assoc($tahun_list)){ ?>

<tr class="text-center border-b">

<td class="p-2"><?= $t['tahun'] ?></td>
<td class="p-2"><?= $t['semester'] ?></td>

<td class="p-2">
<?= $t['aktif'] 
? '<span class="text-green-600 font-semibold">Aktif</span>' 
: '<span class="text-gray-400">Tidak Aktif</span>' ?>
</td>

<td class="p-2">

<?php if(!$t['aktif']){ ?>
<a href="?menu=kelola_jadwal&aktifkan_tahun=<?= $t['id_tahun_ajar'] ?>"
class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
Aktifkan
</a>
<?php } else { ?>
<span class="text-green-600 text-xs">✔ Sedang Aktif</span>
<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

<!-- ================= HEADER ================= -->
<div class="flex justify-between items-center mb-6">
<div>
<h2 class="text-2xl font-bold">Kelola Jadwal</h2>
<p class="text-sm text-gray-500">Manajemen jadwal ruangan</p>
</div>

<a href="index.php?menu=tambah_jadwal"
class="bg-blue-500 text-white px-4 py-2 rounded">
+ Tambah Jadwal
</a>
</div>

<!-- INFO -->
<div class="mb-4 text-sm text-gray-600">
Tahun Ajar Aktif:
<b><?= $tahun_aktif['tahun'] ?> (<?= $tahun_aktif['semester'] ?>)</b>
</div>

<!-- ================= TABLE JADWAL ================= -->
<div class="bg-white rounded shadow overflow-hidden">

<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-3">Hari</th>
<th class="p-3">Jam</th>
<th class="p-3">Ruangan</th>
<th class="p-3">Mata Kuliah</th>
<th class="p-3 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data) > 0){ ?>
<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr class="border-b">

<td class="p-3"><?= $row['hari'] ?></td>
<td class="p-3"><?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?></td>
<td class="p-3"><?= $row['nama_ruangan'] ?></td>
<td class="p-3"><?= $row['nama_mk'] ?></td>

<td class="p-3 text-center">
<a href="index.php?menu=edit_jadwal&id=<?= $row['id_jadwal'] ?>">Edit</a> |
<a href="index.php?menu=hapus_jadwal&id=<?= $row['id_jadwal'] ?>"
onclick="return confirm('Yakin hapus?')"
class="text-red-500">Hapus</a>
</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="5" class="text-center p-6 text-gray-400">
Tidak ada data
</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

</div>