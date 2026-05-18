DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor` (
  `ID` VARCHAR(50) NOT NULL,
  `Password` VARCHAR(255) NOT NULL,
  `Name` VARCHAR(100) NOT NULL,
  `Department` VARCHAR(100) DEFAULT NULL,
  `Experience` INT(11) DEFAULT NULL,
  `Phone` VARCHAR(20) DEFAULT NULL,
  `Email` VARCHAR(100) NOT NULL,
  `Availability` VARCHAR(50) DEFAULT NULL,
  `TimeFrom` TIME DEFAULT NULL,
  `TimeTo` TIME DEFAULT NULL,
  `status` ENUM('pending','approved') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `Phone` (`Phone`)
) 
