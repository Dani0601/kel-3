<?php
$menu = $_GET['menu'] ?? '';
$role = $_SESSION['role'] ?? '';
?>

<div class="w-64 bg-white border-r fixed left-0 top-0 bottom-0 flex flex-col">

    <!-- 🔵 LOGO -->
    <div class="p-4 flex items-center gap-3 text-blue-600 border-b">
        <img src="assets/img/logo_biruuu.png" class="w-12">
        
        <div>
            <div class="text-2xl font-bold">RuKo</div>
            <p class="text-sm text-gray-500">Ruang Kosong</p>
        </div>
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

        <a href="?menu=kelola_mata_kuliah"
        class="block px-4 py-2 rounded-lg <?= $menu=='kelola_mata_kuliah'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Mata Kuliah
        </a>

        <a href="?menu=kelola_pengumuman"
        class="block px-4 py-2 rounded-lg <?= $menu=='kelola_pengumuman'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Pengumuman
        </a>

        <a href="?menu=notifikasi"
        class="block px-4 py-2 rounded-lg <?= $menu=='notifikasi'?'bg-blue-500 text-white':'' ?> hover:bg-blue-500 hover:text-white">
        Notifikasi
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

        <a href="#"
        onclick="openLogoutModal()"
        class="block text-center bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
        Logout
        </a>

    </div>

</div>

<!-- ================= MODAL LOGOUT ================= -->
<div id="modalLogout"
class="fixed inset-0 backdrop-blur-sm bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl p-6 w-80 text-center animate-fadeScale">
        
        <!-- ICON -->
        <div class="mb-3">
            <div class="w-12 h-12 mx-auto flex items-center justify-center bg-red-100 text-red-500 rounded-full text-xl">
                ⚠
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-1">Logout dari sistem?</h2>
        <p class="text-gray-500 text-sm mb-4">
            Anda akan keluar dari akun ini
        </p>

        <div class="flex justify-center gap-3">
            <button onclick="closeLogoutModal()"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                Batal
            </button>

            <a href="auth/logout.php"
               class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
               Ya, Logout
            </a>
        </div>

    </div>
</div>

<!-- ================= SCRIPT ================= -->
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

/* klik luar modal */
window.addEventListener('click', function(e){
    const modal = document.getElementById('modalLogout');
    if(e.target === modal){
        closeLogoutModal();
    }
});

/* tekan ESC */
document.addEventListener('keydown', function(e){
    if(e.key === "Escape"){
        closeLogoutModal();
    }
});
</script>

<!-- ================= ANIMASI ================= -->
<style>
@keyframes fadeScale {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
.animate-fadeScale {
    animation: fadeScale 0.25s ease;
}
</style>