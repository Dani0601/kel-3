
<div class="container">
    <h2 class="mb-4">Laporan Fasilitas Rusak</h2>

    <form enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Nama Pelapor" required>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="NIM" required>
            </div>
        </div>

        <input type="text" class="form-control mb-3" placeholder="Ruangan" required>

        <select class="form-select mb-3" required>
            <option value="">Jenis Fasilitas</option>
            <option>Proyektor</option>
            <option>AC</option>
            <option>Kursi</option>
            <option>Meja</option>
            <option>Papan Tulis</option>
            <option>Lampu</option>
            <option>Lainnya</option>
        </select>

        <textarea class="form-control mb-3" rows="4" placeholder="Deskripsi Kerusakan" required></textarea>

        <label>Upload Foto Bukti (WAJIB)</label>
        <input type="file" class="form-control mb-3" required>

        <button class="btn btn-danger w-100">Kirim Laporan</button>
    </form>
</div>
