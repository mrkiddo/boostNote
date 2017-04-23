<?php

/**
 * Migration base class
 */
class Migration extends Sql
{
    protected $_statement;

    public function __construct()
    {
        $this->setStatement();
    }

    protected function setStatement()
    {
        // set db script here
    }

    public function up()
    {
        $this->setStatement();
        $migrationName = get_class($this);
        $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        try {
            if(isset($this->_statement)) {
                $this->query($this->_statement);
            }
        } catch(ErrorException $e) {
            exit('Migration Err: '.$e->getMessage());
        }
        return array('success' => 1, 'type' => 'up', 'name' => $migrationName);
    }

    public function down()
    {
        // add clear up code here
    }
}