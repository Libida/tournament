<?php

class PMF_DB_Helper
{
    private function __construct()
    {
    }


    public static function createDBInstance($table_name, Array $data)
    {
        if (empty($table_name) || !is_array($data)) {
            return false;
        }

        $id = PMF_Db::getInstance()->nextId(SQLPREFIX . $table_name, 'id');

        $query = "INSERT INTO " . SQLPREFIX . $table_name . " VALUES (" . $id;
        foreach ($data as $value) {
            $query .= ", '" . $value . "'";
        }
        $query .= ");";

        PMF_Db::getInstance()->query($query);

        return $id;
    }

    public static function getAllValues($table_name)
    {
        $sql = "SELECT * FROM " . SQLPREFIX . $table_name;
        $result = PMF_Db::getInstance()->query($sql);
        return PMF_Db::getInstance()->fetchAll($result);
    }

}
