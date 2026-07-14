<style>
/* css loader */
@-webkit-keyframes placeHolderShimmer {
    0% {
        background-position: -468px 0;
    }

    100% {
        background-position: 468px 0;
    }
}

@keyframes placeHolderShimmer {
    0% {
        background-position: -468px 0;
    }

    100% {
        background-position: 468px 0;
    }
}

.content-placeholder {
    display: inline-block;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    -webkit-animation-name: placeHolderShimmer;
    animation-name: placeHolderShimmer;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: -webkit-gradient(linear, left top, right top, color-stop(8%, #eeeeee), color-stop(18%, #dddddd), color-stop(33%, #eeeeee));
    background: -webkit-linear-gradient(left, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
    background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
    -webkit-background-size: 800px 104px;
    background-size: 800px 104px;
    height: inherit;
    position: relative;
    border-radius: 5px;
}

.post_data {
    padding: 16px;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    margin-bottom: 24px;
    background-color: #fff;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
}

/* css halaman data properti */

.image-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    margin-right: 16px;
}

.details-placeholder {
    width: calc(100% - 120px);
}

.title-placeholder {
    width: 70%;
    height: 20px;
    margin-bottom: 8px;
}

.sub-title-placeholder {
    width: 50%;
    height: 20px;
    margin-bottom: 8px;
}

.price-placeholder {
    width: 40%;
    height: 30px;
    margin-bottom: 8px;
}


.image-pro {
    flex: 0 0 180px;
    width: 35%;
    margin-left: inherit;
    width: 260px;
    height: 145px;
    overflow: hidden;
}

.image-pro img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.harga {
    color: #1A44B2;
    font-weight: bold;
}

.unit {
    color: black;
    font-weight: bold;
}

.tayang {
    font-size: smaller;
}

.pagin {
    position: relative;
}

.desk {
    flex: 1 1 auto;
    padding: 0.1rem 0.1rem;
}

.tombol {
    flex: 0 0 auto;
    width: 96px;
}

.tombol button:hover .icon-img {
    filter: brightness(0) invert(1);
}

/* css inputan */
.input-wrapper {
    position: relative;
    line-height: 14px;
    margin: 0 0px;
    display: grid;
}

.label-in {
    color: #bbb;
    font-size: 11px;
    text-transform: uppercase;
    position: absolute;
    z-index: 2;
    left: 20px;
    top: 14px;
    padding: 0 2px;
    pointer-events: none;
    background: #fff;
    -webkit-transition: -webkit-transform 100ms ease;
    -moz-transition: -moz-transform 100ms ease;
    -o-transition: -o-transform 100ms ease;
    -ms-transition: -ms-transform 100ms ease;
    transition: transform 100ms ease;
    -webkit-transform: translateY(-20px);
    -moz-transform: translateY(-20px);
    -o-transform: translateY(-20px);
    -ms-transform: translateY(-20px);
    transform: translateY(-20px);
}

.form-control,
textarea,
select {
    font-size: 12px;
    color: #555;
    outline: none;
    border: 1px solid #bbb;
    padding: 15px 20px 10px;
    border-radius: 10px;
    position: relative;
}

.form-control:invalid+label,
select:invalid+label,
textarea:invalid+label {
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -o-transform: translateY(0);
    -ms-transform: translateY(0);
    transform: translateY(0);
}

.form-control:focus,
select:focus,
textarea:focus {
    border-color: #1A44B2;
}

.form-control:focus+label,
select:focus+label,
textarea:focus+label {
    color: #2b96f1;
    -webkit-transform: translateY(-20px);
    -moz-transform: translateY(-20px);
    -o-transform: translateY(-20px);
    -ms-transform: translateY(-20px);
    transform: translateY(-20px);
}

.dropzone .dz-preview {
    position: relative;
}

.dropzone .dz-preview .btn-remove {
    position: absolute;
    top: 98px;
    right: 30px;
    display: none;
    z-index: 10;
    border-radius: 23%;
}

.dropzone .dz-preview:hover .btn-remove {
    display: block;
}

/* kode untuk menampilkan tombol lihat detail properti */
.image-pro {
    position: relative;
    overflow: hidden;
}

.btn-view {
    display: none;
    position: absolute;
    top: 39%;
    left: 40%;
    transform: translate(-4%, -9%);
    padding: 1px 6px;
    background-color: rgba(0, 0, 0, 0.6);
    color: #fff !important;
    border-radius: 10px;
    text-decoration: none;
    font-size: 11px;
}

.btn-del {
    display: none;
    position: absolute;
    top: 25%;
    left: 40%;
    transform: translate(-4%, -9%);
    padding: 1px 6px;
    margin-top: -7px;
    background-color: rgba(0, 0, 0, 0.6);
    color: #fff !important;
    border-radius: 10px;
    text-decoration: none;
    font-size: 11px;
}

.image-pro:hover .btn-view,
.image-pro:hover .btn-del {
    display: block;
}

.ribbon {
    width: 141px;
    height: 73px;
    overflow: hidden;
    position: absolute;
}

.ribbon::before,
.ribbon::after {
    position: absolute;
    z-index: -1;
    content: "";
    display: block;
    border: 5px solid #2980b9;
}

.ribbon span {
    position: absolute;
    display: block;
    width: 297px;
    padding: 5px 0;
    background-color: #1A44B2;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: #fff;
    font: 600 11px/1 "Lato", sans-serif;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    text-align: center;
}

/* top left*/
.ribbon-top-left {
    top: -3px;
    left: 4px;
}

.ribbon-top-left::before,
.ribbon-top-left::after {
    border-top-color: transparent;
    border-left-color: transparent;
}

.ribbon-top-left::before {
    top: 0;
    right: 0;
}

.ribbon-top-left::after {
    bottom: 0;
    left: 0;
}

.ribbon-top-left span {
    right: -44px;
    top: 18px;
    transform: rotate(-40deg);
}

/* pengaturan total properti */
.custom-btn {
    font-size: 12px;
    padding: 0px 7px;
    height: 25px;
    display: flex;
    align-items: center;
    border-color: transparent;
    color: #1A44B2;
    background-color: transparent;
}

.custom-btn:hover {
    background-color: #1A44B2;
    color: white;
}

.custom-badge {
    font-size: 11px;
    padding: 3px 5px;
    margin-left: 3px;
    background-color: #1A44B2 !important;
    color: white !important;
}

.custom-btn:hover .custom-badge {
    background-color: white !important;
    color: #1A44B2 !important;
}

#gambar-preview img {
    max-width: 148px;
    height: auto;
    border-radius: 5px;
    object-fit: cover;
    position: relative;
}

.gambar-item {
    position: relative;
}

.hapus-gambar {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: rgba(229 0 0 / 62%);
    color: white;
    border-radius: 50%;
    padding: 5px;
    display: none;
    cursor: pointer;
}

.gambar-item:hover .hapus-gambar {
    display: block;
}

.tambah-foto-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 231px;
    height: 83px;
    border: 2px dashed #1a44b2;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 235px;
    margin-top: 4px;
}

.tambah-foto-btn {
    background-color: transparent;
    border: none;
    font-size: 14px;
    color: #555;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.tambah-foto-btn i {
    font-size: 24px;
    margin-bottom: 5px;
}

.tambah-foto-wrapper:hover {
    background-color: #e9e9e9;
}

#meta-preview img {
    width: 55%;
    height: auto;
    display: block;
    margin: 5px 0;
    border-radius: 5px;

}

#meta-preview {
    position: relative;
    width: 100%;
    max-width: 285px;
    height: auto;
    overflow: hidden;
    margin: -3px auto -19px auto;
    text-align: center;
}

#meta-preview:hover #delete-icon {
    display: block;
    /* Tampilkan ikon saat di-hover */
}

#meta-preview img {
    width: 70%;
    height: auto;
    display: block;
    margin: 5px auto;
    border-radius: 5px;
}

.delete-icon {
    position: absolute;
    top: 5px;
    right: 5px;
    font-size: 20px;
    color: red;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    padding: 2px 6px;
}

/* Mengatur ukuran lebar dan tinggi search form */
.custom-search-form {
    width: 164px;
    height: 30px;
}

.custom-search-icon {
    background-color: #1A44B2;
    color: #ffffff;
    border: none;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 10px;
}

#search-unit {
    height: 102%;
    font-size: 11px;
    line-height: 25px;
    padding: 9px;
    text-align: left;
}

.custom-filter-button {
    width: 140px;
    height: 28px;
    font-size: 11px;
    line-height: 25px;
    padding: 0;
    text-align: center;
}

.custom-filter {
    padding-left: 7px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="demo-inline-spacing mb-3">
        <button type="button" class="btn btn-sm btn-primary rounded-2" data-bs-toggle="modal"
            data-bs-target="#add-unit">Tambah Unit</button>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0">Daftar Unit Mobil</h5>
        </div>

        <!-- Search Form and Filter Group -->
        <div class="d-flex align-items-center">
            <!-- Search Form -->
            <form class="d-flex shadow-lg me-0 custom-search-form">
                <div class="input-group">
                    <span class="input-group-text custom-search-icon"><i class="tf-icons bx bx-search"></i></span>
                    <input type="text" id="search-unit" class="form-control" placeholder="Search..." />
                </div>
            </form>

            <!-- Filter Button -->
            <div class="custom-filter">
                <div class="btn-group">
                    <button type="button" id="filterButton" class="btn btn-warning dropdown-toggle custom-filter-button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-filter'></i> Filter Kategori
                    </button>
                    <ul class="dropdown-menu">
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center filter-kategori"
                            data-kategori="">
                            <i class="bx bx-chevron-right scaleX-n1-rtl"></i> Filter Kategori
                        </a>
                        <?php foreach ($filter_kategori as $data) : ?>
                        <li>
                            <a href="javascript:void(0);"
                                class="dropdown-item d-flex align-items-center filter-kategori"
                                data-kategori="<?= $data->kategori; ?>">
                                <i class="bx bx-chevron-right scaleX-n1-rtl"></i> <?= $data->kategori; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="custom-filter">
                <div class="btn-group">
                    <button type="button" id="button-penawaran"
                        class="btn btn-primary dropdown-toggle custom-filter-button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class='bx bx-filter'></i> Filter Tahun
                    </button>
                    <ul class="dropdown-menu">
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center filter-tahun"
                            data-tahun="">
                            <i class="bx bx-chevron-right scaleX-n1-rtl"></i> Semua Tahun
                        </a>
                        <?php foreach ($tahun as $data) : ?>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center filter-tahun"
                                data-tahun="<?= $data->tahun; ?>">
                                <i class="bx bx-chevron-right scaleX-n1-rtl"></i> <?= $data->tahun; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="custom-filter">
                <div class="btn-group">
                    <button type="button" id="button-penawaran"
                        class="btn btn-success dropdown-toggle custom-filter-button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class='bx bx-filter'></i> Filter Tranmisi
                    </button>
                    <ul class="dropdown-menu">
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center filter-transmisi"
                            data-transmisi="">
                            <i class=" bx bx-chevron-right scaleX-n1-rtl"></i> Semua transmisi
                        </a>
                        <?php foreach ($transmisi as $data) : ?>
                        <li>
                            <a href="javascript:void(0);"
                                class="dropdown-item d-flex align-items-center filter-transmisi"
                                data-transmisi="<?= $data->transmition; ?>">
                                <i class="bx bx-chevron-right scaleX-n1-rtl"></i> <?= $data->transmition; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-0" id="load_data">
    </div>
    <div id="load_data_message"></div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center align-items-center">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item prev">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0);">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);">2</a>
                </li>
                <li class="page-item next">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            </ul>
        </nav>
        <button type="button" class="btn btn-sm btn-outline-primary rounded-3 custom-btn ms-3 py-0 px-1">
            Total Unit
            <span class="badge custom-badge ms-2">5</span>
        </button>
    </div>
</div>