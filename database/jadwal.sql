# Host: localhost  (Version 5.5.5-10.1.36-MariaDB)
# Date: 2019-06-29 13:34:42
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "admins"
#

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `nim_admin` char(10) NOT NULL DEFAULT '',
  `nama_admin` varchar(50) NOT NULL DEFAULT '',
  `password_admin` varchar(255) NOT NULL DEFAULT '',
  `telepon_admin` varchar(15) DEFAULT NULL,
  `email_admin` varchar(50) DEFAULT NULL,
  `jabatan_admin` varchar(25) DEFAULT NULL,
  `foto_admin` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nim_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "admins"
#

INSERT INTO `admins` VALUES ('12345','Test Adminitrator','$2y$10$sz7XiNeB0f5ogUbwwCeaper2ip8Ogvwhv2w8S4NObAXR9g80ThlYa','0812','admin@admin','Administrator','1547293859_You Are the Apple of My Eye.jpg','2018-12-03 13:34:00','2019-06-12 13:36:33'),('1234567890','Administrator','$2y$10$yiIdpHKErjauDwcQRpehhepH3QVbLyVeClQkcnTyh5mfnAB.lRJBO','121212','1.M@G.COM','TEST',NULL,'2019-06-12 13:19:08','2019-06-12 13:40:03');

#
# Structure for table "dosen"
#

DROP TABLE IF EXISTS `dosen`;
CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL AUTO_INCREMENT,
  `nip_dosen` varchar(10) NOT NULL DEFAULT '',
  `nama_dosen` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_dosen`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

#
# Data for table "dosen"
#

INSERT INTO `dosen` VALUES (1,'123','Test123'),(2,'1711501559','Mus'),(4,'123454321','Oke');

#
# Structure for table "lab"
#

DROP TABLE IF EXISTS `lab`;
CREATE TABLE `lab` (
  `id_lab` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lab` varchar(15) NOT NULL DEFAULT '',
  `kapasitas_lab` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_lab`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

#
# Data for table "lab"
#

INSERT INTO `lab` VALUES (44,'Lab. Kom 01',31),(45,'Lab. Kom 02',36),(46,'Lab. Kom 14',35),(48,'Lab. Kom 06',35),(51,'Lab. Kom 04',35),(52,'Lab. Kom 05',35),(53,'Lab. Kom 07',35),(54,'Lab. Kom 08',36),(55,'Lab. Kom 09',35),(56,'Lab. Kom 10',34),(57,'Lab. Kom 11',34),(58,'Lab. Kom 12',35);

#
# Structure for table "matakuliah"
#

DROP TABLE IF EXISTS `matakuliah`;
CREATE TABLE `matakuliah` (
  `id_mtk` int(11) NOT NULL AUTO_INCREMENT,
  `kd_mtk` varchar(6) NOT NULL DEFAULT '',
  `nama_mtk` varchar(50) NOT NULL DEFAULT '',
  `sks_mtk` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_mtk`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

#
# Data for table "matakuliah"
#

INSERT INTO `matakuliah` VALUES (2,'KP021','MTK',2),(4,'ALGO1','Algoritma & Struktur Data 1',3),(6,'ALGO2','Algoritma & Struktur Data 2',3),(10,'TEST12','Testing',3),(11,'AWBL01','Aplikasi Wawasan Budi Luhur',1),(14,'ALGO2','Algoritma & Struktur Data 2',3),(16,'1','1',1),(17,'TES123','Dipinjam',7);

#
# Structure for table "jadwal"
#

DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(5) NOT NULL DEFAULT '',
  `tahun_ajaran` varchar(10) NOT NULL DEFAULT '',
  `kelompok` char(2) DEFAULT NULL,
  `id_dosen` int(11) DEFAULT NULL,
  `id_mtk` int(11) DEFAULT NULL,
  `id_lab` varchar(11) DEFAULT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `jam_ajar` char(13) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_dosen` (`id_dosen`),
  KEY `id_mtk` (`id_mtk`),
  KEY `id_lab` (`id_lab`),
  CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`),
  CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_mtk`) REFERENCES `matakuliah` (`id_mtk`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

#
# Data for table "jadwal"
#

INSERT INTO `jadwal` VALUES (29,'Gasal','2019/2020','AB',4,17,'54','Senin','08:55 - 15:10',NULL,NULL),(31,'Gasal','2019/2020','AC',4,17,'45','Senin','10:40 - 17:00',NULL,NULL),(32,'Gasal','2019/2020','SS',2,17,'53','Senin','07:10 - 13:20',NULL,NULL),(33,'Gasal','2019/2020','AG',1,4,'44','Senin','08:00 - 10:35',NULL,NULL),(34,'Gasal','2019/2020','SS',1,14,'56','Senin','08:00 - 10:35',NULL,NULL),(35,'Gasal','2019/2020','HD',1,11,'56','Senin','07:10 - 07:55',NULL,NULL),(38,'Gasal','2019/2020','CC',1,17,'58','Minggu','07:10 - 13:20',NULL,NULL),(39,'Gasal','2019/2020','BB',2,16,'57','Minggu','08:00 - 08:50',NULL,NULL),(41,'Gasal','2019/2020','QQ',1,11,'44','Senin','10:40 - 11:30',NULL,NULL),(43,'Gasal','2019/2020','QW',1,2,'44','Senin','17:05 - 18:50',NULL,NULL),(48,'Gasal','2019/2020','PP',4,2,'51','Senin','07:10 - 08:50',NULL,NULL),(58,'Gasal','2019/2020','PP',1,11,'44','Senin','07:10 - 07:55',NULL,NULL),(59,'Gasal','2019/2020','1S',2,14,'51','Senin','08:55 - 11:30',NULL,NULL),(61,'Gasal','2019/2020','QW',2,4,'44','Senin','12:30 - 15:10','2019-06-27 06:30:57','2019-06-27 06:30:57');

#
# Structure for table "semester"
#

DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester` (
  `id_semester` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(6) DEFAULT NULL,
  `status_semester` char(1) DEFAULT '0',
  PRIMARY KEY (`id_semester`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "semester"
#

INSERT INTO `semester` VALUES (4,'Gasal','1'),(5,'Genap','0');

#
# Structure for table "software"
#

DROP TABLE IF EXISTS `software`;
CREATE TABLE `software` (
  `id_software` int(11) NOT NULL AUTO_INCREMENT,
  `nama_software` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id_software`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

#
# Data for table "software"
#

INSERT INTO `software` VALUES (1,'Android Studio'),(3,'SPSS'),(4,'Microsoft Office Word 2013'),(5,'Cicso Packet Tracer 7.2.1'),(6,'Microsoft Office Word 2010');

#
# Structure for table "spesifikasi"
#

DROP TABLE IF EXISTS `spesifikasi`;
CREATE TABLE `spesifikasi` (
  `id_spek` int(11) NOT NULL AUTO_INCREMENT,
  `id_lab` int(11) DEFAULT NULL,
  `id_software` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_spek`),
  KEY `id_lab` (`id_lab`),
  KEY `id_software` (`id_software`),
  CONSTRAINT `spesifikasi_ibfk_1` FOREIGN KEY (`id_lab`) REFERENCES `lab` (`id_lab`),
  CONSTRAINT `spesifikasi_ibfk_2` FOREIGN KEY (`id_software`) REFERENCES `software` (`id_software`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "spesifikasi"
#


#
# Structure for table "tahunajaran"
#

DROP TABLE IF EXISTS `tahunajaran`;
CREATE TABLE `tahunajaran` (
  `id_tahunajaran` int(11) NOT NULL AUTO_INCREMENT,
  `tahunajaran` char(9) DEFAULT NULL,
  `status_tahunajaran` char(1) DEFAULT '0',
  PRIMARY KEY (`id_tahunajaran`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Data for table "tahunajaran"
#

INSERT INTO `tahunajaran` VALUES (1,'2019/2020','1'),(3,'2018/2019','0'),(4,'2020/2021','0');
