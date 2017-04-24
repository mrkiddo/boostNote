<?php

/**
 * Shares Model
 */
class SharesModel extends Model
{
    public function validateData($data)
    {}

    public function getShares($userId = 0, $noteId = 0, $shareId = 0)
    {
        $tableName = $this->getTableName();
        $conditions = array(
            $tableName.".disable = 0"
        );
        if($userId) {
            array_push($conditions, $tableName.".owner_id = '".$userId."'");
            return $this->where($conditions)->select();
        }
        else if($noteId) {
            array_push($conditions, $tableName.".note_id = '".$noteId."'");
            return $this->where($conditions)->select();
        }
        else {
            return array();
        }
    }

    public function findAllByUser($userId)
    {
        $records = $this->getShares($userId);
        return array(
            'user_id' => $userId,
            'count' => count($records),
            'shares' => $records
        );
    }

    public function findAllByNote($noteId)
    {
        $records = $this->getShares(null, $noteId);
        return array(
            'note_id' => $noteId,
            'count' => count($records),
            'shares' => $records
        );
    }

    public function findById($shareId)
    {
        $record = $this->selectById($shareId);
        return array(
            'shares' => $record
        );
    }
}