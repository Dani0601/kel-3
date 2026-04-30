<?php
include "config/koneksi.php";

// AMANIN SESSION
$role = $_SESSION['role'] ?? "";
$id_user = $_SESSION['id_user'] ?? 0;

// DEFAULT NOTIF
$notif = ['total' => 0];

// HITUNG NOTIF
if($id_user){
    $q = $conn->query("
    SELECT COUNT(*) as total 
    FROM notifikasi_user 
    WHERE id_user='$id_user' AND status_dibaca=0
    ");

    if($q){
        $notif = $q->fetch_assoc();
    }
}
?>

<nav class="bg-white shadow-md fixed top-0 w-full z-50" x-data="{open:false}">
<div class="max-w-7xl mx-auto px-6">
<div class="flex justify-between items-center h-16">

<!-- LOGO -->
<a href="index.php?menu=home" class="flex items-center gap-3 p-4 border-b text-blue-600">
    <img src="assets/img/logo_biruuu.png" class="w-10">
    
    <div>
        <div class="text-xl font-bold tracking-wide">RuKo</div>
        <p class="text-xs text-gray-500">Ruang Kosong</p>
    </div>
</a>

<!-- MENU DESKTOP -->
<div class="hidden md:flex items-center space-x-8">

<!-- MANAJEMEN -->
<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Manajemen Jadwal
</button>

<div x-show="dropdown" @click.outside="dropdown=false"
x-transition
class="absolute bg-white shadow-lg rounded-xl mt-2 w-52 overflow-hidden">

<a href="index.php?menu=jadwal" class="block px-4 py-2 hover:bg-gray-100">
Jadwal
</a>
<a href="index.php?menu=status" class="block px-4 py-2 hover:bg-gray-100">
Status Ruangan
</a>
<a href="index.php?menu=info_ruangan" class="block px-4 py-2 hover:bg-gray-100">
Info Ruangan
</a>
<?php if($role == "dosen"){ ?>
<a href="index.php?menu=booking_ruangan" class="block px-4 py-2 hover:bg-gray-100">
Booking Ruangan
</a>
<?php } ?>

</div>
</div>

<!-- INFORMASI -->
<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Informasi
</button>

<div x-show="dropdown" @click.outside="dropdown=false"
x-transition
class="absolute bg-white shadow-lg rounded-xl mt-2 w-52 overflow-hidden">

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

<!-- LAPORAN -->
<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Laporan
</button>

<div x-show="dropdown" @click.outside="dropdown=false"
x-transition
class="absolute bg-white shadow-lg rounded-xl mt-2 w-52 overflow-hidden">

<a href="index.php?menu=laporan" class="block px-4 py-2 hover:bg-gray-100">
Tambah Laporan
</a>

<a href="index.php?menu=riwayat_laporan" class="block px-4 py-2 hover:bg-gray-100">
Riwayat Laporan
</a>

</div>
</div>

<?php if($role == "admin"){ ?>
<a href="index.php?menu=dashboard_admin"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Dashboard Admin
</a>
<?php } ?>

<?php if($role == "dosen"){ ?>
<a href="index.php?menu=dashboard_dosen"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Dashboard Dosen
</a>
<?php } ?>


<?php if($role == "mahasiswa"){ ?>
<a href="index.php?menu=dashboard_mahasiswa"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Dashboard Mahasiswa
</a>
<?php } ?>

<!-- 🔔 NOTIF -->
<div class="relative">

<a href="index.php?menu=<?= ($role == 'admin') ? 'notifikasi' : 'notifikasi_user' ?>"
class="relative text-xl hover:scale-110 transition">

🔔

<?php if($notif['total'] > 0){ ?>
<span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full shadow">
<?= $notif['total'] ?>
</span>
<?php } ?>

</a>

</div>



<!-- USER -->
<?php if(isset($_SESSION['login'])){ ?>

<div class="relative" x-data="{dropdown:false}">
<button @click="dropdown=!dropdown"
class="text-yellow-500 font-semibold hover:text-yellow-600 transition">

<?= $_SESSION['username']; ?>

</button>

<div x-show="dropdown" @click.outside="dropdown=false"
x-transition
class="absolute right-0 bg-white shadow-lg rounded-xl mt-2 w-40 overflow-hidden">

<a href="auth/logout.php"
onclick="openLogoutModal(); return false;"
class="block px-4 py-2 text-red-500 hover:bg-gray-100">
Logout
</a>

</div>
</div>

<?php } ?>

</div>

<!-- MOBILE BUTTON -->
<button @click="open=!open"
class="md:hidden text-gray-700 text-2xl">
☰
</button>

</div>

<!-- MOBILE MENU -->
<div x-show="open" x-transition class="md:hidden pb-4 px-6">

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

<div class="relative" x-data="{dropdown:false}">

<button @click="dropdown=!dropdown"
class="text-gray-700 hover:text-blue-600 font-medium transition">
Laporan
</button>

<div x-show="dropdown" @click.outside="dropdown=false"
x-transition
class="absolute bg-white shadow-lg rounded-xl mt-2 w-52 overflow-hidden">

<a href="index.php?menu=laporan"
class="block px-4 py-2 hover:bg-gray-100">
Tambah Laporan
</a>

<a href="index.php?menu=riwayat_laporan"
class="block px-4 py-2 hover:bg-gray-100">
Riwayat Laporan
</a>

</div>

</div>

<a href="index.php?menu=notifikasi_user" class="block py-2 text-gray-700">
Notifikasi
</a>

</div>

</div>

<!-- POPUP NOTIF -->
<div id="notifPopup" 
class="fixed top-20 right-5 bg-white shadow-xl rounded-xl p-4 w-72 border hidden z-50">

<h4 class="font-semibold mb-2">🔔 Notifikasi Baru</h4>

<p class="text-sm text-gray-600">
Kamu punya <?= $notif['total'] ?> notifikasi baru
</p>

<a href="index.php?menu=notifikasi_user"
class="block mt-3 text-blue-600 text-sm hover:underline">
Lihat sekarang
</a>

</div>

<script>
<?php if($notif['total'] > 0){ ?>
    setTimeout(() => {
        document.getElementById("notifPopup").classList.remove("hidden");
    }, 1000);
<?php } ?>
</script>

<audio id="notifSound" src="https://www.soundjay.com/buttons/sounds/button-3.mp3"></audio>

<script>
<?php if($notif['total'] > 0){ ?>
    document.getElementById("notifSound").play();
<?php } ?>
</script>

</nav>

<!-- MODAL LOGOUT -->
<div id="modalLogout"
class="fixed inset-0 backdrop-blur-sm bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl p-6 w-80 text-center">
        
        <h2 class="text-lg font-semibold mb-2">Logout dari sistem?</h2>
        <p class="text-gray-500 text-sm mb-4">
            Anda akan keluar dari akun ini
        </p>

        <div class="flex justify-center gap-3">
            <button onclick="closeLogoutModal()"
                class="px-4 py-2 rounded-lg bg-gray-200">
                Batal
            </button>

            <a href="auth/logout.php"
               class="px-4 py-2 rounded-lg bg-red-500 text-white">
               Ya, Logout
            </a>
        </div>

    </div>
</div>

<script>
function openLogoutModal(){
    const modal = document.getElementById('modalLogout');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeLogoutModal(){
    const modal = document.getElementById('modalLogout');
    modal.classList.add('hidden');
}
</script>