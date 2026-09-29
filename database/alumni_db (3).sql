-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2026 at 11:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni_details`
--

CREATE TABLE `alumni_details` (
  `AlumniID` int(11) NOT NULL,
  `InstitutionName` varchar(255) NOT NULL,
  `Degree` varchar(100) NOT NULL,
  `FieldOfStudy` varchar(100) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `S_ID` int(11) DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni_details`
--

INSERT INTO `alumni_details` (`AlumniID`, `InstitutionName`, `Degree`, `FieldOfStudy`, `StartDate`, `EndDate`, `logo`, `description`, `S_ID`, `AddedBy`) VALUES
(6, 'PIES DIGITAL', 'MIT', 'SYSTEM DEVELOPMENT', '2024-06-26', '2024-06-25', 'image/csr-scc.png', 'Avtech Solution', NULL, 1),
(8, 'Diocese of San Carlos', 'DOSC', 'Church System', '2022-01-01', '2024-06-25', 'image/1.png', 'Smart Diocese App', NULL, 1),
(10, 'Tanon State', 'MIT', 'Church System', '2025-01-30', '2025-01-16', 'image/Teacher-male512_44209.png', 'pataka', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcashier`
--

CREATE TABLE `tblcashier` (
  `CASHIER_ID` int(11) NOT NULL,
  `CATEGORY` enum('TUITION','STANDARD','NONSTANDARD','OTHER') NOT NULL DEFAULT 'STANDARD',
  `COURSE_ID` int(11) DEFAULT NULL,
  `YEAR_LEVEL` varchar(20) NOT NULL,
  `ITEM_NAME` varchar(150) DEFAULT NULL,
  `AMOUNT` decimal(10,2) NOT NULL DEFAULT 0.00,
  `SORT_ORDER` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblcashier`
--

INSERT INTO `tblcashier` (`CASHIER_ID`, `CATEGORY`, `COURSE_ID`, `YEAR_LEVEL`, `ITEM_NAME`, `AMOUNT`, `SORT_ORDER`) VALUES
(1, 'TUITION', 1, '1st Year', NULL, 17850.00, 0),
(2, 'TUITION', 2, '1st Year', NULL, 17850.00, 0),
(3, 'TUITION', 3, '1st Year', NULL, 17850.00, 0),
(4, 'STANDARD', NULL, '1st Year', 'Library Fee', 300.00, 1),
(5, 'STANDARD', NULL, '1st Year', 'Laboratory Fee', 800.00, 2),
(6, 'STANDARD', NULL, '1st Year', 'Athletic Fee', 200.00, 3),
(7, 'NONSTANDARD', NULL, '1st Year', 'ID Fee', 150.00, 1),
(8, 'NONSTANDARD', NULL, '1st Year', 'Handbook', 100.00, 2),
(9, 'OTHER', NULL, '1st Year', 'Miscellaneous Fee', 500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblclassrooms`
--

CREATE TABLE `tblclassrooms` (
  `CLASSROOMID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblclassrooms`
--

INSERT INTO `tblclassrooms` (`CLASSROOMID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'trttrty', 'ryyy'),
(2, 'lab1', NULL),
(3, 'kenneth', 'fs'),
(4, 'egg', 'sfger'),
(5, 'sdf', 'sdv'),
(6, 'r', 't');

-- --------------------------------------------------------

--
-- Table structure for table `tblcourses`
--

CREATE TABLE `tblcourses` (
  `COURSE_ID` int(11) NOT NULL,
  `COURSE_CODE` varchar(20) NOT NULL,
  `COURSE_NAME` varchar(150) NOT NULL,
  `COURSE_DESC` text DEFAULT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblcourses`
--

INSERT INTO `tblcourses` (`COURSE_ID`, `COURSE_CODE`, `COURSE_NAME`, `COURSE_DESC`, `STATUS`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology', 'Information Technology program', 'Active'),
(2, 'BSTM', 'Bachelor of Science in Tourism Management', 'Tourism Management program', 'Active'),
(3, 'BSED', 'Bachelor of Secondary Education', 'Secondary Education program', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tblday`
--

CREATE TABLE `tblday` (
  `DAY_ID` int(11) NOT NULL,
  `DAY` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblday`
--

INSERT INTO `tblday` (`DAY_ID`, `DAY`) VALUES
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday'),
(8, 'wednesday'),
(9, 'monday'),
(10, 'tr');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `DEPARTMENTID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`DEPARTMENTID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Elementary', 'Elementary Department'),
(2, 'Senior High School', 'Senior High School Department'),
(3, 'Junior High School', 'Junior High School Department');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `EMPLOYEE_ID` int(11) NOT NULL,
  `FNAME` varchar(50) NOT NULL,
  `MNAME` varchar(50) DEFAULT NULL,
  `LNAME` varchar(50) NOT NULL,
  `SUFFIX` varchar(10) DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `JOB_TITLE` varchar(100) DEFAULT NULL,
  `DEPARTMENT` varchar(100) DEFAULT NULL,
  `MANAGER_ID` int(11) DEFAULT NULL,
  `HIRE_DATE` date DEFAULT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`EMPLOYEE_ID`, `FNAME`, `MNAME`, `LNAME`, `SUFFIX`, `EMAIL`, `JOB_TITLE`, `DEPARTMENT`, `MANAGER_ID`, `HIRE_DATE`, `STATUS`) VALUES
(5, 'JACK', 'P.', 'ABADIES', NULL, '123@GMAIL.COM', 'ceo', 'HR', NULL, '2006-12-16', 'Inactive'),
(6, 'SAMMY', 'P.', 'SIEBADAj', NULL, 'SAM@GMAIL.COM', 'CEO', 'HR', 5, '2024-12-16', 'Active'),
(7, 'jay', 's', 'mar', 'Jr.', 'jay@gmail.com', 'hahah', 'agaga', 6, '2008-12-10', 'Active'),
(8, 'Honey', 'P.', 'Carasaquit', NULL, 'han@gmail.com', 'Accountant', 'IU', 5, '2007-12-05', 'Active'),
(9, 's', 'h', 'z', NULL, 'yen2@gmail.com', 'doctor', 'c', 8, '2003-12-02', 'Active'),
(10, '4884', '515', '965945', 'Sr.', 'jkg@gmail.com', 'fire man', 'fmr', 5, '2000-12-06', 'Inactive'),
(11, 'JESSON', 'P.', 'BATUTO', 'Sr.', 'jbatuto@gmail.com', 'Doctor', 'Radiology', 8, '2000-02-15', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tblenrollment`
--

CREATE TABLE `tblenrollment` (
  `ENROLLMENT_ID` int(11) NOT NULL,
  `S_ID` int(11) NOT NULL,
  `COURSE_ID` int(11) NOT NULL,
  `SECTION_ID` int(11) DEFAULT NULL,
  `SY_ID` int(11) NOT NULL,
  `YEAR_LEVEL` varchar(20) NOT NULL,
  `SEMESTER` varchar(20) NOT NULL,
  `CATEGORY` varchar(30) NOT NULL DEFAULT 'New',
  `CURRICULUM_YR` varchar(20) DEFAULT NULL,
  `DATE_RESERVED` date DEFAULT NULL,
  `DATE_ENROLLED` date DEFAULT NULL,
  `STATUS` varchar(30) NOT NULL DEFAULT 'Registered',
  `AMOUNT_DUE` decimal(10,2) NOT NULL DEFAULT 0.00,
  `AMOUNT_PAID` decimal(10,2) NOT NULL DEFAULT 0.00,
  `REG_FEE_PAID` decimal(10,2) NOT NULL DEFAULT 0.00,
  `ENCODED_BY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblenrollment`
--

INSERT INTO `tblenrollment` (`ENROLLMENT_ID`, `S_ID`, `COURSE_ID`, `SECTION_ID`, `SY_ID`, `YEAR_LEVEL`, `SEMESTER`, `CATEGORY`, `CURRICULUM_YR`, `DATE_RESERVED`, `DATE_ENROLLED`, `STATUS`, `AMOUNT_DUE`, `AMOUNT_PAID`, `REG_FEE_PAID`, `ENCODED_BY`) VALUES
(9, 15, 1, 1, 1, '1st Year', '1st Semester', 'New', '2025-2026', '2026-08-29', '2026-08-29', 'Enrolled', 19800.00, 19800.00, 1000.00, 1),
(10, 16, 1, 3, 1, '1st Year', '1st Semester', 'New', '2025-2026', '2026-08-30', '2026-08-30', 'Enrolled', 19800.00, 1000.00, 1000.00, 1),
(15, 21, 1, 1, 1, '1st Year', '1st Semester', 'New', '2025-2026', '2026-09-02', '2026-09-02', 'Enrolled', 19800.00, 6000.00, 1000.00, 1),
(16, 23, 1, 1, 1, '1st Year', '1st Semester', 'New', '2025-2026', '2026-09-02', '2026-09-02', 'Enrolled', 19800.00, 5000.00, 1000.00, 1),
(17, 24, 1, 1, 1, '1st Year', '1st Semester', 'New', '2025-2026', '2026-09-03', NULL, 'Sectioned', 19800.00, 0.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblenrollmentdetails`
--

CREATE TABLE `tblenrollmentdetails` (
  `DETAIL_ID` int(11) NOT NULL,
  `ENROLLMENT_ID` int(11) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL,
  `IDNO` varchar(20) DEFAULT NULL,
  `STUDENT_NAME` varchar(150) DEFAULT NULL,
  `COURSE_CODE` varchar(10) DEFAULT NULL,
  `YEAR_LEVEL` varchar(20) DEFAULT NULL,
  `SEMESTER` varchar(20) DEFAULT NULL,
  `SCHOOL_YEAR` varchar(20) DEFAULT NULL,
  `STATUS` varchar(30) DEFAULT NULL,
  `SUBJECT_CODE` varchar(30) DEFAULT NULL,
  `SUBJECT_NAME` varchar(150) DEFAULT NULL,
  `UNITS` int(11) DEFAULT NULL,
  `SUBJECT_TYPE` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblgrades`
--

CREATE TABLE `tblgrades` (
  `GRADE_ID` int(11) NOT NULL,
  `S_ID` int(11) NOT NULL,
  `SUBJECT_ID` int(11) NOT NULL,
  `ENROLLMENT_ID` int(11) NOT NULL,
  `SY_ID` int(11) NOT NULL,
  `SEMESTER` varchar(20) DEFAULT NULL,
  `GRADE` decimal(5,2) DEFAULT NULL,
  `REMARKS` varchar(20) DEFAULT NULL,
  `DATE_ENCODED` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblgrades`
--

INSERT INTO `tblgrades` (`GRADE_ID`, `S_ID`, `SUBJECT_ID`, `ENROLLMENT_ID`, `SY_ID`, `SEMESTER`, `GRADE`, `REMARKS`, `DATE_ENCODED`) VALUES
(1, 15, 12, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(2, 15, 13, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(3, 15, 14, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(4, 15, 1, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(5, 15, 2, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(6, 15, 16, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(7, 15, 15, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22'),
(8, 15, 11, 9, 1, '1st Semester', 1.00, 'Passed', '2026-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `tblinstructor`
--

CREATE TABLE `tblinstructor` (
  `INSTRUCTORID` int(11) NOT NULL,
  `INSTRUCTOR` varchar(100) NOT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblinstructor`
--

INSERT INTO `tblinstructor` (`INSTRUCTORID`, `INSTRUCTOR`, `STATUS`) VALUES
(1, 'Sr. Joy, AR', 1),
(2, 'Mrs. Via', 1),
(3, 'Mrs. Bato', 1),
(4, 'Mr. Batuto', 1),
(5, 'Mr. Limot', 1),
(6, 'Mrs. Apatan', 1),
(7, 'Sr. Joy', 1),
(8, 'Oberes', 1),
(9, 'Millan', 1),
(10, 'Batuto', 1),
(11, 'Binghay', 1),
(12, 'Valencia', 1),
(13, 'Mr. Auman', 1),
(14, 'Mr. Dison', 1),
(15, 'Mr. Abellar', 1),
(16, 'fgd', 1),
(17, 'dgfdg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblpayments`
--

CREATE TABLE `tblpayments` (
  `PAYMENT_ID` int(11) NOT NULL,
  `ENROLLMENT_ID` int(11) NOT NULL,
  `AMOUNT` decimal(10,2) NOT NULL,
  `PAYMENT_TYPE` enum('Registration','Tuition') NOT NULL DEFAULT 'Tuition',
  `SOURCE` enum('Counter','Online') NOT NULL DEFAULT 'Counter',
  `PAY_STATUS` enum('Pending','Verified','Rejected') NOT NULL DEFAULT 'Verified',
  `VERIFIED_BY` int(11) DEFAULT NULL,
  `VERIFIED_ON` datetime DEFAULT NULL,
  `OR_NUMBER` varchar(50) DEFAULT NULL,
  `PROOF_FILE` varchar(255) DEFAULT NULL,
  `CASHIER` varchar(100) DEFAULT NULL,
  `DATE_PAID` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpayments`
--

INSERT INTO `tblpayments` (`PAYMENT_ID`, `ENROLLMENT_ID`, `AMOUNT`, `PAYMENT_TYPE`, `SOURCE`, `PAY_STATUS`, `VERIFIED_BY`, `VERIFIED_ON`, `OR_NUMBER`, `PROOF_FILE`, `CASHIER`, `DATE_PAID`) VALUES
(1, 5, 2700.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '9696965', NULL, 'kier', '2026-08-27'),
(2, 5, 3000.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '9696965', NULL, 'kier', '2026-08-27'),
(3, 6, 2700.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '9696965', NULL, 'kier', '2026-08-27'),
(4, 8, 10000.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '9696965', NULL, 'kier', '2026-08-27'),
(5, 8, 9800.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '9696965', NULL, 'kier', '2026-08-27'),
(6, 9, 19800.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '9696965', NULL, 'kier', '2026-08-29'),
(7, 10, 1000.00, 'Tuition', 'Counter', 'Verified', NULL, NULL, '55555', NULL, 'kier', '2026-08-30'),
(14, 15, 2000.00, 'Registration', 'Online', 'Verified', 1, '2026-09-02 10:19:32', '000000', 'proofs/proof_21_1788315445_0IN0e9I__1_.jpg', 'Online Submission', '2026-09-02'),
(15, 15, 2000.00, 'Tuition', 'Online', 'Verified', 1, '2026-09-02 10:20:51', '000000', 'proofs/proof_21_1788315627_1cd0580d2177736a180a9cee727da4e8.jpg', 'Online Submission', '2026-09-02'),
(16, 15, 4000.00, 'Tuition', 'Online', 'Verified', 1, '2026-09-02 10:40:16', '000000', 'proofs/proof_21_1788316775_Screenshot_2026-07-09_160105.png', 'Online Submission', '2026-09-02'),
(17, 16, 1000.00, 'Registration', 'Online', 'Verified', 1, '2026-09-02 15:04:11', '000000', 'proofs/proof_23_1788332606_c9b0869f8a2ecd6f9f972b242ab6de66.jpg', 'Online Submission', '2026-09-02'),
(18, 16, 5000.00, 'Tuition', 'Online', 'Verified', 1, '2026-09-02 15:06:10', '000000', 'proofs/proof_23_1788332718_c9b0869f8a2ecd6f9f972b242ab6de66.jpg', 'Online Submission', '2026-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `tblschoolyear`
--

CREATE TABLE `tblschoolyear` (
  `SY_ID` int(11) NOT NULL,
  `SCHOOL_YEAR` varchar(20) NOT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblschoolyear`
--

INSERT INTO `tblschoolyear` (`SY_ID`, `SCHOOL_YEAR`, `STATUS`) VALUES
(1, '2025-2026', 'Active'),
(4, '2024-2025', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tblsections`
--

CREATE TABLE `tblsections` (
  `SECTION_ID` int(11) NOT NULL,
  `SECTION_NAME` varchar(50) NOT NULL,
  `COURSE_ID` int(11) NOT NULL,
  `SY_ID` int(11) NOT NULL,
  `YEAR_LEVEL` varchar(20) NOT NULL,
  `PROGRAM_HEAD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsections`
--

INSERT INTO `tblsections` (`SECTION_ID`, `SECTION_NAME`, `COURSE_ID`, `SY_ID`, `YEAR_LEVEL`, `PROGRAM_HEAD`) VALUES
(1, 'A', 1, 1, '1st Year', NULL),
(2, 'B', 1, 1, '1st Year', NULL),
(3, 'C', 1, 1, '1st Year', NULL),
(4, 'D', 1, 1, '1st Year', NULL),
(5, 'A', 2, 1, '1st Year', NULL),
(6, 'B', 2, 1, '1st Year', NULL),
(7, 'C', 2, 1, '1st Year', NULL),
(8, 'D', 2, 1, '1st Year', NULL),
(9, 'A', 3, 1, '1st Year', NULL),
(10, 'B', 3, 1, '1st Year', NULL),
(11, 'C', 3, 1, '1st Year', NULL),
(12, 'D', 3, 1, '1st Year', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsetschedule`
--

CREATE TABLE `tblsetschedule` (
  `SCHEDULEID` int(11) NOT NULL,
  `ROOM` varchar(50) NOT NULL,
  `DAY` varchar(50) NOT NULL,
  `TIME` varchar(50) NOT NULL,
  `AY` varchar(20) NOT NULL,
  `SEMESTER` varchar(50) NOT NULL,
  `YEAR_LEVEL` varchar(20) NOT NULL,
  `SECTION` varchar(20) NOT NULL,
  `CODE` varchar(20) NOT NULL,
  `SUBJECT_DESCRIPTION` varchar(150) NOT NULL,
  `UNITS` decimal(3,1) NOT NULL DEFAULT 0.0,
  `INSTRUCTORID` varchar(100) DEFAULT NULL,
  `STATUS` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsetschedule`
--

INSERT INTO `tblsetschedule` (`SCHEDULEID`, `ROOM`, `DAY`, `TIME`, `AY`, `SEMESTER`, `YEAR_LEVEL`, `SECTION`, `CODE`, `SUBJECT_DESCRIPTION`, `UNITS`, `INSTRUCTORID`, `STATUS`) VALUES
(1, 'egg', 'Thursday', '7:00 AM - 8:00 AM', '20006', '1st Semester', '1st Year', '1', '42', '42', 24.0, '5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `S_ID` int(11) NOT NULL,
  `IDNO` varchar(20) NOT NULL,
  `FNAME` varchar(40) NOT NULL,
  `LNAME` varchar(40) NOT NULL,
  `MNAME` varchar(40) NOT NULL,
  `SEX` varchar(10) NOT NULL DEFAULT 'Male',
  `BDAY` date DEFAULT NULL,
  `BPLACE` text DEFAULT NULL,
  `STATUS` varchar(30) NOT NULL DEFAULT 'Active',
  `AGE` int(11) DEFAULT NULL,
  `NATIONALITY` varchar(40) DEFAULT NULL,
  `RELIGION` varchar(255) DEFAULT NULL,
  `CONTACT_NO` varchar(40) DEFAULT NULL,
  `HOME_ADD` text DEFAULT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `ACC_PASSWORD` text DEFAULT NULL,
  `LRNNO` varchar(15) DEFAULT NULL,
  `CONTACTPERSON` varchar(150) DEFAULT NULL,
  `COMPANYIDNO` int(11) DEFAULT NULL,
  `COURSE_ID` int(11) DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`S_ID`, `IDNO`, `FNAME`, `LNAME`, `MNAME`, `SEX`, `BDAY`, `BPLACE`, `STATUS`, `AGE`, `NATIONALITY`, `RELIGION`, `CONTACT_NO`, `HOME_ADD`, `EMAIL`, `photo`, `ACC_PASSWORD`, `LRNNO`, `CONTACTPERSON`, `COMPANYIDNO`, `COURSE_ID`, `AddedBy`) VALUES
(15, '1', 'Viod', '2.0', 'S', 'Male', '1992-03-26', 'san caslos', 'Active', 34, 'Void', 'Void', '0909', 'Unknown', 'Void@gmail.com', 'image/1787985521_฀฀฀ on TikTok.jpe', NULL, NULL, NULL, NULL, 1, NULL),
(16, '2', 'peace', 'cool', 'stay', 'Male', '2007-06-30', 'san caslos', 'Active', 18, 'Void', 'Void', '090988', 'Unknown', 'peace@gmail.com', 'image/1788043359_Golden Brown Pictures.jpe', NULL, NULL, NULL, NULL, 1, NULL),
(21, '2026-0021', 'scsf', 'czcc', 'czcz', 'Male', '2026-09-17', 'czcz', 'Active', 66, 'wfwf', 'gstw', 'gg', 'wtwtw', 'kier@gmail.com', NULL, '$2y$10$o8qiKhInEqOf/LE5JWkpeObvmcUgOZ61eJd6fzwc5VXlILC0m4FP6', NULL, NULL, NULL, 1, NULL),
(23, '2026-0023', 'Shin', 'lol', 'okk', 'Female', '2026-09-10', 'czcz', 'Active', 66, 'wfwf', 'gstw', 'gg', 'wtwtw', 'kensolitario62@gmail.com', 'image/1788332173_฀฀฀ on TikTok.jpe', '$2y$10$9Rwoje9l2MD38XiB5XFw5.76MPRB8dQenCvMCUMgLXllYui2pmFPW', NULL, NULL, NULL, 1, NULL),
(24, '00035', 'sdwd', 'dD', 'dqd', 'Male', '2026-08-20', 'san caslos', 'Active', 34, 'Void', 'Void', '0909', 'wtwtw', 'Void@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubjects`
--

CREATE TABLE `tblsubjects` (
  `SUBJECT_ID` int(11) NOT NULL,
  `SUBJECT_CODE` varchar(20) NOT NULL,
  `SUBJECT_NAME` varchar(150) NOT NULL,
  `UNITS` int(11) NOT NULL DEFAULT 3,
  `PRICE_PER_UNIT` decimal(10,2) NOT NULL DEFAULT 900.00,
  `COURSE_ID` int(11) NOT NULL,
  `YEAR_LEVEL` varchar(20) DEFAULT NULL,
  `SEMESTER` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblsubjects`
--

INSERT INTO `tblsubjects` (`SUBJECT_ID`, `SUBJECT_CODE`, `SUBJECT_NAME`, `UNITS`, `PRICE_PER_UNIT`, `COURSE_ID`, `YEAR_LEVEL`, `SEMESTER`) VALUES
(1, 'IT101', 'Introduction to Computing', 3, 900.00, 1, '1st Year', '1st Semester'),
(2, 'IT102', 'Computer Programming 1', 3, 900.00, 1, '1st Year', '1st Semester'),
(4, 'IT104', 'Web Systems and Technologies', 3, 900.00, 1, '1st Year', '2nd Semester'),
(5, 'TM101', 'Introduction to Tourism', 3, 900.00, 2, '1st Year', '1st Semester'),
(6, 'TM102', 'Philippine Culture and Tourism Geography', 3, 900.00, 2, '1st Year', '1st Semester'),
(7, 'TM103', 'Micro Perspective of Tourism', 3, 900.00, 2, '1st Year', '2nd Semester'),
(8, 'ED101', 'The Teaching Profession', 3, 900.00, 3, '1st Year', '1st Semester'),
(9, 'ED102', 'Child and Adolescent Development', 3, 900.00, 3, '1st Year', '1st Semester'),
(10, 'ED103', 'Facilitating Learner-Centered Teaching', 3, 900.00, 3, '1st Year', '2nd Semester'),
(11, 'RE 1', 'Basic Doctrine and Sacraments in the Teaching of St. Augustine', 2, 900.00, 1, '1st Year', '1st Semester'),
(12, 'GE 1', 'Understanding the Self', 3, 900.00, 1, '1st Year', '1st Semester'),
(13, 'GE 2', 'Readings in Philippine History', 3, 900.00, 1, '1st Year', '1st Semester'),
(14, 'GE 3', 'The Contemporary World', 3, 900.00, 1, '1st Year', '1st Semester'),
(15, 'PATHFit 1', 'Movement Competency Training', 2, 900.00, 1, '1st Year', '1st Semester'),
(16, 'NSTP 1', 'National Service Training Program 1', 3, 900.00, 1, '1st Year', '1st Semester');

-- --------------------------------------------------------

--
-- Table structure for table `tbltime`
--

CREATE TABLE `tbltime` (
  `TIME_ID` int(11) NOT NULL,
  `TIME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltime`
--

INSERT INTO `tbltime` (`TIME_ID`, `TIME`) VALUES
(1, '7:00 AM - 8:00 AM'),
(2, '8:00 AM - 9:00 AM'),
(3, '9:00 AM - 10:00 AM'),
(4, '8:00 AM'),
(5, '11:00'),
(6, '4');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `UID` int(11) NOT NULL,
  `DISPLAYNAME` varchar(30) NOT NULL,
  `PHOTO` varchar(255) DEFAULT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` text NOT NULL,
  `TYPE` varchar(15) NOT NULL,
  `TYPEID` int(11) DEFAULT NULL,
  `ADDEDBY` int(3) NOT NULL,
  `DATEADDED` date NOT NULL,
  `MODIFIEDBY` int(3) NOT NULL,
  `DATEMODIFIED` date NOT NULL,
  `STATUSACTIVE` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`UID`, `DISPLAYNAME`, `PHOTO`, `USERNAME`, `PASSWORD`, `TYPE`, `TYPEID`, `ADDEDBY`, `DATEADDED`, `MODIFIEDBY`, `DATEMODIFIED`, `STATUSACTIVE`) VALUES
(1, 'Kier', '1788329618_ziad_50i✨️.jpe', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', 1, 1, '2020-08-27', 1, '2026-09-02', 1),
(77, 'dfd', NULL, 'dfd', '6bb65257fcab4e2975cd96b0f7fc4b53d97c10b6', 'Staff', 3, 1, '2025-01-16', 1, '2026-08-02', 1),
(78, 'dfd', NULL, 'dfdf', '6bb65257fcab4e2975cd96b0f7fc4b53d97c10b6', 'Staff', 3, 1, '2025-01-16', 1, '2025-01-16', 1),
(79, 'Erick', NULL, 'jason', '5c2dd944dde9e08881bef0894fe7b22a5c9c4b06', 'Administrator', 1, 1, '2025-01-24', 1, '2025-01-24', 1),
(80, 'john', NULL, 'ken', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Nurse', NULL, 1, '2026-09-14', 1, '2026-09-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblusertype`
--

CREATE TABLE `tblusertype` (
  `TYPEID` int(11) NOT NULL,
  `USERTYPE` varchar(30) NOT NULL,
  `STATUS` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusertype`
--

INSERT INTO `tblusertype` (`TYPEID`, `USERTYPE`, `STATUS`) VALUES
(1, 'Administrator', 'Active'),
(2, 'Doctor', 'Active'),
(3, 'Staff', 'Active'),
(7, 'Nurse', 'Active'),
(12, 'hello', 'Inactive'),
(13, 'cashier', 'Active'),
(14, 'sdsds', 'Inactive'),
(16, 'Student', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD PRIMARY KEY (`AlumniID`),
  ADD KEY `fk_alumni_student` (`S_ID`),
  ADD KEY `fk_alumni_addedby` (`AddedBy`);

--
-- Indexes for table `tblcashier`
--
ALTER TABLE `tblcashier`
  ADD PRIMARY KEY (`CASHIER_ID`),
  ADD KEY `tblcashier_course_fk` (`COURSE_ID`);

--
-- Indexes for table `tblclassrooms`
--
ALTER TABLE `tblclassrooms`
  ADD PRIMARY KEY (`CLASSROOMID`);

--
-- Indexes for table `tblcourses`
--
ALTER TABLE `tblcourses`
  ADD PRIMARY KEY (`COURSE_ID`),
  ADD UNIQUE KEY `COURSE_CODE` (`COURSE_CODE`);

--
-- Indexes for table `tblday`
--
ALTER TABLE `tblday`
  ADD PRIMARY KEY (`DAY_ID`);

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`DEPARTMENTID`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`EMPLOYEE_ID`),
  ADD KEY `MANAGER_ID` (`MANAGER_ID`);

--
-- Indexes for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  ADD PRIMARY KEY (`ENROLLMENT_ID`),
  ADD UNIQUE KEY `uq_enrollment_term` (`S_ID`,`SY_ID`,`SEMESTER`),
  ADD KEY `fk_enrollment_student` (`S_ID`),
  ADD KEY `fk_enrollment_course` (`COURSE_ID`),
  ADD KEY `fk_enrollment_section` (`SECTION_ID`),
  ADD KEY `fk_enrollment_sy` (`SY_ID`),
  ADD KEY `fk_enrollment_encodedby` (`ENCODED_BY`);

--
-- Indexes for table `tblenrollmentdetails`
--
ALTER TABLE `tblenrollmentdetails`
  ADD PRIMARY KEY (`DETAIL_ID`);

--
-- Indexes for table `tblgrades`
--
ALTER TABLE `tblgrades`
  ADD PRIMARY KEY (`GRADE_ID`);

--
-- Indexes for table `tblinstructor`
--
ALTER TABLE `tblinstructor`
  ADD PRIMARY KEY (`INSTRUCTORID`);

--
-- Indexes for table `tblpayments`
--
ALTER TABLE `tblpayments`
  ADD PRIMARY KEY (`PAYMENT_ID`);

--
-- Indexes for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  ADD PRIMARY KEY (`SY_ID`),
  ADD UNIQUE KEY `SCHOOL_YEAR` (`SCHOOL_YEAR`);

--
-- Indexes for table `tblsections`
--
ALTER TABLE `tblsections`
  ADD PRIMARY KEY (`SECTION_ID`),
  ADD KEY `fk_sections_course` (`COURSE_ID`),
  ADD KEY `fk_sections_sy` (`SY_ID`);

--
-- Indexes for table `tblsetschedule`
--
ALTER TABLE `tblsetschedule`
  ADD PRIMARY KEY (`SCHEDULEID`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`S_ID`),
  ADD UNIQUE KEY `IDNO` (`IDNO`),
  ADD KEY `fk_student_course` (`COURSE_ID`),
  ADD KEY `fk_student_addedby` (`AddedBy`);

--
-- Indexes for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD PRIMARY KEY (`SUBJECT_ID`),
  ADD UNIQUE KEY `uq_subject_code` (`SUBJECT_CODE`),
  ADD KEY `fk_subjects_course` (`COURSE_ID`);

--
-- Indexes for table `tbltime`
--
ALTER TABLE `tbltime`
  ADD PRIMARY KEY (`TIME_ID`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `uq_username` (`USERNAME`),
  ADD KEY `fk_users_usertype` (`TYPEID`);

--
-- Indexes for table `tblusertype`
--
ALTER TABLE `tblusertype`
  ADD PRIMARY KEY (`TYPEID`),
  ADD UNIQUE KEY `uq_usertype` (`USERTYPE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni_details`
--
ALTER TABLE `alumni_details`
  MODIFY `AlumniID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblcashier`
--
ALTER TABLE `tblcashier`
  MODIFY `CASHIER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblclassrooms`
--
ALTER TABLE `tblclassrooms`
  MODIFY `CLASSROOMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblcourses`
--
ALTER TABLE `tblcourses`
  MODIFY `COURSE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblday`
--
ALTER TABLE `tblday`
  MODIFY `DAY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `DEPARTMENTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `EMPLOYEE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  MODIFY `ENROLLMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblenrollmentdetails`
--
ALTER TABLE `tblenrollmentdetails`
  MODIFY `DETAIL_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblgrades`
--
ALTER TABLE `tblgrades`
  MODIFY `GRADE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblinstructor`
--
ALTER TABLE `tblinstructor`
  MODIFY `INSTRUCTORID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblpayments`
--
ALTER TABLE `tblpayments`
  MODIFY `PAYMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblschoolyear`
--
ALTER TABLE `tblschoolyear`
  MODIFY `SY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblsections`
--
ALTER TABLE `tblsections`
  MODIFY `SECTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblsetschedule`
--
ALTER TABLE `tblsetschedule`
  MODIFY `SCHEDULEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `S_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  MODIFY `SUBJECT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbltime`
--
ALTER TABLE `tbltime`
  MODIFY `TIME_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tblusertype`
--
ALTER TABLE `tblusertype`
  MODIFY `TYPEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni_details`
--
ALTER TABLE `alumni_details`
  ADD CONSTRAINT `fk_alumni_addedby` FOREIGN KEY (`AddedBy`) REFERENCES `tblusers` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alumni_student` FOREIGN KEY (`S_ID`) REFERENCES `tblstudent` (`S_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblcashier`
--
ALTER TABLE `tblcashier`
  ADD CONSTRAINT `tblcashier_course_fk` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD CONSTRAINT `tblemployee_manager_fk` FOREIGN KEY (`MANAGER_ID`) REFERENCES `tblemployee` (`EMPLOYEE_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblenrollment`
--
ALTER TABLE `tblenrollment`
  ADD CONSTRAINT `fk_enrollment_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_encodedby` FOREIGN KEY (`ENCODED_BY`) REFERENCES `tblusers` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_section` FOREIGN KEY (`SECTION_ID`) REFERENCES `tblsections` (`SECTION_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`S_ID`) REFERENCES `tblstudent` (`S_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollment_sy` FOREIGN KEY (`SY_ID`) REFERENCES `tblschoolyear` (`SY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblsections`
--
ALTER TABLE `tblsections`
  ADD CONSTRAINT `fk_sections_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sections_sy` FOREIGN KEY (`SY_ID`) REFERENCES `tblschoolyear` (`SY_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD CONSTRAINT `fk_student_addedby` FOREIGN KEY (`AddedBy`) REFERENCES `tblusers` (`UID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblsubjects`
--
ALTER TABLE `tblsubjects`
  ADD CONSTRAINT `fk_subjects_course` FOREIGN KEY (`COURSE_ID`) REFERENCES `tblcourses` (`COURSE_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD CONSTRAINT `fk_users_usertype` FOREIGN KEY (`TYPEID`) REFERENCES `tblusertype` (`TYPEID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
