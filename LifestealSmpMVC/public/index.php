<?php
// Hata raporlama
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        '../app/core/',
        '../app/controllers/',
        '../app/models/',
        '../app/helpers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Config dosyasını yükle
require_once '../app/config/config.php';

// Core sınıfları manuel yükle
require_once '../app/core/Database.php';
require_once '../app/core/View.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Router.php';

// Controller'ları manuel yükle
require_once '../app/controllers/HomeController.php';

// Router'ı başlat
$router = new Router();

// Route'ları tanımla
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('home', ['controller' => 'Home', 'action' => 'index']);
$router->add('about', ['controller' => 'Home', 'action' => 'about']);
$router->add('features', ['controller' => 'Home', 'action' => 'features']);
$router->add('rules', ['controller' => 'Home', 'action' => 'rules']);
$router->add('join', ['controller' => 'Home', 'action' => 'join']);
$router->add('contact', ['controller' => 'Home', 'action' => 'contact']);

// API route'ları
$router->add('api/server-status', ['controller' => 'Home', 'action' => 'apiServerStatus']);
$router->add('api/player-count', ['controller' => 'Home', 'action' => 'apiPlayerCount']);
$router->add('api/top-players', ['controller' => 'Home', 'action' => 'apiTopPlayers']);

// Admin route'ları
$router->add('admin', ['controller' => 'Admin', 'action' => 'index']);
$router->add('admin/dashboard', ['controller' => 'Admin', 'action' => 'dashboard']);
$router->add('admin/players', ['controller' => 'Admin', 'action' => 'players']);
$router->add('admin/settings', ['controller' => 'Admin', 'action' => 'settings']);

// Auth route'ları
$router->add('login', ['controller' => 'Auth', 'action' => 'login']);
$router->add('register', ['controller' => 'Auth', 'action' => 'register']);
$router->add('logout', ['controller' => 'Auth', 'action' => 'logout']);

// Player route'ları
$router->add('player/{id:\d+}', ['controller' => 'Player', 'action' => 'show']);
$router->add('leaderboard', ['controller' => 'Player', 'action' => 'leaderboard']);

// News route'ları
$router->add('news', ['controller' => 'News', 'action' => 'index']);
$router->add('news/{id:\d+}', ['controller' => 'News', 'action' => 'show']);

// 404 sayfası
$router->add('404', ['controller' => 'Error', 'action' => 'notFound']);

try {
    // URL'yi al
    $url = $_SERVER['REQUEST_URI'];
    
    // Base path'i kaldır
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    if ($basePath !== '/') {
        $url = str_replace($basePath, '', $url);
    }
    
    // Query string'i kaldır
    $url = strtok($url, '?');
    
    // Trailing slash'i kaldır
    $url = rtrim($url, '/');
    
    // Boş URL için ana sayfa
    if (empty($url)) {
        $url = '';
    }
    
    // Route'u dispatch et
    $router->dispatch($url);
    
} catch (Exception $e) {
    // Hata logla
    error_log('Router Error: ' . $e->getMessage());
    
    // 404 sayfasını göster
    if ($e->getCode() === 404) {
        http_response_code(404);
        if (class_exists('ErrorController')) {
            $errorController = new ErrorController();
            $errorController->notFound();
        } else {
            echo '<h1>404 - Sayfa Bulunamadı</h1>';
            echo '<p>Aradığınız sayfa bulunamadı.</p>';
            echo '<a href="/">Ana Sayfaya Dön</a>';
        }
    } else {
        // Genel hata
        http_response_code(500);
        if (DEBUG_MODE) {
            echo '<h1>Hata</h1>';
            echo '<p>' . $e->getMessage() . '</p>';
            echo '<pre>' . $e->getTraceAsString() . '</pre>';
        } else {
            echo '<h1>Sunucu Hatası</h1>';
            echo '<p>Bir hata oluştu. Lütfen daha sonra tekrar deneyin.</p>';
        }
    }
}
?>
