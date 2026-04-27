<?php

namespace Tests\Support;

/**
 * Simple assertion helpers for tests.
 */
class Assert
{
    /**
     * @param string $needle
     * @param string $haystack
     * @param string $message
     * @return void
     */
    public static function contains(string $needle, string $haystack, string $message = ''): void
    {
        if (str_contains($haystack, $needle)) {
            self::pass($message ?: "Contains: \"$needle\"");
        } else {
            self::fail($message ?: "Expected to find \"$needle\" in response");
        }
    }

    /**
     * @param string $html
     * @param string $tag
     * @param string $message
     * @return void
     */
    public static function hasTag(string $html, string $tag, string $message = ''): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        if ($dom->getElementsByTagName($tag)->length > 0) {
            self::pass($message ?: "Has tag <$tag>");
        } else {
            self::fail($message ?: "Expected <$tag> tag in response");
        }
    }

    /**
     * @param string $message
     * @return void
     */
    private static function pass(string $message): void
    {
        echo "\033[32m  ✓ $message\033[0m\n";
    }

    /**
     * @param string $message
     * @return void
     */
    private static function fail(string $message): void
    {
        echo "\033[31m  ✗ $message\033[0m\n";
    }
}
