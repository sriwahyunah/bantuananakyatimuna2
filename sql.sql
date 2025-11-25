-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2025 at 12:51 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

DROP DATABASE IF EXISTS `bantuananakyatimuna2`;
CREATE DATABASE `bantuananakyatimuna2`;
USE `bantuananakyatimuna2`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

 /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- TABLE: admin
-- --------------------------------------------------------

CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `foto`) VALUES
(1, 'sriwahyunah', 'yuna', '21102009', 'yuna.jpg');

-- --------------------------------------------------------
-- TABLE: bantuan
-- --------------------------------------------------------

CREATE TABLE `bantuan` (
  `id_bantuan` int NOT NULL AUTO_INCREMENT,
  `nama_bantuan` varchar(50) NOT NULL,
  `nominal` decimal(15,2) DEFAULT '0.00',
  `keterangan` text,
  PRIMARY KEY (`id_bantuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `bantuan` (`id_bantuan`, `nama_bantuan`, `nominal`, `keterangan`) VALUES
(1, 'bantuananakyatim', '1000000.00', 'sudah di terima');

-- --------------------------------------------------------
-- TABLE: penerima
-- --------------------------------------------------------

CREATE TABLE `penerima` (
  `id_penerima` int NOT NULL AUTO_INCREMENT,
  `nisp` varchar(20) DEFAULT NULL,
  `nama_penerima` text NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `status` text,
  `pendapatan_orang_tua` int DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_penerima`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `penerima` (`id_penerima`, `nisp`, `nama_penerima`, `kelas`, `tanggal_lahir`, `alamat`, `status`, `pendapatan_orang_tua`, `foto`) VALUES
(1, '123456', 'vivi', 'X DKV 1', '2015-11-07', 'jl.merpati putih ', 'yatim', 1000000, 'vivi.jpg');

-- --------------------------------------------------------
-- TABLE: user
-- --------------------------------------------------------

CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','editor') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `role`, `foto`, `status`, `created_at`) VALUES
(87654321, 'dudun', 'dudun_petugas', '123', 'petugas', 'dudun.jpg', 'aktif', '2025-11-20 01:38:42');

-- --------------------------------------------------------
-- TABLE: transaksi
-- --------------------------------------------------------

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `id_bantuan` int NOT NULL,
  `id_penerima` int NOT NULL,
  `id_admin` int NOT NULL,
  `id_user` int NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `fotobuktistruk` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `fk_transaksi_admin` (`id_admin`),
  KEY `fk_transaksi_bantuan` (`id_bantuan`),
  KEY `fk_transaksi_penerima` (`id_penerima`),
  KEY `fk_transaksi_user` (`id_user`),
  CONSTRAINT `fk_transaksi_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`),
  CONSTRAINT `fk_transaksi_bantuan` FOREIGN KEY (`id_bantuan`) REFERENCES `bantuan` (`id_bantuan`),
  CONSTRAINT `fk_transaksi_penerima` FOREIGN KEY (`id_penerima`) REFERENCES `penerima` (`id_penerima`),
  CONSTRAINT `fk_transaksi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `transaksi` (`id_transaksi`, `id_bantuan`, `id_penerima`, `id_admin`, `id_user`, `nominal`, `tanggal_pembayaran`, `fotobuktistruk`) VALUES
(2, 1, 1, 1, 87654321, '1000000.00', '2025-11-20', 'bukti.jpg');

COMMIT;

 /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
