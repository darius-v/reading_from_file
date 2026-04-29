<?php

namespace Tests\unit\Parser\Format;

use App\Parser\Format\CsvParser;
use TestFramework\Support\Assert;

/**
 * Unit tests for CsvParser::parse().
 */
class CsvParserTest
{
    private CsvParser $parser;

    public function __construct()
    {
        $this->parser = new CsvParser();
    }

    /**
     * @return void
     */
    public function testBasicCsv(): void
    {
        echo "testBasicCsv\n";

        $rows = $this->parser->parse("name,age\nAlice,30\nBob,25");

        Assert::equals(2, count($rows), 'Two data rows');
        Assert::equals('Alice', $rows[0]['name'], 'First row name');
        Assert::equals('30', $rows[0]['age'], 'First row age');
        Assert::equals('Bob', $rows[1]['name'], 'Second row name');
    }

    /**
     * @return void
     */
    public function testBlankLineBecomesEmptyRow(): void
    {
        echo "testBlankLineBecomesEmptyRow\n";

        $rows = $this->parser->parse("name,age\nAlice,30\n\nBob,25");

        Assert::equals(3, count($rows), 'Blank line produces an extra row');
        Assert::equals(null, $rows[1]['name'], 'Blank line row has null name');
        Assert::equals('', $rows[1]['age'], 'Blank line row has empty age (padded)');
    }

    /**
     * @return void
     */
    public function testCommasOnlyRowRendersEmptyValues(): void
    {
        echo "testCommasOnlyRowRendersEmptyValues\n";

        $rows = $this->parser->parse("name,age\nAlice,30\n,\nBob,25");

        Assert::equals(3, count($rows), 'Three data rows including empty one');
        Assert::equals('', $rows[1]['name'], 'Empty row name is empty string');
        Assert::equals('', $rows[1]['age'], 'Empty row age is empty string');
    }

    /**
     * @return void
     */
    public function testShortRowIsPaddedWithEmptyStrings(): void
    {
        echo "testShortRowIsPaddedWithEmptyStrings\n";

        $rows = $this->parser->parse("name,age,city\nAlice,30");

        Assert::equals(1, count($rows), 'One data row');
        Assert::equals('Alice', $rows[0]['name'], 'Name present');
        Assert::equals('30', $rows[0]['age'], 'Age present');
        Assert::equals('', $rows[0]['city'], 'Missing city padded with empty string');
    }

    /**
     * @return void
     */
    public function testTrailingNewlineDoesNotAddRow(): void
    {
        echo "testTrailingNewlineDoesNotAddRow\n";

        $rows = $this->parser->parse("name,age\nAlice,30\n");

        Assert::equals(1, count($rows), 'Trailing newline does not produce extra row');
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->testBasicCsv();
        $this->testBlankLineBecomesEmptyRow();
        $this->testCommasOnlyRowRendersEmptyValues();
        $this->testShortRowIsPaddedWithEmptyStrings();
        $this->testTrailingNewlineDoesNotAddRow();
    }
}
