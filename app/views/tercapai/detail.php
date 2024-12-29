<div class="container">
    <div class="row justify-content-center align-items-center">
        <!-- Tombol Hapus Tabungan -->
        <div class="row justify-content-center">
            <div class="col-auto">
                <form action="<?= BASEURL ?>/tercapai/hapusTabungan/<?= $data['tabungan']['id']; ?>" method="post">
                    <button type="submit" class="btn btn-danger mt-5" onclick="return confirm('Yakin ingin menghapus tabungan ini?');">Hapus Tabungan</button>
                </form>
            </div>
        </div>



        <!-- Card Tabungan -->
        <div class="col-md-6 mt-4">
            <div class="card shadow-sm border-0">
                <div class="ratio ratio-16x9">
                    <img src="<?= BASEURL; ?>/img/<?= $data['tabungan']['gambar']; ?>" class="card-img-top img-fluid rounded-top" alt="Tabungan Image">
                </div>

                <div class="card-body">
                    <h5 class="card-title text-primary"><?= $data['tabungan']['nama_tabungan']; ?></h5>
                    <p class="card-harga fs-5">Rp<?= number_format($data['tabungan']['target_tabungan'], 0, ',', '.'); ?></p>
                    <hr>
                    <div class="row text-center mb-3">
                        <div class="col-6 text-success">
                            <h6>Terkumpul</h6>
                            <p>Rp<?= number_format($data['tabungan']['duit_terkumpul'], 0, ',', '.'); ?></p>
                        </div>
                        <div class="col-6 text-danger">
                            <h6>Kekurangan</h6>
                            <p>Rp<?= number_format($data['tabungan']['target_tabungan'] - $data['tabungan']['duit_terkumpul'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                    <hr>
                    <!-- Riwayat Pengisian -->
                    <div>
                        <h6 class="text-center">Riwayat</h6>
                        <ul class="list-group">
                            <?php foreach ($data['riwayat_pengisian'] as $riwayat): ?>
                                <li class="list-group-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editModal-<?= $riwayat['id']; ?>">
                                    <div class="d-flex justify-content-between">
                                        <span><?= date('d M Y • H:i', strtotime($riwayat['tanggal'])); ?></span>
                                        <?php if ($riwayat['nominal'] > 0): ?>
                                            <span class="text-success">+ Rp<?= number_format($riwayat['nominal'], 0, ',', '.'); ?></span>
                                        <?php else: ?>
                                            <span class="text-danger">- Rp<?= number_format(abs($riwayat['nominal']), 0, ',', '.'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <small class="text-muted d-block mt-1"><?= $riwayat['keterangan']; ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

