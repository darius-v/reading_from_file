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
     * Validates the uploaded file and returns the first error message, or null if valid.
     *
     * @param  array $file Entry from $_FILES.
     * @return string|null
     */
    public function validate(array $file): ?string
    {
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return 'No file uploaded or upload failed.';
        }

        if (empty($file['size'])) {
            return 'The uploaded file is empty.';
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $supported = $this->parserFactory->getSupportedExtensions();

        if (!in_array($extension, $supported, true)) {
            return sprintf(
                'Unsupported file format ".%s". Allowed: %s.',
                $extension,
                implode(', ', $supported)
            );
        }

        return null;
    }
}
