<?php
/**
 * Save Config PHP Script
 *
 * This script receives JSON data from admin.js and saves it to the specified file.
 */

header('Content-Type: application/json');

// Disable caching
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Get JSON data from the request
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Validate the data
if (!isset($data['file']) || !isset($data['data'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

// Validate the file path to prevent directory traversal
$file_path = $data['file'];
if (strpos($file_path, '..') !== false || !preg_match('/^config\/[a-zA-Z0-9_\-\.]+\.json$/', $file_path)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid file path'
    ]);
    exit;
}

try {
    // Write the data to the file
    $json_content = json_encode($data['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $result = file_put_contents($file_path, $json_content);

    if ($result === false) {
        throw new Exception('Failed to write to file');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Configuration saved successfully',
        'bytes_written' => $result
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
