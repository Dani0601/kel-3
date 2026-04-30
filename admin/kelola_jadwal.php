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
    SELECT * FROM tahun_ajaran 
    ORDER BY 
        tahun DESC,
        FIELD(semester,'Ganjil','Genap')
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
    ")
)['total'];

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
    <h2 class="text-2xl font-bold mb-3">Kelola Tahun Ajar</h2>

    <div class="bg-white rounded-2xl shadow overflow-hidden mb-6">

        <div class="p-4">
            <form method="POST" class="flex gap-2 flex-wrap">

                <input type="text" name="tahun"
                placeholder="Contoh: 2025/2026"
                class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>

                <select name="semester"
                class="border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none" required>
                <option value="">Pilih Semester</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
                </select>

                <button name="tambah_tahun"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                + Tambah
                </button>

            </form>
        </div>

        <div class="p-4 border-b">
            <h3 class="font-semibold text-gray-700">Data Tahun Ajar</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Tahun</th>
                        <th class="px-4 py-3 text-center">Semester</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

            <tbody class="divide-y text-gray-700">

                    <?php while($t = mysqli_fetch_assoc($tahun_list)){ ?>

                    <tr class="hover:bg-gray-50 transition text-center">

                        <td class="px-4 py-3 font-medium"><?= $t['tahun'] ?></td>

                        <td class="px-4 py-3">
                            <span class="bg-gray-100 px-2 py-1 rounded-full text-xs">
                                <?= $t['semester'] ?>
                            </span>
                        </td>

                        <td class="px-4 py-3">
                        <?= $t['aktif']
                            ? '<span class="text-green-600 font-semibold">Aktif</span>'
                            : '<span class="text-gray-400">Tidak Aktif</span>' ?>
                        </td>

                        <td class="px-4 py-3">
                            <?php if(!$t['aktif']){ ?>
                                <a href="?menu=kelola_jadwal&aktifkan_tahun=<?= $t['id_tahun_ajar'] ?>"
                                class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-600">
                                Aktifkan
                            </a>
                            <?php } else { ?>
                                <span class="text-green-600 text-xs">✔ Aktif</span>
                            <?php } ?>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
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
<div class="bg-white rounded-2xl shadow overflow-hidden">

<div class="p-4 border-b flex justify-between items-center">
    <h3 class="font-semibold text-gray-700">Data Jadwal</h3>
</div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 text-xs uppercase text-gray-600">
<tr>
<th class="px-4 py-3 text-left">Hari</th>
<th class="px-4 py-3 text-center">Jam</th>
<th class="px-4 py-3 text-left">Ruangan</th>
<th class="px-4 py-3 text-left">Mata Kuliah</th>
<th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>

<tbody class="divide-y text-gray-700">

<?php if(mysqli_num_rows($data) > 0){ ?>
<?php while($row = mysqli_fetch_assoc($data)) { ?>

<tr class="hover:bg-gray-50 transition">

<td class="px-4 py-3 font-medium">
<?= $row['hari'] ?>
</td>

<td class="px-4 py-3 text-center">
<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">
<?= $row['jam_mulai'] ?> - <?= $row['jam_selesai'] ?>
</span>
</td>

<td class="px-4 py-3">
<?= $row['nama_ruangan'] ?>
</td>

<td class="px-4 py-3 font-semibold">
<?= $row['nama_mk'] ?>
</td>

<td class="p-3 text-center">
<div class="flex justify-center gap-2">

<a href="index.php?menu=edit_jadwal&id=<?= $row['id_jadwal'] ?>"
class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs hover:bg-yellow-200 transition">
Edit
</a>

<a href="index.php?menu=hapus_jadwal&id=<?= $row['id_jadwal'] ?>"
onclick="return confirm('Yakin hapus?')"
class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
Hapus
</a>

</div>
</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="5" class="text-center py-10 text-gray-400">
<div class="flex flex-col items-center gap-2">
<span class="text-2xl">📭</span>
<span>Tidak ada data jadwal</span>
</div>
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>
</div>