<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Graha Transport | Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo/A.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <script src="assets/vendor/js/helpers.js"></script>
    <style>
    .btn-primary {
        background: linear-gradient(to right, #163D88, #129BCD);
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #A30500, #CD1299);
        border: none;
        color: white;
    }
    </style>
</head>

<body>
    <!-- / Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="<?php echo site_url('Auth'); ?>" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <img src="<?= base_url('assets'); ?>/img/logo/logo.png" />
                                </span>
                            </a>
                        </div>

                        <!-- Flash Message -->
                        <?php if ($this->session->flashdata('sukses')): ?>
                        <div class="alert alert-success">
                            <?= $this->session->flashdata('sukses'); ?>
                        </div>
                        <?php endif; ?>
                        <!-- akhir alert -->
                        <!-- Form -->
                        <form id="formAuthentication" class="mb-3" action="<?= site_url('Auth/login') ?>" method="POST">
                            <!-- Alert -->
                            <?php
                                 if (validation_errors() || $this->session->flashdata('result_login')) {
                            ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span class="alert-icon"><i class="fa fa-warning"></i></span>
                                <strong>Warning!</strong>
                                <?php echo validation_errors(); ?>
                                <?php echo $this->session->flashdata('result_login'); ?>
                                <?php echo $this->session->flashdata('Habis'); ?>
                            </div>
                            <?php } ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Email atau Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Masukkan email atau username" autofocus required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="auth-forgot-password-basic.html">
                                        <small>Lupa Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button id="signInBtn" class="btn btn-primary d-grid w-100 rounded-3" type="submit">
                                    Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>



    <script>
    document.getElementById("formAuthentication").addEventListener("submit", function(event) {
        var signInBtn = document.getElementById("signInBtn");

        // Menonaktifkan tombol dan menampilkan loading
        signInBtn.disabled = true;
        signInBtn.innerHTML = `
        <span class="d-flex justify-content-center align-items-center">
            Processing...
            <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
        </span>
    `;
    });
    </script>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>


</body>

</html>