<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';
require '../vendor/PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

/* ambil data form */
$nama  = htmlspecialchars($_POST['nama'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$pesan = htmlspecialchars($_POST['pesan'] ?? '');

if(empty($nama) || empty($email) || empty($pesan)){
    echo "<script>alert('Semua field wajib diisi');history.back();</script>";
    exit;
}

try {

$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'naulaalfiyatull@gmail.com';
$mail->Password   = 'oerejnolnayvgtoy'; 
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

/* pengirim */
$mail->setFrom('naulaalfiyatull@gmail.com', 'Smart Room System');

/* penerima */
$mail->addAddress('naulaalfiyatull@gmail.com');

/* reply */
$mail->addReplyTo($email, $nama);

$mail->Subject = 'Pesan Baru dari Website Smart Room';

$mail->isHTML(true);

/* isi email */
$mail->Body = "
<div style='font-family:Arial;background:#f4f6f9;padding:20px;'>

<div style='max-width:600px;margin:auto;background:white;border-radius:10px;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,0.1);'>

<div style='background:#22c55e;color:white;padding:15px;font-size:18px;font-weight:bold'>
Pesan Baru dari Website Smart Room
</div>

<div style='padding:20px'>

<p><strong>Nama Pengirim:</strong><br>$nama</p>

<p><strong>Email Pengirim:</strong><br>$email</p>

<p><strong>Pesan:</strong></p>

<div style='background:#f1f5f9;padding:15px;border-radius:6px'>
$pesan
</div>

</div>

<div style='background:#f1f1f1;padding:10px;text-align:center;font-size:12px;color:#666'>
Smart Room Monitoring System
</div>

</div>

</div>
";

$mail->send();

echo "<script>
alert('Pesan berhasil dikirim');
window.location='../index.php?menu=kontak';
</script>";

} catch (Exception $e) {

echo "<script>
alert('Pesan gagal dikirim');
history.back();
</script>";

}
?>