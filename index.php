<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Smart Room Monitoring System</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
font-family: 'Poppins', sans-serif;
}
</style>

</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">

<!-- NAVBAR -->
<?php include "includes/navbar.php"; ?>

<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 pt-28 pb-10">

<div class="bg-white shadow-lg rounded-xl p-6">

<?php include "includes/menu.php"; ?>

</div>

</div>

<!-- FOOTER -->
<?php include "includes/footer.php"; ?>

</body>
</html>