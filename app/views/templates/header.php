<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman <?= $data['judul']; ?></title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css'>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/modal.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/login.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/home.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/register.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid"> <a class="navbar-brand me-auto" href="<?= BASEURL ?>/home/index"> TabunganKu </a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5> <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item"> <a class="nav-link mx-lg-2" href="<?= BASEURL ?>/home/index">Berlangsung</a> </li>
                        <li class="nav-item"> <a class="nav-link mx-lg-2" href="<?= BASEURL ?>/tercapai/index">Tercapai</a> </li>
                    </ul>
                </div>
            </div> 
            <a href="<?= BASEURL ?>/login/logout" class="logout-button">Logout</a> 
            <a href="<?= BASEURL ?>/login/index" class="login-button">Login</a>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- navbar active -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const currentUrl = window.location.href;

            navLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>