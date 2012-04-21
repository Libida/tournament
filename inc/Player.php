<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_Player
{
    public static function getAllCountries()
    {
        return PMF_DB_Helper::get_all_values("t_countries");
    }

    public static function getAllTitles()
    {
        return PMF_DB_Helper::get_all_values("t_titles");
    }

    public static function getAllCategories()
    {
        return PMF_DB_Helper::get_all_values("t_categories");
    }

    public static function getAllDegrees()
    {
        return PMF_DB_Helper::get_all_values("t_degrees");
    }

    public static function addPlayer($player_data)
    {
        return PMF_DB_Helper::create_db_instance("t_players", $player_data);
    }

    public static function getAllPlayers()
    {
        $players = PMF_DB_Helper::get_all_values("t_players");
        self::makePlayersAttributesReadable($players);
        return $players;
    }

    public static function getAllPlayersForTournament($tournament_id)
    {
        $sql = "SELECT * FROM t_players AS p INNER JOIN t_tournaments_players AS tp ON p.id = tp.player_id WHERE tp.tournament_id = %d";
        $sql = sprintf($sql, $tournament_id);
        $result = PMF_Db::getInstance()->query($sql);
        $players = PMF_Db::getInstance()->fetchAll($result);
        self::makePlayersAttributesReadable($players);
        return $players;
    }

    public static function getAllPlayersThatNotInTournament($tournament_id)
    {
        $sql = "select * from t_players where id not in (select player_id from t_tournaments_players where tournament_id = %d)";
        $sql = sprintf($sql, $tournament_id);
        $result = PMF_Db::getInstance()->query($sql);
        $players = PMF_Db::getInstance()->fetchAll($result);
        self::makePlayersAttributesReadable($players);
        return $players;
    }

    private static function makePlayersAttributesReadable($players)
    {
        foreach ($players as $player) {
            $country_id = $player->country_id;
            $player->country = PMF_DB_Helper::get_by_id("t_countries", $country_id)->name;

            $title_id = $player->title_id;
            $player->title = PMF_DB_Helper::get_by_id("t_titles", $title_id)->name;

            $category_id = $player->category_id;
            $player->category = PMF_DB_Helper::get_by_id("t_categories", $category_id)->name;

            $degree_id = $player->degree_id;
            $player->degree = PMF_DB_Helper::get_by_id("t_degrees", $degree_id)->name;
        }
    }
}
