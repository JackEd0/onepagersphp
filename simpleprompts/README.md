# Simple Prompts

A modern, single-page dashboard for storing and managing prompts and notes, built with Vite, Vue.js, and Vuetify.

PROJECT CANCELLED because the complexity is too high with the Notion API.

> Yes, there are several PHP packages available for interacting with the Notion API, as Notion does not provide an official PHP SDK (their official ones are primarily for JavaScript, with community ports for other languages). These are community-maintained, Composer-installable libraries available on Packagist and GitHub. Here are some of the most popular and actively maintained options:

- **brd6/notion-sdk-php**: A PHP port of the official Notion JavaScript SDK, designed to work similarly. It uses PSR-18 for HTTP clients (e.g., pair with Symfony's HTTP client). Install via `composer require brd6/notion-sdk-php symfony/http-client nyholm/psr7`.

- **mariosimao/notion-sdk-php**: A complete, type-safe SDK for PHP 8.1+ with full support for blocks, pages, databases, and more. It includes excellent documentation and IDE autocompletion. Install via `composer require mariosimao/notion-sdk-php`.

- **fiveam-code/laravel-notion-api** (or similar Laravel wrappers like saas-estate/laravel-notion-api): Tailored for Laravel projects, providing a fluent interface for querying and updating Notion data.

- **64robots/php-notion**: A straightforward package for basic Notion API operations (PHP 7.4+).

Other options include **amgrade/notion-api**, **osbre/notion-php-sdk**, and older/abandoned ones like **codecycler/notion** (avoid if possible, as some are no longer maintained).

To get started, create a Notion integration at https://www.notion.com/my-integrations to obtain an API token, then follow the package's README for setup. Check Packagist (packagist.org) or GitHub for the latest versions, stars, and update activity to choose the best fit. If you're building something Laravel-specific, start with the Laravel-focused packages; otherwise, brd6 or mariosimao are solid general-purpose choices.

## Installation

1.  Clone the repository.
2.  Install dependencies: `npm install`
3.  Run the development server: `npm run dev`

## Usage

- Browse and search for prompts.
- Filter prompts by favorites or tags.
- Copy prompt content or the entire prompt object.