-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 04:25 AM
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
-- Database: `btl`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(106, 32, 29, 'Cà rốt', 40, 1, 'carror.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(8, 32, 'lan', 'ntnl261203@gmail.com', '0945736058', 'good');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(24, 32, 'Nguyễn Thị Ngọc Lan', '0347950625', 'ntnl261203@gmail.com', 'cash on delivery', 'An Dương', '1kg Cà chua ', 2, '2024-12-02', 'completed'),
(25, 32, 'Nguyễn Thị Ngọc Lan', '0347950625', 'ntnl261203@gmail.com', 'cash on delivery', 'Hải phòng', '1kg Cà rốt  ', 4, '2024-11-12', 'completed'),
(26, 34, 'Vũ Thị Mùi', '0347950625', 'ntnl261203@gmail.com', 'credit card', '23/210 Cat Linh', '1kg Khoai tây, 1kg Thịt bò, 1kg Thịt heo, 2kg Gà tươi, 3kg Cá hồi  ', 343, '2024-12-13', 'completed'),
(27, 33, 'Đinh Thị Thanh Thư', '0965346244', 'mui123@gmail.com', 'credit card', '23/210 Cái Tắt', '2kg Cà chua, 2kg Khoai tây, 2kg Ớt chuông', 14, '2024-12-01', 'pending'),
(28, 33, 'Đinh Thị Thanh Thư', '0987655332', 'thu123@gmail.com', 'cash on delivery', 'Hồng Bàng', '1kg Thịt bò', 100, '2024-12-12', 'completed'),
(29, 32, 'lan', '0945736058', 'ntnl261203@gmail.com', 'credit card', 'hai phòng', '1kg Tomato, 1kg Cucumber, 1kg ngo  ', 8, '2024-12-12', 'pending'),
(31, 32, 'lan', '12345678', 'ntnl261203@gmail.com', 'cash on delivery', 'hai phòng', '1kg Khoai tây  ', 25, '2024-12-13', 'completed'),
(32, 32, 'lan', '1234567878', 'ntnl261203@gmail.com', 'cash on delivery', 'hai phòng', '1kg Thịt bò  ', 200, '2024-12-13', 'pending'),
(33, 31, 'vu mui', '0829238901', 'vuthimui373@gmail.com', 'cash on delivery', 'gfh', '1kg Thịt heo  ', 150, '2024-12-13', 'pending'),
(34, 31, 'vu mui', '0829238901', 'vuthimui373@gmail.com', 'cash on delivery', 'gfh', '1kg Khoai tây  ', 25, '2024-12-15', 'pending'),
(35, 31, 'vu mui', '0829238901', 'vuthimui373@gmail.com', 'cash on delivery', 'gfh', '5kg Thịt bò  ', 1000, '2024-12-16', 'completed'),
(36, 31, 'lan', '0829238901', 'vuthimui373@gmail.com', 'cash on delivery', 'gfh', '1kg Khoai tây  ', 25, '2024-12-16', 'pending'),
(37, 31, 'lan', '0829238901', 'vuthimui373@gmail.com', 'cash on delivery', 'gfh', '995kg Khoai tây  ', 24875, '2024-12-16', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(65) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sold` int(11) NOT NULL,
  `inventories` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`, `sold`, `inventories`) VALUES
(24, 'Cà chua', 'vegitables', 'Cà chua chất lượng cao(Loại I), quả to.', 35, 'tomato.jpg', 7, 993),
(26, 'Khoai tây', 'vegitables', 'Khoai tây tím, củ to, sạch', 25, 'potato.jpg', 1000, 0),
(27, 'Ớt chuông', 'vegitables', 'Ớt chuông, nhiều màu(xanh,đỏ,vàng) ', 50, 'bellpepper.jpg', 4, 996),
(28, 'Dưa chuột', 'vegitables', 'Dưa chuột sạch, quả nhỏ', 20, 'cucumber.jpg', 2, 998),
(29, 'Cà rốt', 'vegitables', 'Cà rốt tươi, sạch, giàu dinh dưỡng', 40, 'carror.jpg', 1, 999),
(31, 'Thịt bò', 'meat', 'Thịt bò tươi trong ngày', 200, 'beef.jpg', 7, 993),
(32, 'Thịt heo', 'meat', 'Thịt heo tươi trong ngày', 150, 'pork.jpg', 1, 999),
(33, 'Cá hồi', 'fish', 'Cá hồi được nhập khẩu từ Nauy', 300, 'cahoi.jpg', 3, 997),
(34, 'Gà tươi', 'meat', 'Gà tươi trong ngày, đã được làm sạch', 150, 'chicken.jpg', 2, 998),
(37, 'Chuối', 'fruits', 'Chuối chín vàng đều thơm ngon', 25, 'chuoi.jpg', 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`) VALUES
(31, 'Vũ Thị Mùi', 'vuthimui373@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', 'anh5.jpg'),
(32, 'user', 'ntnl261203@gmail.com', '250cf8b51c773f3f8dc8b4be867a9a02', 'user', 'pic-hoangdat.jpg'),
(34, 'Nguyễn Thị Ngọc Lan', 'lan91154@st.vimaru.edu.vn', '202cb962ac59075b964b07152d234b70', 'admin', 'pic-hoangdat.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `pid`, `name`, `price`, `image`) VALUES
(60, 32, 27, 'Ớt chuông', 50, 'bellpepper.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
