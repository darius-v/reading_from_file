<?php

/**
 * Maps file extensions to their parser class.
 * To add a new format: add an entry here and create the corresponding parser.
 */
return [
    'csv'  => \App\Parser\CsvParser::class,
    'xml'  => \App\Parser\XmlParser::class,
    'json' => \App\Parser\JsonParser::class,
];
