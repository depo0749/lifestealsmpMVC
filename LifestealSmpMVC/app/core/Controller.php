<?php
abstract class Controller {
    protected $db;
    protected $view;
    protected $model;
    
    public function __construct() {
        $this->db = new Database();
        $this->view = new View();
    }
    
    // Model yükleme
    protected function loadModel($modelName) {
        $modelPath = '../app/models/' . $modelName . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName($this->db);
        } else {
            throw new Exception("Model bulunamadı: {$modelName}");
        }
    }
    
    // View render etme
    protected function render($view, $data = []) {
        return $this->view->render($view, $data);
    }
    
    // JSON response
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Redirect
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }
    
    // CSRF token oluşturma
    protected function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    // CSRF token doğrulama
    protected function validateCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
    
    // Input temizleme
    protected function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    // POST verisi alma
    protected function getPostData() {
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $this->sanitizeInput($value);
        }
        return $data;
    }
    
    // GET verisi alma
    protected function getGetData() {
        $data = [];
        foreach ($_GET as $key => $value) {
            $data[$key] = $this->sanitizeInput($value);
        }
        return $data;
    }
    
    // File upload kontrolü
    protected function handleFileUpload($file, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'], $maxSize = 5242880) {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'message' => 'Geçersiz dosya parametresi'];
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Dosya yükleme hatası'];
        }
        
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'Dosya boyutu çok büyük'];
        }
        
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedTypes)) {
            return ['success' => false, 'message' => 'Geçersiz dosya türü'];
        }
        
        return ['success' => true, 'file' => $file];
    }
    
    // Session mesajı
    protected function setFlashMessage($type, $message) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    // Flash mesajı alma
    protected function getFlashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
    
    // Authentication kontrolü
    protected function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    
    // Admin kontrolü
    protected function requireAdmin() {
        $this->requireAuth();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect('/dashboard');
        }
    }
    
    // Rate limiting
    protected function checkRateLimit($action, $maxAttempts = 5, $timeWindow = 300) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "rate_limit_{$action}_{$ip}";
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['attempts' => 0, 'first_attempt' => time()];
        }
        
        $rateLimit = $_SESSION[$key];
        
        // Zaman penceresi geçmişse sıfırla
        if (time() - $rateLimit['first_attempt'] > $timeWindow) {
            $_SESSION[$key] = ['attempts' => 0, 'first_attempt' => time()];
            $rateLimit = $_SESSION[$key];
        }
        
        if ($rateLimit['attempts'] >= $maxAttempts) {
            return false;
        }
        
        $_SESSION[$key]['attempts']++;
        return true;
    }
    
    // Log tutma
    protected function log($action, $details = '') {
        $logData = [
            'action' => $action,
            'details' => $details,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'user_id' => $_SESSION['user_id'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Log dosyasına yaz
        $logFile = 'logs/app.log';
        $logDir = dirname($logFile);
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logEntry = date('Y-m-d H:i:s') . " - " . json_encode($logData, JSON_UNESCAPED_UNICODE) . PHP_EOL;
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}
?>
