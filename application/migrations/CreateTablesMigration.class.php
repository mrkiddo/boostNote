<?php

/**
 * Create tables
 */
class CreateTablesMigration extends Migration
{
    protected function setStatement()
    {
        $sql1 = array(
            "CREATE TABLE IF NOT EXISTS `bn_users`",
            "(",
                "`id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,",
                "`email` VARCHAR(255) NOT NULL,",
                "`password` VARCHAR(32) NOT NULL,",
                "`creation_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,",
                "`first_name` VARCHAR(255) NULL,",
                "`last_name` VARCHAR(255) NULL,",
                "`disable` INT(1) NOT NULL DEFAULT 0,",
                "INDEX users_email_index (email)",
            ")",
            "ENGINE = INNODB, AUTO_INCREMENT = 1000;"
        );
        $sql2 = array(
            "CREATE TABLE IF NOT EXISTS `bn_notes`",
            "(",
                "`id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,",
                "`owner_id` BIGINT UNSIGNED NOT NULL,",
                "`creation_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,",
                "`last_update_time` TIMESTAMP NULL,",
                "`disable` INT(1) NOT NULL DEFAULT 0,",
                "`shares` INT(10) NOT NULL DEFAULT 0",
                "FOREIGN KEY fk_users_id_notes_owner_id(owner_id) REFERENCES bn_users(id) ON UPDATE CASCADE ON DELETE RESTRICT",
            ")",
            "ENGINE = INNODB, AUTO_INCREMENT = 10000;"
        );
        $sql3 = array(
            "CREATE TABLE IF NOT EXISTS `bn_note_content`",
            "(",
                "`id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,",
                "`note_id` BIGINT UNSIGNED NOT NULL,",
                "`title` VARCHAR(255),",
                "`content` TEXT,",
                "`disable` INT(1) DEFAULT 0",
                "FOREIGN KEY fk_notes_id_note_content_note_id(note_id) REFERENCES bn_notes(id)",
            ")",
            "ENGINE = INNODB;"
        );
        $sql4 = array(
            "CREATE TABLE IF NOT EXISTS `bn_shares`",
            "(",
                "`id` BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,",
                "`note_id` BIGINT UNSIGNED NOT NULL,",
                "`owner_id` BIGINT UNSIGNED NOT NULL,",
                "`creation_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,",
                "`type` INT(2) NOT NULL,",
                "`target_id` BIGINT UNSIGNED NULL,",
                "`target_email` VARCHAR(255) NULL,",
                "`expiry_time` TIMESTAMP NULL,",
                "`disable` INT(1) NOT NULL DEFAULT 0,",
                "FOREIGN KEY fk_notes_id_shares_note_id(note_id) REFERENCES bn_notes(id),",
                "FOREIGN KEY fk_users_id_shares_owner_id(owner_id) REFERENCES bn_users(id)",
            ")",
            "ENGINE = INNODB;"
        );
        $sql = implode(' ', $sql1).implode(' ', $sql2).implode(' ', $sql3).implode('', $sql4);
        $this->_statement = $sql;
    }
}