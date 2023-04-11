/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 8.0.30 : Database - absensi_bjl
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`absensi_bjl` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `absensi_bjl`;

/*Table structure for table `absensi_karyawan` */

DROP TABLE IF EXISTS `absensi_karyawan`;

CREATE TABLE `absensi_karyawan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT '00:00:00',
  `foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `flag_scan` int DEFAULT '0' COMMENT '1: checkin, 2: checkout',
  `status_absen` int DEFAULT '1' COMMENT '1: ontime, 2: telat',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `absensi_karyawan` */

insert  into `absensi_karyawan`(`id`,`nip`,`tanggal`,`jam`,`foto`,`flag_scan`,`status_absen`,`status`) values 
(1,'03.0001.0323','2023-04-03','07:55:00',NULL,1,1,1),
(2,'03.0001.0323','2023-04-03','17:55:00',NULL,2,1,1),
(3,'03.0001.0323','2023-04-04','07:55:00',NULL,1,1,1),
(4,'03.0001.0323','2023-04-04','17:55:00',NULL,2,1,1),
(5,'03.0001.0323','2023-04-05','07:55:00',NULL,1,1,1),
(6,'03.0001.0323','2023-04-05','17:55:00',NULL,2,1,1),
(7,'03.0001.0323','2023-04-06','07:55:00',NULL,1,1,1),
(8,'03.0001.0323','2023-04-06','17:55:00',NULL,2,1,1),
(9,'03.0001.0323','2023-04-07','07:55:00',NULL,1,1,1),
(10,'03.0001.0323','2023-04-07','17:55:00',NULL,2,1,1),
(11,'03.0001.0323','2023-04-08','08:02:00',NULL,1,2,1),
(12,'03.0001.0323','2023-04-08','17:02:00',NULL,2,1,1),
(13,'03.0001.0323','2023-04-09','17:02:00',NULL,2,1,1),
(14,'03.0001.0323','2023-04-10','07:54:00',NULL,1,1,1),
(15,'03.0001.0323','2023-04-11','07:54:00',NULL,1,1,1),
(16,'03.0001.0323','2023-04-08','08:02:00',NULL,1,2,1),
(17,'03.0001.0323','2023-04-12','08:02:00',NULL,1,2,1),
(18,'03.0001.0323','2023-04-09','17:03:00',NULL,2,1,1),
(19,'03.0001.0323','2023-04-03','08:55:00',NULL,1,2,1),
(20,'03.0001.0323','2023-04-08','13:52:00','',2,1,9),
(21,'03.0001.0323','2023-04-08','13:52:00','1680936285_y3h4w.jpg',2,1,9);

/*Table structure for table `cuti_karyawan` */

DROP TABLE IF EXISTS `cuti_karyawan`;

CREATE TABLE `cuti_karyawan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) COLLATE utf8mb4_general_ci DEFAULT '',
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status_cuti` int DEFAULT '1' COMMENT '1: Pengajuan, 2: Approve, 3: Tolak, 4: Batal',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cuti_karyawan` */

insert  into `cuti_karyawan`(`id`,`nip`,`tgl_mulai`,`tgl_selesai`,`keterangan`,`status_cuti`,`status`) values 
(1,'03.0001.0323','2023-04-03','2023-04-03','Menggunakan jatah cuti',1,1);

/*Table structure for table `ijin_karyawan` */

DROP TABLE IF EXISTS `ijin_karyawan`;

CREATE TABLE `ijin_karyawan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) COLLATE utf8mb4_general_ci DEFAULT '',
  `jenis_ijin` int DEFAULT '0' COMMENT '1: Pulang Awal\r\n2: Keluar Kantor',
  `tanggal` date DEFAULT NULL,
  `jam` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status_ijin` int DEFAULT '1' COMMENT '1: Pengajuan, 2: Approve, 3: Tolak, 4: Batal',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ijin_karyawan` */

insert  into `ijin_karyawan`(`id`,`nip`,`jenis_ijin`,`tanggal`,`jam`,`keterangan`,`status_ijin`,`status`) values 
(1,'03.0001.0323',1,'2023-04-07','13:00','Udah Males Kerja hari ini',1,1);

/*Table structure for table `ms_agama` */

DROP TABLE IF EXISTS `ms_agama`;

CREATE TABLE `ms_agama` (
  `id` int NOT NULL AUTO_INCREMENT,
  `agama` varchar(25) COLLATE utf8mb4_general_ci DEFAULT '',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ms_agama` */

insert  into `ms_agama`(`id`,`agama`,`status`) values 
(1,'Islam',1),
(2,'Kristen',1),
(3,'Katholik',1),
(4,'Hindu',1),
(5,'Budha',1),
(6,'Lain - Lain',1);

/*Table structure for table `ms_divisi` */

DROP TABLE IF EXISTS `ms_divisi`;

CREATE TABLE `ms_divisi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `divisi` varchar(25) COLLATE utf8mb4_general_ci DEFAULT '',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ms_divisi` */

insert  into `ms_divisi`(`id`,`divisi`,`status`) values 
(1,'Sales & Marketing',1),
(2,'Aplikasi',1),
(3,'HRD, Legal & GA',1),
(4,'Accounting & Finance',1),
(5,'Operasional',1);

/*Table structure for table `ms_jabatan` */

DROP TABLE IF EXISTS `ms_jabatan`;

CREATE TABLE `ms_jabatan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(20) COLLATE utf8mb4_general_ci DEFAULT '',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ms_jabatan` */

insert  into `ms_jabatan`(`id`,`jabatan`,`status`) values 
(1,'Staff',1),
(2,'Secretary',1),
(3,'Technician',1),
(4,'Driver',1),
(5,'Management',1),
(6,'Programmer',1),
(7,'Direksi',1);

/*Table structure for table `ms_karyawan` */

DROP TABLE IF EXISTS `ms_karyawan`;

CREATE TABLE `ms_karyawan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `nama` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `jenis_kelamin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `password` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `foto_profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `nik` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `tgl_lahir` date DEFAULT NULL,
  `id_agama` int DEFAULT '0',
  `id_divisi` int DEFAULT '0',
  `id_jabatan` int DEFAULT '0',
  `status_kawin` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `status` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ms_karyawan` */

insert  into `ms_karyawan`(`id`,`nip`,`nama`,`alamat`,`jenis_kelamin`,`email`,`username`,`password`,`foto_profile`,`phone`,`nik`,`tgl_lahir`,`id_agama`,`id_divisi`,`id_jabatan`,`status_kawin`,`status`) values 
(1,'03.0001.0323','Ailsa Nafa Devina','Jl. Gajahmada Semarang','Perempuan','vina@gmail.com','vinn','±lëèÌ¬#9Æ§¥\'¯','https://media.hitekno.com/thumbs/2022/09/02/30698-one-piece-shanks/730x480-img-30698-one-piece-shanks.jpg','08232823283','33222123123123','2000-07-02',1,4,1,'Belum Kawin',1);

/*Table structure for table `ms_scan_log` */

DROP TABLE IF EXISTS `ms_scan_log`;

CREATE TABLE `ms_scan_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `radius` int DEFAULT '0',
  `latitude` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '',
  `longtitude` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '',
  `jam_masuk` time DEFAULT '00:00:00',
  `jam_pulang` time DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ms_scan_log` */

insert  into `ms_scan_log`(`id`,`radius`,`latitude`,`longtitude`,`jam_masuk`,`jam_pulang`) values 
(1,15,'-7.276019','110.403534','08:00:00','15:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
