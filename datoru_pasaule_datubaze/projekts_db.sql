-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 07:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `configuration_id` int(11) NOT NULL,
  `user_comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `configuration_id`, `user_comment`, `created_at`) VALUES
(37, 11, 88, 'Forša konfigurācija!', '2025-01-09 20:07:38'),
(38, 12, 88, 'Es nomainītu pamatplati.', '2025-01-09 20:09:47'),
(39, 12, 90, 'Labais!', '2025-01-09 20:10:01'),
(40, 13, 88, 'Man nepatīk', '2025-01-09 20:11:50'),
(41, 13, 92, 'Varētu izvēlēties labāku barošanas bloku un operatīvo atmiņu.', '2025-01-09 20:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`id`, `name`, `type`, `brand`, `price`, `description`, `image_url`, `is_public`) VALUES
(1, 'Intel Core i5-13600K', 'Procesors', 'Intel', 329.99, 'Intel Core i5-13600K, 14 kodoli, 3.5 GHz bāzes frekvence, līdz 5.1 GHz Turbo Boost, 20 MB kešatmiņa, nav integrētas video kartes.', 'https://90a1c75758623581b3f8-5c119c3de181c9857fcb2784776b17ef.ssl.cf2.rackcdn.com/652628_436212_04_package_comping.jpg', 1),
(2, 'AMD Ryzen 5 7600X', 'Procesors', 'AMD', 279.99, 'AMD Ryzen 5 7600X, 6 kodoli, 4.7 GHz bāzes frekvence, līdz 5.3 GHz Boost, 32 MB kešatmiņa, nav integrētas video kartes.', 'https://www.jumbo-computer.com/cdn/shop/files/amd-ryzen-5-7600x-processor-oemtray-fan-not-21700574235_900x.webp?v=1712825184', 1),
(3, 'Intel Core i7-13700K', 'Procesors', 'Intel', 419.99, 'Intel Core i7-13700K, 16 kodoli, 3.4 GHz bāzes frekvence, līdz 5.4 GHz Turbo Boost, 30 MB kešatmiņa, nav integrētas video kartes.', 'https://www.rdveikals.lv/images/midi/c6f02ea790d29617d00e6f42c0afa5b9.jpg', 1),
(4, 'AMD Ryzen 9 7950X', 'Procesors', 'AMD', 799.99, 'AMD Ryzen 9 7950X, 16 kodoli, 4.5 GHz bāzes frekvence, līdz 5.7 GHz Boost, 64 MB kešatmiņa, nav integrētas video kartes.', 'https://woodmart.b-cdn.net/mega-electronics/wp-content/uploads/sites/9/2022/11/amd-ryzen-9-7950x-2.jpg', 1),
(5, 'Intel Core i9-12900K', 'Procesors', 'Intel', 749.99, 'Intel Core i9-12900K, 16 kodoli, 3.2 GHz bāzes frekvence, līdz 5.2 GHz Turbo Boost, 30 MB kešatmiņa, nav integrētas video kartes.', 'https://www.notebookcheck.net/fileadmin/Notebooks/Sonstiges/Intel/Alder_Lake_S/Alder_Lake_S_7.jpg', 1),
(6, 'AMD Ryzen 7 7800X', 'Procesors', 'AMD', 499.99, 'AMD Ryzen 7 7800X, 8 kodoli, 4.4 GHz bāzes frekvence, līdz 5.1 GHz Boost, 32 MB kešatmiņa, nav integrētas video kartes.', 'https://www.albagame.al/cdn/shop/files/cpu-amd-ryzen-7-7800x3d-4250ghz-9857901582682.png?v=1704552599', 1),
(7, 'Intel Xeon W-3275', 'Procesors', 'Intel', 2999.99, 'Intel Xeon W-3275, 28 kodoli, 2.5 GHz bāzes frekvence, līdz 4.6 GHz Turbo Boost, 38.5 MB kešatmiņa, nav integrētas video kartes.', 'https://www.notebookcheck.net/fileadmin/Notebooks/News/_nc3/Xeon.jpg', 1),
(8, 'AMD Threadripper 3990X', 'Procesors', 'AMD', 3999.99, 'AMD Ryzen Threadripper 3990X, 64 kodoli, 2.9 GHz bāzes frekvence, līdz 4.3 GHz Boost, 288 MB kešatmiņa, nav integrētas video kartes.', 'https://tpucdn.com/cpu-specs/images/chips/2271-front.jpg', 1),
(9, 'Intel Core i5-12600K', 'Procesors', 'Intel', 279.99, 'Intel Core i5-12600K, 10 kodoli, 3.7 GHz bāzes frekvence, līdz 4.9 GHz Turbo Boost, 20 MB kešatmiņa, nav integrētas video kartes.', 'https://www.notebookcheck.net/fileadmin/Notebooks/Sonstiges/Intel/Alder_Lake_S/Alder_Lake_S_8.jpg', 1),
(10, 'AMD Ryzen 5 5600X', 'Procesors', 'AMD', 229.99, 'AMD Ryzen 5 5600X, 6 kodoli, 3.7 GHz bāzes frekvence, līdz 4.6 GHz Boost, 32 MB kešatmiņa, nav integrētas video kartes.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYSwxA9lHCYi8eN0EAkmpFArHMNcmuysDs_g&s', 1),
(11, 'Intel Core i7-12700K', 'Procesors', 'Intel', 499.99, 'Intel Core i7-12700K, 12 kodoli, 3.6 GHz bāzes frekvence, līdz 5.0 GHz Turbo Boost, 25 MB kešatmiņa, nav integrētas video kartes.', 'https://www.jumbo-computer.com/cdn/shop/files/cpu_intel_core_i7_12700k_tray__3_6ghz__25mb__12_cores_20_threads__0703223b7ae44a9ca2dd97b79516fa6f_master_1000x.jpg?v=1709730112', 1),
(12, 'AMD Ryzen 3 3300X', 'Procesors', 'AMD', 149.99, 'AMD Ryzen 3 3300X, 4 kodoli, 3.8 GHz bāzes frekvence, līdz 4.3 GHz Boost, 16 MB kešatmiņa, nav integrētas video kartes.', 'https://down-ph.img.susercontent.com/file/sg-11134201-23010-5i6mjzpzrulv16_tn.webp', 1),
(13, 'Intel Pentium Gold G6400', 'Procesors', 'Intel', 64.99, 'Intel Pentium Gold G6400, 2 kodoli, 4.0 GHz frekvence, 4 MB kešatmiņa, nav integrētas video kartes.', 'https://pcmarket.uz/wp-content/uploads/2021/12/648c3f251880638bf4a4f1c4ebc4201ba8238afb0a0468e862298d214c3d7478.png', 1),
(14, 'AMD Athlon 3000G', 'Procesors', 'AMD', 59.99, 'AMD Athlon 3000G, 2 kodoli, 3.5 GHz frekvence, 192 KB kešatmiņa, integrēta Radeon Vega 3 video karte.', 'https://www.tpstech.in/cdn/shop/products/Athlon3000GOEM.jpg?v=1647859130', 1),
(15, 'Intel Core i9-11900K', 'Procesors', 'Intel', 599.99, 'Intel Core i9-11900K, 8 kodoli, 3.5 GHz bāzes frekvence, līdz 5.3 GHz Turbo Boost, 16 MB kešatmiņa, nav integrētas video kartes.', 'https://thaher.tech/wp-content/uploads/2023/10/TT-CPU-0089.jpg', 1),
(16, 'ASUS ROG Strix Z590-E', 'Pamatplate', 'ASUS', 329.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC4080', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTal5PF405skzb3UpfhmNNRlUSEcNA_x0onw&s', 1),
(17, 'MSI MAG B550 TOMAHAWK WIFI', 'Pamatplate', 'MSI', 169.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1200', 'https://www.dateks.lv/images/pic/2400/2400/235/1291.jpg', 1),
(18, 'Gigabyte Z590 AORUS ELITE', 'Pamatplate', 'Gigabyte', 219.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC897', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/13-145-263-v03-60e7f85131071.jpg.webp', 1),
(19, 'ASRock B450M Pro4', 'Pamatplate', 'ASRock', 74.99, 'Garums: 24.4 cm, Platums: 22.6 cm, 4 DIMM ligzdas, DDR4, Realtek ALC892', 'https://gfx3.senetic.com/akeneo-catalog/c/5/0/5/c5054ba905b3ccaae8f91fa927ae74d3b9930191_1663559_90_MXB8F0_A0UAYZ_image1.jpg', 1),
(20, 'MSI MPG Z490 GAMING EDGE WIFI', 'Pamatplate', 'MSI', 249.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1220-VB', 'https://asset.msi.com/resize/image/global/product/product_8_20200429154426_5ea9305a4b608.png62405b38c58fe0f07fcef2367d8a9ba1/1024.png', 1),
(21, 'ASUS TUF Gaming B550-PLUS', 'Pamatplate', 'ASUS', 169.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC S1200A', 'https://www.dateks.lv/images/pic/1200/1200/579/695.jpg', 1),
(22, 'Gigabyte AORUS X570 Master', 'Pamatplate', 'Gigabyte', 369.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1220-VB', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/gigabyte-x570-aorus-master-02-5d9808ae997e7.jpg.webp', 1),
(23, 'ASRock Z590 Taichi', 'Pamatplate', 'ASRock', 359.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1220-VB', 'https://m.media-amazon.com/images/I/714JcYFWSzS.jpg', 1),
(24, 'MSI B450-A PRO MAX', 'Pamatplate', 'MSI', 89.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC892', 'https://capital.lv/media/catalog/product/cache/78b7d5e9d325dc0c77c021f203703bf1/d/5/d526bd86-c9c0-4c04-9119-e36f48151097.jpg', 1),
(25, 'ASUS ROG Crosshair VIII Hero', 'Pamatplate', 'ASUS', 399.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1220-VB', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/asus-rog-crosshair-viii-hero-01-5d9e7139193ab.jpg.webp', 1),
(26, 'Gigabyte Z490 AORUS XTREME WATERFORCE', 'Pamatplate', 'Gigabyte', 1299.99, 'Garums: 30.5 cm, Platums: 26.5 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1220-VB', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/0506827ab1c2cab85a65dbbc82812eb6-60db58377696a.jpg.webp', 1),
(27, 'ASRock Z490 Taichi', 'Pamatplate', 'ASRock', 289.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC1220-VB', 'https://m.media-amazon.com/images/I/61wmYne7hxL.jpg', 1),
(28, 'MSI B550M PRO-VDH WIFI', 'Pamatplate', 'MSI', 99.99, 'Garums: 24.4 cm, Platums: 22.6 cm, 2 DIMM ligzdas, DDR4, Realtek ALC892', 'https://www.rdveikals.lv/images/midi/b418d8464b72ae51b94a170536bfc5a9.jpg', 1),
(29, 'ASUS Prime Z590-A', 'Pamatplate', 'ASUS', 219.99, 'Garums: 30.5 cm, Platums: 24.4 cm, 4 DIMM ligzdas, DDR4, Realtek ALC897', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/w800-1-60e811655e816.png.webp', 1),
(30, 'Gigabyte B450M DS3H', 'Pamatplate', 'Gigabyte', 64.99, 'Garums: 24.4 cm, Platums: 22.6 cm, 4 DIMM ligzdas, DDR4, Realtek ALC887', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/gigabyte-b450m-ds3h-02-5d9d2c67ede99.jpg.webp', 1),
(31, 'Corsair Vengeance LPX 16GB', 'Operatīvā atmiņa', 'Corsair', 69.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 3200 MHz, Spriegums: 1.35V', 'https://lv2.pigugroup.eu/colours/432/618/0/4326180/c6e4f15fd875eca8f83913354e2d270e_reference.jpg', 1),
(32, 'G.SKILL Ripjaws V 32GB', 'Operatīvā atmiņa', 'G.SKILL', 129.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 32GB, Kopnes ātrums: 3600 MHz, Spriegums: 1.35V', 'https://www.dateks.lv/images/pic/2400/2400/948/858.jpg', 1),
(33, 'Kingston HyperX Fury 8GB', 'Operatīvā atmiņa', 'Kingston', 39.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 8GB, Kopnes ātrums: 2666 MHz, Spriegums: 1.2V', 'https://images.1a.lv/display/aikido/store/0bd4ad40b63605c2dbee6f0450525b5d.jpg', 1),
(34, 'Crucial Ballistix 16GB', 'Operatīvā atmiņa', 'Crucial', 79.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 3000 MHz, Spriegums: 1.35V', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/main-60cdcd3c61d1e.jpeg.webp', 1),
(35, 'Corsair Dominator Platinum 32GB', 'Operatīvā atmiņa', 'Corsair', 199.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 32GB, Kopnes ātrums: 3200 MHz, Spriegums: 1.35V', 'https://www.dateks.lv/images/pic/1200/1200/896/1764.jpg', 1),
(36, 'Patriot Viper Steel 16GB', 'Operatīvā atmiņa', 'Patriot', 89.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 3000 MHz, Spriegums: 1.35V', 'https://www.dateks.lv/images/pic/2400/2400/901/202.jpg', 1),
(37, 'TeamGroup T-Force Vulcan Z 8GB', 'Operatīvā atmiņa', 'TeamGroup', 39.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 8GB, Kopnes ātrums: 2400 MHz, Spriegums: 1.2V', 'https://images.teamgroupinc.com/products/memory/u-dimm/ddr4/vulcan-z/gray/04.jpg', 1),
(38, 'HyperX Predator 16GB', 'Operatīvā atmiņa', 'HyperX', 109.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 2933 MHz, Spriegums: 1.35V', 'https://media.distrelec.com/Web/WebShopImages/landscape_large/5-/01/Kingston-HX430C16PBK2_32-30061425-01.jpg', 1),
(39, 'Samsung 16GB DDR4', 'Operatīvā atmiņa', 'Samsung', 89.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 2666 MHz, Spriegums: 1.2V', 'https://www.dateks.lv/images/pic/2400/2400/079/1368.jpg', 1),
(40, 'Corsair Vengeance LPX 8GB', 'Operatīvā atmiņa', 'Corsair', 39.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 8GB, Kopnes ātrums: 3000 MHz, Spriegums: 1.2V', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/2fea018c-dd17-408f-aa3c-dabc37c487b1-602a2a53e0c6a.jpg.webp', 1),
(41, 'G.SKILL Trident Z RGB 16GB', 'Operatīvā atmiņa', 'G.SKILL', 129.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 3600 MHz, Spriegums: 1.35V', 'https://m.media-amazon.com/images/I/51leZMMlvhL._AC_UF1000,1000_QL80_.jpg', 1),
(42, 'Crucial Ballistix MAX 32GB', 'Operatīvā atmiņa', 'Crucial', 179.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 32GB, Kopnes ātrums: 4000 MHz, Spriegums: 1.35V', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/2265f9b273680e61f172288099b2c7bb-600ac7c571152.jpg.webp', 1),
(43, 'TeamGroup T-Force Delta RGB 16GB', 'Operatīvā atmiņa', 'TeamGroup', 99.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 16GB, Kopnes ātrums: 3000 MHz, Spriegums: 1.35V', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkyeIfmexCQXaeirploHF0wkyMTCbF_az9ng&s', 1),
(44, 'Corsair Vengeance LPX 32GB', 'Operatīvā atmiņa', 'Corsair', 159.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 32GB, Kopnes ātrums: 3200 MHz, Spriegums: 1.35V', 'https://lv2.pigugroup.eu/colours/432/615/9/4326159/3578e62b78b78975411190fc6f748a54_reference.jpg', 1),
(45, 'ADATA XPG Z1 8GB', 'Operatīvā atmiņa', 'ADATA', 42.99, 'Atmiņas tips: DDR4, Atmiņas ietilpība: 8GB, Kopnes ātrums: 2400 MHz, Spriegums: 1.2V', 'https://s.alicdn.com/@sc04/kf/Hd8045a75fa32474c95a3319840865368L.jpg_720x720q50.jpg', 1),
(46, 'NVIDIA GeForce RTX 3090', 'Video karte', 'NVIDIA', 1499.99, 'Video kartes atmiņas tips: GDDR6X, Video kartes atmiņa: 24GB, Dzesētāju skaits: 3, Ieteicamā barošanas bloka jauda: 750W', 'https://m.media-amazon.com/images/I/61AZBIL4+2L.jpg', 1),
(47, 'AMD Radeon RX 6900 XT', 'Video karte', 'AMD', 999.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 16GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 850W', 'https://cdn.mos.cms.futurecdn.net/Rg2x3ZUWKbDQZhHbD38shQ-1200-80.jpg', 1),
(48, 'NVIDIA GeForce RTX 3080', 'Video karte', 'NVIDIA', 699.99, 'Video kartes atmiņas tips: GDDR6X, Video kartes atmiņa: 10GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 750W', 'https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ampere/rtx-3080/geforce-rtx-3080-shop-600-p@2x.png', 1),
(49, 'AMD Radeon RX 6800 XT', 'Video karte', 'AMD', 649.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 16GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 750W', 'https://www.dateks.lv/images/pic/1200/1200/270/1113.jpg', 1),
(50, 'NVIDIA GeForce RTX 3070', 'Video karte', 'NVIDIA', 499.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 8GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 650W', 'https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ampere/rtx-3070/geforce-rtx-3070-shop-630-d@2x.png', 1),
(51, 'AMD Radeon RX 5700 XT', 'Video karte', 'AMD', 399.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 8GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 600W', 'https://www.notebookcheck.net/fileadmin/Notebooks/AMD/RX_5700_XT/RX_5700_XT_16.jpg', 1),
(52, 'NVIDIA GeForce GTX 1660 Ti', 'Video karte', 'NVIDIA', 279.99, 'Video kartes atmiņas tips: GDDR5, Video kartes atmiņa: 6GB, Dzesētāju skaits: 1, Ieteicamā barošanas bloka jauda: 450W', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/gigabyte-nvidia-geforce-gtx-1660-ti-01-5d8746efd6465.png.webp', 1),
(53, 'NVIDIA GeForce RTX 3060 Ti', 'Video karte', 'NVIDIA', 399.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 8GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 600W', 'https://capital.lv/media/catalog/product/cache/78b7d5e9d325dc0c77c021f203703bf1/a/2/a29dacca-589d-49d2-bfae-562121a88be0.jpg', 1),
(54, 'AMD Radeon RX 6600 XT', 'Video karte', 'AMD', 379.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 8GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 500W', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQDiiJbYr8apC8Y-wVua9N8OqP-u7oZt6J39w&s', 1),
(55, 'NVIDIA GeForce GTX 1650 Super', 'Video karte', 'NVIDIA', 169.99, 'Video kartes atmiņas tips: GDDR5, Video kartes atmiņa: 4GB, Dzesētāju skaits: 1, Ieteicamā barošanas bloka jauda: 400W', 'https://tpucdn.com/gpu-specs/images/c/3411-front.jpg', 1),
(56, 'AMD Radeon RX 580', 'Video karte', 'AMD', 229.99, 'Video kartes atmiņas tips: GDDR5, Video kartes atmiņa: 8GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 500W', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAmeykTanFY4DnTYivR7tm4BUEcYpWVb9l1g&s', 1),
(57, 'NVIDIA Titan RTX', 'Video karte', 'NVIDIA', 2499.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 24GB, Dzesētāju skaits: 3, Ieteicamā barošanas bloka jauda: 850W', 'https://www.nvidia.com/content/dam/en-zz/Solutions/titan/titan-rtx/nvidia-titan-rtx-shop-2c50-d@2x.png', 1),
(58, 'NVIDIA Quadro RTX 8000', 'Video karte', 'NVIDIA', 5499.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 48GB, Dzesētāju skaits: 3, Ieteicamā barošanas bloka jauda: 1000W', 'https://www.pny.com/productimages/04428875-CF8B-4F0F-A58F-B6CC05086D29/images/1_NVIDIA-Quadro-RTX-8000-3qtr.png', 1),
(59, 'MSI GeForce GTX 1660 SUPER', 'Video karte', 'MSI', 229.99, 'Video kartes atmiņas tips: GDDR5, Video kartes atmiņa: 6GB, Dzesētāju skaits: 1, Ieteicamā barošanas bloka jauda: 450W', 'https://capital.lv/media/catalog/product/cache/78b7d5e9d325dc0c77c021f203703bf1/6/3/63e3d933-fb0d-4552-a36f-4d890acc122a.jpg', 1),
(60, 'EVGA GeForce RTX 2080 Super', 'Video karte', 'EVGA', 699.99, 'Video kartes atmiņas tips: GDDR6, Video kartes atmiņa: 8GB, Dzesētāju skaits: 2, Ieteicamā barošanas bloka jauda: 650W', 'https://images.1a.lv/display/aikido/store/71b8b3c05d2123ab76661523a45ea6a6.jpg', 1),
(61, 'Samsung 970 EVO Plus', 'Cietais disks', 'Samsung', 129.99, 'SSD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 3500 MB/s, Lasīšanas ātrums: 3500 MB/s, Kešatmiņa: 1GB', 'https://images.1a.lv/display/aikido/store/75985aeec61b249570d50e814f29cb09.jpg', 1),
(62, 'Western Digital Blue SN550', 'Cietais disks', 'Western Digital', 89.99, 'SSD, Diska ietilpība: 500GB, Rakstīšanas ātrums: 2400 MB/s, Lasīšanas ātrums: 2400 MB/s, Kešatmiņa: 512MB', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTscUe4sC70IcPjoQOyv_snC0KZgyTH3kbsQ&s', 1),
(63, 'Crucial MX500', 'Cietais disks', 'Crucial', 109.99, 'SSD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 500 MB/s, Lasīšanas ātrums: 560 MB/s, Kešatmiņa: 512MB', 'https://www.dateks.lv/images/pic/2400/2400/650/1070.jpg', 1),
(64, 'Kingston A2000', 'Cietais disks', 'Kingston', 94.99, 'SSD, Diska ietilpība: 500GB, Rakstīšanas ātrums: 2200 MB/s, Lasīšanas ātrums: 2200 MB/s, Kešatmiņa: 512MB', 'https://capital.lv/media/catalog/product/cache/78b7d5e9d325dc0c77c021f203703bf1/d/0/d0612fca-9758-4647-8a34-3d725ff9d13d.jpg', 1),
(65, 'Seagate Barracuda 2TB', 'Cietais disks', 'Seagate', 69.99, 'HDD, Diska ietilpība: 2TB, Rakstīšanas ātrums: 160 MB/s, Lasīšanas ātrums: 180 MB/s, Kešatmiņa: 256MB', 'https://media.sweetwater.com/m/products/image/90bbf4b45euJt7xFlVG6kjVrJTorlQIjswfWLDf6.jpg?v=90bbf4b45ea92181', 1),
(66, 'Western Digital Black SN850', 'Cietais disks', 'Western Digital', 249.99, 'HDD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 7000 MB/s, Lasīšanas ātrums: 7000 MB/s, Kešatmiņa: 1GB', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDtqbEESDhBCy5ctVJMKXre_0E5xW3IfENIw&s', 1),
(67, 'Samsung 860 EVO', 'Cietais disks', 'Samsung', 139.99, 'SSD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 520 MB/s, Lasīšanas ātrums: 550 MB/s, Kešatmiņa: 512MB', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/samsung-860-evo-ssd-1000gb-satam2-5c78f7247052f.jpg.webp', 1),
(68, 'ADATA SU800', 'Cietais disks', 'ADATA', 79.99, 'SSD, Diska ietilpība: 512GB, Rakstīšanas ātrums: 400 MB/s, Lasīšanas ātrums: 560 MB/s, Kešatmiņa: 512MB', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSCS5CEk66CF9k0lt-BcMa404MpOVAOvzY3Q&s', 1),
(69, 'Toshiba XG6', 'Cietais disks', 'Toshiba', 119.99, 'SSD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 3100 MB/s, Lasīšanas ātrums: 3200 MB/s, Kešatmiņa: 512MB', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7xiS5DlUyy6VrpYLE_wAw8Uq_tAfJpSILqQ&s', 1),
(70, 'SanDisk Ultra 3D', 'Cietais disks', 'SanDisk', 109.99, 'SSD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 530 MB/s, Lasīšanas ātrums: 560 MB/s, Kešatmiņa: 512MB', 'https://www.dateks.lv/images/pic/2400/2400/635/1418.jpg', 1),
(71, 'Seagate FireCuda 520', 'Cietais disks', 'Seagate', 169.99, 'SSD, Diska ietilpība: 500GB, Rakstīšanas ātrums: 5000 MB/s, Lasīšanas ātrums: 5000 MB/s, Kešatmiņa: 1GB', 'https://www.exertis.ie/images/products/34620/112759/600x600/ZP1000GM3A002.webp', 1),
(72, 'Western Digital Red 6TB', 'Cietais disks', 'Western Digital', 179.99, 'HDD, Diska ietilpība: 6TB, Rakstīšanas ātrums: 160 MB/s, Lasīšanas ātrums: 150 MB/s, Kešatmiņa: 256MB', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5DI-2qBCCynHA3jAjy8cpSnC8iicio9U0kA&s', 1),
(73, 'Intel Optane SSD 905P', 'Cietais disks', 'Intel', 399.99, 'SSD, Diska ietilpība: 480GB, Rakstīšanas ātrums: 2600 MB/s, Lasīšanas ātrums: 2500 MB/s, Kešatmiņa: 512MB', 'https://www.intel.com/content/dam/products/hero/foreground/optane-ssd-905p-right-angle-16x9.png.rendition.intel.web.480.270.png', 1),
(74, 'Crucial P5', 'Cietais disks', 'Crucial', 129.99, 'SSD, Diska ietilpība: 1TB, Rakstīšanas ātrums: 3400 MB/s, Lasīšanas ātrums: 3500 MB/s, Kešatmiņa: 1GB', 'https://www.dateks.lv/images/pic/2400/2400/102/1031.jpg', 1),
(76, 'Samsung 980 Pro', 'Cietais disks', 'Samsung', 199.99, 'SSD, Diska ietilpība: 500GB, Rakstīšanas ātrums: 5000 MB/s, Lasīšanas ātrums: 7000 MB/s, Kešatmiņa: 1GB', 'https://images.1a.lv/display/aikido/store/fa2379a1a248064bb3516a52430e64b7.jpg', 1),
(77, 'Corsair RM750x', 'Barošanas bloks', 'Corsair', 109.99, 'Jauda: 750W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://assets.corsair.com/image/upload/f_auto,q_auto/content/CP-9020179-NA-RM750x-PSU-01.png', 1),
(78, 'EVGA SuperNOVA 650 G5', 'Barošanas bloks', 'EVGA', 89.99, 'Jauda: 650W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTi43lcYzrnpAnR442fsY_KFMGLvjrgIb1iAg&s', 1),
(79, 'Seasonic Focus GX-750', 'Barošanas bloks', 'Seasonic', 129.99, 'Jauda: 750W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://www.dateks.lv/images/pic/1200/1200/191/499.jpg', 1),
(80, 'Cooler Master MWE Gold 850W', 'Barošanas bloks', 'Cooler Master', 109.99, 'Jauda: 850W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://www.dateks.lv/images/pic/2400/2400/707/1716.jpg', 1),
(81, 'Be Quiet! Straight Power 11 650W', 'Barošanas bloks', 'Be Quiet!', 119.99, 'Jauda: 650W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://www.guru3d.com/data/publish/220/98752021583813de5d82123f6c265f09f1af0e/img_9978.jpg', 1),
(82, 'Thermaltake Toughpower GF1 750W', 'Barošanas bloks', 'Thermaltake', 109.99, 'Jauda: 750W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://www.dateks.lv/images/pic/1200/1200/858/598.jpg', 1),
(83, 'FSP Hydro G 650W', 'Barošanas bloks', 'FSP', 79.99, 'Jauda: 650W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://www.dateks.lv/images/pic/2400/2400/180/712.jpg', 1),
(84, 'XPG Core Reactor 850W', 'Barošanas bloks', 'XPG', 129.99, 'Jauda: 850W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjHmkEAk8eX6nvHSW5T__oHb-nxLBOdAIPnA&s', 1),
(85, 'SilverStone Strider Platinum 600W', 'Barošanas bloks', 'SilverStone', 109.99, 'Jauda: 600W, Energoefektivitāte: 80 Plus Platinum, PFC tips: Active PFC', 'https://www.silverstonetek.com/upload/images/products/st60f-ps/st60f-ps-34right-top.jpg', 1),
(86, 'Antec High Current Pro 850W', 'Barošanas bloks', 'Antec', 139.99, 'Jauda: 850W, Energoefektivitāte: 80 Plus Platinum, PFC tips: Active PFC', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQeXPyz0nRe_TjYEdtOHsGokYMk6n-RvCb5YA&s', 1),
(87, 'Corsair HX1000i', 'Barošanas bloks', 'Corsair', 189.99, 'Jauda: 1000W, Energoefektivitāte: 80 Plus Platinum, PFC tips: Active PFC', 'https://static2.nordic.pictures/49131542-thickbox_default/corsair-hxi-series-2023-hx1000i-psu.jpg', 1),
(88, 'Gigabyte AORUS P850W', 'Barošanas bloks', 'Gigabyte', 109.99, 'Jauda: 850W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/1000-4-6024ea3bdede6.png.webp', 1),
(89, 'Cooler Master V Gold 650W', 'Barošanas bloks', 'Cooler Master', 89.99, 'Jauda: 650W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRs2g7QNU5RrHmxKM_rKt1Rx02iAbgcNq3rGA&s', 1),
(90, 'EVGA 750 GQ', 'Barošanas bloks', 'EVGA', 99.99, 'Jauda: 750W, Energoefektivitāte: 80 Plus Gold, PFC tips: Active PFC', 'https://m.media-amazon.com/images/I/71fChKT1KzL._AC_UF894,1000_QL80_.jpg', 1),
(91, 'Seasonic Prime Titanium 850W', 'Barošanas bloks', 'Seasonic', 249.99, 'Jauda: 850W, Energoefektivitāte: 80 Plus Titanium, PFC tips: Active PFC', 'https://m.media-amazon.com/images/I/61eV6QibnYL.jpg', 1),
(93, 'NZXT H510', 'Datora korpuss', 'NZXT', 69.99, 'Materiāls: Stikls un tērauds, Krāsa: Melna, Platums: 210 mm, Augstums: 460 mm, Dziļums: 428 mm', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image_webp/products/nzxt-h510-white-black-02-5de1e99168f22.jpg.webp', 1),
(94, 'Fractal Design Meshify C', 'Datora korpuss', 'Fractal Design', 89.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 213 mm, Augstums: 432 mm, Dziļums: 451 mm', 'https://www.dateks.lv/images/pic/1200/1200/176/140.jpg', 1),
(95, 'Cooler Master MasterBox Q300L', 'Datora korpuss', 'Cooler Master', 59.99, 'Materiāls: Tērauds un plastmasa, Krāsa: Melna, Platums: 450 mm, Augstums: 450 mm, Dziļums: 230 mm', 'https://www.dateks.lv/images/pic/2400/2400/868/141.jpg', 1),
(96, 'Corsair 4000D Airflow', 'Datora korpuss', 'Corsair', 74.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 210 mm, Augstums: 460 mm, Dziļums: 450 mm', 'https://www.balticdata.lv/Gfx/ProductImages/Large/Product_73397_1.png', 1),
(97, 'Phanteks P400A', 'Datora korpuss', 'Phanteks', 89.99, 'Materiāls: Stikls un tērauds, Krāsa: Melna, Platums: 210 mm, Augstums: 465 mm, Dziļums: 470 mm', 'https://s1.cel.ro/images/mari/2023/10/16/Carcasa-Phanteks-Eclipse-P400A-Mesh-Black.jpg', 1),
(98, 'Lian Li PC-011 Dynamic', 'Datora korpuss', 'Lian Li', 139.99, 'Materiāls: Alumīnijs un stikls, Krāsa: Melna, Platums: 272 mm, Augstums: 450 mm, Dziļums: 440 mm', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQhPfW5RMyS2U__UPH_cHKePd4unZCE8JFg-Q&s', 1),
(99, 'Thermaltake View 71 RGB', 'Datora korpuss', 'Thermaltake', 169.99, 'Materiāls: Stikls un tērauds, Krāsa: Melna, Platums: 249 mm, Augstums: 551 mm, Dziļums: 509 mm', 'https://m.media-amazon.com/images/I/71TODE9A5vL._AC_UF894,1000_QL80_.jpg', 1),
(100, 'Be Quiet! Pure Base 500DX', 'Datora korpuss', 'Be Quiet!', 89.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 230 mm, Augstums: 474 mm, Dziļums: 453 mm', 'https://www.rdveikals.lv/images/midi/6e9286f50fe5557169e3adc6cbe8d3c6.jpg', 1),
(101, 'MSI MAG Forge 100R', 'Datora korpuss', 'MSI', 69.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 210 mm, Augstums: 432 mm, Dziļums: 450 mm', 'https://storage-asset.msi.com/global/picture/image/feature/PC-Components/MAG-FORGE100R/101M.png', 1),
(102, 'SilverStone RL06', 'Datora korpuss', 'SilverStone', 59.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 211 mm, Augstums: 472 mm, Dziļums: 470 mm', 'https://www.silverstonetek.com/upload/images/products/rl06/rl06-13.jpg', 1),
(103, 'Corsair iCUE 220T RGB', 'Datora korpuss', 'Corsair', 99.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 200 mm, Augstums: 450 mm, Dziļums: 400 mm', 'https://cdn.tet.lv/tetveikals-prd-images/product_popup_image/products/e7ede7a1213f28e72b4f19f1afafc261-1600-60f53e0eb6cfd.jpg', 1),
(104, 'Antec NX410', 'Datora korpuss', 'Antec', 69.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 210 mm, Augstums: 460 mm, Dziļums: 435 mm', 'https://m.media-amazon.com/images/I/81B5xxgz1US.jpg', 1),
(105, 'Cooler Master HAF 700 EVO', 'Datora korpuss', 'Cooler Master', 249.99, 'Materiāls: Tērauds, alumīnijs un stikls, Krāsa: Melna, Platums: 270 mm, Augstums: 640 mm, Dziļums: 600 mm', 'https://a.storyblok.com/f/281110/b7e10f9ad7/haf-700-evo-gallery-1.png/m/960x0/smart', 1),
(106, 'Fractal Design Define 7', 'Datora korpuss', 'Fractal Design', 169.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 240 mm, Augstums: 475 mm, Dziļums: 544 mm', 'https://www.fractal-design.com/app/uploads/2020/10/Define_7_TGD_Black_wo_sidepanel_XL_Left_Front-1200x1200.jpg', 1),
(107, 'Cooler Master MasterCase H500', 'Datora korpuss', 'Cooler Master', 119.99, 'Materiāls: Tērauds un stikls, Krāsa: Melna, Platums: 229 mm, Augstums: 508 mm, Dziļums: 510 mm', 'https://m.media-amazon.com/images/I/81+m0tKYagL.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lapas_info`
--

CREATE TABLE `lapas_info` (
  `id` int(11) NOT NULL,
  `apraksts` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lapas_info`
--

INSERT INTO `lapas_info` (`id`, `apraksts`) VALUES
(1, 'Esiet sveicināti Datoru Pasaulē. Mājaslapā Jūs varat apskatīt plašo klāstu ar datoru komponentēm, un iepazīties ar to specifikācijām. Kad esat atraduši komponentes, kuras vēlētos savam datoram, Jūs varat doties uz datora konfigurēšanu, kur ir iespējams izveidot pašam savu datora konfigurāciju. Ja izveidotajai konfigurācijai ir kāda komponente, ko vēlaties nomainīt pēc tās saglabāšanas, to ir viegli izdarīt savā profila lapā. Kā arī Jūs varat dalīties ar savām konfigurācijām ar citiem lietotājiem, un balsot un komentēt par citu lietotāju izveidotajām konfigurācijām. Lai būtu pilna pieeja visām mājaslapas funkcijām vajag autorizēties vai reģistrēties.\r\n\r\nMājaslapas izveidotājs – Miks Matīss Liepiņš, 221RDB275.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@admin.lv', '$2y$10$uBQZEgiTHwegRx0yqKTAoOUqK2l7CAqHXA7ZGvkdKbfcyxaf0ujSW', 'admin'),
(10, 'test1', 'test1@test.lv', '$2y$10$dhCzpM4Iuz8q2q2KfXgoW.9TdQi1u5glkMTERduPmxr.gOLQ4QU1a', 'registered'),
(11, 'test2', 'test2@test.lv', '$2y$10$nZS7Lf83ENGSv9hthqrCLO1o.SgRNIEEuHyMER2u84HuoZ5tAbNXG', 'registered'),
(12, 'test3', 'test3@test.lv', '$2y$10$sSyYyllV0Ckfzxmz44gGgebatzxEEqfa7tr13SE1pjqkCAH7RNFlG', 'registered'),
(13, 'test4', 'test4@test.lv', '$2y$10$x9ZQwfSiCvxTr4y3OPk7t.pRDFd6w9VpvThRboI6OQnCPXTX./fg6', 'registered');

-- --------------------------------------------------------

--
-- Table structure for table `user_configurations`
--

CREATE TABLE `user_configurations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cpu_id` int(11) DEFAULT NULL,
  `gpu_id` int(11) DEFAULT NULL,
  `motherboard_id` int(11) DEFAULT NULL,
  `ram_id` int(11) DEFAULT NULL,
  `disc_id` int(11) DEFAULT NULL,
  `psu_id` int(11) DEFAULT NULL,
  `case_id` int(11) DEFAULT NULL,
  `total_price` float DEFAULT 0,
  `image_url_id` varchar(255) DEFAULT NULL,
  `configuration_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_public` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_configurations`
--

INSERT INTO `user_configurations` (`id`, `user_id`, `cpu_id`, `gpu_id`, `motherboard_id`, `ram_id`, `disc_id`, `psu_id`, `case_id`, `total_price`, `image_url_id`, `configuration_name`, `created_at`, `updated_at`, `is_public`) VALUES
(88, 10, 6, 48, 19, 32, 64, 81, 94, 1709.93, 'https://www.dateks.lv/images/pic/1200/1200/176/140.jpg', 'test1 pirmais', '2025-01-09 18:04:22', '2025-01-09 18:04:51', 1),
(89, 10, 6, 46, 20, 32, 69, 83, 104, 2649.93, 'https://m.media-amazon.com/images/I/81B5xxgz1US.jpg', 'test1 otrais', '2025-01-09 18:04:47', '2025-01-09 18:04:47', 0),
(90, 11, 1, 49, 17, 33, 65, 83, 102, 1399.93, 'https://www.silverstonetek.com/upload/images/products/rl06/rl06-13.jpg', 'test2 pirmais', '2025-01-09 18:06:54', '2025-01-09 18:07:21', 1),
(91, 11, 9, 48, 16, 32, 64, 80, 97, 1734.93, 'https://s1.cel.ro/images/mari/2023/10/16/Carcasa-Phanteks-Eclipse-P400A-Mesh-Black.jpg', 'test2 otrais', '2025-01-09 18:07:17', '2025-01-09 18:07:17', 0),
(92, 12, 2, 51, 18, 33, 64, 85, 99, 1314.93, 'https://m.media-amazon.com/images/I/71TODE9A5vL._AC_UF894,1000_QL80_.jpg', 'test3 pirmais', '2025-01-09 18:08:28', '2025-01-09 18:09:00', 1),
(93, 12, 11, 58, 28, 44, 76, 83, 101, 6609.93, 'https://storage-asset.msi.com/global/picture/image/feature/PC-Components/MAG-FORGE100R/101M.png', 'test3 otrais', '2025-01-09 18:08:56', '2025-01-09 18:08:56', 0),
(94, 13, 1, 60, 23, 44, 76, 90, 105, 2099.93, 'https://a.storyblok.com/f/281110/b7e10f9ad7/haf-700-evo-gallery-1.png/m/960x0/smart', 'test4 pirmais', '2025-01-09 18:11:01', '2025-01-09 18:11:32', 1),
(95, 13, 15, 60, 30, 45, 76, 91, 107, 1977.93, 'https://m.media-amazon.com/images/I/81+m0tKYagL.jpg', 'test4 otrais', '2025-01-09 18:11:28', '2025-01-09 18:11:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `configuration_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vote_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `configuration_id`, `user_id`, `vote_amount`) VALUES
(32, 88, 11, 1),
(33, 88, 12, 1),
(34, 88, 13, 1),
(35, 90, 13, 1),
(36, 94, 13, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_configuration` (`configuration_id`);

--
-- Indexes for table `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lapas_info`
--
ALTER TABLE `lapas_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_configurations`
--
ALTER TABLE `user_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cpu_id` (`cpu_id`),
  ADD KEY `gpu_id` (`gpu_id`),
  ADD KEY `motherboard_id` (`motherboard_id`),
  ADD KEY `ram_id` (`ram_id`),
  ADD KEY `disc_id` (`disc_id`),
  ADD KEY `psu_id` (`psu_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configuration_id` (`configuration_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `lapas_info`
--
ALTER TABLE `lapas_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_configurations`
--
ALTER TABLE `user_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_configuration` FOREIGN KEY (`configuration_id`) REFERENCES `user_configurations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_configurations`
--
ALTER TABLE `user_configurations`
  ADD CONSTRAINT `user_configurations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_2` FOREIGN KEY (`cpu_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_3` FOREIGN KEY (`gpu_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_4` FOREIGN KEY (`motherboard_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_5` FOREIGN KEY (`ram_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_6` FOREIGN KEY (`disc_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_7` FOREIGN KEY (`psu_id`) REFERENCES `components` (`id`),
  ADD CONSTRAINT `user_configurations_ibfk_8` FOREIGN KEY (`case_id`) REFERENCES `components` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`configuration_id`) REFERENCES `user_configurations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
