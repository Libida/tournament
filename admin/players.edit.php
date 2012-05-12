<?php
if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>

<header>
    <h2><?php print $PMF_LANG['ad_edit_player_header']; ?></h2>
</header>

<?php
$player_id = $_GET['player'];
$player = PMF_Tournament_PlayerService::getPlayerById($player_id);
if ($permission["addplayer"]) {
    ?>
<form action="?action=updateplayer" method="post">
    <input type="hidden" name="id" value="<?php print $player_id; ?>"/>
    <?php
    require_once 'players.fields.php';
    ?>

    <div class="inputs-block">
        <span class="input-left">
            <label for="deleted"><?php print $PMF_LANG['ad_tournedit_deleted']; ?>:</label>
        </span>
        <span class="input-text">
            <?php
            if ($player->deleted) {
                print '<input id="deleted" name="deleted" type="checkbox" checked="checked"/>';
            } else {
                print '<input id="deleted" name="deleted" type="checkbox" />';
            }
            ?>
        </span>
    </div>

    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG["ad_edit_player_update"]; ?>"/>
    </div>
</form>
<?php
}
?>