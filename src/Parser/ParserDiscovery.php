<?php

namespace App\Parser;

/**
 * Scans the Format directory for classes that implement ParserInterface.
 */
class ParserDiscovery
{
    private const string DIRECTORY      = __DIR__ . '/Format';
    private const string PARSER_NAMESPACE = 'App\\Parser\\Format';

    /**
     * Returns FQCNs of all instantiable classes implementing ParserInterface.
     *
     * @return array<int, class-string<ParserInterface>>
     * @throws \RuntimeException If the directory cannot be read.
     */
    public function discover(): array
    {
        if (!is_dir(self::DIRECTORY) || !is_readable(self::DIRECTORY)) {
            throw new \RuntimeException('Parser directory not readable: ' . self::DIRECTORY);
        }

        $found = [];

        foreach (glob(self::DIRECTORY . '/*.php') as $file) {
            $fqcn = self::PARSER_NAMESPACE . '\\' . basename($file, '.php');

            // class_exists triggers the autoloader and returns false for interfaces
            if (class_exists($fqcn) && is_a($fqcn, ParserInterface::class, true)) {
                $found[] = $fqcn;
            }
        }

        return $found;
    }
}
