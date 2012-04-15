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
    ?>
<form class="form-horizontal" action="?action=savetournament" method="post">
    <input type="hidden" name="csrf" value="<?php print $user->getCsrfTokenFromSession(); ?>"/>

    <div class="control-group">
        <label class="control-label" for="name"><?php print $PMF_LANG["ad_categ_titel"]; ?>:</label>

        <div class="controls">
            <input type="text" id="name" name="name" required="required"/>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="description"><?php print $PMF_LANG["ad_categ_desc"]; ?>:</label>

        <div class="controls">
            <textarea id="description" name="description" rows="3" cols="80"></textarea>
        </div>
    </div>

    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG["ad_categ_add"]; ?>"/>
    </div>
</form>
<?php
}
?>