insert into faqright values (40, 'addtourn', 'Right to add tournaments', 1, 1);
insert into faqright values (41, 'edittourn', 'Right to edit tournaments', 1, 1);
insert into faqright values (42, 'deltourn', 'Right to delete tournaments', 1, 1);

insert into faquser_right values (1, 40);
insert into faquser_right values (1, 41);
insert into faquser_right values (1, 42);

UPDATE faqconfig
SET config_value='Автоматизированная система проведения турниров по шашкам и шахматам'
WHERE config_name='main.metaDescription';

UPDATE faqconfig
SET config_value='Турнир'
WHERE config_name='main.titleFAQ';

DROP TABLE IF EXISTS `t_tournaments`;
CREATE TABLE  `t_tournaments` (
  `id` int(11) NOT NULL,
  `name` varchar(4000) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into faqright values (43, 'addplayer', 'Right to add players', 1, 1);
insert into faqright values (44, 'editplayer', 'Right to edit players', 1, 1);
insert into faqright values (45, 'delplayer', 'Right to delete players', 1, 1);

insert into faquser_right values (1, 43);
insert into faquser_right values (1, 44);
insert into faquser_right values (1, 45);

DROP TABLE IF EXISTS `t_countries`;

CREATE TABLE `t_countries` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=302 ;

--
-- Dumping data for table `country`
--

INSERT INTO `t_countries` (`id`, `name`) VALUES
(1, 'UK'),
(2, 'United States'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Angola'),
(6, 'Anguilla'),
(7, 'Antartica'),
(8, 'Antigua and Barbuda'),
(9, 'Argentina'),
(10, 'Armenia'),
(11, 'Aruba'),
(12, 'Ashmore and Cartier  I'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia and Herzegovina'),
(28, 'Botswana'),
(29, 'Brazil'),
(30, 'British Virgin Islands'),
(31, 'Brunei'),
(32, 'Bulgaria'),
(33, 'Burkina Faso'),
(34, 'Burma'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republ'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Clipperton Island'),
(47, 'Cocos (Keeling) Island'),
(48, 'Colombia'),
(49, 'Comoros'),
(50, 'Congo, Democratic Repu'),
(51, 'Congo, Republic of the'),
(52, 'Cook Islands'),
(53, 'Costa Rica'),
(54, 'Cote d''Ivoire'),
(55, 'Croatia'),
(56, 'Cuba'),
(57, 'Cyprus'),
(58, 'Czeck Republic'),
(59, 'Denmark'),
(60, 'Djibouti'),
(61, 'Dominica'),
(62, 'Dominican Republic'),
(63, 'Ecuador'),
(64, 'Egypt'),
(65, 'El Salvador'),
(66, 'Equatorial Guinea'),
(67, 'Eritrea'),
(68, 'Estonia'),
(69, 'Ethiopia'),
(70, 'Europa Island'),
(71, 'Falkland Islands (Isla'),
(72, 'Faroe Islands'),
(73, 'Fiji'),
(74, 'Finland'),
(75, 'France'),
(76, 'French Guiana'),
(77, 'French Polynesia'),
(78, 'French Southern and An'),
(79, 'Gabon'),
(80, 'Gambia, The'),
(81, 'Gaza Strip'),
(82, 'Georgia'),
(83, 'Germany'),
(84, 'Ghana'),
(85, 'Gibraltar'),
(86, 'Glorioso  Islands'),
(87, 'Greece'),
(88, 'Greenland'),
(89, 'Grenada'),
(90, 'Guadeloupe'),
(91, 'Guam'),
(92, 'Guatemala'),
(93, 'Guernsey'),
(94, 'Guinea'),
(95, 'Guinea-Bissau'),
(96, 'Guyana'),
(97, 'Haiti'),
(98, 'Heard Island and McDon'),
(99, 'Holy See (Vatican City'),
(100, 'Honduras'),
(101, 'Hong  Kong'),
(102, 'Howland Island'),
(103, 'Hungary'),
(104, 'Iceland'),
(105, 'India'),
(106, 'Indonesia'),
(107, 'Iran'),
(108, 'Iraq'),
(109, 'Ireland'),
(110, 'Ireland, Northern'),
(111, 'Israel'),
(112, 'Italy'),
(113, 'Jamaica'),
(114, 'Jan Mayen'),
(115, 'Japan'),
(116, 'Jarvis Island'),
(117, 'Jersey'),
(118, 'Johnston Atoll'),
(119, 'Jordan'),
(120, 'Juan de Nova Island'),
(121, 'Kazakhstan'),
(122, 'Kenya'),
(123, 'Kiribati'),
(124, 'Korea, North'),
(125, 'Korea, South'),
(126, 'Kuwait'),
(127, 'Kyrgyzstan'),
(128, 'Laos'),
(129, 'Latvia'),
(130, 'Lebanon'),
(131, 'Lesotho'),
(132, 'Liberia'),
(133, 'Libya'),
(134, 'Liechtenstein'),
(135, 'Lithuania'),
(136, 'Luxembourg'),
(137, 'Macau'),
(138, 'Macedonia'),
(139, 'Madagascar'),
(140, 'Malawi'),
(141, 'Malaysia'),
(142, 'Maldives'),
(143, 'Mali'),
(144, 'Malta'),
(145, 'Man, Isle of'),
(146, 'Marshall Islands'),
(147, 'Martinique'),
(148, 'Mauritania'),
(149, 'Mauritius'),
(150, 'Mayotte'),
(151, 'Mexico'),
(152, 'Micronesia, Federated'),
(153, 'Midway Islands'),
(154, 'Moldova'),
(155, 'Monaco'),
(156, 'Mongolia'),
(157, 'Montserrat'),
(158, 'Morocco'),
(159, 'Mozambique'),
(160, 'Namibia'),
(161, 'Nauru'),
(162, 'Nepal'),
(163, 'Netherlands'),
(164, 'Netherlands Antilles'),
(165, 'New Caledonia'),
(166, 'New Zealand'),
(167, 'Nicaragua'),
(168, 'Niger'),
(169, 'Nigeria'),
(170, 'Niue'),
(171, 'Norfolk Island'),
(172, 'Northern Mariana Islan'),
(173, 'Norway'),
(174, 'Oman'),
(175, 'Pakistan'),
(176, 'Palau'),
(177, 'Panama'),
(178, 'Papua New Guinea'),
(179, 'Paraguay'),
(180, 'Peru'),
(181, 'Philippines'),
(182, 'Pitcaim Islands'),
(183, 'Poland'),
(184, 'Portugal'),
(185, 'Puerto Rico'),
(186, 'Qatar'),
(187, 'Reunion'),
(188, 'Romainia'),
(189, 'Russia'),
(190, 'Rwanda'),
(191, 'Saint Helena'),
(192, 'Saint Kitts and Nevis'),
(193, 'Saint Lucia'),
(194, 'Saint Pierre and Mique'),
(195, 'Saint Vincent and the'),
(196, 'Samoa'),
(197, 'San Marino'),
(198, 'Sao Tome and Principe'),
(199, 'Saudi Arabia'),
(200, 'Scotland'),
(201, 'Senegal'),
(202, 'Seychelles'),
(203, 'Sierra Leone'),
(204, 'Singapore'),
(205, 'Slovakia'),
(206, 'Slovenia'),
(207, 'Solomon Islands'),
(208, 'Somalia'),
(209, 'South Africa'),
(210, 'South Georgia and the'),
(211, 'Spain'),
(212, 'Spratly Islands'),
(213, 'Sri Lanka'),
(214, 'Sudan'),
(215, 'Suriname'),
(216, 'Svalbard'),
(217, 'Swaziland'),
(218, 'Sweden'),
(219, 'Switzerland'),
(220, 'Syria'),
(221, 'Taiwan'),
(222, 'Tajikistan'),
(223, 'Tanzania'),
(224, 'Thailand'),
(225, 'Tobago'),
(226, 'Toga'),
(227, 'Tokelau'),
(228, 'Tonga'),
(229, 'Trinidad'),
(230, 'Tunisia'),
(231, 'Turkey'),
(232, 'Turkmenistan'),
(233, 'Tuvalu'),
(234, 'Uganda'),
(235, 'Ukraine'),
(236, 'United Arab Emirates'),
(238, 'Uruguay'),
(240, 'Uzbekistan'),
(241, 'Vanuatu'),
(242, 'Venezuela'),
(243, 'Vietnam'),
(244, 'Virgin Islands'),
(245, 'Wales'),
(246, 'Wallis and Futuna'),
(247, 'West Bank'),
(248, 'Western Sahara'),
(249, 'Yemen'),
(250, 'Yugoslavia'),
(251, 'Zambia'),
(252, 'Zimbabwe'),
(253, 'Montenegro'),
(254, 'Serbia'),
(300, 'Afghanistan'),
(301, 'Albania');

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

DROP TABLE IF EXISTS `t_tournaments_players`;
CREATE TABLE  `t_tournaments_players` (
  `tournament_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  PRIMARY KEY (`tournament_id`, `player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `t_tours`;
CREATE TABLE `t_tours` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `tour_index` int(11) NOT NULL,
  `finished` Bool NOT NULL DEFAULT 0,
  PRIMARY KEY (`tournament_id`, `tour_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `t_participants`;
CREATE TABLE  `t_participants` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tournament_id`, `player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `t_games`;
CREATE TABLE  `t_games` (
  `id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `first_participant_id` int(11) NOT NULL,
  `second_participant_id` int(11) NOT NULL,
  `first_paticipant_score` int(11) NOT NULL DEFAULT 0,
  `second_participant_score` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `t_tournaments` ADD COLUMN `started` Bool NOT NULL DEFAULT 0;

insert into faqright values (46, 'editgame', 'Right to edit games score', 1, 1);
insert into faquser_right values (1, 46);

ALTER TABLE `t_games` CHANGE `first_paticipant_score` `first_participant_score` int(11) NOT NULL DEFAULT 0;

ALTER TABLE `t_tournaments` ADD COLUMN `winners_count` int(11) NOT NULL DEFAULT 0;

ALTER TABLE `t_participants` ADD COLUMN `factor` int(11) NOT NULL DEFAULT 0;

ALTER TABLE `t_tournaments` ADD COLUMN `deleted` Bool NOT NULL DEFAULT 0;

ALTER TABLE `t_players` ADD COLUMN `deleted` Bool NOT NULL DEFAULT 0;

ALTER TABLE `t_tournaments` ADD COLUMN `tours_type` int(11) NOT NULL DEFAULT 0;

ALTER TABLE `t_participants` CHANGE `rating` `rating` float NOT NULL DEFAULT 0;

ALTER TABLE `t_tournaments` CHANGE `description` `description` varchar(7000) NOT NULL;

ALTER TABLE `t_participants` CHANGE `factor` `factor` float NOT NULL DEFAULT 0;

ALTER TABLE `t_tournaments` ADD COLUMN `points_system` varchar(20) NOT NULL DEFAULT '2-1-0';
ALTER TABLE `t_tournaments` ADD COLUMN `age_category` varchar(20) NOT NULL DEFAULT '5-10';
ALTER TABLE `t_tournaments` ADD COLUMN `criteria` varchar(30) NOT NULL DEFAULT '';

ALTER TABLE `faqnews` ADD COLUMN `tournament_id` int(11) NOT NULL DEFAULT 0;