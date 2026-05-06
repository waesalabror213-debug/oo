<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-lg rounded-5 p-4 p-lg-5">
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="bi bi-person-fill text-primary fs-2"></i>
                </div>
                <h3 class="fw-800 text-dark">Selamat Datang</h3>
                <p class="text-muted small">Masuk ke akun PUASKULINER Anda</p>
            </div>
            <form action="/login" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Username</label>
                    <input type="text" name="username" class="form-control border-0 bg-light rounded-4 p-3" required placeholder="Masukkan username">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Password</label>
                    <input type="password" name="password" class="form-control border-0 bg-light rounded-4 p-3" required placeholder="Masukkan password">
                </div>
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm mb-3">Masuk Sekarang</button>
                <p class="text-center mt-3 small text-muted">
                    Belum punya akun? <a href="/register" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
