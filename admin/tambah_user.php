<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['simpan'])) {

    // ========================
    // AMBIL DATA
    // ========================
    $username = trim($_POST['username']);
    $password_plain = $_POST['password'];
    $role = $_POST['role'];

    // ========================
    // VALIDASI DASAR
    // ========================
    if (empty($username) || empty($password_plain) || empty($role)) {
        echo "<script>alert('Semua data wajib diisi');history.back();</script>";
        exit;
    }

    // ========================
    // CEK ROLE VALID
    // ========================
    $allowed_role = ['admin', 'dosen', 'mahasiswa'];
    if (!in_array($role, $allowed_role)) {
        echo "<script>alert('Role tidak valid');history.back();</script>";
        exit;
    }

    // ========================
    // ESCAPE INPUT
    // ========================
    $username = mysqli_real_escape_string($conn, $username);

    // ========================
    // CEK USERNAME DUPLIKAT
    // ========================
    $cek = mysqli_query($conn, "SELECT id_user FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!');history.back();</script>";
        exit;
    }

    // ========================
    // 🔥 MD5 PASSWORD (FIX DI SINI)
    // ========================
    $password = md5($password_plain);

    // ========================
    // INSERT DATA (AUTO_INCREMENT)
    // ========================
    $sql = mysqli_query($conn, "
        INSERT INTO users (username, password, role)
        VALUES ('$username', '$password', '$role')
    ") or die(mysqli_error($conn));

    // ========================
    // HASIL
    // ========================
    if ($sql) {
        echo "<script>
        alert('User berhasil ditambahkan');
        location='index.php?menu=kelola_user';
        </script>";
    } else {
        echo "<script>
        alert('Gagal menambahkan user');
        history.back();
        </script>";
    }
}
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Tambah User</h2>

<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

<input type="text" name="username"
placeholder="Username"
class="w-full border p-2 rounded"
required>

<input type="password" name="password"
placeholder="Password"
class="w-full border p-2 rounded"
required>

<select name="role" class="w-full border p-2 rounded" required>
    <option value="">-- Pilih Role --</option>
    <option value="admin">Admin</option>
    <option value="dosen">Dosen</option>
    <option value="mahasiswa">Mahasiswa</option>
</select>

<button name="simpan"
class="bg-blue-500 text-white px-4 py-2 rounded">
Simpan
</button>

</form>

</div>