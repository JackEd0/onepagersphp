<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$config = require __DIR__ . '/../config.php';
$dataPath = __DIR__ . '/../data/content.json';
$uploadsDir = __DIR__ . '/../uploads/';
$uploadsWeb = 'uploads/';

$data = json_decode(file_get_contents($dataPath), true);
if (!$data) {
    die('Failed to load content data.');
}

$message = '';
$messageType = '';

function allowedImageExt($name) {
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'ico']);
}

function handleUpload($fieldName, $uploadsDir, $uploadsWeb) {
    if (!empty($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        if (!allowedImageExt($_FILES[$fieldName]['name'])) {
            return ['error' => 'Invalid file type. Only JPG, PNG, WEBP, GIF, ICO allowed.'];
        }
        if ($_FILES[$fieldName]['size'] > 2 * 1024 * 1024) {
            return ['error' => 'File too large. Max 2MB.'];
        }
        $filename = uniqid() . '_' . basename($_FILES[$fieldName]['name']);
        $dest = $uploadsDir . $filename;
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $dest)) {
            return ['path' => $uploadsWeb . $filename];
        } else {
            return ['error' => 'Failed to save uploaded file.'];
        }
    }
    return ['path' => null];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Site
    $data['site']['title'] = $_POST['site_title'] ?? $data['site']['title'];
    $favUpload = handleUpload('site_favicon', $uploadsDir, $uploadsWeb);
    if (isset($favUpload['error'])) {
        $message = $favUpload['error'];
        $messageType = 'danger';
    } elseif ($favUpload['path']) {
        $data['site']['favicon'] = $favUpload['path'];
    } elseif (!empty($_POST['site_favicon_url'])) {
        $data['site']['favicon'] = $_POST['site_favicon_url'];
    }

    // Hero
    $data['hero']['heading'] = $_POST['hero_heading'] ?? $data['hero']['heading'];
    $data['hero']['subheading'] = $_POST['hero_subheading'] ?? $data['hero']['subheading'];
    $heroUpload = handleUpload('hero_image', $uploadsDir, $uploadsWeb);
    if (isset($heroUpload['error'])) {
        $message = $heroUpload['error'];
        $messageType = 'danger';
    } elseif ($heroUpload['path']) {
        $data['hero']['image'] = $heroUpload['path'];
    } elseif (!empty($_POST['hero_image_url'])) {
        $data['hero']['image'] = $_POST['hero_image_url'];
    }

    // Menu
    foreach ($data['menu'] as $index => &$item) {
        $item['title'] = $_POST['menu_title_' . $index] ?? $item['title'];
        $item['price'] = $_POST['menu_price_' . $index] ?? $item['price'];
        $item['description'] = $_POST['menu_desc_' . $index] ?? $item['description'];
        $menuUpload = handleUpload('menu_image_' . $index, $uploadsDir, $uploadsWeb);
        if (isset($menuUpload['error'])) {
            $message = $menuUpload['error'];
            $messageType = 'danger';
        } elseif ($menuUpload['path']) {
            $item['image'] = $menuUpload['path'];
        } elseif (!empty($_POST['menu_image_url_' . $index])) {
            $item['image'] = $_POST['menu_image_url_' . $index];
        }
    }
    unset($item);

    // Testimonials
    foreach ($data['testimonials'] as $index => &$t) {
        $t['name'] = $_POST['test_name_' . $index] ?? $t['name'];
        $t['quote'] = $_POST['test_quote_' . $index] ?? $t['quote'];
        $t['stars'] = floatval($_POST['test_stars_' . $index] ?? $t['stars']);
        $testUpload = handleUpload('test_image_' . $index, $uploadsDir, $uploadsWeb);
        if (isset($testUpload['error'])) {
            $message = $testUpload['error'];
            $messageType = 'danger';
        } elseif ($testUpload['path']) {
            $t['image'] = $testUpload['path'];
        } elseif (!empty($_POST['test_image_url_' . $index])) {
            $t['image'] = $_POST['test_image_url_' . $index];
        }
    }
    unset($t);

    // Contact
    $data['contact']['intro'] = $_POST['contact_intro'] ?? $data['contact']['intro'];
    $data['contact']['address'] = $_POST['contact_address'] ?? $data['contact']['address'];
    $data['contact']['phone'] = $_POST['contact_phone'] ?? $data['contact']['phone'];
    $data['contact']['email'] = $_POST['contact_email'] ?? $data['contact']['email'];
    $data['contact']['social']['instagram'] = $_POST['social_instagram'] ?? $data['contact']['social']['instagram'];
    $data['contact']['social']['facebook'] = $_POST['social_facebook'] ?? $data['contact']['social']['facebook'];
    $data['contact']['social']['twitter'] = $_POST['social_twitter'] ?? $data['contact']['social']['twitter'];

    // Opening Hours
    $data['opening_hours']['mon_thu'] = $_POST['hours_mon_thu'] ?? $data['opening_hours']['mon_thu'];
    $data['opening_hours']['fri'] = $_POST['hours_fri'] ?? $data['opening_hours']['fri'];
    $data['opening_hours']['sat'] = $_POST['hours_sat'] ?? $data['opening_hours']['sat'];
    $data['opening_hours']['sun'] = $_POST['hours_sun'] ?? $data['opening_hours']['sun'];

    if (file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        if (!$message) {
            $message = 'All changes saved successfully!';
            $messageType = 'success';
        }
    } else {
        $message = 'Failed to save changes.';
        $messageType = 'danger';
    }
}

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function currentImage($path) {
    if (empty($path)) return 'No image set';
    if (strpos($path, 'http') === 0) {
        return '<img src="' . e($path) . '" class="img-thumbnail" style="max-height:80px;"> (URL)';
    }
    return '<img src="' . e($path) . '" class="img-thumbnail" style="max-height:80px;"> (Uploaded)';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sakura Sushi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #222; color: white; position: fixed; width: 260px; padding: 30px 20px; }
        .sidebar a { color: #ccc; text-decoration: none; display: block; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; }
        .sidebar a:hover, .sidebar a.active { background: #ff7f7f; color: white; }
        .main-content { margin-left: 260px; padding: 30px; }
        .section-card { background: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .btn-primary-custom { background-color: #ff7f7f; border-color: #ff7f7f; color: white; padding: 12px 30px; border-radius: 50px; transition: all 0.3s ease; }
        .btn-primary-custom:hover { background-color: #ff6b6b; border-color: #ff6b6b; }
        .preview-img { max-height: 80px; border-radius: 8px; border: 1px solid #ddd; }
        @media (max-width: 768px) { .sidebar { position: relative; width: 100%; min-height: auto; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="mb-4 fw-bold">Sakura Admin</h4>
        <a href="#site">Site Settings</a>
        <a href="#hero">Hero Section</a>
        <a href="#menu">Menu Items</a>
        <a href="#testimonials">Testimonials</a>
        <a href="#contact">Contact Info</a>
        <a href="#hours">Opening Hours</a>
        <a href="logout.php" class="mt-4 text-danger">Logout</a>
    </div>

    <div class="main-content">
        <h2 class="fw-bold mb-4">Edit Website Content</h2>

        <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
            <?php echo e($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data">

            <!-- Site Settings -->
            <div id="site" class="section-card">
                <h4 class="fw-bold mb-3">Site Settings</h4>
                <div class="mb-3">
                    <label class="form-label">Website Title</label>
                    <input type="text" class="form-control" name="site_title" value="<?php echo e($data['site']['title']); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Favicon</label>
                    <div class="mb-2"><?php echo currentImage($data['site']['favicon']); ?></div>
                    <input type="text" class="form-control mb-2" name="site_favicon_url" placeholder="Or enter image URL" value="<?php echo e($data['site']['favicon'] ?? ''); ?>">
                    <input type="file" class="form-control" name="site_favicon" accept=".jpg,.jpeg,.png,.webp,.gif,.ico">
                    <div class="form-text">Leave URL empty and choose file to upload. Max 2MB.</div>
                </div>
            </div>

            <!-- Hero -->
            <div id="hero" class="section-card">
                <h4 class="fw-bold mb-3">Hero Section</h4>
                <div class="mb-3">
                    <label class="form-label">Heading</label>
                    <input type="text" class="form-control" name="hero_heading" value="<?php echo e($data['hero']['heading']); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Subheading</label>
                    <textarea class="form-control" name="hero_subheading" rows="2"><?php echo e($data['hero']['subheading']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Background Image</label>
                    <div class="mb-2"><?php echo currentImage($data['hero']['image']); ?></div>
                    <input type="text" class="form-control mb-2" name="hero_image_url" placeholder="Or enter image URL" value="<?php echo e($data['hero']['image'] ?? ''); ?>">
                    <input type="file" class="form-control" name="hero_image" accept=".jpg,.jpeg,.png,.webp,.gif">
                    <div class="form-text">Recommended: wide image (1920x1080). Max 2MB.</div>
                </div>
            </div>

            <!-- Menu -->
            <div id="menu" class="section-card">
                <h4 class="fw-bold mb-3">Menu Items</h4>
                <?php foreach ($data['menu'] as $index => $item): ?>
                <div class="border rounded p-3 mb-3 bg-light">
                    <h6 class="fw-bold"><?php echo e($item['title']); ?></h6>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="mb-2"><?php echo currentImage($item['image']); ?></div>
                            <input type="text" class="form-control form-control-sm mb-2" name="menu_image_url_<?php echo $index; ?>" placeholder="Image URL" value="<?php echo e($item['image'] ?? ''); ?>">
                            <input type="file" class="form-control form-control-sm" name="menu_image_<?php echo $index; ?>" accept=".jpg,.jpeg,.png,.webp,.gif">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small">Title</label>
                            <input type="text" class="form-control form-control-sm" name="menu_title_<?php echo $index; ?>" value="<?php echo e($item['title']); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label small">Price</label>
                            <input type="text" class="form-control form-control-sm" name="menu_price_<?php echo $index; ?>" value="<?php echo e($item['price']); ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label small">Description</label>
                            <textarea class="form-control form-control-sm" name="menu_desc_<?php echo $index; ?>" rows="2"><?php echo e($item['description']); ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Testimonials -->
            <div id="testimonials" class="section-card">
                <h4 class="fw-bold mb-3">Testimonials</h4>
                <?php foreach ($data['testimonials'] as $index => $t): ?>
                <div class="border rounded p-3 mb-3 bg-light">
                    <h6 class="fw-bold"><?php echo e($t['name']); ?></h6>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="mb-2"><?php echo currentImage($t['image']); ?></div>
                            <input type="text" class="form-control form-control-sm mb-2" name="test_image_url_<?php echo $index; ?>" placeholder="Image URL" value="<?php echo e($t['image'] ?? ''); ?>">
                            <input type="file" class="form-control form-control-sm" name="test_image_<?php echo $index; ?>" accept=".jpg,.jpeg,.png,.webp,.gif">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="form-label small">Name</label>
                            <input type="text" class="form-control form-control-sm" name="test_name_<?php echo $index; ?>" value="<?php echo e($t['name']); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="form-label small">Stars (1-5)</label>
                            <input type="number" step="0.5" min="0" max="5" class="form-control form-control-sm" name="test_stars_<?php echo $index; ?>" value="<?php echo e($t['stars']); ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label small">Quote</label>
                            <textarea class="form-control form-control-sm" name="test_quote_<?php echo $index; ?>" rows="2"><?php echo e($t['quote']); ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Contact -->
            <div id="contact" class="section-card">
                <h4 class="fw-bold mb-3">Contact Info</h4>
                <div class="mb-3">
                    <label class="form-label">Introduction Text</label>
                    <textarea class="form-control" name="contact_intro" rows="2"><?php echo e($data['contact']['intro']); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="contact_address" value="<?php echo e($data['contact']['address']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="contact_phone" value="<?php echo e($data['contact']['phone']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="contact_email" value="<?php echo e($data['contact']['email']); ?>">
                    </div>
                </div>
                <h6 class="fw-bold mt-3">Social Media Links</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="text" class="form-control" name="social_instagram" value="<?php echo e($data['contact']['social']['instagram'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="text" class="form-control" name="social_facebook" value="<?php echo e($data['contact']['social']['facebook'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Twitter / X</label>
                        <input type="text" class="form-control" name="social_twitter" value="<?php echo e($data['contact']['social']['twitter'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <!-- Opening Hours -->
            <div id="hours" class="section-card">
                <h4 class="fw-bold mb-3">Opening Hours</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Monday - Thursday</label>
                        <input type="text" class="form-control" name="hours_mon_thu" value="<?php echo e($data['opening_hours']['mon_thu']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Friday</label>
                        <input type="text" class="form-control" name="hours_fri" value="<?php echo e($data['opening_hours']['fri']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Saturday</label>
                        <input type="text" class="form-control" name="hours_sat" value="<?php echo e($data['opening_hours']['sat']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sunday</label>
                        <input type="text" class="form-control" name="hours_sun" value="<?php echo e($data['opening_hours']['sun']); ?>">
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-primary-custom btn-lg px-5">Save All Changes</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
