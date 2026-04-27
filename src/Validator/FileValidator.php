<?php

namespace App\Validator;

use App\Factory\ParserFactory;

/**
 * Validates an uploaded file before parsing.
 * Checks upload integrity, supported format, and non-empty content.
 */
class FileValidator
{
    private ParserFactory $parserFactory;

    /**
     * @param ParserFactory $parserFactory Used to determine supported extensions.
     */
    public function __construct(ParserFactory $parserFactory)
    {
        $this->parserFactory = $parserFactory;
    }

    /**
     * Validates the uploaded file and returns a list of errors.
     *
     * @param  array $file Entry from $_FILES.
     * @return string[]
     */
    public function validate(array $file): array
    {
        $errors = [];

        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'No file uploaded or upload failed.';
            return $errors;
        }

        if (empty($file['size'])) {
            $errors[] = 'The uploaded file is empty.';
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $supported = $this->parserFactory->getSupportedExtensions();

        if (!in_array($extension, $supported, true)) {
            $errors[] = sprintf(
                'Unsupported file format ".%s". Allowed: %s.',
                $extension,
                implode(', ', $supported)
            );
        }

        return $errors;
    }
}
