<?php

/**
 * Sql base class
 */
class Sql
{
    protected $_dbHandle;
    protected $_result;
    private $fields = '*';
    private $filter = '';
    private $orders = '';
    private $joins = '';
    private $limits = '';

    /**
     * connect to db
     * @param string $host
     * @param string $user
     * @param string $pwd
     * @param string $dbname
     */
    public function connect($host, $user, $pwd, $dbname)
    {
        try {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8;", $host, $dbname);
            $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            $this->_dbHandle = new PDO($dsn, $user, $pwd, $option);
        } catch (PDOException $e) {
            exit('DB Connect Err: '.$e->getMessage());
        }
    }

    public function where($where = array())
    {
        if(isset($where)) {
            $this->filter .= ' WHERE ';
            for($i = 0; $i < count($where); $i++) {
                if($i > 0) {
                    $this->filter .= ' AND '.$where[$i];
                }
                else {
                    $this->filter .= $where[$i];
                }
            }
        }
        return $this;
    }

    public function order($order = array())
    {
        if(isset($order)) {
            $this->orders .= ' ORDER BY ';
            $this->orders .= implode(' ', $order);
        }
        return $this;
    }

    public function field($fields = array())
    {
        if(isset($fields)) {
            $this->fields = implode(',', $fields);
        }
        return $this;
    }

    /**
     * join current table with other tables
     * @param string $type
     * @param string $table
     * @param string $reference
     * @return object $this
     */
    public function join($type = 'inner', $table, $reference)
    {
        $type = strtoupper($type);
        if(isset($table) && isset($reference)) {
            $this->joins .= ' ';
            $this->joins .= $type.' JOIN '.$table.' ON '.$reference;
        }
        return $this;
    }

    public function limit($number)
    {
        if(isset($number) && $number > 0) {
            $this->limits .= ' LIMIT ';
            $this->limits .= $number;
        }
        return $this;
    }

    /**
     * retrieve entries from dd
     * @return array
     */
    public function select()
    {
        $sql = sprintf("SELECT %s FROM `%s` %s %s %s %s",
                $this->fields,
                $this->_table,
                $this->joins,
                $this->filter,
                $this->limits,
                $this->orders);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function selectById($id)
    {
        $sql = sprintf("SELECT %s FROM `%s` WHERE `id` = '%s'", $this->fields, $this->_table, $id);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        return $sth->fetch();
    }

    public function delete($id)
    {
        $sql = sprintf("DELETE FROM `%s` WHERE `id` = '%s'", $this->_table, $id);
        return $this->query($sql);
    }

    /**
     * perform query for db and return query results
     * @param string $sql
     * @return array|boolean
     */
    public function query($sql)
    {
        $sth = $this->_dbHandle->prepare($sql);
        $result = $sth->execute();
        return $result ? $sth->rowCount() : false;
    }

    public function add($data)
    {
        $sql = sprintf("INSERT INTO `%s` %s", $this->_table, $this->formatInsert($data));
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();
        $rowCount = $sth->rowCount();
        $newId = $this->_dbHandle->lastInsertId();
        return array(
            'count' => $rowCount,
            'id' => $newId
        );
    }

    public function update($id, $data)
    {
        $sql = sprintf("UPDATE `%s` SET %s WHERE `id` = '%s'", $this->_table, $this->formatUpdate($data), $id);
        return $this->query($sql);
    }

    public function updateByCol($colName, $colValue, $data)
    {
        $sql = sprintf("UPDATE `%s` SET %s WHERE `%s` = '%s'", $this->_table, $this->formatUpdate($data), $colName, $colValue);
        return $this->query($sql);
    }

    private function formatInsert($data)
    {
        $fields = array();
        $values = array();
        foreach($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $values[] = sprintf("'%s'", $value);
        }
        $field = implode(',', $fields);
        $value = implode(',', $values);

        return sprintf("(%s) VALUES (%s)", $field, $value);
    }

    private function formatUpdate($data)
    {
        $fields = array();
        foreach($data as $key => $value) {
            $fields[] = sprintf("`%s` = '%s'", $key, $value);
        }
        return implode(',', $fields);
    }
}