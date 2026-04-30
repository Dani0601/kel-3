<?php
include "config/koneksi.php";

$id_user = $_SESSION['id_user'];

$data = $conn->query("
    SELECT l.*, r.nama_ruangan
    FROM laporan_fasilitas l
    JOIN ruangan r ON l.id_ruangan = r.id_ruangan
    WHERE l.id_user = '$id_user'
    ORDER BY l.id_laporan DESC
");
?>

<!-- DATA TABLE CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- ===================== -->
<!-- UI KAMU TETAP PERSIS -->
<!-- ===================== -->

<h2 class="text-2xl font-bold mb-6 text-center">
📜 Riwayat Laporan
</h2>

<table id="tabelLaporan" class="display w-full">
    <thead>
        <tr>
            <th>No</th>
            <th>Ruangan</th>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $no = 1;
        while($d = $data->fetch_assoc()){
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama_ruangan'] ?></td>
            <td><?= $d['jenis'] ?></td>
            <td><?= $d['deskripsi'] ?></td>

            <td>
                <?php if($d['foto']){ ?>
                    <img src="./upload/laporan/<?= $d['foto'] ?>" width="60">
                <?php } else { ?>
                    Tidak ada foto
                <?php } ?>
            </td>

            <!-- EDIT TETAP PERSIS SEPERTI PUNYAMU -->
            <td>
                <a href="index.php?menu=edit_laporan_user&id=<?= $d['id_laporan'] ?>"
                   class="text-blue-500 hover:underline text-sm">
                   ✏️ Edit
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- INIT DATATABLE -->
<script>
$(document).ready(function () {
    $('#tabelLaporan').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        searching: true,
        ordering: true,
        paging: true
    });
});
</script>