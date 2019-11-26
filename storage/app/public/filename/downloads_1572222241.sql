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
-- Cấu trúc bảng cho bảng `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_extension` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `server_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `download` int(11) NOT NULL DEFAULT 0,
  `cat_id` int(11) DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public` int(11) DEFAULT 1,
  `status` int(11) DEFAULT 1,
  `approved` int(11) DEFAULT 0,
  `featured` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `downloads`
--

INSERT INTO `downloads` (`id`, `name`, `slug`, `user_id`, `description`, `short_description`, `filename`, `file_extension`, `img`, `server_id`, `token`, `rating`, `views`, `download`, `cat_id`, `price`, `discount`, `public`, `status`, `approved`, `featured`, `created_at`, `updated_at`) VALUES
(46, 'Maria Ozawa', 'maria-ozawa', 1, '<p>rqr<strong> 21e414</strong><strong><em> 122r4124</em></strong><br />\r\n&nbsp;</p>', '123123213', 'New Text Document.txt', 'exe', 'taixuong.jpg', NULL, NULL, 4.8, 0, 0, 1, '{\"VND\":\"23000\",\"USD\":\"1\",\"TWD\":\"1\"}', 'k có k.m đâu nhé con sâu', 0, 1, 0, 1, '2019-10-22 03:04:02', '2019-10-26 02:51:58'),
(47, '1323', '1323', 1, '<p>3123123</p>', '123123', 'Vote.zip', '31321', 'taixuong.jpg', NULL, NULL, 4.3, 0, 0, 1, '{\"VND\":\"13223123\",\"USD\":\"12\",\"TWD\":\"323\"}', '123123', 1, 0, 0, 1, '2019-10-22 03:05:16', '2019-10-26 02:52:42'),
(48, 'Tài liệu tài nguyên và môi trường', 'tai-lieu-tai-nguyen-va-moi-truong', 32, '<p>312312313<br />\r\n&nbsp;</p>', '31312313', 'Helpers.zip', 'txt', 'taixuong.jpg', NULL, NULL, NULL, 0, 0, 1, '{\"VND\":\"250000\",\"USD\":\"10\",\"TWD\":\"9\"}', '0', 1, 1, 0, 1, '2019-10-23 02:47:12', '2019-10-26 02:52:53'),
(49, 'Truyện ma', 'truyen-ma', 32, '<p>313123123</p>', '12313123', 'product-4.png', 'exe', 'taixuong.jpg', NULL, NULL, NULL, 0, 0, 1, '{\"VND\":\"0\",\"USD\":\"0\",\"TWD\":\"0\"}', NULL, 0, 1, 0, 0, '2019-10-26 02:42:14', '2019-10-26 02:53:02'),
(50, 'Tài liệu học laravel', 'tai-lieu-hoc-laravel', 32, '<p>13123123</p>', '13123123', 'SamSung-Note-9.jpg', 'mp4', 'taixuong.jpg', NULL, NULL, NULL, 0, 0, 1, '{\"VND\":\"2000000\",\"USD\":\"22\",\"TWD\":\"12\"}', '0', 1, 1, 0, 1, '2019-10-26 02:43:16', '2019-10-26 02:53:12'),
(51, 'Tài liệu học C++', 'tai-lieu-hoc-c', 32, '<p>12312312</p>', '123123', 'SamSung-Note-9.jpg', 'exe', 'taixuong.jpg', NULL, NULL, NULL, 0, 0, 1, '{\"VND\":\"0\",\"USD\":\"0\",\"TWD\":\"0\"}', '0', 0, 1, 0, 1, '2019-10-26 02:44:08', '2019-10-26 02:52:11'),
(52, 'Phim Naruto: The last', 'phim-naruto-the-last', 32, '<p>Đánh ghen trên mặt trăng</p>', 'Naruto-Hinata', 'tải xuống.jpg', 'mp4', 'taixuong.jpg', NULL, NULL, NULL, 0, 0, 1, '{\"VND\":\"1000000000\",\"USD\":\"50000\",\"TWD\":\"45000\"}', '0', 1, 1, 0, 1, '2019-10-26 02:47:06', '2019-10-26 02:53:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
