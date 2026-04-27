<?php

namespace App\Parser;

/**
 * Parses JSON file content into an array of associative rows.
 */
class JsonParser implements ParserInterface
{
    /**
     * @param  string $extension
     * @return bool
     */
    public function supports(string $extension): bool
    {
        return $extension === 'json';
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return 'json';
    }

    /**
     * @param  string $content Raw JSON content.
     * @return array<int, array<string, mixed>>
     * @throws \InvalidArgumentException If the JSON is invalid.
     */
    public function parse(string $content): array
    {
        $rows = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON: ' . json_last_error_msg());
        }

        return $rows;
    }
}
