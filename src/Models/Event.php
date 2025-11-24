<?php
namespace Src\Models;

use Src\Core\Database;
use PDO;

class Event {
    
    // Получить все будущие события (для главной страницы)
    public static function getAllFuture(int $limit = 10): array {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Получить ВСЕ события (для админки), отсортированные по новизне
    public static function getAll(): array {
        $pdo = Database::getInstance()->getConnection();
        return $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();
    }

    // Создать событие
    public static function create(string $title, string $date, string $type = 'event'): bool {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date, type) VALUES (?, ?, ?)");
        return $stmt->execute([strip_tags($title), $date, $type]);
    }

    // Удалить событие
    public static function delete(int $id): bool {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        return $stmt->execute([$id]);
    }
}