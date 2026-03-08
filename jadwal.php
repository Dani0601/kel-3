<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top:90px;">

    <h2 class="mb-4">Jadwal Kuliah</h2>

    <!-- Dropdown Filter -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-select">
                <option>Jadwal per Program Studi</option>
                <option>Informatika</option>
                <option>Sistem Informasi</option>
            </select>
        </div>

        <div class="col-md-3">
            <select class="form-select">
                <option>Jadwal per Semester</option>
                <option>Semester 1</option>
                <option>Semester 3</option>
                <option>Semester 5</option>
            </select>
        </div>

        <div class="col-md-3">
            <select class="form-select">
                <option>Jadwal per Dosen</option>
                <option>Dr. Andi</option>
                <option>Bu Sari</option>
            </select>
        </div>

        <div class="col-md-3">
            <select class="form-select">
                <option>Jadwal per Ruangan</option>
                <option>Lab 1</option>
                <option>Ruang 201</option>
            </select>
        </div>
    </div>

    <!-- Tabel Jadwal -->
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruangan</th>
                <th>Program Studi</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Senin</td>
                <td>08:00 - 10:00</td>
                <td>Pemrograman</td>
                <td>Dr. Andi</td>
                <td>Lab 1</td>
                <td>Informatika</td>
                <td>Semester 3</td>
            </tr>

            <tr>
                <td>Selasa</td>
                <td>10:00 - 12:00</td>
                <td>Basis Data</td>
                <td>Bu Sari</td>
                <td>Ruang 105</td>
                <td>Sistem Informasi</td>
                <td>Semester 5</td>
            </tr>
        </tbody>
    </table>

</div>

<?php include 'footer.php'; ?>

</body>
</html>