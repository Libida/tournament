<?php

abstract class PMF_Tournament_AbstractToursGenerator
{
    public function generateFirstTour($tournament_id)
    {
        $players = PMF_Tournament_PlayerService::getAllPlayersForTournament($tournament_id);
        $participant_ids = PMF_Tournament_Service::createParticipantsForTournament($tournament_id, $players);
        $first_tour_id = $this->createFirstTour($tournament_id);
        $this->createGamesForFirstTour($participant_ids, $first_tour_id);
    }

    protected abstract function createGamesForFirstTour($participant_ids, $first_tour_id);

    public abstract function generateNextTour($tournament_id, $winners_count);

    public function getAllParticipantsSortedByRating($tournament_id)
    {
        $sql = sprintf("SELECT * FROM t_participants WHERE tournament_id=%d", $tournament_id);
        $participants = PMF_Helper_DB::fetchAllResults($sql);
        foreach ($participants as $participant) {
            PMF_Tournament_PlayerService::addPlayerToParticipant($participant);
            $participant->name = $participant->player->last_name . " " . $participant->player->first_name;
        }
        usort($participants, 'self::compareByRating');
        $this->updateWinsLosesDraws($participants);
        return $participants;
    }

    private function updateWinsLosesDraws($participants)
    {
        foreach ($participants as $participant) {
            $sql_wins = "select * from t_games where (first_participant_id=%d
                            and first_participant_score > second_participant_score) or (second_participant_id=%d and second_participant_score > first_participant_score)";
            $sql_loses = "select * from t_games where (first_participant_id=%d
                            and first_participant_score < second_participant_score) or (second_participant_id=%d and second_participant_score < first_participant_score)";
            $sql_draws = "select * from t_games where (first_participant_id=%d
                            and first_participant_score = second_participant_score) or (second_participant_id=%d and second_participant_score = first_participant_score)";

            $sql_wins = sprintf($sql_wins, $participant->id, $participant->id);
            $sql_loses = sprintf($sql_loses, $participant->id, $participant->id);
            $sql_draws = sprintf($sql_draws, $participant->id, $participant->id);

            $participant->wins = count(PMF_Helper_DB::fetchAllResults($sql_wins));
            $participant->loses = count(PMF_Helper_DB::fetchAllResults($sql_loses));
            $participant->draws = count(PMF_Helper_DB::fetchAllResults($sql_draws));
        }
    }

    protected function compareByRating($participant_a, $participant_b)
    {
        $retval = $participant_b->rating - $participant_a->rating;
        if ($retval == 0) {
            $retval = $this->compareWithSameRating($participant_a, $participant_b);
        }
        if ($retval == 0) {
            $retval = $participant_b->factor - $participant_a->factor;
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
        return PMF_Helper_DB::fetchAllResults($sql);
    }

    public static function getCurrentNumOfTours($tournament_id)
    {
        $sql_count_of_tours = sprintf("SELECT * FROM t_tours WHERE tournament_id=%d", $tournament_id);
        $current_tours_count = count(PMF_Helper_DB::fetchAllResults($sql_count_of_tours));
        return $current_tours_count;
    }

    protected function createFirstTour($tournament_id)
    {
        PMF_Tournament_Service::deleteAllTours($tournament_id);
        $first_tour_id = $this->createTour($tournament_id, 1);
        return $first_tour_id;
    }

    protected function createTour($tournament_id, $tour_index)
    {
        $sql_delete_tour = sprintf("DELETE FROM t_tours WHERE tournament_id=%d AND tour_index=%d", $tournament_id, $tour_index);
        PMF_Db::getInstance()->query($sql_delete_tour);

        $finished = 0;
        $tour_id = PMF_Helper_DB::createDBInstance("t_tours", array($tournament_id, $tour_index, $finished));
        PMF_Tournament_Service::deleteAllGamesOfTour($tour_id);
        return $tour_id;
    }

    public function updateParticipantsRating($game, $points_for_win, $points_for_draw)
    {
        $first_score = $game->first_participant_score;
        $second_score = $game->second_participant_score;
        if ($first_score == 0 && $second_score == 0) {
            return;
        }
        $first_rating = PMF_Tournament_PlayerService::getParticipantRating($game->first_participant_id);
        $second_rating = PMF_Tournament_PlayerService::getParticipantRating($game->second_participant_id);
        $first_factor = PMF_Tournament_PlayerService::getParticipantFactor($game->first_participant_id);
        $second_factor = PMF_Tournament_PlayerService::getParticipantFactor($game->second_participant_id);
        if ($first_score > $second_score) {
            $first_rating += $points_for_win;
            $second_factor += $points_for_win;
        } else if ($second_score > $first_score) {
            $second_rating += $points_for_win;
            $first_factor += $points_for_win;
        } else {
            $first_rating += $points_for_draw;
            $first_factor += $points_for_draw;
            $second_rating += $points_for_draw;
            $second_factor += $points_for_draw;
        }
        $sql_update_rating = "UPDATE t_participants SET rating=%f WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $first_rating, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $second_rating, $game->second_participant_id));
        $sql_update_factor = "UPDATE t_participants SET factor=%f WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $first_factor, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $second_factor, $game->second_participant_id));
    }

    public function createGame($tour_id, $first_participant_id, $second_participant_id)
    {
        PMF_Helper_DB::createDBInstance("t_games", array($tour_id, $first_participant_id, $second_participant_id, 0, 0));
    }
}
