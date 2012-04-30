<?php
require_once 'PMF_Helper/DBHelper.php';

abstract class PMF_AbstractToursGenerator
{
    public function generateFirstTour($tournament_id)
    {
        $players = PMF_Player::getAllPlayersForTournament($tournament_id);
        $participant_ids = PMF_TournamentService::createParticipantsForTournament($tournament_id, $players);
        $first_tour_id = $this->createFirstTour($tournament_id);
        $this->createGamesForFirstTour($participant_ids, $first_tour_id);
    }

    protected abstract function createGamesForFirstTour($participant_ids, $first_tour_id);

    public abstract function generateNextTour($tournament_id, $winners_count);

    public function getAllParticipantsSortedByRating($tournament_id)
    {
        $sql = sprintf("SELECT * FROM t_participants WHERE tournament_id=%d", $tournament_id);
        $participants = PMF_DB_Helper::fetchAllResults($sql);
        foreach ($participants as $participant) {
            PMF_Player::addPlayerToParticipant($participant);
            $participant->name = $participant->player->last_name . " " . $participant->player->first_name;
        }
        usort($participants, 'self::compareByRating');
        return $participants;
    }

    protected function compareByRating($participant_a, $participant_b)
    {
        $retval = $participant_b->rating - $participant_a->rating;
        if ($retval == 0) {
            $retval = $this->compareWithSameRating($participant_a, $participant_b);
        }
        if($retval == 0)
            $retval = strnatcmp($participant_a->name, $participant_b->name);
        if ($retval == 0)
            return strnatcmp($participant_a->last_name, $participant_b->last_name);
        return $retval;
    }

    protected abstract function compareWithSameRating($participant_a, $participant_b);

    protected function played($participant_a_id, $participant_b_id)
    {
        $games = $this->getAllGames($participant_a_id, $participant_b_id);
        return count($games) > 0;
    }

    protected function getAllGames($participant_a_id, $participant_b_id) {
        $sql = "SELECT * FROM t_games t WHERE (first_participant_id = %d AND second_participant_id = %d) OR (first_participant_id = %d AND second_participant_id = %d)";
        $sql = sprintf($sql, $participant_a_id, $participant_b_id, $participant_b_id, $participant_a_id);
        return PMF_DB_Helper::fetchAllResults($sql);
    }

    public static function getCurrentNumOfTours($tournament_id)
    {
        $sql_count_of_tours = sprintf("SELECT * FROM t_tours WHERE tournament_id=%d", $tournament_id);
        $current_tours_count = count(PMF_DB_Helper::fetchAllResults($sql_count_of_tours));
        return $current_tours_count;
    }

    protected function createFirstTour($tournament_id)
    {
        PMF_TournamentService::deleteAllTours($tournament_id);
        $first_tour_id = $this->createTour($tournament_id, 1);
        return $first_tour_id;
    }

    protected function createTour($tournament_id, $tour_index)
    {
        $sql_delete_tour = sprintf("DELETE FROM t_tours WHERE tournament_id=%d AND tour_index=%d", $tournament_id, $tour_index);
        PMF_Db::getInstance()->query($sql_delete_tour);

        $finished = 0;
        $tour_id = PMF_DB_Helper::createDBInstance("t_tours", array($tournament_id, $tour_index, $finished));
        PMF_TournamentService::deleteAllGamesOfTour($tour_id);
        return $tour_id;
    }


    public function updateParticipantsRating($game)
    {
        $first_score = $game->first_participant_score;
        $second_score = $game->second_participant_score;
        $first_rating = PMF_Player::getParticipantRating($game->first_participant_id);
        $second_rating = PMF_Player::getParticipantRating($game->second_participant_id);
        if ($first_score > $second_score) {
            $first_rating += 2;
            $game->second_participant->factor += 2;
        } else if ($second_score > $first_score) {
            $second_rating += 2;
            $game->first_participant->factor += 2;
        } else {
            $first_rating += 1;
            $game->first_participant->factor += 1;
            $second_rating += 1;
            $game->second_participant->factor += 1;
        }
        $sql_update_rating = "UPDATE t_participants SET rating=%d WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $first_rating, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $second_rating, $game->second_participant_id));
        $sql_update_factor = "UPDATE t_participants SET factor=%d WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $game->first_participant->factor, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $game->second_participant->factor, $game->second_participant_id));
    }
}
