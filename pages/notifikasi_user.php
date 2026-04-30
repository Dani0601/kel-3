<?php
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'];

$hariMap = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu'
];

$today = $hariMap[date('l')];

// ==========================
// AMBIL JADWAL SESUAI ROLE
// ==========================

if($role == 'dosen'){

    $jadwal = $conn->query("
        SELECT j.*, mk.nama_mk
        FROM jadwal j
        JOIN dosen d ON j.id_dosen = d.id_dosen
        JOIN users u ON d.id_user = u.id_user
        JOIN mk_prodi mp ON j.id_mk_prodi = mp.id_mk_prodi
        JOIN mata_kuliah mk ON mp.id_mk = mk.id_mk
        WHERE u.id_user = '$id_user'
        AND LOWER(j.hari) = LOWER('$today')
    ");

}
else if($role == 'mahasiswa'){

    $jadwal = $conn->query("
        SELECT j.*, mk.nama_mk
        FROM jadwal j
        JOIN kelas k ON j.id_kelas = k.id_kelas
        JOIN mahasiswa m ON m.id_kelas = k.id_kelas
        JOIN users u ON m.id_user = u.id_user
        JOIN mk_prodi mp ON j.id_mk_prodi = mp.id_mk_prodi
        JOIN mata_kuliah mk ON mp.id_mk = mk.id_mk
        WHERE u.id_user = '$id_user'
        AND j.hari = '$today'
    ");

}

// ==========================
// AUTO NOTIF JADWAL
// ==========================

while($j = $jadwal->fetch_assoc()){

    $judul = "Jadwal Hari Ini";
    $pesan = $j['nama_mk']." (".$j['jam_mulai']." - ".$j['jam_selesai'].")";

    // cek duplikat
    $cek = $conn->query("
        SELECT 1
        FROM notifikasi n
        JOIN notifikasi_user nu ON n.id_notifikasi = nu.id_notifikasi
        WHERE nu.id_user = '$id_user'
        AND n.pesan = '$pesan'
        AND DATE(n.created_at) = CURDATE()
    ");

    if($cek->num_rows == 0){

        $conn->query("
            INSERT INTO notifikasi (judul, pesan, created_at, status)
            VALUES ('$judul', '$pesan', NOW(), 'aktif')
        ");

        $id_notif = $conn->insert_id;

        $conn->query("
            INSERT INTO notifikasi_user (id_notifikasi, id_user, status_dibaca)
            VALUES ('$id_notif', '$id_user', 0)
        ");
    }
}

// ==========================
// AMBIL NOTIF
// ==========================

$data = $conn->query("
    SELECT n.*, nu.status_dibaca
    FROM notifikasi n
    JOIN notifikasi_user nu ON n.id_notifikasi = nu.id_notifikasi
    WHERE nu.id_user = '$id_user'
    AND n.status = 'aktif'
    ORDER BY n.id_notifikasi DESC
");
?>

<div class="flex flex-col gap-4">

<?php if($data && $data->num_rows > 0){ ?>

<?php while($d = $data->fetch_assoc()){ ?>

<a href="index.php?menu=detail_notif&id=<?= $d['id_notifikasi'] ?>">

<div class="bg-white p-4 rounded-xl shadow hover:shadow-md cursor-pointer">

    <div class="flex justify-between items-start">

        <h3 class="font-semibold text-gray-800">
            <?= htmlspecialchars($d['judul']) ?>
        </h3>

        <?php if($d['status_dibaca'] == 0): ?>
        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
            Baru
        </span>
        <?php endif; ?>

    </div>

    <p class="text-sm text-gray-600 mt-1">
        <?= htmlspecialchars($d['pesan']) ?>
    </p>

</div>

</a>

<?php } ?>

<?php } else { ?>

<div class="text-center text-gray-400 py-10">
    Tidak ada notifikasi
</div>

<?php } ?>

</div>