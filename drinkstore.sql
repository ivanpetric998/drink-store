-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2020 at 05:14 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drinkstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `detaljiporudzbine`
--

CREATE TABLE `detaljiporudzbine` (
  `idDP` int(200) NOT NULL,
  `idPorudzbina` int(200) NOT NULL,
  `idProizvod` int(255) NOT NULL,
  `kolicina` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `detaljiporudzbine`
--

INSERT INTO `detaljiporudzbine` (`idDP`, `idPorudzbina`, `idProizvod`, `kolicina`) VALUES
(12, 9, 48, 1),
(13, 9, 51, 2),
(14, 10, 58, 1),
(15, 11, 51, 2),
(16, 11, 48, 1),
(17, 11, 49, 4),
(18, 11, 11, 4),
(19, 12, 62, 2),
(20, 13, 11, 1),
(21, 13, 50, 1),
(22, 14, 51, 1),
(23, 14, 48, 1),
(24, 14, 49, 2),
(25, 15, 46, 1),
(26, 16, 49, 2),
(27, 16, 51, 1),
(28, 16, 59, 1),
(29, 16, 60, 2),
(30, 16, 62, 1),
(31, 17, 51, 2),
(32, 18, 62, 1),
(33, 18, 49, 1),
(34, 18, 47, 2),
(35, 18, 45, 2),
(36, 19, 14, 1),
(37, 20, 49, 2),
(38, 20, 48, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `idKategorija` int(100) NOT NULL,
  `nazivKategorija` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`idKategorija`, `nazivKategorija`) VALUES
(1, 'Vina'),
(2, 'Sokovi'),
(3, 'Voda'),
(5, 'Pivo'),
(7, 'Energetska pića'),
(8, 'Kafa'),
(16, 'Rakije'),
(17, 'Viski'),
(20, 'Vodka');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `idKorisnik` int(200) NOT NULL,
  `ime` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `prezime` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `grad` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `adresa` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `lozinka` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `idUloga` int(100) NOT NULL,
  `aktivan` bit(1) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`idKorisnik`, `ime`, `prezime`, `grad`, `adresa`, `email`, `lozinka`, `idUloga`, `aktivan`, `datum`) VALUES
(18, 'Pera', 'Kovac', 'Novi Sad', 'Perina adresa', 'pera@gmail.com', 'df5e8c760f430ff37c1384098bd7e806', 2, b'1', '2020-02-04 13:24:39'),
(23, 'Jovan', 'Jovanovic', 'Beograd', 'Ustanicka 45', 'jovan@gmail.com', 'df5e8c760f430ff37c1384098bd7e806', 2, b'1', '2020-02-06 16:11:56'),
(30, 'Mika', 'Mikic', 'Beograd', 'Ugrinovacka 45', 'mika@gmail.com', 'df5e8c760f430ff37c1384098bd7e806', 2, b'1', '2020-02-08 14:32:25'),
(32, 'Ivan', 'Petric', 'Zemun', 'Prvomajska 65', 'ivan.petric@gmail.com', 'c958b2adc0759e46a9968790bcc0736c', 1, b'1', '2020-02-08 15:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `listazelja`
--

CREATE TABLE `listazelja` (
  `idZelja` int(255) NOT NULL,
  `idKorisnik` int(200) NOT NULL,
  `idProizvod` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `listazelja`
--

INSERT INTO `listazelja` (`idZelja`, `idKorisnik`, `idProizvod`) VALUES
(63, 18, 14),
(62, 18, 62),
(66, 23, 46),
(65, 23, 48),
(64, 23, 49),
(67, 23, 62),
(68, 30, 58);

-- --------------------------------------------------------

--
-- Table structure for table `marka`
--

CREATE TABLE `marka` (
  `idMarka` int(100) NOT NULL,
  `nazivMarka` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `marka`
--

INSERT INTO `marka` (`idMarka`, `nazivMarka`) VALUES
(1, 'Ballantine\'s'),
(2, 'Chivas Regal'),
(3, 'Srpska trojka'),
(4, 'Stara rakija'),
(5, 'Jack Daniel`s'),
(6, 'Johnnie Walker'),
(7, 'Jameson'),
(8, 'Atlantic'),
(9, 'Žuta osa'),
(10, 'Smirnoff'),
(11, 'Rubin'),
(12, 'Vučija rakija');

-- --------------------------------------------------------

--
-- Table structure for table `meni`
--

CREATE TABLE `meni` (
  `idMeni` int(200) NOT NULL,
  `link` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tekst` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pozicija` int(100) NOT NULL,
  `idTip` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meni`
--

INSERT INTO `meni` (`idMeni`, `link`, `tekst`, `pozicija`, `idTip`) VALUES
(1, 'page=najnovije', 'Najnovije', 1, 2),
(2, 'page=preporuceno', 'Preporučeno', 2, 2),
(3, 'page=akcija', 'Na akciji', 3, 2),
(4, 'admin=unos-proizvoda', 'Proizvodi', 3, 1),
(5, 'admin=pocetna', 'Početna', 1, 1),
(6, 'admin=porudzbine', 'Porudžbine', 5, 1),
(7, 'admin=korisnici', 'Korisnici', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `porudzbina`
--

CREATE TABLE `porudzbina` (
  `idPorudzbina` int(200) NOT NULL,
  `idKorisnik` int(200) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `porudzbina`
--

INSERT INTO `porudzbina` (`idPorudzbina`, `idKorisnik`, `datum`) VALUES
(9, 18, '2020-02-06 12:45:42'),
(10, 18, '2020-02-06 12:45:51'),
(11, 18, '2020-02-06 13:57:42'),
(12, 18, '2020-02-06 15:33:50'),
(13, 23, '2020-02-06 16:12:19'),
(14, 23, '2020-02-06 16:14:42'),
(15, 23, '2020-02-06 16:18:04'),
(16, 18, '2020-02-07 20:48:05'),
(17, 18, '2020-02-07 20:49:51'),
(18, 23, '2020-02-08 14:39:44'),
(19, 23, '2020-02-08 14:40:30'),
(20, 30, '2020-02-08 15:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `proizvod`
--

CREATE TABLE `proizvod` (
  `idProizvod` int(255) NOT NULL,
  `proizvodNaziv` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cena` decimal(65,0) NOT NULL,
  `slikaOriginal` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `slikaNova` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `opis` text COLLATE utf8_unicode_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp(),
  `preporuceno` bit(1) NOT NULL,
  `akcija` bit(1) NOT NULL,
  `popust` int(4) DEFAULT NULL,
  `idMarka` int(100) NOT NULL,
  `idKategorija` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `proizvod`
--

INSERT INTO `proizvod` (`idProizvod`, `proizvodNaziv`, `cena`, `slikaOriginal`, `slikaNova`, `opis`, `datum`, `preporuceno`, `akcija`, `popust`, `idMarka`, `idKategorija`) VALUES
(11, 'Jack Daniel`s 0,7L', '3062', '1580558981-jack.jpg', '1580558981-jack.jpg-nova', 'Jack Daniel\'s Black Label, takođe poznat i kao Old No. 7, je brend Tenesi viskija i najprodavaniji j...\r\n\r\nOriginalno objavljeno na stranici https://www.ediskont.rs/srpski/proizvod/jack-daniels-whiskey-0.5l-1075 © EDISKONT', '2020-02-01 12:09:41', b'1', b'0', NULL, 5, 17),
(14, 'Ballantine`s Pernod Ricard 0,7L', '1890', '1580559494-balantines.jpg', '1580559494-balantines.jpg-nova', 'Neki opis za Balantines', '2020-02-01 12:18:14', b'1', b'1', 10, 1, 17),
(45, 'Johnnie Walker R/L kutija 0,7l', '1499', '1580654537-johnnie-walker-red-label-whisky-box.jpg', '1580654537-johnnie-walker-red-label-whisky-box.jpg-nova', 'Neki opis', '2020-02-02 14:42:17', b'1', b'0', NULL, 6, 17),
(46, 'Whiskey Jameson 1l', '3299', '1580654716-jameson.jpg', '1580654716-jameson.jpg-nova', 'dfsfd', '2020-02-02 14:45:16', b'0', b'1', 5, 7, 17),
(47, 'Vodka Atlantik 40% 1l RDZ', '719', '1580654879-atlantic.png', '1580654879-atlantic.png-nova', 'fgfgfg', '2020-02-02 14:47:59', b'0', b'0', NULL, 8, 20),
(48, 'Rakija 45% Zuta osa 0.7l', '2199', '1580655151-yellow_wasp_tastebrandy.jpg', '1580655151-yellow_wasp_tastebrandy.jpg-nova', 'dfdfdf', '2020-02-02 14:52:31', b'0', b'1', 11, 9, 16),
(49, 'Vodka Ice 4% Smirnoff 0.275l', '145', '1580655333-vodka-smirnoff-red-1l-1004437-large.jpg', '1580655333-vodka-smirnoff-red-1l-1004437-large.jpg-nova', 'fgdfgfg', '2020-02-02 14:55:33', b'0', b'0', NULL, 10, 20),
(50, 'Whisky Jonnie Walker B/L kut.0.7l', '3890', '1580655539-Johnnie-Walker-Black-Label.jpg', '1580655539-Johnnie-Walker-Black-Label.jpg-nova', 'rgfdgfdg', '2020-02-02 14:58:59', b'1', b'1', 9, 6, 17),
(51, 'Rakija sljiva 43% Vucija rakija 0.7l', '2099', '1580655944-8821077803038.png', '1580655944-8821077803038.png-nova', 'fgbfgdfg', '2020-02-02 15:05:45', b'1', b'0', NULL, 12, 16),
(58, 'Rakija-kajsija 43% Vucija rakija 0.7l', '2450', '1580684940-8824897044510.png', '1580684940-8824897044510.png-nova', 'dfsdfdsf', '2020-02-02 23:08:41', b'1', b'1', 7, 12, 16),
(59, 'Rakija-dunja 43% Vucija rakija 0.7l', '2780', '1580684972-8820642185246.png', '1580684972-8820642185246.png-nova', 'fgfdgdfg', '2020-02-02 23:09:33', b'0', b'0', NULL, 12, 16),
(60, 'Rakija Superior 45% Zuta osa kutija 0.7l', '3599', '1580685081-K5m0Zusrlte.jpg', '1580685081-K5m0Zusrlte.jpg-nova', 'fsdfsdfdsfsdf', '2020-02-02 23:11:21', b'0', b'1', 11, 9, 16),
(61, 'Rakija Kajsija Barik Srpska Trojka 0,7L', '2899', '1580685453-8847790211102.png', '1580685453-8847790211102.png-nova', 'fsfdfdsfdsfd', '2020-02-02 23:17:33', b'1', b'0', NULL, 3, 16),
(62, 'Srpska Trojka Premium Dunjevaca barik sa zlatom 0.70l', '8299', '1580685697-srpska-trojka-premium-dunjevaca-sa-zlatom-gift.jpg', '1580685697-srpska-trojka-premium-dunjevaca-sa-zlatom-gift.jpg-nova', 'fgfgdfgfdg', '2020-02-02 23:21:37', b'1', b'1', 17, 3, 16);

-- --------------------------------------------------------

--
-- Table structure for table `slajder`
--

CREATE TABLE `slajder` (
  `idSlajder` int(50) NOT NULL,
  `src` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `opis` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idKategorija` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slajder`
--

INSERT INTO `slajder` (`idSlajder`, `src`, `alt`, `opis`, `idKategorija`) VALUES
(6, 'viskiPoz.jpg', 'viski', 'opis', 17),
(7, 'pivo.jpg', 'pivo', 'opis', 5),
(8, 'kafa.jpg', 'kafa', 'opis', 8),
(9, 'sokovi.jpg', 'sokovi', 'opis', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tip`
--

CREATE TABLE `tip` (
  `idTip` int(100) NOT NULL,
  `nazivTip` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tip`
--

INSERT INTO `tip` (`idTip`, `nazivTip`) VALUES
(1, 'admin'),
(2, 'dodatno');

-- --------------------------------------------------------

--
-- Table structure for table `uloga`
--

CREATE TABLE `uloga` (
  `idUloga` int(100) NOT NULL,
  `nazivUloga` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uloga`
--

INSERT INTO `uloga` (`idUloga`, `nazivUloga`) VALUES
(1, 'admin'),
(2, 'korisnik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detaljiporudzbine`
--
ALTER TABLE `detaljiporudzbine`
  ADD PRIMARY KEY (`idDP`),
  ADD KEY `idPorudzbina` (`idPorudzbina`,`idProizvod`),
  ADD KEY `idProizvod` (`idProizvod`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`idKategorija`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`idKorisnik`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idUloga` (`idUloga`);

--
-- Indexes for table `listazelja`
--
ALTER TABLE `listazelja`
  ADD PRIMARY KEY (`idZelja`),
  ADD UNIQUE KEY `idKorisnik_2` (`idKorisnik`,`idProizvod`),
  ADD KEY `idKorisnik` (`idKorisnik`,`idProizvod`),
  ADD KEY `idProizvod` (`idProizvod`);

--
-- Indexes for table `marka`
--
ALTER TABLE `marka`
  ADD PRIMARY KEY (`idMarka`);

--
-- Indexes for table `meni`
--
ALTER TABLE `meni`
  ADD PRIMARY KEY (`idMeni`),
  ADD KEY `idTip` (`idTip`);

--
-- Indexes for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD PRIMARY KEY (`idPorudzbina`),
  ADD KEY `idKorisnik` (`idKorisnik`);

--
-- Indexes for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD PRIMARY KEY (`idProizvod`),
  ADD KEY `idMarka` (`idMarka`),
  ADD KEY `idKategorija` (`idKategorija`);

--
-- Indexes for table `slajder`
--
ALTER TABLE `slajder`
  ADD PRIMARY KEY (`idSlajder`),
  ADD KEY `idKategorija` (`idKategorija`);

--
-- Indexes for table `tip`
--
ALTER TABLE `tip`
  ADD PRIMARY KEY (`idTip`);

--
-- Indexes for table `uloga`
--
ALTER TABLE `uloga`
  ADD PRIMARY KEY (`idUloga`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detaljiporudzbine`
--
ALTER TABLE `detaljiporudzbine`
  MODIFY `idDP` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `idKategorija` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `idKorisnik` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `listazelja`
--
ALTER TABLE `listazelja`
  MODIFY `idZelja` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `marka`
--
ALTER TABLE `marka`
  MODIFY `idMarka` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `meni`
--
ALTER TABLE `meni`
  MODIFY `idMeni` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `porudzbina`
--
ALTER TABLE `porudzbina`
  MODIFY `idPorudzbina` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `proizvod`
--
ALTER TABLE `proizvod`
  MODIFY `idProizvod` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `slajder`
--
ALTER TABLE `slajder`
  MODIFY `idSlajder` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tip`
--
ALTER TABLE `tip`
  MODIFY `idTip` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uloga`
--
ALTER TABLE `uloga`
  MODIFY `idUloga` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detaljiporudzbine`
--
ALTER TABLE `detaljiporudzbine`
  ADD CONSTRAINT `detaljiporudzbine_ibfk_1` FOREIGN KEY (`idPorudzbina`) REFERENCES `porudzbina` (`idPorudzbina`),
  ADD CONSTRAINT `detaljiporudzbine_ibfk_2` FOREIGN KEY (`idProizvod`) REFERENCES `proizvod` (`idProizvod`);

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `korisnik_ibfk_1` FOREIGN KEY (`idUloga`) REFERENCES `uloga` (`idUloga`);

--
-- Constraints for table `listazelja`
--
ALTER TABLE `listazelja`
  ADD CONSTRAINT `listazelja_ibfk_1` FOREIGN KEY (`idProizvod`) REFERENCES `proizvod` (`idProizvod`),
  ADD CONSTRAINT `listazelja_ibfk_2` FOREIGN KEY (`idKorisnik`) REFERENCES `korisnik` (`idKorisnik`);

--
-- Constraints for table `meni`
--
ALTER TABLE `meni`
  ADD CONSTRAINT `meni_ibfk_1` FOREIGN KEY (`idTip`) REFERENCES `tip` (`idTip`);

--
-- Constraints for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD CONSTRAINT `porudzbina_ibfk_1` FOREIGN KEY (`idKorisnik`) REFERENCES `korisnik` (`idKorisnik`);

--
-- Constraints for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD CONSTRAINT `proizvod_ibfk_1` FOREIGN KEY (`idMarka`) REFERENCES `marka` (`idMarka`),
  ADD CONSTRAINT `proizvod_ibfk_2` FOREIGN KEY (`idKategorija`) REFERENCES `kategorija` (`idKategorija`);

--
-- Constraints for table `slajder`
--
ALTER TABLE `slajder`
  ADD CONSTRAINT `slajder_ibfk_1` FOREIGN KEY (`idKategorija`) REFERENCES `kategorija` (`idKategorija`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
