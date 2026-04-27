<?php

namespace Tests\Support;

/**
 * Extracts form attributes from an HTML response using DOMDocument.
 */
class FormParser
{
    /**
     * Returns the name attribute of the first file input found in the form.
     *
     * @param  string $html
     * @return string
     * @throws \RuntimeException If no file input is found.
     */
    public static function extractFileInputName(string $html): string
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        foreach ($dom->getElementsByTagName('input') as $input) {
            if ($input->getAttribute('type') === 'file') {
                return $input->getAttribute('name');
            }
        }

        throw new \RuntimeException('No file input found in form.');
    }

    /**
     * Returns the resolved action URL of the first form on the page.
     * Falls back to $baseUrl if the action is empty or relative.
     *
     * @param  string $html
     * @param  string $baseUrl
     * @return string
     */
    public static function extractFormAction(string $html, string $baseUrl): string
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $forms = $dom->getElementsByTagName('form');

        if ($forms->length === 0) {
            throw new \RuntimeException('No form found on page.');
        }

        $action = $forms->item(0)->getAttribute('action');

        return $action !== '' ? $action : $baseUrl . '/';
    }
}
