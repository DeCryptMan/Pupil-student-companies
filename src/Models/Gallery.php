<?php
namespace Src\Models;
use Src\Core\Database;
use PDO;

class Gallery {
    public static function getAll() {
        $pdo = Database::getInstance()->getConnection();
        return $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
    }

    public static function create($type, $url, $caption) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("INSERT INTO gallery (type, media_url, caption) VALUES (?, ?, ?)");
        return $stmt->execute([$type, filter_var($url, FILTER_SANITIZE_URL), strip_tags($caption)]);
    }

    public static function delete($id) {
        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }
}