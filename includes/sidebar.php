<?php
$menu = $_GET['menu'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<div class="w-64 bg-white border-r fixed left-0 top-16 bottom-0">

    <!-- TITLE -->
    <div class="p-4 text-center text-xl font-semibold text-blue-600 border-b">
        Kelola
    </div>

    <!-- MENU -->
    <nav class="p-4 space-y-2 text-sm">

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

        <?php endif; ?>


       

    </nav>

</div>