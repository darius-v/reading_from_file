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
        Assert::contains('<td>Vytska</td>', $html, 'Table contains row: Vytska');
        Assert::contains('<td>Karina</td>', $html, 'Table contains row: Karina');
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
    }
}
