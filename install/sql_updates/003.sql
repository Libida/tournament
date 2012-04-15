DROP TABLE IF EXISTS `t_tournaments`;
CREATE TABLE  `t_tournaments` (
  `id` int(11) NOT NULL,
  `name` varchar(4000) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;