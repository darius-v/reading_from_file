<?php

namespace App\Controller;

use App\Http\Request;
use App\Service\FileUploadService;

/**
 * Handles file upload and parsed data display.
 */
class FileController
{
    private FileUploadService $service;
    private Request $request;

    /**
     * @param FileUploadService $fileUploadService
     * @param Request           $request
     */
    public function __construct(FileUploadService $fileUploadService, Request $request)
    {
        $this->service = $fileUploadService;
        $this->request = $request;
    }

    /**
     * Renders the upload form.
     * On POST, validates the file, parses it, and passes data to the view.
     *
     * @return void
     */
    public function index(): void
    {
        $error = null;
        $rows  = [];

        if ($this->request->getMethod() === 'POST') {
            try {
                [$error, $rows] = $this->service->process($this->request->getFile('file'));
            } catch (\RuntimeException) {
                // Not a possible case from UI, the user cannot submit a form without a file.
                // But possible with tools like curl.
                $error = 'No file uploaded or upload failed.';
            }
        }

        $supported = $this->service->getSupportedExtensions();

        require __DIR__ . '/../../views/upload.php';
    }
}
