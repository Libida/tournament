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
            if ($tournament->points_system == '2-1-0') {
                printf('<option value="2-1-0" selected="selected">%s</option>', '2 - 1 - 0');
                printf('<option value="1-0.5-0">%s</option>', '1 - 0.5 - 0');
            } else {
                printf('<option value="2-1-0">%s</option>', '2 - 1 - 0');
                printf('<option value="1-0.5-0" selected="selected">%s</option>', '1 - 0.5 - 0');
            }
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
            <option value="5-10">5-10</option>
            <?php
            if ($tournament->age_category == '11-30') {
                printf('<option value="11-30" selected="selected">%s</option>', '11-30');
            } else {
                printf('<option value="11-30">%s</option>', '11-30');
            }
            ?>
        </select>
    </span>
</div>