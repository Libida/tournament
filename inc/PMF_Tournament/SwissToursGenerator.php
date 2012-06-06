<?php

class PMF_Tournament_SwissToursGenerator extends PMF_Tournament_AbstractToursGenerator
{
    protected function createGamesForFirstTour($participant_ids, $first_tour_id)
    {
        $first_part_of_participants = array_slice($participant_ids, 0, count($participant_ids) / 2);
        $second_part_of_participants = array_slice($participant_ids, count($participant_ids) / 2);
        $i = 0;
        while ($i <= count($first_part_of_participants) - 1) {
            $this->createGame($first_tour_id, $first_part_of_participants[$i], $second_part_of_participants[$i]);
            $i++;
        }
    }

    protected function createGamesForNextTour($participants, $tour_id)
    {
        for ($i = 0; $i < count($participants); $i++) {
            if (!$participants[$i]->busy) {
                for ($j = $i + 1; $j < count($participants); $j++) {
                    if (!$participants[$j]->busy && !$this->played($participants[$i]->id, $participants[$j]->id)) {
                        $participants[$i]->busy = true;
                        $participants[$j]->busy = true;
                        $this->createGame($tour_id, $participants[$i]->id, $participants[$j]->id);
                        break;
                    }
                }
            }
        }
    }

    protected function getNumOfTours($players_count, $winners_count)
    {
        $numOfTours = log($players_count, 2);
        if ($winners_count > 1) {
            $numOfTours += log($winners_count - 1, 2);
        }
        return intval($numOfTours);
    }
}