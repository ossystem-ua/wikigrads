<?php

class DataUtils {
    public static function setDoctrineQueryConnection($dql, $conn_name) {
      $docConn = Doctrine_Manager::getInstance()->getConnection($conn_name);
      $dql->setConnection($docConn);
    }

    /**
    * execute raw query.
    * options: index_on, scalar_field
    *
    * @param mixed $sql
    * @param mixed $options
    * @return array
    */
    public static function rawSelect($sql, $options = array()) {
        $conn = Doctrine_Manager::connection();
        $pdo = $conn->execute($sql);
        $pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
        $raw = $pdo->fetchAll();

        if( ! $index_on = Utils::getOptionValue($options, 'index_on')) {
            return $raw;
        }

        $data = array();
        if($scalar_field = Utils::getOptionValue($options, 'scalar_field')) {
            // index_on will be set because of the first check above returns if not set
            $i = 0;
            foreach($raw as $r) {
                //if ($i > 10) break;
                $data[$r[$index_on]] = $r[$scalar_field];
                $i++;
            }

        } else {
            $i = 0;
            foreach($raw as $r) {
                //if ($i > 10) break;
                $data[$r[$index_on]] = $r;
                $i++;
            }
        }

        return $data;
    }

    public static function rawSelectOne($sql, $options = array()) {
        $conn = Doctrine_Manager::connection();
        $pdo = $conn->execute($sql);
        $pdo->setFetchMode(Doctrine_Core::FETCH_ASSOC);
        $raw = $pdo->fetchAll();

        if(empty($raw)) {
            return array();
        }
        $rec = array_shift($raw);

        if($scalar_field = Utils::getOptionValue($options, 'scalar_field')) {
            return $rec[$scalar_field];
        }

        return $rec;
    }

    public static function rawInsert($sql) {
        $conn = Doctrine_Manager::connection();
        $pdo = $conn->execute($sql);
        return $pdo->rowCount();
    }

    public static function rawUpdate($sql) {
        $conn = Doctrine_Manager::connection();
        $pdo = $conn->execute($sql);
        return $pdo->rowCount();
    }

    // quick access to enable/disabling of doctrine's limit subquery algorithm
    public static function enableDoctrineLimitSubqueryAlgorithm($table_name) {
        Doctrine_core::getTable($table_name)->setAttribute(Doctrine_Core::ATTR_QUERY_LIMIT, Doctrine_Core::LIMIT_RECORDS);
    }
    public static function disableDoctrineLimitSubqueryAlgorithm($table_name) {
        Doctrine_core::getTable($table_name)->setAttribute(Doctrine_Core::ATTR_QUERY_LIMIT, Doctrine_Core::LIMIT_ROWS);
    }

    public static function rawEscapeInput($input) {
        return mysql_escape_string($input);
    }

////////////////////////////////////////////////////////////////////////////////////
//                                                                               //
// QUICK SELECT UTILS                                                           //
//                                                                             //
////////////////////////////////////////////////////////////////////////////////

    /**
    * Returns an assoc array of key=>value, based on supplied arguments.
    * options:
    *   - where: specify a where clause to use in the select statement
    *   - first_choice: specify an array('key'=>'value') to prepend to the beginning of the list. (uses array + array)
    *
    * @param mixed $table
    * @param mixed $key_field
    * @param mixed $value_field
    * @param mixed $options
    * @return array
    */
    public static function getLookupList($table, $key_field, $value_field, $options=array()) {
        $sql = "SELECT $key_field, $value_field FROM $table";

        if($where = Utils::getOptionValue($options, 'where')) {
            $sql .= ' WHERE '.$where;
        }

        if($order_by = Utils::getOptionValue($options, 'order_by')) {
            $sql .= ' ORDER BY '.$order_by;
        }

        $raw = self::rawSelect($sql);
        $list = array();
        foreach($raw as $r) {
            $list[$r[$key_field]] = $r[$value_field];
        }

        if($first_choice = Utils::getOptionValue($options, 'first_choice')) {
            $list = $first_choice + $list;
        }

        return $list;
    }
};