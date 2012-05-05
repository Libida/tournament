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

    public static function updatePlayer($id, $player_data)
    {
        PMF_DB_Helper::updateItem("t_players", $id, $player_data);
    }

    public static function getParticipantById($participant_id)
    {
        $participant = PMF_DB_Helper::getById("t_participants", $participant_id);
        self::addPlayerToParticipant($participant);
        return $participant;
    }

    private static function compareByRating($player_a, $player_b)
    {
        $retval = $player_b->rating - $player_a->rating;
        if ($retval == 0)
            return strnatcmp($player_a->last_name, $player_b->last_name);
        return $retval;
    }

    public static function addPlayerToParticipant($participant)
    {
        $player_id = $participant->player_id;
        $player = self::getPlayerById($player_id);
        $participant->player = $player;
    }

    public static function getPlayerById($player_id)
    {
        $player = PMF_DB_Helper::getById("t_players", $player_id);
        self::makePlayerAttributesReadable($player);
        return $player;
    }

    public static function getAllPlayers()
    {
        $sql = "SELECT * FROM t_players WHERE deleted=0";
        $players = self::fetchPlayers($sql);
        usort($players, 'self::compareByRating');
        return $players;
    }

    public static function getAllPlayersForTournament($tournament_id)
    {
        $sql = "SELECT * FROM t_players AS p INNER JOIN t_tournaments_players AS tp ON p.id = tp.player_id WHERE tp.tournament_id = %d";
        $sql = sprintf($sql, $tournament_id);
        $players = self::fetchPlayers($sql);
        usort($players, 'self::compareByRating');
        return $players;
    }

    public static function getAllPlayersThatNotInTournament($tournament_id)
    {
        $sql = "SELECT * FROM t_players WHERE id NOT IN (SELECT player_id FROM t_tournaments_players WHERE tournament_id = %d) AND deleted=0";
        $sql = sprintf($sql, $tournament_id);
        return self::fetchPlayers($sql);
    }

    private static function fetchPlayers($sql)
    {
        $players = PMF_DB_Helper::fetchAllResults($sql);
        self::makeAllPlayersAttributesReadable($players);
        return $players;
    }

    public static function makeAllPlayersAttributesReadable($players)
    {
        foreach ($players as $player) {
            self::makePlayerAttributesReadable($player);
        }
    }

    public static function makePlayerAttributesReadable($player)
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

    public static function getParticipantRating($participant_id) {
        $participant = self::getParticipantById($participant_id);
        return $participant->rating;
    }

    public static function getParticipantFactor($participant_id) {
        $participant = self::getParticipantById($participant_id);
        return $participant->factor;
    }
}
