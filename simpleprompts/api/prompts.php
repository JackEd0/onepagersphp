<?php
require __DIR__ . '/vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use Notion\Notion;
use Notion\Databases\Query;
use Notion\Databases\Query\Sort;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$notionApiKey = $_ENV['NOTION_API_SECRET'];
$databaseId = $_ENV['NOTION_DATASOURCE_ID'];

if (!$notionApiKey || !$databaseId) {
    http_response_code(500);
    echo json_encode(['error' => 'Notion API key or Database ID not configured.']);
    exit;
}

try {
    $notion = Notion::create($notionApiKey);

    $query = Query::create($databaseId)
        ->changeSort(Sort::ascending("title"));

    $result = $notion->databases()->query($query);

    $prompts = [];
    foreach ($result->results() as $page) {
        $properties = $page->properties();

        // Default values
        $title = 'Untitled';
        $instructions = '';
        $content = '';
        $tags = [];
        $favorite = false;

        if (isset($properties['title']) && $properties['title']->isTitle()) {
            $titleParts = [];
            foreach ($properties['title']->title as $richText) {
                $titleParts[] = $richText->plainText;
            }
            $title = implode("", $titleParts);
        }

        if (isset($properties['instructions']) && $properties['instructions']->isRichText()) {
             $instructionParts = [];
            foreach ($properties['instructions']->richText as $richText) {
                $instructionParts[] = $richText->plainText;
            }
            $instructions = implode("", $instructionParts);
        }

        if (isset($properties['content']) && $properties['content']->isRichText()) {
            $contentParts = [];
            foreach ($properties['content']->richText as $richText) {
                $contentParts[] = $richText->plainText;
            }
            $content = implode("", $contentParts);
        }

        if (isset($properties['tags']) && $properties['tags']->isMultiSelect()) {
            foreach ($properties['tags']->multiSelect as $tag) {
                $tags[] = $tag->name;
            }
        }

        if (isset($properties['favorite']) && $properties['favorite']->isCheckbox()) {
            $favorite = $properties['favorite']->checkbox;
        }

        $prompts[] = [
            'id' => $page->id(),
            'title' => $title,
            'instructions' => $instructions,
            'content' => $content,
            'tags' => $tags,
            'favorite' => $favorite,
        ];
    }

    echo json_encode($prompts);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch prompts from Notion: ' . $e->getMessage()]);
}