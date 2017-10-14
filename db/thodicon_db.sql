-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql06.dotvndns.vn:3306
-- Generation Time: Oct 02, 2017 at 02:53 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thodicon_db`
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
  `daxem` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ChamSocKhacHang`
--

INSERT INTO `ChamSocKhacHang` (`id_cskh`, `id_NV`, `id_KH`, `ngay`, `daxem`) VALUES
(89, 35, 26, '2017-09-30 15:33:32', 0),
(90, 35, 27, '2017-09-30 15:48:29', 1),
(91, 31, 28, '2017-09-30 22:21:09', 1),
(92, 37, 29, '2017-10-01 21:31:20', 1),
(93, 37, 30, '2017-10-01 21:33:04', 1),
(94, 37, 31, '2017-10-01 21:33:56', 1),
(95, 31, 32, '2017-10-02 12:05:52', 1),
(96, 34, 33, '2017-10-02 12:07:44', 1),
(97, 32, 34, '2017-10-02 12:09:30', 0),
(98, 34, 35, '2017-10-02 12:10:38', 1),
(99, 32, 36, '2017-10-02 12:11:09', 0);

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
(3, 29, 37, 'sfsafsa', 'fsafsaf', '2017-10-01 21:32:19'),
(4, 30, 37, 'dsgdsg', 'sdgsdgsdg', '2017-10-01 21:33:24'),
(5, 31, 37, 'sáº§', 'Ã asf', '2017-10-01 21:34:16');

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
  `id_NV` int(11) NOT NULL,
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
  `id_NV` int(11) DEFAULT NULL,
  `cs` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id_KH`, `ten_KH`, `sdt_KH`, `email_KH`, `diachi_KH`, `ttthem_KH`, `ngay_them`, `loaikhach`, `id_NV`, `cs`) VALUES
(8, 'Há»“ Sá»¹ KiÃªn', 913765563, 'hokien07@gmail.com', 'Nghá»‡ amn', 'kháº­pfgjáº±g', '2017-09-21 19:10:39', 4, 28, 0),
(27, 'A.SÆ¡n', 987862586, '1@a', '', '', '2017-09-30 15:48:29', 2, 32, 0),
(28, 'khÃ¡ch tÆ° thÃªm', 913765563, 'a@gmail.com', 'hoahah', 'Ã avÃ¢r', '2017-09-30 22:21:09', 0, 31, 0),
(29, 'test phÃ¡t nÃ o', 0, 'gjhgb@jhkjh.hn', 'test phÃ¡t nÃ o', 'test phÃ¡t nÃ o', '2017-10-01 21:31:20', 0, 35, 1),
(30, 'Ã asf', 2147483647, 'fdgsdgs@gsdgsd.gdg', 'gsdgsdg', 'dsgsdg', '2017-10-01 21:33:04', 1, 35, 1),
(31, 'fsafasf', 0, 'fasfas@dfasf.dgd', 'fasfas@dfasf.dgd', 'fasfas@dfasf.dgd', '2017-10-01 21:33:56', 0, 37, 1),
(32, '122E4WQ', 909, 'AS@XS', 'hÃ€ ná»˜I', 'VD', '2017-10-02 12:05:52', 1, 35, 0),
(33, 'DJBV', 909, 'V@D', 'HaÌ€ NÃ´Ì£i', 'VDV', '2017-10-02 12:07:44', 0, 35, 0),
(34, 'vcbvc', 8768967, 'dsfs@fdf', 'HaÌ€ NÃ´Ì£i', 'bcbvc', '2017-10-02 12:09:30', 2, 35, 0),
(35, 'gasdgagawergawerfg', 2147483647, 'fgasgvaergawer@dfgawdw', 'awgawfgawer', 'awrgawergserg', '2017-10-02 12:10:38', 1, 30, 0),
(36, 'ngngngsgbndfgbdfbndfhndhmyj', 2147483647, 'sfghsgrhserthaet@shsghb', 'sghsdhsdjjkdty', 'srjhdrtjhdfgh', '2017-10-02 12:11:09', 0, 30, 0);

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
(53, 30, '2017-09-30 14:05:11', 'thÃªm nhÃ¢n viÃªn: QuÃ¢n'),
(54, 30, '2017-09-30 14:06:18', 'thÃªm nhÃ¢n viÃªn: NhÃ¢n ViÃªn 1'),
(55, 30, '2017-09-30 14:07:02', 'thÃªm nhÃ¢n viÃªn: nhÃ¢n viÃªn 3'),
(56, 30, '2017-09-30 14:08:08', 'sá»­a nhÃ¢n viÃªn: nhÃ¢n viÃªn 3 thÃ nh : nhÃ¢n viÃªn 3'),
(57, 30, '2017-09-30 14:09:22', 'sá»­a nhÃ¢n viÃªn: nhÃ¢n viÃªn 3 thÃ nh : nhÃ¢n viÃªn 3'),
(58, 30, '2017-09-30 14:10:08', 'thÃªm nhÃ¢n viÃªn: NhÃ¢n viÃªn 3'),
(59, 30, '2017-09-30 14:13:10', 'thÃªm nhÃ¢n viÃªn: quáº£n lÃ½'),
(60, 35, '2017-09-30 15:30:55', 'sá»­a nhÃ¢n viÃªn: QuÃ¢n thÃ nh : TRáº¦N Máº NH QUÃ‚N'),
(61, 35, '2017-09-30 15:31:37', 'sá»­a nhÃ¢n viÃªn: NhÃ¢n ViÃªn 1 thÃ nh : VÅ¨ QUANG Äá»¨C'),
(62, 35, '2017-09-30 15:32:20', 'sá»­a nhÃ¢n viÃªn: NhÃ¢n viÃªn 3 thÃ nh : VÅ¨ HUYá»€N MY'),
(63, 35, '2017-09-30 15:33:32', 'thÃªm khÃ¡ch hÃ ng: A.SÆ¡n'),
(64, 30, '2017-09-30 15:39:28', 'xÃ³a khÃ¡ch hÃ ng: A.SÆ¡n'),
(65, 35, '2017-09-30 15:48:29', 'thÃªm khÃ¡ch hÃ ng: A.SÆ¡n'),
(66, 30, '2017-09-30 15:49:33', 'sá»­a khÃ¡ch hÃ ng: A.SÆ¡n thÃ nh : A.SÆ¡n'),
(67, 30, '2017-09-30 16:22:34', 'sá»­a khÃ¡ch hÃ ng: A.SÆ¡n thÃ nh : A.SÆ¡n'),
(68, 31, '2017-09-30 22:21:09', 'thÃªm khÃ¡ch hÃ ng: khÃ¡ch tÆ° thÃªm'),
(69, 35, '2017-10-01 21:30:50', 'thÃªm nhÃ¢n viÃªn: nhanvien1@gmail.com'),
(70, 35, '2017-10-01 21:31:20', 'thÃªm khÃ¡ch hÃ ng: test phÃ¡t nÃ o'),
(71, 35, '2017-10-01 21:33:04', 'thÃªm khÃ¡ch hÃ ng: Ã asf'),
(72, 37, '2017-10-01 21:33:56', 'thÃªm khÃ¡ch hÃ ng: fsafasf'),
(73, 35, '2017-10-02 12:05:52', 'thÃªm khÃ¡ch hÃ ng: 122E4WQ'),
(74, 35, '2017-10-02 12:07:44', 'thÃªm khÃ¡ch hÃ ng: DJBV'),
(75, 35, '2017-10-02 12:09:30', 'thÃªm khÃ¡ch hÃ ng: vcbvc'),
(76, 30, '2017-10-02 12:10:38', 'thÃªm khÃ¡ch hÃ ng: gasdgagawergawerfg'),
(77, 30, '2017-10-02 12:11:09', 'thÃªm khÃ¡ch hÃ ng: ngngngsgbndfgbdfbndfhndhmyj');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id_NV` int(20) NOT NULL,
  `ten_NV` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sdt_NV` int(20) NOT NULL,
  `email_NV` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
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
(30, 'admin', 913765563, 'hokien07@gmail.com', 187356296, 'Quỳnh Lâm, Quỳnh Lưu, Nghệ An', 'Thiết kế phần mềm, cập nhật và chỉnh sửa phần mềm', 1, '057223555002bc36360ddd30f6bcb0c7', '195926659959cf41d0745099.15399606.jpg'),
(31, 'TRáº¦N Máº NH QUÃ‚N', 961088680, 'quantm2108@gmail.com', 2147483647, 'HÃ  Ná»™i', 'NV', 0, '1234567', ''),
(32, 'VÅ¨ QUANG Äá»¨C', 916630792, 'vqd307@gmail.com', 2147483647, 'HÃ  Ná»™i', 'NV', 0, '1234567', ''),
(34, 'VÅ¨ HUYá»€N MY', 904442930, 'miffyz.7992@gmail.com', 2147483647, 'HÃ  Ná»™i', 'NV', 0, '1234567', ''),
(35, 'quáº£n lÃ½', 867654451, 'quanly@gmail.com', 2147483647, 'há»“ chÃ­ minh', 'há»“ chÃ­ minh', 1, '1234567', ''),
(37, 'nhanvien1@gmail.com', 0, 'nhanvien1@gmail.com', 1269852, 'nhanvien1@gmail.com', 'nhanvien1@gmail.com', 0, '1234567', '');

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
(39, 29, 37, 'sfsafsa', 'fsafsaf', '2017-10-01 21:32:19'),
(40, 30, 37, 'dsgdsg', 'sdgsdgsdg', '2017-10-01 21:33:24'),
(41, 31, 37, 'sáº§', 'Ã asf', '2017-10-01 21:34:16');

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
  MODIFY `id_cskh` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `csMoiNhat`
--
ALTER TABLE `csMoiNhat`
  MODIFY `id_moinhat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Hang`
--
ALTER TABLE `Hang`
  MODIFY `id_hang` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `khachChot`
--
ALTER TABLE `khachChot`
  MODIFY `idChot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id_KH` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `Log`
--
ALTER TABLE `Log`
  MODIFY `id_log` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id_NV` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tiendo`
--
ALTER TABLE `tiendo`
  MODIFY `id_tiendo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
