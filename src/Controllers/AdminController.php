<?php
namespace Src\Controllers;

use Src\Core\Database;
use Src\Models\Event;
use Src\Models\News;
use Src\Models\Gallery;
use PDO;

class AdminController {

    // --- 1. AUTHENTICATION ---

    public function loginPage(): void {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        require __DIR__ . '/../../views/admin/login.php';
    }

    public function handleLogin(): void {
        $input = json_decode(file_get_contents('php://input'), true);
        $username = trim($input['username'] ?? '');
        $password = $input['password'] ?? '';

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            
            $this->jsonResponse(['status' => 'success', 'redirect' => $this->getBasePath() . '/dashboard']);
        } else {
            sleep(1);
            $this->jsonResponse(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/');
    }

    // --- 2. DASHBOARD ---

    public function dashboard(): void {
        $this->requireAuth();

        try {
            $events = Event::getAll();
            $news = News::getAll();
            $gallery = Gallery::getAll();
            $applications = $this->fetchApplications(); // Получаем список

            $stats = [
                'events' => count($events),
                'news' => count($news),
                'gallery' => count($gallery),
                'apps' => count($applications)
            ];
        } catch (\Exception $e) {
            $events = []; $news = []; $gallery = []; $applications = [];
            $stats = ['events'=>0, 'news'=>0, 'gallery'=>0, 'apps'=>0];
        }

        $base = $this->getBasePath();
        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    // --- 3. APPLICATION VIEWER (ТОТ САМЫЙ МЕТОД ДЛЯ МОДАЛКИ) ---

    public function getApplication(): void {
        $this->requireAuth();
        
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            $this->jsonResponse(['status' => 'error', 'message' => 'Invalid ID'], 400);
        }

        $pdo = Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $app = $stmt->fetch();

        if ($app) {
            $this->jsonResponse(['status' => 'success', 'data' => $app]);
        } else {
            $this->jsonResponse(['status' => 'error', 'message' => 'Not found'], 404);
        }
    }

    // --- 4. CRUD ACTIONS (EVENTS, NEWS, GALLERY) ---

    public function addEvent(): void {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Event::create($_POST['title'], $_POST['date'], $_POST['type']);
        }
        $this->redirect('/dashboard?tab=events');
    }

    public function deleteEvent(): void {
        $this->requireAuth();
        if ($id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
            Event::delete($id);
        }
        $this->redirect('/dashboard?tab=events');
    }

public function addNews(): void {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $date = $_POST['date'];
            
            $imagePaths = [];
            
            // Проверяем файлы
            if (!empty($_FILES['images']['name'][0])) {
                $files = $_FILES['images'];
                $count = count($files['name']);
                
                // 1. Определяем физический путь (SYSTEM PATH)
                // __DIR__ - это папка контроллера. Выходим на 2 уровня вверх в корень
                $uploadDir = __DIR__ . '/../../uploads/news/';
                
                // Создаем папку, если нет
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] === UPLOAD_ERR_OK) {
                        $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                        $filename = 'news_' . time() . '_' . uniqid() . '.' . $ext;
                        $dest = $uploadDir . $filename;
                        
                        if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                            // 2. Сохраняем WEB путь (БЕЗ ВЕДУЩЕГО СЛЭША!)
                            // Было: '/uploads/news/' ...
                            // Стало: 'uploads/news/' ...
                            $imagePaths[] = 'uploads/news/' . $filename;
                        }
                    }
                }
            }

            // Заглушка, если пусто
            if (empty($imagePaths)) {
                $imagePaths[] = 'https://via.placeholder.com/800x600?text=No+Image';
            }

            $imagesJson = json_encode($imagePaths);
            News::create($title, $imagesJson, $content, $date);
        }
        $this->redirect('/dashboard?tab=news');
    }

    public function deleteNews(): void {
        $this->requireAuth();
        if ($id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
            News::delete($id);
        }
        $this->redirect('/dashboard?tab=news');
    }

public function addGallery(): void {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $caption = $_POST['caption'];
            $mediaList = [];
            $mainType = 'photo'; // По умолчанию

            // Проверяем файлы
            if (!empty($_FILES['media']['name'][0])) {
                $files = $_FILES['media'];
                $count = count($files['name']);
                $uploadDir = __DIR__ . '/../../uploads/gallery/';
                
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                for ($i = 0; $i < $count; $i++) {
                    if ($files['error'][$i] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                        $filename = 'gallery_' . time() . '_' . uniqid() . '.' . $ext;
                        $dest = $uploadDir . $filename;
                        
                        // Определяем тип файла
                        $fileType = 'photo';
                        if (in_array($ext, ['mp4', 'webm', 'mov', 'avi'])) {
                            $fileType = 'video';
                            $mainType = 'video'; // Если есть хоть одно видео, помечаем альбом как видео
                        }

                        if (move_uploaded_file($files['tmp_name'][$i], $dest)) {
                            $mediaList[] = [
                                'type' => $fileType,
                                'url'  => 'uploads/gallery/' . $filename
                            ];
                        }
                    }
                }
            }
            
            // Если это смешанный контент (и фото и видео), ставим тип mixed
            if (count($mediaList) > 1) $mainType = 'mixed';

            // Если загрузили URL вручную (старый метод), добавляем его
            if (!empty($_POST['url'])) {
                $mediaList[] = ['type' => $_POST['type'] ?? 'photo', 'url' => $_POST['url']];
            }

            // Сохраняем JSON
            Gallery::create($mainType, json_encode($mediaList), $caption);
        }
        $this->redirect('/dashboard?tab=gallery');
    }
    public function deleteGallery(): void {
        $this->requireAuth();
        if ($id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
            Gallery::delete($id);
        }
        $this->redirect('/dashboard?tab=gallery');
    }

    // --- 5. HELPERS ---

    private function isLoggedIn(): bool {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    private function requireAuth(): void {
        if (!$this->isLoggedIn()) {
            header('HTTP/1.0 403 Forbidden');
            exit;
        }
    }

    private function getBasePath(): string {
        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        return ($scriptName === '/') ? '' : $scriptName;
    }

    private function redirect(string $path): void {
        header("Location: " . $this->getBasePath() . $path);
        exit;
    }

    private function jsonResponse(array $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function fetchApplications(): array {
        try {
            $pdo = Database::getInstance()->getConnection();
            $check = $pdo->query("SHOW TABLES LIKE 'applications'");
            if ($check->rowCount() > 0) {
                return $pdo->query("SELECT * FROM applications ORDER BY created_at DESC LIMIT 50")->fetchAll();
            }
        } catch (\Exception $e) {}
        return [];
    }
}