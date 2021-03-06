<?php

/**
 * NoteModel Class
 */
class NotesModel extends Model
{
    /**
     * retrieve entries from db
     * @param int|string $userId
     * @param int|string $noteId
     * @return array
     */
    public function get($userId, $noteId)
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
                $tableName.'.shares',
                $tableName.'.disable',
                $contentTableName.'.id AS content_id',
                $contentTableName.'.title',
                $contentTableName.'.content'
            ))
            ->join('inner',$contentTableName, $tableName.".id = ".$contentTableName.".note_id")
            ->where($conditions)
            ->select();
    }

    /**
     * create a record for new note
     * @param array $data
     * @return array
     */
    public function create($data)
    {
        return $this->add(array(
            'owner_id' => $data['user_id'],
            'shares' => 0,
            'disable' => 0
        ));
    }

    /**
     * update a record
     * @param int|string $noteId
     * @param int|string $sharesNum
     * @return array
     */
    public function updateNote($noteId, $sharesNum = 0)
    {
        return $this->update($noteId, array(
            'last_update_time'=> date('Y-m-d G:i:s'),
            'shares' => $sharesNum
        ));
    }

    /**
     * disable a record
     * @param int|string $noteId
     * @return array
     */
    public function disable($noteId)
    {
        return $this->update($noteId, array(
            'disable'=> 1
        ));
    }
}