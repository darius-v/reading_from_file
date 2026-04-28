<?php

namespace App\Parser;

/**
 * Scans a directory for classes that implement ParserInterface.
 */
class ParserDiscovery
{
    /** @var string */
    private string $directory;

    /** @var string */
    private string $namespace;

    /**
     * @param string $directory Absolute path to the directory to scan.
     * @param string $namespace Namespace prefix for classes in that directory.
     */
    public function __construct(string $directory, string $namespace)
    {
        $this->directory = $directory;
        $this->namespace = rtrim($namespace, '\\');
    }

    /**
     * Returns FQCNs of all instantiable classes implementing ParserInterface.
     *
     * @return array<int, class-string<ParserInterface>>
     * @throws \RuntimeException If the directory cannot be read.
     */
    public function discover(): array
    {
        if (!is_dir($this->directory) || !is_readable($this->directory)) {
            throw new \RuntimeException("Parser directory not readable: {$this->directory}");
        }

        $found = [];

        foreach (glob($this->directory . '/*.php') as $file) {
            $fqcn = $this->namespace . '\\' . basename($file, '.php');

            // class_exists triggers the autoloader and returns false for interfaces
            if (class_exists($fqcn) && is_a($fqcn, ParserInterface::class, true)) {
                $found[] = $fqcn;
            }
        }

        return $found;
    }
}
