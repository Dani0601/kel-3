<?php
include __DIR__ . '/../config/koneksi.php';

if(isset($_POST['simpan'])){

    $id_ruangan = $_POST['id_ruangan'];
    $id_gedung = $_POST['id_gedung'];
    $nama = $_POST['nama_ruangan'];
    $kapasitas = $_POST['kapasitas'];

    if(empty($id_ruangan) || empty($id_gedung) || empty($nama) || empty($kapasitas)){
        die("Semua data wajib diisi");
    }

    $sql = mysqli_query($conn,"
        INSERT INTO ruangan
        (id_ruangan, id_gedung, nama_ruangan, kapasitas)
        VALUES
        ('$id_ruangan', '$id_gedung', '$nama', '$kapasitas')
    ");

    if(!$sql){
        die("Error: " . mysqli_error($conn));
    }

    echo "<script>
    alert('Ruangan berhasil ditambahkan');
    location='index.php?menu=kelola_ruangan';
    </script>";
}

/* GEDUNG */
$gedung = mysqli_query($conn,"SELECT * FROM gedung");

/* RUANGAN */
$ruangan = mysqli_query($conn,"
    SELECT r.*, g.nama_gedung
    FROM ruangan r
    LEFT JOIN gedung g ON r.id_gedung = g.id_gedung
");
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Kelola Ruangan (Manual ID)</h2>

<!-- FORM -->
<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

    <input type="number"
           name="id_ruangan"
           placeholder="ID Ruangan (manual)"
           class="w-full border p-2 rounded"
           required>

    <select name="id_gedung" class="w-full border p-2 rounded" required>
        <option value="">Pilih Gedung</option>
        <?php while($g = mysqli_fetch_assoc($gedung)){ ?>
            <option value="<?= $g['id_gedung'] ?>">
                <?= $g['nama_gedung'] ?>
            </option>
        <?php } ?>
    </select>

    <input type="text"
           name="nama_ruangan"
           placeholder="Nama Ruangan"
           class="w-full border p-2 rounded"
           required>

    <input type="number"
           name="kapasitas"
           placeholder="Kapasitas"
           class="w-full border p-2 rounded"
           required>

    <button name="simpan"
            class="bg-blue-500 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>


</div>