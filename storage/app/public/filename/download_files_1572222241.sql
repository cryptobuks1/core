-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 26, 2019 lúc 06:51 AM
-- Phiên bản máy phục vụ: 10.3.13-MariaDB-log
-- Phiên bản PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `core`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `download_files`
--

CREATE TABLE `download_files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_extension` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `download_files`
--

INSERT INTO `download_files` (`id`, `filename`, `file_extension`, `file_description`, `file_size`, `user_id`, `download_id`, `server_id`, `public`, `created_at`, `updated_at`) VALUES
(45, 'cau1.txt', 'exe', 'afafbwbf', NULL, 32, 27, NULL, 0, '2019-10-19 03:53:55', '2019-10-19 03:53:55'),
(46, 'cau2 p1.txt', 'exe', 'afafbwbf', NULL, 32, 27, NULL, 0, '2019-10-19 03:53:55', '2019-10-19 03:53:55'),
(47, 'cau2 p2.1.txt', 'exe', 'afafbwbf', NULL, 32, 27, NULL, 0, '2019-10-19 03:53:55', '2019-10-19 03:53:55'),
(48, 'cau2 p1.txt', 'đâsadsadad', '13123', NULL, 32, 28, NULL, 0, '2019-10-19 04:13:22', '2019-10-19 04:13:22'),
(49, 'cau2 p2.3.txt', 'đâsadsadad', '13123', NULL, 32, 28, NULL, 0, '2019-10-19 04:13:22', '2019-10-19 04:13:22'),
(52, 'cau2 p2.2.txt', 'txt', '123123', NULL, 32, 29, NULL, 0, '2019-10-19 06:57:47', '2019-10-19 06:57:47'),
(57, 'Vote.zip', '1231', '13', NULL, 32, 38, NULL, 0, '2019-10-19 09:12:56', '2019-10-19 09:12:56'),
(58, 'shop.sql', 'mp4', '1123123', NULL, 1, 40, NULL, 0, '2019-10-21 03:35:21', '2019-10-21 03:35:21'),
(59, '71761859_2572933732938026_794318604706250752_n (1).jpg', 'mp4', '1123123', NULL, 40, 40, NULL, 0, '2019-10-21 08:00:03', '2019-10-21 08:00:03'),
(62, '71761859_2572933732938026_794318604706250752_n (1).jpg', 'mp4', '1123123', NULL, 40, 40, NULL, 0, '2019-10-21 08:47:50', '2019-10-21 08:47:50'),
(63, 'photo1516430115640-1516430115641.jpg', 'mp4', '1123123', NULL, 40, 40, NULL, 0, '2019-10-21 08:47:50', '2019-10-21 08:47:50'),
(64, 'vp_users.sql', 'mp4', '1123123', NULL, 40, 40, NULL, 0, '2019-10-21 08:47:50', '2019-10-21 08:47:50'),
(65, 'votes (1).sql', 'mp4', '1123123', NULL, 40, 40, NULL, 0, '2019-10-21 08:47:50', '2019-10-21 08:47:50'),
(66, 'BCompare-4.2.10.23938.exe', 'exe', '123123213', NULL, 1, 46, NULL, 0, '2019-10-22 03:04:03', '2019-10-22 03:04:03'),
(67, 'photo1516430115640-1516430115641.jpg', 'exe', '123123213', NULL, 1, 46, NULL, 0, '2019-10-22 03:04:03', '2019-10-22 03:04:03'),
(68, 'Vote.zip', 'exe', '123123213', NULL, 1, 46, NULL, 0, '2019-10-22 03:04:03', '2019-10-22 03:04:03'),
(69, 'Helpers.zip', 'exe', '123123213', NULL, 1, 46, NULL, 0, '2019-10-22 03:04:03', '2019-10-22 03:04:03'),
(70, 'Localisation.zip', 'exe', '123123213', NULL, 1, 46, NULL, 0, '2019-10-22 03:04:03', '2019-10-22 03:04:03'),
(71, 'New Text Document.txt', 'exe', '123123213', NULL, 1, 46, NULL, 0, '2019-10-22 03:04:03', '2019-10-22 03:04:03'),
(72, '71761859_2572933732938026_794318604706250752_n (1).jpg', '31321', '123123', NULL, 1, 47, NULL, 0, '2019-10-22 03:05:16', '2019-10-22 03:05:16'),
(73, 'BCompare-4.2.10.23938.exe', '31321', '123123', NULL, 1, 47, NULL, 0, '2019-10-22 03:05:17', '2019-10-22 03:05:17'),
(74, 'photo1516430115640-1516430115641.jpg', '31321', '123123', NULL, 1, 47, NULL, 0, '2019-10-22 03:05:17', '2019-10-22 03:05:17'),
(75, 'Vote.zip', '31321', '123123', NULL, 1, 47, NULL, 0, '2019-10-22 03:05:17', '2019-10-22 03:05:17'),
(76, '71761859_2572933732938026_794318604706250752_n (1).jpg', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:12', '2019-10-23 02:47:12'),
(77, 'BCompare-4.2.10.23938.exe', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:14', '2019-10-23 02:47:14'),
(78, 'photo1516430115640-1516430115641.jpg', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:14', '2019-10-23 02:47:14'),
(79, 'Vote.zip', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:14', '2019-10-23 02:47:14'),
(80, 'Helpers.zip', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:14', '2019-10-23 02:47:14'),
(81, '71761859_2572933732938026_794318604706250752_n (1).jpg', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:14', '2019-10-23 02:47:14'),
(82, 'BCompare-4.2.10.23938.exe', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:15', '2019-10-23 02:47:15'),
(83, 'photo1516430115640-1516430115641.jpg', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:15', '2019-10-23 02:47:15'),
(84, 'Vote.zip', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:15', '2019-10-23 02:47:15'),
(85, 'Helpers.zip', 'txt', '31312313', NULL, 32, 48, NULL, 0, '2019-10-23 02:47:15', '2019-10-23 02:47:15'),
(86, '71761859_2572933732938026_794318604706250752_n (1).jpg', 'exe', '123123213', NULL, 46, 46, NULL, 0, '2019-10-23 03:12:43', '2019-10-23 03:12:43'),
(89, 'IPhone-5s-black.jpg', 'exe', '12313123', NULL, 32, 49, NULL, 0, '2019-10-26 02:42:15', '2019-10-26 02:42:15'),
(90, 'iphone7-plus-black-select-2016.jpg', 'exe', '12313123', NULL, 32, 49, NULL, 0, '2019-10-26 02:42:15', '2019-10-26 02:42:15'),
(91, 'product-2.png', 'exe', '12313123', NULL, 32, 49, NULL, 0, '2019-10-26 02:42:15', '2019-10-26 02:42:15'),
(92, 'product-3.png', 'exe', '12313123', NULL, 32, 49, NULL, 0, '2019-10-26 02:42:15', '2019-10-26 02:42:15'),
(93, 'product-4.png', 'exe', '12313123', NULL, 32, 49, NULL, 0, '2019-10-26 02:42:15', '2019-10-26 02:42:15'),
(94, 'anhdienthoai.jpg', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(95, 'HTC-J5.jpg', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(96, 'IPhone-5s-black.jpg', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(97, 'iphone7-plus-black-select-2016.jpg', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(98, 'Oppo-S8.jpg', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(99, 'product-1.png', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(100, 'product-2.png', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(101, 'product-3.png', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(102, 'product-4.png', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(103, 'SamSung-Note-9.jpg', 'mp4', '13123123', NULL, 32, 50, NULL, 0, '2019-10-26 02:43:16', '2019-10-26 02:43:16'),
(104, 'anhdienthoai.jpg', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(105, 'HTC-J5.jpg', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(106, 'IPhone-5s-black.jpg', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(107, 'iphone7-plus-black-select-2016.jpg', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(108, 'Oppo-S8.jpg', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(109, 'product-1.png', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(110, 'product-2.png', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(111, 'product-3.png', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(112, 'product-4.png', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(113, 'SamSung-Note-9.jpg', 'exe', '123123', NULL, 32, 51, NULL, 0, '2019-10-26 02:44:08', '2019-10-26 02:44:08'),
(114, 'tải xuống.jpg', 'mp4', 'Naruto-Hinata', NULL, 32, 52, NULL, 0, '2019-10-26 02:47:06', '2019-10-26 02:47:06');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `download_files`
--
ALTER TABLE `download_files`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `download_files`
--
ALTER TABLE `download_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
