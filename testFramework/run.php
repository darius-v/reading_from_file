<?php

use TestFramework\Support\Assert;
use Tests\e2e\FileUploadTest;
use Tests\unit\Parser\Format\CsvParserTest;

spl_autoload_register(function (string $className): void {
    $map = [
        'TestFramework\\' => __DIR__ . '/',
        'Tests\\'         => __DIR__ . '/../tests/',
        'App\\'           => __DIR__ . '/../src/',
    ];

    foreach ($map as $prefix => $baseDir) {
        if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
            continue;
        }
        $file = $baseDir . str_replace('\\', '/', substr($className, strlen($prefix))) . '.php';
        if (file_exists($file)) {
            require $file;
        }
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
