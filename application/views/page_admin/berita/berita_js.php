<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Daterangepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<!-- Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- Daterangepicker -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    $('#code_preview0').summernote({
        height: 300
    });
});

var content_row = 1;

function addContent() {
    html = '<div id="content-row">';
    html += '<div class="form-group">';
    html += '<label class="col-sm-2">Page Content</label>';
    html += '<div class="col-sm-10">';
    html +=
        '<textarea class="form-control" id="code_preview' +
        content_row +
        '" name="page_code[' +
        content_row +
        '][code]" style="height: 300px;"></textarea>';
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $("#content-row").append(html);
    $("#code_preview" + content_row).summernote({
        height: 300
    });

    content_row++;
}
$(function() {
    var url = window.location.href;

    $(".note-toolbar").each(function() {

        if (url == (this.href)) {
            $(this).closest(".btn-default").addClass("active-info");
        }
    });

});

function load_data_content_berita() {
    var id_berita = $('#id-berita').val();
    let formData = new FormData();
    formData.append('id-berita', $('#id-berita').val());

    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('Berita/data_artikel_berita'); ?>",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#berita-data' + id_berita).html(data).show();
        },
        error: function() {
            alert("Data Gagal Diupload");
        }
    });
}
</script>

<script>
select_tag();
$('.input-tag').hide();
$('.btn-tambah-berita').click(function(e) {
    $('#form-berita').removeAttr('hidden', true);
    $('.btn-tambah-berita').attr('hidden', true);
    $('.btn-simpan-berita, .btn-batal-berita').removeAttr('hidden', true);
});
$('#select-tag').change(function(e) {
    var tag = $("#select-tag").find(':selected').val();
    if (tag == 'add tag') {
        $('.input-tag').val('').show();
    } else {
        $('.input-tag').hide();
        $('#tag-berita').val(tag);
    }
});


$('.browse').click(function() {
    $('#file-foto-berita').trigger('click');
});

$('#file-foto-berita').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#nm-foto-berita").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview-foto-berita").src = e.target.result;
    };

    reader.readAsDataURL(this.files[0]);
});

$('#ceklis-ubah-foto-berita').click(function(e) {
    if ($(this).is(":checked")) {
        $('#ceklis-ubah-foto-berita').val('change-foto-berita');
    } else {
        $('#ceklis-ubah-foto-berita').val('');
    }
});

$('.btn-simpan-berita').click(function(e) {
    e.preventDefault();

    var action = $('.btn-simpan-berita').val();
    const foto_berita = $('#file-foto-berita').prop('files')[0];
    const foto_btn = $('#file-foto-btn').prop('files')[0];
    let formData = new FormData();

    var tagBerita = $('#tag-berita').val();

    // Menambahkan data ke formData
    formData.append('id-berita', $('#id-berita').val());
    formData.append('id-data-berita', $('#id-data-berita').val());
    formData.append('text-berita', $('#code_preview0').summernote('code'));
    formData.append('ceklis-ubah-foto-berita', $('#ceklis-ubah-foto-berita').is(':checked') ? 1 : 0);
    formData.append('judul-berita', $('#judul-berita').val());
    formData.append('keyword', $('#keyword').val());
    formData.append('meta-desk', $('#meta-desk').val());
    formData.append('tgl-berita', $('#tgl-berita').val());
    formData.append('tag-berita', tagBerita);
    formData.append('foto-berita', foto_berita);
    formData.append('foto-lama', $('#foto-lama').val());
    formData.append('file-foto-btn', foto_btn);
    formData.append('link-btn', $('#link-btn').val());
    formData.append('foto-btn-lama', $('#foto-btn-lama').val());

    $('.btn-simpan-berita .spinner-border').show();
    $('.btn-simpan-berita').prop('disabled', true);

    let url;
    if (action == 'simpan') {
        url = "<?php echo site_url('berita/simpan_data_berita'); ?>";
    } else if (action == 'edit') {
        url = "<?php echo site_url('berita/edit_data_berita'); ?>";
    } else if (action == 'add-content') {
        url = "<?php echo site_url('berita/add_content'); ?>";
    } else if (action == 'edit-content') {
        url = "<?php echo site_url('berita/edit_content'); ?>";
    }

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            let successMessage = '';

            // Menentukan pesan sukses berdasarkan action
            if (action == 'simpan') {
                successMessage = 'Berita berhasil disimpan.';
            } else if (action == 'edit') {
                successMessage = 'Berita berhasil diperbarui.';
            } else if (action == 'add-content') {
                successMessage = 'Konten berhasil ditambahkan.';
            } else if (action == 'edit-content') {
                successMessage = 'Konten berhasil diperbarui.';
            }

            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                timer: 1500,
                showConfirmButton: false
            });

            // / Reload data berdasarkan action
            if (action == 'simpan' || action == 'edit') {
                location.reload();
                form_default();
                loadCountBerita();
            } else if (action == 'add-content' || action == 'edit-content') {
                load_data_content_berita();
                form_default();
                loadCountBerita();
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data gagal diupload.'
            });
        },
        complete: function() {
            // Sembunyikan spinner dan aktifkan kembali tombol
            $('.btn-simpan-berita .spinner-border').hide();
            $('.btn-simpan-berita').prop('disabled', false);
        }
    });

});

$('.btn-batal-berita').click(function(e) {
    form_default();
});

$(function() {
    $('#tgl-berita').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD MMMM YYYY'
        }
    })
});

// Ketika tombol "Pilih Foto" diklik, trigger input file
$('#btn-pilih-foto-btn').click(function() {
    if ($('#file-foto-btn').val() === '') {
        $('#file-foto-btn').trigger('click');
    }
});

// Handle file input change event
$('#file-foto-btn').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#nm-foto-btn").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview-foto-btn").src = e.target.result;
        $('#preview-foto-btn').show();
        $('#btn-delete-foto-btn').show();
        $('#btn-pilih-foto-btn').hide();
    };

    reader.readAsDataURL(this.files[0]);
});

// Handle delete photo button click event
$('#btn-delete-foto-btn').click(function() {
    // Reset preview dan input file
    $('#preview-foto-btn').hide().attr('src', '');
    $('#btn-delete-foto-btn').hide();
    $('#btn-pilih-foto-btn').show();
    $('#file-foto-btn, #nm-foto-btn, #link-btn').val('');
    $('#foto-btn-lama').val($(this).val());
});

function form_default() {
    $('.btn-simpan-berita').val('simpan');
    $('.btn-simpan-berita, .btn-batal-berita').attr('hidden', true);
    $('#form-berita, #content-berita').attr('hidden', true);
    $('.btn-tambah-berita').removeAttr('hidden', true);

    // Reset semua input field dan preview gambar
    $('#judul-berita, #meta-desk, #file-foto-berita, #nm-foto-berita').val('');
    $('#preview-foto-berita').attr('src', '');
    $('#ceklis-ubah-foto-berita').prop('checked', false);
    $('#ceklis-ubah-berita').attr('hidden', true);
    $('.btn-simpan-berita .spinner-border').hide();
    $('.btn-simpan-berita').prop('disabled', false);

    // Reset Summernote editor content to empty string
    $("#code_preview0").summernote('code', '');
}

function select_tag() {
    $.ajax({
        url: "<?php echo site_url('berita/select_data_tag'); ?>",
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            $("#select-tag").html(data);
        },
        error: function() {
            alert("Data Gagal Diuploadzzzzz");
        }
    });
}
$("#select-tag").select2({
    placeholder: "Pilih Tags",
    allowClear: true
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// code js data berita

$(document).ready(function() {

    $('.filter').on('click', function() {
        $('.filter').removeClass('active-info');
        $(this).addClass('active-info');
    });

    var limit = 30;
    var start = 0;
    var total_pages = 1;
    var action = 'inactive';

    function lazy_loader(limit) {
        var output = '<div class="row">';
        for (var count = 0; count < limit; count++) {
            output += '<div class="col-lg-12 mb-4">';
            output += '<div class="lazzy-loader-card">';
            output += '<div class="lazzy-loader-title">&nbsp;</div>';
            output += '<div class="lazzy-loader-checkbox-icons">';
            output += '<label><input type="checkbox" disabled />&nbsp;</label>';
            output += '<label><input type="checkbox" disabled />&nbsp;</label>';
            output += '<label><input type="checkbox" disabled />&nbsp;</label>';
            output += '<i class="fa fa-copy"></i>';
            output += '<i class="fa fa-trash"></i>';
            output += '</div></div></div>';
        }
        output += '</div>';
        $('#load_data_message').html(output);
    }

    lazy_loader(limit);

    function load_data(limit, start, filter = 'All') {
        lazy_loader(limit);

        $.ajax({
            url: "<?php echo base_url(); ?>Berita/fetch_berita",
            method: "POST",
            data: {
                limit: limit,
                start: start,
                filter: filter
            },
            cache: false,
            success: function(data) {
                var response = JSON.parse(data);
                if (response.data.trim() === '') {
                    $('#load_data').html(
                        '<div class="alert alert-primary alert-dismissible" role="alert">' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '<i class="fa fa-folder-open"></i> Data Tidak Ditemukan...</div>'
                    );
                    action = 'active';
                } else {
                    $('#load_data').html(response.data);
                    $('#load_data_message').html('');
                    total_pages = response.total_pages;
                    update_pagination();
                    action = 'inactive';

                    $('.accordion-item').each(function() {
                        var idBerita = $(this).find('input[type="text"]').attr('id')
                            .replace('status-berita', '');
                        var statusBerita = $('#status-berita' + idBerita).val();

                        if (statusBerita === 'Error') {
                            $('#ceklis-Error' + idBerita).prop('checked', true);
                        }

                        if (statusBerita === 'Permintaan') {
                            $('#ceklis-Permintaan' + idBerita).prop('checked', true);
                        }

                        if (statusBerita === 'Terindex') {
                            $('#ceklis-Terindex' + idBerita).prop('checked', true);
                        }
                    });
                }
            },
            error: function() {
                $('#load_data').html(
                    '<div class="alert alert-danger">Terjadi kesalahan dalam memuat data.</div>'
                );
            }
        });
    }

    load_data(limit, start);

    function update_pagination() {
        var paginationHtml = '';

        paginationHtml += '<li class="page-item prev ' + (start === 0 ? 'disabled' : '') +
            '"><a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a></li>';

        for (var i = 1; i <= total_pages; i++) {
            paginationHtml += '<li class="page-item ' + (i === (start / limit) + 1 ? 'active' : '') +
                '"><a class="page-link" href="javascript:void(0);">' + i + '</a></li>';
        }

        paginationHtml += '<li class="page-item next ' + (start + limit >= total_pages * limit ? 'disabled' :
                '') +
            '"><a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a></li>';

        $('.pagination').html(paginationHtml);
    }

    $(document).on('click', '.filter', function() {
        var filter = $(this).data('filter');
        start = 0;
        load_data(limit, start, filter);
    });

    $(document).on('click', '.pagination .page-item', function() {
        if ($(this).hasClass('prev')) {
            if (start >= limit) {
                start -= limit;
                load_data(limit, start);
            }
        } else if ($(this).hasClass('next')) {
            if (start + limit < total_pages * limit) {
                start += limit;
                load_data(limit, start);
            }
        } else {
            var page = parseInt($(this).find('a').text());
            start = (page - 1) * limit;
            load_data(limit, start);
        }
    });
});

// update status berita
$(document).on('click', '.ceklis-status-artikel', function(e) {
    var id_berita_ceklis = $(this).data('id-berita');

    $('.ceklis' + id_berita_ceklis).not(this).prop('checked', false);

    var value_ceklis = '';
    if ($(this).is(":checked")) {
        value_ceklis = $(this).val();
    }

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Status berita akan diubah menjadi: Publish &" + value_ceklis,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id-berita', id_berita_ceklis);
            formData.append('status-berita', value_ceklis);

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('berita/validasi_index') ?>",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire(
                        'Berhasil!',
                        'Status berita berhasil dipublish.',
                        'success'
                    );

                    loadCountBerita();
                    let judulElement = $('.tittel' + id_berita_ceklis);
                    judulElement.attr('id', value_ceklis);
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat mengubah status berita.',
                        'error'
                    );
                }
            });
        } else {
            $(this).prop('checked', false);
        }
    });
});

// hapus data berita
$(document).on('click', '.btn-delete-artikel', function(e) {
    e.preventDefault(); // Mencegah aksi default tombol
    var idBerita = $(this).data('id-berita');

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Artikel ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1A44B2',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('id-berita', idBerita);

            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('Berita/delete_artikel') ?>",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Artikel berhasil dihapus.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#accordionExample').find('[data-id-berita="' + idBerita + '"]')
                        .closest('.accordion-item').remove();

                    loadCountBerita()
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan, tidak dapat menghapus artikel!'
                    });
                }
            });
        }
    });
});

// AJAX call untuk memuat count berita
function loadCountBerita() {
    $.ajax({
        url: "<?php echo base_url(); ?>Berita/load_count_berita",
        type: 'GET',
        dataType: 'json',
        success: function(data) {

            $('#all').text(data.all);
            $('#permintaan').text(data.permintaan);
            $('#terindex').text(data.terindex);
            $('#error').text(data.error);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error fetching data: ' + textStatus);
        }
    });
}

$(document).ready(function() {
    loadCountBerita();
});

$(document).on('click', '.data-berita', function(e) {
    $('.berita').hide().html('0');
    var id_berita = $(this).data('id-berita');
    let formData = new FormData();
    formData.append('id-berita', $(this).data('id-berita'));

    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('Berita/data_artikel_berita'); ?>",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#berita-data' + id_berita).html(data).show();
            $('#id-berita').val(id_berita);
            load_data_meta_foto();
        },
        error: function() {
            alert("Data Gagal Diupload123");
        }
    });
})

$(document).on('click', '.btn-edit-berita', function(e) {
    form_default();
    $('.btn-tambah-berita').attr('hidden', true);
    $('.btn-simpan-berita, .btn-batal-berita').removeAttr('hidden', true);
    $('#form-berita').removeAttr('hidden', true);
    $(' #ceklis-ubah-berita').removeAttr('hidden', true);
    $('.btn-simpan-berita').val('edit');
    $('#id-berita').val($(this).data('id-berita'));
    $('#judul-berita').val($(this).data('judul-berita'));
    $('#tgl-berita').val($(this).data('tgl-berita'));
    $('#keyword').val($(this).data('keyword'));
    $('#meta-desk').val($(this).data('meta-desk'));
    $('#foto-berita').val($(this).data('foto-berita'));
    $('#foto-lama').val($(this).data('foto-berita'));
    $('#meta-foto-lama').val($(this).data('meta-foto'));
    $('#select-tag').val($(this).data('tag-berita'));
    $('#select-tag').select2().trigger('change');
    $('#preview-foto-berita').attr({
        src: '<?php echo base_url('assets/img/berita'); ?>/' + $(this).data('foto-berita')
    });

});

function load_data_meta_foto() {
    let formData = new FormData();
    let idBerita = $('#id-berita').val();

    if (!idBerita) {
        alert('ID Berita tidak ditemukan');
        return;
    }

    formData.append('id-berita', idBerita);

    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('Berita/data_meta_foto'); ?>",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#data-meta-foto').html(data);
        },
        error: function() {
            alert("Data Gagal Diupload");
        }
    });
}
</script>