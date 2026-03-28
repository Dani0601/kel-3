<?php
$id = $_GET['id'];
$id_user = $_SESSION['id_user'];

$conn->query("
UPDATE notifikasi_user 
SET status_dibaca=1
WHERE id_notifikasi='$id' AND id_user='$id_user'
");

$data = $conn->query("
SELECT * FROM notifikasi WHERE id_notifikasi='$id'
")->fetch_assoc();
?>

<h3><?= $data['judul'] ?></h3>
<p><?= $data['pesan'] ?></p>