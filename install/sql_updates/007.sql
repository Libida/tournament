DROP TABLE IF EXISTS `t_tournaments_players`;
CREATE TABLE  `t_tournaments_players` (
  `tournament_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  PRIMARY KEY (`tournament_id`, `player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;