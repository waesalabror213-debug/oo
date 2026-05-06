<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row mb-5">
    <div class="col-12">
        <h2 class="fw-bold text-dark mb-2">Favorit Saya</h2>
        <p class="text-muted">Daftar tempat makan favorit yang Anda simpan di PUASKULINER.</p>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($locations)): ?>
        <div class="col-12 text-center py-5">
            <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                <i class="bi bi-heart text-primary opacity-25" style="font-size: 4rem;"></i>
                <h3 class="mt-4 fw-bold">Belum ada favorit</h3>
                <p class="text-muted">Mulai eksplorasi dan simpan tempat makan favorit Anda!</p>
                <a href="/" class="btn btn-primary rounded-pill mt-2">Cari di PUASKULINER</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($locations as $loc): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative">
                    <div class="position-absolute top-0 end-0 m-3 z-1">
                        <a href="/location/<?= $loc['id'] ?>/favorite" class="btn btn-danger rounded-circle shadow-sm" style="width: 40px; height: 40px; padding: 0; line-height: 40px;">
                            <i class="bi bi-heart-fill"></i>
                        </a>
                    </div>
                    <div class="card-img-container" style="height: 200px; overflow: hidden;">
                        <?php 
                            $photoSrc = 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=500&q=80';
                            if ($loc['photo']) {
                                if (filter_var($loc['photo'], FILTER_VALIDATE_URL)) {
                                    $photoSrc = $loc['photo'];
                                } else {
                                    $photoSrc = base_url('uploads/locations/' . $loc['photo']);
                                }
                            }
                        ?>
                        <img src="<?= $photoSrc ?>" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="<?= $loc['name'] ?>">
                    </div>
                    <div class="card-body p-4">
                        <span class="badge-category small text-uppercase mb-2 d-inline-block"><?= $loc['category_name'] ?></span>
                        <h5 class="card-title fw-bold text-dark mb-2"><?= $loc['name'] ?></h5>
                        <p class="card-text text-muted small mb-3">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= $loc['address'] ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill me-1"></i> <?= number_format($loc['rating_avg'], 1) ?>
                            </div>
                            <a href="/location/<?= $loc['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
