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
  `allotment_status` varchar(20) NOT NULL DEFAULT 'DISABLED'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains Admin credentials.';

-- --------------------------------------------------------

--
-- Table structure for table `eligible_students`
--

CREATE TABLE IF NOT EXISTS `eligible_students` (
  `roll_no` varchar(12) NOT NULL,
  `full_name` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains list of students eligible for Hostel-J.';

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE IF NOT EXISTS `group_details` (
  `roll_no` varchar(12) NOT NULL,
  `unique_id` varchar(10) NOT NULL,
  `group_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains details about Groups formed.';

-- --------------------------------------------------------

--
-- Table structure for table `group_id`
--

CREATE TABLE IF NOT EXISTS `group_id` (
  `group_id` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `group_size` varchar(2) NOT NULL,
  `allotment_status` varchar(20) NOT NULL DEFAULT 'NOT_ALLOTED'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains credentials of Groups formed.';

-- --------------------------------------------------------

--
-- Table structure for table `rooms_info`
--

CREATE TABLE IF NOT EXISTS `rooms_info` (
  `room_no` varchar(10) NOT NULL,
  `room_status` varchar(20) NOT NULL DEFAULT 'AVAILABLE',
  `group_id` varchar(10) NOT NULL
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
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contains Student''s personal details';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_id`
--
ALTER TABLE `admin_id`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `eligible_students`
--
ALTER TABLE `eligible_students`
 ADD PRIMARY KEY (`roll_no`);

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
 ADD PRIMARY KEY (`roll_no`), ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indexes for table `group_id`
--
ALTER TABLE `group_id`
 ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `rooms_info`
--
ALTER TABLE `rooms_info`
 ADD PRIMARY KEY (`room_no`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
 ADD PRIMARY KEY (`roll_no`);
