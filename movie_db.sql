-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jul 13, 2023 at 04:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `episode_number` int(11) DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `episodes`
--

INSERT INTO `episodes` (`id`, `movie_id`, `episode_number`, `video_link`) VALUES
(4, 29, 1, 'https://drive.google.com/file/d/1BSKRb1W6gXBZ5r13tQqUouEca8UH1NoI/preview'),
(5, 29, 2, 'https://drive.google.com/file/d/1yljnrw2O_pfKIScX90F51TYMcqJ-lQZA/preview'),
(7, 37, 1, 'https://drive.google.com/file/d/1yqFQ7twm1AUpGl3O5JELZMLbuI73pNqq/preview'),
(8, 37, 2, 'https://drive.google.com/file/d/1BSKRb1W6gXBZ5r13tQqUouEca8UH1NoI/preview');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `release_year` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `episodes` int(11) DEFAULT NULL,
  `actors` text DEFAULT NULL,
  `director` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `othertitle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `image`, `release_year`, `country`, `genre`, `status`, `episodes`, `actors`, `director`, `summary`, `othertitle`) VALUES
(29, 'BIỆT ĐỘI TITANS (PHẦN 4)', 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=https%3A%2F%2Fphimvietsub.cc%2Fstorage%2Fimages%2Fbiet-doi-titans-phan-4%2Fbiet-doi-titans-phan-4-thumb.jpg', 2020, 'Mĩ', 'Hành Động, Viễn Tưởng, Phiêu Lưu, Khoa Học, Phim Bộ', 'Full', 12, ' Brenton Thwaites, Anna Diop, Teagan Croft, Ryan Potter, Curran Walters, Conor Leslie, Minka Kelly, Alan Ritchson, Esai Morales, Chelsea Zhang, Joshua Orpin', 'N/A', 'Con đường hồi hương của các Titan trải đầy chướng ngại khi họ phải đối mặt với giáo phái hùng mạnh và chết chóc ở Metropolis đang cố hủy diệt họ và thế giới.', 'Titans (Season 4)'),
(30, 'CHIẾN BINH BÁO ĐEN: WAKANDA BẤT DIỆT', 'https://i.ebayimg.com/images/g/ceAAAOSwMpBjPJTN/s-l1600.jpg', 2021, 'Mĩ', 'Hành Động, Tâm Lý, Viễn Tưởng, Thần Thoại, Phim Bộ', 'Full', 1, ' Letitia Wright, Lupita Nyongo, Danai Gurira, Winston Duke, Dominique Thorne, Florence Kasumba, Michaela Coel, Tenoch Huerta, Martin Freeman, Angela Bassett', 'Ryan Coogler', 'TChalla, vua của Wakanda, đang mắc một căn bệnh mà em gái của anh Shuri tin rằng có thể chữa khỏi bằng \"tâm hình thảo\". Shuri đã cố gắng tái tạo tổng hợp loại thảo mộc này sau khi nó bị Killmonger phá hủy,[N 1] nhưng không thành công trước khi anh qua đời.\r\n\r\n', 'Black Panther: Wakanda Forever'),
(31, 'LAPUTA: LÂU ĐÀI TRÊN KHÔNG', 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=https%3A%2F%2Fphimvietsub.cc%2Fstorage%2Fimages%2Flaputa-lau-dai-tren-khong%2Flaputa-lau-dai-tren-khong-thumb.jpg', 2015, 'Nhật Bản', 'Gia Đình, Kinh Điển, Hoạt Hình, Phim bộ', 'Full', 1, 'Tanaka Mayumi, Yokozawa Keiko, Hatsui Kotoe', 'N/A', 'Bộ phim hoạt hình phiêu lưu cho trẻ em kể về cậu bé thợ mỏ và cô bé bí ẩn. Hai em khao khát tìm kiếm hòn đảo mất tích đã lâu mà mọi người đồn rằng có rất nhiều của cải.', 'Castle in the Sky'),
(32, 'ĐẤU PHÁ THƯƠNG KHUNG NGOẠI TRUYỆN', 'https://vidian.me/images/dau-pha-thuong-khung.jpg', 2018, 'Trung Quốc', 'Hành Động, Cổ Trang, Võ Thuật, Phiêu Lưu, Hoạt Hình, Phim bộ', 'Full', 50, 'N/A', 'N/A', 'Sau hợp đồng ba năm, Xiao Yan cuối cùng đã gặp Xuaner tại Học viện Jianan, sau đó anh kết bạn thân và thành lập Pan Sect; Để tiếp tục nâng cao sức mạnh của mình và trả thù Vân Lan phái cho cha mình, anh ta đã đi sâu vào Tháp khí đốt thiên đường để nuốt chửng Fallen Heart Yan bằng sự mạo hiểm của chính mình', 'Fights Break Sphere S5'),
(33, 'XÍCH BÍCH: BẢN ĐIỆN ẢNH', 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=https%3A%2F%2Fphimvietsub.cc%2Fstorage%2Fimages%2Fxich-bich-ban-dien-anh%2Fxich-bich-ban-dien-anh-thumb.jpg', 2020, 'Trung Quốc', 'Hành Động, Phiêu Lưu, Chính kịch, Cổ Trang, Phim bộ', 'Full', 1, 'Lương Triều Vỹ, Kaneshiro Takeshi, Trương Phong Nghị, Trương Chấn, Triệu Vy, Hồ Quân, Nakamura Shido, Lâm Chí Linh, Vưu Dũng, Hầu Vịnh', 'John Woo', 'Năm 208 sau Công nguyên ở Trung Quốc, trận chiến quan trọng, đẫm máu nổ ra giữa lãnh chúa Tào Tháo và tướng quân Chu Du, người liên minh với chiến lược gia ranh mãnh Gia Cát Lượng.', NULL),
(34, 'HÀNH TINH KHỈ', 'https://m.media-amazon.com/images/I/71FecJZU8mL._AC_UF1000,1000_QL80_.jpg', 2020, 'Mĩ', ' Hành Động, Viễn Tưởng, Phiêu Lưu, Chính kịch, Phim lẻ', 'Full', 1, ' Charlton Heston, Roddy McDowall, Kim Hunter, Maurice Evans, James Whitmore', 'Franklin J. Schaffner', 'Bối cảnh của phim Hành Tinh Khỉ 1 được lấy vào tương lai rất xa, bốn phi hành gia tỉnh dậy sau giấc ngủ đông (bằng kỹ thuật điện tử) trong chuyến hành trình với vận tốc gần bằng vận tốc ánh sáng của mình và phát hiện họ đã đặt chân đến một hành tinh lạ và đã là năm 3978. Tại hành tinh này họ phát hiện ra các loài linh trưởng, có trí tuệ cao, biết nói là những kẻ thống trị, còn loài người, không có khả năng giao tiếp bằng tiếng nói, lại bị coi là \"động vật\" có thể bị săn bắn, bắt làm nô lệ, hay thậm chí là để nghiên cứu...', 'Planet of the Apes'),
(35, 'ĐÁM CƯỚI KIỂU MỸ', 'https://m.media-amazon.com/images/M/MV5BMTAwNTIzNDk1MDVeQTJeQWpwZ15BbWU3MDMwNzAwMDE@._V1_FMjpg_UX1000_.jpg', NULL, 'Mĩ', 'Tình Cảm, Hài Hước, Phim lẻ', 'Full', NULL, 'Jason Biggs, Alyson Hannigan, Seann William Scott, Eddie Kaye Thomas, Thomas Ian Nicholas', 'Jesse Dylan', 'American Wedding kể về đám cưới của Jim và Michelle, kết quả đáng mong ước từ mối tình trong 2 phần trước đó của họ. Kể từ lời cầu hôn không giống ai, hàng tá chuyện rắc rối không ngừng xảy đến với cặp đôi như bữa tiệc độc thân bất thành, sự xuất hiện của những ông bạn gay hay tệ hơn là toàn bộ hoa cưới bỗng héo rũ ngay trước lễ cưới… Với sự trợ giúp của những ông bạn “phá hoại”, ngày vui của Jim và Michelle sẽ diễn ra như thế nào? Mặc dù xoay quanh cặp đôi Jim và Michelle nhưng phần 3 của loạt phim American Pie này là lần đầu tiên câu chuyện tập trung vào nhân vật Steve Stifler và những trò hề tinh quái của anh. Với kịch bản hài hước, diễn xuất tự nhiên cùng những cảnh quay đẹp mắt, bộ phim đã ẵm hai giải thưởng tại MTV Movie Awards và Teen Choice Awards vào năm 2004.', 'American Wedding'),
(36, '', '', NULL, '', '', '', 1, '', '', '', ''),
(37, 'ROBOT ĐẠI CHIẾN: QUÁI THÚ TRỖI DẬY', 'https://m.media-amazon.com/images/M/MV5BZTNiNDA4NmMtNTExNi00YmViLWJkMDAtMDAxNmRjY2I2NDVjXkEyXkFqcGdeQXVyMDM2NDM2MQ@@._V1_.jpg', 2023, 'Mĩ', 'Hành Động, Viễn Tưởng, Phiêu Lưu, Khoa Học, Phim lẻ', 'Full', 1, 'Anthony Ramos, Dominique Fishback, Luna Lauren Velez, Dean Scott Vazquez, Tobe Nwigwe, Peter Cullen, Ron Perlman, Peter Dinklage, Pete Davidson, Michelle Yeoh', 'Steven Caple Jr.', 'Một cuộc phiêu lưu vòng quanh thế giới thập niên 90 giới thiệu Maximals, Predacons và Terrorcons trong trận chiến hiện có trên trái đất giữa Autobots và Decepticons.', 'Transformers: Rise of the Beasts');

-- --------------------------------------------------------

--
-- Table structure for table `trailers`
--

CREATE TABLE `trailers` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trailers`
--

INSERT INTO `trailers` (`id`, `movie_id`, `title`, `video_link`) VALUES
(29, 29, 'Biệt đội titans', 'https://drive.google.com/file/d/1BSKRb1W6gXBZ5r13tQqUouEca8UH1NoI/preview'),
(30, 37, 'RISE OF THE BEAST', 'https://drive.google.com/file/d/1yljnrw2O_pfKIScX90F51TYMcqJ-lQZA/preview');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trailers`
--
ALTER TABLE `trailers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `trailers`
--
ALTER TABLE `trailers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Constraints for table `trailers`
--
ALTER TABLE `trailers`
  ADD CONSTRAINT `trailers_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
