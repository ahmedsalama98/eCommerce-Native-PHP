-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2021 at 08:30 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `parent` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 1,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `allow_adds` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`, `date`, `description`, `ordering`, `visibility`, `allow_comments`, `allow_adds`) VALUES
(1, 'phones', 0, '2021-06-05 20:09:12', 'nice phones and modern', 2, 1, 1, 1),
(2, 'cars', 0, '2021-06-05 20:09:12', 'this nice cars', 1, 1, 0, 1),
(3, 'furniture', 0, '2021-06-05 22:14:58', 'nice furniture', 3, 1, 1, 1),
(9, 'Electronics', 0, '2021-06-07 13:52:55', 'nice Electronics', 1, 1, 1, 1),
(10, 'Laptop', 0, '2021-06-07 13:55:09', 'nice Laptop', 4, 1, 1, 1),
(12, 'toys', 0, '2021-06-07 13:57:14', 'toys', 0, 1, 1, 1),
(13, 'Tools', 0, '2021-06-08 11:15:05', 'Tools', 40, 1, 1, 1),
(14, 'Samsung', 1, '2021-06-16 01:31:01', '', 0, 1, 1, 1),
(16, 'Hawaui', 1, '2021-06-16 12:07:35', 'Hawaui', 0, 0, 0, 0),
(17, 'Xiaomi', 1, '2021-06-16 13:14:31', 'Xiaomi', 0, 1, 1, 1),
(18, 'Honor', 1, '2021-06-16 13:16:23', 'Honor', 0, 1, 1, 1),
(19, 'Aplle', 1, '2021-06-16 13:20:11', '', 0, 1, 1, 1),
(20, 'TECNO', 1, '2021-06-16 13:20:36', 'TECNO', 0, 1, 1, 1),
(21, 'Oppo', 1, '2021-06-16 14:12:54', 'Oppo', 0, 1, 1, 1),
(22, 'Asus', 10, '2021-06-16 14:17:25', '', 0, 1, 1, 1),
(23, 'Lenovo', 10, '2021-06-16 14:17:55', '', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` date NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `comment_date`, `status`, `user_id`, `item_id`) VALUES
(77, 'nice care', '2021-06-12', 1, 1, 20),
(78, 'amzzing', '2021-06-12', 1, 1, 20),
(79, 'hhhh', '2021-06-12', 1, 1, 20),
(80, 'hhhh', '2021-06-12', 1, 1, 20),
(81, 'hhhh', '2021-06-12', 1, 1, 20),
(82, 'hhhh', '2021-06-12', 1, 1, 20),
(83, 'good', '2021-06-12', 1, 60, 20),
(84, 'good', '2021-06-14', 1, 60, 20),
(85, 'comment', '2021-06-14', 1, 63, 5),
(90, 'nice car', '2021-06-19', 1, 1, 41),
(91, 'comment', '2021-06-19', 1, 63, 39),
(92, 'comment', '2021-06-19', 1, 63, 39);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf32 NOT NULL,
  `price` varchar(255) NOT NULL,
  `add_date` date NOT NULL DEFAULT current_timestamp(),
  `country_made` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` tinyint(10) NOT NULL,
  `approve` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `catigory_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `description`, `price`, `add_date`, `country_made`, `tags`, `status`, `rating`, `approve`, `image`, `catigory_id`, `member_id`) VALUES
(3, 'firari', 'nice firari', '500000 $', '2021-06-07', 'Bahrain', '', '3', 0, 0, '', 2, 27),
(5, 'bed room', 'nice bed room', '300 $', '2021-06-07', 'Egypt', '', '2', 0, 1, '', 3, 22),
(11, 'Danning Room', 'Danning Room', '200$', '2021-06-07', 'Bahrain', '', '2', 0, 0, '', 3, 1),
(19, 'corola', 'corola', '30000 $', '2021-06-08', 'Bahrain', '', '1', 0, 1, '', 2, 39),
(20, 'Toyota', 'Toyota', '$4000', '2021-06-08', 'Bahrain', 'nice car , good price', '1', 0, 1, '', 2, 21),
(21, 'chivrolate', 'chivrolate', '300 $', '2021-06-08', 'Azerbaijan', '', '1', 0, 1, '', 2, 39),
(34, 'A70', 'nice Phone', '300', '2021-06-16', 'Aruba', 'discount , nice phone', '1', 0, 1, '', 14, 60),
(35, 'K20', 'K20', '300', '2021-06-16', 'Bahrain', 'good , very nicce', '1', 0, 1, '', 17, 39),
(36, 'K20 pro', 'K20 pro', '500', '2021-06-16', 'Barbados', 'discount , nice phone', '1', 0, 1, '', 17, 21),
(37, 'oppo F11', 'oppo F11', '590', '2021-06-16', 'Anguilla', 'discount , nice phone', '1', 0, 1, '', 21, 20),
(38, 'oppo F9', 'test', '400', '2021-06-16', 'Bahamas', 'discount , nice phone', '1', 0, 1, '', 21, 19),
(39, 'oppo F13', 'test', '600', '2021-06-16', 'Bahrain', 'discount , nice phone', '1', 0, 1, '2770868386838190F17 pro-navigation-blue-v2.png', 21, 60),
(40, 'Iphone 12 Pro', 'Iphone 12 Pro', '1000', '2021-06-17', 'Canada', 'unique , expensive', '1', 0, 1, '2619449624127300F17 pro-navigation-blue-v2.png', 19, 1),
(41, 'Kia Soreto', 'Kia Soreto', '50000', '2021-06-17', 'Canada', 'unique , expensive', '1', 0, 1, '6144401294146450all-new-kia-sorento-5.jpg', 2, 1),
(42, 'test', 'test', '299', '2021-06-19', 'Egypt', 'zobr , mango , lemone', '2', 0, 0, '2132886199636414all-new-kia-sorento-5.jpg', 2, 27),
(44, 'Oppo Reno 5', 'Oppo Reno 5', '500', '2021-06-19', 'Bahrain', 'discount , nice phone', '1', 0, 0, '38936570106_15341676733.jpg', 21, 63);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `quantity` tinyint(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `item_id`, `user_id`, `status`, `quantity`) VALUES
(1, '2021-06-18 22:25:01', 41, 60, 0, 1),
(4, '2021-06-18 22:27:57', 40, 60, 0, 6),
(5, '2021-06-16 22:46:30', 39, 19, 0, 1),
(6, '2021-06-18 23:58:15', 41, 19, 0, 3),
(7, '2021-06-19 00:32:55', 41, 1, 0, 1),
(9, '2021-06-19 06:08:09', 34, 27, 0, 1),
(11, '2021-06-19 14:25:18', 34, 63, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT 0,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `trust_status` int(11) NOT NULL DEFAULT 0,
  `reg_stutus` int(11) NOT NULL DEFAULT 0,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `gender` enum('male','female','ather') DEFAULT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `avatar`, `group_id`, `password`, `first_name`, `last_name`, `trust_status`, `reg_stutus`, `reg_date`, `gender`, `birth_date`) VALUES
(1, 'ahmed98', 'ahmed@yahoo.com', '6544727320IMG_20210310_164940.jpg', 1, '8cb2237d0679ca88db6464eac60da96345513964', 'Ahmed', 'Eissa', 1, 1, '2021-06-03 16:42:27', 'male', '1998-04-20'),
(19, 'yara20', 'yara@yahoo.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'yara', 'hammad', 0, 1, '2021-06-03 19:03:00', 'female', NULL),
(20, 'mohamed999', 'mohamed@gmail.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'mahmed', 'eissa', 0, 0, '2021-06-03 19:03:56', 'male', NULL),
(21, 'shorouk98', 'shorouk@hh.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'shorouk', 'eissa', 0, 0, '2021-06-03 19:06:05', 'female', NULL),
(22, 'mariam', 'mariam@yahoo.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'mariam', 'eissa', 0, 1, '2021-06-03 19:06:32', 'female', NULL),
(26, 'nashat', 'nashat@ii.com', '47370408072PicsArt_03-23-07.35.14.jpg', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'ahmed', 'nashat', 0, 0, '2021-06-03 19:55:12', 'male', NULL),
(27, 'samir', 'samir@yahoo.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'samir', 'abdelazim', 0, 1, '2021-06-03 19:55:47', 'male', NULL),
(31, '3bslam99', '3bslam@3bslam.3bslam', '', 0, '22e32446f65e2fd2877eaabec8b2c92cd47d70e3', '3bslam', '3bslam', 0, 0, '2021-06-04 12:45:42', 'male', NULL),
(39, 'ahmedsameh', 'ahmedsameh@yahoo.com', '', 0, '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ahmed', 'sameh', 0, 1, '2021-06-04 16:07:36', 'male', NULL),
(48, 'test1', 'test1@test1.test1', '', 0, 'b5e9c9ab4f777c191bc847e1aca222d6836714b7', 'test1', 'test1', 0, 1, '2021-06-05 10:19:02', 'male', NULL),
(51, 'test2', 'test2@test2', '', 0, '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', 'test2', 'test2', 0, 0, '2021-06-05 10:24:56', 'male', NULL),
(52, 'test3', 'test3@test3', '', 0, '3ebfa301dc59196f18593c45e519287a23297589', 'test3', 'test3', 0, 0, '2021-06-05 10:25:18', 'male', NULL),
(53, 'test4', 'test4@test4', '', 0, '1ff2b3704aede04eecb51e50ca698efd50a1379b', 'test4', 'test4', 0, 1, '2021-06-05 10:25:43', 'male', NULL),
(58, 'testreg', 'testreg@testreg.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'testreg', 'testreg', 0, 0, '2021-06-10 15:59:33', NULL, NULL),
(59, 'testagain', 'testagain@testagain.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'testagain', 'testagain', 0, 0, '2021-06-10 16:11:23', NULL, NULL),
(60, 'gad98', 'gad98@yahoo.com', '81573653964images.jfif', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'GAD', 'mohamed', 0, 0, '2021-06-10 16:17:23', 'male', '1990-06-12'),
(61, 'testwithdate', 'testwithdate@testwithdate.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'testwithdate', 'testwithdate', 0, 0, '2021-06-10 17:28:57', 'male', '1991-09-24'),
(62, 'zayed', 'nader98@yahoo.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'nader98', 'nader', 0, 0, '2021-06-10 19:47:23', 'male', '1998-02-02'),
(63, 'ahmednashat98', 'ahmednashat98@yahoo.com', '38046684131_93314716280.jfif', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'Ahmed', 'Nashaat', 0, 0, '2021-06-13 22:43:45', 'male', '1999-05-14'),
(64, 'emad98', 'emad98@yahoo.com', '91559308856tratamiento-massada-men.jpg', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'Emad', 'Essam', 0, 0, '2021-06-17 13:49:15', 'male', '1998-05-19'),
(65, 'osama98', 'osama98@yahoo.com', '', 0, '8cb2237d0679ca88db6464eac60da96345513964', 'osama', 'abdalslam', 0, 0, '2021-06-17 14:03:55', 'male', '1999-06-16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `catigory_id` (`catigory_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `item` (`item_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `catigory_id` FOREIGN KEY (`catigory_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_id` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `item` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
