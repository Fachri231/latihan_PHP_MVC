<div class="container">
    <div class="row justify-content-center align-items-center"">
        <!-- Tombol Tambah Uang -->
        <div class="row justify-content-center">
            <div class="col-auto">
                <button type="button" class="btn btn-primary tombolTambahData mt-5" data-bs-toggle="modal" data-bs-target="#formModalTambah">
                    Tambah Uang
                </button>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-lg-5">
                <?php Flasher::flash(); ?>
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

<!-- Modal tambah -->
<div class="modal fade" id="formModalTambah" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Catatan Tabungan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/home/tambah" method="post" enctype="multipart/form-data">
                    <div class="container text-center mb-3">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_tabungan" id="id_tabungan" value="<?= $data['tabungan']['id']; ?>">

                        <div class="btn-group" role="group" aria-label="Tambah atau Kurang">
                            <input type="radio" class="btn-check" name="action" id="tambahAdd" value="tambah" autocomplete="off" checked>
                            <label class="btn btn-success" for="tambahAdd"><i class='bx bx-plus'></i> Tambah</label>

                            <input type="radio" class="btn-check" name="action" id="kurangAdd" value="kurang" autocomplete="off">
                            <label class="btn btn-danger" for="kurangAdd"><i class='bx bx-minus'></i> Kurang</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Masukkan nominal">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal -->

<!-- Modal ubah -->
<div class="modal fade" id="formModalUbah" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Catatan Tabungan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL ?>/home/ubahRiwayat" method="post" enctype="multipart/form-data">
                    <div class="container text-center mb-3">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_tabungan" id="id_tabungan" value="<?= $data['tabungan']['id']; ?>">

                        <div class="btn-group" role="group" aria-label="Tambah atau Kurang">
                            <input type="radio" class="btn-check" name="action" id="tambahEdit" value="tambah" autocomplete="off" checked>
                            <label class="btn btn-success" for="tambahEdit"><i class='bx bx-plus'></i> Tambah</label>

                            <input type="radio" class="btn-check" name="action" id="kurangEdit" value="kurang" autocomplete="off">
                            <label class="btn btn-danger" for="kurangEdit"><i class='bx bx-minus'></i> Kurang</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Masukkan nominal">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Edit/Hapus untuk setiap riwayat -->
<?php foreach ($data['riwayat_pengisian'] as $riwayat): ?>
    <div class="modal fade" id="editModal-<?= $riwayat['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Riwayat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6>Nominal:</h6>
                        <p class="fs-5">
                            <?php if ($riwayat['nominal'] > 0): ?>
                                <span class="text-success">+ Rp<?= number_format($riwayat['nominal'], 0, ',', '.'); ?></span>
                            <?php else: ?>
                                <span class="text-danger">- Rp<?= number_format(abs($riwayat['nominal']), 0, ',', '.'); ?></span>
                            <?php endif; ?>
                        </p>

                        <?php if (!empty($riwayat['keterangan'])): ?>
                            <h6>Keterangan:</h6>
                            <p><?= $riwayat['keterangan']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#formModalUbah"
                            data-id="<?= $riwayat['id']; ?>"
                            data-nominal="<?= $riwayat['nominal']; ?>"
                            data-keterangan="<?= htmlspecialchars($riwayat['keterangan'], ENT_QUOTES, 'UTF-8'); ?>">
                            <i class='bx bx-edit'></i> Ubah
                        </button>
                        <form action="<?= BASEURL; ?>/home/hapusRiwayat" method="post">
                            <input type="hidden" name="id" value="<?= $riwayat['id']; ?>">
                            <input type="hidden" name="id_tabungan" value="<?= $riwayat['id_tabungan']; ?>">
                            <button class="btn btn-danger" name="hapus" onclick="return confirm('Yakin ingin menghapus riwayat ini?');">
                                <i class='bx bx-trash'></i> Hapus
                            </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Modal -->

<!-- Modal Tabungan Tercapai -->
<?php if (!empty($data['modal'])): ?>
    <div class="container  p-5">
        <div class="row">
            <div class="col-12 text-center">
                <div class="modal fade" id="modalTercapai" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center p-lg-4">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                    <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                                    <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                                </svg>
                                <h4 class="text-success mt-3">Horee!!</h4>
                                <p class="mt-3">Tabungan Anda Sudah Penuh</p>
                                <button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal" onclick="redirectToHome()">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--Model ends-->