<?php


if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$tournament_id = PMF_Filter::filterInput(INPUT_GET, 'tourn', FILTER_VALIDATE_INT, 0);
$add_player_id = PMF_Filter::filterInput(INPUT_GET, 'addplayer', FILTER_VALIDATE_INT, 0);
$remove_player_id = PMF_Filter::filterInput(INPUT_GET, 'removeplayer', FILTER_VALIDATE_INT, 0);

if ($add_player_id != 0) {
    PMF_Tournament::addPlayerToTournament($tournament_id, $add_player_id);
}

if ($remove_player_id != 0) {
    PMF_Tournament::removePlayerFromTournament($tournament_id, $remove_player_id);
}

if ($permission['edittourn']) {
    $tournament = PMF_Tournament::getById($tournament_id);
    ?>

<header>
    <h2><?php print $PMF_LANG['ad_tournedit_header'] . '&nbsp' . $tournament->name; ?></h2>
</header>

<form class="form-horizontal" action="?action=updatetournament" method="post">
    <input id="tournId" type="hidden" name="id" value="<?php print $tournament_id; ?>" />

    <div class="control-group">
        <label><?php print $PMF_LANG['ad_tournedit_title']; ?>:</label>
        <div class="controls">
            <input type="text" id="name" name="name" value="<?php print $tournament->name; ?>" />
        </div>
    </div>

    <div class="control-group">
        <label><?php print $PMF_LANG['ad_tournedit_desc']; ?>:</label>
        <div class="controls">
            <textarea id="description" name="description" rows="3" cols="80"><?php print $tournament->description ?></textarea>
        </div>
    </div>

    <?php
    $players = PMF_Player::getAllPlayersForTournament($tournament_id);
    require_once '../common/players.update.values.php';
    print '<table border="1">';
    printf("<th>%s</th>", $PMF_LANG['ad_player_second_name']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_first_name']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_country']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_birth_year']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_rating']);
    foreach ($players as $player) {
        print '<tr>';
        printf("<td>%s</td>", $player->last_name);
        printf("<td>%s</td>", $player->first_name);
        printf("<td><img src='../images/countries_32/%s.png' title='%s'></td>", $player->country, $player->country_title);
        printf("<td>%s</td>", $player->birth_year);
        printf("<td>%s</td>", $player->rating);
        print "<td>";
        printf('<a href="?action=edittournament&amp;tourn=%s&removeplayer=%s"><img src="images/delete.png" width="16" height="16" alt="%s" title="%s" border="0" /></a>&nbsp;',
            $tournament_id,
            $player->id,
            $PMF_LANG['ad_categ_delete'],
            $PMF_LANG['ad_categ_delete']
        );
        print "</td>";
        print '</tr>';
    }
    print '</table>';


    $not_in_tournament_players = PMF_Player::getAllPlayersThatNotInTournament($tournament_id);
    ?>

    <div style="margin-top: 15px;">
        <?php print $PMF_LANG['ad_menu_add_player'] . ":"; ?>
        <select id="listOfUsers" onchange='function addPlayer() {
            var tournamentId = $("#tournId").val();
            var newUserId = $("#listOfUsers").val();
            var newUrl = window.location.pathname + "?action=edittournament" + "&tourn=" + tournamentId + "&addplayer=" + newUserId;
            window.location.replace(newUrl);
        }
        addPlayer();'>
            <option></option>
            <?php
            foreach ($not_in_tournament_players as $player) {
                printf("<option value='%d'>%s %s</option>", $player->id, $player->last_name, $player->first_name);
            }
            ?>
        </select>
    </div>


    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG['ad_tournedit_submit']; ?>" />
    </div>
</form>
<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}
