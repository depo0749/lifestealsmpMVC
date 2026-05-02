<?php
// PHP yerleşik sunucu için yönlendirici
// İstek edilen dosya gerçekten mevcutsa, sunucuya bırak
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$publicPath = __DIR__ . '/public';

// Statik dosyalar (CSS/JS/IMG) için doğrudan servis
if ($uri !== '/' && file_exists($publicPath . $uri) && is_file($publicPath . $uri)) {
	return false; // dahili sunucu dosyayı servis etsin
}

// Tüm diğer istekleri front controller'a yönlendir
require_once $publicPath . '/index.php';
?>


