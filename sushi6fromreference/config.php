<?php
// Basic PHP configuration for the Sushi website

// Database configuration (for future use)
define('DB_HOST', 'localhost');
define('DB_NAME', 'sushi_restaurant');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_NAME', 'Sushise');
define('SITE_URL', 'http://localhost/onepagersphp/sushi6fromreference/');
define('ADMIN_EMAIL', 'admin@sushise.com');

// Timezone
date_default_timezone_set('Asia/Tokyo');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
session_start();

// Basic functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function format_price($price) {
    return '$' . number_format($price, 2);
}

// Menu items (sample data)
$menu_items = [
    [
        'id' => 1,
        'name' => 'Maguro Sushi',
        'description' => 'Fresh tuna sashimi on seasoned rice',
        'price' => 8.00,
        'category' => 'nigiri',
        'image' => 'maguro-sushi.jpg',
        'rating' => 4.8
    ],
    [
        'id' => 2,
        'name' => 'Salmon Roll',
        'description' => 'Fresh salmon with avocado and cucumber',
        'price' => 12.00,
        'category' => 'maki',
        'image' => 'salmon-roll.jpg',
        'rating' => 4.7
    ],
    [
        'id' => 3,
        'name' => 'Dragon Roll',
        'description' => 'Eel and avocado with special sauce',
        'price' => 15.00,
        'category' => 'specialty',
        'image' => 'dragon-roll.jpg',
        'rating' => 4.9
    ],
    [
        'id' => 4,
        'name' => 'Chirashi Bowl',
        'description' => 'Assorted sashimi over sushi rice',
        'price' => 18.00,
        'category' => 'bowl',
        'image' => 'chirashi-bowl.jpg',
        'rating' => 4.8
    ]
];

// Restaurant information
$restaurant_info = [
    'name' => 'Sushise',
    'phone' => '+81 3-1234-5678',
    'email' => 'info@sushise.com',
    'address' => '123 Sushi Street, Tokyo, Japan',
    'hours' => [
        'monday' => '11:00 AM - 9:00 PM',
        'tuesday' => '11:00 AM - 9:00 PM',
        'wednesday' => '11:00 AM - 9:00 PM',
        'thursday' => '11:00 AM - 9:00 PM',
        'friday' => '11:00 AM - 10:00 PM',
        'saturday' => '11:00 AM - 10:00 PM',
        'sunday' => '12:00 PM - 9:00 PM'
    ]
];

// Function to get menu items by category
function get_menu_by_category($category = null) {
    global $menu_items;
    if ($category) {
        return array_filter($menu_items, function($item) use ($category) {
            return $item['category'] === $category;
        });
    }
    return $menu_items;
}

// Function to get single menu item
function get_menu_item($id) {
    global $menu_items;
    foreach ($menu_items as $item) {
        if ($item['id'] == $id) {
            return $item;
        }
    }
    return null;
}

// Function to process contact form
function process_contact_form($data) {
    $name = sanitize_input($data['name']);
    $email = sanitize_input($data['email']);
    $message = sanitize_input($data['message']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email address'];
    }

    // Here you would typically save to database or send email
    // For now, just return success
    return ['success' => true, 'message' => 'Thank you for your message!'];
}

// Function to process reservation
function process_reservation($data) {
    $name = sanitize_input($data['name']);
    $email = sanitize_input($data['email']);
    $phone = sanitize_input($data['phone']);
    $date = sanitize_input($data['date']);
    $time = sanitize_input($data['time']);
    $guests = (int)$data['guests'];

    // Validate data
    if (empty($name) || empty($email) || empty($date) || empty($time)) {
        return ['success' => false, 'message' => 'Please fill in all required fields'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email address'];
    }

    if ($guests < 1 || $guests > 10) {
        return ['success' => false, 'message' => 'Number of guests must be between 1 and 10'];
    }

    // Here you would typically save to database
    // For now, just return success
    return ['success' => true, 'message' => 'Reservation confirmed!'];
}

?>
