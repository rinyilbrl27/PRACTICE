-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2024 at 02:31 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `record-list`
--

-- --------------------------------------------------------

--
-- Table structure for table `section-tbl`
--

CREATE TABLE `section-tbl` (
  `section` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `section-tbl`
--

INSERT INTO `section-tbl` (`section`) VALUES
('BSCS2A'),
('BSCS2B'),
('BSCS2C'),
('BSCS2D'),
('BSCS2E'),
('BSCS2F'),
('BSCS2G'),
('BSCS2H');

-- --------------------------------------------------------

--
-- Table structure for table `student-subjects`
--

CREATE TABLE `student-subjects` (
  `studentid` varchar(50) NOT NULL,
  `subject-code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student-subjects`
--

INSERT INTO `student-subjects` (`studentid`, `subject-code`) VALUES
('2024-01-01', 'CC104'),
('2024-01-01', 'CC105'),
('2024-01-01', 'CS211'),
('2024-01-02', 'CC104'),
('2024-01-02', 'CC105'),
('2024-01-02', 'CS211'),
('2024-01-02', 'DC101'),
('2024-01-02', 'GE105'),
('2024-01-05', 'CC104'),
('2024-01-05', 'CC105');

-- --------------------------------------------------------

--
-- Table structure for table `students-tbl`
--

CREATE TABLE `students-tbl` (
  `studentid` varchar(50) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `mi` varchar(10) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL,
  `enrollmentStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students-tbl`
--

INSERT INTO `students-tbl` (`studentid`, `lastName`, `firstName`, `mi`, `gender`, `section`, `enrollmentStatus`) VALUES
('2024-01-01', 'Oakds', 'Michael', 'A', 'Male', 'BSCS2E', 'Irregular'),
('2024-01-02', 'adwad', 'Luffy', 'D', 'Male', 'BSCS2C', 'Regular'),
('2024-01-05', 'Olan', '', '', 'Male', 'BSCS2A', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `subject-code-tbl`
--

CREATE TABLE `subject-code-tbl` (
  `subject-code` varchar(50) NOT NULL,
  `subject-name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject-code-tbl`
--

INSERT INTO `subject-code-tbl` (`subject-code`, `subject-name`) VALUES
('CC104', 'Intermidiete Programming'),
('CC105', 'Information Management'),
('CS211', 'Discrete Structure 2'),
('CS212', 'Automata Theory and Formal Languages'),
('DC101', 'Web Developement'),
('GE105', 'Ethics'),
('GE106', 'Art Appreciation'),
('LOL', 'League of Legends'),
('PATHFIT-3', 'Physical Activities Towards Health and Fitness 3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `section-tbl`
--
ALTER TABLE `section-tbl`
  ADD PRIMARY KEY (`section`);

--
-- Indexes for table `student-subjects`
--
ALTER TABLE `student-subjects`
  ADD PRIMARY KEY (`studentid`,`subject-code`);

--
-- Indexes for table `students-tbl`
--
ALTER TABLE `students-tbl`
  ADD PRIMARY KEY (`studentid`);

--
-- Indexes for table `subject-code-tbl`
--
ALTER TABLE `subject-code-tbl`
  ADD PRIMARY KEY (`subject-code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
