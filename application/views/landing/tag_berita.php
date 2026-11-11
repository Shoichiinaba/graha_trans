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
</style>

<section class="pt-28 pb-20 relative">

    <!-- Tombol Back -->
    <a href="<?= base_url("Landingpage")?>#berita"
        class="inline-flex items-center gap-1 px-3 py-2 rounded-2xl bg-[#13233b] border border-white/10 hover:bg-teal-400 hover:text-black transition mb-6">

        <i class="fa-solid fa-arrow-left"></i>

        <span>Kembali ke Artikel</span>

    </a>

    <div class="max-w-[1700px] mx-auto px-6">

        <div class="text-center">

            <div class="inline-flex items-center gap-2
                bg-teal-400/10
                text-teal-300
                px-5 py-2
                rounded-full
                mb-6">

                <i class="fa-solid fa-tags"></i>

                Tag Artikel

            </div>

            <h1 class="text-5xl font-black mb-5">

                #<?= $tag ?>

            </h1>

            <p class="text-slate-400 text-lg">

                Menampilkan semua artikel dengan tag
                <span class="text-teal-400 font-semibold"><?= $tag ?></span>

            </p>

        </div>

    </div>

</section>

<!-- ========================================= -->
<!-- LIST ARTIKEL -->
<!-- ========================================= -->

<section class="pb-24">

    <div class="max-w-[1700px] mx-auto px-6">

        <!-- Card Artikel -->
        <div id="load_data_tag" class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">
        </div>

        <!-- Skeleton -->
        <div id="load_data_message_tag"></div>

        <!-- Pagination -->
        <div class="flex justify-center mt-14">

            <ul id="pagination_tag" class="flex flex-wrap gap-3">
            </ul>

        </div>

        <hr class="border-white/10 my-10">

        <div>

            <h3 class="font-bold text-xl mb-2">
                Tag Artikel
            </h3>

            <div class="mt-8 flex flex-wrap justify-left gap-3">

                <?php foreach($semua_tag as $item){ ?>

                <a href="<?= base_url('tag/'.url_title($item,'-',TRUE)); ?>" class="px-4 py-2 rounded-full transition
           <?= strtolower($item)==strtolower($tag)
                ? 'bg-teal-400 text-black font-semibold'
                : 'bg-slate-700 text-slate-300 hover:bg-teal-400 hover:text-black'; ?>">

                    #<?= $item ?>

                </a>

                <?php } ?>

            </div>

        </div>
    </div>

</section>

<script>
const TAG_BERITA = <?= json_encode($tag); ?>;
</script>