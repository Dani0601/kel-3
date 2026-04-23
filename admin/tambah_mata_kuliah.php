<?php
include __DIR__ . '/../config/koneksi.php';

/* ambil data */
$mk_list = mysqli_query($conn,"SELECT * FROM mata_kuliah ORDER BY nama_mk");
$prodi   = mysqli_query($conn,"SELECT * FROM prodi");

/* ================= SIMPAN ================= */
if(isset($_POST['simpan'])){

    $mode      = $_POST['mode']; // lama / baru
    $id_mk     = $_POST['id_mk'] ?? '';
    $kode_mk   = $_POST['kode_mk'] ?? '';
    $nama_mk   = $_POST['nama_mk'] ?? '';
    $sks       = $_POST['sks'] ?? 0;
    $prodi_ids = $_POST['prodi'] ?? [];
    $semester  = $_POST['semester'];

    /* VALIDASI */
    if(empty($prodi_ids)){
        echo "<script>alert('Pilih minimal 1 prodi');history.back();</script>";
        exit;
    }

    /* ================= MODE BARU ================= */
    if($mode == 'baru'){

        $cek = mysqli_query($conn,"
            SELECT * FROM mata_kuliah 
            WHERE kode_mk='$kode_mk' OR nama_mk='$nama_mk'
        ");

        if(mysqli_num_rows($cek) > 0){
            echo "<script>alert('MK sudah ada');history.back();</script>";
            exit;
        }

        mysqli_query($conn,"
            INSERT INTO mata_kuliah(kode_mk,nama_mk,sks)
            VALUES('$kode_mk','$nama_mk','$sks')
        ");

        $id_mk = mysqli_insert_id($conn);
    }

    /* ================= ASSIGN PRODI ================= */
    foreach($prodi_ids as $p){

        $cek = mysqli_query($conn,"
            SELECT * FROM mk_prodi
            WHERE id_mk='$id_mk'
            AND id_prodi='$p'
            AND semester='$semester'
        ");

        if(mysqli_num_rows($cek) == 0){

            mysqli_query($conn,"
                INSERT INTO mk_prodi(id_mk,id_prodi,semester)
                VALUES('$id_mk','$p','$semester')
            ");
        }
    }

    echo "<script>alert('Berhasil disimpan');location='index.php?menu=kelola_mata_kuliah';</script>";
}
?>

<div class="p-6">
<h2 class="text-xl font-bold mb-4">Tambah Mata Kuliah</h2>

<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

<select name="mode" id="mode" class="border p-2 rounded w-full">
<option value="lama">Pilih MK Lama</option>
<option value="baru">Tambah MK Baru</option>
</select>

<!-- MK lama -->
<div id="mk_lama">
<select name="id_mk" class="border p-2 rounded w-full">
<option value="">-- Pilih MK --</option>
<?php while($m=mysqli_fetch_assoc($mk_list)){ ?>
<option value="<?= $m['id_mk'] ?>">
<?= $m['nama_mk'] ?> (<?= $m['sks'] ?> SKS)
</option>
<?php } ?>
</select>
</div>

<!-- MK baru -->
<div id="mk_baru" style="display:none;">
<input type="text" name="kode_mk" placeholder="Kode MK" class="border p-2 w-full">
<input type="text" name="nama_mk" placeholder="Nama MK" class="border p-2 w-full">
<input type="number" name="sks" placeholder="SKS" class="border p-2 w-full">
</div>

<!-- PRODI MULTI -->
<div>
<label class="font-semibold">Pilih Prodi</label>
<?php while($p=mysqli_fetch_assoc($prodi)){ ?>
<div>
<input type="checkbox" name="prodi[]" value="<?= $p['id_prodi'] ?>">
<?= $p['nama_prodi'] ?>
</div>
<?php } ?>
</div>

<!-- SEMESTER -->
<select name="semester" class="border p-2 rounded w-full">
<?php for($i=1;$i<=8;$i++){ ?>
<option value="<?= $i ?>">Semester <?= $i ?></option>
<?php } ?>
</select>

<button name="simpan" class="bg-blue-500 text-white px-4 py-2 rounded">
Simpan
</button>

</form>
</div>

<script>
document.getElementById("mode").addEventListener("change", function(){
    document.getElementById("mk_lama").style.display = this.value=="lama"?"block":"none";
    document.getElementById("mk_baru").style.display = this.value=="baru"?"block":"none";
});
</script>