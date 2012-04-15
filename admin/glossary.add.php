<?php
/**
 * Displays a form to add a glossary item
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
 * @copyright 2005-2012 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2005-09-15
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

print sprintf('<header><h2>%s</h2></header>', $PMF_LANG['ad_glossary_add']);

if ($permission['addglossary']) {
?>
        <form class="form-horizontal" action="?action=saveglossary" method="post">
            <div class="control-group">
                <label class="control-label" for="item"><?php print $PMF_LANG['ad_glossary_item']; ?>:</label>
                <div class="controls">
                    <input type="text" name="item" id="item" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="definition"><?php print $PMF_LANG['ad_glossary_definition']; ?>:</label>
                <div class="controls">
                    <textarea name="definition" id="definition" cols="50" rows="5"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <input class="btn-primary" type="submit" value="<?php print $PMF_LANG['ad_glossary_save']; ?>" />
            </div>
        </form>
<?php
} else {
    print $PMF_LANG["err_NotAuth"];
}
