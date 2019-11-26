-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2019 at 04:59 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cats` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'chuỗi đứng trước product_slug',
  `product_slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'vi',
  `short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `inputprice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Giá nhập',
  `listedprice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `special_price` double DEFAULT NULL,
  `Column 15` double DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `currency_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `special_start_date` timestamp NULL DEFAULT NULL,
  `special_end_date` timestamp NULL DEFAULT NULL,
  `qty` int(5) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `volume` double DEFAULT NULL,
  `length` double DEFAULT NULL COMMENT 'Chiều dài',
  `width` double DEFAULT NULL COMMENT 'Chiều rộng',
  `height` double DEFAULT NULL COMMENT 'Chiều cao',
  `is_instock` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'Trạng thái sản phẩm trong kho, 1 = còn hàng, 0 = hết hàng.',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `product_branded` int(11) DEFAULT NULL,
  `hotdeal` tinyint(2) DEFAULT '0',
  `bestsales` tinyint(2) DEFAULT '0',
  `new` tinyint(2) DEFAULT '0',
  `custom_layout` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT '1',
  `seo` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `cats`, `product_uri`, `product_slug`, `sku`, `barcode`, `image`, `language`, `short_description`, `description`, `inputprice`, `listedprice`, `price`, `special_price`, `Column 15`, `currency_id`, `currency_code`, `special_start_date`, `special_end_date`, `qty`, `weight`, `volume`, `length`, `width`, `height`, `is_instock`, `status`, `product_branded`, `hotdeal`, `bestsales`, `new`, `custom_layout`, `user_id`, `seo`, `created_at`, `updated_at`) VALUES
(9, 'Canxi Milk Calcium Bio Island Úc - Sữa Bò Non Cho Bé, 90 viên', '[\"9\"]', 'me-va-be', 'canxi-milk-calcium-bio-island-uc-sua-bo-non-cho-be-90-vien', 'CACI985', NULL, NULL, 'vi', 'Milk calcium Bio island được đặc chế từ thành phần sữa bò non, giúp hỗ trợ tốt cho sự phát triển của xương và răng. Đặc biệt Canxi Milk Bio Island được sản xuất từ nguồn canxi tự nhiên rất dễ hấp thụ và không gây lắng cặn, không tác dụng phụ.', '<p><strong>Canxi Milk Bio Island của Úc có tốt không?</strong></p>\r\n\r\n<p>+ Hỗ trợ sự phát triển của xương và răng</p>\r\n\r\n<p>+ Hỗ trợ khả năng miễn dịch</p>\r\n\r\n<p>+ Canxi sữa có thành phần chính là sữa bò, được sản xuất với công nghệ Úc an toàn với, sản phẩm có thể sử dụng cho trẻ từ khi được 7 tháng tuổi</p>\r\n\r\n<p><a href=\"https://chiaki.vn/sua-canxi-cho-be-bio-island-u-c-90\"><img alt=\"Canxi Milk Calcium Bio Island Úc - Sữa Bò Non Cho Bé\" src=\"https://cdn.chiaki.vn/unsafe/0x0/left/top/smart/filters:quality(75)/https://chiaki.vn/upload/news/content/2015/08/1439007398-08082015111638.png\" /></a></p>\r\n\r\n<p><em>Sữa Canxi Milk cho bé Bio Island Úc thành phần chính là canxi và D3</em></p>\r\n\r\n<p><strong>Thành phần Bio Island Canxi Milk</strong></p>\r\n\r\n<p>Hàm lượng dinh dưỡng trong mỗi viên&nbsp;<em>Milk calcium Bio Island</em></p>\r\n\r\n<p>- Hydroxyapatile 270mg</p>\r\n\r\n<p>- Equiv, to calcium: 78mg</p>\r\n\r\n<p>- Cholecalciferol (vit D 100IU) 2,5mcg</p>\r\n\r\n<p><a href=\"https://chiaki.vn/sua-canxi-cho-be-bio-island-u-c-90\"><img alt=\"Canxi Milk Calcium Bio Island Úc - Sữa Bò Non Cho Bé\" src=\"https://cdn.chiaki.vn/unsafe/0x0/left/top/smart/filters:quality(75)/https://chiaki.vn/upload/news/content/2018/11/canxi-sua-1-jpg-1542247001-15112018085641.jpg\" /></a></p>\r\n\r\n<p><em>Thành phần và hướng dẫn sử dụng Canxi Milk của Úc cho bé</em></p>\r\n\r\n<p><strong>Cách sử dụng Canxi Milk Bio island</strong></p>\r\n\r\n<p>- Dùng cho trẻ từ 7 tháng tuổi trở lên</p>\r\n\r\n<p>Bé từ 7-12 tháng tuổi: uống 1-2 viên mỗi ngày</p>\r\n\r\n<p>Bé từ 1-3 tuổi: uống 2 viên mỗi ngày</p>\r\n\r\n<p>Bé từ 4-8 tuổi: uống 3 viên mỗi ngày</p>\r\n\r\n<p>Bé từ 9 tuổi trở lên: uống 4 viên mỗi ngày</p>\r\n\r\n<p>- Có thể uống&nbsp;<em>Milk calcium</em>&nbsp;trong khi ăn hoặc sau khi uống sữa, hoặc theo chỉ định của bác sĩ. Tốt nhất nên uống vào sau bữa ăn sáng</p>\r\n\r\n<p>- Với bé dưới 4 tuổi có thể dùng kéo cắt đầu viên sữa Canxi Bio island, sau đó trộn vào thức ăn hoặc bóp trực tiếp vào miệng bé</p>\r\n\r\n<p>- Khi kết hợp sữa canxi với kẽm và DHA cho bé bạn nên uống cách nhau, sau bữa ăn. Canxi Bio island uống vào buổi sáng sau ăn 30 phút, kẽm uống vào buổi tối.</p>\r\n\r\n<p><strong>Cách phân biệt Canxi Milk Bio Island chính hãng</strong></p>\r\n\r\n<p>Để phân biệt&nbsp;<em>Milk calciumBio Island</em>&nbsp;quý khách có thể sử dụng các phần mềm check mã vạch như: G-check, Barcode ... Hoặc đánh mã vạch nên google. Sau khi check mã vạch, nếu là hàng thật sẽ hiển thị thông tin sản phẩm rõ ràng bao gồm: tên, mã Code, xuất xứ.</p>', '{\"VND\":\"250000\"}', '{\"VND\":\"410000\"}', '{\"VND\":{\"1\":\"329000\",\"2\":\"329000\",\"3\":\"300000\"}}', NULL, NULL, NULL, NULL, NULL, NULL, 1000, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 1, 1, 0, 'default', 1, NULL, '2019-10-13 14:12:54', '2019-10-19 06:34:21'),
(10, 'Canxi Hartus Dành Cho Trẻ Từ 4 Tháng Tuổi 150ml', '[\"8\",\"9\"]', 'thuc-pham-chuc-nang', 'canxi-hartus-danh-cho-tre-tu-4-thang-tuoi-150ml', 'CSLA324', NULL, NULL, 'vi', 'Canxi sinh học Hartus là sản phẩm được chiết xuất từ thực vật theo công nghệ Lipocal sau đó được micro hóa (làm mịn, nhỏ) tráng phủ lớp lethcin đậu nành giúp canxi phân tán đồng nhất, không bị lắng cặn, không nôn. Hartus giúp hỗ trợ tốt cho xương của bé, hương vị chuối rất ngọt ngào làm bé không chỉ dễ uống mà còn yêu thích, giúp ba mẹ cho bé uống canxi dễ dàng như cho bé uống siro ngọt, không gây cảm giác sợ hãi ở trẻ.', '<h3><strong>Canxi Hartus có tốt không?</strong></h3>\r\n\r\n<p>- Canxi Hartus bổ sung 3 thành phần chính calci, vitamin D3 và vitamin K tốt cho xương của bé</p>\r\n\r\n<p>- Hartus Canxi được chiết xuất theo công nghệ Lipocal tạo ra tricalci phosphate, hàm lượng canxi nguyên tố trong hợp chất là 41%. Đây là con số rất cao vì bình thường canxi nguyên tố dạng tricalci phosphat chỉ được 39% và calcium cacbonat 40% là cao nhất</p>\r\n\r\n<p>- Canxi Hartus đã được micro hóa, làm mịn, nhỏ và được bọc bởi lecithin nên rất dễ hấp thu</p>\r\n\r\n<p>- Hương vị thơm ngon, dễ uống: canxi Hartus có hương vị chuối rất thơm ngon và ngọt dịu. Đồng thời để bé dễ uống hơn, bạn cũng có thể hòa cùng với nước mà không phải lo lắng về vấn đề canxi Hartus bị lắng cặn giống như những loại canxi khác.</p>\r\n\r\n<p>- Canxi Hartus đã được chứng minh hấp thụ tốt hơn canxi từ sữa 15%</p>\r\n\r\n<p>- Không sợ bé bị nôn trớ: Canxi Hartus được bọc trong phân tử lecithin nên được phân bố đồng nhất, không lắng cặn, không tạo cho bé cảm giác đắng nên bé sẽ không bị nôn trớ khi uống giống như những loại canxi dạng siro thông thường khác</p>\r\n\r\n<h3><strong>Công dụng của Canxi Hartus</strong></h3>\r\n\r\n<p>- Hỗ trợ bổ sung canxi, vitamin D và Vitamin K cho trẻ</p>\r\n\r\n<p>- Hỗ trợ phát triển chiều cao của trẻ</p>\r\n\r\n<p>- Hỗ trợ tốt cho xương và răng</p>\r\n\r\n<p>- Không phẩm màu, không phụ gia gây hại tốt cho sức khỏe của bé</p>\r\n\r\n<h3><strong>Thành phần của Canxi Hartus</strong></h3>\r\n\r\n<p>- Canxi: 228mg, vitamin K (25 IU), Vitamin D3 (2.5 IU)</p>\r\n\r\n<h3><strong>Đối tượng sử dụng</strong></h3>\r\n\r\n<p>- Trẻ em trong giai đoạn tăng trưởng, phụ nữ mang thai và cho con bú, người lớn tuổi</p>\r\n\r\n<p>- Trường hợp còi xương, loãng xương, ít tiếp xúc với ánh nắng mặt trời, sử dụng corticoid kéo dài.</p>\r\n\r\n<h3><strong>Hướng dẫn sử dụng</strong></h3>\r\n\r\n<p>- Trẻ em từ 4 tháng tuổi đến 3 tuổi: sử dụng 5- ml/ngày</p>\r\n\r\n<p>- Trẻ từ 4 tuổi đến 18 tuổi: sử dụng 10 ml/ngày</p>\r\n\r\n<p>- Người lớn: sử dụng 15 ml/ngày</p>\r\n\r\n<p>- Uống tốt nhất sau ăn sáng 30 phút</p>\r\n\r\n<p>- Không nên vượt quá liều khuyến cáo hàng ngày</p>\r\n\r\n<h3><strong>Mua Canxi Hartus chính hãng cho bé ở đâu?</strong></h3>\r\n\r\n<p>Chiaki.vn cam kết cung cấp sản phẩm Canxi Hartus cho trẻ từ 4 tháng tuổi và nhiều sản phẩm Canxi cho bé chính hãng 100%. Khách hàng có thể đặt mua bằng cách:</p>\r\n\r\n<p>- Đặt mua Online bằng nút \"Mua hàng\" trên trang chi tiết sản phẩm</p>\r\n\r\n<p>- Đến mua trực tiếp theo địa chỉ:</p>\r\n\r\n<p>- Tại HN: (Vui lòng đặt hàng online hoặc qua điện thoại)</p>\r\n\r\n<p>- Tại HCM: Số 62, Yên Đỗ, Phường 1, Bình Thạnh, TP. Hồ Chí Minh</p>\r\n\r\n<p>- SĐT: 0942.666.300</p>\r\n\r\n<h3><strong>Thông tin chi tiết</strong></h3>\r\n\r\n<p>Sản phẩm: Canxi Hartus cho trẻ từ 4 tháng tuổi</p>\r\n\r\n<p>Hãng sản xuất: Laboratoria Natury</p>\r\n\r\n<p>Xuất xứ: Ba Lan</p>\r\n\r\n<p>Quy cách sản phẩm: hộp 150ml</p>\r\n\r\n<p>Giá của Canxi Hartus cho trẻ từ 4 tháng tuổi: 154.000đ/ hộp</p>', '{\"VND\":\"120000\"}', '{\"VND\":\"225000\"}', '{\"VND\":{\"1\":\"154000\",\"2\":\"154000\",\"3\":\"132000\"}}', NULL, NULL, NULL, NULL, NULL, NULL, 1000, NULL, NULL, NULL, NULL, NULL, 1, 1, 3, 1, 1, 0, 'default', 1, NULL, '2019-10-13 14:15:50', '2019-10-18 01:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE `product_brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` int(11) DEFAULT NULL,
  `cat_id` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_brands`
--

INSERT INTO `product_brands` (`id`, `name`, `slug`, `image`, `description`, `status`, `cat_id`, `created_at`, `updated_at`) VALUES
(3, 'Apple', 'apple', '/storage/userfiles/images/icon1.png', '<p>apple</p>', 1, '[\"1\", \"7\"]', '2019-09-30 07:03:06', '2019-09-30 07:11:47'),
(6, 'Samsung', 'samsung', NULL, NULL, 1, '[\"7\"]', '2019-09-30 08:25:43', '2019-09-30 08:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_gallery`
--

CREATE TABLE `product_gallery` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_thumb` tinyint(2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_gallery`
--

INSERT INTO `product_gallery` (`id`, `product_id`, `product_type`, `value`, `label`, `is_thumb`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(24, 9, 'product', '/storage/userfiles/images/sua-canxi-cho-be-bio-island-uc.jpg', '', 1, 0, 1, '2019-10-13 14:12:54', '2019-10-13 14:12:54'),
(25, 9, 'product', '/storage/userfiles/images/sua-canxi-cho-be-bio-island-u-c-90-vie.jpg', '', 0, 0, 1, '2019-10-13 14:12:54', '2019-10-13 14:12:54'),
(26, 10, 'product', '/storage/userfiles/images/5a55e7aca440b.png', '', 1, 0, 1, '2019-10-13 14:15:50', '2019-10-13 14:15:50'),
(27, 10, 'product', '/storage/userfiles/images/5a55e7aca8b1a.png', '', 0, 0, 1, '2019-10-13 14:15:50', '2019-10-13 14:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `product_option`
--

CREATE TABLE `product_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `option_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `is_required` tinyint(2) DEFAULT '1',
  `lang` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_option`
--

INSERT INTO `product_option` (`id`, `name`, `type`, `option_type`, `sort_order`, `is_required`, `lang`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Công suất', 'product', 'radio', 2, 1, NULL, 1, '2019-10-02 07:27:14', '2019-10-02 07:27:14'),
(3, 'Thể tích', 'product', 'radio', 3, 1, NULL, 1, '2019-10-02 07:27:14', '2019-10-02 07:27:14'),
(4, 'Màu sắc', 'product', 'radio', 1, 1, NULL, 1, '2019-10-02 07:35:04', '2019-10-02 07:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_option_value`
--

CREATE TABLE `product_option_value` (
  `id` int(11) NOT NULL,
  `option_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `option_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_option_value`
--

INSERT INTO `product_option_value` (`id`, `option_name`, `option_id`, `name`, `product_id`, `sku`, `price`, `lang`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Màu sắc', 4, 'Màu hồng', 10, 'CSLA324_red', '{\"VND\":{\"1\":\"20000\",\"2\":\"-2000\",\"3\":\"200\"}}', 'vi', 1, 1, '2019-10-18 10:03:43', '2019-10-19 03:21:52'),
(3, 'Thể tích', 3, '32gb', 10, 'CSLA324_asdad', '{\"VND\":{\"1\":\"2000\",\"2\":\"2000\",\"3\":\"2000\"}}', 'vi', NULL, 1, '2019-10-19 02:58:32', '2019-10-19 02:58:32');

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` int(11) NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `product` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_type` varchar(255) DEFAULT NULL COMMENT 'product, option',
  `value` double NOT NULL COMMENT 'giá niêm yết',
  `order_id` int(11) NOT NULL,
  `price` double DEFAULT NULL COMMENT 'Giá bán nhận về',
  `qty` int(11) NOT NULL,
  `sumvalue` double DEFAULT NULL COMMENT 'doanh số niêm yết',
  `discount` double DEFAULT NULL,
  `subtotal` double NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(50) NOT NULL,
  `user` int(11) NOT NULL,
  `user_info` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `cart_content` text NOT NULL,
  `shipment` int(1) NOT NULL DEFAULT '0',
  `provider` varchar(50) DEFAULT NULL,
  `provider_request` varchar(255) DEFAULT NULL COMMENT 'Mã gửi yêu cầu lên nhà cung cấp',
  `provider_trans` varchar(255) DEFAULT NULL COMMENT 'Mã giao dịch của nhà cung cấp',
  `logs` text COMMENT 'Lịch sử log từ nhà cung cấp',
  `merchant_logs` text COMMENT 'Thông tin log gửi xuống merchant',
  `views` int(11) DEFAULT '0',
  `request_id` varchar(255) DEFAULT NULL COMMENT 'mã của khách api',
  `partner_id` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `order_code`, `product`, `product_id`, `product_type`, `value`, `order_id`, `price`, `qty`, `sumvalue`, `discount`, `subtotal`, `currency_id`, `currency_code`, `user`, `user_info`, `status`, `payment`, `cart_content`, `shipment`, `provider`, `provider_request`, `provider_trans`, `logs`, `merchant_logs`, `views`, `request_id`, `partner_id`, `method`, `created_at`, `updated_at`) VALUES
(96, 'PW5DA40CE69D6DB', 'Canxi Hartus Dành Cho Trẻ Từ 4 Tháng Tuổi, 150ml', '10', 'product', 225000, 179, 154000, 1, 225000, 31.555555555555554, 154000, 1, 'VND', 25, 'Nguyễn NEO', 'none', 'none', '{\"rowId\":\"9a53402620662199a253e54f39d58cb6\",\"id\":10,\"name\":\"Canxi Hartus D\\u00e0nh Cho Tr\\u1ebb T\\u1eeb 4 Th\\u00e1ng Tu\\u1ed5i, 150ml\",\"qty\":1,\"price\":154000,\"options\":{\"discount\":31.555555555555554,\"currency_id\":1,\"currency_code\":\"VND\"},\"tax\":0,\"subtotal\":154000}', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'WEB', '2019-10-14 05:51:34', '2019-10-14 05:51:34'),
(97, 'PW5DA40F19ED058', 'Canxi Hartus Dành Cho Trẻ Từ 4 Tháng Tuổi, 150ml', '10', 'product', 225000, 180, 154000, 1, 225000, 31.555555555555554, 154000, 1, 'VND', 34, 'Nguyen Van Nghia', 'none', 'none', '{\"rowId\":\"9a53402620662199a253e54f39d58cb6\",\"id\":10,\"name\":\"Canxi Hartus D\\u00e0nh Cho Tr\\u1ebb T\\u1eeb 4 Th\\u00e1ng Tu\\u1ed5i, 150ml\",\"qty\":1,\"price\":154000,\"options\":{\"discount\":31.555555555555554,\"currency_id\":1,\"currency_code\":\"VND\"},\"tax\":0,\"subtotal\":154000}', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'WEB', '2019-10-14 06:00:57', '2019-10-14 06:00:57'),
(98, 'PW5DA41399B44AC', 'Canxi Hartus Dành Cho Trẻ Từ 4 Tháng Tuổi, 150ml', '10', 'product', 225000, 181, 154000, 1, 225000, 31.555555555555554, 154000, 1, 'VND', 25, 'Nguyễn NEO', 'none', 'none', '{\"rowId\":\"9a53402620662199a253e54f39d58cb6\",\"id\":10,\"name\":\"Canxi Hartus D\\u00e0nh Cho Tr\\u1ebb T\\u1eeb 4 Th\\u00e1ng Tu\\u1ed5i, 150ml\",\"qty\":1,\"price\":154000,\"options\":{\"discount\":31.555555555555554,\"currency_id\":1,\"currency_code\":\"VND\"},\"tax\":0,\"subtotal\":154000}', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'WEB', '2019-10-14 06:20:09', '2019-10-14 06:20:09'),
(99, 'PW5DA41B064EAF1', 'Canxi Hartus Dành Cho Trẻ Từ 4 Tháng Tuổi, 150ml', '10', 'product', 225000, 182, 154000, 1, 225000, 31.555555555555554, 154000, 1, 'VND', 35, 'Nguyen Van Nghia', 'none', 'none', '{\"rowId\":\"9a53402620662199a253e54f39d58cb6\",\"id\":10,\"name\":\"Canxi Hartus D\\u00e0nh Cho Tr\\u1ebb T\\u1eeb 4 Th\\u00e1ng Tu\\u1ed5i, 150ml\",\"qty\":1,\"price\":154000,\"options\":{\"discount\":31.555555555555554,\"currency_id\":1,\"currency_code\":\"VND\"},\"tax\":0,\"subtotal\":154000}', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'WEB', '2019-10-14 06:51:50', '2019-10-14 06:51:50'),
(100, 'PW5DA420DED72B5', 'Canxi Hartus Dành Cho Trẻ Từ 4 Tháng Tuổi, 150ml', '10', 'product', 225000, 183, 154000, 1, 225000, 31.555555555555554, 154000, 1, 'VND', 36, 'Đức Tiến', 'none', 'none', '{\"rowId\":\"9a53402620662199a253e54f39d58cb6\",\"id\":10,\"name\":\"Canxi Hartus D\\u00e0nh Cho Tr\\u1ebb T\\u1eeb 4 Th\\u00e1ng Tu\\u1ed5i, 150ml\",\"qty\":1,\"price\":154000,\"options\":{\"discount\":31.555555555555554,\"currency_id\":1,\"currency_code\":\"VND\"},\"tax\":0,\"subtotal\":154000}', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'WEB', '2019-10-14 07:16:46', '2019-10-14 07:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `id` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `checksum` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'md5 (group +product_di)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`id`, `group`, `product_id`, `price`, `currency_id`, `currency_code`, `checksum`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 40000, 1, 'VND', NULL, '2019-09-27 07:10:22', '2019-09-27 07:10:22'),
(2, 3, 1, 54400, 1, 'VND', NULL, '2019-09-27 07:10:42', '2019-09-27 07:10:42'),
(3, 2, 2, 65000, 1, 'VND', NULL, '2019-09-27 07:11:09', '2019-09-27 07:11:09'),
(4, 1, 4, 40000000, 1, 'VND', 'aab3238922bcc25a6f606eb525ffdc56', '2019-10-02 07:36:57', '2019-10-02 07:36:57'),
(5, 2, 4, 48000000, 1, 'VND', '1ff1de774005f8da13f42943881c655f', '2019-10-02 07:36:57', '2019-10-02 07:36:57'),
(6, 3, 4, 45000000, 1, 'VND', 'e369853df766fa44e1ed0ff613f563bd', '2019-10-02 07:36:57', '2019-10-02 07:36:57'),
(7, 1, 3, 35000000, 1, 'VND', 'c51ce410c124a10e0db5e4b97fc2af39', '2019-10-02 07:37:32', '2019-10-02 07:37:32'),
(8, 2, 3, 40000000, 1, 'VND', '37693cfc748049e45d87b8c7d8b9aacd', '2019-10-02 07:37:32', '2019-10-02 07:37:32'),
(9, 3, 3, 38000000, 1, 'VND', '182be0c5cdcd5072bb1864cdee4d3d6e', '2019-10-02 07:37:32', '2019-10-02 07:37:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD UNIQUE KEY `product_slug` (`product_slug`);

--
-- Indexes for table `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_option`
--
ALTER TABLE `product_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `product_option_value`
--
ALTER TABLE `product_option_value`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `FK_product_option_value_product_option` (`option_name`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `checksum` (`checksum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_brands`
--
ALTER TABLE `product_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_gallery`
--
ALTER TABLE `product_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `product_option`
--
ALTER TABLE `product_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_option_value`
--
ALTER TABLE `product_option_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `product_price`
--
ALTER TABLE `product_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_option_value`
--
ALTER TABLE `product_option_value`
  ADD CONSTRAINT `FK_product_option_value_product_option` FOREIGN KEY (`option_name`) REFERENCES `product_option` (`name`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
