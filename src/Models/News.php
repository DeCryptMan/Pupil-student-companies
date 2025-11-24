<?php
namespace Src\Models;

use Src\Core\Database;
use PDO;

class News {
    
    // Получить все новости (для списка)
    public static function getAll() {
        $pdo = Database::getInstance()->getConnection();
        return $pdo->query("SELECT * FROM news ORDER BY publish_date DESC")->fetchAll();
    }

    // 🔥 ДОБАВЛЕННЫЙ МЕТОД (Исправление ошибки)
    // Получить одну новость по ID
    public static function getById($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? LIMIT 1");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    // Создать новость
    public static function create($title, $image, $content, $date) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO news (title, image_url, content, publish_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([strip_tags($title), $image, strip_tags($content), $date]);
    }

    // Удалить новость
    public static function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }
}