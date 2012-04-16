<?php


if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

if ($permission['edittourn']) {

    $id = PMF_Filter::filterInput(INPUT_GET, 'tourn', FILTER_VALIDATE_INT, 0);
    $tournament = PMF_Tournament::getById($id);
    ?>

<header>
    <h2><?php print $PMF_LANG['ad_tournedit_header'] . '&nbsp' . $tournament->name; ?></h2>
</header>

<form class="form-horizontal" action="?action=updatetournament" method="post">
    <input type="hidden" name="id" value="<?php print $id; ?>" />

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


    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG['ad_tournedit_submit']; ?>" />
    </div>
</form>
<?php
} else {
    print $PMF_LANG['err_NotAuth'];
}
