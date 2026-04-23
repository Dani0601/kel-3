<?php
require_once __DIR__ . '/../config/koneksi.php';

$id_user = $_SESSION['id_user'] ?? 0;

if(!$id_user){
    echo "<div class='text-red-500'>❌ Kamu belum login</div>";
    return;
}

/* ======================
AMBIL DATA DOSEN
====================== */
$q = $conn->query("SELECT * FROM dosen WHERE id_user='$id_user'");
$dosen = $q->fetch_assoc();

if(!$dosen){
    echo "<div class='text-red-500'>❌ Data dosen tidak ditemukan</div>";
    return;
}

/* ======================
AMBIL INPUT (GET FILTER)
====================== */
$hari        = $_GET['hari'] ?? '';
$jam_mulai   = $_GET['jam_mulai'] ?? '';
$id_mk       = $_GET['id_mk'] ?? '';
$id_gedung   = $_GET['id_gedung'] ?? '';

$jam_selesai = "";

/* ======================
HITUNG JAM SELESAI
====================== */
if($id_mk && $jam_mulai){
    $get = $conn->query("SELECT sks FROM mata_kuliah WHERE id_mk='$id_mk'");
    $d = $get->fetch_assoc();

    if($d){
        $durasi = $d['sks'] * 50;
        $mulai = new DateTime($jam_mulai);
        $mulai->modify("+$durasi minutes");
        $jam_selesai = $mulai->format("H:i");
    }
}

/* ======================
FILTER RUANGAN
====================== */
$where = "";

if($hari && $jam_mulai && $jam_selesai){
    $where = "
    WHERE r.id_ruangan NOT IN (

        SELECT id_ruangan FROM booking_ruangan
        WHERE tanggal_booking = CURDATE()
        AND NOT (
            jam_selesai <= '$jam_mulai' 
            OR jam_mulai >= '$jam_selesai'
        )

        UNION

        SELECT id_ruangan FROM jadwal
        WHERE hari='$hari'
        AND NOT (
            jam_selesai <= '$jam_mulai' 
            OR jam_mulai >= '$jam_selesai'
        )

    )
    ";
}

/* FILTER GEDUNG */
if($id_gedung){
    $where .= ($where ? " AND " : " WHERE ") . "r.id_gedung='$id_gedung'";
}

$ruangan = $conn->query("SELECT * FROM ruangan r $where");

/* DROPDOWN */
$gedung = $conn->query("SELECT * FROM gedung");
$mk     = $conn->query("SELECT * FROM mata_kuliah");

$jamList = ["07:30","08:20","09:10","10:00","10:50","11:40","13:00","13:50","14:40","15:30","16:20","17:10"];
?>

<div class="p-6">
<h2 class="text-2xl font-bold mb-6">📌 Booking Ruangan</h2>

<form method="GET" class="bg-white p-6 rounded-xl shadow space-y-4">

<!-- WAJIB: BIAR TIDAK BALIK KE HOME -->
<input type="hidden" name="menu" value="booking_ruangan">

<!-- DOSEN -->
<div class="bg-gray-100 p-3 rounded">
<b><?= $dosen['nama_dosen'] ?></b><br>
<span class="text-sm text-gray-600">NIDN: <?= $dosen['nidn'] ?></span>
</div>

<!-- HARI -->
<select name="hari" onchange="this.form.submit()" class="w-full border p-2 rounded">
<option value="">Pilih Hari</option>
<?php foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h){ ?>
<option value="<?= $h ?>" <?= ($hari==$h)?'selected':'' ?>><?= $h ?></option>
<?php } ?>
</select>

<!-- GEDUNG -->
<select name="id_gedung" onchange="this.form.submit()" class="w-full border p-2 rounded">
<option value="">Semua Gedung</option>
<?php while($g = $gedung->fetch_assoc()){ ?>
<option value="<?= $g['id_gedung'] ?>" <?= ($id_gedung==$g['id_gedung'])?'selected':'' ?>>
<?= $g['nama_gedung'] ?>
</option>
<?php } ?>
</select>

<!-- JAM -->
<select name="jam_mulai" onchange="this.form.submit()" class="w-full border p-2 rounded">
<option value="">Pilih Jam</option>
<?php foreach($jamList as $j){ ?>
<option value="<?= $j ?>" <?= ($jam_mulai==$j)?'selected':'' ?>><?= $j ?></option>
<?php } ?>
</select>

<!-- MATA KULIAH -->
<select name="id_mk" onchange="this.form.submit()" class="w-full border p-2 rounded">
<option value="">Pilih Mata Kuliah</option>
<?php while($m = $mk->fetch_assoc()){ ?>
<option value="<?= $m['id_mk'] ?>" <?= ($id_mk==$m['id_mk'])?'selected':'' ?>>
<?= $m['nama_mk'] ?> (<?= $m['sks'] ?> SKS)
</option>
<?php } ?>
</select>

<!-- RUANGAN -->
<select name="id_ruangan" class="w-full border p-2 rounded" required>
<option value="">Pilih Ruangan</option>

<?php if($ruangan && $ruangan->num_rows > 0){ ?>
<?php while($r = $ruangan->fetch_assoc()){ ?>
<option value="<?= $r['id_ruangan'] ?>">
<?= $r['nama_ruangan'] ?>
</option>
<?php } ?>
<?php } else { ?>
<option disabled>❌ Tidak tersedia</option>
<?php } ?>

</select>

<!-- KETERANGAN -->
<textarea name="keterangan" class="w-full border p-2 rounded" placeholder="Keterangan"></textarea>

<!-- SUBMIT -->
<button 
formaction="dosen/proses_booking.php" 
formmethod="POST"
class="bg-green-600 text-white px-4 py-2 rounded w-full">
Booking Sekarang
</button>

</form>
</div>