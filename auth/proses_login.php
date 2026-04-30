<?php
session_start();
require_once "../config/koneksi.php";

/* VALIDASI CAPTCHA */
if($_POST['captcha'] != $_SESSION['captcha']){
    header("Location: login.php?error=captcha");
    exit();
}

$username = mysqli_real_escape_string($conn,$_POST['username']);
$password = md5($_POST['password']);

$query = mysqli_query($conn,"SELECT * FROM users 
WHERE username='$username' AND password='$password'");

$data = mysqli_fetch_assoc($query);

if($data){

    $_SESSION['login'] = true;
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];
    $_SESSION['id_user'] = $data['id_user'];

    header("Location: login.php?success=1&role=".$data['role']);
    exit();

}else{
    header("Location: login.php?error=login");
    exit();
}
?>