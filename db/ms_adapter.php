<?php

/**
 * Description of Microsoft SQL Database Adapter
 *
 * @author buck
 */
class MsAdapter {

    private $Datasource;

    public function _connect() {
        $args = func_get_args();
        $this->Datasource = sqlsrv_connect($args[0], $args[1]);
        return $this->Datasource;
    }

    public function _after_connect() {
        # ... 
    }

    public function _throw_db_error() {
        return die(print_r(sqlsrv_errors(), true));
    }

    public function _query($statement) {
        return sqlsrv_query($this->Datasource, $statement);
    }

    public function _fetch($query_results) {
        return sqlsrv_fetch_array($query_results);
    }

    public function _fetch_hash($query_results) {
        if (is_resource($query_results))
            return sqlsrv_fetch_array($query_results, SQLSRV_FETCH_ASSOC);
        else
            return false;
    }

    public function _fields($results_array) {
        return sqlsrv_num_fields($results_array);
    }

    public function _rows($result) {
        return sqlsrv_has_rows($result);
    }

    public function _column_names($table) {
        return "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.Columns WHERE TABLE_NAME = '$table'";
    }

    public function _select_limit($table, $col, $limit) {
        return "SELECT TOP $limit $col FROM $table";
    }

    public function _string_index() {
        return "CHARINDEX";
    }

    public function _ifnil() {
        return "ISNULL";
    }

    public function _op() {
        return " + ";
    }

    public function _concat() {
        return "";
    }

    public function _wrap() {
        return '"';
    }


}

?>
