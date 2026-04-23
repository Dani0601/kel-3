<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

# ================= AMBIL DATA =================
$ruangan_data = mysqli_query($conn,"SELECT * FROM ruangan");
$dosen_data   = mysqli_query($conn,"SELECT * FROM dosen");
$kelas_data   = mysqli_query($conn,"SELECT * FROM kelas");

// ambil tahun aktif saja
$tahun_aktif = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM tahun_ajaran WHERE aktif=1
"));

$id_tahun_aktif = $tahun_aktif['id_tahun_ajar'] ?? 0;

if(!$id_tahun_aktif){
    echo "<div class='p-6 text-red-500'>❌ Tidak ada tahun ajar aktif</div>";
    return;
}

$mk_data = mysqli_query($conn,"
    SELECT mk_prodi.*, mata_kuliah.nama_mk, mata_kuliah.sks
    FROM mk_prodi
    JOIN mata_kuliah ON mk_prodi.id_mk = mata_kuliah.id_mk
");

# ================= SIMPAN =================
if(isset($_POST['simpan'])){

    $hari         = $_POST['hari'];
    $jam_mulai    = $_POST['jam_mulai'];
    $id_ruangan   = $_POST['id_ruangan'];
    $id_mk_prodi  = $_POST['id_mk_prodi'];
    $id_dosen     = $_POST['id_dosen'];
    $id_kelas     = $_POST['id_kelas'];

    # ================= VALIDASI =================
    if(empty($hari) || empty($jam_mulai)){
        echo "<script>alert('Data tidak lengkap');history.back();</script>";
        exit;
    }

    # ================= AMBIL SKS =================
    $ambil = mysqli_query($conn,"
        SELECT mata_kuliah.sks
        FROM mk_prodi
        JOIN mata_kuliah ON mk_prodi.id_mk = mata_kuliah.id_mk
        WHERE mk_prodi.id_mk_prodi = '$id_mk_prodi'
    ");

    if(mysqli_num_rows($ambil) == 0){
        echo "<script>alert('Mata kuliah tidak ditemukan');history.back();</script>";
        exit;
    }

    $sks = mysqli_fetch_assoc($ambil)['sks'];

    # ================= HITUNG JAM =================
    $durasi = $sks * 50; // menit

    $mulai   = strtotime($jam_mulai);
    $selesai = strtotime("+$durasi minutes", $mulai);

    // skip istirahat
    if($mulai < strtotime("12:30") && $selesai > strtotime("12:30")){
        $selesai = strtotime("+30 minutes", $selesai);
    }

    $jam_selesai = date("H:i", $selesai);

    if($jam_mulai >= $jam_selesai){
        echo "<script>alert('Jam tidak valid');history.back();</script>";
        exit;
    }

    # ================= CEK BENTROK =================
    $cek = mysqli_query($conn,"
        SELECT * FROM jadwal 
        WHERE hari='$hari'
        AND id_tahun_ajar='$id_tahun_aktif'
        AND (
            id_ruangan='$id_ruangan' OR
            id_dosen='$id_dosen' OR
            id_kelas='$id_kelas'
        )
        AND (
            jam_mulai < '$jam_selesai'
            AND jam_selesai > '$jam_mulai'
        )
    ");

    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('❌ Jadwal bentrok (ruangan/dosen/kelas)!');history.back();</script>";
        exit;
    }

    # ================= INSERT =================
    $sql = mysqli_query($conn,"
        INSERT INTO jadwal
        (hari, jam_mulai, jam_selesai, id_ruangan, id_mk_prodi, id_dosen, id_kelas, id_tahun_ajar)
        VALUES(
            '$hari',
            '$jam_mulai',
            '$jam_selesai',
            '$id_ruangan',
            '$id_mk_prodi',
            '$id_dosen',
            '$id_kelas',
            '$id_tahun_aktif'
        )
    ");

    if(!$sql){
        die("Error insert: " . mysqli_error($conn));
    }

    echo "<script>alert('Berhasil ditambahkan');location='index.php?menu=kelola_jadwal';</script>";
}
?>

<!-- ================= FORM ================= -->
<div class="p-6">
<h2 class="text-xl font-bold mb-4">Tambah Jadwal</h2>

<form method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">

    <!-- INFO TAHUN -->
    <div class="text-sm text-gray-600">
        Tahun Ajar Aktif:
        <b><?= $tahun_aktif['tahun'] ?> (<?= $tahun_aktif['semester'] ?>)</b>
    </div>

    <!-- HARI -->
    <select name="hari" class="w-full border p-2 rounded" required>
        <option value="">Pilih Hari</option>
        <option>Senin</option>
        <option>Selasa</option>
        <option>Rabu</option>
        <option>Kamis</option>
        <option>Jumat</option>
    </select>

    <!-- JAM MULAI -->
    <input type="time" name="jam_mulai" class="w-full border p-2 rounded" required>

    <!-- RUANGAN -->
    <select name="id_ruangan" class="w-full border p-2 rounded" required>
        <option value="">Pilih Ruangan</option>
        <?php while($r = mysqli_fetch_assoc($ruangan_data)){ ?>
            <option value="<?= $r['id_ruangan'] ?>">
                <?= $r['nama_ruangan'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- MATA KULIAH -->
    <select name="id_mk_prodi" class="w-full border p-2 rounded" required>
        <option value="">Pilih Mata Kuliah</option>
        <?php while($m = mysqli_fetch_assoc($mk_data)){ ?>
            <option value="<?= $m['id_mk_prodi'] ?>">
                <?= $m['nama_mk'] ?> (<?= $m['sks'] ?> SKS)
            </option>
        <?php } ?>
    </select>

    <!-- DOSEN -->
    <select name="id_dosen" class="w-full border p-2 rounded" required>
        <option value="">Pilih Dosen</option>
        <?php while($d = mysqli_fetch_assoc($dosen_data)){ ?>
            <option value="<?= $d['id_dosen'] ?>">
                <?= $d['nama_dosen'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- KELAS -->
    <select name="id_kelas" class="w-full border p-2 rounded" required>
        <option value="">Pilih Kelas</option>
        <?php while($k = mysqli_fetch_assoc($kelas_data)){ ?>
            <option value="<?= $k['id_kelas'] ?>">
                <?= $k['nama_kelas'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- INFO -->
    <p class="text-sm text-gray-500">
        Durasi otomatis berdasarkan SKS (1 SKS = 50 menit)
    </p>

    <!-- BUTTON -->
    <button name="simpan" class="bg-blue-500 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>
</div>