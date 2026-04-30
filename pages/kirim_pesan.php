<?php

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// load .env
$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

// ambil config dari .env (pakai $_ENV karena getenv() tidak jalan di Laragon)
$mailUsername = $_ENV['MAIL_USERNAME'] ?? null;
$mailPassword = $_ENV['MAIL_PASSWORD'] ?? null;

// validasi env
if (!$mailUsername || !$mailPassword) {
    die('Config email belum diset di .env');
}

$mail = new PHPMailer(true);

/* ambil data form */
$nama  = htmlspecialchars($_POST['nama'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$pesan = htmlspecialchars($_POST['pesan'] ?? '');

// validasi kosong
if (empty($nama) || empty($email) || empty($pesan)) {
    header("Location: ../index.php?menu=kontak&error=kosong");
    exit;
}

// validasi email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../index.php?menu=kontak&error=email");
    exit;
}

try {

    // konfigurasi SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailUsername;
    $mail->Password   = $mailPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // pengirim
    $mail->setFrom($mailUsername, 'Smart Room System');

    // penerima (email kamu sendiri)
    $mail->addAddress($mailUsername);

    // reply ke user
    $mail->addReplyTo($email, $nama);

    // subject
    $mail->Subject = 'Pesan Baru dari Website Smart Room';

    // format email
    $mail->isHTML(true);

    // isi email
    $mail->Body = "
    <div style='font-family:Arial;background:#f4f6f9;padding:20px;'>
    <div style='max-width:600px;margin:auto;background:white;border-radius:10px;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,0.1);'>

    <div style='background:#22c55e;color:white;padding:15px;font-size:18px;font-weight:bold'>
    Pesan Baru dari Website Smart Room
    </div>

    <div style='padding:20px'>
    <p><strong>Nama:</strong><br>$nama</p>
    <p><strong>Email:</strong><br>$email</p>
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

    header("Location: ../index.php?menu=kontak&msg=sukses");
    exit;

} catch (Exception $e) {

    header("Location: ../index.php?menu=kontak&error=gagal");
    exit;

    // aktifkan ini kalau mau lihat error asli
    // echo $mail->ErrorInfo;
}