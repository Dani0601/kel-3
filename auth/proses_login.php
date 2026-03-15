<?php

session_start();
require_once "../config/koneksi.php";

/* validasi captcha */
if($_POST['captcha'] != $_SESSION['captcha']){

    echo "<script>
    alert('Captcha salah');
    window.location='login.php';
    </script>";
    exit();

}

$username = mysqli_real_escape_string($conn,$_POST['username']);
$password = md5($_POST['password']);

$query = mysqli_query($conn,"SELECT * FROM user 
WHERE username='$username' AND password='$password'");

$data = mysqli_fetch_assoc($query);

if($data){

    $_SESSION['login'] = true;
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    header("Location: ../index.php");
    exit();

}else{

    echo "<script>
    alert('Username atau password salah');
    window.location='login.php';
    </script>";

}

?>