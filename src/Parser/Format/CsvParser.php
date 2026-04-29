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

        return array_map(fn($row) => $this->combineWithHeaders($headers, $row), $rowsAsArrays);
    }

    /**
     * Maps a row to its headers, e.g. ['name', 'age'] + ['Alice', '30'] => ['name' => 'Alice', 'age' => '30'].
     * Short rows are padded with empty strings to prevent array_combine from crashing.
     *
     * @param  array<int, string> $headers
     * @param  array<int, string> $row
     * @return array<string, string>
     */
    private function combineWithHeaders(array $headers, array $row): array
    {
        // for case when csv is with blank line like: "name,age\nAlice,30\n\nBob,25"
        $padded = array_pad($row, count($headers), '');

        return array_combine($headers, $padded);
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
