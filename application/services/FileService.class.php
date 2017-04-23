<?php

/**
 * File Service
 */
class FileService
{
    public function getAllFileNames($dir)
    {
        $files = array();
        if(is_dir($dir)) {
            $handler = opendir($dir);
            while(($fileName = readdir($handler)) !== false) {
                if($fileName != '.' && $fileName != '..') {
                    $files[] = $fileName;
                }
            }
            closedir($handler);
        }
        return $files;
    }

    public function getMigrationFiles()
    {
        $filesFullPath = array();
        $files = $this->getAllFileNames(MIGRATION_DIR);
        foreach($files as $file) {
            $filesFullPath[] = array('fileName' => $file);
        }
        return $filesFullPath;
    }

    public function runMigration()
    {
        $results = array();
        $files = $this->getMigrationFiles();
        foreach($files as $file) {
            $className = explode('.', $file['fileName'])[0];
            $migration = new $className();
            if((int)method_exists($migration, 'up')) {
                $results[] = $migration->up();
            }
        }
        return $results;
    }
}