<?php
class User extends Model {
    
    protected $table = 'users';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Kullanıcı doğrulama
     */
    public function authenticateUser($username, $password) {
        try {
            $sql = "SELECT id, username, email, password, role, status FROM {$this->table} 
                    WHERE (username = :username OR email = :email) AND status = 'active'";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $username);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']); // Şifreyi döndürme
                return $user;
            }
            
            return false;
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı doğrulama hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı doğrulama hatası');
        }
    }
    
    /**
     * Kullanıcı var mı kontrol et
     */
    public function userExists($username, $email) {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE username = :username OR email = :email";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı kontrol hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı kontrol hatası');
        }
    }
    
    /**
     * Yeni kullanıcı oluştur
     */
    public function createUser($username, $email, $password) {
        try {
            // Şifreyi hash'le
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO {$this->table} (username, email, password, role, status, created_at) 
                    VALUES (:username, :email, :password, :role, :status, NOW())";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', 'user');
            $stmt->bindParam(':status', 'active');
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            
            return false;
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı oluşturma hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı oluşturma hatası');
        }
    }
    
    /**
     * Kullanıcı bilgilerini güncelle
     */
    public function updateUser($userId, $data) {
        try {
            $fields = [];
            $params = [':id' => $userId];
            
            foreach ($data as $key => $value) {
                if ($key !== 'id' && $key !== 'created_at') {
                    $fields[] = "{$key} = :{$key}";
                    $params[":{$key}"] = $value;
                }
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı güncelleme hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı güncelleme hatası');
        }
    }
    
    /**
     * Kullanıcı ID'ye göre getir
     */
    public function getUserById($userId) {
        try {
            $sql = "SELECT id, username, email, role, status, created_at FROM {$this->table} WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı getirme hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı getirme hatası');
        }
    }
    
    /**
     * Kullanıcı adına göre getir
     */
    public function getUserByUsername($username) {
        try {
            $sql = "SELECT id, username, email, role, status, created_at FROM {$this->table} WHERE username = :username";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı getirme hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı getirme hatası');
        }
    }
    
    /**
     * Tüm kullanıcıları getir (admin için)
     */
    public function getAllUsers($limit = 50, $offset = 0) {
        try {
            $sql = "SELECT id, username, email, role, status, created_at FROM {$this->table} 
                    ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı listesi getirme hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı listesi getirme hatası');
        }
    }
    
    /**
     * Kullanıcı sayısını getir
     */
    public function getUserCount() {
        try {
            $sql = "SELECT COUNT(*) FROM {$this->table}";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchColumn();
            
        } catch (PDOException $e) {
            $this->log('error', 'Kullanıcı sayısı getirme hatası: ' . $e->getMessage());
            throw new Exception('Kullanıcı sayısı getirme hatası');
        }
    }
}
