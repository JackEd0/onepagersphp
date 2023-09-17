<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$password = $_ENV['PASSWORD'];

/*
if the form is submitted
check if the password is correct
if it is, update the config file
*/
if (isset($_POST['password'])) {
    if ($_POST['password'] === $password) {
        $config = $_POST;
        unset($config['password']);
        // var_dump($config);die();
        $config = deflatten($config);
        // var_dump($config);die();
        file_put_contents(__DIR__ . '/site.json', json_encode($config, JSON_PRETTY_PRINT));
        header('Location: /admin/');
        die();
    }
}

// get config from json file
$config = json_decode(file_get_contents(__DIR__ . '/site.json'), true);

/*
Function to flatten an array
{
    "email": "akdodji@gmail.com",
    "realisations": [
        {
            "title": "Theme page",
            "preview": "theme.png",
            "link": "https://theme.webrepo.co",
            "description": "Theme page for Webtech"
        },
    ],
    "main_skills": [
        "PHP",
    ],
    "skills": [
        [
            "JAVA",
        ]
    ]
}
desired output:
{
    "email": "akdodji@gmail.com",
    "realisations.0.title": "Theme page",
    "realisations.0.preview": "theme.png",
    "realisations.0.link": "https://theme.webrepo.co",
    "realisations.0.description": "Theme page for Webtech",
    "main_skills.0": "PHP",
    "skills.0.0": "JAVA"
}
*/
function flatten($array, $prefix = '') {
    $result = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, flatten($value, $prefix . $key . '__'));
        } else {
            $result[$prefix . $key] = htmlspecialchars($value);
        }
    }
    return $result;
}

/*
function to deflatten an array
*/
function deflatten($array) {
    $result = [];
    foreach ($array as $key => $value) {
        $keys = explode('__', $key);
        $temp = &$result;
        foreach ($keys as $key) {
            $temp = &$temp[$key];
        }
        $temp = $value;
    }
    return $result;
}

// function to beautify a slug, e.g. "main_skills.0" -> "Main Skills"
function beautifySlug($slug) {
    $slug = str_replace('_', ' ', $slug);
    $slug = str_replace('.', ' ', $slug);
    $slug = ucwords($slug);
    return $slug;
}

// flatten the config array
$configFlattened = flatten($config);
// var_dump($config);
// $config = deflatten($config);
// print_r($config);
// die();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="/public/bootstrap.min.css">
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
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group" id="dynamicFields">
                    <?php foreach ($configFlattened as $key => $value) : ?>
                        <div class="mb-3">
                            <label for="<?= $key ?>" class="form-label"><?= beautifySlug($key) ?></label>
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
