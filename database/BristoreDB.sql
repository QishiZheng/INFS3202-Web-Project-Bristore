-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 25, 2018 at 01:28 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BristoreDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_to_cart`
--

CREATE TABLE `add_to_cart` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_to_cart`
--

INSERT INTO `add_to_cart` (`user_id`, `item_id`, `qty`) VALUES
(4, 1, 16),
(4, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `item_title` varchar(255) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_price` decimal(18,2) NOT NULL,
  `item_stock` int(255) NOT NULL,
  `item_category` int(11) NOT NULL DEFAULT '9',
  `item_description` text NOT NULL,
  `item_pic` varchar(255) NOT NULL,
  `item_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_title`, `item_url`, `item_price`, `item_stock`, `item_category`, `item_description`, `item_pic`, `item_created_at`) VALUES
(1, 'item1', 'item1', '120.00', 9979, 1, '                                This is test item 1                            ', '', '2018-04-10 05:26:34'),
(2, 'Washing Machine', 'Washing-Machine', '999.00', 331, 2, '                                                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\n                                                        ', 'item2_img.jpg', '2018-04-10 05:26:34'),
(3, 'furniture', 'furniture', '200.00', 0, 1, '                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.                            ', 'item3_img.jpg', '2018-04-10 09:12:17'),
(4, 'item4', '', '25000.00', 0, 3, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '2018-04-10 09:12:17'),
(5, 'item5', 'item5', '1.99', 0, 5, '                                \"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"                            ', '', '2018-04-10 09:13:55'),
(8, 'Books', 'Books', '23.00', 0, 3, '<b>Books</b>', 'item8_img.jpg', '2018-04-22 08:17:30'),
(12, 'pen', 'pen', '12.00', 2, 2, 'This is a pen', '', '2018-04-22 12:04:12'),
(14, 'My Cat', 'My-Cat', '99999999.00', 0, 9, '                                                                This is my Cat                                                        ', 'item14_img.jpg', '2018-05-04 11:25:43'),
(15, 't-shirts', 't-shirts', '34.00', 15, 4, '                                                                                                t-shirts', 'item15_img.jpg', '2018-05-17 01:44:14'),
(16, 'chair', 'chair', '95.55', 20, 1, '                                                                This is a wooden chair                                                        ', '', '2018-05-17 01:48:03'),
(17, 'Headphones', 'Headphones', '330.00', 25, 8, '                                This is a pair of headphone                            ', 'item17_img.jpg', '2018-05-20 01:53:33'),
(18, 'New Headphones', 'New-Headphones', '300.00', 2, 8, '                                My headphones                            ', 'item18_img.jpg', '2018-05-23 13:32:13'),
(19, 'Watch', 'Watch', '1000.00', 4, 7, 'A Watch', 'item19_img.jpg', '2018-05-23 13:35:12'),
(20, 'Keyboard', 'Keyboard', '200.00', 50, 8, 'Mechanical keyboard', 'item20_img.jpg', '2018-05-23 13:36:35'),
(22, 'Nikon DSLR Camera', 'Nikon-DSLR-Camera', '2000.00', 2, 8, 'A Nikon DSLR', 'item22_img.jpg', '2018-05-24 12:14:22'),
(23, 'My Cat Again', 'My-Cat-Again', '999999999.00', 1, 9, 'This is my cat', 'item23_img.jpg', '2018-05-24 12:15:44'),
(24, 'Perfume', 'Perfume', '100.00', 99, 7, 'Perfume', 'item24_img.jpg', '2018-05-24 12:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_category`
--

INSERT INTO `item_category` (`id`, `cat_name`) VALUES
(1, 'Home & Garden'),
(2, 'Appliances'),
(3, 'Books & Magazines'),
(4, 'Clothes'),
(5, 'Bags & Luggage'),
(6, 'Vehicles'),
(7, 'Accessories'),
(8, 'Electronics'),
(9, 'Othres');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shipping_address` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `time`, `shipping_address`, `billing_address`, `user_id`) VALUES
(17, '2018-05-21 05:46:46', '48 Walcott Street St Lucia Qld 4067', '48 Walcott Street St Lucia Qld 4067', 2),
(18, '2018-05-21 11:37:31', '', '', 12),
(19, '2018-05-22 13:08:07', '48 Walcott Street St Lucia Qld 4067', '48 Walcott Street St Lucia Qld 4067', 2),
(20, '2018-05-22 18:13:02', '1, Campbell Road, Saint Lucia, QLD, Australia, 4067', '1, Campbell Road, Saint Lucia, QLD, Australia, 4067', 2),
(21, '2018-05-22 18:17:10', '1, Campbell Road, Saint Lucia, QLD, Australia, 4067', '1, Campbell Road, Saint Lucia, QLD, Australia, 4067', 2),
(22, '2018-05-22 23:02:18', '1, Campbell Road, Saint Lucia, QLD, Australia, 4067', '1, Campbell Road, Saint Lucia, QLD, Australia, 4067', 2),
(23, '2018-05-23 06:53:12', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', 2),
(24, '2018-05-23 06:53:51', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', 2),
(25, '2018-05-23 07:06:19', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', 2),
(26, '2018-05-23 13:05:31', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', 2),
(27, '2018-05-23 13:06:36', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', 2),
(28, '2018-05-24 01:10:54', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', '11, Jones Street, Highgate Hill, QLD, Australia, 4101', 2),
(29, '2018-05-24 08:42:20', '11, Campbell Street, Toowong, QLD, Australia, 4066', '11, Campbell Street, Toowong, QLD, Australia, 4066', 2),
(30, '2018-05-24 13:05:31', '11, Campbell Street, Toowong, QLD, Australia, 4066', '11, Campbell Street, Toowong, QLD, Australia, 4066', 2),
(31, '2018-05-24 13:06:48', '11, Campbell Street, Toowong, QLD, Australia, 4066', '11, Campbell Street, Toowong, QLD, Australia, 4066', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `item_id`, `qty`, `price`) VALUES
(17, 1, 4, '120.00'),
(18, 14, 1, '99999999.00'),
(19, 12, 2, '12.00'),
(19, 16, 3, '95.55'),
(19, 17, 5, '330.00'),
(20, 1, 3, '120.00'),
(20, 2, 6, '20.99'),
(21, 2, 5, '20.99'),
(22, 3, 1, '50.00'),
(23, 3, 1, '50.00'),
(23, 15, 3, '34.00'),
(24, 1, 3, '120.00'),
(25, 1, 4, '120.00'),
(26, 1, 1, '120.00'),
(26, 2, 1, '20.99'),
(26, 3, 1, '50.00'),
(27, 1, 1, '120.00'),
(27, 15, 1, '34.00'),
(28, 2, 1, '20.99'),
(29, 1, 1, '120.00'),
(29, 2, 6, '20.99'),
(30, 2, 1, '999.00'),
(30, 3, 1, '200.00'),
(30, 19, 1, '1000.00'),
(31, 2, 1, '999.00'),
(31, 15, 3, '34.00'),
(31, 24, 1, '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `address`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'oL59edDlgbtySbeoEzxt3O', 1268889823, 1527163550, 1, 'Admin', 'istrator', 'ADMIN', '0', 'The University of Queensland Brisbane QLD 4072 Australia'),
(2, '::1', 'vincezheng4265@gmail.com', '$2y$08$q7sTSSUnJ41i4Xh84LmwL.wEc8KjBGHxuaqZKAzq0f/X70auFVExe', NULL, 'vincezheng4265@gmail.com', NULL, 'ZAaV4B.3Lwy6-hV6JykFzu75feec95e36a40a56f', 1527036288, 'Z0/iQbaiStjjYclTem8Z3O', 1525657734, 1527165373, 1, 'Vince', 'Zheng', '', '0000000000', '11, Campbell Street, Toowong, QLD, Australia, 4066'),
(3, '::1', 'peter@gg.com', '$2y$08$CrXcoThuEDpxyfobEXdDAe6aaE24HSwNQXUbcjBW0uUaZBwBrkUSG', NULL, 'peter@gg.com', NULL, NULL, NULL, NULL, 1525747584, NULL, 1, 'Peter', 'Pan', 'n/a', '000000000', ''),
(4, '::1', 'new@user.com', '$2y$08$p4I7CZnNiIoJx4veVf2NOOQGNX6Ma8THltUWp7mcxmjU3aYW64PGu', NULL, 'new@user.com', NULL, NULL, NULL, NULL, 1525748504, 1526104521, 1, 'new', 'user', '', '12345678', ''),
(5, '::1', 'user@again.com', '$2y$08$RtEMR6ImnMB5p/McYpFWj.QrU/kQiV7iw4JuBPUQoGvgId4tFZCcW', NULL, 'user@again.com', NULL, NULL, NULL, NULL, 1525748690, NULL, 1, 'user', 'again', NULL, '12345678', ''),
(6, '::1', 'usr@again.com', '$2y$08$IeOXaj.Zbiz0N6sSmBbEyeAVptINKlFpDGdnto05kg.sbXBP9/Tl6', NULL, 'usr@again.com', NULL, NULL, NULL, 'o2oWwJEQJ6bw3crEjxDVwu', 1525749662, 1525848101, 1, 'user', 'again', NULL, '12345678', ''),
(7, '::1', 'new@usr.com', '$2y$08$mXW65H1C1CSC0zESSXYO7..wCL7FX0Jv41DVfnXu9YwaGIs7Adm/i', NULL, 'new@usr.com', NULL, NULL, NULL, NULL, 1525750802, NULL, 1, 'new', 'usr', NULL, '12345678', ''),
(8, '::1', 'ic@chen.com', '$2y$08$YO6zK1aNblxURmf6OqKE7.ncP348uHbz8FHxmDDKGxaF1v0wHFbSG', NULL, 'ic@chen.com', NULL, NULL, NULL, NULL, 1525835431, NULL, 1, 'Ivan', 'Chen', '', '', ''),
(9, '::1', 'j.snow@gmail.com', '$2y$08$qC9ryan3SAaVOGwfYJMrZupf6E8SXkXlHCNZOxucBjOwpJU6yV33W', NULL, 'j.snow@gmail.com', NULL, NULL, NULL, NULL, 1526517615, 1526517648, 1, 'John', 'Snow', NULL, '012345678', ''),
(10, '::1', 'jb@gg.com', '$2y$08$UvQCas9lLUmW/QExjzmGHu3ckltK.us8hg3kS17Gs2O9SR4snLp.K', NULL, 'jb@gg.com', NULL, NULL, NULL, NULL, 1526649174, 1526689843, 1, 'jack', 'black', NULL, '0000000', ''),
(11, '::1', 'bc@gmail.com', '$2y$08$j44X0vdbzUPlrzQ8S6Cxz.rAelvzIazpYU5rJTj0bAc.mb.GKspmC', NULL, 'bc@gmail.com', NULL, NULL, NULL, NULL, 1526695167, NULL, 1, 'brake', 'Chen', NULL, '00000000', ''),
(12, '::1', '123456@qq.com', '$2y$08$ijr2iFr3M2szTM.qW.4KkuaQW.ubhV5TCHhXsUoQ4Grvqn54NJnRm', NULL, '123456@qq.com', NULL, NULL, NULL, NULL, 1526902566, 1526902596, 1, 'di', 'didi', NULL, '0000000001', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(10, 1, 1),
(11, 1, 2),
(3, 2, 2),
(5, 3, 2),
(13, 4, 2),
(7, 5, 2),
(8, 6, 2),
(9, 7, 2),
(12, 8, 2),
(14, 9, 2),
(15, 10, 2),
(16, 11, 2),
(17, 12, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  ADD PRIMARY KEY (`user_id`,`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `add_to_cart_ibfk_2` (`item_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_category` (`item_category`);

--
-- Indexes for table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`item_id`),
  ADD KEY `item_id` (`item_id`) USING BTREE,
  ADD KEY `order_id` (`order_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  ADD CONSTRAINT `add_to_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `add_to_cart_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`item_category`) REFERENCES `item_category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
