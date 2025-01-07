<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">

        <div class="container mt-4">
            <div class="row justify-content-center mt-5">
                <div class="col-lg-5">
                    <?php Flasher::flash(); ?>
                </div>
            </div>
        </div>

        <?php foreach ($data['tabungan'] as $tabungan): ?>
            <div class="col-md-5 mb-4">
                <a href="<?= BASEURL; ?>/tercapai/detail/<?= $tabungan['id']; ?>" class="text-decoration-none">
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



