-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2023 at 05:07 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` char(5) NOT NULL,
  `AdminName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Role` varchar(2) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `Email`, `Role`, `Password`) VALUES
('AD001', 'LIM AH GAOS', 'asdas@gmail.com', 'SA', 'asdaAA12313'),
('AD002', 'LEE CHENG QIIAN', 'chengqian@gmail.com', 'EM', 'B1234567b');

-- --------------------------------------------------------

--
-- Table structure for table `admin_detail`
--

CREATE TABLE `admin_detail` (
  `adminID` char(5) NOT NULL,
  `adminName` varchar(30) NOT NULL,
  `Password` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_detail`
--

INSERT INTO `admin_detail` (`adminID`, `adminName`, `Password`) VALUES
('AD001', 'Lebonk James', 'admin123'),
('AD002', 'Koubi Braiyan', 'admin234');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `title_announcement` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`title_announcement`, `description`) VALUES
('chenchen', 'chen'),
('chuasidjnsidjn', 'sodvjnkaopsdfknv'),
('chunqing', 'chen'),
('sadcsioadcjn', 'vdujifbvuidfjvh');

-- --------------------------------------------------------

--
-- Table structure for table `event_detail`
--

CREATE TABLE `event_detail` (
  `EventName` varchar(30) NOT NULL,
  `EventDate` char(10) NOT NULL,
  `EventtVenue` varchar(40) NOT NULL,
  `EventTime` varchar(30) NOT NULL,
  `Price_P` int(11) NOT NULL,
  `Price_S` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_detail`
--

INSERT INTO `event_detail` (`EventName`, `EventDate`, `EventtVenue`, `EventTime`, `Price_P`, `Price_S`, `Description`) VALUES
('Voice Of Rahman', '04-12-2023', 'New Foyer', '9:00 am - 20:00 pm', 40, 15, 'Good Morning Good Morning Good Morning Good Morning Good Morning Good Morning Good Morning Good Morning Good Morning Good Morning'),
('THE LIGHTS', '13-09-2023', 'Main Foyer', '7:00 am - 18:00 pm', 20, 10, ''),
('Hello World', '15-05-2023', 'DEWAN', '7:00am - 17:00pm', 30, 10, 'HI');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(50) NOT NULL,
  `StudentName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `TypeOfevent` char(2) NOT NULL,
  `Feeling` char(2) NOT NULL,
  `Feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `StudentName`, `Email`, `TypeOfevent`, `Feeling`, `Feedback`) VALUES
(1, 'Lee Cheng Qian', 'llll@gmail.com', 'DR', 'N', 'Dance show is too normal'),
(2, 'Lee Cheng Qian', 'llll@gmail.com', 'LT', 'N', 'Literature just ok');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `OrderID` int(11) NOT NULL,
  `StudentID` char(10) NOT NULL,
  `EventName` varchar(30) NOT NULL,
  `buyQuantity` int(11) NOT NULL,
  `TicketPrice` int(11) NOT NULL,
  `TotalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`OrderID`, `StudentID`, `EventName`, `buyQuantity`, `TicketPrice`, `TotalPrice`) VALUES
(1, '22PMD08417', '', 3, 40, 120),
(2, '22PMD08417', '', 2, 20, 60),
(3, '22PMD08417', '', 1, 10, 10),
(13, '22PMD02891', '', 2, 30, 60),
(14, '22PMD08417', '', 1, 15, 15),
(15, '22PMD08417', '', 2, 40, 80);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `username` varchar(15) NOT NULL,
  `email_address` varchar(25) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `account_number` char(12) NOT NULL,
  `cvc` int(3) NOT NULL,
  `expired_date` char(10) NOT NULL,
  `total_amount` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`username`, `email_address`, `phone_number`, `payment_method`, `account_number`, `cvc`, `expired_date`, `total_amount`) VALUES
('qwdqwdqwd', 'chenchunqing63@gmail.com', '010-5345345', 'DEBIT', '123123123123', 123, '2023-06-03', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `student_detail`
--

CREATE TABLE `student_detail` (
  `StudentID` char(10) NOT NULL,
  `Std_Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(12) NOT NULL,
  `otp` int(6) NOT NULL,
  `Gender` char(1) NOT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `Programme` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_detail`
--

INSERT INTO `student_detail` (`StudentID`, `Std_Name`, `Email`, `Password`, `otp`, `Gender`, `PhoneNumber`, `Programme`) VALUES
('22PMD02891', 'Khong Shi Yun', 'yunkhong04@gmail.com', 'B1234567b', 378711, 'F', '010-8888856', 'BS'),
('22PMD08417', 'Khong Yao Jun', 'junkhong04@gmail.com', 'B1234567b', 0, 'M', '010-5345345', 'IT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `admin_detail`
--
ALTER TABLE `admin_detail`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`title_announcement`);

--
-- Indexes for table `event_detail`
--
ALTER TABLE `event_detail`
  ADD PRIMARY KEY (`EventDate`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`account_number`);

--
-- Indexes for table `student_detail`
--
ALTER TABLE `student_detail`
  ADD PRIMARY KEY (`StudentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
