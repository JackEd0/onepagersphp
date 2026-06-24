<?php
$dataPath = __DIR__ . '/data/content.json';
$data = json_decode(file_get_contents($dataPath), true);
if (!$data) {
    die('Failed to load content data.');
}

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function renderStars($stars) {
    $full = floor($stars);
    $half = ($stars - $full) >= 0.5;
    $html = '';
    for ($i = 0; $i < $full; $i++) {
        $html .= '<i class="fas fa-star"></i>';
    }
    if ($half) {
        $html .= '<i class="fas fa-star-half-alt"></i>';
    }
    return $html;
}

$site = $data['site'] ?? [];
$hero = $data['hero'] ?? [];
$menu = $data['menu'] ?? [];
$testimonials = $data['testimonials'] ?? [];
$contact = $data['contact'] ?? [];
$opening_hours = $data['opening_hours'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($site['title'] ?? 'Sakura Sushi'); ?></title>
    <?php if (!empty($site['favicon'])): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo e($site['favicon']); ?>">
    <?php endif; ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #ff7f7f;
            --text-dark: #333333;
            --text-light: #777777;
            --bg-light: #f9f9f9;
        }
        body { font-family: 'Lato', sans-serif; color: var(--text-dark); overflow-x: hidden; }
        h1, h2, h3, h4, h5, .navbar-brand { font-family: 'Playfair Display', serif; }
        section { padding: 80px 0; }
        .text-primary-custom { color: var(--primary-color) !important; }
        .btn-primary-custom { background-color: var(--primary-color); border-color: var(--primary-color); color: white; padding: 12px 30px; border-radius: 50px; transition: all 0.3s ease; }
        .btn-primary-custom:hover { background-color: #ff6b6b; border-color: #ff6b6b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 127, 127, 0.3); }
        .navbar { background-color: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 15px 0; }
        .navbar-brand { font-size: 1.8rem; font-weight: bold; color: var(--text-dark) !important; }
        .nav-link { font-weight: 700; color: var(--text-dark) !important; margin-left: 20px; font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase; }
        .nav-link:hover { color: var(--primary-color) !important; }
        .hero { position: relative; height: 90vh; background: url('<?php echo e($hero['image'] ?? ''); ?>') no-repeat center center/cover; display: flex; align-items: center; justify-content: center; text-align: center; color: white; }
        .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); }
        .hero-content { position: relative; z-index: 1; max-width: 800px; padding: 20px; }
        .hero h1 { font-size: 4rem; margin-bottom: 20px; }
        .hero p { font-size: 1.2rem; margin-bottom: 30px; opacity: 0.9; }
        .card-img-top { height: 250px; object-fit: cover; transition: transform 0.3s; }
        .menu-card { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: all 0.3s ease; height: 100%; }
        .menu-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .menu-card:hover .card-img-top { transform: scale(1.05); }
        .card-overflow { overflow: hidden; border-top-left-radius: calc(0.375rem - 1px); border-top-right-radius: calc(0.375rem - 1px); }
        .price-tag { color: var(--primary-color); font-weight: 700; font-size: 1.2rem; }
        .section-bg-light { background-color: var(--bg-light); }
        .testimonial-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); text-align: center; height: 100%; }
        .testimonial-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; border: 3px solid var(--primary-color); }
        .stars { color: #ffc107; margin-bottom: 15px; }
        .contact-info-item { margin-bottom: 20px; display: flex; align-items: center; }
        .contact-icon { width: 50px; height: 50px; background-color: rgba(255, 127, 127, 0.1); color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 1.2rem; }
        .hours-table td { padding: 10px 0; border-bottom: 1px solid #eee; }
        footer { background-color: #222; color: #888; padding: 40px 0; text-align: center; font-size: 0.9rem; }
        @media (max-width: 768px) { .hero h1 { font-size: 2.5rem; } section { padding: 50px 0; } }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-fish text-primary-custom me-2"></i>Sakura Sushi
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Reviews</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="hero" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1><?php echo e($hero['heading'] ?? 'The Art of Freshness'); ?></h1>
            <p><?php echo e($hero['subheading'] ?? ''); ?></p>
            <a href="#menu" class="btn btn-primary-custom btn-lg mt-3">View Full Menu</a>
        </div>
    </header>

    <section id="menu">
        <div class="container">
            <div class="text-center mb-5">
                <h5 class="text-primary-custom text-uppercase letter-spacing-2">Discover</h5>
                <h2 class="display-5 fw-bold">Our Menu</h2>
                <p class="text-muted w-75 mx-auto">Hand-picked ingredients, daily fresh fish, and masterfully crafted rolls.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($menu as $item): ?>
                <div class="col">
                    <div class="card menu-card">
                        <div class="card-overflow">
                            <img src="<?php echo e($item['image'] ?? ''); ?>" class="card-img-top" alt="<?php echo e($item['title'] ?? ''); ?>">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0 fw-bold"><?php echo e($item['title'] ?? ''); ?></h5>
                                <span class="price-tag"><?php echo e($item['price'] ?? ''); ?></span>
                            </div>
                            <p class="card-text text-muted"><?php echo e($item['description'] ?? ''); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="testimonials" class="section-bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h5 class="text-primary-custom text-uppercase letter-spacing-2">Testimonials</h5>
                <h2 class="display-5 fw-bold">What People Say</h2>
            </div>

            <div class="row g-4">
                <?php foreach ($testimonials as $t): ?>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <img src="<?php echo e($t['image'] ?? ''); ?>" alt="<?php echo e($t['name'] ?? ''); ?>" class="testimonial-img">
                        <div class="stars">
                            <?php echo renderStars($t['stars'] ?? 5); ?>
                        </div>
                        <p class="fst-italic">"<?php echo e($t['quote'] ?? ''); ?>"</p>
                        <h6 class="fw-bold mt-3">- <?php echo e($t['name'] ?? ''); ?></h6>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h5 class="text-primary-custom text-uppercase letter-spacing-2">Visit Us</h5>
                    <h2 class="display-5 fw-bold mb-4">Contact Info</h2>
                    <p class="text-muted mb-5"><?php echo e($contact['intro'] ?? ''); ?></p>

                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Location</h6>
                            <span class="text-muted"><?php echo e($contact['address'] ?? ''); ?></span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Phone</h6>
                            <span class="text-muted"><?php echo e($contact['phone'] ?? ''); ?></span>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h6 class="fw-bold mb-0">Email</h6>
                            <span class="text-muted"><?php echo e($contact['email'] ?? ''); ?></span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="<?php echo e($contact['social']['instagram'] ?? '#'); ?>" class="btn btn-outline-dark me-2 rounded-circle" style="width: 40px; height:40px; padding:0; line-height:40px;"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo e($contact['social']['facebook'] ?? '#'); ?>" class="btn btn-outline-dark me-2 rounded-circle" style="width: 40px; height:40px; padding:0; line-height:40px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo e($contact['social']['twitter'] ?? '#'); ?>" class="btn btn-outline-dark rounded-circle" style="width: 40px; height:40px; padding:0; line-height:40px;"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-5 bg-light rounded-3 shadow-sm">
                        <h3 class="fw-bold mb-4">Opening Hours</h3>
                        <table class="w-100 hours-table text-muted">
                            <tbody>
                                <tr><td>Monday - Thursday</td><td class="text-end"><?php echo e($opening_hours['mon_thu'] ?? ''); ?></td></tr>
                                <tr><td>Friday</td><td class="text-end"><?php echo e($opening_hours['fri'] ?? ''); ?></td></tr>
                                <tr><td>Saturday</td><td class="text-end"><?php echo e($opening_hours['sat'] ?? ''); ?></td></tr>
                                <tr><td>Sunday</td><td class="text-end"><?php echo e($opening_hours['sun'] ?? ''); ?></td></tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary-custom w-100 mt-4">Book a Table</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Sakura Sushi. All Rights Reserved.</p>
            <small class="text-muted">Designed with <i class="fas fa-heart text-danger"></i> and Rice.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.nav-link').forEach(item => {
            item.addEventListener('click', () => {
                const navbarToggler = document.querySelector('.navbar-toggler');
                const collapse = document.querySelector('.navbar-collapse');
                if (window.getComputedStyle(navbarToggler).display !== 'none') {
                    const bsCollapse = new bootstrap.Collapse(collapse, {toggle: true});
                }
            });
        });
    </script>
</body>
</html>
