<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_Player
{
    public static function getAllCountries()
    {
        return PMF_DB_Helper::getAllValues("t_countries");
    }

    public static function getAllTitles()
    {
        return PMF_DB_Helper::getAllValues("t_titles");
    }

    public static function getAllCategories()
    {
        return PMF_DB_Helper::getAllValues("t_categories");
    }

    public static function getAllDegrees()
    {
        return PMF_DB_Helper::getAllValues("t_degrees");
    }

    public static function addPlayer($player_data)
    {
        return PMF_DB_Helper::createDBInstance("t_players", $player_data);
    }

    public static function getParticipantById($participant_id)
    {
        $participant = PMF_DB_Helper::getById("t_participants", $participant_id);
        $player_id = $participant->player_id;
        $player = self::getPlayerById($player_id);
        $participant->player = $player;
        return $participant;
    }

    public static function getPlayerById($player_id)
    {
        $player = PMF_DB_Helper::getById("t_players", $player_id);
        self::makeOnePlayerAttributesReadable($player);
        return $player;
    }

    public static function getAllPlayers()
    {
        $players = PMF_DB_Helper::getAllValues("t_players");
        self::makeAllPlayersAttributesReadable($players);
        return $players;
    }

    public static function makeAllPlayersAttributesReadable($players)
    {
        foreach ($players as $player) {
            self::makeOnePlayerAttributesReadable($player);
        }
    }

    public static function makeOnePlayerAttributesReadable($player)
    {
        $country_id = $player->country_id;
        $player->country = PMF_DB_Helper::getById("t_countries", $country_id)->name;

        $title_id = $player->title_id;
        $player->title = PMF_DB_Helper::getById("t_titles", $title_id)->name;

        $category_id = $player->category_id;
        $player->category = PMF_DB_Helper::getById("t_categories", $category_id)->name;

        $degree_id = $player->degree_id;
        $player->degree = PMF_DB_Helper::getById("t_degrees", $degree_id)->name;
    }
}
