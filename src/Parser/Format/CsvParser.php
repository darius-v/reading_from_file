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
        // row example: 'Kiestis,29,male'
        $rowsAsStrings = str_getcsv(trim($content), separator: "\n", escape: '');
        // row example: ['Kiestis', '29', 'male']
        $rowsAsArrays = array_map(fn($line) => str_getcsv($line, escape: ''), $rowsAsStrings);
        $headers = array_shift($rowsAsArrays);

        return array_map(fn($row) => array_combine($headers, array_pad($row, count($headers), '')), $rowsAsArrays);
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
}
