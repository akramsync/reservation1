<?php
// Check if GD extension is loaded
if (!extension_loaded('gd')) {
    die('GD extension is not loaded. Please enable it in your PHP configuration.');
}

// Source image path
$source_image = 'assets/images/logo1.png';

// Check if source image exists
if (!file_exists($source_image)) {
    die('Source image not found: ' . $source_image);
}

// Load the source image
$source = imagecreatefrompng($source_image);
if (!$source) {
    die('Failed to load source image');
}

// Make sure we preserve transparency
imagealphablending($source, true);
imagesavealpha($source, true);

// Define favicon sizes
$sizes = [
    ['name' => 'favicon-16x16.png', 'size' => 16],
    ['name' => 'favicon-32x32.png', 'size' => 32],
    ['name' => 'apple-touch-icon.png', 'size' => 180],
    ['name' => 'android-chrome-192x192.png', 'size' => 192],
    ['name' => 'android-chrome-512x512.png', 'size' => 512]
];

// Create favicon directory if it doesn't exist
$favicon_dir = 'assets/images/favicon/';
if (!is_dir($favicon_dir)) {
    mkdir($favicon_dir, 0777, true);
}

// Generate favicons for each size
foreach ($sizes as $size) {
    $target = imagecreatetruecolor($size['size'], $size['size']);
    
    // Preserve transparency
    imagealphablending($target, false);
    imagesavealpha($target, true);
    
    // Fill with transparent background
    $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
    imagefilledrectangle($target, 0, 0, $size['size'], $size['size'], $transparent);
    
    // Copy and resize
    imagecopyresampled(
        $target, $source,
        0, 0, 0, 0,
        $size['size'], $size['size'],
        imagesx($source), imagesy($source)
    );
    
    // Save the file
    $filename = $favicon_dir . $size['name'];
    imagepng($target, $filename, 9);
    imagedestroy($target);
    
    echo "Generated: " . $filename . "\n";
}

// Clean up
imagedestroy($source);
echo "All favicons have been generated successfully!\n"; 