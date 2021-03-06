<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}


$tournament_id = $_REQUEST['tourn'];
$tournament = PMF_Tournament_Service::getTournamentById($tournament_id);
$participants = PMF_Tournament_Service::getAllParticipantsSortedByRating($tournament_id);

$html = $tournament->description;

$html .= '<section style="margin-top: 20px;">';
$html .= PMF_Tournament_Renderer::renderTournamentStandings($tournament_id, $PMF_LANG);
$html .= '</section>';

$tours = PMF_Tournament_Service::getTours($tournament_id);
foreach ($tours as $tour) {
    $html .= "<article style='margin-top: 25px;'>";
    $html .= "<header>";
    $html .= sprintf("<h3>%s %d</h3>", $PMF_LANG['tour'], $tour->tour_index);
    $html .= "</header>";
    $html .= "<table class='games' border='0'>";
    foreach ($tour->games as $game) {
        $html .= "<tr>";
        $html .= sprintf("<td><img src='images/countries/16/%s.png'/></td>", $game->first_country);
        $html .= sprintf("<td>%s</td>", $game->first_name);
        $html .= sprintf("<td><div style='padding-left: 10px;'>%s</div></td>", $game->first_participant_score);
        $html .= "<td>:</td>";
        $html .= sprintf("<td><div style='padding-right: 10px;'>%s</div></td>", $game->second_participant_score);
        $html .= sprintf("<td><img src='images/countries/16/%s.png'/></td>", $game->second_country);
        $html .= sprintf("<td>%s</td>", $game->second_name);

        $html .= "<td><div style='padding-left: 15px'> ";
        $html .= "</div></td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
    $html .= "</article>";
}


$news = new PMF_News($db, $Language);

$tpl->parse('writeContent', array(
    "header" => $tournament->name,
    "news_header" => $PMF_LANG['ad_menu_tourn_news'],
    "writeNews" => $news->getNews(false, true, $tournament_id),
    "content" => $html
));
$tpl->merge('writeContent', 'index');
