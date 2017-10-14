-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 14, 2017 at 08:56 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saleapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ChamSocKhacHang`
--

CREATE TABLE `ChamSocKhacHang` (
  `id_cskh` int(20) NOT NULL,
  `id_NV` int(20) UNSIGNED NOT NULL,
  `id_KH` int(20) UNSIGNED NOT NULL,
  `ngay` datetime NOT NULL,
  `daxem` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ChamSocKhacHang`
--

INSERT INTO `ChamSocKhacHang` (`id_cskh`, `id_NV`, `id_KH`, `ngay`, `daxem`) VALUES
(89, 26, 26, '2017-10-01 03:09:27', 1),
(90, 26, 27, '2017-10-01 03:49:01', 1),
(91, 26, 28, '2017-10-01 03:51:50', 1),
(92, 26, 29, '2017-10-01 04:27:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `csMoiNhat`
--

CREATE TABLE `csMoiNhat` (
  `id_moinhat` int(10) UNSIGNED NOT NULL,
  `id_KH` int(10) UNSIGNED NOT NULL,
  `id_NV` int(11) NOT NULL,
  `csTuongTac` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `csPhanHoi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `csNgay` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `csMoiNhat`
--

INSERT INTO `csMoiNhat` (`id_moinhat`, `id_KH`, `id_NV`, `csTuongTac`, `csPhanHoi`, `csNgay`) VALUES
(1, 14, 22, 'khÃ´ng cÃ³ nhu cáº§u', 'khÃ´ng cÃ³ nhu cáº§u', '2017-09-30 13:52:12'),
(3, 26, 26, 'Mua nhÃ  ', 'mua nhÃ ', '2017-10-01 03:33:37'),
(4, 28, 26, 'aggag', 'ÄƒgÄƒgÄƒ', '2017-10-01 04:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `Hang`
--

CREATE TABLE `Hang` (
  `id_hang` int(20) NOT NULL,
  `ma_hang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ten_hang` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dtich_hang` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sluong_hang` int(30) NOT NULL,
  `ttthem_hang` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Hang`
--

INSERT INTO `Hang` (`id_hang`, `ma_hang`, `ten_hang`, `dtich_hang`, `sluong_hang`, `ttthem_hang`) VALUES
(1, 'chbs_12', 'Chung cÆ° bÃ¬nh sÆ¡n', '1220 m2', 20, 'chung cÆ° má»›i');

-- --------------------------------------------------------

--
-- Table structure for table `khachChot`
--

CREATE TABLE `khachChot` (
  `idChot` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id_NV` int(11) DEFAULT NULL,
  `ten_NV` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ten_kh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sdt_kh` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email_kh` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `canho` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mailchunha` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `dtchunha` text COLLATE utf8_unicode_ci NOT NULL,
  `phithuve` int(11) NOT NULL,
  `ngaylamhopdong` date NOT NULL,
  `ngaynhantien` date NOT NULL,
  `ngayketthuchopdong` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `id_KH` int(20) NOT NULL,
  `ten_KH` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sdt_KH` int(30) NOT NULL,
  `email_KH` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `diachi_KH` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ttthem_KH` text COLLATE utf8_unicode_ci NOT NULL,
  `ngay_them` datetime NOT NULL,
  `loaikhach` int(11) NOT NULL,
  `id_NV` int(11) UNSIGNED DEFAULT NULL,
  `cs` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id_KH`, `ten_KH`, `sdt_KH`, `email_KH`, `diachi_KH`, `ttthem_KH`, `ngay_them`, `loaikhach`, `id_NV`, `cs`) VALUES
(26, 'Há»“ Sá»¹ KiÃªn', 868098591, 'hokien07@gmail.com', '', '', '2017-10-01 03:09:26', 1, 28, 1),
(27, 'HoÃ ng vÄƒn BÃ¡nh', 987678890, 'hoangvb@gmail.com', '', '', '2017-10-01 03:49:00', 2, 28, 0),
(28, 'quáº¡t Ä‘iá»‡n', 167678876, 'dien@gmail.com', '', '', '2017-10-01 03:51:50', 0, 28, 1),
(29, 'Ä‘Ã n guitar', 987678765, 'guitar@gmail.com', 'hÃ  Ä‘Ã´ng', 'hÃ  Ä‘Ã´ng', '2017-10-01 04:27:09', 1, 27, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Log`
--

CREATE TABLE `Log` (
  `id_log` int(20) NOT NULL,
  `id_NV` int(11) NOT NULL,
  `ngay` datetime NOT NULL,
  `ghi_chu` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `Log`
--

INSERT INTO `Log` (`id_log`, `id_NV`, `ngay`, `ghi_chu`) VALUES
(53, 27, '2017-10-01 03:09:27', 'thÃªm khÃ¡ch hÃ ng: Há»“ Sá»¹ KiÃªn'),
(54, 27, '2017-10-01 03:49:01', 'thÃªm khÃ¡ch hÃ ng: HoÃ ng vÄƒn BÃ¡nh'),
(55, 26, '2017-10-01 03:51:50', 'thÃªm khÃ¡ch hÃ ng: quáº¡t Ä‘iá»‡n'),
(56, 26, '2017-10-01 04:01:36', 'sá»­a khÃ¡ch hÃ ng: Há»“ Sá»¹ KiÃªn thÃ nh : Há»“ Sá»¹ KiÃªn'),
(57, 26, '2017-10-01 04:03:39', 'sá»­a khÃ¡ch hÃ ng: HoÃ ng vÄƒn BÃ¡nh thÃ nh : HoÃ ng vÄƒn BÃ¡nh'),
(58, 27, '2017-10-01 04:05:00', 'sá»­a khÃ¡ch hÃ ng: quáº¡t Ä‘iá»‡n thÃ nh : quáº¡t Ä‘iá»‡n'),
(59, 27, '2017-10-01 04:05:45', 'thÃªm nhÃ¢n viÃªn: Nguyá»n HÃ¹ng CÆ°á»ng'),
(60, 27, '2017-10-01 04:06:34', 'sá»­a khÃ¡ch hÃ ng: quáº¡t Ä‘iá»‡n thÃ nh : quáº¡t Ä‘iá»‡n'),
(61, 27, '2017-10-01 04:08:00', 'sá»­a khÃ¡ch hÃ ng: HoÃ ng vÄƒn BÃ¡nh thÃ nh : HoÃ ng vÄƒn BÃ¡nh'),
(62, 27, '2017-10-01 04:08:18', 'sá»­a khÃ¡ch hÃ ng: Há»“ Sá»¹ KiÃªn thÃ nh : Há»“ Sá»¹ KiÃªn'),
(63, 27, '2017-10-01 04:27:09', 'thÃªm khÃ¡ch hÃ ng: Ä‘Ã n guitar');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id_NV` int(20) NOT NULL,
  `ten_NV` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sdt_NV` int(20) NOT NULL,
  `email_NV` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mcnd_NV` int(40) NOT NULL,
  `diachi_NV` text COLLATE utf8_unicode_ci NOT NULL,
  `ttthem_NV` text COLLATE utf8_unicode_ci NOT NULL,
  `loai_user` int(4) NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1234567',
  `avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`id_NV`, `ten_NV`, `sdt_NV`, `email_NV`, `mcnd_NV`, `diachi_NV`, `ttthem_NV`, `loai_user`, `password`, `avatar`) VALUES
(26, 'TrÆ°á»ng giang', 913456789, 'truonggiang@gmail.co', 0, 'hoc', 'hohadeerf', 0, '1234567', ''),
(27, 'admin', 123456789, 'admin@gmail.com', 123456789, 'Ho Chi Minh', 'Nhan vien moi', 1, '1234567', ''),
(28, 'Nguyá»n HÃ¹ng CÆ°á»', 123123123, 'cuong@gmail.com', 12345678, 'há»“ chÃ­ minh', 'hÃ² chÃ­ minh', 0, '1234567', '');

-- --------------------------------------------------------

--
-- Table structure for table `tiendo`
--

CREATE TABLE `tiendo` (
  `id_tiendo` int(11) NOT NULL,
  `id_KH` int(11) NOT NULL,
  `id_NV` int(11) NOT NULL,
  `tuong_tac` text COLLATE utf8_unicode_ci,
  `phan_hoi` text COLLATE utf8_unicode_ci,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tiendo`
--

INSERT INTO `tiendo` (`id_tiendo`, `id_KH`, `id_NV`, `tuong_tac`, `phan_hoi`, `date`) VALUES
(42, 26, 26, 'Mua nhÃ  ', 'mua nhÃ ', '2017-10-01 03:33:37'),
(43, 28, 26, 'aggag', 'ÄƒgÄƒgÄƒ', '2017-10-01 04:25:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ChamSocKhacHang`
--
ALTER TABLE `ChamSocKhacHang`
  ADD PRIMARY KEY (`id_cskh`),
  ADD KEY `daxem` (`daxem`);

--
-- Indexes for table `csMoiNhat`
--
ALTER TABLE `csMoiNhat`
  ADD PRIMARY KEY (`id_moinhat`),
  ADD KEY `id_KH` (`id_KH`),
  ADD KEY `id_NV` (`id_NV`);

--
-- Indexes for table `Hang`
--
ALTER TABLE `Hang`
  ADD PRIMARY KEY (`id_hang`);

--
-- Indexes for table `khachChot`
--
ALTER TABLE `khachChot`
  ADD PRIMARY KEY (`idChot`),
  ADD KEY `id_NV` (`ten_NV`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id_KH`),
  ADD KEY `idLoaikhachhang` (`loaikhach`);

--
-- Indexes for table `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id_NV`),
  ADD UNIQUE KEY `email_NV` (`email_NV`);

--
-- Indexes for table `tiendo`
--
ALTER TABLE `tiendo`
  ADD PRIMARY KEY (`id_tiendo`),
  ADD KEY `id_KH` (`id_KH`),
  ADD KEY `id_NV` (`id_NV`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ChamSocKhacHang`
--
ALTER TABLE `ChamSocKhacHang`
  MODIFY `id_cskh` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `csMoiNhat`
--
ALTER TABLE `csMoiNhat`
  MODIFY `id_moinhat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Hang`
--
ALTER TABLE `Hang`
  MODIFY `id_hang` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `khachChot`
--
ALTER TABLE `khachChot`
  MODIFY `idChot` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id_KH` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `Log`
--
ALTER TABLE `Log`
  MODIFY `id_log` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id_NV` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tiendo`
--
ALTER TABLE `tiendo`
  MODIFY `id_tiendo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
