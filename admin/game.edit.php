<script type="text/javascript">
    $(document).ready(function() {
        $("#saveButton").live('click', function() {
            var gameId = $("#gameId").val();
            var firstScore = $(".first").val();
            var secondScore = $(".second").val();
            var tournamentId = $("#tournamentId").val();
            window.location.replace(window.location.pathname + "?action=edittournament&game=" +
                gameId + "&first=" + firstScore + "&second=" + secondScore + "&tourn=" + tournamentId);
            return false;
        });
    });
</script>

<?php


if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

function printScoreOptions($selected_value)
{
    $i = 0;
    while ($i <= PMF_TournamentService::getMaxGameScore()) {
        if ($selected_value == $i) {
            printf("<option value='%d' selected='selected'>%d</option>", $i, $i);
        } else {
            printf("<option value='%d'>%d</option>", $i, $i);
        }
        $i++;
    }
}

if ($permission['editgame']) {
    $game_id = PMF_Filter::filterInput(INPUT_GET, 'game', FILTER_VALIDATE_INT, 0);
    $game = PMF_TournamentService::getGameById($game_id);
    ?>

<header>
    <h2><?php print $PMF_LANG['ad_editgame_header']?></h2>
</header>

<form class="form-horizontal" action="<?php print $_SERVER['HTTP_REFERER']; ?>" method="post">
    <input type="hidden" id="tournamentId" value="<?php print $game->first_participant->tournament_id; ?>"/>
    <input type="hidden" id="gameId" value="<?php print $game_id; ?>"/>
    <input type="hidden" id="fromURL" value="<?php print $_SERVER['HTTP_REFERER']; ?>"/>
    <table border="0" width="100%">
        <tr>
            <td>
                <div style="text-align: right;"><?php printf("<img src='../images/countries/48/%s.png'/>", $game->first_country); ?></div>
            </td>
            <td>
                <div style="text-align: left; font-size: 25px;"><strong><?php print $game->first_name; ?></strong></div>
            </td>
            <td>
                <div style="text-align: right;">
                    <select class="select-game-score first">
                        <?php
                        printScoreOptions($game->first_participant_score);
                        ?>
                    </select>
                </div>
            </td>
            <td><div style="fonst-size: 25px; text-align: center;"><strong>-</strong></div></td>
            <td>
                <div style="text-align: left;">
                    <select class="select-game-score second">
                        <?php
                        printScoreOptions($game->second_participant_score);
                        ?>
                    </select>
                </div>
            </td>
            <td>
                <div style="text-align: right; font-size: 25px;"><strong><?php print $game->second_name; ?></strong></div>
            </td>
            <td>
                <div style="text-align: left;"><?php printf("<img src='../images/countries/48/%s.png'/>", $game->second_country); ?></div>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <input id="saveButton" class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG['ad_editgame_save']; ?>"/>
    </div>
</form>
<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}
