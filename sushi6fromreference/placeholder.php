<?php
// Simple placeholder image generator for testing
// Call this file with parameters: placeholder.php?width=400&height=300&text=Sushi

$width = isset($_GET['width']) ? max(50, min(2000, (int)$_GET['width'])) : 400;
$height = isset($_GET['height']) ? max(50, min(2000, (int)$_GET['height'])) : 300;
$text = isset($_GET['text']) ? htmlspecialchars($_GET['text']) : 'Image';
$bg_color = isset($_GET['bg']) ? $_GET['bg'] : '2F6B4F';
$text_color = isset($_GET['color']) ? $_GET['color'] : 'FFFFFF';

// Create image
$image = imagecreate($width, $height);

// Convert hex to RGB
function hex2rgb($hex) {
    $hex = str_replace('#', '', $hex);
    return [
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2))
    ];
}

$bg_rgb = hex2rgb($bg_color);
$text_rgb = hex2rgb($text_color);

// Allocate colors
$bg = imagecolorallocate($image, $bg_rgb[0], $bg_rgb[1], $bg_rgb[2]);
$text_col = imagecolorallocate($image, $text_rgb[0], $text_rgb[1], $text_rgb[2]);

// Fill background
imagefill($image, 0, 0, $bg);

// Add text
$font_size = min($width, $height) / 15;
$font = 5; // Built-in font

// Calculate text position
$text_width = imagefontwidth($font) * strlen($text);
$text_height = imagefontheight($font);
$x = ($width - $text_width) / 2;
$y = ($height - $text_height) / 2;

imagestring($image, $font, $x, $y, $text, $text_col);

// Add dimensions text
$dimensions = $width . 'x' . $height;
$dim_width = imagefontwidth($font) * strlen($dimensions);
$dim_x = ($width - $dim_width) / 2;
$dim_y = $y + $text_height + 10;

imagestring($image, $font, $dim_x, $dim_y, $dimensions, $text_col);

// Output
header('Content-Type: image/png');
header('Cache-Control: max-age=3600');
imagepng($image);
imagedestroy($image);
?>
