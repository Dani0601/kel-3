<!DOCTYPE html>
<html>
<head>
    <title>Info Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top:90px;">
    <h2>Info Ruangan</h2>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Nama Ruangan</th>
                <th>Kapasitas</th>
                <th>Fasilitas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Lab 1</td>
                <td>40</td>
                <td>Proyektor, AC, Komputer</td>
            </tr>
            <tr>
                <td>Ruang 201</td>
                <td>30</td>
                <td>AC, Papan Tulis</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

</body>
</html>