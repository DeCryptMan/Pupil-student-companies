<?php
namespace Src\Controllers;

use Src\Models\Gallery;

class GalleryController {
    public function index() {
        // Получаем ВСЕ медиа
        $gallery = Gallery::getAll();
        
        require __DIR__ . '/../../views/gallery_page.php';
    }
}