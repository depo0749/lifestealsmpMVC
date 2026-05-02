<?php
class AuthController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->loadModel('User');
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleLogin();
        }
        
        $data = [
            'title' => 'Giriş Yap - ' . SITE_NAME,
            'page' => 'login'
        ];
        
        return $this->render('auth/login', $data);
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleRegister();
        }
        
        $data = [
            'title' => 'Kayıt Ol - ' . SITE_NAME,
            'page' => 'register'
        ];
        
        return $this->render('auth/register', $data);
    }
    
    public function logout() {
        // Oturum temizleme
        session_destroy();
        $this->setFlashMessage('success', 'Başarıyla çıkış yapıldı.');
        $this->redirect('/');
    }
    
    private function handleLogin() {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validasyon
        if (empty($username) || empty($password)) {
            $this->setFlashMessage('error', 'Kullanıcı adı ve şifre gereklidir.');
            return $this->render('auth/login', [
                'title' => 'Giriş Yap - ' . SITE_NAME,
                'page' => 'login',
                'username' => $username
            ]);
        }
        
        try {
            // Kullanıcı doğrulama
            $user = $this->model->authenticateUser($username, $password);
            
            if ($user) {
                // Oturum başlat
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                $this->setFlashMessage('success', 'Başarıyla giriş yapıldı!');
                $this->redirect('/');
            } else {
                $this->setFlashMessage('error', 'Kullanıcı adı veya şifre hatalı.');
                return $this->render('auth/login', [
                    'title' => 'Giriş Yap - ' . SITE_NAME,
                    'page' => 'login',
                    'username' => $username
                ]);
            }
            
        } catch (Exception $e) {
            $this->log('error', 'Giriş yapılırken hata: ' . $e->getMessage());
            $this->setFlashMessage('error', 'Giriş yapılırken bir hata oluştu.');
            
            return $this->render('auth/login', [
                'title' => 'Giriş Yap - ' . SITE_NAME,
                'page' => 'login',
                'username' => $username
            ]);
        }
    }
    
    private function handleRegister() {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        // Validasyon
        $errors = [];
        
        if (empty($username)) {
            $errors[] = 'Kullanıcı adı gereklidir.';
        } elseif (strlen($username) < 3) {
            $errors[] = 'Kullanıcı adı en az 3 karakter olmalıdır.';
        }
        
        if (empty($email)) {
            $errors[] = 'E-posta adresi gereklidir.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Geçerli bir e-posta adresi giriniz.';
        }
        
        if (empty($password)) {
            $errors[] = 'Şifre gereklidir.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Şifre en az 6 karakter olmalıdır.';
        }
        
        if ($password !== $passwordConfirm) {
            $errors[] = 'Şifreler eşleşmiyor.';
        }
        
        if (!empty($errors)) {
            $this->setFlashMessage('error', implode('<br>', $errors));
            return $this->render('auth/register', [
                'title' => 'Kayıt Ol - ' . SITE_NAME,
                'page' => 'register',
                'username' => $username,
                'email' => $email
            ]);
        }
        
        try {
            // Kullanıcı adı ve e-posta kontrolü
            if ($this->model->userExists($username, $email)) {
                $this->setFlashMessage('error', 'Bu kullanıcı adı veya e-posta adresi zaten kullanılıyor.');
                return $this->render('auth/register', [
                    'title' => 'Kayıt Ol - ' . SITE_NAME,
                    'page' => 'register',
                    'username' => $username,
                    'email' => $email
                ]);
            }
            
            // Yeni kullanıcı oluştur
            $userId = $this->model->createUser($username, $email, $password);
            
            if ($userId) {
                $this->setFlashMessage('success', 'Hesabınız başarıyla oluşturuldu! Şimdi giriş yapabilirsiniz.');
                $this->redirect('/login');
            } else {
                $this->setFlashMessage('error', 'Hesap oluşturulurken bir hata oluştu.');
                return $this->render('auth/register', [
                    'title' => 'Kayıt Ol - ' . SITE_NAME,
                    'page' => 'register',
                    'username' => $username,
                    'email' => $email
                ]);
            }
            
        } catch (Exception $e) {
            $this->log('error', 'Kayıt olurken hata: ' . $e->getMessage());
            $this->setFlashMessage('error', 'Kayıt olurken bir hata oluştu.');
            
            return $this->render('auth/register', [
                'title' => 'Kayıt Ol - ' . SITE_NAME,
                'page' => 'register',
                'username' => $username,
                'email' => $email
            ]);
        }
    }
}
