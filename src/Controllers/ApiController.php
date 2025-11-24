<?php
namespace Src\Controllers;

use Src\Models\Application;

class ApiController {
    public function handleApplication() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
            return;
        }

        // Получаем JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['name']) || empty($input['email']) || empty($input['college'])) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            return;
        }

        if (Application::create($input)) {
            echo json_encode(['status' => 'success', 'message' => 'Application received!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
    }
}