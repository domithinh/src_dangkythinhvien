-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2025 at 08:42 AM
-- Server version: 10.6.22-MariaDB-cll-lve
-- PHP Version: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thinhvie_quanly`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `username`, `password`, `full_name`, `email`, `role`, `created_at`, `last_login`, `status`) VALUES
(1, 'admin_director', 'TongDoJohn.27/12', 'Quản trị viên', 'thinhviendaminh@gmail.com', 'admin', '2025-03-12 14:33:21', '2025-03-17 14:26:06', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `candidate_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `birth_day` int(11) NOT NULL,
  `birth_month` int(11) NOT NULL,
  `birth_year` int(11) NOT NULL,
  `birthplace` varchar(255) NOT NULL,
  `parish` varchar(255) NOT NULL,
  `diocese` varchar(255) NOT NULL,
  `education_level` varchar(50) NOT NULL,
  `graduation_year` int(11) DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `ielts_certificate` bit(1) DEFAULT b'0',
  `ielts_score` varchar(50) DEFAULT NULL,
  `toefl_certificate` bit(1) DEFAULT b'0',
  `toefl_score` varchar(50) DEFAULT NULL,
  `toeic_certificate` bit(1) DEFAULT b'0',
  `toeic_score` varchar(50) DEFAULT NULL,
  `other_certificate` bit(1) DEFAULT b'0',
  `permanent_address` varchar(255) NOT NULL,
  `contact_address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `previous_vocation` varchar(255) DEFAULT NULL,
  `previous_vocation_time` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `is_self_discovery` bit(1) DEFAULT b'0',
  `exam_location` varchar(50) NOT NULL,
  `subject_catheism` bit(1) DEFAULT b'1',
  `subject_vietnamese` bit(1) DEFAULT b'1',
  `language_choice` varchar(50) NOT NULL,
  `aspiration` varchar(50) NOT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_birth_year` int(11) DEFAULT NULL,
  `father_occupation` varchar(255) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_birth_year` int(11) DEFAULT NULL,
  `mother_occupation` varchar(255) DEFAULT NULL,
  `family_parish` varchar(255) DEFAULT NULL,
  `family_diocese` varchar(255) DEFAULT NULL,
  `parish_priest` varchar(255) DEFAULT NULL,
  `registration_date` datetime DEFAULT current_timestamp(),
  `exam_date` date DEFAULT NULL CHECK (`exam_date` in ('2025-06-09','2025-06-23'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `fullname`, `birth_day`, `birth_month`, `birth_year`, `birthplace`, `parish`, `diocese`, `education_level`, `graduation_year`, `major`, `ielts_certificate`, `ielts_score`, `toefl_certificate`, `toefl_score`, `toeic_certificate`, `toeic_score`, `other_certificate`, `permanent_address`, `contact_address`, `email`, `phone`, `previous_vocation`, `previous_vocation_time`, `referrer`, `is_self_discovery`, `exam_location`, `subject_catheism`, `subject_vietnamese`, `language_choice`, `aspiration`, `father_name`, `father_birth_year`, `father_occupation`, `mother_name`, `mother_birth_year`, `mother_occupation`, `family_parish`, `family_diocese`, `parish_priest`, `registration_date`, `exam_date`) VALUES
(7, 'Giuse Đỗ Văn Điệp', 10, 11, 2000, 'Nam Định', 'An Nghĩa', 'Bùi Chu', 'masters', 2025, 'Khoa Học Môi Trường', b'0', '', b'0', '', b'0', '', b'1', 'Xóm 10 Xã Hải An Huyện Hải Hậu Tỉnh Nam Định', 'Xóm 10 Xã Hải An Huyện Hải Hậu Tỉnh Nam Định', 'dovandiep345@gmail.com', '0364803610', 'Giáo phận bùi chu', '9/2020 - 8/2024', 'Cha Giuse Nguyễn Văn Phương', b'0', 'north', b'1', b'1', 'english', 'priest', 'Giuse Đỗ Văn Đang', 1967, 'Công nhân', 'Đỗ Thị Định', 1969, 'Công nhân', 'An Nghĩa', 'Bùi Chu', 'Giuse Lê Văn Thiên', '2025-03-30 20:49:31', '2025-06-23'),
(8, 'Đaminh Savio Phạm Nguyễn Duy Thiên', 18, 2, 1999, 'Sài Gòn', 'Don Bosco Xuân Hiệp', 'Sài Gòn', 'bachelor', 2021, 'Ngôn ngữ Anh', b'0', '', b'0', '', b'0', '', b'0', '21/81a, hẻm 21, đường số 11, khu phố 4, phường Linh Xuân, Tp. Thủ Đức', '21/81a, hẻm 21, đường số 11, khu phố 4, phường Linh Xuân, Tp. Thủ Đức', 'jamespham1802@gmail.com', '0937183722', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Phạm Nguyễn', 1966, 'Giáo viên', 'Đinh Thị Dung', 1969, 'Nội trợ', 'Don Bosco Xuân Hiệp', 'Sài Gòn', 'Giuse Nguyễn Trường Thạch', '2025-03-31 08:22:25', '2025-06-23'),
(9, 'Phaolô Maria Nguyễn Hoàng Hải Đăng', 17, 12, 1998, 'Sài Gòn', 'Thánh Đaminh - Ba Chuông', 'TGP. Sài Gòn', 'bachelor', NULL, 'Quản lý nhà nước', b'0', '', b'0', '', b'0', '', b'0', '15/19/5 đường Nguyễn Du, phường 1, quận Gò Vấp', '15/19/5 đường Nguyễn Du, phường 1, quận Gò Vấp', 'hitsugaya.deathsinger@gmail.com', '0835621423', 'Chưa có', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Nguyễn Hùng Sơn', 1962, 'Giám đốc Trung tâm dạy nghề (Đã về hưu)', 'Nguyễn Thị Đào', 1966, 'Thợ may tự do', 'Giáo xứ Thánh Giuse Gò Vấp', 'Tổng Giáo phận Sài Gòn', 'Cha Gioan Nguyễn Vĩnh Lộc', '2025-03-31 11:14:51', '2025-06-09'),
(11, 'Gioan Phạm Đình Khôi', 20, 1, 2001, 'Phan Thiết', 'Thanh Hải', 'Phan Thiết', 'bachelor', NULL, 'Ngôn ngữ anh', b'0', '', b'0', '', b'0', '', b'0', '541 Thủ Khoa Huân-Thanh Hải-Phan Thiết-Bình Thuận', '541 Thủ Khoa Huân-Thanh Hải', 'phkhoi2001@gmail.com', '0933010446', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'monk', 'Phê rô Phạm Quốc Toàn', 1968, 'mất 2018', 'Matta Nguyễn Thị Mai Hường', 1974, 'Kinh doanh', 'Thanh Hải', 'Phan Thiết', 'Gioan Maria Vianney Dương Nguyên Kha', '2025-04-04 10:07:01', '2025-06-23'),
(12, 'Gioan Baotixita Đỗ Minh Trí', 3, 7, 1997, 'Tân Hiệp - Kiên Giang', 'Đài Đức Mẹ', 'Long Xuyên', 'bachelor', 2019, 'Sư phạm', b'0', '', b'0', '', b'0', '', b'1', '1984 Khu phố Đông Tiến Thị trấn Tân Hiệp huyện Tân Hiệp tỉnh Kiên Giang.', '1984 Khu phố Đông Tiến Thị trấn Tân Hiệp huyện Tân Hiệp tỉnh Kiên Giang.', 'dominhtridhsp@gmail.com', '0376734153', 'Dự tu Giáo phận Long Xuyên tại Thành phố Hồ Chí Minh.', '2 tháng', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'GB Đỗ Đình Tiến', 1964, 'Giám thị', 'Maria Ngô Thị Diễm', 1964, 'Nội trợ', 'Đài Đức Mẹ', 'Long Xuyên', 'Giuse Phạm Xuân Hoàng', '2025-04-04 19:48:57', '2025-06-09'),
(13, 'Gioakim Nguyễn Tấn Tới', 23, 8, 2003, '(?)', 'Đông Yên', 'Hà Tĩnh', 'associate', 2025, 'Tiếng Anh', b'0', '', b'0', '', b'0', '', b'1', 'Ba Đồng, Phường Kỳ Phương, Thị xã Kỳ Anh, Hà Tĩnh', 'Ba Đồng, Phường Kỳ Phương, Thị xã Kỳ Anh, Hà Tĩnh', 'nguyentantoikp20@gmail.com', '0344604994', '', 'Tham gia lớp dự tu giáo phận 2 năm', '', b'1', 'central', b'1', b'1', 'english', 'priest', 'Phero Nguyễn Cung Đàn', 1976, 'Ngư dân', 'Matta Mai Thị Thống', 1980, 'Nội trợ', 'Đông Yên', 'Hà Tình', 'Phaolo Nguyễn Đình Phú', '2025-04-05 19:35:51', '2025-06-23'),
(15, 'Giuse Nguyễn Tuấn Hưng', 22, 9, 2005, 'Lâm Đồng', 'Lạc Lâm', 'Đà Lạt', 'associate', 2026, 'Kỹ Thuật Phần Mềm', b'0', '', b'0', '', b'0', '', b'0', '111 - Hải Hưng - Lạc Lâm - Đơn Dương - Lâm Đồng', '237/33/143 Phạm Văn Chiêu, P14, Gò Vấp, TP Hồ Chí Minh', 'tuanhung2295@gmail.com', '0915207501', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Giuse Nguyễn Thy Phước', 1974, 'Buôn Bán Nhỏ', 'Têrêsa Hà Thị Huệ', 1979, 'Buôn Bán Nhỏ', 'Lạc Lâm', 'Đà Lạt', 'Vinc. Nguyễn Duy Nam, OP', '2025-04-20 20:44:04', '2025-06-23'),
(17, 'Giuse Nguyễn Phúc Thưởng', 6, 11, 2000, 'Đồng Nai', 'Hà Nội', 'Xuân Lộc', 'associate', 0, 'Thiết Kế Đồ Họa', b'0', '', b'0', '', b'0', '', b'0', '201/6, kp6, Biên Hòa, Đồng Nai.', '201/6, kp6, Biên Hòa, Đồng Nai.', 'nguyenphucthuong1@gmail.com', '0945080264', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Giuse Nguyễn Thanh Phước', 1976, 'Buôn bán', 'Maria Phạm Thị Ngọc Dung', 1981, 'Buôn bán', 'Hà Nội', 'Xuân Lộc', '  Phaolô Nguyễn Đức Thành', '2025-04-21 22:20:58', '2025-06-23'),
(18, 'Bùi Kỳ Anh', 31, 8, 2004, 'Đồng Nai', 'Long Thuận', 'Xuân Lộc', 'bachelor', 2022, 'Xây dựng cầu đường', b'0', '', b'0', '', b'0', '', b'0', '989, Xuân Hưng, Xuân Lộc, Đồng Nai', '26/14, Nguyễn Viết Xuân, Dĩ An, Bình Dương', 'buikianh@gmail.com', '0703662994', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Lôrensô Bùi Thanh Hải', 1979, 'Buôn bán', 'Maria Trần Thị Bé Tư', 1984, 'Buôn bán', 'Long Thuận', 'Xuân Lộc', ' Đaminh Vũ Kim Khanh – SDD', '2025-04-22 08:49:55', '2025-06-09'),
(21, 'Giuse Dương Quang Tuyên', 29, 3, 2003, 'Phú Thọ', 'Lã Hoàng', 'Hưng Hoá', 'associate', 2025, 'Điều Dưỡng', b'0', '', b'0', '', b'0', '', b'0', 'Thôn Lã Hoàng 2, Xã Chí Đám, Huyện Đoan Hùng, Tỉnh Phú Thọ', 'Thôn Lã Hoàng 2, Xã Chí Đám, Huyện Đoan Hùng, Tỉnh Phú Thọ', 'josephduongtuyen@gmail.com', '0961183520', 'Đã tìm hiểu ơn gọi trong Giáo Phận Hưng Hoá', '4 năm', '', b'1', 'north', b'1', b'1', 'english', 'priest', 'Giuse Dương Văn Đức', 1964, 'Tự do', 'Maria Nguyễn Thị Liên', 1964, 'Tự do', 'Lã Hoàng', 'Hưng Hoá', 'Phanxico Xavie Nguyễn Văn Thái', '2025-04-28 21:49:20', '2025-06-23'),
(24, 'Phaolo Hoàng Hải', 2, 6, 2002, 'Đồng Nai', 'Gia Yên', 'Xuân Lộc', 'bachelor', 2025, 'Công nghệ thông tin', b'0', '', b'0', '', b'1', '595', b'0', '285/2 Gia Yên, Gia Tân 3, Thống Nhất, Đồng Nai', '766/106 Cách mạng tháng tám, Phường 5, Tân Bình, Tp. Hồ Chí Minh', 'hnghai0206@gmail.com', '0865333718', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Phero Hoàng Việt', 1965, 'Chăn nuôi', 'Maria Vũ Thị Kim Loan', 1967, 'Nội trợ', 'Gia Yên', 'Xuân Lộc', 'Cha Chiến', '2025-05-06 14:25:57', '2025-06-09'),
(25, 'GIUSE  NGUYỄN THÀNH TÍN', 24, 4, 2002, 'An Xuân, Xuân Hải, Ninh Hảii, Ninh Thuận.', 'Thái Hoà', 'Nha Trang', 'highschool', 2020, '', b'0', '', b'0', '', b'0', '', b'0', 'An Xuân, Xuân Hải, Ninh Hải, Ninh Thuận', 'An Xuân, Xuân Hải, Ninh Hải, Ninh Thuận', 'thanhtin240402@gmail.com', '0783512367', 'Dòng Anh Em Hèn Mọn', '4 tháng.', '', b'1', 'da_minh', b'1', b'1', 'english', 'monk', 'MAC CÔ NGUYỄN THÀNH ĐỨC', 1976, 'Nông', 'MARIA VÕ THÁI THỊ XUÂN HƯƠNG', 1980, 'Nông', 'Thái Hoà', 'Nha Trang', 'PHANXICÔ XAVIÊ NGUYỄN TÙNG LÂM', '2025-05-06 22:48:39', '2025-06-09'),
(26, 'Anton Hoàng Bảo Nhân', 1, 3, 2003, 'Hà Tĩnh', 'Dũ Yên', 'Hà Tĩnh', 'bachelor', 2025, 'Sư Phạm Ngữ Văn', b'0', '', b'0', '', b'0', '', b'0', 'Kỳ Thịnh - Kỳ Anh - Hà Tĩnh', 'Tp Huế', 'hoangbaonhan.132003@gmail.com', '0876500131', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Phêro Hoàng Văn Dũng', 1975, 'Thợ nè', 'Matta Hoàng Thị Phận', 1974, 'Phụ trợ', 'Dũ Yên', 'Hà Tĩnh', 'Phero Nguyễn Văn Nghĩa', '2025-05-07 09:36:12', '2025-06-23'),
(27, 'GIUSE MARIA HOÀNG ĐÌNH HUY', 13, 3, 2002, 'TPHCM', 'Lộ Đức', 'Xuân Lộc', 'bachelor', 2024, 'Ngôn ngữ Pháp', b'0', '', b'0', '', b'0', '', b'0', '128/4 (số cũ 83C/2) khu phố 5, Phường Tân Hoà, Thành phố Biên Hoà, Tỉnh Đồng Nai', '128/4 (số cũ 83C/2) khu phố 5, Phường Tân Hoà, Thành phố Biên Hoà, Tỉnh Đồng Nai', 'paxhoangdinhhuy@gmail.com', '0921846042', 'Đại Chủng viện Thánh Giuse Xuân Lộc', 'Con đã dự thi vào Đại Chủng viện Xuân Lộc năm 2017, nhưng không trúng tuyển.', 'Con tự tìm hiểu từ thuở nhỏ, song khi lớn, được Sr. Phượng (Phụng) thuộc Dòng Nữ Trợ Thế Thánh Tâm Chúa Giêsu trong Giáo xứ thúc đẩy.', b'0', 'da_minh', b'1', b'1', 'english', 'priest', 'Giuse Hoàng Đình Niệm', 1974, 'Giáo viên', 'Maria Nguyễn Vũ Thuỳ Trang', 1979, 'Buôn bán', 'Lộ Đức', 'Xuân Lộc', 'Phaolô Nguyễn Trọng Xuân', '2025-05-08 23:44:28', '2025-06-09'),
(28, 'Tôma Aquinô Trần Văn hậu', 13, 2, 2004, 'Đồng Nai', 'Quảng Xuân', 'Xuân Lộc', 'bachelor', 2026, 'Giảng dạy Tiếng Anh', b'0', '', b'0', '', b'0', '', b'0', 'Ấp 3a, Xã Xuân Hưng, Huyện Xuân Lộc, Tỉnh Đồng Nai', '778 Lạc Long Quân, Phường 9, Quận Tân Bình, Thành phố Hồ Chí Minh', 'tom.aq.tvh@gmail.com', '0969120426', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Phêrô Trần Văn An', 1967, 'Buôn bán', 'Maria Bùi Thị Thu Thủy', 1968, 'Công nhân', 'Quảng Xuân', 'Xuân Lộc', 'Tôma Aquinô Trần Bá Huy', '2025-05-09 17:37:51', '2025-06-23'),
(29, 'Giuse Lê Quốc Việt', 25, 1, 2023, 'Ninh Bình', 'La Vân', 'Phát Diệm', 'bachelor', 0, 'Kế Toán Doanh Nghiệp', b'0', '', b'0', '', b'0', '', b'0', 'Phố La Vân- Phường Ninh Giang- TP Hoa Lư- Tỉnh Ninh Bình', 'Phố La Vân- Phường Ninh Giang- TP Hoa Lư- Tỉnh Ninh Bình', 'josephviet2501@gmail.com', '0862370395', '', '', '', b'1', 'north', b'1', b'1', 'english', 'priest', 'Gioan Lê Văn Sơn', 1972, 'Tự do', 'Maria Lê Thị Đào', 1972, 'Tự do', 'La Vân', 'Phát Diệm', 'Luca Phạm Văn Huy', '2025-05-09 22:46:14', '2025-06-23'),
(32, 'GIUSE LÊ ĐỨC HẢI', 24, 1, 1999, 'Đồng Nai', 'Bùi Chu', 'Xuân Lộc', 'associate', 2022, 'Quản trị kinh doanh', b'0', '', b'0', '', b'0', '', b'0', '285/1 Đông Bình, Bùi Chu, xã Bắc Sơn, huyện Trảng Bom, tỉnh Đồng Nai', '285/1 Đông Bình, Bùi Chu, xã Bắc Sơn, huyện Trảng Bom, tỉnh Đồng Nai', 'duchaile99@gmail.com', '0346903865', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Giuse Lê Đức Cầu', 1969, 'công nhân', 'Maria Nguyễn Thị Loan', 1979, 'công nhân', 'Bùi Chu', 'Xuân Lộc', 'Giuse Đoàn Công Bình', '2025-05-10 23:48:34', '2025-06-09'),
(33, 'Antôn Lê Minh Tú', 21, 12, 2000, 'Bến Tre', 'Cái Mơn', 'Vĩnh Long ', 'bachelor', 2023, 'Mạng máy tính và truyền thông dữ liệu ', b'0', '', b'0', '', b'0', '', b'0', '122/92 Vĩnh Nam, Vĩnh Thành, Chợ Lách, Bến Tre ', '28/4 Hẻm 28 Phạm Văn Chiêu, Phường 8, Quận Gò Vấp, Tp. Hồ Chí Minh', 'antonlmtu@gmail.com', '0909378325', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Gioan Baotixita Lê Văn Tuấn', 1973, 'Qua đời', 'Isave Nguyễn Kim Chi ', 1981, 'Làm vườn ', 'Cái Mơn', 'Vĩnh Long ', 'Gioan Baotixita Lê Đình Bạch', '2025-05-13 20:14:53', '2025-06-23'),
(34, 'Phêrô Nguyễn Hữu Dương', 30, 3, 1999, 'Đắk Lắk', 'Tân Hòa', 'Ban Mê Thuột', 'bachelor', 2025, 'Ngôn ngữ Anh', b'0', '', b'0', '', b'0', '', b'0', 'Thôn 5, xã Ea Tiêu, huyện Cư Kuin, tỉnh Đắk Lắk', 'Thôn 5, xã Ea Tiêu, huyện Cư Kuin, tỉnh Đắk Lắk', 'nguyenhuuduong042@gmail.com', '0944388376', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Phêrô Nguyễn Hữu Mịnh', 1973, 'Làm nông', 'Maria Nguyễn Thị Loan', 1975, 'Làm Nông', 'Tân Hòa', 'Ban Mê Thuột', 'Phêrô Hoàng Khắc Dũng', '2025-05-21 19:19:13', '2025-06-23'),
(35, 'Phêrô NGUYỄN QUÝ ĐÌNH', 26, 6, 2000, 'Quảng Bình', 'Cồn Sẻ', 'Hà Tĩnh', 'bachelor', 2025, 'Luật Học', b'0', '', b'0', '', b'0', '', b'1', 'Thôn Tiên Xuân, xã Quảng Tiên, Tx Ba Đồn, tỉnh Quảng Bình', 'Thôn Cồn Sẻ, xã Quảng Lộc, Tx Ba Đồn, tỉnh Quảng Bình', 'peternguyen260620@gmail.com', '0977481744', '', '', 'Linh mục Phê rô Phạm Văn Hoành, OP.', b'0', 'da_minh', b'1', b'1', 'english', 'priest', 'Nguyễn Văn Điểu', 1968, 'Thợ Mộc', 'Mai Thị Bưởi', 1978, 'Nội trợ', 'Cồn Sẻ', 'Hà Tĩnh', 'Phê rô Phùng Văn Tuấn', '2025-05-22 19:47:14', '2025-06-09'),
(36, 'Đaminh TRẦN QUANG VINH', 5, 2, 1999, 'TP. HCM', 'Bến Hải', 'Sài Gòn', 'bachelor', 2022, 'Quan hệ công chúng', b'0', '', b'0', '', b'0', '', b'0', '80/63 Dương Quảng Hàm, Phường 05, Quận Gò Vấp, TP. HCM', '80/63 Dương Quảng Hàm, Phường 05, Quận Gò Vấp, TP. HCM', 'tranquangvinh1690@gmail.com', '0936091690', 'tìm hiểu ngoại trú: Dòng Đaminh, Dòng Cát Minh', 'Dòng Đaminh (2017-2020), Dòng Cát Minh (09/2023 - 05/2024)', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Đaminh TRẦN QUANG TIẾN', 1971, 'Buôn bán thịt gà tươi sống', 'Têrêsa NGUYỄN THÚY KIỀU', 1972, 'Uốc tóc, trang điểm, spa tại nhà', 'Bến Hải', 'Sài Gòn', 'Giuse Dương Vũ', '2025-06-13 13:46:02', '2025-06-23'),
(37, 'Giuse Châu Thiện An', 11, 4, 2002, 'TP.HCM', 'Quảng Biên', 'Xuân Lộc', 'bachelor', 2025, 'Quản trị Dịch vụ Du lịch và Lữ Hành.', b'0', '', b'0', '', b'0', '', b'0', '03,đường Quảng Tiến 20,Quảng Biên,Quảng Tiến,Trảng Bom, Đồng Nai.', '03, đường Quảng Tiến 20, Quảng Biên,Quảng Tiến, Trảng Bom, Đồng Nai.', 'chauthienan1142002@gmail.com', '0937394317', '', 'ĐCV Xuân Lộc (2017-2023)', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Giuse Châu ĐìnGiuGiuse Châu Đình Lân Giuse GiGiúe Cháh', 1968, 'NNhân viên ', 'Onê Nguyen Thị Kiều Inê N', 1969, 'Thợ may áo dài ', 'Quảng Biên', 'Xuân Lộc', 'Giuse Hoàng Mạnh Hiểu.', '2025-06-14 09:36:05', '2025-06-23'),
(38, 'LÊ TRẦN THANH LAM', 11, 11, 2000, 'Đồng Nai', 'Kẻ Sặt', 'Xuân Lộc', 'highschool', 2018, '', b'0', '', b'0', '', b'0', '', b'0', '92/33 Hẻm 92 Nguyễn Ái Quốc, KP.7, P.Tân Biên, TP.Biên Hòa, T.Đồng Nai', '92/33 Hẻm 92 Nguyễn Ái Quốc, KP.7, P.Tân Biên, TP.Biên Hòa, T.Đồng Nai', 'thanhlam111100@gmail.com', '0353515941', '', '', '', b'1', 'da_minh', b'1', b'1', 'english', 'monk', 'GIUSE - LÊ TUẤN DŨNG', 1964, 'Xây dựng', 'TÊRÊSA - TRẦN THỊ BÍCH PHƯƠNG', 1978, 'Thợ May', 'Kẻ Sặt', 'Xuân Lộc', 'ĐA MINH - NGUYỄN THÀNH TIẾN', '2025-06-15 21:55:19', '2025-06-23'),
(39, 'Giuse Lê Huy Tín ', 10, 9, 2000, 'Đồng Nai ', 'Thánh Tâm ', 'Xuân Lộc', 'bachelor', 0, 'Quản trị dịch vụ du lịch và lữ hành ', b'0', '', b'0', '', b'0', '', b'0', '155A/4 Khu phố 10, phường Tân Biên, Biên Hòa, Đồng Nai ', '155A/4 Khu phố 10, phường Tân Biên, Biên Hòa, Đồng Nai ', 'lehuytin1009@gmail.com', '0901204619', 'Dòng Chúa Cứu Thế ', '9 tháng', '', b'1', 'da_minh', b'1', b'1', 'english', 'priest', 'Giuse Lê Huy Thân', 1968, 'Thợ mộc ', 'Maria Quách Thị Kiên', 1971, 'Thợ may', 'Thánh Tâm ', 'Xuân Lộc ', 'Giuse Hà Đăng Định ', '2025-06-21 20:24:13', '2025-06-23'),
(40, 'GIUSE MARIA NGUYỄN CHU KIM THU', 5, 8, 1999, 'Cần Thơ', 'Gò Mây', 'Sài Gòn', 'associate', 2022, 'Quản trị Dịch vụ Du Lịch và Lữ Hành', b'1', '5.5', b'0', '', b'0', '', b'0', 'A5/24C, NHÂN DÂN ẤP 12, HCM', 'A5/24C, NHÂN DÂN ẤP12, HCM', 'kimthucamera@gmail.com', '0938475240', '', '4 năm dự tu, 2 năm Tiểu Chủng viện, 1 năm Đại Chủng Viện Sao Biển.', 'Linh mục Đaminh Nguyễn Hữu Hùng, Lm. Đaminh Trần Bình Tiên', b'0', 'da_minh', b'1', b'1', 'english', 'priest', 'Step. Nguyễn Ngọc Đằng', 1962, 'Nội trợ', 'Anna. Chu Thị Thanh Hương', 1964, 'Nội trợ', 'Gò Mây', 'Sài Gòn', 'Matthew. Phạm Trần Thanh', '2025-07-03 23:32:56', '2025-06-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
