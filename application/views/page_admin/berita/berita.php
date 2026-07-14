<style>
.note-editor {
    margin-bottom: 1rem !important;
}

.btn-group-sm>.btn,
.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}

.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

.open>.dropdown-menu {
    display: block;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
}

.btn-toolbar .btn-group,
.btn-toolbar .input-group {
    float: left;
}

.btn-group,
.btn-group-vertical {
    position: relative;
    display: inline-block;
    vertical-align: middle;
}

.btn-group-vertical>.btn-group:after,
.btn-toolbar:after,
.clearfix:after,
.container-fluid:after,
.container:after,
.dl-horizontal dd:after,
.form-horizontal .form-group:after,
.modal-footer:after,
.nav:after,
.navbar-collapse:after,
.navbar-header:after,
.navbar:after,
.pager:after,
.panel-body:after,
.row:after {
    clear: both;
}

.btn-group-vertical>.btn-group:after,
.btn-group-vertical>.btn-group:before,
.btn-toolbar:after,
.btn-toolbar:before,
.clearfix:after,
.clearfix:before,
.container-fluid:after,
.container-fluid:before,
.container:after,
.container:before,
.dl-horizontal dd:after,
.dl-horizontal dd:before,
.form-horizontal .form-group:after,
.form-horizontal .form-group:before,
.modal-footer:after,
.modal-footer:before,
.nav:after,
.nav:before,
.navbar-collapse:after,
.navbar-collapse:before,
.navbar-header:after,
.navbar-header:before,
.navbar:after,
.navbar:before,
.pager:after,
.pager:before,
.panel-body:after,
.panel-body:before,
.row:after,
.row:before {
    display: table;
    content: " ";
}

:after,
:before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.dropdown-menu>li>a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}

.dropdown-menu>li>a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}

.select2-container {
    width: -webkit-fill-available !important;
}

.card-icon {
    padding: 0px 10px;
    background-image: linear-gradient(#1A44B2, #8358DF, #129BCD);
    place-self: center;
    font-size: 37px;
    border-radius: 8px;
    text-align: center;
    color: #fff;
}

.border-card {
    border-radius: 14px;
    padding: 4px 17px;
    border: solid 3px #0000001f;
}

.active-info {
    box-shadow: inset 0 0px 15px rgba(158, 255, 113, 0.5);
    border: none;
    color: #fff;
    transition: transform 0.3s ease, background 0.3s ease;
}

.filter:hover {
    transform: scale(1.05);
    cursor: pointer;
}

#preview-foto-berita {
    max-width: 50%;
    height: auto;
    margin-left: 85px;
    margin-top: 18px;
}

#ceklis-ubah-berita {
    margin-top: 15px;
    margin-left: -95px;
}

.custom-control-label {
    margin-left: 5px;
}

/* css data berita */
/* lazzy_loader */
.lazzy-loader-card {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #f0f0f0;
    position: relative;
    margin-bottom: -17px;
    height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    animation: loadingAnimation 1.5s infinite;
}

.lazzy-loader-title {
    background-color: #e0e0e0;
    padding: 10px 15px;
    border-radius: 3px;
    color: transparent;
    font-weight: bold;
    width: 99%;
    margin-bottom: auto;
}

.lazzy-loader-checkbox-icons {
    display: flex;
    align-items: center;
    position: absolute;
    bottom: 10px;
    left: 10px;
    gap: 10px;
}

.lazzy-loader-checkbox-icons label,
.lazzy-loader-checkbox-icons i {
    color: #ccc;
    font-size: 1rem;
    background-color: #e0e0e0;
    padding: 5px;
    border-radius: 3px;
    animation: loadingAnimation 1.5s infinite;
}

@keyframes loadingAnimation {
    0% {
        background-color: #e0e0e0;
    }

    50% {
        background-color: #f0f0f0;
    }

    100% {
        background-color: #e0e0e0;
    }
}

.view {
    position: absolute;
    top: 16px;
    left: 10px;
    font-size: 22px;
    color: #1A44B2;
}

#Terindex {
    background: linear-gradient(135deg, rgba(50, 189, 1, 0.5), rgba(41, 237, 225, 0.5));
    border-radius: 3px;
}

#Permintaan {
    background: linear-gradient(135deg, rgba(251, 225, 38, 0.5), rgba(158, 254, 113, 0.5));
    border-radius: 3px;
}

#Error {
    background: linear-gradient(135deg, rgba(255, 0, 0, 0.5), rgba(225, 138, 0, 0.5));
    border-radius: 3px;
}

.icon-eye {
    margin-right: 15px;
}

.berita-judul {
    margin-left: 28px;
    margin-bottom: -10px
}
</style>

<div class="container-xxl flex-grow-1 container-p-y pt-0">
    <main id="main" class="pt-5rem">
        <div class="m-3 mt-2">
            <!-- form buat berita -->
            <div id="form-berita" class="row" hidden>
                <div class="card shadow bg-transparent border border-primary mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 mt-2">
                                <label for="nm-perum">Judul Berita</label>
                                <div class="form-group">
                                    <input type="text" id="judul-berita" class="form-control"
                                        placeholder="Judul Berita ..." autocomplete="off" required="true">
                                </div>

                                <label for="nm-perum">Meta Deskripsi</label>
                                <div class="form-group">
                                    <input type="text" id="meta-desk" class="form-control" placeholder="Deskripsi ..."
                                        autocomplete="off" required="true">
                                </div>

                                <label>Tgl Terbit Berita</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="padding: 10px;">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="tgl-berita" value="">
                                    </div>
                                </div>
                                <label for="select-kota">Tag</label>
                                <div class="form-group">
                                    <select id="select-tag" class="js-states form-control col-12">
                                    </select>
                                </div>
                                <div class="input-group input-tag">
                                    <input type="text" id="tag-berita" class="form-control " placeholder="...">
                                </div>
                                <div class="form-group">
                                    <label for="pilih-foto-berita">Foto Berita</label>
                                    <div class="input-group">
                                        <input type="file" id="file-foto-berita" name="berita" class="file-berita"
                                            hidden>
                                        <input type="text" class="form-control pilih-berita" placeholder="Upload Foto"
                                            id="nm-foto-berita">
                                        <div class="input-group-append">
                                            <button type="button" id="browse-foto-berita"
                                                class="browse btn btn-dark">Pilih Foto</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mt-2 text-center">
                                <div class="form-group">
                                    <img src="" id="preview-foto-berita" class="img-thumbnail img-fluid">
                                    <input type="text" id="foto-lama" hidden>
                                    <input type="text" id="meta-foto-lama" hidden>
                                </div>
                                <div id="ceklis-ubah-berita" class="form-group" hidden>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="ceklis-ubah-foto-berita"
                                            value="">
                                        <label for="ceklis-ubah-foto-berita" class="custom-control-label">Ceklis untuk
                                            Mengubah Foto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- form tambah content -->
            <div id="content-berita" class="row" hidden>
                <div class="card shadow bg-transparent border border-success mb-0">
                    <div class="card-body">
                        <div id="content-row">
                            <div class="form-group">
                                <label class="">Page Content</label>
                                <div>
                                    <textarea class="form-control" id="code_preview0" style="height: 300px;"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="">Gambar</label>
                                    <div class="input-group">
                                        <input type="text" id="foto-btn-lama" class="" value="" hidden>
                                        <input type="file" id="file-foto-btn" class="foto-btn" value="" hidden>
                                        <input type="text" class="form-control pilih-foto-btn" readonly=""
                                            placeholder="Upload Gambar" id="nm-foto-btn">
                                        <div class="input-group-append">
                                            <button type="button" id="btn-pilih-foto-btn"
                                                class="pilih-foto-btn browse btn btn-dark">Pilih Foto</button>
                                            <button type="button" id="btn-delete-foto-btn" class="browse btn btn-danger"
                                                style="display: none;" value="">Hapus Foto</button>
                                        </div>
                                    </div>
                                    <label for="link-btn">Link</label>
                                    <div class="input-group">
                                        <input type="text" id="link-btn" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <img id="preview-foto-btn" src="" class="img-thumbnail"
                                        style="max-height: 20rem; display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="foto-berita" class="row" hidden></div>
            <div class="demo-inline-spacing mb-1 ml-0" style="margin-left: -10px;">
                <button type="button" class="btn-batal-berita btn btn-sm btn-outline-danger" hidden>
                    <i class="fa-regular fa-pen-to-square"></i> Batal
                </button>

                <button type="button" class="btn-tambah-berita btn btn-sm btn-primary rounded-2" data-bs-toggle="modal"
                    data-bs-target="#add-agent" style="margin-left: -10px;">
                    Tambah Article
                </button>

                <button type="button" class="btn-simpan-berita btn btn-sm float-right btn-outline-success"
                    value="simpan" hidden>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                        style="display: none;"></span>
                    Simpan
                </button>

            </div>
            <input type="text" id="id-berita" hidden>
            <input type="text" id="id-data-berita" hidden>
            <input type="text" id="id-foto-berita" hidden>
        </div>
        <ul class="nav row gy-4 d-flex mb-3" role="tablist">
            <li class="nav-item col-12 col-md-4 col-lg-3" role="presentation">
                <a class="filter card border-card nav-link show active-info" data-filter="All" data-bs-toggle="tab">
                    <div class="row">
                        <div class="col-xxl-2 col-lg-3 card-icon"><i class="fa-regular fa-newspaper fa-beat"
                                style="font-size: 28px;"></i></div>
                        <div class="col-xxl-10 col-lg-9" style="text-align-last: end;">
                            <p class="mb-0" style="letter-spacing: 3px;font-weight: bolder;">Artikel</p>
                            <span id="all" class=""></span>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item col-12 col-md-4 col-lg-3" role="presentation">
                <a class="filter card border-card nav-link" data-bs-toggle="tab" data-filter="Permintaan">
                    <div class="row">
                        <div class="col-xxl-2 col-lg-3 card-icon"><i class="fa-solid fa-spinner fa-spin-pulse"
                                style="font-size: 28px;"></i></div>
                        <div class="col-xxl-10 col-lg-9" style="text-align-last: end;">
                            <p class="mb-0 text-warning" style="letter-spacing: 3px;font-weight: bolder;">Permintaan</p>
                            <span id="permintaan" class=" text-warning"></span>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item col-12 col-md-4 col-lg-3" role="presentation">
                <a class="filter card border-card nav-link" data-bs-toggle="tab" data-filter="Terindex">
                    <div class="row">
                        <div class="col-xxl-2 col-lg-3 card-icon"><i class="fa-regular fa-circle-check fa-fade"
                                style="font-size: 28px;"></i></div>
                        <div class="col-xxl-10 col-lg-9" style="text-align-last: end;">
                            <p class="mb-0 text-success" style="letter-spacing: 3px;font-weight: bolder;">Terindex</p>
                            <span id="terindex" class="text-success"></span>
                        </div>
                    </div>
                </a>
            </li><!-- End Tab 1 Nav -->
            <li class="nav-item col-12 col-md-4 col-lg-3" role="presentation">
                <a class="filter card border-card nav-link" data-bs-toggle="tab" data-filter="Error">
                    <div class="row">
                        <div class="col-xxl-2 col-lg-3 card-icon"><i class="fa-solid fa-circle-exclamation fa-shake"
                                style="font-size: 28px;"></i></div>
                        <div class="col-xxl-10 col-lg-9" style="text-align-last: end;">
                            <p class="mb-0 text-danger" style="letter-spacing: 3px;font-weight: bolder;">Error</p>
                            <span id="error" class=" text-danger"></span>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
        <!-- data berita -->
        <div class="row">
            <div class="col-md mb-5 mb-md-0" id="load_data">
                <div id="load_data_message"></div>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm">
                        <li class="page-item prev">
                            <a class="page-link" href="javascript:void(0);"><i
                                    class="tf-icon bx bx-chevrons-left"></i></a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0);">1</a>
                        </li>
                        <li class="page-item next">
                            <a class="page-link" href="javascript:void(0);"><i
                                    class="tf-icon bx bx-chevrons-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</div>