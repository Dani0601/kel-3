<!DOCTYPE html>
<html>
<head>
    <title>Panduan Penggunaan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top:90px;">

    <h2 class="mb-4">Panduan Penggunaan Sistem</h2>

    <!-- Cara Cek Jadwal -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-primary text-white">
            Cara Cek Jadwal Kuliah
        </div>
        <div class="card-body">
            <ol>
                <li>Klik menu <strong>Manajemen Jadwal</strong> → Pilih <strong>Jadwal Kuliah</strong>.</li>
                <li>Gunakan dropdown filter (Program Studi, Semester, Dosen, atau Ruangan).</li>
                <li>Jadwal akan tampil dalam bentuk tabel lengkap.</li>
            </ol>
        </div>
    </div>

    <!-- Cara Melihat Status Ruangan -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-success text-white">
            Cara Melihat Status Ruangan (Live)
        </div>
        <div class="card-body">
            <ol>
                <li>Pilih menu <strong>Status Ruangan (Live)</strong>.</li>
                <li>Lihat warna indikator:</li>
                <ul>
                    <li><span class="badge bg-success">Hijau</span> → Ruangan sedang dipakai</li>
                    <li><span class="badge bg-secondary">Abu-abu</span> → Ruangan kosong</li>
                    <li><span class="badge bg-warning text-dark">Kuning</span> → Akan dipakai</li>
                </ul>
                <li>Gunakan fitur pencarian untuk menemukan ruangan tertentu.</li>
            </ol>
        </div>
    </div>

    <!-- Cara Mengirim Laporan Fasilitas -->
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-danger text-white">
            Cara Mengirim Laporan Fasilitas Rusak
        </div>
        <div class="card-body">
            <ol>
                <li>Pilih menu <strong>Laporan Fasilitas</strong>.</li>
                <li>Isi semua data (Nama, NIM, Ruangan, Jenis Fasilitas).</li>
                <li>Tuliskan deskripsi kerusakan dengan jelas.</li>
                <li>Upload foto bukti (WAJIB).</li>
                <li>Klik tombol <strong>Kirim Laporan</strong>.</li>
            </ol>
        </div>
    </div>

    <!-- FAQ -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            FAQ (Pertanyaan yang Sering Ditanyakan)
        </div>
        <div class="card-body">
            <p><strong>Q: Mengapa jadwal tidak muncul?</strong><br>
            A: Pastikan filter yang dipilih sudah sesuai atau hubungi admin.</p>

            <p><strong>Q: Berapa lama laporan fasilitas diproses?</strong><br>
            A: Maksimal 2x24 jam kerja.</p>

            <p><strong>Q: Siapa yang bisa mengakses sistem ini?</strong><br>
            A: Mahasiswa, Dosen, dan Admin kampus.</p>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>