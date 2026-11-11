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
</style>

<!-- HERO SECTION -->
<section id="beranda" class="hero-bg min-h-screen flex items-center pt-20">
    <div class="max-w-7xl mx-auto px-5 md:px-6 py-12 grid lg:grid-cols-2 gap-14 items-center">

        <!-- TEXT CONTENT -->
        <div data-aos="fade-right">
            <div
                class="inline-flex items-center gap-2 border border-white/10 bg-white/5 rounded-full px-4 py-2 text-sm text-teal-300 mb-6 shadow-sm">
                <i class="fa-solid fa-star text-yellow-400"></i>
                Rental Mobil Ungaran & Semarang Terpercaya
            </div>

            <h1 class="hero-title text-5xl md:text-7xl font-extrabold leading-tight">
                Mobilitas Modern <br />
                <span class="text-teal-400">Dengan Pelayanan Premium</span>
            </h1>
            <p class="text-slate-200 text-lg mt-7 leading-relaxed max-w-lg">
                Graha Transport melayani rental mobil di Ungaran, Semarang, Bandungan, Ambarawa, Salatiga dan
                sekitarnya dengan armada nyaman dan driver profesional.
            </p>
            <div class="flex flex-wrap gap-4 mt-10">
                <a href="#armada"
                    class="btn-primary px-8 py-4 rounded-xl font-semibold text-black flex items-center gap-2">
                    Lihat Armada <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="https://wa.me/6281327160516" target="_blank" rel="noopener noreferrer"
                    class="border border-white/20 bg-white/5 hover:bg-white/10 hover:border-teal-400 transition px-8 py-4 rounded-xl font-semibold backdrop-blur-sm">
                    Konsultasi Gratis
                </a>
            </div>
        </div>

        <!-- HERO SLIDER -->
        <div data-aos="fade-left" data-aos-delay="200">
            <div class="hero-slider shadow-2xl">
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

                                    <a href="https://wa.me/6281327160516" target="_blank"
                                        class="btn-primary px-8 py-4 rounded-2xl font-bold text-black flex items-center gap-3">

                                        <i class="fa-brands fa-whatsapp"></i>

                                        Booking Sekarang

                                    </a>

                                    <a href="#armada"
                                        class="px-8 py-4 rounded-2xl border border-white/10 hover:border-teal-400 transition">

                                        Lihat Armada

                                    </a>

                                </div>

                            </div>

                            <!-- KANAN -->

                            <div class="promo-image">

                                <!-- <span class="promo-badge">

                                DISKON <?= $row->diskon ?>%

                            </span> -->

                                <img src="<?= base_url('assets/img/baner_promo/' . $row->foto_banner); ?>"
                                    alt="<?= $row->judul_promo; ?>">

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
                    aria-label="Tampilkan Promo <?= $i + 1; ?>"></button <?php
                                                                            $i++;
                                                                        }
                                                                            ?> </div>

        </div>

</section>

<!-- KEUNGGULAN SECTION -->
<section id="keunggulan" class="py-24 bg-[#0F172A] relative">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent">
    </div>

    <div class="max-w-7xl mx-auto px-5 md:px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">
                Kenapa Memilih <span class="text-teal-400">Graha Transport?</span>
            </h2>
            <p class="text-slate-300 max-w-2xl mx-auto text-lg">
                Pelayanan eksklusif dengan armada premium dan profesionalisme terbaik untuk menjamin kepuasan perjalanan
                Anda.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 xl:grid-cols-5 gap-6">

            <div class="card-dark rounded-3xl p-8 text-center sm:text-left" data-aos="fade-up" data-aos-delay="100">
                <div
                    class="w-16 h-16 rounded-2xl bg-teal-400/10 flex items-center justify-center sm:justify-start sm:bg-transparent mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-headset text-4xl text-teal-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">24 Jam Support</h3>
                <p class="text-slate-400 text-sm">Customer support aktif kapanpun Anda membutuhkan bantuan.</p>
            </div>

            <div class="card-dark rounded-3xl p-8 text-center sm:text-left" data-aos="fade-up" data-aos-delay="200">
                <div
                    class="w-16 h-16 rounded-2xl bg-orange-400/10 flex items-center justify-center sm:justify-start sm:bg-transparent mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-user-tie text-4xl text-orange-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Driver Expert</h3>
                <p class="text-slate-400 text-sm">Driver profesional yang ramah dan menguasai rute jalan raya.</p>
            </div>

            <div class="card-dark rounded-3xl p-8 text-center sm:text-left" data-aos="fade-up" data-aos-delay="300">
                <div
                    class="w-16 h-16 rounded-2xl bg-purple-400/10 flex items-center justify-center sm:justify-start sm:bg-transparent mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-car-side text-4xl text-purple-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Armada Premium</h3>
                <p class="text-slate-400 text-sm">Mobil keluaran terbaru yang sangat terawat dan wangi.</p>
            </div>

            <div class="card-dark rounded-3xl p-8 text-center sm:text-left" data-aos="fade-up" data-aos-delay="400">
                <div
                    class="w-16 h-16 rounded-2xl bg-cyan-400/10 flex items-center justify-center sm:justify-start sm:bg-transparent mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-map-location-dot text-4xl text-cyan-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Area Luas</h3>
                <p class="text-slate-400 text-sm">Siap melayani perjalanan di dalam maupun luar kota besar.</p>
            </div>

            <div class="card-dark rounded-3xl p-8 text-center sm:text-left" data-aos="fade-up" data-aos-delay="500">
                <div
                    class="w-16 h-16 rounded-2xl bg-pink-400/10 flex items-center justify-center sm:justify-start sm:bg-transparent mb-5 mx-auto sm:mx-0">
                    <i class="fa-solid fa-city text-4xl text-pink-400"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Corporate Ready</h3>
                <p class="text-slate-400 text-sm">Mendukung penyewaan operasional untuk perusahaan.</p>
            </div>

        </div>
    </div>
</section>

<!-- ARMADA SECTION -->
<section id="armada" class="py-18 relative">
    <div class="max-w-[1700px] mx-auto px-5 md:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold">
                Armada <span class="text-teal-400">Terbaik Kami</span>
            </h2>
            <p class="text-slate-400 mt-4 text-lg">
                Pilihan kendaraan modern untuk memastikan perjalanan yang nyaman dan elegan.
            </p>
        </div>

        <!-- SEGMENT 1: PERJALANAN DINAS TERJAMIN -->
        <div class="mb-10">

            <div class="mb-8 border-b border-white/10 pb-4" data-aos="fade-right">
                <h3 class="text-2xl font-bold text-white border-l-4 border-teal-400 pl-4">
                    PERJALANAN DINAS TERJAMIN
                </h3>
                <p class="text-slate-400 mt-2 pl-5 text-sm md:text-base">
                    Rasa Kuat dan Terpercaya untuk perjalanan dan kegiatan anda.
                </p>
            </div>

            <!-- DATA -->
            <div id="load_data_unggulan" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            </div>

            <!-- Skeleton -->
            <div id="load_data_message_unggulan"></div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-2 mb-2">

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
        <div class="mb-10 mt-7">

            <div class="mb-8 border-b border-white/10 pb-4" data-aos="fade-right">

                <h3 class="text-2xl font-bold text-white border-l-4 border-orange-400 pl-4">
                    TEMAN MAIN FAVORIT
                </h3>

                <p class="text-slate-400 mt-2 pl-5 text-sm md:text-base">
                    Armada setia anter kamu kemana aja. Anti panas anti lemas!
                </p>

            </div>

            <div id="load_data_favorit" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            </div>

            <div id="load_data_message_favorit"></div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-2 mb-2">

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
        <div class="mb-0 mt-7">

            <div class="mb-8 border-b border-white/10 pb-4" data-aos="fade-right">

                <h3 class="text-2xl font-bold text-white border-l-4 border-purple-400 pl-4">
                    PILIHAN TERBAIK KELUARGA
                </h3>

                <p class="text-slate-400 mt-2 pl-5 text-sm md:text-base">
                    Siap tampung keluarga, masih sisa angkut tetangga!
                </p>

            </div>

            <div id="load_data_keluarga" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            </div>

            <div id="load_data_message_keluarga"></div>

            <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-2 mb-2">

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

<!-- CLIENT KAMI -->
<section id="client" class="py-10 bg-[#0F172A] relative overflow-hidden">

    <div class="max-w-7xl mx-auto px-5">

        <div class="text-center mb-10" data-aos="fade-up">
            <h2 class="text-4xl font-bold">
                Dipercaya <span class="text-teal-400">Client Kami</span>
            </h2>

            <p class="text-slate-300 mt-3">
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

<section id="berita" class="py-2 mt-1 relative">

    <div class="max-w-[1700px] mx-auto px-5 md:px-8">

        <div class="text-center mb-16" data-aos="fade-up">

            <h2 class="text-4xl md:text-5xl font-bold">

                Artikel <span class="text-teal-400">Terbaru</span>

            </h2>

            <p class="text-slate-400 mt-4 text-lg">

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
            <h2 class="text-4xl md:text-5xl font-bold">
                Lokasi & <span class="text-teal-400">Review Pelanggan</span>
            </h2>
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
            <div class="grid md:grid-cols-2 gap-2" data-aos="fade-left">
                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-xl mb-2 text-white">Andi Prasetyo</h4>
                        <div class="text-yellow-400 mb-4 text-sm tracking-widest"><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="text-slate-400 italic">"Pelayanan sangat ramah dan mobil sangat bersih. Wangi saat
                            pertama kali masuk. Sangat direkomendasikan!"</p>
                    </div>
                    <div class="mt-4 text-xs text-slate-500 text-right">Direview di Google</div>
                </div>

                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-xl mb-2 text-white">Rina Maharani</h4>
                        <div class="text-yellow-400 mb-4 text-sm tracking-widest"><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="text-slate-400 italic">"Driver profesional dan paham jalan, perjalanan bisnis jadi
                            terasa sangat nyaman dan efisien waktu."</p>
                    </div>
                    <div class="mt-4 text-xs text-slate-500 text-right">Direview di Google</div>
                </div>

                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-xl mb-2 text-white">Bagas Putra</h4>
                        <div class="text-yellow-400 mb-4 text-sm tracking-widest"><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="text-slate-400 italic">"Sangat cocok untuk perjalanan bisnis. Menyewa Alphard di
                            sini adalah keputusan terbaik. Premium!"</p>
                    </div>
                    <div class="mt-4 text-xs text-slate-500 text-right">Direview di Google</div>
                </div>

                <div class="review-card rounded-3xl p-7 flex flex-col justify-between">
                    <div>
                        <h4 class="font-bold text-xl mb-2 text-white">Citra Dewi</h4>
                        <div class="text-yellow-400 mb-4 text-sm tracking-widest"><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        <p class="text-slate-400 italic">"Recommended untuk keluarga dan wisata luar kota. Mobilnya
                            aman dan nyaman dipakai berhari-hari."</p>
                    </div>
                    <div class="mt-4 text-xs text-slate-500 text-right">Direview di Google</div>
                </div>
            </div>
        </div>
    </div>
</section>