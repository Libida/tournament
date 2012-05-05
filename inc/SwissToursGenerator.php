<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_SwissToursGenerator extends PMF_AbstractToursGenerator
{
    protected function createGamesForFirstTour($participant_ids, $first_tour_id)
    {
        $first_part_of_participants = array_slice($participant_ids, 0, count($participant_ids) / 2);
        $second_part_of_participants = array_slice($participant_ids, count($participant_ids) / 2);
        $i = 0;
        while ($i <= count($first_part_of_participants) - 1) {
            PMF_DB_Helper::createDBInstance("t_games", array($first_tour_id, $first_part_of_participants[$i], $second_part_of_participants[$i], 0, 0));
            $i++;
        }
    }

    public function generateNextTour($tournament_id, $winners_count)
    {
        $participants = $this->getAllParticipantsSortedByRating($tournament_id);

        $current_tours_count = $this->getCurrentNumOfTours($tournament_id);
        if ($current_tours_count >= $this->getNumOfTours(count($participants), $winners_count)) {
            return;
        }

        $tour_index = $current_tours_count + 1;
        $tour_id = $this->createTour($tournament_id, $tour_index);

        for ($i = 0; $i < count($participants); $i++) {
            if (!$participants[$i]->busy) {
                for ($j = $i + 1; $j < count($participants); $j++) {
                    if (!$participants[$j]->busy && !$this->played($participants[$i]->id, $participants[$j]->id)) {
                        $participants[$i]->busy = true;
                        $participants[$j]->busy = true;
                        PMF_DB_Helper::createDBInstance("t_games", array($tour_id, $participants[$i]->id, $participants[$j]->id, 0, 0));
                        break;
                    }
                }
            }
        }
    }

    private function getNumOfTours($players_count, $winners_count)
    {
        $numOfTours = log($players_count, 2);
        if ($winners_count > 1) {
            $numOfTours += log($winners_count - 1, 2);
        }
        return intval($numOfTours);
    }

    protected function compareWithSameRating($participant_a, $participant_b)
    {
        return $participant_b->factor - $participant_a->factor;
    }

    public function updateParticipantsRating($game)
    {
        $first_score = $game->first_participant_score;
        $second_score = $game->second_participant_score;
        if ($first_score == 0 && $second_score == 0) {
            return;
        }
        $first_rating = PMF_Player::getParticipantRating($game->first_participant_id);
        $second_rating = PMF_Player::getParticipantRating($game->second_participant_id);
        $first_factor = PMF_Player::getParticipantFactor($game->first_participant_id);
        $second_factor = PMF_Player::getParticipantFactor($game->second_participant_id);
        if ($first_score > $second_score) {
            $first_rating += 3;
            $second_factor += 3;
        } else if ($second_score > $first_score) {
            $second_rating += 3;
            $first_factor += 3;
        } else {
            $first_rating += 1;
            $first_factor += 1;
            $second_rating += 1;
            $second_factor += 1;
        }
        $sql_update_rating = "UPDATE t_participants SET rating=%d WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $first_rating, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $second_rating, $game->second_participant_id));
        $sql_update_factor = "UPDATE t_participants SET factor=%d WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $first_factor, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $second_factor, $game->second_participant_id));
    }
}