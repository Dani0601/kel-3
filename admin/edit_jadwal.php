<?php
include __DIR__ . '/../config/koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'] ?? 0;

/* ================= AMBIL DATA JADWAL ================= */
$q = mysqli_query($conn,"
    SELECT * FROM jadwal WHERE id_jadwal='$id'
");

$data = mysqli_fetch_assoc($q);

if(!$data){
    die("Data jadwal tidak ditemukan");
}

/* ================= UPDATE DATA ================= */
if(isset($_POST['update'])){

    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    $ruangan = $_POST['id_ruangan'];
    $mk = $_POST['id_mk_prodi'];
    $dosen = $_POST['id_dosen'];
    $kelas = $_POST['id_kelas'];
    $tahun = $_POST['id_tahun_ajar'];

    /* VALIDASI JAM */
    if($jam_mulai >= $jam_selesai){
        header("Location: index.php?menu=edit_jadwal&id=$id&error=jam");
        exit;
    }

    /* CEK BENTROK (opsional tapi bagus) */
    $cek = mysqli_query($conn,"
        SELECT * FROM jadwal 
        WHERE hari='$hari'
        AND id_ruangan='$ruangan'
        AND id_jadwal != '$id'
        AND (
            jam_mulai < '$jam_selesai'
            AND jam_selesai > '$jam_mulai'
        )
    ");

    if(mysqli_num_rows($cek) > 0){
        header("Location: index.php?menu=edit_jadwal&id=$id&error=bentrok");
        exit;
    }

    /* UPDATE */
    $sql = mysqli_query($conn,"
        UPDATE jadwal SET
        hari='$hari',
        jam_mulai='$jam_mulai',
        jam_selesai='$jam_selesai',
        id_ruangan='$ruangan',
        id_mk_prodi='$mk',
        id_dosen='$dosen',
        id_kelas='$kelas',
        id_tahun_ajar='$tahun'
        WHERE id_jadwal='$id'
    ");

    if(!$sql){
        die("Error update: " . mysqli_error($conn));
    }

    header("Location: index.php?menu=kelola_jadwal&msg=update");
    exit;
}

/* ================= DROPDOWN DATA ================= */
$ruangan = mysqli_query($conn,"SELECT * FROM ruangan");
$dosen = mysqli_query($conn,"SELECT * FROM dosen");
$kelas = mysqli_query($conn,"SELECT * FROM kelas");
$tahun = mysqli_query($conn,"SELECT * FROM tahun_ajaran");

$mk = mysqli_query($conn,"
    SELECT mk_prodi.*, mata_kuliah.nama_mk
    FROM mk_prodi
    JOIN mata_kuliah ON mk_prodi.id_mk = mata_kuliah.id_mk
");
?>

<!-- ================= FORM EDIT ================= -->
<div class="p-6">
<h2 class="text-xl font-bold mb-4">Edit Jadwal</h2>

<form method="POST" class="bg-white p-6 rounded-xl shadow space-y-4">

    <!-- HARI -->
    <select name="hari" class="w-full border p-2 rounded" required>
        <option value="Senin" <?= $data['hari']=='Senin'?'selected':'' ?>>Senin</option>
        <option value="Selasa" <?= $data['hari']=='Selasa'?'selected':'' ?>>Selasa</option>
        <option value="Rabu" <?= $data['hari']=='Rabu'?'selected':'' ?>>Rabu</option>
        <option value="Kamis" <?= $data['hari']=='Kamis'?'selected':'' ?>>Kamis</option>
        <option value="Jumat" <?= $data['hari']=='Jumat'?'selected':'' ?>>Jumat</option>
    </select>

    <!-- JAM -->
    <input type="time" name="jam_mulai"
        value="<?= $data['jam_mulai'] ?>"
        class="w-full border p-2 rounded" required>

    <input type="time" name="jam_selesai"
        value="<?= $data['jam_selesai'] ?>"
        class="w-full border p-2 rounded" required>

    <!-- RUANGAN -->
    <select name="id_ruangan" class="w-full border p-2 rounded" required>
        <?php while($r = mysqli_fetch_assoc($ruangan)){ ?>
            <option value="<?= $r['id_ruangan'] ?>"
                <?= $data['id_ruangan']==$r['id_ruangan']?'selected':'' ?>>
                <?= $r['nama_ruangan'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- MATA KULIAH -->
    <select name="id_mk_prodi" class="w-full border p-2 rounded" required>
        <?php while($m = mysqli_fetch_assoc($mk)){ ?>
            <option value="<?= $m['id_mk_prodi'] ?>"
                <?= $data['id_mk_prodi']==$m['id_mk_prodi']?'selected':'' ?>>
                <?= $m['nama_mk'] ?> (Smt <?= $m['semester'] ?>)
            </option>
        <?php } ?>
    </select>

    <!-- DOSEN -->
    <select name="id_dosen" class="w-full border p-2 rounded" required>
        <?php while($d = mysqli_fetch_assoc($dosen)){ ?>
            <option value="<?= $d['id_dosen'] ?>"
                <?= $data['id_dosen']==$d['id_dosen']?'selected':'' ?>>
                <?= $d['nama_dosen'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- KELAS -->
    <select name="id_kelas" class="w-full border p-2 rounded" required>
        <?php while($k = mysqli_fetch_assoc($kelas)){ ?>
            <option value="<?= $k['id_kelas'] ?>"
                <?= $data['id_kelas']==$k['id_kelas']?'selected':'' ?>>
                <?= $k['nama_kelas'] ?>
            </option>
        <?php } ?>
    </select>

    <!-- TAHUN AJAR -->
    <select name="id_tahun_ajar" class="w-full border p-2 rounded" required>
        <?php while($t = mysqli_fetch_assoc($tahun)){ ?>
            <option value="<?= $t['id_tahun_ajar'] ?>"
                <?= $data['id_tahun_ajar']==$t['id_tahun_ajar']?'selected':'' ?>>
                <?= $t['tahun'] ?>
            </option>
        <?php } ?>
    </select>

    <button name="update" class="bg-green-500 text-white px-4 py-2 rounded">
        Update Jadwal
    </button>

</form>
</div>