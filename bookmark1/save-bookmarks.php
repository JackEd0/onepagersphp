<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get the JSON data from the request body
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if ($data === null) {
            throw new Exception('Invalid JSON data');
        }
        
        // Validate the data structure
        if (!isset($data['bookmarks']) || !isset($data['collections'])) {
            throw new Exception('Missing required data fields');
        }
        
        // Add timestamp
        $data['lastUpdated'] = date('c');
        
        // Save to JSON file
        $filename = 'bookmarks-data.json';
        $result = file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
        
        if ($result === false) {
            throw new Exception('Failed to write to file');
        }
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Bookmarks saved successfully',
            'timestamp' => $data['lastUpdated']
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle GET requests to read the data file
    $filename = 'bookmarks-data.json';
    
    if (file_exists($filename)) {
        $data = file_get_contents($filename);
        echo $data;
    } else {
        // Return empty data structure if file doesn't exist
        echo json_encode([
            'bookmarks' => [],
            'collections' => [],
            'lastUpdated' => null
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed'
    ]);
}
?> 