<?php
namespace App\Models;

use App\Core\Database;
use Exception;

class User_model
{
    private $tabel = 'user';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUser($username)
    {
        $query = "SELECT * FROM {$this->tabel} WHERE username = :username";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->execute();

        return $this->db->single();
    }

    public function cekUser($username)
    {
        $query = "SELECT * FROM {$this->tabel} WHERE username = :username";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahUser($username, $password)
    {
        $query = "INSERT INTO {$this->tabel} (username, password) VALUES (:username, :password)";
        
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $password);
        $this->db->execute();

        return $this->db->rowCount();
    }
}