/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : gis-lahan-irigasi

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 05/07/2020 09:46:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_galeri_lahan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_galeri_lahan`;
CREATE TABLE `tbl_galeri_lahan`  (
  `id_galeri_lahan` int(11) NOT NULL AUTO_INCREMENT,
  `id_lahan` int(11) NULL DEFAULT NULL,
  `ket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `foto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_galeri_lahan`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_galeri_lahan
-- ----------------------------
INSERT INTO `tbl_galeri_lahan` VALUES (8, 1, 'Gambar', '6.jpg');
INSERT INTO `tbl_galeri_lahan` VALUES (2, 1, 'Foto Dari Selatan', '2.jpg');
INSERT INTO `tbl_galeri_lahan` VALUES (3, 1, 'Foto Dari Udara', '3.jpg');
INSERT INTO `tbl_galeri_lahan` VALUES (7, 1, 'Foto Dari Selatan', '5.jpg');
INSERT INTO `tbl_galeri_lahan` VALUES (6, 1, 'Foto Dari Udara', '4.jpg');
INSERT INTO `tbl_galeri_lahan` VALUES (9, 1, 'foto', '42747862_dB7Z2aZBsiTDoKqhvDxUptPZyO5stlvxA5xa93He_8o1.jpg');
INSERT INTO `tbl_galeri_lahan` VALUES (10, 1, 'Gambar 3', 'G7-green-800.jpg');

-- ----------------------------
-- Table structure for tbl_irigasi
-- ----------------------------
DROP TABLE IF EXISTS `tbl_irigasi`;
CREATE TABLE `tbl_irigasi`  (
  `id_irigasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_irigasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `panjang_jalur` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lebar_jalur` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jalur_geojson` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `warna` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ketebalan` int(2) NULL DEFAULT NULL,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_irigasi`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_irigasi
-- ----------------------------
INSERT INTO `tbl_irigasi` VALUES (1, 'Irigasi 1', '7000 m', '3 m', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[100.922556,-1.968054],[100.921612,-1.968912],[100.921183,-1.969855],[100.920839,-1.970713],[100.920582,-1.971742],[100.920753,-1.972343],[100.920882,-1.972879],[100.920711,-1.97363],[100.920603,-1.974316],[100.920346,-1.975195],[100.920067,-1.976525],[100.919766,-1.977254],[100.919509,-1.977575],[100.918093,-1.97839],[100.91702,-1.978991],[100.916162,-1.979634],[100.914917,-1.980192],[100.913801,-1.980792],[100.9126,-1.981092],[100.910754,-1.981393],[100.909767,-1.981436],[100.90878,-1.981436],[100.907922,-1.981221],[100.907063,-1.980835],[100.906076,-1.980578],[100.905304,-1.980278],[100.904617,-1.98002],[100.904145,-1.979849],[100.902901,-1.979377],[100.902343,-1.979248],[100.901399,-1.979077],[100.900326,-1.979034],[100.899124,-1.979034],[100.897579,-1.979162],[100.894232,-1.979891],[100.892515,-1.980063],[100.891528,-1.979977],[100.890241,-1.979377],[100.889511,-1.978991],[100.888395,-1.978605],[100.887494,-1.978476],[100.886507,-1.978133],[100.885735,-1.977618],[100.885391,-1.988469],[100.884318,-1.977318],[100.883117,-1.977318],[100.882044,-1.977618],[100.881658,-1.978176],[100.8814,-1.978991],[100.881443,-1.979634],[100.8814,-1.980235],[100.8814,-1.980835],[100.880971,-1.981393],[100.880156,-1.981307],[100.879383,-1.981693],[100.877366,-1.982293],[100.876808,-1.982679],[100.876465,-1.98328],[100.876293,-1.983666],[100.876164,-1.98491],[100.875692,-1.98581],[100.874748,-1.986239],[100.874534,-1.987097],[100.874147,-1.987998],[100.874062,-1.988898],[100.874448,-1.989842],[100.875864,-1.989971],[100.875607,-1.990528],[100.874319,-1.991386]]}}]}', '#0055FF', 5, '007515200_1532563175-Jaringan_irigasi-ok.jpg');
INSERT INTO `tbl_irigasi` VALUES (2, 'Irigasi 2', '5000 m', '3 m', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[100.876207,-1.983837],[100.875735,-1.98328],[100.875134,-1.98358],[100.874577,-1.98418],[100.87389,-1.983837],[100.873847,-1.98298],[100.874104,-1.982336],[100.874577,-1.981736],[100.875134,-1.981178],[100.875306,-1.980492],[100.874705,-1.979977],[100.873761,-1.979977],[100.873289,-1.980063],[100.873418,-1.979119],[100.873504,-1.978776],[100.873203,-1.978219],[100.872774,-1.977961],[100.872388,-1.977661],[100.872087,-1.977189],[100.871744,-1.976718],[100.871229,-1.976375],[100.871315,-1.97556],[100.870457,-1.975217],[100.869727,-1.975217],[100.869298,-1.975345]]}}]}', '#FF0808', 8, 'unnamed.jpg');
INSERT INTO `tbl_irigasi` VALUES (3, 'Irigasi 3', '1000 m', '3 m', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"LineString\",\"coordinates\":[[100.905819,-1.984352],[100.905347,-1.983666],[100.904875,-1.983108],[100.904531,-1.982293],[100.904531,-1.981693],[100.903587,-1.981564],[100.902858,-1.981779],[100.902214,-1.981135],[100.901313,-1.981178],[100.900669,-1.981436],[100.900455,-1.980921],[100.900025,-1.980664],[100.899038,-1.980406],[100.897794,-1.98032],[100.896206,-1.980535],[100.895519,-1.980878],[100.894704,-1.981307],[100.894425,-1.98105],[100.894361,-1.980803],[100.894006,-1.98136],[100.893985,-1.981671],[100.89376,-1.981832],[100.893449,-1.981843],[100.893255,-1.981521],[100.893416,-1.981243],[100.893534,-1.980921],[100.893363,-1.980706],[100.89303,-1.980664],[100.892848,-1.981146],[100.892504,-1.981425],[100.892,-1.981436],[100.891818,-1.980985],[100.891593,-1.980749],[100.891303,-1.980535],[100.89097,-1.980267],[100.890638,-1.980009],[100.89038,-1.979763],[100.889179,-1.979741],[100.888696,-1.979795],[100.888385,-1.979913],[100.887998,-1.979988],[100.88773,-1.980149],[100.88728,-1.980192],[100.886797,-1.979988],[100.886217,-1.979774],[100.885166,-1.979581],[100.884587,-1.979666],[100.884329,-1.979795],[100.884104,-1.979891],[100.883932,-1.979945],[100.883718,-1.979859],[100.883374,-1.979913],[100.88302,-1.980138],[100.88273,-1.980406],[100.882462,-1.980953],[100.882033,-1.981103],[100.881604,-1.981167]]}}]}', '#FFFF0E', 3, '007515200_1532563175-Jaringan_irigasi-ok2.jpg');

-- ----------------------------
-- Table structure for tbl_lahan
-- ----------------------------
DROP TABLE IF EXISTS `tbl_lahan`;
CREATE TABLE `tbl_lahan`  (
  `id_lahan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lahan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `luas_lahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `isi_lahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pemilik_lahan` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_pemilik` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `denah_geojson` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `warna` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_lahan`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_lahan
-- ----------------------------
INSERT INTO `tbl_lahan` VALUES (1, 'Lahan 1', '100 m', 'Padi', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.873075,-1.969512],[100.876122,-1.969469],[100.876336,-1.976889],[100.876057,-1.976986],[100.875617,-1.97705],[100.875124,-1.977093],[100.874684,-1.977136],[100.874362,-1.977179],[100.873933,-1.977211],[100.873536,-1.977232],[100.873182,-1.977254],[100.873032,-1.977254],[100.873042,-1.976911],[100.873128,-1.976503],[100.873203,-1.976203],[100.8733,-1.975753],[100.873321,-1.975334],[100.873375,-1.975056],[100.873407,-1.974509],[100.873332,-1.973983],[100.873332,-1.973126],[100.873332,-1.971893],[100.873075,-1.969512]]]}}]}', '#E91818', '0a57ba334d33b288be879e833d1fe16b.jpg');
INSERT INTO `tbl_lahan` VALUES (2, 'Lahan 2', '100 m', 'Kelapa', 'Pak Maman', 'Painan', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.87625,-1.969426],[100.876164,-1.963936],[100.878997,-1.963894],[100.879083,-1.969426],[100.87625,-1.969426]]]}}]}', '#F115E6', 'COGaykcVEAAhdq4.jpg');
INSERT INTO `tbl_lahan` VALUES (3, 'Lahan 3', '100 m', 'Jagung', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.879169,-1.969512],[100.881915,-1.969469],[100.881958,-1.974659],[100.881615,-1.975045],[100.8811,-1.975217],[100.880585,-1.975388],[100.880198,-1.97556],[100.879769,-1.975731],[100.879426,-1.975989],[100.879169,-1.97616],[100.879169,-1.969512]]]}}]}', '#0C43F3', 'IMG_20191103_113942.jpg');
INSERT INTO `tbl_lahan` VALUES (4, 'Lahan 44', '100 m', 'Lahan 44', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.882001,-1.969469],[100.881915,-1.963936],[100.88479,-1.963894],[100.884833,-1.969512],[100.882001,-1.969469]]]}}]}', '#18E9FF', 'IMG_20191103_113942.jpg');
INSERT INTO `tbl_lahan` VALUES (5, 'Lahan 5', '100 m', 'Jagung', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.884876,-1.969469],[100.887752,-1.969512],[100.887709,-1.974444],[100.88479,-1.974487],[100.884876,-1.969469]]]}}]}', '#15F3D3', 'IMG_20191103_113942.jpg');
INSERT INTO `tbl_lahan` VALUES (6, 'Lahan 6', '100 m', 'Padi', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.887666,-1.963979],[100.890498,-1.963936],[100.89067,-1.969512],[100.887794,-1.969598],[100.887666,-1.963979]]]}}]}', '#1AFD5B', '0a57ba334d33b288be879e833d1fe16b.jpg');
INSERT INTO `tbl_lahan` VALUES (7, 'Lahan 7', '100 m', 'Kelapa', 'Pak Maman', 'Painan', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.890541,-1.958404],[100.893545,-1.958404],[100.893631,-1.963936],[100.890584,-1.963936],[100.890541,-1.958404]]]}}]}', '#EDED13', 'COGaykcVEAAhdq4.jpg');
INSERT INTO `tbl_lahan` VALUES (8, 'Lahan 88', '100 m', 'Lahan 8', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.895326,-1.968247],[100.895283,-1.96473],[100.893717,-1.964022],[100.896807,-1.963936],[100.89685,-1.966081],[100.896764,-1.968183],[100.896721,-1.969469],[100.893888,-1.969469],[100.895326,-1.968247]]]}}]}', '#15F3D3', 'IMG_20191103_113942.jpg');
INSERT INTO `tbl_lahan` VALUES (9, 'Lahan 9', '100 m', 'Jagung', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.871787,-1.951584],[100.871744,-1.952613],[100.871744,-1.953085],[100.871615,-1.953771],[100.871401,-1.954415],[100.871444,-1.955187],[100.872216,-1.958404],[100.876036,-1.958189],[100.875864,-1.956731],[100.87595,-1.951884],[100.871787,-1.951584]]]}}]}', '#15F3D3', 'IMG_20191103_113942.jpg');
INSERT INTO `tbl_lahan` VALUES (11, 'Lahan A2', '100 m', 'Cabe', 'Pak Budi', 'Padang', '{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Polygon\",\"coordinates\":[[[100.90127,-1.964194],[100.906463,-1.96458],[100.912642,-1.965094],[100.913115,-1.974359],[100.907922,-1.974359],[100.905604,-1.974487],[100.903587,-1.974487],[100.901828,-1.97453],[100.901227,-1.974316],[100.901227,-1.972429],[100.901227,-1.968183],[100.90127,-1.966081],[100.90127,-1.964194]]]}}]}', '#FFF300', '007515200_1532563175-Jaringan_irigasi-ok1.jpg');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, 'Mardalius', 'admin', 'admin');
INSERT INTO `tbl_user` VALUES (2, 'Budi', 'budi', 'budi');

SET FOREIGN_KEY_CHECKS = 1;
