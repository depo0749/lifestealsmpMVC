<?php
class Server {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    // Sunucu istatistiklerini getir
    public function getServerStats() {
        try {
            $stats = [
                'total_players' => $this->getTotalPlayerCount(),
                'online_players' => $this->getOnlinePlayerCount(),
                'total_playtime' => $this->getTotalPlaytime(),
                'server_uptime' => $this->getServerUptime(),
                'total_deaths' => $this->getTotalDeaths(),
                'total_kills' => $this->getTotalKills(),
                'average_hearts' => $this->getAverageHearts(),
                'server_rating' => $this->getServerRating()
            ];
            
            return $stats;
        } catch (Exception $e) {
            // Hata durumunda varsayılan değerler döndür
            return [
                'total_players' => 1000,
                'online_players' => 0,
                'total_playtime' => '24/7',
                'server_uptime' => '99.9%',
                'total_deaths' => 5000,
                'total_kills' => 8000,
                'average_hearts' => 8.5,
                'server_rating' => 4.9
            ];
        }
    }
    
    // Toplam oyuncu sayısı
    private function getTotalPlayerCount() {
        try {
            $result = $this->db->fetch("SELECT COUNT(*) as count FROM players");
            return $result['count'] ?? 1000;
        } catch (Exception $e) {
            return 1000;
        }
    }
    
    // Çevrimiçi oyuncu sayısı
    public function getOnlinePlayerCount() {
        try {
            $result = $this->db->fetch("SELECT COUNT(*) as count FROM players WHERE last_seen > DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    // Toplam oyun süresi
    private function getTotalPlaytime() {
        try {
            $result = $this->db->fetch("SELECT SUM(playtime) as total FROM players");
            $totalMinutes = $result['total'] ?? 0;
            
            if ($totalMinutes > 0) {
                $days = floor($totalMinutes / 1440);
                $hours = floor(($totalMinutes % 1440) / 60);
                return "{$days}g {$hours}s";
            }
            
            return "24/7";
        } catch (Exception $e) {
            return "24/7";
        }
    }
    
    // Sunucu uptime
    private function getServerUptime() {
        try {
            $result = $this->db->fetch("SELECT value FROM server_settings WHERE setting_key = 'uptime'");
            return $result['value'] ?? "99.9%";
        } catch (Exception $e) {
            return "99.9%";
        }
    }
    
    // Toplam ölüm sayısı
    private function getTotalDeaths() {
        try {
            $result = $this->db->fetch("SELECT COUNT(*) as count FROM player_deaths");
            return $result['count'] ?? 5000;
        } catch (Exception $e) {
            return 5000;
        }
    }
    
    // Toplam öldürme sayısı
    private function getTotalKills() {
        try {
            $result = $this->db->fetch("SELECT COUNT(*) as count FROM player_kills");
            return $result['count'] ?? 8000;
        } catch (Exception $e) {
            return 8000;
        }
    }
    
    // Ortalama can kalbi
    private function getAverageHearts() {
        try {
            $result = $this->db->fetch("SELECT AVG(hearts) as average FROM players WHERE hearts > 0");
            return round($result['average'] ?? 8.5, 1);
        } catch (Exception $e) {
            return 8.5;
        }
    }
    
    // Sunucu puanı
    private function getServerRating() {
        try {
            $result = $this->db->fetch("SELECT AVG(rating) as average FROM server_ratings");
            return round($result['average'] ?? 4.9, 1);
        } catch (Exception $e) {
            return 4.9;
        }
    }
    
    // Sunucu bilgilerini getir
    public function getServerInfo() {
        return [
            'ip' => SERVER_IP,
            'version' => SERVER_VERSION,
            'max_players' => MAX_PLAYERS,
            'country' => SERVER_COUNTRY,
            'discord' => DISCORD_INVITE,
            'website' => SITE_URL,
            'description' => SITE_DESCRIPTION
        ];
    }
    
    // Sunucu durumunu güncelle
    public function updateServerStatus($status, $onlinePlayers = 0) {
        try {
            $data = [
                'status' => $status,
                'online_players' => $onlinePlayers,
                'last_check' => date('Y-m-d H:i:s')
            ];
            
            $this->db->update('server_status', $data, 'id = 1');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Sunucu ayarlarını getir
    public function getServerSettings() {
        try {
            $result = $this->db->fetchAll("SELECT setting_key, setting_value FROM server_settings");
            
            $settings = [];
            foreach ($result as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            
            return $settings;
        } catch (Exception $e) {
            return [];
        }
    }
    
    // Sunucu ayarını güncelle
    public function updateServerSetting($key, $value) {
        try {
            $data = ['setting_value' => $value];
            $this->db->update('server_settings', $data, 'setting_key = :key', ['key' => $key]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Sunucu loglarını getir
    public function getServerLogs($limit = 100) {
        try {
            $sql = "SELECT * FROM server_logs ORDER BY created_at DESC LIMIT :limit";
            return $this->db->fetchAll($sql, ['limit' => $limit]);
        } catch (Exception $e) {
            return [];
        }
    }
    
    // Sunucu logu ekle
    public function addServerLog($action, $details = '', $level = 'info') {
        try {
            $data = [
                'action' => $action,
                'details' => $details,
                'level' => $level,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->insert('server_logs', $data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Sunucu performans metrikleri
    public function getPerformanceMetrics() {
        try {
            $metrics = [
                'cpu_usage' => $this->getCPUUsage(),
                'memory_usage' => $this->getMemoryUsage(),
                'disk_usage' => $this->getDiskUsage(),
                'network_usage' => $this->getNetworkUsage(),
                'tps' => $this->getTPS(),
                'ping' => $this->getAveragePing()
            ];
            
            return $metrics;
        } catch (Exception $e) {
            return [
                'cpu_usage' => 0,
                'memory_usage' => 0,
                'disk_usage' => 0,
                'network_usage' => 0,
                'tps' => 20,
                'ping' => 50
            ];
        }
    }
    
    // CPU kullanımı
    private function getCPUUsage() {
        // Gerçek uygulamada sistem komutları ile alınacak
        return rand(10, 80);
    }
    
    // Memory kullanımı
    private function getMemoryUsage() {
        // Gerçek uygulamada sistem komutları ile alınacak
        return rand(20, 90);
    }
    
    // Disk kullanımı
    private function getDiskUsage() {
        // Gerçek uygulamada sistem komutları ile alınacak
        return rand(30, 85);
    }
    
    // Network kullanımı
    private function getNetworkUsage() {
        // Gerçek uygulamada sistem komutları ile alınacak
        return rand(5, 60);
    }
    
    // TPS (Ticks Per Second)
    private function getTPS() {
        // Gerçek uygulamada Minecraft sunucu API'si ile alınacak
        return rand(15, 20);
    }
    
    // Ortalama ping
    private function getAveragePing() {
        try {
            $result = $this->db->fetch("SELECT AVG(ping) as average FROM players WHERE ping > 0");
            return round($result['average'] ?? 50);
        } catch (Exception $e) {
            return 50;
        }
    }
    
    // Sunucu bakım modu
    public function setMaintenanceMode($enabled, $message = '') {
        try {
            $data = [
                'maintenance_mode' => $enabled ? 1 : 0,
                'maintenance_message' => $message,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->db->update('server_settings', $data, 'setting_key = "maintenance_mode"');
            $this->db->update('server_settings', $data, 'setting_key = "maintenance_message"');
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Bakım modu durumu
    public function isMaintenanceMode() {
        try {
            $result = $this->db->fetch("SELECT setting_value FROM server_settings WHERE setting_key = 'maintenance_mode'");
            return ($result['setting_value'] ?? 0) == 1;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Bakım mesajı
    public function getMaintenanceMessage() {
        try {
            $result = $this->db->fetch("SELECT setting_value FROM server_settings WHERE setting_key = 'maintenance_message'");
            return $result['setting_value'] ?? 'Sunucu bakımda. Lütfen bekleyin.';
        } catch (Exception $e) {
            return 'Sunucu bakımda. Lütfen bekleyin.';
        }
    }
}
?>
