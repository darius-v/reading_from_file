<?php

/** PSR-4 autoloader for Tests\ namespace */

use Tests\FileUploadTest;

spl_autoload_register(function (string $className): void {
    $map = [
        'Tests\\' => __DIR__ . '/',
        'App\\'   => __DIR__ . '/../src/',
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
    new FileUploadTest($baseUrl),
];

foreach ($tests as $suite) {
    echo get_class($suite) . "\n";
    $suite->run();
    echo "\n";
}
