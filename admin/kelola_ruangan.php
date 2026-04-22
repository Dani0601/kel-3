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
            Manajemen gedung dan ruangan realtime
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
<div class="p-4 border-b">
<h3 class="font-semibold">Data Gedung</h3>
</div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 text-xs uppercase">
<tr>
<th class="px-4 py-3">ID</th>
<th class="px-4 py-3 text-center">Nama Gedung</th>
<th class="px-4 py-3 text-center">Lantai</th>
<th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>
<tbody id="gedungBody" class="divide-y"></tbody>
</table>
</div>
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

<!-- ================= CHART ================= -->
<div class="grid md:grid-cols-3 gap-6">

<div class="bg-white p-4 rounded-2xl shadow">
<h4 class="font-semibold mb-2">Ruangan per Gedung</h4>
<canvas id="chartGedung"></canvas>
</div>

<div class="bg-white p-4 rounded-2xl shadow">
<h4 class="font-semibold mb-2">Kapasitas</h4>
<canvas id="chartKap"></canvas>
</div>

<div class="bg-white p-4 rounded-2xl shadow">
<h4 class="font-semibold mb-2">Distribusi Gedung</h4>
<canvas id="chartPie"></canvas>
</div>

</div>

<!-- ================= RUANGAN ================= -->
<div class="bg-white rounded-2xl shadow overflow-hidden">
<div class="p-4 border-b">
<h3 class="font-semibold">Data Ruangan</h3>
</div>

<div class="overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 text-xs uppercase">
<tr>
<th class="px-4 py-3">Gedung</th>
<th class="px-4 py-3 text-center">Lantai</th>
<th class="px-4 py-3">Ruangan</th>
<th class="px-4 py-3 text-center">Kapasitas</th>
</tr>
</thead>
<tbody id="tbody" class="divide-y"></tbody>
</table>
</div>
</div>

<div id="pagination" class="flex gap-2"></div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let page=1;
let chartGedung,chartKap,chartPie;

/* ================= LOAD GEDUNG ================= */
function loadGedung(){
fetch('admin/ajax_gedung.php')
.then(res=>res.json())
.then(data=>{

let html='';
let opt='<option value="">Semua Gedung</option>';

data.forEach(g=>{
html+=`
<tr class="hover:bg-gray-50">

<td class="px-4 py-3">${g.id_gedung}</td>

<td class="text-center">
<input value="${g.nama_gedung}" id="nama_${g.id_gedung}" class="border p-1 rounded w-32">
<button onclick="updateGedung(${g.id_gedung})" class="text-blue-500">Save</button>
</td>

<td class="text-center">
<span class="bg-blue-100 px-2 py-1 rounded text-xs">${g.jumlah_lantai}</span>
</td>

<td class="text-center">
<a href="admin/hapus_gedung.php?id=${g.id_gedung}" onclick="return confirm('Hapus?')" class="text-red-500">Hapus</a>
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
.then(res=>res.text())
.then(alert);
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
html=`<tr><td colspan="4" class="text-center p-4 text-gray-400">Tidak ada data</td></tr>`;
}else{
res.data.forEach(r=>{
html+=`
<tr class="hover:bg-gray-50">
<td>${r.nama_gedung}</td>
<td class="text-center">${r.lantai}</td>
<td class="font-semibold">${r.nama_ruangan}</td>
<td class="text-center">
<input type="number" value="${r.kapasitas}"
onchange="updateKapasitas(${r.id_ruangan},this.value)"
class="border w-16 text-center">
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
pag+=`<button onclick="goPage(${i})" class="px-3 py-1 border ${i==page?'bg-blue-500 text-white':''}">${i}</button>`;
}

pagination.innerHTML=pag;

/* UPDATE CHART */
updateChart(res);

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

/* ================= CHART ================= */
function updateChart(res){

if(chartGedung) chartGedung.destroy();
if(chartKap) chartKap.destroy();
if(chartPie) chartPie.destroy();

chartGedung=new Chart(document.getElementById('chartGedung'),{
type:'bar',
data:{
labels:res.chartGedung.label,
datasets:[{data:res.chartGedung.data}]
}
});

chartKap=new Chart(document.getElementById('chartKap'),{
type:'line',
data:{
labels:res.chartKap.label,
datasets:[{data:res.chartKap.data}]
}
});

chartPie=new Chart(document.getElementById('chartPie'),{
type:'pie',
data:{
labels:res.chartPie.label,
datasets:[{data:res.chartPie.data}]
}
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