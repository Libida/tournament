<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
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
        $player_id = PMF_Player::addPlayer($player_data);
        if ($player_id) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_player_added']);
        } else {
            printf('<p class="alert alert-error">%s</p>', PMF_Db::getInstance()->error());
        }
    }

    print '<table border="1">';
    printf("<th>%s</th>", $PMF_LANG['ad_player_second_name']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_first_name']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_country']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_birth_year']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_title']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_rating']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_category']);
    printf("<th>%s</th>", $PMF_LANG['ad_player_degree']);
    foreach (PMF_Player::getAllPlayers() as $player) {
        print '<tr>';
        printf("<td>%s</td>", $player->last_name);
        printf("<td>%s</td>", $player->first_name);
        $country_title = $player->country;
        if (isset($PMF_LANG[$country_title])) {
            $country_title = $PMF_LANG[$country_title];
        }
        printf("<td><img src='../images/countries_32/%s.png' title='%s'></td>", $player->country, $country_title);
        printf("<td>%s</td>", $player->birth_year);
        printf("<td>%s</td>", $player->title);
        printf("<td>%s</td>", $player->rating);
        printf("<td>%s</td>", $player->category);
        printf("<td>%s</td>", $player->degree);
        print '</tr>';
    }
print '</table>';

} else {
    print $PMF_LANG['err_NotAuth'];
}
