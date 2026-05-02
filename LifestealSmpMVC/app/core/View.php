<?php
class View {
    private $layout = 'default';
    private $viewPath = 'app/views/';
    
    public function render($view, $data = []) {
        // Data'yı extract et
        extract($data);
        
        // View dosyasını yükle
        $viewFile = $this->viewPath . $view . '.php';
        
        if (!file_exists($viewFile)) {
            throw new Exception("View dosyası bulunamadı: {$view}");
        }
        
        // Output buffer başlat
        ob_start();
        
        // View dosyasını include et
        include $viewFile;
        
        // View içeriğini al
        $content = ob_get_clean();
        
        // Layout'u render et
        return $this->renderLayout($content, $data);
    }
    
    private function renderLayout($content, $data = []) {
        $layoutFile = $this->viewPath . 'layouts/' . $this->layout . '.php';
        
        if (!file_exists($layoutFile)) {
            // Layout yoksa sadece content'i döndür
            return $content;
        }
        
        // Data'yı extract et
        extract($data);
        
        // Output buffer başlat
        ob_start();
        
        // Layout dosyasını include et
        include $layoutFile;
        
        // Layout'u döndür
        return ob_get_clean();
    }
    
    // Layout değiştirme
    public function setLayout($layout) {
        $this->layout = $layout;
    }
    
    // Partial view render etme
    public function partial($view, $data = []) {
        $viewFile = $this->viewPath . 'partials/' . $view . '.php';
        
        if (!file_exists($viewFile)) {
            throw new Exception("Partial view bulunamadı: {$view}");
        }
        
        // Data'yı extract et
        extract($data);
        
        // Output buffer başlat
        ob_start();
        
        // Partial view'ı include et
        include $viewFile;
        
        // Partial view içeriğini döndür
        return ob_get_clean();
    }
    
    // Asset URL oluşturma
    public function asset($path) {
        return SITE_URL . '/public/' . ltrim($path, '/');
    }
    
    // URL oluşturma
    public function url($path = '') {
        return SITE_URL . '/' . ltrim($path, '/');
    }
    
    // CSRF token input
    public function csrfToken() {
        return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    }
    
    // Flash message gösterme
    public function flashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            
            $type = $message['type'];
            $text = $message['message'];
            
            $html = '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">';
            $html .= $text;
            $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            $html .= '</div>';
            
            return $html;
        }
        return '';
    }
    
    // Pagination
    public function pagination($currentPage, $totalPages, $urlPattern = '?page={page}') {
        if ($totalPages <= 1) {
            return '';
        }
        
        $html = '<nav aria-label="Sayfalama">';
        $html .= '<ul class="pagination justify-content-center">';
        
        // Önceki sayfa
        if ($currentPage > 1) {
            $prevUrl = str_replace('{page}', $currentPage - 1, $urlPattern);
            $html .= '<li class="page-item"><a class="page-link" href="' . $prevUrl . '">Önceki</a></li>';
        }
        
        // Sayfa numaraları
        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);
        
        for ($i = $start; $i <= $end; $i++) {
            $active = ($i == $currentPage) ? ' active' : '';
            $url = str_replace('{page}', $i, $urlPattern);
            $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
        }
        
        // Sonraki sayfa
        if ($currentPage < $totalPages) {
            $nextUrl = str_replace('{page}', $currentPage + 1, $urlPattern);
            $html .= '<li class="page-item"><a class="page-link" href="' . $nextUrl . '">Sonraki</a></li>';
        }
        
        $html .= '</ul>';
        $html .= '</nav>';
        
        return $html;
    }
    
    // Form validation error
    public function validationError($field, $errors) {
        if (isset($errors[$field])) {
            return '<div class="invalid-feedback d-block">' . $errors[$field] . '</div>';
        }
        return '';
    }
    
    // Old input value
    public function old($field, $default = '') {
        return $_POST[$field] ?? $default;
    }
    
    // Checked attribute
    public function checked($field, $value, $default = false) {
        $oldValue = $_POST[$field] ?? null;
        if ($oldValue !== null) {
            return ($oldValue == $value) ? ' checked' : '';
        }
        return $default ? ' checked' : '';
    }
    
    // Selected attribute
    public function selected($field, $value, $default = false) {
        $oldValue = $_POST[$field] ?? null;
        if ($oldValue !== null) {
            return ($oldValue == $value) ? ' selected' : '';
        }
        return $default ? ' selected' : '';
    }
    
    // Date format
    public function formatDate($date, $format = 'd.m.Y H:i') {
        if (is_string($date)) {
            $date = new DateTime($date);
        }
        return $date->format($format);
    }
    
    // Number format
    public function formatNumber($number, $decimals = 0) {
        return number_format($number, $decimals, ',', '.');
    }
    
    // Truncate text
    public function truncate($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }
    
    // Active menu item
    public function isActive($path) {
        $currentPath = $_SERVER['REQUEST_URI'];
        return (strpos($currentPath, $path) !== false) ? ' active' : '';
    }
}
?>
