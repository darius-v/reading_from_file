# CLAUDE.md – Project Rules

## Coding Standards
- Follow **PSR-1** and **PSR-2** standards (4-space indentation, StudlyCaps class names, camelCase methods, etc.)
- All PHP files must have `<?php` and no closing tag `?>`

## Principles
- **SOLID** – single responsibility, open/closed, dependency inversion, etc.
- **DRY** – no code repetition, extract into shared classes/methods
- **KISS** – prefer simple solutions over complex ones

## Autoloader
- Use a hand-written **PSR-4** autoloader – `composer` is not allowed
- All PHP files must be loaded dynamically via the autoloader, not manually via `require`/`include`

## Third-party Libraries
- Using any third-party frameworks or libraries is **forbidden**

## Comments and PHPDoc
- **Block comments** are required on classes and methods
- **PHPDoc** is required (`@param`, `@return`, `@throws`, etc.)
- Only add inline comments when the WHY is not obvious from the code itself

## Architecture
- Apply **MVC** structure
- Use appropriate **Design Patterns**: Factory (for parsers by file type), Adapter (for different formats), etc.
- Extensibility principle: adding a new file format must require only a configuration change, not modifications to existing code

## Configuration
- Configuration may be stored in any format: `.env`, `.yaml`, `.php`, etc.

## Supported File Formats
- CSV, XML, JSON (each via a dedicated adapter/parser)

## Docker Environment
- PHP 8.5-fpm + nginx + xdebug (port 9003, idekey PHPSTORM)
- Application available at `http://localhost:8080`
- `/.well-known/` is blocked at the nginx level (never reaches PHP)
