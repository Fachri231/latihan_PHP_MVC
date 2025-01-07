<div class="row justify-content-center mt-4">
            <div class="col-lg-5">
                <?php Flasher::flash(); ?>
            </div>
        </div>

<div class="d-flex justify-content-center align-items-center mt-5">
    <div class="register-container ">
        <h2>Daftar</h2>
        <form action="<?= BASEURL ?>/login/userRegister" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username Anda" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password Anda" required>
            </div>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password2" class="form-control" id="confirm-password" placeholder="Konfirmasi password Anda" required>
            </div>
            <button type="submit" class="btn btn-register">Daftar</button>
        </form>
        <p class="login-link">Sudah punya akun? <a href="<?= BASEURL ?>/login/index">Login di sini</a></p>
    </div>
</div>