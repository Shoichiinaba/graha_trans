<style>
.armada-card {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

/* Background mobil */
.armada-bg {
    position: absolute;
    right: -20px;
    bottom: -4px;
    width: 300px;
    /* ukuran mobil */
    opacity: 0.12;
    /* transparan */
    z-index: 0;
    pointer-events: none;
    transform: rotate(-8deg);
}

/* Isi card berada di atas gambar */
.armada-card .card-body {
    position: relative;
    z-index: 2;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <!-- Card Welcome -->
        <div class="col-lg-8 mb-4">
            <div class="card h-80">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                Selamat <?= $userdata->nama_agent; ?> 🎉
                            </h5>

                            <p class="mb-4">
                                Anda telah melakukan penjualan
                                <span class="fw-bold">72%</span>
                                lebih banyak hari ini.
                                Cek badge baru Anda di profil Anda.
                            </p>

                            <a href="#" class="btn btn-sm btn-outline-primary">
                                Lihat Badge
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-5 text-center">
                        <div class="card-body p-0">
                            <img src="<?= base_url('assets'); ?>/img/illustrations/car-light.png" height="150"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Statistik -->
        <div class="col-lg-4 mb-4">
            <div class="card h-80 armada-card">
                <!-- Background Mobil -->
                <img src="<?= base_url('assets/img/illustrations/car-light.png'); ?>" class="armada-bg" alt="Car">

                <div class="card-body position-relative">

                    <h5 class="card-title mb-4">
                        🚗 Informasi Armada
                    </h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Unit</span>
                        <h4 class="mb-0 text-primary">
                            <?= $total_unit ?>
                        </h4>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>✅ Tersedia</span>
                        <span class="fw-bold text-success">
                            <?= $unit_ready ?>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>📄 Disewa</span>
                        <span class="fw-bold text-warning">
                            <?= $unit_rental ?>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>🔧 Maintenance</span>
                        <span class="fw-bold text-danger">
                            <?= $unit_service ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>