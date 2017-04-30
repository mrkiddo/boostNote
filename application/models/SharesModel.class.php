<?php

/**
 * Shares Model
 */
class SharesModel extends Model
{
    /**
     * validate data input
     * @param array $data
     * @return bool
     */
    public function validateData($data)
    {
        if(!isset($data['type']) || empty($data['type'])) {
            return false;
        }
        else if(!isset($data['target_id']) || empty($data['target_id'])) {
            if(intval($data['type']) === SHARE_LEVEL_USER) {
                return false;
            }
        }
        else if(!isset($data['type']) || empty($data['type'])) {
            if(intval($data['type']) === SHARE_LEVEL_EMAIL ||
                intval($data['type']) === SHARE_LEVEL_USER) {
                return false;
            }
        }
        else if(!isset($data['expiry_date']) || empty($data['expiry_date'])) {
            return false;
        }
        return true;
    }

    /**
     * get shares by user_id or by note_id
     * @param int|string $userId
     * @param int|string $noteId
     * @return array
     */
    public function get($userId = 0, $noteId = 0)
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

    /**
     * get user's all shares
     * @param int|string $userId
     * @return array
     */
    public function findAllByUser($userId)
    {
        $records = $this->get($userId);
        $results = array();
        foreach($records as $record) {
            $noteId = $record['note_id'];
            if(isset($noteId) && !empty($noteId)) {
                if(isset($results[$noteId])) {
                    array_push($results[$noteId], $record);
                }
                else {
                    $results[$noteId] = array();
                    array_push($results[$noteId], $record);
                }
            }
        }
        return array(
            'user_id' => $userId,
            'count' => count($records),
            'shares' => $results
        );
    }

    /**
     * get note's all shares
     * @param int|string $noteId
     * @return array
     */
    public function findAllByNote($noteId)
    {
        $records = $this->get(null, $noteId);
        return array(
            'note_id' => $noteId,
            'count' => count($records),
            'shares' => $records
        );
    }

    /**
     * @param int|string $shareId
     * @return array
     */
    public function findById($shareId)
    {
        $record = $this->selectById($shareId);
        return array(
            'shares' => $record
        );
    }

    /**
     * @param int|string $userId
     * @param int|string $noteId
     * @param array $data
     * @return array
     */
    public function create($userId, $noteId, $data)
    {
        $newData = array(
            'owner_id' => $userId,
            'note_id' => $noteId,
            'type' => $data['type'],
            'target_id' => isset($data['target_id']) ? $data['target_id'] : '',
            'target_email' => isset($data['target_email']) ? $data['target_email'] : '',
            'expiry_date' => $data['expiry_date'],
            'disable' => 0
        );
        return $this->add($newData);
    }

    /**
     * @param int|string $shareId
     * @return bool
     */
    public function disable($shareId)
    {
        return $this->update($shareId, array(
            'disable' => 1
        ));
    }
}