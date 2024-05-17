-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 17, 2024 lúc 08:34 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fast-food-php`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
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
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `show_on_home` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `title`, `image`, `show_on_home`, `active`) VALUES
(2, 'burger', 'Food_category_6629c559b7ab4.jpg', 'Yes', 'Yes'),
(3, 'pizza', 'Food_category_663301b984b42.jpg', 'Yes', 'Yes'),
(4, 'Chicken', 'Food_category_6646c5f5cdaac.jpg', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` char(12) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`ID`, `username`, `password`, `name`, `address`, `phone`, `status`) VALUES
(1, 'vuong', '333', 'Huynh Ba Vuong', 'TPHCM', '0933123456', 1),
(2, 'huynhvuong', '123', 'Huynh Ba Vuong', 'Long An', '0909012359', 1),
(3, 'tung', '123', 'thanh tung', 'HCM', '0333333333', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_address`
--

CREATE TABLE `customer_address` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_address`
--

INSERT INTO `customer_address` (`ID`, `User_ID`, `address`, `phone`) VALUES
(1, 3, '123, HCM', '0334567891'),
(2, 1, '333 Binh Duong', '0334567891'),
(3, 3, '123 , P.THP , Ca Mau', '0334567891');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `show_on_home` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `food`
--

INSERT INTO `food` (`id`, `name`, `description`, `price`, `image`, `category_id`, `show_on_home`, `active`) VALUES
(2, '     pizza', '     aaa', 10000, 'Food-Name9248.jpg', 3, 'Yes', 'Yes'),
(4, '    chicken', '    aaa', 20000, 'Food-Name427.jpg', 2, 'Yes', 'Yes'),
(5, 'burger', 'aaa', 20000, 'Food-Name7679.jpg', 2, 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_food`
--

CREATE TABLE `order_food` (
  `id` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `total_order` int(11) NOT NULL,
  `delivery_address` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `status2` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_food`
--

INSERT INTO `order_food` (`id`, `Customer_ID`, `order_date`, `total_order`, `delivery_address`, `status`, `status2`) VALUES
(2, 3, '2024-05-17', 30000, 1, 1, 0),
(3, 3, '2024-05-17', 50000, 3, 1, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
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
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
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
-- Chỉ mục cho bảng `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id_fk` (`category_id`);

--
-- Chỉ mục cho bảng `order_food`
--
ALTER TABLE `order_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_delivery_address` (`delivery_address`),
  ADD KEY `fk_customer_id` (`Customer_ID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_food`
--
ALTER TABLE `order_food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_food_id` FOREIGN KEY (`Food_ID`) REFERENCES `food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`ID`) REFERENCES `order_food` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`User_ID`) REFERENCES `customer` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_food`
--
ALTER TABLE `order_food`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`Customer_ID`) REFERENCES `customer` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_delivery_address` FOREIGN KEY (`delivery_address`) REFERENCES `customer_address` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
