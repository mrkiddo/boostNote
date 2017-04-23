<?php

/**
 * Model base class
 */
class Model extends Sql
{
    protected $_model;
    protected $_table;

    public function __construct()
    {
        $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->_model = get_class($this);
        $this->_model = substr($this->_model, 0, -5);
        $this->_table = strtolower(DB_TABLE_PREFIX.$this->_model);
    }

    public function getTableName()
    {
        if(isset($this->_table)) {
            $tableName = explode('Model', $this->_table)[0];
            return $tableName;
        }
    }

    public function wrapColumnName($field)
    {
        return $this->getTableName().'.'.$field;
    }
}