<!-- MOBILE MENU -->
<div id="mobileMenu" class="mobile-menu" aria-hidden="true">
    <!-- CLOSE BUTTON -->
    <button id="closeMenu" aria-label="Close menu"
        class="absolute top-6 right-6 w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-2xl hover:bg-teal-400 hover:text-black transition">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <a href="#beranda" class="mobile-link">
        <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="#armada" class="mobile-link">
        <i class="fa-solid fa-car-side"></i> Armada
    </a>
    <a href="#layanan" class="mobile-link">
        <i class="fa-solid fa-bell-concierge"></i> Layanan Kami
    </a>
    <a href="#keunggulan" class="mobile-link">
        <i class="fa-solid fa-shield-heart"></i> Keunggulan
    </a>
    <a href="#wilayah" class="mobile-link">
        <i class="fa-solid fa-map-location-dot"></i> Jangkauan Wilayah
    </a>
    <a href="#review" class="mobile-link">
        <i class="fa-solid fa-star"></i> Review
    </a>
    <a href="#kontak" class="mobile-link">
        <i class="fa-solid fa-phone"></i> Kontak
    </a>
</div>

<!-- NAVBAR -->
<header id="navbar" class="fixed top-0 left-0 w-full z-50 glass">
    <div class="max-w-7xl mx-auto px-5 md:px-6 py-4 flex items-center justify-between">
        <!-- LOGO -->
        <a href="#" class="flex items-center gap-3 group">
            <div class="w-14 h-14 flex items-center justify-center group-hover:scale-105 transition duration-300">
                <img src="<?= base_url('assets'); ?>/img/logo/logo.png" alt="Logo Graha Transport"
                    class="w-full h-full object-contain">
            </div>

            <div class="text-2xl md:text-3xl font-extrabold italic tracking-tight">
                <span class="text-white">GRAHA</span><span class="text-teal-400">TRANSPORT</span>
            </div>
        </a>

        <!-- DESKTOP NAV -->
        <nav class="hidden lg:flex items-center gap-8 font-medium text-sm">
            <a href="#beranda" class="hover:text-teal-400 transition">Beranda</a>
            <a href="#armada" class="hover:text-teal-400 transition">Armada</a>
            <a href="#layanan" class="hover:text-teal-400 transition">Layanan</a>
            <a href="#keunggulan" class="hover:text-teal-400 transition">Keunggulan</a>
            <a href="#wilayah" class="hover:text-teal-400 transition">Jangkauan</a>
            <a href="#review" class="hover:text-teal-400 transition">Review</a>
            <a href="#kontak" class="hover:text-teal-400 transition">Kontak</a>
        </nav>

        <!-- ACTIONS -->
        <div class="flex items-center gap-4">
            <a href="https://wa.me/6281327160516" target="_blank" rel="noopener noreferrer"
                class="hidden lg:flex btn-primary px-6 py-3 rounded-xl font-semibold text-black gap-2 items-center">
                <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi Kami
            </a>
            <button id="menuBtn" aria-label="Open menu" class="lg:hidden text-2xl p-2 focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</header>