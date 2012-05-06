<?php
if (!isset($player)) {
    $player = '';
}
function printOptions($PMF_LANG, $options, $selected_value_id)
{
    foreach ($options as $option) {
        $value = $option->name;
        $id = $option->id;
        if (isset($PMF_LANG[$value])) {
            $value = $PMF_LANG[$value];
        }
        if ($id == $selected_value_id) {
            printf("<option value='%s' selected>%s</option>", $option->id, $value);
        } else {
            printf("<option value='%s'>%s</option>", $option->id, $value);
        }
    }
}
?>

<div class="inputs-block">
    <span class="input-left">
        <label for="first_name"><?php print $PMF_LANG["ad_player_name"]; ?>:</label>
    </span>
    <span>
        <span class="input-text">
            <input id="last_name" name="last_name" placeholder="<?php print $PMF_LANG["ad_player_last_name"]; ?>"
                   required="required" value="<?php print $player->last_name; ?>" type="text">
        </span>
        <span class="input-text">
            <input id="first_name" name="first_name" placeholder="<?php print $PMF_LANG["ad_player_first_name"]; ?>"
                   required="required" value="<?php print $player->first_name; ?>" type="text">
        </span>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label for="country"><?php print $PMF_LANG["ad_player_country"]; ?>:</label>
    </span>
    <?php
    $countries = PMF_Player::getAllCountries();
    ?>
    <span class="input-text">
        <select id="country" name="country">
            <?php
            printOptions($PMF_LANG, $countries, $player->country_id);
            ?>
        </select>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label for="birth_year"><?php print $PMF_LANG["ad_player_birth_year"]; ?>:</label>
    </span>
    <span class="input-text">
        <input type="number" min="1980" max="2012" value="1990" id="birth_year" name="birth_year"
               required="required"/>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="gender"><?php print $PMF_LANG["ad_player_gender"]; ?>:</label>
    </span>
    <span class="input-text">
        <select id="gender" name="gender">
            <?php
                $is_male = $player->male;
                if ($is_male) {
                    printf('<option value="1" selected>%s</option>', $PMF_LANG["ad_player_male"]);
                    printf('<option value="0">%s</option>', $PMF_LANG["ad_player_female"]);
                } else {
                    printf('<option value="1">%s</option>', $PMF_LANG["ad_player_male"]);
                    printf('<option value="0" selected>%s</option>', $PMF_LANG["ad_player_female"]);
                }
            ?>
        </select>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="title"><?php print $PMF_LANG["ad_player_title"]; ?>:</label>
    </span>
    <span class="input-text">
        <?php
        $titles = PMF_Player::getAllTitles();
        ?>
        <select id="title" name="title">
            <?php
            printOptions($PMF_LANG, $titles, $player->title_id);
            ?>
        </select>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="rating"><?php print $PMF_LANG["ad_player_rating"]; ?>:</label>
    </span>
    <span class="input-text">
        <input type="number" min="0" id="rating" name="rating" required="required"
               value="<?php print $player->rating; ?>"/>
    </span>
</div>

<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="category"><?php print $PMF_LANG["ad_player_category"]; ?>:</label>
    </span>
    <span class="input-text">
        <?php
        $categories = PMF_Player::getAllCategories();
        ?>
        <select id="category" name="category">
            <?php
            printOptions($PMF_LANG, $categories, $player->category_id);
            ?>
        </select>
    </span>
</div>


<div class="inputs-block">
    <span class="input-left">
        <label class="control-label" for="degree"><?php print $PMF_LANG["ad_player_degree"]; ?>:</label>
    </span>
    <span class="input-text">
        <?php
        $degrees = PMF_Player::getAllDegrees();
        ?>
        <select id="degree" name="degree">
            <?php
            printOptions($PMF_LANG, $degrees, $player->degree_id);
            ?>
        </select>
    </span>
</div>