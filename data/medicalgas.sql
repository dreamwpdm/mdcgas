-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 04, 2023 at 08:43 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicalgas`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowing`
--

CREATE TABLE `borrowing` (
  `borrowno` varchar(20) COLLATE utf8_unicode_ci NOT NULL ,
  `equipcode` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL ,
  `deptcode` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL ,
  `dateborrow` date DEFAULT NULL ,
  `datereturn` date DEFAULT NULL ,
  `datesend` date DEFAULT NULL ,
  `dateready` date DEFAULT NULL ,
  `status` tinyint(3) UNSIGNED NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `borrowing`
--

INSERT INTO `borrowing` (`borrowno`, `equipcode`, `deptcode`, `dateborrow`, `datereturn`, `datesend`, `dateready`, `status`) VALUES
('202309-0001', 'BNH 208', 'BNH5004', '2023-09-04', '2023-09-05', NULL, NULL, 2),
('202309-0002', 'BNH 101', 'BNH3026', '2023-09-03', '2023-09-04', '2023-09-06', NULL, 3),
('202309-0003', 'BNH 475', 'BNH3054', '2023-09-05', '2023-09-06', '2023-09-07', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `deptcode` varchar(7) COLLATE utf8_unicode_ci NOT NULL ,
  `deptname` varchar(30) COLLATE utf8_unicode_ci NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`deptcode`, `deptname`) VALUES
('BNH6014','Biomedical Engineering'),
('BNH1004','Orderly Patient Services'),
('BNH2001','Emergency Services'),
('BNH3088','Cardiac Cath Lab'),
('BNH3006','Cardiometabolic Centre'),
('BNH3027','Checkup  Clinic'),
('BNH3128','Chemotherapy'),
('BNH3005','Dematologic & Beauty Centre'),
('BNH3012','Dental Clinic'),
('BNH3031','Diagnostic Imaging Centre'),
('BNH3054','Digestive Medical Care'),
('BNH3017','Ear Nose Throat Clinic (ENT)'),
('BNH3011','Eye Clinic'),
('BNH4036','Gynecology Center'),
('BNH3026','Hemodialysis Department'),
('BNH5001','Intensive Care Unit'),
('BNH3015','Internal Medicine'),
('BNH5005','Labour Room'),
('BNH5006','Nursery'),
('BNH5004','Operating Room'),
('BNH3023','Orthopedic Surgery Clinic'),
('BNH3019','Paediatrics Clinic'),
('BNH3043','Rehabilitation & Physical Therapy'),
('BNH3141','Shoulder and Joint Center'),
('BNH3111','Spine Clinic'),
('BNH4030','Ward 5A'),
('BNH4031','Ward 5B'),
('BNH4034','Ward 6A'),
('BNH4035','Ward 6B'),
('BNH4080','Ward 8B'),
('BNH3018','Women’s Health Center'),
('BNH3149','BNH @ All Seasons');
-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `equipcode` varchar(7) COLLATE utf8_unicode_ci NOT NULL ,
  `equipname` varchar(50) COLLATE utf8_unicode_ci NOT NULL ,
  `equipmodel` varchar(10) COLLATE utf8_unicode_ci NOT NULL ,
  `equipsn` varchar(30) COLLATE utf8_unicode_ci NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`equipcode`, `equipname`, `equipmodel`, `equipsn`) VALUES
('BNH 105','Oxygen Cylinder','0.5 Q','4057014'),
('BNH 201','Oxygen Cylinder','0.5 Q','5505'),
('BNH 206','Oxygen Cylinder','0.5 Q','4056116'),
('BNH 208','Carbon Dioxide Cylinder','6 kg','W139'),
('BNH 209','Oxygen Cylinder','0.5 Q','249484'),
('BNH 210','Nitrus Oxide Cylinder','2 kg','50033'),
('BNH 211','Nitrus Oxide Cylinder','2 kg','122360'),
('BNH 212','Oxygen Cylinder','0.5 Q','208271'),
('BNH 213','Oxygen Cylinder','0.5 Q','449506'),
('BNH 230','Oxygen Cylinder','6 Q','86386'),
('BNH 231','Oxygen Cylinder','0.5 Q','10A04'),
('BNH 234','Carbon Dioxide Cylinder','6 kg','17856'),
('BNH 235','Oxygen Cylinder','0.5 Q','3AL2015'),
('BNH 237','Oxygen Cylinder','0.5 Q','TP250'),
('BNH 238','Oxygen Cylinder','6 Q','070321'),
('BNH 239','Oxygen Cylinder','0.5 Q','29889'),
('BNH 240','Nitrus Oxide Cylinder','2 kg',''),
('BNH 241','Oxygen Cylinder','0.5 Q','9502168'),
('BNH 242','Oxygen Cylinder','6 Q','70603'),
('BNH 243','Oxygen Cylinder','0.5 Q','151190'),
('BNH 244','Nitrus Oxide Cylinder','2 kg','395424'),
('BNH 245','Nitrus Oxide Cylinder','2 kg','39474'),
('BNH 246','Oxygen Cylinder','6 Q','650764'),
('BNH 247','Carbon Dioxide Cylinder','2 kg','13036'),
('BNH 248','Carbon Dioxide Cylinder','6 kg','37863'),
('BNH 249','Carbon Dioxide Cylinder','6 kg','TP245M'),
('BNH 250','Carbon Dioxide Cylinder','6 kg','21017'),
('BNH 251','Oxygen Cylinder','0.5 Q','1104'),
('BNH 252','Carbon Dioxide Cylinder','6 kg','17856'),
('BNH 253','Carbon Dioxide Cylinder','2 kg','X254'),
('BNH 254','Oxygen Cylinder','1.5 Q','31062'),
('BNH 255','Oxygen Cylinder','Al 0.5 Q','55631'),
('BNH 258','Carbon Dioxide Cylinder','6 kg','3853'),
('BNH 259','Oxygen Cylinder','0.5 Q','5099'),
('BNH 260','Oxygen Cylinder','0.5 Q','CC79C'),
('BNH 261','Oxygen Cylinder','0.5 Q','8592450'),
('BNH 262','Nitrus Oxide Cylinder','2 kg','11097'),
('BNH 263','Oxygen Cylinder','0.5 Q','8592450'),
('BNH 265','Oxygen Cylinder','0.5 Q','33804'),
('BNH 266','Oxygen Cylinder','0.5 Q','4056047'),
('BNH 267','Oxygen Cylinder','0.5 Q',''),
('BNH 268','Medical Air Cylinder','6 Q','CB5099'),
('BNH 269','Medical Air Cylinder','6 Q','BX860437'),
('BNH 270','Nitrus Oxide Cylinder','2 kg','BX860383'),
('BNH 271','Oxygen Cylinder','0.5 Q','RX860444'),
('BNH 272','Oxygen Cylinder','0.5 Q','12-70'),
('BNH 273','Nitrus Oxide Cylinder','2 kg','K247259'),
('BNH 274','Oxygen Cylinder','0.5 Q','2908'),
('BNH 275','Nitrus Oxide Cylinder','2 kg','15255'),
('BNH 276','Oxygen Cylinder','0.5 Q','576156'),
('BNH 277','Oxygen Cylinder','0.5 Q','576311'),
('BNH 280','Oxygen Cylinder','0.5 Q','NN0705853'),
('BNH 281','Oxygen Cylinder','0.5 Q','NN0705842'),
('BNH 282','Oxygen Cylinder','0.5 Q','NN0705896'),
('BNH 283','Oxygen Cylinder','0.5 Q','NN0705839'),
('BNH 284','Oxygen Cylinder','0.5 Q','NN0705888'),
('BNH 285','Oxygen Cylinder','0.5 Q','NN0705841'),
('BNH 286','Oxygen Cylinder','0.5 Q','NN0705861'),
('BNH 287','Oxygen Cylinder','0.5 Q','NN0705845'),
('BNH 288','Oxygen Cylinder','0.5 Q','NN0705840'),
('BNH 289','Oxygen Cylinder','0.5 Q','NN0705884'),
('BNH 290','Oxygen Cylinder','0.5 Q','NN0705851'),
('BNH 291','Oxygen Cylinder','0.5 Q','NN0705830'),
('BNH 292','Oxygen Cylinder','0.5 Q','NN0705855'),
('BNH 293','Oxygen Cylinder','0.5 Q','NN0705874'),
('BNH 294','Oxygen Cylinder','0.5 Q','NN0705949'),
('BNH 295','Oxygen Cylinder','6 Q','11199'),
('BNH 297','Oxygen Cylinder','6 Q','456261'),
('BNH 298','Oxygen Cylinder','0.5 Q','AR0348967'),
('BNH 299','Oxygen Cylinder','Al 0.5 Q','NN0711641'),
('BNH 300','Oxygen Cylinder','Al 0.5 Q','NN0711547'),
('BNH 301','Oxygen Cylinder','Al 0.5 Q','NN0711609'),
('BNH 302','Oxygen Cylinder','Al 0.5 Q','NN0711613'),
('BNH 303','Oxygen Cylinder','Al 0.5 Q','NN0711634'),
('BNH 304','Oxygen Cylinder','Al 0.5 Q','NN0711642'),
('BNH 305','Oxygen Cylinder','Al 0.5 Q','NN0711615'),
('BNH 306','Oxygen Cylinder','Al 0.5 Q','NN0711611'),
('BNH 307','Oxygen Cylinder','Al 0.5 Q','NN0711644'),
('BNH 308','Oxygen Cylinder','Al 0.5 Q','NN0711601'),
('BNH 309','Oxygen Cylinder','Al 0.5 Q','NN0711568'),
('BNH 310','Oxygen Cylinder','0.5 Q','AS1246777'),
('BNH 311','Oxygen Cylinder','Al 0.5 Q','MM3088760'),
('BNH 312','Oxygen Cylinder','Al 0.5 Q','MM3088731'),
('BNH 313','Oxygen Cylinder','Al 0.5 Q','MM3088785'),
('BNH 314','Oxygen Cylinder','Al 1.5 Q','21212010'),
('BNH 315','Oxygen Cylinder','Al 1.5 Q','21217010'),
('BNH 316','Oxygen Cylinder','Al 1.5 Q','21212118'),
('BNH 317','Oxygen Cylinder','Al 1.5 Q','21217078'),
('BNH 318','Oxygen Cylinder','Al 1.5 Q','21212034'),
('BNH 319','Oxygen Cylinder','Al 1.5 Q','21212093'),
('BNH 320','Oxygen Cylinder','Al 1.5 Q','21212085'),
('BNH 321','Oxygen Cylinder','Al 1.5 Q','21212064'),
('BNH 322','Oxygen Cylinder','Al 1.5 Q','21217083'),
('BNH 323','Oxygen Cylinder','Al 1.5 Q','21212079'),
('BNH 324','Oxygen Cylinder','Al 0.5 Q','V536155'),
('BNH 325','Oxygen Cylinder','Al 0.5 Q','V536268'),
('BNH 326','Oxygen Cylinder','Al 0.5 Q','V536130'),
('BNH 327','Oxygen Cylinder','Al 0.5 Q','V536288'),
('BNH 328','Oxygen Cylinder','Al 0.5 Q','V536221'),
('BNH 329','Oxygen Cylinder','Al 0.5 Q','V536179'),
('BNH 330','Oxygen Cylinder','Al 0.5 Q','V536276'),
('BNH 331','Oxygen Cylinder','Al 0.5 Q','V536234'),
('BNH 332','Oxygen Cylinder','Al 0.5 Q','V536233'),
('BNH 333','Oxygen Cylinder','Al 0.5 Q','V536196'),
('BNH 334','Oxygen Cylinder','Al 0.5 Q','10062'),
('BNH 335','Oxygen Cylinder','Al 0.5 Q','a4055132'),
('BNH 337','Oxygen Cylinder','Al 0.5 Q','AS1383258'),
('BNH 338','Oxygen Cylinder','Al 0.5 Q','NN0614250'),
('BNH 339','Oxygen Cylinder','Al 0.5 Q','MM6088776'),
('BNH 340','Oxygen Cylinder','Al 0.5 Q','AR0486836'),
('BNH 341','Oxygen Cylinder','Al 0.5 Q','AR0486886'),
('BNH 342','Oxygen Cylinder','6 Q','AR0486886'),
('BNH 360','Oxygen Cylinder','Al 0.5 Q','576081'),
('BNH 361','Oxygen Cylinder','Al 0.5 Q','576114'),
('BNH 362','Oxygen Cylinder','Al 0.5 Q','576131'),
('BNH 363','Medical Air Cylinder','-',''),
('BNH 364','Medical Air Cylinder','-','576349'),
('BNH 365','Medical Air Cylinder','-','MM257902U'),
('BNH 366','Medical Air Cylinder','-','CUM2680628'),
('BNH 369','Nitrus Oxide Cylinder','2 kg','578959'),
('BNH 370','Oxygen Cylinder','6 Q','D059387'),
('BNH 371','Nitrus Oxide Cylinder','2 kg','MM2580512'),
('BNH 372','Oxygen Cylinder','Al 0.5 Q','576029'),
('BNH 373','Oxygen Cylinder','Al 0.5 Q','MM2579014'),
('BNH 374','Oxygen Cylinder','Al 0.5 Q','43801024'),
('BNH 375','Medical Air Cylinder','Al 0.5 Q','CB6099'),
('BNH 401','Oxygen Cylinder','Al 0.5 Q','D0616529'),
('BNH 402','Oxygen Cylinder','Al 0.5 Q','D0616482'),
('BNH 403','Oxygen Cylinder','Al 0.5 Q','D0616457'),
('BNH 404','Oxygen Cylinder','Al 0.5 Q','D0616417'),
('BNH 405','Oxygen Cylinder','Al 0.5 Q','D0616501'),
('BNH 406','Oxygen Cylinder','Al 0.5 Q','D0616543'),
('BNH 407','Oxygen Cylinder','Al 0.5 Q','D0616515'),
('BNH 408','Oxygen Cylinder','Al 0.5 Q','D0616415'),
('BNH 409','Oxygen Cylinder','Al 0.5 Q','D0616512'),
('BNH 410','Oxygen Cylinder','Al 0.5 Q','D0616531'),
('BNH 411','Oxygen Cylinder','Al 0.5 Q','D0616431'),
('BNH 412','Oxygen Cylinder','Al 0.5 Q','D0616493'),
('BNH 413','Oxygen Cylinder','Al 0.5 Q','D0616524'),
('BNH 414','Oxygen Cylinder','Al 0.5 Q','D0616482'),
('BNH 415','Oxygen Cylinder','Al 0.5 Q','D0616486'),
('BNH 416','Oxygen Cylinder','Al 0.5 Q','D0616518'),
('BNH 417','Oxygen Cylinder','Al 0.5 Q','D0616421'),
('BNH 418','Oxygen Cylinder','Al 0.5 Q','D0616521'),
('BNH 419','Oxygen Cylinder','Al 0.5 Q','D0616510'),
('BNH 42','Nitrogen Cylinder','1.5 Q','27268'),
('BNH 420','Oxygen Cylinder','Al 0.5 Q','D0616502'),
('BNH 421','Oxygen Cylinder','Al 0.5 Q','D0616505'),
('BNH 422','Oxygen Cylinder','Al 0.5 Q','D0616539'),
('BNH 423','Oxygen Cylinder','Al 0.5 Q','D0616577'),
('BNH 424','Oxygen Cylinder','Al 0.5 Q','D0616551'),
('BNH 425','Oxygen Cylinder','Al 0.5 Q','D0616507'),
('BNH 426','Oxygen Cylinder','Al 0.5 Q','D0616496'),
('BNH 427','Oxygen Cylinder','Al 0.5 Q','D0616446'),
('BNH 428','Oxygen Cylinder','Al 0.5 Q','D0616445'),
('BNH 429','Oxygen Cylinder','Al 0.5 Q','D0616448'),
('BNH 430','Oxygen Cylinder','Al 0.5 Q','D0616570'),
('BNH 431','Oxygen Cylinder','Al 0.5 Q','D0616557'),
('BNH 432','Oxygen Cylinder','Al 0.5 Q','D0616500'),
('BNH 433','Oxygen Cylinder','Al 0.5 Q','D0616511'),
('BNH 434','Oxygen Cylinder','Al 0.5 Q','D0616594'),
('BNH 435','Oxygen Cylinder','Al 0.5 Q','D0616536'),
('BNH 436','Oxygen Cylinder','Al 0.5 Q','D0616548'),
('BNH 437','Oxygen Cylinder','Al 0.5 Q','D0616438'),
('BNH 438','Oxygen Cylinder','Al 0.5 Q','D0616437'),
('BNH 439','Oxygen Cylinder','Al 4.5 Q','D0616428'),
('BNH 44','Nitrus Oxide Cylinder','3 kg','18365'),
('BNH 440','Oxygen Cylinder','Al 4.5 Q','AP0001941'),
('BNH 441','Oxygen Cylinder','Al 4.5 Q','AP0001930'),
('BNH 442','Oxygen Cylinder','Al 4.5 Q','AP0002085'),
('BNH 443','Oxygen Cylinder','Al 4.5 Q','AP0001946'),
('BNH 444','Oxygen Cylinder','Al 4.5 Q','AP0001937'),
('BNH 445','Oxygen Cylinder','6 Q','151172239'),
('BNH 446','Oxygen Cylinder','6 Q','151172061'),
('BNH 447','Oxygen Cylinder','6 Q','151172030'),
('BNH 448','Oxygen Cylinder','6 Q','151172038'),
('BNH 449','Oxygen Cylinder','6 Q','151172100'),
('BNH 45','Carbon Dioxide Cylinder','6 kg','4176'),
('BNH 450','Oxygen Cylinder','6 Q','151172178'),
('BNH 451','Oxygen Cylinder','6 Q','151172157'),
('BNH 452','Oxygen Cylinder','6 Q','151172045'),
('BNH 453','Oxygen Cylinder','6 Q','151172079'),
('BNH 454','Oxygen Cylinder','6 Q','151172073'),
('BNH 455','Oxygen Cylinder','6 Q','151172049'),
('BNH 456','Oxygen Cylinder','6 Q','151172001'),
('BNH 457','Oxygen Cylinder','6 Q','151172219'),
('BNH 458','Oxygen Cylinder','6 Q','151172297'),
('BNH 459','Oxygen Cylinder','6 Q','151172043'),
('BNH 46','Nitrus Oxide Cylinder','3 kg','91254'),
('BNH 460','Oxygen Cylinder','6 Q','151172211'),
('BNH 461','Oxygen Cylinder','6 Q','151172170'),
('BNH 462','Oxygen Cylinder','6 Q','151172014'),
('BNH 463','Oxygen Cylinder','6 Q','151172121'),
('BNH 464','Oxygen Cylinder','6 Q','151172093'),
('BNH 465','Oxygen Cylinder','6 Q','151172191'),
('BNH 466','Oxygen Cylinder','6 Q','151172040'),
('BNH 467','Oxygen Cylinder','6 Q','151172016'),
('BNH 468','Oxygen Cylinder','6 Q','151172250'),
('BNH 469','Oxygen Cylinder','6 Q','151172069'),
('BNH 47','Carbon Dioxide Cylinder','6 kg','17979'),
('BNH 470','Nitrogen Cylinder','6 Q','151251037'),
('BNH 471','Nitrogen Cylinder','6 Q','151251101'),
('BNH 472','Nitrogen Cylinder','6 Q','151251253'),
('BNH 473','Nitrogen Cylinder','6 Q','151251168'),
('BNH 474','Nitrogen Cylinder','6 Q','151251208'),
('BNH 475','Nitrogen Cylinder','6 Q','151251291'),
('BNH 476','Nitrogen Cylinder','6 Q','151251170'),
('BNH 477','Nitrogen Cylinder','6 Q','151251177'),
('BNH 478','Nitrogen Cylinder','6 Q','-'),
('BNH 479','Nitrogen Cylinder','6 Q','151251247'),
('BNH 48','Nitrus Oxide Cylinder','3 kg','2437'),
('BNH 480','Nitrogen Cylinder','6 Q',''),
('BNH 481','Nitrogen Cylinder','6 Q','151251245'),
('BNH 482','Nitrogen Cylinder','6 Q','151251032'),
('BNH 483','Nitrogen Cylinder','6 Q','151251151'),
('BNH 484','Nitrogen Cylinder','6 Q','151251140'),
('BNH 485','Nitrogen Cylinder','6 Q','151251036'),
('BNH 486','Nitrogen Cylinder','6 Q','151251013'),
('BNH 487','Nitrogen Cylinder','6 Q','151251189'),
('BNH 488','Nitrogen Cylinder','6 Q',''),
('BNH 489','Nitrogen Cylinder','6 Q','151251143'),
('BNH 49','Nitrus Oxide Cylinder','3 kg','47G27'),
('BNH 490','Nitrogen Cylinder','6 Q','151251200'),
('BNH 491','Nitrogen Cylinder','6 Q','151251005'),
('BNH 500','Nitrus Oxide Cylinder','20 kg','16279071'),
('BNH 501','Nitrus Oxide Cylinder','20 kg','16279099'),
('BNH 502','Nitrus Oxide Cylinder','20 kg','16279259'),
('BNH 503','Nitrus Oxide Cylinder','20 kg','16279167'),
('BNH 504','Nitrus Oxide Cylinder','20 kg','16279248'),
('BNH 505','Nitrus Oxide Cylinder','20 kg','16279277'),
('BNH 506','Nitrus Oxide Cylinder','20 kg','16279037'),
('BNH 507','Nitrus Oxide Cylinder','20 kg','16279090'),
('BNH 508','Nitrus Oxide Cylinder','20 kg','16279035'),
('BNH 509','Nitrus Oxide Cylinder','20 kg','16279120'),
('BNH 510','Nitrus Oxide Cylinder','20 kg','16279045'),
('BNH 511','Nitrus Oxide Cylinder','20 kg','16279245'),
('BNH 512','Nitrus Oxide Cylinder','20 kg','16279030'),
('BNH 513','Nitrus Oxide Cylinder','20 kg','16279168'),
('BNH 514','Nitrus Oxide Cylinder','20 kg','16279221'),
('BNH 515','Nitrus Oxide Cylinder','20 kg','16279212'),
('BNH 516','Nitrus Oxide Cylinder','20 kg','16279181'),
('BNH 517','Nitrus Oxide Cylinder','20 kg','16279054'),
('BNH 518','Nitrus Oxide Cylinder','20 kg','16279250'),
('BNH 519','Nitrus Oxide Cylinder','20 kg','16279190'),
('BNH 520','Nitrus Oxide Cylinder','20 kg','16279267'),
('BNH 521','Nitrus Oxide Cylinder','20 kg','16279280'),
('BNH 522','Carbon Dioxide Cylinder','8.87 kg','-'),
('BNH 523','Carbon Dioxide Cylinder','8.87 kg','401192'),
('BNH 524','Oxygen Cylinder','Al 0.5 Q','-'),
('BNH 525','Nitrus Oxide Cylinder','0.5 kg','-'),
('BNH 526','Nitrogen Cylinder','1.5 Q','N/A'),
('BNH 527','Oxygen Cylinder','Al 0.5 Q','61801064'),
('BNH 528','Oxygen Cylinder','Al 0.5 Q','AP0003736'),
('BNH 529','Oxygen Cylinder','Al 4.5 Q','AP0003360'),
('BNH 530','Oxygen Cylinder','Al 0.5 Q',''),
('BNH 531','Oxygen Cylinder','Al 0.5 Q','AP0003314'),
('BNH 532','Oxygen Cylinder','-','AP0001740'),
('BNH 533','Oxygen Cylinder','Al 0.5 Q','CX04117'),
('BNH 534','Carbon Dioxide Cylinder','6 kg','-'),
('BNH 535','Carbon Dioxide Cylinder','6 kg','-'),
('BNH 536','Carbon Dioxide Cylinder','6 kg','-'),
('BNH 537','Carbon Dioxide Cylinder','6 kg','-'),
('BNH 538','Oxygen Cylinder','0.5 Q','-'),
('BNH 539','Nitrus Oxide Cylinder','0.5 kg','-'),
('BNH 547','Oxygen Cylinder','Al 0.5 Q','HQ31167'),
('BNH 549','Nitrus Oxide Cylinder','3 kg','HQ31055'),
('BNH 551','Oxygen Cylinder','Al 4.64 L','CHN04311'),
('BNH 552','Oxygen Cylinder','Al 4.64 L','CHN04457'),
('BNH 553','Oxygen Cylinder','Al 4.64 L','CHN04453'),
('BNH 554','Oxygen Cylinder','Al 4.64 L','CHN04353'),
('BNH 555','Oxygen Cylinder','Al 4.64 L','CHN04304'),
('BNH 556','Oxygen Cylinder','Al 4.64 L','CHN04374'),
('BNH 557','Oxygen Cylinder','Al 4.64 L','CHN04287'),
('BNH 558','Oxygen Cylinder','Al 4.64 L','CHN04390'),
('BNH 559','Oxygen Cylinder','Al 4.64 L','CHN04440'),
('BNH 560','Oxygen Cylinder','Al 4.64 L','CHN04451'),
('BNH 561','Oxygen Cylinder','Al 4.64 L','CHN04463'),
('BNH 562','Oxygen Cylinder','Al 4.64 L','CHN04333'),
('BNH 563','Oxygen Cylinder','Al 4.64 L','CHN04276'),
('BNH 564','Oxygen Cylinder','Al 4.64 L','CHN04441'),
('BNH 565','Oxygen Cylinder','Al 4.64 L','CHN04361'),
('BNH 566','Oxygen Cylinder','Al 4.64 L','CHN04412'),
('BNH 567','Oxygen Cylinder','Al 4.64 L','CHN04445'),
('BNH 568','Oxygen Cylinder','Al 4.64 L','CHN04347'),
('BNH 569','Oxygen Cylinder','Al 4.64 L','CHN04415'),
('BNH 570','Oxygen Cylinder','Al 4.64 L','CHN04275'),
('BNH 6','Medical Air Cylinder','6 Q','912-77'),
('BNH 67','Nitrus Oxide Cylinder','20 kg','6505077'),
('BNH 72','Carbon Dioxide Cylinder','6 kg','5374'),
('BNH 8','Oxygen Cylinder','6 Q','79027');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD PRIMARY KEY (`borrowno`),
  ADD KEY `borrowEquip` (`equipcode`),
  ADD KEY `borrowDept` (`deptcode`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`deptcode`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`equipcode`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowing`
--
ALTER TABLE `borrowing`
  ADD CONSTRAINT `borrowDept` FOREIGN KEY (`deptcode`) REFERENCES `departments` (`deptcode`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowEquip` FOREIGN KEY (`equipcode`) REFERENCES `equipments` (`equipcode`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
