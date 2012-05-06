<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>
<header>
    <h2><?php print $PMF_LANG['ad_menu_tourn_edit']; ?></h2>
</header>
    <input type="button" value="<?php print $PMF_LANG['ad_kateg_add']; ?>" onclick="document.location.href='?action=addtournament';">
<?php

if ($permission['edittourn']) {

    if ($action == 'savetournament') {
        $started = 0;
        $winners_count = 0;
        $deleted = 0;
        $type = 0;
        $tournament_data = array(
            PMF_Filter::filterInput(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            html_entity_decode($_POST['description']),
            $started, $winners_count, $deleted, $type
        );

        $tournament_id = PMF_TournamentService::addTournament($tournament_data);
        if ($tournament_id) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_tourn_added']);
        } else {
            printf('<p class="alert alert-error">%s</p>', PMF_Db::getInstance()->error());
        }
    }

    if ($action == 'deletetournament') {
        $tournament_id = $_GET['tourn'];
        PMF_TournamentService::deleteTournament($tournament_id);
    }

    print '<ul>';
    foreach (PMF_TournamentService::getAllTournaments() as $tourn) {
        print '<li>';
        printf("<a href='?action=edittournament&amp;tourn=%s' style='margin-right: 7px;'>%s</a>", $tourn->id, $tourn->name);
        print '</li>';
    }

    print '</ul>';

    printf('<a href="?action=deletedtournaments">%s</a>', $PMF_LANG['ad_menu_deleted_tourns']);
} else {
    print $PMF_LANG['err_NotAuth'];
}
