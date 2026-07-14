<style>
.view {
    position: absolute;
    top: 16px;
    left: 10px;
    font-size: 22px;
    color: #1A44B2;
}

#Terindex {
    background: #8bc34a9c;
}

#Permintaan {
    background: #c2ddf5;
}

#Error {
    background: #ffbab5;
}

.icon-eye {
    margin-right: 15px;
}

.berita-judul {
    margin-left: 28px;
    margin-bottom: -10px
}
</style>

<div class="row">
    <div class="col-md mb-5 mb-md-0">
        <?php
            $count = 0;
            foreach ($data_berita as $data) :
                $judul_berita = $data->judul_berita;
                $tittle_news = preg_replace("![^a-z0-9]+!i", "+", $judul_berita);
                $tittle_ = preg_replace("![^a-z0-9]+!i", "-", $judul_berita);
        ?>

        <div class="accordion mt-2 shadow" id="accordionExample">
            <div class="card accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button type="button" class="accordion-button collapsed data-berita d-flex align-items-center"
                        data-bs-toggle="collapse" data-id-berita="<?php echo $data->id_berita; ?>"
                        data-bs-target="#faq-content-<?php echo $data->id_berita; ?>" aria-expanded="false"
                        aria-controls="accordionTwo">

                        <a class="view icon-eye" href="http://www.google.com/search?q=<?= $tittle_news; ?>"
                            target="_blank">
                            <i class="fa-regular fa fa-eye fa-beat"></i>
                        </a>

                        <span id="<?= $data->status_berita; ?>" class="tittel<?= $data->id_berita; ?> berita-judul">
                            <?php echo $data->judul_berita; ?>
                        </span>
                    </button>

                    <h6 class="d-flex align-items-center mt-1 mb-1" style="left: 48px; position: relative;">
                        <div id="" class="form-group me-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input ceklis-status-artikel ceklis<?= $data->id_berita; ?>"
                                    type="checkbox" data-id-berita="<?= $data->id_berita; ?>"
                                    id="ceklis-Error<?= $data->id_berita; ?>" value="Error">
                                <label for="ceklis-Error<?= $data->id_berita; ?>" class="custom-control-label"
                                    style="font-size: xx-small;">Error</label>
                            </div>
                        </div>
                        <div id="" class="form-group me-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input ceklis-status-artikel ceklis<?= $data->id_berita; ?>"
                                    type="checkbox" data-id-berita="<?= $data->id_berita; ?>"
                                    id="ceklis-Permintaan<?= $data->id_berita; ?>" value="Permintaan">
                                <label for="ceklis-Permintaan<?= $data->id_berita; ?>" class="custom-control-label"
                                    style="font-size: xx-small;">Permintaan</label>
                            </div>
                        </div>
                        <div id="" class="form-group me-3">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input ceklis-status-artikel ceklis<?= $data->id_berita; ?>"
                                    type="checkbox" data-id-berita="<?= $data->id_berita; ?>"
                                    id="ceklis-Terindex<?= $data->id_berita; ?>" value="Terindex">
                                <label for="ceklis-Terindex<?= $data->id_berita; ?>" class="custom-control-label"
                                    style="font-size: xx-small;">Terindex</label>
                            </div>
                        </div>
                        <div id="" class="form-group me-3 ">
                            <a href="<?= base_url('Artikel'); ?>/page/<?= $tittle_; ?>" target="_blank">
                                <i class="fa-regular fa-copy fa-shake"></i>
                            </a>
                        </div>
                        <div id="" class="form-group me-3">
                            <a href="#" class="btn-delete-artikel" data-id-berita="<?= $data->id_berita; ?>">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                        <input type="text" id="status-berita<?= $data->id_berita; ?>"
                            value="<?= $data->status_berita; ?>" hidden>
                    </h6>
                </h2>

                <div id="faq-content-<?php echo $data->id_berita; ?>" class="accordion-collapse collapse"
                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                <button type="button" class="btn-edit-berita col-12 btn btn-sm btn-outline-warning"
                                    data-id-berita="<?php echo $data->id_berita; ?>"
                                    data-judul-berita="<?php echo $data->judul_berita; ?>"
                                    data-tgl-berita="<?php echo $data->tgl_berita; ?>"
                                    data-meta-desk="<?php echo $data->meta_desk; ?>"
                                    data-tag-berita="<?php echo $data->tag_berita; ?>"
                                    data-foto-berita="<?php echo $data->foto_berita; ?>"
                                    data-meta-foto="<?php echo $data->meta_foto; ?>"><i
                                        class="fa-regular fa-pen-to-square fa-beat"></i> Edit
                                    Berita</button>
                            </div>
                        </div>
                        <div id="berita-data<?php echo $data->id_berita; ?>" class="berita"></div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        var status = $('#status-berita<?= $data->id_berita; ?>').val();
        $('#ceklis-' + status + <?= $data->id_berita; ?>).prop('checked', true);
        </script>
        <?php
            endforeach;
        ?>
    </div>
</div>
<!--/ Accordion -->

<script>
$(document).ready(function() {
    load_count_berita()

})
$('.data-berita').click(function() {
    $('.berita').hide().html('0');
    // alert('yaaa')
    var id_berita = $(this).data('id-berita');
    // alert(id_berita);
    let formData = new FormData();
    formData.append('id-berita', $(this).data('id-berita'));
    // formData.append('filter', $('#filter').val());

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
$('.btn-edit-berita').click(function() {
    form_default();
    $('.btn-tambah-berita').attr('hidden', true);
    $('.btn-simpan-berita, .btn-batal-berita').removeAttr('hidden', true);
    $('#form-berita').removeAttr('hidden', true);
    $(' #ceklis-ubah-berita').removeAttr('hidden', true);
    $('.btn-simpan-berita').val('edit');
    $('#id-berita').val($(this).data('id-berita'));
    $('#judul-berita').val($(this).data('judul-berita'));
    $('#tgl-berita').val($(this).data('tgl-berita'));
    $('#meta-desk').val($(this).data('meta-desk'));
    $('#foto-berita').val($(this).data('foto-berita'));
    $('#foto-lama').val($(this).data('foto-berita'));
    $('#meta-foto-lama').val($(this).data('meta-foto'));
    $('#select-tag').val($(this).data('tag-berita'));
    $('#select-tag').select2().trigger('change');
    $('#preview-foto-berita').attr({
        src: '<?php echo base_url('assets/img/berita'); ?>/' + $(this).data('foto-berita')
    });
    const element = document.getElementById("page");
    element.scrollIntoView();
});
$('.ceklis-status-artikel').click(function(e) {
    var id_berita_ceklis = $(this).data('id-berita');
    $('.ceklis' + id_berita_ceklis).not(this).prop('checked', false);
    if ($(this).is(":checked")) {
        var value_ceklis = $(this).val();
        // $('.tittel' + id_berita_ceklis).attr('id', value_ceklis)
    } else {
        var value_ceklis = '';

    }
    var confirmalert = confirm("Are you sure?");
    if (confirmalert == true) {
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
            success: function(msg) {
                $('.tittel' + id_berita_ceklis).attr('id', value_ceklis)
                load_count_berita()
            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    }
});
$('.btn-delete-artikel').click(function(e) {
    var confirmalert = confirm("Are you sure?");

    if (confirmalert == true) {
        // alert($(this).data('id-berita'));
        let formData = new FormData();
        formData.append('id-berita', $(this).data('id-berita'));
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('berita/delete_artikel') ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(msg) {
                // alert(msg);
                load_count_berita()
                load_data_berita();

            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    };
})

function load_data_meta_foto() {
    let formData = new FormData();
    formData.append('id-berita', $('#id-berita').val());
    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('berita/data_meta_foto'); ?>",
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

function load_count_berita() {
    // let formData = new FormData();
    $.ajax({
        // type: 'POST',
        url: "<?php echo site_url('berita/load_count_berita'); ?>",
        // data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            // alert(data);
            $('#script-load-count-berita').html(data);
        },
        error: function() {
            alert("Data Gagal Diupload");
        }
    });
}
// $('.btn-delete').click(function(e) {
//     var el = this;
//     var confirmalert = confirm("Are you sure?");
//     if (confirmalert == true) {
//         let formData = new FormData();
//         formData.append('id-berita', $(this).data('id-berita'));
//         formData.append('foto-berita', $(this).data('foto-berita'));
//         $.ajax({
//             type: 'POST',
//             url: "<?php echo site_url('berita/delete_data_berita') ?>",
//             data: formData,
//             cache: false,
//             processData: false,
//             contentType: false,
//             success: function(msg) {
//                 // alert('berhasil');
//                 $(el).closest('tr').css('background', 'tomato');
//                 $(el).closest('tr').fadeOut(300, function() {
//                     $(this).remove();
//                 });
//             },
//             error: function() {
//                 alert("Data Gagal Diupload");
//             }
//         });
//     }
// });
// $('.btn-edit').click(function(e) {
//     $('.btn-batal-berita').removeAttr('hidden', true);
//     $(' #ceklis-ubah-berita').removeAttr('hidden', true);
//     $('.btn-simpan-berita').val('edit');
//     $('#id-berita').val($(this).data('id-berita'));
//     $('#judul-berita').val($(this).data('judul-berita'));
//     $('#tgl-berita').val($(this).data('tgl-berita'));
//     $('#desk-berita').val($(this).data('desk-berita'));
//     $('#foto-berita').val($(this).data('foto-berita'));
//     $('#foto-lama').val($(this).data('foto-berita'));
//     $('#preview-foto-berita').attr({
//         src: '<?php echo base_url('upload'); ?>/' + $(this).data('foto-berita')
//     });
// });
</script>