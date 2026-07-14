<style>
/* code untuk membuat loader animasi  */
.container-loader {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.post_data {
    display: flex;
    flex-direction: column;
    width: 250px;
    margin: 10px;
    padding: 10px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

.image-placeholder {
    width: 100%;
    height: 180px;
    background-color: #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}

.image-placeholder::before {
    content: '';
    display: block;
    padding-top: 56.25%;
}

.details-placeholder {
    display: flex;
    flex-direction: column;
    padding: 10px 0;
}

.title-placeholder {
    height: 20px;
    background-color: #e0e0e0;
    margin-bottom: 8px;
    border-radius: 4px;
    width: 70%;
}

.sub-title-placeholder {
    height: 15px;
    background-color: #e0e0e0;
    margin-bottom: 8px;
    border-radius: 4px;
    width: 50%;
}

.price-placeholder {
    height: 15px;
    background-color: #e0e0e0;
    margin-bottom: 8px;
    border-radius: 4px;
    width: 30%;
}

/* code edit hover */
.card-hover {
    position: relative;
    overflow: hidden;
}

.edit-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    z-index: 10;
}

.card-hover:hover .edit-overlay {
    display: flex;
}

.card-hover:hover .content-blur,
.card-hover:hover video,
.card-hover:hover .btn-view {
    filter: blur(5px);
    transition: filter 0.3s ease-in-out;
}

.btn-edit {
    background-color: #313DA0;
    border: none;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: bold;
    color: #fff;
    margin-right: 5px;
}

.btn-delete {
    background-color: #313DA0;
    border: none;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: bold;
    color: #fff;
}



/* css mengatur video */
.custom-video {
    height: 300px;
    border-radius: 28px;
    padding: 6px;
}

.position-relative {
    position: relative;
}

.badge-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
    padding: 5px 10px;
}

.pagin {
    position: relative;
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

/* code video preview */
#video-preview {
    width: 100%;
    height: auto;
    max-width: 207px;
    margin: 0 auto;
}

#video-preview video {
    width: 100%;
    height: auto;
}

#change-video {
    position: absolute;
    bottom: 356px;
    right: 312px;
    z-index: 10;
}

#video-preview:hover #change-video {
    display: block;
}

/* code footer tanggal & views */
.card-text-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.card-text.date-left {
    margin: 0;
}

.card-text.date-right {
    margin: 0;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="demo-inline-spacing mb-3">
        <button type="button" class="btn btn-sm btn-primary rounded-2" data-bs-toggle="modal"
            data-bs-target="#add-reels">Tambah Reels</button>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0">Daftar reels Video</h5>
        </div>
        <form class="d-flex" style="width: 200px;">
            <div class="input-group">
                <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
                <input type="text" id="search-reels" class="form-control" placeholder="Search..." />
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