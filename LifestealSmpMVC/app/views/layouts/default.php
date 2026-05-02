<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? SITE_NAME ?></title>
    
    <!-- Meta Tags -->
    <meta name="description" content="<?= SITE_DESCRIPTION ?>">
    <meta name="keywords" content="minecraft, lifesteal, smp, sunucu, oyun, türkiye">
    <meta name="author" content="<?= SITE_NAME ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL ?>">
    <meta property="og:title" content="<?= $title ?? SITE_NAME ?>">
    <meta property="og:description" content="<?= SITE_DESCRIPTION ?>">
    <meta property="og:image" content="<?= $this->asset('images/og-image.jpg') ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= SITE_URL ?>">
    <meta property="twitter:title" content="<?= $title ?? SITE_NAME ?>">
    <meta property="twitter:description" content="<?= SITE_DESCRIPTION ?>">
    <meta property="twitter:image" content="<?= $this->asset('images/og-image.jpg') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= $this->asset('images/favicon.svg') ?>">
    <link rel="apple-touch-icon" href="<?= $this->asset('images/apple-touch-icon.png') ?>">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= $this->asset('manifest.json') ?>">
    <meta name="theme-color" content="#ff6b6b">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="<?= SITE_NAME ?>">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->asset('css/style.css') ?>">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #667eea;
            --accent-color: #764ba2;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #ff5252;
            border-color: #ff5252;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 100px 0;
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }
        
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            z-index: 10000;
            transition: width 0.1s ease;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Scroll Progress Bar -->
    <div class="scroll-progress"></div>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= $this->url() ?>">
                <i class="fas fa-heart me-2"></i><?= SITE_NAME ?>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link<?= $this->isActive('home') ?>" href="<?= $this->url() ?>">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $this->isActive('about') ?>" href="<?= $this->url('about') ?>">Hakkında</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $this->isActive('features') ?>" href="<?= $this->url('features') ?>">Özellikler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $this->isActive('rules') ?>" href="<?= $this->url('rules') ?>">Kurallar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $this->isActive('join') ?>" href="<?= $this->url('join') ?>">Katıl</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= $this->isActive('contact') ?>" href="<?= $this->url('contact') ?>">İletişim</a>
                    </li>
                </ul>
                
                <!-- Auth Buttons -->
                <div class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Logged In User -->
                        <div class="nav-item dropdown me-2">
                            <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($_SESSION['username']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= $this->url('profile') ?>">
                                    <i class="fas fa-user-circle me-2"></i>Profil
                                </a></li>
                                <li><a class="dropdown-item" href="<?= $this->url('dashboard') ?>">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= $this->url('logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                                </a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Guest User -->
                        <div class="nav-item dropdown me-2">
                            <a class="btn btn-outline-primary btn-sm" href="<?= $this->url('login') ?>" role="button">
                                <i class="fas fa-sign-in-alt me-1"></i>Giriş Yap
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="btn btn-primary btn-sm" href="<?= $this->url('register') ?>" role="button">
                                <i class="fas fa-user-plus me-1"></i>Kayıt Ol
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <!-- Flash Messages -->
        <?= $this->flashMessage() ?>
        
        <!-- Page Content -->
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-primary mb-3"><?= SITE_NAME ?></h5>
                    <p class="mb-3"><?= SITE_DESCRIPTION ?></p>
                    <div class="social-links">
                        <a href="<?= DISCORD_INVITE ?>" target="_blank" title="Discord">
                            <i class="fab fa-discord"></i>
                        </a>
                        <a href="#" target="_blank" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" target="_blank" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-primary mb-3">Hızlı Linkler</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= $this->url() ?>" class="text-light text-decoration-none">Ana Sayfa</a></li>
                        <li class="mb-2"><a href="<?= $this->url('about') ?>" class="text-light text-decoration-none">Hakkında</a></li>
                        <li class="mb-2"><a href="<?= $this->url('features') ?>" class="text-light text-decoration-none">Özellikler</a></li>
                        <li class="mb-2"><a href="<?= $this->url('rules') ?>" class="text-light text-decoration-none">Kurallar</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-primary mb-3">Sunucu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= $this->url('join') ?>" class="text-light text-decoration-none">Katıl</a></li>
                        <li class="mb-2"><a href="<?= DISCORD_INVITE ?>" target="_blank" class="text-light text-decoration-none">Discord</a></li>
                        <li class="mb-2"><a href="<?= $this->url('contact') ?>" class="text-light text-decoration-none">İletişim</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h6 class="text-primary mb-3">Sunucu Bilgileri</h6>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong>IP:</strong> <?= SERVER_IP ?></p>
                            <p class="mb-2"><strong>Versiyon:</strong> <?= SERVER_VERSION ?></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-2"><strong>Ülke:</strong> <?= SERVER_COUNTRY ?></p>
                            <p class="mb-2"><strong>Maksimum:</strong> <?= MAX_PLAYERS ?> oyuncu</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tüm hakları saklıdır.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">
                        <a href="<?= $this->url('privacy') ?>" class="text-light text-decoration-none me-3">Gizlilik</a>
                        <a href="<?= $this->url('terms') ?>" class="text-light text-decoration-none">Şartlar</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $this->asset('js/app.js') ?>"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Scroll Progress Bar
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.offsetHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            
            const progressBar = document.querySelector('.scroll-progress');
            if (progressBar) {
                progressBar.style.width = scrollPercent + '%';
            }
        });
        
        // Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Navbar Active State
        const currentPath = window.location.pathname;
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath || 
                (currentPath === '/' && link.getAttribute('href') === '<?= $this->url() ?>')) {
                link.classList.add('active');
            }
        });
        
        // Copy IP Function
        function copyIP() {
            const ip = '<?= SERVER_IP ?>';
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(ip).then(() => {
                    showNotification('IP adresi kopyalandı!', 'success');
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = ip;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    showNotification('IP adresi kopyalandı!', 'success');
                } catch (err) {
                    showNotification('Kopyalama başarısız!', 'error');
                }
                
                document.body.removeChild(textArea);
            }
        }
        
        // Notification System
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = `
                top: 100px;
                right: 20px;
                z-index: 10000;
                min-width: 300px;
            `;
            
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }
        
        // Discord Join Function
        function joinDiscord() {
            const discordLink = '<?= DISCORD_INVITE ?>';
            if (discordLink !== 'https://discord.gg/YOUR_DISCORD_INVITE') {
                window.open(discordLink, '_blank');
            } else {
                showNotification('Discord linki henüz eklenmedi!', 'warning');
            }
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button if needed
            const installBtn = document.querySelector('.install-btn');
            if (installBtn) {
                installBtn.style.display = 'block';
            }
        });
        
        function installApp() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    }
                    deferredPrompt = null;
                });
            }
        }
    </script>
</body>
</html>
