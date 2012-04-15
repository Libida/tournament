<?php
/**
 * This is the page there a user can add a FAQ record.
 *
 * PHP Version 5.2.3
 *
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 *
 * @category  phpMyFAQ
 * @package   Frontend
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2012 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2012-02-12
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

if (is_null($error)) {
    $loginMessage = '<p>' . $PMF_LANG['ad_auth_insert'] . '</p>';
} else {
    $loginMessage = '<p class="alert alert-error">' . $error . '</p>';
}

$tpl->parse(
    'writeContent',
    array(
        'registerUser'   => '<a href="?action=register">' . $PMF_LANG['msgRegistration'] . '</a>',
        'sendPassword'   => '<a href="./admin/password.php">' . $PMF_LANG['lostPassword'] . '</a>',
        'loginHeader'    => $PMF_LANG['msgLoginUser'],
        'loginMessage'   => $loginMessage,
        'writeLoginPath' => $systemUri,
        'faqloginaction' => $action,
        'login'          => $PMF_LANG['ad_auth_ok'],
        'username'       => $PMF_LANG['ad_auth_user'],
        'password'       => $PMF_LANG['ad_auth_passwd']
    )
);

$tpl->merge('writeContent', 'index');