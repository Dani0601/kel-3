<?php
$role = $_SESSION['role'] ?? "";
?>

<nav class="bg-white shadow-md fixed top-0 w-full z-50" x-data="{open:false}">
<div class="max-w-7xl mx-auto px-6">
<div class="flex justify-between items-center h-16">

<!-- LOGO -->
<a href="index.php" class="text-2xl font-bold text-blue-600">
Smart Room
</a>

<!-- MENU DESKTOP -->
<div class="hidden md:flex items-center space-x-6">

<a href="index.php" class="text-gray-700 hover:text-blue-600 font-medium">
Beranda
</a>

<!-- MANAJEMEN JADWAL -->
<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown" class="text-gray-700 hover:text-blue-600 font-medium">
Manajemen Jadwal
</button>

<div x-show="dropdown" @click.outside="dropdown=false"
class="absolute bg-white shadow-lg rounded-lg mt-2 w-48">

<a href="index.php?menu=jadwal" class="block px-4 py-2 hover:bg-gray-100">
Jadwal
</a>

<a href="index.php?menu=status" class="block px-4 py-2 hover:bg-gray-100">
Status Ruangan
</a>

<a href="index.php?menu=info_ruangan" class="block px-4 py-2 hover:bg-gray-100">
Info Ruangan
</a>

</div>
</div>

<!-- INFORMASI -->
<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown" class="text-gray-700 hover:text-blue-600 font-medium">
Informasi
</button>

<div x-show="dropdown" @click.outside="dropdown=false"
class="absolute bg-white shadow-lg rounded-lg mt-2 w-48">

<a href="index.php?menu=pengumuman" class="block px-4 py-2 hover:bg-gray-100">
Pengumuman
</a>

<a href="index.php?menu=panduan" class="block px-4 py-2 hover:bg-gray-100">
Panduan
</a>

<a href="index.php?menu=kontak" class="block px-4 py-2 hover:bg-gray-100">
Kontak
</a>

</div>
</div>

<a href="index.php?menu=laporan" class="text-gray-700 hover:text-blue-600 font-medium">
Laporan
</a>

<?php if($role == "admin"){ ?>
<a href="index.php?menu=dashboard_admin" class="text-gray-700 hover:text-blue-600 font-medium">
Dashboard
</a>
<?php } ?>

<?php if($role == "dosen"){ ?>
<a href="index.php?menu=dashboard_dosen" class="text-gray-700 hover:text-blue-600 font-medium">
Dashboard Dosen
</a>
<?php } ?>

<?php if($role == "mahasiswa"){ ?>
<a href="index.php?menu=dashboard_mahasiswa" class="text-gray-700 hover:text-blue-600 font-medium">
Dashboard Mahasiswa
</a>
<?php } ?>

<!-- USER -->
<?php if(isset($_SESSION['login'])){ ?>

<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown"
class="text-yellow-500 font-semibold">

<?php echo $_SESSION['username']; ?>

</button>

<div x-show="dropdown" @click.outside="dropdown=false"
class="absolute right-0 bg-white shadow-lg rounded-lg mt-2 w-40">

<a href="auth/logout.php"
onclick="return confirm('Yakin ingin logout?')"
class="block px-4 py-2 text-red-500 hover:bg-gray-100">

Logout

</a>

</div>

</div>

<?php } ?>

</div>

<!-- MOBILE BUTTON -->
<button @click="open=!open" class="md:hidden text-gray-700 text-2xl">
☰
</button>

</div>

<!-- MOBILE MENU -->
<div x-show="open" class="md:hidden pb-4">

<a href="index.php" class="block py-2 text-gray-700">
Beranda
</a>

<a href="index.php?menu=jadwal" class="block py-2 text-gray-700">
Jadwal
</a>

<a href="index.php?menu=status" class="block py-2 text-gray-700">
Status Ruangan
</a>

<a href="index.php?menu=info_ruangan" class="block py-2 text-gray-700">
Info Ruangan
</a>

<a href="index.php?menu=pengumuman" class="block py-2 text-gray-700">
Pengumuman
</a>

<a href="index.php?menu=laporan" class="block py-2 text-gray-700">
Laporan
</a>

</div>

</div>
</nav>