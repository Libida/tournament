<?php

class PMF_TournamentRenderer
{
    public static function renderTournamentStandings($tournament_id, $images_root, $headers)
    {
        $tournament = PMF_TournamentService::getById($tournament_id);
        $participants = PMF_Player::getAllParticipantsSorted($tournament_id);

        $html = '<table border="1">';
        $html .= sprintf('<th style="width: 30px;">%s</th>', '№');
        foreach ($headers as $header) {
            $html .= sprintf('<th>%s</th>', $header);
        }
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
            $html .= sprintf("<td style='text-align: center;'><img src='%s/countries/16/%s.png' title='%s'></td>",
                $images_root, $participant->player->country, $participant->player->country_title);
            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->rating);
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}
