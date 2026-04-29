<?php

namespace Tests\Support;

/**
 * Simple assertion helpers for tests.
 */
class Assert
{
    private static int $passed = 0;
    private static int $failed = 0;

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
     * @param string $html
     * @param string $tag
     * @param string $message
     * @return void
     */
    public static function hasNoTag(string $html, string $tag, string $message = ''): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        if ($dom->getElementsByTagName($tag)->length === 0) {
            self::pass($message ?: "Has no tag <$tag>");
        } else {
            self::fail($message ?: "Expected no <$tag> tag in response");
        }
    }

    /**
     * Asserts no inline <script> tag (without a src attribute) exists in the HTML.
     * External <script src="..."> tags are permitted.
     *
     * @param string $html
     * @param string $message
     * @return void
     */
    public static function hasNoInlineScript(string $html, string $message = ''): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        foreach ($dom->getElementsByTagName('script') as $node) {
            if (!$node->hasAttribute('src')) {
                self::fail($message ?: 'Expected no inline <script> tag in response');
                return;
            }
        }

        self::pass($message ?: 'No inline <script> tag in output');
    }

    /**
     * @param string $message
     * @return void
     */
    /**
     * Prints a summary line: green if all passed, red if any failed.
     *
     * @return void
     */
    public static function summary(): void
    {
        $total = self::$passed + self::$failed;

        if (self::$failed === 0) {
            echo "\033[32mAll $total assertions passed.\033[0m\n";
        } else {
            echo "\033[31m" . self::$failed . " failed, " . self::$passed . " passed.\033[0m\n";
        }
    }

    private static function pass(string $message): void
    {
        self::$passed++;
        echo "\033[32m  ✓ $message\033[0m\n";
    }

    /**
     * @param string $message
     * @return void
     */
    private static function fail(string $message): void
    {
        self::$failed++;
        echo "\033[31m  ✗ $message\033[0m\n";
    }
}
