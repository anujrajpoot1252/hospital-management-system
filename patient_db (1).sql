

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `patient` (
  `Name` text NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Age` int(3) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `Weight` varchar(5) NOT NULL,
  `Blood_group` varchar(4) NOT NULL,
  `disease` text NOT NULL,
  `medical_history` text NOT NULL,
  `gender` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;


