<?php

class PMF_Tournament_BergerCriteria extends PMF_Tournament_AbstractCriteria
{
    protected function compare($participant_a, $participant_b)
    {
        return $this->getBergerFactor($participant_b->id) - $this->getBergerFactor($participant_a->id);
    }

    private function getBergerFactor($participant_id)
    {
        $games = $this->getAllGamesForParticipant($participant_id);
        $factor = 0;
        foreach ($games as $game) {
            $first_id = $game->first_participant_id;
            $second_id = $game->second_participant_id;
            $first_score = $game->first_participant_score;
            $second_score = $game->second_participant_score;

            if ($first_id == $participant_id) {
                if ($first_score > $second_score) {
                    $factor += PMF_Tournament_PlayerService::getParticipantRating($second_id);
                } else if ($first_score == $second_score) {
                    $factor += PMF_Tournament_PlayerService::getParticipantRating($second_id) / 2;
                }
            } else if ($second_id == $participant_id) {
                if ($second_score > $first_score) {
                    $factor += PMF_Tournament_PlayerService::getParticipantRating($first_id);
                } else if ($second_score == $first_score) {
                    $factor += PMF_Tournament_PlayerService::getParticipantRating($first_id) / 2;
                }
            }
        }
        return $factor;
    }

    private function getAllGamesForParticipant($participant_id)
    {
        $sql = "SELECT * FROM t_games WHERE first_participant_id = %d OR second_participant_id = %d";
        $sql = sprintf($sql, $participant_id, $participant_id);
        return PMF_Helper_DB::fetchAllResults($sql);
    }
}
