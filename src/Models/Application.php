<?php
namespace Src\Models;

use Src\Core\Database;
use PDO;

class Application {
    public static function create($data) {
        $pdo = Database::getInstance()->getConnection();
        
        // 1. Основные поля
        $name = strip_tags($data['name']);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $college = strip_tags($data['college']);
        $idea = strip_tags($data['idea']);
        
        // 2. ВСЕ остальные данные сохраняем как JSON (чтобы ничего не потерять)
        // Если full_data уже пришла как строка JSON, используем её, иначе кодируем массив
        $fullData = isset($data['full_data']) ? $data['full_data'] : json_encode($data, JSON_UNESCAPED_UNICODE);

        $stmt = $pdo->prepare("INSERT INTO applications (full_name, email, college, idea, full_data) VALUES (?, ?, ?, ?, ?)");
        
        return $stmt->execute([$name, $email, $college, $idea, $fullData]);
    }
}