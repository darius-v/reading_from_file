<?php

namespace TestFramework\Support;

/**
 * Thin curl wrapper for making HTTP requests in tests.
 */
class HttpClient
{
    /**
     * @param string $url
     * @return string
     */
    public function get(string $url): string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response as string instead of printing it
        return curl_exec($ch);
    }

    /**
     * @param string $url
     * @param array  $fields   POST fields
     * @param array  $files    ['fieldName' => '/path/to/file']
     * @return string
     */
    public function post(string $url, array $fields = [], array $files = []): string
    {
        $postData = $fields;

        foreach ($files as $fieldName => $filePath) {
            $postData[$fieldName] = new \CURLFile($filePath);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return response as string instead of printing it
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        return curl_exec($ch);
    }
}
