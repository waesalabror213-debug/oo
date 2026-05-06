<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-5 align-items-center py-5">
    <div class="col-lg-6">
        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 fw-bold mb-3">
            <i class="bi bi-stars me-1"></i> #1 Rekomendasi PUASKULINER Semarang
        </span>
        <h1 class="display-3 fw-800 text-dark mb-3" style="letter-spacing: -2px; line-height: 1.1;">Puas <span class="text-primary">Makan</span>,<br>Puas <span class="text-primary">Review!</span></h1>
        <p class="lead text-muted mb-4 fs-5">Platform kurasi rasa nomor satu untuk pengalaman makan yang tak terlupakan. Cari, makan, dan bagikan kepuasanmu!</p>
        
        <div class="search-container d-flex p-2 mb-4 bg-white shadow-lg" style="border-radius: 24px;">
            <form action="/" method="get" class="w-100 d-flex">
                <div class="input-group input-group-lg border-0">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 shadow-none fs-6" placeholder="Cari nasi goreng, kafe, atau menu..." value="<?= $search ?>">
                </div>
                <button type="submit" class="btn btn-primary px-4 ms-2 rounded-pill">Cari</button>
            </form>
        </div>

        <div class="d-flex gap-3 align-items-center mt-4">
            <div class="d-flex -space-x-2">
                <img src="https://i.pravatar.cc/40?img=11" class="rounded-circle border border-2 border-white" style="width: 40px; height: 40px;">
                <img src="https://i.pravatar.cc/40?img=12" class="rounded-circle border border-2 border-white ms-n2" style="width: 40px; height: 40px;">
                <img src="https://i.pravatar.cc/40?img=13" class="rounded-circle border border-2 border-white ms-n2" style="width: 40px; height: 40px;">
            </div>
            <p class="small text-muted mb-0 fw-medium">Bergabung dengan <span class="text-dark fw-bold">10,000+</span> pemburu rasa lainnya.</p>
        </div>
    </div>
    <div class="col-lg-6 d-none d-lg-block">
        <div class="position-relative">
            <div class="position-absolute top-0 start-0 translate-middle bg-white p-3 rounded-4 shadow-lg z-1 animate-bounce" style="margin-top: 50px;">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-success bg-opacity-10 p-2 rounded-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                    </div>
                    <div>
                        <p class="small fw-bold mb-0">Ulasan Terverifikasi</p>
                        <p class="text-muted" style="font-size: 10px; margin-bottom: 0;">100% dari pengguna asli</p>
                    </div>
                </div>
            </div>
            <div class="position-absolute bottom-0 end-0 bg-white p-3 rounded-4 shadow-lg z-1" style="margin-bottom: 50px;">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-warning bg-opacity-10 p-2 rounded-3">
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <div>
                        <p class="small fw-bold mb-0">Rating 4.9/5.0</p>
                        <p class="text-muted" style="font-size: 10px; margin-bottom: 0;">Kepuasan Pengguna</p>
                    </div>
                </div>
            </div>
            <?php 
                $heroImage = 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=800&q=80';
                if ($category == 3) $heroImage = 'https://images.unsplash.com/photo-1544145945-f904253d0c7b?auto=format&fit=crop&w=800&q=80';
            ?>
            <img src="<?= $heroImage ?>" alt="Hero Image" class="img-fluid rounded-5 shadow-2xl rotate-2">
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-800 text-dark mb-1">Pilih <span class="text-primary">Selera</span> Kamu</h3>
                <p class="text-muted small">Eksplorasi berbagai kategori makanan dan minuman pilihan.</p>
            </div>
        </div>
        <div class="d-flex overflow-auto pb-3 gap-3" style="scrollbar-width: none;">
            <a href="/?<?= http_build_query(array_merge($_GET, ['category' => ''])) ?>" class="btn btn-<?= !$category ? 'primary shadow-lg' : 'white border-0 shadow-sm text-dark' ?> rounded-pill px-4 py-2 fw-bold transition-all">
                <i class="bi bi-grid-fill me-2"></i>Semua
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="/?<?= http_build_query(array_merge($_GET, ['category' => $cat['id']])) ?>" class="btn btn-<?= $category == $cat['id'] ? 'primary shadow-lg' : 'white border-0 shadow-sm text-dark' ?> rounded-pill px-4 py-2 fw-bold text-nowrap transition-all">
                    <?php 
                        $icon = 'bi-egg-fried';
                        if(stripos($cat['name'], 'minum') !== false) $icon = 'bi-cup-hot';
                        if(stripos($cat['name'], 'snack') !== false || stripos($cat['name'], 'jajan') !== false) $icon = 'bi-cookie';
                        if(stripos($cat['name'], 'kafe') !== false || stripos($cat['name'], 'nongkrong') !== false) $icon = 'bi-cup-straw';
                    ?>
                    <i class="bi <?= $icon ?> me-2"></i><?= $cat['name'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="fw-800 text-dark mb-1">Filter <span class="text-primary">Cerdas</span></h3>
                <p class="text-muted small">Gunakan filter untuk hasil yang lebih spesifik.</p>
            </div>
        </div>
        <form action="/" method="get" id="filterForm">
            <input type="hidden" name="search" value="<?= $search ?>">
            <input type="hidden" name="category" value="<?= $category ?>">
            
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <div class="dropdown">
                    <button class="btn btn-white border-0 shadow-sm rounded-pill px-4 py-2 fw-semibold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-star-fill me-2 text-warning"></i><?= $rating ? $rating . '+ Bintang' : 'Rating' ?>
                    </button>
                    <ul class="dropdown-menu border-0 shadow-lg rounded-4 p-2">
                        <li><a class="dropdown-item rounded-3" href="/?<?= http_build_query(array_merge($_GET, ['rating' => ''])) ?>">Semua Rating</a></li>
                        <?php for($i=4; $i>=1; $i--): ?>
                            <li><a class="dropdown-item rounded-3 <?= $rating == $i ? 'active' : '' ?>" href="/?<?= http_build_query(array_merge($_GET, ['rating' => $i])) ?>"><?= $i ?>+ Bintang</a></li>
                        <?php endfor; ?>
                    </ul>
                </div>

                <button type="button" id="btn-distance" class="btn btn-white border-0 shadow-sm rounded-pill px-4 py-2 fw-semibold">
                    <i class="bi bi-geo-fill me-2 text-danger"></i>Terdekat
                </button>

                <?php if ($rating || $category || $search): ?>
                    <a href="/" class="btn btn-link text-muted text-decoration-none small fw-bold">Reset Semua</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <?php if ($is_home): ?>
        <!-- Section Makanan -->
        <div class="col-12 mt-5">
            <div class="d-flex align-items-center gap-3 mb-1">
                <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                    <i class="bi bi-fire text-primary fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-800 text-dark mb-0">Menu Wajib Coba</h3>
                    <p class="text-muted mb-0">Jangan lewatkan sensasi rasa dari tempat-tempat paling hits.</p>
                </div>
            </div>
        </div>
        <?php foreach ($makanan as $loc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-5 overflow-hidden group">
                    <div class="position-absolute top-0 end-0 m-3 z-1">
                        <div class="bg-white bg-opacity-90 backdrop-blur-sm text-dark shadow-sm rounded-pill px-3 py-2 fw-bold d-flex align-items-center">
                            <i class="bi bi-star-fill text-warning me-1"></i> <?= number_format($loc['rating_avg'], 1) ?>
                        </div>
                    </div>
                    <div class="card-img-container" style="height: 250px; overflow: hidden;">
                        <?php 
                            $photoSrc = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80';
                            if ($loc['photo']) {
                                $photoSrc = filter_var($loc['photo'], FILTER_VALIDATE_URL) ? $loc['photo'] : base_url('uploads/locations/' . $loc['photo']);
                            }
                        ?>
                        <img src="<?= $photoSrc ?>" class="card-img-top w-100 h-100 transition-all group-hover-scale-110" style="object-fit: cover;" alt="<?= $loc['name'] ?>">
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-soft-warning text-warning border-0 rounded-pill px-3 py-1 small fw-bold text-uppercase"><?= $loc['category_name'] ?></span>
                        </div>
                        <h4 class="card-title fw-800 text-dark mb-2"><?= $loc['name'] ?></h4>
                        <p class="card-text text-muted small mb-4 line-clamp-2">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= $loc['address'] ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="/location/<?= $loc['id'] ?>" class="btn btn-primary rounded-pill px-4 w-100 fw-bold">Detail Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Section Minuman -->
        <div class="col-12 mt-5 pt-4">
            <div class="d-flex align-items-center gap-3 mb-1">
                <div class="bg-info bg-opacity-10 p-3 rounded-4">
                    <i class="bi bi-cup-hot text-info fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-800 text-dark mb-0">Haus? Cek Ini!</h3>
                    <p class="text-muted mb-0">Daftar minuman paling segar untuk melepas dahagamu.</p>
                </div>
            </div>
        </div>
        <?php foreach ($minuman as $loc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-5 overflow-hidden group">
                    <div class="position-absolute top-0 end-0 m-3 z-1">
                        <div class="bg-white bg-opacity-90 backdrop-blur-sm text-dark shadow-sm rounded-pill px-3 py-2 fw-bold d-flex align-items-center">
                            <i class="bi bi-star-fill text-warning me-1"></i> <?= number_format($loc['rating_avg'], 1) ?>
                        </div>
                    </div>
                    <div class="card-img-container" style="height: 250px; overflow: hidden;">
                        <?php 
                            $photoSrc = 'https://images.unsplash.com/photo-1544145945-f904253d0c7b?auto=format&fit=crop&w=600&q=80';
                            if ($loc['photo']) {
                                $photoSrc = filter_var($loc['photo'], FILTER_VALIDATE_URL) ? $loc['photo'] : base_url('uploads/locations/' . $loc['photo']);
                            }
                        ?>
                        <img src="<?= $photoSrc ?>" class="card-img-top w-100 h-100 transition-all group-hover-scale-110" style="object-fit: cover;" alt="<?= $loc['name'] ?>">
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-soft-info text-info border-0 rounded-pill px-3 py-1 small fw-bold text-uppercase"><?= $loc['category_name'] ?></span>
                        </div>
                        <h4 class="card-title fw-800 text-dark mb-2"><?= $loc['name'] ?></h4>
                        <p class="card-text text-muted small mb-4 line-clamp-2">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= $loc['address'] ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="/location/<?= $loc['id'] ?>" class="btn btn-primary rounded-pill px-4 w-100 fw-bold">Detail Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php elseif (empty($locations)): ?>
        <div class="col-12 text-center py-5">
            <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                <i class="bi bi-search-heart text-primary opacity-25" style="font-size: 4rem;"></i>
                <h3 class="mt-4 fw-800">Opps! Tidak ada hasil</h3>
                <p class="text-muted">Coba gunakan kata kunci lain atau filter kategori yang berbeda.</p>
                <a href="/" class="btn btn-outline-primary rounded-pill mt-2 fw-bold px-4">Reset Pencarian</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($locations as $loc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-5 overflow-hidden group">
                    <div class="position-absolute top-0 end-0 m-3 z-1">
                        <div class="bg-white bg-opacity-90 backdrop-blur-sm text-dark shadow-sm rounded-pill px-3 py-2 fw-bold d-flex align-items-center">
                            <i class="bi bi-star-fill text-warning me-1"></i> <?= number_format($loc['rating_avg'], 1) ?>
                        </div>
                    </div>
                    <div class="card-img-container" style="height: 250px; overflow: hidden;">
                        <?php if (isset($loc['distance'])): ?>
                            <div class="position-absolute top-0 start-0 m-3 z-1">
                                <span class="badge bg-primary rounded-pill px-3 py-2 fw-bold shadow-sm">
                                    <i class="bi bi-geo-alt-fill me-1"></i> <?= number_format($loc['distance'], 1) ?> km
                                </span>
                            </div>
                        <?php endif; ?>
                        <?php 
                            $photoSrc = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=600&q=80';
                            
                            if ($loc['photo']) {
                                if (filter_var($loc['photo'], FILTER_VALIDATE_URL)) {
                                    $photoSrc = $loc['photo'];
                                } else {
                                    $photoSrc = base_url('uploads/locations/' . $loc['photo']);
                                }
                            } else {
                                if (stripos($loc['category_name'], 'minum') !== false) {
                                    $photoSrc = 'https://images.unsplash.com/photo-1544145945-f904253d0c7b?auto=format&fit=crop&w=600&q=80';
                                } elseif (stripos($loc['category_name'], 'kafe') !== false || stripos($loc['category_name'], 'nongkrong') !== false) {
                                    $photoSrc = 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=600&q=80';
                                } elseif (stripos($loc['category_name'], 'snack') !== false || stripos($loc['category_name'], 'jajan') !== false) {
                                    $photoSrc = 'https://images.unsplash.com/photo-1621464540242-cc7a8844b2fa?auto=format&fit=crop&w=600&q=80';
                                }
                            }
                        ?>
                        <img src="<?= $photoSrc ?>" class="card-img-top w-100 h-100 transition-all group-hover-scale-110" style="object-fit: cover;" alt="<?= $loc['name'] ?>">
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-soft-primary text-primary border-0 rounded-pill px-3 py-1 small fw-bold text-uppercase"><?= $loc['category_name'] ?></span>
                        </div>
                        <h4 class="card-title fw-800 text-dark mb-2"><?= $loc['name'] ?></h4>
                        <p class="card-text text-muted small mb-4 line-clamp-2">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= $loc['address'] ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                            <a href="/location/<?= $loc['id'] ?>" class="btn btn-primary rounded-pill px-4 w-100 fw-bold">Detail Lokasi</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="d-flex justify-content-center mt-5">
    <?php if (isset($pager)): ?>
        <?= $pager->links('locations', 'bootstrap_pagination') ?>
    <?php endif; ?>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .bg-soft-primary { background-color: rgba(255, 71, 87, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 165, 2, 0.1); }
    .bg-soft-info { background-color: rgba(47, 53, 66, 0.05); }
    .btn-white { background: white; color: var(--secondary-color); }
    .transition-all { transition: all 0.3s ease; }
    .rotate-2 { transform: rotate(2deg); }
    .ms-n2 { margin-left: -0.5rem; }
    .backdrop-blur-sm { backdrop-filter: blur(4px); }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .group:hover .group-hover-scale-110 { transform: scale(1.1); }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
</style>

<script>
    document.getElementById('btn-distance')?.addEventListener('click', function() {
        const btn = this;
        if (navigator.geolocation) {
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mencari...';
            btn.disabled = true;
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                window.location.href = `/?lat=${lat}&lng=${lng}`;
            }, function(error) {
                alert("Gagal mendapatkan lokasi: " + error.message);
                btn.innerHTML = '<i class="bi bi-geo-fill me-2 text-danger"></i>Terdekat';
                btn.disabled = false;
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }
    });
</script>

<?= $this->endSection() ?>
