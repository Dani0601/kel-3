<?php
include __DIR__ . '/../config/koneksi.php';

$id = $_GET['id'] ?? 0;

$data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM pengumuman WHERE id_pengumuman='$id'
"));

if(!$data){
    die("Data tidak ditemukan");
}

if(isset($_POST['update'])){

    $judul = $_POST['judul'];
    $isi = $_POST['isi'];

    $sql = mysqli_query($conn,"
        UPDATE pengumuman SET
        judul='$judul',
        isi='$isi'
        WHERE id_pengumuman='$id'
    ");

    if(!$sql){
        die(mysqli_error($conn));
    }

    echo "<script>
    alert('Pengumuman berhasil diupdate');
    location='index.php?menu=kelola_pengumuman';
    </script>";
}
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Edit Pengumuman</h2>

<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

<input type="text"
       name="judul"
       value="<?= $data['judul'] ?>"
       class="w-full border p-2 rounded"
       required>

<textarea name="isi"
          class="w-full border p-2 rounded"
          rows="5"
          required><?= $data['isi'] ?></textarea>

<button name="update"
        class="bg-green-500 text-white px-4 py-2 rounded">
    Update
</button>

</form>

</div>