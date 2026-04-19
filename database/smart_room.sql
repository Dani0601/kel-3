-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Apr 2026 pada 11.22
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_room`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `nidn` varchar(20) DEFAULT NULL,
  `nama_dosen` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `id_user`, `id_prodi`, `nidn`, `nama_dosen`, `email`) VALUES
(201001, 1010001, 801, '198305112015042001', 'Dr. Pradeepa Wijaya, M.Sc.', 'pradeepa.wijaya@kampus.ac.id'),
(201002, 1010002, 801, '198305112015042002', 'Dr. Nayana Putri, M.Kom.', 'nayana.putri@kampus.ac.id'),
(201003, 1010003, 801, '198305112015042003', 'Dr. Adhira, S.Kom., M.T', 'adhiraa@kampus.ac.id'),
(201004, 1010004, 801, '198305112015042004', 'Dr. Ravindra, M.Kom.', 'ravindr@kampus.ac.id'),
(201005, 1010005, 802, '198305112015042005', 'Prof. Arya, M.Sc.', 'aryya@kampus.ac.id'),
(201006, 1010006, 802, '198305112015042006', 'Dr. Wira Adinata, M.Si.', 'wiradinata@kampus.ac.id'),
(201007, 1010007, 802, '198305112015042007', 'Dr. Aditya, M.Sc.', 'aditya@kampus.ac.id'),
(201008, 1010008, 802, '198305112015042008', 'Dr. Clara, M.Kom.', 'clara@kampus.ac.id'),
(201009, 1010009, 803, '198305112015042009', 'Ust. Hasan Al-Fatih, Lc., M.Ag.', 'hasan@kampus.ac.id'),
(201010, 1010010, 803, '198305112015042010', 'Dr. Citra Maharani, M.Psi.', 'citramaharani@kampus.ac.id'),
(201011, 1010011, 803, '198305112015042011', 'Dr. Fajar, M.Pd.', 'fajar@kampus.ac.id'),
(201012, 1010012, 803, '198305112015042012', 'Dr. Ayu Kartika, M.Pd.', 'ayukartika@kampus.ac.id');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int(11) NOT NULL,
  `nama_fakultas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
(411, 'FITK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gedung`
--

CREATE TABLE `gedung` (
  `id_gedung` int(11) NOT NULL,
  `nama_gedung` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gedung`
--

INSERT INTO `gedung` (`id_gedung`, `nama_gedung`) VALUES
(901, 'Gedung FITK'),
(902, 'Gedung Siber'),
(903, 'Gedung Mahad');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_mk_prodi` int(11) DEFAULT NULL,
  `id_dosen` int(11) DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_tahun_ajar` int(11) DEFAULT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_mk_prodi`, `id_dosen`, `id_ruangan`, `id_kelas`, `id_tahun_ajar`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(501, 3111, 201001, 402, 511, 712, 'Kamis', '07:30:00', '10:00:00'),
(502, 3111, 201001, 402, 512, 712, 'Kamis', '10:00:00', '12:30:00'),
(503, 3112, 201002, 409, 511, 712, 'Rabu', '13:00:00', '15:30:00'),
(504, 3112, 201002, 408, 512, 712, 'Rabu', '15:30:00', '18:00:00'),
(505, 3113, 201003, 408, 511, 711, 'Senin', '10:00:00', '12:30:00'),
(506, 3113, 201003, 409, 512, 711, 'Senin', '07:30:00', '10:00:00'),
(507, 3114, 201004, 409, 511, 711, 'Rabu', '07:30:00', '10:00:00'),
(508, 3114, 201004, 409, 512, 711, 'Rabu', '10:00:00', '12:30:00'),
(509, 3115, 201005, 403, 513, 712, 'Selasa', '07:30:00', '10:00:00'),
(5011, 3115, 201005, 403, 514, 712, 'Selasa', '10:00:00', '12:30:00'),
(5012, 3116, 201006, 404, 513, 712, 'Senin', '09:10:00', '11:40:00'),
(5013, 3116, 201006, 404, 514, 712, 'Senin', '13:00:00', '15:30:00'),
(5014, 3117, 201007, 401, 513, 711, 'Selasa', '13:00:00', '15:30:00'),
(5015, 3117, 201007, 401, 514, 711, 'Selasa', '15:30:00', '18:00:00'),
(5016, 3118, 201008, 406, 513, 711, 'Kamis', '13:50:00', '16:20:00'),
(5017, 3118, 201008, 406, 514, 711, 'Kamis', '14:40:00', '17:10:00'),
(5018, 3119, 201009, 404, 515, 712, 'Senin', '07:30:00', '09:10:00'),
(5019, 3119, 201009, 404, 516, 712, 'Selasa', '07:30:00', '09:10:00'),
(5020, 3120, 201010, 405, 515, 712, 'Jumat', '14:40:00', '16:20:00'),
(5021, 3120, 201010, 405, 516, 712, 'Jumat', '07:30:00', '09:10:00'),
(5022, 3121, 201011, 402, 515, 711, 'Jumat', '13:50:00', '15:30:00'),
(5023, 3121, 201011, 402, 516, 711, 'Jumat', '13:00:00', '14:40:00'),
(5024, 3122, 201012, 401, 515, 711, 'Senin', '07:30:00', '09:10:00'),
(5025, 3122, 201012, 401, 516, 711, 'Senin', '09:10:00', '10:50:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `id_prodi`, `nama_kelas`) VALUES
(511, 801, 'INF A'),
(512, 801, 'INF B'),
(513, 802, 'MTK A'),
(514, 802, 'MTK B'),
(515, 803, 'PGMI A'),
(516, 803, 'PGMI B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_fasilitas`
--

CREATE TABLE `laporan_fasilitas` (
  `id_laporan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('pending','proses','selesai') DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_fasilitas`
--

INSERT INTO `laporan_fasilitas` (`id_laporan`, `id_user`, `id_ruangan`, `judul`, `deskripsi`, `status`, `tanggal`, `foto`, `jenis`) VALUES
(1, 3052101, 401, 'Laporan Fasilitas', 'AC - AC mati, pembelajaran jadi terganggu karena mahasiswa kepanasan.', 'pending', '2026-04-19 14:48:54', NULL, NULL),
(2, 3052101, 407, 'Lainnya', 'speakernya rusakm jdi suaranya tidak terdengar jelas', 'pending', '2026-04-19 16:15:53', '1776590153_bunga.jpeg', 'Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `nama_mahasiswa` varchar(100) DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `id_user`, `id_kelas`, `nim`, `nama_mahasiswa`, `angkatan`) VALUES
(301001, 3052101, 511, '2488010001', 'Azkania Rahma', '2024'),
(301002, 3052102, 512, '2488010002', 'Ayyara Mahesa', '2024'),
(301003, 3052103, 513, '2588010003', 'Nakhla Aryani', '2025'),
(301004, 3052104, 514, '2588010004', 'Adira Prameswari', '2025'),
(301005, 3052105, 515, '2490020001', 'Kavindra Satya', '2024'),
(301006, 3052106, 516, '2490020002', 'Ravika', '2024'),
(301007, 3052107, 511, '2590020003', 'Satyana Kusuma', '2025'),
(301008, 3052108, 512, '2590020004', 'Navira Lestari', '2025'),
(301009, 3052109, 513, '2491030001', 'Kirana', '2024'),
(301010, 3052110, 514, '2491030002', 'Kalyana Putri', '2024'),
(301011, 3052111, 515, '2591030003', 'Nayaka Pradana', '2025'),
(301012, 3052112, 516, '2591030004', 'Adhikara', '2025');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_mk` int(11) NOT NULL,
  `kode_mk` varchar(20) DEFAULT NULL,
  `nama_mk` varchar(20) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_mk`, `kode_mk`, `nama_mk`, `sks`) VALUES
(1111, '201', 'Matematika Diskrit', 3),
(1112, 'INF202', 'Algoritma dan Pemrog', 3),
(1113, 'INF401', 'Pemrograman Web', 3),
(1114, 'INF402', 'Internet of Things', 3),
(1115, 'MTK201', 'Geometri', 3),
(1116, 'MTK202', 'Aljabar Linear Eleme', 3),
(1117, 'MTK401', 'Matematika Aktuaria', 3),
(1118, 'MTK402', 'Teori Pengkodean', 3),
(1119, 'PGMI201', 'Praktikum Qiroah dan', 2),
(1120, 'PGMI202', 'Psikologi Pembelajar', 2),
(1121, 'PGMI401', 'Pemgembangan Media P', 2),
(1122, 'PGMI402', 'Perkembangan Peserta', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mk_prodi`
--

CREATE TABLE `mk_prodi` (
  `id_mk_prodi` int(11) NOT NULL,
  `id_mk` int(11) DEFAULT NULL,
  `id_prodi` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mk_prodi`
--

INSERT INTO `mk_prodi` (`id_mk_prodi`, `id_mk`, `id_prodi`, `semester`) VALUES
(3111, 1111, 801, 2),
(3112, 1112, 801, 2),
(3113, 1113, 801, 4),
(3114, 1114, 801, 4),
(3115, 1115, 802, 2),
(3116, 1116, 802, 2),
(3117, 1117, 802, 4),
(3118, 1118, 802, 4),
(3119, 1119, 803, 2),
(3120, 1120, 803, 2),
(3121, 1121, 803, 2),
(3122, 1122, 803, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('aktif','dihapus') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `judul`, `pesan`, `created_at`, `status`) VALUES
(211, 'trial', 'hai semua', NULL, 'dihapus'),
(212, 'trial pt 2', 'hehe', NULL, 'dihapus'),
(213, 'trial pt 2', 'hehe', NULL, 'dihapus'),
(214, 'Rapat', 'Dimohon untuk semua dosen untuk berkumpul di audit gedung siber lantai 8', '2026-03-28 23:32:26', 'dihapus'),
(215, 'Rapat', 'Dimohon untuk semua dosen untuk berkumpul di audit gedung siber lantai 8', '2026-03-28 23:37:14', 'dihapus'),
(216, 'secreet', 'Untuk mendapatkan IPK yang tinggi, anda harus rajin belajar dan aktif di kelas', '2026-03-28 23:38:26', 'aktif'),
(217, 'Rapat', 'Dimohon untuk semua dosen untuk berkumpul di audit gedung siber lantai 8', '2026-03-28 23:45:28', 'aktif'),
(218, 'Laporan terkirim', 'Laporan kamu berhasil dikirim', NULL, 'dihapus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi_user`
--

CREATE TABLE `notifikasi_user` (
  `id_notifikasi_user` int(11) NOT NULL,
  `id_notifikasi` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status_dibaca` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi_user`
--

INSERT INTO `notifikasi_user` (`id_notifikasi_user`, `id_notifikasi`, `id_user`, `status_dibaca`) VALUES
(1, 0, 122001, 1),
(2, 215, 1010001, 1),
(3, 215, 1010002, 0),
(4, 215, 1010003, 0),
(5, 215, 1010004, 0),
(6, 215, 1010005, 0),
(7, 215, 1010006, 0),
(8, 215, 1010007, 0),
(9, 215, 1010008, 0),
(10, 215, 1010009, 0),
(11, 215, 1010010, 0),
(12, 215, 1010011, 0),
(13, 215, 1010012, 0),
(14, 216, 3052101, 1),
(15, 216, 3052102, 0),
(16, 216, 3052103, 0),
(17, 216, 3052104, 0),
(18, 216, 3052105, 0),
(19, 216, 3052106, 0),
(20, 216, 3052107, 0),
(21, 216, 3052108, 0),
(22, 216, 3052109, 0),
(23, 216, 3052110, 0),
(24, 216, 3052111, 0),
(25, 216, 3052112, 0),
(26, 217, 1010001, 1),
(27, 217, 1010002, 0),
(28, 217, 1010003, 0),
(29, 217, 1010004, 0),
(30, 217, 1010005, 0),
(31, 217, 1010006, 0),
(32, 217, 1010007, 0),
(33, 217, 1010008, 0),
(34, 217, 1010009, 0),
(35, 217, 1010010, 0),
(36, 217, 1010011, 0),
(37, 217, 1010012, 0),
(38, 218, 3052101, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `id_user`, `judul`, `isi`, `tanggal`) VALUES
(601, 122001, 'Maintenance Sistem', 'Sistem akademik akan maintenance pukul 18:00 WIB.', '2026-03-17 20:26:42'),
(602, 122001, 'Pengambilan KTM', 'Mahasiswa dapat mengambil KTM di loket FITK', '2026-03-17 20:26:42'),
(603, 122002, 'Seminar Artificial Intelligence', 'Seminar Artificial Intelligence akan dilaksanakan di Auditorium 2.', '2026-03-17 20:26:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(11) NOT NULL,
  `id_fakultas` int(11) DEFAULT NULL,
  `nama_prodi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `id_fakultas`, `nama_prodi`) VALUES
(801, 411, 'Informatika'),
(802, 411, 'Matematika'),
(803, 411, 'PGMI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `id_gedung` int(11) DEFAULT NULL,
  `nama_ruangan` varchar(50) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `id_gedung`, `nama_ruangan`, `kapasitas`) VALUES
(401, 901, 'R. 201', 35),
(402, 901, 'R. 202', 35),
(403, 901, 'R. 301', 35),
(404, 901, 'R. 302', 35),
(405, 901, 'R. 401', 35),
(406, 901, 'R. 402', 35),
(407, 901, 'Auditorium FITK', 60),
(408, 902, 'Lab 1', 30),
(409, 902, 'Lab 2', 30),
(410, 902, 'Auditorium Siber', 90);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_tahun_ajar` int(11) NOT NULL,
  `tahun` varchar(10) DEFAULT NULL,
  `semester` enum('ganjil','genap') DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun_ajar`, `tahun`, `semester`, `aktif`) VALUES
(711, '2024', 'genap', 1),
(712, '2025', 'genap', 1),
(713, '2025', 'ganjil', 0),
(714, '2026', 'ganjil', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(122001, 'asteriopratama', '8ec596bb91bab7603ee80ff6abb7adb4', 'admin'),
(122002, 'adhikapranawa', '531ad33609e0a8c733a939177c371e3c', 'admin'),
(122003, 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
(1010001, 'pradeepawijaya', '54215d57b809f36ba2467bcf2b37b53e', 'dosen'),
(1010002, 'nayyanaputri', 'a3b71a69faba39b4cf3caa5311da7b30', 'dosen'),
(1010003, 'adhira', '6e06f0d435cbd35930299a69d5b74b58', 'dosen'),
(1010004, 'ravindra', '7bd8e5203d650430c900df31e6240520', 'dosen'),
(1010005, 'arya', '1de1c7ef7a4b08603b92d21ddd1e9a9e', 'dosen'),
(1010006, 'wiradinata', '22ef1e2ba10416d3ebfc22d0dfd8a584', 'dosen'),
(1010007, 'aaditya', '0c305b856b217ea6e5b478beaebfa9d9', 'dosen'),
(1010008, 'clarraaa', '8790be5955075557395a404e0fd0ebd7', 'dosen'),
(1010009, 'hasanalfath', '08eccac25e178dfb255b1a4228bb8117', 'dosen'),
(1010010, 'citramhrni', '4de704d55168ee62c7a72629ba1c07cc', 'dosen'),
(1010011, 'fajjar', '68c7b6bd4793f98758cbc9da12110a39', 'dosen'),
(1010012, 'ayukarrtika', '0f79ec9bb1f34c99afab1b618938a127', 'dosen'),
(1010013, 'dosen', 'd5bbfb47ac3160c31fa8c247827115aa', 'dosen'),
(3052101, 'azkaniarahma', '5b55d2e233eeb2b3ece5cabf6d3b7bd7', 'mahasiswa'),
(3052102, 'ayyaramahesa', 'e8e462fb485482ff6e54817ef3b72099', 'mahasiswa'),
(3052103, 'nakhlaryani', '2c41c37d694e9cec5247409be8180148', 'mahasiswa'),
(3052104, 'adiraprmameswari', '8b4e8058574eead9786122f824bafe1d', 'mahasiswa'),
(3052105, 'kavindrasatya', '6504d5d4a65fc542c232980225b2116b', 'mahasiswa'),
(3052106, 'ravika', 'c5202be8e5d050d4c6d7a1427de1a10d', 'mahasiswa'),
(3052107, 'satyanakusuma', '07ffb637d23a456b0a66303023591f90', 'mahasiswa'),
(3052108, 'naviralestari', 'af7b06eb19be6ec8e1f4b4721af1548a', 'mahasiswa'),
(3052109, 'kirana', '26350c8154947cfa99eec36189ba2c33', 'mahasiswa'),
(3052110, 'kalyanaputri', '60d67ed2bc84b293fd29e02d15d80128', 'mahasiswa'),
(3052111, 'nayakapradana', '8a547e1b19317f1c7c43de8d563ffe0f', 'mahasiswa'),
(3052112, 'adhikara', '7b408ab7c1575fb59901418cf6cd54e1', 'mahasiswa'),
(3052113, 'mahasiswa', 'b398b8a18ef4f69811a32cf169946bac', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indeks untuk tabel `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indeks untuk tabel `gedung`
--
ALTER TABLE `gedung`
  ADD PRIMARY KEY (`id_gedung`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_mk_prodi` (`id_mk_prodi`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indeks untuk tabel `laporan_fasilitas`
--
ALTER TABLE `laporan_fasilitas`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_mk`),
  ADD UNIQUE KEY `kode_mk` (`kode_mk`);

--
-- Indeks untuk tabel `mk_prodi`
--
ALTER TABLE `mk_prodi`
  ADD PRIMARY KEY (`id_mk_prodi`),
  ADD KEY `id_mk` (`id_mk`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indeks untuk tabel `notifikasi_user`
--
ALTER TABLE `notifikasi_user`
  ADD PRIMARY KEY (`id_notifikasi_user`),
  ADD KEY `id_notifikasi` (`id_notifikasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `id_fakultas` (`id_fakultas`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD KEY `id_gedung` (`id_gedung`);

--
-- Indeks untuk tabel `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajar`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporan_fasilitas`
--
ALTER TABLE `laporan_fasilitas`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT untuk tabel `notifikasi_user`
--
ALTER TABLE `notifikasi_user`
  MODIFY `id_notifikasi_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `dosen_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`);

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_mk_prodi`) REFERENCES `mk_prodi` (`id_mk_prodi`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`);

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`);

--
-- Ketidakleluasaan untuk tabel `laporan_fasilitas`
--
ALTER TABLE `laporan_fasilitas`
  ADD CONSTRAINT `laporan_fasilitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `laporan_fasilitas_ibfk_2` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`);

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `mahasiswa_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);

--
-- Ketidakleluasaan untuk tabel `mk_prodi`
--
ALTER TABLE `mk_prodi`
  ADD CONSTRAINT `mk_prodi_ibfk_1` FOREIGN KEY (`id_mk`) REFERENCES `mata_kuliah` (`id_mk`),
  ADD CONSTRAINT `mk_prodi_ibfk_2` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`);

--
-- Ketidakleluasaan untuk tabel `notifikasi_user`
--
ALTER TABLE `notifikasi_user`
  ADD CONSTRAINT `notifikasi_user_ibfk_1` FOREIGN KEY (`id_notifikasi`) REFERENCES `notifikasi` (`id_notifikasi`),
  ADD CONSTRAINT `notifikasi_user_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_ibfk_1` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`);

--
-- Ketidakleluasaan untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `ruangan_ibfk_1` FOREIGN KEY (`id_gedung`) REFERENCES `gedung` (`id_gedung`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
