DROP TABLE IF EXISTS `disease_priority`;

CREATE TABLE `disease_priority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `disease_name` varchar(100) NOT NULL UNIQUE,
  `priority` enum('high', 'moderate', 'normal') NOT NULL DEFAULT 'normal',
  PRIMARY KEY (`id`)
);

INSERT INTO `disease_priority` (`disease_name`, `priority`) VALUES
('heart pain', 'high'),
('chest pain', 'high'),
('breathing', 'high'),
('accident', 'high'),
('bleeding', 'high'),
('emergency', 'high'),
('stroke', 'high'),
('attack', 'high'),
('fever', 'moderate'),
('vomiting', 'moderate'),
('infection', 'moderate'),
('pain', 'moderate'),
('fracture', 'moderate'),
('injury', 'moderate')
ON DUPLICATE KEY UPDATE `priority` = VALUES(`priority`);
