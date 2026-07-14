<script>
/* ===========================
   PROMO SLIDER
=========================== */

const promoTrack = document.getElementById("promoTrack");

if (promoTrack) {

    const slides = document.querySelectorAll(".promo-slide");

    const dots = document.querySelectorAll(".promo-dot");

    let index = 0;

    function updatePromo() {

        promoTrack.style.transform = `translateX(-${index*100}%)`;

        dots.forEach(dot => dot.classList.remove("active"));

        dots[index].classList.add("active");

    }

    function nextPromo() {

        index++;

        if (index >= slides.length) {

            index = 0;

        }

        updatePromo();

    }

    let interval = setInterval(nextPromo, 5000);

    dots.forEach((dot, i) => {

        dot.onclick = function() {

            clearInterval(interval);

            index = i;

            updatePromo();

            interval = setInterval(nextPromo, 5000);

        }

    });

}

$(document).ready(function() {

    /**
     * ==========================================
     * Loader
     * ==========================================
     */

    function createLoader(option) {

        let state = {
            default_limit: 3,
            limit: 3,
            start: 0,
            total_data: 0,
            mode: "more"
        };

        /**
         * ==========================================
         * Skeleton
         * ==========================================
         */

        function lazzy_loader(limit) {

            let output = "";

            for (let i = 0; i < limit; i++) {

                output += `

                <div class="skeleton-card">

                    <div class="skeleton skeleton-image"></div>

                    <div class="p-6">

                        <div class="skeleton skeleton-title"></div>

                        <div class="skeleton skeleton-price"></div>

                        <div class="skeleton-line"></div>

                        <div class="grid grid-cols-3 gap-2 text-center">

                            <div>
                                <div class="skeleton skeleton-icon"></div>
                                <div class="skeleton skeleton-text"></div>
                            </div>

                            <div>
                                <div class="skeleton skeleton-icon"></div>
                                <div class="skeleton skeleton-text"></div>
                            </div>

                            <div>
                                <div class="skeleton skeleton-icon"></div>
                                <div class="skeleton skeleton-text"></div>
                            </div>

                        </div>

                        <div class="skeleton-line"></div>

                        <div class="skeleton skeleton-button"></div>

                    </div>

                </div>

                `;

            }

            $(option.message).html(`

                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">

                    ${output}

                </div>

            `);

        }

        /**
         * ==========================================
         * Button Read More
         * ==========================================
         */

        /**
         * ==========================================
         * Update Button
         * ==========================================
         */
        function updateButton() {

            // Jika total data <= 3 maka tombol disembunyikan
            if (state.total_data <= state.default_limit) {

                $(option.pagination).hide();

                return;

            }

            // Jika semua data sudah tampil maka ubah ke mode Back
            if (state.limit >= state.total_data) {

                state.mode = "back";

            }

            // Jika data sudah kembali ke 3 maka ubah ke Read More
            if (state.limit <= state.default_limit) {

                state.mode = "more";

            }

            let html = "";

            if (state.mode == "more") {

                html = `

            <button
                class="load-more-btn
                bg-teal-400
                hover:bg-teal-600
                text-black
                font-bold
                px-3
                py-2
                rounded-xl
                transition-all duration-300"

                data-action="more">

                Lihat Unit Lainnya

            </button>

        `;

            } else {

                html = `

            <button
                class="load-more-btn
                bg-red-500
                hover:bg-red-600
                text-white
                font-bold
                px-6
                py-3
                rounded-xl
                transition-all duration-300"

                data-action="back">

                Back

            </button>

        `;

            }

            $(option.pagination)
                .show()
                .html(html);

        }

        /**
         * ==========================================
         * Badge
         * ==========================================
         */

        function updateTotal() {

            $(option.badge).text(state.total_data);

        }

        /**
         * ==========================================
         * Load Data
         * ==========================================
         */

        function load_data() {

            $(option.container).html("");

            lazzy_loader(state.limit);

            $(".load-more-btn")
                .prop("disabled", true);

            $.ajax({

                url: "<?= base_url('Landingpage/fetch'); ?>",

                type: "POST",

                cache: false,

                data: {

                    kategori: option.kategori,

                    limit: state.limit,

                    start: 0

                },

                success: function(data) {

                    let response = JSON.parse(data);

                    $(option.message).html("");

                    if ($.trim(response.data) == "") {

                        $(option.container).html("");

                        $(option.message).html(`

                            <div class="text-center py-10">

                                <i class="fa-solid fa-car text-4xl text-slate-500 mb-2"></i>

                                <div class="text-slate-400">

                                    Belum Ada Data Unit.

                                </div>

                            </div>

                        `);

                        $(option.pagination).hide();

                        $(option.badge).text(0);

                        return;

                    }

                    state.total_data = response.total_data;

                    $(option.container)

                        .hide()

                        .html(response.data)

                        .fadeIn(250);

                    updateButton();

                    updateTotal();

                },

                error: function() {

                    $(option.message).html("");

                    $(option.container).html(`

                        <div class="text-center py-8 text-red-500">

                            Terjadi kesalahan saat mengambil data.

                        </div>

                    `);

                },

                complete: function() {

                    $(".load-more-btn")

                        .prop("disabled", false);

                }

            });

        }

        /**
         * ==========================================
         * Read More
         * ==========================================
         */

        $(document).on("click", option.pagination + " .load-more-btn", function() {

            let action = $(this).data("action");

            if (action == "more") {

                state.limit += state.default_limit;

                if (state.limit > state.total_data) {
                    state.limit = state.total_data;
                }

            } else {

                state.limit -= state.default_limit;

                if (state.limit < state.default_limit) {
                    state.limit = state.default_limit;
                }

            }

            load_data();

        });

        load_data();

    }

    /**
     * ==========================================
     * Loader 1
     * ==========================================
     */

    createLoader({

        kategori: "unggulan",

        container: "#load_data_unggulan",

        message: "#load_data_message_unggulan",

        pagination: "#pagination_unggulan",

        badge: "#badge_unggulan"

    });

    /**
     * ==========================================
     * Loader 2
     * ==========================================
     */

    createLoader({

        kategori: "Favorit",

        container: "#load_data_favorit",

        message: "#load_data_message_favorit",

        pagination: "#pagination_favorit",

        badge: "#badge_favorit"

    });

    /**
     * ==========================================
     * Loader 3
     * ==========================================
     */

    createLoader({

        kategori: "Keluarga",

        container: "#load_data_keluarga",

        message: "#load_data_message_keluarga",

        pagination: "#pagination_keluarga",

        badge: "#badge_keluarga"

    });

});

// kode javascript artikel

$(document).ready(function() {

    let berita = {

        limit: 3,

        start: 0,

        total_pages: 1,

        total_data: 0

    };

    /*==========================================
        Skeleton Loader
    ==========================================*/
    function lazy_loader_berita(limit) {

        let output = '';

        for (let i = 0; i < limit; i++) {

            output += `

            <div class="article-skeleton">

                <div class="article-skeleton-img"></div>

                <div class="article-skeleton-body">

                    <div class="article-line short"></div>

                    <div class="article-line title"></div>

                    <div class="article-line full"></div>

                    <div class="article-line medium"></div>

                    <div class="article-line short"></div>

                </div>

            </div>

            `;

        }

        $("#load_data_message_berita").html(
            `<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">
                ${output}
            </div>`
        );

    }

    /*==========================================
        Load Data
    ==========================================*/
    function load_data_berita() {

        $("#load_data_berita").html("");

        lazy_loader_berita(berita.limit);

        $("#pagination_berita .page-item")
            .prop("disabled", true)
            .addClass("opacity-50 cursor-not-allowed");

        $.ajax({

            url: "<?= base_url('Landingpage/fetch_berita');?>",

            method: "POST",

            cache: false,

            data: {

                limit: berita.limit,

                start: berita.start

            },

            success: function(response) {

                let res = JSON.parse(response);

                $("#load_data_message_berita").html("");

                if ($.trim(res.data) == '') {

                    $("#load_data_berita").html("");

                    $("#load_data_message_berita").html(`

                        <div class="text-center py-10">

                            <i class="fa fa-folder-open text-4xl text-slate-500 mb-3"></i>

                            <div class="text-slate-400">

                                Belum ada artikel.

                            </div>

                        </div>

                    `);

                    $("#pagination_berita").hide();

                    $("#badge_berita").text(0);

                } else {

                    $("#load_data_berita")

                        .hide()

                        .html(res.data)

                        .fadeIn(250);

                    berita.total_pages = res.total_pages;

                    berita.total_data = res.total_data;

                    updatePaginationBerita();

                    updateTotalBerita();

                    $("#pagination_berita").show();

                }

            },

            complete: function() {

                $("#pagination_berita .page-item")

                    .prop("disabled", false)

                    .removeClass("opacity-50 cursor-not-allowed");

            },

            error: function() {

                $("#load_data_message_berita").html("");

                $("#load_data_berita").html(`

                    <div class="text-center text-danger py-5">

                        Terjadi kesalahan mengambil data.

                    </div>

                `);

            }

        });

    }

    /*==========================================
        Pagination
    ==========================================*/
    function updatePaginationBerita() {

        let html = '';

        const currentPage = Math.floor(berita.start / berita.limit) + 1;

        const totalPages = berita.total_pages;

        const maxVisible = 10;

        // ==========================
        // Tombol Prev
        // ==========================
        html += `
        <li>
            <button class="page-item prev
                w-10 h-10 rounded-xl
                border border-white/10
                bg-white/5
                hover:bg-teal-400
                hover:text-black transition">

                <i class="fa-solid fa-angle-left"></i>

            </button>
        </li>
    `;

        // ==========================
        // Jika total halaman <=10
        // ==========================
        if (totalPages <= maxVisible) {

            for (let i = 1; i <= totalPages; i++) {

                html += pageButton(i);

            }

        }

        // ==========================
        // Awal halaman
        // ==========================
        else if (currentPage <= 6) {

            for (let i = 1; i <= 10; i++) {

                html += pageButton(i);

            }

            html += `
            <li class="px-2 text-slate-400">...</li>
        `;

            html += pageButton(totalPages);

        }

        // ==========================
        // Akhir halaman
        // ==========================
        else if (currentPage >= totalPages - 5) {

            html += pageButton(1);

            html += `
            <li class="px-2 text-slate-400">...</li>
        `;

            for (let i = totalPages - 9; i <= totalPages; i++) {

                html += pageButton(i);

            }

        }

        // ==========================
        // Tengah halaman
        // ==========================
        else {

            html += pageButton(1);

            html += `
            <li class="px-2 text-slate-400">...</li>
        `;

            for (let i = currentPage - 4; i <= currentPage + 5; i++) {

                html += pageButton(i);

            }

            html += `
            <li class="px-2 text-slate-400">...</li>
        `;

            html += pageButton(totalPages);

        }

        // ==========================
        // Tombol Next
        // ==========================
        html += `
        <li>
            <button class="page-item next
                w-10 h-10 rounded-xl
                border border-white/10
                bg-white/5
                hover:bg-teal-400
                hover:text-black transition">

                <i class="fa-solid fa-angle-right"></i>

            </button>
        </li>
    `;

        $("#pagination_berita").html(html);

        // Disable Prev
        if (berita.start == 0) {

            $("#pagination_berita .prev")
                .prop("disabled", true)
                .addClass("opacity-40 cursor-not-allowed");

        }

        // Disable Next
        if ((berita.start + berita.limit) >= berita.total_data) {

            $("#pagination_berita .next")
                .prop("disabled", true)
                .addClass("opacity-40 cursor-not-allowed");

        }

        // ==========================
        // Helper Button
        // ==========================
        function pageButton(page) {

            let active = page == currentPage;

            return `
            <li>

                <button
                    class="page-item page-number
                    w-10 h-10 rounded-xl
                    ${active
                        ? 'bg-teal-400 text-black font-bold shadow-lg'
                        : 'bg-white/5 border border-white/10 text-white hover:bg-teal-400 hover:text-black'}
                    transition"

                    data-page="${page}">

                    ${page}

                </button>

            </li>
        `;

        }

    }

    /*==========================================
        Total Data
    ==========================================*/
    function updateTotalBerita() {

        $("#badge_berita").text(berita.total_data);

    }

    /*==========================================
        Click Pagination
    ==========================================*/
    $(document).on("click", "#pagination_berita .page-item", function() {

        if ($(this).prop("disabled")) return;

        if ($(this).hasClass("prev")) {

            if (berita.start >= berita.limit) {

                berita.start -= berita.limit;

                load_data_berita();

            }

        } else if ($(this).hasClass("next")) {

            if ((berita.start + berita.limit) < berita.total_data) {

                berita.start += berita.limit;

                load_data_berita();

            }

        } else {

            let page = parseInt($(this).data("page"));

            berita.start = (page - 1) * berita.limit;

            load_data_berita();

        }

    });

    /*==========================================
        First Load
    ==========================================*/
    load_data_berita();

});
</script>