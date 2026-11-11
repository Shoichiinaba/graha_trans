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
    opacity: 0.12;
    z-index: 0;
    pointer-events: none;
    transform: rotate(-8deg);
}

.armada-card .card-body {
    position: relative;
    z-index: 2;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <?php if ($this->session->flashdata('error_akses')) : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bx bx-lock-alt me-1"></i> <?= htmlspecialchars($this->session->flashdata('error_akses')); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (!empty($overdue_list)) : ?>
    <div class="alert alert-danger border-start border-4 border-danger shadow-sm mb-4" role="alert">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h6 class="alert-heading fw-bold mb-1">
                    <i class="bx bx-error-circle bx-tada me-1"></i>
                    Peringatan: <?= count($overdue_list); ?> Unit Melewati Masa Sewa!
                </h6>
                <div class="small">
                    <?php foreach ($overdue_list as $ov) : ?>
                    <span class="badge bg-danger me-1 mb-1">
                        <?= htmlspecialchars($ov->nama_user); ?> - <?= htmlspecialchars($ov->tipe_unit); ?> (<?= htmlspecialchars($ov->plat_nomor); ?>) | <?= !empty($ov->in_grace_period) ? 'Toleransi s/d 06:00' : 'Akumulasi +' . (int)$ov->hari_terlambat . ' hari'; ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-sm btn-danger">
                <i class="bx bx-right-arrow-alt me-1"></i> Kelola Perpanjangan / Selesai
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">

        <!-- Card Welcome -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="d-flex align-items-end row h-100">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                Selamat Datang, <?= htmlspecialchars($userdata->nama_agent); ?>!
                            </h5>

                            <p class="mb-3">
                                Role aktif: <span class="badge bg-label-primary"><?= htmlspecialchars($userdata->position); ?></span>.
                                Ringkasan operasional bulan <strong><?= nama_bulan_id(date('n')) . ' ' . date('Y'); ?></strong>:
                            </p>

                            <div class="row g-2 mb-3 small">
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded">
                                        <div class="text-muted">Pendapatan Garasi</div>
                                        <div class="fw-bold text-warning"><?= format_rupiah($sewa_summary['total_unit_garasi']); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 bg-light rounded">
                                        <div class="text-muted">Margin Unit Luar</div>
                                        <div class="fw-bold text-success"><?= format_rupiah($sewa_summary['total_unit_luar']); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-sm btn-primary">
                                    <i class="bx bx-receipt me-1"></i> Manajemen Sewa (<?= (int)$sewa_summary['total_open']; ?> Open)
                                </a>
                                <a href="<?= site_url('Kontrak'); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-file me-1"></i> Kontrak Sewa (<?= (int)$kontrak_aktif; ?> Aktif)
                                </a>
                            </div>
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
            <div class="card h-100 armada-card">
                <img src="<?= base_url('assets/img/illustrations/car-light.png'); ?>" class="armada-bg" alt="Car">

                <div class="card-body position-relative">

                    <h5 class="card-title mb-4">
                        Informasi Armada Garasi
                    </h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Unit</span>
                        <h4 class="mb-0 text-primary">
                            <?= $total_unit ?>
                        </h4>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tersedia (Ready)</span>
                        <span class="fw-bold text-success">
                            <?= $unit_ready ?>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Disewa (Rental)</span>
                        <span class="fw-bold text-warning">
                            <?= $unit_rental ?>
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Maintenance</span>
                        <span class="fw-bold text-danger">
                            <?= $unit_service ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
