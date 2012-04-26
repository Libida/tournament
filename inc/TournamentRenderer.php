<?php

class PMF_TournamentRenderer
{
    public static function renderTournamentStandings($tournament_id, $PMF_LANG)
    {
        $tournament = PMF_TournamentService::getById($tournament_id);
        $participants = PMF_Player::getAllParticipantsSortedByRating($tournament_id);

        $html = '<table id="standings" border="1">';
        $html .= sprintf('<th style="width: 30px;">%s</th>', '№');

        $html .= sprintf('<th>%s</th>', $PMF_LANG['ad_standings_name']);
        $html .= sprintf('<th>%s</th>', $PMF_LANG['ad_player_country']);
        $html .= sprintf('<th>%s</th>', $PMF_LANG['ad_standings_points']);
        $winners_count = $tournament->winners_count;
        $i = 1;
        foreach ($participants as $participant) {
            $html .= '<tr>';
            if ($i <= $winners_count) {
                $html .= sprintf("<td class='winner'><strong>%d</strong></td>", $i);
                $html .= sprintf("<td class='winner'><strong>%s</strong></td>", $participant->name);
            } else {
                $html .= sprintf("<td>%d</td>", $i);
                $html .= sprintf("<td>%s</td>", $participant->name);
            }
            $i++;
            $html .= sprintf("<td style='text-align: center;'><img src='/tournament/images/countries/16/%s.png' title='%s'></td>",
                $participant->player->country, $participant->player->country_title);
            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->rating);
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }

    public static function renderPlayersTable($players, $PMF_LANG)
    {
        $html = '<table id="players" border="1">';
        $html .= sprintf("<th>%s</th>", "№");
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_second_name']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_first_name']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_country']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_birth_year']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_title']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_rating']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_category']);
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_degree']);
        $i = 1;
        foreach ($players as $player) {
            $html .= '<tr>';
            $html .= sprintf("<td>%s</td>", $i++);
            $html .= sprintf("<td>%s</td>", $player->last_name);
            $html .= sprintf("<td>%s</td>", $player->first_name);
            $html .= sprintf("<td style='text-align: center;'><img src='/tournament/images/countries/32/%s.png' title='%s'></td>", $player->country, $player->country_title);
            $html .= sprintf("<td>%s</td>", $player->birth_year);
            $html .= sprintf("<td>%s</td>", $player->title);
            $html .= sprintf("<td>%s</td>", $player->rating);
            $html .= sprintf("<td>%s</td>", $player->category);
            $html .= sprintf("<td>%s</td>", $player->degree);
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}
