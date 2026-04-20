<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

# ================= AMBIL DATA DROPDOWN =================
$ruangan = mysqli_query($conn,"SELECT * FROM ruangan");
$dosen = mysqli_query($conn,"SELECT * FROM dosen");
$kelas = mysqli_query($conn,"SELECT * FROM kelas");
$tahun = mysqli_query($conn,"SELECT * FROM tahun_ajaran");

$mk = mysqli_query($conn,"
    SELECT mk_prodi.*, mata_kuliah.nama_mk
    FROM mk_prodi
    JOIN mata_kuliah ON mk_prodi.id_mk = mata_kuliah.id_mk
");

# ================= SIMPAN =================
if(isset($_POST['simpan'])){

    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $ruangan = $_POST['id_ruangan'];
    $mk = $_POST['id_mk_prodi'];

    $id_dosen = $_POST['id_dosen'];
    $id_kelas = $_POST['id_kelas'];
    $id_tahun = $_POST['id_tahun_ajar'];

    # VALIDASI JAM
    if($jam_mulai >= $jam_selesai){
        echo "<script>alert('Jam tidak valid');history.back();</script>";
        exit;
    }

    # CEK BENTROK RUANGAN
    $cek = mysqli_query($conn,"
        SELECT * FROM jadwal 
        WHERE hari='$hari'
        AND id_ruangan='$ruangan'
        AND (
            jam_mulai < '$jam_selesai'
            AND jam_selesai > '$jam_mulai'
        )
    ");

    if(mysqli_num_rows($cek) > 0){
        echo "<script>alert('❌ Jadwal bentrok!');history.back();</script>";
        exit;
    }

    # INSERT
    $sql = mysqli_query($conn,"
        INSERT INTO jadwal
        (hari, jam_mulai, jam_selesai, id_ruangan, id_mk_prodi, id_dosen, id_kelas, id_tahun_ajar)
        VALUES(
            '$hari',
            '$jam_mulai',
            '$jam_selesai',
            '$ruangan',
            '$mk',
            '$id_dosen',
            '$id_kelas',
            '$id_tahun'
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

    <!-- HARI -->
    <select name="hari" class="w-full border p-2 rounded" required>
        <option value="">Pilih Hari</option>
        <option>Senin</option>
        <option>Selasa</option>
        <option>Rabu</option>
        <option>Kamis</option>
        <option>Jumat</option>
    </select>

    <!-- JAM -->
    <input type="time" name="jam_mulai" class="w-full border p-2 rounded" required>
    <input type="time" name="jam_selesai" class="w-full border p-2 rounded" required>

    <!-- RUANGAN -->
    <select name="id_ruangan" class="w-full border p-2 rounded" required>
        <option value="">Pilih Ruangan</option>
        <?php while($r = mysqli_fetch_assoc($ruangan)){ ?>
            <option value="<?= $r['id_ruangan'] ?>">
                <?= $r['nama_ruangan'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- MATA KULIAH -->
    <select name="id_mk_prodi" class="w-full border p-2 rounded" required>
        <option value="">Pilih Mata Kuliah</option>
        <?php while($m = mysqli_fetch_assoc($mk)){ ?>
            <option value="<?= $m['id_mk_prodi'] ?>">
                <?= $m['nama_mk'] ?> (Semester <?= $m['semester'] ?>)
            </option>
        <?php } ?>
    </select>

    <!-- DOSEN -->
    <select name="id_dosen" class="w-full border p-2 rounded" required>
        <option value="">Pilih Dosen</option>
        <?php while($d = mysqli_fetch_assoc($dosen)){ ?>
            <option value="<?= $d['id_dosen'] ?>">
                <?= $d['nama_dosen'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- KELAS -->
    <select name="id_kelas" class="w-full border p-2 rounded" required>
        <option value="">Pilih Kelas</option>
        <?php while($k = mysqli_fetch_assoc($kelas)){ ?>
            <option value="<?= $k['id_kelas'] ?>">
                <?= $k['nama_kelas'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- TAHUN AJAR -->
    <select name="id_tahun_ajar" class="w-full border p-2 rounded" required>
        <option value="">Pilih Tahun Ajar</option>
        <?php while($t = mysqli_fetch_assoc($tahun)){ ?>
            <option value="<?= $t['id_tahun_ajar'] ?>">
                <?= $t['tahun'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- BUTTON -->
    <button name="simpan" class="bg-blue-500 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>
</div>