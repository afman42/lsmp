/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : lsmp

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 29/11/2020 15:40:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kelas_siswa
-- ----------------------------
DROP TABLE IF EXISTS `kelas_siswa`;
CREATE TABLE `kelas_siswa`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` int(11) NULL DEFAULT NULL,
  `siswa_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mapel
-- ----------------------------
DROP TABLE IF EXISTS `mapel`;
CREATE TABLE `mapel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for mapel_kelas
-- ----------------------------
DROP TABLE IF EXISTS `mapel_kelas`;
CREATE TABLE `mapel_kelas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kelas_id` int(11) NULL DEFAULT NULL,
  `mapel_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pengajar
-- ----------------------------
DROP TABLE IF EXISTS `pengajar`;
CREATE TABLE `pengajar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jk` int(1) NULL DEFAULT NULL COMMENT '1 = laki-laki, 0 = perempuan',
  `tempat_lahir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_lahir` date NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `foto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `mapel_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for siswa
-- ----------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jk` int(1) NULL DEFAULT NULL COMMENT '1 = laki - laki, 0 = perempuan',
  `tempat_lahir` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_lahir` date NULL DEFAULT NULL,
  `agama` enum('islam','konghucu','kristen','protestan','yahudi') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `tahun_masuk` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `foto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for soal
-- ----------------------------
DROP TABLE IF EXISTS `soal`;
CREATE TABLE `soal`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pertanyaan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `pg_a` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `pg_b` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `pg_c` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `pg_d` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `jwb_pg` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pengajar_id` int(11) NULL DEFAULT NULL,
  `ujian_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ujian
-- ----------------------------
DROP TABLE IF EXISTS `ujian`;
CREATE TABLE `ujian`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ujian` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jsoal` int(11) NULL DEFAULT NULL,
  `mapel_kelas_id` int(11) NULL DEFAULT NULL,
  `pengajar_id` int(11) NULL DEFAULT NULL,
  `tgl_expired` datetime(0) NULL DEFAULT NULL,
  `tgl_dibuat` date NULL DEFAULT NULL,
  `jam_mulai` datetime(0) NULL DEFAULT NULL,
  `jam_selesai` datetime(0) NULL DEFAULT NULL,
  `tipe` int(1) NULL DEFAULT NULL COMMENT '1 = UTS/UAS, 2 = Kuis',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_siswa` int(11) NULL DEFAULT NULL,
  `is_pengajar` int(11) NULL DEFAULT NULL,
  `is_admin` int(11) NULL DEFAULT NULL,
  `level` int(1) NULL DEFAULT NULL COMMENT '1 = admin, 2 = pengajar, 3 = siswa',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
