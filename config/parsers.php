<?php

/**
 * Auto-discovers all classes in src/Parser/ that implement ParserInterface.
 * To add a new format: create a parser implementing ParserInterface in src/Parser/ — no config change needed.
 */

use App\Parser\ParserDiscovery;

$discovery = new ParserDiscovery(
    __DIR__ . '/../src/Parser',
    'App\\Parser'
);

return $discovery->discover();
