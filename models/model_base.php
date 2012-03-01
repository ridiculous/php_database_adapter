<?php

/* * ************************
 * Model Base Class
 *
 * Dynamically Models Tables
 *
 * Generates SQL statements for common DB commands
 *
 * Functions: _new(), _create(), _update(), _all(), _destroy(), _attributes()
 *
 * The attributes are based on the respective model
 *
 * @author Ryan Buckley <rbuckley@hawaii.edu>
 *
 * Last Update: 01/21/2012
 *
 * *************************** */

require_once 'db/db.php';

class ModelBase extends Db {

    private $Model = '';
    private $Attributes = array();

    public function __construct($model) {
        $this->Model = $model;
        parent::__construct();
        $this->Attributes = $this->_attributes();
    }

    #
    # Returns a set of attributes for each column in the table. Merges values in arguments

    public function _new() {
        return $this->_attributes(func_get_args());
    }

    #
    # Saves the record by creating an insert statement

    public function _save() {
        $numargs = func_num_args();
        $args = func_get_args();
        $args = $this->_flatten($args);

        $attrs = array();
        for ($i = 0; $i < $numargs; $i++) {
            foreach ($args[$i] as $key => $val) {
                if ($key != 'id')
                    array_push($attrs, "'$val'");
            }
        }
        $columns = $this->Attributes;
        unset($columns['id']);

        return "INSERT INTO $this->Model(" . implode(', ', array_keys($columns)) . ") VALUES(" . implode(', ', $attrs) . ")";
    }

    #
    # Update record by creating sql update statement

    public function _update() {
        $numargs = func_num_args();
        $args = $this->_flatten(func_get_args());

        $id = 0;
        $attrs = array();
        for ($i = 0; $i < $numargs; $i++) {
            foreach ($args[$i] as $key => $val) {
                if ($key == 'id')
                    $id = $val;
                else
                    array_push($attrs, "$key = '$val'");
            }
        }
        return "UPDATE $this->Model SET " . implode(', ', $attrs) . " WHERE id = $id ";
        ;
    }

    public function _destroy($id) {
        return "DELETE FROM $this->Model WHERE id = $id";
    }

    #
    # Return all records for model (w/ certain columns suppressed)

    public function _all($order = 'id DESC') {
        $attrs = $this->Attributes;
        return $statement = "SELECT " . implode(', ', array_keys($attrs)) . " FROM $this->Model ORDER BY $order";
    }

    /* Class Helper Methods */

    # Returns all the attributes/columns of the table
    # Arguments are merged if included in attributes

    private function _attributes($attrs = array()) {

        $statement = parent::column_names($this->Model);
        $result = parent::query($statement);
        $attrs = isset($attrs[0]) ? $this->_flatten($attrs[0]) : array();

        while ($row = parent::fetch_hash($result)) {
            $col = array_values($row);
            $this->Attributes[$col[0]] = isset($attrs[$col[0]]) ? $attrs[$col[0]] : '';
        }

        return $this->Attributes;
    }

    #
    # Turns two dimensional array/hash into one dimensional array. (tested w/ two levels)

    private function _flatten($args) {
        $attrs = array();
        for ($i = 0; $i < count($args); $i++) {
            foreach ($args[$i] as $key => $val) {
                $attrs[$key] = $val;
            }
        }
        return $attrs;
    }

}

?>