<!-- modal tambah agent -->
<div class="modal fade" id="add-agent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Tambah Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-2" id="form-container">
                    <form id="daftar-agent" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-wrapper mt-1 col-4">
                                <input type="text" id="nama-agent" name="nama_agent" class="form-control" required>
                                <label for="nama-agent" class="label-in">Nama</label>
                            </div>
                            <div class="input-wrapper mt-1 col-4">
                                <input type="email" id="email" name="email" class="form-control" required>
                                <label for="email" class="label-in">Email</label>
                            </div>
                            <div class="input-wrapper mt-1 col-4">
                                <input type="number" id="no-tlp" name="no_tlp" class="form-control" required>
                                <label for="no-tlp" class="label-in">Phone</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="input-wrapper col-4">
                                <input type="text" id="username" name="username" class="form-control" required>
                                <label for="username" class="label-in">Username</label>
                            </div>
                            <div class="input-wrapper col-4">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <label for="password" class="label-in">Password</label>
                            </div>
                            <div class="input-wrapper proper col-4">
                                <input class="form-control" list="datalistOptions" id="exampleDataList" name="posisi"
                                    placeholder="Search Posisi...">
                                <label for="exampleDataList" class="label-in">Pilih Posisi</label>
                                <datalist id="datalistOptions">
                                    <option value="Admin"></option>
                                    <option value="Owner"></option>
                                    <option value="admin_oprational"></option>
                                </datalist>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="input-wrapper col-6">
                                <textarea id="alamat" name="alamat" class="form-control" required></textarea>
                                <label for="alamat" class="label-in">Alamat</label>
                            </div>
                            <div class="alert alert-primary col-6 mb-0" role="alert">Upload Foto Profile
                                <div id="dropzone" class="dropzone mt-2"></div>
                                <div id="responseMessage" class="mt-3"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitAgent" class="btn btn-primary rounded-3">
                    <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="loadingText" class="d-none">Menyimpan...</span>
                    <span id="submitText">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- modal ubah agent -->
<div class="modal fade" id="edit-agent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-2" id="form-container">
                    <form id="edit-agent-form" enctype="multipart/form-data">
                        <input type="hidden" id="edit-id-agent" name="id_agent">
                        <div class="row">
                            <div class="input-wrapper mt-1 col-4">
                                <input type="text" id="edit-nama-agent" name="nama_agent" class="form-control" required>
                                <label for="edit-nama-agent" class="label-in">Nama</label>
                            </div>
                            <div class="input-wrapper mt-1 col-4">
                                <input type="email" id="edit-email" name="email" class="form-control" required>
                                <label for="edit-email" class="label-in">Email</label>
                            </div>
                            <div class="input-wrapper mt-1 col-4">
                                <input type="number" id="edit-no-tlp" name="no_tlp" class="form-control" required>
                                <label for="edit-no-tlp" class="label-in">Phone</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="input-wrapper col-4">
                                <input type="text" id="edit-username" name="username" class="form-control" required>
                                <label for="edit-username" class="label-in">Username</label>
                            </div>
                            <div class="input-wrapper col-4">
                                <input type="password" id="edit-password" name="password" class="form-control">
                                <label for="edit-password" class="label-in">Password (opsional)</label>
                            </div>
                            <div class="input-wrapper proper col-4">
                                <input class="form-control" list="editDatalistOptions" id="edit-posisi" name="posisi"
                                    placeholder="Search Posisi...">
                                <label for="edit-posisi" class="label-in">Pilih Posisi</label>
                                <datalist id="editDatalistOptions">
                                    <option value="Admin"></option>
                                    <option value="Owner"></option>
                                    <option value="admin_oprational"></option>
                                </datalist>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="input-wrapper col-6">
                                <textarea id="edit-alamat" name="alamat" class="form-control" required></textarea>
                                <label for="edit-alamat" class="label-in">Alamat</label>
                            </div>
                            <div class="alert alert-primary col-6 mb-0" role="alert">Upload Foto Profile
                                <div id="profil-preview" class="position-relative">
                                </div>
                                <button type="button" id="change-foto" class="btn btn-sm btn-primary rounded-3">Ganti
                                    Profil</button>
                                <input type="file" id="upload-profil" class="d-none" name="foto_profil">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitEditAgent" class="btn btn-primary rounded-3">
                    <span id="loadingIconEdit" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="loadingTextEdit" class="d-none">Menyimpan...</span>
                    <span id="submitTextEdit">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!--Modal data Listing-->
<div class="modal fade" id="data-listing" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Data Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body shadow-lg">
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    var limit = 6;
    var start = 0;
    var action = 'inactive';
    var total_pages = 1;

    function lazzy_loader(limit) {
        var output = '<div class="row">';
        for (var count = 0; count < limit; count++) {
            output += '<div class="col-lg-4 mb-4">';
            output += '<div class="card shadow-lg post_data" style="padding: 20px;">';
            output += '<div class="d-flex align-items-end row">';

            // Placeholder untuk bagian teks
            output += '<div class="col-sm-7 col-lg-7">';
            output += '<div class="card-body pt-0 mt-0">';
            output +=
                '<div class="content-placeholder title-placeholder" style="height: 20px; width: 150px; margin-bottom: 10px;">&nbsp;</div>';
            output +=
                '<div class="content-placeholder sub-title-placeholder" style="height: 15px; width: 100px; margin-bottom: 10px;">&nbsp;</div>';
            output +=
                '<div class="content-placeholder details-placeholder" style="height: 15px; width: 120px; margin-bottom: 10px;">&nbsp;</div>';
            output +=
                '<div class="content-placeholder details-placeholder" style="height: 15px; width: 150px; margin-bottom: 10px;">&nbsp;</div>';
            output +=
                '<div class="content-placeholder details-placeholder" style="height: 15px; width: 120px; margin-bottom: 10px;">&nbsp;</div>';
            output += '</div>';
            output += '</div>';

            // Placeholder untuk bagian gambar
            output += '<div class="col-sm-5 col-lg-5 text-end text-sm-left">';
            output += '<div class="card-body pb-0 px-0 px-md-4 pt-0">';
            output +=
                '<div class="content-placeholder image-placeholder" style="height: 105px; width: 105px; border-radius: 50%;">&nbsp;</div>';
            output += '</div>';
            output += '</div>';

            output += '</div>';
            output += '</div>';
            output += '</div>';
        }
        output += '</div>'; // End row
        $('#load_data_message').html(output);
    }

    lazzy_loader(limit);

    function load_data(limit, start, search = '') {
        $.ajax({
            url: "<?php echo base_url(); ?>Kelola_user/fetch_agent",
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
                        '<i class="fa fa-folder-open"></i> Data Agent Tidak Ditemukan...</div>'
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
                load_data(limit, start, $('#search-agent').val());
            }
        } else if ($(this).hasClass('next')) {
            if (start + limit < total_pages * limit) {
                start += limit;
                load_data(limit, start, $('#search-agent').val());
            }
        } else {
            var page = parseInt($(this).find('.page-link').text());
            start = (page - 1) * limit;
            load_data(limit, start, $('#search-agent').val());
        }
    });

    load_data(limit, start);

    $('#search-agent').on('input', function() {
        var search = $(this).val();
        $('#load_data').html('');
        start = 0;
        lazzy_loader(limit);
        load_data(limit, start, search);
    });
});

// Fungsi untuk memuat ulang data
var baseUrl = "<?php echo base_url(); ?>";
var limit = 6;
var start = 0;
var total_pages = 0;

function reloadAgentData() {
    var search = $('#search-reels').val();

    $.ajax({
        url: baseUrl + "Kelola_user/fetch_agent",
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
                    '<i class="fa fa-folder-open"></i> Data Agent Tidak Ditemukan...</div>'
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
    reloadAgentData();
}

$(document).ready(function() {
    reloadAgentData();
});

// code untuk tambah agent
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("#dropzone", {
    url: "<?= base_url('Kelola_user/daftar'); ?>",
    method: "post",
    paramName: "file",
    maxFilesize: 3,
    acceptedFiles: "image/jpeg,image/png,image/jpg",
    uploadMultiple: false,
    parallelUploads: 1,
    autoProcessQueue: false,
    addRemoveLinks: true,
    maxFiles: 1,

    init: function() {

        let dz = this;

        $("#submitAgent").click(function(e) {

            e.preventDefault();

            $("#submitAgent").prop("disabled", true);

            $("#submitText").addClass("d-none");
            $("#loadingIcon").removeClass("d-none");
            $("#loadingText").removeClass("d-none");

            var form = $("#daftar-agent")[0];
            var formData = new FormData(form);

            dz.options.params = {
                nama_agent: formData.get("nama_agent"),
                email: formData.get("email"),
                no_tlp: formData.get("no_tlp"),
                username: formData.get("username"),
                password: formData.get("password"),
                posisi: formData.get("posisi"),
                alamat: formData.get("alamat")
            };

            // Jika ada file upload
            if (dz.getQueuedFiles().length > 0) {

                dz.processQueue();

            } else {

                // Tidak upload foto
                $.ajax({

                    url: "<?= base_url('Kelola_user/daftar'); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",

                    success: function(response) {

                        selesai(response);

                    },

                    error: function() {

                        gagal("Terjadi kesalahan server.");

                    }

                });

            }

        });

        dz.on("success", function(file, response) {

            selesai(response);

        });

        dz.on("error", function(file, response) {

            if (typeof response == "object") {
                gagal(response.message);
            } else {
                gagal(response);
            }

        });

    }

});

function selesai(response) {

    $("#submitAgent").prop("disabled", false);

    $("#submitText").removeClass("d-none");
    $("#loadingIcon").addClass("d-none");
    $("#loadingText").addClass("d-none");

    if (typeof response === "string") {
        response = JSON.parse(response);
    }

    if (response.status == "success") {

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.message,
            timer: 1500,
            showConfirmButton: false
        }).then(function() {

            $("#add-agent").modal("hide");

            $("#daftar-agent")[0].reset();

            myDropzone.removeAllFiles(true);

            reloadAgentData();

        });

    } else {

        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            html: response.message
        });

    }

}

function gagal(msg) {

    $("#submitAgent").prop("disabled", false);

    $("#submitText").removeClass("d-none");
    $("#loadingIcon").addClass("d-none");
    $("#loadingText").addClass("d-none");

    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        html: msg
    });

}

// kode hapus data reels
$(document).on('click', '.btn-delete', function() {
    var idAgent = $(this).data('id');

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: "Apakah Anda yakin ingin menghapus data Agent?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url('Kelola_user/hapus_agent'); ?>",
                type: "POST",
                data: {
                    id_agent: idAgent
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Terhapus!',
                            'Agent berhasil dihapus.',
                            'success'
                        ).then(() => {
                            reloadAgentData();
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

// code ubah data agent

$(document).ready(function() {

    // Menangani klik tombol Edit
    $(document).on('click', '.btn-edit', function() {
        var id_agent = $(this).data('id');
        var nama_agent = $(this).data('nama_agent');
        var email = $(this).data('email');
        var no_tlp = $(this).data('no_tlp');
        var position = $(this).data('position');
        var alamat = $(this).data('alamat');
        var username = $(this).data('username');
        var foto = $(this).data('foto');

        $('#edit-id-agent').val(id_agent);
        $('#edit-nama-agent').val(nama_agent);
        $('#edit-email').val(email);
        $('#edit-no-tlp').val(no_tlp);
        $('#edit-username').val(username);
        $('#edit-posisi').val(position);
        $('#edit-alamat').val(alamat);

        // Hapus foto sebelumnya
        $('#profil-preview').empty();
        $('#change-foto').addClass('d-none');

        // Tampilkan foto jika ada
        if (foto) {
            var fotoPath = `${baseUrl}assets/img/admin/${foto}`;
            var imgElement = `<img src="${fotoPath}" alt="Foto Profil" class="img-fluid" />`;
            $('#profil-preview').append(imgElement);
            $('#change-foto').removeClass('d-none');
        }

        $('#ubah-reels').modal('show');
    });

    // Menangani klik tombol Ganti Profil
    $('#change-foto').on('click', function() {
        $('#upload-profil').click();
    });

    // Menangani perubahan pada input file
    $('#upload-profil').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        console.log("File uploaded: " + fileName); // Opsional: menampilkan nama file yang diupload

        // Mengupdate preview jika file dipilih
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profil-preview').empty();
                var imgElement =
                    `<img src="${e.target.result}" alt="Foto Profil" class="img-fluid" />`;
                $('#profil-preview').append(imgElement);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Simpan perubahan
    $('#submitEditAgent').on('click', function() {
        const formData = new FormData($('#edit-agent-form')[0]);

        const fileInput = $('#upload-profil')[0].files[0];
        if (fileInput) {
            console.log('File name:', fileInput.name);
        } else {
            console.log('No file selected');
        }

        $.ajax({
            url: '<?php echo base_url("Kelola_user/updateAgentData"); ?>',
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

                $('#edit-agent').modal('hide');
                reloadAgentData();
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