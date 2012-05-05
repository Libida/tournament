<?php

class PMF_RoundToursGenerator extends PMF_AbstractToursGenerator
{

    protected function createGamesForFirstTour($participant_ids, $first_tour_id)
    {
        for ($i = 0; $i < count($participant_ids); $i++) {
            for ($j = $i + 1; $j < count($participant_ids); $j++) {
                if (!$this->played($participant_ids[$i], $participant_ids[$j])) {
                    PMF_DB_Helper::createDBInstance("t_games", array($first_tour_id, $participant_ids[$i], $participant_ids[$j], 0, 0));
                }
            }
        }
    }

    public function generateNextTour($tournament_id, $winners_count)
    {
        return;
    }

    protected function compareWithSameRating($participant_a, $participant_b) {
        return $this->getBergerFactor($participant_b->id) - $this->getBergerFactor($participant_a->id);
    }

    private function getBergerFactor($participant_id) {
        $games = $this->getAllGamesForParticipant($participant_id);
        $factor = 0;
        foreach ($games as $game) {
            $first_id = $game->first_participant_id;
            $second_id = $game->second_participant_id;
            $first_score = $game->first_participant_score;
            $second_score = $game->second_participant_score;

            if ($first_id == $participant_id) {
                if ($first_score > $second_score) {
                    $factor += PMF_Player::getParticipantRating($second_id);
                } else if ($first_score == $second_score) {
                    $factor += PMF_Player::getParticipantRating($second_id) / 2;
                }
            } else if ($second_id == $participant_id) {
                if ($second_score > $first_score) {
                    $factor += PMF_Player::getParticipantRating($first_id);
                } else if ($second_score == $first_score) {
                    $factor += PMF_Player::getParticipantRating($first_id) / 2;
                }
            }
        }
        return $factor;
    }

    private function getAllGamesForParticipant($participant_id) {
        $sql = "SELECT * FROM t_games WHERE first_participant_id = %d OR second_participant_id = %d";
        $sql = sprintf($sql, $participant_id, $participant_id);
        return PMF_DB_Helper::fetchAllResults($sql);
    }

    public function updateParticipantsRating($game)
    {
        $first_score = $game->first_participant_score;
        $second_score = $game->second_participant_score;
        $first_rating = PMF_Player::getParticipantRating($game->first_participant_id);
        $second_rating = PMF_Player::getParticipantRating($game->second_participant_id);
        if ($first_score > $second_score) {
            $first_rating += 3;
            $game->second_participant->factor += 3;
        } else if ($second_score > $first_score) {
            $second_rating += 3;
            $game->first_participant->factor += 3;
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
