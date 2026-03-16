<div class="min-h-screen bg-gray-100 py-16">

<div class="max-w-6xl mx-auto px-6">

<!-- Judul -->
<div class="text-center mb-12">

<h2 class="text-3xl font-bold text-gray-800">
Kontak Admin
</h2>

<div class="w-24 h-1 bg-blue-600 mx-auto mt-3 rounded"></div>

<p class="text-gray-500 mt-3">
Hubungi admin jika mengalami kendala atau ingin memberikan saran
terhadap sistem Smart Room Monitoring.
</p>

</div>


<div class="grid md:grid-cols-2 gap-8">

<!-- Informasi Kontak -->
<div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">

<h3 class="text-xl font-semibold text-blue-600 mb-4">
Informasi Kontak
</h3>

<div class="space-y-4 text-gray-700">

<div>
<p class="font-semibold">📧 Email Admin</p>
<p class="text-gray-600">naulaalfiyatull@gmail.com</p>
</div>

<div>
<p class="font-semibold">⏰ Jam Operasional</p>
<p class="text-gray-600">Senin - Jumat (08:00 - 16:00)</p>
</div>

<div>
<p class="font-semibold">📍 Lokasi</p>
<p class="text-gray-600">
Kampus UIN Siber Syekh Nurjati Cirebon<br>
Gedung Rektorat Lantai 2
</p>
</div>

</div>

</div>


<!-- Form Saran -->
<div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-xl transition">

<h3 class="text-xl font-semibold text-green-600 mb-6">
Form Saran & Masukan
</h3>

<form method="post" action="pages/kirim_pesan.php" class="space-y-4">

<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Nama
</label>

<input
type="text"
name="nama"
placeholder="Masukkan nama anda"
required
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
</div>


<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Email
</label>

<input
type="email"
name="email"
placeholder="Masukkan email anda"
required
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
</div>


<div>
<label class="block text-sm font-medium text-gray-700 mb-1">
Pesan / Saran
</label>

<textarea
name="pesan"
rows="4"
placeholder="Tulis saran atau pertanyaan anda..."
required
class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
</div>


<button
type="submit"
class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 hover:scale-105 transition">

Kirim Pesan

</button>

</form>

</div>

</div>

</div>

</div>