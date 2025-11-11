<?php

// Create categories directory if it doesn't exist
$categoriesDir = 'storage/app/public/categories';
if (!file_exists($categoriesDir)) {
    mkdir($categoriesDir, 0755, true);
}

// List of image files to copy
$images = [
    'rolce-image.png',
    'photo-video.png',
    'beautiful-home.png',
    'music-violin.png',
    'flower-cat.png',
    'furchete-cat.png',
    'horse-cat.png',
    'gift-car.png',
    'accesories.png'
];

foreach ($images as $image) {
    $source = 'public/images/' . $image;
    $destination = 'storage/app/public/categories/' . $image;
    
    if (file_exists($source)) {
        if (copy($source, $destination)) {
            echo "Copied $image successfully\n";
        } else {
            echo "Failed to copy $image\n";
        }
    } else {
        echo "Source file $image not found\n";
    }
}

echo "Image copying complete.\n";