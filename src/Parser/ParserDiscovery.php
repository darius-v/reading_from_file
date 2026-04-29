<?php

namespace App\Parser;

/**
 * Scans the Format directory for classes that implement ParserInterface.
 */
class ParserDiscovery
{
    private const string DIRECTORY = __DIR__ . '/Format';
    private const string PARSER_NAMESPACE = 'App\\Parser\\Format';

    /**
     * Returns FQCNs of all instantiable classes implementing ParserInterface.
     *
     * @return array<int, class-string<ParserInterface>>
     */
    public function discover(): array
    {
        $found = [];

        $pathNamesMatchingPattern = glob(self::DIRECTORY . '/*.php');

        foreach ($pathNamesMatchingPattern as $file) {

            $fileNameWithoutExtension = basename($file, '.php');
            $fqcn = self::PARSER_NAMESPACE . '\\' . $fileNameWithoutExtension;

            if (class_exists($fqcn) && is_a($fqcn, ParserInterface::class, true)) {
                $found[] = $fqcn;
            }
        }

        return $found;
    }
}
