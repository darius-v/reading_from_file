<?php

namespace TestFramework\Support;

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
        $dom = Dom::parse($html);

        foreach ($dom->getElementsByTagName('input') as $input) {
            if ($input->getAttribute('type') === 'file') {
                return $input->getAttribute('name');
            }
        }

        throw new \RuntimeException('No file input found in form.');
    }

}
