<?php

namespace App\Factory;

use App\Parser\ParserInterface;

/**
 * Creates the appropriate parser based on file extension.
 * Supported formats are defined in config/parsers.php.
 */
class ParserFactory
{
    /** @var array<string, class-string<ParserInterface>> */
    private array $parsers;

    /**
     * @param array<string, class-string<ParserInterface>> $parsers
     */
    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    /**
     * Returns a parser instance for the given file extension.
     *
     * @param  string $extension
     * @return ParserInterface
     * @throws \InvalidArgumentException If the format is not supported.
     */
    public function create(string $extension): ParserInterface
    {
        $extension = strtolower($extension);

        if (!isset($this->parsers[$extension])) {
            throw new \InvalidArgumentException("Unsupported file format: $extension");
        }

        return new $this->parsers[$extension]();
    }

    /**
     * Returns list of supported file extensions.
     *
     * @return array<int, string>
     */
    public function getSupportedExtensions(): array
    {
        return array_keys($this->parsers);
    }
}
