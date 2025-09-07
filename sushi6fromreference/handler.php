<?php
require_once 'config.php';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'contact':
            $result = process_contact_form($_POST);
            break;
        case 'reservation':
            $result = process_reservation($_POST);
            break;
        default:
            $result = ['success' => false, 'message' => 'Invalid action'];
    }

    // Return JSON response for AJAX requests
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }

    // For regular form submissions, redirect with message
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['success'] ? 'success' : 'error';
    redirect('index.html#contact');
}

// Handle GET requests for menu data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'menu':
            header('Content-Type: application/json');
            $category = $_GET['category'] ?? null;
            echo json_encode(get_menu_by_category($category));
            exit();
        case 'item':
            header('Content-Type: application/json');
            $id = $_GET['id'] ?? 0;
            echo json_encode(get_menu_item($id));
            exit();
    }
}

// If no action specified, redirect to home
redirect('index.html');
?>
