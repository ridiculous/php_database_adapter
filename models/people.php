<?php

/* * ************************
 * People Model
 *
 * Objectifies the people table
 *
 * Inherits from the ModelBase Class
 *
 * Functions: _new(), _create(), _find(), _update(), _attributes()
 *
 * The attributes are set dynamically based on the people table each time the model is accessed
 *
 * @author Ryan Buckley <rbuckley@hawaii.edu>
 *
 * Last Update: 01/20/2012
 *
 * ************************* */


require_once 'models/model_base.php';

class People extends ModelBase {

    public function __construct() {
        parent::__construct(strtolower(get_class($this)));
    }

    // ... custom methods here
    // access ModelBase functions

    public function _new() {
        return parent::_new(func_get_args());
    }

    public function _save() {
        return parent::_save(func_get_args());
    }

    public function _update() {
        return parent::_update(func_get_args());
    }

    public function _all() {
        return parent::_all();
    }

    public function _destroy($_id) {
        return parent::_destroy($_id);
    }

    public function _find($_id) {
        return parent::fetch_hash(parent::query("SELECT * FROM " . get_class($this) . " WHERE id = '$_id'"));
    }

    // schema for this model

    public function _migrate() {
        return parent::query('create table people( id int, name varchar(255), age int )');
    }

}

?>
