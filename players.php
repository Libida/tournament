<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$players = PMF_Player::getAllPlayers();
require 'common/players.update.values.php';

$html = PMF_TournamentRenderer::renderPlayersTable($players, $PMF_LANG);

$tpl->parse('writeContent', array(
    "playersTable" => $html
));
$tpl->merge('writeContent', 'index');
