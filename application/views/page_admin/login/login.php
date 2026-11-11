<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url('assets'); ?>/">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Graha Transport | Login Admin Rental Mobil</title>

    <meta name="description" content="Portal Login Admin CV. Graha Transport - Manajemen Sewa & Armada" />

    <!-- Favicon & PWA -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets'); ?>/img/logo/A.png" />
    <link rel="manifest" href="<?= base_url('site.webmanifest'); ?>" />
    <meta name="theme-color" content="#0f172a" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Icons & Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/css/theme-default.css" />

    <style>
        :root {
            --gt-bg-dark: #091122;
            --gt-navy: #12203b;
            --gt-blue: #1A44B2;
            --gt-blue-bright: #2563eb;
            --gt-teal: #2dd4bf;
            --gt-slate: #94a3b8;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', 'Public Sans', sans-serif;
            background: radial-gradient(circle at 15% 20%, rgba(45, 212, 191, 0.14), transparent 42%),
                        radial-gradient(circle at 85% 80%, rgba(37, 99, 235, 0.24), transparent 45%),
                        linear-gradient(135deg, #070d1b 0%, #0f1c38 55%, #091326 100%);
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated ambient grid */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
            background-size: 46px 46px;
            pointer-events: none;
            z-index: 0;
        }

        .login-shell {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1040px;
            background: rgba(18, 32, 59, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 26px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.52);
            backdrop-filter: blur(18px);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.12fr 0.88fr;
        }

        /* Left Interactive Rental Showcase */
        .showcase-pane {
            padding: 36px 38px;
            background:
                radial-gradient(circle at 50% 58%, rgba(45, 212, 191, 0.16), transparent 60%),
                linear-gradient(160deg, rgba(26, 68, 178, 0.28) 0%, rgba(9, 17, 34, 0.92) 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .showcase-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .brand-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(45, 212, 191, 0.12);
            border: 1px solid rgba(45, 212, 191, 0.3);
            color: #2dd4bf;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .brand-pill .dot-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2dd4bf;
            box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.7);
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.65); }
            70% { box-shadow: 0 0 0 10px rgba(45, 212, 191, 0); }
            100% { box-shadow: 0 0 0 0 rgba(45, 212, 191, 0); }
        }

        .back-home-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #cbd5e1;
            font-size: 12.5px;
            font-weight: 500;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.25s ease;
        }

        .back-home-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(45, 212, 191, 0.4);
        }

        .showcase-headline {
            margin-top: 22px;
        }

        .showcase-headline h1 {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.28;
            margin: 0 0 8px;
            letter-spacing: -0.3px;
        }

        .showcase-headline h1 span {
            color: #2dd4bf;
        }

        .showcase-headline p {
            font-size: 13.5px;
            color: #94a3b8;
            margin: 0;
            line-height: 1.6;
        }

        /* Interactive Car Stage */
        .car-stage {
            position: relative;
            margin: 18px 0 12px;
            padding: 18px 10px 26px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            perspective: 900px;
        }

        .car-glow {
            position: absolute;
            width: 78%;
            height: 75px;
            bottom: 18px;
            background: radial-gradient(ellipse at center, rgba(45, 212, 191, 0.35) 0%, rgba(26, 68, 178, 0.15) 55%, transparent 75%);
            filter: blur(14px);
            border-radius: 50%;
            z-index: 0;
        }

        .road-track {
            position: absolute;
            bottom: 22px;
            width: 88%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(45, 212, 191, 0.55), transparent);
            overflow: hidden;
        }

        .road-track::after {
            content: '';
            position: absolute;
            top: 0;
            left: -40%;
            width: 40%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #2dd4bf, transparent);
            animation: roadSweep 2.6s linear infinite;
        }

        @keyframes roadSweep {
            0% { left: -40%; }
            100% { left: 100%; }
        }

        .car-image-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 205px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
            border-radius: 20px;
            border: 1px solid rgba(45, 212, 191, 0.32);
            padding: 14px 22px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.38), 0 0 26px rgba(45, 212, 191, 0.12);
            transition: transform 0.25s ease-out;
        }

        .car-image-wrap img {
            max-width: 92%;
            max-height: 175px;
            object-fit: contain;
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        .car-image-wrap img.switching {
            opacity: 0;
            transform: translateX(18px) scale(0.97);
        }

        .fleet-pills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-top: 4px;
            position: relative;
            z-index: 2;
        }

        .fleet-pill {
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.12);
            background: rgba(15, 23, 42, 0.65);
            color: #cbd5e1;
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 999px;
            transition: all 0.22s ease;
        }

        .fleet-pill:hover {
            border-color: rgba(45, 212, 191, 0.55);
            color: #fff;
        }

        .fleet-pill.active {
            background: linear-gradient(135deg, #1A44B2, #0ea5e9);
            border-color: rgba(45, 212, 191, 0.65);
            color: #fff;
            box-shadow: 0 4px 14px rgba(14, 165, 233, 0.32);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 16px;
        }

        .feature-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 10px 12px;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .feature-chip:hover {
            transform: translateY(-2px);
            border-color: rgba(45, 212, 191, 0.35);
        }

        .feature-chip i {
            font-size: 18px;
            color: #2dd4bf;
            margin-bottom: 4px;
            display: inline-block;
        }

        .feature-chip .fc-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #f1f5f9;
            display: block;
        }

        .feature-chip .fc-sub {
            font-size: 10.5px;
            color: #94a3b8;
            display: block;
            margin-top: 1px;
        }

        /* Right Form Pane */
        .form-pane {
            background: #ffffff;
            color: #1e293b;
            padding: 40px 38px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .logo-box img {
            height: 86px;
            width: auto;
            object-fit: contain;
        }

        .mobile-home-link {
            display: none;
            font-size: 12px;
            font-weight: 600;
            color: #1A44B2;
            text-decoration: none;
        }

        .form-heading {
            text-align: center;
        }

        .form-heading h2 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 6px;
        }

        .form-heading p {
            font-size: 13.5px;
            color: #64748b;
            margin: 0 0 22px;
        }

        .gt-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.45px;
            color: #475569;
            margin-bottom: 6px;
        }

        .gt-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .gt-input-icon {
            position: absolute;
            left: 14px;
            color: #64748b;
            font-size: 18px;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .gt-input {
            width: 100%;
            height: 46px;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 10px 42px 10px 42px;
            font-size: 14px;
            color: #0f172a;
            background: #f8fafc;
            transition: all 0.2s ease;
            outline: none;
        }

        .gt-input:focus {
            background: #ffffff;
            border-color: #1A44B2;
            box-shadow: 0 0 0 4px rgba(26, 68, 178, 0.12);
        }

        .gt-input-wrap:focus-within .gt-input-icon {
            color: #1A44B2;
        }

        .gt-toggle-pw {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 19px;
            cursor: pointer;
            padding: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .gt-toggle-pw:hover {
            color: #1A44B2;
            background: rgba(26, 68, 178, 0.08);
        }

        .btn-gt-login {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #1A44B2 0%, #0284c7 100%);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.2px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(26, 68, 178, 0.26);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .btn-gt-login:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(26, 68, 178, 0.34);
            filter: brightness(1.05);
        }

        .btn-gt-login:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-gt-login:disabled {
            opacity: 0.85;
            cursor: wait;
        }

        .login-footer-note {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #64748b;
        }

        .help-trigger {
            color: #1A44B2;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .help-trigger:hover {
            text-decoration: underline;
        }

        .alert-modern {
            border-radius: 12px;
            font-size: 13px;
            padding: 11px 14px;
            margin-bottom: 18px;
        }

        @media (max-width: 900px) {
            body {
                padding: 14px;
            }
            .login-shell {
                grid-template-columns: 1fr;
                max-width: 470px;
                border-radius: 22px;
            }
            .showcase-pane {
                padding: 22px 22px 18px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }
            .showcase-headline h1 {
                font-size: 20px;
            }
            .car-stage {
                margin: 10px 0 6px;
                padding: 8px 6px 18px;
            }
            .car-image-wrap {
                height: 130px;
            }
            .car-image-wrap img {
                max-height: 122px;
            }
            .feature-grid {
                display: none;
            }
            .form-pane {
                padding: 28px 24px;
            }
            .back-home-link {
                display: none;
            }
            .mobile-home-link {
                display: inline-flex;
                align-items: center;
                gap: 4px;
            }
        }
    </style>
</head>

<body>
    <div class="login-shell">
        <!-- Left Interactive Rental Showcase -->
        <div class="showcase-pane" id="showcasePane">
            <div>
                <div class="showcase-top">
                    <span class="brand-pill">
                        <span class="dot-pulse"></span>
                        GRAHA TRANSPORT SYSTEM
                    </span>
                    <a href="<?= base_url(); ?>" class="back-home-link">
                        <i class="bx bx-left-arrow-alt"></i> Beranda Website
                    </a>
                </div>

                <div class="showcase-headline">
                    <h1>Kendali Penuh <span>Armada &amp; Sewa</span> Dalam Satu Dashboard</h1>
                    <p>Pantau jadwal sewa harian, cetak kontrak &amp; invoice otomatis, hingga notifikasi unit lewat batas waktu secara realtime.</p>
                </div>
            </div>

            <div class="car-stage">
                <div class="car-glow"></div>
                <div class="road-track"></div>
                <div class="car-image-wrap" id="carTiltWrap">
                    <img id="showcaseCarImg" src="<?= base_url('assets/img/car/zenix.png'); ?>" alt="Armada Graha Transport">
                </div>
                <div class="fleet-pills" id="fleetPills">
                    <button type="button" class="fleet-pill active" data-img="<?= base_url('assets/img/car/zenix.png'); ?>" data-name="Innova Zenix">Innova Zenix</button>
                    <button type="button" class="fleet-pill" data-img="<?= base_url('assets/img/car/fortuner.png'); ?>" data-name="Fortuner">Fortuner</button>
                    <button type="button" class="fleet-pill" data-img="<?= base_url('assets/img/car/alphard.png'); ?>" data-name="Alphard">Alphard</button>
                    <button type="button" class="fleet-pill" data-img="<?= base_url('assets/img/car/avanza.png'); ?>" data-name="Avanza">Avanza</button>
                </div>
            </div>

            <div class="feature-grid">
                <div class="feature-chip">
                    <i class="bx bx-receipt"></i>
                    <span class="fc-title">Invoice &amp; Laporan</span>
                    <span class="fc-sub">Laba unit garasi &amp; luar</span>
                </div>
                <div class="feature-chip">
                    <i class="bx bx-file"></i>
                    <span class="fc-title">Kontrak Digital</span>
                    <span class="fc-sub">Multi-unit &amp; cetak PDF</span>
                </div>
                <div class="feature-chip">
                    <i class="bx bx-bell"></i>
                    <span class="fc-title">Alert Realtime HP</span>
                    <span class="fc-sub">Pantau batas 06.00 WIB</span>
                </div>
            </div>
        </div>

        <!-- Right Login Form -->
        <div class="form-pane">
            <div class="logo-box">
                <a href="<?= site_url('Auth'); ?>">
                    <img src="<?= base_url('assets/img/logo/logo.png'); ?>" alt="Logo Graha Transport" />
                </a>
                <a href="<?= base_url(); ?>" class="mobile-home-link">
                    <i class="bx bx-home-alt"></i> Beranda
                </a>
            </div>

            <div class="form-heading">
                <h2>Masuk Panel Admin</h2>
                <p>Silakan masukkan akun operasional atau administrator Anda.</p>
            </div>

            <!-- Flash Success -->
            <?php if ($this->session->flashdata('sukses')): ?>
            <div class="alert alert-success alert-modern d-flex align-items-center gap-2" role="alert">
                <i class="bx bx-check-circle fs-5"></i>
                <div><?= $this->session->flashdata('sukses'); ?></div>
            </div>
            <?php endif; ?>

            <!-- Flash Error / Validation -->
            <?php if (validation_errors() || $this->session->flashdata('result_login') || $this->session->flashdata('Habis')): ?>
            <div class="alert alert-danger alert-dismissible fade show alert-modern" role="alert">
                <div class="d-flex align-items-start gap-2">
                    <i class="bx bx-error-circle fs-5 mt-1"></i>
                    <div>
                        <strong>Login Gagal!</strong>
                        <?= validation_errors(); ?>
                        <?= $this->session->flashdata('result_login'); ?>
                        <?= $this->session->flashdata('Habis'); ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form id="formAuthentication" action="<?= site_url('Auth/login') ?>" method="POST">
                <div class="mb-3">
                    <label for="username" class="gt-label d-block">Username / Email</label>
                    <div class="gt-input-wrap">
                        <i class="bx bx-user gt-input-icon"></i>
                        <input type="text" class="gt-input" id="username" name="username"
                            placeholder="Contoh: admin_oprational" autocomplete="username" autofocus required />
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="gt-label mb-0" for="password">Password</label>
                        <a href="javascript:void(0);" class="help-trigger small" data-bs-toggle="modal" data-bs-target="#modal-lupa-password">Lupa Password?</a>
                    </div>
                    <div class="gt-input-wrap">
                        <i class="bx bx-lock-alt gt-input-icon"></i>
                        <input type="password" id="password" class="gt-input" name="password"
                            placeholder="Masukkan password Anda" autocomplete="current-password" required />
                        <button type="button" id="togglePasswordBtn" class="gt-toggle-pw" aria-label="Tampilkan atau sembunyikan password" title="Lihat Password">
                            <i class="bx bx-hide" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <button id="signInBtn" class="btn-gt-login" type="submit">
                    <i class="bx bx-log-in-circle fs-5"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <div class="login-footer-note">
                <span>&copy; <?= date('Y'); ?> CV. Graha Transport</span>
                <span>Kab. Semarang &bull; Rental System</span>
            </div>
        </div>
    </div>

    <!-- Modal Info Lupa Password -->
    <div class="modal fade" id="modal-lupa-password" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold"><i class="bx bx-key text-primary me-1"></i> Reset Password Admin</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body small">
                    Untuk keamanan akun operasional, silakan hubungi <b>Owner / Administrator Utama</b> CV. Graha Transport untuk reset password melalui menu <b>Kelola Admin</b>.
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets'); ?>/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/js/bootstrap.js"></script>
    <script>
        (function() {
            // 1. Toggle show/hide password
            const pwInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            if (toggleBtn && pwInput && toggleIcon) {
                toggleBtn.addEventListener('click', function() {
                    const isHidden = pwInput.type === 'password';
                    pwInput.type = isHidden ? 'text' : 'password';
                    toggleIcon.className = isHidden ? 'bx bx-show' : 'bx bx-hide';
                });
            }

            // 2. Interactive Fleet Showcase Switcher & Auto Carousel
            const carImg = document.getElementById('showcaseCarImg');
            const pills = Array.prototype.slice.call(document.querySelectorAll('.fleet-pill'));
            let currentIdx = 0;
            let autoTimer = null;

            function switchCar(idx) {
                if (!carImg || pills.length === 0) return;
                currentIdx = idx % pills.length;
                const pill = pills[currentIdx];
                const src = pill.getAttribute('data-img');
                const name = pill.getAttribute('data-name');

                pills.forEach(function(p) { p.classList.remove('active'); });
                pill.classList.add('active');

                carImg.classList.add('switching');
                setTimeout(function() {
                    carImg.src = src;
                    carImg.alt = name + ' - Graha Transport';
                    carImg.classList.remove('switching');
                }, 180);
            }

            pills.forEach(function(pill, idx) {
                pill.addEventListener('click', function() {
                    switchCar(idx);
                    if (autoTimer) {
                        clearInterval(autoTimer);
                        autoTimer = setInterval(function() { switchCar(currentIdx + 1); }, 4500);
                    }
                });
            });

            if (pills.length > 1) {
                autoTimer = setInterval(function() { switchCar(currentIdx + 1); }, 4500);
            }

            // 3. Subtle 3D mouse tilt on desktop showcase
            const pane = document.getElementById('showcasePane');
            const tiltWrap = document.getElementById('carTiltWrap');
            if (pane && tiltWrap && window.matchMedia('(pointer: fine)').matches) {
                pane.addEventListener('mousemove', function(e) {
                    const rect = pane.getBoundingClientRect();
                    const x = ((e.clientX - rect.left) / rect.width) - 0.5;
                    const y = ((e.clientY - rect.top) / rect.height) - 0.5;
                    tiltWrap.style.transform = 'rotateY(' + (x * 10).toFixed(2) + 'deg) rotateX(' + (-y * 6).toFixed(2) + 'deg) translateY(' + (-y * 4).toFixed(2) + 'px)';
                });
                pane.addEventListener('mouseleave', function() {
                    tiltWrap.style.transform = 'rotateY(0deg) rotateX(0deg) translateY(0px)';
                });
            }

            // 4. Submit loading feedback
            const form = document.getElementById('formAuthentication');
            const signInBtn = document.getElementById('signInBtn');
            if (form && signInBtn) {
                form.addEventListener('submit', function() {
                    signInBtn.disabled = true;
                    signInBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span>Memproses Login...</span>';
                });
            }
        })();
    </script>
</body>

</html>
