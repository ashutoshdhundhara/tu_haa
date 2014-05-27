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
  `password` varchar(50) NOT NULL,
  `allotment_status` varchar(20) NOT NULL DEFAULT 'DISABLED',
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
  `allotment_status` varchar(20) NOT NULL DEFAULT 'NOT_ALLOTED',
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
  `process_status` enum('ENABLED','DISABLED','','') NOT NULL COMMENT 'Status of allotment process.',
  `message` varchar(200) NOT NULL COMMENT 'Message to be displayed if allotment disabled.',
  `show_message` enum('0','1','','') NOT NULL COMMENT 'Whether to to show global message or not.',
  PRIMARY KEY (`process_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains status about allotment process.'