<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="text-primary mb-3">
                            <i class="fas fa-user-plus me-2"></i>Kayıt Ol
                        </h2>
                        <p class="text-muted">Yeni hesap oluşturun</p>
                    </div>
                    
                    <form method="POST" action="<?= $this->url('register') ?>" id="registerForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="username" 
                                       name="username" 
                                       value="<?= htmlspecialchars($username ?? '') ?>"
                                       placeholder="Kullanıcı adınızı girin"
                                       minlength="3"
                                       required>
                            </div>
                            <div class="form-text">En az 3 karakter olmalıdır.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="<?= htmlspecialchars($email ?? '') ?>"
                                       placeholder="E-posta adresinizi girin"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Şifrenizi girin"
                                       minlength="6"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">En az 6 karakter olmalıdır.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Şifre Tekrar</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       placeholder="Şifrenizi tekrar girin"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                <a href="<?= $this->url('terms') ?>" target="_blank" class="text-decoration-none">Kullanım şartlarını</a> 
                                ve 
                                <a href="<?= $this->url('privacy') ?>" target="_blank" class="text-decoration-none">gizlilik politikasını</a> 
                                kabul ediyorum
                            </label>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter">
                            <label class="form-check-label" for="newsletter">
                                E-posta ile güncellemeler almak istiyorum
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Hesap Oluştur
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">
                            Zaten hesabınız var mı? 
                            <a href="<?= $this->url('login') ?>" class="text-decoration-none fw-bold">
                                Giriş yapın
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Social Register -->
            <div class="card mt-4 border-0 bg-light">
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Veya şununla kayıt olun:</p>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-dark">
                            <i class="fab fa-discord me-2"></i>Discord ile Kayıt
                        </a>
                        <a href="#" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Google ile Kayıt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Şifre göster/gizle
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
    
    // Şifre eşleşme kontrolü
    const passwordConfirm = document.getElementById('password_confirm');
    const form = document.getElementById('registerForm');
    
    function validatePassword() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.setCustomValidity('Şifreler eşleşmiyor');
        } else {
            passwordConfirm.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    passwordConfirm.addEventListener('keyup', validatePassword);
    
    // Form validasyonu
    form.addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;
        const terms = document.getElementById('terms').checked;
        
        if (!username || !email || !password || !passwordConfirm || !terms) {
            e.preventDefault();
            alert('Lütfen tüm gerekli alanları doldurun ve şartları kabul edin.');
            return false;
        }
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('Şifreler eşleşmiyor.');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Şifre en az 6 karakter olmalıdır.');
            return false;
        }
        
        if (username.length < 3) {
            e.preventDefault();
            alert('Kullanıcı adı en az 3 karakter olmalıdır.');
            return false;
        }
    });
    
    // Kullanıcı adı kontrolü
    const usernameInput = document.getElementById('username');
    usernameInput.addEventListener('blur', function() {
        const username = this.value.trim();
        if (username.length > 0 && username.length < 3) {
            this.setCustomValidity('Kullanıcı adı en az 3 karakter olmalıdır');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
