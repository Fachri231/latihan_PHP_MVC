<div class="container fade-in">
    <div class="row justify-content-center align-items-center">
        <!-- Tombol Tambah Tabungan -->
        <div class="row justify-content-center">
            <div class="col-auto">
                <button type="button" class="btn btn-primary tombolTambahData mt-5" data-bs-toggle="modal" data-bs-target="#formModal">
                    Tambah Tabungan
                </button>
            </div>
        </div>

        <!-- Flash Message -->
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <?php Flasher::flash(); ?>
            </div>
        </div>

        <!-- Daftar Tabungan -->
        <?php foreach ($data['tabungan'] as $tabungan): ?>
            <div class="col-md-5 mb-4 mt-4">
                <a href="<?= BASEURL; ?>/home/detail/<?= $tabungan['id']; ?>" class="text-decoration-none">
                    <div class="card">
                        <div class="ratio ratio-16x9">
                            <img src="<?= BASEURL; ?>/img/<?= $tabungan['gambar']; ?>" class="card-img-top img-fluid" alt="Advan Work+">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $tabungan['nama_tabungan']; ?></h5>
                            <p class="card-harga">Rp<?= number_format($tabungan['target_tabungan'], 0, ',', '.'); ?></p>
                            <hr>
                            <p class="card-tabungan text-center">Rp<?= number_format($tabungan['nominal_pengisian'], 0, ',', '.'); ?> per-hari</p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Tambah Data Tabungan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL; ?>/home/tambah" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="nama-tabungan" class="form-label">Nama Tabungan</label>
                        <input type="text" class="form-control" id="nama_tabungan" name="nama_tabungan">
                    </div>
                    <div class="mb-3">
                        <label for="target-tabungan" class="form-label">Target Tabungan</label>
                        <input type="number" class="form-control" id="target_tabungan" name="target_tabungan">
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal Pengisian</label>
                        <input type="number" class="form-control" id="nominal_pengisian" name="nominal_pengisian">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="liveAlertBtn">Tambah Tabungan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->