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

function currentImagePreview($path) {
    if (empty($path)) return '<div class="no-image"><i class="fas fa-image"></i><span>No image</span></div>';
    $src = (strpos($path, 'http') === 0) ? $path : '../' . $path;
    return '<div class="image-preview-wrapper"><img src="' . e($src) . '" class="image-preview" alt="Preview"><span class="image-tag">' . (strpos($path, 'http') === 0 ? 'URL' : 'File') . '</span></div>';
}

function renderStars($stars) {
    $full = floor($stars);
    $half = ($stars - $full) >= 0.5;
    $html = '';
    for ($i = 0; $i < $full; $i++) {
        $html .= '<i class="fas fa-star text-warning"></i>';
    }
    if ($half) {
        $html .= '<i class="fas fa-star-half-alt text-warning"></i>';
    }
    return $html;
}

$sections = [
    'site' => ['icon' => 'fa-globe', 'label' => 'Site Settings'],
    'hero' => ['icon' => 'fa-image', 'label' => 'Hero Section'],
    'menu' => ['icon' => 'fa-utensils', 'label' => 'Menu Items'],
    'testimonials' => ['icon' => 'fa-comments', 'label' => 'Testimonials'],
    'contact' => ['icon' => 'fa-address-card', 'label' => 'Contact Info'],
    'hours' => ['icon' => 'fa-clock', 'label' => 'Opening Hours'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakura Admin — Content Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff7f7f;
            --primary-hover: #ff6b6b;
            --primary-glow: rgba(255, 127, 127, 0.15);
            --dark-bg: #0f1115;
            --dark-surface: #1a1d24;
            --dark-surface-hover: #22262e;
            --dark-border: #2a2f3a;
            --text-primary: #f0f0f5;
            --text-secondary: #8a8f9e;
            --text-muted: #5a6070;
            --success: #4ade80;
            --danger: #f87171;
            --warning: #fbbf24;
            --radius: 16px;
            --radius-sm: 10px;
        }

        * { scrollbar-width: thin; scrollbar-color: var(--dark-border) var(--dark-bg); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark-bg); }
        ::-webkit-scrollbar-thumb { background: var(--dark-border); border-radius: 3px; }

        body {
            background-color: var(--dark-bg);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .brand-title { font-family: 'Playfair Display', serif; }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: 280px;
            background: var(--dark-surface);
            border-right: 1px solid var(--dark-border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .sidebar-brand {
            padding: 30px 28px 20px;
            border-bottom: 1px solid var(--dark-border);
        }
        .sidebar-brand h3 {
            font-size: 1.4rem;
            margin: 0;
            color: var(--primary);
            letter-spacing: 0.5px;
        }
        .sidebar-brand small {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .sidebar-nav {
            flex: 1;
            padding: 20px 16px;
            overflow-y: auto;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 18px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }
        .sidebar-nav a:hover {
            background: var(--dark-surface-hover);
            color: var(--text-primary);
        }
        .sidebar-nav a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 20px rgba(255, 127, 127, 0.3);
        }
        .sidebar-nav a i {
            width: 20px;
            text-align: center;
            font-size: 0.95rem;
        }
        .sidebar-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--dark-border);
        }
        .sidebar-footer a {
            color: var(--danger);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: opacity 0.2s;
        }
        .sidebar-footer a:hover { opacity: 0.8; }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 16px; left: 16px;
            z-index: 1100;
            width: 44px; height: 44px;
            border-radius: 12px;
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            padding: 40px 48px;
            max-width: 1100px;
        }
        .page-header {
            margin-bottom: 36px;
        }
        .page-header h1 {
            font-size: 2.2rem;
            margin-bottom: 6px;
            color: var(--text-primary);
        }
        .page-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin: 0;
        }

        /* Cards */
        .admin-card {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: var(--radius);
            margin-bottom: 32px;
            overflow: hidden;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .admin-card:hover {
            border-color: var(--dark-border);
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .card-header {
            padding: 24px 28px;
            border-bottom: 1px solid var(--dark-border);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .card-header-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--primary-glow);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .card-header h4 {
            font-size: 1.15rem;
            margin: 0;
            color: var(--text-primary);
        }
        .card-body {
            padding: 28px;
        }

        /* Form Elements */
        .form-label {
            color: var(--text-secondary);
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            background: var(--dark-bg);
            border: 1px solid var(--dark-border);
            color: var(--text-primary);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            background: var(--dark-bg);
            border-color: var(--primary);
            color: var(--text-primary);
            box-shadow: 0 0 0 4px var(--primary-glow);
        }
        .form-control::placeholder { color: var(--text-muted); }
        textarea.form-control { resize: vertical; min-height: 80px; }

        .form-text {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 6px;
        }

        /* Image Upload */
        .image-upload-block {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }
        .image-preview-wrapper {
            position: relative;
            width: 160px;
            height: 120px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--dark-border);
            flex-shrink: 0;
            background: var(--dark-bg);
        }
        .image-preview-wrapper img {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .image-tag {
            position: absolute;
            bottom: 8px; right: 8px;
            background: rgba(0,0,0,0.7);
            color: white;
            font-size: 0.65rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .no-image {
            width: 160px; height: 120px;
            border-radius: var(--radius-sm);
            border: 2px dashed var(--dark-border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .no-image i { font-size: 1.5rem; }
        .no-image span { font-size: 0.75rem; font-weight: 500; }
        .image-upload-controls {
            flex: 1;
            min-width: 200px;
        }
        .upload-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        .upload-input-wrapper input[type="file"] {
            position: absolute;
            left: 0; top: 0; opacity: 0;
            width: 100%; height: 100%;
            cursor: pointer;
        }
        .upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--dark-bg);
            border: 1px dashed var(--dark-border);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }
        .upload-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-glow);
        }
        .upload-filename {
            margin-top: 8px;
            font-size: 0.8rem;
            color: var(--text-muted);
            min-height: 20px;
        }

        /* Menu & Testimonial Items */
        .item-card {
            background: var(--dark-bg);
            border: 1px solid var(--dark-border);
            border-radius: var(--radius-sm);
            padding: 24px;
            margin-bottom: 20px;
            transition: all 0.2s ease;
        }
        .item-card:hover {
            border-color: var(--dark-border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        .item-card:last-child { margin-bottom: 0; }
        .item-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .item-number {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--primary-glow);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
        .item-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        .item-rating {
            margin-left: auto;
            font-size: 0.8rem;
        }

        /* Save Button */
        .save-btn-wrapper {
            position: fixed;
            bottom: 32px;
            right: 48px;
            z-index: 100;
        }
        .save-btn {
            background: var(--primary);
            border: none;
            color: white;
            padding: 16px 36px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 8px 30px rgba(255, 127, 127, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .save-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(255, 127, 127, 0.5);
        }
        .save-btn:active { transform: translateY(0); }

        /* Alerts */
        .alert {
            border-radius: var(--radius-sm);
            border: none;
            padding: 16px 20px;
            font-weight: 500;
            font-size: 0.92rem;
        }
        .alert-success {
            background: rgba(74, 222, 128, 0.1);
            color: var(--success);
            border: 1px solid rgba(74, 222, 128, 0.2);
        }
        .alert-danger {
            background: rgba(248, 113, 113, 0.1);
            color: var(--danger);
            border: 1px solid rgba(248, 113, 113, 0.2);
        }
        .alert-dismissible .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: 0.5;
        }

        /* Mobile */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .main-content { margin-left: 0; padding: 80px 20px 40px; }
            .save-btn-wrapper { right: 20px; bottom: 20px; }
            .save-btn { padding: 14px 28px; font-size: 0.95rem; }
        }
        @media (max-width: 576px) {
            .main-content { padding: 80px 16px 40px; }
            .card-body { padding: 20px; }
            .image-upload-block { flex-direction: column; }
        }
    </style>
</head>
<body>

    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h3>Sakura Sushi</h3>
            <small>Content Manager</small>
        </div>
        <div class="sidebar-nav">
            <?php foreach ($sections as $id => $sec): ?>
            <a href="#<?php echo $id; ?>" class="nav-link" data-section="<?php echo $id; ?>">
                <i class="fas <?php echo $sec['icon']; ?>"></i>
                <?php echo $sec['label']; ?>
            </a>
            <?php endforeach; ?>
        </div>
        <div class="sidebar-footer">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="page-header">
            <h1>Edit Website Content</h1>
            <p>Manage your site content, images, and information from one place.</p>
        </div>

        <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show mb-4" role="alert">
            <?php echo e($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data" id="contentForm">

            <!-- Site Settings -->
            <div id="site" class="admin-card">
                <div class="card-header">
                    <div class="card-header-icon"><i class="fas fa-globe"></i></div>
                    <h4>Site Settings</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Website Title</label>
                        <input type="text" class="form-control" name="site_title" value="<?php echo e($data['site']['title']); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Favicon</label>
                        <div class="image-upload-block">
                            <?php echo currentImagePreview($data['site']['favicon'] ?? ''); ?>
                            <div class="image-upload-controls">
                                <input type="text" class="form-control mb-2" name="site_favicon_url" placeholder="Or paste an image URL" value="<?php echo e($data['site']['favicon'] ?? ''); ?>">
                                <div class="upload-input-wrapper">
                                    <div class="upload-btn">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Choose file to upload</span>
                                    </div>
                                    <input type="file" name="site_favicon" accept=".jpg,.jpeg,.png,.webp,.gif,.ico" onchange="showFileName(this)">
                                </div>
                                <div class="upload-filename" id="filename-site_favicon"></div>
                            </div>
                        </div>
                        <div class="form-text">Recommended: 32x32px .ico or .png. Max 2MB.</div>
                    </div>
                </div>
            </div>

            <!-- Hero Section -->
            <div id="hero" class="admin-card">
                <div class="card-header">
                    <div class="card-header-icon"><i class="fas fa-image"></i></div>
                    <h4>Hero Section</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Heading</label>
                        <input type="text" class="form-control" name="hero_heading" value="<?php echo e($data['hero']['heading']); ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Subheading</label>
                        <textarea class="form-control" name="hero_subheading" rows="2"><?php echo e($data['hero']['subheading']); ?></textarea>
                    </div>
                    <div>
                        <label class="form-label">Background Image</label>
                        <div class="image-upload-block">
                            <?php echo currentImagePreview($data['hero']['image'] ?? ''); ?>
                            <div class="image-upload-controls">
                                <input type="text" class="form-control mb-2" name="hero_image_url" placeholder="Or paste an image URL" value="<?php echo e($data['hero']['image'] ?? ''); ?>">
                                <div class="upload-input-wrapper">
                                    <div class="upload-btn">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Choose file to upload</span>
                                    </div>
                                    <input type="file" name="hero_image" accept=".jpg,.jpeg,.png,.webp,.gif" onchange="showFileName(this)">
                                </div>
                                <div class="upload-filename" id="filename-hero_image"></div>
                            </div>
                        </div>
                        <div class="form-text">Recommended: 1920x1080px. Max 2MB.</div>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div id="menu" class="admin-card">
                <div class="card-header">
                    <div class="card-header-icon"><i class="fas fa-utensils"></i></div>
                    <h4>Menu Items</h4>
                </div>
                <div class="card-body">
                    <?php foreach ($data['menu'] as $index => $item): ?>
                    <div class="item-card">
                        <div class="item-header">
                            <div class="item-number"><?php echo $index + 1; ?></div>
                            <h5 class="item-title"><?php echo e($item['title']); ?></h5>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Dish Image</label>
                                <?php echo currentImagePreview($item['image'] ?? ''); ?>
                                <input type="text" class="form-control form-control-sm mt-2" name="menu_image_url_<?php echo $index; ?>" placeholder="Or paste URL" value="<?php echo e($item['image'] ?? ''); ?>">
                                <div class="upload-input-wrapper mt-2">
                                    <div class="upload-btn" style="padding: 8px 14px; font-size: 0.82rem;">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Upload image</span>
                                    </div>
                                    <input type="file" name="menu_image_<?php echo $index; ?>" accept=".jpg,.jpeg,.png,.webp,.gif" onchange="showFileName(this)">
                                </div>
                                <div class="upload-filename" id="filename-menu_image_<?php echo $index; ?>"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-sm-7">
                                        <label class="form-label">Dish Name</label>
                                        <input type="text" class="form-control" name="menu_title_<?php echo $index; ?>" value="<?php echo e($item['title']); ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="form-control" name="menu_price_<?php echo $index; ?>" value="<?php echo e($item['price']); ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="menu_desc_<?php echo $index; ?>" rows="2"><?php echo e($item['description']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Testimonials -->
            <div id="testimonials" class="admin-card">
                <div class="card-header">
                    <div class="card-header-icon"><i class="fas fa-comments"></i></div>
                    <h4>Testimonials</h4>
                </div>
                <div class="card-body">
                    <?php foreach ($data['testimonials'] as $index => $t): ?>
                    <div class="item-card">
                        <div class="item-header">
                            <div class="item-number"><?php echo $index + 1; ?></div>
                            <h5 class="item-title"><?php echo e($t['name']); ?></h5>
                            <div class="item-rating">
                                <?php echo renderStars($t['stars'] ?? 5); ?>
                                <span class="text-muted ms-1">(<?php echo e($t['stars'] ?? 5); ?>)</span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Customer Photo</label>
                                <?php echo currentImagePreview($t['image'] ?? ''); ?>
                                <input type="text" class="form-control form-control-sm mt-2" name="test_image_url_<?php echo $index; ?>" placeholder="Or paste URL" value="<?php echo e($t['image'] ?? ''); ?>">
                                <div class="upload-input-wrapper mt-2">
                                    <div class="upload-btn" style="padding: 8px 14px; font-size: 0.82rem;">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Upload photo</span>
                                    </div>
                                    <input type="file" name="test_image_<?php echo $index; ?>" accept=".jpg,.jpeg,.png,.webp,.gif" onchange="showFileName(this)">
                                </div>
                                <div class="upload-filename" id="filename-test_image_<?php echo $index; ?>"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-sm-7">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" name="test_name_<?php echo $index; ?>" value="<?php echo e($t['name']); ?>">
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="form-label">Star Rating</label>
                                        <input type="number" step="0.5" min="0" max="5" class="form-control" name="test_stars_<?php echo $index; ?>" value="<?php echo e($t['stars']); ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Quote</label>
                                        <textarea class="form-control" name="test_quote_<?php echo $index; ?>" rows="2"><?php echo e($t['quote']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Contact Info -->
            <div id="contact" class="admin-card">
                <div class="card-header">
                    <div class="card-header-icon"><i class="fas fa-address-card"></i></div>
                    <h4>Contact Info</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Introduction Text</label>
                        <textarea class="form-control" name="contact_intro" rows="2"><?php echo e($data['contact']['intro']); ?></textarea>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="contact_address" value="<?php echo e($data['contact']['address']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="contact_phone" value="<?php echo e($data['contact']['phone']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="contact_email" value="<?php echo e($data['contact']['email']); ?>">
                        </div>
                    </div>
                    <div style="border-top: 1px solid var(--dark-border); padding-top: 24px;">
                        <h5 class="mb-3" style="font-size: 0.95rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Social Media Links</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label"><i class="fab fa-instagram me-1 text-muted"></i> Instagram</label>
                                <input type="text" class="form-control" name="social_instagram" value="<?php echo e($data['contact']['social']['instagram'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fab fa-facebook me-1 text-muted"></i> Facebook</label>
                                <input type="text" class="form-control" name="social_facebook" value="<?php echo e($data['contact']['social']['facebook'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="fab fa-twitter me-1 text-muted"></i> Twitter / X</label>
                                <input type="text" class="form-control" name="social_twitter" value="<?php echo e($data['contact']['social']['twitter'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opening Hours -->
            <div id="hours" class="admin-card">
                <div class="card-header">
                    <div class="card-header-icon"><i class="fas fa-clock"></i></div>
                    <h4>Opening Hours</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Monday — Thursday</label>
                            <input type="text" class="form-control" name="hours_mon_thu" value="<?php echo e($data['opening_hours']['mon_thu']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Friday</label>
                            <input type="text" class="form-control" name="hours_fri" value="<?php echo e($data['opening_hours']['fri']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Saturday</label>
                            <input type="text" class="form-control" name="hours_sat" value="<?php echo e($data['opening_hours']['sat']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sunday</label>
                            <input type="text" class="form-control" name="hours_sun" value="<?php echo e($data['opening_hours']['sun']); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="save-btn-wrapper">
                <button type="submit" class="save-btn">
                    <i class="fas fa-check"></i>
                    Save All Changes
                </button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function showFileName(input) {
            const id = 'filename-' + input.name;
            const el = document.getElementById(id);
            if (el && input.files && input.files.length > 0) {
                el.textContent = 'Selected: ' + input.files[0].name;
                el.style.color = '#ff7f7f';
            }
        }

        // Active nav link based on scroll
        const sections = document.querySelectorAll('.admin-card');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-section') === current) {
                    link.classList.add('active');
                }
            });
        });

        // Smooth scroll for nav links
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    if (window.innerWidth < 992) {
                        document.getElementById('sidebar').classList.remove('open');
                    }
                }
            });
        });
    </script>
</body>
</html>
