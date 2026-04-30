<?php
require_once __DIR__ . '/../config/koneksi.php';

/* ================= VALIDASI INPUT GEDUNG ================= */
if(
    empty($_POST['nama_gedung']) ||
    empty($_POST['jumlah_lantai'])
){
    die("Data gedung wajib diisi!");
}

/* ================= AMBIL DATA ================= */
$nama = trim($_POST['nama_gedung']);
$jumlah_lantai = (int) $_POST['jumlah_lantai'];

/* ================= NORMALISASI ================= */
$nama = preg_replace('/\s+/', ' ', $nama);

/* ================= VALIDASI ARRAY ================= */
if(!isset($_POST['kode']) || !is_array($_POST['kode'])){
    die("Data ruangan tidak ditemukan!");
}

/* ================= START TRANSACTION ================= */
mysqli_begin_transaction($conn);

try {

    /* ================= INSERT GEDUNG ================= */
    $insertGedung = mysqli_query($conn,"
    INSERT INTO gedung (nama_gedung,jumlah_lantai)
    VALUES ('$nama','$jumlah_lantai')
    ");

    if(!$insertGedung){
        throw new Exception(mysqli_error($conn));
    }

    /* ✅ AMBIL ID AUTO */
    $id_gedung = mysqli_insert_id($conn);

    /* ================= LOOP RUANGAN ================= */
    $totalRow = count($_POST['kode']);

    for($i=0; $i < $totalRow; $i++){

        $kode      = trim($_POST['kode'][$i] ?? '');
        $lantai    = (int) ($_POST['lantai'][$i] ?? 0);
        $jumlah    = (int) ($_POST['jumlah'][$i] ?? 0);
        $kapasitas = (int) ($_POST['kapasitas'][$i] ?? 0);

        /* ================= NORMALISASI ================= */
        $kode = preg_replace('/\s+/', ' ', $kode);

        /* ================= VALIDASI ================= */
        if(empty($kode) || $lantai <= 0 || $jumlah <= 0){
            throw new Exception("Data ruangan tidak lengkap di baris ke-" . ($i+1));
        }

        if($lantai > $jumlah_lantai){
            throw new Exception("Lantai melebihi batas gedung!");
        }

        /* ❗ KODE TIDAK BOLEH DIAKHIRI ANGKA */
        if(preg_match('/\d+$/', $kode)){
            throw new Exception("Kode '$kode' tidak boleh diakhiri angka!");
        }

        /* ================= GENERATE ================= */
        for($n=1; $n <= $jumlah; $n++){

            /* ================= FORMAT NOMOR ================= */
            $no = str_pad($n,2,"0",STR_PAD_LEFT);

            /* ================= NAMA RUANGAN ================= */
            $nama_ruangan = $kode . " " . $lantai . $no;

            /* ================= INSERT ================= */
            $insertRuangan = mysqli_query($conn,"
            INSERT INTO ruangan
            (id_gedung,nama_ruangan,lantai,kapasitas)
            VALUES
            ('$id_gedung','$nama_ruangan','$lantai','$kapasitas')
            ");

            if(!$insertRuangan){
                throw new Exception(mysqli_error($conn));
            }
        }
    }

    /* ================= COMMIT ================= */
    mysqli_commit($conn);

    header("Location: ../index.php?menu=kelola_ruangan&msg=simpan");
    exit;

} catch (Exception $e){

    /* ================= ROLLBACK ================= */
    mysqli_rollback($conn);

    header("Location: ../index.php?menu=kelola_ruangan&error=gagal");
    exit;
}