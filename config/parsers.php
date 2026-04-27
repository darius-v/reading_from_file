<?php

/**
 * List of parser classes to register.
 * To add a new format: create a parser implementing ParserInterface and add its class here.
 */

use App\Parser\CsvParser;
use App\Parser\JsonParser;
use App\Parser\XmlParser;

return [
    CsvParser::class,
    XmlParser::class,
    JsonParser::class,
];
