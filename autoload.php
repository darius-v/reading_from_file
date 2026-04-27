<?php

/**
 * PSR-4 autoloader.
 * Maps namespace prefix "App\" to the src/ directory.
 */
spl_autoload_register(function (string $className): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/src/';

    if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($className, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
