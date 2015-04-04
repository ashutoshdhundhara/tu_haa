SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

--
-- Database: `HostelJ`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_id`
--

CREATE TABLE IF NOT EXISTS `admin_id` (
  `admin_id` varchar(10) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains Admin credentials.';

-- --------------------------------------------------------

--
-- Table structure for table `eligible_students`
--

CREATE TABLE IF NOT EXISTS `eligible_students` (
  `roll_no` varchar(12) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `unique_id` varchar(10) NOT NULL,
  PRIMARY KEY (`roll_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains list of students eligible for Hostel-J.';

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE IF NOT EXISTS `group_details` (
  `roll_no` varchar(12) NOT NULL,
  `unique_id` varchar(10) NOT NULL,
  `group_id` varchar(10) NOT NULL,
  PRIMARY KEY (`roll_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains details about Groups formed.';

-- --------------------------------------------------------

--
-- Table structure for table `group_id`
--

CREATE TABLE IF NOT EXISTS `group_id` (
  `group_id` varchar(10) NOT NULL,
  `password` char(128) NOT NULL,
  `group_size` varchar(2) NOT NULL,
  `allotment_status` enum('SELECT','ALLOT','COMPLETE') NOT NULL DEFAULT 'SELECT',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains credentials of Groups formed.';

-- --------------------------------------------------------

--
-- Table structure for table `rooms_info`
--

CREATE TABLE IF NOT EXISTS `rooms_info` (
  `wing` char(1) NOT NULL,
  `floor` char(1) NOT NULL,
  `cluster` char(1) NOT NULL,
  `room_no` varchar(2) NOT NULL,
  `room_status` varchar(20) NOT NULL DEFAULT 'AVAILABLE',
  `group_id` varchar(10) NOT NULL,
  PRIMARY KEY (`wing`,`floor`,`cluster`,`room_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains details about Hostel Rooms.';

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE IF NOT EXISTS `student_details` (
  `unique_id` varchar(10) NOT NULL,
  `roll_no` varchar(12) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `class` varchar(10) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `current_year` varchar(2) NOT NULL,
  `dob` date NOT NULL,
  `category` varchar(5) NOT NULL,
  `blood_group` varchar(3) NOT NULL,
  `student_mobile` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `father_name` varchar(50) NOT NULL,
  `father_mobile` varchar(20) NOT NULL,
  `mother_name` varchar(50) NOT NULL,
  `mother_mobile` varchar(20) DEFAULT NULL,
  `permanent_address` varchar(200) NOT NULL,
  `alternate_address` varchar(200) DEFAULT NULL,
  `landline` varchar(25) DEFAULT NULL,
  `photo` varchar(100) NOT NULL,
  `room_no` char(6) DEFAULT NULL,
  PRIMARY KEY (`roll_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains Student''s personal details';

-- --------------------------------------------------------

--
-- Table structure for table `complaint_details`
--

CREATE TABLE IF NOT EXISTS `complaint_details` (
  `email` varchar(50) NOT NULL,
  `complaint_id` varchar(10) NOT NULL,
  `complaint` varchar(500) NOT NULL,
  `name` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`complaint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains complaint details';

-- --------------------------------------------------------

--
-- Table structure for table `allotment_status`
--

CREATE TABLE IF NOT EXISTS `allotment_status` (
  `process_status` enum('ENABLED','DISABLED') NOT NULL COMMENT 'Status of allotment process.',
  `message` varchar(200) NOT NULL COMMENT 'Message to be displayed if allotment disabled.',
  `show_message` enum('SHOW','HIDE') NOT NULL COMMENT 'Whether to to show global message or not.',
  `login_status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'DISABLED',
  `login_message` varchar(500) NOT NULL,
  PRIMARY KEY (`process_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains status about allotment process.';

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

CREATE TABLE IF NOT EXISTS `developers` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL COMMENT 'Developer name.',
  `email` varchar(50) NOT NULL COMMENT 'Developers email id.',
  `mobile` varchar(20) NOT NULL COMMENT 'Developers mobile number.',
  `role` varchar(20) NOT NULL COMMENT 'Developers role.',
  `other_details` varchar(50) NOT NULL COMMENT 'Developers other details.',
  `photo` varchar(100) NOT NULL COMMENT 'Developers photo.',
  PRIMARY KEY (`index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains information about developers.';

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `group_id` varchar(10) NOT NULL,
  `score` varchar(5) NOT NULL,
  `comments` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains feedback from users.';

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`index`, `full_name`, `email`, `mobile`, `role`, `other_details`, `photo`) VALUES
(1, 'Dr. Parteek Bhatia', 'parteek.bhatia@thapar.edu', '09876175046', 'Warden/Mentor', 'https://sites.google.com/site/parteekbhatia/', 'pb.jpg'),
(2, 'Abhinav Acharya', 'abhinavach28@gmail.com', '08437167060', 'Software Developer', 'https://www.facebook.com/Abhinavach28', 'aa.jpg'),
(3, 'Ashutosh Dhundhara', 'ashutoshdhundhara@yahoo.com', '09779749075', 'Software Developer', 'https://facebook.com/ashutosh.dhundhara', 'ad.png'),
(4, 'Ayush Jain', 'ayushjain1992@gmail.com', '09855329177', 'Software Developer', 'https://www.facebook.com/ayush.jain.2312', 'aj.jpg'),
(5, 'Vidhant Maini', 'vidhant_14@hotmail.com', '08191083236', 'Software Developer', 'https://www.facebook.com/vidhant.maini', 'vm.jpg');

--
-- Dumping data for table `allotment_status`
--

INSERT INTO `allotment_status` (`process_status`, `message`, `show_message`, `login_status`, `login_message`) VALUES
('ENABLED', '', '0', 'ENABLED', '');

--
-- Dumping data for table `admin_id`
--

INSERT INTO `admin_id` (`admin_id`, `password`) VALUES
('jadmin', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86');