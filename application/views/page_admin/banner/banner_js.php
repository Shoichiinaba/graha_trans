<!-- modal edit banner -->
<div class="modal fade" id="edit-banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Ubah Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-2">
                    <form id="edit-banner-form" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Tambahkan id untuk properti -->
                            <input type="hidden" name="id_banner" id="id-banner">
                            <div class="row">
                                <div class="input-wrapper col-6">

                                    <select id="ubah-type" name="type_banner" class="form-select">

                                        <option value=""> Pilih Type Banner </option>
                                        <option value="biasa">Biasa</option>
                                        <option value="promo">Promo</option>
                                        <option value="client">Client</option>

                                    </select>

                                    <label class="label-in">Pilih Type</label>

                                </div>
                                <div id="promoFields-ubah" style="display:none;">
                                    <div class="row">
                                        <div class="input-wrapper col-6 mt-3">

                                            <select id="ubah-id-unit" name="id_unit" class="form-select">

                                                <option value="">Memuat data...</option>

                                            </select>
                                            <label class="label-in">Pilih Unit</label>
                                        </div>

                                        <div class="input-wrapper col-6">
                                            <div class="percent-input">
                                                <input type="number" id="ubah-diskon" name="diskon" class="form-control"
                                                    min="0" max="100">
                                                <span class="percent-symbol">%</span>
                                            </div>

                                            <label class="label-in">Diskon</label>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="input-wrapper mt-3 col-6">
                                            <input type="text" id="ubah-judul" name="judul_promo" class="form-control">

                                            <label for="judul" class="label-in">
                                                Judul Promo
                                            </label>
                                        </div>

                                        <div class="input-wrapper mt-3 col-6">
                                            <input type="text" id="ubah-tagline" name="tagline" class="form-control">

                                            <label for="tagline" class="label-in">
                                                Tagline
                                            </label>
                                        </div>
                                    </div>

                                    <div class="input-wrapper mt-3 col-12">
                                        <textarea id="ubah-ket" name="ket_promo" class="form-control"
                                            rows="3"></textarea>

                                        <label for="deskripsi" class="label-in">
                                            Deskripsi Promo
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="input-wrapper col-12 mt-3">
                                <div class="alert alert-primary col-12 mb-0" role="alert">Upload Banner
                                    <div id="banner-preview" class="position-relative">
                                    </div>
                                    <button type="button" id="change-foto"
                                        class="btn btn-sm btn-primary rounded-3">Ganti
                                        Profil</button>
                                    <input type="file" id="upload-banner" class="d-none" name="foto_banner">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="UbahBanner" class="btn btn-primary rounded-3">
                    <span id="loadingIconEdit" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="loadingTexEdit" class="d-none">Menyimpan...</span>
                    <span id="submitTextEdit">Ubah</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah banner -->
<div class="modal fade" id="add-banner" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Tambah Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-2">
                    <form id="upload-banner" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-wrapper col-6">

                                <select id="type-banner-input" name="type_banner" class="form-select">

                                    <option value=""> Pilih Type Banner </option>
                                    <option value="biasa">Biasa</option>
                                    <option value="promo">Promo</option>
                                    <option value="client">Client</option>

                                </select>

                                <label class="label-in">Pilih Type</label>

                            </div>
                            <div id="promoFields" style="display:none;">
                                <div class="row">
                                    <div class="input-wrapper col-6 mt-3">

                                        <select id="id_unit" name="id_unit" class="form-select">

                                            <option value="">Memuat data...</option>

                                        </select>
                                        <label class="label-in">Pilih Unit</label>
                                    </div>

                                    <div class="input-wrapper col-6">
                                        <div class="percent-input">
                                            <input type="number" id="diskon" name="diskon" class="form-control" min="0"
                                                max="100">
                                            <span class="percent-symbol">%</span>
                                        </div>

                                        <label class="label-in">Diskon</label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="input-wrapper mt-3 col-6">
                                        <input type="text" id="judul" name="judul_promo" class="form-control">

                                        <label for="judul" class="label-in">
                                            Judul Promo
                                        </label>
                                    </div>
                                    <div class="input-wrapper mt-3 col-6">
                                        <input type="text" id="tagline" name="tagline" class="form-control">

                                        <label for="tagline" class="label-in">
                                            Tagline
                                        </label>
                                    </div>
                                </div>

                                <div class="input-wrapper mt-3 col-12">
                                    <textarea id="deskripsi" name="ket_promo" class="form-control" rows="3"></textarea>

                                    <label for="deskripsi" class="label-in">
                                        Deskripsi Promo
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="input-wrapper col-12 mt-4">
                            <div class="alert alert-info " role="alert">Upload Banner
                                <div id="dropzone" class="dropzone mt-2"></div>
                                <div id="responseMessage" class="mt-3"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitBanner" class="btn btn-primary rounded-3">
                    <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="loadingText" class="d-none">Menyimpan...</span>
                    <span id="submitText">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {

    const typeBanner = document.getElementById("type-banner-input");
    const promoFields = document.getElementById("promoFields");
    const judul = document.getElementById("judul");
    const deskripsi = document.getElementById("deskripsi");

    if (!typeBanner) return;

    function togglePromoField() {

        if (typeBanner.value.toLowerCase() === "promo") {

            promoFields.style.display = "block";

            judul.required = true;
            deskripsi.required = true;

        } else {

            promoFields.style.display = "none";

            judul.required = false;
            deskripsi.required = false;

            judul.value = "";
            deskripsi.value = "";

        }
    }

    // untuk select gunakan change
    typeBanner.addEventListener("change", togglePromoField);

    // jalankan sekali saat halaman dimuat
    togglePromoField();

});

var base_url = "<?= base_url(); ?>";
// Load data unit
function loadUnit() {

    $.ajax({

        url: base_url + "Kelola_banner/get_unit",
        type: "GET",
        dataType: "json",

        beforeSend: function() {

            $("#id_unit").html('<option>Memuat data...</option>');

        },

        success: function(response) {

            let html = '<option value="">Pilih Unit</option>';

            $.each(response, function(i, item) {

                html += '<option value="' + item.id_unit + '">' + item.nama_unit + '</option>';

            });

            $("#id_unit").html(html);

        },

        error: function() {

            $("#id_unit").html('<option value="">Gagal mengambil data</option>');

        }

    });

}

// Saat modal dibuka
$('#add-banner').on('shown.bs.modal', function() {

    loadUnit();

});

$('#add-banner').on('shown.bs.modal', function() {

    typeBanner.value = "";

    judul.value = "";
    deskripsi.value = "";

    togglePromoField();

});
// kode untuk upload banner

// Inisialisasi Dropzone
Dropzone.autoDiscover = false;

$(document).ready(function() {
    var bannerDropzone = new Dropzone("#dropzone", {
        url: "<?= base_url('Kelola_banner/upload_banner') ?>",
        autoProcessQueue: false,
        paramName: "foto_banner",
        maxFilesize: 1,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
        dictDefaultMessage: "Seret file ke sini atau klik untuk mengupload",
        dictRemoveFile: "Hapus file",
        init: function() {
            var dropzoneInstance = this;

            this.on("sending", function(file, xhr, formData) {

                formData.append("type_banner", $("#type-banner-input").val());
                formData.append("id_unit", $("#id_unit").val());
                formData.append("judul_promo", $("#judul").val());
                formData.append("tagline", $("#tagline").val());
                formData.append("ket_promo", $("#deskripsi").val());
                formData.append("diskon", $("#diskon").val());

                $('#loadingIcon').removeClass('d-none');
                $('#loadingText').removeClass('d-none');
                $('#submitText').addClass('d-none');

            });

            this.on("success", function(file, response) {
                $('#loadingIcon').addClass('d-none');
                $('#loadingText').addClass('d-none');
                $('#submitText').removeClass('d-none');

                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                $('#add-banner').modal('hide');
                $('#add-banner form')[0].reset();

                if (response.status === "success") {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        dropzoneInstance.removeAllFiles(true);
                        reloadBannerData();
                    });
                } else {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menyimpan data banner: ' + (response.message ||
                            'Unknown error'),
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

            this.on("error", function(file, response) {
                $('#loadingIcon').addClass('d-none');
                $('#loadingText').addClass('d-none');
                $('#submitText').removeClass('d-none');

                if (file.size > this.options.maxFilesize * 1024 * 1024) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Ukuran File Terlalu Besar!',
                        text: 'Ukuran file melebihi batas 1 MB.',
                        showConfirmButton: true
                    });
                } else {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengupload banner.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

            this.on("maxfilesexceeded", function(file) {
                this.removeFile(file);
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar!',
                    text: 'Ukuran file melebihi batas 1 MB.',
                    showConfirmButton: true
                });
            });
        }
    });

    $('#submitBanner').click(function(e) {

        e.preventDefault();

        let type = $('#type-banner-input').val();

        if (type == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Type Banner',
                text: 'Silahkan pilih type banner'
            });
            return;
        }

        if (type == "promo") {

            if ($("#id_unit").val() == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Unit',
                    text: 'Silahkan pilih unit'
                });
                return;
            }

            if ($("#judul").val() == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Judul Promo',
                    text: 'Judul promo belum diisi'
                });
                return;
            }

        }

        if (bannerDropzone.getQueuedFiles().length == 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Banner',
                text: 'Upload banner terlebih dahulu'
            });

            return;
        }

        bannerDropzone.processQueue();

    });

});

// kode list data banner
$(document).ready(function() {
    var limit = 4;
    var start = 0;
    var action = 'inactive';
    var total_pages = 1;
    var bannerType = '';

    function lazzy_loader(limit) {
        var output = '';
        for (var count = 0; count < limit; count++) {
            output += '<div class="post_data">';
            output += '<div class="image-placeholder content-placeholder">&nbsp;</div>';
            output += '<div class="details-placeholder">';
            output += '<div class="title-placeholder content-placeholder">&nbsp; </div>';
            output += '<div class="sub-title-placeholder content-placeholder">&nbsp;</div>';
            output += '<div class="price-placeholder content-placeholder">&nbsp;</div>';
            output += '</div>';
            output += '</div>';
        }
        $('#load_data_message').html(output);
    }

    lazzy_loader(limit);

    function load_data(limit, start, search = '', bannerType = '') {
        $.ajax({
            url: "<?php echo base_url(); ?>Kelola_banner/fetch_banner",
            method: "POST",
            data: {
                limit: limit,
                start: start,
                search: search,
                bannerType: bannerType
            },
            cache: false,
            success: function(data) {
                var response = JSON.parse(data);
                $('#load_data').html('');
                if (response.data.trim() === '') {
                    $('#load_data_message').html(
                        '<div class="alert alert-primary alert-dismissible" role="alert">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '<i class="fa fa-folder-open"></i> Data Banner Tidak Ditemukan...</div>'
                    );
                    action = 'active';
                } else {
                    if (start === 0) {
                        $('#load_data').html(response.data);
                    } else {
                        $('#load_data').append(response.data);
                    }
                    $('#load_data_message').html("");
                    action = 'inactive';
                    total_pages = response.total_pages;
                    update_pagination();
                }
            }
        });
    }

    function update_pagination() {
        var paginationHtml =
            '<li class="page-item prev"><a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a></li>';

        for (var i = 1; i <= total_pages; i++) {
            paginationHtml += '<li class="page-item ' + (i === (start / limit) + 1 ? 'active' : '') +
                '"><a class="page-link" href="javascript:void(0);">' + i + '</a></li>';
        }

        paginationHtml +=
            '<li class="page-item next"><a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a></li>';

        $('.pagination').html(paginationHtml);
    }

    $('.pagination').on('click', '.page-item', function() {
        if ($(this).hasClass('prev')) {
            if (start >= limit) {
                start -= limit;
                load_data(limit, start, $('#search-banner').val(), bannerType);
            }
        } else if ($(this).hasClass('next')) {
            if (start + limit < total_pages * limit) {
                start += limit;
                load_data(limit, start, $('#search-banner').val(), bannerType);
            }
        } else {
            var page = parseInt($(this).find('.page-link').text());
            start = (page - 1) * limit;
            load_data(limit, start, $('#search-banner').val(), bannerType);
        }
    });

    load_data(limit, start);

    $('#search-banner').on('input', function() {
        var search = $(this).val();
        start = 0;
        load_data(limit, start, search, bannerType);
    });

    $('.filter-banner').on('click', function() {
        bannerType = $(this).data('type');
        start = 0;
        load_data(limit, start, $('#search-banner').val(), bannerType);
    });
});

// Fungsi untuk memuat ulang data
var baseUrl = "<?php echo base_url(); ?>";
var limit = 4;
var start = 0;
var bannerType = '';
var total_pages = 0;

function reloadBannerData() {
    var search = $('#search-banner').val();

    $.ajax({
        url: baseUrl + "Kelola_banner/fetch_banner",
        method: "POST",
        data: {
            limit: limit,
            start: start,
            search: search,
            bannerType: bannerType
        },
        cache: false,
        success: function(data) {
            var response = JSON.parse(data);
            $('#load_data').html('');
            if (response.data.trim() === '') {
                $('#load_data_message').html(
                    '<div class="alert alert-primary alert-dismissible" role="alert">' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '<i class="fa fa-folder-open"></i> Data Banner Tidak Ditemukan...</div>'
                );
                action = 'active';
            } else {
                if (start === 0) {
                    $('#load_data').html(response.data);
                } else {
                    $('#load_data').append(response.data);
                }
                $('#load_data_message').html("");
                action = 'inactive';
                total_pages = response.total_pages;
                update_pagination();
            }
        }
    });
}

// Fungsi untuk update pagination
function update_pagination() {
    if (total_pages === 0) {
        return;
    }

    var paginationHtml =
        '<li class="page-item prev"><a class="page-link" href="javascript:void(0);" onclick="changePage(' + Math
        .max(
            start - limit, 0) + ');"><i class="tf-icon bx bx-chevrons-left"></i></a></li>';

    for (var i = 1; i <= total_pages; i++) {
        paginationHtml += '<li class="page-item ' + (i === (start / limit) + 1 ? 'active' : '') +
            '"><a class="page-link" href="javascript:void(0);" onclick="changePage(' + (i - 1) * limit + ');">' +
            i +
            '</a></li>';
    }

    paginationHtml +=
        '<li class="page-item next"><a class="page-link" href="javascript:void(0);" onclick="changePage(' + Math
        .min(
            start + limit, (total_pages - 1) * limit) + ');"><i class="tf-icon bx bx-chevrons-right"></i></a></li>';

    $('.pagination').html(paginationHtml);
}

function changePage(newStart) {
    if (newStart < 0 || newStart >= total_pages * limit) {
        return;
    }
    start = newStart;
    reloadBannerData();
}

$(document).ready(function() {
    reloadBannerData();
});

// kode hapus data banner
$(document).on('click', '.btn-delete', function() {

    let id_banner = $(this).data('id');

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus banner ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "<?= site_url('Kelola_banner/hapus_banner'); ?>",

                type: "POST",

                data: {
                    id_banner: id_banner
                },

                dataType: "json",

                success: function(response) {

                    if (response.status == "success") {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {

                            reloadBannerData();

                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });

                    }

                },

                error: function() {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server.'
                    });

                }

            });

        }

    });

});

$(document).ready(function() {

    // Menangani klik tombol Edit
    $(document).on('click', '.ubah-data', function() {

        let id_banner = $(this).data('id_banner');
        let id_unit = $(this).data('id_unit');
        let judul = $(this).data('judul');
        let tagline = $(this).data('tagline');
        let ket = $(this).data('ket');
        let diskon = $(this).data('diskon');
        let type = $(this).data('type_banner');
        let foto = $(this).data('foto');

        $('#id-banner').val(id_banner);
        $('#ubah-type').val(type).trigger('change');

        $('#ubah-id-unit').val(id_unit);
        $('#ubah-judul').val(judul);
        $('#ubah-tagline').val(tagline);
        $('#ubah-ket').val(ket);
        $('#ubah-diskon').val(diskon);

        // tampil/sembunyikan field promo
        if (type == "promo") {
            $("#edit-banner #promoFields-ubah").show();
        } else {
            $("#edit-banner #promoFields-ubah").hide();
        }

        // load unit
        $.ajax({
            url: baseUrl + 'Kelola_banner/get_unit',
            type: 'GET',
            dataType: 'json',
            success: function(res) {

                let html = '<option value="">Pilih Unit</option>';

                $.each(res, function(i, row) {

                    html += `<option value="${row.id_unit}">
                            ${row.nama_unit}
                        </option>`;

                });

                $('#ubah-id-unit').html(html);

                // SET VALUE SETELAH OPTION ADA
                $('#ubah-id-unit').val(id_unit);

            }

        });


        // tentukan folder gambar
        let folder = (type == "promo") ?
            "assets/img/baner_promo/" :
            "assets/img/baner_slider/";

        $("#banner-preview").html(
            `<img src="${baseUrl}${folder}${foto}"
              class="img-fluid rounded-3"
              style="max-height:220px;">`
        );

        $("#ubah-type").change(function() {

            if ($(this).val() == "promo") {

                $("#edit-banner #promoFields-ubah").slideDown();

            } else {

                $("#edit-banner #promoFields-ubah").slideUp();

            }

        });

    });

    //    code ubah banner
    $('#change-foto').on('click', function() {
        $('#upload-banner').click();
    });

    // Menangani perubahan pada input file
    $('#upload-banner').on('change', function() {
        var fileName = $(this).val().split('\\').pop();

        // Mengupdate preview jika file dipilih
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#banner-preview').empty();
                var imgElement =
                    `<img src="${e.target.result}" alt="Foto Banner" class="img-fluid" />`;
                $('#banner-preview').append(imgElement);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Simpan perubahan
    $('#UbahBanner').on('click', function() {
        const formData = new FormData($('#edit-banner-form')[0]);

        const fileInput = $('#upload-banner')[0].files[0];
        if (fileInput) {
            console.log('File name:', fileInput.name);
        } else {
            console.log('No file selected');
        }

        $.ajax({
            url: '<?php echo base_url("Kelola_banner/updateBannerData"); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#loadingIconEdit').removeClass('d-none');
                $('#loadingTextEdit').removeClass('d-none');
                $('#submitTextEdit').addClass('d-none');
            },
            success: function(response) {

                Swal.fire({
                    position: 'top-center',
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                $('#edit-banner').modal('hide');
                reloadBannerData();
            },
            complete: function() {
                $('#loadingIconEdit').addClass('d-none');
                $('#loadingTextEdit').addClass('d-none');
                $('#submitTextEdit').removeClass('d-none');
            }
        });
    });

});
</script>