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
    <input type="button" value="<?php print $PMF_LANG['ad_menu_add_player']; ?>" onclick="document.location.href='?action=addplayer';">
</ul>
<?php

if ($permission['editplayer']) {

    if ($action == 'saveplayer') {
        $deleted = 0;
        $player_data = array(
            PMF_Filter::filterInput(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'country', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'birth_year', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'gender', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'rating', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'category', FILTER_SANITIZE_STRING),
            PMF_Filter::filterInput(INPUT_POST, 'degree', FILTER_SANITIZE_STRING),
            $deleted
        );
        $player_id = PMF_Tournament_PlayerService::addPlayer($player_data);
        if ($player_id) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_player_added']);
        } else {
            printf('<p class="alert alert-error">%s</p>', PMF_Db::getInstance()->error());
        }
    }

    if ($action == 'updateplayer') {
        $deleted = $_POST['deleted'] != null ? 1 : 0;
        $id = PMF_Filter::filterInput(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $player_data = array(
            "last_name" => PMF_Filter::filterInput(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING),
            "first_name" => PMF_Filter::filterInput(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING),
            "country_id" => PMF_Filter::filterInput(INPUT_POST, 'country', FILTER_SANITIZE_STRING),
            "birth_year" => PMF_Filter::filterInput(INPUT_POST, 'birth_year', FILTER_SANITIZE_STRING),
            "male" => PMF_Filter::filterInput(INPUT_POST, 'gender', FILTER_SANITIZE_STRING),
            "title_id" => PMF_Filter::filterInput(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
            "rating" => PMF_Filter::filterInput(INPUT_POST, 'rating', FILTER_SANITIZE_STRING),
            "category_id" => PMF_Filter::filterInput(INPUT_POST, 'category', FILTER_SANITIZE_STRING),
            "degree_id" => PMF_Filter::filterInput(INPUT_POST, 'degree', FILTER_SANITIZE_STRING),
            "deleted" => $deleted
        );
        PMF_Tournament_PlayerService::updatePlayer($id, $player_data);
    }

    $players = PMF_Tournament_PlayerService::getAllPlayers();
    require_once '../common/players.update.values.php';
    print PMF_Tournament_Renderer::renderPlayersTable($players, $PMF_LANG, true);

} else {
    print $PMF_LANG['err_NotAuth'];
}
