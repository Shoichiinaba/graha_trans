<style>
.border-content {
    border: 2px solid;
    border-radius: 3px;
    padding: 9px;
}

*,
*::before,
*::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.gallery {
    --anim-time--hi: 266ms;
    --anim-time--med: 400ms;
    --anim-time--lo: 600ms;

    display: flex;
    place-content: center;
    max-width: clamp(30rem, 95%, 50rem);
    width: max(22.5rem, 100%);
    min-height: 100vh;
    margin-inline: auto;
    padding: clamp(0px, (30rem - 100vw) * 9999, 1rem);

}

.gallery__content--flow {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.gallery__content--flow>* {
    flex-grow: 1;
    flex-basis: calc((30rem - 100%) * 999);
}

figure {
    display: flex;
    min-width: 14rem;
    /* max-height: 16rem; */
    position: relative;
    border-radius: .35rem;
    box-shadow:
        rgb(40, 40, 40, 0.1) 0px 2px 3px,
        rgb(20, 20, 20, 0.2) 0px 5px 8px,
        rgb(0, 0, 0, 0.25) 0px 10px 12px;
    overflow: hidden;
    transition: transform var(--anim-time--med) ease;
}

figure::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top,
            hsla(0, 0%, 0%, 0.8) 0%,
            hsla(0, 0%, 0%, 0.7) 12%,
            hsla(0, 0%, 0%, 0.2) 41.6%,
            hsla(0, 0%, 0%, 0.125) 50%,
            hsla(0, 0%, 0%, 0.01) 59.9%,
            hsla(0, 0%, 0%, 0) 100%);
    opacity: 0;
    transition-property: opacity, transform;
    transition-duration: var(--anim-time--med), var(--anim-time--med);
    transition-timing-function: ease, ease;
    z-index: 4;
}

.header__caption {
    z-index: 10;
    position: absolute;
    display: inline-flex;
    flex-direction: column;
    align-self: flex-end;
    width: 100%;
    gap: 0.5rem;
    padding: 1rem;
    justify-content: center;
    text-align: center;
    transform: translateY(100%);
    transition: transform var(--anim-time--hi) linear,
        opacity var(--anim-time--hi) linear;
}

figure:hover::before {
    opacity: 0.8;
}

figure:hover .header__caption {
    transform: translateY(0);
    opacity: 1;
}

figure:hover .img-grid-news {
    transform: scale(1);
}

.title {
    color: #fff;

}

.title--primary {
    font-size: 1.25rem;
    font-weight: bold;
}

.title--secondary {
    text-transform: uppercase;
    font-weight: bold;
}

.img-grid-news {
    display: block;
    width: 100%;
    object-fit: cover;
    object-position: center;
    height: 100%;
    transform: scale(1.15);
    aspect-ratio: 16 / 13;
    transition: 400ms ease-in-out;
}
</style>

<?php
foreach ($data_artikel_berita as $data) {
    $id_data_berita = $data->id_data_berita;
    $berita_id = $data->berita_id
?>

<!-- upload meta foto -->
<div class="row">
    <div class="col-2">
        <figure id="data-meta-foto" class="pilih-foto-meta-berita">
            <figcaption class="header__caption" role="presentation">
                <h2 class="title title--secondary">
                    <button type="button" id="" class="pilih-foto-meta-berita browse btn btn-info">Pilih Foto</button>
                </h2>
            </figcaption>
        </figure>
    </div>
</div>
<div class="form-group" hidden>
    <div class="input-group">
        <input type="file" id="file-foto-meta-berita" name="berita" class="file-berita-meta" value="" hidden>
        <input type="text" class="form-control" placeholder="Upload Foto" id="nm-foto-meta-berita">
        <div class="input-group-append">
            <button type="button" id="" class="pilih-berita-meta browse btn btn-dark">Pilih Foto</button>
        </div>
    </div>
</div>

<!-- Code upload gambar di data berita -->
<div class="form-group" hidden>
    <div class="input-group">
        <input type="file" id="file-foto-berita-other" name="berita" class="file-berita-other" value="" hidden>
        <input type="text" class="form-control" placeholder="Upload Foto" id="nm-foto-berita-other">
        <div class="input-group-append">
            <button type="button" class="pilih-berita-other browse btn btn-dark">Pilih
                Foto</button>
        </div>
    </div>
</div>

<div class="col-md-12 col-xl-12 col-lg-12">
    <div class="card shadow-none bg-transparent border border-warning mb-3">
        <div class="card-body p-2">
            <div id="galeri<?php echo $id_data_berita; ?>" class="card-text">
                <div class="row">
                    <?php foreach ($data_foto_berita as $foto) : ?>
                    <?php if ($id_data_berita == $foto->data_berita_id) : ?>
                    <div class="col-3">
                        <figure>
                            <?php
                                 $imageUrl = base_url('assets/img/berita') . '/' . $foto->file_foto_berita;
                                   echo "<img src='$imageUrl' class='img-grid-news' alt='Image not found' title='Image Title'>";
                            ?>
                            <figcaption class="header__caption" role="presentation">
                                <h2 class="title title--secondary">
                                    <button type="button" data-id-foto-berita="<?php echo $foto->id_foto_berita; ?>"
                                        data-file-foto-berita="<?php echo $foto->file_foto_berita; ?>"
                                        class="btn-hapus-foto-berita-other browse btn btn-danger">Hapus Foto</button>
                                </h2>
                            </figcaption>
                        </figure>
                    </div>

                    <?php endif; ?>
                    <?php endforeach; ?>

                    <div class="col-3">
                        <figure class="pilih-berita-other" data-id-data-berita="<?php echo $data->id_data_berita;?>">
                            <img id="preview-foto-berita-other<?php echo $data->id_data_berita; ?>"
                                src="https://media.istockphoto.com/id/1365197728/id/vektor/tambahkan-plus-tombol-cross-round-medis-ikon-vektor-3d-gaya-kartun-minimal.jpg?s=612x612&w=0&k=20&c=NKmTHM4TqtP5AuSrB779A6iMvktncz9t33fspLQWxlQ="
                                class="img-grid-news">
                            <figcaption class="header__caption" role="presentation">
                                <h2 class="title title--secondary">
                                    <button type="button" id="foto-data-berita-<?php echo $data->id_data_berita; ?>"
                                        class="browse btn btn-info">Pilih Foto</button>

                                </h2>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button"
                        class="btn-simpan-foto col-12 mt-3 btn btn-sm btn-outline-success rounded-3 shadow-lg"
                        data-id-data-berita=" <?php echo $data->id_data_berita; ?>">Simpan Foto</button>
                </div>
            </div>
            <hr>
            <span class="text-berita<?php echo $data->id_data_berita; ?>"><?php echo $data->text_berita; ?></span>
            <center>
                <a href="<?= $data->link_btn; ?>" target="_blank">
                    <img src="<?php echo base_url('assets/img/berita'); ?>/<?php echo $data->file_foto_btn; ?>"
                        class="img-fluid" alt="" style="width: 25rem;">
                </a>
            </center>

            <footer class="footer bg-light rounded-2 py-2">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn-hapus-catatan btn btn-sm btn-outline-danger rounded-3"
                            data-id-data-berita="<?php echo $data->id_data_berita; ?>">
                            <i class="fa-regular fa-pen-to-square"></i> Hapus Catatan
                        </button>
                        <button type="button" class="btn-edit-catatan btn btn-sm btn-outline-warning rounded-3"
                            data-id-data-berita="<?php echo $data->id_data_berita; ?>"
                            data-file-foto-btn="<?= $data->file_foto_btn; ?>" data-link-btn="<?= $data->link_btn; ?>">
                            <i class="fa-regular fa-pen-to-square"></i> Edit Catatan
                        </button>
                    </div>
                </div>
            </footer>

        </div>
    </div>
</div>
<?php
}
?>

<div class="row mt-2">
    <div class="col">
        <button type="button" class="btn-tambah-catatan col-12 btn btn-sm btn-outline-info rounded-3 shadow-lg"><i
                class="fa-regular fa-pen-to-square"></i> Tambah Catatan</button>
    </div>
</div>
<input type="hidden" id="meta-foto" value="">

<script>
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

// begitu tumbol di klik maka akan scrolll
document.querySelectorAll('.btn-tambah-catatan, .btn-edit-catatan, .btn-edit-berita').forEach(function(button) {
    button.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

// // tambah gambar di data artikel
$(document).on('click', '[id^=foto-data-berita-]', function() {
    var id_data_berita = $(this).closest('.pilih-berita-other').data('id-data-berita');

    if (!id_data_berita) {
        console.error("ID data berita tidak ditemukan.");
        return;
    }

    $('#file-foto-berita-other').click();

    $('#file-foto-berita-other').data('id-data-berita', id_data_berita);
});

$(document).on('change', '#file-foto-berita-other', function(e) {
    var id_data_berita = $(this).data('id-data-berita');

    var fileName = e.target.files[0].name;
    $("#nm-foto-berita-other").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        var previewElement = document.getElementById("preview-foto-berita-other" + id_data_berita);
        if (previewElement) {
            previewElement.src = e.target.result;
        } else {
            console.error("Elemen preview gambar tidak ditemukan untuk ID: preview-foto-berita-other" +
                id_data_berita);
        }
    };
    reader.readAsDataURL(this.files[0]);
});


// Proses upload dengan AJAX saat file sudah siap diupload
$('.btn-simpan-foto').click(function() {
    var id_data_berita = $(this).data('id-data-berita');
    const foto_berita = $('#file-foto-berita-other').prop('files')[0];
    let formData = new FormData();

    formData.append('foto-berita-other', foto_berita);
    formData.append('id-berita', id_data_berita);

    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('Berita/simpan_foto_berita'); ?>",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(data) {
            alert('Berhasil mengunggah foto');
            load_data_content_berita();
        },
        error: function() {
            alert("Data gagal diupload");
        }
    });
});


// code untuk upload foto meta
$('#data-meta-foto').on('click', function() {
    $('#file-foto-meta-berita').click();
});

$('#file-foto-meta-berita').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#nm-foto-meta-berita").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("preview-foto-meta-berita").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);

    const foto_meta_berita = $('#file-foto-meta-berita').prop('files')[0];
    let formData = new FormData();
    formData.append('id-berita', $('#id-berita').val());
    formData.append('meta-foto', foto_meta_berita);

    $.ajax({
        type: 'POST',
        url: "<?php echo site_url('berita/add_meta_foto') ?>",
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(msg) {
            alert('Foto berhasil diunggah');
        },
        error: function() {
            alert("Data gagal diupload");
        }
    });
});

// code edit data article
$('.btn-tambah-catatan').click(function(e) {
    form_default();
    text_editor();
    const element = document.getElementById("page");
});

function text_editor() {
    $('.btn-simpan-berita').val('add-content');
    $('#content-berita').removeAttr('hidden', true);
    $('.btn-tambah-berita').attr('hidden', true);
    $('.btn-simpan-berita, .btn-batal-berita').removeAttr('hidden', true);
}

$('.btn-edit-catatan').click(function(e) {
    text_editor();

    $('.btn-simpan-berita').val('edit-content');
    $('#id-data-berita').val($(this).data('id-data-berita'));

    var idDataBerita = $(this).data('id-data-berita');
    var summernoteElement = $('.text-berita' + idDataBerita);
    if (!summernoteElement.hasClass('note-editor')) {
        summernoteElement.summernote({
            height: 300
        });
    }

    $("#code_preview0").summernote('code', summernoteElement.summernote('code'));

    if ($(this).data('file-foto-btn') == '') {
        $('#link-btn').val('');
        $('#nm-foto-btn, #foto-btn-lama').val('');
        $('#preview-foto-btn').attr({
            src: ''
        });
        $('#btn-delete-foto-btn').hide();
        $('#btn-pilih-foto-btn').show();
    } else {
        $('#link-btn').val($(this).data('link-btn'));
        $('#nm-foto-btn, #btn-delete-foto-btn').val($(this).data('file-foto-btn'));
        $('#preview-foto-btn').attr({
            src: '<?= base_url('assets/img/berita/'); ?>' + $(this).data('file-foto-btn')
        });
        $('#btn-delete-foto-btn').show();
        $('#btn-pilih-foto-btn').hide();
    }
});

$('.btn-hapus-catatan').click(function(e) {
    $('#id-data-berita').val($(this).data('id-data-berita'));
    var confirmalert = confirm("Are you sure?");
    if (confirmalert == true) {

        let formData = new FormData();
        formData.append('id-data-berita', $(this).data('id-data-berita'));
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('berita/delete_content') ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert('Catatan berhasil di hapus');
                load_data_content_berita();

            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    }
});

$('.btn-hapus-foto-berita-other').click(function() {
    var el = this;
    var confirmalert = confirm("Are you sure?");
    if (confirmalert == true) {
        let formData = new FormData();
        formData.append('id-foto-berita', $(this).data('id-foto-berita'));
        formData.append('file-foto-berita', $(this).data('file-foto-berita'));
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('berita/delete_foto_berita') ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(msg) {
                alert('Foto berhasil di hapus');
                load_data_content_berita();

            },
            error: function() {
                alert("Data Gagal Diupload");
            }
        });
    }

})
</script>