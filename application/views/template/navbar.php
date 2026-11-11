<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <?php
            $ci_nav =& get_instance();
            if (!isset($ci_nav->Sewa_model)) {
                $ci_nav->load->model('Sewa_model');
            }
            $ci_nav->load->helper('rental');
            $nav_overdue_items = $ci_nav->Sewa_model->get_overdue();
            $nav_overdue_count = count($nav_overdue_items);
            ?>
            <!-- Realtime Notification Bell -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3">
                <a id="nav-notif-dropdown-toggle" class="nav-link dropdown-toggle hide-arrow position-relative" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" title="Unit Perlu Ditindaklanjuti">
                    <i class="bx bx-bell bx-sm"></i>
                    <span id="nav-notif-badge" class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle <?= $nav_overdue_count === 0 ? 'd-none' : ''; ?>" style="font-size:10px; padding:3px 5px;"><?= $nav_overdue_count; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 320px; max-width: 360px;">
                    <li class="dropdown-header d-flex justify-content-between align-items-center py-2 px-3 bg-light border-bottom">
                        <span class="fw-bold text-dark small">Unit Perlu Ditindaklanjuti</span>
                        <span id="nav-notif-header-count" class="badge bg-label-danger"><?= $nav_overdue_count; ?></span>
                    </li>
                    <li>
                        <div id="nav-notif-list" style="max-height: 280px; overflow-y: auto;">
                            <?php if ($nav_overdue_count === 0) : ?>
                            <div class="p-3 text-center text-muted small">Tidak ada unit melewati batas sewa.</div>
                            <?php else : ?>
                            <?php foreach ($nav_overdue_items as $ov) : ?>
                            <a href="<?= site_url('Sewa_mobil'); ?>" class="dropdown-item border-bottom py-2 px-3" style="white-space:normal;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong class="small text-danger"><?= htmlspecialchars($ov->nama_user); ?></strong>
                                    <?php if (!empty($ov->in_grace_period)) : ?>
                                    <span class="badge bg-warning text-dark ms-1">Toleransi 06:00</span>
                                    <?php else : ?>
                                    <span class="badge bg-danger ms-1">+<?= (int) $ov->hari_terlambat; ?> hr</span>
                                    <?php endif; ?>
                                </div>
                                <div class="small text-dark"><?= htmlspecialchars($ov->tipe_unit); ?> (<?= htmlspecialchars($ov->plat_nomor); ?>)</div>
                                <div class="small text-muted">Selesai: <?= format_tanggal_id($ov->tanggal_selesai); ?> &bull; Tagihan: <?= format_rupiah($ov->tagihan_berjalan); ?></div>
                            </a>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                    <li class="border-top p-2 d-flex justify-content-between bg-light">
                        <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-xs btn-primary">Kelola Sewa</a>
                        <a href="<?= site_url('Notifikasi'); ?>" class="btn btn-xs btn-outline-secondary">Atur Notifikasi HP</a>
                    </li>
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="<?= base_url('assets/img'); ?>/admin/<?= $userdata->foto_profil; ?>" alt
                            class="w-px-40 h-auto rounded-circle shadow-lg" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="<?= base_url('assets/img'); ?>/admin/<?= $userdata->foto_profil; ?>"
                                            alt class="w-px-40 h-auto rounded-circle shadow-lg" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?= $userdata->nama_agent; ?></span>
                                    <small class="text-muted"><?= $userdata->position; ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo site_url('Auth/logout'); ?>">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<!-- / Navbar -->
