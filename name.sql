-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.11
-- Generation Time: Oct 04, 2024 at 04:19 PM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u299560388_651230`
--

-- --------------------------------------------------------

--
-- Table structure for table `pj_city`
--

CREATE TABLE `pj_city` (
  `CityID` int(11) NOT NULL,
  `CityName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pj_prefix`
--

CREATE TABLE `pj_prefix` (
  `PrefixID` int(11) NOT NULL,
  `PrefixTH` varchar(100) DEFAULT NULL,
  `PrefixEN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pj_prefix`
--

INSERT INTO `pj_prefix` (`PrefixID`, `PrefixTH`, `PrefixEN`) VALUES
(1, 'นาย', 'Mr.'),
(2, 'นางสาว', 'Miss'),
(3, 'นาง', 'Mrs.');

-- --------------------------------------------------------

--
-- Table structure for table `pj_province`
--

CREATE TABLE `pj_province` (
  `ProvinceID` int(11) NOT NULL,
  `ProvinceName` varchar(100) DEFAULT NULL,
  `CityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pj_user`
--

CREATE TABLE `pj_user` (
  `UserID` int(11) NOT NULL,
  `PrefixID` int(11) DEFAULT NULL,
  `NameUser` varchar(100) DEFAULT NULL,
  `LNameUser` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pj_user`
--

INSERT INTO `pj_user` (`UserID`, `PrefixID`, `NameUser`, `LNameUser`, `Email`, `UserName`, `Password`) VALUES
(1, 1, 'Thanapoj', 'Kucharo', 'thanapoj-k@rmutp.ac.th', 'user1', 'user1234');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `CityID` int(11) NOT NULL,
  `CityName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`CityID`, `CityName`) VALUES
(1, 'กรุงเทพมหานคร'),
(2, 'สมุทรปราการ'),
(3, 'นนทบุรี'),
(4, 'ปทุมธานี'),
(5, 'พระนครศรีอยุธยา'),
(6, 'อ่างทอง'),
(7, 'ลพบุรี'),
(8, 'สิงห์บุรี'),
(9, 'ชัยนาท'),
(10, 'สระบุรี'),
(11, 'ชลบุรี'),
(12, 'ระยอง'),
(13, 'จันทบุรี'),
(14, 'ตราด'),
(15, 'ฉะเชิงเทรา'),
(16, 'ปราจีนบุรี'),
(17, 'นครนายก'),
(18, 'สระแก้ว'),
(19, 'นครราชสีมา'),
(20, 'บุรีรัมย์'),
(21, 'สุรินทร์'),
(22, 'ศรีสะเกษ'),
(23, 'อุบลราชธานี'),
(24, 'ยโสธร'),
(25, 'ชัยภูมิ'),
(26, 'อำนาจเจริญ'),
(27, 'หนองบัวลำภู'),
(28, 'ขอนแก่น'),
(29, 'อุดรธานี'),
(30, 'เลย'),
(31, 'หนองคาย'),
(32, 'มหาสารคาม'),
(33, 'ร้อยเอ็ด'),
(34, 'กาฬสินธุ์'),
(35, 'สกลนคร'),
(36, 'นครพนม'),
(37, 'มุกดาหาร'),
(38, 'เชียงใหม่'),
(39, 'ลำพูน'),
(40, 'ลำปาง'),
(41, 'อุตรดิตถ์'),
(42, 'แพร่'),
(43, 'น่าน'),
(44, 'พะเยา'),
(45, 'เชียงราย'),
(46, 'แม่ฮ่องสอน'),
(47, 'นครสวรรค์'),
(48, 'อุทัยธานี'),
(49, 'กำแพงเพชร'),
(50, 'ตาก'),
(51, 'สุโขทัย'),
(52, 'พิษณุโลก'),
(53, 'พิจิตร'),
(54, 'เพชรบูรณ์'),
(55, 'ราชบุรี'),
(56, 'กาญจนบุรี'),
(57, 'สุพรรณบุรี'),
(58, 'นครปฐม'),
(59, 'สมุทรสาคร'),
(60, 'สมุทรสงคราม'),
(61, 'เพชรบุรี'),
(62, 'ประจวบคีรีขันธ์'),
(63, 'นครศรีธรรมราช'),
(64, 'กระบี่'),
(65, 'พังงา'),
(66, 'ภูเก็ต'),
(67, 'สุราษฎร์ธานี'),
(68, 'ระนอง'),
(69, 'ชุมพร'),
(70, 'สงขลา'),
(71, 'สตูล'),
(72, 'ตรัง'),
(73, 'พัทลุง'),
(74, 'ปัตตานี'),
(75, 'ยะลา'),
(76, 'นราธิวาส'),
(77, 'บึงกาฬ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `DepID` int(11) NOT NULL,
  `Department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`DepID`, `Department`) VALUES
(1, 'วิทยาการคอม'),
(2, 'วิทยาการข้อมูล'),
(3, 'วิทย์สิ่งแวดล้อม'),
(4, 'วัสดุศาสตร์'),
(5, 'เครื่องสำอางค์และการชะลอวัย'),
(6, 'สถิติ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hobby`
--

CREATE TABLE `tbl_hobby` (
  `HobbyID` int(11) NOT NULL,
  `HobbyName` varchar(100) NOT NULL,
  `HobbyNameEng` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_hobby`
--

INSERT INTO `tbl_hobby` (`HobbyID`, `HobbyName`, `HobbyNameEng`) VALUES
(1, 'อ่านหนังสือ', 'Reading'),
(2, 'เขียนนิยาย', 'Write a novel'),
(3, 'เดินป่า', 'Hiking'),
(4, 'เล่นกล', 'tricks'),
(5, 'ว่ายน้ำ', 'Swimming'),
(6, 'ทำอาหาร', 'Cooking'),
(7, 'ฟังเพลง', 'Listening to music'),
(8, 'เล่นกีฬา', 'Playing sports'),
(9, 'เล่นเกม', 'Playing games'),
(10, 'ออกกำลังกาย', 'Exercise'),
(11, 'ชมภาพยนตร์', 'Watching movies'),
(12, 'ปั่นจักรยาน', 'Cycling'),
(13, 'เล่นดนตรี', 'Playing music'),
(14, 'ระบายสี', 'Painting'),
(15, 'ร้องเพลง', 'Singing'),
(16, 'ท่องเที่ยว', 'Traveling'),
(17, 'ตกปลา', 'fishing'),
(18, 'เลี้ยงสัตว์', 'Raise animals'),
(19, 'ถ่ายรูป', 'Photography'),
(20, 'เต้น', 'Dance');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_predixes`
--

CREATE TABLE `tbl_predixes` (
  `PrefixID` int(11) NOT NULL,
  `PrefixTH` varchar(10) NOT NULL,
  `PrefixEN` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_predixes`
--

INSERT INTO `tbl_predixes` (`PrefixID`, `PrefixTH`, `PrefixEN`) VALUES
(1, 'นาย', 'Mr.'),
(2, 'นางสาว', 'Miss'),
(3, 'นาง', 'Mrs.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `SID` int(11) NOT NULL,
  `PrefixID` int(1) NOT NULL,
  `StudentName` varchar(20) NOT NULL,
  `StudentLastName` varchar(30) NOT NULL,
  `StudentNameEn` varchar(20) NOT NULL,
  `StudentLastNameEN` varchar(30) NOT NULL,
  `Age` int(2) NOT NULL,
  `DepID` int(11) NOT NULL,
  `Domicille` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Telephone` varchar(15) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `CityID` int(11) NOT NULL,
  `yearID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`SID`, `PrefixID`, `StudentName`, `StudentLastName`, `StudentNameEn`, `StudentLastNameEN`, `Age`, `DepID`, `Domicille`, `Address`, `Telephone`, `SubjectID`, `CityID`, `yearID`) VALUES
(1, 2, 'พิมมาดา', 'อังสุธาร', ' Pimmada', 'Angsuthar', 19, 1, 'แขวง กรุงเทพ เขต กรุงเทพ', 'แขวง กรุงเทพ เขต กรุงเทพ', '0123456789', 3, 1, 5),
(2, 2, 'ชนิกา', 'จันทรา', ' Chanika', 'Chanthra', 20, 2, 'อำเภอเมือง จังหวัดนนทบุรี', 'อำเภอเมือง จังหวัดนนทบุรี', '0251647952', 6, 3, 4),
(3, 2, 'ณิชาภา', 'วิเศษกุล', ' Nichapa', 'Wisetkul', 18, 5, 'แขวง กรุงเทพ เขต กรุงเทพ', 'แขวง กรุงเทพ เขต กรุงเทพ', '0654821035', 9, 1, 6),
(4, 2, 'ธนัชชา', 'รัตนพันธ์', 'Thanatcha', 'Rattanaphan', 20, 2, 'อำเภอ เมือง ตำบล เมือง จังหวัดเชียงใหม่', 'อำเภอ เมือง ตำบล เมือง จังหวัดเชียงใหม่', '03156225489', 6, 38, 4),
(5, 2, 'ปวีณา', 'สิงห์โต', 'Paweena', 'Singto', 21, 1, 'อำเภอ เมือง ตำบล เมือง จังหวัด ฉะเชิงเทรา', 'อำเภอ เมือง ตำบล เมือง จังหวัด ฉะเชิงเทรา', '0064184625', 7, 15, 3),
(6, 2, 'ภัทราวดี', 'สุขสันต์', 'Phattharawadee', 'Sukhsant', 21, 1, 'อำเภอ เมือง ตำบล เมือง จังหวัด ขอนแก่น', 'อำเภอ เมือง ตำบล เมือง จังหวัด ขอนแก่น', '054132798', 2, 28, 3),
(7, 2, 'อัญชลี', 'ชัยวัฒน์', 'Anchalee', 'Chaiwat', 22, 1, 'อำเภอ เมือง ตำบล เมือง จังหวัด ชลบุรี', 'อำเภอ เมือง ตำบล เมือง จังหวัด ชลบุรี', '02356566215', 8, 11, 2),
(8, 2, 'กนกวรรณ', 'วงศ์สุวรรณ', 'Kanokwan', 'Wongsuwan', 22, 1, 'อำเภอ เมือง ตำบล เมือง จังหวัด เพชรบุรี', 'อำเภอ เมือง ตำบล เมือง จังหวัด เพชรบุรี', '0236523548', 4, 61, 2),
(9, 2, 'รัตนาภรณ์', 'เจริญสุข', 'Rattanaporn', 'Charouensuk', 19, 5, 'อำเภอ เมือง ตำบล เมือง จังหวัด เพชรบุรี', 'อำเภอ เมือง ตำบล เมือง จังหวัด เพชรบุรี', '0984521563', 9, 61, 5),
(10, 2, 'กุลธิดา', 'อัศวเมธี', 'Kulthida', 'Aswamedhi', 18, 3, 'แขวง เมือง เขต เมือง กรุงเทพฯ', 'แขวง เมือง เขต เมือง กรุงเทพฯ', '0215698452', 9, 1, 6),
(11, 1, 'พัชรพล', 'กิตติคุณ', ' Patcharaphon', 'Kittikhun', 22, 6, 'แขวง เมือง เขต เมือง กรุงเทพฯ', 'แขวง เมือง เขต เมือง กรุงเทพฯ', '0147852145', 10, 1, 2),
(12, 1, 'กฤตภาส', 'วิทยาคม', 'Kritthaphas', 'Withayakhom', 23, 1, 'อำเภอ เมือง ตำบล เมือง นนทบุรี', 'อำเภอ เมือง ตำบล เมือง นนทบุรี', '0365879521', 1, 3, 1),
(13, 1, 'ธนพัฒน์', 'รัตนวงศ์', 'Thanaphat', 'Rattanawong', 20, 4, 'อำเภอ เมือง ตำบล เมือง เพชรบูรณ์', 'อำเภอ เมือง ตำบล เมือง เพชรบูรณ์', '04562318925', 9, 54, 4),
(14, 1, 'อธิปัตย์', 'สุขุม', 'Athipat', 'Sukhum', 19, 4, 'อำเภอ เมือง ตำบล เมือง เพชรบูรณ์', 'อำเภอ เมือง ตำบล เมือง เพชรบูรณ์', '07451258740', 9, 54, 5),
(15, 1, 'กิตติพงษ์', 'สิงห์โต', 'Kittipong', 'Singto', 20, 1, 'อำเภอ เมือง ตำบล เมือง ฉะเชิงเทรา', 'อำเภอ เมือง ตำบล เมือง ฉะเชิงเทรา', '0321475841', 3, 15, 4),
(16, 1, 'พงศ์พันธุ์', 'ชัยชนะ', 'PhongPhun', 'Chaichana', 18, 3, 'แขวง เมือง เขต เมือง กรุงเทพฯ', 'แขวง เมือง เขต เมือง กรุงเทพฯ', '0585410210', 10, 1, 6),
(17, 1, 'อรรถพล', 'วงศ์สุวรรณ', 'Atthaphon', 'Wongsuwan', 21, 2, 'อำเภอ เมือง ตำบล เมือง เพชรบุรี', 'อำเภอ เมือง ตำบล เมือง เพชรบุรี', '0124752150', 4, 61, 3),
(18, 1, 'รวิศ', 'เจริญสุข', 'Rawit', 'Charoensuk', 20, 1, 'อำเภอ เมือง ตำบล เมือง เพชรบุรี', 'อำเภอ เมือง ตำบล เมือง เพชรบุรี', '0254147852', 5, 61, 4),
(19, 1, 'ธีรภัทร', 'อัศวเมธี', ' Teerapat', 'Aswamedhi', 22, 4, 'แขวง เมือง เขต เมือง กรุงเทพฯ', 'แขวง เมือง เขต เมือง กรุงเทพฯ', '05821425002', 10, 1, 2),
(20, 1, 'กฤษดา', 'สุขสันต์', 'Kritsada', 'Sukhsant', 19, 1, 'อำเถอ เมือง ตำบล เมือง ขอนแก่น', 'อำเถอ เมือง ตำบล เมือง ขอนแก่น', '07698523100', 7, 28, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_StudentHobby`
--

CREATE TABLE `tbl_StudentHobby` (
  `SID` int(11) NOT NULL,
  `HobbyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_StudentHobby`
--

INSERT INTO `tbl_StudentHobby` (`SID`, `HobbyID`) VALUES
(2, 1),
(18, 1),
(6, 2),
(13, 3),
(17, 4),
(3, 6),
(11, 8),
(14, 9),
(9, 11),
(8, 12),
(1, 13),
(12, 13),
(16, 13),
(19, 13),
(7, 15),
(4, 16),
(15, 16),
(20, 18),
(5, 19),
(10, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `SubjectID` int(11) NOT NULL,
  `Subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`SubjectID`, `Subject`) VALUES
(1, 'Java'),
(2, 'C#'),
(3, 'C'),
(4, 'Python'),
(5, 'php'),
(6, 'SQL'),
(7, 'CSS'),
(8, 'JavaScript'),
(9, 'วิทยาศาสตร์'),
(10, 'แคลคูลัส');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year`
--

CREATE TABLE `tbl_year` (
  `yearID` int(11) NOT NULL,
  `Year` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_year`
--

INSERT INTO `tbl_year` (`yearID`, `Year`) VALUES
(1, '2544'),
(2, '2545'),
(3, '2546'),
(4, '2547'),
(5, '2548'),
(6, '2549');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pj_city`
--
ALTER TABLE `pj_city`
  ADD PRIMARY KEY (`CityID`);

--
-- Indexes for table `pj_prefix`
--
ALTER TABLE `pj_prefix`
  ADD PRIMARY KEY (`PrefixID`);

--
-- Indexes for table `pj_province`
--
ALTER TABLE `pj_province`
  ADD PRIMARY KEY (`ProvinceID`);

--
-- Indexes for table `pj_user`
--
ALTER TABLE `pj_user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`CityID`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`DepID`);

--
-- Indexes for table `tbl_hobby`
--
ALTER TABLE `tbl_hobby`
  ADD PRIMARY KEY (`HobbyID`);

--
-- Indexes for table `tbl_predixes`
--
ALTER TABLE `tbl_predixes`
  ADD PRIMARY KEY (`PrefixID`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`SID`),
  ADD KEY `PrefixID` (`PrefixID`),
  ADD KEY `DepID` (`DepID`),
  ADD KEY `SubjectID` (`SubjectID`),
  ADD KEY `CityID` (`CityID`),
  ADD KEY `yearID` (`yearID`);

--
-- Indexes for table `tbl_StudentHobby`
--
ALTER TABLE `tbl_StudentHobby`
  ADD PRIMARY KEY (`SID`),
  ADD KEY `HobbyID` (`HobbyID`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indexes for table `tbl_year`
--
ALTER TABLE `tbl_year`
  ADD PRIMARY KEY (`yearID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD CONSTRAINT `tbl_student_ibfk_2` FOREIGN KEY (`PrefixID`) REFERENCES `tbl_predixes` (`PrefixID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_ibfk_3` FOREIGN KEY (`DepID`) REFERENCES `tbl_department` (`DepID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_ibfk_4` FOREIGN KEY (`SubjectID`) REFERENCES `tbl_subject` (`SubjectID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_ibfk_5` FOREIGN KEY (`CityID`) REFERENCES `tbl_city` (`CityID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_student_ibfk_6` FOREIGN KEY (`yearID`) REFERENCES `tbl_year` (`yearID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_StudentHobby`
--
ALTER TABLE `tbl_StudentHobby`
  ADD CONSTRAINT `tbl_StudentHobby_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `tbl_student` (`SID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_StudentHobby_ibfk_2` FOREIGN KEY (`HobbyID`) REFERENCES `tbl_hobby` (`HobbyID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
