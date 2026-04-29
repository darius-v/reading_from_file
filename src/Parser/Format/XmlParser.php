<?php

namespace App\Parser\Format;

use App\Parser\ParserInterface;

/**
 * Parses XML file content into an array of associative rows.
 * Expects a root element containing repeated child elements (items/item).
 */
class XmlParser implements ParserInterface
{
    /**
     * @param  string $extension
     * @return bool
     */
    public function supports(string $extension): bool
    {
        return $extension === 'xml';
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return 'xml';
    }

    /**
     * @param  string $content Raw XML content.
     * @return array<int, array<string, mixed>>
     * @throws \InvalidArgumentException If the XML is malformed.
     */
    public function parse(string $content): array
    {
        libxml_use_internal_errors(true);

        try {
            $xml = new \SimpleXMLElement($content);
        } catch (\Exception $e) {
            libxml_clear_errors();
            throw new \InvalidArgumentException('Invalid XML: ' . $e->getMessage());
        } finally {
            // resets it back to false so the rest of the application isn't affected by this parser's setting.
            libxml_use_internal_errors(false);
        }
        $rows = [];

        foreach ($xml->children() as $child) {
            $row = [];
            foreach ($child as $key => $value) {
                $row[$key] = (string) $value;
            }
            $rows[] = $row;
        }

        return $rows;
    }
}
