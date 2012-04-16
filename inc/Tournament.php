<?php
require 'PMF_Helper/DBHelper.php';

class PMF_Tournament
{
    const TABLE_NAME = 't_tournaments';

    public static function addTournament(Array $tournament_data)
    {
        return PMF_DB_Helper::createDBInstance(self::TABLE_NAME, $tournament_data);
    }

    public static function getAllTournaments()
    {
        return PMF_DB_Helper::getAllValues(self::TABLE_NAME);
    }

    public static function getById($tourn_id)
    {
        return PMF_DB_Helper::getById(self::TABLE_NAME, $tourn_id);
    }

    public static function updateTournament($id, $data)
    {
        return PMF_DB_Helper::updateItem(self::TABLE_NAME, $id, $data);
    }

}
