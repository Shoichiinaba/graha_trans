<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="<?php echo site_url('Dashboard'); ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?= base_url('assets'); ?>/img/logo/logo.png" />
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

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_unit') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_unit'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-car"></i>
                <div data-i18n="Analytics">Kelola Unit</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_banner') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_banner'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bx-landscape'></i>
                <div data-i18n="Analytics">Kelola Banner</div>
            </a>
        </li>

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Berita') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Berita'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-news'></i>
                <div data-i18n="Analytics">Kelola Article</div>
            </a>
        </li>

        <!-- <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_video') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_video'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-video-recording"></i>
                <div data-i18n="Analytics">Kelola Videos</div>
            </a>
        </li> -->

        <li class="menu-item <?php echo ($this->uri->segment(1) == 'Kelola_user') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Kelola_user'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Analytics">Kelola Admin</div>
            </a>
        </li>
        <!-- <li class="menu-item <?php echo ($this->uri->segment(1) == 'Api_keys') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('Api_keys'); ?>" class="menu-link">
                <i class='menu-icon tf-icons bx bx-key'></i>
                <div data-i18n="Analytics">Buat API Key</div>
            </a>
        </li> -->
    </ul>

</aside>
<!-- / Menu -->