<!-- Menu -->
<?php
$user_position = isset($userdata->position) ? strtolower(trim($userdata->position)) : '';
$is_operational = ($user_position === 'admin_oprational');
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" style="padding-left: 1.25rem; padding-right: 1rem;">
        <a href="<?php echo site_url('Dashboard'); ?>" class="app-brand-link d-flex align-items-center gap-2 text-decoration-none">
            <span class="app-brand-logo demo flex-shrink-0">
                <img src="<?= base_url('assets'); ?>/img/logo/logo.png" alt="Logo Graha Transport" style="width: 44px; height: 44px; object-fit: contain;" />
            </span>
            <span class="fw-bolder" style="font-size: 1.05rem; color: #1A44B2; letter-spacing: -0.2px; line-height: 1.15; white-space: nowrap;">
                Graha Transport
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Dashboard') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Dashboard'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Operasional Rental</span>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Sewa_mobil') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Sewa_mobil'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Sewa Mobil">Manajemen Sewa</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kontrak') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kontrak'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Kontrak Sewa">Kontrak Sewa</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_unit') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_unit'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-car"></i>
                <div data-i18n="Kelola Unit">Kelola Unit</div>
            </a>
        </li>

        <?php
        $ci_sb =& get_instance();
        if (!isset($ci_sb->Sewa_model)) {
            $ci_sb->load->model('Sewa_model');
        }
        $ci_sb->load->helper('rental');
        $sb_overdue_count = count($ci_sb->Sewa_model->get_overdue());
        ?>
        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Notifikasi') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Notifikasi'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div data-i18n="Notifikasi HP">Notifikasi HP</div>
                <span id="sidebar-overdue-badge" class="badge rounded-pill bg-danger ms-auto <?= $sb_overdue_count === 0 ? 'd-none' : ''; ?>"><?= $sb_overdue_count; ?></span>
            </a>
        </li>

        <?php if (!$is_operational) : ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Konten &amp; Sistem</span>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_banner') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_banner'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bx-landscape'></i>
                <div data-i18n="Kelola Banner">Kelola Banner</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Berita') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Berita'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-news'></i>
                <div data-i18n="Kelola Article">Kelola Article</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_user') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_user'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Kelola Admin">Kelola Admin</div>
            </a>
        </li>
        <?php endif; ?>
    </ul>

</aside>
<!-- / Menu -->
