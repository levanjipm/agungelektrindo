-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2019 at 10:48 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agungelektrindo`
--

-- --------------------------------------------------------

--
-- Table structure for table `absentee_list`
--

CREATE TABLE `absentee_list` (
  `ID` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absentee_list`
--

INSERT INTO `absentee_list` (`ID`, `user_id`, `time`, `date`) VALUES
(1, 2, '12:41:02', '2019-02-16'),
(2, 3, '12:42:04', '2019-02-16'),
(3, 3, '12:42:43', '2019-02-16'),
(4, 3, '12:43:20', '2019-02-16');

-- --------------------------------------------------------

--
-- Table structure for table `code_delivery_order`
--

CREATE TABLE `code_delivery_order` (
  `id` int(255) NOT NULL,
  `date` date NOT NULL,
  `number` varchar(20) NOT NULL,
  `tax` tinyint(1) NOT NULL,
  `name` varchar(30) NOT NULL,
  `customer_id` int(255) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `isdelete` tinyint(1) NOT NULL DEFAULT '0',
  `so_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code_delivery_order`
--

INSERT INTO `code_delivery_order` (`id`, `date`, `number`, `tax`, `name`, `customer_id`, `sent`, `isdelete`, `so_id`) VALUES
(1, '2019-02-17', '1', 1, '', 3, 0, 0, 0),
(2, '2019-02-17', '2', 0, '1\"', 3, 0, 0, 0),
(3, '2019-02-17', '3', 0, '1\"', 3, 0, 0, 0),
(4, '2019-02-17', '3', 0, '1\"', 3, 0, 0, 0),
(5, '2019-02-17', '3', 0, '1\"', 3, 0, 0, 0),
(6, '2019-02-17', '3', 0, '1\"', 3, 0, 0, 0),
(7, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(8, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(9, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(10, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(11, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(12, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(13, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(14, '2019-02-17', '4', 0, '1\"', 3, 0, 0, 0),
(15, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 0),
(16, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 0),
(17, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 0),
(18, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 0),
(19, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 0),
(20, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(21, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(22, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(23, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(24, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(25, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(26, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(27, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(28, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(29, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(30, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(31, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1),
(32, '2019-02-17', '4', 1, 'SJ-AE-04P.17-II-19', 3, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `code_purchaseorder`
--

CREATE TABLE `code_purchaseorder` (
  `id` int(255) NOT NULL,
  `name` varchar(40) NOT NULL,
  `supplier_id` int(255) NOT NULL,
  `date` date NOT NULL,
  `top` int(11) NOT NULL,
  `value` int(255) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `promo_code` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `code_quotation`
--

CREATE TABLE `code_quotation` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `customer_id` int(255) NOT NULL,
  `date` date NOT NULL,
  `value` int(255) NOT NULL,
  `payment_id` int(20) NOT NULL,
  `down_payment` int(255) NOT NULL,
  `repayment` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code_quotation`
--

INSERT INTO `code_quotation` (`id`, `name`, `customer_id`, `date`, `value`, `payment_id`, `down_payment`, `repayment`, `note`) VALUES
(46, 'Q-AE-01.03-II-19', 6, '2019-02-03', 54229800, 3, 0, 45, '											'),
(47, 'Q-AE-02.03-II-19', 1, '2019-02-03', 15222000, 3, 0, 30, '											'),
(48, 'Q-AE-02.03-II-19', 1, '2019-02-03', 15222000, 3, 0, 30, '											'),
(49, 'Q-AE-04.03-II-19', 3, '2019-02-03', 3000000, 3, 0, 30, '											'),
(50, 'Q-AE-05.04-II-19', 12, '2019-02-04', 5270430, 3, 0, 45, '											'),
(51, 'Q-AE-06.04-II-19', 3, '2019-02-04', 9000000, 3, 0, 30, '											'),
(52, 'Q-AE-07.09-II-19', 29, '2019-02-09', 128263063, 3, 0, 30, '											'),
(53, 'Q-AE-08.09-II-19', 29, '2019-02-09', 47662739, 3, 0, 30, '											'),
(54, 'Q-AE-09.09-II-19', 29, '2019-02-09', 57529258, 3, 0, 30, '											'),
(55, 'Q-AE-10.11-II-19', 26, '2019-02-11', 1448558, 3, 0, 30, '											'),
(56, 'Q-AE-11.11-II-19', 1, '2019-02-11', 783970, 3, 0, 30, '											'),
(57, 'Q-AE-12.11-II-19', 30, '2019-02-11', 1082400, 3, 0, 30, '											'),
(58, 'Q-AE-13.11-II-19', 14, '2019-02-11', 255738640, 3, 0, 30, '						Harga belum termasuk dengan ongkos kerja serta material bantu lainnya.					'),
(59, 'Q-AE-14.11-II-19', 14, '2019-02-11', 323920065, 3, 0, 30, '						Harga belum termasuk dengan jasa pemasangan dan aksesoris lainnya					'),
(60, 'Q-AE-15.11-II-19', 14, '2019-02-11', 78057249, 3, 0, 30, '						Harga di atas belum termasuk dengan jasa pemasangan dan material bantu lain					'),
(61, 'Q-AE-16.11-II-19', 14, '2019-02-11', 65990855, 3, 0, 30, '											'),
(62, 'Q-AE-17.11-II-19', 14, '2019-02-11', 14815274, 3, 0, 30, '											'),
(63, 'Q-AE-18.11-II-19', 14, '2019-02-11', 6697742, 3, 0, 30, '											'),
(64, 'Q-AE-19.11-II-19', 14, '2019-02-11', 6346741, 3, 0, 30, '											'),
(65, 'Q-AE-20.11-II-19', 14, '2019-02-11', 642061223, 3, 0, 30, '											'),
(66, 'Q-AE-21.11-II-19', 14, '2019-02-11', 8938384, 3, 0, 30, '											'),
(67, 'Q-AE-22.11-II-19', 14, '2019-02-11', 228911392, 3, 0, 30, '											'),
(68, 'Q-AE-23.11-II-19', 14, '2019-02-11', 85000000, 1, 0, 0, '											'),
(69, 'Q-AE-24.11-II-19', 13, '2019-02-11', 682220, 3, 0, 30, '											'),
(70, 'Q-AE-25.12-II-19', 29, '2019-02-12', 1716906317, 3, 0, 0, '											'),
(71, 'Q-AE-26.13-II-19', 18, '2019-02-13', 128700, 3, 0, 30, '											'),
(72, 'Q-AE-27.13-II-19', 31, '2019-02-13', 538368, 3, 0, 30, '											'),
(73, 'Q-AE-28.13-II-19', 32, '2019-02-13', 2147483647, 4, 30, 0, '											'),
(74, 'Q-AE-29.14-II-19', 31, '2019-02-14', 2662660, 3, 0, 30, '											'),
(75, 'Q-AE-30.15-II-19', 12, '2019-02-15', 1422960, 3, 0, 30, '											'),
(76, 'Q-AE-31.15-II-19', 33, '2019-02-15', 1472647, 3, 0, 30, '											'),
(77, 'Q-AE-32.16-II-19', 25, '2019-02-16', 10097208, 3, 0, 45, '											'),
(78, 'Q-AE-33.16-II-19', 15, '2019-02-16', 48501400, 3, 0, 30, '											'),
(79, '', 0, '0000-00-00', 0, 0, 0, 0, ''),
(80, 'Q-AE-34.18-II-19', 5, '2019-02-18', 183250000, 3, 0, 3, '											'),
(81, 'Q-AE-35.18-II-19', 29, '2019-02-18', 20020373, 3, 0, 30, '											'),
(82, 'Q-AE-36.18-II-19', 3, '2019-02-18', 780755874, 3, 0, 30, '											');

-- --------------------------------------------------------

--
-- Table structure for table `code_salesorder`
--

CREATE TABLE `code_salesorder` (
  `id` int(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `po_number` varchar(50) NOT NULL,
  `taxing` tinyint(1) NOT NULL,
  `customer_id` int(255) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `value` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `code_salesorder`
--

INSERT INTO `code_salesorder` (`id`, `name`, `date`, `po_number`, `taxing`, `customer_id`, `delivery_id`, `value`) VALUES
(1, '1902-SO-001', '2019-02-17', '', 1, 3, 7, 23000000);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `npwp` varchar(20) NOT NULL,
  `city` text NOT NULL,
  `prefix` text NOT NULL,
  `pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`, `phone`, `npwp`, `city`, `prefix`, `pic`) VALUES
(1, 'PT Mitracool Jaya Utama', 'Jalan Indramayu Blok 000 no.45, RT000, RW000', '022-60842371/022-721', '02.204.095.0-429.000', 'Bandung', 'Ibu', 'Sani Angraeni'),
(2, 'PT Mentari Gemilang Perdana Sentosa', 'Jalan Raya Paseban Blok 000 no.1B, RT000, RW000', '021-3153888', '01.859.814.4-032.000', 'Jakarta Barat', 'Bapak', 'Keefvin Sastraaminata'),
(3, 'PT Kahatex', 'Jalan Raya Rancaekek KM6 Blok 000 no.000, RT000, RW000', '022-27798051', '01.104.586.1-092.000', 'Bandung', 'Ibu', 'Margaretha Liana'),
(4, 'PT Sahabat Mitra Jaya', 'Jalan Boulevard Raya Grand Galaxy City Blok RSN I no.53, RT000, RW000', '021-82742227', '80.912.736.8-432.000', 'Bekasi', 'Ibu', 'Paskah Ria'),
(5, 'PT Mathar Telekomunikasi Indonesia', 'Jalan Cingised Komplek Griya Caraka Blok AA no.32, RT001, RW005', '022-87881504', '02.203.924.2-429.000', 'Bandung', 'Bapak', 'H. Arief'),
(6, 'PT Mugirahayu Sentosa', 'Jalan Alamanda Komplek Griya Caraka Blok A5 no.76, RT000, RW000', '0231-8493500', '02.447.793.7-426.000', 'Cirebon', 'Bapak', 'Sumardi'),
(7, 'CV Surya Elektrik', 'Sangkuriang Blok 000 no.76, RT000, RW000', '022-6650986', '01.240.382.0-421.000', 'Cimahi', '', ''),
(8, 'PT Wahana Kreasi Teknik', 'Jalan Kiaracondong gg Samsi II Blok 000 no.22, RT001, RW001', '022-7271395', '84.212.084.2-424.000', 'Bandung', '', ''),
(9, 'PT Lucy Elektrik Djaya', 'Jalan H. Kurdi I Blok 000 no.14, RT000, RW000', '022-5206600', '80.351.967.7-422.000', 'Bandung', 'Bapak', 'Wawan Irawan'),
(10, 'CV Anugrah Jaya Elektrindo', 'Jalan Otto Iskandar Dinata Blok 000 no.38, RT000, RW000', '022-4231572', '00.000.000.0-000.000', 'Bandung', '', ''),
(11, 'PT Padi Hijau Buana', 'Thamrin Square Jalan MH.Thamrin Blok C no.6, RT000, RW000', '022-2019251', '01.713.741.5-431.000', 'Cikarang', '', ''),
(12, 'PT Hen Jaya', 'Jalan H.Kurdi Blok 1 no.14, RT005, RW001', '022-5206600', '02.366.495.6-422.000', 'Bandung', '', ''),
(13, 'PT Bandung Sakura Textile Mills', 'Jalan Raya Dayeuh Kolot Blok 000 no.33, RT002, RW007', '022-5205888', '01.104.698.4-441.000', 'Bandung', '', ''),
(14, 'PT Karya Putra Sangkuriang', 'Jalan Raya Cipacing Km.20 Blok 000 no.000, RT000, RW000', '022-7796345', '01.421.870.5-441.000', 'Sumedang', '', ''),
(15, 'CV Karunia Abadi', 'Jalan ABC Komplek Cikapundung Electronic Center Lantai 1 Blok EE-25 no.000, RT000, RW000', '081-2211-5405', '82.233.773.9-423.000', 'Bandung', '', ''),
(16, 'PT Tri Sumber Elektrika', 'Jalan Sutawinangun gg Tulus Blok 000 no.035, RT001, RW006', '0231-209741', '02.447.968.5-426.000', 'Cirebon', '', ''),
(17, 'PT Teguh Jaya Pranata', 'Jalan Mengger Blok 000 no.99, RT001, RW007', '022-5203126', '01.465.527.8-441.000', 'Bandung', '', ''),
(18, 'PT Sinar Jaya Rimbawan Asri', 'Jalan Soekarno Hatta Blok 000 no.835, RT000, RW000', '022-7800391', '...-.', 'Bandung', '', ''),
(19, 'PT Wahana Teknik Indonesia', 'Jalan Kiaracondong gg Samsi II Blok 000 no.22, RT001, RW001', '022-7271395', '02.023.953.9-424.000', 'Bandung', '', ''),
(20, 'CV Karunia Hidup Teknik', 'Jalan Banceuy Blok 000 no.031, RT004, RW002', '022-4231286', '80.625.835.6-423.000', 'Bandung', '', ''),
(21, 'PT Namasindo Plas', 'Kp. Cangkorah Blok 000 no.007, RT007, RW001', '022-6867068/022-6867', '02.011.944.2-441.000', 'Bandung', '', ''),
(22, 'PT Kurnia Abadi Padang', 'Komplek Pola Mas Blok C no.17, RT004, RW000', '0751-35569/0751-3169', '01.714.605.1-201.000', 'Padang', '', ''),
(23, 'Toko Sumber Lampu', 'Komplek IBCC Blok B-1 no.3-9, RT000, RW000', '022-7233271', '...-.', 'Bandung', '', ''),
(24, 'Toyo Teknik', 'Jalan Soekarno Hatta Km.13,8 Blok 000 no.D5, RT000, RW000', '022-7834607', '07.141.137.5-429.000', 'Bandung', '', ''),
(25, 'Toko Agni Surya', 'Jalan A.Yani Blok 000 no.353, RT000, RW000', '022-7273893', '...-.', 'Bandung', '', ''),
(26, 'PT Sinar Mulia Plasindo Lestari', 'Jalan Cicukang Holis Blok 000 no.22, RT000, RW000', '022-6030672', '01.772.511.0-441.000', 'Bandung', '', ''),
(27, 'PT Tritunggal Swarna', 'Jalan Tamblong Blok 000 no.2, RT000, RW000', '', '21.073.608.8-423.000', 'Bandung', 'Ibu', 'Eri Mayasari'),
(28, 'PT Kurnia Abadi Padang', 'Komplek Pulo Mas Blok C no.17, RT004, RW000', '(0751)35569', '01.714.605.1-201.000', 'Padang', 'Ibu', 'Suci Noverina Misri'),
(29, 'PT Pajajaran Internusa Tekstil', 'Jalan Kebon Jati Blok Kav. B-4 no.88, RT000, RW000', '', '01.778.288.9-428.000', 'Bandung', 'Bapak', 'Khanan'),
(30, 'Toko Sarana Abadi', 'Jalan Sukamaju Ruko Gondangdia Residence Blok 000 no.A3, RT000, RW000', '(022)87883454', '...-.', 'Bandung', 'Bapak', ''),
(31, 'PT Royal Abadi Sejahtera', 'Jalan Raya Cimareme Blok 000 no.275, RT000, RW000', '(022)6866360#132', '01.455.909.0-441.000', 'Bandung', 'Ibu', 'Retno Tyas'),
(32, 'PT Hariff Power Services', 'Jalan A. H. Nasution Blok 000 no.80, RT000, RW000', '', '02.519.152.9-424.000', 'Bandung', 'Bapak', 'Mufti Pitriadi'),
(33, 'PT Total Inpro Multitech', 'Jalan Letjen Suprapto Ruko Mega Grosir Cempaka Mas Blok G no.10, RT001, RW003', '(021)42883851', '21.050.975.8-048.000', 'Jakarta Pusat', 'Ibu', 'Gita Eda');

-- --------------------------------------------------------

--
-- Table structure for table `customer_deliveryaddress`
--

CREATE TABLE `customer_deliveryaddress` (
  `id` int(11) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `city` varchar(250) NOT NULL,
  `customer_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_deliveryaddress`
--

INSERT INTO `customer_deliveryaddress` (`id`, `address`, `city`, `customer_id`) VALUES
(5, 'Jalan Indramayu Blok 000 no.45, RT000, RW000', 'Bandung', 1),
(6, 'Jalan Raya Paseban Blok 000 no.1B, RT000, RW000', 'Jakarta Barat', 2),
(7, 'Jalan Raya Rancaekek KM6 Blok 000 no.000, RT000, RW000', 'Bandung', 3),
(8, 'Jalan Boulevard Raya Grand Galaxy City Blok RSN I no.53, RT000, RW000', 'Bekasi', 4),
(9, 'Jalan Cingised Komplek Griya Caraka Blok AA no.32, RT001, RW005', 'Bandung', 5),
(10, 'Jalan Alamanda Komplek Griya Caraka Blok A5 no.76, RT000, RW000', 'Cirebon', 6),
(11, 'Sangkuriang Blok 000 no.76, RT000, RW000', 'Cimahi', 7),
(12, 'Jalan Kiaracondong gg Samsi II Blok 000 no.22, RT001, RW001', 'Bandung', 8),
(13, 'Jalan H. Kurdi I Blok 000 no.14, RT000, RW000', 'Bandung', 9),
(14, 'Jalan Otto Iskandar Dinata Blok 000 no.38, RT000, RW000', 'Bandung', 10),
(15, 'Thamrin Square Jalan MH.Thamrin Blok C no.6, RT000, RW000', 'Cikarang', 11),
(16, 'Jalan H.Kurdi Blok 1 no.14, RT005, RW001', 'Bandung', 12),
(17, 'Jalan Raya Dayeuh Kolot Blok 000 no.33, RT002, RW007', 'Bandung', 13),
(18, 'Jalan Raya Cipacing Km.20 Blok 000 no.000, RT000, RW000', 'Sumedang', 14),
(19, 'Jalan ABC Komplek Cikapundung Electronic Center Lantai 1 Blok EE-25 no.000, RT000, RW000', 'Bandung', 15),
(20, 'Jalan Sutawinangun gg Tulus Blok 000 no.035, RT001, RW006', 'Cirebon', 16),
(21, 'Jalan Mengger Blok 000 no.99, RT001, RW007', 'Bandung', 17),
(22, 'Jalan Soekarno Hatta Blok 000 no.835, RT000, RW000', 'Bandung', 18),
(23, 'Jalan Kiaracondong gg Samsi II Blok 000 no.22, RT001, RW001', 'Bandung', 19),
(24, 'Jalan Banceuy Blok 000 no.031, RT004, RW002', 'Bandung', 20),
(25, 'Kp. Cangkorah Blok 000 no.007, RT007, RW001', 'Bandung', 21),
(26, 'Komplek Pola Mas Blok C no.17, RT004, RW000', 'Padang', 22),
(27, 'Komplek IBCC Blok B-1 no.3-9, RT000, RW000', 'Bandung', 23),
(28, 'Jalan Soekarno Hatta Km.13,8 Blok 000 no.D5, RT000, RW000', 'Bandung', 24),
(29, 'Jalan A.Yani Blok 000 no.353, RT000, RW000', 'Bandung', 25),
(30, 'Jalan Cicukang Holis Blok 000 no.22, RT000, RW000', 'Bandung', 26),
(31, 'Jalan Tamblong Blok 000 no.2, RT000, RW000', 'Bandung', 27),
(32, 'Jalan Unpar II Blok 000 no.12, RT003, RW007', 'Bandung', 11),
(33, ' Blok  no., RT, RW', '', 0),
(34, ' Blok  no., RT, RW', '', 0),
(35, ' Blok  no., RT, RW', '', 0),
(36, ' Blok  no., RT, RW', '', 0),
(37, ' Blok  no., RT, RW', '', 0),
(38, 'Jalan Sukamenak Blok 000 no.143B, RT001, RW003', 'Bandung', 27);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_address`
--

CREATE TABLE `delivery_address` (
  `id` int(255) NOT NULL,
  `tag` text NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_address`
--

INSERT INTO `delivery_address` (`id`, `tag`, `address`, `city`) VALUES
(1, 'Office', 'Jalan Jamuju Blok 000 no.18, RT005, RW006', 'Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order`
--

CREATE TABLE `delivery_order` (
  `id` int(255) NOT NULL,
  `reference` varchar(200) NOT NULL,
  `quantity` int(255) NOT NULL,
  `do_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_order`
--

INSERT INTO `delivery_order` (`id`, `reference`, `quantity`, `do_id`) VALUES
(1, '', 5, 0),
(2, '', 5, 0),
(3, '', 5, 0),
(4, '', 5, 0),
(5, '', 5, 0),
(6, 'LV432876', 5, 0),
(7, 'LV432876', 5, 0),
(8, 'LV432876', 2, 0),
(9, 'LV432876', 2, 0),
(10, 'LV432876', 2, 0),
(11, 'LV432876', 2, 0),
(12, 'LV432876', 2, 0),
(13, 'LV432876', 2, 0),
(14, 'LV432876', 2, 15),
(15, 'LV432876', 2, 16),
(16, 'A9K14110', 2, 16),
(17, 'LV432876', 2, 17),
(18, 'A9K14110', 2, 17),
(19, 'LV432876', 2, 18),
(20, 'A9K14110', 2, 18),
(21, 'LV432876', 2, 19),
(22, 'A9K14110', 2, 19),
(23, 'LV432876', 2, 20),
(24, 'A9K14110', 2, 20),
(25, 'LV432876', 2, 21),
(26, 'A9K14110', 2, 21),
(27, 'LV432876', 5, 22),
(28, 'A9K14110', 6, 22),
(29, 'LV432876', 5, 23),
(30, 'A9K14110', 6, 23),
(31, 'LV432876', 10, 24),
(32, 'A9K14110', 10, 24),
(33, 'LV432876', 10, 25),
(34, 'A9K14110', 10, 25),
(35, 'LV432876', 10, 26),
(36, 'A9K14110', 10, 26),
(37, 'LV432876', 10, 27),
(38, 'A9K14110', 5, 27),
(39, 'LV432876', 10, 28),
(40, 'A9K14110', 5, 28),
(41, 'LV432876', 5, 29),
(42, 'A9K14110', 5, 29),
(43, 'LV432876', 5, 30),
(44, 'A9K14110', 5, 30),
(45, 'LV432876', 5, 31),
(46, 'A9K14110', 5, 31),
(47, 'LV432876', 5, 32),
(48, 'A9K14110', 5, 32);

-- --------------------------------------------------------

--
-- Table structure for table `itemlist`
--

CREATE TABLE `itemlist` (
  `id` int(200) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemlist`
--

INSERT INTO `itemlist` (`id`, `reference`, `description`) VALUES
(1, 'A9K14106', 'MCB 1P 6A iK60A'),
(2, 'A9K14110', 'MCB 1P 10A iK60A'),
(3, 'A9K14116', 'MCB 1P 16A iK60A'),
(4, 'A9K14120', 'MCB 1P 20A iK60A'),
(5, 'A9K14125', 'MCB 1P 25A iK60A'),
(6, 'A9K14132', 'MCB 1P 32A iK60A'),
(7, 'A9K14306', 'MCB 3P 6A iK60A'),
(8, 'A9K14310', 'MCB 3P 10A iK60A'),
(9, 'A9K14316', 'MCB 3P 16A IK60A'),
(10, 'A9K14320', 'MCB 3P 20A iK60A'),
(11, 'A9K14325', 'MCB 3P 25A iK60A'),
(12, 'A9K14332', 'MCB 3P 32A iK60A'),
(13, 'A9K24102', 'MCB 1P 2A iK60N'),
(14, 'A9K24104', 'MCB 1P 4A iK60N'),
(15, 'A9K27106', 'MCB 1P 6A iK60N'),
(16, 'A9K27110', 'MCB 1P 10A iK60N'),
(17, 'A9K27116', 'MCB 1P 16A iK60N'),
(18, 'A9K27120', 'MCB 1P 20A iK60N'),
(19, 'A9K27125', 'MCB 1P 25A iK60N'),
(20, 'A9K27132', 'MCB 1P 32A iK60N'),
(21, 'A9K24140', 'MCB 1P 40A iK60N'),
(22, 'A9K27206', 'MCB 2P 6A iK60N'),
(23, 'A9K27210', 'MCB 2P 10A iK60N'),
(24, 'A9K27216', 'MCB 2P 16A iK60N'),
(25, 'A9K27220', 'MCB 2P 20A iK60N'),
(26, 'A9K27225', 'MCB 2P 25A - iK60N'),
(27, 'A9K27232', 'MCB 2P 32A iK60N'),
(28, 'A9K24240', 'MCB 2P 40A iK60N'),
(29, 'A9K24306', 'MCB 3P 6A iK60N'),
(30, 'A9K24310', 'MCB 3P 10A iK60N'),
(31, 'A9K24316', 'MCB 3P 16A iK60N'),
(32, 'A9K24320', 'MCB 3P 20A iK60N'),
(33, 'A9K24325', 'MCB 3P 25A iK60N'),
(34, 'A9K24332', 'MCB 3P 32A iK60N'),
(35, 'A9K24340', 'MCB 3P 40A iK60N'),
(36, 'A9K24406', 'MCB 4P 6A iK60N'),
(37, 'A9K24410', 'MCB 4P 10A iK60N'),
(38, 'A9K24416', 'MCB 4P 16A iK60N'),
(39, 'A9K24420', 'MCB 4P 20A iK60N'),
(40, 'A9K24425', 'MCB 4P 25A iK60N'),
(41, 'A9K24432', 'MCB 4P 32A iK60N'),
(42, 'A9K24440', 'MCB 4P 40A iK60N'),
(45, 'A9F74101', 'MCB 1P 1A iC60N'),
(46, 'A9F74102', 'MCB 1P 2A iC60N'),
(47, 'A9F74104', 'MCB 1P 4A iC60N'),
(48, 'A9F74106', 'MCB 1P 6A iC60N'),
(49, 'A9F74103', 'MCB 1P 3A iC60N'),
(50, 'A9F74110', 'MCB 1P 10A iC60N'),
(51, 'A9F74116', 'MCB 1P 16A iC60N'),
(52, 'A9F74120', 'MCB 1P 20A iC60N'),
(53, 'A9F74125', 'MCB 1P 25A iC60N'),
(54, 'A9F74132', 'MCB 1P 32A iC60N'),
(55, 'A9F74140', 'MCB 1P 40A iC60N'),
(56, 'A9F74150', 'MCB 1P 50A iC60N'),
(57, 'A9F74163', 'MCB 1P 63A iC60N'),
(58, 'A9F74201', 'MCB 2P 1A iC60N'),
(59, 'A9F74202', 'MCB 2P 2A iC60N'),
(60, 'A9F74203', 'MCB 2P 3A iC60N'),
(61, 'A9F74204', 'MCB 2P 4A iC60N'),
(62, 'A9F74206', 'MCB 2P 6A iC60N'),
(63, 'A9F74210', 'MCB 2P 10A iC60N'),
(64, 'A9F74216', 'MCB 2P 16A iC60N'),
(65, 'A9F74220', 'MCB 2P 20A iC60N'),
(66, 'A9F74225', 'MCB 2P 25A iC60N'),
(67, 'A9F74232', 'MCB 2P 32A iC60N'),
(68, 'A9F74240', 'MCB 2P 40A iC60N'),
(69, 'A9F74250', 'MCB 2P 50A iC60N'),
(70, 'A9F74263', 'MCB 2P 63A iC60N'),
(71, 'A9F74301', 'MCB 3P 1A iC60N'),
(72, 'A9F74302', 'MCB 3P 2A iC60N'),
(73, 'A9F74303', 'MCB 3P 3A iC60N'),
(74, 'A9F74304', 'MCB 3P 4A iC60N'),
(75, 'A9F74306', 'MCB 3P 6A iC60N'),
(80, 'A9F74310', 'MCB 3P 10A iC60N'),
(81, 'A9F74316', 'MCB 3P 16A IC60N'),
(82, 'A9F74320', 'MCB 3P 20A iC60N'),
(83, 'A9F74325', 'MCB 3P 25A iC60N'),
(84, 'A9F74332', 'MCB 3P 32A iC60N'),
(85, 'A9F74340', 'MCB 3P 40A iC60N'),
(86, 'A9F74350', 'MCB 3P 50A iC60N'),
(87, 'A9F74363', 'MCB 3P 63A iC60N'),
(88, 'A9F74401', 'MCB 4P 1A iC60N'),
(89, 'A9F74402', 'MCB 4P 2A iC60N'),
(90, 'A9F74403', 'MCB 4P 3A iC60N'),
(91, 'A9F74404', 'MCB 4P 4A iC60N'),
(92, 'A9F74406', 'MCB 4P 6A iC60N'),
(93, 'A9F74410', 'MCB 4P 10A iC60N'),
(94, 'A9F74416', 'MCB 4P 16A iC60N'),
(95, 'A9F74420', 'MCB 4P 20A iC60N'),
(96, 'A9F74425', 'MCB 4P 25A iC60N'),
(97, 'A9F74432', 'MCB 4P 32A iC60N'),
(98, 'A9F74440', 'MCB 4P 40A iC60N'),
(99, 'A9F74450', 'MCB 4P 50A iC60N'),
(100, 'A9F74463', 'MCB 4P 63A iC60N'),
(101, 'A9F84101', 'MCB 1P 1A iC60H'),
(102, 'A9F84102', 'MCB 1P 2A iC60H'),
(103, 'A9F84104', 'MCB 1P 4A iC60H'),
(104, 'A9F84106', 'MCB 1P 6A iC60H'),
(105, 'A9F84110', 'MCB 1P 10A iC60H'),
(106, 'A9F84116', 'MCB 1P 16A iC60H'),
(107, 'A9F84120', 'MCB 1P 20A iC60H'),
(108, 'A9F84125', 'MCB 1P 25A iC60H'),
(109, 'A9F84132', 'MCB 1P 32A iC60H'),
(110, 'A9F84140', 'MCB 1P 40A iC60H'),
(111, 'A9F84150', 'MCB 1P 50A iC60H'),
(112, 'A9F84163', 'MCB 1P 63A iC60H'),
(113, 'A9F84201', 'MCB 2P 1A iC60H'),
(114, 'A9F84202', 'MCB 2P 2A iC60H'),
(115, 'A9F84204', 'MCB 2P 4A iC60H'),
(116, 'A9F84206', 'MCB 2P 6A iC60H'),
(117, 'A9F84210', 'MCB 2P 10A iC60H'),
(118, 'A9F84216', 'MCB 2P 16A iC60H'),
(119, 'A9F84220', 'MCB 2P 20A iC60H'),
(120, 'A9F84225', 'MCB 2P 25A iC60H'),
(121, 'A9F84232', 'MCB 2P 32A iC60H'),
(122, 'A9F84240', 'MCB 2P 40A iC60H'),
(123, 'A9F84250', 'MCB 2P 50A iC60H'),
(124, 'A9F84263', 'MCB 2P 63A iC60H'),
(125, 'A9F84301', 'MCB 3P 1A iC60H'),
(126, 'A9F84302', 'MCB 3P 2A iC60H'),
(127, 'A9F84304', 'MCB 3P 4A iC60H'),
(128, 'A9F84306', 'MCB 3P 6A iC60H'),
(129, 'A9F84310', 'MCB 3P 10A iC60H'),
(130, 'A9F84316', 'MCB 3P 16A iC60H'),
(131, 'A9F84320', 'MCB 3P 20A iC60H'),
(132, 'A9F84325', 'MCB 3P 25A iC60H'),
(133, 'A9F84332', 'MCB 3P 32A iC60H'),
(134, 'A9F84340', 'MCB 3P 40A iC60H'),
(135, 'A9F84350', 'MCB 3P 50A iC60H'),
(136, 'A9F84363', 'MCB 3P 63A iC60H'),
(137, 'A9F84401', 'MCB 4P 1A iC60H'),
(138, 'A9F84402', 'MCB 4P 2A iC60H'),
(139, 'A9F84404', 'MCB 4P 4A iC60H'),
(140, 'A9F84406', 'MCB 4P 6A iC60H'),
(141, 'A9F84410', 'MCB 4P 10A iC60H'),
(142, 'A9F84416', 'MCB 4P 16A iC60H'),
(143, 'A9F84420', 'MCB 4P 20A iC60H'),
(144, 'A9F84425', 'MCB 4P 25A iC60H'),
(145, 'A9F84432', 'MCB 4P 32A iC60H'),
(146, 'A9F84440', 'MCB 4P 40A iC60H'),
(147, 'A9F84450', 'MCB 4P 50A iC60H'),
(148, 'A9F84463', 'MCB 4P 63A iC60H'),
(149, 'A9A26929', 'Auxiliary iOF/SD+OF aux (2C/O)'),
(150, 'A9L15586', 'Surge Arrester PF65 3P+N 65kA 230/400V'),
(151, 'A9L15687', 'Surge Arrester PF40 1P+N 40kA 230V'),
(152, 'A9L15688', 'Surge Arrester PF40 3P+N 40kA 230/400V'),
(153, 'A9L15692', 'Surge Arrester PF20 1P+N 20kA 230V'),
(154, 'DOM12251SNI', 'MCB Domae 1P 2A'),
(155, 'DOM12252SNI', 'MCB Domae 1P 4A'),
(156, 'DOM11340SNI', 'MCB Domae 1P 6A'),
(157, 'DOM11341SNI', 'MCB Domae 1P 10A'),
(158, 'DOM11342SNI', 'MCB Domae 1P 16A'),
(159, 'DOM11343SNI', 'MCB Domae 1P 20A'),
(160, 'DOM11344SNI', 'MCB Domae 1P 25A'),
(161, 'DOM11345SNI', 'MCB Domae 1P 32A'),
(162, 'DOM11346SNI', 'MCB Domae 1P 40A'),
(163, 'DOM11335SNI', 'MCB Domae 1P 50A'),
(164, 'DOM11336SNI', 'MCB Domae 1P 63A'),
(165, 'DOM11228SNI', 'MCB Domae 2P 2A'),
(166, 'DOM11229SNI', 'MCB Domae 2P 4A'),
(167, 'DOM11230SNI', 'MCB Domae 2P 6A'),
(168, 'DOM11231SNI', 'MCB Domae 2P 10A'),
(169, 'DOM11232SNI', 'MCB Domae 2P 16A'),
(170, 'DOM11233SNI', 'MCB Domae 2P 20A'),
(171, 'DOM11234SNI', 'MCB Domae 2P 25A'),
(172, 'DOM11235SNI', 'MCB Domae 2P 32A'),
(173, 'DOM11236SNI', 'MCB Domae 2P 40A'),
(174, 'DOM11237SNI', 'MCB Domae 2P 50A'),
(175, 'DOM11238SNI', 'MCB Domae 2P 63A'),
(176, 'DOM11347SNI', 'MCB Domae 3P 6A'),
(177, 'DOM11348SNI', 'MCB Domae 3P 10A'),
(178, 'DOM11349SNI', 'MCB Domae 3P 16A'),
(179, 'DOM11350SNI', 'MCB Domae 3P 20A'),
(180, 'DOM11351SNI', 'MCB Domae 3P 25A'),
(181, 'DOM11352SNI', 'MCB Domae 3P 32A'),
(182, 'DOM11353SNI', 'MCB Domae 3P 40A'),
(183, 'DOM11337SNI', 'MCB Domae 3P 50A'),
(184, 'DOM11338SNI', 'MCB Domae 3P 63A'),
(185, 'DOM16790', 'RCCB 1P+N 30mA 25A'),
(186, 'DOM16792', 'RCCB 1P+N 300mA 25A'),
(187, 'DOM16793', 'RCCB 1P+N 30mA 40A'),
(188, 'DOM16795', 'RCCB 1P+N 300mA 40A'),
(189, 'DOM16833', 'RCCB 3P+N 300mA 25A'),
(190, 'EZC100H1020', 'MCCB 1P 20A 25kA'),
(191, 'EZC100B3015', 'MCCB 3P 15A 7,5kA'),
(192, 'EZC100B3020', 'MCCB 3P 20A 7,5kA'),
(193, 'EZC100B3025', 'MCCB 3P 25A 7,5kA'),
(194, 'EZC100B3030', 'MCCB 3P 30A 7,5kA'),
(195, 'EZC100B3040', 'MCCB 3P 40A 7,5kA'),
(196, 'EZC100B3050', 'MCCB 3P 50A 7,5kA'),
(197, 'EZC100B3060', 'MCCB 3P 60A 7,5kA'),
(198, 'EZC100F3015', 'MCCB 3P 15A 10kA'),
(199, 'EZC100F3020', 'MCCB 3P 20A 10kA'),
(200, 'EZC100F3025', 'MCCB 3P 25A 10kA'),
(201, 'EZC100F3030', 'MCCB 3P 30A 10kA'),
(202, 'EZC100F3040', 'MCCB 3P 40A 10kA'),
(203, 'EZC100F3050', 'MCCB 3P 50A 10kA'),
(204, 'EZC100F3060', 'MCCB 3P 60A 10kA'),
(205, 'EZC100F3075', 'MCCB 3P 75A 10kA'),
(206, 'EZC100F3080', 'MCCB 3P 80A 10kA'),
(207, 'EZC100F3100', 'MCCB 3P 100A 10kA'),
(208, 'EZC100N3015', 'MCCB 3P 15A 18kA'),
(209, 'EZC100N3020', 'MCCB 3P 20A 18kA'),
(210, 'EZC100N3025', 'MCCB 3P 25A 18kA'),
(211, 'EZC100N3030', 'MCCB 3P 30A 18kA'),
(212, 'EZC100N3035', 'MCCB 3P 35A 18kA'),
(213, 'EZC100N3040', 'MCCB 3P 40A 18kA'),
(214, 'EZC100N3050', 'MCCB 3P 50A 18kA'),
(215, 'EZC100N3060', 'MCCB 3P 60A 18kA'),
(216, 'EZC100N3075', 'MCCB 3P 75A 18kA'),
(217, 'EZC100N3080', 'MCCB 3P 80A 18kA'),
(218, 'EZC100N3100', 'MCCB 3P 100A 18kA'),
(219, 'EZC100H3015', 'MCCB 3P 15A 30kA'),
(220, 'EZC100H3020', 'MCCB 3P 20A 30kA'),
(221, 'EZC100H3025', 'MCCB 3P 25A 30kA'),
(222, 'EZC100H3030', 'MCCB 3P 30A 30kA'),
(223, 'EZC100H3035', 'MCCB 3P 35A 30kA'),
(224, 'EZC100H3040', 'MCCB 3P 40A 30kA'),
(225, 'EZC100H3050', 'MCCB 3P 50A 30kA'),
(226, 'EZC100H3060', 'MCCB 3P 60A 30kA'),
(227, 'EZC100H3075', 'MCCB 3P 75A 30kA'),
(228, 'EZC100H3080', 'MCCB 3P 80A 30kA'),
(229, 'EZC100H3100', 'MCCB 3P 100A 30kA'),
(230, 'EZC250F3100', 'MCCB 3P 100A 18kA'),
(231, 'EZC250F3125', 'MCCB 3P 125A 18kA'),
(232, 'EZC250F3160', 'MCCB 3P 160A 18kA'),
(233, 'EZC250F3200', 'MCCB 3P 200A 18kA'),
(234, 'EZC250F3225', 'MCCB 3P 225A 18kA'),
(235, 'EZC250F3250', 'MCCB 3P 250A 18kA'),
(236, 'EZC250N3100', 'MCCB 3P 100A 25kA'),
(237, 'EZC250N3125', 'MCCB 3P 125A 25kA'),
(238, 'EZC250N3160', 'MCCB 3P 160A 25kA'),
(239, 'EZC250N3200', 'MCCB 3P 200A 25kA'),
(240, 'EZC250N3225', 'MCCB 3P 225A 25kA'),
(241, 'EZC250N3250', 'MCCB 3P 250A 25kA'),
(242, 'EZC250H3100', 'MCCB 3P 100A 36kA'),
(243, 'EZC250H3125', 'MCCB 3P 125A 36kA'),
(244, 'EZC250H3160', 'MCCB 3P 160A 36kA'),
(245, 'EZC250H3200', 'MCCB 3P 200A 36kA'),
(246, 'EZC250H3225', 'MCCB 3P 225A 36kA'),
(247, 'EZC250H3250', 'MCCB 3P 250A 36kA'),
(248, 'LC1D09B7', 'Kontaktor TesysD 3P 9A 4kW 24VAC'),
(249, 'LC1D09D7', 'Kontaktor TesysD 3P 9A 4kW 42VAC'),
(250, 'LC1D09E7', 'Kontaktor TesysD 3P 9A 4kW 48VAC'),
(251, 'LC1D09F7', 'Kontaktor TesysD 3P 9A 4kW 110VAC'),
(252, 'LC1D09M7', 'Kontaktor TesysD 3P 9A 4kW 220VAC'),
(253, 'LC1D09Q7', 'Kontaktor TesysD 3P 9A 4kW 380VAC'),
(254, 'LC1D09JD', 'Kontaktor TesysD 3P 9A 4kW 12VDC'),
(255, 'LC1D09BD', 'Kontaktor TesysD 3P 9A 4kW 24VDC'),
(256, 'LC1D09ED', 'Kontaktor TesysD 3P 9A 4kW 48VDC'),
(257, 'LC1D09FD', 'Kontaktor TesysD 3P 9A 4kW 110VDC'),
(258, 'LC1D09MD', 'Kontaktor TesysD 3P 9A 4kW 220VDC'),
(259, 'LC1D09BNE', 'Kontaktor TesysD 3P 9A 4kW 24-60V'),
(260, 'LC1D09EHE', 'Kontaktor TesysD 3P 9A 4kW 18-130V'),
(261, 'LC1D09KUE', 'Kontaktor TesysD 3P 9A 4kW 110-250V'),
(262, 'LC1D40AB7', 'Kontaktor TesysD 3P 40A 18,5kW 24VAC'),
(263, 'LC1D40AD7', 'Kontaktor TesysD 3P 40A 18,5kW 42VAC'),
(264, 'LC1D40AE7', 'Kontaktor TesysD 3P 40A 18,5kW 48VAC'),
(265, 'LC1D40AF7', 'Kontaktor TesysD 3P 40A 18,5kW 110VAC'),
(266, 'LC1D40AM7', 'Kontaktor TesysD 3P 40A 18,5kW 220VAC'),
(267, 'LC1D40AQ7', 'Kontaktor TesysD 3P 40A 18,5kW 380VAC'),
(268, 'LC1D40AJD', 'Kontaktor TesysD 3P 40A 18,5kW 12VDC'),
(269, 'LC1D40ABD', 'Kontaktor TesysD 3P 40A 18,5kW 24VDC'),
(270, 'LC1D40AED', 'Kontaktor TesysD 3P 40A 18,5kW 48VDC'),
(271, 'LC1D40AFD', 'Kontaktor TesysD 3P 40A 18,5kW 110VDC'),
(272, 'LC1D40AMD', 'Kontaktor TesysD 3P 40A 18,5kW 220VDC'),
(273, 'LC1D40ABNE', 'Kontaktor TesysD Green 3P 40A 18,5kW 24-60V'),
(274, 'LC1D40AEHE', 'Kontaktor TesysD Green 3P 40A 18,5kW 48-130V'),
(275, 'LC1D40AKUE', 'Kontaktor TesysD Green 3P 40A 18,5kW 110-250V'),
(276, 'LC1D50AB7', 'Kontaktor TesysD 3P 50A 22kW 24VAC'),
(277, 'LC1D50AD7', 'Kontaktor TesysD 3P 50A 22kW 42VAC'),
(278, 'LC1D50AE7', 'Kontaktor TesysD 3P 50A 22kW 48VAC'),
(279, 'LC1D50AF7', 'Kontaktor TesysD 3P 50A 22kW 110VAC'),
(280, 'LC1D50AM7', 'Kontaktor TesysD 3P 50A 22kW 220VAC'),
(281, 'LC1D50AQ7', 'Kontaktor TesysD 3P 50A 22kW 380VAC'),
(282, 'LC1D50AJD', 'Kontaktor TesysD 3P 50A 22kW 12VDC'),
(283, 'LC1D50ABD', 'Kontaktor TesysD 3P 50A 22kW 24VDC'),
(284, 'LC1D50AED', 'Kontaktor TesysD 3P 50A 22kW 48VDC'),
(285, 'LC1D50AFD', 'Kontaktor TesysD 3P 50A 22kW 110VDC'),
(286, 'LC1D50AMD', 'Kontaktor TesysD 3P 50A 22kW 220VDC'),
(287, 'LC1D50ABNE', 'Kontaktor TesysD Green 3P 50A 22kW 24-60V'),
(288, 'LC1D50AEHE', 'Kontaktor TesysD Green 3P 50A 22kW 48-130V'),
(289, 'LC1D50AKUE', 'Kontaktor TesysD Green 3P 50A 22kW 110-250V'),
(290, 'LC1D65AB7', 'Kontaktor TesysD 3P 65A 30kW 24VAC'),
(291, 'LC1D65AD7', 'Kontaktor TesysD 3P 65A 30kW 42VAC'),
(292, 'LC1D65AE7', 'Kontaktor TesysD 3P 65A 30kW 48VAC'),
(293, 'LC1D65AF7', 'Kontaktor TesysD 3P 65A 30kW 110VAC'),
(294, 'LC1D65AM7', 'Kontaktor TesysD 3P 65A 30kW 220VAC'),
(295, 'LC1D65AQ7', 'Kontaktor TesysD 3P 65A 30kW 380VAC'),
(296, 'LC1D65AJD', 'Kontaktor TesysD 3P 65A 30kW 12VDC'),
(297, 'LC1D65ABD', 'Kontaktor TesysD 3P 65A 30kW 24VDC'),
(298, 'LC1D65AED', 'Kontaktor TesysD 3P 65A 30kW 48VDC'),
(299, 'LC1D65AFD', 'Kontaktor TesysD 3P 65A 30kW 110VDC'),
(300, 'LC1D65AMD', 'Kontaktor TesysD 3P 65A 30kW 220VDC'),
(301, 'LC1D65ABNE', 'Kontaktor TesysD Green 65A 30kW 24-60V'),
(302, 'LC1D65AEHE', 'Kontaktor TesysD 65A 30kW 48-130V'),
(303, 'LC1D65AKUE', 'Kontaktor TesysD 65A 30kW 110-250V'),
(304, 'LC1D80B7', 'Kontaktor TesysD 3P 80A 37kW 24VAC'),
(305, 'LC1D80D7', 'Kontaktor TesysD 3P 80A 37kW 42VAC'),
(306, 'LC1D80E7', 'Kontaktor TesysD 3P 80A 37kW 48VAC'),
(312, 'LC1D80F7', 'Kontaktor TesysD 3P 80A 37kW 110VAC'),
(313, 'LC1D80M7', 'Kontaktor TesysD 3P 80A 37kW 220VAC'),
(314, 'LC1D80Q7', 'Kontaktor TesysD 3P 80A 37kW 380VAC'),
(315, 'LC1D80JD', 'Kontaktor TesysD 3P 80A 37kW 12VDC'),
(316, 'LC1D80BD', 'Kontaktor TesysD 3P 80A 37kW 24VDC'),
(317, 'LC1D80ED', 'Kontaktor TesysD 3P 80A 37kW 48VDC'),
(318, 'LC1D80FD', 'Kontaktor TesysD 3P 80A 37kW 110VDC'),
(319, 'LC1D80MD', 'Kontaktor TesysD 3P 80A 37kW 220VDC'),
(320, 'LC1D95B7', 'Kontaktor TesysD 3P 95A 45kW 24VAC'),
(321, 'LC1D95D7', 'Kontaktor TesysD 3P 95A 45kW 42VAC'),
(322, 'LC1D95E7', 'Kontaktor TesysD 3P 95A 45kW 48VAC'),
(323, 'LC1D95F7', 'Kontaktor TesysD 3P 95A 45kW 110VAC'),
(324, 'LC1D95M7', 'Kontaktor TesysD 3P 95A 45kW 220VAC'),
(325, 'LC1D95Q7', 'Kontaktor TesysD 3P 95A 45kW 380VAC'),
(326, 'LC1D95JD', 'Kontaktor TesysD 3P 95A 45kW 12VDC'),
(327, 'LC1D95BD', 'Kontaktor TesysD 3P 95A 45kW 24VDC'),
(328, 'LC1D95ED', 'Kontaktor TesysD 3P 95A 45kW 48VDC'),
(329, 'LC1D95FD', 'Kontaktor TesysD 3P 95A 45kW 110VDC'),
(330, 'LC1D95MD', 'Kontaktor TesysD 3P 95A 45kW 220VDC'),
(331, 'LC1D115D7', 'Kontaktor TesysD 3P 115A 55kW 42VAC'),
(332, 'LC1D115E7', 'Kontaktor TesysD 3P 115A 55kW 48VAC'),
(333, 'LC1D115F7', 'Kontaktor TesysD 3P 115A 55kW 110VAC'),
(334, 'LC1D115M7', 'Kontaktor TesysD 3P 115A 55kW 220VAC'),
(335, 'LC1D115Q7', 'Kontaktor TesysD 3P 115A 55kW 380VAC'),
(336, 'LC1D115JD', 'Kontaktor TesysD 3P 115A 55kW 12VDC'),
(337, 'LC1D115BD', 'Kontaktor TesysD 3P 115A 55kW 24VDC'),
(338, 'LC1D115ED', 'Kontaktor TesysD 3P 115A 55kW 48VDC'),
(339, 'LC1D115FD', 'Kontaktor TesysD 3P 115A 55kW 110VDC'),
(340, 'LC1D115MD', 'Kontaktor TesysD 3P 115A 55kW 220VDC'),
(341, 'LC1D115B7', 'Kontaktor TesysD 3P 115A 55kW 24VAC'),
(342, 'LC1D150B7', 'Kontaktor TesysD 3P 150A 75kW 24VAC'),
(343, 'LC1D150D7', 'Kontaktor TesysD 3P 150A 75kW 42VAC'),
(344, 'LC1D150E7', 'Kontaktor TesysD 3P 150A 75kW 48VAC'),
(345, 'LC1D150F7', 'Kontaktor TesysD 3P 150A 75kW 110VAC'),
(346, 'LC1D150M7', 'Kontaktor TesysD 3P 150A 75kW 220VAC'),
(347, 'LC1D150Q7', 'Kontaktor TesysD 3P 150A 75kW 380VAC'),
(348, 'LC1D150JD', 'Kontaktor TesysD 3P 150A 75kW 12VDC'),
(349, 'LC1D150BD', 'Kontaktor TesysD 3P 150A 75kW 24VDC'),
(350, 'LC1D150ED', 'Kontaktor TesysD 3P 150A 75kW 48VDC'),
(351, 'LC1D150FD', 'Kontaktor TesysD 3P 150A 75kW 110VDC'),
(352, 'LC1D150MD', 'Kontaktor TesysD 3P 150A 75kW 220VDC'),
(353, 'LV510300', 'MCCB CVS100-250B 3P 16A 25kA TM16D'),
(354, 'LV510301', 'MCCB CVS100-250B 3P 25A 25kA TM25D'),
(355, 'LV510302', 'MCCB CVS100-250B 3P 32A 25kA TM32D'),
(356, 'LV510303', 'MCCB CVS100-250B 3P 40A 25kA TM40D'),
(357, 'LV510304', 'MCCB CVS100-250B 3P 50A 25kA TM50D'),
(358, 'LV510305', 'MCCB CVS100-250B 3P 63A 25kA TM63D'),
(359, 'LV510306', 'MCCB CVS100-250B 3P 80A 25kA TM80D'),
(360, 'LV510307', 'MCCB CVS100-250B 3P 100A 25kA TM100D'),
(361, 'LV516302', 'MCCB CVS100-250B 3P 125A 25kA TM125D'),
(362, 'LV516303', 'MCCB CVS100-250B 3P 160A 25kA TM160D'),
(363, 'LV525302', 'MCCB CVS100-250B 3P 200A 25kA TM200D'),
(364, 'LV525303', 'MCCB CVS100-250B 3P 250A 25kA TM250D'),
(365, 'LV510310', 'MCCB CVS100-250B 4P 16A 25kA TM16D'),
(366, 'LV510311', 'MCCB CVS100-250B 4P 25A 25kA TM25D'),
(367, 'LV510312', 'MCCB CVS100-250B 4P 32A 25kA TM32D'),
(368, 'LV510313', 'MCCB CVS100-250B 4P 40A 25kA TM40D'),
(369, 'LV510314', 'MCCB CVS100-250B 4P 50A 25kA TM50D'),
(370, 'LV510315', 'MCCB CVS100-250B 4P 63A 25kA TM63D'),
(371, 'LV510316', 'MCCB CVS100-250B 4P 80A 25kA TM80D'),
(372, 'LV510317', 'MCCB CVS100-250B 4P 100A 25kA TM100D'),
(373, 'LV516312', 'MCCB CVS100-250B 4P 125A 25kA TM125D'),
(374, 'LV516313', 'MCCB CVS100-250B 4P 160A 25kA TM160D'),
(375, 'LV525312', 'MCCB CVS100-250B 4P 200A 25kA TM200D'),
(376, 'LV525313', 'MCCB CVS100-250B 4P 250A 25kA TM250D'),
(377, 'LV510330', 'MCCB CVS100-250F 3P 16A 36kA TM16D'),
(378, 'LV510331', 'MCCB CVS100-250F 3P 25A 36kA TM25D'),
(379, 'LV510332', 'MCCB CVS100-250F 3P 32A 36kA TM32D'),
(380, 'LV510333', 'MCCB CVS100-250F 3P 40A 36kA TM40D'),
(381, 'LV510334', 'MCCB CVS100-250F 3P 50A 36kA TM50D'),
(382, 'LV510335', 'MCCB CVS100-250F 3P 63A 36kA TM63D'),
(383, 'LV510336', 'MCCB CVS100-250F 3P 80A 36kA TM80D'),
(384, 'LV510337', 'MCCB CVS100-250F 3P 100A 36kA TM100D'),
(385, 'LV516332', 'MCCB CVS100-250F 3P 125A 36kA TM125D'),
(386, 'LV516333', 'MCCB CVS100-250F 3P 160A 36kA TM160D'),
(387, 'LV525332', 'MCCB CVS100-250F 3P 200A 36kA TM200D'),
(388, 'LV525333', 'MCCB CVS100-250F 3P 250A 36kA TM250D'),
(389, 'LV510340', 'MCCB CVS100-250F 4P 16A 36kA TM16D'),
(390, 'LV510341', 'MCCB CVS100-250F 4P 25A 36kA TM25D'),
(391, 'LV510342', 'MCCB CVS100-250F 4P 32A 36kA TM32D'),
(392, 'LV510343', 'MCCB CVS100-250B 4P 40A 36kA TM40D'),
(393, 'LV510344', 'MCCB CVS100-250F 4P 50A 36kA TM50D'),
(394, 'LV510345', 'MCCB CVS100-250F 4P 63A 36kA TM63D'),
(395, 'LV510346', 'MCCB CVS100-250F 4P 80A 36kA TM80D'),
(396, 'LV510347', 'MCCB CVS100-250F 4P 100A 36kA TM100D'),
(397, 'LV516342', 'MCCB CVS100-250F 4P 125A 36kA TM125D'),
(398, 'LV516343', 'MCCB CVS100-250F 4P 160A 36kA TM160D'),
(399, 'LV525342', 'MCCB CVS100-250F 4P 200A 36kA TM200D'),
(400, 'LV525343', 'MCCB CVS100-250F 4P 250A 36kA TM250D'),
(401, 'LV510470', 'MCCB CVS100-250N 3P 16A 50kA TM16D'),
(402, 'LV510471', 'MCCB CVS100-250N 3P 25A 50kA TM25D'),
(403, 'LV510472', 'MCCB CVS100-250N 3P 32A 50kA TM32D'),
(404, 'LV510473', 'MCCB CVS100-250N 3P 40A 50kA TM40D'),
(405, 'LV510474', 'MCCB CVS100-250N 3P 50A 50kA TM50D'),
(406, 'LV510475', 'MCCB CVS100-250N 3P 63A 50kA TM63D'),
(407, 'LV510476', 'MCCB CVS100-250N 3P 80A 50kA TM80D'),
(408, 'LV510477', 'MCCB CVS100-250N 3P 100A 50kA TM100D'),
(409, 'LV516462', 'MCCB CVS100-250N 3P 125A 50kA TM125D'),
(410, 'LV516463', 'MCCB CVS100-250N 3P 160A 50kA TM160D'),
(411, 'LV525452', 'MCCB CVS100-250N 3P 200A 50kA TM200D'),
(412, 'LV525453', 'MCCB CVS100-250N 3P 250A 50kA TM250D'),
(413, 'LV510480', 'MCCB CVS100-250N 4P 16A 50kA TM16D'),
(414, 'LV510481', 'MCCB CVS100-250N 4P 25A 50kA TM25D'),
(415, 'LV510482', 'MCCB CVS100-250N 4P 32A 50kA TM32D'),
(416, 'LV510483', 'MCCB CVS100-250N 4P 40A 50kA TM40D'),
(417, 'LV510484', 'MCCB CVS100-250N 4P 50A 50kA TM50D'),
(418, 'LV510485', 'MCCB CVS100-250N 4P 63A 50kA TM63D'),
(419, 'LV510486', 'MCCB CVS100-250N 4P 80A 50kA TM80D'),
(420, 'LV510487', 'MCCB CVS100-250N 4P 100A 50kA TM100D'),
(421, 'LV516467', 'MCCB CVS100-250N 4P 125A 50kA TM125D'),
(422, 'LV516468', 'MCCB CVS100-250N 4P 160A 50kA TM160D'),
(423, 'LV525457', 'MCCB CVS100-250N 4P 200A 50kA TM200D'),
(424, 'LV525458', 'MCCB CVS100-250N 4P 250A 50kA TM250D'),
(425, 'LV540305', 'MCCB CVS400-630F 3P 320A 36kA TM320D'),
(426, 'LV540306', 'MCCB CVS400-630F 3P 400A 36kA TM400D'),
(427, 'LV563305', 'MCCB CVS400-630F 3P 500A 36kA TM500D'),
(428, 'LV563306', 'MCCB CVS400-630F 3P 600A 36kA TM600D'),
(429, 'LV540308', 'MCCB CVS400-630F 4P 320A 36kA TM320D'),
(430, 'LV540309', 'MCCB CVS400-630F 4P 400A 36kA TM 400D'),
(431, 'LV563308', 'MCCB CVS400-630F 4P 500A 36kA TM500D'),
(432, 'LV563309', 'MCCB CVS400-630F 4P 600A 36kA TM600D'),
(433, 'LV540315', 'MCCB CVS400-630N 3P 320A 50kA TM320D'),
(434, 'LV540316', 'MCCB CVS400-630N 3P 400A 50kA TM400D'),
(435, 'LV563315', 'MCCB CVS400-630N 3P 500A 50kA TM500D'),
(436, 'LV563316', 'MCCB CVS400-630N 3P 600A 50kA TM600D'),
(437, 'LV540318', 'MCCB CVS400-630N 4P 320A 50kA TM320D'),
(438, 'LV540319', 'MCCB CVS400-630N 4P 400A 50kA TM400D'),
(439, 'LV563318', 'MCCB CVS400-630N 4P 500A 50kA TM500D'),
(440, 'LV563319', 'MCCB CVS400-630N 4P 600A 50kA TM600D'),
(441, 'LV540505', 'MCCB CVS400-630F 3P 400A 36kA ETS 400'),
(442, 'LV563505', 'MCCB CVS400-630F 3P 630A 36kA ETS 630'),
(443, 'LV540506', 'MCCB CVS400-630F 4P 400A 36kA ETS 400'),
(444, 'LV563506', 'MCCB CVS400-630F 4P 630A 36kA ETS 630'),
(445, 'LV540510', 'MCCB CVS400-630N 3P 400A 50kA ETS 400'),
(446, 'LV563510', 'MCCB CVS400-630N 3P 630A 50kA ETS 630'),
(447, 'LV540511', 'MCCB CVS400-630N 4P 400A 50kA ETS 400'),
(448, 'LV563511', 'MCCB CVS400-630N 4P 630A 50kA ETS 630'),
(449, 'LV426400', 'MCCB 3P 16A 50kA Compact NSXm'),
(450, 'LV426401', 'MCCB 3P 25A 50kA Compact NSXm'),
(451, 'LV426402', 'MCCB 3P 32A 50kA Compact NSXm'),
(452, 'LV426403', 'MCCB 3P 40A 50kA Compact NSXm'),
(453, 'LV426404', 'MCCB 3P 50A 50kA Compact NSXm'),
(454, 'LV426405', 'MCCB 3P 63A 50kA Compact NSXm'),
(455, 'LV426406', 'MCCB 3P 80A 50kA Compact NSXm'),
(456, 'LV426407', 'MCCB 3P 100A 50kA Compact NSXm'),
(457, 'LV426408', 'MCCB 3P 125A 50kA Compact NSXm'),
(458, 'LV426409', 'MCCB 3P 160A 50kA Compact NSXm'),
(459, 'LV429637', 'MCCB 3P 16A 36kA Compact NSX100F'),
(460, 'LV429636', 'MCCB 3P 25A 36kA Compact NSX100F'),
(461, 'LV429635', 'MCCB 3P 32A 36kA Compact NSX100F'),
(462, 'LV429634', 'MCCB 3P 40A 36kA Compact NSX100F'),
(463, 'LV429633', 'MCCB 3P 50A 36kA Compact NSX100F'),
(464, 'LV429632', 'MCCB 3P 63A 36kA Compact NSX100F'),
(465, 'LV429631', 'MCCB 3P 80A 36kA Compact NSX100F'),
(466, 'LV429630', 'MCCB 3P 100A 36kA Compact NSX100F'),
(467, 'LV430631', 'MCCB 3P 125A 36kA Compact NSX100F'),
(468, 'LV430630', 'MCCB 3P 160A 36kA Compact NSX100F'),
(469, 'LV431631', 'MCCB 3P 200A 36kA Compact NSX100F'),
(470, 'LV431630', 'MCCB 3P 250A 36kA Compact NSX100F'),
(471, 'LV429647', 'MCCB 4P 16A 36kA Compact NSX100F'),
(472, 'LV429646', 'MCCB 4P 25A 36kA Compact NSX100F'),
(473, 'LV429645', 'MCCB 3P 32A 36kA Compact NSX100F'),
(474, 'LV429644', 'MCCB 4P 40A 36kA Compact NSX100F'),
(475, 'LV429643', 'MCCB 4P 50A 36kA Compact NSX100F'),
(476, 'LV429642', 'MCCB 4P 63A 36kA Compact NSX100F'),
(477, 'LV429641', 'MCCB 4P 80A 36kA Compact NSX100F'),
(478, 'LV429640', 'MCCB 4P 100A 36kA Compact NSX100F'),
(479, 'LV430641', 'MCCB 4P 125A 36kA Compact NSX100F'),
(480, 'LV430640', 'MCCB 4P 160A 36kA Compact NSX100F'),
(481, 'LV431641', 'MCCB 4P 200A 36kA Compact NSX100F'),
(482, 'LV431640', 'MCCB 4P 250A 36kA Compact NSX100F'),
(483, 'LV429847', 'MCCB 3P 16A 50kA Compact NSX100N'),
(484, 'LV429846', 'MCCB 3P 25A 50kA Compact NSX100N'),
(485, 'LV429845', 'MCCB 3P 32A 50kA Compact NSX100N'),
(486, 'LV429844', 'MCCB 3P 40A 50kA Compact NSX100N'),
(487, 'LV429843', 'MCCB 3P 50A 50kA Compact NSX100N'),
(488, 'LV429842', 'MCCB 3P 63A 50kA Compact NSX100N'),
(489, 'LV429841', 'MCCB 3P 80A 50kA Compact NSX100N'),
(490, 'LV429840', 'MCCB 3P 100A 50kA Compact NSX100N'),
(491, 'LV430841', 'MCCB 3P 125A 50kA Compact NSX100N'),
(492, 'LV430840', 'MCCB 3P 160A 50kA Compact NSX100N'),
(493, 'LV431831', 'MCCB 3P 200A 50kA Compact NSX100N'),
(494, 'LV431830', 'MCCB 3P 250A 50kA Compact NSX100N'),
(495, 'LV429677', 'MCCB 3P 16A 70kA Compact NSX100H'),
(496, 'LV429676', 'MCCB 3P 25A 70kA Compact NSX100H'),
(497, 'LV429675', 'MCCB 3P 32A 70kA Compact NSX100H'),
(498, 'LV429674', 'MCCB 3P 40A 70kA Compact NSX100H'),
(499, 'LV429673', 'MCCB 3P 50A 70kA Compact NSX100H'),
(500, 'LV429672', 'MCCB 3P 63A 70kA Compact NSX100H'),
(501, 'LV429671', 'MCCB 3P 80A 70kA Compact NSX100H'),
(502, 'LV429670', 'MCCB 3P 100A 70kA Compact NSX100H'),
(503, 'LV430671', 'MCCB 3P 125A 70kA Compact NSX100H'),
(504, 'LV430670', 'MCCB 3P 160A 70kA Compact NSX100H'),
(505, 'LV431671', 'MCCB 3P 200A 70kA Compact NSX100H'),
(506, 'LV431670', 'MCCB 3P 250A 70kA Compact NSX100H'),
(507, 'LV430641', 'MCCB 4P 125A 36kA Compact NSX100F'),
(508, 'LV430640', 'MCCB 4P 160A 36kA Compact NSX100F'),
(509, 'LV431641', 'MCCB 3P 200A 36kA Compact NSX100F'),
(510, 'LV429833', 'MCCB 3P 25A 50kA 9kW Compact NSX100N dengan Micrologic 2.2-M'),
(511, '29370', 'Locking Removable Device NSX100-250'),
(512, 'LV429629', 'Compact NSX100NA 3P 100A'),
(513, 'LV430629', 'Compact NSX160NA 3P 160A'),
(514, 'LV431629', 'Compact NSX250NA 3P 250A'),
(515, 'LV432756', 'Compact NSX400NA 3P 400A'),
(516, 'LV432956', 'Compact NSX630NA 3P 630A'),
(517, '33487', 'Compact NS800NA 3P 800A'),
(518, '33488', 'Compact NS1000NA 3p 1000A'),
(519, '33489', 'Compact NS1250NA 3P 1250A'),
(520, '33490', 'Compact NS1600NA 3P 1600A'),
(521, 'LV429639', 'Compact NSX100NA 4P 100A'),
(522, 'LV430639', 'Compact NSX160NA 4P 160A'),
(523, 'LV431639', 'Compact NSX250NA 4P 250A'),
(524, 'LV432757', 'Compact NSX400NA 4P 400A'),
(525, 'LV432957', 'Compact NSX630NA 4P 630A'),
(526, '33492', 'Compact NS800NA 4P 800A'),
(527, '33493', 'Compact NS1000NA 4P 1000A'),
(528, '33494', 'Compact NS1250NA 4P 1250A'),
(529, '33495', 'Compact NS1600NA 4P 1600A'),
(530, '28900', 'Compact INS40 3P 40A'),
(531, '28901', 'Compact INS40 4P 40A'),
(532, '28902', 'Compact INS63 3P 63A '),
(533, '28903', 'Compact INS63 4P 63A '),
(534, '28904', 'Compact INS80 3P 80A'),
(535, '28905', 'Compact INS80 4P 80A'),
(536, '28908', 'Compact INS100 3P 100A'),
(537, '28909', 'Compact INS100 4P 100A'),
(538, '28910', 'Compact INS125 3P 125A'),
(539, '28911', 'Compact INS125 4P 125A'),
(540, '28912', 'Compact INS160 3P 160A'),
(541, '28913', 'Compact INS160 4P 160A'),
(542, '31106', 'Compact INS250 3P 250A'),
(543, '31107', 'Compact INS250 4P 250A'),
(544, '31108', 'Compact INS320 3P 320A'),
(545, '31109', 'Compact INS320 4P 320A'),
(546, '31110', 'Compact INS400 3P 400A'),
(547, '31111', 'Compact INS400 4P 400A'),
(548, '31112', 'Compact INS500 3P 500A'),
(549, '31113', 'Compact INS500 4P 500A'),
(550, '31114', 'Compact INS630 3P 630A'),
(551, '31115', 'Compact INS630 4P 630A'),
(552, '31330', 'Compact INS800 3P 800A'),
(553, '31331', 'Compact INS800 4P 800A'),
(554, '31332', 'Compact INS1000 3P 1000A'),
(555, '31333', 'Compact INS1000 4P 1000A'),
(556, '31334', 'Compact INS1250 3P 1250A'),
(557, '31335', 'Compact INS1250 4P 1250A'),
(558, '31336', 'Compact INS1600 3P 1600A'),
(559, '31337', 'Compact INS1600 4P 1600A'),
(560, '31338', 'Compact INS2000 3P 2000A'),
(561, '31339', 'Compact INS2000 4P 2000A'),
(562, '31340', 'Compact INS2500 3P 2500A'),
(563, '31341', 'Compact INS2500 4P 2500A'),
(564, '29450', 'Accessories Auxiliary contact OF'),
(565, 'LV429841', 'Accessories front-black handle INS40/160'),
(566, '33466', 'MCCB 3P 800A 50kA Micrologic 2.0 Compact NS800N'),
(567, '33552', 'MCCB 3P 800A 50kA Micrologic 5.0 Compact NS800N'),
(568, '33467', 'MCCB 3P 800A 70kA Micrologic 2.0 Compact NS800H'),
(569, '33553', 'MCCB 3P 800A 70kA Micrologic 5.0 Compact NS800H'),
(570, '33469', 'MCCB 4P 800A 50kA Micrologic 2.0 Compact NS800N'),
(571, '33555', 'MCCB 4P 800A 50kA Micrologic 5.0 Compact NS800N'),
(572, '33470', 'MCCB 4P 800A 70kA Micrologic 2.0 Compact NS800H'),
(573, '33556', 'MCCB 4P 800A 70kA Micrologic 5.0 Compact NS800H'),
(574, '33472', 'MCCB 3P 1000A 50 kA Micrologic 2.0 Compact NS1000N'),
(575, '33558', 'MCCB 3P 1000A 50kA Micrologic 5.0 Compact NS1000N'),
(576, '33473', 'MCCB 3P 1000A 70kA Micrologic 2.0 Compact NS1000H'),
(577, '33559', 'MCCB 3P 1000A 70kA Micrologic 5.0 Compact NS1000H'),
(578, '33475', 'MCCB 4P 1000A 50kA Micrologic 2.0 Compact NS1000N'),
(579, '33561', 'MCCB 4P 1000A 50kA Micrologic 5.0 Compact NS1000N'),
(580, '33476', 'MCCB 4P 1000A 70kA Micrologic 2.0 Compact NS1000H'),
(581, '33562', 'MCCB 4P 1000A 70kA Micrologic 5.0 Compact NS1000H'),
(582, '33478', 'MCCB 3P 1250A 50kA Micrologic 2.0 Compact NS1250N'),
(583, '33564', 'MCCB 3P 1250A 50kA Micrologic 5.0 Compact NS1250N'),
(584, '33479', 'MCCB 3P 1250A 70kA Micrologic 2.0 Compact NS1250H'),
(585, '33565', 'MCCB 3P 1250A 70kA Micrologic 5.0 Compact NS1250H'),
(586, '33480', 'MCCB 4P 1250A 50kA Micrologic 2.0 Compact NS1250N'),
(587, '33566', 'MCCB 4P 1250A 50kA Micrologic 5.0 Compact NS1250N'),
(588, '33481', 'MCCB 4P 1250A 70kA Micrologic 2.0 Compact NS1250H'),
(589, '33567', 'MCCB 4P 1250A 70kA Micrologic 5.0 Compact NS1250H'),
(590, '33482', 'MCCB 3P 1600A 50kA Micrologic 2.0 Compact NS1600N'),
(591, '33568', 'MCCB 3P 1600A 50kA Micrologic 5.0 Compact NS1600N'),
(592, '33483', 'MCCB 3P 1600A 70kA Micrologic 2.0 Compact NS1600H'),
(593, '33569', 'MCCB 3P 1600A 70kA Micrologic 5.0 Compact NS1600H'),
(594, '33484', 'MCCB 4P 1600A 50kA Micrologic 2.0 Compact NS1600N'),
(595, '33570', 'MCCB 4P 1600A 50kA Micrologic 5.0 Compact NS1600N'),
(596, '33485', 'MCCB 4P 1600A 70kA Micrologic 2.0 Compact NS1600H'),
(597, '33571', 'MCCB 4P 1600A 70kA Micrologic 5.0 Compact NS1600H'),
(598, '33466E', 'MCCB 3P 800A 50kA Micrologic 2.0 Compact NS800N with Motor Mechanism Module 220VAC'),
(599, '33552E', 'MCCB 3P 800A 50kA Micrologic 5.0 Compact NS800N With Motor Mechanism Module 220VAC'),
(600, '33467E', 'MCCB 3P 800A 70kA Micrologic 2.0 Compact NS800H With Motor Mechanism Module 220VAC'),
(601, '33553E', 'MCCB 3P 800A 70kA Micrologic 5.0 Compact NS800H With Motor Mechanism Module 220VAC'),
(602, '33469E', 'MCCB 4P 800A 50kA Micrologic 2.0 Compact NS800N With Motor Mechanism Module 220VAC'),
(603, '33555E', 'MCCB 4P 800A 50kA Micrologic 5.0 Compact NS800N With Motor Mechanism Module 220VAC'),
(604, '33470E', 'MCCB 4P 800A 70kA Micrologic 2.0 Compact NS800H With Motor Mechanism Module 220VAC'),
(605, '33556E', 'MCCB 4P 800A 70kA Micrologic 5.0 Compact NS800H With Motor Mechanism Module 220VAC'),
(606, '33472E', 'MCCB 3P 1000A 50 kA Micrologic 2.0 Compact NS1000N With Motor Mechanism Module 220VAC'),
(607, '33558E', 'MCCB 3P 1000A 50kA Micrologic 5.0 Compact NS1000N With Motor Mechanism Module 220VAC'),
(608, '33473E', 'MCCB 3P 1000A 70kA Micrologic 2.0 Compact NS1000H With Motor Mechanism Module 220VAC'),
(609, '33559E', 'MCCB 3P 1000A 70kA Micrologic 5.0 Compact NS1000H With Motor Mechanism Module 220VAC'),
(610, '33475E', 'MCCB 4P 1000A 50kA Micrologic 2.0 Compact NS1000N With Motor Mechanism Module 220VAC'),
(611, '33561E', 'MCCB 4P 1000A 50kA Micrologic 5.0 Compact NS1000N With Motor Mechanism Module 220VAC'),
(612, '33476E', 'MCCB 4P 1000A 70kA Micrologic 2.0 Compact NS1000H With Motor Mechanism Module 220VAC'),
(613, '33562E', 'MCCB 4P 1000A 70kA Micrologic 5.0 Compact NS1000H With Motor Mechanism Module 220VAC'),
(614, '33478E', 'MCCB 3P 1250A 50kA Micrologic 2.0 Compact NS1250N With Motor Mechanism Module 220VAC'),
(615, '33564E', 'MCCB 3P 1250A 50kA Micrologic 5.0 Compact NS1250N With Motor Mechanism Module 220VAC'),
(616, '33479E', 'MCCB 3P 1250A 70kA Micrologic 2.0 Compact NS1250H With Motor Mechanism Module 220VAC'),
(617, '33565E', 'MCCB 3P 1250A 70kA Micrologic 5.0 Compact NS1250H With Motor Mechanism Module 220VAC'),
(618, '33480E', 'MCCB 4P 1250A 50kA Micrologic 2.0 Compact NS1250N With Motor Mechanism Module 220VAC'),
(619, '33566E', 'MCCB 4P 1250A 50kA Micrologic 5.0 Compact NS1250N With Motor Mechanism Module 220VAC'),
(620, '33481E', 'MCCB 4P 1250A 70kA Micrologic 2.0 Compact NS1250H With Motor Mechanism Module 220VAC'),
(621, '33567E', 'MCCB 4P 1250A 70kA Micrologic 5.0 Compact NS1250H With Motor Mechanism Module 220VAC'),
(622, 'NW08H13F2EH', 'ACB 3P 800A 65kA NW08 Tipe Fixed'),
(623, 'NW10H13F2EH', 'ACB 3P 1000A 65kA NW10 Tipe Fixed'),
(624, 'NW12H13F2EH', 'ACB 3P 1250A 65kA NW12 Tipe Fixed'),
(625, 'NW16H13F2EH', 'ACB 3P 1600A 65kA NW16 Tipe Fixed'),
(626, 'NW20H13F2EH', 'ACB 3P 2000A 65kA NW20 Tipe Fixed'),
(627, 'NW25H13F2EH', 'ACB 3P 2500 65kA NW25 Tipe Fixed'),
(628, 'NW32H13F2EH', 'ACB 3P 3200A 65kA NW32 Tipe Fixed'),
(629, 'NW40H13F2EH', 'ACB 3P 4000A 65kA NW40 Tipe Fixed'),
(630, 'NW50H13F2EH', 'ACB 3P 5000A 100kA NW50 Tipe Fixed'),
(631, 'NW63H13F2EV', 'ACB 3P 6300A 100kA NW63 Tipe Fixed'),
(632, 'NW08H14F2EH', 'ACB 4P 800A 65kA NW08 Tipe Fixed'),
(633, 'NW10H14F2EH', 'ACB 4P 1000A 65kA NW10 Tipe Fixed'),
(634, 'NW12H14F2EH', 'ACB 4P 1250A 65kA NW12 Tipe Fixed'),
(635, 'NW16H14F2EH', 'ACB 4P 1600A 65kA NW16 Tipe Fixed'),
(636, 'NW20H14F2EH', 'ACB 4P 2000A 65kA NW20 Tipe Fixed'),
(637, 'NW25H14F2EH', 'ACB 4P 2500A 65kA NW25 Tipe Fixed'),
(638, 'NW32H14F2EH', 'ACB 4P 3200A 65kA NW32 Tipe Fixed'),
(639, 'NW40H14F2EH', 'ACB 4P 4000A 65kA NW40 Tipe Fixed'),
(640, 'NW50H14F2EH', 'ACB 4P 5000A 100kA NW50 Tipe Fixed'),
(641, 'NW63H14F2EV', 'ACB 4P 6300A 100kA NW63 Tipe Fixed'),
(642, 'NW08H23F2EH', 'ACB 3P 800A 100kA NW08 Tipe Fixed'),
(643, 'NW10H23F2EH', 'ACB 3P 1000A 100kA NW10 Tipe Fixed'),
(644, 'NW12H23F2EH', 'ACB 3P 1250A 100kA NW12 Tipe Fixed'),
(645, 'NW16H23F2EH', 'ACB 3P 1600A 100kA NW16 Tipe Fixed'),
(646, 'NW20H23F2EH', 'ACB 3P 2000A 100kA NW20 Tipe Fixed'),
(647, 'NW25H23F2EH', 'ACB 3P 2500A 100kA NW25 Tipe Fixed'),
(648, 'NW32H23F2EH', 'ACB 3P 3200A 100kA NW32 Tipe Fixed'),
(649, 'NW40H23F2EH', 'ACB 3P 4000A 100kA NW40 Tipe Fixed'),
(650, 'NW50H23F2EH', 'ACB 3P 5000A 150kA NW50 Tipe Fixed'),
(651, 'NW63H23F2EV', 'ACB 3P 6300A 150kA NW63 Tipe Fixed'),
(652, 'NW08H24F2EH', 'ACB 4P 800A 100kA NW08 Tipe Fixed'),
(653, 'NW10H24F2EH', 'ACB 4P 1000A 100kA NW10 Tipe Fixed'),
(654, 'NW12H24F2EH', 'ACB 4P 1250A 100kA NW12 Tipe Fixed'),
(655, 'NW16H24F2EH', 'ACB 4P 1600A 100kA NW16 Tipe Fixed'),
(656, 'NW20H24F2EH', 'ACB 4P 2000A 100kA NW20 Tipe Fixed'),
(657, 'NW25H24F2EH', 'ACB 4P 2500A 100kA NW25 Tipe Fixed'),
(658, 'NW32H24F2EH', 'ACB 4P 3200A 100kA NW32 Tipe Fixed'),
(659, 'NW40H24F2EH', 'ACB 4P 4000A 100kA NW40 Tipe Fixed'),
(660, 'NW50H24F2EH', 'ACB 4P 5000A 150kA NW50 Tipe Fixed'),
(661, 'NW63H24F2EV', 'ACB 4P 6300A 150kA NW63 Tipe Fixed'),
(662, '47353', 'Closing Release (XF) Standar 200-250VAC/DC'),
(663, '47363', 'Opening Release (MX) Standar 200-250VAC/DC'),
(664, '47373', 'Shunt Release (2nd MX) 200-250VAC/DC'),
(665, '47383', 'Under Voltage Release (MN) 200-250VAC/DC'),
(666, '48212', 'Gear Motor (MCH) 200-240VAC'),
(667, '51207', 'Varlogic RT6-PF Regulator 6 Step'),
(668, '51213', 'Varlogic RT12-PF Regulator 12 Step'),
(669, 'ATS01N209QN', 'Altistart01 3P 9A 3/4kW 380-415VAC 50/60Hz'),
(670, 'ATV12H075M2', 'Altivar12 1P 4.2A 0.75kW 200-240VAC 50/60Hz'),
(671, 'ATV212HD11N4', 'Inverter Altivar212 3P 22.5A 11 kW 380-480VAC'),
(672, 'ATV212HD15N4', 'Inverter Altivar212 3P 30.5A 15kW 380-480VAC'),
(673, 'ATV212HD18N4', 'Inverter Altivar212 3P 37A 18.5kW 380-480VAC'),
(674, 'ATV212HD45N4', 'Inverter Altivar212 3P 94A 45kW 380-480VAC'),
(675, 'ATV212HD75N4', 'Inverter Altivar212 3P 160A 75kW 380-480VAC'),
(676, 'ATV212HU15N4', 'Inverter Altivar212 3P 3.7A 1.5kW '),
(677, 'ATV212HU55N4', 'Inverter Altivar212 3P 12A 5.5kW 380-480VAC'),
(678, 'ATV610C13N4', 'Inverter Altivar610 250A 132kW'),
(679, 'ATV610D11N4', 'Inverter Altivar610 23.5A 11kW'),
(680, 'ATV610D15N4', 'Inverter Altivar610 31.7A 15kW'),
(681, 'ATV610D22N4', 'Inverter Altivar610 46.3A 22kW'),
(682, 'ATV610U15N4', 'Inverter Altivar610 4.0A 1.5kW'),
(683, 'ATV610U75N4', 'Inverter Altivar 15.8A 7.5kW'),
(684, 'ATV630D30N4', 'Inverter Altivar630 3P 61.5A 30kW 380-480VAC'),
(685, 'BLRCH104A125B40', 'Kapasitor VarPlus (Heavy Duty) 10.4kVAR'),
(686, 'BLRCH125A150B40', 'Kapasitor VarPlus (Heavy Duty) 12.5kVAR'),
(687, 'BLRCH150A180B40', 'Kapasitor VarPlus (Heavy Duty) 15kVAR'),
(688, 'BLRCH200A240B40', 'Kapasitor VarPlus (Heavy Duty) 20kVAR'),
(689, 'BLRCH250A300B40', 'Kapasitor VarPlus (Heavy Duty) 25kVAR'),
(690, 'BLRCH500A000B40', 'Kapasitor VarPlus (Heavy Duty) 50kVAR'),
(691, 'BLRCS104A125B40', 'Kapasitor EasyCan (Standard Duty) 10.4kVAR'),
(692, 'BLRCS125A150B40', 'Kapasitor EasyCan (Standard Duty) 12.5kVAR'),
(693, 'BLRCS150A180B40', 'Kapasitor EasyCan (Standard Duty) 15kVAR'),
(694, 'BLRCS200A240B40', 'Kapasitor EasyCan (Standard Duty) 20kVAR'),
(695, 'BLRCS250A300B40', 'Kapasitor EasyCan (Standard Duty) 25kVAR'),
(696, 'GV2L10', 'Motor Circuit Breaker 100kA 2.2kW'),
(697, 'GV2L16', 'Motor Circuit Breaker 50kA 5.5kW'),
(698, 'GV2L20', 'Motor Circuit Breaker 50kA 7.5kW'),
(699, 'GV2L22', 'Motor Circuit Breaker 50kA 9/11kW'),
(700, 'GV2L32', 'Motor Circuit Breaker 50kA 15kW'),
(701, 'GV2ME03', 'Motor Circuit Breaker 0.25-0.4A 100kA 0.09kW'),
(702, 'GV2ME04', 'Motor Circuit Breaker 0.4-0.63A 100kA 0.12/0.18kW'),
(703, 'GV2ME05', 'Motor Circuit Breaker 0.63-1/1-1.6A 100kA 0.25/0.37kW'),
(704, 'GV2ME06', 'Motor Circuit Breaker 1-1.6A 100kA 0.55kW'),
(705, 'GV2ME07', 'Motor Circuit Breaker 1.6-2.5A 100kA 0.75kW'),
(706, 'GV2ME08', 'Motor Circuit Breaker 2.5-4A 100kA 1.1/1.5kW'),
(707, 'GV2ME10', 'Motor Circuit Breaker 4-6.3A 100kA 2.2kW'),
(708, 'GV2ME14', 'Motor Circuit Breaker 6-10A 100kA 3/4kW'),
(709, 'GV2ME16', 'Motor Circuit Breaker 9-14A 15kA 5.5kW'),
(710, 'GV2ME20', 'Motor Circuit Breaker 13-18A 15kA 7.5kW'),
(711, 'GV2ME21', 'Motor Circuit Breaker 17-23A 15kA 9kW'),
(712, 'GV2ME22', 'Motor Circuit Breaker 20-25A 15kA 11kW'),
(713, 'GV2ME32', 'Motor Circuit Breaker 24-32A 10kA 15kW'),
(714, 'GV2P04', 'Motor Circuit Breaker 0.4-0.63A 100kA 0.12/0.18kW'),
(715, 'GV2P07', 'Motor Circuit Breaker 1.6-2.5A 100kA 0.75kW'),
(716, 'GV2P08', 'Motor Circuit Breaker 2.5-4A 100kA 1.1kW'),
(717, 'GV2P14', 'Motor Circuit Breaker 6-10A 100kA 3kW'),
(718, 'GV2P16', 'Motor Circuit Breaker 9-14A 100kA 5.5kW'),
(719, 'GV3ME80', 'Motor Circuit Breaker 56-80A 15kA 37kW'),
(720, 'GV3P40', 'Motor Circuit Breaker 30-40A 50kA 18.5kW'),
(721, 'GV3P50', 'Motor Circuit Breaker 37-50A 50kA 22kW'),
(722, 'GV3P65', 'Motor Circuit Breaker 48-65A 50kA 37kW'),
(723, 'GV7RE100', 'Motor Circuit Breaker 60-100A 36kA 45kW'),
(724, 'GV7RE150', 'Motor Circuit Breaker 90-150A 35kA 75kW'),
(725, 'GVAE11', 'Kontak Bantu Depan GV2 N/O+N/C'),
(726, 'GVAN11', 'Kontak Bantu Samping GV2 N/O+N/C'),
(727, 'HMIGXU3512', 'Magelis Easy GXU 7inch 48MB(aplikasi) 128KB(backup)'),
(728, 'HMIGXU5512', 'Magelis Easy GXU Universal 10inch 48MB(aplikasi) 128KB(backup)'),
(729, 'EZASHT200AC', 'Kontak Bantu EasyPact (Shunt Trip 200-277VAC)'),
(730, 'EZAUX01', 'Kontak Bantu EasyPact - Alarm Switch (AL)'),
(731, 'EZAUX10', 'Kontak Bantu EasyPact - Auxiliary Switch (AX)'),
(732, 'EZAUX11', 'Kontak Bantu EasyPact - Auxiliary Switch/Alarm Switch (AX/AL)'),
(733, 'EZEAXAL', 'Kontak Bantu EasyPact 250 - Auxiliary Switch/Alarm Switch (AX/AL)'),
(734, 'EZESHT200AC', 'Shunt Trip 200-240VAC'),
(735, 'LRD01', 'Thermal Overload Relay 0.10-0.16A Koneksi Standard'),
(736, 'LRD02', 'Thermal Overload Relay 0.16-0.25A Koneksi Standard'),
(737, 'LRD03', 'Thermal Overload Relay 0.25-0.40A Koneksi Standard'),
(738, 'LRD04', 'Thermal Overload Relay 0.40-0.63A Koneksi Standard'),
(739, 'LRD05', 'Thermal Overload Relay 0.63-1A Koneksi Standard'),
(740, 'LRD06', 'Thermal Overload Relay 1-1.6A Koneksi Standard'),
(741, 'LRD07', 'Thermal Overload Relay 1.6-2.5A Koneksi Standard'),
(742, 'LRD08', 'Thermal Overload Relay 2'),
(743, 'LRD10', 'Thermal Overload Relay 4-6A Koneksi Standard'),
(744, 'LRD12', 'Thermal Overload Relay 5.5-8A Koneksi Standard'),
(745, 'LRD14', 'Thermal Overload Relay 7-10A Koneksi Standard'),
(746, 'LRD16', 'Thermal Overload Relay 9-13A Koneksi Standard'),
(747, 'LRD21', 'Thermal Overload Relay 12-18A Koneksi Standard'),
(748, 'LRD22', 'Thermal Overload Relay 16-24A Koneksi Standard'),
(749, 'LRD32', 'Thermal Overload Relay 23-32A Koneksi Standard'),
(750, 'LRD35', 'Thermal Overload Relay 30-38A Koneksi Standard'),
(751, 'LRD332', 'Thermal Overload Relay 23-32A Koneksi EverLink'),
(752, 'LRD340', 'Thermal Overload Relay 30-40A Koneksi EverLink'),
(753, 'LRD350', 'Thermal Overload Relay 37-50A Koneksi EverLink'),
(754, 'LRD365', 'Thermal Overload Relay 48-65A Koneksi EverLink'),
(755, 'LRD3361', 'Thermal Overload Relay 55-70A Koneksi Standard'),
(756, 'LRD3363', 'Thermal Overload Relay 63-80A Koneksi Standard'),
(757, 'LRD4369', 'Thermal Overload Relay 110-140A Koneksi Standard'),
(758, 'LVR07250A40T', 'Detuned Reactor 25kVAR 1449mH'),
(759, 'LVR07500A40T', 'Detuned Reactor 50kVAR 0.75mH'),
(760, 'METSECT5CC004', 'Current Transformer 40/5A'),
(761, 'METSEDM1110', 'Ampere Meter Digital 1P 50mA-6A'),
(762, 'METSEDM3110', 'Ampere Meter Digital 3P 50mA-6A'),
(763, 'METSEDM3210', 'Volt Meter Digital 3P 80-480VAC L-L'),
(764, 'METSEDM6200HCL10RS', 'Digital Meter Seri 6200H dengan komunikasi'),
(765, 'METSEPM2120', 'Power Meter Seri 2000 LED dengan komunikasi'),
(766, 'METSEPM2230', 'Power Meter Seri 2000 LCD dengan komunikasi dan akurasi 0.5S'),
(767, 'METSEPM5100', 'PM5100 Pulse Output Acc 0.5S Single Tariff'),
(768, 'METSEPM5110', 'PM5110 Modbus RS-485 Acc 0.5S Single Tariff'),
(769, 'METSEPM5330', 'PM5330 Modbus RS-485 Acc 0.5S Single Tariff'),
(770, 'METSEPM5350', 'PM5350 Modbus RS-485 Acc 0.5S Single Tariff'),
(771, 'METSEPM5560', 'PM5560 Integrated Display Acc 0.2S Ethernet Port'),
(772, 'MVS08H4MF2A', 'ACB 4P 800A 65kA MVS08 Tipe Fixed'),
(773, 'MVS08N4MF2A', 'ACB 4P 800A 50kA MVS08 Tipe Fixed'),
(774, 'MVS10H4MF2A', 'ACB 4P 1000A 65kA MVS10 Tipe Fixed'),
(775, 'MVS10N3MF2A', 'ACB 3P 1000A 50kA MVS10 Tipe Fixed'),
(776, 'MVS10N4MF2A', 'ACB 4P 1000A 50kA MVS10 Tipe Fixed'),
(777, 'MVS12N4MF2A', 'ACB 4P 1250A 50kA MVS12 Tipe Fixed'),
(778, 'MVS16H3MF2A', 'ACB 3P 1600A 65kA MVS16 Tipe Fixed'),
(779, 'MVS16H4MF2A', 'ACB 4P 1600A 65kA MVS16 Tipe Fixed'),
(780, 'MVS16N3MF2A', 'ACB 3P 1600A 50kA MVS16 Tipe Fixed'),
(781, 'MVS20H4MF2A', 'ACB 4P 2000A 65kA MVS20 Tipe Fixed'),
(782, 'MVS20N3MF2A', 'ACB 3P 2000A 50kA MVS20 Tipe Fixed'),
(783, 'MVS20N4MF2A', 'ACB 4P 2000A 50kA MVS20 Tipe Fixed'),
(784, 'MVS25H3MF2A', 'ACB 3P 2500A 65kA MVS25 Tipe Fixed'),
(785, 'MVS25N3MF2A', 'ACB 3P 2500A 50kA MVS25 Tipe Fixed'),
(786, 'MVS32H3MF2A', 'ACB 3P 3200A 65kA MVS32 Tipe Fixed'),
(787, 'MVS32N3MF2A', 'ACB 3P 3200A 50kA MVS32 Tipe Fixed'),
(788, 'MVS40H4MF2A', 'ACB 4P 4000A 65kA MVS40 Tipe Fixed'),
(789, 'MVS40N3MF2A', 'ACB 3P 4000A 50kA MVS40 Tipe Fixed'),
(790, 'DOM11251SNI', 'MCB 1P 2A Domae'),
(791, 'NYA15H', 'Kabel NYA 1 x 1.5mm Hitam'),
(792, 'NYA15M', 'Kabel NYA 1 x 1.5mm Merah'),
(793, 'NYA15B', 'Kabel NYA 1 x 1.5 Biru'),
(794, 'NYA 15KH', 'Kabel NYA 1 x 1.5mm Kuning-Hijau'),
(795, 'NYAF15H', 'Kabel NYAF 1 x 1.5mm Hitam.'),
(796, 'NYAF15B', 'Kabel NYAF 1 x 1.5mm Biru'),
(797, 'NYAF15KH', 'Kabel NYAF 1 x 1.5mm Kuning-Hijau'),
(798, 'NYAF15M', 'Kabel NYAF 1 x 1.5mm Merah'),
(799, 'NYAF 05H', 'Kabel NYAF 1 x 0.50mm Hitam'),
(800, 'NYAF 05B', 'Kabel NYAF 1 x 0.50mm Biru'),
(801, 'NYAF 05M', 'Kabel NYAF 1 x 0.50mm Merah'),
(802, 'NYAF 05K', 'Kabel NYAF 1 x 0.50 Kuning'),
(803, 'NYAF 05KH', 'Kabel NYAF 1 x 0.50mm Kuning-Hijau'),
(804, 'NYAF075KH', 'Kabel NYAF 1 x 0.75mm Kuning-Hijau'),
(805, 'NYAF075B', 'Kabel NYAF 1 x 0.75mm Biru'),
(806, 'NYAF075K', 'Kabel NYAF 1 x 0.75mm Kuning'),
(807, 'NYAF075M', 'Kabel NYAF 1 x 0.75mm Merah'),
(808, 'NYAF075H', 'Kabel NYAF 1 x 0.75mm Hitam'),
(809, 'NYA25B', 'Kabel NYA 1 x 2.5mm Biru'),
(810, 'NYA25KH', 'Kabel NYA 1 x 2.5mm Kuning-Hijau'),
(811, 'NYA25M', 'Kabel NYA 1 x 2.5mm Merah'),
(812, 'NYA25H', 'Kabel NYA 1 x 2.5mm Hitam'),
(813, 'NYAF25M', 'Kabel NYAF 1 x 2.5mm Merah'),
(814, 'NYAF25B', 'Kabel NYAF 1 x 2.5mm Biru'),
(815, 'NYAF25KH', 'Kabel NYAF 1 x 2.5mm Kuning-Hijau'),
(816, 'NYAF25H', 'Kabel NYAF 1 x 2.5mm Hitam'),
(817, 'RE17RAMU', 'Timer RE17 solid-state-output 0,7A dengan fungsi ganda'),
(818, 'EZC100N3063', 'MCCB 3P 63A 18kA'),
(819, 'XB5AA42', 'Push button Harmony XB5 1N/C merah'),
(820, 'XB5AD33', 'Selector switch 3 posisi stay-put Harmony XB5 2N/O '),
(821, 'A9E21180', 'Command control tipe RCP 400V'),
(822, 'METSECT5DA150', 'Current Transformer 1500/5A'),
(823, 'XB7EV03MP', 'Pilot lamp Harmony XB7 hijau'),
(824, 'XB7EV04MP', 'Pilot lamp Harmony XB7 merah'),
(825, 'XB7EV05MP', 'Pilot lamp Harmony XB7 kuning'),
(826, 'XA2EVM3LC', 'Pilot lamp Harmony XA2 hijau'),
(827, 'XA2EVM4LC', 'Pilot lamp Harmony XA2 merah'),
(828, 'XA2EVM5LC', 'Pilot lamp Harmony XA2 jingga'),
(829, 'NYAF250H', 'Kabel NYAF 1 x 25 Hitam'),
(830, 'WM', 'Material lain untuk melakukan wiring pada panel'),
(831, 'CB1080', 'Rel busbar tembaga 10mm x 80mm'),
(832, 'CB1060', 'Rel busbar tembaga 10mm x 60mm'),
(833, 'CB530', 'Rel busbar tembaga 5mm x 30mm'),
(834, 'RXM2AB1P7', 'Relay plug-in 8 pin 2 kontak C/O 12A tanpa LED 230 VAC'),
(835, 'RXZE2M114M', 'Socket relay tercampur untuk RXM2 dan RXM4'),
(836, 'MB', 'Material bantu untuk melakukan wiring pada panel'),
(837, 'WF', 'Ongkos pelaksanaan wiring panel'),
(838, 'BP20002000500L', 'Box panel ukuran 2000mm x 2000mm x 500mm lokal'),
(839, 'BP20001000500L', 'Box panel ukuran 2000mm x 1000mm x 500mm lokal'),
(840, 'SAM3P-Fort', 'Selector automatic - manual 3P Fort'),
(841, 'LV432876', 'MCCB NSX 3P 250-630A dengan trip unit Micrologic 2.3'),
(842, 'EZC400N3300', 'MCCB EZC 3P 300A 36kA'),
(843, 'A9L40501', 'Surge Arrester PRD40r 1P+N 40kA 230V'),
(844, 'RXM4LB1P7', 'Relay plug-in 14 pin 4 kontak C/O 3A tanpa LED 230 VAC'),
(845, 'TRAFINDO32500DYN5', 'Transformer 3P 2500kVA Vector group DYN5 Trafindo '),
(846, 'N2XSY195SPLN24', 'Kabel N2XSY 1 x 95mm standar SPLN/SNI 24kV (tegangan menengah)'),
(847, 'NYY1300', 'Kabel NYY 1 x 300mm'),
(848, 'RAY395S', 'Outdoor termination 3 x 95mm single core - Raychem'),
(849, 'RAY195S', 'Outdoor termination 1 x 95mm single core - Raychem'),
(850, 'BP18003000700L', 'Box panel ukuran 1800mm x 3000mm x 700mm lokal'),
(851, '47342', '\"Ready to close\" contact (PF) fixed type'),
(852, 'MVS40N4MF2A', 'ACB 4P 4000A 50kA MVS40 Tipe Fixed'),
(854, 'LV432676', 'MCCB NSX 3P 160-400A dengan trip unit Micrologic 2.3'),
(855, 'CB10150', 'Rel busbar tembaga 10mm x 150mm'),
(856, 'CB10100', 'Rel busbar tembaga 10mm x 100mm'),
(857, 'CB1040', 'Rel busbar tembaga 10mm x 40mm'),
(858, 'A9R71440', 'RCCB iID 4P 40A 30mA'),
(859, 'BP18002200700L', 'Box panel ukuran 1800mm x 2200mm x 700mm lokal'),
(860, 'VPL12N', 'Regulator kapasitor Varplus Logic 12 step'),
(861, 'CB315', 'Rel busbar tembaga 3mm x 15mm'),
(862, 'METSECT5MA040', 'Current Transformer 400/5A'),
(863, 'NYY34', 'Kabel NYY 3 x 4mm'),
(864, 'METSECT5DC400', 'Current Transformer 4000/5A'),
(865, 'METSECT5DA125', 'Current Transformer 1250/5A'),
(866, 'F-SM6R-IM-A1', 'SM6-24 IM500 LBS SM6 Man 630A, use CIT manual cubicle'),
(867, 'F-SM6R-QM-A1', 'SM6-24 QM500 LBS Man630A,CI1,op. coil220Vac,T. Fuse, F. Holder DIN cubicle'),
(869, 'RXM4AB1P7', 'Relay plug-in 14 pin 4 kontak C/O 6A tanpa LED 230 VAC		'),
(870, 'XB5AW33M5', 'Illuminated push button Harmony XB5 hijau 230...240 V AC'),
(871, 'XB5AW34M5', 'Illuminated push button Harmony XB5 merah 230...240 V AC'),
(872, 'BP18001800700L', 'Box panel ukuran 1800mm x 1800mm x 700mm lokal'),
(873, 'MVS12N3MF2A', 'ACB 3P 1250A 50kA MVS12 Tipe Fixed'),
(874, 'EZC400N3400N', 'MCCB 3P 400A 36kA'),
(875, 'CB8100', 'Rel busbar tembaga 8mm x 100mm'),
(876, 'CB320', 'Rel busbar tembaga 3mm x 20mm'),
(877, 'NYAF100H', 'Kabel NYAF 10mm hitam'),
(878, 'BP1800600700L', 'Box panel ukuran 1800mm x 600mm x 700mm lokal'),
(879, 'CB325', 'Rel busbar tembaga 3mm x 25mm'),
(880, 'METSECT5MA025', 'Current Transformer 250/5A'),
(881, 'BP800600250L', 'Box panel ukuran 800mm x 600mm x 250mm lokal'),
(882, 'METSECT5CC013', 'Current Transformer 125/5A'),
(883, 'METSECT5CC015', 'Current Transformer 150/5A'),
(884, 'NYY1240', 'Kabel NYY 1 x 240mm'),
(885, 'NYY195', 'Kabel NYY 1 x 95mm'),
(886, 'NYY470', 'Kabel NYY 4 x 70mm'),
(887, 'BC25', 'Kabel bare cooper 25mm'),
(888, 'NYM215', 'Kabel NYM 2 x 1,5mm'),
(889, 'NYM315', 'Kabel NYM 3 x 1,5mm'),
(890, 'NYM325', 'Kabel NYM 3 x 2,5mm'),
(891, '51006543M0', 'MV fuse cubicle 24kV, DIN standard, 31,5A'),
(892, 'NYY150', 'Kabel NYY 1 x 50mm'),
(893, 'NYY1185', 'Kabel NYY 1 x 185mm'),
(894, 'NYY1150', 'Kabel NYY 1 x 150mm'),
(895, 'NYY450', 'Kabel NYY 4 x 50mm'),
(896, 'NYY435', 'Kabel NYY 4 x 35mm'),
(897, 'NYY425', 'Kabel NYY 4 x 25mm'),
(898, 'NYY416', 'Kabel NYY 4 x 16mm'),
(899, 'NYY410', 'Kabel NYY 4 x 10mm'),
(900, 'NYY46', 'Kabel NYY 4 x 6mm'),
(901, 'NYY42', 'Kabel NYY 4 x 2,5mm'),
(902, 'LADN22', 'Kontak bantu seketika dengan 2 N/O dan 2 N/C untuk kontaktor Tesys'),
(903, 'NYFGBY295', 'Kabel NYFGbY 2 x 95mm'),
(904, 'NYFGBY270', 'Kabel NYFGbY 2 x 70mm'),
(905, 'NYFGBY250', 'Kabel NYFGbY 2 x 50mm'),
(906, 'NYFGBY34', 'Kabel NYFGbY 3 x 4mm'),
(907, 'NYFGBY42', 'Kabel NYFGbY 4 x 2,5mm'),
(908, 'NYFGBY46', 'Kabel NYFGbY 4 x 6mm'),
(909, 'NYFGBY416', 'Kabel NYFGbY 4 x 16mm'),
(910, 'NYFGBY425', 'Kabel NYFGbY 4 x 25mm'),
(911, 'NYFGBY470', 'Kabel NYFGbY 4 x 70mm'),
(912, 'NYFGBY4240', 'Kabel NYFGbY 4 x 240mm'),
(913, 'NYFGBY4185', 'Kabel NYFGbY 4 x 185mm'),
(914, 'NYFGBY410', 'Kabel NYFGbY 4 x 10mm'),
(915, 'NYFGBY4300', 'Kabel NYFGbY 4 x 300mm'),
(916, 'NYY44', 'Kabel NYY 4 x 4mm'),
(917, 'NYA70H', 'Kabel NYA 70mm hitam'),
(918, 'BC95', 'Kabel bare cooper 95mm'),
(919, 'BC70', 'Kabel bare cooper 70mm'),
(920, 'BC50', 'Kabel bare cooper 50mm'),
(921, 'BC16', 'Kabel bare cooper 16mm'),
(922, 'BC10', 'Kabel bare cooper 10mm'),
(923, 'BC6', 'Kabel bare cooper 6mm'),
(924, 'NYYHY42', 'Kabel NYYHY 4 x 2,5mm'),
(925, 'NYYHY435', 'Kabel NYYHY 4 x 35mm'),
(927, 'NYYHY416', 'Kabel NYYHY 4 x 16mm'),
(928, '51006503M0', 'MV fuse cubicle 24kV, DIN standard, 20A'),
(929, 'F-SM6-EP-M', 'SM6-end cover panel mirroring'),
(930, 'D00400C60', 'Transformer 3P 400kVA 50Hz 20kV DYN5 - Schneider'),
(931, 'SC300-16', 'Schoen tembaga 300mm dengan lubang baut M16'),
(932, 'RAY170S', 'Outdoor termination 1 x 70mm single core - Raychem'),
(933, 'CL1200100L', 'Cable Ladder 1200mm x 100mm x 3000mm lokal'),
(934, 'CL800100L', 'Cable ladder 800mm x 100mm x 3000mm lokal'),
(935, 'CLR1200800', 'Reducer cable ladder 1200mm - 800mm'),
(936, 'NYYHY44', 'Kabel NYYHY 4 x 4mm'),
(937, 'NYY1400', 'Kabel NYY 1 x 400mm'),
(938, 'NYM41', 'Kabel NYM 4 x 1,5mm');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(255) NOT NULL,
  `payment_term` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `payment_term`) VALUES
(1, 'Cash before delivery'),
(2, 'Check'),
(3, 'Payement at x days after delivery date'),
(4, 'x% down payment and repayment after y days');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `id` int(255) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `price_list` bigint(255) NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `unitprice` bigint(255) NOT NULL,
  `quantity` int(100) NOT NULL,
  `totalprice` int(255) NOT NULL,
  `purchaseorder_id` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`id`, `reference`, `price_list`, `discount`, `unitprice`, `quantity`, `totalprice`, `purchaseorder_id`, `status`) VALUES
(1, 'DOM11342SNI', 125000, '10', 112500, 100, 11250000, '1', 0),
(2, 'A9F74340', 190909, '50', 95455, 120, 11454545, '2', 0),
(3, '51213', 100000, '10', 90000, 100, 9000000, '3', 0),
(4, '51213', 100000, '10', 90000, 100, 9000000, '4', 0),
(5, 'DOM12252SNI', 100000, '10', 90000, 120, 10800000, '4', 0),
(6, '51213', 1000000, '10', 900000, 100, 90000000, '5', 0),
(7, '51213', 120000, '10', 108000, 100, 10800000, '6', 0),
(8, 'LC1D40AF7', 5000000, '45', 2750000, 10, 27500000, '7', 0),
(9, 'LC1D09D7', 100000, '45', 55000, 10, 550000, '7', 0),
(10, 'A9L15586', 100000, '45', 55000, 100, 5500000, '7', 0),
(11, '51213', 100000, '10', 90000, 100, 9000000, '8', 0),
(12, 'DOM11341SNI', 100000, '10', 90000, 100, 9000000, '9', 0),
(13, 'A9K14125', 100000, '10', 90000, 100, 9000000, '9', 0),
(14, 'A9K14320', 100000, '10', 90000, 100, 9000000, '9', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_received`
--

CREATE TABLE `purchaseorder_received` (
  `id` int(255) NOT NULL,
  `refference` varchar(255) NOT NULL,
  `purchaseorder_id` varchar(50) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `id` int(255) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `price_list` int(11) NOT NULL,
  `discount` decimal(11,0) NOT NULL,
  `net_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(255) NOT NULL,
  `quotation_code` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `reference`, `price_list`, `discount`, `net_price`, `quantity`, `total_price`, `quotation_code`) VALUES
(71, 'MVS10N3MF2A', 16785600, '50', 8392800, 1, 8392800, 46),
(72, '48212', 10465000, '40', 6279000, 1, 6279000, 46),
(73, 'LVR07250A40T', 10465000, '40', 6279000, 2, 12558000, 46),
(74, 'BLRCH500A000B40', 300000, '10', 270000, 100, 27000000, 46),
(75, 'GV7RE100', 2580000, '41', 1522200, 10, 15222000, 47),
(76, 'GV7RE100', 2580000, '41', 1522200, 10, 15222000, 48),
(77, 'NYAF 15H', 1000, '0', 1000, 1000, 1000000, 49),
(78, 'NYAF 15B', 1000, '0', 1000, 1000, 1000000, 49),
(79, 'NYAF 15KH', 1000, '0', 1000, 1000, 1000000, 49),
(80, 'A9F74110', 133650, '40', 80190, 12, 962280, 50),
(81, 'A9F84116', 133650, '40', 80190, 27, 2165130, 50),
(82, 'A9F84132', 290400, '40', 174240, 2, 348480, 50),
(83, 'A9F84325', 902550, '40', 541530, 2, 1083060, 50),
(84, 'LV510304', 1185800, '40', 711480, 1, 711480, 50),
(94, '51213', 100000, '10', 90000, 100, 9000000, 51),
(95, 'GVAE11', 100000, '10', 90000, 100, 9000000, 51),
(405, 'EZC100N3100', 951500, '42', 551870, 3, 1655610, 53),
(406, 'LC1D65AM7', 2254000, '36', 1442560, 6, 8655360, 53),
(407, 'LRD332', 1050000, '36', 672000, 3, 2016000, 53),
(408, 'RE17RAMU', 457050, '42', 265089, 3, 795267, 53),
(409, 'DOM11340SNI', 66550, '30', 46585, 3, 139755, 53),
(410, 'XB5AA42', 63250, '42', 36685, 3, 110055, 53),
(411, 'SAM3P-Fort', 122100, '42', 70818, 3, 212454, 53),
(412, 'A9E21180', 1572450, '42', 912021, 1, 912021, 53),
(413, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 53),
(414, 'METSECT5DA150', 1026300, '35', 667095, 3, 2001285, 53),
(415, 'XA2EVM3LC', 28600, '42', 16588, 1, 16588, 53),
(416, 'XA2EVM4LC', 28600, '42', 16588, 1, 16588, 53),
(417, 'XA2EVM5LC', 28600, '42', 16588, 1, 16588, 53),
(418, 'NYAF250H', 34789, '0', 34789, 50, 1739450, 53),
(419, 'NYAF075KH', 1450, '0', 1450, 200, 290000, 53),
(420, 'NYAF075B', 1450, '0', 1450, 100, 145000, 53),
(421, 'EZC250H3200', 2187900, '42', 1268982, 1, 1268982, 53),
(422, 'CB1080', 3723200, '0', 3723200, 1, 3723200, 53),
(423, 'CB1060', 2795000, '0', 2795000, 2, 5590000, 53),
(424, 'CB530', 700700, '0', 700700, 1, 700700, 53),
(425, 'RXM2AB1P7', 91300, '42', 52954, 3, 158862, 53),
(426, 'RXZE2M114M', 42350, '42', 24563, 3, 73689, 53),
(427, 'BP20001000500L', 8000000, '0', 8000000, 1, 8000000, 53),
(428, 'WM', 1875000, '0', 1875000, 1, 1875000, 53),
(429, 'MB', 550000, '0', 550000, 1, 550000, 53),
(430, 'WF', 6000000, '0', 6000000, 1, 6000000, 53),
(431, 'EZC100N3100', 951500, '42', 551870, 12, 6622440, 52),
(432, 'LC1D65AM7', 2254000, '36', 1442560, 24, 34621440, 52),
(433, 'LRD332', 1050000, '36', 672000, 12, 8064000, 52),
(434, 'RE17RAMU', 457050, '42', 265089, 12, 3181068, 52),
(435, 'DOM11340SNI', 66550, '30', 46585, 12, 559020, 52),
(436, 'XB5AA42', 63250, '42', 36685, 12, 440220, 52),
(437, 'SAM3P-Fort', 122100, '42', 70818, 12, 849816, 52),
(438, 'A9E21180', 1572450, '42', 912021, 1, 912021, 52),
(439, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 52),
(440, 'METSECT5DA150', 1026300, '35', 667095, 3, 2001285, 52),
(441, 'XA2EVM3LC', 28600, '42', 16588, 1, 16588, 52),
(442, 'XA2EVM4LC', 28600, '42', 16588, 1, 16588, 52),
(443, 'XA2EVM5LC', 28600, '42', 16588, 1, 16588, 52),
(444, 'NYAF250H', 34789, '0', 34789, 100, 3478900, 52),
(445, 'NYAF075KH', 1450, '0', 1450, 300, 435000, 52),
(446, 'NYAF075B', 1450, '0', 1450, 300, 435000, 52),
(447, '33466', 16940000, '42', 9825200, 1, 9825200, 52),
(448, 'CB1080', 3723200, '0', 3723200, 5, 18616000, 52),
(449, 'CB1060', 2795000, '0', 2795000, 2, 5590000, 52),
(450, 'CB530', 700700, '0', 700700, 2, 1401400, 52),
(451, 'RXM2AB1P7', 91300, '42', 52954, 12, 635448, 52),
(452, 'RXZE2M114M', 42350, '42', 24563, 12, 294756, 52),
(453, 'BP20002000500L', 16000000, '0', 16000000, 1, 16000000, 52),
(454, 'WM', 2500000, '0', 2500000, 1, 2500000, 52),
(455, 'MB', 750000, '0', 750000, 1, 750000, 52),
(456, 'WF', 10000000, '0', 10000000, 1, 10000000, 52),
(457, 'EZC100N3100', 951500, '42', 556628, 5, 2783138, 54),
(458, 'LC1D65AM7', 2254000, '36', 1442560, 10, 14425600, 54),
(459, 'LRD332', 1050000, '36', 672000, 5, 3360000, 54),
(460, 'RE17RAMU', 457050, '42', 267374, 5, 1336871, 54),
(461, 'DOM11340SNI', 66550, '30', 46585, 5, 232925, 54),
(462, 'XB5AA42', 63250, '42', 37001, 5, 185006, 54),
(463, 'SAM3P-Fort', 122100, '42', 71429, 5, 357143, 54),
(464, 'A9E21180', 1572450, '42', 919883, 1, 919883, 54),
(465, 'METSEDM6200HCL10', 1538900, '35', 1000285, 1, 1000285, 54),
(466, 'METSECT5DA150', 1026300, '35', 667095, 3, 2001285, 54),
(467, 'XA2EVM3LC', 28600, '42', 16731, 1, 16731, 54),
(468, 'XA2EVM4LC', 28600, '42', 16731, 1, 16731, 54),
(469, 'XA2EVM5LC', 28600, '42', 16731, 1, 16731, 54),
(470, 'NYAF250H', 34789, '0', 34789, 100, 3478900, 54),
(471, 'NYAF075KH', 1450, '0', 1450, 200, 290000, 54),
(472, 'NYAF075B', 1450, '0', 1450, 100, 145000, 54),
(473, 'EZC400N3300', 3646500, '42', 2133203, 1, 2133203, 54),
(474, 'CB1080', 3723200, '0', 3723200, 1, 3723200, 54),
(475, 'CB1060', 2795000, '0', 2795000, 2, 5590000, 54),
(476, 'CB530', 700700, '0', 700700, 1, 700700, 54),
(477, 'RXM2AB1P7', 91300, '42', 53411, 5, 267053, 54),
(478, 'RXZE2M114M', 42350, '42', 24775, 5, 123874, 54),
(479, 'BP20001000500L', 8000000, '0', 8000000, 1, 8000000, 54),
(480, 'WM', 1875000, '0', 1875000, 1, 1875000, 54),
(481, 'MB', 550000, '0', 550000, 1, 550000, 54),
(482, 'WF', 4000000, '0', 4000000, 1, 4000000, 54),
(483, 'A9L40501', 1452550, '35', 944158, 1, 944158, 55),
(484, 'LRD07', 388000, '35', 252200, 1, 252200, 55),
(485, 'LRD10', 388000, '35', 252200, 1, 252200, 55),
(486, 'A9F74316', 512050, '35', 332833, 1, 332833, 56),
(487, 'DOM12251SNI', 81950, '30', 57365, 1, 57365, 56),
(488, 'DOM12252SNI', 81950, '30', 57365, 1, 57365, 56),
(489, 'RE17RAMU', 457050, '35', 297083, 1, 297083, 56),
(490, 'RXM4LB1P7', 60500, '35', 39325, 1, 39325, 56),
(491, 'A9K14325', 451000, '40', 270600, 4, 1082400, 57),
(738, 'BP800600250L', 1500000, '0', 1500000, 1, 1500000, 64),
(739, 'EZC250F3125', 1483020, '37', 934303, 1, 934303, 64),
(740, 'DOM11351SNI', 331650, '30', 232155, 6, 1392930, 64),
(741, 'DOM11342SNI', 63525, '30', 44468, 15, 667013, 64),
(742, 'XB7EV03MP', 58223, '37', 36680, 1, 36680, 64),
(743, 'XB7EV04MP', 58223, '37', 36680, 1, 36680, 64),
(744, 'XB7EV05MP', 58223, '37', 36680, 1, 36680, 64),
(745, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 64),
(746, 'METSECT5CC015', 380600, '35', 247390, 3, 742170, 64),
(757, 'NYY1240', 318000, '7', 295740, 1980, 585565200, 65),
(758, 'NYY195', 138000, '7', 128340, 104, 13347360, 65),
(759, 'NYY470', 400000, '7', 372000, 100, 37200000, 65),
(760, 'BC25', 27039, '0', 27039, 220, 5948663, 65),
(761, 'NYM215', 5904, '2', 5786, 300, 1735776, 66),
(762, 'NYM315', 7574, '2', 7423, 400, 2969008, 66),
(763, 'NYM325', 10800, '2', 10584, 400, 4233600, 66),
(764, 'N2XSY195SPLN24', 224952, '0', 224952, 546, 122823792, 67),
(765, 'NYY1300', 410000, '7', 381300, 252, 96087600, 67),
(766, 'RAY395S', 2500000, '0', 2500000, 2, 5000000, 67),
(767, 'RAY195S', 2500000, '0', 2500000, 2, 5000000, 67),
(768, 'F-SM6R-IM-A1', 33000000, '0', 33000000, 1, 33000000, 68),
(769, 'F-SM6R-QM-A1', 47500000, '0', 47500000, 1, 47500000, 68),
(770, '51006543M0', 1500000, '0', 1500000, 3, 4500000, 68),
(771, 'A9F74340', 598950, '30', 419265, 1, 419265, 69),
(772, 'DOM11353SNI', 375650, '30', 262955, 1, 262955, 69),
(773, 'NYY195', 138000, '7', 128340, 150, 19251000, 70),
(774, 'NYY150', 73000, '7', 67890, 50, 3394500, 70),
(775, 'NYY1240', 318000, '7', 295740, 3400, 1005516000, 70),
(776, 'NYY1185', 245000, '7', 227850, 1570, 357724500, 70),
(777, 'NYY1150', 206000, '7', 191580, 438, 83912040, 70),
(778, 'NYY450', 280000, '7', 260400, 120, 31248000, 70),
(779, 'NYY435', 210000, '7', 195300, 810, 158193000, 70),
(780, 'NYY425', 156000, '7', 145080, 100, 14508000, 70),
(781, 'NYY416', 100000, '7', 93000, 360, 33480000, 70),
(782, 'NYY410', 66045, '7', 61422, 70, 4299530, 70),
(783, 'NYY46', 38967, '7', 36239, 25, 905983, 70),
(784, 'NYY42', 21380, '7', 19883, 225, 4473765, 70),
(785, 'MVS40N4MF2A', 108044200, '37', 68067846, 1, 68067846, 58),
(786, '48212', 10985205, '37', 6920679, 3, 20762037, 58),
(787, '47353', 1947330, '37', 1226818, 3, 3680454, 58),
(788, '47363', 1947330, '37', 1226818, 3, 3680454, 58),
(789, '47342', 1156100, '37', 728343, 3, 2185029, 58),
(790, 'MVS12N4MF2A', 32433555, '37', 20433140, 2, 40866279, 58),
(791, 'LV432676', 6448200, '37', 4062366, 4, 16249464, 58),
(792, 'CB10150', 7033000, '0', 7033000, 7, 49231000, 58),
(793, 'CB10100', 4680000, '0', 4680000, 5, 23400000, 58),
(794, 'CB1040', 1865500, '0', 1865500, 2, 3731000, 58),
(795, 'METSEPM5560', 15224000, '35', 9895600, 1, 9895600, 58),
(796, 'METSECT5DC400', 2004200, '35', 1302730, 3, 3908190, 58),
(797, 'METSECT5DA125', 942700, '35', 612755, 6, 3676530, 58),
(798, 'METSECT5MA040', 487300, '35', 316745, 12, 3800940, 58),
(799, 'XB7EV03MP', 58223, '37', 36680, 7, 256761, 58),
(800, 'XB7EV04MP', 58223, '37', 36680, 7, 256761, 58),
(801, 'XB7EV05MP', 58223, '37', 36680, 7, 256761, 58),
(802, 'A9E21180', 1527450, '37', 962294, 1, 962294, 58),
(803, 'DOM11340SNI', 63525, '30', 44468, 3, 133403, 58),
(804, 'A9R71440', 1171170, '37', 737837, 1, 737837, 58),
(805, 'BP18002200700L', 18000000, '0', 18000000, 1, 18000000, 59),
(806, 'VPL12N', 10396155, '0', 10396155, 1, 10396155, 59),
(807, 'MVS25N3MF2A', 45666500, '37', 28769895, 1, 28769895, 59),
(808, 'LV510337', 1256640, '37', 791683, 30, 23750496, 59),
(809, 'LC1D115M7', 3395700, '37', 2139291, 30, 64178730, 59),
(810, 'BLRCH500A000B40', 6055665, '37', 3815069, 30, 114452069, 59),
(811, 'RXZE2M114M', 42350, '37', 26681, 9, 240125, 59),
(812, 'RXM4AB1P7', 93500, '37', 58905, 12, 706860, 59),
(813, 'XB5AW33M5', 167750, '37', 105683, 12, 1268190, 59),
(814, 'XB5AA42', 63250, '37', 39848, 12, 478170, 59),
(815, 'CB10100', 4680000, '0', 4680000, 5, 23400000, 59),
(816, 'CB315', 209300, '0', 209300, 18, 3767400, 59),
(817, 'METSECT5DC400', 2004200, '35', 1302730, 1, 1302730, 59),
(818, 'XB7EV03MP', 58223, '37', 36680, 1, 36680, 59),
(819, 'XB7EV04MP', 58223, '37', 36680, 1, 36680, 59),
(820, 'XB7EV05MP', 58223, '37', 36680, 1, 36680, 59),
(821, 'NYAF250H', 34789, '0', 34789, 160, 5566240, 59),
(822, 'SAM3P-Fort', 122100, '35', 79365, 1, 79365, 59),
(823, 'NYY1300', 381300, '0', 381300, 72, 27453600, 59),
(824, 'BP18001800700L', 18000000, '0', 18000000, 1, 18000000, 60),
(825, 'MVS12N3MF2A', 26242755, '0', 26242755, 1, 26242755, 60),
(826, 'EZC400N3400N', 3754905, '37', 2365590, 2, 4731180, 60),
(827, 'EZC250F3250', 1604295, '37', 1010706, 2, 2021412, 60),
(828, 'EZC250F3160', 1523445, '37', 959770, 3, 2879311, 60),
(829, 'LV510337', 1256640, '37', 791683, 6, 4750099, 60),
(830, 'DOM11351SNI', 331650, '30', 232155, 3, 696465, 60),
(831, 'DOM11342SNI', 63525, '30', 44468, 6, 266805, 60),
(832, 'CB1080', 3723200, '0', 3723200, 3, 11169600, 60),
(833, 'CB530', 700700, '0', 700700, 3, 2102100, 60),
(834, 'CB320', 286000, '0', 286000, 3, 858000, 60),
(835, 'CB315', 209300, '0', 209300, 6, 1255800, 60),
(836, 'XB7EV03MP', 58223, '37', 36680, 1, 36680, 60),
(837, 'XB7EV04MP', 58223, '37', 36680, 1, 36680, 60),
(838, 'XB7EV05MP', 58223, '37', 36680, 1, 36680, 60),
(839, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 60),
(840, 'METSECT5DA125', 942700, '35', 612755, 3, 1838265, 60),
(841, 'NYAF100H', 13513, '0', 13513, 10, 135130, 60),
(842, 'BP18001800700L', 18000000, '37', 11340000, 1, 11340000, 61),
(843, 'MVS12N3MF2A', 27687000, '37', 17442810, 1, 17442810, 61),
(844, 'LV432676', 6448200, '37', 4062366, 2, 8124732, 61),
(845, 'EZC250F3250', 1604295, '37', 1010706, 2, 2021412, 61),
(846, 'EZC250F3160', 1523445, '37', 959770, 3, 2879311, 61),
(847, 'LV510337', 1256640, '37', 791683, 6, 4750099, 61),
(848, 'DOM11351SNI', 331650, '30', 232155, 3, 696465, 61),
(849, 'DOM11342SNI', 63525, '30', 44468, 6, 266805, 61),
(850, 'CB1080', 3723200, '0', 3723200, 3, 11169600, 61),
(851, 'CB530', 700700, '0', 700700, 3, 2102100, 61),
(852, 'CB320', 286000, '0', 286000, 3, 858000, 61),
(853, 'CB315', 209300, '0', 209300, 6, 1255800, 61),
(854, 'XB7EV03MP', 58223, '37', 36680, 1, 36680, 61),
(855, 'XB7EV04MP', 58223, '37', 36680, 1, 36680, 61),
(856, 'XB7EV05MP', 58223, '37', 36680, 1, 36680, 61),
(857, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 61),
(858, 'METSECT5DA125', 942700, '35', 612755, 3, 1838265, 61),
(859, 'NYAF100H', 13513, '0', 13513, 10, 135130, 61),
(860, 'BP1800600700L', 6000000, '0', 6000000, 1, 6000000, 62),
(861, 'EZC250F3250', 1604295, '37', 1010706, 1, 1010706, 62),
(862, 'LV510337', 1256640, '37', 791683, 2, 1583366, 62),
(863, 'EZC100B3050', 658900, '37', 415107, 5, 2075535, 62),
(864, 'DOM11351SNI', 331650, '30', 232155, 3, 696465, 62),
(865, 'DOM11342SNI', 63525, '30', 44468, 6, 266805, 62),
(866, 'CB325', 351000, '0', 351000, 2, 702000, 62),
(867, 'CB315', 209300, '0', 209300, 3, 627900, 62),
(868, 'XB7EV03MP', 58223, '37', 36680, 1, 36680, 62),
(869, 'XB7EV04MP', 58223, '37', 36680, 1, 36680, 62),
(870, 'XB7EV05MP', 58223, '37', 36680, 1, 36680, 62),
(871, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 62),
(872, 'METSECT5MA025', 380600, '35', 247390, 3, 742170, 62),
(883, 'BP800600250L', 1500000, '0', 1500000, 1, 1500000, 63),
(884, 'EZC250F3125', 1483020, '37', 934303, 1, 934303, 63),
(885, 'DOM11351SNI', 331650, '30', 232155, 6, 1392930, 63),
(886, 'DOM11342SNI', 63525, '30', 44468, 15, 667013, 63),
(887, 'XB7EV03MP', 58223, '37', 36680, 1, 36680, 63),
(888, 'XB7EV04MP', 58223, '37', 36680, 1, 36680, 63),
(889, 'XB7EV05MP', 58223, '37', 36680, 1, 36680, 63),
(890, 'METSEDM6200HCL10RS', 1538900, '35', 1000285, 1, 1000285, 63),
(891, 'CB325', 351000, '0', 351000, 1, 351000, 63),
(892, 'METSECT5CC015', 380600, '35', 247390, 3, 742170, 63),
(893, 'LADN22', 214500, '40', 128700, 1, 128700, 71),
(894, 'DOM11340SNI', 66550, '30', 46585, 3, 139755, 72),
(895, 'A9K14110', 93500, '35', 60775, 2, 121550, 72),
(896, 'A9K14320', 426250, '35', 277063, 1, 277063, 72),
(897, 'NYFGBY295', 300970, '0', 300970, 800, 240776000, 73),
(898, 'NYFGBY470', 369150, '0', 369150, 1220, 450363000, 73),
(899, 'NYFGBY250', 172445, '0', 172445, 1320, 227627400, 73),
(900, 'NYFGBY34', 31575, '0', 31575, 3920, 123774000, 73),
(901, 'NYFGBY42', 25255, '0', 25255, 924, 23335620, 73),
(902, 'NYFGBY46', 43765, '0', 43765, 80, 3501200, 73),
(903, 'NYFGBY410', 67905, '0', 67905, 379, 25735995, 73),
(904, 'NYFGBY416', 100025, '0', 100025, 574, 57414350, 73),
(905, 'NYFGBY425', 161230, '0', 161230, 1761, 283926030, 73),
(906, 'NYFGBY470', 369150, '0', 369150, 77, 28424550, 73),
(907, 'NYFGBY4240', 1405125, '0', 1405125, 300, 421537500, 73),
(908, 'NYFGBY4185', 1026130, '0', 1026130, 98, 100560740, 73),
(909, 'NYFGBY4300', 1580390, '0', 1580390, 93, 146976270, 73),
(910, 'NYY1300', 368510, '0', 368510, 240, 88442400, 73),
(911, 'NYY1185', 220210, '0', 220210, 848, 186738080, 73),
(912, 'NYY410', 61485, '0', 61485, 30, 1844550, 73),
(913, 'NYY44', 27935, '0', 27935, 15, 419025, 73),
(914, 'NYM325', 10980, '0', 10980, 980, 10760400, 73),
(915, 'NYA70H', 99500, '0', 99500, 24, 2388000, 73),
(916, 'BC95', 103120, '0', 103120, 136, 14024320, 73),
(917, 'BC70', 77770, '0', 77770, 1026, 79792020, 73),
(918, 'BC50', 55250, '0', 55250, 324, 17901000, 73),
(919, 'BC16', 17845, '0', 17845, 1838, 32799110, 73),
(920, 'BC10', 10710, '0', 10710, 983, 10527930, 73),
(921, 'BC6', 9400, '0', 9400, 1019, 9578600, 73),
(922, 'A9F74306', 512050, '35', 332833, 8, 2662660, 74),
(923, 'LV510303', 1185800, '40', 711480, 2, 1422960, 75),
(924, 'NYAF075KH', 1419, '0', 1419, 100, 141883, 76),
(925, 'NYAF075B', 1419, '0', 1419, 100, 141883, 76),
(926, 'NYAF075K', 1419, '0', 1419, 100, 141883, 76),
(927, 'NYAF075M', 1419, '0', 1419, 100, 141883, 76),
(928, 'NYAF075H', 1419, '0', 1419, 100, 141883, 76),
(929, 'NYAF15KH', 1908, '0', 1908, 100, 190808, 76),
(930, 'NYAF15B', 1908, '0', 1908, 100, 190808, 76),
(931, 'NYAF15H', 1908, '0', 1908, 100, 190808, 76),
(932, 'NYAF15M', 1908, '0', 1908, 100, 190808, 76),
(933, 'DOM12252SNI', 81950, '34', 54087, 60, 3245220, 77),
(934, 'DOM11340SNI', 66550, '34', 43923, 60, 2635380, 77),
(935, 'DOM11341SNI', 66550, '34', 43923, 60, 2635380, 77),
(936, 'DOM11342SNI', 66550, '34', 43923, 36, 1581228, 77),
(937, 'NYYHY42', 20360, '10', 18324, 100, 1832400, 78),
(938, 'NYYHY435', 200000, '0', 200000, 200, 40000000, 78),
(939, 'NYYHY416', 102600, '0', 102600, 65, 6669000, 78),
(945, 'F-SM6R-IM-A1', 31993390, '0', 31993390, 1, 31993390, 80),
(946, 'F-SM6R-QM-A1', 47751545, '0', 47751545, 1, 47751545, 80),
(947, '51006503M0', 990138, '0', 990138, 3, 2970414, 80),
(948, 'F-SM6-EP-M', 4284651, '0', 4284651, 1, 4284651, 80),
(949, 'D00400C60', 96250000, '0', 96250000, 1, 96250000, 80),
(950, 'N2XSY195SPLN24', 178000, '0', 178000, 20, 3559996, 81),
(951, '47383', 1139189, '0', 1139189, 2, 2278377, 81),
(952, 'SC300-16', 38500, '0', 38500, 6, 231000, 81),
(953, 'RAY170S', 2500000, '0', 2500000, 2, 5000000, 81),
(954, 'CL1200100L', 1290000, '0', 1290000, 3, 3870000, 81),
(955, 'CL800100L', 1016200, '0', 1016200, 5, 5081000, 81),
(956, 'CLR1200800', 0, '0', 0, 1, 0, 81),
(957, 'NYAF25KH', 2727, '0', 2727, 200, 545454, 82),
(958, 'NYA25M', 2727, '0', 2727, 1000, 2727270, 82),
(959, 'NYA25H', 2727, '0', 2727, 1000, 2727270, 82),
(960, 'NYYHY44', 26657, '0', 26657, 5000, 133285000, 82),
(961, 'NYAF25H', 2909, '0', 2909, 2000, 5818180, 82),
(962, 'NYAF25M', 2909, '0', 2909, 2000, 5818180, 82),
(963, 'NYY150', 63510, '0', 63510, 1000, 63510000, 82),
(964, 'NYY1400', 356700, '0', 356700, 1000, 356700000, 82),
(965, 'NYM41', 9158, '2', 8975, 3000, 26924520, 82),
(966, 'NYY435', 182700, '0', 182700, 1000, 182700000, 82);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `id` int(11) NOT NULL,
  `reference` varchar(200) NOT NULL,
  `price` int(255) NOT NULL,
  `discount` int(3) NOT NULL,
  `price_list` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `total_price` int(255) NOT NULL,
  `so_id` int(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_order`
--

INSERT INTO `sales_order` (`id`, `reference`, `price`, `discount`, `price_list`, `quantity`, `total_price`, `so_id`, `status`) VALUES
(1, 'LV432876', 2150000, 28, 3000000, 10, 21500000, 1, 0),
(2, 'A9K14110', 150000, 17, 180000, 10, 1500000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_sent`
--

CREATE TABLE `sales_order_sent` (
  `id` int(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `so_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_order_sent`
--

INSERT INTO `sales_order_sent` (`id`, `reference`, `quantity`, `so_id`, `status`) VALUES
(1, 'A9K14106', 0, 19, 0),
(2, 'LV432876', 10, 1, 1),
(3, 'A9K14110', 10, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `npwp` varchar(20) NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `address`, `phone`, `npwp`, `city`) VALUES
(1, 'PT Mediantara General Sistemindo', 'Jalan Green Sedayu Pergudangan Sedayu Bizpark Blok GS8 no.3, RT011, RW003', '021-22874107', '66.382.351.6-043.000', 'Jakarta Timur'),
(2, 'PT Mentari Gemilang Perdana Sentosa', 'Jalan Raya Paseban Blok 000 no.1B, RT000, RW000', '021-3153888', '01.859.814.4-032.000', 'Jakarta Barat'),
(3, 'CV Matahari Elektrindo', 'Jalan Banceuy Blok 000 no.79A, RT005, RW002', '022 - 4231282', '83.391.815.4-423.000', 'Bandung'),
(4, 'PT Prima Indah Lestari', 'Jalan Raya Tegal Alur Blok 000 no.83, RT003, RW002', '021-5550861', '01.737.201.2-038.000', ''),
(5, 'PT Trikarya Manunggal', 'Jalan Telepon Blok 000 no.2, RT000, RW000', '022-4208371', '02.606.999.7-423.000', 'Bandung'),
(6, 'PT Pelita Abadi Sejahtera', 'Jalan Cisaranten Wetan Blok 000 no.56, RT000, RW000', '022-87821188', '02.333.103.6-429.000', 'Bandung'),
(7, 'PT Total Inpro Multitech', 'Ruko Mega Grosir Cempaka Mas Blok G no.10, RT008, RW008', '022-42883851', '21.050.975.8-048.000', ''),
(8, 'CV Sinar Jaya', 'Jalan Pelajar Pejuang 45 Blok 000 no.46, RT000, RW000', '022-7300139', '72.683.962.4-445.000', 'Bandung'),
(9, 'PT Multi Guna Trans Energi', 'Jalan Tarum Barat Raya II Ruko Sunter Niaga Mas Blok E2 no.1, RT006, RW007', '021-29083307', '31.211.799.7-413.000', 'Cikarang'),
(10, 'CV Bangun Guna Sejahtera', 'Jalan Cikudapateuh Kolot Blok 000 no.1, RT000, RW000', '022-7301545', '21.039.516.6-424.000', ''),
(11, 'PT Sunindo Mandiri Perkasa', 'Jalan Kamal Raya Outer RingRoad Mutiara Taman Palem Blok D1 no.31, RT006, RW014', '021-29020080', '31.351.513.2-034.000', ''),
(12, 'PT Tunas Parahyangan Cemerlang Sejati Sakti', 'Jalan Prof.Dr.Sutami Ruko Setrasari Blok B3 no.59, RT006, RW001', '022-2008811', '70.249.311.5-428.000', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_id`
--

CREATE TABLE `user_id` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_id`
--

INSERT INTO `user_id` (`id`, `name`, `username`, `password`) VALUES
(2, 'Dadan Sutisna', 'dadans', 'fd68e8922a6705a916b19669fb356cce'),
(3, 'Daniel Tri', 'danieltri', 'aa47f8215c6f30a0dcdb2a36a9f4168e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absentee_list`
--
ALTER TABLE `absentee_list`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `code_delivery_order`
--
ALTER TABLE `code_delivery_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code_purchaseorder`
--
ALTER TABLE `code_purchaseorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code_quotation`
--
ALTER TABLE `code_quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `code_salesorder`
--
ALTER TABLE `code_salesorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_deliveryaddress`
--
ALTER TABLE `customer_deliveryaddress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_address`
--
ALTER TABLE `delivery_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_order`
--
ALTER TABLE `delivery_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itemlist`
--
ALTER TABLE `itemlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorder_received`
--
ALTER TABLE `purchaseorder_received`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_code` (`quotation_code`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order_sent`
--
ALTER TABLE `sales_order_sent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_id`
--
ALTER TABLE `user_id`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absentee_list`
--
ALTER TABLE `absentee_list`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `code_delivery_order`
--
ALTER TABLE `code_delivery_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `code_purchaseorder`
--
ALTER TABLE `code_purchaseorder`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `code_quotation`
--
ALTER TABLE `code_quotation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `code_salesorder`
--
ALTER TABLE `code_salesorder`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `customer_deliveryaddress`
--
ALTER TABLE `customer_deliveryaddress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `delivery_address`
--
ALTER TABLE `delivery_address`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_order`
--
ALTER TABLE `delivery_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `itemlist`
--
ALTER TABLE `itemlist`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=939;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `purchaseorder_received`
--
ALTER TABLE `purchaseorder_received`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=967;

--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_order_sent`
--
ALTER TABLE `sales_order_sent`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_id`
--
ALTER TABLE `user_id`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quotation`
--
ALTER TABLE `quotation`
  ADD CONSTRAINT `quotation_ibfk_1` FOREIGN KEY (`quotation_code`) REFERENCES `code_quotation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
