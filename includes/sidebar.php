<?php
$menu = $_GET['menu'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<div class="w-64 bg-white border-r fixed left-0 top-0 bottom-0 flex flex-col">

    <!-- 🔵 LOGO -->
    <div class="p-4 text-center text-2xl font-bold text-blue-600 border-b">
        Smart Room
    </div>

    <!-- 🔹 MENU -->
    <nav class="flex-1 p-4 space-y-2 text-sm">

        <!-- ADMIN -->
        <?php if($role == 'admin'): ?>

        <a href="?menu=dashboard_admin"
        class="block px-4 py-2 rounded-lg <?= $menu=='dashboard_admin'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Dashboard
        </a>

        <a href="?menu=kelola_jadwal"
        class="block px-4 py-2 rounded-lg <?= $menu=='kelola_jadwal'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Jadwal
        </a>

        <a href="?menu=kelola_ruangan"
        class="block px-4 py-2 rounded-lg <?= $menu=='kelola_ruangan'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Ruangan
        </a>

        <a href="?menu=kelola_pengumuman"
        class="block px-4 py-2 rounded-lg <?= $menu=='kelola_pengumuman'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Pengumuman
        </a>

        <a href="?menu=kelola_user"
        class="block px-4 py-2 rounded-lg <?= $menu=='kelola_user'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        User
        </a>

        <a href="?menu=laporan"
        class="block px-4 py-2 rounded-lg <?= $menu=='laporan'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Laporan
        </a>

        <a href="?menu=notifikasi"
        class="block px-4 py-2 rounded-lg <?= $menu=='notifikasi'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Notifikasi
        </a>

        <?php endif; ?>

        <!-- DOSEN -->
        <?php if($role == 'dosen'): ?>

        <a href="?menu=dashboard_dosen"
        class="block px-4 py-2 rounded-lg <?= $menu=='dashboard_dosen'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Dashboard
        </a>

        <a href="?menu=laporan"
        class="block px-4 py-2 rounded-lg <?= $menu=='laporan'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Laporan
        </a>

        <?php endif; ?>

        <!-- MAHASISWA -->
        <?php if($role == 'mahasiswa'): ?>

        <a href="?menu=dashboard_mahasiswa"
        class="block px-4 py-2 rounded-lg <?= $menu=='dashboard_mahasiswa'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Dashboard
        </a>

        <a href="?menu=tambah_laporan"
        class="block px-4 py-2 rounded-lg <?= $menu=='tambah_laporan'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Tambah Laporan
        </a>

        <?php endif; ?>

    </nav>

    <!-- 🔻 LOGOUT -->
    <div class="p-4 border-t">

        <a href="auth/logout.php"
        onclick="return confirm('Yakin ingin logout?')"
        class="block text-center bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
        Logout
        </a>

    </div>

</div>