<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_TournamentService
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
        PMF_Player::makeAllPlayersAttributesReadable($players);
        return $players;
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

    public static function get_all_games($tournament_id)
    {

    }


    public static function create_participants_for_tournament($tournament_id, $players)
    {
        self::delete_all_participants($tournament_id);
        $participant_ids = array();
        foreach ($players as $player) {
            $participant_id = PMF_DB_Helper::createDBInstance("t_participants", array($tournament_id, intval($player->id), 0));
            array_push($participant_ids, $participant_id);
        }
        return $participant_ids;
    }

    public static function delete_all_participants($tournament_id)
    {
        $sql_delete_all_participants = sprintf("DELETE FROM t_participants WHERE tournament_id=%s", $tournament_id);
        PMF_Db::getInstance()->query($sql_delete_all_participants);
    }

    public static function delete_all_tours($tournament_id)
    {
        $sql_delete_all_tours = sprintf("DELETE FROM t_tours WHERE tournament_id=%s", $tournament_id);
        PMF_Db::getInstance()->query($sql_delete_all_tours);
    }

    public static function delete_all_games_of_tour($first_tour_id)
    {
        $sql_remove_all_games_from_first_tour = sprintf("DELETE FROM t_games WHERE tour_id=%s", $first_tour_id);
        PMF_Db::getInstance()->query($sql_remove_all_games_from_first_tour);
    }



    public static function generateTours($tournament_id, $winners_count)
    {
        PMF_SwissTournGenerator::generateTours($tournament_id, $winners_count);
        $sql_set_tournament_started = sprintf("UPDATE t_tournaments SET started=%d WHERE id=%s", 1, $tournament_id);
        PMF_Db::getInstance()->query($sql_set_tournament_started);
    }

    public static function getTours($tournament_id)
    {
        $sql_get_tours = sprintf("SELECT * FROM t_tours WHERE tournament_id=%s ORDER BY tour_index", $tournament_id);
        $tours = PMF_DB_Helper::fetchAllResults($sql_get_tours);
        foreach ($tours as $tour) {
            $tour_id = $tour->id;
            $tour->games = self::getAllGamesForTour($tour_id);
        }
        return $tours;
    }

    private static function getAllGamesForTour($tour_id)
    {
        $sql_select_all_games_for_tour = sprintf("SELECT * FROM t_games WHERE tour_id=%s", $tour_id);
        $games = PMF_DB_Helper::fetchAllResults($sql_select_all_games_for_tour);
        foreach ($games as $game) {
            $first_participant_id = $game->first_participant_id;
            $second_participant_id = $game->second_participant_id;
            $first_participant = PMF_Player::getParticipantById($first_participant_id);
            $second_participant = PMF_Player::getParticipantById($second_participant_id);
            $game->first_participant = $first_participant;
            $game->second_participant = $second_participant;
        }
        return $games;
    }
}
