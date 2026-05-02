<!-- Contact Page -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">İletişim</h1>
                <p class="lead">Bizimle iletişime geçin</p>
            </div>
        </div>
        
        <div class="row">
            <!-- İletişim Bilgileri -->
            <div class="col-lg-4 mb-5">
                <div class="card h-100 border-primary">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-info-circle me-2"></i>İletişim Bilgileri</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5><i class="fas fa-server text-primary me-2"></i>Sunucu Bilgileri</h5>
                            <p class="mb-2"><strong>IP:</strong> <?= $serverIP ?></p>
                            <p class="mb-2"><strong>Versiyon:</strong> <?= $serverVersion ?></p>
                            <p class="mb-2"><strong>Ülke:</strong> <?= $serverCountry ?></p>
                        </div>
                        
                        <div class="mb-4">
                            <h5><i class="fab fa-discord text-primary me-2"></i>Discord</h5>
                            <p class="mb-2">Ana iletişim kanalımız Discord sunucumuzdur.</p>
                            <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-primary">
                                <i class="fab fa-discord me-2"></i>Discord'a Katıl
                            </a>
                        </div>
                        
                        <div class="mb-4">
                            <h5><i class="fas fa-clock text-primary me-2"></i>Çalışma Saatleri</h5>
                            <p class="mb-2"><strong>Sunucu:</strong> 7/24 Aktif</p>
                            <p class="mb-2"><strong>Destek:</strong> 09:00 - 23:00 (TR)</p>
                        </div>
                        
                        <div>
                            <h5><i class="fas fa-users text-primary me-2"></i>Topluluk</h5>
                            <p class="mb-2">Binlerce aktif üye ile sürekli iletişim halindeyiz.</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-success">Aktif</span>
                                <span class="badge bg-info">Dostane</span>
                                <span class="badge bg-warning">Yardımsever</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- İletişim Formu -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0"><i class="fas fa-envelope me-2"></i>Mesaj Gönder</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= $this->url('contact') ?>" data-validate>
                            <?= $this->csrfToken() ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Ad Soyad *</label>
                                    <input type="text" class="form-control" id="name" name="name" required 
                                           value="<?= $this->old('name') ?>" placeholder="Adınız ve soyadınız">
                                    <?= $this->validationError('name', $errors ?? []) ?>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">E-posta *</label>
                                    <input type="email" class="form-control" id="email" name="email" required 
                                           value="<?= $this->old('email') ?>" placeholder="ornek@email.com">
                                    <?= $this->validationError('email', $errors ?? []) ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="subject" class="form-label">Konu *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Konu seçiniz</option>
                                        <option value="genel" <?= $this->selected('subject', 'genel') ?>>Genel Bilgi</option>
                                        <option value="teknik" <?= $this->selected('subject', 'teknik') ?>>Teknik Destek</option>
                                        <option value="oneri" <?= $this->selected('subject', 'oneri') ?>>Öneri/Şikayet</option>
                                        <option value="isbirligi" <?= $this->selected('subject', 'isbirligi') ?>>İş Birliği</option>
                                        <option value="diger" <?= $this->selected('subject', 'diger') ?>>Diğer</option>
                                    </select>
                                    <?= $this->validationError('subject', $errors ?? []) ?>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Öncelik</label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="normal" <?= $this->selected('priority', 'normal') ?>>Normal</option>
                                        <option value="yuksek" <?= $this->selected('priority', 'yuksek') ?>>Yüksek</option>
                                        <option value="acil" <?= $this->selected('priority', 'acil') ?>>Acil</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Mesaj *</label>
                                <textarea class="form-control" id="message" name="message" rows="6" required 
                                          placeholder="Mesajınızı buraya yazın..."><?= $this->old('message') ?></textarea>
                                <?= $this->validationError('message', $errors ?? []) ?>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" 
                                           <?= $this->checked('newsletter', '1') ?>>
                                    <label class="form-check-label" for="newsletter">
                                        Güncellemeler ve haberler için e-posta almak istiyorum
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreement" name="agreement" required>
                                    <label class="form-check-label" for="agreement">
                                        <a href="<?= $this->url('rules') ?>" target="_blank">Sunucu kurallarını</a> okudum ve kabul ediyorum *
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Mesajı Gönder
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sık Sorulan Sorular -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0"><i class="fas fa-question-circle me-2"></i>Sık Sorulan Sorular</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h5><i class="fas fa-heart text-info me-2"></i>Lifesteal Sistemi</h5>
                                <p class="small">Lifesteal sistemi hakkında detaylı bilgi için Discord sunucumuza katılın veya kurallar sayfasını ziyaret edin.</p>
                                <a href="<?= $this->url('rules') ?>" class="btn btn-sm btn-outline-info">Kuralları Oku</a>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <h5><i class="fas fa-tools text-info me-2"></i>Teknik Destek</h5>
                                <p class="small">Teknik sorunlar yaşıyorsanız Discord sunucumuzdaki #teknik-destek kanalını kullanın.</p>
                                <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-sm btn-outline-info">Discord'a Katıl</a>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <h5><i class="fas fa-users text-info me-2"></i>Klan Sistemi</h5>
                                <p class="small">Klan kurma ve yönetimi hakkında bilgi almak için Discord sunucumuzdaki #klan-sistemi kanalını ziyaret edin.</p>
                                <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-sm btn-outline-info">Detaylar</a>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <h5><i class="fas fa-gift text-info me-2"></i>Ödül Sistemi</h5>
                                <p class="small">Günlük görevler ve ödüller hakkında bilgi almak için Discord sunucumuzdaki #gorevler kanalını takip edin.</p>
                                <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-sm btn-outline-info">Görevler</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hızlı İletişim -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <div class="card bg-dark text-white">
                    <div class="card-body py-4">
                        <h3 class="mb-3">Hızlı İletişim</h3>
                        <p class="mb-4">Discord sunucumuzda moderatörlerimiz size yardımcı olmaya hazır!</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-primary btn-lg">
                                <i class="fab fa-discord me-2"></i>Discord Topluluğu
                            </a>
                            <a href="<?= $this->url('join') ?>" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-play me-2"></i>Sunucuya Katıl
                            </a>
                            <a href="<?= $this->url('rules') ?>" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-book me-2"></i>Kuralları Oku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control:focus,
.form-select:focus {
    border-color: #ff6b6b;
    box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
}

.btn-success:hover {
    background-color: #198754;
    border-color: #198754;
}

.card-header {
    border-bottom: none;
}

.badge {
    font-size: 0.8em;
}
</style>
