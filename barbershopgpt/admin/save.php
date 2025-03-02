<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonFile = "../data/content.json";
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['json'])) {
        file_put_contents($jsonFile, $input['json']);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid JSON"]);
    }
} else {
    http_response_code(405); // Method Not Allowed
}
?>
