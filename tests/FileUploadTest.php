<?php

namespace Tests;

use Tests\Support\Assert;
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
     * Runs all tests in this class.
     *
     * @return void
     */
    public function run(): void
    {
        $this->testFormIsVisible();
    }
}
