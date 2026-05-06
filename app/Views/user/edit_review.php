<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-5 p-4 p-lg-5">
            <h2 class="fw-bold text-dark mb-4">Edit Review</h2>
            <p class="text-muted mb-4">Anda dapat mengubah review ini dalam waktu 24 jam setelah dikirim.</p>
            
            <form action="/review/update/<?= $review['id'] ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-4 text-center">
                    <label class="form-label d-block text-muted small mb-3">Rating Anda</label>
                    <div class="rating-input fs-1 text-warning">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <i class="bi bi-star<?= $i <= $review['rating'] ? '-fill' : '' ?> cursor-pointer px-1" data-value="<?= $i ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="rating" id="rating_val" value="<?= $review['rating'] ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Komentar</label>
                    <textarea name="comment" class="form-control border-0 bg-light rounded-4 p-3" rows="5" required><?= $review['comment'] ?></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5">
                    <a href="/location/<?= $review['location_id'] ?>" class="text-decoration-none text-muted fw-bold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.rating-input i');
    const ratingInput = document.getElementById('rating_val');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const val = this.getAttribute('data-value');
            ratingInput.value = val;
            
            stars.forEach(s => {
                if(s.getAttribute('data-value') <= val) {
                    s.classList.replace('bi-star', 'bi-star-fill');
                } else {
                    s.classList.replace('bi-star-fill', 'bi-star');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
