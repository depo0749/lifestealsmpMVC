<?php
class HomeController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->loadModel('Server');
        $this->loadModel('Player');
        $this->loadModel('News');
    }
    
    public function index() {
        try {
            // Sunucu istatistikleri
            $serverStats = $this->model->getServerStats();
            
            // Son haberler
            $latestNews = $this->model->getLatestNews(3);
            
            // En iyi oyuncular
            $topPlayers = $this->model->getTopPlayers(5);
            
            // Sunucu durumu
            $serverStatus = $this->checkServerStatus();
            
            $data = [
                'title' => 'Ana Sayfa - ' . SITE_NAME,
                'serverStats' => $serverStats,
                'latestNews' => $latestNews,
                'topPlayers' => $topPlayers,
                'serverStatus' => $serverStatus,
                'page' => 'home'
            ];
            
            return $this->render('home/index', $data);
            
        } catch (Exception $e) {
            $this->log('error', 'Ana sayfa yüklenirken hata: ' . $e->getMessage());
            
            if (DEBUG_MODE) {
                throw $e;
            } else {
                $this->setFlashMessage('error', 'Sayfa yüklenirken bir hata oluştu.');
                return $this->render('errors/500');
            }
        }
    }
    
    public function about() {
        $data = [
            'title' => 'Hakkında - ' . SITE_NAME,
            'page' => 'about'
        ];
        
        return $this->render('home/about', $data);
    }
    
    public function features() {
        $data = [
            'title' => 'Özellikler - ' . SITE_NAME,
            'page' => 'features'
        ];
        
        return $this->render('home/features', $data);
    }
    
    public function rules() {
        $data = [
            'title' => 'Kurallar - ' . SITE_NAME,
            'page' => 'rules'
        ];
        
        return $this->render('home/rules', $data);
    }
    
    public function join() {
        $data = [
            'title' => 'Katıl - ' . SITE_NAME,
            'page' => 'join',
            'serverIP' => SERVER_IP,
            'serverVersion' => SERVER_VERSION,
            'maxPlayers' => MAX_PLAYERS,
            'serverCountry' => SERVER_COUNTRY,
            'discordInvite' => DISCORD_INVITE
        ];
        
        return $this->render('home/join', $data);
    }
    
    public function contact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleContactForm();
        }
        
        $data = [
            'title' => 'İletişim - ' . SITE_NAME,
            'page' => 'contact'
        ];
        
        return $this->render('home/contact', $data);
    }
    
    private function handleContactForm() {
        // Rate limiting kontrolü
        if (!$this->checkRateLimit('contact', 3, 3600)) {
            $this->setFlashMessage('error', 'Çok fazla deneme yaptınız. Lütfen 1 saat sonra tekrar deneyin.');
            return $this->redirect('/contact');
        }
        
        $postData = $this->getPostData();
        
        // CSRF token kontrolü
        if (!$this->validateCSRFToken($postData['csrf_token'] ?? '')) {
            $this->setFlashMessage('error', 'Güvenlik hatası. Lütfen sayfayı yenileyin.');
            return $this->redirect('/contact');
        }
        
        // Form validasyonu
        $errors = $this->validateContactForm($postData);
        
        if (!empty($errors)) {
            $data = [
                'title' => 'İletişim - ' . SITE_NAME,
                'page' => 'contact',
                'errors' => $errors,
                'oldData' => $postData
            ];
            
            return $this->render('home/contact', $data);
        }
        
        try {
            // İletişim mesajını kaydet
            $contactData = [
                'name' => $postData['name'],
                'email' => $postData['email'],
                'subject' => $postData['subject'],
                'message' => $postData['message'],
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->loadModel('Contact');
            $this->model->create($contactData);
            
            // Admin'e bildirim gönder
            $this->sendContactNotification($contactData);
            
            $this->setFlashMessage('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
            
            // Log tut
            $this->log('contact_form', 'İletişim formu gönderildi: ' . $postData['email']);
            
            return $this->redirect('/contact');
            
        } catch (Exception $e) {
            $this->log('error', 'İletişim formu hatası: ' . $e->getMessage());
            
            $this->setFlashMessage('error', 'Mesaj gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
            return $this->redirect('/contact');
        }
    }
    
    private function validateContactForm($data) {
        $errors = [];
        
        if (empty($data['name'])) {
            $errors['name'] = 'Ad alanı zorunludur.';
        } elseif (strlen($data['name']) < 2) {
            $errors['name'] = 'Ad en az 2 karakter olmalıdır.';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'E-posta alanı zorunludur.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Geçerli bir e-posta adresi giriniz.';
        }
        
        if (empty($data['subject'])) {
            $errors['subject'] = 'Konu alanı zorunludur.';
        } elseif (strlen($data['subject']) < 5) {
            $errors['subject'] = 'Konu en az 5 karakter olmalıdır.';
        }
        
        if (empty($data['message'])) {
            $errors['message'] = 'Mesaj alanı zorunludur.';
        } elseif (strlen($data['message']) < 10) {
            $errors['message'] = 'Mesaj en az 10 karakter olmalıdır.';
        }
        
        return $errors;
    }
    
    private function sendContactNotification($contactData) {
        // E-posta gönderme işlemi burada yapılacak
        // Şimdilik sadece log tutuyoruz
        $this->log('contact_notification', 'İletişim bildirimi: ' . json_encode($contactData));
    }
    
    private function checkServerStatus() {
        try {
            // Minecraft sunucu durumu kontrolü
            $host = SERVER_IP;
            $port = 25565; // Default Minecraft port
            
            $socket = @fsockopen($host, $port, $errno, $errstr, 5);
            
            if ($socket) {
                fclose($socket);
                return [
                    'status' => 'online',
                    'message' => 'Sunucu Çevrimiçi',
                    'color' => 'success'
                ];
            } else {
                return [
                    'status' => 'offline',
                    'message' => 'Sunucu Çevrimdışı',
                    'color' => 'danger'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => 'unknown',
                'message' => 'Durum Bilinmiyor',
                'color' => 'warning'
            ];
        }
    }
    
    // API endpoint'leri
    public function apiServerStatus() {
        try {
            $status = $this->checkServerStatus();
            $this->jsonResponse($status);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }
    
    public function apiPlayerCount() {
        try {
            $playerCount = $this->model->getOnlinePlayerCount();
            $this->jsonResponse(['count' => $playerCount]);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }
    
    public function apiTopPlayers() {
        try {
            $topPlayers = $this->model->getTopPlayers(10);
            $this->jsonResponse($topPlayers);
        } catch (Exception $e) {
            $this->jsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
?>
