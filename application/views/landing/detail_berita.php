<style>
.article-content {

    font-size: 18px;

    line-height: 2.2;

    color: #d4d4d8;

}

.article-content p {

    margin-bottom: 25px;

}

.article-content img {

    border-radius: 25px;

}

.article-content a {

    color: #2dd4bf;

}

.article-content strong {

    color: white;

}

.article-content ul {

    padding-left: 25px;

    list-style: disc;

}

.article-content ol {

    padding-left: 25px;

    list-style: decimal;

}

/* css conten artikel */

.article-content {
    color: #cbd5e1;
    font-size: 18px;
    line-height: 2;
}

/* Heading */

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    color: #fff;
    font-weight: 700;
    margin-top: 35px;
    margin-bottom: 20px;
    line-height: 1.4;
}

.article-content h1 {
    font-size: 40px;
}

.article-content h2 {
    font-size: 34px;
}

.article-content h3 {
    font-size: 28px;
}

.article-content h4 {
    font-size: 24px;
}

/* Paragraph */

.article-content p {
    margin-bottom: 22px;
    text-align: justify;
}

/* Link */

.article-content a {
    color: #2dd4bf;
    text-decoration: none;
}

.article-content a:hover {
    text-decoration: underline;
}

/* List */

.article-content ul {
    list-style: disc;
    padding-left: 30px;
    margin: 20px 0;
}

.article-content ol {
    list-style: decimal;
    padding-left: 30px;
    margin: 20px 0;
}

.article-content li {
    margin-bottom: 10px;
}

/* Blockquote */

.article-content blockquote {
    border-left: 5px solid #2dd4bf;
    background: #13233b;
    padding: 20px;
    border-radius: 15px;
    margin: 30px 0;
    color: #e2e8f0;
}

/* Table */

.article-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
}

.article-content table th,
.article-content table td {
    border: 1px solid rgba(255, 255, 255, .15);
    padding: 12px;
}

.article-content table th {
    background: #1e293b;
    color: #fff;
}

/* Image dari Summernote */

.article-content img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 25px auto;
    border-radius: 18px;
}

/* Code */

.article-content pre {
    background: #111827;
    padding: 20px;
    border-radius: 15px;
    overflow: auto;
    margin: 25px 0;
}

.article-content code {
    color: #2dd4bf;
}

/* HR */

.article-content hr {
    border-color: rgba(255, 255, 255, .1);
    margin: 35px 0;
}

/* Ukuran gambar */
.btn-image {
    width: 212px;
    max-width: 100%;
    height: auto;
    transition: .3s ease;
    display: block;
}

.btn-image:hover {
    transform: scale(1.03);
}

/* Tombol */
.btn-gradient {
    background: linear-gradient(90deg, #2dd4bf, #22d3ee);
    color: #000;
    font-weight: 600;
    padding: 5px 5px;
    border: none;
    transition: .3s;
    border-radius: 8px;
}

.btn-gradient:hover {
    transform: translateY(-2px);
    color: #000;
}
</style>


<!-- =======================================================
HERO
======================================================= -->

<section class="relative overflow-hidden">

    <img src="<?= base_url('assets/img/berita/'.$berita->foto_berita) ?>" alt="<?= $berita->judul_berita ?>"
        class="w-full h-[550px] object-cover brightness-50">

    <div class="absolute inset-0 bg-gradient-to-t from-[#081420] via-[#081420]/70 to-transparent"></div>

    <div class="absolute bottom-0 left-0 right-0">

        <div class="max-w-[1700px] mx-auto px-6 pb-16">

            <!-- Breadcrumb -->

            <div class="inline-flex items-center gap-2
                bg-white/10
                backdrop-blur-xl
                px-5 py-2
                rounded-full
                text-sm
                mb-8">

                <a href="<?= base_url() ?>" class="hover:text-teal-400">

                    Home

                </a>

                <i class="fa-solid fa-angle-right text-xs"></i>

                <a href="<?= base_url("Landingpage")?>#berita" class="hover:text-teal-400">

                    Artikel

                </a>

                <i class="fa-solid fa-angle-right text-xs"></i>

                <span class="text-teal-400">

                    Detail

                </span>

            </div>

            <!-- Judul -->

            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black leading-tight w-full">

                <?= $berita->judul_berita ?>

            </h1>

            <!-- Info -->

            <div class="flex flex-wrap gap-6 mt-8">

                <div class="flex items-center gap-2">

                    <i class="fa-solid fa-calendar-days text-teal-400"></i>

                    <?= date('d F Y',strtotime($berita->tgl_berita));?>

                </div>

                <div class="flex items-center gap-2">

                    <i class="fa-solid fa-eye text-orange-400"></i>

                    <?= number_format($berita->view_berita);?>

                    Views

                </div>

                <div class="flex items-center gap-2">

                    <i class="fa-solid fa-clock text-cyan-400"></i>

                    <?= ceil(str_word_count(strip_tags($berita->meta_desk))/180)+2; ?>

                    Menit Baca

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =======================================================
CONTENT
======================================================= -->

<section class="py-20">

    <div class="max-w-[1700px] mx-auto px-5 lg:px-8">

        <div class="grid grid-cols-12 gap-8">

            <!-- ===========================
                SIDEBAR POPULER
            ============================ -->
            <aside class="order-2 lg:order-1 col-span-12 lg:col-span-2">

                <div class="sticky top-24
                    bg-[#13233b]
                    rounded-[25px]
                    border border-white/10
                    p-3">

                    <div class="flex items-center gap-3 mb-2">

                        <div class="w-10 h-10
                            rounded-xl
                            bg-teal-400/20
                            flex items-center
                            justify-center">

                            <i class="fa-solid fa-fire text-orange-400"></i>

                        </div>

                        <h3 class="text-xl font-bold">

                            Populer

                        </h3>

                    </div>

                    <?php foreach($populer as $row){ ?>

                    <a href="<?= site_url('Artikel/'.url_title($row->judul_berita,'-',TRUE)); ?>">

                        <div class="group mb-3">

                            <img src="<?= base_url('assets/img/berita/'.$row->foto_berita)?>" class="rounded-xl
                                w-full
                                h-25
                                object-cover
                                group-hover:scale-105
                                transition duration-500">

                            <div class="mt-3
                                font-semibold
                                line-clamp-2
                                group-hover:text-teal-400
                                transition">

                                <?= $row->judul_berita ?>

                            </div>

                            <div class="text-xs
                                text-slate-400
                                mt-2">

                                <i class="fa fa-eye text-orange-400"></i>

                                <?= number_format($row->view_berita) ?>

                            </div>

                        </div>

                    </a>

                    <?php } ?>

                </div>

            </aside>

            <!-- ===========================
                CONTENT
            ============================ -->

            <main class="order-1 lg:order-2 col-span-12 lg:col-span-8">

                <!-- Meta Deskripsi -->
                <div class="text-xl text-slate-300 leading-10 border-l-4 border-teal-400 pl-6 italic">

                    <?= $berita->meta_desk ?>

                </div>

                <hr class="border-white/10 my-10">


                <?php foreach($isi as $item){ ?>

                <article class="mb-14">

                    <!-- TEXT -->

                    <div class="article-content">
                        <?= $item['text_berita']; ?>
                    </div>

                    <!-- FOTO -->

                    <?php if (!empty($item['foto'])) : ?>

                    <?php
                        $jumlahFoto = count($item['foto']);

                        // Tentukan jumlah kolom
                        switch ($jumlahFoto) {
                            case 1:
                                $gridClass = 'grid-cols-1';
                                break;

                            case 2:
                                $gridClass = 'grid-cols-2';
                                break;

                            case 3:
                                $gridClass = 'grid-cols-3';
                                break;

                            case 4:
                                $gridClass = 'grid-cols-2';
                                break;

                            default:
                                $gridClass = 'grid-cols-3';
                                break;
                        }
                    ?>

                    <div class="grid <?= $gridClass ?> gap-6 mt-10">

                        <?php foreach ($item['foto'] as $foto) : ?>

                        <figure>

                            <img src="<?= base_url('assets/img/berita/'.$foto); ?>"
                                class="rounded-3xl shadow-2xl w-full h-full object-cover hover:scale-[1.02] transition duration-500">

                        </figure>

                        <?php endforeach; ?>

                    </div>

                    <?php endif; ?>

                    <!-- BUTTON -->

                    <?php if (!empty($item['link_btn'])) : ?>

                    <div class="mt-0 p-0 flex justify-center items-center">

                        <?php if (!empty($item['file_foto_btn'])) : ?>

                        <a href="<?= $item['link_btn']; ?>" target="_blank" class="inline-block">
                            <img src="<?= base_url('assets/img/berita/' . $item['file_foto_btn']); ?>" alt="Banner"
                                class="btn-image">
                        </a>

                        <?php else : ?>

                        <a href="<?= $item['link_btn']; ?>" target="_blank" class="btn btn-gradient rounded-pill">
                            Lihat Selengkapnya
                            <i class="fa-solid fa-arrow-right ms-2"></i>

                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                </article>

                <?php } ?>

                <hr class="border-white/10 my-10">

                <div>

                    <h3 class="font-bold text-xl mb-5">
                        Tag Artikel
                    </h3>

                    <?php

                        $tagAktif = array_map('trim', explode(',', $berita->tag_berita));

                        foreach($semua_tag as $tag){

                            $aktif = in_array($tag, $tagAktif);
                    ?>

                    <a href="<?= base_url('tag/'.url_title($tag,'-',TRUE)); ?>" class="inline-flex items-center px-4 py-2 rounded-full mr-2 mb-2 transition duration-300
                        <?= $aktif
                            ? 'bg-teal-400 text-black font-semibold'
                            : 'bg-slate-700 text-slate-300 hover:bg-teal-400 hover:text-black'; ?>">

                        #<?= $tag ?>

                    </a>

                    <?php } ?>

                </div>

                <hr class="border-white/10 my-10">
                <h3 class="text-xl font-bold mb-6">

                    Bagikan Artikel

                </h3>

                <div class="flex gap-4 flex-wrap">
                    <a href="https://wa.me/?text=<?= urlencode(current_url()); ?>" target="_blank"
                        class="w-14 h-14 rounded-full bg-green-500 flex items-center justify-center hover:scale-110 transition">

                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()); ?>"
                        target="_blank"
                        class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center hover:scale-110 transition">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <button id="copyLink"
                        class="w-14 h-14 rounded-full bg-slate-700 hover:bg-teal-400 hover:text-black transition">
                        <i class="fa-solid fa-link"></i>
                    </button>

                </div>

            </main>

            <!-- ===========================
                SIDEBAR TERBARU
            ============================ -->

            <aside class="order-3 lg:order-3 col-span-12 lg:col-span-2">

                <div class="sticky top-24
                    bg-[#13233b]
                    rounded-[25px]
                    border border-white/10
                    p-3">

                    <div class="flex items-center gap-3 mb-2">

                        <div class="w-10 h-10
                            rounded-xl
                            bg-teal-400/20
                            flex
                            items-center
                            justify-center">

                            <i class="fa-solid fa-newspaper text-teal-400"></i>

                        </div>

                        <h3 class="text-xl font-bold">

                            Terbaru

                        </h3>

                    </div>

                    <?php foreach($terbaru as $row){ ?>

                    <a href="<?= site_url('Artikel/'.url_title($row->judul_berita,'-',TRUE)); ?>">

                        <div class="group mb-3">

                            <img src="<?= base_url('assets/img/berita/'.$row->foto_berita)?>" class="rounded-xl
                                w-full
                                h-25
                                object-cover
                                group-hover:scale-105
                                transition">

                            <div class="mt-3
                                font-semibold
                                line-clamp-2
                                group-hover:text-teal-400
                                transition">

                                <?= $row->judul_berita ?>

                            </div>

                            <div class="text-xs
                                text-slate-400
                                mt-2">

                                <?= date('d M Y',strtotime($row->tgl_berita));?>

                            </div>

                        </div>

                    </a>

                    <?php } ?>

                </div>

            </aside>
        </div>

    </div>

</section>