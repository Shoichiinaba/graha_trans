<style>
/* Placeholder for title (name) */
.title-placeholder {
    width: 150px;
    height: 20px;
    margin-bottom: 10px;
}

/* Placeholder for subtitle (position) */
.sub-title-placeholder {
    width: 100px;
    height: 15px;
    margin-bottom: 10px;
}

/* Placeholder for other details (location, contact) */
.details-placeholder {
    width: 120px;
    height: 15px;
    margin-bottom: 10px;
}

/* Placeholder for image (profile picture) */
.image-placeholder {
    width: 105px;
    height: 105px;
    border-radius: 50%;
}

/* Placeholder animation */
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
    position: relative;
    border-radius: 5px;
}

/* Placeholder Container */
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

.card-body-custom {
    margin-top: -10px;
}

.badge-small {
    font-size: 9px;
    padding: 5px 4px;
    height: auto;
}

.list {
    font-size: 12px;
}

img {
    filter: drop-shadow(2px 0px 56px);
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


/* hover foto keluar tombol */
.card {
    position: relative;
}

.card .hover-buttons {
    display: none;
    position: absolute;
    top: 10px;
    /* Sesuaikan dengan posisi yang diinginkan */
    right: 10px;
    /* Sesuaikan dengan posisi yang diinginkan */
    z-index: 2;
}

.card:hover .hover-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
}

.card .hover-buttons button {
    width: 25px;
    height: 25px;
    font-size: 10px;
    padding: 0px;
}

.action-buttons .btn {
    margin-right: 10px;
}

.action-buttons .btn:last-child {
    margin-right: 0;
}

.alert {
    position: relative;
}

#profil-preview {
    margin-bottom: -15px;
}

#change-foto {
    position: absolute;
    bottom: 140px;
    right: 9px;
    margin: 0px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="demo-inline-spacing mb-3">
        <button type="button" class="btn btn-sm btn-primary rounded-2" data-bs-toggle="modal"
            data-bs-target="#add-agent">Tambah User</button>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0">Daftar User</h5>
        </div>
        <form class="d-flex" style="width: 200px;">
            <div class="input-group">
                <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                <input type="text" id="search-agent" class="form-control" placeholder="Search..." />
            </div>
        </form>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5" id="load_data">
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