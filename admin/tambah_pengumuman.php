<?php
include __DIR__ . '/../config/koneksi.php';

if(isset($_POST['simpan'])){

    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);
    $tanggal = date('Y-m-d H:i:s');
    $id_user = $_SESSION['id_user'] ?? 0;

    if(empty($judul) || empty($isi)){
        die("Semua data wajib diisi");
    }

    if($id_user == 0){
        die("User tidak valid (session tidak ditemukan)");
    }

    $sql = mysqli_query($conn,"
        INSERT INTO pengumuman (judul, isi, tanggal, id_user)
        VALUES ('$judul', '$isi', '$tanggal', '$id_user')
    ");

    if(!$sql){
        die(mysqli_error($conn));
    }

    header("Location: index.php?menu=kelola_pengumuman&msg=tambah");
    exit;

    include "admin/tambah_notifikasi.php";

    tambah_notifikasi(
        $conn,
        "Pengumuman: ".$_POST['judul'],
        substr($_POST['isi'], 0, 100) . "..."
    );
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