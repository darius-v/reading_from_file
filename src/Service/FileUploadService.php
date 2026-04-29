<?php

namespace App\Service;

use App\Factory\ParserFactory;
use App\Validator\FileValidator;

/**
 * Validates and parses an uploaded file.
 */
class FileUploadService
{
    private FileValidator $validator;
    private ParserFactory $parserFactory;

    /**
     * @param FileValidator $validator
     * @param ParserFactory $parserFactory
     */
    public function __construct(FileValidator $validator, ParserFactory $parserFactory)
    {
        $this->validator     = $validator;
        $this->parserFactory = $parserFactory;
    }

    /**
     * Validates and parses the given file entry.
     *
     * @param  array<string, mixed> $file Entry from $_FILES.
     * @return array{0: string|null, 1: array<int, array<string, mixed>>}
     */
    public function process(array $file): array
    {
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

    /**
     * Returns a list of supported file extensions.
     *
     * @return array<int, string>
     */
    public function getSupportedExtensions(): array
    {
        return $this->parserFactory->getSupportedExtensions();
    }
}
