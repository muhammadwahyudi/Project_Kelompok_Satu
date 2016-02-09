-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2016 at 11:16 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_pergudangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `password_email` varchar(100) NOT NULL,
  `role` varchar(15) NOT NULL,
  `status` int(11) NOT NULL,
  `hak_email` varchar(100) NOT NULL,
  `hak_anggota` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `nama`, `password_email`, `role`, `status`, `hak_email`, `hak_anggota`) VALUES
(1, 'jokosugi', 'cac65cd8d6a8e1ad78a6907d512c69a9', 'sugi14tk@mahasiswa.pcr.ac.id', 'jokosugi', '', 'super_admin', 1, '', ''),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@mahasiswa.pcr.ac.id', 'admin gudang', '', 'super_admin', 1, '', 'tambah,edit,hapus,select');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
`id` int(15) NOT NULL,
  `kodebarang` varchar(30) NOT NULL,
  `namabarang` varchar(25) NOT NULL,
  `jumlahbarang` int(5) NOT NULL,
  `satuan` varchar(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kodebarang`, `namabarang`, `jumlahbarang`, `satuan`) VALUES
(1, 'indah', 'laptop', 41, 'unit');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE IF NOT EXISTS `pembelian` (
`id` int(10) NOT NULL,
  `kodetransaksi` varchar(15) NOT NULL,
  `kodebarang` varchar(15) NOT NULL,
  `jumlahmasuk` int(10) NOT NULL,
  `tanggalmasuk` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `kodetransaksi`, `kodebarang`, `jumlahmasuk`, `tanggalmasuk`) VALUES
(1, 'qq', 'indah', 1, '2016-02-03'),
(2, 'qq', 'indah', 2, '2016-02-03'),
(3, 'qq', 'indah', 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
`id` int(15) NOT NULL,
  `kodetransaksi` varchar(15) NOT NULL,
  `kodebarang` varchar(15) NOT NULL,
  `jumlahkeluar` int(15) NOT NULL,
  `tanggalkeluar` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=233 ;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `kodetransaksi`, `kodebarang`, `jumlahkeluar`, `tanggalkeluar`) VALUES
(1, 'aku jualan', 'indah', 2, '0000-00-00'),
(2, 'wahyudi jual', 'indah', 1, '2016-02-03'),
(3, 'lagi', 'indah', 10, '2016-02-03'),
(232, 'qq', 'indah', 3, '2016-02-04');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
`id` int(15) NOT NULL,
  `kodetransaksi` varchar(30) NOT NULL,
  `jenistransaksi` enum('pembelian','penjualan','','') NOT NULL,
  `tanggaltransaksi` date NOT NULL,
  `keterangan` varchar(300) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kodetransaksi`, `jenistransaksi`, `tanggaltransaksi`, `keterangan`) VALUES
(73, 'akubeli', 'pembelian', '2016-02-06', 'hore'),
(74, 'aku jualan', 'penjualan', '2016-02-03', 'mantap'),
(75, 'joko-beli', 'pembelian', '2016-02-05', 'baru beli'),
(76, 'wahyudi jual', 'penjualan', '2016-02-05', 'hvvbjn,'),
(77, 'lagi', 'penjualan', '2016-02-04', 'tyui'),
(78, 'aaaaaaaaaaaaaaa', 'penjualan', '2016-02-04', 'djjdj'),
(79, 'beliiiiiiiiiiiiiiiii', 'pembelian', '0000-00-00', ''),
(80, 'qq', 'pembelian', '2016-02-04', 'bnm,');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `kodebarang` (`kodebarang`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `kodetransaksi` (`kodetransaksi`,`kodebarang`), ADD KEY `kodebarang` (`kodebarang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `kodetransaksi` (`kodetransaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`kodetransaksi`) REFERENCES `transaksi` (`kodetransaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`kodebarang`) REFERENCES `barang` (`kodebarang`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
