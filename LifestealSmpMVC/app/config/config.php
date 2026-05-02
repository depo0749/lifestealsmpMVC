<?php
// Veritabanı bağlantı bilgileri
define('DB_HOST', 'localhost');
define('DB_NAME', 'lifestealsmp');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site ayarları
define('SITE_NAME', 'LifestealSMP');
// Dinamik SITE_URL (geliştirme için uygun)
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
if (isset($_SERVER['SERVER_PORT']) && !in_array($_SERVER['SERVER_PORT'], ['80', '443']) && strpos($host, ':') === false) {
	$host .= ':' . $_SERVER['SERVER_PORT'];
}
define('SITE_URL', $scheme . '://' . $host);
define('SITE_DESCRIPTION', 'Hayatını kaybet, hayatını kazan! LifestealSMP Minecraft sunucusu.');

// Sunucu bilgileri
define('SERVER_IP', 'play.lifestealsmp.com');
define('SERVER_VERSION', '1.20.1');
define('MAX_PLAYERS', '100');
define('SERVER_COUNTRY', 'Türkiye');

// Discord bilgileri
define('DISCORD_INVITE', 'https://discord.gg/YOUR_DISCORD_INVITE');

// Mail ayarları
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'your-email@gmail.com');
define('MAIL_PASSWORD', 'your-app-password');

// Güvenlik
define('CSRF_TOKEN_SECRET', 'your-secret-key-here');
define('SESSION_SECRET', 'another-secret-key-here');

// Cache ayarları
define('CACHE_ENABLED', true);
define('CACHE_DURATION', 3600); // 1 saat

// Debug modu
define('DEBUG_MODE', true);

// Hata raporlama
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Zaman dilimi
date_default_timezone_set('Europe/Istanbul');

// Session başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

