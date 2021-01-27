# Host: localhost  (Version 5.5.5-10.4.11-MariaDB)
# Date: 2021-01-27 20:19:17
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "jadwal"
#

DROP TABLE IF EXISTS `jadwal`;
CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(6) NOT NULL DEFAULT '',
  `jam_ajar` char(13) DEFAULT NULL,
  `tahunajaran` char(9) NOT NULL DEFAULT '',
  `kelompok` char(2) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_mtk` int(11) DEFAULT NULL,
  `id_lab` int(11) DEFAULT NULL,
  `hari` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `jadwal_ibfk_1` (`id_mtk`),
  KEY `jadwal_ibfk_3` (`id_user`),
  CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_mtk`) REFERENCES `jadwal`.`matakuliah` (`id_mtk`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "jadwal"
#

INSERT INTO `jadwal` VALUES (75,'Gasal','08:00 - 10:35','2019/2020','AE',19,24,1,'Senin'),(76,'Gasal','10:40 - 13:20','2019/2020','AD',42,24,3,'Senin'),(77,'Gasal','10:40 - 13:20','2019/2020','AA',32,24,6,'Senin'),(78,'Gasal','10:40 - 12:25','2019/2020','AA',5,25,11,'Senin'),(80,'Gasal','13:25 - 15:10','2019/2020','AB',16,20,5,'Senin'),(81,'Gasal','13:25 - 16:05','2019/2020','AA',25,26,8,'Senin'),(82,'Gasal','13:25 - 15:10','2019/2020','AB',30,23,9,'Senin'),(83,'Gasal','13:25 - 16:05','2019/2020','AB',5,31,11,'Senin'),(85,'Gasal','08:00 - 10:35','2019/2020','XA',46,33,3,'Senin'),(86,'Gasal','10:40 - 13:20','2019/2020','XA',46,33,8,'Senin'),(87,'Gasal','13:25 - 15:10','2019/2020','CD',54,37,4,'Senin'),(88,'Gasal','08:00 - 10:35','2019/2020','AA',57,32,1,'Selasa'),(89,'Gasal','08:00 - 10:35','2019/2020','AC',21,30,2,'Selasa'),(90,'Gasal','08:00 - 10:35','2019/2020','AC',17,31,3,'Selasa'),(91,'Gasal','08:00 - 09:40','2019/2020','CB',52,37,5,'Selasa'),(92,'Gasal','08:00 - 09:40','2019/2020','CB',47,34,4,'Selasa'),(93,'Gasal','08:00 - 10:35','2019/2020','TI',39,30,6,'Selasa'),(94,'Gasal','08:00 - 10:35','2019/2020','AU',49,36,7,'Selasa'),(96,'Gasal','10:40 - 13:20','2019/2020','AA',36,30,1,'Selasa'),(97,'Gasal','10:40 - 13:20','2019/2020','TI',32,24,2,'Selasa'),(98,'Gasal','10:40 - 13:20','2019/2020','AH',33,30,3,'Selasa'),(99,'Gasal','10:40 - 13:20','2019/2020','AU',51,35,4,'Selasa'),(100,'Gasal','10:40 - 13:20','2019/2020','AA',40,21,6,'Selasa'),(101,'Gasal','10:40 - 13:20','2019/2020','AF',45,30,8,'Selasa'),(102,'Gasal','10:40 - 13:20','2019/2020','AG',42,24,9,'Selasa'),(103,'Gasal','10:40 - 12:25','2019/2020','AB',5,25,11,'Selasa'),(104,'Gasal','13:25 - 16:05','2019/2020','AF',18,24,1,'Selasa'),(105,'Gasal','13:25 - 16:05','2019/2020','AB',5,21,11,'Selasa'),(108,'Gasal','08:00 - 10:35','2019/2020','AD',57,32,1,'Rabu'),(109,'Gasal','08:00 - 09:40','2019/2020','CC',53,34,4,'Rabu'),(110,'Gasal','08:00 - 10:35','2019/2020','AC',35,24,5,'Rabu'),(111,'Gasal','08:00 - 10:35','2019/2020','DA',48,35,7,'Rabu'),(112,'Gasal','08:00 - 10:35','2019/2020','AC',25,26,8,'Rabu'),(113,'Gasal','08:00 - 10:35','2019/2020','AD',14,31,9,'Rabu'),(114,'Gasal','10:40 - 13:20','2019/2020','AI',36,30,1,'Rabu'),(115,'Gasal','10:40 - 12:25','2019/2020','CE',53,37,4,'Rabu'),(116,'Gasal','10:40 - 13:20','2019/2020','AB',38,30,8,'Rabu'),(117,'Gasal','10:40 - 13:20','2019/2020','AJ',45,30,9,'Rabu'),(119,'Gasal','13:25 - 16:05','2019/2020','AB',57,27,1,'Rabu'),(120,'Gasal','13:25 - 15:10','2019/2020','AA',16,20,2,'Rabu'),(122,'Gasal','08:00 - 09:40','2019/2020','CA',52,37,4,'Kamis'),(123,'Gasal','08:00 - 10:35','2019/2020','AJ',43,24,6,'Kamis'),(124,'Gasal','08:00 - 10:35','2019/2020','EA',55,36,7,'Kamis'),(125,'Gasal','08:00 - 10:35','2019/2020','AL',32,24,11,'Kamis'),(126,'Gasal','10:40 - 13:20','2019/2020','KU',39,32,1,'Kamis'),(127,'Gasal','10:40 - 13:20','2019/2020','AI',42,24,3,'Kamis'),(128,'Gasal','10:40 - 12:25','2019/2020','CD',50,34,4,'Kamis'),(129,'Gasal','10:40 - 13:20','2019/2020','AA',26,27,5,'Kamis'),(130,'Gasal','10:40 - 13:20','2019/2020','AM',45,30,9,'Kamis'),(132,'Gasal','13:25 - 16:05','2019/2020','AD',33,30,1,'Kamis'),(133,'Gasal','13:25 - 15:10','2019/2020','AF',31,20,2,'Kamis'),(134,'Gasal','13:25 - 16:05','2019/2020','AB',25,26,8,'Kamis'),(135,'Gasal','13:25 - 15:10','2019/2020','AA',29,22,9,'Kamis'),(136,'Gasal','16:10 - 17:55','2019/2020','AD',31,20,5,'Kamis'),(137,'Gasal','16:10 - 17:55','2019/2020','CC',54,37,7,'Kamis'),(138,'Gasal','08:00 - 09:40','2019/2020','AU',51,34,4,'Jumat'),(139,'Gasal','08:00 - 10:35','2019/2020','AK',43,24,6,'Jumat'),(140,'Gasal','08:00 - 09:40','2019/2020','CA',49,34,7,'Jumat'),(141,'Gasal','08:00 - 09:40','2019/2020','AC',44,23,8,'Jumat'),(142,'Gasal','13:25 - 16:05','2019/2020','AB',34,31,2,'Jumat'),(143,'Gasal','13:25 - 16:05','2019/2020','AL',23,30,3,'Jumat'),(144,'Gasal','13:25 - 16:05','2019/2020','AB',43,24,6,'Jumat'),(145,'Gasal','13:25 - 15:10','2019/2020','AA',5,25,11,'Jumat'),(146,'Gasal','08:55 - 10:35','2019/2020','ZX',15,22,2,'Senin'),(147,'Gasal','07:10 - 09:40','2019/2020','ZX',46,33,4,'Senin'),(149,'Gasal','08:55 - 10:35','2019/2020','ZX',16,22,6,'Senin'),(150,'Gasal','08:55 - 11:30','2019/2020','ZX',37,36,5,'Senin'),(151,'Gasal','10:40 - 12:25','2019/2020','ZZ',46,20,1,'Senin'),(152,'Gasal','0','2019/2020','AS',14,36,1,'Rabu'),(154,'Gasal','12:30 - 14:15','2019/2020','AC',16,20,0,'Rabu'),(157,'Gasal','07:10 - 08:50','2019/2020','AC',15,20,0,'Senin'),(160,'Genap','07:10 - 08:50','2019/2020','AC',14,20,0,'Senin'),(161,'Genap','16:10 - 17:55','2019/2020','AS',15,20,0,'Senin'),(162,'Gasal','14:20 - 17:00','2019/2020','AW',14,21,3,'Selasa'),(163,'Gasal','17:05 - 18:50','2019/2020','AW',10,22,5,'Selasa'),(164,'Gasal','15:15 - 17:00','2019/2020','AC',15,25,11,'Rabu'),(165,'Gasal','16:10 - 17:55','2019/2020','QS',46,23,9,'Rabu'),(166,'Gasal','16:10 - 18:50','2019/2020','AC',17,32,1,'Rabu'),(167,'Gasal','16:10 - 18:50','2019/2020','SD',9,31,2,'Rabu'),(168,'Gasal','16:10 - 18:50','2019/2020','QS',6,35,3,'Rabu'),(169,'Gasal','12:30 - 15:10','2019/2020','QS',45,24,0,'Jumat'),(170,'Gasal','09:45 - 12:25','2019/2020','AW',45,21,1,'Sabtu'),(171,'Gasal','15:15 - 17:55','2019/2020','SD',16,27,3,'Sabtu'),(172,'Gasal','16:10 - 17:55','2019/2020','SD',15,20,10,'Sabtu'),(174,'Gasal','08:00 - 10:35','2020/2021','AH',25,32,0,'Senin'),(175,'Gasal','10:40 - 13:20','2020/2021','AE',36,30,2,'Senin'),(176,'Gasal','08:00 - 10:35','2020/2021','AE',18,24,6,'Senin'),(177,'Gasal','10:40 - 12:25','2020/2021','AA',32,25,11,'Senin'),(178,'Gasal','16:10 - 18:50','2020/2021','AB',43,30,10,'Senin'),(179,'Gasal','10:40 - 12:25','2020/2021','AW',15,20,2,'Selasa'),(180,'Gasal','14:20 - 16:05','2020/2021','SD',27,22,8,'Selasa'),(181,'Gasal','15:15 - 17:55','2020/2021','AU',44,21,6,'Selasa'),(182,'Gasal','08:00 - 09:40','2020/2021','MJ',50,34,7,'Selasa'),(183,'Gasal','11:35 - 13:20','2020/2021','E1',38,23,8,'Selasa'),(184,'Gasal','08:00 - 10:35','2020/2021','AD',55,32,9,'Rabu'),(185,'Gasal','08:00 - 10:35','2020/2021','AC',33,24,5,'Rabu'),(186,'Gasal','13:25 - 15:10','2020/2021','AA',15,20,2,'Rabu'),(187,'Gasal','17:05 - 18:50','2020/2021','MA',47,34,7,'Rabu'),(188,'Gasal','13:25 - 16:05','2020/2021','AG',36,30,0,'Rabu'),(189,'Gasal','08:00 - 09:40','2020/2021','CA',50,37,4,'Kamis'),(190,'Gasal','10:40 - 13:20','2020/2021','KU',37,32,9,'Kamis'),(191,'Gasal','10:40 - 13:20','2020/2021','FD',17,26,8,'Kamis'),(192,'Gasal','08:55 - 11:30','2020/2021','AE',21,26,8,'Jumat');

#
# Structure for table "kuliahpengganti"
#

DROP TABLE IF EXISTS `kuliahpengganti`;
CREATE TABLE `kuliahpengganti` (
  `id_kp` int(11) NOT NULL AUTO_INCREMENT,
  `jam_pengganti` char(13) DEFAULT NULL,
  `tanggal_pengganti` date DEFAULT NULL,
  `id_lab` int(11) DEFAULT NULL,
  `id_jadwal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kp`),
  KEY `kuliahpengganti_ibfk_1` (`id_jadwal`),
  KEY `kuliahpengganti_ibfk_2` (`id_lab`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "kuliahpengganti"
#

INSERT INTO `kuliahpengganti` VALUES (119,'07:10 - 07:55','2021-01-31',NULL,188),(120,'07:10 - 07:55','2021-01-31',0,177),(121,'07:10 - 07:55','2021-01-31',1,175);

#
# Structure for table "lab"
#

DROP TABLE IF EXISTS `lab`;
CREATE TABLE `lab` (
  `id_lab` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lab` varchar(15) NOT NULL DEFAULT '',
  `kapasitas_lab` int(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_lab`)
) ENGINE=InnoDB AUTO_INCREMENT=123456793 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "lab"
#

INSERT INTO `lab` VALUES (0,'Lab. Kom 01',34),(1,'Lab. Kom 02',34),(2,'Lab. Kom 04',34),(3,'Lab. Kom 05',34),(4,'Lab. Kom 06',34),(5,'Lab. Kom 07',35),(6,'Lab. Kom 08',34),(7,'Lab. Kom 09',34),(8,'Lab. Kom 10',34),(9,'Lab. Kom 11',40),(10,'Lab. Kom 12',34),(11,'Lab. Kom 14',34);

#
# Structure for table "matakuliah"
#

DROP TABLE IF EXISTS `matakuliah`;
CREATE TABLE `matakuliah` (
  `id_mtk` int(11) NOT NULL AUTO_INCREMENT,
  `kd_mtk` varchar(6) NOT NULL DEFAULT '',
  `nama_mtk` varchar(50) NOT NULL DEFAULT '',
  `sks_mtk` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_mtk`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "matakuliah"
#

INSERT INTO `matakuliah` VALUES (20,'KP378','Bahasa Query Terstruktur',2),(21,'KM160','Desain Grafis',3),(22,'KP369','Implementasi Jaringan Komputer 1',2),(23,'KP370','Implementasi Jaringan Komputer 2',2),(24,'PG173','Implementasi Pemrograman Berorientasi Objek',3),(25,'PG130','Java Web Programming',2),(26,'KP314','Linux Administration',3),(27,'PG061','Pemrograman Berorientasi Obyek',3),(28,'PG174','Pemrograman Java Enterprise',3),(29,'PG065','Pemrograman Web 1',3),(30,'PG066','Pemrograman Web 2',3),(31,'KP212','Rekayasa Web',3),(32,'PG119','Mobile Programming',3),(33,'KP188','Dasar Komputer Arsitektur',3),(34,'AK125','Praktik Pengolahan Data Penelitian Akuntansi',2),(35,'AK138','Praktik Pengolahan Data Penelitian Akuntansi',3),(36,'AK137','Aplikasi Excel untuk Bisnis dan Akuntansi',3),(37,'MM117','Praktik Pengolahan Data Penelitian Manajemen',2),(38,'MM215','Praktik Pengolahan Data Penelitian Manajemen',3);

#
# Structure for table "pinjamlab"
#

DROP TABLE IF EXISTS `pinjamlab`;
CREATE TABLE `pinjamlab` (
  `id_pinjam` int(11) NOT NULL AUTO_INCREMENT,
  `jam_pinjam` char(13) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `nama_pinjam` varchar(50) DEFAULT NULL,
  `judul_pinjam` varchar(75) DEFAULT NULL,
  `keterangan_pinjam` text DEFAULT NULL,
  `email_pinjam` varchar(50) DEFAULT NULL,
  `id_lab` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nohp` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_pinjam`),
  KEY `id_lab` (`id_lab`),
  CONSTRAINT `pinjamlab_ibfk_1` FOREIGN KEY (`id_lab`) REFERENCES `jadwal`.`lab` (`id_lab`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "pinjamlab"
#


#
# Structure for table "semester"
#

DROP TABLE IF EXISTS `semester`;
CREATE TABLE `semester` (
  `id_semester` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(6) DEFAULT NULL,
  `status_semester` char(1) DEFAULT '0',
  PRIMARY KEY (`id_semester`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

#
# Data for table "semester"
#

INSERT INTO `semester` VALUES (4,'Gasal','1'),(5,'Genap','0'),(6,'Antara','0');

#
# Structure for table "tahunajaran"
#

DROP TABLE IF EXISTS `tahunajaran`;
CREATE TABLE `tahunajaran` (
  `id_tahunajaran` int(11) NOT NULL AUTO_INCREMENT,
  `tahunajaran` char(9) DEFAULT NULL,
  `status_tahunajaran` char(1) DEFAULT '0',
  PRIMARY KEY (`id_tahunajaran`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

#
# Data for table "tahunajaran"
#

INSERT INTO `tahunajaran` VALUES (1,'2019/2020','0'),(4,'2020/2021','1');

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `nim` char(20) DEFAULT '',
  `nama` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) DEFAULT '',
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `jabatan` enum('SPV','Dosen','Asisten') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;

#
# Data for table "users"
#

INSERT INTO `users` VALUES ('1711500312','Gabriel Yoda Gustiegan','$2y$10$l/UgH3Fh/1Jgx1HwVeZCEeJuTX/HUtnmZDB24vbUwSJJ06NnyWiAG','089615506609','yodaegan@gmail.com','SPV','2020-11-19 04:04:24','2021-01-07 11:43:23',2),('','Anita Diana','$2y$10$2WENErUKuNElixwxsNzG9.INUEFNCB/EUiilWPbVD/m','089','anita@gmail.com','Dosen',NULL,'2021-01-04 15:22:11',6),('','Teja Endra Eng Tju','$2y$10$p8RokbRpzZFfr0YfZkYmiOS27c3Lv7EgL2FNYm/T0kE6OLqqz.K72','089','teja@gmail.com','Dosen',NULL,'2021-01-12 13:09:51',7),('','Wiwin Windihastuty','$2y$10$zThBvDyrEUJV6Lb07//AWer0xPWvAysdXGu0ZIf/GVm','089','wiwin@gmail.com','Dosen',NULL,'2021-01-04 15:22:27',8),('','Grace Gata','$2y$10$jDeEgINxr2yaAcbaAszl0.tNs7kY66StNAVzlmU2CGg','089','grace@gmail.com','Dosen',NULL,'2021-01-04 15:22:34',9),('','Achmad Syarif','$2y$10$P5EieBqXyoFWihzroGjYt.F58.buq/nCfz.MflVwBTv','089','achmad@gmail.com','Dosen',NULL,'2021-01-04 15:22:56',10),('','Tri Ika Jaya Kusumawati','$2y$10$2gzEZLuiKDZ1P4CEjhoib.2vJECrFdzf8DhisuLQR6i','089','tri@gmail.com','Dosen',NULL,'2021-01-04 15:23:03',11),('','Samsinar','$2y$10$RWH.At4J0yaSnYr8N/dPo.iUShAorW/MwnxYEqrSXr7','089','samsinar@gmail.com','Dosen',NULL,'2021-01-04 15:23:19',12),('','Achmad Aditya Ashadul Ushud','$2y$10$MF2LdN0PF5CMdjUGkmMwqO.nITIKxTm2H9j4FyeZ41r','089','achmadadit@gmail.com','Dosen',NULL,'2021-01-04 15:23:26',13),('','Agnes Aryasanti','$2y$10$UlpE.eIqN9LKVabukKYuXe8pJRpUPPFyllNRFTELIM3','089','agnes@gmail.com','Dosen',NULL,'2021-01-04 15:23:40',14),('','Agus Umar Hamdani','$2y$10$C3lmEE5.CSBpSixOKBpq2ODOhG6hxfCwyxtiujWL4pRvptlE8n93e','089','agus@gmail.com','Dosen',NULL,'2021-01-27 08:51:08',15),('','Atik Ariesta','$2y$10$jonCvYabW6NL.3L4NVVsDeSW4klnXb/1yHFEDDUMhoD','089','atik@gmail.com','Dosen',NULL,'2021-01-04 15:24:07',16),('','Basuki Hari Prasetyo','$2y$10$7dn7M0wrUfmf2YyjuvsBg.zFzThmSAbVQq7h1Xw1L.v','089','basuki@gmail.com','Dosen',NULL,'2021-01-04 15:24:15',17),('','Dani Anggoro','$2y$10$2W2y4xGKsTuzNZIeMMRd0OpAFQi82FzZ8Xr5b2z/0F3','089','dani@gmail.com','Dosen',NULL,'2021-01-04 15:24:24',18),('','Dolly Virgian Shaka Yudha Sakti','$2y$10$uxkXEBG9ehwAZsk15TKuMeVjiO5Cvu31xZqh6IUpMLq','089','dolly@gmail.com','Dosen',NULL,'2021-01-04 15:24:38',19),('','Dyah Retno Utari','$2y$10$EyikWgQLLA62N/EQu7ibdu1DcnuIEzuywWlqG6ZhFpW','089','dyah@gmail.com','Dosen',NULL,'2021-01-04 15:24:48',20),('','Gunawan Pria Utama','$2y$10$v8TzCeDQwIoa7NYkhrpGKes9I.8NsYcOFTpLCuhEdsZ','089','gunawan@gmail.com','Dosen',NULL,'2021-01-04 15:24:55',21),('','Hadidtyo Wisnu Wardani','$2y$10$PVVUGmja4TL6X9HE/uh49u1tnjS5RGCfMHcGq1neMTs','089','hadityo@gmail.com','Dosen',NULL,'2021-01-04 15:25:13',22),('','Humisar Hasugian','$2y$10$93BV7Y4wK7gInFQDd1iWOumdbDjkXxh0dKjPtEEaRUe','089','humisar@gmail,com','Dosen',NULL,'2021-01-04 15:25:26',23),('','Iman Permana','$2y$10$dl2atlYgVU2N1qJGN2/VReNdX0Fl0VwafJJDLP8WxdU','089','iman@gmail.com','Dosen',NULL,'2021-01-04 15:25:36',24),('','Indah Puspasari Handayani','$2y$10$54hRhgeTBc/bPzlrBPiNPOCv.xGhDXDfgZ0kRTkseSf','089','indah@gmail.com','Dosen',NULL,'2021-01-04 15:25:50',25),('','Jan Everhard Riwurohi','$2y$10$hPj9D.IWiRSYpBxXvrlYXeol9wltTfEAWAa6J2VrSyo','089','jan@gmail.com','Dosen',NULL,'2021-01-04 15:26:17',26),('','Joko Christian Chandra','$2y$10$m4yYFgnb2SGvmUVUYbDIPeogJ4JgKpO.f.2zoGz/PLX','089','joko@gmail.com','Dosen',NULL,'2021-01-04 15:26:26',27),('','Kukuh Harsanto','$2y$10$dIEu1nK8TFvXTIkBl9MmiuNJi6N7hbZFAwBX7jgzOX7','089','kukuh@gmail.com','Dosen',NULL,'2021-01-04 15:26:36',28),('','Lusi Fajarita','$2y$10$b6XRkTdwEbRTJ4tGtHF1UeRBGSd6qQvJZrt.2mEMARP','089','lusi@gmail.com','Dosen',NULL,'2021-01-04 15:26:45',29),('','M. Anif','$2y$10$zAHCl5yYg34oUljflKEOWOVFweuJBI1oe2hbI.b6rh0','089','anif@gmail.com','Dosen',NULL,'2021-01-04 15:26:55',30),('','Marini','$2y$10$YPXopvQD0MaDLaIIUHvCNOuu2/wjmUSY7SSLCGQpmCc','089','marini@gmail.com','Dosen',NULL,'2021-01-04 15:27:20',31),('','Mepa Kurniasih','$2y$10$MbmTadX41xsWdcXv537r8ublounz9k5/1wmz1qvBTQD','089','mepa@gmail.com','Dosen',NULL,'2021-01-04 15:27:33',32),('','Nofiyani','$2y$10$uTnUQRrj8JMhBPzIVIYB/u9hagcVV5Fy4ezUm9pmU4a','089','nofi@gmail.com','Dosen',NULL,'2021-01-04 15:27:51',33),('','Pipin Farida Ariyani','$2y$10$EhDyUHR1KqaBHmngWkNAOe8En6WpQraWB.OBGLPApLf','089','pipin@gmail.com','Dosen',NULL,'2021-01-04 15:28:11',34),('','Sejati Waluyo','$2y$10$R.r0RzovwYAw9.Vy3x2iJO8DUL1H4yc790kMJtR5F4s','089','sejati@gmail.com','Dosen',NULL,'2021-01-04 15:28:19',35),('','Titin Fatimah','$2y$10$pdMe7V1Vjq9yOW07vlnaQePd4bvxHLXF4AD4mF1v0Ey','089','titin@gmail.com','Dosen',NULL,'2021-01-04 15:28:28',36),('','Utomo Budiyanto','$2y$10$36My1z5y5/s6NGkqJFNbg.S2nnwe.80Zk3zdvm/T80K','089','utomo@gmail.com','Dosen',NULL,'2021-01-04 15:28:37',37),('','Windarto','$2y$10$S7SVBLHZcyxMV.R8ccxuGOB18tIwMhpD1rdM//9jsIb','089','widarto@gmail.com','Dosen',NULL,'2021-01-04 15:28:45',38),('','Wulandari','$2y$10$NNKkYsyzZP7voLijJXzoVOFyO8s57kMdBun4XZ8Fubm','089','wulan@gmail.com','Dosen',NULL,'2021-01-04 15:28:53',39),('','Yesi Puspita Dew','$2y$10$829qWWAwrCHvBbVoUu3R9.3Ii7YuTa6FDvA/m7bi5vi','089','yesi@gmail.com','Dosen',NULL,'2021-01-04 15:31:17',40),('','Yudi Santoso','$2y$10$tou15Ip.K.TiR4ph46oUfO/hvi1pGyDCpEw4X6tlcaO','089','yudisantoso@gmail.com','Dosen',NULL,'2021-01-04 15:31:27',41),('','Yudi Wiharto','$2y$10$G3dT8G.jzFGNtNeDowg7kOomQ8m3mwMcSgnfJc5RLin','089','yudiwiharto@gmail.com','Dosen',NULL,'2021-01-04 15:31:44',42),('','Yuliazmi','$2y$10$5csCEwjgs9yJ7o6smoMTDOBvBZJ6gx8TP97/FRGyLd5','089','yuliazmi@gmail.com','Dosen',NULL,'2021-01-04 15:32:00',43),('','Inggit Musdinar Sayekti Sihing','$2y$10$yTmgNn9fOf1mA/E.lAqgZ.TMtIcb6yLV78WrvqOUdfa','089','inggit@gmail.com','Dosen',NULL,'2021-01-04 15:32:10',44),('','Amir Indrabudiman','$2y$10$sLL3M3LkkW/4UJPU2EwEj.1bIImUOWNYH4z12p3YO6p','089','amir@gmail.com','Dosen',NULL,'2021-01-04 15:32:22',45),('','Anissa Amalia Mulya','$2y$10$nStRk7EnyWpCFbWhdGzD8u2Z45zh.Tm9EuGWInpAHXI','089','anissa@gmail.com','Dosen',NULL,'2021-01-04 15:32:40',46),('','Desy Anggraeni','$2y$10$ByiJ2xlLKdheccdMsJ5rpuifVr.XvFTLUfGdqpQEEpc','089','desy@gmail.com','Dosen',NULL,'2021-01-04 15:32:49',47),('','Nora Hilmia Primasari','$2y$10$sqacSFO87fn4Y3wfwqoNiu9FEpqtKdZUWXel/vjtJAg','089','nora@gmail.com','Dosen',NULL,'2021-01-04 15:33:00',48),('','Puspita Rani','$2y$10$NJAD5xIRii9HN8xbeg/FLOUzqk95MPp91D4aFHBU3js','089','puspita@gmail.com','Dosen',NULL,'2021-01-04 15:33:10',49),('','Retno Fuji Oktaviani','$2y$10$soRTsgR9oF5KSgxxQ5PQb.b/4jGEavoPlkXIELMhew2','089','retno@gmail.com','Dosen',NULL,'2021-01-04 15:33:19',50),('','Rinny Meidiyustiani','$2y$10$Is7aaFow9AJQvQ4xreJg0ONWpnRWPg.iHvH9RY9FAx7','089','rinny@gmail.com','Dosen',NULL,'2021-01-04 15:33:27',51),('','Sugeng Priyanto','$2y$10$D07qFINVz6lPeki1Ssp2SOzFT.gd7u4tgMhMLIFTzd9','089','sugeng@gmail.com','Dosen',NULL,'2021-01-04 15:33:35',52),('','Tio Prasetio','$2y$10$SKPpUs9YoDglMYzzLaETJOkTvTE3RUR8AIM6p4lNIi3','089','tio@gmail.com','Dosen',NULL,'2021-01-04 15:33:43',53),('','Triana Anggraini','$2y$10$9ihIPagQ5YI/rhr4S/lzD..oAIlAQNcGxSYo8HIq.dy','089','triana@gmail.com','Dosen',NULL,'2021-01-04 15:33:53',54),('','Putri Hayati','$2y$10$Z.fztRujOKuquDlmqlhjM.vWoKvdyWWXu89Uqo.vNNJ','089','putri@gmail.com','Dosen',NULL,'2021-01-04 15:34:01',55),('','Painem','$2y$10$9gCR.0aMdmvhto3LQYVhPu3Q0zrowgl6cX/wn1UwKN8','089','painen@gmail.com','Dosen',NULL,'2021-01-04 15:34:09',56),('1711501559','Mus Priandi','$2y$10$cHxAJfrkmyw6B7O9MXbAIexFVJCWw.YA4DGVEupFmoQGvoDtTtpbu','089','yodantis@yahoo.com','SPV','2020-12-18 10:27:49','2021-01-07 12:05:40',65),('123','bambang','$2y$10$9H.5Ri7z6ckO8UAzZ9J9q.dWgsoPjyqAIKw49uVi1NgJldymmi2B.','123','123@gmail.com','Asisten','2020-12-22 00:55:13','2021-01-27 08:19:18',66);
