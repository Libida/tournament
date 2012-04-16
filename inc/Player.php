<?php
require 'PMF_Helper/DBHelper.php';

class PMF_Player
{
    public static function getAllCountries()
    {
        return PMF_DB_Helper::getAllValues("t_countries");
    }

    public static function getAllTitles()
    {
        return PMF_DB_Helper::getAllValues("t_titles");
    }

    public static function getAllCategories()
    {
        return PMF_DB_Helper::getAllValues("t_categories");
    }

    public static function getAllDegrees()
    {
        return PMF_DB_Helper::getAllValues("t_degrees");
    }
}
