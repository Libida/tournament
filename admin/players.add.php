<?php
if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>

<header>
    <h2><?php print $PMF_LANG['ad_add_player_header']; ?></h2>
</header>

<?php
if ($permission["addplayer"]) {
    ?>
<form action="?action=saveplayer" method="post">
    <?php
        require_once 'players.fields.php';
    ?>

    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG["ad_categ_add"]; ?>"/>
    </div>
</form>
<?php
}
?>