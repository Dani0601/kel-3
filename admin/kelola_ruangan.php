<?php 
require_once __DIR__ . '/../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header("Location: ../index.php");
    exit();
}
?>

<div class="p-6 space-y-6">

<div class="flex justify-between items-center mb-6">

    <div>
        <h2 class="text-2xl font-bold text-gray-800">
            Kelola Gedung & Ruangan
        </h2>
        <p class="text-sm text-gray-500">
            Manajemen gedung dan ruangan secara realtime
        </p>
    </div>

    <a href="index.php?menu=tambah_gedung"
    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl shadow flex items-center gap-2">
        <span class="text-lg">+</span>
        Tambah Gedung
    </a>

</div>

<!-- ================= GEDUNG ================= -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
<div class="p-4 border-b flex justify-between items-center">
<h3 class="font-semibold text-gray-700">Data Gedung</h3>
</div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 text-xs uppercase text-gray-600">
<tr>
<th class="px-4 py-3 text-center w-16">ID</th>
<th class="px-4 py-3 text-left">Nama Gedung</th>
<th class="px-4 py-3 text-center w-24">Lantai</th>
<th class="px-4 py-3 text-center w-32">Aksi</th>
</tr>
</thead>

<tbody id="gedungBody" class="divide-y text-gray-700"></tbody>

</table>
</div>
</div>


<!-- ================= RUANGAN ================= -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
<div class="p-4 border-b">
<h3 class="font-semibold text-gray-700">Data Ruangan</h3>
</div>

<!-- ================= FILTER ================= -->
<div class="bg-white p-4 rounded-2xl shadow flex flex-wrap gap-3">

<select id="fGedung" class="border rounded px-3 py-2"></select>

<select id="fLantai" class="border rounded px-3 py-2">
<option value="">Semua Lantai</option>
<?php for($i=1;$i<=10;$i++){ ?>
<option value="<?= $i ?>">Lantai <?= $i ?></option>
<?php } ?>
</select>

<input id="search" placeholder="Cari ruangan..."
class="border rounded px-3 py-2 w-60">

<select id="limit" class="border rounded px-3 py-2">
<option value="5">5</option>
<option value="10" selected>10</option>
<option value="20">20</option>
</select>

</div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 text-xs uppercase text-gray-600">
<tr>
<th class="px-4 py-3 text-left">Gedung</th>
<th class="px-4 py-3 text-center w-24">Lantai</th>
<th class="px-4 py-3 text-left">Ruangan</th>
<th class="px-4 py-3 text-center w-32">Kapasitas</th>
</tr>
</thead>

<tbody id="tbody" class="divide-y text-gray-700"></tbody>

</table>
</div>
</div>

<div id="pagination" class="flex justify-center gap-2 mt-4"></div>

</div>

<script>
let page=1;

/* ================= LOAD GEDUNG ================= */
function loadGedung(){
fetch('admin/ajax_gedung.php')
.then(res=>res.json())
.then(data=>{

let html='';
let opt='<option value="">Semua Gedung</option>';

data.forEach(g=>{
html+=`
<tr class="hover:bg-gray-50 transition">

<td class="px-4 py-3 text-center font-medium text-gray-600">
${g.id_gedung}
</td>

<td class="px-4 py-3">
<div class="flex items-center gap-2">
<input value="${g.nama_gedung}" id="nama_${g.id_gedung}"
class="border px-2 py-1 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none w-full">

<button onclick="updateGedung(${g.id_gedung})"
class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs transition">
Save
</button>
</div>
</td>

<td class="px-4 py-3 text-center">
<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-medium">
${g.jumlah_lantai}
</span>
</td>

<td class="px-4 py-3 text-center">
<button 
onclick="openDeleteModal('admin/hapus_gedung.php?id=${g.id_gedung}', 'Hapus Gedung?')"
class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs hover:bg-red-200 transition">
Hapus
</button>
</td>

</tr>
`;
opt+=`<option value="${g.id_gedung}">${g.nama_gedung}</option>`;
});

gedungBody.innerHTML=html;
fGedung.innerHTML=opt;

});
}

/* ================= UPDATE GEDUNG ================= */
function updateGedung(id){
let nama=document.getElementById('nama_'+id).value;

fetch('admin/update_gedung.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`id=${id}&nama=${encodeURIComponent(nama)}`
})
.then(()=>alert("Berhasil disimpan"));
}

/* ================= LOAD DATA ================= */
function loadData(){

let g=fGedung.value;
let l=fLantai.value;
let s=search.value;
let limit=document.getElementById('limit').value;

fetch(`admin/ajax_ruangan.php?gedung=${g}&lantai=${l}&search=${s}&page=${page}&limit=${limit}`)
.then(res=>res.json())
.then(res=>{

let html='';

if(res.data.length===0){
html=`
<tr>
<td colspan="4" class="text-center py-8 text-gray-400">
<div class="flex flex-col items-center gap-2">
<span class="text-2xl">📭</span>
<span>Tidak ada data</span>
</div>
</td>
</tr>
`;
}else{
res.data.forEach(r=>{
html+=`
<tr class="hover:bg-gray-50 transition">

<td class="px-4 py-3 font-medium text-gray-700">
${r.nama_gedung}
</td>

<td class="px-4 py-3 text-center">
<span class="bg-gray-100 px-2 py-1 rounded-full text-xs">
${r.lantai}
</span>
</td>

<td class="px-4 py-3 font-semibold">
${r.nama_ruangan}
</td>

<td class="px-4 py-3 text-center">
<input type="number" value="${r.kapasitas}"
onchange="updateKapasitas(${r.id_ruangan},this.value)"
class="border px-2 py-1 rounded-lg text-center w-20 focus:ring-2 focus:ring-blue-400 outline-none">
</td>

</tr>
`;
});
}

tbody.innerHTML=html;

/* PAGINATION */
let totalPage=Math.ceil(res.total/limit);
let pag='';

for(let i=1;i<=totalPage;i++){
pag+=`<button onclick="goPage(${i})" class="px-3 py-1 rounded-lg border hover:bg-blue-100 transition ${i==page?'bg-blue-500 text-white':''}">${i}</button>`;
}

pagination.innerHTML=pag;

});
}

/* ================= UPDATE KAPASITAS ================= */
function updateKapasitas(id,val){
fetch('admin/update_ruangan.php',{
method:'POST',
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:`id=${id}&kapasitas=${val}`
});
}

/* EVENT */
fGedung.onchange=()=>{page=1;loadData()};
fLantai.onchange=()=>{page=1;loadData()};
limit.onchange=()=>{page=1;loadData()};

let t;
search.onkeyup=()=>{
clearTimeout(t);
t=setTimeout(()=>{page=1;loadData()},300);
};

function goPage(p){page=p;loadData();}

/* INIT */
loadGedung();
loadData();
</script>