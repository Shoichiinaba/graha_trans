<style>
/* lazzy_loader */
/* Placeholder styling */
.post_data {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f4f4f4;
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

.avatar {
    display: flex;
    margin-left: -15px;
    margin-right: -57px;
    align-items: center;
    width: 100px;
    height: 100px;
}

.avatar img {
    max-width: 30%;
    max-height: 30%;
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

/* css tombol copy */
.btn-copy {
    color: #6c757d;
    font-size: 1.25rem;
    cursor: pointer;
    transition: color 0.3s;
}

.btn-copy:hover {
    color: #1A44B2;
}

/* css key data */
.key-data {
    height: 59px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row pb-3">
        <div class="demo-inline-spacing mb-3">
            <button type="button" class="btn btn-sm btn-primary rounded-2" data-bs-toggle="modal"
                data-bs-target="#create-key">Buat Key</button>
        </div>
        <div class="col-md-12 col-lg-12 order-2 mt-0">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">API Key</h5>
                </div>
                <div class="card-body shadow-lg">
                    <ul class="p-0 m-0" id="load_data">
                    </ul>
                    <div id="load_data_message"></div>
                </div>
            </div>
        </div>
        <!-- Pagination -->
    </div>
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