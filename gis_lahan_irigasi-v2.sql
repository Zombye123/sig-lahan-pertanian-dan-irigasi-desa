-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 19, 2026 at 10:51 AM
-- Server version: 8.4.7
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gis_lahan_irigasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_galeri_lahan`
--

DROP TABLE IF EXISTS `tbl_galeri_lahan`;
CREATE TABLE IF NOT EXISTS `tbl_galeri_lahan` (
  `id_galeri_lahan` int NOT NULL AUTO_INCREMENT,
  `id_lahan` int DEFAULT NULL,
  `ket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `foto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`id_galeri_lahan`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_galeri_lahan`
--

INSERT INTO `tbl_galeri_lahan` (`id_galeri_lahan`, `id_lahan`, `ket`, `foto`) VALUES
(8, 1, 'Gambar', '6.jpg'),
(2, 1, 'Foto Dari Selatan', '2.jpg'),
(3, 1, 'Foto Dari Udara', '3.jpg'),
(7, 1, 'Foto Dari Selatan', '5.jpg'),
(6, 1, 'Foto Dari Udara', '4.jpg'),
(9, 1, 'foto', '42747862_dB7Z2aZBsiTDoKqhvDxUptPZyO5stlvxA5xa93He_8o1.jpg'),
(10, 1, 'Gambar 3', 'G7-green-800.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hasil_spk`
--

DROP TABLE IF EXISTS `tbl_hasil_spk`;
CREATE TABLE IF NOT EXISTS `tbl_hasil_spk` (
  `id_hasil` int NOT NULL AUTO_INCREMENT,
  `id_riwayat` int DEFAULT NULL,
  `id_lahan` int NOT NULL,
  `nilai_preferensi` decimal(10,5) NOT NULL,
  `ranking` int NOT NULL,
  `status` enum('Sangat Layak','Layak','Cukup Layak','Tidak Layak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_hitung` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_hasil`),
  KEY `id_lahan` (`id_lahan`),
  KEY `fk_hasil_riwayat` (`id_riwayat`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_hasil_spk`
--

INSERT INTO `tbl_hasil_spk` (`id_hasil`, `id_riwayat`, `id_lahan`, `nilai_preferensi`, `ranking`, `status`, `tanggal_hitung`) VALUES
(82, NULL, 1, 0.90000, 1, 'Sangat Layak', '2026-06-19 10:33:10'),
(83, NULL, 4, 0.90000, 2, 'Sangat Layak', '2026-06-19 10:33:10'),
(84, NULL, 3, 0.82000, 3, 'Layak', '2026-06-19 10:33:10'),
(85, NULL, 5, 0.74000, 4, 'Cukup Layak', '2026-06-19 10:33:10'),
(86, NULL, 14, 0.72000, 5, 'Cukup Layak', '2026-06-19 10:33:10'),
(87, NULL, 9, 0.65000, 6, 'Cukup Layak', '2026-06-19 10:33:10'),
(88, NULL, 8, 0.59000, 7, 'Tidak Layak', '2026-06-19 10:33:10'),
(89, NULL, 6, 0.57000, 8, 'Tidak Layak', '2026-06-19 10:33:10'),
(90, NULL, 12, 0.56000, 9, 'Tidak Layak', '2026-06-19 10:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_irigasi`
--

DROP TABLE IF EXISTS `tbl_irigasi`;
CREATE TABLE IF NOT EXISTS `tbl_irigasi` (
  `id_irigasi` int NOT NULL AUTO_INCREMENT,
  `nama_irigasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `panjang_jalur` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `lebar_jalur` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `jalur_geojson` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `warna` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ketebalan` int DEFAULT NULL,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') DEFAULT 'Baik',
  PRIMARY KEY (`id_irigasi`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_irigasi`
--

INSERT INTO `tbl_irigasi` (`id_irigasi`, `nama_irigasi`, `panjang_jalur`, `lebar_jalur`, `jalur_geojson`, `warna`, `ketebalan`, `gambar`, `kondisi`) VALUES
(1, 'Irigasi 1', '7000 m', '3 m', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[100.922556,-1.968054],[100.921612,-1.968912],[100.921183,-1.969855],[100.920839,-1.970713],[100.920582,-1.971742],[100.920753,-1.972343],[100.920882,-1.972879],[100.920711,-1.97363],[100.920603,-1.974316],[100.920346,-1.975195],[100.920067,-1.976525],[100.919766,-1.977254],[100.919509,-1.977575],[100.918093,-1.97839],[100.91702,-1.978991],[100.916162,-1.979634],[100.914917,-1.980192],[100.913801,-1.980792],[100.9126,-1.981092],[100.910754,-1.981393],[100.909767,-1.981436],[100.90878,-1.981436],[100.907922,-1.981221],[100.907063,-1.980835],[100.906076,-1.980578],[100.905304,-1.980278],[100.904617,-1.98002],[100.904145,-1.979849],[100.902901,-1.979377],[100.902343,-1.979248],[100.901399,-1.979077],[100.900326,-1.979034],[100.899124,-1.979034],[100.897579,-1.979162],[100.894232,-1.979891],[100.892515,-1.980063],[100.891528,-1.979977],[100.890241,-1.979377],[100.889511,-1.978991],[100.888395,-1.978605],[100.887494,-1.978476],[100.886507,-1.978133],[100.885735,-1.977618],[100.885391,-1.988469],[100.884318,-1.977318],[100.883117,-1.977318],[100.882044,-1.977618],[100.881658,-1.978176],[100.8814,-1.978991],[100.881443,-1.979634],[100.8814,-1.980235],[100.8814,-1.980835],[100.880971,-1.981393],[100.880156,-1.981307],[100.879383,-1.981693],[100.877366,-1.982293],[100.876808,-1.982679],[100.876465,-1.98328],[100.876293,-1.983666],[100.876164,-1.98491],[100.875692,-1.98581],[100.874748,-1.986239],[100.874534,-1.987097],[100.874147,-1.987998],[100.874062,-1.988898],[100.874448,-1.989842],[100.875864,-1.989971],[100.875607,-1.990528],[100.874319,-1.991386]]}}]}', '#0055FF', 5, '007515200_1532563175-Jaringan_irigasi-ok.jpg', 'Baik'),
(2, 'Irigasi 2', '5000 m', '3 m', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[100.876207,-1.983837],[100.875735,-1.98328],[100.875134,-1.98358],[100.874577,-1.98418],[100.87389,-1.983837],[100.873847,-1.98298],[100.874104,-1.982336],[100.874577,-1.981736],[100.875134,-1.981178],[100.875306,-1.980492],[100.874705,-1.979977],[100.873761,-1.979977],[100.873289,-1.980063],[100.873418,-1.979119],[100.873504,-1.978776],[100.873203,-1.978219],[100.872774,-1.977961],[100.872388,-1.977661],[100.872087,-1.977189],[100.871744,-1.976718],[100.871229,-1.976375],[100.871315,-1.97556],[100.870457,-1.975217],[100.869727,-1.975217],[100.869298,-1.975345]]}}]}', '#FF0808', 8, 'unnamed.jpg', 'Baik'),
(3, 'Irigasi 3', '1000 m', '3 m', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[100.905819,-1.984352],[100.905347,-1.983666],[100.904875,-1.983108],[100.904531,-1.982293],[100.904531,-1.981693],[100.903587,-1.981564],[100.902858,-1.981779],[100.902214,-1.981135],[100.901313,-1.981178],[100.900669,-1.981436],[100.900455,-1.980921],[100.900025,-1.980664],[100.899038,-1.980406],[100.897794,-1.98032],[100.896206,-1.980535],[100.895519,-1.980878],[100.894704,-1.981307],[100.894425,-1.98105],[100.894361,-1.980803],[100.894006,-1.98136],[100.893985,-1.981671],[100.89376,-1.981832],[100.893449,-1.981843],[100.893255,-1.981521],[100.893416,-1.981243],[100.893534,-1.980921],[100.893363,-1.980706],[100.89303,-1.980664],[100.892848,-1.981146],[100.892504,-1.981425],[100.892,-1.981436],[100.891818,-1.980985],[100.891593,-1.980749],[100.891303,-1.980535],[100.89097,-1.980267],[100.890638,-1.980009],[100.89038,-1.979763],[100.889179,-1.979741],[100.888696,-1.979795],[100.888385,-1.979913],[100.887998,-1.979988],[100.88773,-1.980149],[100.88728,-1.980192],[100.886797,-1.979988],[100.886217,-1.979774],[100.885166,-1.979581],[100.884587,-1.979666],[100.884329,-1.979795],[100.884104,-1.979891],[100.883932,-1.979945],[100.883718,-1.979859],[100.883374,-1.979913],[100.88302,-1.980138],[100.88273,-1.980406],[100.882462,-1.980953],[100.882033,-1.981103],[100.881604,-1.981167]]}}]}', '#FFFF0E', 3, '007515200_1532563175-Jaringan_irigasi-ok2.jpg', 'Baik'),
(5, 'irigasi sukamaju', '4000', '2', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[107.141828,-6.803564],[107.141801,-6.803713],[107.141785,-6.803836],[107.141801,-6.803921],[107.141779,-6.80407],[107.141779,-6.804187],[107.141753,-6.804326],[107.141779,-6.804512],[107.141758,-6.804587],[107.141522,-6.804672],[107.141318,-6.804672],[107.141146,-6.804736],[107.140953,-6.804757],[107.140845,-6.804757],[107.14069,-6.804757],[107.140421,-6.804784],[107.140255,-6.804843],[107.14011,-6.804608],[107.139997,-6.804523],[107.139944,-6.804427],[107.14003,-6.804273],[107.140174,-6.804102],[107.140239,-6.80407],[107.140781,-6.804353],[107.14091,-6.804326],[107.141006,-6.804262],[107.140996,-6.804177],[107.140985,-6.804081],[107.140985,-6.804001],[107.141044,-6.803916],[107.141119,-6.803846],[107.1412,-6.803783]]}}]}', '#1E446D', 3, 'Screenshot_2026-06-10_0031032.png', 'Rusak Ringan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kondisi_lahan`
--

DROP TABLE IF EXISTS `tbl_kondisi_lahan`;
CREATE TABLE IF NOT EXISTS `tbl_kondisi_lahan` (
  `id_kondisi` int NOT NULL AUTO_INCREMENT,
  `id_lahan` int DEFAULT NULL,
  `tahun` year DEFAULT NULL,
  `jenis_tanah` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ph_tanah` decimal(3,1) DEFAULT NULL,
  `sumber_air` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curah_hujan` decimal(10,2) DEFAULT NULL,
  `ketinggian` int DEFAULT NULL,
  `tanggal_input` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kondisi`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_kondisi_lahan`
--

INSERT INTO `tbl_kondisi_lahan` (`id_kondisi`, `id_lahan`, `tahun`, `jenis_tanah`, `ph_tanah`, `sumber_air`, `curah_hujan`, `ketinggian`, `tanggal_input`) VALUES
(1, 14, NULL, 'Lempung', 6.5, 'Irigasi', 2000.00, 500, '2026-06-18 22:58:43'),
(3, 3, NULL, 'Lempung', 6.8, 'Irigasi', 2200.00, 450, '2026-06-18 22:58:43'),
(4, 4, NULL, 'Humus', 6.5, 'Sungai', 2500.00, 650, '2026-06-18 22:58:43'),
(5, 5, NULL, 'Liat', 5.8, 'Irigasi', 3000.00, 550, '2026-06-18 22:58:43'),
(6, 6, NULL, 'Aluvial', 6.7, 'Irigasi', 2100.00, 350, '2026-06-18 22:58:43'),
(8, 8, NULL, 'Lempung', 6.3, 'Irigasi', 2400.00, 400, '2026-06-18 22:58:43'),
(9, 9, NULL, 'Humus', 6.9, 'Sungai', 2600.00, 700, '2026-06-18 22:58:43'),
(11, 11, NULL, 'Aluvial', 6.6, 'Irigasi', 2300.00, 300, '2026-06-18 22:58:43'),
(12, 12, NULL, 'Lempung', 6.4, 'Sumur', 1900.00, 250, '2026-06-18 22:58:43'),
(13, 13, NULL, 'Humus', 7.0, 'Sungai', 2800.00, 800, '2026-06-18 22:58:43'),
(16, 1, NULL, 'Lempung', 6.5, 'Irigasi', 2500.00, 500, '2026-06-18 22:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kriteria`
--

DROP TABLE IF EXISTS `tbl_kriteria`;
CREATE TABLE IF NOT EXISTS `tbl_kriteria` (
  `id_kriteria` int NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  `atribut` enum('benefit','cost') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sumber_data` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_kriteria`
--

INSERT INTO `tbl_kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`, `atribut`, `sumber_data`) VALUES
(6, 'Produksi Panen', 0.25, 'benefit', 'tbl_produksi.hasil_panen'),
(5, 'Luas Lahan', 0.25, 'benefit', 'tbl_lahan.luas_lahan'),
(7, 'Jarak Irigasi', 0.2, 'cost', 'tbl_analisis_irigasi.jarak_meter'),
(8, 'PH Tanah', 0.15, 'benefit', 'tbl_kondisi_lahan.ph_tanah'),
(9, 'Curah Hujan', 0.15, 'benefit', 'tbl_kondisi_lahan.curah_hujan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lahan`
--

DROP TABLE IF EXISTS `tbl_lahan`;
CREATE TABLE IF NOT EXISTS `tbl_lahan` (
  `id_lahan` int NOT NULL AUTO_INCREMENT,
  `nama_lahan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `luas_lahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `isi_lahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pemilik_lahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `alamat_pemilik` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `tahun` year DEFAULT NULL,
  `denah_geojson` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `warna` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `luas_ha` int DEFAULT NULL,
  PRIMARY KEY (`id_lahan`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_lahan`
--

INSERT INTO `tbl_lahan` (`id_lahan`, `nama_lahan`, `luas_lahan`, `isi_lahan`, `pemilik_lahan`, `alamat_pemilik`, `tahun`, `denah_geojson`, `warna`, `gambar`, `latitude`, `longitude`, `luas_ha`) VALUES
(1, 'Lahan 1', '100 m', 'Lahan 1', 'Pak Budi', 'Padang', '2023', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.873075,-1.969512],[100.876122,-1.969469],[100.876336,-1.976889],[100.876057,-1.976986],[100.875617,-1.97705],[100.875124,-1.977093],[100.874684,-1.977136],[100.874362,-1.977179],[100.873933,-1.977211],[100.873536,-1.977232],[100.873182,-1.977254],[100.873032,-1.977254],[100.873042,-1.976911],[100.873128,-1.976503],[100.873203,-1.976203],[100.8733,-1.975753],[100.873321,-1.975334],[100.873375,-1.975056],[100.873053,-1.974809],[100.871872,-1.974166],[100.873332,-1.973126],[100.872001,-1.97275],[100.873332,-1.971893],[100.873075,-1.969512]]]}}]}', '#E91818', 'obet.jpg', NULL, NULL, 1000),
(3, 'Lahan 3', '100 m', 'Jagung', 'Pak Budi', 'Padang', '2025', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.879169,-1.969512],[100.881915,-1.969469],[100.881958,-1.974659],[100.881615,-1.975045],[100.8811,-1.975217],[100.880585,-1.975388],[100.880198,-1.97556],[100.879769,-1.975731],[100.879426,-1.975989],[100.879169,-1.97616],[100.879169,-1.969512]]]}}]}', '#0C43F3', 'webcam-toy-photo61.jpg', NULL, NULL, 100),
(4, 'Lahan 44', '100 m', 'Lahan 44', 'Pak Budi', 'Padang', '2023', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.882001,-1.969469],[100.881915,-1.963936],[100.88479,-1.963894],[100.884833,-1.969512],[100.882001,-1.969469]]]}}]}', '#18E9FF', '722097227_1755940285397075_7607844808996015738_n.jpg', NULL, NULL, 100),
(5, 'Lahan 5', '100 m', 'Jagung', 'Pak Budi', 'Padang', NULL, '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.884876,-1.969469],[100.887752,-1.969512],[100.887709,-1.974444],[100.88479,-1.974487],[100.884876,-1.969469]]]}}]}', '#15F3D3', 'IMG_20191103_113942.jpg', NULL, NULL, NULL),
(6, 'Lahan 6', '100 m', 'Padi', 'Pak Budi', 'Padang', NULL, '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.887666,-1.963979],[100.890498,-1.963936],[100.89067,-1.969512],[100.887794,-1.969598],[100.887666,-1.963979]]]}}]}', '#1AFD5B', '0a57ba334d33b288be879e833d1fe16b.jpg', NULL, NULL, NULL),
(14, 'sukamaju', '2000', 'Padi', 'Pak mimin', 'Painan', '2024', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[107.140888,-6.804576],[107.141312,-6.804709],[107.140749,-6.804885],[107.140888,-6.804576]]]}}]}', 'rgb(21, 111, 94)', 'obet1.jpg', NULL, NULL, 2),
(8, 'Lahan 88', '100 m', 'Lahan 8', 'Pak Budi', 'Padang', NULL, '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.895326,-1.968247],[100.895283,-1.96473],[100.893717,-1.964022],[100.896807,-1.963936],[100.89685,-1.966081],[100.896764,-1.968183],[100.896721,-1.969469],[100.893888,-1.969469],[100.895326,-1.968247]]]}}]}', '#15F3D3', 'IMG_20191103_113942.jpg', NULL, NULL, NULL),
(9, 'Lahan 9', '100 m', 'Jagung', 'Pak Budi', 'Padang', NULL, '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.871787,-1.951584],[100.871744,-1.952613],[100.871744,-1.953085],[100.871615,-1.953771],[100.871401,-1.954415],[100.871444,-1.955187],[100.872216,-1.958404],[100.876036,-1.958189],[100.875864,-1.956731],[100.87595,-1.951884],[100.871787,-1.951584]]]}}]}', '#15F3D3', 'IMG_20191103_113942.jpg', NULL, NULL, NULL),
(12, 'Lahan 2', '100 m', 'Lahan 2', 'Pak mimin', 'Painan', '2024', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[107.140078,-6.803687],[107.141227,-6.803852],[107.141291,-6.80447],[107.140158,-6.80463],[107.140078,-6.803687]]]}}]}', 'rgb(111, 21, 21)', 'Screenshot_2026-06-10_003151.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log_penilaian`
--

DROP TABLE IF EXISTS `tbl_log_penilaian`;
CREATE TABLE IF NOT EXISTS `tbl_log_penilaian` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_penilaian` int DEFAULT NULL,
  `id_lahan` int DEFAULT NULL,
  `id_kriteria` int DEFAULT NULL,
  `nilai_lama` decimal(10,2) DEFAULT NULL,
  `nilai_baru` decimal(10,2) DEFAULT NULL,
  `aksi` enum('Tambah','Ubah','Hapus') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id_lahan` (`id_lahan`),
  KEY `id_kriteria` (`id_kriteria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penilaian`
--

DROP TABLE IF EXISTS `tbl_penilaian`;
CREATE TABLE IF NOT EXISTS `tbl_penilaian` (
  `id_penilaian` int NOT NULL AUTO_INCREMENT,
  `id_lahan` int DEFAULT NULL,
  `id_kriteria` int DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`id_penilaian`),
  UNIQUE KEY `id_lahan` (`id_lahan`,`id_kriteria`)
) ENGINE=MyISAM AUTO_INCREMENT=626 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_penilaian`
--

INSERT INTO `tbl_penilaian` (`id_penilaian`, `id_lahan`, `id_kriteria`, `nilai`) VALUES
(581, 1, 5, 5),
(582, 1, 6, 3),
(583, 1, 7, 3),
(584, 1, 8, 5),
(585, 1, 9, 5),
(586, 3, 5, 5),
(587, 3, 6, 2),
(588, 3, 7, 3),
(589, 3, 8, 5),
(590, 3, 9, 4),
(591, 4, 5, 5),
(592, 4, 6, 3),
(593, 4, 7, 3),
(594, 4, 8, 5),
(595, 4, 9, 5),
(596, 5, 5, 1),
(597, 5, 6, 5),
(598, 5, 7, 3),
(599, 5, 8, 3),
(600, 5, 9, 5),
(601, 6, 5, 1),
(602, 6, 6, 1),
(603, 6, 7, 3),
(604, 6, 8, 5),
(605, 6, 9, 4),
(606, 8, 5, 1),
(607, 8, 6, 2),
(608, 8, 7, 3),
(609, 8, 8, 4),
(610, 8, 9, 4),
(611, 9, 5, 1),
(612, 9, 6, 2),
(613, 9, 7, 3),
(614, 9, 8, 5),
(615, 9, 9, 5),
(616, 12, 5, 1),
(617, 12, 6, 2),
(618, 12, 7, 3),
(619, 12, 8, 4),
(620, 12, 9, 3),
(621, 14, 5, 3),
(622, 14, 6, 2),
(623, 14, 7, 3),
(624, 14, 8, 5),
(625, 14, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produksi`
--

DROP TABLE IF EXISTS `tbl_produksi`;
CREATE TABLE IF NOT EXISTS `tbl_produksi` (
  `id_produksi` int NOT NULL AUTO_INCREMENT,
  `id_lahan` int DEFAULT NULL,
  `tahun` int DEFAULT NULL,
  `tanaman` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hasil_panen` double DEFAULT NULL,
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Ton',
  `produktivitas` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_produksi`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_produksi`
--

INSERT INTO `tbl_produksi` (`id_produksi`, `id_lahan`, `tahun`, `tanaman`, `hasil_panen`, `satuan`, `produktivitas`) VALUES
(1, 1, 2023, 'Padi', 7.5, 'Ton', 5.00),
(2, 2, 2023, 'Jagung', 6.2, 'Ton', 4.50),
(3, 3, 2023, 'Padi', 8.1, 'Ton', 5.80),
(4, 4, 2023, 'Cabai', 3.5, 'Ton', 6.20),
(5, 5, 2023, 'Tomat', 4.2, 'Ton', 5.50),
(6, 6, 2023, 'Kedelai', 5, 'Ton', 4.80),
(7, 7, 2023, 'Singkong', 9.5, 'Ton', 7.10),
(8, 8, 2023, 'Padi', 8.3, 'Ton', 5.90),
(9, 9, 2023, 'Jagung', 6.8, 'Ton', 5.10),
(10, 10, 2023, 'Cabai', 3.8, 'Ton', 6.00),
(11, 11, 2024, 'Padi', 8.7, 'Ton', 6.20),
(12, 12, 2024, 'Jagung', 7, 'Ton', 5.30),
(13, 13, 2024, 'Tomat', 4.6, 'Ton', 5.90),
(14, 14, 2024, 'Kedelai', 5.4, 'Ton', 5.00),
(15, 15, 2024, 'Singkong', 10.2, 'Ton', 7.40),
(16, 16, 2024, 'Padi', 9, 'Ton', 6.50),
(17, 17, 2024, 'Jagung', 7.3, 'Ton', 5.60),
(18, 18, 2024, 'Cabai', 4, 'Ton', 6.30),
(19, 19, 2024, 'Tomat', 4.8, 'Ton', 6.10),
(20, 20, 2024, 'Kedelai', 5.7, 'Ton', 5.20),
(21, 21, 2025, 'Padi', 9.3, 'Ton', 6.80),
(22, 22, 2025, 'Jagung', 7.6, 'Ton', 5.90),
(23, 23, 2025, 'Singkong', 10.8, 'Ton', 7.80),
(24, 24, 2025, 'Cabai', 4.3, 'Ton', 6.50),
(25, 25, 2025, 'Tomat', 5.1, 'Ton', 6.30),
(26, 1, 2025, 'Padi', 9.1, 'Ton', 6.60),
(27, 2, 2025, 'Jagung', 7.4, 'Ton', 5.70),
(28, 3, 2025, 'Kedelai', 5.9, 'Ton', 5.40),
(29, 4, 2025, 'Cabai', 4.5, 'Ton', 6.70),
(30, 5, 2025, 'Singkong', 11, 'Ton', 8.00),
(31, 13, 2026, 'Padi', 60, 'Ton', NULL),
(32, 2, 2026, 'Padi', 7, 'Ton', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rekomendasi_tanaman`
--

DROP TABLE IF EXISTS `tbl_rekomendasi_tanaman`;
CREATE TABLE IF NOT EXISTS `tbl_rekomendasi_tanaman` (
  `id_rekomendasi` int NOT NULL AUTO_INCREMENT,
  `id_lahan` int DEFAULT NULL,
  `id_tanaman` int DEFAULT NULL,
  `nilai_kesesuaian` decimal(5,2) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimasi_panen` double NOT NULL,
  `luas_ha` decimal(10,2) DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekomendasi`),
  KEY `id_tanaman` (`id_tanaman`),
  KEY `fk_lahan_rekomendasi` (`id_lahan`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_rekomendasi_tanaman`
--

INSERT INTO `tbl_rekomendasi_tanaman` (`id_rekomendasi`, `id_lahan`, `id_tanaman`, `nilai_kesesuaian`, `status`, `estimasi_panen`, `luas_ha`, `tanggal`) VALUES
(1, 1, 1, 75.00, 'Sesuai', 0.04, 0.01, '2026-06-18 18:55:56'),
(3, 3, 1, 100.00, 'Sangat Sesuai', 500, 100.00, '2026-06-18 18:55:56'),
(4, 4, 1, 75.00, 'Sesuai', 375, 100.00, '2026-06-18 18:55:56'),
(5, 5, 1, 75.00, 'Sesuai', 375, 100.00, '2026-06-18 18:55:56'),
(6, 6, 1, 75.00, 'Sesuai', 375, 100.00, '2026-06-18 18:55:56'),
(8, 8, 1, 100.00, 'Sangat Sesuai', 500, 100.00, '2026-06-18 18:55:56'),
(9, 9, 1, 75.00, 'Sesuai', 375, 100.00, '2026-06-18 18:55:56'),
(11, 12, 1, 100.00, 'Sangat Sesuai', 500, 100.00, '2026-06-18 18:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_riwayat_spk`
--

DROP TABLE IF EXISTS `tbl_riwayat_spk`;
CREATE TABLE IF NOT EXISTS `tbl_riwayat_spk` (
  `id_riwayat` int NOT NULL AUTO_INCREMENT,
  `id_lahan` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `jumlah_lahan` int DEFAULT NULL,
  `jumlah_kriteria` int DEFAULT NULL,
  `keterangan` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_riwayat`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_riwayat_spk`
--

INSERT INTO `tbl_riwayat_spk` (`id_riwayat`, `id_lahan`, `tanggal`, `jumlah_lahan`, `jumlah_kriteria`, `keterangan`) VALUES
(1, 5, '2026-06-18 16:37:27', 12, 5, 'Kalkulasi SPK Metode SAW Otomatis Berhasil.'),
(2, 5, '2026-06-18 17:34:48', 12, 5, 'Kalkulasi SPK Metode SAW Otomatis Berhasil.'),
(3, 1, '2026-06-19 10:31:08', 9, 5, 'Kalkulasi SPK Metode SAW Otomatis Berhasil.'),
(4, 1, '2026-06-19 10:33:10', 9, 5, 'Kalkulasi SPK Metode SAW Otomatis Berhasil.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tanaman`
--

DROP TABLE IF EXISTS `tbl_tanaman`;
CREATE TABLE IF NOT EXISTS `tbl_tanaman` (
  `id_tanaman` int NOT NULL AUTO_INCREMENT,
  `nama_tanaman` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ph_min` decimal(3,1) DEFAULT NULL,
  `ph_max` decimal(3,1) DEFAULT NULL,
  `jenis_tanah` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kebutuhan_air` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curah_min` int DEFAULT NULL,
  `curah_max` int DEFAULT NULL,
  `tinggi_min` int DEFAULT NULL,
  `tinggi_max` int DEFAULT NULL,
  PRIMARY KEY (`id_tanaman`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_tanaman`
--

INSERT INTO `tbl_tanaman` (`id_tanaman`, `nama_tanaman`, `ph_min`, `ph_max`, `jenis_tanah`, `kebutuhan_air`, `curah_min`, `curah_max`, `tinggi_min`, `tinggi_max`) VALUES
(1, 'Padi', 5.5, 7.5, 'Lempung', 'tinggi', 1500, 4000, 0, 800),
(2, 'Jagung', 5.0, 7.0, 'Liat', 'sedang', 1000, 2500, 0, 1200),
(3, 'Kedelai', 5.0, 6.8, 'Lempung', 'sedang', 1000, 3000, 0, 700),
(4, 'Cabai', 6.0, 7.0, 'Lempung', 'sedang', 1500, 3500, 0, 1400),
(5, 'Kentang', 5.0, 6.5, 'Lempung', 'sedang', 1200, 3000, 700, 2500),
(6, 'Tomat', 5.5, 7.0, 'Lempung', 'sedang', 1000, 2500, 0, 1500),
(7, 'Bawang Merah', 5.6, 6.5, 'Liat', 'rendah', 800, 2000, 0, 1000),
(8, 'Singkong', 4.5, 8.0, 'Liat', 'rendah', 500, 2500, 0, 1500),
(9, 'Kacang Tanah', 5.0, 7.0, 'Lempung', 'rendah', 500, 2000, 0, 1200),
(10, 'Ubi Jalar', 5.0, 7.5, 'Lempung', 'rendah', 800, 2500, 0, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nama_user`, `username`, `password`) VALUES
(1, 'Mardalius', 'admin', 'admin'),
(2, 'Budi', 'budi', 'budi');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
