<style>
    /*=========================
  Skeleton Loader
==========================*/

    @keyframes shimmer {
        0% {
            background-position: -700px 0;
        }

        100% {
            background-position: 700px 0;
        }
    }

    .skeleton {
        background: linear-gradient(90deg,
                rgba(255, 255, 255, .05) 25%,
                rgba(255, 255, 255, .12) 50%,
                rgba(255, 255, 255, .05) 75%);
        background-size: 800px 100%;
        animation: shimmer 1.5s infinite linear;
        border-radius: 12px;
    }

    .skeleton-card {
        background: #1b2740;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 30px;
        overflow: hidden;
    }

    .skeleton-image {
        width: 100%;
        height: 220px;
    }

    .skeleton-title {
        height: 28px;
        width: 60%;
        margin-bottom: 18px;
    }

    .skeleton-price {
        height: 24px;
        width: 45%;
        margin-bottom: 25px;
    }

    .skeleton-line {
        height: 1px;
        width: 100%;
        background: rgba(255, 255, 255, .08);
        margin: 18px 0;
    }

    .skeleton-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        margin: auto;
    }

    .skeleton-text {
        width: 55px;
        height: 12px;
        margin: 10px auto 0;
    }

    .skeleton-button {
        width: 100%;
        height: 48px;
        border-radius: 14px;
    }

    .post_data {
        padding: 16px;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        margin-bottom: 24px;
        background-color: #fff;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }

    /* ============================
ARTICLE CARD
============================ */

    .article-card {

        background: #1b2740;

        border: 1px solid rgba(255, 255, 255, .08);

        border-radius: 30px;

        overflow: hidden;

        transition: .4s;

        position: relative;

    }

    .article-card:hover {

        transform: translateY(-10px);

        border-color: #2dd4bf;

        box-shadow: 0 0 35px rgba(45, 212, 191, .18);

    }

    .article-image {

        height: 250px;

        overflow: hidden;

    }

    .article-image img {

        width: 100%;

        height: 100%;

        object-fit: cover;

        transition: .8s;

    }

    .article-card:hover img {

        transform: scale(1.1);

    }

    .article-content {

        padding: 25px;

    }

    .article-title {

        font-size: 22px;

        font-weight: 700;

        color: #fff;

        line-height: 1.4;

        margin-bottom: 15px;

    }

    .article-meta {

        display: flex;

        justify-content: space-between;

        color: #94a3b8;

        font-size: 14px;

        margin-bottom: 15px;

    }

    .article-desc {

        color: #94a3b8;

        line-height: 1.8;

        margin-bottom: 20px;

    }

    .article-tags {

        margin-bottom: 20px;

    }

    .article-tags span {

        display: inline-block;

        background: rgba(45, 212, 191, .15);

        color: #2dd4bf;

        padding: 6px 14px;

        border-radius: 30px;

        margin-right: 8px;

        margin-bottom: 8px;

        font-size: 12px;

    }

    .article-btn {

        display: inline-flex;

        align-items: center;

        gap: 10px;

        color: #2dd4bf;

        font-weight: bold;

        transition: .3s;

    }

    .article-btn:hover {

        gap: 16px;

    }

    /*======================================
ARTICLE SKELETON
======================================*/

    .article-skeleton {

        background: #1b2740;

        border-radius: 30px;

        overflow: hidden;

        border: 1px solid rgba(255, 255, 255, .08);

    }

    .article-skeleton-img {

        width: 100%;

        height: 250px;

        background: linear-gradient(90deg,
                rgba(255, 255, 255, .05) 25%,
                rgba(255, 255, 255, .12) 37%,
                rgba(255, 255, 255, .05) 63%);

        background-size: 400% 100%;

        animation: skeleton-loading 1.4s infinite;

    }

    .article-skeleton-body {

        padding: 25px;

    }

    .article-line {

        height: 12px;

        border-radius: 30px;

        margin-bottom: 15px;

        background: linear-gradient(90deg,
                rgba(255, 255, 255, .05) 25%,
                rgba(255, 255, 255, .12) 37%,
                rgba(255, 255, 255, .05) 63%);

        background-size: 400% 100%;

        animation: skeleton-loading 1.4s infinite;

    }

    .article-line.title {

        height: 22px;

        width: 90%;

    }

    .article-line.short {

        width: 40%;

    }

    .article-line.medium {

        width: 70%;

    }

    .article-line.full {

        width: 100%;

    }

    @keyframes skeleton-loading {

        0% {

            background-position: 100% 0;

        }

        100% {

            background-position: -100% 0;

        }

    }

    /* ==========================
   CLIENT
========================== */

    .client-slider {
        overflow: hidden;
        position: relative;
        padding: 20px 0;
        mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 8%, black 92%, transparent);
    }

    .client-track {
        display: flex;
        align-items: center;
        gap: 32px;
        width: max-content;
        animation: clientScroll 32s linear infinite;
        will-change: transform;
    }

    .client-item {
        width: 210px;
        height: 110px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, rgba(20, 32, 54, 0.85) 0%, rgba(10, 18, 32, 0.95) 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 22px;
        padding: 22px 28px;
        backdrop-filter: blur(12px);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.5);
    }

    .client-item:hover {
        transform: translateY(-7px) scale(1.03);
        border-color: rgba(45, 212, 191, 0.5);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.7), 0 0 25px rgba(45, 212, 191, 0.25);
    }

    .client-bg-vector {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.25;
        transition: all 0.4s ease;
    }

    .client-item:hover .client-bg-vector {
        opacity: 0.65;
        transform: scale(1.05);
    }

    .circuit-ring {
        transform-origin: 80px 45px;
    }

    .client-item:hover .circuit-ring {
        animation: wheelSpin 7s linear infinite;
    }

    .client-shimmer-sweep {
        position: absolute;
        top: -50%;
        left: -120%;
        width: 60%;
        height: 200%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), rgba(45, 212, 191, 0.15), transparent);
        transform: rotate(25deg);
        pointer-events: none;
        z-index: 5;
        transition: left 0.8s ease;
    }

    .client-item:hover .client-shimmer-sweep {
        left: 180%;
    }

    .client-item img {
        max-width: 100%;
        max-height: 65px;
        object-fit: contain;
        filter: brightness(0) invert(1) opacity(0.85);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .client-item:hover img {
        filter: none;
        opacity: 1;
        transform: scale(1.06);
    }

    @keyframes clientScroll {

        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }

    }

    .client-slider:hover .client-track {
        animation-play-state: paused;
    }

    /* ==========================
   MOBILE
========================== */

    @media (max-width:768px) {

        .client-slider {
            width: 100%;
            overflow: hidden;
        }

        .client-track {

            /* Matikan animasi desktop */
            animation: none;

            gap: 0;

            width: 100%;

            transition: transform .5s ease;

        }

        .client-item {

            min-width: 100%;
            width: 100%;
            flex: 0 0 100%;

            margin: 0;

            padding: 25px;

        }

        .client-item img {
            max-height: 80px;
        }

        .promo-title {
            font-size: 28px;
            line-height: 1.2;
            transition: font-size 0.2s ease;
        }

        .promo-desc {
            font-size: 22px;
            line-height: 1.6;
            transition: font-size 0.2s ease;
        }

    }

    .eyebrow-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 9999px;
        background: rgba(45, 212, 191, 0.1);
        border: 1px solid rgba(45, 212, 191, 0.28);
        color: #5eead4;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .client-slider::before,
    .client-slider::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        width: 80px;
        z-index: 5;
        pointer-events: none;
    }

    .client-slider::before {
        left: 0;
        background: linear-gradient(to right, #0F172A, transparent);
    }

    .client-slider::after {
        right: 0;
        background: linear-gradient(to left, #0F172A, transparent);
    }

    .segment-pill {
        transition: all 0.25s ease;
    }

    .segment-pill:hover {
        border-color: #2dd4bf;
        color: #5eead4;
        background: rgba(45, 212, 191, 0.1);
        transform: translateY(-1px);
    }
</style>

<!-- HERO SECTION -->
<section id="beranda" class="hero-bg min-h-screen flex items-center pt-24 pb-16 relative overflow-hidden">
    <!-- Ambient Luxury Glowing Orbs & Automotive Light Cones -->
    <div class="absolute top-10 -left-20 w-[500px] h-[500px] bg-teal-500/15 blur-[140px] rounded-full pointer-events-none"></div>
    <div class="absolute top-1/3 left-1/4 w-[350px] h-[350px] bg-amber-500/10 blur-[130px] rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-10 right-0 w-[600px] h-[600px] bg-cyan-500/15 blur-[150px] rounded-full pointer-events-none"></div>

    <!-- Background Automotive Light Streaks -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
        <div class="speed-beam speed-beam-teal" style="top: 18%; opacity: 0.5;"></div>
        <div class="speed-beam speed-beam-cyan" style="top: 78%; opacity: 0.4;"></div>
        <div class="speed-beam speed-beam-amber" style="top: 48%; opacity: 0.45;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 md:px-8 py-8 grid lg:grid-cols-12 gap-12 lg:gap-14 items-center relative z-10">

        <!-- TEXT CONTENT (KOLOM KIRI) -->
        <div class="lg:col-span-7" data-aos="fade-right">
            <!-- Eyebrow Pill -->
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-slate-900/85 border border-teal-500/35 text-teal-300 text-xs font-semibold backdrop-blur-md shadow-lg shadow-teal-950/40 mb-6 group hover:border-teal-400/60 transition">
                <span class="w-6 h-6 rounded-full bg-amber-400/15 border border-amber-400/30 flex items-center justify-center text-amber-400 text-[11px] shadow-sm">
                    <i class="fa-solid fa-crown"></i>
                </span>
                <span class="tracking-wider uppercase text-[11px] font-bold text-slate-200">
                    Rental Mobil Eksklusif • Ungaran & Semarang
                </span>
                <span class="relative flex h-2 w-2 ml-1">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
            </div>

            <!-- Main Headline -->
            <h1 class="hero-title text-4xl sm:text-5xl md:text-6xl xl:text-[68px] font-black leading-[1.08] tracking-tight text-white">
                Kenyamanan Berkelas <br />
                <span class="bg-gradient-to-r from-teal-300 via-teal-400 to-cyan-200 bg-clip-text text-transparent drop-shadow-[0_4px_30px_rgba(45,212,191,0.35)]">
                    Perjalanan Tanpa Kompromi
                </span>
            </h1>

            <!-- Description -->
            <p class="text-slate-300 text-base md:text-lg mt-6 leading-relaxed max-w-xl font-normal">
                Graha Transport menyediakan armada modern pilihan keluaran terbaru—bersih steril, wangi, dan selalu dalam kondisi prima prima untuk keperluan dinas VIP, kunjungan kerja, wisata keluarga, maupun operasional korporasi.
            </p>

            <!-- Key Feature Badges -->
            <div class="flex flex-wrap gap-2.5 sm:gap-3 mt-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/[0.04] border border-white/10 text-xs text-slate-300 font-medium backdrop-blur-sm hover:border-teal-400/40 hover:text-white transition">
                    <i class="fa-solid fa-shield-halved text-teal-400"></i> Asuransi All-Risk & Terawat
                </div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/[0.04] border border-white/10 text-xs text-slate-300 font-medium backdrop-blur-sm hover:border-teal-400/40 hover:text-white transition">
                    <i class="fa-solid fa-user-tie text-teal-400"></i> Driver Ramah & Berpengalaman
                </div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/[0.04] border border-white/10 text-xs text-slate-300 font-medium backdrop-blur-sm hover:border-teal-400/40 hover:text-white transition">
                    <i class="fa-solid fa-bolt text-amber-400"></i> Booking Cepat & Fleksibel
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-4 mt-8">
                <a href="#armada"
                    class="luxury-shimmer-btn px-8 py-4 rounded-2xl font-black text-slate-950 flex items-center gap-2.5 shadow-xl shadow-teal-500/30 hover:shadow-teal-400/50 hover:scale-102 transition group">
                    <span>Lihat Pilihan Armada</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1.5 transition-transform duration-300"></i>
                </a>
                <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20ingin%20konsultasi%20dan%20cek%20ketersediaan%20unit%20mobil."
                    target="_blank" rel="noopener noreferrer"
                    class="border border-white/20 bg-slate-900/70 hover:bg-white/10 hover:border-teal-400/80 transition px-7 py-4 rounded-2xl font-bold text-white backdrop-blur-md flex items-center gap-3 shadow-lg group">
                    <div class="w-8 h-8 rounded-xl bg-[#25D366] text-white flex items-center justify-center text-base shadow group-hover:scale-110 transition-transform">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <span>Konsultasi Cepat (Gratis)</span>
                </a>
            </div>

            <!-- QUICK TRUST STATS -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 sm:gap-4 mt-9 pt-8 border-t border-white/10">
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-teal-400/40 hover:bg-white/[0.06] transition duration-300 group">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="text-2xl font-black text-white group-hover:text-teal-300 transition">13+</div>
                        <i class="fa-solid fa-car text-teal-400/70 text-sm group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div class="text-xs text-slate-400 font-medium">Pilihan Armada</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-teal-400/40 hover:bg-white/[0.06] transition duration-300 group">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="text-2xl font-black text-teal-400">24/7</div>
                        <i class="fa-solid fa-clock text-teal-400/70 text-sm group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div class="text-xs text-slate-400 font-medium">Layanan & Support</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-amber-400/40 hover:bg-white/[0.06] transition duration-300 group">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="text-2xl font-black text-amber-300 flex items-center gap-1">4.9 <i class="fa-solid fa-star text-xs text-amber-400"></i></div>
                        <i class="fa-brands fa-google text-amber-400/70 text-sm group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div class="text-xs text-slate-400 font-medium">Rating Google</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/10 hover:border-emerald-400/40 hover:bg-white/[0.06] transition duration-300 group">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="text-2xl font-black text-emerald-400">100%</div>
                        <i class="fa-solid fa-sparkles text-emerald-400/70 text-sm group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div class="text-xs text-slate-400 font-medium">Unit Bersih & Prima</div>
                </div>
            </div>
        </div>

        <!-- HERO SLIDER (KOLOM KANAN) -->
        <div class="lg:col-span-5 relative" data-aos="fade-left" data-aos-delay="200">
            
            <!-- Outer Glow Aurora Backdrop -->
            <div class="absolute -inset-4 bg-gradient-to-r from-teal-500/20 via-cyan-500/15 to-transparent rounded-[44px] blur-2xl -z-10 pointer-events-none"></div>

            <!-- Top Floating Review Badge -->
            <div class="hidden sm:flex items-center gap-2.5 absolute -top-4 -left-4 bg-[#0c182b]/95 border border-amber-400/35 rounded-2xl px-4 py-2.5 shadow-2xl backdrop-blur-md z-30">
                <div class="w-7 h-7 rounded-lg bg-amber-400/20 text-amber-300 flex items-center justify-center text-xs shadow-inner">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div class="text-left">
                    <div class="text-[11px] font-extrabold text-white flex items-center gap-1">
                        4.9 / 5.0 Rating
                        <i class="fa-solid fa-circle-check text-teal-400 text-[10px]"></i>
                    </div>
                    <div class="text-[10px] text-slate-400">150+ Ulasan Puas</div>
                </div>
            </div>

            <!-- Slider Container with Luxury Frame -->
            <div class="p-3 rounded-[36px] bg-gradient-to-b from-white/10 via-white/5 to-transparent border border-teal-500/30 backdrop-blur-xl shadow-2xl relative">
                <div class="hero-slider rounded-[26px] overflow-hidden relative shadow-inner">
                    
                    <!-- Manual Navigation Arrows -->
                    <button id="heroPrev" aria-label="Slide Sebelumnya"
                        class="absolute left-3.5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-950/70 hover:bg-teal-400 hover:text-black border border-white/20 text-white flex items-center justify-center transition-all duration-300 backdrop-blur-md opacity-80 hover:opacity-100 hover:scale-110 shadow-lg">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button id="heroNext" aria-label="Slide Selanjutnya"
                        class="absolute right-3.5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-950/70 hover:bg-teal-400 hover:text-black border border-white/20 text-white flex items-center justify-center transition-all duration-300 backdrop-blur-md opacity-80 hover:opacity-100 hover:scale-110 shadow-lg">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>

                    <div id="heroTrack" class="hero-track">

                        <?php if ($banner->num_rows() > 0) {
                            foreach ($banner->result() as $key => $row) {
                        ?>

                                <img src="<?= base_url('assets/img/baner_slider/' . $row->foto_banner); ?>"
                                    alt="Banner Graha Transport <?= $key + 1; ?>"
                                    <?= $key === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>

                        <?php
                            }
                        } ?>

                    </div>
                    <div class="overlay"></div>
                    <div class="dots">

                        <?php
                        if ($banner->num_rows() > 0) {
                            foreach ($banner->result() as $key => $row) {
                        ?>

                                <button type="button" class="dot <?= $key === 0 ? 'active' : ''; ?>"
                                    aria-label="Tampilkan Slide <?= $key + 1; ?>">
                                </button>

                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

            <!-- FLOATING STATUS BADGE WITH PULSING INDICATOR -->
            <div class="hidden sm:flex items-center gap-3.5 absolute -bottom-5 left-6 bg-[#0c182b]/95 border border-teal-400/40 rounded-2xl px-5 py-3.5 shadow-2xl backdrop-blur-md car-floating z-30">
                <div class="w-10 h-10 rounded-xl bg-teal-400/20 border border-teal-400/30 flex items-center justify-center text-teal-300 shrink-0">
                    <i class="fa-solid fa-car-side text-xl"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <div class="text-xs font-bold text-white tracking-wide">Siap Antar-Jemput 24 Jam</div>
                    </div>
                    <div class="text-[11px] text-slate-300 font-medium">Ungaran • Semarang • Bandara & Luar Kota</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================= -->
<!-- PROMO BANNER -->
<!-- ========================================= -->
<section class="py-14 bg-[#07111f] relative overflow-hidden">

    <!-- Ambient Luxury Glow -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-teal-500/15 blur-[140px] rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/10 blur-[140px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">

        <div class="relative overflow-hidden rounded-[36px]
            border border-teal-500/25
            bg-gradient-to-r
            from-[#0c182c]
            via-[#11233f]
            to-[#0a1527]
            shadow-2xl">

            <!-- Background Luxury Laser Beams & Glows -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-35">
                <div class="speed-beam speed-beam-teal" style="top: 18%; opacity: 0.6;"></div>
                <div class="speed-beam speed-beam-cyan" style="top: 75%; opacity: 0.45;"></div>
                <div class="speed-beam speed-beam-amber" style="top: 45%; opacity: 0.45;"></div>
            </div>

            <!-- Background Luxury Radial Circles -->
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full border border-teal-400/30"></div>
                <div class="absolute -right-10 -top-10 w-96 h-96 rounded-full border border-teal-400/20"></div>
                <div class="absolute -left-20 -bottom-20 w-72 h-72 rounded-full border border-amber-400/20"></div>
            </div>

            <!-- Slider Navigation Buttons -->
            <?php if ($promo->num_rows() > 1) { ?>
                <button type="button" id="promoPrev" class="promo-nav-btn promo-nav-prev" aria-label="Promo Sebelumnya">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button type="button" id="promoNext" class="promo-nav-btn promo-nav-next" aria-label="Promo Berikutnya">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            <?php } ?>

            <!-- PROMO TRACK -->
            <div class="promo-slider">
                <div id="promoTrack" class="promo-track">
                    <?php foreach ($promo->result() as $row) { ?>
                        <div class="promo-slide">

                            <!-- KIRI: KONTEN TEKS & PROMO TAG -->
                            <div class="promo-content">
                                
                                <!-- Label Promo & Badge Diskusi (Tanpa Persentase Diskon) -->
                                <div class="flex flex-wrap items-center gap-3 mb-6">
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-500/25 via-orange-500/15 to-transparent border border-amber-400/40 text-amber-200 text-xs font-bold uppercase tracking-wider backdrop-blur-md shadow-md">
                                        <i class="fa-solid fa-gift text-amber-300"></i>
                                        <?= !empty($row->tagline) ? htmlspecialchars($row->tagline, ENT_QUOTES, 'UTF-8') : 'Penawaran Spesial'; ?>
                                    </span>
                                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/15 border border-teal-400/35 text-teal-300 text-xs font-semibold backdrop-blur-md">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                                        </span>
                                        <i class="fa-solid fa-comments text-teal-300 text-[11px]"></i>
                                        Nego Terbaik by Diskusi
                                    </span>
                                </div>

                                <h2 class="promo-title text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight leading-[1.15]">
                                    <?= htmlspecialchars($row->judul_promo, ENT_QUOTES, 'UTF-8'); ?>
                                </h2>

                                <p class="promo-desc text-slate-300 text-sm sm:text-base leading-relaxed mt-4">
                                    <?= htmlspecialchars($row->ket_promo, ENT_QUOTES, 'UTF-8'); ?>
                                </p>

                                <!-- Visualisasi Fitur & Keunggulan -->
                                <div class="flex flex-wrap gap-2.5 mt-6">
                                    <span class="inline-flex items-center gap-2 text-xs text-slate-300 bg-white/[0.04] border border-white/10 px-3.5 py-1.5 rounded-xl backdrop-blur-sm hover:border-teal-400/40 hover:text-white transition">
                                        <i class="fa-solid fa-handshake-angle text-teal-400"></i> Nego Fleksibel via WA
                                    </span>
                                    <span class="inline-flex items-center gap-2 text-xs text-slate-300 bg-white/[0.04] border border-white/10 px-3.5 py-1.5 rounded-xl backdrop-blur-sm hover:border-teal-400/40 hover:text-white transition">
                                        <i class="fa-solid fa-car-side text-teal-400"></i> Bebas Pilih Armada
                                    </span>
                                    <span class="inline-flex items-center gap-2 text-xs text-slate-300 bg-white/[0.04] border border-white/10 px-3.5 py-1.5 rounded-xl backdrop-blur-sm hover:border-teal-400/40 hover:text-white transition">
                                        <i class="fa-solid fa-clock-rotate-left text-amber-400"></i> Respon Cepat 24 Jam
                                    </span>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex flex-wrap gap-4 mt-8 items-center">
                                    <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20tertarik%20dengan%20promo%20<?= rawurlencode($row->judul_promo); ?>.%20Boleh%20diskusi%20untuk%20penawaran%20harga%20terbaik%20dan%20ketersediaan%20unitnya%3F"
                                        target="_blank" rel="noopener noreferrer"
                                        class="luxury-shimmer-btn px-8 py-4 rounded-2xl font-black text-slate-950 flex items-center gap-3 shadow-xl shadow-teal-500/25 hover:shadow-teal-400/40 hover:scale-102 transition group">
                                        <div class="w-7 h-7 rounded-lg bg-[#25D366] text-white flex items-center justify-center text-sm shadow group-hover:scale-110 transition-transform">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </div>
                                        <span>Klaim & Diskusi Promo</span>
                                    </a>

                                    <a href="#armada"
                                        class="px-7 py-4 rounded-2xl border border-white/20 bg-slate-900/60 hover:bg-white/10 hover:border-teal-400 transition font-bold text-white text-sm backdrop-blur-md flex items-center gap-2 group">
                                        <span>Pilih Unit Mobil</span>
                                        <i class="fa-solid fa-arrow-right text-xs text-teal-400 group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- KANAN: SHOWCASE MOBIL PROMO DENGAN GLOW & BADGE -->
                            <div class="promo-image relative">
                                <!-- Ambient Glow di Belakang Mobil -->
                                <div class="absolute inset-0 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-amber-500/15 rounded-[36px] blur-2xl -z-10 pointer-events-none scale-105"></div>
                                
                                <div class="promo-image-box">
                                    <img src="<?= base_url('assets/img/baner_promo/' . $row->foto_banner); ?>"
                                        alt="<?= htmlspecialchars($row->judul_promo, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                                    
                                    <!-- Badge Kesiapan Unit -->
                                    <div class="absolute bottom-4 right-4 z-20 px-3.5 py-1.5 rounded-xl bg-slate-950/85 border border-teal-400/40 text-teal-300 text-xs font-bold backdrop-blur-md shadow-xl flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                        <span>Unit Siap Jalan</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>

        <!-- DOTS -->
        <div class="promo-dots flex justify-center gap-2.5 mt-6">
            <?php
            $i = 0;
            foreach ($promo->result() as $row) {
            ?>
                <button type="button" class="promo-dot <?= $i == 0 ? 'active' : ''; ?>"
                    aria-label="Tampilkan Promo <?= $i + 1; ?>"></button>
            <?php
                $i++;
            }
            ?>
        </div>

    </div>
</section>

<!-- ARMADA SECTION -->
<section id="armada" class="py-20 relative">
    <div class="max-w-[1700px] mx-auto px-5 md:px-8">
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-car-rear"></i> Katalog Armada
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white">
                Armada <span class="text-teal-400">Terbaik Kami</span>
            </h2>
            <p class="text-slate-400 mt-4 text-base md:text-lg max-w-2xl mx-auto">
                Pilihan kendaraan modern dan terawat untuk memastikan setiap perjalanan Anda terasa nyaman, aman, dan berkesan.
            </p>

            <!-- QUICK SEGMENT NAVIGATION -->
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                <a href="#segmen-unggulan" class="segment-pill px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-sm font-semibold text-slate-200">
                    <i class="fa-solid fa-briefcase text-teal-400 mr-1.5"></i> Perjalanan Dinas
                </a>
                <a href="#segmen-favorit" class="segment-pill px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-sm font-semibold text-slate-200">
                    <i class="fa-solid fa-fire text-orange-400 mr-1.5"></i> Teman Main Favorit
                </a>
                <a href="#segmen-keluarga" class="segment-pill px-5 py-2.5 rounded-full bg-white/5 border border-white/10 text-sm font-semibold text-slate-200">
                    <i class="fa-solid fa-people-roof text-purple-400 mr-1.5"></i> Pilihan Keluarga
                </a>
            </div>
        </div>

        <!-- SEGMENT 1: PERJALANAN DINAS TERJAMIN -->
        <div id="segmen-unggulan" class="mb-14 scroll-mt-24">

            <div class="mb-8 border-b border-white/10 pb-4 flex flex-col sm:flex-row sm:items-end justify-between gap-2" data-aos="fade-right">
                <div>
                    <span class="text-[11px] font-bold tracking-widest uppercase text-teal-400 pl-5">Executive & Corporate</span>
                    <h3 class="text-2xl font-bold text-white border-l-4 border-teal-400 pl-4 mt-1">
                        PERJALANAN DINAS TERJAMIN
                    </h3>
                    <p class="text-slate-400 mt-2 pl-5 text-sm md:text-base">
                        Rasa Kuat dan Terpercaya untuk perjalanan dan kegiatan anda.
                    </p>
                </div>
            </div>

            <!-- DATA -->
            <div id="load_data_unggulan" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            </div>

            <!-- Skeleton -->
            <div id="load_data_message_unggulan"></div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-2 mb-2">

                <div
                    class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2 backdrop-blur-md">

                    <i class="fa-solid fa-car-side text-teal-400"></i>

                    <span class="text-slate-300">
                        Total Unit
                    </span>

                    <span id="badge_unggulan"
                        class="custom-badge bg-teal-400 text-black font-bold rounded-full px-3 py-1 text-sm">
                        0
                    </span>

                </div>

                <ul id="pagination_unggulan" class="pagination flex items-center gap-2">
                </ul>

            </div>

        </div>

        <!-- SEGMENT 2: FAVORIT TEMAN MAIN -->
        <div id="segmen-favorit" class="mb-14 mt-7 scroll-mt-24">

            <div class="mb-8 border-b border-white/10 pb-4" data-aos="fade-right">
                <span class="text-[11px] font-bold tracking-widest uppercase text-orange-400 pl-5">City & Lifestyle</span>
                <h3 class="text-2xl font-bold text-white border-l-4 border-orange-400 pl-4 mt-1">
                    TEMAN MAIN FAVORIT
                </h3>

                <p class="text-slate-400 mt-2 pl-5 text-sm md:text-base">
                    Armada setia anter kamu kemana aja. Anti panas anti lemas!
                </p>

            </div>

            <div id="load_data_favorit" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            </div>

            <div id="load_data_message_favorit"></div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-2 mb-2">

                <div
                    class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2 backdrop-blur-md">

                    <i class="fa-solid fa-car-side text-teal-400"></i>

                    <span class="text-slate-300">
                        Total Unit
                    </span>

                    <span id="badge_favorit"
                        class="custom-badge bg-teal-400 text-black font-bold rounded-full px-3 py-1 text-sm">
                        0
                    </span>

                </div>

                <ul id="pagination_favorit" class="pagination flex items-center gap-2">
                </ul>

            </div>

        </div>

        <!-- SEGMENT 3: PILIHAN TERBAIK KELUARGA -->
        <div id="segmen-keluarga" class="mb-0 mt-7 scroll-mt-24">

            <div class="mb-8 border-b border-white/10 pb-4" data-aos="fade-right">
                <span class="text-[11px] font-bold tracking-widest uppercase text-purple-400 pl-5">Family & Tour</span>
                <h3 class="text-2xl font-bold text-white border-l-4 border-purple-400 pl-4 mt-1">
                    PILIHAN TERBAIK KELUARGA
                </h3>

                <p class="text-slate-400 mt-2 pl-5 text-sm md:text-base">
                    Siap tampung keluarga, masih sisa angkut tetangga!
                </p>

            </div>

            <div id="load_data_keluarga" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            </div>

            <div id="load_data_message_keluarga"></div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-2 mb-2">

                <div
                    class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2 backdrop-blur-md">

                    <i class="fa-solid fa-car-side text-teal-400"></i>

                    <span class="text-slate-300">
                        Total Unit
                    </span>

                    <span id="badge_keluarga"
                        class="custom-badge bg-teal-400 text-black font-bold rounded-full px-3 py-1 text-sm">
                        0
                    </span>

                </div>

                <ul id="pagination_keluarga" class="pagination flex items-center gap-2">
                </ul>

            </div>

        </div>

    </div>
</section>

<!-- ========================================= -->
<!-- LAYANAN SEWA MOBIL KAMI -->
<!-- ========================================= -->
<section id="layanan" class="py-24 bg-[#0a1424] relative overflow-hidden">
    <!-- Ambient Glow -->
    <div class="absolute top-1/2 -left-20 w-80 h-80 bg-teal-500/10 blur-[130px] rounded-full pointer-events-none"></div>
    <div class="absolute top-1/2 -right-20 w-80 h-80 bg-cyan-500/10 blur-[130px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16" data-aos="fade-up">
            <div>
                <div class="eyebrow-badge mb-3">
                    <i class="fa-solid fa-bell-concierge text-teal-300"></i> Layanan Sewa Mobil Kami
                </div>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight">
                    Solusi Transportasi <span class="bg-gradient-to-r from-teal-300 to-cyan-300 bg-clip-text text-transparent">Lengkap & Fleksibel</span>
                </h2>
            </div>
            <p class="text-slate-400 max-w-md text-sm md:text-base leading-relaxed">
                Kami menyediakan ragam opsi penyewaan armada yang dirancang presisi untuk kebutuhan personal, dinas instansi, hingga kontrak korporasi.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">

            <!-- Layanan 1: Sewa Mobil Jangka Panjang (Visual: Sedan Eksekutif / Kalender Kontrak) -->
            <div class="service-card rounded-[30px] overflow-hidden bg-gradient-to-b from-[#16243c] to-[#0f192b] border border-white/10 hover:border-teal-400/60 p-8 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                <!-- SVG Animated Visualisation: Mobil Eksekutif Bergaris Jalan -->
                <div class="service-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Wind Speed Lines -->
                        <line x1="10" y1="35" x2="60" y2="35" stroke="#2dd4bf" stroke-width="1.8" class="wind-line" />
                        <line x1="25" y1="50" x2="80" y2="50" stroke="#38bdf8" stroke-width="1.5" class="wind-line" />
                        <line x1="5" y1="105" x2="195" y2="105" stroke="#475569" stroke-width="2" stroke-dasharray="8 6" />

                        <!-- Car Body (Sedan Eksekutif Mewah) -->
                        <g class="car-body-group">
                            <!-- Body outline -->
                            <path d="M 35 95 L 45 75 Q 60 72, 75 52 L 130 52 Q 150 72, 175 75 L 185 85 Q 188 95, 175 95 Z" fill="#1e293b" stroke="#2dd4bf" stroke-width="2.5" />
                            <!-- Cabin Roof & Windows -->
                            <path d="M 78 55 L 128 55 Q 142 70, 160 74 L 62 74 Q 70 60, 78 55 Z" fill="#0f172a" stroke="#38bdf8" stroke-width="1.5" />
                            <line x1="105" y1="55" x2="105" y2="74" stroke="#38bdf8" stroke-width="1.5" />
                            <!-- Headlight & Taillight -->
                            <circle cx="182" cy="80" r="3" fill="#2dd4bf" />
                            <circle cx="38" cy="85" r="3" fill="#f43f5e" />
                        </g>

                        <!-- Front Wheel -->
                        <g class="wheel-spin" style="transform-origin: 155px 95px;">
                            <circle cx="155" cy="95" r="14" fill="#0b1324" stroke="#2dd4bf" stroke-width="2" />
                            <circle cx="155" cy="95" r="6" fill="#1e293b" />
                            <line x1="155" y1="83" x2="155" y2="107" stroke="#38bdf8" stroke-width="1.5" />
                            <line x1="143" y1="95" x2="167" y2="95" stroke="#38bdf8" stroke-width="1.5" />
                        </g>

                        <!-- Rear Wheel -->
                        <g class="wheel-spin" style="transform-origin: 65px 95px;">
                            <circle cx="65" cy="95" r="14" fill="#0b1324" stroke="#2dd4bf" stroke-width="2" />
                            <circle cx="65" cy="95" r="6" fill="#1e293b" />
                            <line x1="65" y1="83" x2="65" y2="107" stroke="#38bdf8" stroke-width="1.5" />
                            <line x1="53" y1="95" x2="77" y2="95" stroke="#38bdf8" stroke-width="1.5" />
                        </g>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="service-icon w-14 h-14 rounded-2xl bg-teal-400/15 border border-teal-400/30 flex items-center justify-center text-teal-300 text-2xl transition duration-300">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300">Bulanan / Tahunan</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Sewa Mobil Jangka Panjang</h3>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Kontrak fleksibel bulanan hingga tahunan untuk mobil dinas, operasional perusahaan, instansi, atau ekspatriat dengan fasilitas perawatan rutin gratis dan unit pengganti.
                    </p>
                </div>
                <div class="pt-5 border-t border-white/10 flex items-center justify-between relative z-10">
                    <span class="text-xs text-teal-300 font-semibold flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Free Maintenance & Servis</span>
                    <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20tertarik%20dengan%20layanan%20Sewa%20Mobil%20Jangka%20Panjang."
                        target="_blank" rel="noopener noreferrer"
                        class="w-10 h-10 rounded-xl bg-white/5 hover:bg-teal-400 hover:text-slate-950 text-white flex items-center justify-center transition">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Layanan 2: Sewa Mobil Harian (Visual: Mobil Melaju Cepat 24 Jam) -->
            <div class="service-card rounded-[30px] overflow-hidden bg-gradient-to-b from-[#16243c] to-[#0f192b] border border-white/10 hover:border-teal-400/60 p-8 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="200">
                <!-- SVG Animated Visualisation: Mobil Hatchback Lincah + Speed Wind -->
                <div class="service-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Speed Wind Streams -->
                        <line x1="15" y1="28" x2="70" y2="28" stroke="#fbbf24" stroke-width="2" class="wind-line" />
                        <line x1="5" y1="42" x2="85" y2="42" stroke="#f59e0b" stroke-width="1.8" class="wind-line" />
                        <line x1="25" y1="58" x2="65" y2="58" stroke="#fcd34d" stroke-width="1.5" class="wind-line" />
                        <line x1="5" y1="105" x2="195" y2="105" stroke="#475569" stroke-width="2" stroke-dasharray="8 6" />

                        <!-- Car Body (City Car Lincah) -->
                        <g class="car-body-group">
                            <path d="M 38 95 L 42 68 Q 65 65, 85 48 L 132 48 Q 155 65, 175 75 L 180 85 Q 182 95, 172 95 Z" fill="#1e293b" stroke="#fbbf24" stroke-width="2.5" />
                            <path d="M 88 52 L 130 52 Q 145 66, 158 72 L 72 72 Q 80 58, 88 52 Z" fill="#0f172a" stroke="#f59e0b" stroke-width="1.5" />
                            <circle cx="176" cy="80" r="3" fill="#fbbf24" />
                            <circle cx="42" cy="78" r="3" fill="#f43f5e" />
                        </g>

                        <!-- Wheels -->
                        <g class="wheel-spin" style="transform-origin: 150px 95px;">
                            <circle cx="150" cy="95" r="14" fill="#0b1324" stroke="#fbbf24" stroke-width="2" />
                            <circle cx="150" cy="95" r="6" fill="#1e293b" />
                            <line x1="150" y1="83" x2="150" y2="107" stroke="#f59e0b" stroke-width="1.5" />
                            <line x1="138" y1="95" x2="162" y2="95" stroke="#f59e0b" stroke-width="1.5" />
                        </g>
                        <g class="wheel-spin" style="transform-origin: 65px 95px;">
                            <circle cx="65" cy="95" r="14" fill="#0b1324" stroke="#fbbf24" stroke-width="2" />
                            <circle cx="65" cy="95" r="6" fill="#1e293b" />
                            <line x1="65" y1="83" x2="65" y2="107" stroke="#f59e0b" stroke-width="1.5" />
                            <line x1="53" y1="95" x2="77" y2="95" stroke="#f59e0b" stroke-width="1.5" />
                        </g>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="service-icon w-14 h-14 rounded-2xl bg-amber-400/15 border border-amber-400/30 flex items-center justify-center text-amber-300 text-2xl transition duration-300">
                            <i class="fa-solid fa-stopwatch"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300">Mulai 12 - 24 Jam</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Sewa Mobil Harian</h3>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Pilihan sewa harian untuk agenda liburan, silaturahmi keluarga, antar-jemput stasiun/bandara, atau kebutuhan perjalanan singkat di Ungaran, Semarang, dan sekitarnya.
                    </p>
                </div>
                <div class="pt-5 border-t border-white/10 flex items-center justify-between relative z-10">
                    <span class="text-xs text-amber-300 font-semibold flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Siap Antar Tepat Waktu</span>
                    <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20tertarik%20dengan%20layanan%20Sewa%20Mobil%20Harian."
                        target="_blank" rel="noopener noreferrer"
                        class="w-10 h-10 rounded-xl bg-white/5 hover:bg-teal-400 hover:text-slate-950 text-white flex items-center justify-center transition">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Layanan 3: Sewa Mobil dengan Driver (Visual: MPV Keluarga + Siluet Pengemudi) -->
            <div class="service-card rounded-[30px] overflow-hidden bg-gradient-to-b from-[#16243c] to-[#0f192b] border border-white/10 hover:border-teal-400/60 p-8 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                <!-- SVG Animated Visualisation: Mobil MPV + Driver Icon Inside -->
                <div class="service-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <line x1="5" y1="105" x2="195" y2="105" stroke="#475569" stroke-width="2" stroke-dasharray="8 6" />

                        <!-- Car Body (MPV Keluarga) -->
                        <g class="car-body-group">
                            <path d="M 32 95 L 36 65 Q 55 60, 75 42 L 145 42 Q 165 58, 180 75 L 185 86 Q 186 95, 172 95 Z" fill="#1e293b" stroke="#38bdf8" stroke-width="2.5" />
                            <!-- Windows -->
                            <path d="M 76 46 L 142 46 Q 155 58, 166 70 L 60 70 Q 68 54, 76 46 Z" fill="#0f172a" stroke="#0284c7" stroke-width="1.5" />
                            <!-- Driver Siluet di balik kaca depan -->
                            <circle cx="132" cy="56" r="5" fill="#38bdf8" />
                            <path d="M 124 68 Q 132 63, 140 68" stroke="#38bdf8" stroke-width="2" fill="none" />
                            <!-- Stir Mobil -->
                            <circle cx="144" cy="62" r="4" stroke="#38bdf8" stroke-width="1.5" fill="none" />
                        </g>

                        <!-- Wheels -->
                        <g class="wheel-spin" style="transform-origin: 155px 95px;">
                            <circle cx="155" cy="95" r="14" fill="#0b1324" stroke="#38bdf8" stroke-width="2" />
                            <circle cx="155" cy="95" r="6" fill="#1e293b" />
                            <line x1="155" y1="83" x2="155" y2="107" stroke="#0284c7" stroke-width="1.5" />
                            <line x1="143" y1="95" x2="167" y2="95" stroke="#0284c7" stroke-width="1.5" />
                        </g>
                        <g class="wheel-spin" style="transform-origin: 62px 95px;">
                            <circle cx="62" cy="95" r="14" fill="#0b1324" stroke="#38bdf8" stroke-width="2" />
                            <circle cx="62" cy="95" r="6" fill="#1e293b" />
                            <line x1="62" y1="83" x2="62" y2="107" stroke="#0284c7" stroke-width="1.5" />
                            <line x1="50" y1="95" x2="74" y2="95" stroke="#0284c7" stroke-width="1.5" />
                        </g>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="service-icon w-14 h-14 rounded-2xl bg-cyan-400/15 border border-cyan-400/30 flex items-center justify-center text-cyan-300 text-2xl transition duration-300">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full bg-teal-400/15 border border-teal-400/30 text-teal-300">Favorit Pelanggan</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Sewa Mobil dengan Driver</h3>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Nikmati perjalanan tanpa rasa lelah. Driver kami ramah, berpenampilan rapi, berpengalaman luas, menguasai rute jalan raya, dan menjaga kenyamanan privasi Anda.
                    </p>
                </div>
                <div class="pt-5 border-t border-white/10 flex items-center justify-between relative z-10">
                    <span class="text-xs text-cyan-300 font-semibold flex items-center gap-1.5"><i class="fa-solid fa-circle-check"></i> Driver Ramah & Rapi</span>
                    <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20tertarik%20dengan%20layanan%20Sewa%20Mobil%20dengan%20Driver."
                        target="_blank" rel="noopener noreferrer"
                        class="w-10 h-10 rounded-xl bg-white/5 hover:bg-teal-400 hover:text-slate-950 text-white flex items-center justify-center transition">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Layanan 4: Sewa Mobil Lepas Kunci (Visual: Mobil + Kunci Mobil Menyala) -->
            <div class="service-card rounded-[30px] overflow-hidden bg-gradient-to-b from-[#16243c] to-[#0f192b] border border-white/10 hover:border-teal-400/60 p-8 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="400">
                <!-- SVG Animated Visualisation: Mobil + Floating Key -->
                <div class="service-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Flying Key Graphic -->
                        <g class="pulse-glow" style="transform: translate(25px, 20px) rotate(-20deg);">
                            <circle cx="20" cy="20" r="10" stroke="#34d399" stroke-width="2.5" fill="none" />
                            <circle cx="20" cy="20" r="4" fill="#34d399" />
                            <line x1="30" y1="20" x2="52" y2="20" stroke="#34d399" stroke-width="2.5" />
                            <line x1="45" y1="20" x2="45" y2="26" stroke="#34d399" stroke-width="2.5" />
                            <line x1="50" y1="20" x2="50" y2="25" stroke="#34d399" stroke-width="2.5" />
                        </g>

                        <line x1="5" y1="105" x2="195" y2="105" stroke="#475569" stroke-width="2" stroke-dasharray="8 6" />

                        <!-- Car Body -->
                        <g class="car-body-group">
                            <path d="M 40 95 L 48 72 Q 68 70, 85 52 L 132 52 Q 152 70, 172 75 L 180 85 Q 182 95, 170 95 Z" fill="#1e293b" stroke="#34d399" stroke-width="2.5" />
                            <path d="M 86 56 L 130 56 Q 142 68, 155 72 L 68 72 Q 76 60, 86 56 Z" fill="#0f172a" stroke="#10b981" stroke-width="1.5" />
                        </g>

                        <!-- Wheels -->
                        <g class="wheel-spin" style="transform-origin: 152px 95px;">
                            <circle cx="152" cy="95" r="14" fill="#0b1324" stroke="#34d399" stroke-width="2" />
                            <circle cx="152" cy="95" r="6" fill="#1e293b" />
                            <line x1="152" y1="83" x2="152" y2="107" stroke="#10b981" stroke-width="1.5" />
                            <line x1="140" y1="95" x2="164" y2="95" stroke="#10b981" stroke-width="1.5" />
                        </g>
                        <g class="wheel-spin" style="transform-origin: 68px 95px;">
                            <circle cx="68" cy="95" r="14" fill="#0b1324" stroke="#34d399" stroke-width="2" />
                            <circle cx="68" cy="95" r="6" fill="#1e293b" />
                            <line x1="68" y1="83" x2="68" y2="107" stroke="#10b981" stroke-width="1.5" />
                            <line x1="56" y1="95" x2="80" y2="95" stroke="#10b981" stroke-width="1.5" />
                        </g>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="service-icon w-14 h-14 rounded-2xl bg-emerald-400/15 border border-emerald-400/30 flex items-center justify-center text-emerald-300 text-2xl transition duration-300">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <span class="text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full bg-white/5 border border-white/10 text-slate-300">Privasi Penuh</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Sewa Lepas Kunci</h3>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Kebebasan mengemudi sendiri bersama keluarga atau teman. Proses mudah dan aman dengan sistem verifikasi data diri & dokumen resmi yang cepat dan terpercaya.
                    </p>
                </div>
                <div class="pt-5 border-t border-white/10 flex items-center justify-between relative z-10">
                    <span class="text-xs text-emerald-300 font-semibold flex items-center gap-1.5"><i class="fa-solid fa-shield-halved"></i> Perlu Verifikasi Data Diri</span>
                    <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20ingin%20tanya%20syarat%20Sewa%20Mobil%20Lepas%20Kunci."
                        target="_blank" rel="noopener noreferrer"
                        class="w-10 h-10 rounded-xl bg-white/5 hover:bg-teal-400 hover:text-slate-950 text-white flex items-center justify-center transition">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Layanan 5: Jasa Pengemudi (Visual: Dashboard & Kemudi Mobil Berputar) -->
            <div class="service-card rounded-[30px] overflow-hidden bg-gradient-to-b from-[#16243c] to-[#0f192b] border border-white/10 hover:border-teal-400/60 p-8 flex flex-col justify-between md:col-span-2 lg:col-span-2" data-aos="fade-up" data-aos-delay="500">
                <!-- SVG Animated Visualisation: Setir Mobil & Dasbor Profesional -->
                <div class="service-bg-vector !w-[280px] !h-[170px] !right-10 !bottom-6">
                    <svg viewBox="0 0 240 140" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Speedometer Arc in Background -->
                        <path d="M 60 110 A 50 50 0 0 1 160 110" stroke="#a855f7" stroke-width="4" stroke-dasharray="6 4" opacity="0.4" />
                        <line x1="110" y1="110" x2="80" y2="80" stroke="#c084fc" stroke-width="2.5" stroke-linecap="round" />

                        <!-- Animated Steering Wheel -->
                        <g class="wheel-spin" style="transform-origin: 170px 75px;">
                            <circle cx="170" cy="75" r="38" stroke="#c084fc" stroke-width="5" fill="#0f172a" />
                            <circle cx="170" cy="75" r="12" fill="#581c87" stroke="#c084fc" stroke-width="2" />
                            <line x1="170" y1="37" x2="170" y2="63" stroke="#c084fc" stroke-width="4" />
                            <line x1="132" y1="75" x2="158" y2="75" stroke="#c084fc" stroke-width="4" />
                            <line x1="182" y1="75" x2="208" y2="75" stroke="#c084fc" stroke-width="4" />
                            <circle cx="170" cy="75" r="4" fill="#fff" />
                        </g>

                        <!-- Road Lines in Front -->
                        <path d="M 20 135 L 70 100" stroke="#475569" stroke-width="2" stroke-dasharray="6 4" />
                        <path d="M 120 135 L 90 100" stroke="#475569" stroke-width="2" stroke-dasharray="6 4" />
                    </svg>
                </div>

                <div class="grid md:grid-cols-2 gap-6 items-center relative z-10">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="service-icon w-14 h-14 rounded-2xl bg-purple-400/15 border border-purple-400/30 flex items-center justify-center text-purple-300 text-2xl transition duration-300">
                                <i class="fa-solid fa-id-card-clip"></i>
                            </div>
                            <span class="text-[11px] font-extrabold uppercase tracking-wider px-3 py-1 rounded-full bg-purple-500/15 border border-purple-400/30 text-purple-300">Driver Only Service</span>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Jasa Pengemudi Profesional</h3>
                        <p class="text-slate-300 text-sm leading-relaxed mb-4">
                            Sudah memiliki kendaraan sendiri namun butuh driver andal? Kami menyediakan jasa pengemudi berpengalaman, terlatih, paham etika berkendara, dan siap menemani perjalanan dalam maupun luar kota.
                        </p>
                    </div>
                    <div class="bg-white/[0.04] backdrop-blur-md border border-white/10 rounded-2xl p-6 flex flex-col justify-between gap-4">
                        <div class="space-y-2.5 text-xs text-slate-300">
                            <div class="flex items-center gap-2"><i class="fa-solid fa-check text-teal-400"></i> Driver berlisensi resmi & hafal rute lintas kota</div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-check text-teal-400"></i> Cocok untuk acara pernikahan, dinas, & roadtrip</div>
                            <div class="flex items-center gap-2"><i class="fa-solid fa-check text-teal-400"></i> Tarif terjangkau per hari / per trip</div>
                        </div>
                        <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20membutuhkan%20Jasa%20Pengemudi%20%28Driver%20Only%29."
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-teal-400 text-slate-950 font-bold text-sm hover:bg-teal-300 transition shadow-lg shadow-teal-500/20">
                            <i class="fa-brands fa-whatsapp"></i> Pesan Jasa Pengemudi
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- KEUNGGULAN SECTION -->
<section id="keunggulan" class="py-24 bg-[#0F172A] relative">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent"></div>
    <!-- Moving Car Speed Light Line -->
    <div class="road-track-line mb-10"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-gem text-teal-300"></i> Standard Pelayanan Eksklusif
            </div>
            <h2 class="text-3xl md:text-5xl font-bold mb-4 text-white">
                Mengapa Memilih <span class="text-teal-400">Graha Transport?</span>
            </h2>
            <p class="text-slate-300 max-w-2xl mx-auto text-base md:text-lg">
                Dedikasi penuh menghadirkan standar rental mobil premium yang aman, tepat waktu, dan memberikan ketenangan di setiap perjalanan.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 xl:grid-cols-5 gap-6">

            <div class="luxury-card rounded-3xl p-7 text-center sm:text-left" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 rounded-2xl bg-teal-400/10 border border-teal-400/25 flex items-center justify-center mb-5 mx-auto sm:mx-0 shadow-inner">
                    <i class="fa-solid fa-headset text-2xl text-teal-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">24/7 VIP Support</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Respon tanggap & konsultasi kebutuhan armada kapanpun Anda butuhkan.</p>
            </div>

            <div class="luxury-card rounded-3xl p-7 text-center sm:text-left" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 rounded-2xl bg-amber-400/10 border border-amber-400/25 flex items-center justify-center mb-5 mx-auto sm:mx-0 shadow-inner">
                    <i class="fa-solid fa-user-tie text-2xl text-amber-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Chauffeur Berpengalaman</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Driver profesional, berseragam rapi, beretika tinggi, dan paham protokol dinas.</p>
            </div>

            <div class="luxury-card rounded-3xl p-7 text-center sm:text-left" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 rounded-2xl bg-purple-400/10 border border-purple-400/25 flex items-center justify-center mb-5 mx-auto sm:mx-0 shadow-inner">
                    <i class="fa-solid fa-car-side text-2xl text-purple-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Armada Prima & Steril</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Keluaran tahun muda, perawatan bengkel resmi, kabin higienis dan wangi.</p>
            </div>

            <div class="luxury-card rounded-3xl p-7 text-center sm:text-left" data-aos="fade-up" data-aos-delay="400">
                <div class="w-14 h-14 rounded-2xl bg-cyan-400/10 border border-cyan-400/25 flex items-center justify-center mb-5 mx-auto sm:mx-0 shadow-inner">
                    <i class="fa-solid fa-route text-2xl text-cyan-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Jangkauan Luas & Fleksibel</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Siap melayani sewa dalam kota, penjemputan bandara/stasiun, hingga rute luar kota.</p>
            </div>

            <div class="luxury-card rounded-3xl p-7 text-center sm:text-left" data-aos="fade-up" data-aos-delay="500">
                <div class="w-14 h-14 rounded-2xl bg-rose-400/10 border border-rose-400/25 flex items-center justify-center mb-5 mx-auto sm:mx-0 shadow-inner">
                    <i class="fa-solid fa-briefcase text-2xl text-rose-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Legalitas & Corporate</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Perusahaan berbadan hukum resmi dengan invoice & kontrak operasional rapi.</p>
            </div>

        </div>
    </div>
</section>

<!-- ========================================= -->
<!-- JANGKAUAN WILAYAH & ANIMASI PETA INDONESIA -->
<!-- ========================================= -->
<section id="wilayah" class="py-24 bg-[#07111f] relative overflow-hidden border-t border-white/5">
    <!-- Ambient Map Glow -->
    <div class="absolute -top-32 left-1/3 w-[500px] h-[500px] bg-teal-500/10 blur-[160px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <!-- Header -->
        <div class="text-center max-w-6xl mx-auto mb-16" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-map-location-dot text-teal-300"></i> Jaringan Titik Layanan
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-extrabold text-white tracking-tight leading-snug mb-5">
                Sewa Mobil di Berbagai Wilayah, <span class="bg-gradient-to-r from-teal-300 via-teal-400 to-cyan-300 bg-clip-text text-transparent">Didukung Titik Layanan Terintegrasi.</span>
            </h2>
            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-3xl mx-auto">
                Graha Transport berbasis di Ungaran & Semarang dengan jaringan operasional terpercaya ke berbagai kota di Jawa Tengah dan kota-kota besar di Indonesia. Setiap unit ditangani secara profesional dengan dukungan bengkel resmi dan rekanan kredibel untuk menjamin kelancaran perjalanan Anda.
            </p>
        </div>

        <!-- Radar Network Animated Box -->
        <div class="relative overflow-hidden rounded-[36px] bg-gradient-to-b from-[#111e33] via-[#0d1829] to-[#07111f] border border-white/10 p-6 md:p-12 shadow-2xl" data-aos="zoom-in" data-aos-delay="150">

            <!-- Decorative Coordinate Grid Background -->
            <div class="absolute inset-0 bg-[radial-gradient(#2dd4bf_1px,transparent_1px)] [background-size:28px_28px] opacity-10 pointer-events-none"></div>

            <!-- SVG Animated Map & Transmission Rays -->
            <div class="relative w-full aspect-[16/9] min-h-[380px] max-h-[520px] flex items-center justify-center">
                <svg viewBox="0 0 1000 460" class="w-full h-full" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <!-- Radial glow for HQ -->
                        <radialGradient id="hqGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#2dd4bf" stop-opacity="0.8" />
                            <stop offset="100%" stop-color="#2dd4bf" stop-opacity="0" />
                        </radialGradient>
                        <!-- Gradient for laser lines -->
                        <linearGradient id="laserGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#2dd4bf" stop-opacity="0.9" />
                            <stop offset="50%" stop-color="#38bdf8" stop-opacity="0.7" />
                            <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.8" />
                        </linearGradient>
                    </defs>

                    <!-- Real Vector Map of Indonesia Islands -->
                    <path d="<?= trim(file_get_contents(FCPATH . 'assets/img/indonesia_clean_path.txt')); ?>"
                        fill="#182740" stroke="#38bdf8" stroke-width="0.8" stroke-opacity="0.45" />

                    <!-- Laser Network Transmission Lines (Origin: Semarang / Ungaran X=334, Y=353) -->
                    <!-- Path to Jakarta (256, 330) -->
                    <path d="M 334 353 Q 295 325, 256 330" stroke="url(#laserGrad)" stroke-width="2.2" class="laser-line" />
                    <!-- Path to Surabaya (384, 358) -->
                    <path d="M 334 353 Q 360 350, 384 358" stroke="url(#laserGrad)" stroke-width="2.2" class="laser-line" />
                    <!-- Path to Yogyakarta (333, 372) -->
                    <path d="M 334 353 L 333 372" stroke="url(#laserGrad)" stroke-width="2" class="laser-line" />
                    <!-- Path to Bandung (273, 349) -->
                    <path d="M 334 353 Q 300 338, 273 349" stroke="url(#laserGrad)" stroke-width="2" class="laser-line" />
                    <!-- Path to Bali (437, 388) -->
                    <path d="M 334 353 Q 390 355, 437 388" stroke="url(#laserGrad)" stroke-width="2" class="laser-line" />
                    <!-- Path to Balikpapan / IKN (474, 198) -->
                    <path d="M 334 353 Q 410 270, 474 198" stroke="url(#laserGrad)" stroke-width="2" class="laser-line" />
                    <!-- Path to Makassar (529, 302) -->
                    <path d="M 334 353 Q 440 310, 529 302" stroke="url(#laserGrad)" stroke-width="2" class="laser-line" />
                    <!-- Path to Medan (79, 69) -->
                    <path d="M 334 353 Q 190 190, 79 69" stroke="url(#laserGrad)" stroke-width="2" class="laser-line" />

                    <!-- Destination Node Points with Glow -->
                    <!-- Jakarta -->
                    <circle cx="256" cy="330" r="5" fill="#38bdf8" />
                    <circle cx="256" cy="330" r="11" stroke="#38bdf8" stroke-width="1" opacity="0.6" />
                    <text x="256" y="315" fill="#e2e8f0" font-size="11" font-weight="700" text-anchor="middle">Jakarta</text>

                    <!-- Surabaya -->
                    <circle cx="384" cy="358" r="5" fill="#38bdf8" />
                    <text x="384" y="344" fill="#e2e8f0" font-size="11" font-weight="700" text-anchor="middle">Surabaya</text>

                    <!-- Bali -->
                    <circle cx="437" cy="388" r="5" fill="#38bdf8" />
                    <text x="437" y="412" fill="#e2e8f0" font-size="11" font-weight="700" text-anchor="middle">Bali</text>

                    <!-- Balikpapan / IKN -->
                    <circle cx="474" cy="198" r="5" fill="#38bdf8" />
                    <circle cx="474" cy="198" r="10" stroke="#38bdf8" stroke-width="1" opacity="0.6" />
                    <text x="474" y="184" fill="#e2e8f0" font-size="11" font-weight="700" text-anchor="middle">IKN / Balikpapan</text>

                    <!-- Makassar -->
                    <circle cx="529" cy="302" r="5" fill="#38bdf8" />
                    <text x="529" y="288" fill="#e2e8f0" font-size="11" font-weight="700" text-anchor="middle">Makassar</text>

                    <!-- Medan -->
                    <circle cx="79" cy="69" r="5" fill="#38bdf8" />
                    <text x="79" y="55" fill="#e2e8f0" font-size="11" font-weight="700" text-anchor="middle">Medan</text>

                    <!-- Bandung -->
                    <circle cx="273" cy="349" r="4" fill="#38bdf8" />
                    <text x="273" y="370" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Bandung</text>

                    <!-- Yogyakarta -->
                    <circle cx="333" cy="372" r="4" fill="#38bdf8" />
                    <text x="333" y="392" fill="#94a3b8" font-size="10" font-weight="600" text-anchor="middle">Jogja / Solo</text>

                    <!-- HQ SEMARANG & UNGARAN (MAIN HUB) -->
                    <!-- Radar Waves -->
                    <circle cx="334" cy="353" r="10" stroke="#2dd4bf" fill="none" class="radar-pulse-circle" />
                    <circle cx="334" cy="353" r="18" stroke="#2dd4bf" fill="none" class="radar-pulse-circle" style="animation-delay: 0.9s;" />
                    <circle cx="334" cy="353" r="26" stroke="#2dd4bf" fill="none" class="radar-pulse-circle" style="animation-delay: 1.8s;" />

                    <!-- Center Hub Dot -->
                    <circle cx="334" cy="353" r="8" fill="#2dd4bf" filter="drop-shadow(0px 0px 10px #2dd4bf)" />
                    <circle cx="334" cy="353" r="3.5" fill="#fff" />
                </svg>

                <!-- Floating Main Hub Card Tag (Positioned directly over Semarang/Ungaran Hub: X=33.4%, Y=76.7%) -->
                <div class="absolute top-[76%] left-[33.4%] -translate-x-1/2 -translate-y-full bg-slate-950/95 border border-teal-400/60 rounded-2xl px-4 py-2.5 shadow-2xl backdrop-blur-md flex items-center gap-2.5 z-20">
                    <span class="w-3 h-3 rounded-full bg-teal-400 animate-ping"></span>
                    <div>
                        <div class="text-[10px] uppercase tracking-wider font-extrabold text-teal-300">PUSAT OPERASIONAL</div>
                        <div class="text-xs font-bold text-white leading-tight">Ungaran & Semarang</div>
                    </div>
                </div>

                <!-- Live Fleet Coverage Badge on Bottom Left -->
                <div class="absolute bottom-4 left-4 bg-black/60 border border-white/10 rounded-2xl px-4 py-3 backdrop-blur-md hidden sm:flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></div>
                    <div class="text-xs">
                        <span class="text-white font-bold">Jalur Tol Trans-Jawa Siap Layani</span>
                        <span class="text-slate-400 block text-[11px]">Dukungan unit prima, driver bersertifikat & bengkel rekanan</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Coverage Summary Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 pt-8 border-t border-white/10">
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5">
                    <div class="text-xs font-bold text-teal-400 uppercase tracking-wider mb-1">Zona Utama</div>
                    <div class="text-sm md:text-base font-extrabold text-white">Ungaran & Semarang</div>
                    <div class="text-[11px] text-slate-400 mt-1">Antar-jemput 24 Jam</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5">
                    <div class="text-xs font-bold text-teal-400 uppercase tracking-wider mb-1">Jalur Wisata</div>
                    <div class="text-sm md:text-base font-extrabold text-white">Bandungan & Salatiga</div>
                    <div class="text-[11px] text-slate-400 mt-1">Ambarawa & sekitarnya</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5">
                    <div class="text-xs font-bold text-teal-400 uppercase tracking-wider mb-1">Hub Transportasi</div>
                    <div class="text-sm md:text-base font-extrabold text-white">Bandara & Stasiun</div>
                    <div class="text-[11px] text-slate-400 mt-1">Ahmad Yani / Tawang / Poncol</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5">
                    <div class="text-xs font-bold text-teal-400 uppercase tracking-wider mb-1">Rute Lintas Kota</div>
                    <div class="text-sm md:text-base font-extrabold text-white">Jawa & Luar Pulau</div>
                    <div class="text-[11px] text-slate-400 mt-1">Dinas & Drop Off Lintas Wilayah</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- CARA BOOKING MUDAH -->
<section class="py-16 bg-[#07111f] border-y border-white/5 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12" data-aos="fade-up">
            <div>
                <div class="eyebrow-badge mb-3">
                    <i class="fa-solid fa-bolt"></i> Proses Cepat & Transparan
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white">
                    Sewa Mobil Hanya dalam <span class="text-teal-400">3 Langkah Mudah</span>
                </h2>
            </div>
            <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20ingin%20tanya%20rekomendasi%20unit%20mobil."
                target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-2 text-sm font-semibold text-teal-400 hover:text-teal-300 transition shrink-0">
                Butuh rekomendasi cepat? Chat Admin <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            
            <!-- LANGKAH 1: PILIH UNIT FAVORIT -->
            <div class="step-card luxury-card rounded-3xl p-8 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="100">
                <!-- SVG Animated Visualisation: Target Lock & Mobil Sport SUV -->
                <div class="step-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Target Selection Reticle / Brackets -->
                        <g class="target-lock-anim" style="transform-origin: 100px 65px;">
                            <path d="M 30,35 L 20,35 L 20,45" stroke="#2dd4bf" stroke-width="2" stroke-linecap="round" />
                            <path d="M 170,35 L 180,35 L 180,45" stroke="#2dd4bf" stroke-width="2" stroke-linecap="round" />
                            <path d="M 30,105 L 20,105 L 20,95" stroke="#2dd4bf" stroke-width="2" stroke-linecap="round" />
                            <path d="M 170,105 L 180,105 L 180,95" stroke="#2dd4bf" stroke-width="2" stroke-linecap="round" />
                            <circle cx="100" cy="28" r="2" fill="#2dd4bf" />
                            <circle cx="100" cy="112" r="2" fill="#2dd4bf" />
                        </g>
                        
                        <!-- Speed wind dashes -->
                        <line x1="15" y1="42" x2="65" y2="42" stroke="#38bdf8" stroke-width="1.5" class="wind-line" />
                        <line x1="30" y1="56" x2="85" y2="56" stroke="#2dd4bf" stroke-width="1.8" class="wind-line" />
                        <!-- Road Track Line -->
                        <line x1="5" y1="102" x2="195" y2="102" stroke="#475569" stroke-width="2" stroke-dasharray="8 6" class="road-dash-fast" />

                        <!-- Car Silhouette (Modern SUV / MPV) -->
                        <g class="step-car-hover">
                            <!-- Headlight Cone Beam -->
                            <polygon points="172,78 198,72 198,88 172,82" fill="url(#stepHeadlightGlow1)" opacity="0.6" />
                            <!-- Body Profile -->
                            <path d="M 32,94 L 38,72 Q 48,68 62,50 L 126,50 Q 146,50 162,70 L 174,74 Q 178,82 176,92 L 168,94 Q 166,82 152,82 Q 138,82 136,94 L 68,94 Q 66,82 52,82 Q 38,82 36,94 Z"
                                  fill="#111c30" stroke="#2dd4bf" stroke-width="2.2" stroke-linejoin="round" />
                            <!-- Windows & Pillar -->
                            <path d="M 66,54 L 122,54 Q 138,54 150,68 L 60,68 Q 63,58 66,54 Z"
                                  fill="rgba(45, 212, 191, 0.25)" stroke="#38bdf8" stroke-width="1.2" />
                            <line x1="96" y1="54" x2="96" y2="68" stroke="#38bdf8" stroke-width="1.5" />
                            <!-- Headlight & Taillight -->
                            <circle cx="174" cy="76" r="2.5" fill="#ffffff" />
                            <circle cx="34" cy="78" r="2.5" fill="#ef4444" />
                        </g>

                        <!-- Front Wheel -->
                        <g class="step-wheel-spin" style="transform-origin: 152px 94px;">
                            <circle cx="152" cy="94" r="13" fill="#070d18" stroke="#2dd4bf" stroke-width="2" />
                            <circle cx="152" cy="94" r="5" fill="#1e293b" />
                            <line x1="152" y1="83" x2="152" y2="105" stroke="#38bdf8" stroke-width="1.4" />
                            <line x1="141" y1="94" x2="163" y2="94" stroke="#38bdf8" stroke-width="1.4" />
                        </g>
                        <!-- Rear Wheel -->
                        <g class="step-wheel-spin" style="transform-origin: 52px 94px;">
                            <circle cx="52" cy="94" r="13" fill="#070d18" stroke="#2dd4bf" stroke-width="2" />
                            <circle cx="52" cy="94" r="5" fill="#1e293b" />
                            <line x1="52" y1="83" x2="52" y2="105" stroke="#38bdf8" stroke-width="1.4" />
                            <line x1="41" y1="94" x2="63" y2="94" stroke="#38bdf8" stroke-width="1.4" />
                        </g>

                        <defs>
                            <linearGradient id="stepHeadlightGlow1" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#ffffff" stop-opacity="0.8" />
                                <stop offset="100%" stop-color="#2dd4bf" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-300 to-teal-500 text-slate-950 font-black text-lg flex items-center justify-center shadow-lg shadow-teal-500/30">01</span>
                        <div class="w-10 h-10 rounded-xl bg-teal-400/10 border border-teal-400/20 flex items-center justify-center text-teal-300 text-lg group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-car"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2.5">Pilih Unit Favorit</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Pilih dari deretan kendaraan prima kami—mulai dari city car lincah, SUV tangguh, hingga MPV luxury untuk dinas & keluarga.</p>
                </div>
            </div>

            <!-- LANGKAH 2: KONFIRMASI CEPAT VIA WHATSAPP -->
            <div class="step-card luxury-card rounded-3xl p-8 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="200">
                <!-- SVG Animated Visualisation: Smartphone & Chat WhatsApp Verified -->
                <div class="step-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Radiating Signal Waves -->
                        <path d="M 125,25 A 25,25 0 0,1 150,50" stroke="#25D366" stroke-width="1.8" stroke-linecap="round" stroke-dasharray="4 4" class="wind-line" opacity="0.7" />
                        <path d="M 125,15 A 35,35 0 0,1 160,50" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-dasharray="6 6" class="wind-line" opacity="0.5" />

                        <!-- Phone Outline -->
                        <rect x="35" y="22" width="60" height="92" rx="12" fill="#0b1324" stroke="#2dd4bf" stroke-width="2.2" />
                        <!-- Phone screen -->
                        <rect x="40" y="32" width="50" height="72" rx="6" fill="#060c18" stroke="#1e293b" stroke-width="1" />
                        <!-- Home bar & speaker -->
                        <line x1="57" y1="27" x2="73" y2="27" stroke="#475569" stroke-width="2" stroke-linecap="round" />
                        <line x1="55" y1="108" x2="75" y2="108" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" />

                        <!-- Messages inside screen -->
                        <rect x="43" y="38" width="32" height="10" rx="4" fill="rgba(45,212,191,0.2)" />
                        <rect x="54" y="52" width="32" height="10" rx="4" fill="rgba(37,211,102,0.3)" />
                        <rect x="43" y="66" width="28" height="10" rx="4" fill="rgba(45,212,191,0.2)" />

                        <!-- Floating Big WhatsApp Chat Bubble (Interaktif) -->
                        <g class="chat-bubble-anim" style="transform-origin: 140px 68px;">
                            <path d="M 110,48 C 110,40 118,34 135,34 L 165,34 C 178,34 188,42 188,52 C 188,64 176,72 165,72 L 140,72 L 126,82 L 130,72 C 118,72 110,64 110,48 Z"
                                  fill="#0e231d" stroke="#25D366" stroke-width="2.2" />
                            <circle cx="148" cy="53" r="11" fill="#25D366" />
                            <path d="M 143,51 C 143,55 146,58 151,58 C 152,58 153,57.5 153.5,57 L 152.5,54.5 C 152,55 151.2,55.3 150.5,55 C 148.5,53.8 147.5,52 147,50 C 146.5,49.2 147,48.5 147.5,48 L 145.5,47 C 144,48 143,49.5 143,51 Z" fill="#ffffff" />
                            
                            <!-- Double Checkmark (Verified) -->
                            <g transform="translate(164, 58)">
                                <path d="M 0,4 L 3,7 L 9,0" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M 4,4 L 7,7 L 13,0" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </g>

                        <!-- Dynamic Laser Transfer Line connecting Phone to Bubble -->
                        <path d="M 85,58 C 98,58 102,60 112,62" stroke="#2dd4bf" stroke-width="1.5" stroke-dasharray="4 4" class="wind-line" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-300 to-teal-500 text-slate-950 font-black text-lg flex items-center justify-center shadow-lg shadow-teal-500/30">02</span>
                        <div class="w-10 h-10 rounded-xl bg-teal-400/10 border border-teal-400/20 flex items-center justify-center text-teal-300 text-lg group-hover:scale-110 transition-transform">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2.5">Konfirmasi Cepat via WhatsApp</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Cukup klik tombol booking, tentukan tanggal sewa, durasi, dan titik jemput. Admin kami langsung mengunci jadwal Anda.</p>
                </div>
            </div>

            <!-- LANGKAH 3: ARMADA SIAP MELUNCUR -->
            <div class="step-card luxury-card rounded-3xl p-8 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="300">
                <!-- SVG Animated Visualisation: Jalan Tol, Mobil Melaju & Kunci Emas -->
                <div class="step-bg-vector">
                    <svg viewBox="0 0 200 130" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <!-- Road Perspective Highway -->
                        <polygon points="40,118 75,70 125,70 160,118" fill="rgba(15, 23, 42, 0.6)" stroke="#334155" stroke-width="1" />
                        <!-- Fast Road Center Dashes -->
                        <line x1="100" y1="72" x2="100" y2="116" stroke="#2dd4bf" stroke-width="2" stroke-dasharray="6 6" class="road-dash-fast" />

                        <!-- Car Driving Forward On Highway -->
                        <g class="step-car-hover">
                            <!-- Headlights Cone Beam Forward -->
                            <polygon points="76,86 45,116 80,116 82,90" fill="url(#stepHeadlightFront1)" opacity="0.7" />
                            <polygon points="124,86 118,90 120,116 155,116" fill="url(#stepHeadlightFront1)" opacity="0.7" />
                            
                            <!-- Front Facing Car Silhouette -->
                            <path d="M 84,72 L 90,62 L 110,62 L 116,72 Z" fill="#0f172a" stroke="#38bdf8" stroke-width="1.5" />
                            <path d="M 76,73 L 124,73 Q 132,74 130,86 L 128,94 Q 128,97 122,97 L 78,97 Q 72,97 72,94 L 70,86 Q 68,74 76,73 Z"
                                  fill="#111c30" stroke="#2dd4bf" stroke-width="2.2" />
                            <rect x="85" y="82" width="30" height="9" rx="3" fill="#070d18" stroke="#2dd4bf" stroke-width="1" />
                            <ellipse cx="78" cy="78" rx="4" ry="2.5" fill="#ffffff" />
                            <ellipse cx="122" cy="78" rx="4" ry="2.5" fill="#ffffff" />
                            <rect x="68" y="86" width="6" height="12" rx="2" fill="#0b1324" stroke="#2dd4bf" stroke-width="1.2" />
                            <rect x="126" y="86" width="6" height="12" rx="2" fill="#0b1324" stroke="#2dd4bf" stroke-width="1.2" />
                        </g>

                        <!-- Floating Golden Ignition Key (Interaktif Gleam) -->
                        <g class="key-gleam-anim" style="transform-origin: 155px 38px;">
                            <circle cx="155" cy="38" r="14" fill="#0f1d33" stroke="#f59e0b" stroke-width="2.2" />
                            <circle cx="155" cy="38" r="6" fill="#f59e0b" />
                            <path d="M 155,52 L 155,80 L 160,80 L 160,74 L 163,74 L 163,68 L 158,68 L 158,52 Z"
                                  fill="#f59e0b" stroke="#d97706" stroke-width="1" />
                            <path d="M 172,25 L 174,31 L 180,33 L 174,35 L 172,41 L 170,35 L 164,33 L 170,31 Z" fill="#fbbf24" />
                        </g>

                        <defs>
                            <linearGradient id="stepHeadlightFront1" x1="50%" y1="0%" x2="50%" y2="100%">
                                <stop offset="0%" stop-color="#ffffff" stop-opacity="0.8" />
                                <stop offset="100%" stop-color="#2dd4bf" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-300 to-teal-500 text-slate-950 font-black text-lg flex items-center justify-center shadow-lg shadow-teal-500/30">03</span>
                        <div class="w-10 h-10 rounded-xl bg-teal-400/10 border border-teal-400/20 flex items-center justify-center text-teal-300 text-lg group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-key"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2.5">Armada Siap Meluncur</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Mobil tiba tepat waktu di lokasi Anda dalam kondisi bersih mengkilap, wangi, dan bahan bakar siap pakai.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ============================= -->
<!-- CLIENT KAMI -->
<!-- ============================= -->
<section id="client" class="py-20 bg-[#091220] relative overflow-hidden border-t border-white/5">
    <!-- Ambient Glow Orbs -->
    <div class="absolute -top-24 -left-20 w-80 h-80 bg-teal-500/10 blur-[140px] rounded-full pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-20 w-80 h-80 bg-cyan-500/10 blur-[140px] rounded-full pointer-events-none"></div>

    <!-- Automotive / Partnership Network Laser Speed Beams -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-30">
        <div class="speed-beam speed-beam-teal" style="top: 25%; opacity: 0.5;"></div>
        <div class="speed-beam speed-beam-cyan" style="top: 75%; opacity: 0.4;"></div>
        <div class="speed-beam speed-beam-amber" style="top: 50%; opacity: 0.35;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 relative z-10">

        <div class="text-center mb-12" data-aos="fade-up">
            <div class="eyebrow-badge mb-3">
                <i class="fa-solid fa-handshake"></i> Partner & Instansi
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-white">
                Dipercaya <span class="text-teal-400">Client Kami</span>
            </h2>

            <p class="text-slate-300 mt-3 max-w-2xl mx-auto">
                Berbagai instansi pemerintah, BUMN, perbankan, dan perusahaan swasta telah mempercayakan
                kebutuhan transportasinya kepada Graha Transport.
            </p>
        </div>

        <div class="client-slider pt-2">
            <div class="client-track">

                <?php
                // Render seamless infinite marquee with rich cards
                $client_data = $client->result();
                $repeat_times = 5; // Repeat sufficiently to guarantee continuous scroll without empty gaps
                for ($r = 0; $r < $repeat_times; $r++) {
                    foreach ($client_data as $key => $row) {
                ?>
                    <div class="client-item group">
                        <!-- SVG Interactive Background Watermark: Cyber Circuit & Target Framing -->
                        <div class="client-bg-vector">
                            <svg viewBox="0 0 160 90" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                <!-- Partnership Network Circuit Rings -->
                                <circle cx="80" cy="45" r="34" stroke="#2dd4bf" stroke-width="1.2" stroke-dasharray="4 4" class="circuit-ring" opacity="0.4" />
                                <circle cx="80" cy="45" r="22" stroke="#38bdf8" stroke-width="1" opacity="0.25" />
                                <!-- Corner Target Brackets -->
                                <path d="M 12,12 L 22,12 M 12,12 L 12,22" stroke="#2dd4bf" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M 148,12 L 138,12 M 148,12 L 148,22" stroke="#2dd4bf" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M 12,78 L 22,78 M 12,78 L 12,68" stroke="#2dd4bf" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M 148,78 L 138,78 M 148,78 L 148,68" stroke="#2dd4bf" stroke-width="1.5" stroke-linecap="round" />
                                <!-- Pulse Dots -->
                                <circle cx="80" cy="11" r="2" fill="#2dd4bf" />
                                <circle cx="80" cy="79" r="2" fill="#38bdf8" />
                            </svg>
                        </div>
                        
                        <!-- Light Shimmer Sweep Flare on Hover -->
                        <div class="client-shimmer-sweep"></div>

                        <!-- Client Logo -->
                        <img src="<?= base_url('assets/img/baner_slider/' . $row->foto_banner); ?>"
                            alt="Logo Partner Graha Transport <?= $key + 1; ?>" loading="lazy" class="relative z-10">
                    </div>
                <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>

<!-- ============================= -->
<!-- ARTIKEL -->
<!-- ============================= -->
<section id="berita" class="py-20 relative">

    <div class="max-w-[1700px] mx-auto px-5 md:px-8">

        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-newspaper"></i> Info & Tips Perjalanan
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white">
                Artikel <span class="text-teal-400">Terbaru</span>
            </h2>

            <p class="text-slate-400 mt-4 text-base md:text-lg max-w-2xl mx-auto">
                Tips, informasi dan berita terbaru seputar transportasi,
                rental mobil dan perjalanan.
            </p>

        </div>
        <!-- DATA -->

        <div id="load_data_berita" class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">

        </div>
        <!-- Skeleton -->

        <div id="load_data_message_berita"></div>

        <!-- Footer -->

        <div class="flex flex-col md:flex-row justify-between items-center mt-10 gap-3">

            <div
                class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2 backdrop-blur-md">

                <i class="fa-solid fa-newspaper text-teal-400"></i>

                <span class="text-slate-300">
                    Total Artikel
                </span>

                <span id="badge_berita"
                    class="custom-badge bg-teal-400 text-black font-bold rounded-full px-3 py-1 text-sm">
                    0
                </span>

            </div>

            <ul id="pagination_berita" class="pagination flex items-center gap-2">

            </ul>

        </div>

    </div>

</section>

<!-- REVIEW & MAP SECTION -->
<section id="review" class="py-24 bg-[#0F172A] border-t border-white/5">
    <div class="max-w-7xl mx-auto px-5 md:px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-location-dot text-teal-300"></i> Reputasi Terpercaya & Lokasi
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white">
                Kepuasan <span class="text-teal-400">Pelanggan Kami</span>
            </h2>
            <div class="inline-flex items-center gap-3 mt-4 px-5 py-2.5 rounded-full bg-white/[0.04] border border-white/10 text-sm text-slate-200 backdrop-blur-md">
                <span class="text-amber-300 font-extrabold flex items-center gap-1.5"><i class="fa-solid fa-star"></i> 4.9 / 5.0</span>
                <span class="text-slate-600">•</span>
                <span>Rating Sempurna dari Ulasan Terverifikasi Google Maps</span>
            </div>
        </div>

        <div class="grid xl:grid-cols-2 gap-10 items-start">
            <!-- MAP -->
            <div class="map-wrapper shadow-2xl" data-aos="fade-right">
                <div class="overflow-hidden rounded-3xl border border-white/10 relative h-[520px]">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4031.2647432648455!2d110.39620667508028!3d-7.115132292888454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4e0668b3b6c02d3%3A0x6bce558a24a94e79!2sGRAHA%20TRANSPORT!5e1!3m2!1sen!2sid!4v1779474357412!5m2!1sen!2sid"
                        class="absolute inset-0 w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                        title="Lokasi Graha Transport" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- REVIEWS -->
            <div class="grid md:grid-cols-2 gap-4" data-aos="fade-left">
                <div class="luxury-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-teal-400/20 text-teal-300 font-black flex items-center justify-center text-sm border border-teal-400/30">AP</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Andi Prasetyo</h4>
                                <div class="text-amber-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Pelayanan sangat ramah dan mobil sangat bersih. Wangi saat pertama kali masuk. Sangat direkomendasikan!"</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-400 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1.5"></i> Google Review</span>
                        <span class="text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>Terverifikasi</span>
                    </div>
                </div>

                <div class="luxury-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-orange-400/20 text-orange-300 font-black flex items-center justify-center text-sm border border-orange-400/30">RM</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Rina Maharani</h4>
                                <div class="text-amber-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Driver profesional dan paham jalan, perjalanan bisnis jadi terasa sangat nyaman dan efisien waktu."</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-400 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1.5"></i> Google Review</span>
                        <span class="text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>Terverifikasi</span>
                    </div>
                </div>

                <div class="luxury-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-purple-400/20 text-purple-300 font-black flex items-center justify-center text-sm border border-purple-400/30">BP</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Bagas Putra</h4>
                                <div class="text-amber-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Sangat cocok untuk perjalanan bisnis. Menyewa Alphard di sini adalah keputusan terbaik. Premium!"</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-400 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1.5"></i> Google Review</span>
                        <span class="text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>Terverifikasi</span>
                    </div>
                </div>

                <div class="luxury-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-cyan-400/20 text-cyan-300 font-black flex items-center justify-center text-sm border border-cyan-400/30">CD</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Citra Dewi</h4>
                                <div class="text-amber-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Recommended untuk keluarga dan wisata luar kota. Mobilnya aman dan nyaman dipakai berhari-hari."</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-400 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1.5"></i> Google Review</span>
                        <span class="text-emerald-400 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section id="faq" class="py-20 bg-[#0B1324] border-t border-white/5 relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-5 md:px-6 relative z-10">
        <div class="text-center mb-14" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-circle-question text-teal-300"></i> Tanya Jawab Rental
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white">
                Pertanyaan yang <span class="text-teal-400">Sering Diajukan</span>
            </h2>
            <p class="text-slate-400 mt-3 text-base md:text-lg">
                Informasi penting seputar syarat, fasilitas, dan ketentuan sewa di Graha Transport.
            </p>
        </div>

        <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
            <!-- FAQ 1 -->
            <div class="faq-item rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden transition duration-300">
                <button type="button" class="faq-toggle w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-white hover:text-teal-300 transition">
                    <span class="flex items-center gap-3 text-base md:text-lg">
                        <i class="fa-solid fa-car text-teal-400"></i>
                        Apakah sewa mobil bisa lepas kunci atau wajib dengan driver?
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    Graha Transport menyediakan opsi <strong>dengan driver (chauffeur)</strong> profesional untuk kenyamanan maksimal perjalanan Anda, serta opsi <strong>lepas kunci</strong> dengan syarat & verifikasi identitas yang mudah, cepat, dan aman.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="faq-item rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden transition duration-300">
                <button type="button" class="faq-toggle w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-white hover:text-teal-300 transition">
                    <span class="flex items-center gap-3 text-base md:text-lg">
                        <i class="fa-solid fa-map-location-dot text-teal-400"></i>
                        Area mana saja yang dijangkau untuk antar-jemput armada?
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    Kami melayani antar-jemput di seluruh wilayah <strong>Ungaran, Kota Semarang, Bandungan, Ambarawa, Salatiga</strong>, serta penjemputan khusus di <strong>Bandara Ahmad Yani, Stasiun Tawang, dan Stasiun Poncol</strong>.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="faq-item rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden transition duration-300">
                <button type="button" class="faq-toggle w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-white hover:text-teal-300 transition">
                    <span class="flex items-center gap-3 text-base md:text-lg">
                        <i class="fa-solid fa-file-invoice-dollar text-teal-400"></i>
                        Apakah melayani kebutuhan dinas instansi atau kontrak korporasi?
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    Ya, kami sangat berpengalaman melayani perjalanan dinas BUMN, kementerian, lembaga swasta, maupun perhotelan dengan kelengkapan <strong>legalitas perusahaan resmi, invoice, kwitansi, dan kontrak sewa berkala</strong>.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="faq-item rounded-2xl bg-white/[0.03] border border-white/10 overflow-hidden transition duration-300">
                <button type="button" class="faq-toggle w-full p-6 text-left flex items-center justify-between gap-4 font-bold text-white hover:text-teal-300 transition">
                    <span class="flex items-center gap-3 text-base md:text-lg">
                        <i class="fa-solid fa-clock text-teal-400"></i>
                        Bagaimana cara booking dan pembayaran?
                    </span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-content hidden px-6 pb-6 text-slate-300 text-sm leading-relaxed border-t border-white/5 pt-4">
                    Booking sangat fleksibel dan cepat melalui <strong>WhatsApp resmi Graha Transport</strong>. Setelah konfirmasi ketersediaan unit dan jadwal, Anda dapat melakukan pembayaran via transfer bank resmi perusahaan atau tunai saat serah terima unit.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FINAL CONVERSION CTA -->
<section class="py-16 bg-[#07111f] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <div class="rounded-[32px] p-8 md:p-12 bg-gradient-to-r from-[#132944] via-[#173354] to-[#0f243d] border border-teal-400/25 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-8" data-aos="fade-up">
            <div class="text-center lg:text-left max-w-2xl">
                <div class="eyebrow-badge mb-4">
                    <i class="fa-solid fa-calendar-check"></i> Siap Berangkat Kapan Saja
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">
                    Butuh Mobil Hari Ini? <span class="text-teal-400">Booking Unit Favorit Anda Sekarang!</span>
                </h2>
                <p class="text-slate-300 mt-3 text-base">
                    Konsultasikan kebutuhan sewa harian, mingguan, perjalanan dinas, atau wisata keluarga bersama admin Graha Transport.
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-4 shrink-0">
                <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20ingin%20booking%20mobil.%20Mohon%20info%20unit%20yang%20ready."
                    target="_blank" rel="noopener noreferrer"
                    class="luxury-shimmer-btn px-8 py-4 rounded-2xl font-black text-slate-950 flex items-center gap-3 shadow-xl shadow-teal-500/25 hover:shadow-teal-400/40 transition">
                    <i class="fa-brands fa-whatsapp text-xl"></i>
                    Booking via WhatsApp
                </a>
                <a href="#armada"
                    class="px-7 py-4 rounded-2xl border border-white/20 bg-white/5 hover:bg-white/10 hover:border-teal-400 transition font-bold text-white">
                    Pilih Armada
                </a>
            </div>
        </div>
    </div>
</section>