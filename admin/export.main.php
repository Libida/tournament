<?php
/**
 * XML, XHTML and PDF export - main page
 * 
 * PHP Version 5.2
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
 * @author    Matteo Scaramuccia <matteo@phpmyfaq.de>
 * @copyright 2003-2011 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2003-04-17
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

require PMF_INCLUDE_DIR . '/Export.php';
?>
        <header>
            <h2><?php print($PMF_LANG["ad_menu_export"]); ?></h2>
        </header>

        <form class="form-horizontal" action="?action=exportfile" method="post">
<?php

if (!PMF_Db::checkOnEmptyTable('faqdata')) {

    if (!PMF_Db::checkOnEmptyTable('faqcategories')) {
        $category = new PMF_Category($current_admin_user, $current_admin_groups);
        $category->buildTree();
        
        $helper = PMF_Helper_Category::getInstance();
        $helper->setCategory($category);
?>
            <fieldset>
                <legend><?php print($PMF_LANG['ad_export_which_cat']); ?></legend>
                <div class="control-group">
                    <label class="control-label" for="catid"><?php print($PMF_LANG["ad_entry_category"]); ?></label>
                    <div class="controls">
                        <select name="catid" id="catid" size="1">
                            <option value="0"><?php print $PMF_LANG['msgShowAllCategories'] ?></option>
                            <?php print $helper->renderCategoryOptions(); ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <label class="checkbox" for="downwards">
                            <input type="checkbox" name="downwards" id="downwards" value="1" checked="checked" />
                            <?php print($PMF_LANG['ad_export_cat_downwards']); ?>
                        </label>
                    </div>
                </div>
            </fieldset>

<?php
    }
?>
            <fieldset>
                <legend><?php print($PMF_LANG['ad_export_type']); ?></legend>
                <div class="control-group">
                    <div class="controls">
                        <label><?php print($PMF_LANG['ad_export_type_choose']); ?></label>
                        <label class="radio">
                            <input type="radio" name="type" value="pdf" checked="checked" />
                            <?php print($PMF_LANG["ad_export_generate_pdf"]); ?>
                        </label>
                        <label class="radio">
                            <input type="radio" name="type" value="xml" />
                            <?php print($PMF_LANG["ad_xml_gen"]); ?>
                        </label>
                        <label class="radio">
                            <input type="radio" name="type" value="xhtml" />
                            <?php print($PMF_LANG['ad_export_gen_xhtml']); ?>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <label><?php print($PMF_LANG['ad_export_download_view']); ?></label>
                        <label class="radio">
                            <input type="radio" name="dispos" value="<?php print PMF_HttpStreamer::EXPORT_DISPOSITION_ATTACHMENT; ?>" checked="checked" />
                            <?php print($PMF_LANG['ad_export_download']); ?>
                        </label>
                        <label class="radio">
                            <input type="radio" name="dispos" value="<?php print PMF_HttpStreamer::EXPORT_DISPOSITION_INLINE; ?>">
                            <?php print($PMF_LANG['ad_export_view']); ?>
                        </label>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <input class="btn-primary" type="submit" name="submitExport" value="<?php print(strip_tags($PMF_LANG["ad_menu_export"])); ?>" />
                <input class="btn-info" type="reset" name="resetExport" value="<?php print(strip_tags($PMF_LANG["ad_config_reset"])); ?>" />
            </div>
        </form>
<?php
} else {
    print($PMF_LANG["err_noArticles"]);
}