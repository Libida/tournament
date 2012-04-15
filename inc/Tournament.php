<?php
require 'PMF_Helper/DBHelper.php';

class PMF_Tournament
{
    public static function addTournament(Array $tournament_data)
    {
        return PMF_DB_Helper::createDBInstance('t_tournaments', $tournament_data);
    }

    public static function getAllTournaments()
    {
        return PMF_DB_Helper::getAllValues('t_tournaments');
    }
}
