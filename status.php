<!DOCTYPE html>
<html>
<head>
    <title>Status Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top:90px;">
    <h2>Status Ruangan (Live)</h2>

    <table class="table table-bordered text-center mt-3">
        <thead class="table-dark">
            <tr>
                <th>Ruangan</th>
                <th>Status</th>
                <th>Dosen</th>
                <th>Mata Kuliah</th>
                <th>Jam</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-success">
                <td>Lab 1</td>
                <td>Dipakai</td>
                <td>Dr. Andi</td>
                <td>Pemrograman</td>
                <td>08:00 - 10:00</td>
            </tr>

            <tr class="table-secondary">
                <td>Ruang 201</td>
                <td>Kosong</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>

            <tr class="table-warning">
                <td>Ruang 105</td>
                <td>Akan Dipakai</td>
                <td>Bu Sari</td>
                <td>Basis Data</td>
                <td>10:00 - 12:00</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
</body>
</html>