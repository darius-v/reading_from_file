<?php

namespace Tests;

use Tests\Support\Assert;
use Tests\Support\FormParser;
use Tests\Support\HttpClient;

/**
 * Tests for the file upload form and table rendering.
 */
class FileUploadTest
{
    private HttpClient $client;
    private string $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->client  = new HttpClient();
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Verifies the upload form is present on the home page.
     *
     * @return void
     */
    public function testFormIsVisible(): void
    {
        echo "testFormIsVisible\n";

        $html = $this->client->get($this->baseUrl . '/');

        Assert::hasTag($html, 'form', 'Page contains a form');
        Assert::contains('multipart/form-data', $html, 'Form has multipart encoding');
        Assert::hasTag($html, 'input', 'Form contains an input');
    }

    /**
     * Verifies that uploading a CSV file renders a table with the correct data.
     * Reads the form first to discover the actual file input name and action.
     *
     * @return void
     */
    public function testCsvUploadRendersTable(): void
    {
        echo "testCsvUploadRendersTable\n";

        $formHtml  = $this->client->get($this->baseUrl . '/');
        $action    = FormParser::extractFormAction($formHtml, $this->baseUrl);
        $fieldName = FormParser::extractFileInputName($formHtml);

        $html = $this->client->post(
            $action,
            [],
            [$fieldName => __DIR__ . '/fixtures/test.csv']
        );

        Assert::hasTag($html, 'table', 'Response contains a table');
        Assert::contains('<th>first_name</th>', $html, 'Table has first_name column');
        Assert::contains('<th>age</th>', $html, 'Table has age column');
        Assert::contains('<th>gender</th>', $html, 'Table has gender column');
        Assert::contains('<td>Kiestis</td>', $html, 'Table contains row: Kiestis');
        Assert::contains('<td>CsvUser</td>', $html, 'Table contains csv marker row');
        Assert::contains('<td>csv</td>', $html, 'Table contains csv gender marker');
    }

    /**
     * Verifies that uploading an XML file renders a table with the correct data.
     * Reads the form first to discover the actual file input name and action.
     *
     * @return void
     */
    public function testXmlUploadRendersTable(): void
    {
        echo "testXmlUploadRendersTable\n";

        $formHtml  = $this->client->get($this->baseUrl . '/');
        $action    = FormParser::extractFormAction($formHtml, $this->baseUrl);
        $fieldName = FormParser::extractFileInputName($formHtml);

        $html = $this->client->post(
            $action,
            [],
            [$fieldName => __DIR__ . '/fixtures/test.xml']
        );

        Assert::hasTag($html, 'table', 'Response contains a table');
        Assert::contains('<th>first_name</th>', $html, 'Table has first_name column');
        Assert::contains('<th>age</th>', $html, 'Table has age column');
        Assert::contains('<th>gender</th>', $html, 'Table has gender column');
        Assert::contains('<td>Kiestis</td>', $html, 'Table contains row: Kiestis');
        Assert::contains('<td>XmlUser</td>', $html, 'Table contains xml marker row');
        Assert::contains('<td>xml</td>', $html, 'Table contains xml gender marker');
    }

    /**
     * Verifies that uploading a JSON file renders a table with the correct data.
     * Reads the form first to discover the actual file input name and action.
     *
     * @return void
     */
    public function testJsonUploadRendersTable(): void
    {
        echo "testJsonUploadRendersTable\n";

        $formHtml  = $this->client->get($this->baseUrl . '/');
        $action    = FormParser::extractFormAction($formHtml, $this->baseUrl);
        $fieldName = FormParser::extractFileInputName($formHtml);

        $html = $this->client->post(
            $action,
            [],
            [$fieldName => __DIR__ . '/fixtures/test.json']
        );

        Assert::hasTag($html, 'table', 'Response contains a table');
        Assert::contains('<th>first_name</th>', $html, 'Table has first_name column');
        Assert::contains('<th>age</th>', $html, 'Table has age column');
        Assert::contains('<th>gender</th>', $html, 'Table has gender column');
        Assert::contains('<td>Kiestis</td>', $html, 'Table contains row: Kiestis');
        Assert::contains('<td>JsonUser</td>', $html, 'Table contains row: JsonUser');
        Assert::contains('<td>json</td>', $html, 'Table contains json gender marker');
    }

    /**
     * Verifies that submitting the form without a file shows an error.
     *
     * @return void
     */
    public function testNoFileShowsError(): void
    {
        echo "testNoFileShowsError\n";

        $formHtml = $this->client->get($this->baseUrl . '/');
        $action   = FormParser::extractFormAction($formHtml, $this->baseUrl);

        $html = $this->client->post($action);

        Assert::contains('No file uploaded or upload failed.', $html, 'Shows no-file error');
        Assert::hasNoTag($html, 'table', 'No table shown on error');
    }

    /**
     * Verifies that uploading an unsupported format shows an error.
     *
     * @return void
     */
    public function testUnsupportedFormatShowsError(): void
    {
        echo "testUnsupportedFormatShowsError\n";

        $formHtml  = $this->client->get($this->baseUrl . '/');
        $action    = FormParser::extractFormAction($formHtml, $this->baseUrl);
        $fieldName = FormParser::extractFileInputName($formHtml);

        $html = $this->client->post($action, [], [$fieldName => __DIR__ . '/fixtures/test.txt']);

        Assert::contains('Unsupported file format', $html, 'Shows unsupported format error');
        Assert::hasNoTag($html, 'table', 'No table shown on error');
    }

    /**
     * Verifies that uploading an empty file shows an error.
     *
     * @return void
     */
    public function testEmptyFileShowsError(): void
    {
        echo "testEmptyFileShowsError\n";

        $formHtml  = $this->client->get($this->baseUrl . '/');
        $action    = FormParser::extractFormAction($formHtml, $this->baseUrl);
        $fieldName = FormParser::extractFileInputName($formHtml);

        $html = $this->client->post($action, [], [$fieldName => __DIR__ . '/fixtures/empty.csv']);

        Assert::contains('The uploaded file is empty.', $html, 'Shows empty file error');
        Assert::hasNoTag($html, 'table', 'No table shown on error');
    }

    /**
     * Runs all tests in this class.
     *
     * @return void
     */
    public function run(): void
    {
        $this->testFormIsVisible();
        $this->testCsvUploadRendersTable();
        $this->testXmlUploadRendersTable();
        $this->testJsonUploadRendersTable();
        $this->testNoFileShowsError();
        $this->testUnsupportedFormatShowsError();
        $this->testEmptyFileShowsError();
    }
}
