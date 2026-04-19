<?php
session_start();
include "../config/koneksi.php";

// PROTEKSI ADMIN
if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola User</title>
</head>
<body>

<h3>Kelola User</h3>

<a href="dashboard.php">← Kembali ke Dashboard</a>
<br><br>
<a href="kelola_user.php?tambah=1" class="btn btn-primary mb-3">
+ Tambah User
</a>
<form method="GET">
<input type="text" name="cari" placeholder="Cari username..." class="form-control mb-2">
</form>

<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Username</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php
$no = 1;
$data = $conn->query("SELECT * FROM users");

while($u = $data->fetch_assoc()){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $u['username'] ?></td>
    <td>
        <span class="badge bg-info"><?= $u['role'] ?></span>
    </td>
    <td>
        <a href="kelola_user.php?edit=<?= $u['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="kelola_user.php?hapus=<?= $u['id_user'] ?>"
        onclick="return confirm('Yakin hapus?')"
        class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>


<!-- ================= TAMBAH USER ================= -->
<?php if(isset($_GET['tambah'])){ ?>

<h3>Tambah User</h3>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <select name="role">
        <option value="admin">Admin</option>
        <option value="dosen">Dosen</option>
        <option value="mahasiswa">Mahasiswa</option>
    </select><br><br>

    <button name="simpan">Simpan</button>
</form>

<?php } ?>

<!-- PROSES SIMPAN -->
<?php
if(isset($_POST['simpan'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']); // nanti bisa di-upgrade
    $role = $_POST['role'];

    $conn->query("INSERT INTO users VALUES(NULL,'$username','$password','$role')");

    echo "<script>alert('User berhasil ditambah');location='kelola_user.php';</script>";
}
?>

<!-- ================= EDIT USER ================= -->
<?php if(isset($_GET['edit'])){ 

$id = $_GET['edit'];
$data = $conn->query("SELECT * FROM users WHERE id_user='$id'");
$u = $data->fetch_assoc();
?>

<h3>Edit User</h3>

<form method="POST">
    <input type="text" name="username" value="<?= $u['username'] ?>"><br><br>

    <select name="role">
        <option <?= $u['role']=="admin"?"selected":"" ?>>admin</option>
        <option <?= $u['role']=="dosen"?"selected":"" ?>>dosen</option>
        <option <?= $u['role']=="mahasiswa"?"selected":"" ?>>mahasiswa</option>
    </select><br><br>

    <button name="update">Update</button>
</form>

<?php } ?>

<!-- PROSES UPDATE -->
<?php
if(isset($_POST['update'])){
    $conn->query("
    UPDATE users SET 
    username='$_POST[username]',
    role='$_POST[role]'
    WHERE id_user='$_GET[edit]'
    ");

    echo "<script>alert('User berhasil diupdate');location='kelola_user.php';</script>";
}
?>

<!-- ================= HAPUS USER ================= -->
<?php
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    $conn->query("DELETE FROM users WHERE id_user='$id'");

    echo "<script>alert('User berhasil dihapus');location='kelola_user.php';</script>";
}
?>

</body>
</html>