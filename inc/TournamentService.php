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

    public static function deleteAllGamesOfTour($first_tour_id)
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
            self::updateTourAttributes($tour);
        }
        return $tours;
    }

    public static function updateTourAttributes($tour)
    {
        $tour_id = $tour->id;
        $tour->games = self::getAllGamesForTour($tour_id);
    }

    private static function getAllGamesForTour($tour_id)
    {
        $sql_select_all_games_for_tour = sprintf("SELECT * FROM t_games WHERE tour_id=%s", $tour_id);
        $games = PMF_DB_Helper::fetchAllResults($sql_select_all_games_for_tour);
        foreach ($games as $game) {
            self::updateGameAttributes($game);
        }
        return $games;
    }

    public static function getGameById($gameId) {
        $game = PMF_DB_Helper::getById("t_games", $gameId);
        self::updateGameAttributes($game);
        return $game;
    }

    private static function updateGameAttributes($game)
    {
        $first_participant_id = $game->first_participant_id;
        $second_participant_id = $game->second_participant_id;
        $first_participant = PMF_Player::getParticipantById($first_participant_id);
        $second_participant = PMF_Player::getParticipantById($second_participant_id);

        $game->first_participant = $first_participant;
        $game->second_participant = $second_participant;

        $game->first_country = $game->first_participant->player->country;
        $game->second_country = $game->second_participant->player->country;

        $game->first_name = $game->first_participant->player->last_name . " " . $game->first_participant->player->first_name;
        $game->second_name = $game->second_participant->player->last_name . " " . $game->second_participant->player->first_name;
    }

    public static function getMaxGameScore()
    {
        return 2;
    }

    public static function updateGameScore($game_id, $first_score, $second_score)
    {
        $sql = "UPDATE t_games SET first_participant_score=%d, second_participant_score=%d WHERE id=%d";
        $sql = sprintf($sql, $first_score, $second_score, $game_id);
        PMF_Db::getInstance()->query($sql);
    }

    public static function closeTour($tour_id)
    {
        $tour = PMF_DB_Helper::getById("t_tours", $tour_id);
        if ($tour->finished) {
            return;
        }
        $sql_close_tour = sprintf("UPDATE t_tours SET finished=1 WHERE id=%d", $tour_id);
        PMF_Db::getInstance()->query($sql_close_tour);

        self::updateTourAttributes($tour);
        foreach ($tour->games as $game) {
            PMF_SwissTournGenerator::updateParticipantsRating($game);
        }

        return PMF_SwissTournGenerator::prepareNextTour($tour->tournament_id, 3);
    }
}
