<?php
require_once __DIR__ . '/../config/koneksi.php';

$gedung = $_GET['gedung'] ?? '';
$lantai = $_GET['lantai'] ?? '';
$search = $_GET['search'] ?? '';
$page   = $_GET['page'] ?? 1;
$limit  = $_GET['limit'] ?? 10;

$offset = ($page - 1) * $limit;

/* ================= WHERE ================= */
$where = "WHERE 1=1";

if($gedung != ''){
    $where .= " AND r.id_gedung = '$gedung'";
}

if($lantai != ''){
    $where .= " AND r.lantai = '$lantai'";
}

if($search != ''){
    $where .= " AND r.nama_ruangan LIKE '%$search%'";
}

/* ================= DATA ================= */
$q = mysqli_query($conn,"
SELECT r.*, g.nama_gedung
FROM ruangan r
JOIN gedung g ON r.id_gedung = g.id_gedung
$where
LIMIT $offset, $limit
");

$data = [];
while($d = mysqli_fetch_assoc($q)){
    $data[] = $d;
}

/* ================= TOTAL ================= */
$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM ruangan r
$where
"))['total'];

/* ================= CHART GEDUNG ================= */
$qGedung = mysqli_query($conn,"
SELECT g.nama_gedung, COUNT(r.id_ruangan) as total
FROM ruangan r
JOIN gedung g ON r.id_gedung = g.id_gedung
$where
GROUP BY r.id_gedung
");

$chartGedungLabel = [];
$chartGedungData = [];

while($g = mysqli_fetch_assoc($qGedung)){
    $chartGedungLabel[] = $g['nama_gedung'];
    $chartGedungData[] = $g['total'];
}

/* ================= CHART KAPASITAS ================= */
$qKap = mysqli_query($conn,"
SELECT r.kapasitas, COUNT(*) as total
FROM ruangan r
$where
GROUP BY r.kapasitas
ORDER BY r.kapasitas ASC
");

$chartKapLabel = [];
$chartKapData = [];

while($k = mysqli_fetch_assoc($qKap)){
    $chartKapLabel[] = $k['kapasitas'];
    $chartKapData[] = $k['total'];
}

/* ================= CHART PIE ================= */
$qPie = mysqli_query($conn,"
SELECT g.nama_gedung, COUNT(r.id_ruangan) as total
FROM ruangan r
JOIN gedung g ON r.id_gedung = g.id_gedung
$where
GROUP BY r.id_gedung
");

$chartPieLabel = [];
$chartPieData = [];

while($p = mysqli_fetch_assoc($qPie)){
    $chartPieLabel[] = $p['nama_gedung'];
    $chartPieData[] = $p['total'];
}

/* ================= OUTPUT ================= */
echo json_encode([
    'data' => $data,
    'total' => $total,

    'chartGedung' => [
        'label' => $chartGedungLabel,
        'data'  => $chartGedungData
    ],

    'chartKap' => [
        'label' => $chartKapLabel,
        'data'  => $chartKapData
    ],

    'chartPie' => [
        'label' => $chartPieLabel,
        'data'  => $chartPieData
    ]
]);