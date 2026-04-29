<?php

namespace App\Http;

/**
 * Encapsulates the current HTTP request data.
 */
class Request
{
    /** @var array<string, mixed> */
    private array $server;

    /** @var array<string, mixed> */
    private array $files;

    /**
     * @param array<string, mixed> $server
     * @param array<string, mixed> $files
     */
    public function __construct(array $server, array $files)
    {
        $this->server = $server;
        $this->files  = $files;
    }

    /**
     * Creates a Request from PHP superglobals.
     *
     * @return self
     */
    public static function fromGlobals(): self
    {
        return new self($_SERVER, $_FILES);
    }

    /**
     * Returns the HTTP method (e.g. GET, POST).
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * Returns the uploaded file data for the given field name.
     *
     * @param  string $key
     * @return array<string, mixed>
     * @throws \RuntimeException If no file was uploaded under the given field name.
     */
    public function getFile(string $key): array
    {
        if (!isset($this->files[$key])) {
            throw new \RuntimeException("No file uploaded for field: $key");
        }

        return $this->files[$key];
    }
}
