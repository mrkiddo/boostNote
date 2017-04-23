<?php

/**
 * Created by PhpStorm.
 * User: mrkiddo
 * Date: 2017/4/22
 * Time: 14:40
 */
class NotesModel extends Model
{
    public function getNotes($userId, $noteId = '')
    {
        $contentTableName = DB_TABLE_PREFIX.'note_content';
        $tableName = $this->getTableName();
        $conditions = array(
            $tableName.".owner_id = '".$userId."'",
            $tableName.".disable = 0"
        );
        if(!empty($noteId)) {
            array_push($conditions, $tableName.'.id = '.$noteId);
        }
        return $this
            ->field(array(
                $tableName.'.id AS note_id',
                $tableName.'.owner_id',
                $tableName.'.creation_time',
                $tableName.'.last_update_time',
                $tableName.'.disable',
                $contentTableName.'.id AS content_id',
                $contentTableName.'.title',
                $contentTableName.'.content'
            ))
            ->join('inner',$contentTableName, $tableName.".id = ".$contentTableName.".note_id")
            ->where(array($tableName.".owner_id = '".$userId."'", $tableName.".disable = 0"))
            ->select();
    }

    public function findAll($userId)
    {
        $records = $this->getNotes($userId);
        return array(
            'user_id' => $userId,
            'count' => count($records),
            'notes' => $records
        );
    }

    public function findOne($userId, $noteId)
    {
        $records = $this->getNotes($userId, $noteId);
        return array(
            'user_id' => $userId,
            'data' => $records
        );
    }

    public function create($data)
    {
        return $this->add(array(
            'owner_id' => $data['user_id'],
            'disable' => 0
        ));
    }

    public function updateNote($noteId)
    {
        return $this->update($noteId, array(
            'last_update_time'=> date('Y-m-d G:i:s')
        ));
    }

    public function disableNote($noteId)
    {
        return $this->update($noteId, array(
            'disable'=> 1
        ));
    }
}