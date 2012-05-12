<?php

class PMF_Tournament_TournamentService
{
    const TOURNAMENTS_TABLE = 't_tournaments';

    public static function addTournament(Array $tournament_data)
    {
        return PMF_Helper_DB::createDBInstance(self::TOURNAMENTS_TABLE, $tournament_data);
    }

    public static function getAllTournaments()
    {
        $result = PMF_Db::getInstance()->query(sprintf("SELECT * FROM %s WHERE deleted=0", self::TOURNAMENTS_TABLE));
        return PMF_Db::getInstance()->fetchAll($result);
    }

    public static function getAllDeletedTournaments()
    {
        $result = PMF_Db::getInstance()->query(sprintf("SELECT * FROM %s WHERE deleted=1", self::TOURNAMENTS_TABLE));
        return PMF_Db::getInstance()->fetchAll($result);
    }

    public static function getById($tourn_id)
    {
        return PMF_Helper_DB::getById(self::TOURNAMENTS_TABLE, $tourn_id);
    }

    public static function updateTournament($id, $data)
    {
        PMF_Helper_DB::updateItem(self::TOURNAMENTS_TABLE, $id, $data);
    }

    public static function deleteTournament($tournament_id)
    {
        $sql = sprintf("UPDATE t_tournaments SET deleted=1 WHERE id=%d", $tournament_id);
        PMF_Db::getInstance()->query($sql);
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

    public static function createParticipantsForTournament($tournament_id, $players)
    {
        self::deleteAllParticipants($tournament_id);
        $participant_ids = array();
        foreach ($players as $player) {
            $participant_id = PMF_Helper_DB::createDBInstance("t_participants", array($tournament_id, intval($player->id), 0, 0));
            array_push($participant_ids, $participant_id);
        }
        return $participant_ids;
    }

    public static function deleteAllParticipants($tournament_id)
    {
        $sql_delete_all_participants = sprintf("DELETE FROM t_participants WHERE tournament_id=%s", $tournament_id);
        PMF_Db::getInstance()->query($sql_delete_all_participants);
    }

    public static function deleteAllTours($tournament_id)
    {
        $sql_delete_all_tours = sprintf("DELETE FROM t_tours WHERE tournament_id=%s", $tournament_id);
        PMF_Db::getInstance()->query($sql_delete_all_tours);
    }

    public static function deleteAllGamesOfTour($first_tour_id)
    {
        $sql_remove_all_games_from_first_tour = sprintf("DELETE FROM t_games WHERE tour_id=%s", $first_tour_id);
        PMF_Db::getInstance()->query($sql_remove_all_games_from_first_tour);
    }

    public static function generateTours($tournament_id, $winners_count, $tours_type)
    {
        $sql_update_tournament = "UPDATE t_tournaments SET started=%d, winners_count=%d, tours_type=%d WHERE id=%s";
        $sql_update_tournament = sprintf($sql_update_tournament, 1, $winners_count, $tours_type, $tournament_id);
        PMF_Db::getInstance()->query($sql_update_tournament);
        self::getToursGenerator($tournament_id)->generateFirstTour($tournament_id, $winners_count);
    }

    public static function getTours($tournament_id)
    {
        $sql_get_tours = sprintf("SELECT * FROM t_tours WHERE tournament_id=%s ORDER BY tour_index", $tournament_id);
        $tours = PMF_Helper_DB::fetchAllResults($sql_get_tours);
        foreach ($tours as $tour) {
            self::addGamesObjectsToTour($tour);
        }
        return $tours;
    }

    private static function addGamesObjectsToTour($tour)
    {
        $tour_id = $tour->id;
        $tour->games = self::getAllGamesForTour($tour_id);
    }

    private static function getAllGamesForTour($tour_id)
    {
        $sql_select_all_games_for_tour = sprintf("SELECT * FROM t_games WHERE tour_id=%s", $tour_id);
        $games = PMF_Helper_DB::fetchAllResults($sql_select_all_games_for_tour);
        foreach ($games as $game) {
            self::updateGameAttributes($game);
        }
        return $games;
    }

    public static function getGameById($gameId) {
        $game = PMF_Helper_DB::getById("t_games", $gameId);
        self::updateGameAttributes($game);
        return $game;
    }

    private static function updateGameAttributes($game)
    {
        $first_participant_id = $game->first_participant_id;
        $second_participant_id = $game->second_participant_id;
        $first_participant = PMF_Tournament_Player::getParticipantById($first_participant_id);
        $second_participant = PMF_Tournament_Player::getParticipantById($second_participant_id);

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

    public static function closeTourAndGenerateNext($tournament_id, $tour_id)
    {
        $tour = PMF_Helper_DB::getById("t_tours", $tour_id);
        if ($tour->finished) {
            return;
        }
        $sql_close_tour = sprintf("UPDATE t_tours SET finished=1 WHERE id=%d", $tour_id);
        PMF_Db::getInstance()->query($sql_close_tour);

        $tournament = PMF_Helper_DB::getById(self::TOURNAMENTS_TABLE, $tournament_id);
        self::getToursGenerator($tournament_id)->generateNextTour($tour->tournament_id, $tournament->winners_count);
    }

    public static function updateStandings($tournament_id)
    {
        $games = self::getAllGamesForTournament($tournament_id);
        $points_system = split('-', self::getById($tournament_id)->points_system);
        $points_for_win = $points_system[0];
        $points_for_draw = $points_system[1];

        self::resetStandings($tournament_id);
        foreach ($games as $game) {
            self::getToursGenerator($tournament_id)->updateParticipantsRating($game, $points_for_win, $points_for_draw);
        }
    }

    private static function getAllGamesForTournament($tournament_id)
    {
        $sql = "SELECT * FROM t_games g INNER JOIN t_tours t ON g.tour_id=t.id WHERE t.tournament_id=%s";
        $sql = sprintf($sql, $tournament_id);
        return PMF_Helper_DB::fetchAllResults($sql);
    }

    private static function resetStandings($tournament_id)
    {
        $sql = sprintf("UPDATE t_participants SET rating=0, factor=0 WHERE tournament_id=%s", $tournament_id);
        PMF_Db::getInstance()->query($sql);
    }

    private static function getToursGenerator($tournament_id)
    {
        $tournament = PMF_Helper_DB::getById(self::TOURNAMENTS_TABLE, $tournament_id);
        $tours_type = $tournament->tours_type;
        if ($tours_type == 0) {
            return new PMF_Tournament_SwissToursGenerator();
        }
        if ($tours_type == 1) {
            return new PMF_Tournament_RoundToursGenerator();
        }
    }

    public static function getAllParticipantsSortedByRating($tournament_id) {
        return self::getToursGenerator($tournament_id)->getAllParticipantsSortedByRating($tournament_id);
    }

    public static function addGame($tournament_id, $tour_id, $first_participant_id, $second_participant_id)
    {
        self::getToursGenerator($tournament_id)->createGame($tour_id, $first_participant_id, $second_participant_id);
    }

    public static function deleteGame($game_id)
    {
        $sql = sprintf("DELETE FROM t_games WHERE id=%d", $game_id);
        PMF_Db::getInstance()->query($sql);
    }
}
