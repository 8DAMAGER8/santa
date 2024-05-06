<?php

namespace Repository;

use Services\DatabaseService;

require_once ( __DIR__ . '/../Services/DatabaseService.php');


class AbstractRepository
{
    protected static function getAllDataFromTable($table): array
    {
        return self::selectAll("SELECT * FROM `$table`");
    }

    protected static function set($table, $set, $where, $sign = '', $logic = ''): bool
    {
        if (empty($where) || empty($set)){

            return false;
        }

        $query = "UPDATE `$table` SET ";

        foreach ($set as $field => $value) {
            $query .= "`$field` = '" . addslashes($value) . "',";
        }

        $query = substr($query, 0, -1);
        $where = self::getWhere($where, $sign, $logic);
        $query .= " WHERE $where";

        return DatabaseService::getDb()->query($query);
    }

    protected static function selectAll($SQL): array
    {
        $res = DatabaseService::getDb()->query($SQL);
        $items = [];

        while($data = $res->fetch_assoc()){
            $items[]=$data;
        }

        return $items;
    }

    protected static function add($table, $set): bool
    {
        if (empty($set)) {

            return false;
        } else {
            $data = self::createDataForAdd($set);


            return self::addDataInTable($table, $data['fields'], $data['values']);
        }
    }

    private static function addDataInTable($table, $fields, $values): bool
    {
        $query = "INSERT INTO `$table` (" . $fields . ") VALUES (" . $values . ")";

        DatabaseService::getDb()->query($query);

        if (DatabaseService::getDb()->insert_id) {

            return true;
        }

        return false;
    }

    private static function createDataForAdd($set): array
    {
        $fields = "";
        $values = "";

        foreach ($set as $field => $value) {
            $fields .= "`" . $field . "`,";
            $values .= "'" . addslashes($value) . "',";
        }
        $data['fields'] = substr($fields, 0, -1);
        $data['values'] = substr($values, 0, -1);

        return $data;
    }

    protected static function get($output, $table, $where = "", $sign = "", $logic = "", $order = "", $offset = "", $limit = "")
    {
        $array = array();
        $out = "";
        $output = trim($output);

        if (is_array($output)) {

            foreach ($output as $value) {
                $out .= "`" . $value . "`,";
            }
            $out = substr($out, 0, -1);

        } elseif ($output == "*") {
            $out = '*';
        } elseif (strpos($output, "(")) { // count(*);
            $out = $output;
        } else {
            $out = '`' . $output . '`';
        }
        $where = self::getWhere($where, $sign, $logic);

        if (!empty($where)) {
            $where = " WHERE " . $where;
        }

        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $ordo = " ORDER BY `" . $key . "` " . $value . " ";
            }
        } else {
            $ordo = "";
        }
        $ordo = substr($ordo, 0, -1);

        if (!empty($offset)) {
            $offset .= ',';
        }

        if (!empty($limit)) {
            $limit = "LIMIT " . $offset . " " . $limit;
        }
        $query = "SELECT $out FROM `$table` $where $ordo $limit";

        return self::selectAll($query);
    }

    private static function getWhere($wh, $sign = '', $logic = '')
    {
        if (empty($wh)) {

            return "";
        }

        if (empty($sign)) {
            $sign = "=";
        }

        if (empty($logic)) {
            $logic = "AND";
        }

        $where = "";

        foreach ($wh as $key => $value) {

            if (!is_array($value)) {
                $where = $where . " `" . $key . "` $sign '" . $value . "' $logic ";
            } else {

                for ($i = 0; $i < count($value); $i++) {
                    $where = $where . " `" . $key . "` $sign '" . $value[$i] . "' $logic ";
                }
            }
        }

        if (!empty($logic)){
            $where = substr($where, 0, -4);
        }

        return $where;
    }
}