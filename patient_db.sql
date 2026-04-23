CREATE TABLE `patient` (
  `Name` text NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Age` int(3) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Weight` varchar(5) NOT NULL,
  `height` DECIMAL(10) NOT NULL,
  `Blood_group` varchar(4) NOT NULL,
  `disease` text NOT NULL,
  `medical_history` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` text NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `photo` varchar(500) NOT NULL
)
