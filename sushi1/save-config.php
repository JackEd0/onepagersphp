<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get the JSON input
$input = file_get_contents('php://input');
$config = json_decode($input, true);

// Validate JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

// Validate required fields
$required_sections = ['site', 'navigation', 'hero', 'gallery', 'testimonials', 'contact', 'footer'];
foreach ($required_sections as $section) {
    if (!isset($config[$section])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required section: $section"]);
        exit;
    }
}

// Sanitize the configuration data
$sanitized_config = sanitizeConfig($config);

// Save to file
$config_file = 'site-config.json';
$backup_file = 'site-config.backup.json';

// Create backup of current config
if (file_exists($config_file)) {
    copy($config_file, $backup_file);
}

// Write new configuration
$result = file_put_contents($config_file, json_encode($sanitized_config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

if ($result === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save configuration']);
    exit;
}

// Return success response
echo json_encode([
    'success' => true,
    'message' => 'Configuration saved successfully',
    'timestamp' => date('Y-m-d H:i:s')
]);

/**
 * Sanitize configuration data
 */
function sanitizeConfig($config) {
    $sanitized = [];
    
    // Site section
    $sanitized['site'] = [
        'title' => htmlspecialchars(trim($config['site']['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'logo' => htmlspecialchars(trim($config['site']['logo'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'brand' => htmlspecialchars(trim($config['site']['brand'] ?? ''), ENT_QUOTES, 'UTF-8')
    ];
    
    // Navigation section
    $sanitized['navigation'] = [
        'items' => []
    ];
    if (isset($config['navigation']['items']) && is_array($config['navigation']['items'])) {
        foreach ($config['navigation']['items'] as $item) {
            $sanitized['navigation']['items'][] = [
                'id' => htmlspecialchars(trim($item['id'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'text' => htmlspecialchars(trim($item['text'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'href' => htmlspecialchars(trim($item['href'] ?? ''), ENT_QUOTES, 'UTF-8')
            ];
        }
    }
    
    // Hero section
    $sanitized['hero'] = [
        'title' => 'Experience ' . htmlspecialchars(trim($config['hero']['titleHighlight'] ?? ''), ENT_QUOTES, 'UTF-8') . ' Japanese Cuisine',
        'titleHighlight' => htmlspecialchars(trim($config['hero']['titleHighlight'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'subtitle' => htmlspecialchars(trim($config['hero']['subtitle'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'buttons' => []
    ];
    if (isset($config['hero']['buttons']) && is_array($config['hero']['buttons'])) {
        foreach ($config['hero']['buttons'] as $button) {
            $sanitized['hero']['buttons'][] = [
                'text' => htmlspecialchars(trim($button['text'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'href' => htmlspecialchars(trim($button['href'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'style' => $button['style'] ?? 'primary'
            ];
        }
    }
    
    // Gallery section
    $sanitized['gallery'] = [
        'title' => htmlspecialchars(trim($config['gallery']['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'subtitle' => htmlspecialchars(trim($config['gallery']['subtitle'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'items' => []
    ];
    if (isset($config['gallery']['items']) && is_array($config['gallery']['items'])) {
        foreach ($config['gallery']['items'] as $item) {
            $sanitized['gallery']['items'][] = [
                'id' => htmlspecialchars(trim($item['id'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'name' => htmlspecialchars(trim($item['name'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'description' => htmlspecialchars(trim($item['description'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'price' => htmlspecialchars(trim($item['price'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'tag' => htmlspecialchars(trim($item['tag'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'emoji' => htmlspecialchars(trim($item['emoji'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'color' => htmlspecialchars(trim($item['color'] ?? 'gray'), ENT_QUOTES, 'UTF-8')
            ];
        }
    }
    
    // Testimonials section
    $sanitized['testimonials'] = [
        'title' => htmlspecialchars(trim($config['testimonials']['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'subtitle' => htmlspecialchars(trim($config['testimonials']['subtitle'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'items' => []
    ];
    if (isset($config['testimonials']['items']) && is_array($config['testimonials']['items'])) {
        foreach ($config['testimonials']['items'] as $item) {
            $sanitized['testimonials']['items'][] = [
                'id' => htmlspecialchars(trim($item['id'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'name' => htmlspecialchars(trim($item['name'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'role' => htmlspecialchars(trim($item['role'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'content' => htmlspecialchars(trim($item['content'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'rating' => intval($item['rating'] ?? 5),
                'initial' => htmlspecialchars(trim($item['initial'] ?? ''), ENT_QUOTES, 'UTF-8')
            ];
        }
    }
    
    // Contact section
    $sanitized['contact'] = [
        'title' => htmlspecialchars(trim($config['contact']['title'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'subtitle' => htmlspecialchars(trim($config['contact']['subtitle'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'info' => [
            'address' => [
                'label' => 'Address',
                'value' => htmlspecialchars(trim($config['contact']['info']['address']['value'] ?? ''), ENT_QUOTES, 'UTF-8')
            ],
            'phone' => [
                'label' => 'Phone',
                'value' => htmlspecialchars(trim($config['contact']['info']['phone']['value'] ?? ''), ENT_QUOTES, 'UTF-8')
            ],
            'email' => [
                'label' => 'Email',
                'value' => htmlspecialchars(trim($config['contact']['info']['email']['value'] ?? ''), ENT_QUOTES, 'UTF-8')
            ],
            'hours' => [
                'label' => 'Hours',
                'value' => htmlspecialchars(trim($config['contact']['info']['hours']['value'] ?? ''), ENT_QUOTES, 'UTF-8')
            ]
        ],
        'reservation' => [
            'title' => 'Make a Reservation',
            'timeSlots' => [
                '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
                '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00'
            ]
        ]
    ];
    
    // Footer section
    $sanitized['footer'] = [
        'description' => htmlspecialchars(trim($config['footer']['description'] ?? ''), ENT_QUOTES, 'UTF-8'),
        'hours' => [
            'weekdays' => htmlspecialchars(trim($config['footer']['hours']['weekdays'] ?? ''), ENT_QUOTES, 'UTF-8'),
            'sunday' => htmlspecialchars(trim($config['footer']['hours']['sunday'] ?? ''), ENT_QUOTES, 'UTF-8')
        ],
        'copyright' => htmlspecialchars(trim($config['footer']['copyright'] ?? ''), ENT_QUOTES, 'UTF-8')
    ];
    
    return $sanitized;
}
?> 