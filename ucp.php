<?php
/**
 * User Control Panel
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
 * @since     2012-01-12
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

if ($user instanceof PMF_User) {

    $tpl->parse(
        'writeContent',
        array(
            'headerUserControlPanel' => $PMF_LANG['headerUserControlPanel'],
            'userid'                 => $user->getUserId(),
            'msgRealName'            => $PMF_LANG['ad_user_name'],
            'realname'               => $user->getUserData('display_name'),
            'msgEmail'               => $PMF_LANG['msgNewContentMail'],
            'email'                  => $user->getUserData('email'),
            'msgPassword'            => $PMF_LANG['ad_auth_passwd'],
            'msgConfirm'             => $PMF_LANG['ad_user_confirm'],
            'msgSave'                => $PMF_LANG['msgSave'],
            'msgCancel'              => $PMF_LANG['msgCancel']
        )
    );

    $tpl->merge('writeContent', 'index');
}