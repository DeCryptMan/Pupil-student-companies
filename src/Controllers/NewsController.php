<?php
namespace Src\Controllers;

use Src\Models\News;

class NewsController {
    
    public function index() {
        $news = News::getAll();
        require __DIR__ . '/../../views/news_page.php';
    }

    public function view($id) {
        $id = (int)$id;
        
        // Получаем новость по ID
        // (Убедитесь, что метод getById есть в модели News!)
        $item = News::getById($id);

        if (empty($item)) {
            // Если новости нет - редирект на список
            header("Location: ../news");
            exit;
        }

        require __DIR__ . '/../../views/news_single.php';
    }
}