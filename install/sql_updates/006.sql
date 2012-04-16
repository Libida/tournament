DROP TABLE IF EXISTS `t_players`;

DROP TABLE IF EXISTS `t_titles`;
CREATE TABLE  `t_titles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `t_titles` (`id`, `name`) VALUES
(1, 'none'),
(2, 'чемпион мира'),
(3, 'чемпион страны');

DROP TABLE IF EXISTS `t_categories`;
CREATE TABLE  `t_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `t_categories` (`id`, `name`) VALUES
(1, 'none'),
(2, '1-й спортивный разряд'),
(3, '2-й спортивный разряд'),
(4, '3-й спортивный разряд');

DROP TABLE IF EXISTS `t_degrees`;
CREATE TABLE  `t_degrees` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `t_degrees` (`id`, `name`) VALUES
(1, 'none'),
(2, 'Мастер спорта международного класса'),
(3, 'Мастер спорта');


CREATE TABLE  `t_players` (
  `id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `country_id` int(11) NOT NULL,
  `birth_year` int(11) NOT NULL,
  `male` Bool NOT NULL,
  `title_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  FOREIGN KEY (country_id) REFERENCES t_countries(id),
  FOREIGN KEY (title_id) REFERENCES t_titles(id),
  FOREIGN KEY (category_id) REFERENCES t_categories(id),
  FOREIGN KEY (degree_id) REFERENCES t_degrees(id),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;