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
    }

    .client-track {
        display: flex;
        align-items: center;
        gap: 40px;
        width: max-content;
        animation: clientScroll 30s linear infinite;
        will-change: transform;
    }

    .client-item {
        width: 180px;
        height: 100px;
        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #172338;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 18px;
        padding: 20px;

        transition: .3s;
    }

    .client-item:hover {
        transform: translateY(-5px);
        border-color: #2dd4bf;
    }

    .client-item img {
        max-width: 100%;
        max-height: 70px;
        object-fit: contain;

        filter: brightness(0) invert(1);

        transition: all .35s ease;
    }

    .client-item:hover img {
        filter: none;
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
    <!-- Ambient Glow & Grid -->
    <div class="absolute top-16 -left-24 w-96 h-96 bg-teal-500/15 blur-[130px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-10 -right-24 w-96 h-96 bg-cyan-500/15 blur-[130px] rounded-full pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 py-8 grid lg:grid-cols-2 gap-12 lg:gap-16 items-center relative z-10">

        <!-- TEXT CONTENT -->
        <div data-aos="fade-right">
            <div class="eyebrow-badge mb-6">
                <i class="fa-solid fa-star text-yellow-400"></i>
                Rental Mobil Ungaran & Semarang Terpercaya
            </div>

            <h1 class="hero-title text-4xl sm:text-5xl md:text-6xl xl:text-[64px] font-extrabold leading-[1.1] tracking-tight text-white">
                Perjalanan Nyaman <br />
                <span class="bg-gradient-to-r from-teal-300 via-teal-400 to-cyan-300 bg-clip-text text-transparent">
                    Berstandar Premium
                </span>
            </h1>

            <p class="text-slate-300 text-base md:text-lg mt-6 leading-relaxed max-w-xl">
                Graha Transport hadir dengan armada keluaran terbaru yang bersih, wangi, dan selalu terawat untuk
                kebutuhan dinas, wisata keluarga, maupun korporasi di Ungaran, Semarang, Bandungan, Ambarawa, dan Salatiga.
            </p>

            <div class="flex flex-wrap gap-4 mt-9">
                <a href="#armada"
                    class="btn-primary px-8 py-4 rounded-2xl font-bold text-slate-950 flex items-center gap-2.5 shadow-lg shadow-teal-500/25">
                    Lihat Armada & Harga <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20ingin%20konsultasi%20dan%20cek%20ketersediaan%20unit%20mobil."
                    target="_blank" rel="noopener noreferrer"
                    class="border border-white/20 bg-white/5 hover:bg-white/10 hover:border-teal-400 transition px-7 py-4 rounded-2xl font-semibold text-white backdrop-blur-sm flex items-center gap-2.5">
                    <i class="fa-brands fa-whatsapp text-teal-400 text-lg"></i>
                    Konsultasi Gratis
                </a>
            </div>

            <!-- QUICK TRUST STATS -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-10 pt-8 border-t border-white/10">
                <div>
                    <div class="text-2xl font-extrabold text-white">13+</div>
                    <div class="text-xs text-slate-400 mt-0.5">Pilihan Armada</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-teal-400">24/7</div>
                    <div class="text-xs text-slate-400 mt-0.5">Layanan & Support</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-white">4.9 ★</div>
                    <div class="text-xs text-slate-400 mt-0.5">Rating Pelanggan</div>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-teal-400">100%</div>
                    <div class="text-xs text-slate-400 mt-0.5">Unit Bersih & Prima</div>
                </div>
            </div>
        </div>

        <!-- HERO SLIDER -->
        <div data-aos="fade-left" data-aos-delay="200" class="relative">
            <div class="p-2.5 rounded-[32px] bg-white/5 border border-white/10 backdrop-blur-md shadow-2xl">
                <div class="hero-slider rounded-[24px] overflow-hidden relative">
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

            <!-- FLOATING STATUS BADGE -->
            <div class="hidden sm:flex items-center gap-3 absolute -bottom-5 left-6 bg-[#0f1d33]/95 border border-teal-400/30 rounded-2xl px-4 py-3 shadow-xl backdrop-blur-md">
                <span class="w-3 h-3 rounded-full bg-teal-400 animate-pulse"></span>
                <div>
                    <div class="text-xs font-bold text-white">Siap Antar-Jemput 24 Jam</div>
                    <div class="text-[11px] text-slate-400">Ungaran • Semarang • Luar Kota</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================= -->
<!-- PROMO BANNER -->
<!-- ========================================= -->
<section class="py-12 bg-[#07111f] relative overflow-hidden">

    <!-- Glow -->
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-teal-400/10 blur-[120px] rounded-full"></div>
    <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-cyan-400/10 blur-[120px] rounded-full"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">

        <div class="relative overflow-hidden rounded-[35px]
            border border-white/10
            bg-gradient-to-r
            from-[#13233b]
            via-[#162844]
            to-[#13233b]
            shadow-2xl">

            <!-- Background -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -right-24 -top-24 w-72 h-72 rounded-full border-[40px] border-teal-400"></div>
                <div class="absolute -left-20 bottom-0 w-56 h-56 rounded-full border-[30px] border-cyan-400"></div>
            </div>

            <!-- PROMO TRACK -->
            <div class="promo-slider">
                <div id="promoTrack" class="promo-track">
                    <?php foreach ($promo->result() as $row) { ?>
                        <div class="promo-slide">

                            <!-- KIRI -->
                            <div class="promo-content">
                                <span class="promo-label">
                                    <i class="fa-solid fa-gift"></i>
                                    <?= $row->tagline ?>
                                </span>

                                <h2 class="promo-title">
                                    <?= $row->judul_promo ?>
                                </h2>

                                <p class="promo-desc">
                                    <?= $row->ket_promo ?>
                                </p>

                                <div class="flex flex-wrap gap-4 mt-8">
                                    <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport%2C%20saya%20tertarik%20dengan%20promo%20<?= rawurlencode($row->judul_promo); ?>"
                                        target="_blank" rel="noopener noreferrer"
                                        class="btn-primary px-8 py-4 rounded-2xl font-bold text-black flex items-center gap-3">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        Booking Sekarang
                                    </a>

                                    <a href="#armada"
                                        class="px-8 py-4 rounded-2xl border border-white/15 hover:border-teal-400 hover:bg-white/5 transition font-semibold text-white">
                                        Lihat Armada
                                    </a>
                                </div>
                            </div>

                            <!-- KANAN -->
                            <div class="promo-image">
                                <img src="<?= base_url('assets/img/baner_promo/' . $row->foto_banner); ?>"
                                    alt="<?= $row->judul_promo; ?>" loading="lazy">
                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>

        <!-- DOTS -->
        <div class="promo-dots flex justify-center gap-3 mt-8">
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

<!-- KEUNGGULAN SECTION -->
<section id="keunggulan" class="py-24 bg-[#0F172A] relative">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="eyebrow-badge mb-4">
                <i class="fa-solid fa-shield-halved"></i> Keunggulan Layanan
            </div>
            <h2 class="text-3xl md:text-5xl font-bold mb-4 text-white">
                Kenapa Memilih <span class="text-teal-400">Graha Transport?</span>
            </h2>
            <p class="text-slate-300 max-w-2xl mx-auto text-base md:text-lg">
                Standar pelayanan eksklusif dengan armada terawat rutin dan tim profesional untuk menjamin kenyamanan perjalanan Anda.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 xl:grid-cols-5 gap-6">

            <div class="card-dark rounded-3xl p-7 text-center sm:text-left hover:border-teal-400/50 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 rounded-2xl bg-teal-400/10 border border-teal-400/20 flex items-center justify-center mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-headset text-2xl text-teal-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">24 Jam Support</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Respon cepat & customer support aktif kapanpun Anda membutuhkan bantuan.</p>
            </div>

            <div class="card-dark rounded-3xl p-7 text-center sm:text-left hover:border-orange-400/50 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 rounded-2xl bg-orange-400/10 border border-orange-400/20 flex items-center justify-center mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-user-tie text-2xl text-orange-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Driver Expert</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Driver berpengalaman, ramah, rapi, dan menguasai rute dalam & luar kota.</p>
            </div>

            <div class="card-dark rounded-3xl p-7 text-center sm:text-left hover:border-purple-400/50 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 rounded-2xl bg-purple-400/10 border border-purple-400/20 flex items-center justify-center mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-car-side text-2xl text-purple-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Armada Premium</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Unit keluaran terbaru, servis berkala terjamin, kabin bersih & wangi.</p>
            </div>

            <div class="card-dark rounded-3xl p-7 text-center sm:text-left hover:border-cyan-400/50 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="w-14 h-14 rounded-2xl bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-map-location-dot text-2xl text-cyan-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Jangkauan Luas</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Melayani Ungaran, Semarang, Bandungan, Salatiga hingga perjalanan luar kota.</p>
            </div>

            <div class="card-dark rounded-3xl p-7 text-center sm:text-left hover:border-pink-400/50 transition-all duration-300" data-aos="fade-up" data-aos-delay="500">
                <div class="w-14 h-14 rounded-2xl bg-pink-400/10 border border-pink-400/20 flex items-center justify-center mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-city text-2xl text-pink-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Corporate Ready</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Siap mendukung sewa operasional kantor, instansi, dan tamu VIP perusahaan.</p>
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
            <div class="rounded-3xl bg-[#132038] border border-white/10 p-7 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between mb-5">
                    <span class="w-11 h-11 rounded-2xl bg-teal-400 text-slate-950 font-extrabold text-lg flex items-center justify-center">1</span>
                    <i class="fa-solid fa-car text-2xl text-teal-400/40"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Pilih Unit Favorit</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Sesuaikan pilihan mobil dengan kebutuhan Anda—mulai dari city car, SUV tangguh, hingga MPV keluarga & VIP.</p>
            </div>

            <div class="rounded-3xl bg-[#132038] border border-white/10 p-7 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-between mb-5">
                    <span class="w-11 h-11 rounded-2xl bg-teal-400 text-slate-950 font-extrabold text-lg flex items-center justify-center">2</span>
                    <i class="fa-brands fa-whatsapp text-2xl text-teal-400/40"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Konfirmasi via WhatsApp</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Klik tombol Booking Sekarang, informasikan tanggal sewa dan lokasi penjemputan kepada admin kami.</p>
            </div>

            <div class="rounded-3xl bg-[#132038] border border-white/10 p-7 relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center justify-between mb-5">
                    <span class="w-11 h-11 rounded-2xl bg-teal-400 text-slate-950 font-extrabold text-lg flex items-center justify-center">3</span>
                    <i class="fa-solid fa-key text-2xl text-teal-400/40"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Unit Siap Meluncur</h3>
                <p class="text-slate-400 text-sm leading-relaxed">Mobil datang tepat waktu dalam kondisi bersih, wangi, dan siap menemani perjalanan Anda dengan aman.</p>
            </div>
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

<!-- ============================= -->
<!-- CLIENT KAMI -->
<!-- ============================= -->
<section id="client" class="py-16 bg-[#0F172A] relative overflow-hidden border-t border-white/5">

    <div class="max-w-7xl mx-auto px-5">

        <div class="text-center mb-12" data-aos="fade-up">
            <div class="eyebrow-badge mb-3">
                <i class="fa-solid fa-handshake"></i> Partner & Instansi
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-white">
                Dipercaya <span class="text-teal-400">Client Kami</span>
            </h2>

            <p class="text-slate-300 mt-3 max-w-2xl mx-auto">
                Berbagai instansi, perusahaan dan organisasi telah mempercayakan
                kebutuhan transportasinya kepada Graha Transport.
            </p>
        </div>

        <div class="client-slider pt-3">
            <div class="client-track">

                <!-- LOOP PERTAMA -->
                <?php foreach ($client->result() as $key => $row) { ?>
                    <div class="client-item">
                        <img src="<?= base_url('assets/img/baner_slider/' . $row->foto_banner); ?>"
                            alt="Logo Client Graha Transport <?= $key + 1; ?>" loading="lazy">
                    </div>
                <?php } ?>

                <!-- LOOP KEDUA (UNTUK EFEK MARQUEE/SLIDER INFINITE) -->
                <?php foreach ($client->result() as $key => $row) { ?>
                    <div class="client-item">
                        <img src="<?= base_url('assets/img/baner_slider/' . $row->foto_banner); ?>"
                            alt="Logo Client Graha Transport <?= $key + 1; ?>" loading="lazy">
                    </div>
                <?php } ?>

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
                <i class="fa-solid fa-location-dot"></i> Testimoni & Lokasi
            </div>
            <h2 class="text-3xl md:text-5xl font-bold text-white">
                Lokasi & <span class="text-teal-400">Review Pelanggan</span>
            </h2>
            <div class="inline-flex items-center gap-2.5 mt-4 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-sm text-slate-200">
                <span class="text-yellow-400 font-bold"><i class="fa-solid fa-star"></i> 4.9 / 5.0</span>
                <span class="text-slate-500">•</span>
                <span>Ulasan Pelanggan Terverifikasi di Google Maps</span>
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
                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-teal-400/20 text-teal-300 font-bold flex items-center justify-center text-sm">AP</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Andi Prasetyo</h4>
                                <div class="text-yellow-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Pelayanan sangat ramah dan mobil sangat bersih. Wangi saat pertama kali masuk. Sangat direkomendasikan!"</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-500 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1"></i> Google Review</span>
                        <span class="text-teal-400/80">Terverifikasi</span>
                    </div>
                </div>

                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-orange-400/20 text-orange-300 font-bold flex items-center justify-center text-sm">RM</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Rina Maharani</h4>
                                <div class="text-yellow-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Driver profesional dan paham jalan, perjalanan bisnis jadi terasa sangat nyaman dan efisien waktu."</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-500 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1"></i> Google Review</span>
                        <span class="text-teal-400/80">Terverifikasi</span>
                    </div>
                </div>

                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-purple-400/20 text-purple-300 font-bold flex items-center justify-center text-sm">BP</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Bagas Putra</h4>
                                <div class="text-yellow-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Sangat cocok untuk perjalanan bisnis. Menyewa Alphard di sini adalah keputusan terbaik. Premium!"</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-500 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1"></i> Google Review</span>
                        <span class="text-teal-400/80">Terverifikasi</span>
                    </div>
                </div>

                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-cyan-400/20 text-cyan-300 font-bold flex items-center justify-center text-sm">CD</div>
                            <div>
                                <h4 class="font-bold text-lg text-white leading-tight">Citra Dewi</h4>
                                <div class="text-yellow-400 text-xs tracking-widest mt-0.5"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed italic">"Recommended untuk keluarga dan wisata luar kota. Mobilnya aman dan nyaman dipakai berhari-hari."</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/5 text-xs text-slate-500 flex items-center justify-between">
                        <span><i class="fa-brands fa-google text-teal-400 mr-1"></i> Google Review</span>
                        <span class="text-teal-400/80">Terverifikasi</span>
                    </div>
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
                    class="btn-primary px-8 py-4 rounded-2xl font-bold text-slate-950 flex items-center gap-3 shadow-xl shadow-teal-500/25">
                    <i class="fa-brands fa-whatsapp text-xl"></i>
                    Booking via WhatsApp
                </a>
                <a href="#armada"
                    class="px-7 py-4 rounded-2xl border border-white/20 bg-white/5 hover:bg-white/10 hover:border-teal-400 transition font-semibold text-white">
                    Pilih Armada
                </a>
            </div>
        </div>
    </div>
</section>