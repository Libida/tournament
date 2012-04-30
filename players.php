<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$players = PMF_Player::getAllPlayers();
require 'common/players.update.values.php';

$header = $PMF_LANG['ad_menu_players'];
$table = PMF_TournamentRenderer::renderPlayersTable($players, $PMF_LANG);

$tpl->parse('writeContent', array(
    "header" => $header,
    "playersTable" => $table
));
$tpl->merge('writeContent', 'index');
