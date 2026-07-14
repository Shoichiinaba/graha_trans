<!-- modal tambah unit -->

<div class="modal fade" id="add-unit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Tambah Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-5" id="form-container">
                    <form id="UnitForm" enctype="multipart/form-data">
                        <!-- Data Unit -->
                        <div class="input-wrapper mt-3">
                            <input type="text" name="nama_unit" class="form-control" required>
                            <label for="nama_unit" class="label-in">Nama Unit</label>
                        </div>
                        <div class="row mt-3">
                            <div class="input-wrapper col-6" id="kategori">
                                <input class="form-control" list="data-kategori" name="kategori"
                                    placeholder="Pilih jenis Kategori.." />
                                <label for="kategori" class="label-in">Pilih Kategori</label>

                                <datalist id="data-kategori">
                                    <option value="PREMIUM"></option>
                                    <option value="SUV"></option>
                                    <option value="HYBRID"></option>
                                    <option value="FAVORIT"></option>
                                    <option value="MPV"></option>
                                    <option value="CITY CAR"></option>
                                    <option value="COMPACT SUV"></option>
                                    <option value="MINIBUS"></option>
                                </datalist>
                            </div>
                            <div class="input-wrapper col-6" id="tataletak_web">
                                <input class="form-control" list="data-layout" name="tataletak_web"
                                    placeholder="Pilih jenis letak..." />
                                <label for="tataletak_web" class="label-in">Pilih Posisi</label>

                                <datalist id="data-layout">
                                    <option value="Unggulan"></option>
                                    <option value="Favorit"></option>
                                    <option value="Keluarga"></option>
                                </datalist>
                            </div>
                        </div>
                        <!-- Data Detail unit -->
                        <div class="alert alert-primary mt-4" role="alert">Detail Unit
                        </div>
                        <div class="row">
                            <div class="input-wrapper mt-3 col-6">
                                <input type="number" name="seat" class="form-control" required>
                                <label for="seat" class="label-in">Jumlah Kursi</label>
                            </div>
                            <div class="input-wrapper mt-3 col-6">
                                <input type="text" name="fuel" class="form-control" required>
                                <label for="fuel" class="label-in">Bahan Bakar</label>
                            </div>
                            <div class="input-wrapper mt-3 col-6">
                                <input type="text" name="transmition" class="form-control" required>
                                <label for="transmition" class="label-in">Transmisi</label>
                            </div>
                            <div class="input-wrapper mt-3 col-6">
                                <input type="number" name="tahun" class="form-control" required>
                                <label for="tahun" class="label-in">Tahun Mobil</label>
                            </div>
                            <div class="input-wrapper mt-3 col-6">
                                <input type="number" name="price" class="form-control" required>
                                <label for="price" class="label-in">Harga (IDR)</label>
                            </div>
                        </div>
                        <div class="alert alert-primary mt-4" role="alert">Data Gambar Unit
                        </div>
                        <!-- upload Unit -->
                        <div class="alert alert-success col-12 pb-4" role="alert">
                            Upload Gambar Unit
                            <div id="meta-preview" class="position-relative">
                                <img id="preview-image" src="#" alt="Preview" style="display: none;">
                                <span id="delete-icon" class="delete-icon" style="display: none;">&#10006;</span>
                            </div>
                            <div class="tambah-foto-wrapper" id="addFotoWrapper">
                                <button id="btnTambahFoto" class="tambah-foto-btn" type="button">
                                    <i class="bx bx-image-add"></i> Tambahkan Foto
                                </button>
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="d-none">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitUnit" class="btn btn-primary rounded-3">
                    <span class="d-none" id="loadingIcon" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                    <span class="d-none" id="loadingText">Menyimpan...</span>
                    <span id="submitText"> Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Unit -->
<div class="modal fade" id="edit-unit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-2">
                <div class="container mt-5">

                    <form id="EditUnitForm" enctype="multipart/form-data">

                        <!-- Hidden ID -->
                        <input type="hidden" name="id_unit" id="edit_id_unit">

                        <!-- Data Unit -->
                        <div class="input-wrapper mt-3">
                            <input type="text" name="nama_unit" id="edit_nama_unit" class="form-control" required>
                            <label class="label-in">Nama Unit</label>
                        </div>

                        <div class="row mt-3">

                            <div class="input-wrapper col-6">
                                <input class="form-control" list="edit-data-kategori" name="kategori" id="edit_kategori"
                                    placeholder="Pilih jenis Kategori..">

                                <label class="label-in">Pilih Kategori</label>

                                <datalist id="edit-data-kategori">
                                    <option value="PREMIUM"></option>
                                    <option value="SUV"></option>
                                    <option value="HYBRID"></option>
                                    <option value="FAVORIT"></option>
                                    <option value="MPV"></option>
                                    <option value="CITY CAR"></option>
                                    <option value="COMPACT SUV"></option>
                                    <option value="MINIBUS"></option>
                                </datalist>
                            </div>

                            <div class="input-wrapper col-6">
                                <input class="form-control" list="edit-data-layout" name="tataletak_web"
                                    id="edit_tataletak_web" placeholder="Pilih jenis letak...">

                                <label class="label-in">Pilih Posisi</label>

                                <datalist id="edit-data-layout">
                                    <option value="Unggulan"></option>
                                    <option value="Favorit"></option>
                                    <option value="Keluarga"></option>
                                </datalist>

                            </div>

                        </div>

                        <!-- Detail Unit -->
                        <div class="alert alert-primary mt-4">
                            Detail Unit
                        </div>

                        <div class="row">

                            <div class="input-wrapper mt-3 col-6">
                                <input type="number" name="seat" id="edit_seat" class="form-control" required>
                                <label class="label-in">Jumlah Kursi</label>
                            </div>

                            <div class="input-wrapper mt-3 col-6">
                                <input type="text" name="fuel" id="edit_fuel" class="form-control" required>
                                <label class="label-in">Bahan Bakar</label>
                            </div>

                            <div class="input-wrapper mt-3 col-6">
                                <input type="text" name="transmition" id="edit_transmition" class="form-control"
                                    required>
                                <label class="label-in">Transmisi</label>
                            </div>

                            <div class="input-wrapper mt-3 col-6">
                                <input type="number" name="tahun" id="edit_tahun" class="form-control" required>
                                <label class="label-in">Tahun Mobil</label>
                            </div>

                            <div class="input-wrapper mt-3 col-6">
                                <input type="number" name="price" id="edit_price" class="form-control" required>
                                <label class="label-in">Harga (IDR)</label>
                            </div>

                        </div>

                        <!-- Upload Gambar -->
                        <div class="alert alert-primary mt-4">
                            Data Gambar Unit
                        </div>

                        <div class="alert alert-success col-12 pb-4">

                            Upload Gambar Unit

                            <div id="meta-preview" class="position-relative">

                                <img id="edit-preview-image" src="#" alt="Preview" style="display:none;">

                                <span id="edit-delete-icon" class="delete-icon" style="display:none;">
                                    &#10006;
                                </span>

                            </div>

                            <div class="tambah-foto-wrapper" id="editFotoWrapper">

                                <button id="editBtnTambahFoto" class="tambah-foto-btn" type="button">

                                    <i class="bx bx-image-add"></i>
                                    Ganti Foto

                                </button>

                                <input type="file" name="gambar" id="edit_gambar" accept="image/*" class="d-none">

                            </div>

                        </div>

                    </form>

                </div>
            </div>

            <div class="modal-footer">

                <button type="button" id="updateUnit" class="btn btn-primary rounded-3">

                    <span class="spinner-border spinner-border-sm d-none" id="editLoadingIcon"></span>

                    <span class="d-none" id="editLoadingText">
                        Mengupdate...
                    </span>

                    <span id="updateText">
                        Update
                    </span>

                </button>

            </div>

        </div>
    </div>
</div>

<script>
// kode simpan uNIT
$(function() {

    $("#submitUnit").on("click", function(e) {

        e.preventDefault();

        var form = $("#UnitForm")[0];

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        var btn = $(this);
        var formData = new FormData(form);

        btn.prop("disabled", true);

        $("#submitText").addClass("d-none");
        $("#loadingIcon,#loadingText").removeClass("d-none");

        $.ajax({
            url: baseUrl + "Kelola_unit/tambah",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 60000,
            dataType: "json",

            success: function(res) {


                if (res.status) {

                    $("#UnitForm")[0].reset();

                    $("#preview-image").hide().attr("src", "");
                    $("#delete-icon").hide();

                    // Tampilkan kembali tombol upload
                    $("#addFotoWrapper").show();

                    $("#add-unit").modal("hide");

                    reloadUnitData();

                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                } else {

                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: res.message
                    });

                }

            },

            error: function(xhr) {

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Terjadi kesalahan pada server."
                });

            },

            complete: function() {

                btn.prop("disabled", false);

                $("#submitText").removeClass("d-none");
                $("#loadingIcon,#loadingText").addClass("d-none");

            }

        });

    });

});

$("#btnTambahFoto").click(function() {
    $("#gambar").click();
});


$("#gambar").change(function() {

    const file = this.files[0];

    if (!file) return;

    $("#preview-image")
        .attr("src", URL.createObjectURL(file))
        .fadeIn(200);

    $("#delete-icon").fadeIn(200);

    // Sembunyikan tombol tambah foto
    $("#UnitForm .tambah-foto-wrapper").fadeOut(200);


});

$("#delete-icon").click(function() {

    $("#gambar").val("");

    $("#preview-image")
        .attr("src", "")
        .hide();

    $("#delete-icon").hide();

    // Tampilkan lagi tombol tambah foto
    $("#UnitForm .tambah-foto-wrapper").fadeIn(200);

});


// kode list data Unit
$(document).ready(function() {
    var limit = 4;
    var start = 0;
    var action = 'inactive';
    var total_pages = 1;
    var total_data = 0;
    var unit_kategori = '';
    var tahun = '';
    var transmisi = '';

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

    function load_data(limit, start, search = '', unit_kategori, tahun, transmisi) {
        $.ajax({
            url: "<?php echo base_url(); ?>Kelola_unit/fetch",
            method: "POST",
            data: {
                limit: limit,
                start: start,
                search: search,
                unit_kategori: unit_kategori,
                tahun: tahun,
                transmisi: transmisi
            },
            cache: false,
            success: function(data) {
                var response = JSON.parse(data);
                $('#load_data').html('');
                if (response.data.trim() === '') {
                    $('#load_data_message').html(
                        '<div class="alert alert-primary alert-dismissible" role="alert">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '<i class="fa fa-folder-open"></i> Data Unit Tidak Ditemukan...</div>'
                    );
                    $('.pagination, .filter-kategori, .filter-tahun,  .filter-transmisi').hide();
                    $('.custom-badge').text(0);
                    action = 'active';
                } else {
                    if (start === 0) {
                        $('#load_data').html(response.data);
                    } else {
                        $('#load_data').append(response.data);
                    }
                    $('#load_data_message').html("");
                    $('.pagination, .filter-kategori, .filter-tahun, .filter-tahun').show();
                    total_pages = response.total_pages;
                    total_data = response.total_data;
                    update_pagination();
                    update_total_data();
                    action = 'inactive';
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

    function update_total_data() {
        $('.custom-badge').text(total_data);
    }

    $('.pagination').on('click', '.page-item', function() {
        if ($(this).hasClass('prev')) {
            if (start >= limit) {
                start -= limit;
                load_data(limit, start, $('#search-unit').val(), unit_kategori, tahun,
                    transmisi);
            }
        } else if ($(this).hasClass('next')) {
            if (start + limit < total_pages * limit) {
                start += limit;
                load_data(limit, start, $('#search-unit').val(), unit_kategori, tahun,
                    transmisi);
            }
        } else {
            var page = parseInt($(this).find('.page-link').text());
            start = (page - 1) * limit;
            load_data(limit, start, $('#search-unit').val(), unit_kategori, tahun,
                transmisi);
        }
    });

    load_data(limit, start);

    $('#search-unit').on('input', function() {
        var search = $(this).val();
        start = 0;
        load_data(limit, start, search, unit_kategori, tahun, transmisi);
    });

    $('.filter-kategori').on('click', function() {
        unit_kategori = $(this).data('kategori');
        start = 0;
        load_data(limit, start, $('#search-unit').val(), unit_kategori, tahun,
            transmisi);
    });

    $('.filter-tahun').on('click', function() {
        tahun = $(this).data('tahun');
        start = 0;
        load_data(limit, start, $('#search-unit').val(), unit_kategori, tahun,
            transmisi);
    });

    $('.filter-transmisi').on('click', function() {
        transmisi = $(this).data('transmisi');
        start = 0;
        load_data(limit, start, $('#search-unit').val(), unit_kategori, tahun,
            transmisi);
    });
});

// Fungsi untuk memuat ulang data
var baseUrl = "<?php echo base_url(); ?>";
var limit = 4;
var start = 0;
var total_pages = 0;

function reloadUnitData() {
    var search = $('#search-unit').val();

    $.ajax({
        url: baseUrl + "Kelola_unit/fetch",
        method: "POST",
        data: {
            limit: limit,
            start: start,
            search: search
        },
        cache: false,
        success: function(data) {
            var response = JSON.parse(data);
            $('#load_data').html('');
            if (response.data.trim() === '') {
                $('#load_data_message').html(
                    '<div class="alert alert-primary alert-dismissible" role="alert">' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '<i class="fa fa-folder-open"></i> Data Unit Tidak Ditemukan...</div>'
                );
                $('.custom-badge').text(0);
                action = 'active';
            } else {
                if (start === 0) {
                    $('#load_data').html(response.data);
                } else {
                    $('#load_data').append(response.data);
                }
                $('#load_data_message').html("");
                $('.custom-badge').text(response.total_data);
                action = 'inactive';
                total_pages = response.total_pages;
                update_pagination();
            }
        }
    });
}

// Fungsi untuk memperbarui pagination
function update_pagination() {
    if (total_pages === 0) {
        $('.pagination').html('');
        return;
    }

    var paginationHtml =
        '<li class="page-item prev ' + (start === 0 ? 'disabled' : '') + '">' +
        '<a class="page-link" href="javascript:void(0);" onclick="changePage(' + Math.max(start - limit, 0) + ');">' +
        '<i class="tf-icon bx bx-chevrons-left"></i></a></li>';

    for (var i = 1; i <= total_pages; i++) {
        paginationHtml += '<li class="page-item ' + (i === (start / limit) + 1 ? 'active' : '') + '">' +
            '<a class="page-link" href="javascript:void(0);" onclick="changePage(' + (i - 1) * limit + ');">' +
            i + '</a></li>';
    }

    paginationHtml +=
        '<li class="page-item next ' + (start >= (total_pages - 1) * limit ? 'disabled' : '') + '">' +
        '<a class="page-link" href="javascript:void(0);" onclick="changePage(' + Math.min(start + limit, (total_pages -
            1) * limit) + ');">' +
        '<i class="tf-icon bx bx-chevrons-right"></i></a></li>';

    $('.pagination').html(paginationHtml);
}

function changePage(newStart) {
    if (newStart < 0 || newStart >= total_pages * limit) {
        return;
    }
    start = newStart;
    reloadUnitData();
}

$(document).ready(function() {
    reloadUnitData();

    $('#search-unit').on('input', function() {
        start = 0;
        reloadUnitData();
    });
});

// kode hapus data unit
$(document).on('click', '.btn-del', function() {
    var idUnit = $(this).data('id');

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: "Apakah Anda yakin ingin menghapus data unit?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url('Kelola_unit/hapus_unit'); ?>",
                type: "POST",
                data: {
                    id_unit: idUnit
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Terhapus!',
                            'Unit berhasil dihapus.',
                            'success'
                        ).then(() => {
                            reloadUnitData();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menghapus data.',
                    });
                }
            });
        }
    });
});

///////////////////////////////////////////
// code edit unit

$("#editBtnTambahFoto").click(function() {
    $("#edit_gambar").click();
});

$("#edit_gambar").change(function() {

    const file = this.files[0];

    if (!file) return;

    $("#edit-preview-image")
        .attr("src", URL.createObjectURL(file))
        .fadeIn(200);

    $("#edit-delete-icon").fadeIn(200);

    $("#EditUnitForm .tambah-foto-wrapper").fadeOut(200);
});

$(document).on("click", "#edit-delete-icon", function() {

    $("#edit_gambar").val("");

    $("#edit-preview-image")
        .attr("src", "")
        .hide();

    $(this).hide();

    $("#EditUnitForm .tambah-foto-wrapper").fadeIn(200);
});


// =============================
// Tampilkan data ke modal edit
// =============================
$(document).on("click", ".btn-edit", function() {

    let id = $(this).data("id");

    $.ajax({

        url: "<?= base_url('Kelola_unit/get_unit')?>",

        type: "POST",

        data: {
            id_unit: id
        },

        dataType: "json",

        success: function(res) {

            $("#edit_id_unit").val(res.id_unit);
            $("#edit_nama_unit").val(res.nama_unit);
            $("#edit_kategori").val(res.kategori);
            $("#edit_tataletak_web").val(res.tataletak_web);
            $("#edit_seat").val(res.seat);
            $("#edit_fuel").val(res.fuel);
            $("#edit_transmition").val(res.transmition);
            $("#edit_tahun").val(res.tahun);
            $("#edit_price").val(res.price);

            if (res.gambar != "") {

                $("#edit-preview-image")
                    .attr("src", "<?= base_url('assets/img/car/') ?>" + res.gambar)
                    .show();

                $("#edit-delete-icon").show();
                $("#editFotoWrapper").hide();

            } else {

                $("#edit-preview-image").hide();

                $("#edit-delete-icon").hide();

                $("#editFotoWrapper").show();
            }

            $("#edit-unit").modal("show");

        }

    });

});

// =============================
// Update Data Unit
// =============================
$(document).on("click", "#updateUnit", function() {

    let formData = new FormData($("#EditUnitForm")[0]);

    $.ajax({

        url: "<?= base_url('Kelola_unit/update_unit')?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",

        beforeSend: function() {

            $("#updateUnit").prop("disabled", true);

            $("#editLoadingIcon").removeClass("d-none");
            $("#editLoadingText").removeClass("d-none");
            $("#updateText").addClass("d-none");

        },

        success: function(res) {

            if (res.status == "success") {

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                reloadUnitData();
                $("#edit-unit").modal("hide");


            } else {

                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: res.message
                });

            }

        },

        error: function(xhr) {

            console.log(xhr.responseText);

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Terjadi kesalahan pada server."
            });

        },

        complete: function() {

            $("#updateUnit").prop("disabled", false);

            $("#editLoadingIcon").addClass("d-none");
            $("#editLoadingText").addClass("d-none");
            $("#updateText").removeClass("d-none");

        }

    });

});
</script>