<?php

namespace App\Controller;

/**
 * Handles file upload and parsing actions.
 */
class FileController
{
    /**
     * Renders the file upload form.
     *
     * @return void
     */
    public function index(): void
    {
        require __DIR__ . '/../../views/upload.php';
    }
}
