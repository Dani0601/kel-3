<style>
body{
    background:#f5f7fb;
}

.contact-title{
    font-weight:700;
    color:#2c3e50;
}

.card{
    border:none;
    border-radius:15px;
}

.card-header{
    border-radius:15px 15px 0 0 !important;
    font-weight:600;
}

.contact-info p{
    font-size:15px;
    margin-bottom:15px;
}

.contact-info i{
    color:#0d6efd;
    margin-right:8px;
}

.form-control{
    border-radius:8px;
}

.btn-kirim{
    border-radius:8px;
    font-weight:600;
    transition:0.3s;
}

.btn-kirim:hover{
    transform:scale(1.02);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}
</style>


<div class="container" style="margin-top:100px; margin-bottom:60px;">

    <h2 class="text-center mb-5 contact-title">Kontak Admin</h2>

    <div class="row g-4">

        <!-- Informasi Kontak -->
        <div class="col-md-5">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    Informasi Kontak
                </div>
                <div class="card-body contact-info">

                    <p>
                        📧 <strong>Email Admin</strong><br>
                        naulaalfiyatull@gmail.com
                    </p>

                    <p>
                        ⏰ <strong>Jam Operasional</strong><br>
                        Senin - Jumat (08:00 - 16:00)
                    </p>

                    <p>
                        📍 <strong>Lokasi</strong><br>
                        Kampus UIN Siber Syekh Nurjati Cirebon<br>
                        Gedung Rektorat Lantai 2
                    </p>

                </div>
            </div>
        </div>


        <!-- Form Saran -->
        <div class="col-md-7">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    Form Saran & Masukan
                </div>

                <div class="card-body">

                    <form method="post" action="pages/kirim_pesan.php">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name= "nama" class="form-control" placeholder="Masukkan nama anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name= "email" class="form-control" placeholder="Masukkan email anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pesan / Saran</label>
                            <textarea name= "pesan" class="form-control" rows="4" placeholder="Tulis saran atau pertanyaan anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-kirim w-100">
                            Kirim Pesan
                        </button>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>