<header>
    <h2><?php print $PMF_LANG['ad_menu_tourn_edit']; ?></h2>
</header>
<?php

if ($permission['edittourn']) {
    print '<ul>';
    foreach (PMF_Tournament_TournamentService::getAllDeletedTournaments() as $tourn) {
        print '<li>';
        printf("<a href='?action=edittournament&amp;tourn=%s' style='margin-right: 7px;'>%s</a>", $tourn->id, $tourn->name);
        print '</li>';
    }
    print '</ul>';
} else {
    print $PMF_LANG['err_NotAuth'];
}
