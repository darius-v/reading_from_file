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
     * @param  string $content Raw file content.
     * @return array<int, array<string, mixed>> Associative rows keyed by column name.
     */
    public function parse(string $content): array;
}
