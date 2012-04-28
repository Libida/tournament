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


    public static function getAllParticipantsSortedByRating($tournament_id)
    {
        $sql = sprintf("SELECT * FROM t_participants WHERE tournament_id=%d", $tournament_id);
        $participants = PMF_DB_Helper::fetchAllResults($sql);
        foreach ($participants as $participant) {
            self::addPlayerToParticipant($participant);
            $participant->name = $participant->player->last_name . " " . $participant->player->first_name;
        }
        usort($participants, 'self::compareByRating');
        return $participants;
    }

    private static function compareByRating($participant_a, $participant_b)
    {
        $retval = $participant_b->rating - $participant_a->rating;
        if ($retval == 0)
            $retval = $participant_b->factor - $participant_a->factor;
        if($retval == 0)
            return strnatcmp($participant_a->name, $participant_b->name);
        return $retval;
    }

    private static function addPlayerToParticipant($participant)
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
        return self::fetchPlayers($sql);
    }

    public static function getAllPlayersForTournament($tournament_id)
    {
        $sql = "SELECT * FROM t_players AS p INNER JOIN t_tournaments_players AS tp ON p.id = tp.player_id WHERE tp.tournament_id = %d";
        $sql = sprintf($sql, $tournament_id);
        return self::fetchPlayers($sql);
    }

    public static function getAllPlayersThatNotInTournament($tournament_id)
    {
        $sql = "select * from t_players where id not in (select player_id from t_tournaments_players where tournament_id = %d)";
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
}
