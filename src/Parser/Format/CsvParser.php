<?php

namespace App\Parser\Format;

use App\Parser\ParserInterface;

/**
 * Parses CSV file content into an array of associative rows.
 */
class CsvParser implements ParserInterface
{
    /**
     * @param  string $content Raw CSV content.
     * @return array<int, array<string, mixed>>
     */
    public function parse(string $content): array
    {
        $lines = explode("\n", trim($content));
        $rows  = array_map(fn($line) => $this->parseLine($line), array_values($lines));

        $headers = array_shift($rows);

        return array_map(fn($row) => array_combine($headers, array_pad($row, count($headers), '')), $rows);
    }

    /**
     * @param  string $extension
     * @return bool
     */
    public function supports(string $extension): bool
    {
        return $extension === 'csv';
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return 'csv';
    }

    /**
     * Splits a CSV line and strips surrounding single quotes.
     *
     * @param  string $line
     * @return array<int, string>
     */
    private function parseLine(string $line): array
    {
        return array_map(
            fn($value) => trim($value, "' \t"),
            explode(',', $line)
        );
    }
}
