<?php

/**
 * Migration controller
 */
class MigrationController extends Controller
{
    public function index()
    {
        $fileService = new FileService();
        $results = $fileService->runMigration();
        $this->assign('title', 'Migrations');
        $this->assign('results', $results);
        $this->render();
    }
}