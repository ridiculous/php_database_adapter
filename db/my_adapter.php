<?php

/**
 * Description of MySQL Database Adapter
 *
 * @author buck
 */
class MyAdapter {

    private $Datasource;
    private $Database;

    public function _connect() {
        $args = func_get_args();
        $options = $args[1];
        $this->Database = $options['Database'];
        $this->Datasource = mysql_connect($args[0], $options['UID'], $options['PWD']);
        return $this->Datasource;
    }

    public function _after_connect() {
        return mysql_select_db($this->Database);
    }

    public function _throw_db_error() {
        return die(mysql_error());
    }

    public function _query($s) {
        return mysql_query($s, $this->Datasource);
    }

    public function _fetch($query_results) {
        return mysql_fetch_array($query_results, MYSQL_NUM);
    }

    public function _fetch_hash($query_results) {
        if (is_resource($query_results))
            return mysql_fetch_array($query_results, MYSQL_ASSOC);
        else
            return false;
    }

    public function _fields($results_array) {
        return mysql_num_fields($results_array);
    }

    public function _rows($result) {
        return mysql_num_rows($result);
    }

    public function _column_names($table) {
        return "DESCRIBE $table";
    }

    public function _select_limit($table, $col, $limit) {
        return "SELECT $col FROM $table LIMIT $limit";
    }

    public function _string_index() {
        return "LOCATE";
    }

    public function _ifnil() {
        return "IFNULL";
    }

    public function _op() {
        return " , ";
    }

    public function _concat() {
        return "CONCAT";
    }

    public function _wrap() {
        return '`';
    }

    /* End of class */
}

?>
