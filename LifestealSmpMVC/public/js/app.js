// LifestealSMP Ana JavaScript Dosyası

// DOM yüklendikten sonra çalışacak kodlar
document.addEventListener('DOMContentLoaded', function() {
    console.log('LifestealSMP yüklendi!');
    
    // Scroll progress bar'ı başlat
    initScrollProgress();
    
    // Smooth scrolling'i başlat
    initSmoothScrolling();
    
    // Navbar active state'i başlat
    initNavbarActiveState();
    
    // Animasyonları başlat
    initAnimations();
    
    // Form validasyonlarını başlat
    initFormValidation();
    
    // Server status check'i başlat
    initServerStatusCheck();
});

// Scroll Progress Bar
function initScrollProgress() {
    const progressBar = document.querySelector('.scroll-progress');
    if (!progressBar) return;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset;
        const docHeight = document.body.offsetHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        
        progressBar.style.width = scrollPercent + '%';
    });
}

// Smooth Scrolling
function initSmoothScrolling() {
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
}

// Navbar Active State
function initNavbarActiveState() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || 
            (currentPath === '/' && href === '/') ||
            (currentPath !== '/' && href !== '/' && currentPath.includes(href.replace('/', '')))) {
            link.classList.add('active');
        }
    });
}

// Animasyonlar
function initAnimations() {
    // Intersection Observer ile animasyonları tetikle
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);
    
    // Animasyon yapılacak elementleri gözlemle
    document.querySelectorAll('.stat-card, .feature-card, .card').forEach(el => {
        observer.observe(el);
    });
}

// Form Validasyonu
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

// Form doğrulama fonksiyonu
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showFieldError(input, 'Bu alan zorunludur');
            isValid = false;
        } else {
            clearFieldError(input);
        }
        
        // Email validasyonu
        if (input.type === 'email' && input.value) {
            if (!isValidEmail(input.value)) {
                showFieldError(input, 'Geçerli bir email adresi giriniz');
                isValid = false;
            }
        }
    });
    
    return isValid;
}

// Email validasyonu
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Field error gösterme
function showFieldError(input, message) {
    clearFieldError(input);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback d-block';
    errorDiv.textContent = message;
    
    input.classList.add('is-invalid');
    input.parentNode.appendChild(errorDiv);
}

// Field error temizleme
function clearFieldError(input) {
    input.classList.remove('is-invalid');
    const errorDiv = input.parentNode.querySelector('.invalid-feedback');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// Server Status Check
function initServerStatusCheck() {
    // Her 30 saniyede bir server status'ü kontrol et
    setInterval(checkServerStatus, 30000);
    
    // Sayfa yüklendiğinde ilk kontrolü yap
    checkServerStatus();
}

// Server status kontrolü
function checkServerStatus() {
    fetch('/api/server-status')
        .then(response => response.json())
        .then(data => {
            updateServerStatusDisplay(data);
        })
        .catch(error => {
            console.error('Server status check hatası:', error);
        });
}

// Server status display güncelleme
function updateServerStatusDisplay(status) {
    const statusElements = document.querySelectorAll('.server-status');
    
    statusElements.forEach(element => {
        // Status badge'ini güncelle
        const badge = element.querySelector('.badge');
        if (badge) {
            badge.className = `badge bg-${status.color}`;
            badge.innerHTML = `<i class="fas fa-circle me-1"></i>${status.message}`;
        }
        
        // Online player count'u güncelle
        const playerCount = element.querySelector('.player-count');
        if (playerCount && status.online_players !== undefined) {
            playerCount.textContent = status.online_players;
        }
    });
}

// Copy IP Function
function copyIP() {
    const ip = document.querySelector('[data-server-ip]')?.dataset.serverIp || 'play.lifestealsmp.com';
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(ip).then(() => {
            showNotification('IP adresi kopyalandı!', 'success');
        }).catch(() => {
            fallbackCopyIP(ip);
        });
    } else {
        fallbackCopyIP(ip);
    }
}

// Fallback copy IP (eski tarayıcılar için)
function fallbackCopyIP(ip) {
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

// Notification System
function showNotification(message, type = 'info') {
    // Mevcut notification'ları temizle
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => {
        notification.remove();
    });
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show custom-notification position-fixed`;
    notification.style.cssText = `
        top: 100px;
        right: 20px;
        z-index: 10000;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
    const discordLink = document.querySelector('[data-discord-invite]')?.dataset.discordInvite || 'https://discord.gg/YOUR_DISCORD_INVITE';
    
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
    
    // Install button'ı göster
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
                console.log('Kullanıcı PWA kurulumunu kabul etti');
                showNotification('Uygulama kuruldu!', 'success');
            }
            deferredPrompt = null;
        });
    }
}

// Loading Spinner
function showLoading(element) {
    const spinner = document.createElement('div');
    spinner.className = 'loading-spinner';
    element.appendChild(spinner);
}

function hideLoading(element) {
    const spinner = element.querySelector('.loading-spinner');
    if (spinner) {
        spinner.remove();
    }
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Export functions for global use
window.LifestealSMP = {
    copyIP,
    joinDiscord,
    installApp,
    showNotification,
    showLoading,
    hideLoading
};
