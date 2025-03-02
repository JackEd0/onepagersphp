<?php
// Load JSON content
$jsonFile = "../data/content.json";
$jsonData = file_get_contents($jsonFile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Barbershop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/split.js/1.6.5/split.min.js"></script>
    <style>
        .split { display: flex; width: 100vw; height: 100vh; }
        .left, .right { overflow: auto; }
        .left { width: 50%; background: #f8f8f8; padding: 10px; }
        .right { width: 50%; border-left: 2px solid #ddd; }
        iframe { width: 100%; height: 100%; border: none; }
    </style>
</head>
<body>

<div class="split">
    <!-- Left: JSON Editor -->
    <div class="left">
        <h2 class="text-xl font-bold mb-2">Edit JSON</h2>
        <div id="editor" class="border p-2 h-5/6 rounded-lg"></div>
        <button id="saveBtn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Save</button>
    </div>

    <!-- Right: Live Website Preview -->
    <div class="right">
        <iframe id="previewFrame" src="../index.html"></iframe>
    </div>
</div>

<script>
    Split(['.left', '.right'], { sizes: [50, 50] });

    // Initialize Ace Editor
    let editor = ace.edit("editor");
    editor.setTheme("ace/theme/github");
    editor.session.setMode("ace/mode/json");
    editor.setValue(<?php echo json_encode($jsonData); ?>, -1);

    // Save JSON to PHP script
    document.getElementById("saveBtn").addEventListener("click", function() {
        fetch('save.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ json: editor.getValue() })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("previewFrame").contentWindow.location.reload(); // Reload preview
            } else {
                alert("Error saving JSON!");
            }
        });
    });
</script>

</body>
</html>
