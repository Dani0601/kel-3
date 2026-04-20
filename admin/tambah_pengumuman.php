<?php
include __DIR__ . '/../config/koneksi.php';

if(isset($_POST['simpan'])){

    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d');

    if(empty($judul) || empty($isi)){
        die("Semua data wajib diisi");
    }

    $sql = mysqli_query($conn,"
        INSERT INTO pengumuman (judul, isi, tanggal)
        VALUES ('$judul', '$isi', '$tanggal')
    ");

    if(!$sql){
        die(mysqli_error($conn));
    }

    echo "<script>
    alert('Pengumuman berhasil ditambahkan');
    location='index.php?menu=kelola_pengumuman';
    </script>";
}
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Tambah Pengumuman</h2>

<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

<input type="text"
       name="judul"
       placeholder="Judul Pengumuman"
       class="w-full border p-2 rounded"
       required>

<textarea name="isi"
          placeholder="Isi pengumuman..."
          class="w-full border p-2 rounded"
          rows="5"
          required></textarea>

<button name="simpan"
        class="bg-blue-500 text-white px-4 py-2 rounded">
    Simpan
</button>

</form>

</div>