<?php
/**
 * STUDENTBIZ CORE KERNEL
 * Architecture: MVC / Front Controller
 * Features: Clean URLs, Auto-Routing, Security Headers
 */

declare(strict_types=1);

// 1. SECURITY & CONFIGURATION
error_reporting(E_ALL);
ini_set('display_errors', '1'); // В продакшене поставьте '0'
ini_set('session.cookie_httponly', '1');
ini_set('session.use_strict_mode', '1');

header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

session_start();

define('ROOT_DIR', __DIR__);
define('VIEWS_DIR', ROOT_DIR . '/views');

// 2. AUTOLOADER
spl_autoload_register(function (string $class): void {
    $prefix = 'Src\\';
    $base_dir = ROOT_DIR . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

// 3. ADVANCED ROUTER (REGEX SUPPORT)
class Router {
    private array $routes = [];
    private string $basePath;

    public function __construct() {
        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $this->basePath = ($scriptName === '/') ? '' : $scriptName;
    }

    public function add(string $method, string $path, $handler, bool $authRequired = false): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'auth' => $authRequired
        ];
    }

    public function dispatch(): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Удаляем базовую папку из URI
        if ($this->basePath !== '' && strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }
        $path = '/' . ltrim($uri, '/');

        foreach ($this->routes as $route) {
            // Превращаем {id} в регулярное выражение (\d+)
            $pattern = preg_replace('/\{id\}/', '(\d+)', $route['path']);
            $pattern = "@^" . $pattern . "$@D";

            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                // Убираем полное совпадение, оставляем параметры
                array_shift($matches);

                if ($route['auth'] === true) $this->checkAdminAuth();

                $this->executeHandler($route['handler'], $matches);
                return;
            }
        }

        $this->sendNotFound($path);
    }

    private function executeHandler($handler, $params = []): void {
        if (is_array($handler)) {
            [$controllerName, $action] = $handler;
            $controller = new $controllerName();
            call_user_func_array([$controller, $action], $params);
        } elseif (is_callable($handler)) {
            call_user_func_array($handler, $params);
        }
    }

    private function checkAdminAuth(): void {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('HTTP/1.0 403 Forbidden'); exit;
        }
    }

    private function sendNotFound($path): void {
        http_response_code(404);
        echo "<div style='font-family:sans-serif;text-align:center;padding:50px;'><h1>404 Not Found</h1><p>Route: $path</p></div>";
    }
}

// 4. ROUTES DEFINITION
$app = new Router();

// Public Pages
$app->add('GET', '/', [\Src\Controllers\HomeController::class, 'index']);
$app->add('GET', '/index.php', [\Src\Controllers\HomeController::class, 'index']);
$app->add('GET', '/news', [\Src\Controllers\NewsController::class, 'index']);
$app->add('GET', '/news/{id}', [\Src\Controllers\NewsController::class, 'view']); // Clean URL
$app->add('GET', '/gallery', [\Src\Controllers\GalleryController::class, 'index']);

// Apply Page & API
$app->add('GET', '/apply', function() { require VIEWS_DIR . '/apply_form.php'; });
$app->add('POST', '/api/apply', [\Src\Controllers\ApiController::class, 'handleApplication']);

// Admin Panel
$app->add('GET', '/admin-login', [\Src\Controllers\AdminController::class, 'loginPage']);
$app->add('POST', '/secret-login-api', [\Src\Controllers\AdminController::class, 'handleLogin']);
$app->add('GET', '/dashboard', [\Src\Controllers\AdminController::class, 'dashboard'], true);
$app->add('GET', '/logout', [\Src\Controllers\AdminController::class, 'logout'], true);

// Admin Actions
$app->add('POST', '/admin/events/add', [\Src\Controllers\AdminController::class, 'addEvent'], true);
$app->add('GET', '/admin/events/delete', [\Src\Controllers\AdminController::class, 'deleteEvent'], true);
$app->add('POST', '/admin/news/add', [\Src\Controllers\AdminController::class, 'addNews'], true);
$app->add('GET', '/admin/news/delete', [\Src\Controllers\AdminController::class, 'deleteNews'], true);
$app->add('POST', '/admin/gallery/add', [\Src\Controllers\AdminController::class, 'addGallery'], true);
$app->add('GET', '/admin/gallery/delete', [\Src\Controllers\AdminController::class, 'deleteGallery'], true);
$app->add('GET', '/admin/applications/get', [\Src\Controllers\AdminController::class, 'getApplication'], true);

// 5. RUN
try {
    $app->dispatch();
} catch (Throwable $e) {
    http_response_code(500);
    echo "System Error: " . $e->getMessage();
}