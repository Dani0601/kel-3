<?php
include __DIR__ . '/../config/koneksi.php';

$id = $_GET['id'] ?? null;

if(!$id){
    die("ID tidak valid");
}

/* cek apakah dipakai di jadwal */
$cek = mysqli_query($conn,"
    SELECT * FROM jadwal WHERE id_ruangan='$id'
");

if(mysqli_num_rows($cek) > 0){
    echo "<script>
    alert('Ruangan masih dipakai di jadwal!');
    window.location.href='../index.php?menu=kelola_ruangan';
    </script>";
    exit;
}

mysqli_query($conn,"
    DELETE FROM ruangan WHERE id_ruangan='$id'
");

echo "<script>
alert('Berhasil dihapus');
window.location.href='../index.php?menu=kelola_ruangan';
</script>";
?>