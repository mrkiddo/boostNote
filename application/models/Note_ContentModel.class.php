<?php

/**
 * Created by PhpStorm.
 * User: mrkiddo
 * Date: 2017/4/22
 * Time: 16:15
 */
class Note_ContentModel extends Model
{
    public function create($noteId, $title, $content) {
        return $this->add(array(
            'note_id' => $noteId,
            'title' => $title,
            'content' => $content
        ));
    }

    public function updateContent($noteId, $title, $content)
    {
        return $this->updateByCol('note_id', $noteId, array(
            'title' => $title,
            'content' => $content
        ));
    }

    public function disableContent($noteId)
    {
        return $this->updateByCol('note_id', $noteId, array(
            'disable' => 1
        ));
    }
}