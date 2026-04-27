<?php

namespace App\Parser;

use Exception;

/**
 * Parses XML file content into an array of associative rows.
 * Expects a root element containing repeated child elements (items/item).
 */
class XmlParser implements ParserInterface
{
    /**
     * @throws Exception
     * @return array<int, array<string, mixed>>
     * @param string $content Raw XML content.
     */
    public function parse(string $content): array
    {
        $xml  = new \SimpleXMLElement($content);
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
