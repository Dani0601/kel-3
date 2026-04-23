<?php
include __DIR__ . '/../config/koneksi.php';

$id = $_GET['id'];

/* ================= DATA MK ================= */
$mk = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM mata_kuliah WHERE id_mk='$id'
"));

if(!$mk){
    echo "Data tidak ditemukan";
    exit;
}

/* ================= DATA PRODI ================= */
$prodi = mysqli_query($conn,"SELECT * FROM prodi");

/* ================= RELASI ================= */
$relasi = mysqli_query($conn,"
    SELECT mp.*, p.nama_prodi
    FROM mk_prodi mp
    JOIN prodi p ON mp.id_prodi = p.id_prodi
    WHERE mp.id_mk='$id'
");

/* ================= UPDATE MK ================= */
if(isset($_POST['update_mk'])){

    $kode = $_POST['kode_mk'];
    $nama = $_POST['nama_mk'];
    $sks  = $_POST['sks'];

    mysqli_query($conn,"
        UPDATE mata_kuliah
        SET kode_mk='$kode',
            nama_mk='$nama',
            sks='$sks'
        WHERE id_mk='$id'
    ");

    echo "<script>alert('MK berhasil diupdate');location='';</script>";
}

/* ================= TAMBAH RELASI ================= */
if(isset($_POST['tambah_relasi'])){

    $prodi_ids = $_POST['prodi'] ?? [];
    $semester  = $_POST['semester'];

    if(empty($prodi_ids)){
        echo "<script>alert('Pilih minimal 1 prodi');</script>";
    } else {

        foreach($prodi_ids as $p){

            $cek = mysqli_query($conn,"
                SELECT * FROM mk_prodi
                WHERE id_mk='$id'
                AND id_prodi='$p'
                AND semester='$semester'
            ");

            if(mysqli_num_rows($cek) == 0){

                mysqli_query($conn,"
                    INSERT INTO mk_prodi(id_mk,id_prodi,semester)
                    VALUES('$id','$p','$semester')
                ");
            }
        }

        echo "<script>alert('Relasi ditambahkan');location='';</script>";
    }
}

/* ================= HAPUS RELASI ================= */
if(isset($_GET['hapus_relasi'])){
    $id_relasi = $_GET['hapus_relasi'];

    mysqli_query($conn,"
        DELETE FROM mk_prodi WHERE id_mk_prodi='$id_relasi'
    ");

    echo "<script>location='index.php?menu=edit_mata_kuliah&id=$id';</script>";
}
?>

<div class="p-6 space-y-6">

<h2 class="text-2xl font-bold">Edit Mata Kuliah</h2>

<!-- ================= EDIT MK ================= -->
<form method="POST" class="bg-white p-6 rounded shadow space-y-3">

<h3 class="font-semibold">Data Mata Kuliah</h3>

<input type="text" name="kode_mk"
value="<?= $mk['kode_mk'] ?>"
class="border p-2 w-full">

<input type="text" name="nama_mk"
value="<?= $mk['nama_mk'] ?>"
class="border p-2 w-full">

<input type="number" name="sks"
value="<?= $mk['sks'] ?>"
class="border p-2 w-full">

<button name="update_mk"
class="bg-blue-500 text-white px-4 py-2 rounded">
Update MK
</button>

</form>

<!-- ================= RELASI EXISTING ================= -->
<div class="bg-white p-6 rounded shadow">

<h3 class="font-semibold mb-3">Relasi Prodi & Semester</h3>

<table class="w-full text-sm">
<thead class="bg-gray-100">
<tr>
<th class="p-2">Prodi</th>
<th class="p-2">Semester</th>
<th class="p-2 text-center">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($relasi)>0){ ?>
<?php while($r=mysqli_fetch_assoc($relasi)){ ?>

<tr class="border-b">

<td class="p-2"><?= $r['nama_prodi'] ?></td>
<td class="p-2">Semester <?= $r['semester'] ?></td>

<td class="p-2 text-center">
<a href="index.php?menu=edit_mata_kuliah&id=<?= $id ?>&hapus_relasi=<?= $r['id_mk_prodi'] ?>"
onclick="return confirm('Hapus relasi?')"
class="text-red-500">
Hapus
</a>
</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="3" class="text-center p-3 text-gray-400">
Belum ada relasi
</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

<!-- ================= TAMBAH RELASI ================= -->
<form method="POST" class="bg-white p-6 rounded shadow space-y-4">

<h3 class="font-semibold">Tambah Relasi</h3>

<div>
<label class="font-semibold">Pilih Prodi</label>

<?php mysqli_data_seek($prodi,0); while($p=mysqli_fetch_assoc($prodi)){ ?>
<div>
<input type="checkbox" name="prodi[]" value="<?= $p['id_prodi'] ?>">
<?= $p['nama_prodi'] ?>
</div>
<?php } ?>

</div>

<select name="semester" class="border p-2 w-full">
<?php for($i=1;$i<=8;$i++){ ?>
<option value="<?= $i ?>">Semester <?= $i ?></option>
<?php } ?>
</select>

<button name="tambah_relasi"
class="bg-green-500 text-white px-4 py-2 rounded">
Tambah Relasi
</button>

</form>

</div>