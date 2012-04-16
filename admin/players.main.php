<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>
<header>
    <h2><?php print $PMF_LANG['ad_menu_players']; ?></h2>
</header>
<ul>
    <li><a href="?action=addplayer"><?php print $PMF_LANG['ad_menu_add_player']; ?></a></li>
</ul>
<?php

if ($permission['editplayer']) {

    if ($action == 'saveplayer') {
        $player_data = array(
            PMF_Filter::filterInput(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'country', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'birth_year', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'gender', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'rating', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'category', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'degree', FILTER_SANITIZE_STRING)
        );
    }

    if ($action == 'updatetournament') {
        $id = PMF_Filter::filterInput(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $tournament_data = array(
            "name" => PMF_Filter::filterInput(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            "description" => PMF_Filter::filterInput(INPUT_POST, 'description', FILTER_SANITIZE_STRING)
        );
        PMF_Tournament::updateTournament($id, $tournament_data);
    }

    print '<ul>';
    foreach (PMF_Tournament::getAllTournaments() as $tourn) {
        print '<li>';
        printf("<strong>%s</strong> ", $tourn->name);

        printf('<a href="?action=edittournament&amp;tourn=%s"><img src="images/edit.png" width="16" height="16" border="0" title="%s" alt="%s" /></a>&nbsp;',
            $tourn->id,
            $PMF_LANG['ad_kateg_rename'],
            $PMF_LANG['ad_kateg_rename']
        );


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
