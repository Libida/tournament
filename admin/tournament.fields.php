<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="name"><?php print $PMF_LANG['ad_tournedit_title']; ?>:</label>
    </span>
    <span class="input-text">
        <input type="text" id="name" name="name" value="<?php print $tournament->name; ?>"/>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="description"><?php print $PMF_LANG['ad_tournedit_desc']; ?>:</label>
    </span>
    <span class="input-text">
        <textarea id="description" name="description" rows="3" cols="80"><?php print $tournament->description; ?></textarea>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="deleted"><?php print $PMF_LANG['ad_tournedit_deleted']; ?>:</label>
    </span>
    <span class="input-text">
        <?php
        if ($tournament->deleted) {
            print '<input id="deleted" name="deleted" type="checkbox" checked="checked"/>';
        } else {
            print '<input id="deleted" name="deleted" type="checkbox" />';
        }
        ?>
    </span>
</div>
<?php
if ($tournament->started) {
    ?>
<div class="inputs-block">
    <span class="input-left">
        <label class="control-label"><?php print $PMF_LANG['ad_tournedit_generate_tours_type']; ?>:</label>
    </span>
    <span class="input-text">
        <?php
        if ($tournament->tours_type == 0) {
            print $PMF_LANG['ad_tournedit_generate_tours_swiss'];
        } else if ($tournament->tours_type == 1) {
            print $PMF_LANG['ad_tournedit_generate_tours_round'];
        }
        ?>
    </span>
</div>
<?php
}
?>
<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="pointsSystem"><?php print $PMF_LANG['ad_tournedit_points_system']; ?>
            :</label>
    </span>
    <span class="input-text">
        <select id="pointsSystem" name="pointsSystem">
            <?php
            $values = array('2-1-0', '1-0.5-0');
            printOptions($values, $tournament->points_system);
            ?>
        </select>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="ageCategory"><?php print $PMF_LANG['ad_tournedit_age_category']; ?>
            :</label>
    </span>
    <span class="input-text">
        <select id="ageCategory" name="ageCategory">
            <?php
            $values = array('5-10', '11-30');
            printOptions($values, $tournament->age_category);
            ?>
        </select>
    </span>
</div>

<?php
function printOptions($values, $selected_value)
{
    foreach ($values as $value) {
        if ($value == $selected_value) {
            printf('<option value="%s" selected="selected">%s</option>', $value, $value);
        } else {
            printf('<option value="%s">%s</option>', $value, $value);
        }
    }
}
?>