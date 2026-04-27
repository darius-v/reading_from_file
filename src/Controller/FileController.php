<?php

namespace App\Controller;

use App\Factory\ParserFactory;

/**
 * Handles file upload and parsed data display.
 */
class FileController
{
    private ParserFactory $parserFactory;

    /**
     * @param ParserFactory $parserFactory
     */
    public function __construct(ParserFactory $parserFactory)
    {
        $this->parserFactory = $parserFactory;
    }

    /**
     * Renders the upload form.
     * On POST, validates the file, parses it, and passes data to the view.
     *
     * @return void
     */
    public function index(): void
    {
        $errors = [];
        $rows   = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [$errors, $rows] = $this->handleUpload();
        }

        $supported = $this->parserFactory->getSupportedExtensions();

        require __DIR__ . '/../../views/upload.php';
    }

    /**
     * Validates the uploaded file and parses its contents.
     *
     * @return array{0: string[], 1: array<int, array<string, mixed>>}
     */
    private function handleUpload(): array
    {
        $file = $_FILES['file'] ?? null;

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return [['No file uploaded or upload error.'], []];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        try {
            $parser = $this->parserFactory->create($extension);
        } catch (\InvalidArgumentException $e) {
            return [[$e->getMessage()], []];
        }

        $content = file_get_contents($file['tmp_name']);
        $rows    = $parser->parse($content);

        return [[], $rows];
    }
}
