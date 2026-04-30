<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit();
}

$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Smart Room Monitoring System</title>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{ font-family:'Poppins',sans-serif; }

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
.animate-slideIn {
    animation: slideIn 0.3s ease;
}
</style>

</head>

<!-- FLEX LAYOUT WAJIB -->
<body class="bg-gray-100 flex flex-col min-h-screen">

<?php 
if($role != 'admin'){
    include "includes/navbar.php";
}
?>

<!-- ================= NOTIF ================= -->
<?php if(isset($_GET['notif'])): ?>
<div id="notifBox"
class="fixed top-5 right-5 z-50 px-6 py-3 rounded-xl shadow-lg text-white animate-slideIn
<?php
switch($_GET['notif']){
    case 'hapus_sukses': echo 'bg-red-500'; break;
    case 'simpan_sukses': echo 'bg-green-500'; break;
    case 'update_sukses': echo 'bg-blue-500'; break;
    case 'error': echo 'bg-gray-500'; break;
    case 'error_tahun': echo 'bg-yellow-500'; break;
    default: echo 'bg-gray-800';
}
?>">
<?php
switch($_GET['notif']){
    case 'hapus_sukses': echo 'Data berhasil dihapus'; break;
    case 'simpan_sukses': echo 'Data berhasil disimpan'; break;
    case 'update_sukses': echo 'Data berhasil diupdate'; break;
    case 'error': echo 'Terjadi kesalahan'; break;
    case 'error_tahun': echo 'Tahun ajar belum diatur!'; break;
    default: echo 'Notifikasi';
}
?>
</div>

<script>
setTimeout(()=>{
    let notif = document.getElementById('notifBox');
    if(notif){
        notif.style.opacity = '0';
        notif.style.transform = 'translateX(100%)';
        setTimeout(()=>notif.remove(),300);
    }
},3000);
</script>
<?php endif; ?>


<!-- ================= MAIN ================= -->
<div class="flex flex-1">

    <!-- SIDEBAR -->
    <?php if($role == 'admin'){ ?>
        <?php include "includes/sidebar.php"; ?>
    <?php } ?>

    <!-- CONTENT -->
    <main class="flex-1 pt-20 px-6 pb-10 <?= ($role == 'admin') ? 'ml-64' : '' ?>">
        <?php include "includes/menu.php"; ?>
    </main>

</div>


<!-- ================= DELETE MODAL ================= -->
<div id="deleteModal"
class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">

    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg text-center">

        <h2 id="deleteTitle" class="text-lg font-bold mb-2">
            Hapus Data?
        </h2>

        <p class="text-sm text-gray-500 mb-6">
            Data yang dihapus tidak bisa dikembalikan.
        </p>

        <div class="flex justify-center gap-3">
            <button onclick="closeDeleteModal()"
            class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </button>

            <a id="btnDeleteConfirm"
            class="px-4 py-2 bg-red-600 text-white rounded">
                Hapus
            </a>
        </div>

    </div>

</div>

<script>
function openDeleteModal(url, title = 'Hapus Data?'){
    document.getElementById('btnDeleteConfirm').href = url;
    document.getElementById('deleteTitle').innerText = title;

    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal(){
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}
</script>

<!-- FOOTER TERPISAH -->
<?php include "includes/footer.php"; ?>

</body>
</html>