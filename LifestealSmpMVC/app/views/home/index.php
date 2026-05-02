<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4"><?= SITE_NAME ?></h1>
                <p class="lead mb-4">Hayatını kaybet, hayatını kazan! Minecraft'ın en heyecan verici sunucusu.</p>
                
                <!-- Server Status -->
                <div class="d-flex align-items-center mb-4">
                    <div class="badge bg-<?= $serverStatus['color'] ?> me-3 p-2">
                        <i class="fas fa-circle me-1"></i>
                        <?= $serverStatus['message'] ?>
                    </div>
                    <span class="text-light"><?= $serverStats['online_players'] ?? 0 ?> oyuncu çevrimiçi</span>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-3">
                    <button class="btn btn-primary btn-lg" onclick="copyIP()">
                        <i class="fas fa-copy me-2"></i>
                        IP: <?= SERVER_IP ?>
                    </button>
                    <button class="btn btn-outline-light btn-lg" onclick="joinDiscord()">
                        <i class="fab fa-discord me-2"></i>
                        Discord'a Katıl
                    </button>
                </div>
            </div>
            
            <div class="col-lg-6 text-center">
                <div class="minecraft-character">
                    <i class="fas fa-heart fa-5x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Server Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-primary">Sunucu İstatistikleri</h2>
                <p class="lead">LifestealSMP'nin güçlü rakamları</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="display-6 fw-bold text-primary"><?= $serverStats['total_players'] ?? 1000 ?>+</h3>
                    <p class="text-muted">Kayıtlı Oyuncu</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="display-6 fw-bold text-primary"><?= $serverStats['total_playtime'] ?? '24/7' ?></h3>
                    <p class="text-muted">Toplam Oyun Süresi</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="display-6 fw-bold text-primary"><?= $serverStats['average_hearts'] ?? 8.5 ?></h3>
                    <p class="text-muted">Ortalama Can Kalbi</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="display-6 fw-bold text-primary"><?= $serverStats['server_rating'] ?? 4.9 ?>/5</h3>
                    <p class="text-muted">Oyuncu Puanı</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-primary">Sunucu Özellikleri</h2>
                <p class="lead">LifestealSMP'de neler var?</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="card-title">Lifesteal Sistemi</h4>
                        <p class="card-text">Her ölümde can kalbinizi kaybedin, öldürdüğünüzde can kalbi kazanın!</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="card-title">Koruma Sistemi</h4>
                        <p class="card-text">Evinizi ve eşyalarınızı koruyun, rakiplerinizden güvende olun.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h4 class="card-title">Liderlik Tablosu</h4>
                        <p class="card-text">En çok can kalbi olan oyuncuları görün ve rekabet edin.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-gem"></i>
                        </div>
                        <h4 class="card-title">Özel Eşyalar</h4>
                        <p class="card-text">Sunucuya özel eşyalar ve yetenekler kazanın.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="card-title">Klan Sistemi</h4>
                        <p class="card-text">Arkadaşlarınızla klan kurun ve birlikte savaşın.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon mb-3">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h4 class="card-title">Özelleştirme</h4>
                        <p class="card-text">Karakterinizi ve eşyalarınızı özelleştirin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News Section -->
<?php if (!empty($latestNews)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-primary">Son Haberler</h2>
                <p class="lead">Sunucudan güncel bilgiler</p>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($latestNews as $news): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <?php if (!empty($news['image'])): ?>
                    <img src="<?= $this->asset('images/news/' . $news['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($news['title']) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($news['title']) ?></h5>
                        <p class="card-text"><?= $this->truncate($news['content'], 100) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><?= $this->formatDate($news['created_at']) ?></small>
                            <a href="<?= $this->url('news/' . $news['id']) ?>" class="btn btn-sm btn-primary">Devamını Oku</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= $this->url('news') ?>" class="btn btn-outline-primary btn-lg">Tüm Haberleri Gör</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Top Players Section -->
<?php if (!empty($topPlayers)): ?>
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-primary">En İyi Oyuncular</h2>
                <p class="lead">Liderlik tablosunda kimler var?</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Oyuncu</th>
                                <th>Can Kalbi</th>
                                <th>Seviye</th>
                                <th>Oyun Süresi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topPlayers as $index => $player): ?>
                            <tr>
                                <td>
                                    <?php if ($index === 0): ?>
                                        <i class="fas fa-trophy text-warning"></i>
                                    <?php elseif ($index === 1): ?>
                                        <i class="fas fa-medal text-secondary"></i>
                                    <?php elseif ($index === 2): ?>
                                        <i class="fas fa-award text-bronze"></i>
                                    <?php else: ?>
                                        <?= $index + 1 ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $this->asset('images/avatars/' . ($player['avatar'] ?? 'default.png')) ?>" 
                                             class="rounded-circle me-2" width="32" height="32" 
                                             alt="<?= htmlspecialchars($player['username']) ?>">
                                        <?= htmlspecialchars($player['username']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-heart me-1"></i>
                                        <?= $player['hearts'] ?? 0 ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?= $player['level'] ?? 1 ?></span>
                                </td>
                                <td><?= $this->formatNumber($player['playtime'] ?? 0) ?> saat</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= $this->url('leaderboard') ?>" class="btn btn-outline-primary btn-lg">Tam Liderlik Tablosu</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Hemen Katılmaya Hazır mısın?</h2>
        <p class="lead mb-4">LifestealSMP'de hayatını kaybet, hayatını kazan!</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <button class="btn btn-light btn-lg" onclick="copyIP()">
                <i class="fas fa-copy me-2"></i>
                IP'yi Kopyala
            </button>
            <a href="<?= $this->url('join') ?>" class="btn btn-outline-light btn-lg">
                <i class="fas fa-play me-2"></i>
                Nasıl Katılırım?
            </a>
            <button class="btn btn-outline-light btn-lg" onclick="joinDiscord()">
                <i class="fab fa-discord me-2"></i>
                Discord Topluluğu
            </button>
        </div>
    </div>
</section>

<style>
.minecraft-character {
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.2);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-section .container {
    position: relative;
    z-index: 2;
}

@media (max-width: 768px) {
    .minecraft-character {
        width: 150px;
        height: 150px;
    }
    
    .hero-section {
        padding: 60px 0;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
    
    .display-5 {
        font-size: 2rem;
    }
}
</style>
