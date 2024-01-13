<?php

define("CONFIG_FILE_PATH", __DIR__ . "/site.json");
define("ASSETS_PATH", "/adminv2/public/");
define("EMV_PATH", __DIR__ . "/../.env");
define("HOME_ADMIN_URL", "/admin2/");
define("HOME_FRONT_URL", "https://tog.webrepo.co/");

Helper::LoadEnv(EMV_PATH);

define("WEBSITE_PASSWORD", $_ENV["PASSWORD"]);

session_start();

if (isset($_POST["password"])) {
    Helper::Login(WEBSITE_PASSWORD, $_POST["password"]);
}

if (isset($_POST["logout"])) {
    Helper::Logout();
}

if (isset($_POST["formSubmitted"]) && Helper::IsLoggedIn() ) {
    $config = $_POST;
    unset($config["formSubmitted"]);
    unset($config["password"]);
    $config = Helper::Deflatten($config);
    file_put_contents(CONFIG_FILE_PATH, json_encode($config, JSON_PRETTY_PRINT));
    header("Location: " . HOME_ADMIN_URL);
    die();
}

// get config from json file
$config = json_decode(file_get_contents(CONFIG_FILE_PATH), true);

$configFlattened = Helper::Flatten($config);

class Helper
{
    const HOME_URL = HOME_ADMIN_URL;

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

    /**
     * Load .env file in the environment
     *
     * @param string $path
     * @return void
     */
    public static function LoadEnv(string $path): void
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), "#") === 0) {
                // Skip comments
                continue;
            }

            list($name, $value) = explode("=", $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_ENV)) {
                putenv(sprintf("%s=%s", $name, $value));
                $_ENV[$name] = $value;
            }
        }
    }

    /**
     * Login to the admin page
     *
     * @param string $password
     * @param string|null $postedPassword
     * @return void
     */
    public static function Login(string $password, ?string $postedPassword = null): void
    {
        if ($password === $postedPassword) {
            $_SESSION["is_logged_in"] = true;
            header("Location: " . Helper::HOME_URL);
            die();
        }
    }

    /**
     * Logout from the admin page
     *
     * @return void
     */
    public static function Logout(): void
    {
        unset($_SESSION["is_logged_in"]);
        header("Location: " . Helper::HOME_URL);
        die();
    }

    /**
     * Check if the user is logged in
     *
     * @return boolean
     */
    public static function IsLoggedIn(): bool
    {
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] === true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>index.css">
</head>
<body>
    <?php if (!Helper::IsLoggedIn()) : ?>
        <div class="login-card">
            <div class="login-card-content">
                <div class="header">
                    <div class="logo">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-gear-fill" viewBox="0 0 16 16">
                            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708z"/>
                            <path d="M11.07 9.047a1.5 1.5 0 0 0-1.742.26l-.02.021a1.5 1.5 0 0 0-.261 1.742 1.5 1.5 0 0 0 0 2.86 1.5 1.5 0 0 0-.12 1.07H3.5A1.5 1.5 0 0 1 2 13.5V9.293l6-6 4.724 4.724a1.5 1.5 0 0 0-1.654 1.03"/>
                            <path d="m13.158 9.608-.043-.148c-.181-.613-1.049-.613-1.23 0l-.043.148a.64.64 0 0 1-.921.382l-.136-.074c-.561-.306-1.175.308-.87.869l.075.136a.64.64 0 0 1-.382.92l-.148.045c-.613.18-.613 1.048 0 1.229l.148.043a.64.64 0 0 1 .382.921l-.074.136c-.306.561.308 1.175.869.87l.136-.075a.64.64 0 0 1 .92.382l.045.149c.18.612 1.048.612 1.229 0l.043-.15a.64.64 0 0 1 .921-.38l.136.074c.561.305 1.175-.309.87-.87l-.075-.136a.64.64 0 0 1 .382-.92l.149-.044c.612-.181.612-1.049 0-1.23l-.15-.043a.64.64 0 0 1-.38-.921l.074-.136c.305-.561-.309-1.175-.87-.87l-.136.075a.64.64 0 0 1-.92-.382ZM12.5 14a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                        </svg>
                    </div>
                    <h2>Dentist at <span class="highlight">Montreal</span></h2>
                    <h3>Admin Page</h3>
                </div>

                <form class="form" method="post">
                    <div class="form-field password">
                        <div class="icon"><i class="fas fa-lock"></i></div>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                    </div>

                    <button type="submit" class="btn">Login</button>
                    <div>Return to <a href="<?= HOME_FRONT_URL ?>"><?= HOME_FRONT_URL ?></a></div>
                </form>
            </div>
        </div>
    <?php else : ?>
        <div class="container">
            <header class="header">
                <nav class="navbar">
                    <a class="navbar__item" href="<?= HOME_ADMIN_URL ?>">Home</a>
                    <form method="post" class="navbar__item">
                        <button type="submit" class="link" name="logout">Logout</button>
                    </form>
                </nav>
            </header>

            <main class="">
                <h2>Edit Configuration</h2>
                <form id="configForm" method="post">
                    <input type="hidden" name="formSubmitted" value="1">

                    <div class="form-group" id="dynamicFields">
                        <?php foreach ($configFlattened as $key => $value) : ?>
                            <?php if (strpos($key, "horizontal_separator")) : ?>
                                <hr>
                                <?php continue; ?>
                            <?php endif; ?>
                            <div class="form-field">
                                <label for="<?= $key ?>" class=""><?= Helper::BeautifySlug($key) ?></label>
                                <?php if (strlen($value) >= 60) : ?>
                                    <textarea name="<?= $key ?>" id="<?= $key ?>" cols="30" rows="5"><?= $value ?></textarea>
                                <?php else : ?>
                                    <input type="text" class="" id="<?= $key ?>" name="<?= $key ?>" value="<?= $value ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" class="btn" id="save">Save</button>
                    <a class="link--cancel" href="<?= HOME_ADMIN_URL ?>">Cancel</a>
                </form>
            </main>
        </div>
    <?php endif; ?>
</body>
</html>
