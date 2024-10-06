-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 07:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinhs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstName`, `lastName`, `gender`, `contactNumber`, `status`, `photo`, `email`, `password`) VALUES
(1903172, 'Gideon', 'Cura', 'Male', '09202971529', 'Admin', 'default-profile.png', 'curagideon72@pnc.edu.ph', 'Admin123'),
(1903173, 'Cariel', 'Soriaga', 'Male', '', 'Admin', 'default-profile.png', '', 'Admin123'),
(1903174, 'Alexander', 'Sindingan', 'Male', '', 'Admin', 'default-profile.png', '', 'Admin123'),
(1903175, 'Son', 'Goku', 'Male', '', 'Admin', 'default-profile.png', '', 'Admin12345');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `criterion_id` int(11) NOT NULL,
  `criterion_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`criterion_id`, `criterion_name`) VALUES
(2, 'Time Management'),
(3, 'Evaluation of Students\' Learning'),
(4, 'Communication Skills'),
(5, 'Relationship with Students'),
(6, 'Instruction & Classroom Management');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_percentage`
--

CREATE TABLE `criteria_percentage` (
  `faculty_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  `student_count` int(11) NOT NULL,
  `cumulative_score` decimal(10,0) NOT NULL,
  `criterion_percentage` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_records`
--

CREATE TABLE `evaluation_records` (
  `evaluation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `firstName`, `lastName`, `gender`, `contactNumber`, `status`, `photo`, `email`, `password`) VALUES
(2001, 'John', 'Doe', 'Male', '09283218741', 'Faculty', 'default-profile.png', 'doe_john@gmail.com', 'Faculty123'),
(2002, 'Luke', 'Sanchez', 'Male', '', 'Faculty', 'default-profile.png', '', 'faculty123'),
(2003, 'Dante', 'Ramirez', 'Male', '', 'Faculty', 'default-profile.png', '', 'faculty123'),
(2005, 'Shizuka', 'Nanahoshi', 'Female', '', 'Faculty', 'default-profile.png', '', 'Faculty-123'),
(2006, 'Dante', 'Gulapa', 'Male', '', 'Faculty', 'default-profile.png', '', 'Faculty-123'),
(2008, 'James', 'Smogen', 'Male', '09274893218', 'Faculty', 'default-profile.png', 'smogen_james@gmail.com', 'Faculty123'),
(2009, 'Juan', 'Tamad', 'Male', '09281738174', 'Faculty', '66eba471bf406.png', '', 'JuanTamad123');

-- --------------------------------------------------------

--
-- Table structure for table `gradelevel`
--

CREATE TABLE `gradelevel` (
  `gradeLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradelevel`
--

INSERT INTO `gradelevel` (`gradeLevel`) VALUES
(11),
(12);

-- --------------------------------------------------------

--
-- Table structure for table `overall_results`
--

CREATE TABLE `overall_results` (
  `faculty_id` int(11) NOT NULL,
  `student_count` int(11) NOT NULL,
  `cumulative_score` decimal(10,0) NOT NULL,
  `overall_percentage` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE `questionnaire` (
  `question_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  `criterion_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionnaire`
--

INSERT INTO `questionnaire` (`question_id`, `question`, `criterion_id`, `criterion_name`) VALUES
(13, 'Explains the lessons clearly.', 6, 'Instruction & Classroom Management'),
(14, 'Reviews the past lessons before starting a new one.', 6, 'Instruction & Classroom Management'),
(15, 'Is knowledgeable of the subject matter.', 6, 'Instruction & Classroom Management'),
(19, 'Gives different types of assessment and learning activities that adequately measure the attainment of learning outcomes.', 3, 'Evaluation of Students\' Learning'),
(20, 'Is prompt in checking and returning of assessment and learning activities – quizzes, projects, exams, etc.', 3, 'Evaluation of Students\' Learning'),
(21, 'Gives constructive feedback and criticism of student\'s work and performance. ', 3, 'Evaluation of Students\' Learning'),
(22, 'Speaks clearly, audibly, and confidently.', 4, 'Communication Skills'),
(23, 'Makes the students feel important in online communication.', 4, 'Communication Skills'),
(24, 'Adapts language use to the level of comprehension of the students.', 4, 'Communication Skills'),
(25, 'Is approachable.', 5, 'Relationship with Students'),
(27, 'Is fair and impartial in dealing with students, showing no sign of favoritism, and making students feel equal in his/her eyes.', 5, 'Relationship with Students'),
(28, 'Shows respect for students and invites respect for himself/herself.', 5, 'Relationship with Students'),
(29, 'Gives back graded quizzes, reports, assignments, projects, performance tasks promptly.', 2, 'Time Management'),
(30, 'Starts the class on time.', 2, 'Time Management'),
(31, 'Ends the class on time.', 2, 'Time Management');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `sectionName` varchar(255) NOT NULL,
  `gradeLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `sectionName`, `gradeLevel`) VALUES
(5001, 'Peacock', 11),
(5002, 'Diamond', 11),
(5003, 'Emerald', 11),
(5004, 'Sapphire', 12),
(5005, 'Ruby', 12);

-- --------------------------------------------------------

--
-- Table structure for table `sections_faculties`
--

CREATE TABLE `sections_faculties` (
  `gradeLevel` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections_faculties`
--

INSERT INTO `sections_faculties` (`gradeLevel`, `section_id`, `faculty_id`) VALUES
(11, 5001, 2001),
(11, 5001, 2003),
(11, 5001, 2002),
(12, 5005, 2002),
(12, 5005, 2001),
(11, 5002, 2003),
(11, 5002, 2003);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `gradeLevel` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `sectionName` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `firstName`, `lastName`, `gender`, `address`, `contactNumber`, `gradeLevel`, `section_id`, `sectionName`, `status`, `photo`, `email`, `password`) VALUES
(3002, 'James', 'Dela Cruz', 'Male', '', '', 12, 5005, 'Ruby', 'Student', 'default-profile.png', 'delacruz_james@pnc.edu.ph', 'Student123'),
(3003, 'Ezzo', 'De Veyra', 'Male', '', '', 11, 5002, 'Diamond', 'Student', 'default-profile.png', '', 'Student123'),
(3004, 'Crisostomo', 'Ibarra', 'Male', '', '', 11, 5001, 'Peacock', 'Student', 'default-profile.png', 'ibarra_crisostomo@pnc.edu.ph', 'Admin123'),
(3005, 'Figarland', 'Garling', 'Male', '', '09193799795', 11, 5001, 'Peacock', 'Student', 'default-profile.png', '', 'Student123'),
(3006, 'Jane', 'Doe', 'Female', '', '', 11, 5002, 'Diamond', 'Student', 'default-profile.png', '', 'Student123'),
(3007, 'Jean', 'Gray', 'Female', '', '', 12, 5005, 'Ruby', 'Student', 'default-profile.png', 'gray_jean@gmail.com', 'Student12345');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subjectName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subjectName`) VALUES
(9001, 'Science'),
(9002, 'English'),
(9003, 'Filipino ');

-- --------------------------------------------------------

--
-- Table structure for table `subject_faculties`
--

CREATE TABLE `subject_faculties` (
  `subject_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_faculties`
--

INSERT INTO `subject_faculties` (`subject_id`, `faculty_id`) VALUES
(9002, 2001),
(9003, 2001),
(9001, 2001),
(9003, 2003),
(9001, 2002);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`criterion_id`);

--
-- Indexes for table `criteria_percentage`
--
ALTER TABLE `criteria_percentage`
  ADD KEY `criterion_id` (`criterion_id`);

--
-- Indexes for table `evaluation_records`
--
ALTER TABLE `evaluation_records`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Indexes for table `gradelevel`
--
ALTER TABLE `gradelevel`
  ADD PRIMARY KEY (`gradeLevel`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `criterion_id` (`criterion_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `gradeLevel` (`gradeLevel`);

--
-- Indexes for table `sections_faculties`
--
ALTER TABLE `sections_faculties`
  ADD KEY `section_id` (`section_id`),
  ADD KEY `faculty_id` (`faculty_id`),
  ADD KEY `gradeLevel` (`gradeLevel`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `gradeLevel` (`gradeLevel`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subject_faculties`
--
ALTER TABLE `subject_faculties`
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1903189;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `criterion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `evaluation_records`
--
ALTER TABLE `evaluation_records`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2011;

--
-- AUTO_INCREMENT for table `gradelevel`
--
ALTER TABLE `gradelevel`
  MODIFY `gradeLevel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5006;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3008;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9004;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD CONSTRAINT `questionnaire_ibfk_1` FOREIGN KEY (`criterion_id`) REFERENCES `criteria` (`criterion_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`gradeLevel`) REFERENCES `gradelevel` (`gradeLevel`);

--
-- Constraints for table `sections_faculties`
--
ALTER TABLE `sections_faculties`
  ADD CONSTRAINT `sections_faculties_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `sections_faculties_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `sections_faculties_ibfk_4` FOREIGN KEY (`gradeLevel`) REFERENCES `gradelevel` (`gradeLevel`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections_faculties` (`section_id`),
  ADD CONSTRAINT `student_ibfk_4` FOREIGN KEY (`gradeLevel`) REFERENCES `gradelevel` (`gradeLevel`);

--
-- Constraints for table `subject_faculties`
--
ALTER TABLE `subject_faculties`
  ADD CONSTRAINT `subject_faculties_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `subject_faculties_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
