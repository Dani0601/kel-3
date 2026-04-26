<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Smart Room</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
/* ================= BACKGROUND ================= */
.bg-anim {
    background: linear-gradient(120deg, #4A7FC1, #2F5FA4);
    background-size: 200% 200%;
    animation: gradientMove 10s ease infinite;
}
@keyframes gradientMove {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
}

/* ================= BUBBLE ================= */
.bubble {
    position: absolute;
    border-radius: 50%;
    opacity: 0.15;
    background: white;
    animation: float 12s infinite ease-in-out;
}
@keyframes float {
    0% {transform: translateY(0);}
    50% {transform: translateY(-60px);}
    100% {transform: translateY(0);}
}

/* ================= GLASS ================= */
.glass {
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.2);
}

/* ================= INPUT ================= */
.input:focus {
    transform: scale(1.02);
    box-shadow: 0 0 12px rgba(255,255,255,0.25);
}

/* ================= DOODLE ================= */
.doodle {
    animation: idle 3s ease-in-out infinite;
}
@keyframes idle {
    0%,100% { transform: translateY(0);}
    50% { transform: translateY(-6px);}
}

/* ================= SUCCESS ================= */
.glow {
    filter: drop-shadow(0 0 15px #fff)
            drop-shadow(0 0 25px #60a5fa);
}

.celebrate {
    animation: celebrate 0.6s;
}
@keyframes celebrate {
    0% {transform: translateY(0);}
    40% {transform: translateY(-50px);}
    70% {transform: translateY(10px);}
    100% {transform: translateY(0);}
}

/* ================= LEMPAR TOPI ================= */
.throw-cap {
    animation: throwCap 1s ease-out forwards;
}
@keyframes throwCap {
    0% { transform: translate(0,0) rotate(0); }
    30% { transform: translate(-20px,-120px) rotate(120deg); }
    60% { transform: translate(20px,-80px) rotate(240deg); }
    100% { transform: translate(0,200px) rotate(360deg); opacity: 0; }
}

/* ================= TRANSITION ================= */
.fade-out {
    animation: fadeOut 0.6s forwards;
}
@keyframes fadeOut {
    to {
        opacity: 0;
        transform: scale(1.05);
    }
}

/* tassel */
#tassel {
    transform-origin: top;
    animation: swing 2s infinite ease-in-out;
}
@keyframes swing {
    0% { transform: rotate(5deg); }
    50% { transform: rotate(-10deg); }
    100% { transform: rotate(5deg); }
}
</style>
</head>

<body class="bg-anim min-h-screen flex items-center justify-center relative overflow-hidden">

<!-- BUBBLE -->
<div class="bubble w-40 h-40 top-10 left-10"></div>
<div class="bubble w-64 h-64 bottom-20 right-10" style="animation-delay:2s"></div>
<div class="bubble w-32 h-32 top-1/2 left-1/3" style="animation-delay:4s"></div>

<!-- CONTENT -->
<div class="grid md:grid-cols-2 gap-5 items-center max-w-6xl w-full px-6">

<!-- LEFT -->
<div class="text-white text-center md:text-left space-y-4 space-x-4">
    <img src="../assets/img/logo_putih.png" class="w-80 mx-auto md:mx-0">
    <h1 class="text-7xl font-bold">RuKo</h1>
    <p>Sistem monitoring dan manajemen ruangan modern</p>
</div>

<!-- RIGHT -->
<div class="relative flex items-center justify-center">

<!-- DOODLE -->
<div class="absolute -top-28 left-1/2 -translate-x-1/2">
<svg id="doodle" width="130" height="130" viewBox="0 0 200 200" class="doodle">

    <!-- TOPI -->
    <g id="cap">
        <polygon points="40,60 100,40 160,60 100,80" fill="#111"/>
        <rect x="75" y="60" width="50" height="15" rx="5" fill="#222"/>
        <line x1="120" y1="60" x2="140" y2="85" stroke="#ffffff" stroke-width="3" id="tassel"/>
        <circle cx="140" cy="85" r="4" fill="#ffffff"/>
    </g>

    <!-- BODY -->
    <g id="body">
        <ellipse cx="100" cy="120" rx="65" ry="55" fill="#ffffff"/>
        <circle id="eye1" cx="75" cy="105" r="8" fill="#000"/>
        <circle id="eye2" cx="125" cy="105" r="8" fill="#000"/>
        <path id="mouth" d="M70 135 Q100 155 130 135" stroke="#000" stroke-width="4" fill="none"/>
    </g>

</svg>
</div>

<!-- CARD -->
<div class="glass p-8 rounded-3xl shadow-2xl w-full max-w-md mx-auto">

<h2 class="text-white text-2xl text-center mb-4">Masuk Sistem</h2>

<form action="proses_login.php" method="POST" class="space-y-4">

<input type="text" id="username" name="username"
class="input w-full px-4 py-3 rounded-xl bg-white/20 text-white"
placeholder="Username" required>

<div class="relative">
<input type="password" id="password" name="password"
class="input w-full px-4 py-3 rounded-xl bg-white/20 text-white"
placeholder="Password" required>

<span onclick="togglePass()" class="absolute right-3 top-3 cursor-pointer text-white">👁</span>
</div>

<div class="flex gap-2">
<input type="text" name="captcha"
class="input flex-1 px-4 py-3 rounded-xl bg-white/20 text-white"
placeholder="Captcha" required>

<img src="captcha.php" onclick="this.src='captcha.php?'+Math.random();"
class="h-12 rounded-lg cursor-pointer">
</div>

<button class="w-full py-3 bg-white text-blue-700 rounded-xl font-bold">
LOGIN
</button>

</form>
</div>
</div>
</div>

<script>
function togglePass(){
    let p = document.getElementById("password");
    p.type = p.type === "password" ? "text" : "password";
}

/* MATA IKUT KURSOR */
document.addEventListener("mousemove", e=>{
    let x = (e.clientX / window.innerWidth - 0.5) * 10;
    let y = (e.clientY / window.innerHeight - 0.5) * 10;

    eye1.setAttribute("cx", 75 + x);
    eye1.setAttribute("cy", 105 + y);

    eye2.setAttribute("cx", 125 + x);
    eye2.setAttribute("cy", 105 + y);
});

/* REAKSI INPUT */
username.onfocus = ()=> mouth.setAttribute("d","M70 120 Q100 140 130 120");
password.onfocus = ()=> mouth.setAttribute("d","M70 125 Q100 115 130 125");

/* LOGIN SUCCESS */
const urlParams = new URLSearchParams(window.location.search);
if(urlParams.get('success')){

    const doodle = document.getElementById("doodle");
    const cap = document.getElementById("cap");
    const body = document.getElementById("body");

    doodle.classList.add("glow");

    document.querySelector("form").style.pointerEvents = "none";

    // lompat
    setTimeout(()=>{
        body.classList.add("celebrate");
    },200);

    // lempar topi
    setTimeout(()=>{
        cap.classList.add("throw-cap");
    },500);

    // redirect
    setTimeout(()=>{
        document.body.classList.add("fade-out");

        setTimeout(()=>{
            window.location.href = "../index.php";
        },600);

    },1200);
}

/* HOVER */
doodle.addEventListener("mouseenter", ()=>{
    mouth.setAttribute("d","M70 135 Q100 165 130 135");
});

/* CLICK */
doodle.addEventListener("click", ()=>{
    doodle.classList.add("celebrate");
    setTimeout(()=>doodle.classList.remove("celebrate"),600);
});
</script>

</body>
</html>