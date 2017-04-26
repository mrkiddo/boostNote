<?php

/**
 * Note_Content Model
 */
class Note_ContentModel extends Model
{
    /**
     * create note content record
     * @param string|number $noteId
     * @param string $title
     * @param string $content
     * @return array
     */
    public function create($noteId, $title, $content) {
        return $this->add(array(
            'note_id' => $noteId,
            'title' => $title,
            'content' => $content
        ));
    }

    /**
     * update note content
     * @param string|number $noteId
     * @param string $title
     * @param string $content
     * @return array
     */
    public function updateContent($noteId, $title, $content)
    {
        return $this->updateByCol('note_id', $noteId, array(
            'title' => $title,
            'content' => $content
        ));
    }

    /**
     * disable content for a disabled note
     * @param string|number $noteId
     * @return array
     */
    public function disableContent($noteId)
    {
        return $this->updateByCol('note_id', $noteId, array(
            'disable' => 1
        ));
    }
}