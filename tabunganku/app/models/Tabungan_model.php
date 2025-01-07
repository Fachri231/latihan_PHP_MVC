<?php
class Tabungan_model
{
    private $tabel = 'tabunganku';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getAllTabungan()
    {
        $this->db->query("SELECT * FROM {$this->tabel}");
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getTabunganById($id)
    {
        $this->db->query("SELECT * FROM {$this->tabel} WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->single();
    }

    public function getAllRiwayatTabunganById($id)
    {
        $this->db->query("SELECT * FROM riwayat_tabungan WHERE id_tabungan = :id ORDER BY tanggal DESC");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getRiwayatTabunganById($id)
    {
        $this->db->query("SELECT * FROM riwayat_tabungan WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function tambahTabungan($data)
    {
        $query = "INSERT INTO tabunganku 
                (nama_tabungan, target_tabungan, nominal_pengisian, gambar, duit_terkumpul, status_tabungan) 
                VALUES 
                (:nama_tabungan, :target_tabungan, :nominal_pengisian, :gambar, 0, 'belum_tercapai')";

        $this->db->query($query);

        $this->db->bind(':nama_tabungan', $data['nama_tabungan']);
        $this->db->bind(':target_tabungan', $data['target_tabungan']);
        $this->db->bind(':nominal_pengisian', $data['nominal_pengisian']);
        $this->db->bind(':gambar', $data['gambar']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateTabungan($duitTerkumpul, $keterangan, $id, $nominal, $aksi)
    {
        try {
            // Update saldo tabungan
            $this->db->query("UPDATE {$this->tabel} SET duit_terkumpul = :duitTerkumpul, terakhir_diubah = NOW() WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->bind(':duitTerkumpul', $duitTerkumpul);
            $this->db->execute();

            // Insert ke riwayat
            $query = "INSERT INTO riwayat_tabungan (id_tabungan, nominal, keterangan, tanggal) VALUES (:id_tabungan, :nominal, :keterangan, NOW())";
            $this->db->query($query);
            $this->db->bind(':id_tabungan', $id);
            // Jika aksi 'kurang', nominal dijadikan negatif
            $nominalRiwayat = ($aksi == 'kurang') ? -$nominal : $nominal;
            $this->db->bind(':nominal', $nominalRiwayat);
            $this->db->bind(':keterangan', $keterangan);
            $this->db->execute();

            $tabungan = $this->getTabunganById($id);
            if ($tabungan['duit_terkumpul'] >= $tabungan['target_tabungan']) {
                $this->ubahStatus($id, 'tercapai');
            } else {
                $this->ubahStatus($id, 'belum_tercapai');
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function hapusRiwayat($id_riwayat, $duitTerkumpul, $id_tabungan)
    {
        try {
            // Sebelum dihapus, update duit terkumpul
            $query = "UPDATE {$this->tabel} SET duit_terkumpul = :duitTerkumpul, terakhir_diubah = NOW() WHERE id = :id_tabungan";
            $this->db->query($query);
            $this->db->bind(':duitTerkumpul', $duitTerkumpul);
            $this->db->bind(':id_tabungan', $id_tabungan);
            $this->db->execute();

            // Hapus riwayat tabungan
            $query = "DELETE FROM riwayat_tabungan WHERE id = :id_riwayat";
            $this->db->query($query);
            $this->db->bind(':id_riwayat', $id_riwayat);
            $this->db->execute();

            return $this->db->rowCount();
        } catch (Exception $e) {
            return false;
        }
    }

    public function ubahRiwayat($id_riwayat, $id_tabungan, $duitTerkumpul, $nominal, $keterangan, $aksi)
    {
        try {
            // Update tabungan
            $query = "UPDATE {$this->tabel} SET duit_terkumpul = :duitTerkumpul, terakhir_diubah = NOW() WHERE id = :id_tabungan";
            $this->db->query($query);
            $this->db->bind(':duitTerkumpul', $duitTerkumpul);
            $this->db->bind(':id_tabungan', $id_tabungan);
            $this->db->execute();

            // Hitung nominal berdasarkan aksi
            $nominalRiwayat = ($aksi == 'kurang') ? -$nominal : $nominal;

            // Update riwayat
            $query = "UPDATE riwayat_tabungan SET 
        id_tabungan = :id_tabungan,
        nominal = :nominal, 
        keterangan = :keterangan,
        tanggal = NOW()
        WHERE id = :id";

            $this->db->query($query);
            $this->db->bind(':id_tabungan', $id_tabungan);
            $this->db->bind(':nominal', $nominalRiwayat);
            $this->db->bind(':keterangan', $keterangan);
            $this->db->bind(':id', $id_riwayat);

            $this->db->execute();

            // Log hasil eksekusi query
            $rowCount = $this->db->rowCount();

            return $rowCount;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function ubahStatus($id_tabungan, $status)
    {
        try {
            $query = "UPDATE {$this->tabel} SET status_tabungan = :status_tabungan WHERE id = :id_tabungan";
            $this->db->query($query);
            $this->db->bind(':status_tabungan', $status);
            $this->db->bind(':id_tabungan', $id_tabungan);

            $this->db->execute();

            // Log hasil eksekusi query
            $rowCount = $this->db->rowCount();

            return $rowCount;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function getTabunganByStatus($status)
    {
        $query = "SELECT * FROM {$this->tabel} WHERE status_tabungan = :status_tabungan";

        $this->db->query($query);
        $this->db->bind(':status_tabungan', $status);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function hapusTabunganById($id)
    {
        $this->hapusRiwayatByTabunganId($id);

        $query = "DELETE FROM {$this->tabel} WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusRiwayatByTabunganId($id_tabungan)
    {
        $query = "DELETE FROM riwayat_tabungan WHERE id_tabungan = :id_tabungan";
        $this->db->query($query);
        $this->db->bind(':id_tabungan', $id_tabungan);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
