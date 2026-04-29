<?php

namespace App\Parser;

/**
 * Contract for all file parsers.
 */
interface ParserInterface
{
    /**
     * Parses raw file content into an array of rows.
     *
     * Example return value:
     * [
     *   ['first_name' => 'Alice', 'age' => '30'],
     *   ['first_name' => 'Bob', 'age' => '25'],
     * ]
     *
     * @param  string $content Raw file content.
     * @return array<int, array<string, mixed>>
     */
    public function parse(string $content): array;

    /**
     * Returns true if this parser handles the given file extension.
     *
     * @param  string $extension Lowercase file extension (e.g. "csv").
     * @return bool
     */
    public function supports(string $extension): bool;

    /**
     * Returns the file extension this parser handles.
     *
     * @return string
     */
    public function getExtension(): string;
}
