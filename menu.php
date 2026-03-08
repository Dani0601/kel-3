<?php
if(isset($_GET['menu'])){
$menu=$_GET['menu'];
}
else{
$menu="";
}
if($menu=="info_ruangan"){
	include"info_ruangan.php";
}
else if($menu=="jadwal"){
	include"jadwal.php";
}
else if($menu=="kontak"){
	include"kontak.php";
}
else if($menu=="pengumuman"){
	include"pengumuman.php";
}
else if($menu=="panduan"){
	include"panduan.php";
}
else if($menu=="status"){
	include"status.php";
}
else{
	include"home.php";
}
?>