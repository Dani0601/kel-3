<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'] ?? 0;

/* ================= AMBIL DATA RUANGAN ================= */
$q = mysqli_query($conn,"
    SELECT * FROM ruangan WHERE id_ruangan='$id'
");

$data = mysqli_fetch_assoc($q);

if(!$data){
    die("Data ruangan tidak ditemukan");
}

/* ================= GEDUNG ================= */
$gedung = mysqli_query($conn,"SELECT * FROM gedung");

/* ================= UPDATE ================= */
if(isset($_POST['update'])){

    $id_gedung = $_POST['id_gedung'];
    $nama = $_POST['nama_ruangan'];
    $kapasitas = $_POST['kapasitas'];

    if(empty($id_gedung) || empty($nama) || empty($kapasitas)){
        die("Semua data wajib diisi");
    }

    $sql = mysqli_query($conn,"
        UPDATE ruangan SET
        id_gedung='$id_gedung',
        nama_ruangan='$nama',
        kapasitas='$kapasitas'
        WHERE id_ruangan='$id'
    ");

    if(!$sql){
        die("Error update: " . mysqli_error($conn));
    }

    echo "<script>
    alert('Ruangan berhasil diupdate');
    location='index.php?menu=kelola_ruangan';
    </script>";
}
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Edit Ruangan</h2>

<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

    <!-- GEDUNG -->
    <select name="id_gedung" class="w-full border p-2 rounded" required>
        <option value="">Pilih Gedung</option>

        <?php while($g = mysqli_fetch_assoc($gedung)){ ?>
            <option value="<?= $g['id_gedung'] ?>"
                <?= $data['id_gedung'] == $g['id_gedung'] ? 'selected' : '' ?>>
                <?= $g['nama_gedung'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- NAMA RUANGAN -->
    <input type="text"
           name="nama_ruangan"
           value="<?= $data['nama_ruangan'] ?>"
           class="w-full border p-2 rounded"
           required>

    <!-- KAPASITAS -->
    <input type="number"
           name="kapasitas"
           value="<?= $data['kapasitas'] ?>"
           class="w-full border p-2 rounded"
           required>

    <button name="update"
            class="bg-green-500 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

</div>