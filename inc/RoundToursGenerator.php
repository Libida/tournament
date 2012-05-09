<?php

class PMF_RoundToursGenerator extends PMF_AbstractToursGenerator
{

    protected function createGamesForFirstTour($participant_ids, $first_tour_id)
    {
        for ($i = 0; $i < count($participant_ids); $i++) {
            for ($j = $i + 1; $j < count($participant_ids); $j++) {
                if (!$this->played($participant_ids[$i], $participant_ids[$j])) {
                    $this->createGame($first_tour_id, $participant_ids[$i], $participant_ids[$j]);
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
}
