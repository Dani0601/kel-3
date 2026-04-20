<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit();
}
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
</style>

</head>

<body class="bg-gray-100">

<?php include "includes/navbar.php"; ?>

<?php
$role = $_SESSION['role'] ?? '';
?>

<div class="flex">

    <!-- SIDEBAR (HANYA ADMIN) -->
    <?php if($role == 'admin'){ ?>
        <?php include "includes/sidebar.php"; ?>
    <?php } ?>

    <!-- CONTENT -->
    <div class="flex-1 pt-20 px-6 pb-10 
    <?= ($role == 'admin') ? 'ml-64' : '' ?>">

        <?php include "includes/menu.php"; ?>

    </div>

</div>



</body>
</html>