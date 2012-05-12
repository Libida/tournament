<?php

class PMF_Tournament_RoundToursGenerator extends PMF_Tournament_AbstractToursGenerator
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
    }
}
