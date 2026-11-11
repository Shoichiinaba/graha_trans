<style>
.sewa-kpi-card {
    border-radius: 12px;
    border: 1px solid #edf1f7;
    transition: transform 0.15s ease;
}
.sewa-kpi-card:hover {
    transform: translateY(-2px);
}
.overdue-banner {
    border-left: 5px solid #dc3545;
    background: #fff5f5;
}
.table-laporan-sheet th,
.table-laporan-sheet td {
    border: 1px solid #555 !important;
    padding: 5px 7px !important;
    font-size: 12px;
    vertical-align: middle;
    white-space: nowrap;
}
.sheet-title-green {
    background-color: #38761d;
    color: #ffffff;
    font-weight: 700;
    font-size: 18px;
    letter-spacing: 0.5px;
    padding: 10px 14px;
    text-align: center;
}
.sheet-subtitle {
    font-weight: 700;
    font-size: 14px;
    color: #222;
    text-align: center;
    padding: 8px 0 12px 0;
}
.sheet-day-header {
    background-color: #1f4e78 !important;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    text-align: center;
}
.sheet-col-header th {
    background-color: #4472c4 !important;
    color: #ffffff !important;
    font-weight: 600;
    text-align: center;
}
.col-tgl { background-color: #f4cccc !important; text-align: center; }
.col-user { background-color: #d9ead3 !important; }
.col-unit-info { background-color: #efefef !important; }
.col-harga { background-color: #fce5cd !important; text-align: right; }
.col-asal { background-color: #f3f3f3 !important; }
.col-garasi-luar { background-color: #fff2cc !important; text-align: right; }
.sheet-total-label {
    background-color: #cc0000 !important;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 13px;
    text-align: center;
}
.sheet-total-garasi {
    background-color: #ffd966 !important;
    color: #000 !important;
    font-weight: 700;
    text-align: right;
}
.sheet-total-luar {
    background-color: #f6b26b !important;
    color: #000 !important;
    font-weight: 700;
    text-align: right;
}
.status-open-text {
    color: #cc0000;
    font-style: italic;
    font-weight: 700;
}
.row-overdue {
    background-color: #fff5f5 !important;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-receipt text-primary me-1"></i> Manajemen Sewa Mobil &amp; Invoicing</h4>
            <p class="text-muted mb-0 small">Kelola unit Garasi &amp; Unit Luar, peringatan jatuh tempo, perpanjangan, invoice, dan laporan transaksi harian.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary" id="btn-tambah-sewa">
                <i class="bx bx-plus me-1"></i> Tambah Transaksi Sewa
            </button>
            <a href="<?= site_url('Kontrak'); ?>" class="btn btn-outline-secondary">
                <i class="bx bx-file me-1"></i> Menu Kontrak Sewa
            </a>
        </div>
    </div>

    <!-- Warning Overdue Container -->
    <div id="overdue-alert-container" class="mb-4 <?= empty($overdue_list) ? 'd-none' : ''; ?>">
        <div class="card overdue-banner shadow-sm">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-danger fw-bold mb-0">
                        <i class="bx bx-error-circle bx-tada me-1"></i>
                        PERINGATAN: Unit Melewati Masa Sewa (<span id="overdue-count"><?= count($overdue_list); ?></span> Unit)
                    </h6>
                    <small class="text-muted">Perpanjang masa sewa agar tagihan terus terhitung, atau klik Selesai jika unit sudah dikembalikan.</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered bg-white mb-0">
                        <thead class="table-danger">
                            <tr>
                                <th>Penyewa</th>
                                <th>Unit &amp; Plat</th>
                                <th>Asal Unit</th>
                                <th>Jadwal Selesai</th>
                                <th>Terlambat</th>
                                <th>Tagihan Awal</th>
                                <th>Tagihan Berjalan</th>
                                <th class="text-center">Aksi Cepat</th>
                            </tr>
                        </thead>
                        <tbody id="overdue-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card sewa-kpi-card shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Total Transaksi</small>
                            <h4 class="fw-bold mb-1" id="kpi-total-transaksi">0</h4>
                            <small class="text-muted"><span class="text-danger fw-semibold" id="kpi-open">0 Open</span> &bull; <span class="text-success" id="kpi-selesai">0 Selesai</span></small>
                        </div>
                        <span class="badge bg-label-primary p-2 rounded"><i class="bx bx-car fs-4"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card sewa-kpi-card shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Total Masuk (Omzet)</small>
                            <h4 class="fw-bold text-primary mb-1" id="kpi-total-masuk">Rp0</h4>
                            <small class="text-muted">Setor Vendor: <span id="kpi-rtr">Rp0</span></small>
                        </div>
                        <span class="badge bg-label-info p-2 rounded"><i class="bx bx-wallet fs-4"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card sewa-kpi-card shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Pendapatan Unit Garasi</small>
                            <h4 class="fw-bold text-warning mb-1" id="kpi-unit-garasi">Rp0</h4>
                            <small class="text-muted">Milik Sendiri (100%)</small>
                        </div>
                        <span class="badge bg-label-warning p-2 rounded"><i class="bx bx-home-alt fs-4"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card sewa-kpi-card shadow-sm h-100">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Margin Unit Luar</small>
                            <h4 class="fw-bold text-success mb-1" id="kpi-unit-luar">Rp0</h4>
                            <small class="text-muted">Nett Total: <span class="fw-bold text-dark" id="kpi-nett">Rp0</span></small>
                        </div>
                        <span class="badge bg-label-success p-2 rounded"><i class="bx bx-trending-up fs-4"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Export Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body pb-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-2 col-6">
                    <label class="form-label small fw-semibold mb-1">Bulan</label>
                    <input type="month" id="filter-bulan" class="form-control form-control-sm" value="">
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label small fw-semibold mb-1">Minggu</label>
                    <select id="filter-minggu" class="form-select form-select-sm">
                        <option value="">Semua Minggu</option>
                        <option value="1">Minggu Pertama (1-7)</option>
                        <option value="2">Minggu Kedua (8-14)</option>
                        <option value="3">Minggu Ketiga (15-21)</option>
                        <option value="4">Minggu Keempat (22-31)</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label small fw-semibold mb-1">Asal Unit</label>
                    <select id="filter-asal" class="form-select form-select-sm">
                        <option value="">Semua Asal</option>
                        <option value="garasi">Garasi (Sendiri)</option>
                        <option value="luar">Unit Luar (Vendor)</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label small fw-semibold mb-1">Status Sewa</label>
                    <select id="filter-status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Open">Open (Sedang Sewa)</option>
                        <option value="overdue">Warning (Lewat Batas)</option>
                        <option value="Selesai">Selesai (Kembali)</option>
                    </select>
                </div>
                <div class="col-md-4 col-12">
                    <label class="form-label small fw-semibold mb-1">Cari Transaksi</label>
                    <div class="d-flex align-items-stretch gap-2">
                        <input type="text" id="filter-search" class="form-control form-control-sm" placeholder="Nama user, plat, tipe unit, invoice...">
                        <button type="button" id="btn-reset-filter" class="btn btn-sm btn-outline-secondary text-nowrap d-inline-flex align-items-center justify-content-center flex-shrink-0 px-2" title="Reset Filter">
                            <i class="bx bx-refresh me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </div>

            <hr class="my-3">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <!-- View Switcher Tabs -->
                <ul class="nav nav-pills nav-sm" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-operasional" type="button" role="tab">
                            <i class="bx bx-list-ul me-1"></i> Daftar Operasional &amp; Aksi
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-laporan" type="button" role="tab">
                            <i class="bx bx-table me-1"></i> Tampilan Laporan Harian (Format Gambar)
                        </button>
                    </li>
                </ul>

                <!-- Export Actions -->
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" id="btn-cetak-laporan" class="btn btn-sm btn-danger">
                        <i class="bx bxs-file-pdf me-1"></i> Cetak / PDF Laporan Harian
                    </button>
                    <button type="button" id="btn-export-excel" class="btn btn-sm btn-success">
                        <i class="bx bxs-spreadsheet me-1"></i> Export Excel (.xls)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content p-0">
        <!-- Tab 1: Operational Table -->
        <div class="tab-pane fade show active" id="tab-operasional" role="tabpanel">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No / Invoice</th>
                                <th>Periode Sewa</th>
                                <th>Penyewa</th>
                                <th>Unit &amp; Plat</th>
                                <th>Asal Unit</th>
                                <th class="text-end">Tagihan</th>
                                <th class="text-end">Garasi / Margin</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sewa-tbody">
                            <tr><td colspan="9" class="text-center py-4 text-muted">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 2: Laporan Transaksi Harian Format Gambar -->
        <div class="tab-pane fade" id="tab-laporan" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="sheet-title-green rounded-top">LAPORAN TRANSAKSI HARIAN CV. GRAHA TRANSPORT</div>
                    <div class="sheet-subtitle" id="sheet-periode-label">Semua Periode</div>
                    <div id="laporan-sheet-container" class="table-responsive">
                        <div class="text-center py-4 text-muted">Memuat tampilan laporan...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

