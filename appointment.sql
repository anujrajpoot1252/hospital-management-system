

CREATE TABLE `appointment` (
  `doctor_id` varchar(50) NOT NULL,
  `patient_email` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `disease` varchar(255) DEFAULT NULL
) 