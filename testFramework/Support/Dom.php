<?php

namespace TestFramework\Support;

/**
 * Utility for parsing HTML strings into a DOMDocument.
 */
class Dom
{
    /**
     * Parses an HTML string and returns a DOMDocument.
     * Uses internal error handling to suppress warnings for minor HTML issues (missing doctype, etc.).
     *
     * @param  string $html
     * @return \DOMDocument
     */
    public static function parse(string $html): \DOMDocument
    {
        $dom = new \DOMDocument();
        // loadHTML emits warnings for minor HTML issues (missing doctype, etc.) — suppress them cleanly.
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        return $dom;
    }
}
