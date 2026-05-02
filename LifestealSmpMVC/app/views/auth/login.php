<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="text-primary mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                        </h2>
                        <p class="text-muted">Hesabınıza giriş yapın</p>
                    </div>
                    
                    <form method="POST" action="<?= $this->url('login') ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı veya E-posta</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="username" 
                                       name="username" 
                                       value="<?= htmlspecialchars($username ?? '') ?>"
                                       placeholder="Kullanıcı adınızı veya e-posta adresinizi girin"
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
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Beni hatırla
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-2">
                            <a href="<?= $this->url('forgot-password') ?>" class="text-decoration-none">
                                Şifrenizi mi unuttunuz?
                            </a>
                        </p>
                        <p class="mb-0">
                            Hesabınız yok mu? 
                            <a href="<?= $this->url('register') ?>" class="text-decoration-none fw-bold">
                                Kayıt olun
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Social Login -->
            <div class="card mt-4 border-0 bg-light">
                <div class="card-body text-center">
                    <p class="text-muted mb-3">Veya şununla giriş yapın:</p>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-dark">
                            <i class="fab fa-discord me-2"></i>Discord ile Giriş
                        </a>
                        <a href="#" class="btn btn-outline-danger">
                            <i class="fab fa-google me-2"></i>Google ile Giriş
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
    
    // Form validasyonu
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        
        if (!username || !password) {
            e.preventDefault();
            alert('Lütfen tüm alanları doldurun.');
            return false;
        }
    });
});
</script>
