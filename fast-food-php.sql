-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 18, 2024 lúc 09:59 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fast-food-php`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'Dương Thanh Tùng', 'tung028', '123456'),
(2, 'Thanh Tùng', 'tung029', '123456'),
(11, 'Administrator', 'Administrator', 'admin'),
(12, 'a', 'a', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `ID` int(11) NOT NULL,
  `Food_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`ID`, `Food_ID`, `Quantity`, `Total`) VALUES
(2, 2, 1, 10000),
(2, 4, 1, 20000),
(3, 2, 1, 10000),
(3, 4, 1, 20000),
(3, 5, 1, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ID` int NOT NULL,
  `Food_ID` int NOT NULL,
  `User_ID` int NOT NULL,
  `Quantity` int NOT NULL,
  `Total` int NOT NULL,
  `delivery_address` int NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ID`, `Food_ID`, `User_ID`, `Quantity`, `Total`, `delivery_address`, `Status`) VALUES
(2, 1, 3, 2, 40000, 1, 1),
(2, 2, 3, 1, 10000, 1, 1),
(3, 1, 3, 1, 20000, 3, 1),
(3, 2, 3, 1, 10000, 3, 1),
(4, 2, 3, 1, 10000, 3, 1),
(4, 1, 3, 1, 20000, 3, 1),
(5, 2, 1, 1, 10000, 2, 1),
(6, 1, 1, 3, 60000, 2, 1),
(6, 2, 1, 1, 10000, 2, 1),
(7, 1, 1, 7, 140000, 2, 1),
(8, 1, 1, 1, 20000, 2, 1),
(9, 1, 1, 1, 20000, 2, 1),
(15, 2, 1, 1, 10000, 2, 1),
(15, 1, 1, 1, 20000, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `show_on_home` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` char(12) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID`, `username`, `password`, `name`, `address`, `phone`, `status`) VALUES
(1, 'vuong', '333', 'Huynh Ba Vuong', 'TPHCM', '0933123456', 1),
(2, 'huynhvuong', '123', 'Huynh Ba Vuong', 'Long An', '0909012359', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `show_on_home` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_food`
--

CREATE TABLE `order_food` (
  `id` int(10) UNSIGNED NOT NULL,
  `food` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(10) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_food`
--

INSERT INTO `order_food` (`id`, `Customer_ID`, `order_date`, `total_order`, `delivery_address`, `status`, `status2`) VALUES
(2, 3, '2024-05-17', 30000, 1, 1, 0),
(3, 3, '2024-05-17', 50000, 3, 1, 0);

--
-- Dumping data for table `order_food`
--

INSERT INTO `order_food` (`id`, `order_date`, `total_order`, `status`) VALUES
(2, '2024-05-02', 0, 1),
(3, '2024-05-02', 0, 0),
(4, '2024-05-02', 0, 0),
(5, '2024-05-09', 0, 0),
(6, '2024-05-09', 0, 0),
(7, '2024-05-09', 0, 1),
(8, '2024-05-09', 0, 1),
(9, '2024-05-09', 0, 1),
(15, '2024-05-09', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD KEY `fk_order_id` (`ID`),
  ADD KEY `fk_food_id` (`Food_ID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `food_id_fk` (`Food_ID`),
  ADD KEY `customer_id_fk` (`User_ID`),
  ADD KEY `delivery_address_fk` (`delivery_address`),
  ADD KEY `Id_Order` (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id_fk` (`User_ID`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id_fk` (`User_ID`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id_fk` (`category_id`);

--
-- Indexes for table `order_food`
--
ALTER TABLE `order_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_delivery_address` (`delivery_address`),
  ADD KEY `fk_customer_id` (`Customer_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_food`
--
ALTER TABLE `order_food`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;