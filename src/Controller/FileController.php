<?php

namespace App\Controller;

use App\Factory\ParserFactory;
use App\Validator\FileValidator;

/**
 * Handles file upload and parsed data display.
 */
class FileController
{
    private ParserFactory $parserFactory;
    private FileValidator $validator;

    /**
     * @param ParserFactory $parserFactory
     * @param FileValidator $validator
     */
    public function __construct(ParserFactory $parserFactory, FileValidator $validator)
    {
        $this->parserFactory = $parserFactory;
        $this->validator     = $validator;
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
        $file   = $_FILES['file'] ?? [];
        $errors = $this->validator->validate($file);

        if (!empty($errors)) {
            return [$errors, []];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        try {
            $parser = $this->parserFactory->create($extension);
            $rows   = $parser->parse(file_get_contents($file['tmp_name']));
        } catch (\InvalidArgumentException $e) {
            return [[$e->getMessage()], []];
        }

        return [[], $rows];
    }
}
