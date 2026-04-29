<?php

namespace App\Controller;

use App\Factory\ParserFactory;
use App\Http\Request;
use App\Validator\FileValidator;

/**
 * Handles file upload and parsed data display.
 */
class FileController
{
    private ParserFactory $parserFactory;
    private FileValidator $validator;
    private Request $request;

    /**
     * @param ParserFactory $parserFactory
     * @param FileValidator $validator
     * @param Request       $request
     */
    public function __construct(ParserFactory $parserFactory, FileValidator $validator, Request $request)
    {
        $this->parserFactory = $parserFactory;
        $this->validator     = $validator;
        $this->request       = $request;
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
            [$error, $rows] = $this->handleUpload();
        }

        $supported = $this->parserFactory->getSupportedExtensions();

        require __DIR__ . '/../../views/upload.php';
    }

    /**
     * Validates the uploaded file and parses its contents.
     *
     * @return array{0: string|null, 1: array<int, array<string, mixed>>}
     */
    private function handleUpload(): array
    {
        $file  = $this->request->getFile('file');
        $error = $this->validator->validate($file);

        if ($error !== null) {
            return [$error, []];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        try {
            $parser = $this->parserFactory->create($extension);
            $rows   = $parser->parse(file_get_contents($file['tmp_name']));
        } catch (\InvalidArgumentException $e) {
            return [$e->getMessage(), []];
        }

        return [null, $rows];
    }
}
