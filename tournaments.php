<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$html = '<ul id="tournaments" style="font-size: 15px;">';
foreach (PMF_Tournament_TournamentService::getAllTournaments() as $tourn) {
    $html .= '<li>';
    $html .= sprintf("<a href='?action=tournview&amp;tourn=%s'>%s</a>", $tourn->id, $tourn->name);
    $html .= '</li>';
}
$html .= '</ul>';

$tpl->parse('writeContent', array(
    "header" => $PMF_LANG['ad_menu_tourn_edit'],
    "tournaments" => $html
));
$tpl->merge('writeContent', 'index');
