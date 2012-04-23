<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_SwissTournGenerator
{
    public static function generateTours($tournament_id, $winners_count)
    {
        $players = PMF_TournamentService::getAllPlayersForTournament($tournament_id);
        self::prepare_first_tour($tournament_id, $players);
    }

    private static function prepare_first_tour($tournament_id, $players)
    {
        $participant_ids = PMF_TournamentService::create_participants_for_tournament($tournament_id, $players);
        $first_tour_id = self::create_first_tour($tournament_id);
        self::create_games_for_first_tour($participant_ids, $first_tour_id);
    }

    private static function create_first_tour($tournament_id)
    {
        PMF_TournamentService::delete_all_tours($tournament_id);
        $tour_index = 1;
        $finished = 0;
        $first_tour_id = PMF_DB_Helper::createDBInstance("t_tours", array($tournament_id, $tour_index, $finished));
        PMF_TournamentService::delete_all_games_of_tour($first_tour_id);
        return $first_tour_id;
    }

    private static function create_games_for_first_tour($participant_ids, $first_tour_id)
    {
        $first_part_of_participants = array_slice($participant_ids, 0, count($participant_ids) / 2);
        $second_part_of_participants = array_slice($participant_ids, count($participant_ids) / 2);
        $i = 0;
        while ($i <= count($first_part_of_participants) - 1) {
            PMF_DB_Helper::createDBInstance("t_games", array($first_tour_id, $first_part_of_participants[$i], $second_part_of_participants[$i], 0, 0));
            $i++;
        }
    }

    public static function getNumOfTours($players, $winners_count)
    {
        $count = count($players) + 2;
        $numOfTours = log($count, 2);
        if ($winners_count > 1) {
            $numOfTours += log($winners_count - 1, 2);
        }
        $numOfTours = intval($numOfTours);
        return $numOfTours;
    }
}