<!-- KONTAK SECTION (SESUAI DESAIN REFERENSI DENGAN BACKGROUND ANIMASI) -->
<section id="kontak" class="relative overflow-hidden py-20 lg:py-28 border-t border-white/10">
    <!-- BACKGROUND IMAGE FLEET DENGAN OVERLAY MEWAH -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="<?= base_url('assets/img/kontak_bg.jpg'); ?>" alt="Armada Graha Transport"
            class="w-full h-full object-cover object-center filter brightness-75">
        <!-- Multi-layer Gradient: pekat di kiri untuk teks, transparan di kanan untuk visual mobil -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#050f1d] via-[#07162b]/95 to-[#081e3a]/75"></div>
        <div class="absolute inset-0 bg-[#050d1a]/50"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#07111f] via-transparent to-[#050b14]"></div>
    </div>

    <!-- LAYER ANIMASI BACKGROUND AUTOMOTIVE HIGHWAY & SPEED BEAMS -->
    <div class="kontak-anim-wrap">
        <!-- 1. Lantai Grid Perspektif Jalan Tol Modern -->
        <div class="kontak-road-grid"></div>

        <!-- 2. Ambient Headlight Glow Orbs (Pendaran Cahaya Mobil) -->
        <div class="headlight-glow-orb w-[550px] h-[350px] bg-teal-500/15 top-10 -right-20"></div>
        <div class="headlight-glow-orb w-[400px] h-[300px] bg-sky-500/10 top-1/2 left-10" style="animation-delay: -3s;"></div>

        <!-- 3. Radar Pulse Signal di Belakang Kartu Kontak -->
        <div class="absolute right-[12%] top-[30%] -translate-y-1/2 w-[420px] h-[420px] pointer-events-none opacity-30 hidden lg:block">
            <span class="absolute inset-0 rounded-full border border-teal-400/30 animate-ping" style="animation-duration: 4s;"></span>
            <span class="absolute inset-12 rounded-full border border-teal-400/20 animate-ping" style="animation-duration: 4s; animation-delay: 1.5s;"></span>
            <span class="absolute inset-24 rounded-full border border-teal-400/15 animate-ping" style="animation-duration: 4s; animation-delay: 2.8s;"></span>
        </div>

        <!-- 4. Garis Berkas Cahaya Cepat (Speed Light Streaks) -->
        <div class="speed-beam speed-beam-teal" style="top: 22%;"></div>
        <div class="speed-beam speed-beam-cyan" style="top: 45%;"></div>
        <div class="speed-beam speed-beam-emerald" style="top: 68%;"></div>
        <div class="speed-beam speed-beam-amber" style="bottom: 70px;"></div>
        <div class="speed-beam speed-beam-red" style="bottom: 35px;"></div>

        <!-- 5. Siluet Mobil Melaju dengan Sorotan Lampu Depan & Roda Berputar -->
        <div class="moving-car-runner">
            <!-- Sorotan Kerucut Cahaya Lampu Depan (Headlight Cone Beam) -->
            <div class="absolute left-[138px] top-[14px] w-[280px] h-[55px] pointer-events-none"
                 style="background: linear-gradient(90deg, rgba(255,255,255,0.75) 0%, rgba(45,212,191,0.35) 35%, rgba(45,212,191,0.08) 75%, transparent 100%);
                        clip-path: polygon(0 42%, 100% 0, 100% 100%, 0 58%);
                        filter: blur(2px);">
            </div>
            <!-- Pendaran Lampu Belakang Merah -->
            <div class="absolute left-[-15px] top-[20px] w-[50px] h-[15px] pointer-events-none"
                 style="background: radial-gradient(circle, rgba(239,68,68,0.85) 0%, transparent 80%); filter: blur(3px);">
            </div>
            <!-- SVG Mobil Futuristik -->
            <svg viewBox="0 0 150 45" class="w-full h-full drop-shadow-[0_4px_14px_rgba(45,212,191,0.45)]">
                <!-- Bodi Mobil -->
                <path d="M 5,26 C 5,26 8,18 20,18 L 40,18 C 48,18 55,9 70,8 L 105,8 C 118,8 128,15 133,20 L 144,22 C 147,23 148,25 148,28 L 148,32 C 148,34 146,35 144,35 L 132,35 C 130,30 124,26 117,26 C 110,26 104,30 102,35 L 48,35 C 46,30 40,26 33,26 C 26,26 20,30 18,35 L 7,35 C 5,35 4,33 4,31 Z"
                      fill="#07111f" stroke="#2dd4bf" stroke-width="1.5" />
                <!-- Kaca Mobil -->
                <path d="M 46,17 L 69,11 L 102,11 C 112,11 119,16 123,20 L 46,20 Z"
                      fill="rgba(45, 212, 191, 0.3)" stroke="#38bdf8" stroke-width="0.9" />
                <!-- Lampu LED Depan & Belakang -->
                <circle cx="145" cy="24" r="2.5" fill="#ffffff" filter="drop-shadow(0 0 6px #2dd4bf)" />
                <circle cx="6" cy="22" r="2" fill="#ef4444" filter="drop-shadow(0 0 6px #ef4444)" />
                <!-- Roda Depan Berputar -->
                <g transform="translate(117, 34)">
                    <circle cx="0" cy="0" r="7.5" fill="#0b1322" stroke="#2dd4bf" stroke-width="1.8" />
                    <circle cx="0" cy="0" r="3" fill="#2dd4bf" />
                    <g class="wheel-spin">
                        <line x1="-5" y1="0" x2="5" y2="0" stroke="#38bdf8" stroke-width="1.2" />
                        <line x1="0" y1="-5" x2="0" y2="5" stroke="#38bdf8" stroke-width="1.2" />
                    </g>
                </g>
                <!-- Roda Belakang Berputar -->
                <g transform="translate(33, 34)">
                    <circle cx="0" cy="0" r="7.5" fill="#0b1322" stroke="#2dd4bf" stroke-width="1.8" />
                    <circle cx="0" cy="0" r="3" fill="#2dd4bf" />
                    <g class="wheel-spin">
                        <line x1="-5" y1="0" x2="5" y2="0" stroke="#38bdf8" stroke-width="1.2" />
                        <line x1="0" y1="-5" x2="0" y2="5" stroke="#38bdf8" stroke-width="1.2" />
                    </g>
                </g>
            </svg>
        </div>

        <!-- 6. Floating Sparkles / Partikel Cahaya Halus -->
        <div class="kontak-sparkle" style="top: 25%; left: 15%; animation-delay: 0s;"></div>
        <div class="kontak-sparkle" style="top: 60%; left: 45%; animation-delay: 1.8s;"></div>
        <div class="kontak-sparkle" style="top: 35%; right: 25%; animation-delay: 3.2s;"></div>
        <div class="kontak-sparkle" style="top: 75%; right: 10%; animation-delay: 2.1s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-5 md:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
            
            <!-- KOLOM KIRI: HEADLINE & DESKRIPSI -->
            <div class="lg:col-span-7" data-aos="fade-right">
                <!-- Eyebrow Title -->
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs uppercase tracking-[0.25em] text-teal-400 font-bold">KONTAK</span>
                    <div class="h-[1.5px] w-12 bg-teal-400/50"></div>
                </div>

                <!-- Main Heading (Serif Mewah Sesuai Mockup) -->
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-[1.15] mb-6 font-serif">
                    Hubungi Kami <br class="hidden sm:inline">untuk Penawaran <br class="hidden sm:inline"><span class="text-teal-400">Sewa Mobil Terbaik!</span>
                </h2>

                <!-- Description Text -->
                <p class="text-slate-300 text-sm sm:text-base md:text-lg leading-relaxed max-w-xl font-normal">
                    Jadikan <span class="text-white font-semibold">Graha Transport</span> sebagai mitra sewa mobil terpercaya bagi perjalanan pribadi maupun operasional perusahaan Anda. Hubungi kami sekarang untuk mendapatkan penawaran terbaik, baik sewa mobil harian maupun jangka panjang, dengan driver atau lepas kunci, untuk solusi perjalanan yang efisien, andal, dan bebas ribet!
                </p>
            </div>

            <!-- KOLOM KANAN: KARTU KONTAK CTA -->
            <div class="lg:col-span-5 flex flex-col gap-4" data-aos="fade-left">
                <!-- Pill: Tim Siap Membantu -->
                <div class="self-start inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-[#0a192f]/90 border border-teal-500/30 text-teal-300 text-xs font-semibold backdrop-blur-md shadow-lg shadow-teal-950/40">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span>Tim kami siap membantu</span>
                </div>

                <!-- Card 1: Chat WhatsApp (Solid White) -->
                <a href="https://wa.me/6281327160516?text=Halo%20Graha%20Transport,%20saya%20ingin%20konsultasi%20dan%20penawaran%20sewa%20mobil."
                   target="_blank" rel="noopener noreferrer"
                   class="group flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-white text-slate-900 shadow-2xl hover:shadow-teal-500/20 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#25D366] text-white flex items-center justify-center text-2xl shadow-md group-hover:scale-110 transition-transform duration-300 shrink-0">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold tracking-widest text-slate-500 uppercase">CHAT WHATSAPP</div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">0813 2716 0516</div>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 group-hover:bg-teal-400 group-hover:text-black group-hover:translate-x-1 transition-all duration-300 shrink-0">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </div>
                </a>

                <!-- Card 2: Call Center / Telepon (Dark Glass) -->
                <a href="tel:+6281327160516"
                   class="group flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-slate-800/60 hover:bg-slate-800/80 border border-white/20 backdrop-blur-md text-white shadow-2xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 text-teal-300 flex items-center justify-center text-xl shadow-md group-hover:scale-110 transition-transform duration-300 shrink-0">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold tracking-widest text-slate-300 uppercase">CALL CENTER / TELEPON</div>
                            <div class="text-xl sm:text-2xl font-black text-white tracking-tight">0813 2716 0516</div>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white group-hover:bg-teal-400 group-hover:text-black group-hover:translate-x-1 transition-all duration-300 shrink-0">
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </div>
                </a>

                <!-- Sub-link: Kunjungi Kantor Terdekat / Google Maps -->
                <div class="pt-2 text-center sm:text-left">
                    <a href="https://maps.google.com/?q=Graha+Transport+Ungaran" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 text-sm text-slate-300 hover:text-teal-400 transition underline underline-offset-4 font-medium">
                        <i class="fa-solid fa-location-dot text-teal-400"></i>
                        <span>Atau kunjungi kantor terdekat / Google Maps</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>
            </div>

        </div>

        <!-- BOTTOM STRIP: 3 KEUNGGULAN / USP BAR -->
        <div class="border-t border-white/15 mt-14 pt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center gap-3.5 text-slate-200">
                <div class="w-7 h-7 rounded-full bg-teal-500/20 border border-teal-500/40 text-teal-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-xs"></i>
                </div>
                <span class="text-sm font-medium">Titik layanan Ungaran, Semarang & Luar Kota</span>
            </div>
            <div class="flex items-center gap-3.5 text-slate-200">
                <div class="w-7 h-7 rounded-full bg-teal-500/20 border border-teal-500/40 text-teal-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-xs"></i>
                </div>
                <span class="text-sm font-medium">Layanan darurat & respon cepat 24 jam</span>
            </div>
            <div class="flex items-center gap-3.5 text-slate-200">
                <div class="w-7 h-7 rounded-full bg-teal-500/20 border border-teal-500/40 text-teal-400 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-xs"></i>
                </div>
                <span class="text-sm font-medium">Armada prima, bersih & terawat rutin</span>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER BASE -->
<footer class="py-16 bg-[#040810] border-t border-white/10 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 md:px-8 grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">

        <!-- Kolom 1: Brand & Sosial Media -->
        <div>
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 flex items-center justify-center overflow-hidden shrink-0">
                    <img src="<?= base_url('assets'); ?>/img/logo/logo.png" alt="Logo Graha Transport"
                        class="w-full h-full object-contain">
                </div>
                <h3 class="text-2xl font-extrabold italic tracking-tight text-white">
                    GRAHA<span class="text-teal-400">TRANSPORT</span>
                </h3>
            </div>

            <p class="text-slate-400 leading-relaxed text-sm max-w-sm">
                Solusi rental mobil premium terpercaya di Ungaran, Semarang, dan sekitarnya. Mengedepankan keamanan, armada modern yang prima, dan keramahan driver profesional.
            </p>

            <div class="flex gap-3 mt-6">
                <a href="#" aria-label="Instagram"
                    class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-teal-400 hover:text-black transition duration-300">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" aria-label="Facebook"
                    class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-teal-400 hover:text-black transition duration-300">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="TikTok"
                    class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-teal-400 hover:text-black transition duration-300">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
            </div>
        </div>

        <!-- Kolom 2: Informasi Kantor & Kontak -->
        <div>
            <h4 class="text-lg font-semibold mb-6 border-b border-white/10 pb-3 inline-block text-white">Informasi Kontak</h4>
            <div class="space-y-4 text-slate-400 text-sm">
                <div class="flex gap-3 items-start">
                    <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-location-dot text-teal-400"></i>
                    </div>
                    <span class="pt-1">Jl. Arjuna III No.17, Mapagan<br />Kabupaten Semarang, Jawa Tengah</span>
                </div>
                <div class="flex gap-3 items-center">
                    <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-phone text-teal-400"></i>
                    </div>
                    <span>+62 813-2716-0516</span>
                </div>
                <div class="flex gap-3 items-center">
                    <div class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-envelope text-teal-400"></i>
                    </div>
                    <span>grahatransportungaran@gmail.com</span>
                </div>
            </div>
        </div>

        <!-- Kolom 3: Navigasi Cepat (Armada urutan 2 setelah Beranda) -->
        <div>
            <h4 class="text-lg font-semibold mb-6 border-b border-white/10 pb-3 inline-block text-white">Navigasi Cepat</h4>
            <div class="flex flex-col gap-2.5 text-slate-400 text-sm">
                <a href="#beranda" class="hover:text-teal-400 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-[10px] text-teal-400/50"></i> Beranda
                </a>
                <a href="#armada" class="hover:text-teal-400 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-[10px] text-teal-400/50"></i> Armada Pilihan
                </a>
                <a href="#layanan" class="hover:text-teal-400 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-[10px] text-teal-400/50"></i> Layanan Kami
                </a>
                <a href="#keunggulan" class="hover:text-teal-400 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-[10px] text-teal-400/50"></i> Keunggulan
                </a>
                <a href="#wilayah" class="hover:text-teal-400 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-[10px] text-teal-400/50"></i> Jangkauan Wilayah
                </a>
                <a href="#review" class="hover:text-teal-400 transition flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-[10px] text-teal-400/50"></i> Review Pelanggan
                </a>
            </div>
        </div>

    </div>

    <div class="border-t border-white/10 mt-12 pt-8 text-center text-slate-500 text-xs relative z-10 max-w-7xl mx-auto px-5">
        &copy; <?= date('Y'); ?> GRAHA TRANSPORT. All Rights Reserved.
    </div>
</footer>

<!-- FLOATING WHATSAPP -->
<a href="https://wa.me/6281327160516" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp"
    class="wa-float fixed bottom-6 right-6 md:bottom-8 md:right-8 w-16 h-16 rounded-full bg-[#25D366] flex items-center justify-center text-3xl z-50 hover:scale-110 transition-transform shadow-2xl">
    <i class="fa-brands fa-whatsapp text-white"></i>
</a>
