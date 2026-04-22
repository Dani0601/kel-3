<?php
require_once __DIR__ . '/../config/koneksi.php';

$q = mysqli_query($conn,"SELECT * FROM gedung ORDER BY id_gedung ASC");

$data = [];

while($d = mysqli_fetch_assoc($q)){
    $data[] = $d;
}

echo json_encode($data);