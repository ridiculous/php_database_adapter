<?php

/* * **********************************
 * Database Class
 * 
 * Routine database functions
 * 
 * Allows the application to function the same with either a Microsoft SQL or MySQL backend.
 * 
 * The methods, commands and syntax used by the classes functions are based on the DBTYPE variable. Defaults to MS SQL if not set
 *
 * @author Ryan Buckley <rbuckley@hawaii.edu>
 *
 * Last Update: 2/20/2012
 * *********************************** */
ini_set('display_errors', 'on');
// require_once 'ms_adapter.php';
require_once 'my_adapter.php';

class Db {

    private $Username;
    private $Password;
    private $Database;
    private $Server;
    private $Datasource;
    private $Adapter;
    private $IFNIL;     # MS SQL => ISNULL, MySQL => IFNULL
    private $OP;        # MS SQL => '+', MySQL => ',' (concatenation operator)
    private $CONCAT;    # MS SQL => "", MySQL => "CONCAT"
    private $STRINDEX;  # MS SQL => "Charindex", MySQl => "LOCATE"
    private $WRAP;      # For wrapping field names that have spaces. I.E `Program Coordinator`

    function __construct() {
        $this->set_db();
        $this->set_vars();
        $this->connect_db();
    }

    private function set_vars() {
        $this->set_ifnil();
        $this->set_op();
        $this->set_concat();
        $this->set_strindex();
        $this->set_wrap();
    }

    private function set_db() {
        $this->Username = 'root';
        $this->Password = '';
        $this->Database = 'mauisite';
        $this->Server = 'localhost';
        $this->Adapter = new MyAdapter();
    }

    private function connect_db() {
        $this->Datasource = $this->_connect();
        if (!$this->Datasource) {
            $this->throw_db_error();
        }
        $this->Adapter->_after_connect();
    }

    private function _connect() {
        $options = array(
            "UID" => $this->Username,
            "PWD" => $this->Password,
            "Database" => $this->Database
        );
        return $this->Adapter->_connect($this->Server, $options);
    }

    protected function throw_db_error() {
        return $this->Adapter->_throw_db_error();
    }

    public function query($statement) {
        $result = $this->Adapter->_query($statement);
        if (!$result)
            $this->throw_db_error();
        return $result;
    }

    public function fetch($query_results) {
        return $this->Adapter->_fetch($query_results);
    }

    public function fetch_hash($query_results) {
        return $this->Adapter->_fetch_hash($query_results);
    }

    public function fields($results_array) {
        return $this->Adapter->_fields($results_array);
    }

    public function has_rows($result) {
        return $this->Adapter->_rows($result);
    }

    public function column_names($table) {
        return $this->Adapter->_column_names($table);
    }

    // Helpers

    public function strindex() {
        return $this->STRINDEX;
    }

    public function ifnil() {
        return $this->IFNIL;
    }

    public function op() {
        return $this->OP;
    }

    public function concat() {
        return $this->CONCAT;
    }

    public function wrap() {
        return $this->WRAP;
    }

    # Setters

    private function set_strindex() {
        $this->STRINDEX = $this->Adapter->_string_index();
    }

    private function set_ifnil() {
        $this->IFNIL = $this->Adapter->_ifnil();
    }

    private function set_concat() {
        $this->CONCAT = $this->Adapter->_concat();
    }

    private function set_op() {
        $this->OP = $this->Adapter->_op();
    }

    private function set_wrap() {
        $this->WRAP = $this->Adapter->_wrap();
    }

}

/* * ***********  END OF CLASS  ************* */
?>
