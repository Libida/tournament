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

        $id = PMF_Db::getInstance()->nextId($table_name, 'id');

        $sql = "INSERT INTO " . $table_name . " VALUES (" . $id;
        foreach ($data as $value) {
            $sql .= ", '" . $value . "'";
        }
        $sql .= ");";

        PMF_Db::getInstance()->query($sql);

        return $id;
    }

    public static function getAllValues($table_name)
    {
        $sql = "SELECT * FROM " . $table_name;
        $result = PMF_Db::getInstance()->query($sql);
        return PMF_Db::getInstance()->fetchAll($result);
    }

    public static function getById($table_name, $id)
    {
        $sql = "SELECT * FROM " . $table_name . " WHERE id = " . $id;
        $result = PMF_Db::getInstance()->query($sql);
        return PMF_Db::getInstance()->fetchObject($result);
    }

    public static function updateItem($table_name, $id, $data)
    {
        $sql = "UPDATE " . $table_name . " SET";
        $i = 0;
        foreach ($data as $column_name => $new_value) {
            $sql .= " " . $column_name . "= '" . $new_value . "'";
            if ($i++ != count($data) - 1) {
                $sql .= ",";
            }
        }
        $sql .= " WHERE id = " . $id;

        PMF_Db::getInstance()->query($sql);
    }
}
