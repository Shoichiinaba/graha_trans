<div class="modal fade" id="add-reels" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Tambah Reels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-2" id="form-container">
                    <form id="upload-reels" enctype="multipart/form-data">
                        <!-- Data Properti -->
                        <div class="row">
                            <div class="input-wrapper col-4 proper">
                                <input class="form-control" list="datalistOptions" id="exampleDataList"
                                    name="judul_properti" placeholder="Ketik nama properti...">
                                <label for="exampleDataList" class="label-in">Pilih Properti</label>
                                <datalist id="datalistOptions">
                                    <?php foreach ($prop_select as $prop) : ?>
                                    <option data-id="<?php echo $prop->id_properti; ?>"
                                        value="<?php echo $prop->judul_properti; ?>">
                                    </option>
                                    <?php endforeach; ?>
                                </datalist>
                                <input type="hidden" name="id_properti" id="id-properti">
                            </div>
                            <div class="input-wrapper mt-1 col-5">
                                <input type="text" id="judul" name="judul" class="form-control" required>
                                <label for="judul" class="label-in">Judul</label>
                            </div>
                            <div class="input-wrapper mt-1 col-3">
                                <input type="text" id="sosmed" name="sosmed" class="form-control" required>
                                <label for="sosmed" class="label-in">Sosial Media</label>
                            </div>
                        </div>
                        <div class="input-wrapper mt-3">
                            <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
                            <label for="deskripsi" class="label-in">Deskripsi</label>
                        </div>
                        <!-- upload Reels -->
                        <div class="alert alert-info mt-4" role="alert">Upload Reels Videos
                            <div id="dropzone" class="dropzone mt-2"></div>
                            <div id="responseMessage" class="mt-3"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitReels" class="btn btn-primary rounded-3">
                    <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="loadingText" class="d-none">Menyimpan...</span>
                    <span id="submitText">Simpan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- modal Ubah -->
<div class="modal fade" id="ubah-reels" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Ubah Reels</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="container mt-2" id="form-container">
                    <form id="ubah-reels-form" enctype="multipart/form-data">
                        <!-- Data Reels -->
                        <div class="row">
                            <div class="input-wrapper col-4 proper" disabled>
                                <input class="form-control" list="datalistOptions" id="judul_properti"
                                    name="judul_properti" placeholder="Ketik nama properti...">
                                <label for="judul_properti" class="label-in">Pilih Properti</label>
                                <datalist id="datalistOptions">
                                    <?php foreach ($prop_select as $prop) : ?>
                                    <option data-id="<?php echo $prop->id_properti; ?>"
                                        value="<?php echo $prop->judul_properti; ?>">
                                    </option>
                                    <?php endforeach; ?>
                                </datalist>
                                <input type="hidden" name="id_properti" id="ubah-id-properti">
                                <input type="hidden" name="id_reel" id="id-reel">
                            </div>
                            <div class="input-wrapper mt-1 col-5">
                                <input type="text" id="ubah-judul" name="ubah-judul" class="form-control" required>
                                <label for="ubah-judul" class="label-in">Judul</label>
                            </div>
                            <div class="input-wrapper mt-1 col-3">
                                <input type="text" id="ubah-sosmed" name="ubah-sosmed" class="form-control" required>
                                <label for="ubah-sosmed" class="label-in">Sosial Media</label>
                            </div>
                        </div>
                        <div class="input-wrapper mt-3">
                            <textarea id="ubah-deskripsi" name="ubah-deskripsi" class="form-control"
                                required></textarea>
                            <label for="ubah-deskripsi" class="label-in">Deskripsi</label>
                        </div>
                        <div class="alert alert-info mt-4" role="alert">
                            Upload Reels Videos
                            <div id="video-preview" class="position-relative">
                            </div>
                            <button type="button" id="change-video" class="btn btn-sm btn-primary rounded-3">Ganti
                                Video</button>
                            <input type="file" id="upload-video" class="d-none" accept="video/mp4">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="ubahReels" class="btn btn-primary rounded-3">
                    <span id="Icon-ubah" class="spinner-border spinner-border-sm d-none" role="status"
                        aria-hidden="true"></span>
                    <span id="Text-ubah" class="d-none">Menyimpan...</span>
                    <span id="ubahText">Ubah</span>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
$('#exampleDataList').on('input', function() {
    var inputVal = $(this).val();
    var selectedOption = $('#datalistOptions option').filter(function() {
        return this.value == inputVal;
    });

    if (selectedOption.length) {
        var idPro = selectedOption.data('id');
        $('#id-properti').val(selectedOption.data('id'));

    }
});

// $(document).ready(function() {
Dropzone.autoDiscover = false;

$(document).ready(function() {
    var reelsDropzone = new Dropzone("#dropzone", {
        url: "<?php echo site_url('Kelola_video/upload_video'); ?>",
        method: "post",
        paramName: "video_reels",
        dataType: "json",
        maxFilesize: 100,
        acceptedFiles: "video/*",
        addRemoveLinks: true,
        autoProcessQueue: false,
        parallelUploads: 1,
        init: function() {
            var myDropzone = this;

            $('#submitReels').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                toggleLoading(true);

                if (myDropzone.getQueuedFiles().length > 0) {
                    myDropzone.processQueue();
                } else {
                    saveReelsData(null);
                }
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append("judul_properti", $('#exampleDataList').val());
                formData.append("judul", $('[name="judul"]').val());
                formData.append("sosmed", $('[name="sosmed"]').val());
                formData.append("deskripsi", $('[name="deskripsi"]').val());
            });

            myDropzone.on("success", function(file, response) {
                console.log("Server response:", response);
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                console.log("Parsed Video Path:", response.video_path);
                saveReelsData(response);
            });

            myDropzone.on("error", function(file, response) {
                toggleLoading(false);
                alert("Gagal mengunggah video.");
            });
        }
    });

    function saveReelsData(response) {
        var videoPath = response && response.video_path ? response.video_path : null;
        var id_properti = $('#id-properti').val();

        var data = {
            id_properti: id_properti,
            judul: $('[name="judul"]').val(),
            sosmed: $('[name="sosmed"]').val(),
            deskripsi: $('[name="deskripsi"]').val(),
            video: videoPath
        };

        $.ajax({
            url: "<?php echo site_url('Kelola_video/simpan_reels'); ?>",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(res) {
                toggleLoading(false);
                if (res.status === "success") {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Reels berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#add-reels').modal('hide');
                    location.reload();
                } else {

                    Swal.fire({
                        position: 'top-center',
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menyimpan data reels: ' + res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX error:", status, error); // Debug log
                toggleLoading(false);
                Swal.fire({
                    position: 'top-center',
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan data reels.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }

    function toggleLoading(isLoading) {
        if (isLoading) {
            $('#loadingIcon').removeClass('d-none');
            $('#loadingText').removeClass('d-none');
            $('#submitText').addClass('d-none');
        } else {
            $('#loadingIcon').addClass('d-none');
            $('#loadingText').addClass('d-none');
            $('#submitText').removeClass('d-none');
        }
    }
});

// kode daftar video reels
$(document).ready(function() {
    var limit = 3;
    var start = 0;
    var action = 'inactive';
    var total_pages = 1;

    function lazzy_loader(limit) {
        var output = '<div class="container-loader">';
        for (var count = 0; count < limit; count++) {
            output += '<div class="post_data">';
            output += '<div class="image-placeholder content-placeholder">&nbsp;</div>';
            output += '<div class="details-placeholder">';
            output += '<div class="title-placeholder content-placeholder">&nbsp;</div>';
            output += '<div class="sub-title-placeholder content-placeholder">&nbsp;</div>';
            output += '<div class="price-placeholder content-placeholder">&nbsp;</div>';
            output += '</div>';
            output += '</div>';
        }
        output += '</div>';
        $('#load_data_message').html(output);
    }

    lazzy_loader(limit);

    function load_data(limit, start, search = '') {
        $.ajax({
            url: "<?php echo base_url(); ?>Kelola_video/fetch_reels",
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
                        '<i class="fa fa-folder-open"></i> Data Reels Tidak Ditemukan...</div>'
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
                load_data(limit, start, $('#search-reels').val());
            }
        } else if ($(this).hasClass('next')) {
            if (start + limit < total_pages * limit) {
                start += limit;
                load_data(limit, start, $('#search-reels').val());
            }
        } else {
            var page = parseInt($(this).find('.page-link').text());
            start = (page - 1) * limit;
            load_data(limit, start, $('#search-reels').val());
        }
    });

    load_data(limit, start);

    $('#search-reels').on('input', function() {
        var search = $(this).val();
        start = 0;
        load_data(limit, start, search);
    });
});

// Fungsi untuk memuat ulang data video
var baseUrl = "<?php echo base_url(); ?>";
var limit = 3;
var start = 0;
var total_pages = 0;

function reloadVideoData() {
    var search = $('#search-reels').val();

    $.ajax({
        url: baseUrl + "Kelola_video/fetch_reels",
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
                    '<i class="fa fa-folder-open"></i> Data Reels Tidak Ditemukan...</div>'
                );
                action = 'active';
            } else {
                $('#load_data').html(response.data);
                $('#load_data_message').html("");
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
        '<li class="page-item prev"><a class="page-link" href="javascript:void(0);" onclick="changePage(' + Math.max(
            start - limit, 0) + ');"><i class="tf-icon bx bx-chevrons-left"></i></a></li>';

    for (var i = 1; i <= total_pages; i++) {
        paginationHtml += '<li class="page-item ' + (i === (start / limit) + 1 ? 'active' : '') +
            '"><a class="page-link" href="javascript:void(0);" onclick="changePage(' + (i - 1) * limit + ');">' + i +
            '</a></li>';
    }

    paginationHtml +=
        '<li class="page-item next"><a class="page-link" href="javascript:void(0);" onclick="changePage(' + Math.min(
            start + limit, (total_pages - 1) * limit) + ');"><i class="tf-icon bx bx-chevrons-right"></i></a></li>';

    $('.pagination').html(paginationHtml);
}

// Fungsi untuk mengubah halaman
function changePage(newStart) {
    if (newStart < 0 || newStart >= total_pages * limit) {
        return;
    }
    start = newStart;
    reloadVideoData();
}

$(document).ready(function() {
    reloadVideoData();
});

// kode edit data reel
$(document).ready(function() {

    $('#judul_properti').on('input', function() {
        var inputVal = $(this).val();
        var selectedOption = $('#datalistOptions option').filter(function() {
            return this.value == inputVal;
        });

        if (selectedOption.length) {
            var idPro = selectedOption.data('id');
            $('#ubah-id-properti').val(selectedOption.data('id'));

        }
    });

    var baseUrl = "<?php echo base_url(); ?>";

    // Saat tombol ubah data diklik
    $(document).on('click', '.ubah-data', function() {
        var judul = $(this).data('judul');
        var sosmed = $(this).data('sosmed');
        var deskripsi = $(this).data('deskripsi');
        var idProperti = $(this).data('idproperti');
        var judulProperti = $(this).data('judulproperti');
        var video = $(this).data('video');
        var idReel = $(this).data('id');

        $('#ubah-judul').val(judul);
        $('#ubah-sosmed').val(sosmed);
        $('#ubah-deskripsi').val(deskripsi);
        $('#ubah-id-properti').val(idProperti);
        $('#judul_properti').val(judulProperti);
        $('#id-reel').val(idReel);

        // Hapus video sebelumnya
        $('#video-preview').empty();
        $('#change-video').addClass('d-none');

        // Tampilkan video jika ada
        if (video) {
            var videoPath = `${baseUrl}upload/videos/${video}`;
            console.log("Video Path: ", videoPath);

            var videoElement = `
                <video controls>
                    <source src="${videoPath}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>`;
            $('#video-preview').append(videoElement);
            $('#change-video').removeClass('d-none');
        }

        $('#ubah-reels').modal('show');
    });

    // Tampilkan input file ketika tombol "Ganti Video" diklik
    $('#change-video').on('click', function() {
        $('#upload-video').click(); // Klik input file
    });

    // Menangani pengunggahan video baru
    $('#upload-video').on('change', function() {
        $('#video-preview').empty(); // Hapus video preview sebelumnya

        var file = this.files[0];
        var url = URL.createObjectURL(file);

        var videoElement = `
            <video controls>
                <source src="${url}" type="video/mp4">
                Your browser does not support the video tag.
            </video>`;
        $('#video-preview').append(videoElement);

        // Tampilkan kembali tombol ganti video setelah video baru dipilih
        $('#change-video').removeClass('d-none');
    });

    // Saat tombol "Ubah" diklik, simpan data melalui AJAX
    $(document).on('click', '#ubahReels', function(e) {
        e.preventDefault();

        var formData = new FormData($('#ubah-reels-form')[0]);

        if ($('#upload-video')[0].files.length > 0) {
            formData.append('video', $('#upload-video')[0].files[0]);
        }

        console.log("FormData content:", formData);

        $.ajax({
            url: "<?php echo site_url('kelola_video/simpan_ubah_reels'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('#ubahReels').prop('disabled', true);
                $('#Icon-ubah').removeClass('d-none');
                $('#ubahText').text('Menyimpan...');
            },

            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Reels berhasil diubah.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        reloadVideoData();
                    });

                    $('#ubah-reels').modal('hide');
                    $('#ubahReels').prop('disabled', false);
                    $('#Icon-ubah').addClass('d-none');
                    $('#ubahText').text('Ubah');

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
                    text: 'Terjadi kesalahan saat mengirim data.',
                });
            }
        });
    });

    // kode hapus data reels
    $(document).on('click', '.btn-delete', function() {
        var idReel = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus video ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('kelola_video/hapus_reel'); ?>",
                    type: "POST",
                    data: {
                        id_reel: idReel
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Terhapus!',
                                'Video berhasil dihapus.',
                                'success'
                            ).then(() => {
                                reloadVideoData();
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

});
</script>