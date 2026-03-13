<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>

<title>Login Sistem</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container">
<div class="row justify-content-center">
<div class="col-md-4">

<h3 class="text-center mt-5">Login Sistem</h3>

<form action="proses_login.php" method="POST">

<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<!-- CAPTCHA -->
<div class="text-center mb-2">
<img src="captcha.php" onclick="this.src='captcha.php?'+Math.random();" style="cursor:pointer;">
<p style="font-size:12px;">Klik gambar untuk refresh captcha</p>
</div>

<input type="text" name="captcha" class="form-control mb-3" placeholder="Masukkan captcha" required>

<button class="btn btn-primary w-100">Login</button>

</form>

</div>
</div>
</div>

</body>
</html>