<?php
include __DIR__ . '/../config/koneksi.php';

$id = $_GET['id'] ?? 0;

if($id == 0){
    die("ID tidak valid");
}

$hapus = mysqli_query($conn,"
    DELETE FROM pengumuman
    WHERE id_pengumuman='$id'
");

if(!$hapus){
    die(mysqli_error($conn));
}

echo "<script>
alert('Berhasil dihapus');
location='index.php?menu=kelola_pengumuman';
</script>";
?>