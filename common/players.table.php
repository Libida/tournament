<?php

require_once 'players.update.values.php';

print '<table border="1">';
printf("<th>%s</th>", $PMF_LANG['ad_player_second_name']);
printf("<th>%s</th>", $PMF_LANG['ad_player_first_name']);
printf("<th>%s</th>", $PMF_LANG['ad_player_country']);
printf("<th>%s</th>", $PMF_LANG['ad_player_birth_year']);
printf("<th>%s</th>", $PMF_LANG['ad_player_title']);
printf("<th>%s</th>", $PMF_LANG['ad_player_rating']);
printf("<th>%s</th>", $PMF_LANG['ad_player_category']);
printf("<th>%s</th>", $PMF_LANG['ad_player_degree']);
foreach ($players as $player) {
    print '<tr>';
    printf("<td>%s</td>", $player->last_name);
    printf("<td>%s</td>", $player->first_name);
    printf("<td><img src='../images/countries_32/%s.png' title='%s'></td>", $player->country, $player->country_title);
    printf("<td>%s</td>", $player->birth_year);
    printf("<td>%s</td>", $player->title);
    printf("<td>%s</td>", $player->rating);
    printf("<td>%s</td>", $player->category);
    printf("<td>%s</td>", $player->degree);
    print '</tr>';
}
print '</table>';