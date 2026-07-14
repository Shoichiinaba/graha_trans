<!-- modal generate key -->
<div class="modal fade" id="create-key" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Generate Key</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="generateApiKeyForm">
                <div class="modal-body pt-2">
                    <div class="container mt-2">
                        <div class="input-wrapper mt-1 col-12">
                            <input type="text" id="key_name" name="key_name" class="form-control" required>
                            <label for="key_name" class="label-in">Key Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitkey" class="btn btn-primary rounded-3">
                        <span id="loadingIcon" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                        <span id="loadingText" class="d-none">Generating...</span>
                        <span id="submitText">Generate API Key</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // code generate_key
    $('#generateApiKeyForm').on('submit', function(e) {
        e.preventDefault();

        $('#loadingIcon').removeClass('d-none');
        $('#loadingText').removeClass('d-none');
        $('#submitText').addClass('d-none');

        var keyName = $('#key_name').val();

        $.ajax({
            url: '<?php echo base_url('Api_keys/generate_key'); ?>',
            type: 'POST',
            data: {
                key_name: keyName
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                    $('#responseMessage').html(
                        '<div class="alert alert-success">API Key generated: ' + result
                        .api_key + '</div>'
                    );
                } else {
                    $('#responseMessage').html('<div class="alert alert-danger">' + result
                        .message + '</div>');
                }
            },
            error: function(xhr) {
                var errorMessage = xhr.responseText ? xhr.responseText :
                    'An error occurred';
                $('#responseMessage').html('<div class="alert alert-danger">' +
                    errorMessage + '</div>');
            },
            complete: function() {
                reloadDataKey();
                $('#loadingIcon').addClass('d-none');
                $('#loadingText').addClass('d-none');
                $('#submitText').removeClass('d-none');
                $('#create-key').modal('hide');
                $("#create-key")[0].reset();
            }
        });
    });

    // kode menampilkan list API Keys
    var limit = 4;
    var start = 0;
    var action = 'inactive';
    var total_pages = 1;

    function lazzy_loader(limit) {
        var output = '';
        output += '<div class="post_data">';
        output += '<div class="image-placeholder content-placeholder">&nbsp;</div>';
        output += '<div class="details-placeholder">';
        output += '<div class="title-placeholder content-placeholder">&nbsp; </div>';
        output += '<div class="sub-title-placeholder content-placeholder">&nbsp;</div>';
        output += '<div class="price-placeholder content-placeholder">&nbsp;</div>';
        output += '</div>';
        output += '</div>';
        $('#load_data_message').html(output);
    }

    lazzy_loader(limit);

    function load_data(limit, start, search = '') {
        $.ajax({
            url: "<?php echo base_url(); ?>Api_keys/fetch_key",
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
                load_data(limit, start, $('#search-banner').val());
            }
        } else if ($(this).hasClass('next')) {
            if (start + limit < total_pages * limit) {
                start += limit;
                load_data(limit, start, $('#search-banner').val());
            }
        } else {
            var page = parseInt($(this).find('.page-link').text());
            start = (page - 1) * limit;
            load_data(limit, start, $('#search-banner').val());
        }
    });

    load_data(limit, start);

    $('#search-banner').on('input', function() {
        var search = $(this).val();
        start = 0;
        load_data(limit, start, search);
    });

});

// Fungsi untuk memuat ulang data
var baseUrl = "<?php echo base_url(); ?>";
var limit = 4;
var start = 0;
var total_pages = 0;

function reloadDataKey() {
    var search = $('#search-reels').val();

    $.ajax({
        url: "<?php echo base_url(); ?>Api_keys/fetch_key",
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
                    '<i class="fa fa-folder-open"></i> Data key Tidak Ditemukan...</div>'
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
    reloadDataKey();
}

$(document).ready(function() {
    reloadDataKey();
});

$(document).on('click', '.btn-delete', function() {
    var idKey = $(this).data('id');

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: "Apakah Anda yakin ingin menghapus data API Key?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url('Api_keys/hapus_dataKey'); ?>",
                type: "POST",
                data: {
                    id_key: idKey
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Terhapus!',
                            'Agent berhasil dihapus.',
                            'success'
                        ).then(() => {
                            reloadDataKey();
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

$(document).on('click', '.status-toggle', function() {
    var id = $(this).data('id');
    var currentStatus = $(this).data('status');

    $.ajax({
        url: '<?= base_url('Api_keys/update_status') ?>',
        method: 'POST',
        data: {
            id: id,
            status: currentStatus
        },
        dataType: 'json',
        success: function(response) {
            var newStatus = response.new_status;
            var statusElement = $('#status-' + id);

            if (newStatus == 'active') {
                statusElement.html('<i class="bx bx-badge-check p-0"></i> Active');
                statusElement.removeClass('bg-label-warning').addClass('bg-label-success');
                statusElement.data('status', 'active');
            } else {
                statusElement.html('<i class="bx bx-shield-x"></i> Inactive');
                statusElement.removeClass('bg-label-success').addClass('bg-label-warning');
                statusElement.data('status', 'inactive');
            }
        }
    });
});

$(document).on('click', '.btn-copy', function(e) {
    e.preventDefault();

    var apiKey = $(this).data('key');

    var $temp = $('<input>');
    $('body').append($temp);
    $temp.val(apiKey).select();
    document.execCommand('copy');
    $temp.remove();

    Swal.fire({
        icon: 'success',
        title: 'Copied!',
        text: 'API Key has been copied to clipboard.',
        timer: 1500,
        showConfirmButton: false
    });
});
</script>