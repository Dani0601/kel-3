<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';
require '../vendor/PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

$mail->SMTPDebug = 2;

$nama = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];

try {

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'naulaalfiyatull@gmail.com';
$mail->Password = 'oerejnolnayvgtoy';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('naulaalfiyatull@gmail.com', 'Website Kampus');
$mail->addAddress('naulaalfiyatull@gmail.com');
$mail->addReplyTo($email, $nama);

$mail->Subject = 'Pesan Baru dari Website Kampus';

$mail->isHTML(true);

$mail->Body = "
<div style='font-family:Arial, sans-serif; background:#f4f6f9; padding:20px;'>

    <div style='max-width:600px; margin:auto; background:white; border-radius:8px; overflow:hidden; box-shadow:0 3px 10px rgba(0,0,0,0.1);'>
        
        <div style='background:#198754; color:white; padding:15px; font-size:18px;'>
            Pesan Baru dari Website Kampus
        </div>

        <div style='padding:20px;'>

            <p><strong>Nama Pengirim:</strong><br>$nama</p>

            <p><strong>Email Pengirim:</strong><br>$email</p>

            <p><strong>Pesan:</strong></p>

            <div style='background:#f8f9fa; padding:15px; border-radius:6px;'>
                $pesan
            </div>

        </div>

        <div style='background:#f1f1f1; padding:10px; text-align:center; font-size:12px; color:#777;'>
            Sistem Informasi Kampus
        </div>

    </div>

</div>
";

$mail->send();

echo "<script>alert('Pesan berhasil dikirim'); window.location='../index.php';</script>";

} catch (Exception $e) {

echo "Pesan gagal dikirim";

}

?>