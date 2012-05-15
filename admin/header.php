<?php
/**
 * Header of the admin area
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
 * @package   Administraion
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2003-2012 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2003-02-26
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

header("Expires: Thu, 7 Apr 1977 14:47:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: text/html; charset=utf-8");
header("Vary: Negotiate,Accept");

$secLevelEntries   = '';
$dashboardPage     = true;
$contentPage       = false;
$userPage          = false;
$statisticsPage    = false;
$exportsPage       = false;
$backupPage        = false;
$configurationPage = false;

$adminHelper = PMF_Helper_Administration::getInstance();
$adminHelper->setPermission($permission);

switch ($action) {
    case 'user':
    case 'group':
    case 'passwd':
    case 'cookies':
        $secLevelHeader = $PMF_LANG['admin_mainmenu_users'];
        $secLevelEntries .= $adminHelper->addMenuEntry('adduser+edituser+deluser', 'user', 'ad_menu_user_administration', $action);
        if ($faqconfig->get('security.permLevel') != 'basic') {
            $secLevelEntries .= $adminHelper->addMenuEntry('addgroup+editgroup+delgroup', 'group', 'ad_menu_group_administration', $action);
        }
        $secLevelEntries .= $adminHelper->addMenuEntry('passwd', 'passwd', 'ad_menu_passwd', $action);
        $dashboardPage    = false;
        $userPage         = true;
        break;
    case 'content':
    case 'category':
    case 'addcategory':
    case 'savecategory':
    case 'editcategory':
    case 'translatecategory':
    case 'updatecategory':
    case 'deletecategory':
    case 'removecategory':
    case 'cutcategory':
    case 'pastecategory':
    case 'movecategory':
    case 'changecategory':
    case 'showcategory':
    case 'editentry':
    case 'insertentry':
    case 'view':
    case 'searchfaqs':
    case 'glossary':
    case 'saveglossary':
    case 'updateglossary':
    case 'deleteglossary':
    case 'addglossary':
    case 'editglossary':
    case 'news';
    case 'addnews':
    case 'editnews':
    case 'savenews':
    case 'updatenews';
    case 'delnews':
    case 'question':
    case 'comments':
    case 'attachments':
        $secLevelHeader = $PMF_LANG['admin_mainmenu_content'];
        $secLevelEntries .= $adminHelper->addMenuEntry('delcomment', 'comments', 'ad_menu_comments', $action);
        $secLevelEntries .= $adminHelper->addMenuEntry('addnews+editnews+delnews', 'news', 'ad_menu_news_edit', $action);
        $dashboardPage    = false;
        $contentPage      = true;
        break;
    case 'statistics':
    case 'viewsessions':
    case 'sessionbrowse':
    case 'sessionsuche':
    case 'adminlog':
    case 'searchstats':
    case 'reports':
    case 'reportview':
        $secLevelHeader   = $PMF_LANG['admin_mainmenu_statistics'];
        $secLevelEntries .= $adminHelper->addMenuEntry('viewlog', 'viewsessions', 'ad_menu_session', $action);
        $secLevelEntries .= $adminHelper->addMenuEntry('viewlog', 'searchstats', 'ad_menu_searchstats', $action);
        $secLevelEntries .= $adminHelper->addMenuEntry('reports', 'reports', 'ad_menu_reports', $action);
        $dashboardPage    = false;
        $statisticsPage   = true;
        break;
    case 'export':
        $secLevelHeader   = $PMF_LANG['admin_mainmenu_exports'];
        $secLevelEntries .= $adminHelper->addMenuEntry('', 'export', 'ad_menu_export', $action);
        $dashboardPage    = false;
        $exportsPage      = true;
        break;
    case 'backup':
        $secLevelHeader   = $PMF_LANG['admin_mainmenu_backup'];
        $secLevelEntries .= $adminHelper->addMenuEntry('', 'backup', 'ad_menu_export', $action);
        $dashboardPage    = false;
        $backupPage       = true;
        break;
    case 'config':
    case 'linkconfig':
    case 'stopwordsconfig':
    case 'translist':
    case 'transedit':
    case 'transadd':
    case 'upgrade':
        $secLevelHeader    = $PMF_LANG['admin_mainmenu_configuration'];
        $secLevelEntries  .= $adminHelper->addMenuEntry('editconfig', 'config', 'ad_menu_editconfig', $action);
        $secLevelEntries  .= $adminHelper->addMenuEntry('editconfig+editbt+delbt', 'linkconfig', 'ad_menu_linkconfig', $action);
        $secLevelEntries  .= $adminHelper->addMenuEntry('editconfig', 'stopwordsconfig', 'ad_menu_stopwordsconfig', $action);
        $dashboardPage     = false;
        $configurationPage = true;
        break;
    default:
        $secLevelHeader   = $PMF_LANG['admin_mainmenu_home'];
        $secLevelEntries .= $adminHelper->addMenuEntry('addtourn+edittourn+deltourn', 'tournament', 'ad_menu_tourn_edit');
        $secLevelEntries .= $adminHelper->addMenuEntry('addplayer+editplayer+delplayer', 'players', 'ad_menu_players');
        $dashboardPage    = true;
        break;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="<?php print $PMF_LANG['metaLanguage']; ?>" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="<?php print $PMF_LANG['metaLanguage']; ?>" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="<?php print $PMF_LANG['metaLanguage']; ?>" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="<?php print $PMF_LANG['metaLanguage']; ?>" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php print $PMF_LANG['metaLanguage']; ?>" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title><?php print $faqconfig->get('main.titleFAQ'); ?></title>
    <base href="<?php print PMF_Link::getSystemUri('index.php'); ?>" />
    
    <meta name="description" content="Only Chuck Norris can divide by zero.">
    <meta name="author" content="phpMyFAQ Team">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <meta name="application-name" content="phpMyFAQ <?php print $faqconfig->get('main.currentVersion'); ?>">
    <meta name="copyright" content="(c) 2012 Maria Rudko">
    <meta name="publisher" content="phpMyFAQ Team">
    <meta name="MSSmartTagsPreventParsing" content="true">
    
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="stylesheet" href="../js/plugins/autocomplete/jquery.autocomplete.css" type="text/css">
    <link rel="stylesheet" href="../js/plugins/datePicker/datePicker.css" type="text/css">

    <script src="../js/libs/modernizr.min.js"></script>
    <script src="../js/libs/jquery.min.js"></script>
    <script src="../js/functions.js"></script>
    <script src="../js/phpmyfaq.js"></script>

    <script src="../js/plugins/autocomplete/jquery.autocomplete.pack.js"></script>
    <script src="../js/plugins/datePicker/date.js"></script>
    <script src="../js/plugins/datePicker/jquery.datePicker.js"></script>
    <script type="text/javascript" src="editor/tiny_mce.js"></script>

    <script type="text/javascript">
        tinyMCE.init({
            // General options
            mode     : "textareas",
            language : "<?php print (PMF_Language::isASupportedTinyMCELanguage($LANGCODE) ? $LANGCODE : 'en'); ?>",
            width    : "300",
            height   : "280",
            theme    : "advanced",
            plugins  : "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,syntaxhl,phpmyfaq",
            theme_advanced_blockformats : "p,div,h1,h2,h3,h4,h5,h6,blockquote,dt,dd,code,samp",

            // Theme options
            theme_advanced_buttons1 : "<?php print $tinyMceSave ?>bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,phpmyfaq,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,syntaxhl,|,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,fullscreen",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            relative_urls           : false,
            convert_urls            : false,
            remove_linebreaks       : false,
            use_native_selects      : true,
            entity_encoding         : "raw",
            extended_valid_elements : "code",

            // Ajax-based file manager
            file_browser_callback : "ajaxfilemanager",

            // Save function
            save_onsavecallback : "phpMyFAQSave",

            // Example content CSS (should be your site CSS)
            content_css : "../template/<?php print PMF_Template::getTplSetName(); ?>/css/style.css,css/style.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "js/template_list.js",

            // Replace values for the template plugin
            template_replace_values : {
                username : "<?php print $user->userdata->get('display_name'); ?>",
                user_id  : "<?php print $user->userdata->get('user_id'); ?>"
            }
        });
    </script>
    
    <link rel="shortcut icon" href="../template/<?php print PMF_Template::getTplSetName(); ?>/favicon.ico">
    <link rel="apple-touch-icon" href="../template/<?php print PMF_Template::getTplSetName(); ?>/apple-touch-icon.png">
</head>
<body dir="<?php print $PMF_LANG["dir"]; ?>">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a href="/tournament/"><h1 class="brand" href="../index.php"><?php print $faqconfig->get('main.titleFAQ'); ?></h1></a>
            <div class="nav-collapse">
                <?php if (isset($auth) && in_array(true, $permission)): ?>
                <ul class="nav">
                    <li<?php print ($dashboardPage ? ' class="active"' : ''); ?>>
                        <a href="index.php"><?php print $PMF_LANG['admin_mainmenu_home']; ?></a>
                    </li>
                    <li<?php print ($userPage ? ' class="active"' : ''); ?>>
                        <a href="index.php?action=user"><?php print $PMF_LANG['admin_mainmenu_users']; ?></a>
                    </li>
                    <li<?php print ($contentPage ? ' class="active"' : ''); ?>>
                        <a href="index.php?action=content"><?php print $PMF_LANG['admin_mainmenu_content']; ?></a>
                    </li>
                    <li<?php print ($statisticsPage ? ' class="active"' : ''); ?>>
                        <a href="index.php?action=statistics"><?php print $PMF_LANG['admin_mainmenu_statistics']; ?></a>
                    </li>
                    <li<?php print ($backupPage ? ' class="active"' : ''); ?>>
                        <a href="index.php?action=backup"><?php print $PMF_LANG['admin_mainmenu_backup']; ?></a>
                    </li>
                    <li<?php print ($configurationPage ? ' class="active"' : ''); ?>>
                        <a href="index.php?action=config"><?php print $PMF_LANG['admin_mainmenu_configuration']; ?></a>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span title="<?php print $PMF_LANG['ad_user_loggedin'] . $user->getLogin(); ?>">
                            <?php print $user->getUserData('display_name'); ?>
                            </span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php print $PMF_LANG['ad_session_expiration']; ?>: <span id="sessioncounter">Loading...</span>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="index.php?action=logout"><?php print $PMF_LANG['admin_mainmenu_logout']; ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="nav">
                    <li><a href="password.php"><?php print $PMF_LANG["lostPassword"]; ?></a></li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div id="main">
    <div class="container-fluid">
        <div class="row-fluid">
            <?php if (isset($auth) && in_array(true, $permission)) { ?>
            <div class="span3">
                <div class="well categories">
                    <ul class="nav nav-list">
                        <li class="nav-header"><?php print $secLevelHeader; ?></li>
                        <?php print $secLevelEntries; ?>
                    </ul>
                </div>
            </div>
            <?php } ?>

            <div class="span9">