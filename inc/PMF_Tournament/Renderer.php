<?php

class PMF_Tournament_Renderer
{
    public static function renderTournamentStandings($tournament_id, $PMF_LANG)
    {
        $html = '<table id="standings" class="standings" border="1">';
        $html .= sprintf('<th style="width: 30px;">%s</th>', '№');

        $html .= sprintf('<th>%s</th>', $PMF_LANG['ad_standings_name']);
        $html .= sprintf('<th >%s</th>', $PMF_LANG['ad_player_country']);
        $html .= sprintf('<th>%s</th>', $PMF_LANG['ad_standings_points']);
        $html .= sprintf('<th style="width: 30px;">%s</th>', 'K');
        $html .= sprintf('<th style="width: 30px;">%s</th>', $PMF_LANG['ad_standings_wins']);
        $html .= sprintf('<th style="width: 30px;">%s</th>', $PMF_LANG['ad_standings_loses']);
        $html .= sprintf('<th style="width: 30px;">%s</th>', $PMF_LANG['ad_standings_draws']);
        $tournament = PMF_Tournament_TournamentService::getTournamentById($tournament_id);
        $winners_count = $tournament->winners_count;
        $place = 1;
        $prev_participant = null;
        $participants = PMF_Tournament_TournamentService::getAllParticipantsSortedByRating($tournament_id);
        foreach ($participants as $participant) {
            $html .= '<tr>';
            if ($participant->rating == $prev_participant->rating && $participant->factor == $prev_participant->factor) {
                $place--;
            }
            if ($place <= $winners_count) {
                $html .= sprintf("<td class='winner'><strong>%d</strong></td>", $place++);
                $html .= sprintf("<td class='winner'><strong>%s</strong></td>", $participant->name);
            } else {
                $html .= sprintf("<td>%d</td>", $place++);
                $html .= sprintf("<td>%s</td>", $participant->name);
            }
            $prev_participant = $participant;

            $html .= sprintf("<td style='text-align: center;'><img src='/tournament/images/countries/16/%s.png' title='%s'></td>",
                $participant->player->country, $participant->player->country_title);
            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->rating);
            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->factor);

            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->wins);
            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->loses);
            $html .= sprintf("<td style='text-align: center;'>%s</td>", $participant->draws);
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }

    public static function renderPlayersTable($players, $PMF_LANG, $is_admin_menu = false)
    {
        if (count($players) == 0) {
            return "";
        }
        $html = '<table id="players" border="1">';
        $html .= sprintf("<th>%s</th>", "№");
        $html .= sprintf("<th>%s</th>", $PMF_LANG['ad_player_last_name']);
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
            if ($is_admin_menu) {
                $html .= sprintf('<td><a href="?action=editplayer&amp;player=%s"><img src="/tournament/admin/images/edit.png" width="16" height="16" alt="%s" title="%s" border="0" /></a></td>',
                    $player->id,
                    $PMF_LANG['ad_categ_edit_1'],
                    $PMF_LANG['ad_categ_edit_1']
                );
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}
