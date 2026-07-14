<script>
$("#copyLink").click(function() {

    navigator.clipboard.writeText(window.location.href);

    Swal.fire({

        icon: 'success',

        title: 'Link berhasil disalin',

        timer: 1500,

        showConfirmButton: false

    });

});

// code untuk tag berita
$(document).ready(function() {

    let tagArtikel = {

        limit: 3,
        start: 0,
        total_pages: 1,
        total_data: 0

    };

    /*==========================================
        Skeleton Loader
    ==========================================*/
    function lazy_loader_tag(limit) {

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

        $("#load_data_message_tag").html(

            `<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">

                ${output}

            </div>`

        );

    }

    /*==========================================
        Load Data
    ==========================================*/
    function load_data_tag() {

        $("#load_data_tag").html("");

        lazy_loader_tag(tagArtikel.limit);

        $("#pagination_tag .page-item")
            .prop("disabled", true)
            .addClass("opacity-50 cursor-not-allowed");

        $.ajax({

            url: "<?= base_url('Artikel/fetch_tag');?>",
            type: "POST",
            cache: false,

            data: {

                tag_berita: TAG_BERITA,
                limit: tagArtikel.limit,
                start: tagArtikel.start

            },

            success: function(response) {

                let res = JSON.parse(response);

                $("#load_data_message_tag").html("");

                if ($.trim(res.data) == '') {

                    $("#load_data_tag").html("");

                    $("#pagination_tag").hide();

                    $("#load_data_message_tag").html(`

                        <div class="text-center py-20">

                            <i class="fa-solid fa-folder-open text-6xl text-slate-500 mb-6"></i>

                            <h3 class="text-3xl font-bold mb-4">

                                Artikel Tidak Ditemukan

                            </h3>

                        </div>

                    `);

                    return;

                }

                $("#load_data_tag")
                    .hide()
                    .html(res.data)
                    .fadeIn(200);

                tagArtikel.total_pages = res.total_pages;
                tagArtikel.total_data = res.total_data;

                updatePaginationTag();

                $("#pagination_tag").show();

            },

            complete: function() {

                $("#pagination_tag .page-item")
                    .prop("disabled", false)
                    .removeClass("opacity-50 cursor-not-allowed");

            }

        });

    }

    /*==========================================
        Pagination
    ==========================================*/
    function updatePaginationTag() {

        let html = '';

        let currentPage = Math.floor(tagArtikel.start / tagArtikel.limit) + 1;

        html += `

        <li>

            <button class="page-item prev
                w-10 h-10 rounded-xl
                border border-white/10
                bg-white/5
                hover:bg-teal-400
                hover:text                transition">

                <i class="fa-solid fa-angle-left"></i>

            </button>

        </li>

        `;

        // Nomor halaman
        for (let i = 1; i <= tagArtikel.total_pages; i++) {

            let active = (i == currentPage);

            html += `

            <li>

                <button

                    class="page-item page-number
                    w-10 h-10 rounded-xl
                    transition
                    ${active
                        ? 'bg-teal-400 text-black font-bold'
                        : 'bg-white/5 border border-white/10 text-white hover:bg-teal-400 hover:text-black'}"

                    data-page="${i}">

                    ${i}

                </button>

            </li>

            `;

        }

        html += `

        <li>

            <button class="page-item next
                w-10 h-10 rounded-xl
                border border-white/10
                bg-white/5
                hover:bg-teal-400
                hover:text-black
                transition">

                <i class="fa-solid fa-angle-right"></i>

            </button>

        </li>

        `;

        $("#pagination_tag").html(html);

        if (tagArtikel.start == 0) {

            $("#pagination_tag .prev")
                .prop("disabled", true)
                .addClass("opacity-40 cursor-not-allowed");

        }

        if ((tagArtikel.start + tagArtikel.limit) >= tagArtikel.total_data) {

            $("#pagination_tag .next")
                .prop("disabled", true)
                .addClass("opacity-40 cursor-not-allowed");

        }

    }

    $(document).on("click", "#pagination_tag .page-item", function() {

        if ($(this).prop("disabled")) return;

        if ($(this).hasClass("prev")) {

            if (tagArtikel.start >= tagArtikel.limit) {

                tagArtikel.start -= tagArtikel.limit;

                load_data_tag();

            }

        } else if ($(this).hasClass("next")) {

            if ((tagArtikel.start + tagArtikel.limit) < tagArtikel.total_data) {

                tagArtikel.start += tagArtikel.limit;

                load_data_tag();

            }

        } else {

            let page = parseInt($(this).data("page"));

            tagArtikel.start = (page - 1) * tagArtikel.limit;

            load_data_tag();

        }

    });

    /*==========================================
        First Load
    ==========================================*/

    load_data_tag();

});
</script>