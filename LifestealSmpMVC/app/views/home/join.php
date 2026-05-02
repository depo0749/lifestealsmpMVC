<!-- Join Page -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">Sunucuya Katıl</h1>
                <p class="lead">LifestealSMP'de nasıl oynayacağınızı öğrenin</p>
            </div>
        </div>
        
        <!-- Sunucu Bilgileri -->
        <div class="row mb-5">
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-primary">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-server me-2"></i>Sunucu Bilgileri</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <h6><i class="fas fa-network-wired text-primary me-2"></i>IP Adresi</h6>
                                <p class="mb-2"><strong><?= $serverIP ?></strong></p>
                                <button class="btn btn-sm btn-outline-primary" onclick="copyIP()">
                                    <i class="fas fa-copy me-1"></i>Kopyala
                                </button>
                            </div>
                            <div class="col-6 mb-3">
                                <h6><i class="fas fa-code-branch text-primary me-2"></i>Versiyon</h6>
                                <p class="mb-2"><strong><?= $serverVersion ?></strong></p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6><i class="fas fa-users text-primary me-2"></i>Maksimum Oyuncu</h6>
                                <p class="mb-2"><strong><?= $maxPlayers ?></strong></p>
                            </div>
                            <div class="col-6 mb-3">
                                <h6><i class="fas fa-globe text-primary me-2"></i>Ülke</h6>
                                <p class="mb-2"><strong><?= $serverCountry ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-success">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0"><i class="fas fa-heart me-2"></i>Lifesteal Sistemi</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Nasıl Çalışır?</h6>
                            <ul class="mb-0">
                                <li>Başlangıçta 10 can kalbiniz olur</li>
                                <li>Öldürdüğünüz oyuncudan 1 can kalbi alırsınız</li>
                                <li>Öldüğünüzde 1 can kalbinizi kaybedersiniz</li>
                                <li>0 can kalbi ile oyuna devam edemezsiniz</li>
                            </ul>
                        </div>
                        <div class="text-center">
                            <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-success">
                                <i class="fab fa-discord me-2"></i>Discord'a Katıl
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Adım Adım Kurulum -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0"><i class="fas fa-list-ol me-2"></i>Adım Adım Kurulum</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">1</span>
                                    </div>
                                    <h5>Minecraft İndirin</h5>
                                    <p class="small">Minecraft Java Edition'ı resmi siteden indirin</p>
                                    <a href="https://www.minecraft.net" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-download me-1"></i>İndir
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">2</span>
                                    </div>
                                    <h5>Sunucuya Bağlanın</h5>
                                    <p class="small">Multiplayer menüsünden sunucu IP'sini girin</p>
                                    <button class="btn btn-sm btn-outline-info" onclick="copyIP()">
                                        <i class="fas fa-copy me-1"></i>IP Kopyala
                                    </button>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">3</span>
                                    </div>
                                    <h5>Discord'a Katılın</h5>
                                    <p class="small">Topluluk Discord sunucusuna katılın</p>
                                    <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fab fa-discord me-1"></i>Katıl
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <span class="h4 mb-0">4</span>
                                    </div>
                                    <h5>Oynamaya Başlayın</h5>
                                    <p class="small">Sunucuya giriş yapın ve oyuna başlayın</p>
                                    <span class="badge bg-success">Hazır!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sık Sorulan Sorular -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="mb-0"><i class="fas fa-question-circle me-2"></i>Sık Sorulan Sorular</h3>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                        Lifesteal sistemi nasıl çalışır?
                                    </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Lifesteal sisteminde, öldürdüğünüz oyuncudan can kalbi alırsınız ve öldüğünüzde can kalbinizi kaybedersiniz. 0 can kalbi ile oyuna devam edemezsiniz.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                        Hangi Minecraft versiyonu gerekli?
                                    </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Sunucumuz <?= $serverVersion ?> versiyonunda çalışmaktadır. Bu versiyonu kullanmanız gerekmektedir.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                        Mod kullanabilir miyim?
                                    </button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Hayır, sunucumuzda mod kullanımı yasaktır. Sadece vanilla Minecraft ile oynayabilirsiniz.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                        Can kalbimi nasıl geri alabilirim?
                                    </button>
                                </h2>
                                <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Can kalbinizi geri almak için başka oyuncuları öldürmeniz gerekir. Her öldürdüğünüz oyuncudan 1 can kalbi alırsınız.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="row">
            <div class="col-12 text-center">
                <div class="card bg-primary text-white">
                    <div class="card-body py-5">
                        <h2 class="mb-4">Hemen Katılmaya Hazır mısın?</h2>
                        <p class="lead mb-4">LifestealSMP'de hayatını kaybet, hayatını kazan!</p>
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <button class="btn btn-light btn-lg" onclick="copyIP()">
                                <i class="fas fa-copy me-2"></i>IP'yi Kopyala
                            </button>
                            <a href="<?= $discordInvite ?>" target="_blank" class="btn btn-outline-light btn-lg">
                                <i class="fab fa-discord me-2"></i>Discord Topluluğu
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
.rounded-circle {
    font-weight: bold;
}

.accordion-button:not(.collapsed) {
    background-color: #ff6b6b;
    color: white;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
}

.card-header {
    border-bottom: none;
}
</style>
