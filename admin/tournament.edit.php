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
        var winnersCount = $("#winnersCount").val();
        window.location.replace(getCurrentURL() + "&generatetours=" + winnersCount);
    }

    function submitCloseTour() {
        var currentTourIndex = $("#tourIndex").val();
        window.location.replace(getCurrentURL() + "&closetour=" + currentTourIndex);
    }

    $(document).ready(function() {
        $("#listOfUsers").live('change', function() {
            submitAddPlayer()
        });

        $("#generateTours").live('click', function() {
            submitGenerateTours();
        });

        $("#closeTour").live('click', function() {
            submitCloseTour();
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


    $add_player_id = PMF_Filter::filterInput(INPUT_GET, 'addplayer', FILTER_VALIDATE_INT, 0);
    $remove_player_id = PMF_Filter::filterInput(INPUT_GET, 'removeplayer', FILTER_VALIDATE_INT, 0);
    $winners_count = PMF_Filter::filterInput(INPUT_GET, 'generatetours', FILTER_VALIDATE_INT, 0);
    $tour_id_to_close = PMF_Filter::filterInput(INPUT_GET, 'closetour', FILTER_VALIDATE_INT, 0);

    if ($add_player_id != 0) {
        PMF_TournamentService::addPlayerToTournament($tournament_id, $add_player_id);
    }

    if ($remove_player_id != 0) {
        PMF_TournamentService::removePlayerFromTournament($tournament_id, $remove_player_id);
    }

    if ($tour_id_to_close != 0) {
        PMF_TournamentService::closeTour($tournament_id, $tour_id_to_close);
    }

    $tournament = PMF_TournamentService::getById($tournament_id);
    $tournament_started = $tournament->started != 0;
    if ($winners_count && !$tournament_started) {
        PMF_TournamentService::generateTours($tournament_id, $winners_count);
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
    <div class="control-group">
        <label for="deleted"><?php print $PMF_LANG['ad_tournedit_deleted']; ?>:</label>
        <?php
        if ($tournament->deleted) {
            print '<input id="deleted" name="deleted" type="checkbox" checked="checked"/>';
        } else {
            print '<input id="deleted" name="deleted" type="checkbox" />';
        }
        ?>
    </div>
    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG['ad_tournedit_submit']; ?>" />
    </div>
</form>
<div style="width: 75%;">
    <?php
    $players = PMF_Player::getAllPlayersForTournament($tournament_id);
    if (count($players) > 0) {
        require_once '../common/players.update.values.php';
        print '<table border="1"  width="100%">';
        printf("<th>%s</th>", "");
        printf("<th>%s</th>", $PMF_LANG['ad_player_last_name']);
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
            printf("<td style='text-align: center;'><img src='../images/countries/32/%s.png' title='%s'></td>", $player->country, $player->country_title);
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

    $not_in_tournament_players = PMF_Player::getAllPlayersThatNotInTournament($tournament_id);
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
                printf("<input id='generateTours' type='button' value='%s'/>", $PMF_LANG['ad_tournedit_generate_tours']);
                ?>
                <label for="winnersCount" style="display: inline;"><?php print $PMF_LANG['ad_tournedit_generate_tours_winners_count'] . ":"; ?></label>
                <select id="winnersCount" style="width: 50px;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                <?php
            } else {
                printf("<input id='generateTours' type='button' value='%s' disabled='disabled' title='%s'/>",
                    $PMF_LANG['ad_tournedit_generate_tours'], $PMF_LANG['ad_tournedit_generate_tours_disabled']);
            }
            ?>
        </div>
        <?php
    } else {
        $participants = PMF_Player::getAllParticipantsSortedByRating($tournament_id);
        print '<section class="standings">';
        printf('<header><h3>%s</h3></header>', $PMF_LANG['ad_standings']);
        print PMF_TournamentRenderer::renderTournamentStandings($tournament_id, $PMF_LANG);
        print '</section>';
    }
    ?>

    <section class="tours">
        <?php
        $tours = PMF_TournamentService::getTours($tournament_id);

        foreach ($tours as $tour) {
            if (!$tour->finished) {
                print "<article class='tour current'>";
            } else {
                print "<article class='tour'>";
            }
            print "<header>";
            printf("<h3>%s %d</h3>", $PMF_LANG['tour'], $tour->tour_index);
            print "</header>";
            print "<table class='games' border='0'>";
            foreach ($tour->games as $game) {
                print "<tr>";
                printf("<td><img src='../images/countries/16/%s.png'/></td>", $game->first_country);
                printf("<td>%s</td>", $game->first_name);
                printf("<td><div style='padding-left: 10px;'>%s</div></td>", $game->first_participant_score);
                print "<td>:</td>";
                printf("<td><div style='padding-right: 10px;'>%s</div></td>", $game->second_participant_score);
                printf("<td><img src='../images/countries/16/%s.png'/></td>", $game->second_country);
                printf("<td>%s</td>", $game->second_name);

                print "<td><div style='padding-left: 15px'> ";
                if (!$tour->finished) {
                    printf('<a href="?action=editgame&amp;game=%s"><img src="images/edit.png" width="16" height="16" alt="%s" title="%s" border="0" /></a>&nbsp;',
                        $game->id,
                        $PMF_LANG['game_edit_score'],
                        $PMF_LANG['game_edit_score']
                    );
                }
                print "</div></td>";
                print "</tr>";
            }
            print "</table>";
            if (!$tour->finished) {
                printf("<input id='tourIndex' type='hidden' value='%s'/>", $tour->id);
                printf("<input id='closeTour' class='close-tour-button' type='submit' value='%s'/>", $PMF_LANG['ad_tour_close']);
            }
            print "</article>";
        }
        ?>
    </section>
</div>


<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}
