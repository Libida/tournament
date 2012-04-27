<?php
require_once 'PMF_Helper/DBHelper.php';

class PMF_SwissTournGenerator
{
    public static function generateFirstTour($tournament_id)
    {
        $players = PMF_Player::getAllPlayersForTournament($tournament_id);
        $participant_ids = PMF_TournamentService::createParticipantsForTournament($tournament_id, $players);
        $first_tour_id = self::createFirstTour($tournament_id);
        self::createGamesForFirstTour($participant_ids, $first_tour_id);
    }

    public static function generateNextTour($tournament_id, $winners_count)
    {
        $participants = PMF_Player::getAllParticipantsSortedByRating($tournament_id);

        $current_tours_count = self::getCurrentNumOfTours($tournament_id);
        if ($current_tours_count >= self::getNumOfTours(count($participants), $winners_count)) {
            return;
        }

        $tour_index = $current_tours_count + 1;
        $tour_id = self::createTour($tournament_id, $tour_index);

        for ($i = 0; $i < count($participants); $i++) {
            if (!$participants[$i]->busy) {
                for ($j = $i + 1; $j < count($participants); $j++) {
                    if (!$participants[$j]->busy && !self::played($participants[$i], $participants[$j])) {
                        $participants[$i]->busy = true;
                        $participants[$j]->busy = true;
                        PMF_DB_Helper::createDBInstance("t_games", array($tour_id, $participants[$i]->id, $participants[$j]->id, 0, 0));
                        break;
                    }
                }
            }
        }
    }

    private static function played($participant_a, $participant_b)
    {
        $sql = "SELECT * FROM t_games t WHERE (first_participant_id = %d AND second_participant_id = %d) OR (first_participant_id = %d AND second_participant_id = %d)";
        $sql = sprintf($sql, $participant_a->id, $participant_b->id, $participant_b->id, $participant_a->id);
        $result = PMF_DB_Helper::fetchAllResults($sql);
        return count($result) > 0;
    }

    public static function getCurrentNumOfTours($tournament_id)
    {
        $sql_count_of_tours = sprintf("SELECT * FROM t_tours WHERE tournament_id=%d", $tournament_id);
        $current_tours_count = count(PMF_DB_Helper::fetchAllResults($sql_count_of_tours));
        return $current_tours_count;
    }

    private static function createFirstTour($tournament_id)
    {
        PMF_TournamentService::deleteAllTours($tournament_id);
        $first_tour_id = self::createTour($tournament_id, 1);
        return $first_tour_id;
    }

    private static function createTour($tournament_id, $tour_index)
    {
        $sql_delete_tour = sprintf("DELETE FROM t_tours WHERE tournament_id=%d AND tour_index=%d", $tournament_id, $tour_index);
        PMF_Db::getInstance()->query($sql_delete_tour);

        $finished = 0;
        $tour_id = PMF_DB_Helper::createDBInstance("t_tours", array($tournament_id, $tour_index, $finished));
        PMF_TournamentService::deleteAllGamesOfTour($tour_id);
        return $tour_id;
    }

    private static function createGamesForFirstTour($participant_ids, $first_tour_id)
    {
        $first_part_of_participants = array_slice($participant_ids, 0, count($participant_ids) / 2);
        $second_part_of_participants = array_slice($participant_ids, count($participant_ids) / 2);
        $i = 0;
        while ($i <= count($first_part_of_participants) - 1) {
            PMF_DB_Helper::createDBInstance("t_games", array($first_tour_id, $first_part_of_participants[$i], $second_part_of_participants[$i], 0, 0));
            $i++;
        }
    }

    public static function getNumOfTours($players_count, $winners_count)
    {
        $numOfTours = log($players_count, 2);
        if ($winners_count > 1) {
            $numOfTours += log($winners_count - 1, 2);
        }
        return intval($numOfTours);
    }

    public static function updateParticipantsRating($game)
    {
        $first_score = $game->first_participant_score;
        $second_score = $game->second_participant_score;
        if ($first_score > $second_score) {
            $game->first_participant->rating += 2;
            $game->second_participant->factor += 2;
        } else if ($second_score > $first_score) {
            $game->second_participant->rating += 2;
            $game->first_participant->factor += 2;
        } else {
            $game->first_participant->rating += 1;
            $game->first_participant->factor += 1;
            $game->second_participant->rating += 1;
            $game->second_participant->factor += 1;
        }
        $sql_update_rating = "UPDATE t_participants SET rating=%d WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $game->first_participant->rating, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_rating, $game->second_participant->rating, $game->second_participant_id));
        $sql_update_factor = "UPDATE t_participants SET factor=%d WHERE id=%d";
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $game->first_participant->factor, $game->first_participant_id));
        PMF_Db::getInstance()->query(sprintf($sql_update_factor, $game->second_participant->factor, $game->second_participant_id));
    }
}