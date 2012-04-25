<?php

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

$tpl->parse('writeContent', array(
    "header" => $PMF_LANG['msgGallery']
));
$tpl->merge('writeContent', 'index');
