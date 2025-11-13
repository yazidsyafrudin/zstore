-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2025 at 11:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_zstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `category` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `rating` double DEFAULT '0',
  `is_favourite` tinyint(1) DEFAULT '0',
  `is_popular` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `category`, `price`, `rating`, `is_favourite`, `is_popular`) VALUES
(1, 'Kaos Pusing Koding™', 'Kaos premium nyaman dipakai, desain eksklusif untuk programmer.', 'T-Shirt', 100000, 4.8, 1, 1),
(2, 'T-Shirt Premium Predator Jatim', 'Kaos komunitas Predator Jatim dengan bahan premium di buat pleh yazid.', 'T-Shirt', 120000, 4.1, 1, 0),
(3, 'T-Shirt Informatika UI™', 'Kaos eksklusif Informatika UI berbahan halus dan adem.', 'T-Shirt', 150000, 4.8, 1, 1),
(4, 'Mens New High Top Sneaker', 'Sepatu sneakers tinggi untuk gaya kasual modern.', 'Sneakers', 500000, 4.1, 0, 1),
(5, 'GUMIHO - Sneakers Korean Style', 'Sneakers bergaya Korea, ringan dan trendi.', 'Sneakers', 350000, 4.1, 0, 1),
(6, 'Sneakers Aliexpress Wedges', 'Sneakers wedges elegan dengan desain kekinian.', 'Sneakers', 650000, 4.1, 1, 1),
(7, 'YOLO-XUBIXING Sneakers', 'Sneakers berkualitas tinggi dengan desain sporty.', 'Sneakers', 600000, 4.1, 1, 0),
(8, 'Berserk Gust Hoodie', 'Hoodie anime Berserk dengan sablon premium.', 'Hoodie', 360000, 4.1, 1, 1),
(9, 'Hoodie Anime Demon Slayer Kimetsu No Yaiba', 'Hoodie tebal dan lembut dengan desain Kimetsu No Yaiba.', 'Hoodie', 450000, 4.1, 1, 1),
(10, 'Hoodie Boxy Itachi Uchiha', 'Hoodie Itachi Uchiha dengan model boxy fit.', 'Hoodie', 380000, 4.1, 1, 1),
(11, 'Hoodie Ace & Luffy One Piece', 'Hoodie One Piece dengan desain Ace & Luffy.', 'Hoodie', 420000, 4.1, 1, 1),
(15, 'kaos zthirft', 'manatap', 'T-shirt', 1000000, 0.6, 1, 1),
(16, 'silet', 'gede', 'T-shirt', 10000, 4.5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`) VALUES
(3, 1, 'assets/images/kaos_pusing_koding3.png'),
(4, 1, 'assets/images/kaos_pusing_koding4.png'),
(5, 2, 'assets/images/predator1_model1.png'),
(6, 2, 'assets/images/predator1_model2.png'),
(7, 3, 'assets/images/informatika1_model1.png'),
(8, 4, 'assets/images/snekers1_model1.png'),
(9, 5, 'assets/images/snakers_gumiho.png'),
(10, 6, 'assets/images/snakers_wegdes.png'),
(11, 7, 'assets/images/snakers_xubixing.png'),
(12, 8, 'assets/images/berserk1_model1.png'),
(13, 9, 'assets/images/demon_slayer.png'),
(14, 10, 'assets/images/boxy_itachi.png'),
(15, 11, 'assets/images/ace_luffy.png'),
(16, 4, 'assets/images/snekers1_model2.png'),
(20, 15, 'assets/images/kaos1_putih.png'),
(23, 16, 'assets/images/kaos_kuning.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'yazid@gmail.com', '$2y$10$n/cPGc1RVyD9d9g381eHH.d9KUHDoTbfusXwrSqyRFjbVYL9FAl9G', '2025-11-10 10:28:40'),
(2, 'yazidsyafrudin@gmail.com', '$2y$10$ZU8SJYEvK308Zdbjp6OVj.GGbsTlXX1pPDF/Mm.v4if32X3CsFW3C', '2025-11-10 10:34:46'),
(3, 'qwertyu@gmail.com', '$2y$10$DGeTj/lJn6UDOYg2kQG.nOswSyP7N6VY94QotuQxEtLClx/2yc24G', '2025-11-10 11:56:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
