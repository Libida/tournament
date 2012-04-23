<?php
foreach ($players as $player) {
    $player->country_title = $player->country;
    if (isset($PMF_LANG[$player->country])) {
        $player->country_title = $PMF_LANG[$player->country];
    }

    if (isset($PMF_LANG[$player->title])) {
        $player->title = $PMF_LANG[$player->title];
    }

    if (isset($PMF_LANG[$player->category])) {
        $player->category = $PMF_LANG[$player->category];
    }

    if (isset($PMF_LANG[$player->degree])) {
        $player->degree = $PMF_LANG[$player->degree];
    }
}