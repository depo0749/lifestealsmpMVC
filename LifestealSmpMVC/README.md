# LifestealSMP MVC Projesi

Bu proje, Minecraft LifestealSMP sunucusu için geliştirilmiş modern bir web sitesidir. MVC (Model-View-Controller) mimarisi kullanılarak geliştirilmiştir.

## Özellikler

- 🎮 **Minecraft Sunucu Entegrasyonu** - Sunucu durumu, oyuncu sayısı, en iyi oyuncular
- 👥 **Kullanıcı Yönetimi** - Kayıt, giriş, profil yönetimi
- 📱 **Responsive Tasarım** - Mobil ve masaüstü uyumlu
- 🎨 **Modern UI/UX** - Bootstrap 5 ve özel CSS ile güzel tasarım
- 🔒 **Güvenlik** - Şifre hash'leme, session yönetimi
- 📊 **Admin Panel** - Sunucu yönetimi ve istatistikler

## Kurulum

### Gereksinimler

- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- Apache/Nginx web sunucusu
- Composer (opsiyonel)

### Adım 1: Projeyi İndirin

```bash
git clone https://github.com/username/lifestealsmp-mvc.git
cd lifestealsmp-mvc
```

### Adım 2: Veritabanını Kurun

1. MySQL'de yeni bir veritabanı oluşturun
2. `database/users.sql` dosyasını çalıştırın
3. `app/config/config.php` dosyasında veritabanı bilgilerini güncelleyin

### Adım 3: Web Sunucusunu Yapılandırın

#### Apache (.htaccess zaten mevcut)
```apache
DocumentRoot /path/to/lifestealsmp-mvc/public
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/lifestealsmp-mvc/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Adım 4: Yapılandırma

`app/config/config.php` dosyasında şu ayarları güncelleyin:

```php
// Site ayarları
define('SITE_NAME', 'LifestealSMP');
define('SITE_URL', 'http://yourdomain.com');
define('SITE_DESCRIPTION', 'Minecraft LifestealSMP Sunucusu');

// Sunucu ayarları
define('SERVER_IP', 'play.yourdomain.com');
define('SERVER_VERSION', '1.20.1');
define('MAX_PLAYERS', 100);
define('SERVER_COUNTRY', 'TR');

// Discord
define('DISCORD_INVITE', 'https://discord.gg/yourinvite');

// Veritabanı
define('DB_HOST', 'localhost');
define('DB_NAME', 'lifestealsmp');
define('DB_USER', 'username');
define('DB_PASS', 'password');
```

## Kullanım

### Varsayılan Kullanıcılar

Proje kurulumunda otomatik olarak oluşturulan kullanıcılar:

- **Admin**: `admin` / `admin123`
- **Test**: `testuser` / `test123`

### Yeni Kullanıcı Oluşturma

1. `/register` sayfasından kayıt olun
2. E-posta doğrulaması (opsiyonel)
3. Giriş yapın ve profilinizi düzenleyin

### Admin Paneli

- URL: `/admin`
- Kullanıcı yönetimi
- Sunucu ayarları
- İstatistikler

## Proje Yapısı

```
lifestealsmp-mvc/
├── app/
│   ├── controllers/     # Controller sınıfları
│   ├── models/         # Model sınıfları
│   ├── views/          # View dosyaları
│   ├── core/           # Çekirdek sınıflar
│   └── config/         # Yapılandırma dosyaları
├── public/             # Web kök dizini
│   ├── css/           # Stil dosyaları
│   ├── js/            # JavaScript dosyaları
│   ├── images/        # Resimler
│   └── index.php      # Ana giriş noktası
├── database/           # Veritabanı dosyaları
└── router.php         # Basit yönlendirici
```

## Geliştirme

### Yeni Controller Ekleme

```php
class NewController extends Controller {
    public function index() {
        $data = [
            'title' => 'Yeni Sayfa',
            'page' => 'new'
        ];
        
        return $this->render('new/index', $data);
    }
}
```

### Yeni Model Ekleme

```php
class NewModel extends Model {
    protected $table = 'new_table';
    
    public function getData() {
        // Veritabanı işlemleri
    }
}
```

### Yeni Route Ekleme

`public/index.php` dosyasında:

```php
$router->add('new', ['controller' => 'New', 'action' => 'index']);
```

## Güvenlik

- Şifreler `password_hash()` ile hash'lenir
- SQL injection koruması (PDO prepared statements)
- XSS koruması (`htmlspecialchars`)
- CSRF koruması (session tabanlı)
- Brute force koruması (login attempts)

## Katkıda Bulunma

1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit yapın (`git commit -m 'Add amazing feature'`)
4. Push yapın (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için `LICENSE` dosyasına bakın.

## Destek

- Discord: [Sunucuya Katılın](https://discord.gg/yourinvite)
- E-posta: support@yourdomain.com
- Issues: [GitHub Issues](https://github.com/username/lifestealsmp-mvc/issues)

## Teşekkürler

- Bootstrap 5 ekibi
- Font Awesome
- Minecraft topluluğu
- Tüm katkıda bulunanlara

---

**Not**: Bu proje eğitim amaçlı geliştirilmiştir. Production ortamında kullanmadan önce güvenlik testlerini yapın.
