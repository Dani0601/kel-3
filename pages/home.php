<div class="container mt-5">

<div class="text-center mb-5 hero-title">
<h1 class="fw-bold">Smart Room Monitoring System</h1>
<div class="title-line"></div>

<p class="text-muted">
Smart Room Monitoring System adalah aplikasi berbasis web untuk
mengelola jadwal ruangan, menampilkan informasi ruangan,
serta menyampaikan pengumuman secara digital.
</p>
</div>


<div class="row g-4 justify-content-center">

<!-- Card 1 -->
<div class="col-md-4">
<div class="card3d">
<div class="card-body text-center">
<div class="icon">📅</div>
<h5 class="fw-bold mt-3">Manajemen Jadwal</h5>
<p class="text-muted">
Mengatur jadwal penggunaan ruangan secara
terstruktur dan mudah diakses.
</p>
</div>
</div>
</div>


<!-- Card 2 -->
<div class="col-md-4">
<div class="card3d">
<div class="card-body text-center">
<div class="icon">📢</div>
<h5 class="fw-bold mt-3">Pengumuman</h5>
<p class="text-muted">
Memberikan informasi penting kepada pengguna
secara cepat dan efisien.
</p>
</div>
</div>
</div>


<!-- Card 3 -->
<div class="col-md-4">
<div class="card3d">
<div class="card-body text-center">
<div class="icon">🏫</div>
<h5 class="fw-bold mt-3">Informasi Ruangan</h5>
<p class="text-muted">
Menampilkan fasilitas dan status ruangan
secara digital dan real-time.
</p>
</div>
</div>
</div>

</div>

</div>


<style>

/* background */

body{
background: linear-gradient(180deg,#f8f9fa,#eef2f7);
}


/* garis dekoratif judul */

.title-line{
width:80px;
height:4px;
background:#0d6efd;
margin:15px auto 20px auto;
border-radius:5px;
}


/* CARD 3D */

.card3d{
background:white;
border-radius:18px;
padding:20px;
position:relative;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
transition:all 0.35s ease;
transform-style:preserve-3d;
}


/* glow effect */

.card3d::before{
content:"";
position:absolute;
top:-50%;
left:-50%;
width:200%;
height:200%;
background:radial-gradient(circle, rgba(13,110,253,0.08), transparent 60%);
opacity:0;
transition:opacity 0.4s;
}

.card3d:hover::before{
opacity:1;
}


/* hover 3D */

.card3d:hover{
transform: translateY(-10px) scale(1.03) rotateX(5deg) rotateY(5deg);
box-shadow:0 30px 60px rgba(0,0,0,0.15);
}


/* icon */

.icon{
font-size:42px;
transition:transform 0.3s;
}

.card3d:hover .icon{
transform:scale(1.2) rotate(5deg);
}

</style>