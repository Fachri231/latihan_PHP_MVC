<?php
class Login extends Controller
{
    public function index()
    {
        if(isset($_SESSION['username'])) {
            Flasher::setFlash('Akses Tolak, ', 'Anda Sudah Login, Harap Logout Terlebih Dahulu', 'danger');
            header('Location: ' . BASEURL . '/home/index');
            exit;
        }
        $data['judul'] = 'Login';
        $this->views('templates/header', $data);
        $this->views('login/index');
        $this->views('templates/footer');
    }


    public function register()
    {
        $data['judul'] = 'Register';
        $this->views('templates/header', $data);
        $this->views('login/register');
        $this->views('templates/footer');
    }

    public function userRegister()
    {
        if (!empty($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($this->models('User_model')->cekUser($username) > 0) {
                Flasher::setFlash('Nama', 'Telah Dipakai', 'danger');
                header('Location:' . BASEURL . '/login/register');
                exit;
            }

            if($password !== $password2) {
                Flasher::setFlash('Password', 'Tidak Sesuai', 'danger');
                header('Location:' . BASEURL . '/login/register');
                exit;
            }

            if($this->models('User_model')->tambahUser($username, $password) > 0) {
                Flasher::setFlash('Register', 'Berhasil, Data Ditambahkan', 'success');
                header('Location:' . BASEURL . '/login/register');
                exit;
            }
        }
    }

    public function userLogin()
    {
        if(!empty($_POST)) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $users = $this->models('User_model')->getUser($username);

            if($users['username'] == $username && $users['password'] == $password) {
                session_start();
                $_SESSION['username'] = $username;
                Flasher::setFlash('Login', 'Berhasil', 'success');
                header('Location:' . BASEURL . '/home/index');
                exit;
            } else {
                Flasher::setFlash('Login', 'Gagal Username Atau Password Salah', 'danger');
                header('Location:' . BASEURL . '/login/index');
                exit;
            }
        }
    }

    public function logout()
    {
        session_start();

        $_SESSION = [];
        session_destroy();

        Flasher::setFlash('Logout', 'Berhasil', 'success'); 
        header('Location:' . BASEURL . '/login/index'); 
        exit;
    }
}
