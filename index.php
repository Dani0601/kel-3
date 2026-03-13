<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Smart Room Monitoring System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<!-- NAVBAR -->
<?php include "includes/navbar.php"; ?>

<!-- CONTENT -->
<div class="container" style="margin-top:90px;">

<?php include "includes/menu.php"; ?>

</div>

<!-- FOOTER -->
<?php include "includes/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>