<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'] ?? 0;

// ========================
// AMBIL DATA
// ========================
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users WHERE id_user='$id'
"));

if(!$data){
    die("Data tidak ditemukan");
}

// ========================
// PROSES UPDATE
// ========================
if(isset($_POST['update'])){

    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // VALIDASI
    if(empty($username) || empty($role)){
        header("Location: index.php?menu=edit_user&id=$id&error=kosong");
        exit;
    }

    // CEK DUPLIKAT USERNAME (kecuali dirinya sendiri)
    $cek = mysqli_query($conn,"
        SELECT * FROM users 
        WHERE username='$username' 
        AND id_user!='$id'
    ");

    if(mysqli_num_rows($cek) > 0){
        header("Location: index.php?menu=edit_user&id=$id&error=username");
        exit;
    }

    // ========================
    // UPDATE PASSWORD OPSIONAL
    // ========================
    if(!empty($password)){
        $password = md5($password);

        $sql = mysqli_query($conn,"
            UPDATE users SET
            username='$username',
            password='$password',
            role='$role'
            WHERE id_user='$id'
        ");
    } else {
        // kalau password tidak diisi, tidak diubah
        $sql = mysqli_query($conn,"
            UPDATE users SET
            username='$username',
            role='$role'
            WHERE id_user='$id'
        ");
    }

    if(!$sql){
        die("ERROR: " . mysqli_error($conn));
    }

    header("Location: index.php?menu=kelola_user&msg=update");
    exit;
}
?>

<div class="p-6">

<h2 class="text-xl font-bold mb-4">Edit User</h2>

<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

<!-- ID (READ ONLY) -->
<input type="text"
value="<?= $data['id_user'] ?>"
class="w-full border p-2 rounded bg-gray-100"
readonly>

<!-- USERNAME -->
<input type="text"
name="username"
value="<?= $data['username'] ?>"
class="w-full border p-2 rounded"
required>

<!-- PASSWORD (OPSIONAL) -->
<input type="password"
name="password"
placeholder="Kosongkan jika tidak ingin mengganti password"
class="w-full border p-2 rounded">

<!-- ROLE -->
<select name="role" class="w-full border p-2 rounded">
<option <?= $data['role']=='admin'?'selected':'' ?>>admin</option>
<option <?= $data['role']=='dosen'?'selected':'' ?>>dosen</option>
<option <?= $data['role']=='mahasiswa'?'selected':'' ?>>mahasiswa</option>
</select>

<button name="update"
class="bg-green-500 text-white px-4 py-2 rounded">
Update
</button>

</form>

</div>