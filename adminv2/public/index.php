<?php

define("CONFIG_FILE_PATH", __DIR__ . "/site2.json");
// define("CONFIG_FILE_PATH", __DIR__ . "/site.json");
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
    $previousVersionConfig = json_decode(file_get_contents(CONFIG_FILE_PATH), true);
    $config = array_merge($previousVersionConfig, $config);
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
                <form method="post">
                    <input type="hidden" name="formSubmitted" value="1">

                    <!-- <div class="section--admin">
                        <?php foreach ($configFlattened as $key => $value) : ?>
                            <div class="form-field">
                                <label for="<?= $key ?>" class=""><?= Helper::BeautifySlug($key) ?></label>
                                <?php if (strlen($value) >= 60) : ?>
                                    <textarea name="<?= $key ?>" id="<?= $key ?>" cols="30" rows="5"><?= $value ?></textarea>
                                <?php else : ?>
                                    <input type="text" class="" id="<?= $key ?>" name="<?= $key ?>" value="<?= $value ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div> -->

                    <div class="section--company">
                        <?php
                        $companyInformation = [
                            "companyName" => "Name of the company",
                            "companyAddress" => "Address",
                            "companyPhone" => "Phone",
                            "companyEmail" => "Email",
                        ];
                        ?>
                        <?php foreach ($companyInformation as $key => $label) : ?>
                            <?php if (isset($configFlattened[$key])) : ?>
                                <div class="form-field">
                                    <label for="<?= $key ?>" class=""><?= $label ?></label>
                                    <input type="text" class="" id="<?= $key ?>" name="<?= $key ?>" value="<?= $configFlattened[$key] ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="section-menu">
                        <h3>Header Section</h3>
                        <?php
                        $menuItems = [
                            0 => "Left menu",
                            1 => "Right menu",
                        ];
                        ?>
                        <?php foreach ($menuItems as $key => $label) : ?>
                            <h4><?= $label ?></h4>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteMenuItems__%s__name", $key) ?>">Name</label>
                                <input type="text" class="" id="<?= sprintf("websiteMenuItems__%s__name", $key) ?>" name="<?= sprintf("websiteMenuItems__%s__name", $key) ?>" value="<?= $configFlattened[sprintf("websiteMenuItems__%s__name", $key)] ?>">
                            </div>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteMenuItems__%s__link", $key) ?>">Link</label>
                                <input type="text" class="" id="<?= sprintf("websiteMenuItems__%s__link", $key) ?>" name="<?= sprintf("websiteMenuItems__%s__link", $key) ?>" value="<?= $configFlattened[sprintf("websiteMenuItems__%s__link", $key)] ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="section--hero">
                        <h3>Hero Section</h3>
                        <?php
                        $heroInformation = [
                            "websiteWelcomeText" => "Welcome Text",
                            "websiteWelcomeText2" => "Welcome Text Subtitle",
                            "websiteWelcomeButtonText" => "Welcome Button Text",
                            "websiteWelcomeButtonLink" => "Welcome Button Link",
                        ];
                        ?>
                        <?php foreach ($heroInformation as $key => $label) : ?>
                            <?php if (isset($configFlattened[$key])) : ?>
                                <div class="form-field">
                                    <label for="<?= $key ?>" class=""><?= $label ?></label>
                                    <input type="text" class="" id="<?= $key ?>" name="<?= $key ?>" value="<?= $configFlattened[$key] ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="section--services">
                        <h3>Services Section</h3>
                        <?php
                        $websiteServices = [
                            0 => "Left",
                            1 => "Center",
                            2 => "Right",
                        ]
                        ?>
                        <div class="form-field">
                            <label for="websiteServicesTitle">Services Title</label>
                            <input type="text" class="" id="websiteServicesTitle" name="websiteServicesTitle" value="<?= $configFlattened["websiteServicesTitle"] ?>">
                        </div>
                        <div class="form-field">
                            <label for="websiteServicesText">Services Text</label>
                            <textarea name="websiteServicesText" id="websiteServicesText" cols="30" rows="5"><?= $configFlattened["websiteServicesText"] ?></textarea>
                        </div>
                        <?php foreach ($websiteServices as $key => $label) : ?>
                            <h4><?= $label ?></h4>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteServices__%s__name", $key) ?>">Title</label>
                                <input type="text" class="" id="<?= sprintf("websiteServices__%s__name", $key) ?>" name="<?= sprintf("websiteServices__%s__name", $key) ?>" value="<?= $configFlattened[sprintf("websiteServices__%s__name", $key)] ?>">
                            </div>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteServices__%s__image", $key) ?>">Title</label>
                                <input type="text" class="" id="<?= sprintf("websiteServices__%s__image", $key) ?>" name="<?= sprintf("websiteServices__%s__image", $key) ?>" value="<?= $configFlattened[sprintf("websiteServices__%s__image", $key)] ?>">
                            </div>
                            <div class="form-field">
                                <label for="websiteServicesText">Description</label>
                                <textarea name="<?= sprintf("websiteServices__%s__description", $key) ?>" id="<?= sprintf("websiteServices__%s__description", $key) ?>" cols="30" rows="5"><?= $configFlattened[sprintf("websiteServices__%s__description", $key)] ?></textarea>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="section--contact">
                        <h3>Contact Section</h3>
                        <?php
                        $websiteContactsDays = 7;
                        ?>
                        <div class="form-field">
                            <label for="websiteContactTitle">Title</label>
                            <input type="text" class="" id="websiteContactTitle" name="websiteContactTitle" value="<?= $configFlattened["websiteContactTitle"] ?>">
                        </div>
                        <div class="form-field">
                            <label for="websiteContactText">Text</label>
                            <textarea name="websiteContactText" id="websiteContactText" cols="30" rows="5"><?= $configFlattened["websiteContactText"] ?></textarea>
                        </div>
                        <h4>Schedule</h4>
                        <?php for ($i = 0; $i < $websiteContactsDays; $i++) : ?>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteContactSchedule__%s__day", $i) ?>" class="hidden">Day <?= $i + 1 ?></label>
                                <input type="text" class="" id="<?= sprintf("websiteContactSchedule__%s__day", $i) ?>" name="<?= sprintf("websiteContactSchedule__%s__day", $i) ?>" value="<?= $configFlattened[sprintf("websiteContactSchedule__%s__day", $i)] ?>">
                            </div>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteContactSchedule__%s__hours", $i) ?>" class="hidden">Openning Hours</label>
                                <input type="text" class="" id="<?= sprintf("websiteContactSchedule__%s__hours", $i) ?>" name="<?= sprintf("websiteContactSchedule__%s__hours", $i) ?>" value="<?= $configFlattened[sprintf("websiteContactSchedule__%s__hours", $i)] ?>">
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="section--footer">
                        <h3>Footer Section</h3>
                        <?php
                        $footerMenuItems = [
                            0 => "",
                            1 => "",
                            2 => "",
                            3 => "",
                        ];
                        $footerSocialMedia1 = [
                            0 => "Facebook",
                            1 => "Twitter",
                            2 => "Instagram",
                        ];
                        $footerSocialMedia2 = [
                            0 => "YouTube",
                            1 => "LinkedIn",
                            2 => "Snapchat",
                        ];
                        ?>
                        <?php foreach ($footerSocialMedia1 as $key => $label) : ?>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteFooterSocialMediaLine1__%s__link", $key) ?>"><?= $label ?></label>
                                <input type="text" class="" id="<?= sprintf("websiteFooterSocialMediaLine1__%s__link", $key) ?>" name="<?= sprintf("websiteFooterSocialMediaLine1__%s__link", $key) ?>" value="<?= $configFlattened[sprintf("websiteFooterSocialMediaLine1__%s__link", $key)] ?>">
                                <input type="hidden" name="<?= sprintf("websiteFooterSocialMediaLine1__%s__name", $key) ?>" value="<?= $configFlattened[sprintf("websiteFooterSocialMediaLine1__%s__name", $key)] ?>">
                                <input type="hidden" name="<?= sprintf("websiteFooterSocialMediaLine1__%s__icon", $key) ?>" value="<?= $configFlattened[sprintf("websiteFooterSocialMediaLine1__%s__icon", $key)] ?>">
                            </div>
                        <?php endforeach; ?>
                        <?php foreach ($footerSocialMedia2 as $key => $label) : ?>
                            <div class="form-field">
                                <label for="<?= sprintf("websiteFooterSocialMediaLine2__%s__link", $key) ?>"><?= $label ?></label>
                                <input type="text" class="" id="<?= sprintf("websiteFooterSocialMediaLine2__%s__link", $key) ?>" name="<?= sprintf("websiteFooterSocialMediaLine2__%s__link", $key) ?>" value="<?= $configFlattened[sprintf("websiteFooterSocialMediaLine2__%s__link", $key)] ?>">
                                <input type="hidden" name="<?= sprintf("websiteFooterSocialMediaLine2__%s__name", $key) ?>" value="<?= $configFlattened[sprintf("websiteFooterSocialMediaLine2__%s__name", $key)] ?>">
                                <input type="hidden" name="<?= sprintf("websiteFooterSocialMediaLine2__%s__icon", $key) ?>" value="<?= $configFlattened[sprintf("websiteFooterSocialMediaLine2__%s__icon", $key)] ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="section--policy">
                        <h3>Privacy Policy</h3>
                        <div class="form-field">
                            <label for="websitePolicyText">Text</label>
                            <textarea name="websitePolicyText" id="websitePolicyText" cols="30" rows="5"><?= $configFlattened["websitePolicyText"] ?></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn">Save</button>
                    <a class="link--cancel" href="<?= HOME_ADMIN_URL ?>">Cancel</a>
                </form>
            </main>
        </div>
    <?php endif; ?>
</body>
</html>
