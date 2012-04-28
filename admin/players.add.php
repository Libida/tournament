<?php
if (!defined('IS_VALID_PHPMYFAQ')) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}
?>

<header>
    <h2><?php print $PMF_LANG['ad_add_player_header']; ?></h2>
</header>

<?php
function printOptions($PMF_LANG, $options)
{
    foreach ($options as $option) {
        $value = $option->name;
        if (isset($PMF_LANG[$value])) {
            $value = $PMF_LANG[$value];
        }
        printf("<option value='%s'>%s</option>", $option->id, $value);
    }
}

if ($permission["addplayer"]) {
    ?>
<form action="?action=saveplayer" method="post">
    <div class="inputs-block">
        <span class="input-left">
            <label for="first_name"><?php print $PMF_LANG["ad_player_name"]; ?>:</label>
        </span>
        <span>
            <span class="input-text">
                <input id="last_name" name="last_name" placeholder="<?php print $PMF_LANG["ad_player_last_name"]; ?>"
                       required="required">
            </span>
            <span class="input-text">
                <input id="first_name" name="first_name" placeholder="<?php print $PMF_LANG["ad_player_first_name"]; ?>"
                       required="required">
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
                printOptions($PMF_LANG, $countries);
                ?>
            </select>
        </span>
    </div>

    <div class="inputs-block">
        <span class="input-left">
            <label for="birth_year"><?php print $PMF_LANG["ad_player_birth_year"]; ?>:</label>
        </span>
        <span class="input-text">
            <input type="number" min="1980" max="2012" value="1990" id="birth_year" name="birth_year" required="required"/>
        </span>
    </div>

    <div class="inputs-block">
        <span class="input-left">
            <label class="control-label" for="gender"><?php print $PMF_LANG["ad_player_gender"]; ?>:</label>
        </span>
        <span class="input-text">
            <select id="gender" name="gender">
                <option value="1"><?php print $PMF_LANG["ad_player_male"];?></option>
                <option value="0"><?php print $PMF_LANG["ad_player_female"];?></option>
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
                printOptions($PMF_LANG, $titles);
                ?>
            </select>
        </span>
    </div>

    <div class="inputs-block">
        <span class="input-left">
            <label class="control-label" for="rating"><?php print $PMF_LANG["ad_player_rating"]; ?>:</label>
        </span>
        <span class="input-text">
            <input type="number" min="0" value="0" id="rating" name="rating" required="required"/>
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
                printOptions($PMF_LANG, $categories);
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
                printOptions($PMF_LANG, $degrees);
                ?>
            </select>
        </span>
    </div>

    <div class="form-actions">
        <input class="btn-primary" type="submit" name="submit" value="<?php print $PMF_LANG["ad_categ_add"]; ?>"/>
    </div>
</form>
<?php
}
?>