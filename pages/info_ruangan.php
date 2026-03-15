<?php
include __DIR__ . '/../config/koneksi.php';

// Ambil input dan escape agar aman
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$gedung_filter = isset($_GET['gedung']) ? mysqli_real_escape_string($conn, $_GET['gedung']) : '';

// Query ruangan dengan filter
$query = mysqli_query($conn, "
    SELECT 
        ruangan.nama_ruangan,
        ruangan.kapasitas,
        gedung.nama_gedung
    FROM ruangan
    JOIN gedung 
    ON ruangan.id_gedung = gedung.id_gedung
    WHERE ruangan.nama_ruangan LIKE '%$search%'
    AND gedung.nama_gedung LIKE '%$gedung_filter%'
");

$total_ruangan = mysqli_num_rows($query);

// Ambil semua gedung untuk dropdown
$gedung = mysqli_query($conn, "SELECT * FROM gedung");
?>

<style>
.card-hover:hover{
    transform: translateY(-5px);
    transition:0.3s;
    box-shadow:0 10px 20px rgba(0,0,0,0.15);
}
</style>

<div class="container" style="margin-top:90px;">

<h2 class="text-center mb-4">Informasi Ruangan</h2>

<!-- Statistik -->
<div class="row text-center mb-4">

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Total Ruangan</h6>
                <h3 class="text-primary"><?= $total_ruangan ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Total Gedung</h6>
                <h3 class="text-success">
                    <?php
                    $g = mysqli_query($conn,"SELECT COUNT(*) as total FROM gedung");
                    $d = mysqli_fetch_assoc($g);
                    echo $d['total'];
                    ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6>Kapasitas Maks</h6>
                <h3 class="text-danger">
                    <?php
                    $k = mysqli_query($conn,"SELECT MAX(kapasitas) as max FROM ruangan");
                    $m = mysqli_fetch_assoc($k);
                    echo $m['max'];
                    ?>
                </h3>
            </div>
        </div>
    </div>

</div>

<!-- Search & Filter -->
<form method="GET" action="index.php">
<input type="hidden" name="menu" value="info_ruangan">

<div class="row mb-4">

    <div class="col-md-6">
        <input type="text" name="search" class="form-control" 
        value="<?= $search ?>" placeholder="Cari nama ruangan...">
    </div>

    <div class="col-md-4">
        <select name="gedung" class="form-control">
            <option value="">Semua Gedung</option>
            <?php while($g = mysqli_fetch_assoc($gedung)): ?>
                <option value="<?= $g['nama_gedung'] ?>" 
                <?= $g['nama_gedung'] == $gedung_filter ? 'selected' : '' ?>>
                    <?= $g['nama_gedung'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Cari</button>
    </div>

</div>
</form>

<!-- Card Ruangan -->
<div class="row">

<?php while($data = mysqli_fetch_assoc($query)): ?>

    <div class="col-md-4 mb-4">
        <div class="card card-hover shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title">
                    🏫 <?= $data['nama_ruangan']; ?>
                </h5>

                <p class="text-muted mb-1">
                    📍 <?= $data['nama_gedung']; ?>
                </p>

                <p>
                    👥 Kapasitas
                    <span class="badge bg-primary">
                        <?= $data['kapasitas']; ?> orang
                    </span>
                </p>

            </div>
        </div>
    </div>

<?php endwhile; ?>

</div>
</div>