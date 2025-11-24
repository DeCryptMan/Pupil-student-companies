<?php
namespace Src\Controllers;

use Src\Models\Event;
use Src\Models\News;
use Src\Models\Gallery;

class HomeController {
    public function index() {
        // 1. Получаем события (Только будущие)
        $events = Event::getAllFuture();
        
        // 2. Получаем новости (Сортировка по дате уже в модели)
        $news = News::getAll();
        
        // 3. Получаем галерею
        $gallery = Gallery::getAll();

        // 4. Подготовка данных для JS-календаря (JSON)
        // Преобразуем PHP массив в формат, понятный Javascript
        $eventsJson = json_encode(array_map(function($e) {
            return [
                'day' => (int)date('d', strtotime($e['event_date'])),
                'month' => (int)date('m', strtotime($e['event_date'])),
                'title' => $e['title'],
                'type' => $e['type'] // deadline, meeting, event
            ];
        }, $events));

        // 5. Подключаем View и передаем туда переменные
        require __DIR__ . '/../../views/home.php';
    }
}