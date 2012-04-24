<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>
<header>
    <h2><?php print $PMF_LANG['ad_menu_tourn_edit']; ?></h2>
</header>
<ul>
    <li><a href="?action=addtournament"><?php print $PMF_LANG['ad_kateg_add']; ?></a></li>
</ul>
<?php

if ($permission['edittourn']) {

    if ($action == 'savetournament') {

        $tournament_data = array(
            PMF_Filter::filterInput(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
            0, 0
        );

        $tournament_id = PMF_TournamentService::addTournament($tournament_data);
        if ($tournament_id) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_tourn_added']);
        } else {
            printf('<p class="alert alert-error">%s</p>', PMF_Db::getInstance()->error());
        }
    }

    if ($action == 'updatetournament') {
        $id = PMF_Filter::filterInput(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $tournament_data = array(
            "name" => PMF_Filter::filterInput(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            "description" => PMF_Filter::filterInput(INPUT_POST, 'description', FILTER_SANITIZE_STRING)
        );
        PMF_TournamentService::updateTournament($id, $tournament_data);
    }

    print '<ul>';
    foreach (PMF_TournamentService::getAllTournaments() as $tourn) {
        print '<li>';
        printf("<a href='?action=edittournament&amp;tourn=%s' style='margin-right: 7px;'>%s</a>", $tourn->id, $tourn->name);

        printf('<a href="?action=deletetournament&amp;tourn=%s"><img src="images/delete.png" width="16" height="16" alt="%s" title="%s" border="0" /></a>&nbsp;',
            $tourn->id,
            $PMF_LANG['ad_categ_delete'],
            $PMF_LANG['ad_categ_delete']
        );
        print '</li>';
    }

    print '</ul>';
} else {
    print $PMF_LANG['err_NotAuth'];
}
