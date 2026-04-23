<?php
include __DIR__ . '/../config/koneksi.php';

// AMBIL ID DENGAN AMAN
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// VALIDASI ID
if($id <= 0){
    echo "<script>
    alert('ID tidak valid');
    location='index.php?menu=kelola_pengumuman';
    </script>";
    exit;
}

// CEK DATA ADA ATAU TIDAK
$cek = mysqli_query($conn,"
    SELECT * FROM pengumuman WHERE id_pengumuman='$id'
");

if(mysqli_num_rows($cek) == 0){
    echo "<script>
    alert('Data tidak ditemukan');
    location='index.php?menu=kelola_pengumuman';
    </script>";
    exit;
}

// HAPUS DATA
$hapus = mysqli_query($conn,"
    DELETE FROM pengumuman
    WHERE id_pengumuman='$id'
");

if(!$hapus){
    echo "<script>
    alert('Gagal menghapus');
    location='index.php?menu=kelola_pengumuman';
    </script>";
    exit;
}

// SUKSES
echo "<script>
alert('Pengumuman berhasil dihapus');
location='index.php?menu=kelola_pengumuman';
</script>";