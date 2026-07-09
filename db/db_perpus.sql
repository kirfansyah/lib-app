/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : db_perpus

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 09/07/2026 19:38:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for detail_peminjaman
-- ----------------------------
DROP TABLE IF EXISTS `detail_peminjaman`;
CREATE TABLE `detail_peminjaman`  (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_peminjaman` int NOT NULL,
  `id_buku` int NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'dipinjam',
  `tanggal_kembali` date NULL DEFAULT NULL,
  `denda` int NULL DEFAULT 0,
  PRIMARY KEY (`id_detail`) USING BTREE,
  INDEX `id_peminjaman`(`id_peminjaman` ASC) USING BTREE,
  INDEX `id_buku`(`id_buku` ASC) USING BTREE,
  CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `transaksi_peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `master_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detail_peminjaman
-- ----------------------------
INSERT INTO `detail_peminjaman` VALUES (1, 11, 75, 'dikembalikan', '2026-05-10', 0);
INSERT INTO `detail_peminjaman` VALUES (2, 11, 76, 'dikembalikan', '2026-05-10', 0);
INSERT INTO `detail_peminjaman` VALUES (4, 13, 78, 'dikembalikan', '2026-05-10', 0);
INSERT INTO `detail_peminjaman` VALUES (5, 13, 77, 'dikembalikan', '2026-07-09', 108000);
INSERT INTO `detail_peminjaman` VALUES (6, 13, 76, 'dikembalikan', '2026-05-10', 0);

-- ----------------------------
-- Table structure for group_user
-- ----------------------------
DROP TABLE IF EXISTS `group_user`;
CREATE TABLE `group_user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NOT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updatedBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group_user
-- ----------------------------
INSERT INTO `group_user` VALUES (1, 'e427be11-1f8e-48fa-a203-b24f6736c08f', 'Super Admin', 1, 'SYSTEM', '2025-02-08 11:20:39', 'SYSTEM', '2025-02-15 19:19:09');
INSERT INTO `group_user` VALUES (3, '6574b167-eea9-433d-b866-c885b39a29b9', 'Admin', 1, 'SYSTEM', '2025-02-10 21:10:48', 'SYSTEM', '2025-02-15 19:19:15');
INSERT INTO `group_user` VALUES (4, 'bc693e97-8aab-498c-b01c-bdfb8c5bd4c1', 'User', 1, 'SYSTEM', '2025-02-14 13:56:44', 'SYSTEM', '2025-02-16 11:00:30');

-- ----------------------------
-- Table structure for master_buku
-- ----------------------------
DROP TABLE IF EXISTS `master_buku`;
CREATE TABLE `master_buku`  (
  `id_buku` int NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penulis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `penerbit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tahun_terbit` int NULL DEFAULT NULL,
  `id_kategori` int NULL DEFAULT NULL,
  `stok` int NOT NULL DEFAULT 0,
  `is_active` int NULL DEFAULT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updateBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `uid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_buku`) USING BTREE,
  INDEX `id_kategori`(`id_kategori` ASC) USING BTREE,
  CONSTRAINT `master_buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `master_kategori` (`id_kategori`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_buku
-- ----------------------------
INSERT INTO `master_buku` VALUES (65, 'Harry Potter dan Batu Bertuah', 'J.K. Rowling', 'Gramedia', 1997, 1, 10, 1, 'admin', '2024-02-15 10:00:00', 'admin', '2026-05-10 08:06:23', 'e211');
INSERT INTO `master_buku` VALUES (66, 'The Selfish Gene', 'Richard Dawkins', 'Oxford University Press', 1976, 2, 8, 1, 'admin', '2024-02-15 10:30:00', 'admin', '2026-05-10 08:06:23', 'e212');
INSERT INTO `master_buku` VALUES (67, 'Naruto: The Great Ninja War', 'Masashi Kishimoto', 'Shonen Jump', 2002, 3, 15, 1, 'admin', '2024-02-15 11:00:00', 'admin', '2026-05-10 08:06:23', 'e213');
INSERT INTO `master_buku` VALUES (68, 'The Elegant Universe', 'Brian Greene', 'Vintage Books', 1999, 4, 3, 1, 'admin', '2024-02-15 11:30:00', 'admin', '2026-05-10 08:06:23', 'e214');
INSERT INTO `master_buku` VALUES (69, 'Introduction to Algorithms', 'Thomas H. Cormen', 'MIT Press', 2009, 5, 7, 1, 'admin', '2024-02-15 12:00:00', 'admin', '2026-05-10 08:06:23', 'e215');
INSERT INTO `master_buku` VALUES (70, 'The History of Time', 'Stephen Hawking', 'Bantam Books', 1988, 6, 2, 1, 'admin', '2024-02-15 12:30:00', 'admin', '2026-05-10 08:06:23', 'e216');
INSERT INTO `master_buku` VALUES (71, 'Belajar Matematika Dasar', 'Nina H. Ginting', 'Salemba Empat', 2015, 7, 20, 1, 'admin', '2024-02-15 13:00:00', 'admin', '2026-05-10 08:06:23', 'e217');
INSERT INTO `master_buku` VALUES (72, 'Thinking, Fast and Slow', 'Daniel Kahneman', 'Farrar, Straus and Giroux', 2011, 8, 8, 1, 'admin', '2024-02-15 13:30:00', 'admin', '2026-05-10 08:06:23', 'e218');
INSERT INTO `master_buku` VALUES (73, 'The Diary of a Young Girl', 'Anne Frank', 'Bantam Books', 1947, 9, 6, 1, 'admin', '2024-02-15 14:00:00', 'admin', '2026-05-10 08:06:23', 'e219');
INSERT INTO `master_buku` VALUES (74, 'Sherlock Holmes: The Hound of the Baskervilles', 'Arthur Conan Doyle', 'Penguin Classics', 1902, 10, 4, 1, 'admin', '2024-02-15 14:30:00', 'admin', '2026-05-10 08:06:23', 'e220');
INSERT INTO `master_buku` VALUES (75, 'Pride and Prejudice', 'Jane Austen', 'T. Egerton', 1813, 11, 5, 1, 'admin', '2024-02-15 15:00:00', 'admin', '2026-05-10 11:10:51', 'e221');
INSERT INTO `master_buku` VALUES (76, 'The Quran', 'Rahman', 'Various', 610, 12, 26, 1, 'admin', '2024-02-15 15:30:00', 'admin', '2026-05-10 11:18:38', 'e222');
INSERT INTO `master_buku` VALUES (77, 'The Art of Happiness', 'Dalai Lama', 'Riverhead Books', 1998, 13, 10, 1, 'admin', '2024-02-15 16:00:00', 'admin', '2026-07-09 19:22:14', 'e223');
INSERT INTO `master_buku` VALUES (78, 'P.S. I Love You', 'Cecelia Ahern', 'HarperCollins', 2004, 14, 9, 1, 'admin', '2024-02-15 16:30:00', 'admin', '2026-05-10 11:30:40', 'e224');
INSERT INTO `master_buku` VALUES (79, 'The Lion, the Witch and the Wardrobe', 'C.S. Lewis', 'Geoffrey Bles', 1950, 15, 12, 1, 'admin', '2024-02-15 17:00:00', 'admin', '2026-05-10 08:06:23', 'e225');
INSERT INTO `master_buku` VALUES (81, 'test', 'test', 'test', 2025, 2, 2, 1, 'admin', '2026-04-26 10:26:04', '', '2026-05-10 08:06:23', 'e226');
INSERT INTO `master_buku` VALUES (82, 'asd', 'asd', 'asd', 1234, 12, 0, 1, 'admin', '2026-04-26 11:50:05', '', '2026-05-10 08:06:23', 'e227');

-- ----------------------------
-- Table structure for master_kategori
-- ----------------------------
DROP TABLE IF EXISTS `master_kategori`;
CREATE TABLE `master_kategori`  (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NULL DEFAULT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updateBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_kategori
-- ----------------------------
INSERT INTO `master_kategori` VALUES (1, 'Fiksi', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (2, 'Non-Fiksi', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (3, 'Komik', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (4, 'Sains', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (5, 'Teknologi', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (6, 'Sejarah', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (7, 'Pendidikan', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (8, 'Psikologi', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (9, 'Biografi', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (10, 'Misteri', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (11, 'Sastra', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (12, 'Agama', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (13, 'Kehidupan', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (14, 'Novel Romantis', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (15, 'Anak-anak', 1, 'SYSTEM', '2025-02-15 08:47:10', 'SYSTEM', '2025-02-15 08:47:59');
INSERT INTO `master_kategori` VALUES (16, 'TEST gg', 0, 'SYSTEM', '2025-02-15 10:08:01', 'admin', '2025-02-15 10:25:36');

-- ----------------------------
-- Table structure for member_perpus
-- ----------------------------
DROP TABLE IF EXISTS `member_perpus`;
CREATE TABLE `member_perpus`  (
  `id_member` int NOT NULL AUTO_INCREMENT,
  `nama_member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_active` int NULL DEFAULT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updateBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `uid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_member`) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_perpus
-- ----------------------------
INSERT INTO `member_perpus` VALUES (1, 'Andi Santoso', 'andi.santoso@mail.com', '081234567890', 'Jl. Merdeka No. 15, Jakarta', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:21:50', '111');
INSERT INTO `member_perpus` VALUES (2, '', '', '', '', 0, 'SYSTEM', '2025-02-15 08:57:39', 'admin', '2026-04-26 06:21:52', '222');
INSERT INTO `member_perpus` VALUES (3, 'Citra Dewi', 'citra.dewi@mail.com', '083234567892', 'Jl. Raya No. 35, Surabaya', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:21:53', '333');
INSERT INTO `member_perpus` VALUES (4, 'Dewi Lestari', 'dewi.lestari@mail.com', '084234567893', 'Jl. Sukajadi No. 10, Medan', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:21:54', '444');
INSERT INTO `member_perpus` VALUES (5, 'Eko Kurniawan', 'eko.kurniawan@mail.com', '085234567894', 'Jl. Kebon Jeruk No. 50, Jakarta', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:22:00', '555');
INSERT INTO `member_perpus` VALUES (6, 'Fanny Lestari', 'fanny.lestari@mail.com', '086234567895', 'Jl. Suka Maju No. 72, Yogyakarta', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:22:02', '666');
INSERT INTO `member_perpus` VALUES (7, 'Gilang Ramesh', 'gilang.ramesh@mail.com', '087234567896', 'Jl. Raya Kuta No. 5, Bali', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:22:03', '777');
INSERT INTO `member_perpus` VALUES (8, 'Hannah Putri', 'hannah.putri@mail.com', '088234567897', 'Jl. Cempaka No. 23, Semarang', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:22:05', '888');
INSERT INTO `member_perpus` VALUES (9, 'Indra Wijaya', 'indra.wijaya@mail.com', '089234567898', 'Jl. Sawah No. 40, Makassar', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:22:06', '999');
INSERT INTO `member_perpus` VALUES (10, 'Jasmine Putri', 'jasmine.putri@mail.com', '081234567899', 'Jl. Merdeka No. 18, Surabaya', 1, 'SYSTEM', '2025-02-15 08:57:39', '', '2026-04-26 06:22:09', '1122');
INSERT INTO `member_perpus` VALUES (13, 'test', 'tes@mail.com', '378467837878357', '378678345', 1, 'admin', '2026-04-25 20:43:42', '', '2026-04-26 06:22:12', '2233');
INSERT INTO `member_perpus` VALUES (14, '2323', '2323', '223', '2323', 1, 'admin', '2026-04-25 21:00:37', '', '2026-04-26 06:22:15', '3344');
INSERT INTO `member_perpus` VALUES (17, 'ttt', 'aaa3mail.com', '2323', 'esdsd', 1, 'admin', '2026-04-25 21:09:04', '', '2026-04-26 06:22:16', '4455');
INSERT INTO `member_perpus` VALUES (18, 'qw', 'qw@gmail.com', '222222222222222', 'ddfdfddf', 1, 'admin', '2026-04-25 21:12:46', '', '2026-04-26 06:22:23', '5566');
INSERT INTO `member_perpus` VALUES (19, 'asasa@mail.com', 'asasa@mail.com', '3434', 'dfd', 1, 'admin', '2026-04-25 21:31:39', '', '2026-04-26 06:22:27', '4455');
INSERT INTO `member_perpus` VALUES (20, 'surya', 'asda', '112233', 'gfxc', 1, 'admin', '2026-04-26 11:46:11', '', '2026-04-26 11:46:11', '11552');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NOT NULL,
  `ordinal_number` int NOT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updatedBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updatedAt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 'Dashboard', 'data-feather=\"home\"', '/', 1, 1, 'SYTEM', '2025-02-08 11:21:26', 'SYSTEM', '2025-02-10 21:15:54');
INSERT INTO `menu` VALUES (2, 'Master', 'data-feather=\"hard-drive\"', '/master', 1, 2, 'SYTEM', '2025-02-08 11:22:31', 'SYSTEM', '2025-02-10 21:15:54');
INSERT INTO `menu` VALUES (11, 'Transaksi', 'ata-feather=\"hard-drive\"', '#', 1, 3, 'SYSTEM', '2025-02-15 09:13:09', '', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for rfid_scans
-- ----------------------------
DROP TABLE IF EXISTS `rfid_scans`;
CREATE TABLE `rfid_scans`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `type` enum('member','buku') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'member',
  `status` enum('new','used') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'new',
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 212 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rfid_scans
-- ----------------------------
INSERT INTO `rfid_scans` VALUES (1, '123456', 'member', 'used', '2026-04-25 20:04:54');
INSERT INTO `rfid_scans` VALUES (2, '12212212', 'member', 'used', '2026-04-25 20:05:25');
INSERT INTO `rfid_scans` VALUES (3, '33333333', 'member', 'used', '2026-04-25 20:08:16');
INSERT INTO `rfid_scans` VALUES (4, '33333333', 'member', 'used', '2026-04-25 20:08:24');
INSERT INTO `rfid_scans` VALUES (5, '444', 'member', 'used', '2026-04-25 20:08:45');
INSERT INTO `rfid_scans` VALUES (6, '34343', 'member', 'used', '2026-04-25 20:09:07');
INSERT INTO `rfid_scans` VALUES (7, '3445545', 'member', 'used', '2026-04-25 20:09:11');
INSERT INTO `rfid_scans` VALUES (8, '34324324', 'member', 'used', '2026-04-25 20:09:28');
INSERT INTO `rfid_scans` VALUES (9, '1', 'member', 'used', '2026-04-25 20:09:31');
INSERT INTO `rfid_scans` VALUES (10, '1', 'member', 'used', '2026-04-25 20:11:46');
INSERT INTO `rfid_scans` VALUES (11, '2222', 'member', 'used', '2026-04-25 20:11:54');
INSERT INTO `rfid_scans` VALUES (12, '2222', 'member', 'used', '2026-04-25 20:11:59');
INSERT INTO `rfid_scans` VALUES (13, '2222', 'member', 'used', '2026-04-25 20:12:18');
INSERT INTO `rfid_scans` VALUES (14, '2222', 'member', 'used', '2026-04-25 20:12:39');
INSERT INTO `rfid_scans` VALUES (15, '2222', 'member', 'used', '2026-04-25 20:12:51');
INSERT INTO `rfid_scans` VALUES (16, '444', 'member', 'used', '2026-04-25 20:12:55');
INSERT INTO `rfid_scans` VALUES (17, '444', 'member', 'used', '2026-04-25 20:15:14');
INSERT INTO `rfid_scans` VALUES (18, '4545', 'member', 'used', '2026-04-25 20:15:26');
INSERT INTO `rfid_scans` VALUES (19, '4545', 'member', 'used', '2026-04-25 20:18:16');
INSERT INTO `rfid_scans` VALUES (20, '4545', 'member', 'used', '2026-04-25 20:18:50');
INSERT INTO `rfid_scans` VALUES (21, '4545', 'member', 'used', '2026-04-25 20:19:37');
INSERT INTO `rfid_scans` VALUES (22, '5555', 'member', 'used', '2026-04-25 20:19:47');
INSERT INTO `rfid_scans` VALUES (23, '6666', 'member', 'used', '2026-04-25 20:19:53');
INSERT INTO `rfid_scans` VALUES (24, '5555555w535', 'member', 'used', '2026-04-25 20:20:01');
INSERT INTO `rfid_scans` VALUES (25, 'asasa', 'member', 'used', '2026-04-25 20:30:55');
INSERT INTO `rfid_scans` VALUES (26, '12424323', 'member', 'used', '2026-04-25 20:31:31');
INSERT INTO `rfid_scans` VALUES (27, '12424323', 'member', 'used', '2026-04-25 20:42:38');
INSERT INTO `rfid_scans` VALUES (28, '12424323', 'member', 'used', '2026-04-25 20:43:10');
INSERT INTO `rfid_scans` VALUES (29, '455555', 'member', 'used', '2026-04-25 20:50:55');
INSERT INTO `rfid_scans` VALUES (30, '455555', 'member', 'used', '2026-04-25 20:51:27');
INSERT INTO `rfid_scans` VALUES (31, '455555', 'member', 'used', '2026-04-25 20:52:05');
INSERT INTO `rfid_scans` VALUES (32, '353534545', 'member', 'used', '2026-04-25 20:52:11');
INSERT INTO `rfid_scans` VALUES (33, '353534545', 'member', 'used', '2026-04-25 20:52:18');
INSERT INTO `rfid_scans` VALUES (34, '12424323', 'member', 'used', '2026-04-25 20:55:57');
INSERT INTO `rfid_scans` VALUES (35, '1', 'member', 'used', '2026-04-25 20:57:25');
INSERT INTO `rfid_scans` VALUES (36, '12424323', 'member', 'used', '2026-04-25 20:58:55');
INSERT INTO `rfid_scans` VALUES (37, '12424323', 'member', 'used', '2026-04-25 21:06:12');
INSERT INTO `rfid_scans` VALUES (38, '6666', 'member', 'used', '2026-04-25 21:07:15');
INSERT INTO `rfid_scans` VALUES (39, '333', 'member', 'used', '2026-04-25 21:12:27');
INSERT INTO `rfid_scans` VALUES (40, '333', 'member', 'used', '2026-04-25 21:12:53');
INSERT INTO `rfid_scans` VALUES (41, '333', 'member', 'used', '2026-04-25 21:14:17');
INSERT INTO `rfid_scans` VALUES (42, '333', 'member', 'used', '2026-04-25 21:16:36');
INSERT INTO `rfid_scans` VALUES (43, '333', 'member', 'used', '2026-04-25 21:17:49');
INSERT INTO `rfid_scans` VALUES (44, '333', 'member', 'used', '2026-04-25 21:19:05');
INSERT INTO `rfid_scans` VALUES (45, '333', 'member', 'used', '2026-04-25 21:19:06');
INSERT INTO `rfid_scans` VALUES (46, '333', 'member', 'used', '2026-04-25 21:19:33');
INSERT INTO `rfid_scans` VALUES (47, '334', 'member', 'used', '2026-04-25 21:30:04');
INSERT INTO `rfid_scans` VALUES (48, '333', 'member', 'used', '2026-04-25 21:30:57');
INSERT INTO `rfid_scans` VALUES (49, '333', 'member', 'used', '2026-04-25 21:32:02');
INSERT INTO `rfid_scans` VALUES (50, '333', 'member', 'used', '2026-04-25 21:34:29');
INSERT INTO `rfid_scans` VALUES (51, '333', 'member', 'used', '2026-04-25 21:34:48');
INSERT INTO `rfid_scans` VALUES (52, '333', 'member', 'used', '2026-04-25 21:35:26');
INSERT INTO `rfid_scans` VALUES (53, '333', 'member', 'used', '2026-04-25 21:38:12');
INSERT INTO `rfid_scans` VALUES (54, '333', 'member', 'used', '2026-04-25 21:39:50');
INSERT INTO `rfid_scans` VALUES (55, '333', 'member', 'used', '2026-04-25 21:41:25');
INSERT INTO `rfid_scans` VALUES (56, '333', 'member', 'used', '2026-04-25 21:55:22');
INSERT INTO `rfid_scans` VALUES (57, '333', 'member', 'used', '2026-04-25 21:58:29');
INSERT INTO `rfid_scans` VALUES (58, '333', 'member', 'used', '2026-04-25 21:59:51');
INSERT INTO `rfid_scans` VALUES (59, '333', 'member', 'used', '2026-04-25 22:01:52');
INSERT INTO `rfid_scans` VALUES (60, '333', 'member', 'used', '2026-04-25 22:01:54');
INSERT INTO `rfid_scans` VALUES (61, '333', 'member', 'used', '2026-04-25 22:03:02');
INSERT INTO `rfid_scans` VALUES (62, '333', 'member', 'used', '2026-04-25 22:03:33');
INSERT INTO `rfid_scans` VALUES (63, '333', 'member', 'used', '2026-04-25 22:06:44');
INSERT INTO `rfid_scans` VALUES (64, '333', 'member', 'used', '2026-04-25 22:23:11');
INSERT INTO `rfid_scans` VALUES (65, '123', 'member', 'used', '2026-04-26 06:19:12');
INSERT INTO `rfid_scans` VALUES (66, '123', 'member', 'used', '2026-04-26 06:20:15');
INSERT INTO `rfid_scans` VALUES (67, 'ggggg', 'member', 'used', '2026-04-26 06:20:36');
INSERT INTO `rfid_scans` VALUES (68, 'ggggg', 'member', 'used', '2026-04-26 06:34:11');
INSERT INTO `rfid_scans` VALUES (69, 'ggggg', 'member', 'used', '2026-04-26 07:43:30');
INSERT INTO `rfid_scans` VALUES (70, 'ggggg', 'member', 'used', '2026-04-26 07:45:31');
INSERT INTO `rfid_scans` VALUES (71, '333', 'member', 'used', '2026-04-26 07:49:32');
INSERT INTO `rfid_scans` VALUES (72, '333', 'member', 'used', '2026-04-26 07:57:50');
INSERT INTO `rfid_scans` VALUES (73, '333', 'member', 'used', '2026-04-26 07:57:54');
INSERT INTO `rfid_scans` VALUES (74, '333', 'member', 'used', '2026-04-26 07:58:10');
INSERT INTO `rfid_scans` VALUES (75, '333', 'member', 'used', '2026-04-26 07:58:20');
INSERT INTO `rfid_scans` VALUES (76, '333', 'member', 'used', '2026-04-26 07:58:25');
INSERT INTO `rfid_scans` VALUES (77, '333', 'member', 'used', '2026-04-26 07:58:41');
INSERT INTO `rfid_scans` VALUES (78, '333', 'member', 'used', '2026-04-26 08:00:04');
INSERT INTO `rfid_scans` VALUES (79, '333', 'member', 'used', '2026-04-26 08:00:07');
INSERT INTO `rfid_scans` VALUES (80, '333', 'member', 'used', '2026-04-26 08:00:10');
INSERT INTO `rfid_scans` VALUES (81, '333', 'member', 'used', '2026-04-26 08:00:35');
INSERT INTO `rfid_scans` VALUES (82, '333', 'member', 'used', '2026-04-26 08:01:09');
INSERT INTO `rfid_scans` VALUES (83, '333', 'member', 'used', '2026-04-26 08:01:13');
INSERT INTO `rfid_scans` VALUES (84, '333', 'member', 'used', '2026-04-26 08:02:56');
INSERT INTO `rfid_scans` VALUES (85, '555', 'member', 'used', '2026-04-26 08:04:05');
INSERT INTO `rfid_scans` VALUES (86, '555', 'member', 'used', '2026-04-26 08:04:09');
INSERT INTO `rfid_scans` VALUES (87, '555', 'member', 'used', '2026-04-26 08:05:20');
INSERT INTO `rfid_scans` VALUES (88, '555', 'member', 'used', '2026-04-26 08:05:22');
INSERT INTO `rfid_scans` VALUES (89, '555', 'member', 'used', '2026-04-26 08:05:22');
INSERT INTO `rfid_scans` VALUES (90, '555', 'member', 'used', '2026-04-26 08:05:22');
INSERT INTO `rfid_scans` VALUES (91, '555', 'member', 'used', '2026-04-26 08:05:22');
INSERT INTO `rfid_scans` VALUES (92, '555', 'member', 'used', '2026-04-26 08:05:23');
INSERT INTO `rfid_scans` VALUES (93, '555', 'member', 'used', '2026-04-26 08:05:23');
INSERT INTO `rfid_scans` VALUES (94, '555', 'member', 'used', '2026-04-26 08:05:23');
INSERT INTO `rfid_scans` VALUES (95, '555', 'member', 'used', '2026-04-26 08:05:42');
INSERT INTO `rfid_scans` VALUES (96, '555', 'member', 'used', '2026-04-26 08:06:25');
INSERT INTO `rfid_scans` VALUES (97, '555', 'member', 'used', '2026-04-26 08:06:29');
INSERT INTO `rfid_scans` VALUES (98, '555', 'member', 'used', '2026-04-26 08:06:40');
INSERT INTO `rfid_scans` VALUES (99, '555', 'member', 'used', '2026-04-26 08:08:36');
INSERT INTO `rfid_scans` VALUES (100, '555', 'member', 'used', '2026-04-26 08:10:04');
INSERT INTO `rfid_scans` VALUES (101, '555', 'member', 'used', '2026-04-26 08:10:22');
INSERT INTO `rfid_scans` VALUES (102, '555', 'member', 'used', '2026-04-26 08:10:48');
INSERT INTO `rfid_scans` VALUES (103, '555', 'member', 'used', '2026-04-26 08:21:53');
INSERT INTO `rfid_scans` VALUES (104, '555', 'member', 'used', '2026-04-26 08:25:25');
INSERT INTO `rfid_scans` VALUES (105, '555', 'member', 'used', '2026-04-26 08:25:36');
INSERT INTO `rfid_scans` VALUES (106, '555', 'member', 'used', '2026-04-26 08:26:08');
INSERT INTO `rfid_scans` VALUES (107, '555', 'member', 'used', '2026-04-26 08:28:41');
INSERT INTO `rfid_scans` VALUES (108, '555', 'member', 'used', '2026-04-26 08:28:52');
INSERT INTO `rfid_scans` VALUES (109, '555', 'member', 'used', '2026-04-26 08:29:25');
INSERT INTO `rfid_scans` VALUES (110, '555', 'member', 'used', '2026-04-26 08:56:19');
INSERT INTO `rfid_scans` VALUES (111, '555', 'member', 'used', '2026-04-26 09:14:44');
INSERT INTO `rfid_scans` VALUES (112, 'B11', 'buku', 'used', '2026-04-26 09:14:55');
INSERT INTO `rfid_scans` VALUES (113, 'B11', 'buku', 'used', '2026-04-26 09:14:59');
INSERT INTO `rfid_scans` VALUES (114, 'B11', 'buku', 'used', '2026-04-26 09:15:16');
INSERT INTO `rfid_scans` VALUES (115, 'B11', 'buku', 'used', '2026-04-26 09:15:22');
INSERT INTO `rfid_scans` VALUES (116, '555', 'member', 'used', '2026-04-26 09:15:58');
INSERT INTO `rfid_scans` VALUES (117, 'B11', 'buku', 'used', '2026-04-26 09:17:09');
INSERT INTO `rfid_scans` VALUES (118, 'B11', 'buku', 'used', '2026-04-26 09:17:49');
INSERT INTO `rfid_scans` VALUES (119, 'B11', 'buku', 'used', '2026-04-26 09:17:54');
INSERT INTO `rfid_scans` VALUES (120, 'B11', 'buku', 'used', '2026-04-26 09:18:46');
INSERT INTO `rfid_scans` VALUES (121, 'B11', 'buku', 'used', '2026-04-26 09:18:53');
INSERT INTO `rfid_scans` VALUES (122, 'B11', 'buku', 'used', '2026-04-26 09:18:56');
INSERT INTO `rfid_scans` VALUES (123, 'B11', 'buku', 'used', '2026-04-26 09:18:56');
INSERT INTO `rfid_scans` VALUES (124, '555', 'member', 'used', '2026-04-26 09:20:23');
INSERT INTO `rfid_scans` VALUES (125, 'B11', 'buku', 'used', '2026-04-26 09:20:36');
INSERT INTO `rfid_scans` VALUES (126, 'B11', 'buku', 'used', '2026-04-26 09:20:39');
INSERT INTO `rfid_scans` VALUES (127, 'B11', 'buku', 'used', '2026-04-26 09:20:56');
INSERT INTO `rfid_scans` VALUES (128, 'B11', 'buku', 'used', '2026-04-26 09:20:59');
INSERT INTO `rfid_scans` VALUES (129, 'B11', 'buku', 'used', '2026-04-26 09:20:59');
INSERT INTO `rfid_scans` VALUES (130, '555', 'member', 'used', '2026-04-26 09:21:26');
INSERT INTO `rfid_scans` VALUES (131, '555', 'member', 'used', '2026-04-26 09:22:29');
INSERT INTO `rfid_scans` VALUES (132, 'B11', 'buku', 'used', '2026-04-26 09:22:36');
INSERT INTO `rfid_scans` VALUES (133, 'B12', 'buku', 'used', '2026-04-26 09:22:46');
INSERT INTO `rfid_scans` VALUES (134, '666', 'member', 'used', '2026-04-26 09:37:18');
INSERT INTO `rfid_scans` VALUES (135, 'B14', 'buku', 'used', '2026-04-26 09:37:46');
INSERT INTO `rfid_scans` VALUES (136, 'B15', 'buku', 'used', '2026-04-26 09:37:54');
INSERT INTO `rfid_scans` VALUES (137, '666', 'member', 'used', '2026-04-26 09:39:28');
INSERT INTO `rfid_scans` VALUES (138, 'B14', 'buku', 'used', '2026-04-26 09:39:39');
INSERT INTO `rfid_scans` VALUES (139, 'B15', 'buku', 'used', '2026-04-26 09:39:49');
INSERT INTO `rfid_scans` VALUES (140, '555', 'member', 'used', '2026-04-26 09:43:18');
INSERT INTO `rfid_scans` VALUES (141, 'B14', 'buku', 'used', '2026-04-26 09:43:32');
INSERT INTO `rfid_scans` VALUES (142, '666', 'member', 'used', '2026-04-26 09:45:00');
INSERT INTO `rfid_scans` VALUES (143, 'B14', 'buku', 'used', '2026-04-26 09:45:16');
INSERT INTO `rfid_scans` VALUES (144, 'B15', 'buku', 'used', '2026-04-26 09:45:22');
INSERT INTO `rfid_scans` VALUES (145, 'B15', 'buku', 'used', '2026-04-26 10:16:43');
INSERT INTO `rfid_scans` VALUES (146, 'B15', 'buku', 'used', '2026-04-26 10:17:03');
INSERT INTO `rfid_scans` VALUES (147, 'B15', 'buku', 'used', '2026-04-26 10:20:04');
INSERT INTO `rfid_scans` VALUES (148, 'B25', 'buku', 'used', '2026-04-26 10:20:43');
INSERT INTO `rfid_scans` VALUES (149, 'B25', 'buku', 'used', '2026-04-26 10:20:45');
INSERT INTO `rfid_scans` VALUES (150, 'B65', 'buku', 'used', '2026-04-26 10:25:36');
INSERT INTO `rfid_scans` VALUES (151, '123', 'member', 'used', '2026-04-26 11:38:31');
INSERT INTO `rfid_scans` VALUES (152, '123', 'member', 'used', '2026-04-26 11:39:13');
INSERT INTO `rfid_scans` VALUES (153, '123', 'member', 'used', '2026-04-26 11:39:29');
INSERT INTO `rfid_scans` VALUES (154, '1122', 'member', 'used', '2026-04-26 11:40:44');
INSERT INTO `rfid_scans` VALUES (155, 'B14', 'buku', 'used', '2026-04-26 11:40:59');
INSERT INTO `rfid_scans` VALUES (156, 'B15', 'buku', 'used', '2026-04-26 11:41:08');
INSERT INTO `rfid_scans` VALUES (157, 'B223', 'buku', 'used', '2026-04-26 11:43:07');
INSERT INTO `rfid_scans` VALUES (158, '1122', 'member', 'used', '2026-04-26 11:44:11');
INSERT INTO `rfid_scans` VALUES (159, '1122', 'member', 'used', '2026-04-26 11:44:13');
INSERT INTO `rfid_scans` VALUES (160, '11552', 'member', 'used', '2026-04-26 11:45:07');
INSERT INTO `rfid_scans` VALUES (161, 'B124', 'buku', 'used', '2026-04-26 11:49:47');
INSERT INTO `rfid_scans` VALUES (162, 'B124', 'buku', 'used', '2026-04-26 11:50:42');
INSERT INTO `rfid_scans` VALUES (163, '11552', 'member', 'used', '2026-04-26 11:50:50');
INSERT INTO `rfid_scans` VALUES (164, 'B124', 'buku', 'used', '2026-04-26 11:52:05');
INSERT INTO `rfid_scans` VALUES (165, 'B124', 'buku', 'used', '2026-04-26 11:52:11');
INSERT INTO `rfid_scans` VALUES (166, '666', 'member', 'used', '2026-04-26 13:41:47');
INSERT INTO `rfid_scans` VALUES (167, 'e2 ab', 'member', 'used', '2026-04-26 15:53:12');
INSERT INTO `rfid_scans` VALUES (168, 'e2 ab', 'member', 'used', '2026-04-26 15:53:14');
INSERT INTO `rfid_scans` VALUES (169, 'e2 ab', 'buku', 'used', '2026-04-26 15:53:40');
INSERT INTO `rfid_scans` VALUES (170, 'e2 ab', 'buku', 'used', '2026-04-26 15:53:47');
INSERT INTO `rfid_scans` VALUES (171, 'e2 ab', 'buku', 'used', '2026-04-26 16:04:50');
INSERT INTO `rfid_scans` VALUES (172, '111', 'member', 'used', '2026-05-10 07:56:25');
INSERT INTO `rfid_scans` VALUES (173, 'e2 ab', 'buku', 'used', '2026-05-10 07:56:49');
INSERT INTO `rfid_scans` VALUES (174, '1122', 'member', 'used', '2026-05-10 08:12:27');
INSERT INTO `rfid_scans` VALUES (175, '1122', 'member', 'used', '2026-05-10 08:12:43');
INSERT INTO `rfid_scans` VALUES (176, 'e221', 'buku', 'used', '2026-05-10 08:12:53');
INSERT INTO `rfid_scans` VALUES (177, 'e222', 'buku', 'used', '2026-05-10 08:13:09');
INSERT INTO `rfid_scans` VALUES (178, '1122', 'member', 'used', '2026-05-10 09:22:25');
INSERT INTO `rfid_scans` VALUES (179, 'e211', 'buku', 'used', '2026-05-10 09:22:34');
INSERT INTO `rfid_scans` VALUES (180, 'e211', 'buku', 'used', '2026-05-10 09:22:36');
INSERT INTO `rfid_scans` VALUES (181, 'e222', 'buku', 'used', '2026-05-10 09:22:51');
INSERT INTO `rfid_scans` VALUES (182, 'e211', 'buku', 'used', '2026-05-10 09:23:06');
INSERT INTO `rfid_scans` VALUES (183, 'e223', 'buku', 'used', '2026-05-10 09:23:16');
INSERT INTO `rfid_scans` VALUES (184, '1122', 'member', 'used', '2026-05-10 09:25:31');
INSERT INTO `rfid_scans` VALUES (185, 'e223', 'buku', 'used', '2026-05-10 09:25:50');
INSERT INTO `rfid_scans` VALUES (186, 'e222', 'buku', 'used', '2026-05-10 09:25:59');
INSERT INTO `rfid_scans` VALUES (187, 'e211', 'buku', 'used', '2026-05-10 09:26:09');
INSERT INTO `rfid_scans` VALUES (188, 'e212', 'buku', 'used', '2026-05-10 09:26:21');
INSERT INTO `rfid_scans` VALUES (189, 'e212', 'buku', 'used', '2026-05-10 09:26:23');
INSERT INTO `rfid_scans` VALUES (190, '1123', 'member', 'used', '2026-05-10 09:27:53');
INSERT INTO `rfid_scans` VALUES (191, '1122', 'member', 'used', '2026-05-10 09:28:03');
INSERT INTO `rfid_scans` VALUES (192, 'e211', 'buku', 'used', '2026-05-10 09:28:14');
INSERT INTO `rfid_scans` VALUES (193, 'e221', 'buku', 'used', '2026-05-10 09:28:28');
INSERT INTO `rfid_scans` VALUES (194, 'e222', 'buku', 'used', '2026-05-10 09:28:37');
INSERT INTO `rfid_scans` VALUES (195, '222', 'member', 'used', '2026-05-10 10:24:06');
INSERT INTO `rfid_scans` VALUES (196, '555', 'member', 'used', '2026-05-10 10:24:14');
INSERT INTO `rfid_scans` VALUES (197, 'e223', 'buku', 'used', '2026-05-10 10:24:25');
INSERT INTO `rfid_scans` VALUES (198, 'e223', 'buku', 'used', '2026-05-10 10:24:27');
INSERT INTO `rfid_scans` VALUES (199, 'e222', 'buku', 'used', '2026-05-10 10:24:35');
INSERT INTO `rfid_scans` VALUES (200, 'e224', 'buku', 'used', '2026-05-10 10:24:45');
INSERT INTO `rfid_scans` VALUES (201, '1122', 'member', 'used', '2026-05-10 11:23:21');
INSERT INTO `rfid_scans` VALUES (202, '1122', 'member', 'used', '2026-05-10 11:23:24');
INSERT INTO `rfid_scans` VALUES (203, '123', 'member', 'used', '2026-05-10 11:23:29');
INSERT INTO `rfid_scans` VALUES (204, '222', 'member', 'used', '2026-07-09 19:24:23');
INSERT INTO `rfid_scans` VALUES (205, '222', 'member', 'used', '2026-07-09 19:24:29');
INSERT INTO `rfid_scans` VALUES (206, '222', 'member', 'used', '2026-07-09 19:24:47');
INSERT INTO `rfid_scans` VALUES (207, '222', 'member', 'used', '2026-07-09 19:24:49');
INSERT INTO `rfid_scans` VALUES (208, '222', 'member', 'used', '2026-07-09 19:24:49');
INSERT INTO `rfid_scans` VALUES (209, '333', 'member', 'used', '2026-07-09 19:25:06');
INSERT INTO `rfid_scans` VALUES (210, '1122', 'member', 'used', '2026-07-09 19:25:48');
INSERT INTO `rfid_scans` VALUES (211, '1122', 'member', 'used', '2026-07-09 19:28:13');

-- ----------------------------
-- Table structure for sub_menu
-- ----------------------------
DROP TABLE IF EXISTS `sub_menu`;
CREATE TABLE `sub_menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NOT NULL,
  `ordinal_number` int NOT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updateBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_sub_menu_menu`(`menu_id` ASC) USING BTREE,
  CONSTRAINT `fk_sub_menu_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_menu
-- ----------------------------
INSERT INTO `sub_menu` VALUES (2, 2, 'Master User', '/icon', '/master-user', 1, 2, 'SYSTEM', '2025-02-08 11:23:19', 'SYSTEM', '2025-02-14 21:08:15');
INSERT INTO `sub_menu` VALUES (3, 2, 'Master Group User', '', '/master-grup-user', 1, 1, 'SYSTEM', '2025-02-08 11:23:45', 'SYSTEM', '2025-02-10 21:15:37');
INSERT INTO `sub_menu` VALUES (5, 2, 'Master Menu', '/', '/master-menu', 1, 3, 'SYSTEM', '2025-02-10 21:15:19', 'SYSTEM', '2025-02-14 21:08:21');
INSERT INTO `sub_menu` VALUES (10, 2, 'Master Kategori Buku', '/', '/master-kategori', 1, 4, 'SYSTEM', '2025-02-15 09:06:07', '', '2025-02-15 09:06:07');
INSERT INTO `sub_menu` VALUES (11, 2, 'Master Buku', '/', '/master-buku', 1, 5, 'SYSTEM', '2025-02-15 09:09:26', '', '2025-02-15 09:09:26');
INSERT INTO `sub_menu` VALUES (12, 11, 'Member', '/', '/member-perpus', 1, 1, 'SYSTEM', '2025-02-15 09:13:37', 'SYSTEM', '2025-02-15 09:15:00');
INSERT INTO `sub_menu` VALUES (13, 11, 'Peminjaman dan Pengembalian', '/', '/peminjaman-buku', 1, 2, 'SYSTEM', '2025-02-15 09:14:18', 'SYSTEM', '2025-02-16 12:18:32');

-- ----------------------------
-- Table structure for transaksi_peminjaman
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_peminjaman`;
CREATE TABLE `transaksi_peminjaman`  (
  `id_peminjaman` int NOT NULL AUTO_INCREMENT,
  `id_member` int NULL DEFAULT NULL,
  `tanggal_pinjam` date NULL DEFAULT NULL,
  `tanggal_pengembalian_seharusnya` date NOT NULL,
  `status` enum('dipinjam','dikembalikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'dipinjam',
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updateBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_peminjaman`) USING BTREE,
  INDEX `id_member`(`id_member` ASC) USING BTREE,
  CONSTRAINT `transaksi_peminjaman_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `member_perpus` (`id_member`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi_peminjaman
-- ----------------------------
INSERT INTO `transaksi_peminjaman` VALUES (11, 10, '2026-05-10', '2026-05-12', 'dikembalikan', 'admin', '2026-05-10 09:30:01', 'admin', '2026-05-10 11:10:51');
INSERT INTO `transaksi_peminjaman` VALUES (13, 5, '2026-05-10', '2026-05-16', 'dikembalikan', 'admin', '2026-05-10 10:25:16', 'admin', '2026-07-09 19:22:14');

-- ----------------------------
-- Table structure for user_access
-- ----------------------------
DROP TABLE IF EXISTS `user_access`;
CREATE TABLE `user_access`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_user_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `sub_menu_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_user_access_group_user`(`group_user_id` ASC) USING BTREE,
  INDEX `fk_user_access_menu`(`menu_id` ASC) USING BTREE,
  INDEX `fk_user_access_submenu`(`sub_menu_id` ASC) USING BTREE,
  CONSTRAINT `fk_user_access_group_user` FOREIGN KEY (`group_user_id`) REFERENCES `group_user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_user_access_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_user_access_submenu` FOREIGN KEY (`sub_menu_id`) REFERENCES `sub_menu` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 77 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_access
-- ----------------------------
INSERT INTO `user_access` VALUES (5, 1, 2, 3);
INSERT INTO `user_access` VALUES (42, 1, 2, 5);
INSERT INTO `user_access` VALUES (46, 1, 2, 2);
INSERT INTO `user_access` VALUES (50, 1, 2, 10);
INSERT INTO `user_access` VALUES (51, 1, 2, 11);
INSERT INTO `user_access` VALUES (65, 3, 2, 11);
INSERT INTO `user_access` VALUES (66, 3, 2, 10);
INSERT INTO `user_access` VALUES (69, 3, 2, 3);
INSERT INTO `user_access` VALUES (70, 3, 2, 5);
INSERT INTO `user_access` VALUES (71, 3, 2, 2);
INSERT INTO `user_access` VALUES (73, 4, 11, 13);
INSERT INTO `user_access` VALUES (74, 3, 11, 13);
INSERT INTO `user_access` VALUES (75, 3, 11, 12);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group_user_id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_number` int NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` int NOT NULL,
  `createdBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp,
  `updatedBy` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updatedAt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (8, 'c16b3784-7740-4874-88f5-3f8ca2e8ed1e', 1, 'Kiki Irfansyah', 222, '', 'kirfansyah', '2222', 1, 'SYSTEM', '2025-02-09 17:40:17', 'SYSTEM', '2025-02-16 11:16:27');
INSERT INTO `users` VALUES (9, '0e57fd42-32c5-4394-85ca-1939b03c733d', 3, 'Admin', 2, '', 'admin', 'admin', 1, 'SYSTEM', '2025-02-10 18:00:32', 'SYSTEM', '2025-02-15 19:20:27');
INSERT INTO `users` VALUES (10, 'dfd006ea-e899-4903-9ea2-527bf2370abf', 4, 'User', 124578, '', 'USER', 'USER1234', 1, 'SYSTEM', '2025-02-16 11:01:02', '', '0000-00-00 00:00:00');

-- ----------------------------
-- View structure for vwmstbuku
-- ----------------------------
DROP VIEW IF EXISTS `vwmstbuku`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vwmstbuku` AS SELECT
    A.*,
    B.nama_kategori,
    B.is_active as is_active_category
FROM
    master_buku A
    LEFT JOIN master_kategori B ON A.id_kategori = B.id_kategori 
WHERE
    A.is_active = 1 AND B.is_active = 1
ORDER BY
    A.id_buku DESC ;

-- ----------------------------
-- View structure for vwmstpeminjaman
-- ----------------------------
DROP VIEW IF EXISTS `vwmstpeminjaman`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vwmstpeminjaman` AS SELECT
    A.id_peminjaman,
    A.id_member,
    A.status,
    A.tanggal_pinjam,
    A.tanggal_pengembalian_seharusnya,
    A.createdBy,
    A.createdAt,
    A.updateBy,
    A.updateAt,
    B.nama_member,
    GROUP_CONCAT(
        CONCAT(D.id_detail, '|', C.id_buku, '|', C.judul_buku, '|', D.status, '|', IFNULL(D.tanggal_kembali, ''), '|', D.denda)
        ORDER BY C.id_buku SEPARATOR ';;'
    ) AS detail_buku,
    SUM(D.denda) AS total_denda,
		d.tanggal_kembali
FROM
    transaksi_peminjaman A
    LEFT JOIN member_perpus B ON A.id_member = B.id_member
    LEFT JOIN detail_peminjaman D ON A.id_peminjaman = D.id_peminjaman
    LEFT JOIN master_buku C ON D.id_buku = C.id_buku
GROUP BY
    A.id_peminjaman
ORDER BY
    A.id_peminjaman DESC ;

-- ----------------------------
-- View structure for vwmstsubmenu
-- ----------------------------
DROP VIEW IF EXISTS `vwmstsubmenu`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vwmstsubmenu` AS SELECT
	A.*,
	B.NAME AS menu_name 
FROM
	sub_menu A
	LEFT JOIN menu B ON a.menu_id = b.id ;

-- ----------------------------
-- View structure for vwmstuser
-- ----------------------------
DROP VIEW IF EXISTS `vwmstuser`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vwmstuser` AS SELECT a.*, b.name leveluser
FROM users a 
LEFT JOIN group_user b ON a.group_user_id = b.id 
WHERE a.is_active = 1 ;

SET FOREIGN_KEY_CHECKS = 1;
