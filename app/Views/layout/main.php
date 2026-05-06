<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PUASKULINER' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF4757;
            --secondary-color: #2F3542;
            --accent-color: #FFA502;
            --bg-body: #F1F2F6;
        }
        body { 
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px 0;
        }
        .navbar-brand { 
            font-weight: 800; 
            color: var(--primary-color) !important;
            font-size: 1.6rem;
            letter-spacing: -1px;
        }
        .card { 
            border: none;
            border-radius: 24px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            background: white;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .btn-primary { 
            background-color: var(--primary-color);
            border: none;
            font-weight: 700;
            border-radius: 16px;
            padding: 12px 28px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #ff3344;
            transform: scale(1.05);
        }
        .badge-category {
            background-color: var(--accent-color);
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 8px 16px;
            font-size: 0.7rem;
            text-transform: uppercase;
        }
        .search-container {
            background: white;
            padding: 10px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 60px 0 30px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="bi bi-fire me-2"></i>
                <span>PUASKULINER</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link px-3 fw-bold" href="/">BERANDA</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold" href="/?category=1">MAKANAN</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold" href="/?category=3">MINUMAN</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold" href="/favorites">FAVORIT</a></li>
                    <li class="nav-item"><a class="nav-link px-3 fw-bold text-primary" href="/submit"><i class="bi bi-plus-circle-fill me-1"></i>TAMBAH</a></li>

                </ul>
                <div class="d-flex align-items-center">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="dropdown">
                            <button class="btn btn-light rounded-pill px-4 dropdown-toggle d-flex align-items-center shadow-sm" type="button" data-bs-toggle="dropdown">
                                <span class="fw-bold small"><?= session()->get('username') ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 p-2 rounded-4">
                                <li><a class="dropdown-item rounded-3" href="/favorites">Favorit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-3 text-danger" href="/logout">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-link text-decoration-none fw-bold text-dark me-2" href="/login">MASUK</a>
                        <a class="btn btn-primary shadow-sm" href="/register">DAFTAR</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 py-3 px-4" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 py-3 px-4" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <h3 class="fw-bold mb-4 text-white">PUASKULINER</h3>
            <p class="opacity-50 small mb-4">Temukan pengalaman makan terbaik di setiap sudut kota bersama PUASKULINER.</p>
            <div class="d-flex justify-content-center gap-3 mb-5">
                <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white fs-4"><i class="bi bi-twitter-x"></i></a>
            </div>
            <p class="opacity-50 small mb-0">&copy; <?= date('Y') ?> PUASKULINER. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
