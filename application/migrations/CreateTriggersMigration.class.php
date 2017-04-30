<?php

/**
 *
 */
class CreateTriggersMigration extends Migration
{
    protected function setStatement()
    {
       $triggerLastUpdateTime = array(
           "DELIMITER $$",
           "DROP TRIGGER IF EXISTS note_content_after_update $$",
           "CREATE TRIGGER note_content_after_update AFTER UPDATE",
           "ON bn_note_content FOR EACH ROW",
           "IF NEW.title != OLD.title OR NEW.content != OLD.content THEN",
           "UPDATE bn_notes SET bn_notes.last_update_time = now()",
           "WHERE new.note_id = bn_notes.id;",
           "UPDATE bn_shares SET bn_shares.disable = 1",
           "WHERE",
           "END IF;",
           "$$",
           "DELIMITER ;"
       );

       $triggerDisable = array(
           "DELIMITER $$",
           "DROP TRIGGER IF EXISTS notes_after_update $$",
           "CREATE TRIGGER notes_after_update AFTER UPDATE",
           "ON bn_notes",
           "FOR EACH ROW",
           "BEGIN",
           "IF NEW.disable = 1 THEN",
           "UPDATE bn_note_content SET bn_note_content.disable = 1",
           "WHERE NEW.id = bn_note_content.note_id;",
           "UPDATE bn_shares SET bn_shares.disable = 1",
           "WHERE NEW.id = bn_shares.note_id;",
           "END IF;",
           "END",
           "$$",
           "DELIMITER ;"
       );

       $triggerShareCount = array(
           "DELIMITER $$",
           "DROP TRIGGER IF EXISTS shares_after_insert $$",
           "CREATE TRIGGER shares_after_insert AFTER INSERT ON bn_shares",
           "FOR EACH ROW",
           "BEGIN",
           "SET @c = 0;",
           "SET @c = (SELECT COUNT(bn_shares.id) FROM bn_shares WHERE NEW.note_id = bn_shares.note_id);",
           "UPDATE bn_notes SET bn_notes.shares = @c WHERE NEW.note_id = bn_notes.id;",
           "END $$",
           "DELIMITER ;"
        );

       $sql = implode(' ', $triggerLastUpdateTime)
                .implode(' ', $triggerDisable)
                .implode(' ', $triggerShareCount);
       $this->_statement = $sql;
    }
}