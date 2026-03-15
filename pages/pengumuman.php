<?php
include __DIR__ . '/../config/koneksi.php';
include __DIR__ . '/../includes/navbar.php';

$query = mysqli_query($conn, "SELECT * FROM pengumuman ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengumuman</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:#f4f6fb;
}

.card-pengumuman{
transition:0.3s;
border:none;
}

.card-pengumuman:hover{
transform:translateY(-5px);
box-shadow:0 10px 20px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="container" style="margin-top:100px">

<div class="row mb-4">
<div class="col">
<h3 class="fw-bold">📢 Pengumuman Smart Room</h3>
<p class="text-muted">Informasi terbaru sistem smart room</p>
</div>
</div>

<div class="row">

<?php
if(mysqli_num_rows($query) > 0){
while($data = mysqli_fetch_assoc($query)){
?>

<div class="col-md-6 mb-4">

<div class="card card-pengumuman shadow-sm">

<div class="card-body">

<h5 class="fw-bold text-primary">
<?php echo $data['judul']; ?>
</h5>

<p class="text-muted small">
📅 <?php echo date('d F Y H:i', strtotime($data['tanggal'])); ?>
</p>

<hr>

<p>
<?php echo $data['isi']; ?>
</p>

</div>

</div>

</div>

<?php
}
}else{
?>

<div class="col">
<div class="alert alert-info">
Belum ada pengumuman
</div>
</div>

<?php } ?>

</div>

</div>

</body>
</html>