<?php

namespace App\Factory;

use App\Parser\ParserDiscovery;
use App\Parser\ParserInterface;

/**
 * Resolves the appropriate parser for a given file extension.
 */
class ParserFactory
{
    /** @var ParserInterface[] */
    private array $parsers;

    /**
     * @param ParserDiscovery $discovery
     */
    public function __construct(ParserDiscovery $discovery)
    {
        $this->parsers = array_map(fn($class) => new $class(), $discovery->discover());
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

        foreach ($this->parsers as $parser) {
            if ($parser->supports($extension)) {
                return $parser;
            }
        }

        throw new \InvalidArgumentException("Unsupported file format: $extension");
    }

    /**
     * Returns list of supported file extensions.
     *
     * @return array<int, string>
     */
    public function getSupportedExtensions(): array
    {
        return array_map(fn($parser) => $parser->getExtension(), $this->parsers);
    }
}
