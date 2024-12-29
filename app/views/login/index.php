<div class="row justify-content-center mt-4">
            <div class="col-lg-5">
                <?php Flasher::flash(); ?>
            </div>                                  
        </div>

<div class="d-flex justify-content-center align-items-center mt-5">
    <div class="login-container">
        <h2 class="text-center mb-4">Login</h2>
        <form action="<?= BASEURL ?>/login/userLogin" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="username" name="username" class="form-control" id="username" placeholder="Masukkan Username Anda" required autocomplete="off" autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password Anda" required autocomplete="off">
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="<?= BASEURL ?>/login/register">Daftar di sini</a></p>
    </div>
</div>