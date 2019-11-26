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
-- Cấu trúc bảng cho bảng `download_cat`
--

CREATE TABLE `download_cat` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `download_cat`
--

INSERT INTO `download_cat` (`id`, `name`, `slug`, `description`, `featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Truyện tranh', 'truyen-tranh', NULL, 0, 1, '2019-10-16 05:27:46', '2019-10-16 05:27:46'),
(2, 'Sách giáo khoa', 'sach-giao-khoa', NULL, 0, 1, '2019-10-16 08:21:14', '2019-10-16 08:21:14'),
(3, 'Sách thiếu nhi', 'sach-thieu-nhi', NULL, 0, 1, '2019-10-16 08:21:24', '2019-10-16 08:21:24'),
(4, 'Sách 18+', 'sach-18', NULL, 0, 1, '2019-10-16 08:21:49', '2019-10-16 08:21:49'),
(5, 'Sách khoa học', 'sach-khoa-hoc', NULL, 0, 1, '2019-10-16 08:22:03', '2019-10-16 08:22:03');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `download_cat`
--
ALTER TABLE `download_cat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `download_cat`
--
ALTER TABLE `download_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
