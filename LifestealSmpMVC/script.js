// DOM yüklendikten sonra çalışacak kodlar
document.addEventListener('DOMContentLoaded', function() {
    // Mobil menü toggle
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
        
        // Menü linklerine tıklandığında mobil menüyü kapat
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }
    
    // Navbar scroll efekti
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.style.background = 'rgba(0, 0, 0, 0.95)';
        } else {
            navbar.style.background = 'rgba(0, 0, 0, 0.9)';
        }
    });
    
    // Smooth scroll için tüm anchor linkler
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
    
    // Animasyonlu sayaçlar
    const stats = document.querySelectorAll('.stat-item h3');
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalValue = target.textContent;
                const isPercentage = finalValue.includes('%');
                const isPlus = finalValue.includes('+');
                const isSlash = finalValue.includes('/');
                
                let numericValue = finalValue.replace(/[^0-9.]/g, '');
                let startValue = 0;
                
                if (isSlash) {
                    // 24/7 formatı için
                    target.textContent = finalValue;
                    return;
                }
                
                const duration = 2000;
                const increment = numericValue / (duration / 16);
                
                const timer = setInterval(() => {
                    startValue += increment;
                    if (startValue >= numericValue) {
                        startValue = numericValue;
                        clearInterval(timer);
                    }
                    
                    let displayValue = Math.floor(startValue);
                    if (isPercentage) displayValue += '%';
                    if (isPlus) displayValue += '+';
                    
                    target.textContent = displayValue;
                }, 16);
                
                observer.unobserve(target);
            }
        });
    }, observerOptions);
    
    stats.forEach(stat => {
        observer.observe(stat);
    });
    
    // Feature kartları için hover efekti
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Rule kartları için hover efekti
    const ruleCards = document.querySelectorAll('.rule-card');
    ruleCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Stat kartları için hover efekti
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.05)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Sayfa yüklendiğinde fade-in efekti
    const sections = document.querySelectorAll('section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Server status animasyonu
    const statusIndicator = document.querySelector('.status-indicator');
    if (statusIndicator) {
        setInterval(() => {
            statusIndicator.style.transform = 'scale(1.2)';
            setTimeout(() => {
                statusIndicator.style.transform = 'scale(1)';
            }, 200);
        }, 3000);
    }
    
    // Minecraft karakter animasyonu
    const minecraftChar = document.querySelector('.minecraft-character');
    if (minecraftChar) {
        minecraftChar.addEventListener('click', function() {
            this.style.transform = 'rotate(360deg) scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'rotate(0deg) scale(1)';
            }, 600);
        });
    }
});

// IP kopyalama fonksiyonu
function copyIP() {
    const ip = 'play.lifestealsmp.com';
    
    // Modern tarayıcılar için Clipboard API
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(ip).then(() => {
            showNotification('IP adresi kopyalandı!', 'success');
        }).catch(() => {
            fallbackCopy(ip);
        });
    } else {
        fallbackCopy(ip);
    }
}

// Fallback kopyalama yöntemi
function fallbackCopy(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
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

// Discord'a katılma fonksiyonu
function joinDiscord() {
    // Discord sunucu linkini buraya ekleyin
    const discordLink = 'https://discord.gg/YOUR_DISCORD_INVITE';
    
    // Eğer Discord linki varsa yönlendir, yoksa uyarı göster
    if (discordLink !== 'https://discord.gg/YOUR_DISCORD_INVITE') {
        window.open(discordLink, '_blank');
    } else {
        showNotification('Discord linki henüz eklenmedi!', 'warning');
    }
}

// Bildirim gösterme fonksiyonu
function showNotification(message, type = 'info') {
    // Mevcut bildirimleri temizle
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => {
        notification.remove();
    });
    
    // Yeni bildirim oluştur
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Bildirim stilleri
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : type === 'warning' ? '#ff9800' : '#2196F3'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 300px;
    `;
    
    // Bildirim içeriği stilleri
    const content = notification.querySelector('.notification-content');
    content.style.cssText = `
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    `;
    
    // Kapatma butonu stilleri
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.style.cssText = `
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    `;
    
    // Bildirimi sayfaya ekle
    document.body.appendChild(notification);
    
    // Animasyon ile göster
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Kapatma butonu işlevi
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    });
    
    // Otomatik kapatma
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }
    }, 5000);
}

// Sayfa scroll progress bar'ı
window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset;
    const docHeight = document.body.offsetHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    
    // Progress bar oluştur veya güncelle
    let progressBar = document.querySelector('.scroll-progress');
    if (!progressBar) {
        progressBar = document.createElement('div');
        progressBar.className = 'scroll-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b, #667eea);
            z-index: 10001;
            transition: width 0.1s ease;
        `;
        document.body.appendChild(progressBar);
    }
    
    progressBar.style.width = scrollPercent + '%';
});

// Sayfa yüklendiğinde loading animasyonu
window.addEventListener('load', function() {
    const loader = document.querySelector('.page-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.remove();
        }, 500);
    }
});

// Konsole mesajı
console.log('%c🎮 LifestealSMP Websitesi', 'color: #ff6b6b; font-size: 20px; font-weight: bold;');
console.log('%cHayatını kaybet, hayatını kazan!', 'color: #667eea; font-size: 14px;');
console.log('%cIP: play.lifestealsmp.com', 'color: #4CAF50; font-size: 12px;');

// PWA Service Worker Kaydı
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker kaydı başarılı:', registration.scope);
            })
            .catch(function(error) {
                console.log('ServiceWorker kaydı başarısız:', error);
            });
    });
}

// PWA Install Prompt
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    
    // Install butonu göster
    showInstallButton();
});

function showInstallButton() {
    const installBtn = document.createElement('button');
    installBtn.className = 'btn btn-primary install-btn';
    installBtn.innerHTML = '<i class="fas fa-download"></i> Uygulamayı Yükle';
    installBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        background: #ff6b6b;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 25px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
        transition: all 0.3s ease;
    `;
    
    installBtn.addEventListener('click', installApp);
    document.body.appendChild(installBtn);
    
    // 10 saniye sonra otomatik gizle
    setTimeout(() => {
        if (installBtn.parentNode) {
            installBtn.remove();
        }
    }, 10000);
}

function installApp() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('Kullanıcı uygulamayı yükledi');
            }
            deferredPrompt = null;
        });
    }
}

// Offline/Online durumu
window.addEventListener('online', function() {
    showNotification('İnternet bağlantısı geri geldi!', 'success');
    document.querySelector('.status-indicator').classList.add('online');
    document.querySelector('.status-indicator').classList.remove('offline');
});

window.addEventListener('offline', function() {
    showNotification('İnternet bağlantısı kesildi!', 'warning');
    document.querySelector('.status-indicator').classList.add('offline');
    document.querySelector('.status-indicator').classList.remove('online');
});

// CSS'e offline durumu için stil ekle
const style = document.createElement('style');
style.textContent = `
    .status-indicator.offline {
        background: #f44336 !important;
        animation: none;
    }
    
    .install-btn:hover {
        background: #ff5252;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 107, 107, 0.5);
    }
`;
document.head.appendChild(style);
