<?php

namespace App\Factory;

use App\Parser\ParserDiscovery;
use App\Parser\ParserInterface;

/**
 * Resolves the appropriate parser for a given file extension.
 */
readonly class ParserFactory
{
    /**
     * @param ParserDiscovery $discovery
     */
    public function __construct(public ParserDiscovery $discovery)
    {
    }

    /**
     * Returns the parser that supports the given file extension.
     *
     * @param  string $extension
     * @return ParserInterface
     * @throws \InvalidArgumentException If no parser supports the format.
     */
    public function create(string $extension): ParserInterface
    {
        $extension = strtolower($extension);

        foreach ($this->buildParserInstances($this->discovery->discover()) as $parser) {
            if ($parser->supports($extension)) {
                return $parser;
            }
        }

        throw new \InvalidArgumentException("Unsupported file format: $extension");
    }

    /**
     * Returns a list of supported file extensions.
     *
     * @return array<int, string>
     */
    public function getSupportedExtensions(): array
    {
        return array_map(
            fn($parser) => $parser->getExtension(),
            $this->buildParserInstances($this->discovery->discover())
        );
    }

    /**
     * @param array $parsersClassNames
     * @return ParserInterface[]
     */
    private function buildParserInstances(array $parsersClassNames): array
    {
        return array_map(fn($class) => new $class(), $parsersClassNames);
    }
}
