-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 02:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinkes1`
--

-- --------------------------------------------------------

--
-- Table structure for table `apotek`
--

CREATE TABLE `apotek` (
  `no` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longtitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apotek`
--

INSERT INTO `apotek` (`no`, `nama`, `alamat`, `kecamatan`, `latitude`, `longtitude`) VALUES
(1, 'Apotek Sari Sehat', 'Jl. Trunojoyo 96, Kel. Parteker, Kec. Pamekasan,69311', 'Pamekasan', '-7.164734907', '113.4816338'),
(2, 'Apotek Margi', 'Jl. Niaga No. 35, Kel. Barurambat Kota, Kec. Pamekasan', 'Pamekasan', '-7.163164734', '113.4846247'),
(3, 'Apotek Arofa', 'Jl. Trunojoyo 130, Kel. Parteker, Kec. Pamekasan 69317', 'Pamekasan', '-7.166236001', '113.481127'),
(4, 'Apotek Mandiri Farma 2', 'Jl. Panglegur No. 5, Kel. Panglegur, Kec. Tlanakan', 'Tlanakan', '-7.183688987', '113.4787163'),
(5, 'Apotek Ainy Farma', 'Jl. Raya Waru No. 8, desa Waru Barat, Kec. Waru', 'Waru', '-6.939350839', '113.554691'),
(6, 'Apotek Setia', 'Jl. Kesehatan No. 14, Kel. Barurambat Kota, Kec. Pamekasan', 'Pamekasan', '-7.157619505', '113.4845172'),
(7, 'Apotek Farmasi', 'Jl. Mesigit No. 17, Kel. Gladak Anyar, Kec. Pamekasan', 'Pamekasan', '-7.16068847', '113.481612'),
(8, 'Apotek Mandiri Farma', 'Jl. Stadion 51, Kel. Barurambat Kota, Kec.Pamekasan 69323', 'Pamekasan', '-7.157260396', '113.4876402'),
(9, 'Apotek Mandiri 3', 'Jl. Mandilaras No. 17, Kel. Barurambat Kota, Kec. Pamekasan 69317', 'Pamekasan', '-7.155460062', '113.4826102'),
(10, 'Apotek Kimia Farma 274', 'Jl. Diponegoro No. 04, Kel. Barkot Kec. Pamekasan 69315', 'Pamekasan', '-7.159289889', '113.481702'),
(11, 'Apotek Afas', 'Jl. Jokotole N0. 240 A, Kel. Buddagan, Kec. Pademawu', 'Pademawu', '-7.162378087', '113.5039968'),
(12, 'Apotek Inas Farma', 'Jl. Kabupaten No. 04,Kel. Gladak Anyar, Kec. Pamekasan 69317', 'Pamekasan', '-7.158419334', '113.4775572'),
(13, 'Apotek Nusa Farma', 'Jl. Raya Waru 112 Desa Waru Barat Kec. Waru', 'Waru', '-6.942102241', '113.5514087'),
(14, 'Apotek K-24', 'Jl. Jokotole No. 37, Kel. Barurambat Kota, Kec. Pamekasan 69321', 'Pamekasan', '-7.16058797', '113.4855293'),
(15, 'Apotek Sifa Farma', 'JL. Pasar Ayam 5, Dsn. Tobalang III, DESA WARU BARAT, Kec. Waru 69353', 'Waru', '-6.941317543', '113.5531055'),
(16, 'Apotek Mega Farma', 'Jl. Stadion No. 76, Kel. Barkot, Kec. Pamekasan', 'Pamekasan', '-7.156967633', '113.48793'),
(17, 'Apotek Afas 2', 'Jl. Pintu Gerbang No. 53, Kel. Bugih, Kec. Pamekasan 69317', 'Pamekasan', '-7.154464504', '113.4748372'),
(18, 'Apotek Jokotole', 'Jl. Jokotole No. 51, Kel. Barkot, Kec. Pamekasan', 'Pamekasan', '-7.160589399', '113.4863066'),
(19, 'Apotek Kailani', 'Dsn. Lonpao Tengah 11, Ds. Blaban, Kec. Batumarmar 69354', 'Batumarmar', '-6.901356629', '113.4870542'),
(20, 'Apotek Mitra Mandiri', 'Ruko Perum Nyalabu Laok Regency No. 8 Jl. Raya Proppo Kec. Proppo', 'Proppo', '-7.147981429', '113.4595106'),
(21, 'Apotek Air Mulya', 'Jl. Raya Sumenep No. 12 B, Ds. Tentenan Barat, Kec. Larangan', 'Larangan', '-7.127917286', '113.5346166'),
(22, 'Apotek Waru Indah', 'Jl. Raya Waru Barat, Kompleks Pertokoan H. Ibrahim No. 04, Ds. Waru Barat, Kec. Waru', 'Waru', '-6.941854591', '113.5512861'),
(23, 'Apotek Amanah 2', 'Jl. Raya Pademawu komplek Pertokoan depan Puskesmas Pademawu No. 01, Kec. Pademawu', 'Pademawu', '-7.172958151', '113.5136408'),
(24, 'Apotek Wahyudi Farma', 'Jl. Raya Larangan Tokol, Ds. Larangan Tokol, Kec. Tlanakan 69371', 'Tlanakan', '-7.199586198', '113.4706754'),
(25, 'Apotek Ahnaf Farmasi', 'Dsn. Nyalaran, Ds. Blumbungan, Kec. Larangan', 'Larangan', '-7.112308924', '113.4977813'),
(26, 'Apotek Surya', 'Jl. Raya Teja Timur 220, Ds. Teja Timur, Kec. Pamekasan', 'Pamekasan', '-7.166922953', '113.4625735'),
(27, 'Apotek Faras Satu Hati', 'Jl. Raya Tlanakan, Dsn. Pos, Ds. Tlanakan, Kec. Tlanakan', 'Tlanakan', '-7.218173204', '113.4467933'),
(28, 'Apotek Indah Farma', 'JL. KABUPATEN NO.95 KELURAHAN BUGIH KEC. PAMEKASAN', 'Pamekasan', '-7.157813334', '113.4748328'),
(29, 'Assifa', 'DUSUN ORO TIMUR, Ds. TLONTO RAJA, Kec.PASEAN', 'Pasean', '-6.895314317', '113.5705575'),
(30, 'Zetha Farma', 'Perum Tlanakan Indah C-1A, Kel. Larangan Tokol, Kec. Tlanakan', 'Tlanakan', '-7.197444073', '113.4715547'),
(31, 'Syamil Khan Farma 2', 'Jl. Raya Palengaan, Dsn. Bunut, Kel. Plakpak, Kec. Pegantenan', 'Pegantenan', '-7.098310873', '113.4718211'),
(32, 'Fafira Farma', 'JL. RAYA PASAR PAKONG DESA PAKONG Kec. Pakong, 69352', 'Pakong', '-7.033665083', '113.5578478'),
(33, 'Zakia Farmasi', 'Jl. Raya Galis, Ds. Bulay, Kec. Galis 69382', 'Galis', '-7.150880648', '113.5508266'),
(34, 'HM FARMASI', 'Jl. Raya Konang, Ds. Konang, Kec. Galis, Kab. Pamekasan 69382', 'Pamekasan', '-7.157660034', '113.5378638'),
(35, 'SRI REJEKI', 'Dsn. Taman II, Ds. Larangan Tokol, Kec. Larangan 69371', 'Larangan', '-7.213930346', '113.4593739'),
(36, 'RANDU AGUNG JAYA', 'Dsn. Sumber Taman, Ds. Pakong, Kec. Pakong 69352', 'Pakong', '-7.03606508', '113.5590163'),
(37, 'AMIN FARMA', 'Jl. Raya Teja, Ds. Laden, Kec. Pamekasan 69317', 'Pamekasan', '-7.168795498', '113.4723839'),
(38, 'BINTANG', 'Jl. Raya Tamberu, Ds. Blaban, Kec. Batumarmar', 'Batumarmar', '-6.900122973', '113.4859107'),
(39, 'Adiba Farma', 'Dsn. Bulay, Ds. Bulay., Kec. Galis 69382', 'Galis', '-7.148451893', '113.5509693'),
(40, 'AMILINA FARMA', 'Jl. Veteran Modung Utara, Ds. Bunder, Kec. Pademawu', 'Pademawu', '-7.185869057', '113.5295003'),
(41, 'SKM', 'Jl. Bonorogo 19, Kel. Lada', 'Pademawu', '-7.156572405', '113.490602'),
(42, 'RAKYAT SEHAT', 'Jl. Raya Pakong - Masjid, Ds. Bandungan, Kec. Pakong', 'Pakong', '-7.043545097', '113.5449644'),
(43, 'QONA\'AH', 'Jl. Kangenan 45, Ds. Kangenan, Kec. Pamekasan 69317', 'Pamekasan', '-7.180709912', '113.4825355'),
(44, 'SRI REJEKI 2', 'Jl. Raya Larangan Badung, Kec. Palengaan', 'Palengaan', '-7.106411665', '113.4778718'),
(45, 'AHZA FARMA', 'Jl. Raya Larangan Badung, Kec. Palengaan', 'Palengaan', '-7.124976349', '113.4778055'),
(46, 'ALI FARMA', 'Dsn. Glugur I, Ds. Palengaan Laok, Kec. Palengaan', 'Palengaan', '-7.062723682', '113.4332419'),
(47, 'AMANAH FARMA BERSAUDARA', 'Jl. Raya Palengaan, Ds. Palengaan, Kec. Palengaan', 'Palengaan', '-7.061472569', '113.4286565'),
(48, 'AZ-ZAHRAH', 'Jl. Raya Pamekasan - Sumenep, Dsn. Sakolaan, Ds. Kaduara Barat, Kec. Larangan 69382', 'Larangan', '-7.118907027', '113.5956657'),
(49, 'CARISA FARMA', 'Jl. Kangenan 89, Ds. Kangenan, Kec. Pamekasan 69317', 'Pamekasan', '-7.18079218', '113.4861852'),
(50, 'CAHAYA', 'Jl. Raya Bunder, Ds. Pademawu Barat, Kec. Pademawu 69323', 'Pademawu', '-7.177156906', '113.5186265'),
(51, 'ZIDAN FARMA', 'Jl. Raya Waru - Pasean, Dsn. Kendal, Ds. Waru Timur, Kec. Waru 69325', 'Waru', '-6.732855989', '113.6034807'),
(52, 'Raddina Farma', 'Dsn. Keppo RT. 001/RW. 001, Ds. Polagan, Kec. Galis 69382', 'Galis', '-7.132912214', '113.5615961'),
(53, 'Alfabeta', 'Dsn. Panyepen, ds. Lenteng, kec. Proppo 69272', 'Proppo', '-7.1349471', '113.435079'),
(54, 'Family', 'Jl. Raya Pakong, Dsn. Duko Barat, Ds. Pakong, Kec. Pakong 69352', 'Pakong', '-7.03108335', '113.5512453'),
(55, 'Syamil Khan Farma', 'Jl. Raya Blumbungan, Kec. Larangan 69383', 'Larangan', '-7.098150816', '113.4715738'),
(56, 'Miss Zee', 'Dsn. Du\'Alas, Ds. Larangan Luar, Kec. Larangan 69383', 'Larangan', '-7.129678905', '113.5449679'),
(57, 'Air Mulya 2', 'Jl. Raya Sumenep, Dsn. Talang, Ds. Montok, Kec. Larangan 69383', 'Larangan', '-7.132680702', '113.5943559'),
(58, 'Medikal Farma', 'Dusun Tenggina RT001 RW009, Desa. Kadur, Kec. Kadur 69355', 'Kadur', '', ''),
(59, 'Al-Buhori', 'Jl. Raya Pegantenan, Dsn. Utara, Ds. Pegantenan, Kec. Pegantenan 69361', 'Pegantenan', '-7.04117', '113.484604'),
(60, 'Sentral 01', 'Jl. Simpang III Pasar Anyar, Ds. Bujur Tengah, Kec. Batumarmar', 'Batumarmar', '6.9691022', '113.4899165'),
(61, 'Akhmad Farmasi', 'Jl. Raya Pademawu Timur, Ds. Pademawu Timur, Kec. Pademawu 69323', 'Pademawu', '-7.204839777', '113.5323892'),
(62, 'Yahya Farma New', 'Jl. Pintu Gerbang Blok A-4, Kel. Bugih, Kec. Pamekasan 69317', 'Pamekasan', '-7.140091573', '113.4793194');

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `judul_file` text NOT NULL,
  `nama_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `judul_file`, `nama_file`) VALUES
(73, 'Jumlah Penderita Penyakit Tidak Menular Menurut Kecamatan Tahun 2022', 'Jumlah_Penderita_Penyakit_Tidak_Menular_Menurut_Kecamatan_Tahun_2022.xlsx'),
(74, 'Jumlah Bayi Berdasarkan Berat Badan Lahir Rendah (BBLR) Menurut Kecamatan Tahun 2023 Triwulan III', 'Jumlah_Bayi_Berdasarkan_Berat_Badan_Lahir_Rendah_(BBLR)_Menurut_Kecamatan_Tahun_2023_Triwulan_III.xlsx'),
(75, 'Banyaknya Kunjungan Ke Puskesmas Menurut Kecamatan Tahun 2023 Hingga Bulan September', 'Banyaknya_Kunjungan_Ke_Puskesmas_Menurut_Kecamatan_Tahun_2023_Hingga_Bulan_September.xlsx'),
(76, 'Banyaknya Rawat Inap Ke Puskesmas Menurut Kecamatan Tahun 2023 Hingga Bulan September', 'Banyaknya_Rawat_Inap_Ke_Puskesmas_Menurut_Kecamatan_Tahun_2023_Hingga_Bulan_September.xlsx'),
(77, 'Jumlah Bayi Berdasarkan Berat Badan Lahir Rendah (BBLR) Menurut Kecamatan Tahun 2023 Triwulan II', 'Jumlah_Bayi_Berdasarkan_Berat_Badan_Lahir_Rendah_(BBLR)_Menurut_Kecamatan_Tahun_2023_Triwulan_II.xlsx'),
(78, 'Jumlah Bayi Berdasarkan Berat Badan Lahir Rendah (BBLR) Menurut Kecamatan Tahun 2023 Triwulan I', 'Jumlah_Bayi_Berdasarkan_Berat_Badan_Lahir_Rendah_(BBLR)_Menurut_Kecamatan_Tahun_2023_Triwulan_I.xlsx'),
(79, 'Jumlah Rumah Sakit Umum, Rumah Sakit Khusus, Puskesmas, Klinik Pratama, Dan Posyandu Menurut Kecamatan Tahun 2022', 'Jumlah_Rumah_Sakit_Umum,_Rumah_Sakit_Khusus,_Puskesmas,_Klinik_Pratama,_Dan_Posyandu_Menurut_Kecamatan_Tahun_2022.xlsx'),
(80, 'Jumlah Desa Atau kelurahan Yang Sudah Stop Buang Air Besar Di Sembarang Tempat (Stop BABS) Menurut Kecamatan Tahun 2022 Semester I', 'Jumlah_Desa_Atau_kelurahan_Yang_Sudah_Stop_Buang_Air_Besar_Di_Sembarang_Tempat_(Stop_BABS)_Menurut_Kecamatan_Tahun_2022_Semester_I.xlsx'),
(81, 'Jumlah Kematian Ibu Menurut Kecamatan Tahun 2022', 'Jumlah_Kematian_Ibu_Menurut_Kecamatan_Tahun_2022.xlsx'),
(82, 'Jumlah Rumah Sakit Umum', 'Jumlah_Rumah_Sakit_Umum.xlsx'),
(83, 'Jumlah Tenaga Kesehatan Menurut Kecamatan', 'Jumlah_Tenaga_Kesehatan_Menurut_Kecamatan.xlsx'),
(84, 'Jumlah Tenaga Medis Puskesmas Menurut Kecamatan', 'Jumlah_Tenaga_Medis_Puskesmas_Menurut_Kecamatan.xlsx'),
(88, 'Jumlah Penderita Stunting Tahun 2023 Triwulan III', 'Jumlah_Penderita_Stunting_Tahun_2023_Triwulan_III.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id` int(11) NOT NULL,
  `nama_gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`id`, `nama_gambar`) VALUES
(30, 'p.png'),
(31, 'qr.jpg'),
(32, 'dinkes.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `klinik`
--

CREATE TABLE `klinik` (
  `no` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longtitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klinik`
--

INSERT INTO `klinik` (`no`, `nama`, `jenis`, `alamat`, `latitude`, `longtitude`) VALUES
(2, 'Klinik Rawat Inap Meilia', 'Pratama', 'JL RAYA PASEAN DESA TLONTORAJA KECAMATAN PASEAN PAMEKASAN', '-6.89567', '113.56800'),
(3, 'Klinik Pratama Polres Pamekasan', 'Pratama', 'Jl. Stadion no.155 kel. lawangan daya - pademawu - pamekasan', '-7.152659559', '113.4905026'),
(4, 'Klinik Kesehatan Sumber Bungur', 'Pratama', 'DSN SUMBER TAMAN RT 002 RW 005 KECAMATAN PAKONG DESA PAKONG', '-7.02210684', '113.559726'),
(5, 'Klinik Elysia Estetika', 'Pratama', 'Jl. Kesehatan No. 06 Pamekasan', '-7.001823475', '113.8591914'),
(6, 'Klinik Pratama Rawat Inap Sinta', 'Pratama', 'desa larangan badung', '-7.074664752', '113.4856427'),
(7, 'Klinik Pratama An-Nur', 'Pratama', 'JL.RAYA PLAKPAK PEGANTENAN PAMEKASAN', '-7.096484273', '113.4761872'),
(8, 'Ghana Prima', 'Pratama', 'Jl. Stadion gang VI no 19 pamekasan', '-7.157064391', '113.4886202'),
(9, 'Natasha Skin Clinic Center', 'Pratama', 'Jl. Mandilaras No. 43 Kel. Barurambat Kota Kec. Pamekasan Kab. Pamekasan Provinsi Jawa Timur', '-7.155294959', '113.4817782'),
(10, 'Klinik Pratama Al-Miftah', 'Pratama', 'JL. Raya palengaan KM 11 Pamekasan', '-7.082840448', '113.4564762'),
(11, 'Klinik Pratama As-Salamah', 'Pratama', 'JL. P. DIPONEGORO 1 KEL. GLADAK ANYAR PAMEKASAN', '-7.152282141', '113.4907537'),
(12, 'Klinik Utama Rawat Jalan dr. Budi', 'Utama', 'Jl. Ronggosukowati no.8 Pamekasan', '-7.152392966', '113.4890411'),
(13, 'Klinik Pratama Afiya Medika', 'Pratama', 'Jalan raya teja timur 69317 Pamekasan', '-7.166870928', '113.4617857'),
(14, 'Klinik Pratama Lapas Narkotika Kelas Iia Pamekasan', 'Pratama', 'jalan pembina no 02 Jungcangcang, pamekasan', '-7.159043215', '113.474014'),
(15, 'Polkes 05.09.25 Pamekasan', 'Pratama', 'JL. PANGLIMA SUDIRMAN NO. 17 BARURAMBAT KOTA. KECAMATAN PAMEKASANKABUPATEN PAMEKASAN', '-7.161064982', '113.4830612'),
(16, 'Klinik Utama Madura Medikal Spesialis', 'Utama', 'Jl. Raya Kangenan No. 66, Taman, Kangenan, Kecamatan Pamekasan, Kabupaten Pamekasan, Jawa Timur 69317', '-7.180658923', '113.4836734'),
(17, 'Klinik Kasih Bunda', 'Pratama', 'Dusun Tengah RT. 006/RW.002 Desa Pegantenan Kec. Pegantenan Kab. Pamekasan', '-7.043960327', '113.4864463'),
(18, 'Klinik Pratama Rawat Jalan Malik Medika', 'Pratama', 'Dusun Sangoleng Desa Lesong Daja Batumarmar pamekasan', '', ''),
(19, 'Klinik Pratama dr. Fajar Habibi', 'Pratama', 'jl. Raya Waru Pasean. Kecamatan Waru, Kabupaten Pamekasan.', '-6.928846786', '113.564777'),
(20, 'Klinik Pratama Rawat Jalan L`San Lapas Kelas IIA P', 'Pratama', 'Jl.Pembina No.01 Pamekasan', '-7.157998134', '113.4715829'),
(21, 'Klinik Pratama Pipit Beauty Care', 'Pratama', 'Desa Ponteh', '-7.131774514', '113.557571'),
(22, 'Klinik Muslimat NU Pamekasan', 'Pratama', 'Jalan Raya Teja Kelurahan Jungcangcang', '-7.168822649', '113.4744125'),
(23, 'Klinik Zaytun Pamekasan', 'Utama', 'JL MANDILARAS NO 82 B KELURAHAN BARURAMBAT KOTA', '-7.154998478', '113.4817473'),
(24, 'Klinik Utama Faiza', 'Utama', 'Jl. Bonorogo No. 161 RT/RW 010/004, Lawangan Daya, Pademawu', '-7.158269753', '113.4987689');

-- --------------------------------------------------------

--
-- Table structure for table `programdinkes`
--

CREATE TABLE `programdinkes` (
  `no` int(11) NOT NULL,
  `daftar_data` text NOT NULL,
  `sumber_data` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programdinkes`
--

INSERT INTO `programdinkes` (`no`, `daftar_data`, `sumber_data`, `logo`) VALUES
(81, 'Sumber Daya Kesehatan', 'https://sisdmk.kemkes.go.id/', 'sidmk.png'),
(82, 'Capaian Vaksinasi Harian', 'https://datastudio.google.com/reporting/1ee3dcc3-b', 'kemkes.png'),
(83, 'Aplikasi AllRecord\r\nPemeriksaan Antigen- Covid 19', 'https://allrecord-antigen.kemkes.go.id/web/site/lo', 'kemkes.png'),
(85, 'Komdat Ditjen Kesmas ', 'https://komdatkesmas.kemkes.go.id/login', 'kemkes.png'),
(86, 'Sehat Indonesiaku', 'https://sehatindonesiaku.kemkes.go.id/auth/login', 'sehat.png'),
(87, 'Pengendalian Penyakit', 'https://skdr.surveilans.org/auth', 'kemkes.png'),
(88, 'Sistem Pelaporan Narkotika dan Psikotropika', 'https://sipnap.kemkes.go.id/', 'sipnap.png'),
(89, 'Aplikasi Sarana, Prasarana, dan Alat Kesehatan', 'https://aspak.kemkes.go.id/aplikasi/', 'kemkes.png'),
(90, 'Sistem Informasi HIV/AIDS & IMS', 'https://siha.kemkes.go.id/login_index.php', 'siha.png'),
(91, 'Simasda Sipena Sidia Pamekasan', 'https://simasda.com/', 'kemkes.png'),
(92, 'Realisasi Fisik dan Keuangan ', 'https://rafikapamekasan.com/pak', 'kemkes.png'),
(93, 'Sistem Informasi Pemerintahan Daerah Republik Indonesia', 'https://sipd-ri.kemendagri.go.id/auth/login', 'sipd.png'),
(94, 'Layanan Pengadaan Secara Elektronik (LPSE)', 'https://lpse.pamekasankab.go.id/eproc4', 'lpse.png'),
(95, 'E-renggar', 'https://e-renggar.kemkes.go.id/', 'kemkes.png'),
(96, 'OM-SPAN (Online Monitoring SPAN)', 'https://spanint.kemenkeu.go.id/spanint/latest/app/', 'omspan.png'),
(97, 'Layanan Aspirasi dan Pengaduan Online Rakyat', 'https://www.lapor.go.id/', 'lapor.png'),
(98, 'Satu Data Pamekasan', 'https://satudata.pamekasankab.go.id/', 'satudata.png'),
(99, 'Sitem Informasi Rencana Umum Pengadaan', 'https://sirup.lkpp.go.id/sirup/loginctr/index', 'sirup.png'),
(100, 'Insentif', 'https://insentif-ukm.kemkes.go.id/login-verify-dat', 'insentif.png'),
(101, 'P3DN', 'https://p3dn.sipd.kemendagri.go.id/', 'p3dn.png'),
(102, 'Krisna', 'https://pamekasankab.krisna.systems/gov2login.php?', 'kemkes.png'),
(103, 'MyASN', 'https://mysapk.bkn.go.id/landing-page', 'myasn.png'),
(104, 'Epuskesmas', 'https://pamekasan.epuskesmas.id/', 'epuskesmas.png'),
(105, 'Laporan Penyelenggaraan Pemerintah Daerah', 'https://lppd.pamekasankab.go.id/2022/', 'kemkes.png'),
(106, 'LPPD JATIM', 'https://lppd.ropem.jatimprov.go.id/', 'lppd.png'),
(107, 'SPM BANGDA', 'https://spm.bangda.kemendagri.go.id/', 'garuda.png'),
(108, 'SPM KEMENKES', 'https://spm.kemkes.go.id/login/?next=/', 'spm.png'),
(109, 'E-Monev', 'https://emonev.kabpamekasan.id/login', 'sakera.png'),
(110, 'SAKIP', 'https://esr.menpan.go.id/', 'garuda.png'),
(111, 'SAKERA', 'https://sakera.pamekasankab.go.id/', 'sakera.png');

-- --------------------------------------------------------

--
-- Table structure for table `puskesmas`
--

CREATE TABLE `puskesmas` (
  `no` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kelurahan` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `longtitude` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `website` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `puskesmas`
--

INSERT INTO `puskesmas` (`no`, `nama`, `alamat`, `kelurahan`, `kecamatan`, `longtitude`, `latitude`, `website`, `email`) VALUES
(1, 'Puskesmas Teja', 'Jl.Teja Timur No. 101', 'Jungcangcang', 'Pamekasan', '113.5109103', '-7.179653', 'pkmteja.pamekasankab.go.id', 'puskesmasteja@gmail.com'),
(2, 'Puskesmas Pademawu', 'Jl. Raya Murtajih 200 Kec. Pademawu Pamekasan', 'Murtajih', 'Pademawu', '113.513415', '-7.172984', 'pkmpademawu.pamekasankab.go.id', 'pkmpademawu007@gmail.com'),
(3, 'Puskesmas Galis', 'Jl. Raya Galis No.17', 'Galis', 'Galis', '113.55109', '-7.15122', 'pkmgalis.pamekasankab.go.id', 'puskesmasgalis1@gmail.com'),
(4, 'Puskesmas Kowel', 'Jl kowel jaya No 63, Pamekasan', 'Kowel', 'Pamekasan', '113.4871307', '-7.135608', 'pkmkowel.pamekasankab.go.id', 'puskesmas.kowel@gmail.com'),
(5, 'Puskesmas Pakong', 'jln. raya pakong laok kec. Pakong', 'Pakong', 'Pamekasan', '113.5571047', '-7.044539', 'pkmpakong.pamekasankab.go.id', 'puskesmaspakong1@gmail.com'),
(6, 'Puskesmas Proppo', 'Jl Raya Proppo, Mapper, Proppo', 'Proppo', 'Proppo', '113.41448', '-7.12585', 'pkmproppo.pamekasankab.go.id', 'puskesmasproppo@gmail.com'),
(7, 'Puskesmas Panaguan', 'Jalan Raya Panaguan', 'Panaguan', 'Proppo', '113.384957', '-7.119375', 'pkmpanaguan.pamekasankab.go.id', 'pkmpanaguan@gmail.com'),
(8, 'Puskesmas Tampojung Pregi', 'Jl. Raya Tampojung Pregi, Serengan', 'Tampojung Pregi', 'Waru', '113.539857', '-6.981854', 'pkmtampojungpregi.pamekasankab.go.id', 'puskesmastampojungpregi@gmail.com'),
(9, 'Puskesmas Pasean', 'Jl. Raya Pasean Waru Dsn Oro Timur Ds Tlontoraja, Kec. Pasean', 'Tlonto Raja', 'Pasean ', '113.5710385', '-6.89597', 'pkmpasean.pamekasankab.go.id', 'upt.pkm.pasean@gmail.com'),
(10, 'Puskesmas Bandaran', 'Jl.  Raya Bandaran No.16, Bandaran kec. Tlanakan', 'Bandaran', 'Tlanakan', '113.3961031', '-7.2160969', 'pkmbandaran.pamekasankab.go.id', 'pkm.bandaran@gmail.com'),
(11, 'Puskesmas Bulangan Haji', 'Jl. Raya Sulthan Muhammad ', 'Bulangan Haji', 'Pegantenan', '113.51833', '-7.064566', 'pkmbulanganhaji.pamekasankab.go.id', 'puskesmas.bulanganhaji@gmail.com'),
(12, 'Puskesmas Waru ', 'Jl. Raya Waru-Sotabar Kec. Waru', 'Waru Barat ', 'Waru ', '112.7559713', '-7.3543091', 'pkmwaru.pamekasankab.go.id', 'puskesmaswaru.pamekasan@gmail.com'),
(13, 'Puskesmas Palengaan', 'Jl. Raya Palengaan', 'Palengaan Laok', 'Palengaan', '113.413597', '-7.0622', 'pkmpalengaan.pamekasankab.go.id', 'pkm.palengaan@gmail.com'),
(14, 'Puskesmas Larangan', 'Jl. Raya Larangan', 'Tentenan Timur', 'Larangan', '113.532974', '-7.130753', 'pkmlarangan.pamekasankab.go.id', 'pkmlarangankm8@gmail.com'),
(15, 'Puskesmas Larangan Badung ', 'Jl. Raya Larangan Badung', 'larangan badung', 'Palengaan ', '113.47758', '-7.10562', 'pkmlaranganbadung.pamekasankab.go.id', 'pkmlaranganbadung@gmail.com'),
(16, 'Puskesmas Talang', 'Jl. Raya Sumenep- Pamekasan', 'Montok', 'Larangan', '113.593938', '-7.134437', 'pkmtalang.pamekasankab.go.id', 'puskesmastalangbpjs.pmksn@gmail.com'),
(17, 'Puskesmas Batumarmar', 'Jl . Raya Tamberu, Batumarmar', 'Tamberu', 'Batumarmar', '113.48581', '-6.900492', 'pkmbatumarmar.pamekasankab.go.id', 'puskesmasbatumarmar@gmail.com'),
(18, 'Puskesmas Sopaah', 'Jl. Raya Sopaah Kec. Pademawu (69323) Kab. Pamekasan', 'Sopaah', 'Pademawu', '113.4932459', '-7.200778385', 'pkmsopaah.pamekasankab.go.id', 'pkmsopaah@gmail.com'),
(19, 'Puskesmas Tlanakan', 'Jl. Raya Tlanakan Km. 7 Pamekasan', 'Tlanakan', 'Tlanakan', '113.466489', '-7.166386', 'pkmtlanakan.pamekasankab.go.id', 'puskesmastlanakan01@gmail.com'),
(20, 'Puskesmas Kadur', 'Jl. Raya Kadur No. 17 Kec. Kadur', 'kadur', 'kadur', '113.5568942', '-7.0992337', 'pkmkadur.pamekasankab.go.id', 'pkmkadur@yahoo.com'),
(121, 'Puskesmas Pegantenan', 'Jl.Raya Pegantenan, Utara, Pegantenan, Kec. Pegantenan', 'Pegantenan', 'Pegantenan', '113.48465065396583', '-7.039784109935026 ', 'http://pkmpegantenan.pamekasankab.go.id', 'puskesmas.pegantenan00@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `nama_surat` text NOT NULL,
  `file` text NOT NULL,
  `nama_upload` varchar(50) NOT NULL,
  `tgl_upload` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `nama_surat`, `file`, `nama_upload`, `tgl_upload`) VALUES
(27, 'Dinas Kesehatan', 'Dinas Kesehatan.pdf', 'Alam', '2024-01-25'),
(28, 'Perencanaan', 'Perencanaan.pdf', 'Dede', '2024-01-26'),
(29, 'Bukti Anggaran', 'Bukti Anggaran.pdf', 'Aini', '2024-01-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'dinkes123', 'dinkes123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apotek`
--
ALTER TABLE `apotek`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klinik`
--
ALTER TABLE `klinik`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `programdinkes`
--
ALTER TABLE `programdinkes`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `puskesmas`
--
ALTER TABLE `puskesmas`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `klinik`
--
ALTER TABLE `klinik`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `programdinkes`
--
ALTER TABLE `programdinkes`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `puskesmas`
--
ALTER TABLE `puskesmas`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
