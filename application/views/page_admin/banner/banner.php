<style>
/* css loader */
/* Placeholder styling */
.post_data {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #ffffff;
    /* White background */
    border: 1px solid #ddd;
    border-radius: 8px;
}

/* Image placeholder */
.image-placeholder {
    width: 50px;
    height: 50px;
    background-color: #e0e0e0;
    border-radius: 50%;
    animation: shimmer 1.5s infinite linear;
}

/* Details placeholder */
.details-placeholder {
    flex-grow: 1;
    margin-left: 15px;
}

/* Title, subtitle, and price placeholders */
.title-placeholder,
.sub-title-placeholder,
.price-placeholder {
    height: 15px;
    background-color: #e0e0e0;
    margin-bottom: 8px;
    border-radius: 4px;
    animation: shimmer 1.5s infinite linear;
}

.title-placeholder {
    width: 60%;
}

.sub-title-placeholder {
    width: 40%;
}

.price-placeholder {
    width: 30%;
}

/* Keyframe animation for shimmer effect */
@keyframes shimmer {
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


/* untuk mengatur banner */

.banner-left {
    padding: 0;
}

.image-group {
    width: 100%;
    height: 160px;
    overflow: hidden;
}

.image-group img {
    width: 100%;
    height: 100%;
    border-radius: 15px;
    object-fit: cover;
    display: block;
}

.banner-right {
    padding: 15px 104px 35px 16px;
}

.banner-right h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 10px;
}

.banner-right p {
    color: #8a95a5;
    margin-bottom: 15px;
}

.banner-date {
    position: absolute;
    top: 2px;
    right: 5px;
    font-size: 11px;
    color: #9ca3af;
}

.banner-card {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
}

.action-buttons {
    position: absolute;
    right: 8px;
    bottom: 6px;
    z-index: 100;
    display: flex;
    gap: 8px;
}

.action-buttons .btn {
    width: 25px;
    height: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 6px;
}

.ribbon {
    z-index: 30;
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

.ribbon {
    width: 62px;
    height: 54px;
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

.ribbon span {}

/* Banner biasa */
.ribbon-biasa span {
    position: absolute;
    display: block;
    width: 246px;
    padding: 5px 0;
    background-color: #1A44B2;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: #fff;
    font: 600 11px/1 "Lato", sans-serif;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    text-align: center;
}

/* Banner promo */
.ribbon-promo span {
    position: absolute;
    display: block;
    width: 246px;
    padding: 5px 0;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: #fff;
    font: 600 11px/1 "Lato", sans-serif;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    text-align: center;
    background: #22C55E;
    /* Hijau */
}

/* top left*/
.ribbon-top-left {
    top: -6px;
    left: -6px;
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
    right: -79px;
    top: 16px;
    transform: rotate(-40deg);
}

/* mengatur preview ubah */
.alert {
    position: relative;
}


inputan diskon .percent-input {
    position: relative;
}

.percent-input input {
    padding-right: 50px;
    /* memberi ruang untuk % */
}

.percent-symbol {
    position: absolute;
    right: 25px;
    /* sebelum spinner */
    top: 44%;
    transform: translateY(-50%);
    color: rgb(253, 11, 11);
    font-weight: 620;
    pointer-events: none;
    z-index: 1;
}

#banner-preview {
    width: 33%;
    max-width: 300px;
    height: auto;
    overflow: hidden;
    margin-top: 10px;
    margin-left: 225px;
}

#banner-preview img {
    width: 100%;
    height: auto;
    display: block;
}

#change-foto {
    position: sticky;
    bottom: 209px;
    right: 365px;
    margin: 0px;
}


.modal-backdrop {
    z-index: 1040 !important;
}

.swal2-container.swal2-front {
    z-index: 1070 !important;
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

#search-banner {
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
</style>


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="demo-inline-spacing mb-3">
        <button type="button" class="btn btn-sm btn-primary rounded-2 shadow-lg" data-bs-toggle="modal"
            data-bs-target="#add-banner">Upload Banner</button>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Daftar banner</h5>
        </div>

        <!-- Search Form and Filter Group -->
        <div class="d-flex align-items-center">
            <!-- Search Form -->
            <form class="d-flex shadow-lg me-2 custom-search-form">
                <div class="input-group">
                    <span class="input-group-text custom-search-icon"><i class="tf-icons bx bx-search"></i></span>
                    <input type="text" id="search-banner" class="form-control" placeholder="Search..." />
                </div>
            </form>

            <!-- Filter Button -->
            <div class="custom-filter">
                <div class="btn-group">
                    <button type="button" id="filterButton" class="btn btn-primary dropdown-toggle custom-filter-button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-filter'></i> Filter Kategori
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($filter_type as $data) : ?>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center filter-banner"
                                data-type="<?= $data->type_banner; ?>">
                                <i class="bx bx-chevron-right scaleX-n1-rtl"></i> <?= $data->type_banner; ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-3 mt-0" id="load_data">
    </div>
    <div id="load_data_message"></div>
    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
                <li class="page-item prev">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0);">1</a>
                </li>
                <li class="page-item next">
                    <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>