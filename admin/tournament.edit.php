<script type="text/javascript">
    function getCurrentURL() {
        var tournamentId = $("#tournId").val();
        return window.location.pathname + "?action=edittournament" + "&tourn=" + tournamentId;
    }

    function submitAddPlayer() {
        var newUserId = $("#listOfUsers").val();
        window.location.replace(getCurrentURL() + "&addplayer=" + newUserId);
    }

    function submitGenerateTours() {
        window.location.replace(getCurrentURL() + "&generatetours=1");
    }

    $(document).ready(function() {
        $("#listOfUsers").live('change', function() {
            submitAddPlayer()
        });

        $("#generateTours").live('click', function() {
            submitGenerateTours();
        });
    });
</script>

<?php


if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

if ($permission['edittourn']) {
    $tournament_id = PMF_Filter::filterInput(INPUT_GET, 'tourn', FILTER_VALIDATE_INT, 0);
    $tournament = PMF_TournamentService::getById($tournament_id);
    $tournament_started = $tournament->started != 0;

    $add_player_id = PMF_Filter::filterInput(INPUT_GET, 'addplayer', FILTER_VALIDATE_INT, 0);
    $remove_player_id = PMF_Filter::filterInput(INPUT_GET, 'removeplayer', FILTER_VALIDATE_INT, 0);
    $generate_tours = PMF_Filter::filterInput(INPUT_GET, 'generatetours', FILTER_VALIDATE_INT, 0);

    if ($add_player_id != 0) {
        PMF_TournamentService::addPlayerToTournament($tournament_id, $add_player_id);
    }

    if ($remove_player_id != 0) {
        PMF_TournamentService::removePlayerFromTournament($tournament_id, $remove_player_id);
    }

    if ($generate_tours && !$tournament_started) {
        PMF_TournamentService::generateTours($tournament_id, 3);
        $tournament_started = true;
    }
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
    $players = PMF_TournamentService::getAllPlayersForTournament($tournament_id);
    if (count($players) > 0) {
        require_once '../common/players.update.values.php';
        print '<table border="1">';
        printf("<th>%s</th>", "");
        printf("<th>%s</th>", $PMF_LANG['ad_player_second_name']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_first_name']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_country']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_birth_year']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_title']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_rating']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_category']);
        printf("<th>%s</th>", $PMF_LANG['ad_player_degree']);
        $i = 1;
        foreach ($players as $player) {
            print '<tr>';
            printf("<td>%d</td>", $i++);
            printf("<td>%s</td>", $player->last_name);
            printf("<td>%s</td>", $player->first_name);
            printf("<td><img src='../images/countries/16/%s.png' title='%s'></td>", $player->country, $player->country_title);
            printf("<td>%s</td>", $player->birth_year);
            printf("<td>%s</td>", $player->title);
            printf("<td>%s</td>", $player->rating);
            printf("<td>%s</td>", $player->category);
            printf("<td>%s</td>", $player->degree);
            if (!$tournament_started) {
                print "<td>";
                printf('<a href="?action=edittournament&amp;tourn=%s&removeplayer=%s"><img src="images/delete.png" width="16" height="16" alt="%s" title="%s" border="0" /></a>&nbsp;',
                    $tournament_id,
                    $player->id,
                    $PMF_LANG['ad_categ_delete'],
                    $PMF_LANG['ad_categ_delete']
                );
                print "</td>";
            }

            print '</tr>';
        }
        print '</table>';
    }

    $not_in_tournament_players = PMF_TournamentService::getAllPlayersThatNotInTournament($tournament_id);
    ?>
    <?php
    if (!$tournament_started) {
        ?>
        <div style="margin-top: 15px;">
            <?php print $PMF_LANG['ad_menu_add_player'] . ":"; ?>
            <select id="listOfUsers">
                <option></option>
                <?php
                foreach ($not_in_tournament_players as $player) {
                    printf("<option value='%d'>%s %s</option>", $player->id, $player->last_name, $player->first_name);
                }
                ?>
            </select>
            <?php
            if (count($players) >= 8 && count($players) % 2 == 0) {
                ?>
                <input id="generateTours" type="button"
                       value="<?php print $PMF_LANG['ad_tournedit_generate_tours']; ?>"/>
                <?php
            }
            ?>
        </div>
        <?php
    }
    ?>

    <section class="tours">
        <?php
        $tours = PMF_TournamentService::getTours($tournament_id);

        foreach ($tours as $tour) {
            print "<article class='tour'>";
            print "<header>";
            printf("<h3>%s %d</h3>", $PMF_LANG['tour'], $tour->tour_index);
            print "</header>";
            print "<table class='games' border='0'>";
            foreach ($tour->games as $game) {
                print "<tr>";
                printf("<td><img src='../images/countries/16/%s.png'</td>", $game->first_participant->player->country);
                printf("<td>%s %s</td>", $game->first_participant->player->last_name, $game->first_participant->player->first_name);
                printf("<td><div style='padding-left: 10px;'>%s</div></td>", $game->first_paticipant_score);
                print "<td>:</td>";
                printf("<td><div style='padding-right: 10px;'>%s</div></td>", $game->second_participant_score);
                printf("<td><img src='../images/countries/16/%s.png'</td>", $game->second_participant->player->country);
                printf("<td>%s %s</td>", $game->second_participant->player->last_name, $game->second_participant->player->first_name);

                print "<td><div style='padding-left: 15px'> ";
                printf('<a href="?action=editgame&amp;game=%s"><img src="images/edit.png" width="16" height="16" alt="%s" title="%s" border="0" /></a>&nbsp;',
                    $game->id,
                    $PMF_LANG['game_edit_score'],
                    $PMF_LANG['game_edit_score']
                );
                print "</div></td>";
                print "</tr>";
            }
            print "</table>";
            print "</article>";
        }
        ?>
    </section>


    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG['ad_tournedit_submit']; ?>" />
    </div>
</form>
<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}
