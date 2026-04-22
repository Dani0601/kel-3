<?php
include "config/koneksi.php";

$id_user = $_SESSION['id_user'] ?? 0;

$role = $_SESSION['role'] ?? '';

$data_user = [
    'nama' => '',
    'nim'  => ''
];

if($role == "mahasiswa"){
    $q = $conn->query("
        SELECT nama_mahasiswa AS nama, nim 
        FROM mahasiswa 
        WHERE id_user = '$id_user'
    ");
    $data_user = $q->fetch_assoc();
}
elseif($role == "dosen"){
    $q = $conn->query("
        SELECT nama_dosen AS nama, nidn AS nim 
        FROM dosen 
        WHERE id_user = '$id_user'
    ");
    $data_user = $q->fetch_assoc();
}

// ambil data ruangan
$ruangan = $conn->query("SELECT * FROM ruangan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Laporan Fasilitas</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg">

    <!-- TITLE -->
    <h2 class="text-2xl font-bold text-gray-700 mb-6 text-center">
        📝 Form Laporan Fasilitas
    </h2>

    <!-- ALERT -->
    <?php if(isset($_GET['success'])){ ?>
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
        ✅ Laporan berhasil dikirim!
    </div>
    <?php } ?>

    <?php if(isset($_GET['error'])){ ?>
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
        ❌ Gagal mengirim laporan!
    </div>
    <?php } ?>

    <!-- FORM -->
    <form action="pages/proses_laporan.php" method="POST" enctype="multipart/form-data" class="space-y-5">

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-600 mb-1">Nama</label>
                <input type="text"
                value="<?= $data_user['nama'] ?>"
                readonly
                class="w-full border rounded-lg px-3 py-2 bg-gray-100">
            </div>

            <div>
                <label class="block text-gray-600 mb-1">
                    <?= ($role == "dosen") ? "NIDN" : "NIM" ?>
                </label>
                <input type="text"
                value="<?= $data_user['nim'] ?>"
                readonly
                class="w-full border rounded-lg px-3 py-2 bg-gray-100">
            </div>
        </div>

        <!-- RUANGAN -->
        <div>
            <label class="block text-gray-600 mb-1">Pilih Ruangan</label>
            <select name="id_ruangan" required
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                <option value="">-- Pilih Ruangan --</option>
                <?php while($r = $ruangan->fetch_assoc()){ ?>
                    <option value="<?= $r['id_ruangan'] ?>">
                        <?= $r['nama_ruangan'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- JENIS -->
        <div>
            <label class="block text-gray-600 mb-1">Jenis Laporan</label>
            <input type="text" name="jenis" required
            placeholder="Contoh: Proyektor rusak"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <!-- DESKRIPSI -->
        <div>
            <label class="block text-gray-600 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4" required
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none"
            placeholder="Jelaskan kerusakan fasilitas..."></textarea>
        </div>

        <!-- FOTO -->
        <div>
            <label class="block text-gray-600 mb-1">Upload Foto</label>
            <input type="file" name="foto" required
            class="w-full border rounded-lg px-3 py-2 bg-gray-50">
        </div>

        <!-- BUTTON -->
        <div class="text-center">
            <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                🚀 Kirim Laporan
            </button>
        </div>

    </form>
</div>

<!-- AUTO HIDE ALERT -->
<script>
setTimeout(() => {
    const alertBox = document.querySelector('.bg-green-100, .bg-red-100');
    if(alertBox){
        alertBox.style.display = 'none';
    }
}, 3000);
</script>

</body>
</html>
