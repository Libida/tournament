<script type="text/javascript" src="js/tournament.fields.js"></script>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="name"><?php print $PMF_LANG['ad_tournedit_title']; ?>:</label>
    </span>
    <span class="input-text">
        <input type="text" id="name" name="name" value="<?php print $tournament->name; ?>"/>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left" style="float: left;">
        <label class="control-label" for="description"><?php print $PMF_LANG['ad_tournedit_desc']; ?>:</label>
    </span>
    <span style="display: inline-block;">
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
        <label class="control-label" for="custom_tours"><?php print $PMF_LANG['ad_tournedit_custom_tours']; ?>:</label>
    </span>
    <span class="input-text">
        <?php
        if ($tournament->custom_tours) {
            print '<input id="custom_tours" name="custom_tours" type="checkbox" checked="checked"/>';
        } else {
            print '<input id="custom_tours" name="custom_tours" type="checkbox" />';
        }
        ?>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="pointsSystem"><?php print $PMF_LANG['ad_tournedit_points_system']; ?>:</label>
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
        <label class="control-label" for="ageCategory"><?php print $PMF_LANG['ad_tournedit_age_category']; ?>:</label>
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

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label"><?php print $PMF_LANG['ad_tournedit_criteria']; ?>:</label>
    </span>
    <span class="input-text">
        <span style="margin-right: 10px;">
            <input class="criteria" id="berger" type="checkbox" value="0"/>
            <label style="display: inline;" for="berger"><?php print $PMF_LANG['ad_tournedit_berger']; ?></label>
        </span>
        <span style="margin-right: 10px;">
            <input class="criteria" id="buhgoltz" type="checkbox" value="1"/>
            <label style="display: inline;" for="buhgoltz"><?php print $PMF_LANG['ad_tournedit_buhgoltz']; ?></label>
        </span>
        <span style="margin-right: 10px;">
            <input class="criteria" id="personal" type="checkbox" value="2"/>
            <label style="display: inline;" for="personal"><?php print $PMF_LANG['ad_tournedit_personal']; ?></label>
        </span>
    </span>
</div>

<input type="hidden" id="selectedCriteria" name="selectedCriteria" value="<?php print $tournament->criteria ?>"/>

<div id="selectedCriteriaDiv" class="inputs-block">
    <span class="input-left">
        <label class="control-label"><?php print $PMF_LANG['ad_tournedit_selected_criteria']; ?>:</label>
    </span>
    <span id="selectedCriteriaText" class="input-text">
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