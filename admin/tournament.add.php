<?php
if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>

<header>
    <h2><?php print $PMF_LANG['ad_tourn_new']; ?></h2>
</header>

<?php
if ($permission["addtourn"]) {
    $tournament = null;
    ?>

<form action="?action=savetournament" method="post">
    <?php require_once 'tournament.fields.php' ?>

    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG["ad_categ_add"]; ?>"/>
    </div>
</form>
<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}
?>