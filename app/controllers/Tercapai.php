<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Flasher;


if (session_status() == PHP_SESSION_NONE) session_start();
class Tercapai extends Controller
{
    public function index()
    {
        if(!isset($_SESSION['username'])) {
            Flasher::setFlash('Akses', 'Ditolak, Harap Login Terlebih Dahulu', 'danger');
            header('Location: ' . BASEURL . '/login/index');
            exit;
        }
        $data['judul'] = 'Tabungan Tercapai';
        $data['tabungan'] = $this->models('Tabungan_model')->getTabunganByStatus('tercapai');
        $this->views('templates/header', $data);
        $this->views('tercapai/index', $data);
        $this->views('templates/footer1');
    }

    public function detail($id)
    {
        if(!isset($_SESSION['username'])) {
            Flasher::setFlash('Akses', 'Ditolak, Harap Login Terlebih Dahulu', 'danger');
            header('Location: ' . BASEURL . '/login/index');
            exit;
        }
        $data['judul'] = 'Detail Tabungan Tercapai';
        $data['tabungan'] = $this->models('Tabungan_model')->getTabunganById($id);
        $data['riwayat_pengisian'] = $this->models('Tabungan_model')->getAllRiwayatTabunganById($id);
        $this->views('templates/header', $data);
        $this->views('tercapai/detail', $data);
        $this->views('templates/footer1');
    }

    public function hapusTabungan($id)
    {
        if ($this->models('Tabungan_model')->hapusTabunganById($id) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success');
            header('Location: ' . BASEURL . '/home/index');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger');
            header('Location: ' . BASEURL . '/home/index');
            exit;
        }
    }
}
