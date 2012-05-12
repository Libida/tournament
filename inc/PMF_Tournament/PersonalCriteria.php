<?php

class PMF_Tournament_PersonalCriteria extends PMF_Tournament_AbstractCriteria
{
    protected function compare($participant_a, $participant_b)
    {
        $first_game = $this->getFirstGame($participant_a, $participant_b);
        if ($first_game->first_participant_id == $participant_b->id) {
            return $first_game->second_participant_score - $first_game->first_participant_score;
        } else {
            return $first_game->first_participant_score - $first_game->second_participant_score;
        }
    }

    private function getFirstGame($participant_a, $participant_b)
    {
        $sql = "SELECT * FROM t_games WHERE (first_participant_id = %d and second_participant_id) or (first_participant_id = %d and second_participant_id)";
        $sql = sprintf($sql, $participant_a->id, $participant_b->id, $participant_b->id, $participant_a->id);
        $games = PMF_Helper_DB::fetchAllResults($sql);
        return $games[0];
    }
}
