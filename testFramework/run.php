<?php

use TestFramework\Support\Assert;
use Tests\e2e\FileUploadTest;
use Tests\unit\Parser\Format\CsvParserTest;

function findPrefix(array $map, string $className): ?array
{
    foreach ($map as $prefix => $baseDir) {
        if (strncmp($prefix, $className, strlen($prefix)) === 0) {
            return [$prefix, $baseDir];
        }
    }
    return null;
}

// Registers a PSR-4 autoloader — instead of manually require-ing every file upfront, PHP calls this function
// automatically the moment it encounters an unknown class name. The file is only loaded when the class is first used,
// so if a test never instantiates XmlParser, that file is never loaded.
spl_autoload_register(function (string $className): void {
    $map = [
        'TestFramework\\' => __DIR__ . '/',
        'Tests\\'         => __DIR__ . '/../tests/',
        'App\\'           => __DIR__ . '/../src/',
    ];

    $match = findPrefix($map, $className);
    if ($match === null) {
        return;
    }

    [$prefix, $baseDir] = $match;
    $file = $baseDir . str_replace('\\', '/', substr($className, strlen($prefix))) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$baseUrl = $argv[1] ?? 'http://localhost:8080';

echo "Running tests against $baseUrl\n\n";

$tests = [
    new CsvParserTest(),
    new FileUploadTest($baseUrl),
];

foreach ($tests as $suite) {
    echo get_class($suite) . "\n";
    $suite->run();
    echo "\n";
}

Assert::summary();
