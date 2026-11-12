<style>
.gt-hero-card {
    background: radial-gradient(circle at 88% 18%, rgba(45, 212, 191, 0.22), transparent 44%),
                linear-gradient(135deg, #0b1630 0%, #15316e 58%, #1A44B2 100%);
    color: #ffffff;
    border: none;
    border-radius: 18px;
    position: relative;
    overflow: hidden;
}

.gt-hero-card::after {
    content: '';
    position: absolute;
    right: -30px;
    bottom: -30px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
    pointer-events: none;
}

.gt-hero-stat {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 12px;
    padding: 10px 14px;
    backdrop-filter: blur(8px);
}

.gt-kpi-card {
    border: 1px solid #e9eef5;
    border-radius: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-top: 3px solid transparent;
}

.gt-kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08) !important;
}

.gt-kpi-primary { border-top-color: #1A44B2; }
.gt-kpi-success { border-top-color: #10b981; }
.gt-kpi-info    { border-top-color: #0ea5e9; }
.gt-kpi-warning { border-top-color: #f59e0b; }

.gt-kpi-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.gt-card-modern {
    border: 1px solid #e9eef5;
    border-radius: 16px;
}

.gt-seg-btn {
    border-radius: 10px !important;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 12px;
}

.gt-armada-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 10px;
    border-radius: 10px;
    background: #f8fafc;
    margin-bottom: 6px;
}

.gt-top-unit-item {
    padding: 10px 12px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #edf2f7;
    margin-bottom: 10px;
    transition: border-color 0.2s ease;
}

.gt-top-unit-item:hover {
    border-color: #cbd5e1;
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

    <!-- Row 1: Hero Welcome + Fleet Donut -->
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card gt-hero-card shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between position-relative" style="z-index:1;">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                        <div>
                            <span class="badge mb-2" style="background: rgba(45, 212, 191, 0.18); border: 1px solid rgba(45, 212, 191, 0.45); color: #5eead4;">
                                <i class="bx bx-shield-quarter me-1"></i><?= htmlspecialchars($userdata->position); ?>
                            </span>
                            <h4 class="text-white fw-bold mb-1">
                                Selamat Datang, <?= htmlspecialchars($userdata->nama_agent); ?>!
                            </h4>
                            <p class="small mb-0" style="color: rgba(255, 255, 255, 0.82);">
                                Ringkasan performa rental &amp; perkembangan omset periode <strong><?= htmlspecialchars($curr_month_label); ?></strong>.
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="small" style="color: rgba(255, 255, 255, 0.78);" id="gt-live-date"><?= format_hari_tanggal_id(date('Y-m-d')); ?></div>
                            <div class="fw-bold fs-5 text-white" id="gt-live-clock"><?= date('H:i'); ?> WIB</div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-4 col-6">
                            <div class="gt-hero-stat">
                                <div class="small" style="color: rgba(255, 255, 255, 0.78);">Laba Sewa (Garasi + Luar)</div>
                                <div class="fw-bold text-warning fs-6"><?= format_rupiah($sewa_summary['total_nett']); ?></div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="gt-hero-stat">
                                <div class="small" style="color: rgba(255, 255, 255, 0.78);">Biaya Perawatan Unit</div>
                                <div class="fw-bold text-danger fs-6" style="color: #fda4af !important;"><?= format_rupiah($biaya_summary['total_biaya']); ?></div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="gt-hero-stat">
                                <div class="small" style="color: rgba(255, 255, 255, 0.78);">Laba Bersih Akhir</div>
                                <div class="fw-bold fs-6" style="color: #5eead4;"><?= format_rupiah($laba_bersih_akhir); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-sm btn-light fw-semibold text-primary">
                            <i class="bx bx-receipt me-1"></i> Kelola Sewa &amp; Invoice
                        </a>
                        <a href="<?= site_url('Perawatan_unit'); ?>" class="btn btn-sm btn-outline-light">
                            <i class="bx bx-wrench me-1"></i> Perawatan &amp; Biaya
                        </a>
                        <a href="<?= site_url('Kontrak'); ?>" class="btn btn-sm btn-outline-light">
                            <i class="bx bx-file me-1"></i> Kontrak (<?= (int)$kontrak_aktif; ?> Aktif)
                        </a>
                        <a href="<?= site_url('Kelola_unit'); ?>" class="btn btn-sm btn-outline-light">
                            <i class="bx bx-car me-1"></i> Data Armada
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card gt-card-modern shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="fw-bold mb-0">Kesiapan Armada Garasi</h6>
                            <small class="text-muted">Total <?= (int)$total_unit; ?> unit terdaftar</small>
                        </div>
                        <a href="<?= site_url('Kelola_unit'); ?>" class="btn btn-xs btn-outline-primary">Detail</a>
                    </div>

                    <div id="gt-fleet-donut" style="min-height: 155px;"></div>

                    <div class="gt-armada-row">
                        <span class="small"><span class="badge bg-success rounded-pill me-1">&nbsp;</span> Tersedia (Ready)</span>
                        <span class="fw-bold text-success"><?= (int)$unit_ready; ?> Unit</span>
                    </div>
                    <div class="gt-armada-row">
                        <span class="small"><span class="badge bg-warning rounded-pill me-1">&nbsp;</span> Sedang Disewa</span>
                        <span class="fw-bold text-warning"><?= (int)$unit_rental; ?> Unit</span>
                    </div>
                    <div class="gt-armada-row mb-0">
                        <span class="small"><span class="badge bg-danger rounded-pill me-1">&nbsp;</span> Maintenance</span>
                        <span class="fw-bold text-danger"><?= (int)$unit_service; ?> Unit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: 4 KPI Cards with Month-over-Month Comparison -->
    <div class="row g-3 mb-4">
        <?php
        $omset_up = ($growth_omset >= 0);
        $laba_up  = ($growth_laba >= 0);
        $unit_diff = (int)$sewa_summary['total_transaksi'] - (int)$prev_summary['total_transaksi'];
        $unit_up  = ($unit_diff >= 0);
        ?>
        <div class="col-xl-3 col-sm-6">
            <div class="card gt-kpi-card gt-kpi-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <small class="text-muted fw-semibold d-block">Omset Bulan Ini</small>
                            <h4 class="fw-bold text-primary mb-0"><?= format_rupiah($sewa_summary['total_masuk']); ?></h4>
                        </div>
                        <span class="gt-kpi-icon bg-label-primary text-primary"><i class="bx bx-wallet"></i></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small mt-2">
                        <span class="badge <?= $omset_up ? 'bg-label-success' : 'bg-label-danger'; ?>">
                            <i class="bx <?= $omset_up ? 'bx-trending-up' : 'bx-trending-down'; ?>"></i>
                            <?= ($omset_up ? '+' : '') . $growth_omset; ?>%
                        </span>
                        <span class="text-muted">Lalu: <?= format_rupiah($prev_summary['total_masuk']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card gt-kpi-card gt-kpi-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <small class="text-muted fw-semibold d-block">Laba Bersih Akhir</small>
                            <h4 class="fw-bold <?= $laba_bersih_akhir >= 0 ? 'text-success' : 'text-danger'; ?> mb-0"><?= format_rupiah($laba_bersih_akhir); ?></h4>
                        </div>
                        <span class="gt-kpi-icon bg-label-success text-success"><i class="bx bx-line-chart"></i></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small mt-2">
                        <span class="badge <?= $laba_up ? 'bg-label-success' : 'bg-label-danger'; ?>">
                            <i class="bx <?= $laba_up ? 'bx-trending-up' : 'bx-trending-down'; ?>"></i>
                            <?= ($laba_up ? '+' : '') . $growth_laba; ?>%
                        </span>
                        <span class="text-muted">Lalu: <?= format_rupiah($prev_laba_bersih); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card gt-kpi-card gt-kpi-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <small class="text-muted fw-semibold d-block">Unit Tersewa (Bulan Ini)</small>
                            <h4 class="fw-bold text-info mb-0"><?= (int)$sewa_summary['total_transaksi']; ?> <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                        </div>
                        <span class="gt-kpi-icon bg-label-info text-info"><i class="bx bx-car"></i></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small mt-2">
                        <span class="badge <?= $unit_up ? 'bg-label-info' : 'bg-label-warning'; ?>">
                            <?= ($unit_diff >= 0 ? '+' : '') . $unit_diff; ?> unit (<?= ($growth_unit >= 0 ? '+' : '') . $growth_unit; ?>%)
                        </span>
                        <span class="text-muted">Lalu: <?= (int)$prev_summary['total_transaksi']; ?> unit</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card gt-kpi-card gt-kpi-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <small class="text-muted fw-semibold d-block">Status Sewa Aktif</small>
                            <h4 class="fw-bold text-dark mb-0"><?= (int)$sewa_summary['total_open']; ?> <span class="fs-6 fw-normal text-muted">Open</span></h4>
                        </div>
                        <span class="gt-kpi-icon bg-label-warning text-warning"><i class="bx bx-time-five"></i></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small mt-2">
                        <span class="badge <?= !empty($overdue_list) ? 'bg-danger' : 'bg-label-success'; ?>">
                            <?= !empty($overdue_list) ? count($overdue_list) . ' Lewat Batas' : 'Semua Tepat Waktu'; ?>
                        </span>
                        <span class="text-muted"><?= (int)$sewa_summary['total_selesai']; ?> Selesai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Interactive Charts (Monthly Omset + Units & Composition Donut) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card gt-card-modern shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h6 class="fw-bold mb-0"><i class="bx bx-bar-chart-alt-2 text-primary me-1"></i> Grafik Perkembangan Omset &amp; Unit Tersewa</h6>
                        <small class="text-muted" id="gt-main-chart-subtitle">Perbandingan omset, laba bersih, &amp; jumlah unit tersewa 6 bulan terakhir</small>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Mode Grafik">
                            <button type="button" class="btn btn-primary gt-seg-btn gt-chart-mode active" data-mode="6m">6 Bulan</button>
                            <button type="button" class="btn btn-outline-primary gt-seg-btn gt-chart-mode" data-mode="12m">12 Bulan</button>
                            <button type="button" class="btn btn-outline-primary gt-seg-btn gt-chart-mode" data-mode="daily">Bulan Ini vs Lalu</button>
                        </div>
                        <div class="btn-group btn-group-sm d-none" id="gt-daily-metric-wrap" role="group">
                            <button type="button" class="btn btn-info gt-seg-btn gt-daily-metric active" data-metric="omset">Omset</button>
                            <button type="button" class="btn btn-outline-info gt-seg-btn gt-daily-metric" data-metric="unit">Unit</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div id="gt-main-chart" style="min-height: 330px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card gt-card-modern shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center gap-2">
                    <div>
                        <h6 class="fw-bold mb-0"><i class="bx bx-pie-chart-alt-2 text-success me-1"></i> Sumber Pendapatan</h6>
                        <small class="text-muted">Garasi vs Unit Luar (<?= htmlspecialchars($curr_month_label); ?>)</small>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-success gt-seg-btn gt-comp-mode active" data-comp="laba">Laba</button>
                        <button type="button" class="btn btn-outline-success gt-seg-btn gt-comp-mode" data-comp="unit">Unit</button>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div id="gt-comp-donut" style="min-height: 240px;"></div>
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <div class="p-2 rounded bg-light border text-center">
                                <small class="text-muted d-block">Unit Garasi</small>
                                <strong class="text-warning d-block"><?= format_rupiah($sewa_summary['total_unit_garasi']); ?></strong>
                                <small class="text-muted"><?= (int)$comp_counts['garasi']; ?>x sewa</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded bg-light border text-center">
                                <small class="text-muted d-block">Unit Luar (Margin)</small>
                                <strong class="text-info d-block"><?= format_rupiah($sewa_summary['total_unit_luar']); ?></strong>
                                <small class="text-muted"><?= (int)$comp_counts['luar']; ?>x sewa</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Top Armada & Recent Transactions -->
    <div class="row g-3">
        <div class="col-xl-5">
            <div class="card gt-card-modern shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0"><i class="bx bx-trophy text-warning me-1"></i> Unit Paling Sering Disewa</h6>
                        <small class="text-muted">Periode: <?= htmlspecialchars($top_scope); ?></small>
                    </div>
                    <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-xs btn-outline-secondary">Lihat Semua</a>
                </div>
                <div class="card-body pt-3">
                    <?php if (empty($top_units)) : ?>
                    <div class="text-center text-muted py-4 small">Belum ada data transaksi sewa untuk ditampilkan.</div>
                    <?php else : ?>
                    <?php
                    $max_sewa = 1;
                    foreach ($top_units as $tu) {
                        if ((int)$tu->kali_sewa > $max_sewa) {
                            $max_sewa = (int)$tu->kali_sewa;
                        }
                    }
                    ?>
                    <?php foreach ($top_units as $idx => $tu) : ?>
                    <?php $pct = round(((int)$tu->kali_sewa / $max_sewa) * 100); ?>
                    <div class="gt-top-unit-item">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <span class="fw-bold text-dark"><?= ($idx + 1) . '. ' . htmlspecialchars($tu->tipe_unit); ?></span>
                                <span class="badge bg-dark ms-1"><?= htmlspecialchars($tu->plat_nomor); ?></span>
                                <?php if ($tu->asal_unit === 'garasi') : ?>
                                <span class="badge bg-label-warning ms-1">Garasi</span>
                                <?php else : ?>
                                <span class="badge bg-label-info ms-1">Luar: <?= htmlspecialchars($tu->nama_unit_asal); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary small"><?= format_rupiah($tu->total_omset); ?></span>
                            </div>
                        </div>
                        <div class="progress mb-1" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $pct; ?>%;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span><?= (int)$tu->kali_sewa; ?>x disewa &bull; <?= (int)$tu->total_hari; ?> hari total</span>
                            <span>Laba: <?= format_rupiah($tu->total_laba); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="card gt-card-modern shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0"><i class="bx bx-history text-primary me-1"></i> Aktivitas Sewa Terbaru</h6>
                        <small class="text-muted">6 unit transaksi terakhir</small>
                    </div>
                    <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-xs btn-primary">Buka Manajemen Sewa</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Penyewa &amp; Invoice</th>
                                <th>Unit &amp; Plat</th>
                                <th>Periode</th>
                                <th class="text-end">Tagihan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_list)) : ?>
                            <tr><td colspan="5" class="text-center text-muted py-4 small">Belum ada transaksi sewa.</td></tr>
                            <?php else : ?>
                            <?php foreach ($recent_list as $rc) : ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark"><?= htmlspecialchars($rc->nama_user); ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($rc->no_invoice); ?></small>
                                </td>
                                <td>
                                    <div class="small fw-semibold"><?= htmlspecialchars($rc->tipe_unit); ?></div>
                                    <span class="badge bg-label-secondary"><?= htmlspecialchars($rc->plat_nomor); ?></span>
                                </td>
                                <td class="small text-muted">
                                    <?= format_tanggal_id($rc->tanggal_mulai); ?> - <?= format_tanggal_id($rc->tanggal_selesai); ?><br>
                                    <span class="badge bg-label-primary"><?= (int)$rc->hari; ?> Hari</span>
                                </td>
                                <td class="text-end fw-bold text-dark">
                                    <?= format_rupiah($rc->tagihan_berjalan); ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($rc->status === 'Selesai') : ?>
                                    <span class="badge bg-success">Selesai</span>
                                    <?php elseif (!empty($rc->is_overdue)) : ?>
                                    <span class="badge bg-danger"><?= !empty($rc->in_grace_period) ? 'Toleransi 06:00' : '+' . (int)$rc->hari_terlambat . ' Hari'; ?></span>
                                    <?php else : ?>
                                    <span class="badge bg-warning text-dark">Open</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
