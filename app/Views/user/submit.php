<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-5 p-4 p-lg-5">
            <h2 class="fw-bold text-dark mb-4">Kontribusi PUASKULINER</h2>
            <p class="text-muted mb-4">Punya rekomendasi tempat makan enak? Bagikan ke komunitas PUASKULINER lainnya!</p>
            
            <form action="/submit" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nama Tempat Makan</label>
                        <input type="text" name="name" class="form-control border-0 bg-light rounded-4 p-3" required placeholder="Contoh: Nasi Goreng Pak Kumis">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Kategori</label>
                        <select name="category_id" class="form-select border-0 bg-light rounded-4 p-3" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Alamat Lengkap</label>
                    <div class="input-group">
                        <textarea name="address" id="address" class="form-control border-0 bg-light rounded-4 p-3" rows="2" required placeholder="Masukkan alamat lengkap untuk mencari koordinat otomatis..."></textarea>
                        <button type="button" id="btn-geocode" class="btn btn-primary rounded-4 ms-2 px-4 fw-bold">
                            <i class="bi bi-geo-alt-fill me-2"></i>Cari Koordinat
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">Sistem akan otomatis mencari Latitude & Longitude berdasarkan alamat via Nominatim API.</small>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control border-0 bg-light rounded-4 p-3" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control border-0 bg-light rounded-4 p-3" readonly required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Deskripsi Singkat</label>
                    <textarea name="description" class="form-control border-0 bg-light rounded-4 p-3" rows="3" placeholder="Ceritakan apa yang spesial dari tempat ini..."></textarea>
                </div>



                <div class="mb-4">
                    <label class="form-label fw-bold small">Foto Lokasi (Maksimal 3 foto)</label>
                    <input type="file" name="photos[]" class="form-control border-0 bg-light rounded-4 p-3" multiple>
                    <small class="text-muted mt-1 d-block">Pilih hingga 3 foto sekaligus. Foto akan di-resize otomatis.</small>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-5">
                    <a href="/" class="text-decoration-none text-muted fw-bold">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm">Kirim untuk Review Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btn-geocode').addEventListener('click', function() {
    const address = document.getElementById('address').value;
    if (!address) {
        alert('Silakan isi alamat terlebih dahulu.');
        return;
    }

    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mencari...';
    this.disabled = true;

    fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(address)}&format=json&limit=1`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                document.getElementById('latitude').value = data[0].lat;
                document.getElementById('longitude').value = data[0].lon;
                alert('Koordinat berhasil ditemukan!');
            } else {
                alert('Alamat tidak ditemukan. Silakan isi alamat lebih detail.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari koordinat.');
        })
        .finally(() => {
            this.innerHTML = '<i class="bi bi-geo-alt-fill me-2"></i>Cari Koordinat';
            this.disabled = false;
        });
});
</script>
<?= $this->endSection() ?>
