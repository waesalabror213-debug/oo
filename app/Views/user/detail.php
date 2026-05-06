
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-5 overflow-hidden mb-4">
            <div class="position-relative">
                <?php 
                    $photoSrc = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80';
                    if ($location['photo']) {
                        if (filter_var($location['photo'], FILTER_VALIDATE_URL)) {
                            $photoSrc = $location['photo'];
                        } else {
                            $photoSrc = base_url('uploads/locations/' . $location['photo']);
                        }
                    } else {
                        // Fallback based on category
                        if (stripos($location['category_name'], 'minum') !== false) {
                            $photoSrc = 'https://images.unsplash.com/photo-1544145945-f904253d0c7b?auto=format&fit=crop&w=800&q=80';
                        } elseif (stripos($location['category_name'], 'kafe') !== false || stripos($location['category_name'], 'nongkrong') !== false) {
                            $photoSrc = 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=800&q=80';
                        } elseif (stripos($location['category_name'], 'snack') !== false || stripos($location['category_name'], 'jajan') !== false) {
                            $photoSrc = 'https://images.unsplash.com/photo-1621464540242-cc7a8844b2fa?auto=format&fit=crop&w=800&q=80';
                        }
                    }
                ?>
                <img src="<?= $photoSrc ?>" class="w-100" alt="<?= $location['name'] ?>" style="height: 450px; object-fit: cover;">
                <div class="position-absolute bottom-0 start-0 w-100 p-4 pb-5 bg-gradient-dark text-white" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <span class="badge bg-primary rounded-pill px-3 py-2 mb-2 text-uppercase fw-bold small"><?= $location['category_name'] ?></span>
                            <h1 class="display-6 fw-bold mb-0"><?= $location['name'] ?></h1>
                        </div>
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a href="/location/<?= $location['id'] ?>/favorite" class="btn btn-<?= $isFavorite ? 'danger' : 'light' ?> rounded-circle p-3 shadow-lg mb-2">
                                <i class="bi bi-heart<?= $isFavorite ? '-fill' : '' ?> fs-4"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-lg-5">
                <div class="row align-items-center mb-4">
                    <div class="col-md-7">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-warning me-2 fs-4">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="bi bi-star<?= $i <= round($location['rating_avg']) ? '-fill' : ($i - 0.5 <= $location['rating_avg'] ? '-half' : '') ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="fw-bold fs-4"><?= number_format($location['rating_avg'], 1) ?></span>
                            <span class="text-muted ms-2">(<?= count($reviews) ?> Ulasan Pengguna)</span>
                        </div>
                        <p class="text-muted lead"><?= $location['description'] ?></p>
                    </div>
                    <div class="col-md-5">
                        <div class="bg-light p-4 rounded-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Lokasi Presisi</h6>
                            <p class="small text-muted mb-3"><?= $location['address'] ?></p>
                            <div id="map" class="rounded-3 shadow-sm mb-3" style="height: 200px;"></div>
                            <?php if ($location['is_closed']): ?>
                                <div class="alert alert-danger rounded-4 py-2 small fw-bold mb-0">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>TEMPAT TUTUP PERMANEN
                                </div>
                            <?php elseif ($location['closure_requested']): ?>
                                <div class="alert alert-warning rounded-4 py-2 small fw-bold mb-0">
                                    <i class="bi bi-clock-history me-2"></i>Menunggu validasi penutupan...
                                </div>
                            <?php else: ?>
                                <a href="/location/<?= $location['id'] ?>/close" class="btn btn-outline-danger w-100 rounded-pill btn-sm fw-bold" onclick="return confirm('Apakah Anda yakin tempat ini sudah tutup permanen?')">Tandai Tutup Permanen</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr class="my-5 opacity-5">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">Ulasan Pengguna</h4>
                    <button class="btn btn-outline-primary rounded-pill btn-sm fw-bold px-3 d-lg-none" data-bs-toggle="modal" data-bs-target="#reviewModal">Tulis Ulasan</button>
                </div>

                <?php if (empty($reviews)): ?>
                    <div class="text-center py-5 bg-light rounded-5">
                        <i class="bi bi-chat-heart text-muted opacity-25" style="font-size: 3rem;"></i>
                        <p class="mt-3 text-muted">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                    </div>
                <?php else: ?>
                    <div class="review-list">
                        <?php foreach ($reviews as $rev): ?>
                            <div class="card border-0 bg-white mb-3 rounded-4 shadow-none border-bottom rounded-0 pb-4">
                                <div class="card-body p-0 pt-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-soft-blue text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 40px; height: 40px;">
                                                <?= strtoupper(substr($rev['username'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0"><?= $rev['username'] ?></h6>
                                                <small class="text-muted"><?= date('d M Y', strtotime($rev['created_at'])) ?></small>
                                                <?php 
                                                    $createdAt = new \DateTime($rev['created_at']);
                                                    $now = new \DateTime();
                                                    $diff = $now->diff($createdAt);
                                                    $hours = $diff->h + ($diff->days * 24);
                                                    if (session()->get('id') == $rev['user_id'] && $hours < 24):
                                                ?>
                                                    <a href="/review/edit/<?= $rev['id'] ?>" class="ms-2 badge bg-light text-primary border-0 small text-decoration-none">Edit</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="text-warning small">
                                            <?php for($i=1; $i<=5; $i++): ?>
                                                <i class="bi bi-star<?= $i <= $rev['rating'] ? '-fill' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <p class="card-text text-dark"><?= $rev['comment'] ?></p>
                                    <?php if ($rev['photo']): ?>
                                        <img src="/uploads/reviews/<?= $rev['photo'] ?>" class="rounded-3 mt-2" style="max-height: 120px; cursor: pointer;" onclick="window.open(this.src)">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-5 p-4 sticky-top" style="top: 100px;">
            <h5 class="fw-bold mb-4">Beri Penilaian</h5>
            <?php if (session()->get('isLoggedIn')): ?>
                <form action="/location/<?= $location['id'] ?>/review" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-4 text-center">
                        <label class="form-label d-block text-muted small mb-3">Klik bintang untuk memberi rating</label>
                        <div class="rating-input fs-2 text-muted">
                            <i class="bi bi-star cursor-pointer px-1" data-value="1"></i>
                            <i class="bi bi-star cursor-pointer px-1" data-value="2"></i>
                            <i class="bi bi-star cursor-pointer px-1" data-value="3"></i>
                            <i class="bi bi-star cursor-pointer px-1" data-value="4"></i>
                            <i class="bi bi-star cursor-pointer px-1" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="rating_val" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Ceritakan pengalamanmu</label>
                        <textarea name="comment" class="form-control border-0 bg-light rounded-4 p-3" rows="4" required placeholder="Gimana rasa makanannya? Murah nggak?"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Foto Makanan (Opsional)</label>
                        <div class="input-group">
                            <input type="file" name="photo" class="form-control border-0 bg-light rounded-4">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">Kirim Review Jujur</button>
                </form>
            <?php else: ?>
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-lock text-muted" style="font-size: 2.5rem;"></i>
                    </div>
                    <p class="text-muted small px-3">Hanya pengguna yang sudah login yang bisa memberikan ulasan.</p>
                    <a href="/login" class="btn btn-primary rounded-pill w-100 fw-bold">Masuk / Daftar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Map Implementation
    const lat = <?= $location['latitude'] ?: '-6.9826' ?>;
    const lng = <?= $location['longitude'] ?: '110.4091' ?>;
    
    var map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup('<b><?= $location['name'] ?></b><br><?= $location['address'] ?>')
        .openPopup();

    // Star Rating Implementation
    const stars = document.querySelectorAll('.rating-input i');
    const ratingInput = document.getElementById('rating_val');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const val = this.getAttribute('data-value');
            ratingInput.value = val;
            
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= val) {
                    s.classList.replace('bi-star', 'bi-star-fill');
                    s.classList.add('text-warning');
                } else {
                    s.classList.replace('bi-star-fill', 'bi-star');
                    s.classList.remove('text-warning');
                }
            });
        });

        star.addEventListener('mouseover', function() {
            const val = this.getAttribute('data-value');
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= val) {
                    s.classList.add('text-warning');
                }
            });
        });

        star.addEventListener('mouseout', function() {
            const val = ratingInput.value;
            stars.forEach(s => {
                if(s.getAttribute('data-value') > val) {
                    s.classList.remove('text-warning');
                }
            });
        });
    });
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    .bg-soft-blue { background-color: #e7f1ff; }
</style>
<?= $this->endSection() ?>
