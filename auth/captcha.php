<?php
session_start();

/* karakter captcha */
$karakter = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';

/* panjang captcha */
$captcha = substr(str_shuffle($karakter),0,5);

$_SESSION['captcha'] = $captcha;

/* header image */
header('Content-type: image/png');

/* ukuran gambar */
$img = imagecreate(120,40);

/* warna */
$bg = imagecolorallocate($img,255,255,255);
$textcolor = imagecolorallocate($img,0,0,0);
$linecolor = imagecolorallocate($img,150,150,150);

/* garis noise */
for($i=0;$i<5;$i++){
    imageline($img,0,rand()%40,120,rand()%40,$linecolor);
}

/* tampilkan captcha */
imagestring($img,5,30,10,$captcha,$textcolor);

/* output image */
imagepng($img);
imagedestroy($img);
?>