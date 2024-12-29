<?php
if (session_status() == PHP_SESSION_NONE) session_start();
class Home extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['username'])) {
            Flasher::setFlash('Akses', 'Ditolak, Harap Login Terlebih Dahulu', 'danger');
            header('Location: ' . BASEURL . '/login/index');
            exit;
        }
        $data['judul'] = 'Tabunganku';
        $data['tabungan'] = $this->models('Tabungan_model')->getTabunganByStatus('belum_tercapai');
        $this->views('templates/header', $data);
        $this->views('home/index', $data);
        $this->views('templates/footer');
    }

    public function detail($id)
    {
        if(!isset($_SESSION['username'])) {
            Flasher::setFlash('Akses', 'Ditolak, Harap Login Terlebih Dahulu', 'danger');
            header('Location: ' . BASEURL . '/login/index');
            exit;
        }
        $data['judul'] = 'Detail Tabungan';
        $data['tabungan'] = $this->models('Tabungan_model')->getTabunganById($id);
        $data['riwayat_pengisian'] = $this->models('Tabungan_model')->getAllRiwayatTabunganById($id);
        $data['modal'] = ($data['tabungan']['status_tabungan'] === 'tercapai');
        $this->views('templates/header', $data);
        $this->views('home/detail', $data);
        $this->views('templates/footer');
    }

    public function tambah()
    {
        if (isset($_POST['action'])) {
            $id_tabungan = $_POST['id_tabungan'];
            $aksi = $_POST['action'];
            $nominal = (int)$_POST['nominal'];
            $keterangan = $_POST['keterangan']; //opsional

            if ($nominal <= 0) {
                Flasher::setFlash('Nominal Harus Lebih Dari 0!', 'gagal', 'danger');
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            }

            $tabungan = $this->models('Tabungan_model')->getTabunganById($id_tabungan);

            if ($aksi == 'tambah') {
                $duitTerkumpul = $tabungan['duit_terkumpul'] + $nominal;
            } elseif ($aksi == 'kurang') {
                $duitTerkumpul = $tabungan['duit_terkumpul'] - $nominal;
            }

            if ($duitTerkumpul < 0) {
                Flasher::setFlash('Saldo Tidak Cukup!', 'Gagal', 'danger');
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            }

            // Tambahkan parameter nominal dan aksi
            if ($this->models('Tabungan_model')->updateTabungan($duitTerkumpul, $keterangan, $id_tabungan, $nominal, $aksi) > 0) {
                Flasher::setFlash('Berhasil', 'Ditambah', 'success');
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            }
        } else {
            // Ini untuk menambah tabungan baru
            $data = [
                'nama_tabungan' => $_POST['nama_tabungan'],
                'target_tabungan' => $_POST['target_tabungan'],
                'nominal_pengisian' => $_POST['nominal_pengisian'],
                'gambar' => 'default.jpeg'
            ];

            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
                $data['gambar'] = $this->upload($_FILES['gambar']);
            }

            if ($this->models('Tabungan_model')->tambahTabungan($data) > 0) {
                Flasher::setFlash('Berhasil', 'Ditambahkan', 'success');
                header('Location: ' . BASEURL . '/home');
                exit;
            } else {
                Flasher::setFlash('Gagal', 'Ditambahkan', 'danger');
                header('Location: ' . BASEURL . '/home');
                exit;
            }
        }
    }

    public function upload($gambar)
    {
        $namaFile = $gambar['name'];
        $ukuranFile = $gambar['size'];
        $error = $gambar['error'];
        $tmpName = $gambar['tmp_name'];

        if ($error === 4) {
            return 'default.jpeg';
        }

        $tipeFile = $gambar['type'];
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if (!in_array($tipeFile, $allowedTypes)) {
            return 'default.jpeg';
        }

        if ($ukuranFile > 2000000) {
            return 'default.jpeg';
        }

        $ekstensiFile = pathinfo($namaFile, PATHINFO_EXTENSION);
        $namaFileBaru = uniqid() . '.' . $ekstensiFile;

        $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/tabunganku/public/img/';

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $destination = $uploadPath . $namaFileBaru;

        try {
            if (move_uploaded_file($tmpName, $destination)) {
                return $namaFileBaru;
            } else {
                error_log("Upload failed. Error: " . print_r(error_get_last(), true));
                return 'default.jpeg';
            }
        } catch (Exception $e) {
            error_log("Exception during upload: " . $e->getMessage());
            return 'default.jpeg';
        }
    }

    public function ubahRiwayat()
    {
        if (isset($_POST['action'])) {
            $id = $_POST['id'];
            $id_tabungan = $_POST['id_tabungan'];
            $aksi = $_POST['action'];
            $nominal = (int)$_POST['nominal'];
            $keterangan = $_POST['keterangan'];

            if ($nominal <= 0) {
                Flasher::setFlash('Nominal Harus Lebih Dari 0!', 'gagal', 'danger');
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            }

            $tabungan = $this->models('Tabungan_model')->getTabunganById($id_tabungan);
            $riwayatLama = $this->models('Tabungan_model')->getRiwayatTabunganById($id);

            // Kembalikan saldo ke posisi sebelum riwayat yang akan diubah
            $duitTerkumpul = $tabungan['duit_terkumpul'] - $riwayatLama['nominal'];

            // Tambahkan nominal baru sesuai aksi
            if ($aksi == 'tambah') {
                $duitTerkumpul += $nominal;
            } elseif ($aksi == 'kurang') {
                $duitTerkumpul -= $nominal;
            }

            if ($duitTerkumpul < 0) {
                Flasher::setFlash('Saldo Tidak Cukup!', 'Gagal', 'danger');
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            }

            try {
                $result = $this->models('Tabungan_model')->ubahRiwayat($id, $id_tabungan, $duitTerkumpul, $nominal, $keterangan, $aksi);
                if ($result > 0) {
                    Flasher::setFlash('Berhasil', 'Diupdate', 'success');
                } else {
                    Flasher::setFlash('Error: Tidak ada baris yang diperbarui.', 'gagal', 'danger');
                }
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            } catch (Exception $e) {
                Flasher::setFlash('Error: ' . $e->getMessage(), 'gagal', 'danger');
                header('Location: ' . BASEURL . '/home/detail/' . $id_tabungan);
                exit;
            }
        }
    }

    public function hapusRiwayat()
    {
        $id = $_POST['id'];
        $idTabungan = $_POST['id_tabungan'];

        $riwayatTabungan = $this->models('Tabungan_model')->getRiwayatTabunganById($id);

        if ($tabungan = $this->models('Tabungan_model')->getTabunganById($idTabungan)) {
            $duitTerkumpul = $tabungan['duit_terkumpul'] - $riwayatTabungan['nominal'];
        }

        if ($this->models('Tabungan_model')->hapusRiwayat($id, $duitTerkumpul, $idTabungan) > 0) {
            Flasher::setFlash('Berhasil', 'Dihapus', 'success');
            header('Location: ' . BASEURL . '/home/detail/' . $idTabungan);
            exit;
        } else {
            Flasher::setFlash('Gagal', 'Dihapus', 'success');
            header('Location: ' . BASEURL . '/home/detail/' . $idTabungan);
            exit;
        }
    }

    public function cekStatusTabungan($id_tabungan)
    {
        // Dapatkan data tabungan berdasarkan ID
        $tabungan = $this->models('Tabungan_model')->getTabunganById($id_tabungan);

        // Tentukan status berdasarkan target yang tercapai
        if ($tabungan['duit_terkumpul'] >= $tabungan['target_tabungan']) {
            $this->models('Tabungan_model')->ubahStatus($id_tabungan, 'tercapai');
            header('Location: ' . BASEURL . '/home/index/' . $id_tabungan);
            exit;
        } else {
            $this->models('Tabungan_model')->ubahStatus($id_tabungan, 'belum_tercapai');
            header('Location: ' . BASEURL . '/home/index/' . $id_tabungan);
            exit;
        }
    }
}
