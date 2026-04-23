<?php
include __DIR__ . '/../config/koneksi.php';

$id = intval($_GET['id'] ?? 0);

// DEBUG (boleh dihapus nanti)
if($id <= 0){
    die("ID tidak valid / tidak terkirim");
}

$query = mysqli_query($conn,"
    SELECT * FROM pengumuman WHERE id_pengumuman='$id'
");

$data = mysqli_fetch_assoc($query);

if(!$data){
    die("Data tidak ditemukan di database");
}

// ================= UPDATE =================
if(isset($_POST['update'])){

    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);

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
       value="<?= htmlspecialchars($data['judul']) ?>"
       class="w-full border p-2 rounded"
       required>

<textarea name="isi"
          class="w-full border p-2 rounded"
          rows="5"
          required><?= htmlspecialchars($data['isi']) ?></textarea>

<button name="update"
        class="bg-green-500 text-white px-4 py-2 rounded">
    Update
</button>

</form>

</div>