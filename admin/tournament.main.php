<?php
/**
 * List all categories in the admin section
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
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2003-2012 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2003-12-20
 */

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
    <li><a href="?action=showtournament"><?php print $PMF_LANG['ad_categ_show'];?></a></li>
</ul>
<?php

$csrfToken = PMF_Filter::filterInput(INPUT_POST, 'csrf', FILTER_SANITIZE_STRING);
if ('category' != $action && 'content' != $action &&
    (!isset($_SESSION['phpmyfaq_csrf_token']) || $_SESSION['phpmyfaq_csrf_token'] !== $csrfToken)) {
    $permission['editcateg'] = false;
}

if ($permission['edittourn']) {

    // Save a new category
    if ($action == 'savetournament') {

        $tournament = new PMF_Tournament();
        $tournament_data = array(
            'name'        => PMF_Filter::filterInput(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            'description' => PMF_Filter::filterInput(INPUT_POST, 'description', FILTER_SANITIZE_STRING));

        $tournament_id = $tournament->addTournament($tournament_data);
        if ($tournament_id) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_tourn_added']);
        } else {
            printf('<p class="alert alert-error">%s</p>', $db->error());
        }
    }

    // Updates an existing category
    if ($action == 'updatecategory') {

        $category      = new PMF_Category($current_admin_user, $current_admin_groups, false);
        $parent_id     = PMF_Filter::filterInput(INPUT_POST, 'parent_id', FILTER_VALIDATE_INT);
        $category_data = array(
            'id'          => PMF_Filter::filterInput(INPUT_POST, 'id', FILTER_VALIDATE_INT),
            'lang'        => PMF_Filter::filterInput(INPUT_POST, 'catlang', FILTER_SANITIZE_STRING),
            'parent_id'   => $parent_id,
            'name'        => PMF_Filter::filterInput(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            'description' => PMF_Filter::filterInput(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
            'user_id'     => PMF_Filter::filterInput(INPUT_POST, 'user_id', FILTER_VALIDATE_INT));

        $userperm      = PMF_Filter::filterInput(INPUT_POST, 'userpermission', FILTER_SANITIZE_STRING);
        $user_allowed  = ('all' == $userperm) ? -1 : PMF_Filter::filterInput(INPUT_POST, 'restricted_users', FILTER_VALIDATE_INT);
        $groupperm     = PMF_Filter::filterInput(INPUT_POST, 'grouppermission', FILTER_SANITIZE_STRING);
        $group_allowed = ('all' == $groupperm) ? -1 : PMF_Filter::filterInput(INPUT_POST, 'restricted_groups', FILTER_VALIDATE_INT);

        if (!$category->checkLanguage($category_data['id'], $category_data['lang'])) {
            if ($category->addCategory($category_data, $parent_id, $category_data['id']) &&
                $category->addPermission('user', array($category_data['id']), $user_allowed) &&
                $category->addPermission('group', array($category_data['id']), $group_allowed)) {
                printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_categ_translated']);
            } else {
                printf('<p class="alert alert-error">%s</p>', $db->error());
            }
        } else {
            if ($category->updateCategory($category_data)) {
                $category->deletePermission('user', array($category_data['id']));
                $category->deletePermission('group', array($category_data['id']));
                $category->addPermission('user', array($category_data['id']), $user_allowed);
                $category->addPermission('group', array($category_data['id']), $group_allowed);
                printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_categ_updated']);
            } else {
                printf('<p class="alert alert-error">%s</p>', $db->error());
            }
        }

        // All the other translations            
        $languages = PMF_Filter::filterInput(INPUT_POST, 'used_translated_languages', FILTER_SANITIZE_STRING);
        if ($faqconfig->get('main.enableGoogleTranslation') === true && !empty($languages)) {

            $languages     = explode(",", $languages);
            $category_lang = $category_data['lang'];
            $category_id   = $category_data['id'];
            $user_id       = $category_data['user_id'];
            foreach ($languages as $translated_lang) {
                if ($translated_lang == $category_lang) {
                    continue;
                }
                $translated_name        = PMF_Filter::filterInput(INPUT_POST, 'name_translated_' . $translated_lang, FILTER_SANITIZE_STRING);
                $translated_description = PMF_Filter::filterInput(INPUT_POST, 'description_translated_' . $translated_lang, FILTER_SANITIZE_STRING);

                $category_data = array_merge($category_data, array(
                    'id'          => $category_id,
                    'lang'        => $translated_lang,
                    'parent_id'   => $parent_id,
                    'name'        => $translated_name,
                    'description' => $translated_description,
                    'user_id'     => $user_id));

                if (!$category->checkLanguage($category_id, $translated_lang)) {
                    $category->addCategory($category_data, $parent_id, $category_id);
                } else {
                    $category->updateCategory($category_data);
                }
            }
        }
    }

    // Deletes an existing category
    if ($permission['delcateg'] && $action == 'removecategory') {

        $category = new PMF_Category($current_admin_user, $current_admin_groups, false);
        $id         = PMF_Filter::filterInput(INPUT_POST, 'cat', FILTER_VALIDATE_INT);
        $lang       = PMF_Filter::filterInput(INPUT_POST, 'lang', FILTER_SANITIZE_STRING);
        $deleteall  = PMF_Filter::filterInput(INPUT_POST, 'deleteall', FILTER_SANITIZE_STRING);
        $delete_all = strtolower($deleteall) == 'yes' ? true : false;

        if ($category->deleteCategory($id, $lang, $delete_all) &&
            $category->deleteCategoryRelation($id, $lang, $delete_all) &&
            $category->deletePermission('user', array($id)) && $category->deletePermission('group', array($id))) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_categ_deleted']);
        } else {
            printf('<p class="alert alert-error">%s</p>', $db->error());
        }
    }

    // Moves a category
    if ($action == 'changecategory') {

        $category      = new PMF_Category($current_admin_user, $current_admin_groups, false);
        $category_id_1 = PMF_Filter::filterInput(INPUT_POST, 'cat', FILTER_VALIDATE_INT);
        $category_id_2 = PMF_Filter::filterInput(INPUT_POST, 'change', FILTER_VALIDATE_INT);

        if ($category->swapCategories($category_id_1, $category_id_2)) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_categ_updated']);
        } else {
            printf('<p class="alert alert-error">%s<br />%s</p>', $PMF_LANG['ad_categ_paste_error'], $db->error());
        }
    }

    // Pastes a category
    if ($action == 'pastecategory') {

        $category    = new PMF_Category($current_admin_user, $current_admin_groups, false);
        $category_id = PMF_Filter::filterInput(INPUT_POST, 'cat', FILTER_VALIDATE_INT);
        $parent_id   = PMF_Filter::filterInput(INPUT_POST, 'after', FILTER_VALIDATE_INT);
        if ($category->updateParentCategory($category_id, $parent_id)) {
            printf('<p class="alert alert-success">%s</p>', $PMF_LANG['ad_categ_updated']);
        } else {
            printf('<p class="alert alert-error">%s<br />%s</p>', $PMF_LANG['ad_categ_paste_error'], $db->error());
        }
    }

    // If we changed the category tree, unset the object
    if (isset($tournament)) {
        unset($tournament);
    }
    $tournament = new PMF_Tournament();

    print '<ul>';
    foreach ($tournament->getAllTournaments() as $tourn) {
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
