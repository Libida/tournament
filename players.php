<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$players = PMF_Player::getAllPlayers();
require 'common/players.update.values.php';

$html = '<table border="1">';
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
    $html .= sprintf("<td style='text-align: center;'><img src='images/countries/32/%s.png' title='%s'></td>", $player->country, $player->country_title);
    $html .= sprintf("<td>%s</td>", $player->birth_year);
    $html .= sprintf("<td>%s</td>", $player->title);
    $html .= sprintf("<td>%s</td>", $player->rating);
    $html .= sprintf("<td>%s</td>", $player->category);
    $html .= sprintf("<td>%s</td>", $player->degree);
    $html .= '</tr>';
}
$html .= '</table>';

$tpl->parse('writeContent', array(
    "playersTable" => $html
));
$tpl->merge('writeContent', 'index');
