<?php

require __DIR__ . "/../vendor/autoload.php";

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// define("CONFIG_FILE_PATH", __DIR__ . "/config.example.json");
define("CONFIG_FILE_PATH", __DIR__ . "/site.json");
define("WEBSITE_PASSWORD", $_ENV["PASSWORD"]);
define("ASSETS_PATH", "/adminv1/public/");

if (isset($_POST["password"]) && $_POST["password"] === WEBSITE_PASSWORD) {
    $config = $_POST;
    unset($config["password"]);
    $config = Helper::Deflatten($config);
    file_put_contents(CONFIG_FILE_PATH, json_encode($config, JSON_PRETTY_PRINT));
    header("Location: /admin/");
    die();
}

// get config from json file
$config = json_decode(file_get_contents(CONFIG_FILE_PATH), true);

$configFlattened = Helper::Flatten($config);

// var_dump($config);
// $config = Helper::Deflatten($config);
// print_r($config);
// die();

class Helper
{

    /**
     * Flatten an array
     *
     * initial array
     * {
     *   "email": "akdodji@gmail.com",
     *   "realisations": [{"title": "Theme page", "link": "https://theme.webrepo.co"}, {...}],
     *   "main_skills": ["PHP", ...],
     *   "skills": [["JAVA", ...], ...]
     * }
     * desired output
     * {
     *   "email": "akdodji@gmail.com",
     *   "realisations__0__title": "Theme page",
     *   "realisations__0__link": "https://theme.webrepo.co",
     *   "main_skills__0": "PHP",
     *   "skills__0__0": "JAVA"
     * }
     *
     * @param array $array
     * @param string $prefix
     * @return array
     */
    public static function Flatten(array $array, string $prefix = ""): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, Helper::Flatten($value, $prefix . $key . "__"));
            } else {
                $result[$prefix . $key] = htmlspecialchars($value);
            }
        }

        return $result;
    }

    /**
     * Deflatten an array
     *
     * @param array $array
     * @return array
     */
    public static function Deflatten(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $keys = explode("__", $key);
            $temp = &$result;
            foreach ($keys as $key) {
                $temp = &$temp[$key];
            }
            $temp = $value;
        }

        return $result;
    }

    /**
     * Beautify a slug, e.g. "main_skills.0" -> "Main Skills"
     *
     * @param string $slug
     * @return string
     */
    public static function BeautifySlug(string $slug = ""): string
    {
        $slug = str_replace("_", " ", $slug);
        $slug = str_replace(".", " ", $slug);
        $slug = ucwords($slug);

        return $slug;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>bootstrap.min.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="/">Home</a>
            </nav>
        </header>

        <main class="mt-5 mb-5">
            <h2>Edit Configuration</h2>
            <form id="configForm" method="post">
                <div class="form-group mb-5">
                    <label for="password">Password:</label>
                    <input type="text" class="form-control" id="password" name="password" autocomplete="off" required>
                </div>

                <div class="form-group" id="dynamicFields">
                    <?php foreach ($configFlattened as $key => $value) : ?>
                        <div class="mb-3">
                            <label for="<?= $key ?>" class="form-label"><?= Helper::BeautifySlug($key) ?></label>
                            <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>" value="<?= $value ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <a class="btn btn-secondary" href="/admin/">Cancel</a>
                <button type="submit" class="btn btn-success" id="save">Save</button>
            </form>
        </main>
    </div>
</body>
</html>
