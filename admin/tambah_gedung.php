<?php
if($_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}
?>

<div class="p-6 max-w-5xl mx-auto space-y-6">

<!-- HEADER -->
<div>
    <h2 class="text-2xl font-bold text-gray-800">Tambah Gedung</h2>
    <p class="text-sm text-gray-500">Buat gedung sekaligus generate ruangan</p>
</div>

<form action="admin/simpan_gedung.php" method="POST" class="space-y-6">

<!-- ================= GEDUNG ================= -->
<div class="bg-white p-6 rounded-2xl shadow space-y-4">

<h3 class="font-semibold text-gray-700">Data Gedung</h3>

<input type="text" name="nama_gedung"
placeholder="Nama Gedung"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-400" required>

<input type="number" name="jumlah_lantai" id="maxLantai"
placeholder="Jumlah Lantai"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-400" required>

</div>

<!-- ================= RUANGAN ================= -->
<div class="bg-white p-6 rounded-2xl shadow space-y-4">

<div class="flex justify-between items-center">
<h3 class="font-semibold text-gray-700">Generate Ruangan</h3>

<button type="button" onclick="tambahRow()"
class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
+ Tambah
</button>
</div>

<div id="wrapper" class="space-y-4">

<!-- ROW AWAL -->
<div class="space-y-2 border p-3 rounded-lg bg-gray-50">

<div class="grid grid-cols-4 gap-2">

<input type="text" name="kode[]"
placeholder="Kode (R / Lab / Auditorium)"
class="border p-2 rounded" required>

<input type="number" name="lantai[]"
placeholder="Lantai"
class="border p-2 rounded lantaiInput" required>

<input type="number" name="jumlah[]"
placeholder="Jumlah"
class="border p-2 rounded jumlahInput" required>

<input type="number" name="kapasitas[]"
placeholder="Kapasitas"
class="border p-2 rounded" required>

</div>

<div class="text-sm text-gray-500 preview"></div>

</div>

</div>

</div>

<!-- ================= BUTTON ================= -->
<div class="flex justify-end gap-2">

<a href="index.php?menu=kelola_ruangan"
class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
Batal
</a>

<button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
Simpan
</button>

</div>

</form>

</div>

<script>
function tambahRow(){

    const wrapper = document.getElementById('wrapper');

    const html = `
    <div class="space-y-2 border p-3 rounded-lg bg-gray-50">

        <div class="grid grid-cols-4 gap-2">

            <input type="text" name="kode[]" placeholder="Kode"
            class="border p-2 rounded" required>

            <input type="number" name="lantai[]" placeholder="Lantai"
            class="border p-2 rounded" required>

            <input type="number" name="jumlah[]" placeholder="Jumlah"
            class="border p-2 rounded" required>

            <input type="number" name="kapasitas[]" placeholder="Kapasitas"
            class="border p-2 rounded" required>

        </div>

        <div class="text-sm text-gray-500 preview"></div>

    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
}

/* ================= VALIDASI + PREVIEW ================= */
document.addEventListener('input', function(){

    const max = document.getElementById('maxLantai').value;

    document.querySelectorAll('#wrapper > div').forEach(row => {

        const kode = row.querySelector('[name="kode[]"]').value;
        const lantai = row.querySelector('[name="lantai[]"]').value;
        const jumlah = row.querySelector('[name="jumlah[]"]').value;
        const preview = row.querySelector('.preview');

        if(lantai && max && lantai > max){
            alert("Lantai melebihi jumlah lantai gedung!");
            row.querySelector('[name="lantai[]"]').value = '';
            return;
        }

        if(kode && lantai && jumlah){

            let awal = kode + " " + lantai + "01";
            let akhir = kode + " " + lantai + String(jumlah).padStart(2,'0');

            preview.innerHTML = `
            <span class="text-blue-600 font-medium">
            Preview: ${awal} - ${akhir}
            </span>
            `;
        }else{
            preview.innerHTML = '';
        }

    });

});
</script>