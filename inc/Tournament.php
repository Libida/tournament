<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_Tournament
{
    const TABLE_NAME = 't_tournaments';



    public static function addTournament(Array $tournament_data)
    {
        return PMF_DB_Helper::create_db_instance(self::TABLE_NAME, $tournament_data);
    }

    public static function getAllTournaments()
    {
        return PMF_DB_Helper::get_all_values(self::TABLE_NAME);
    }

    public static function getById($tourn_id)
    {
        return PMF_DB_Helper::get_by_id(self::TABLE_NAME, $tourn_id);
    }

    public static function updateTournament($id, $data)
    {
        return PMF_DB_Helper::update_item(self::TABLE_NAME, $id, $data);
    }

    public static function addPlayerToTournament($tournament_id, $add_player_id)
    {
        $sql = "INSERT INTO t_tournaments_players VALUES(%s, %s)";
        $sql = sprintf($sql, $tournament_id, $add_player_id);
        PMF_Db::getInstance()->query($sql);
    }

    public static function removePlayerFromTournament($tournament_id, $remove_player_id)
    {
        $sql = "DELETE FROM t_tournaments_players WHERE tournament_id=%s AND player_id=%s";
        $sql = sprintf($sql, $tournament_id, $remove_player_id);
        PMF_Db::getInstance()->query($sql);
    }
}
