<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-wrench text-primary me-1"></i> Perawatan, Asuransi &amp; Pajak Unit
            </h4>
            <p class="text-muted mb-0 small">Catat servis berkala, ganti oli, premi asuransi, dan pajak STNK/KIR armada. Total biaya otomatis terhubung ke Laba Bersih Akhir di Dashboard.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-perawatan">
                <i class="bx bx-plus me-1"></i> Catat Biaya / Perawatan
            </button>
            <a href="<?= site_url('Kelola_unit'); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-car me-1"></i> Data Armada
            </a>
        </div>
    </div>

    <!-- In-Page Due Date Reminder Banner (does not push to HP notifications) -->
    <div id="perawatan-due-alert" class="alert alert-warning border-start border-4 border-warning shadow-sm mb-3 <?= empty($upcoming_due) ? 'd-none' : ''; ?>">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h6 class="alert-heading fw-bold mb-1">
                    <i class="bx bx-calendar-exclamation me-1"></i> Pengingat Jatuh Tempo Perawatan / Pajak / Asuransi (<span id="due-count"><?= count($upcoming_due); ?></span> Item)
                </h6>
                <div class="small" id="due-badges-list">
                    <?php foreach ($upcoming_due as $du) : ?>
                    <span class="badge <?= $du->due_days_left < 0 ? 'bg-danger' : 'bg-warning text-dark'; ?> me-1 mb-1">
                        <?= htmlspecialchars($du->nama_unit); ?><?= !empty($du->plat_nomor) ? ' (' . htmlspecialchars($du->plat_nomor) . ')' : ''; ?> - <?= htmlspecialchars($du->judul_biaya); ?> (<?= $du->due_days_left < 0 ? 'Lewat ' . abs((int)$du->due_days_left) . ' hr' : ($du->due_days_left == 0 ? 'Hari Ini' : 'H-' . (int)$du->due_days_left); ?>)
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 KPI Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card shadow-sm h-100 border-top border-3 border-danger">
                <div class="card-body py-3">
                    <small class="text-muted d-block">Total Biaya Perawatan</small>
                    <h4 class="fw-bold text-danger mb-1" id="kpi-total-biaya">Rp0</h4>
                    <small class="text-muted"><span id="kpi-jumlah-item">0</span> catatan &bull; <span id="kpi-sedang-servis" class="text-warning fw-semibold">0 proses</span></small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm h-100 border-top border-3 border-primary">
                <div class="card-body py-3">
                    <small class="text-muted d-block">Servis &amp; Ganti Oli</small>
                    <h4 class="fw-bold text-primary mb-1" id="kpi-servis">Rp0</h4>
                    <small class="text-muted">Perawatan rutin &amp; perbaikan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm h-100 border-top border-3 border-info">
                <div class="card-body py-3">
                    <small class="text-muted d-block">Pembayaran Asuransi</small>
                    <h4 class="fw-bold text-info mb-1" id="kpi-asuransi">Rp0</h4>
                    <small class="text-muted">Premi &amp; klaim asuransi unit</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm h-100 border-top border-3 border-warning">
                <div class="card-body py-3">
                    <small class="text-muted d-block">Pajak STNK &amp; KIR</small>
                    <h4 class="fw-bold text-warning mb-1" id="kpi-pajak">Rp0</h4>
                    <small class="text-muted">Lainnya: <span id="kpi-lainnya">Rp0</span></small>
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
                    <label class="form-label small fw-semibold mb-1">Kategori Biaya</label>
                    <select id="filter-jenis" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        <option value="servis">Servis &amp; Ganti Oli</option>
                        <option value="asuransi">Asuransi</option>
                        <option value="pajak">Pajak STNK / KIR</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label small fw-semibold mb-1">Unit Garasi</label>
                    <select id="filter-unit" class="form-select form-select-sm">
                        <option value="">Semua Unit</option>
                        <?php foreach ($unit_garasi as $ug) : ?>
                        <option value="<?= (int) $ug->id_unit; ?>"><?= htmlspecialchars($ug->nama_unit); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <label class="form-label small fw-semibold mb-1">Status</label>
                    <select id="filter-status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Proses">Sedang Proses / Servis</option>
                        <option value="Selesai">Selesai / Lunas</option>
                    </select>
                </div>
                <div class="col-md-4 col-12">
                    <label class="form-label small fw-semibold mb-1">Cari Catatan</label>
                    <div class="d-flex align-items-stretch gap-2">
                        <input type="text" id="filter-search" class="form-control form-control-sm" placeholder="Unit, plat, bengkel, rincian...">
                        <button type="button" id="btn-reset-filter" class="btn btn-sm btn-outline-secondary text-nowrap d-inline-flex align-items-center justify-content-center flex-shrink-0 px-2" title="Reset Filter">
                            <i class="bx bx-refresh me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </div>

            <hr class="my-3">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span class="small text-muted fw-semibold"><i class="bx bx-list-ul me-1"></i> Daftar Pengeluaran Perawatan, Asuransi &amp; Pajak</span>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" id="btn-cetak-laporan" class="btn btn-sm btn-danger">
                        <i class="bx bxs-file-pdf me-1"></i> Cetak / PDF Laporan Biaya
                    </button>
                    <button type="button" id="btn-export-excel" class="btn btn-sm btn-success">
                        <i class="bx bx-spreadsheet me-1"></i> Export Excel (.xls)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Unit &amp; Plat</th>
                        <th>Kategori</th>
                        <th>Rincian &amp; Bengkel/Vendor</th>
                        <th>Kilometer</th>
                        <th>Jatuh Tempo</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="perawatan-tbody">
                    <tr><td colspan="9" class="text-center py-4 text-muted">Memuat data perawatan unit...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah / Edit Perawatan & Biaya Unit -->
<div class="modal fade" id="modal-perawatan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-perawatan-title">Catat Biaya Perawatan Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-perawatan">
                <input type="hidden" id="pw-id" name="id_perawatan" value="">
                <div class="modal-body">
                    <div class="row g-2 mb-3">
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold mb-1">Pilih Unit Garasi</label>
                            <select id="pw-id-unit" name="id_unit" class="form-select form-select-sm">
                                <option value="">-- Ketik Manual / Non-Garasi --</option>
                                <?php foreach ($unit_garasi as $ug) : ?>
                                <option value="<?= (int) $ug->id_unit; ?>" data-nama="<?= htmlspecialchars($ug->nama_unit); ?>"><?= htmlspecialchars($ug->nama_unit); ?> (<?= ucfirst($ug->status); ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Nama Unit <span class="text-danger">*</span></label>
                            <input type="text" id="pw-nama-unit" name="nama_unit" class="form-control form-control-sm" placeholder="cth: Innova Reborn" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Plat Nomor</label>
                            <input type="text" id="pw-plat" name="plat_nomor" class="form-control form-control-sm text-uppercase" placeholder="cth: H 1453 EV">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Kategori Biaya <span class="text-danger">*</span></label>
                            <select id="pw-jenis" name="jenis_biaya" class="form-select form-select-sm" required>
                                <option value="servis">Servis Berkala / Ganti Oli</option>
                                <option value="asuransi">Pembayaran Asuransi</option>
                                <option value="pajak">Pembayaran Pajak (STNK / KIR)</option>
                                <option value="lainnya">Biaya Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" id="pw-tgl" name="tanggal_transaksi" class="form-control form-control-sm" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Nominal Biaya (Rp) <span class="text-danger">*</span></label>
                            <input type="number" id="pw-nominal" name="nominal" class="form-control form-control-sm" min="0" value="0" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-7">
                            <label class="form-label small fw-semibold mb-1" id="pw-lbl-judul">Judul / Rincian Pekerjaan <span class="text-danger">*</span></label>
                            <input type="text" id="pw-judul" name="judul_biaya" class="form-control form-control-sm" placeholder="cth: Ganti Oli Mesin + Filter Oli 50.000 KM" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold mb-1" id="pw-lbl-vendor">Bengkel / Perusahaan / Instansi</label>
                            <input type="text" id="pw-vendor" name="vendor_bengkel" class="form-control form-control-sm" placeholder="cth: Bengkel Resmi / Asuransi / Samsat">
                        </div>
                    </div>

                    <div class="row g-2 mb-3" id="pw-km-row">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">KM Saat Ini</label>
                            <input type="number" id="pw-km-now" name="km_saat_ini" class="form-control form-control-sm" min="0" placeholder="cth: 45000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Target KM Servis Berikutnya</label>
                            <input type="number" id="pw-km-next" name="km_berikutnya" class="form-control form-control-sm" min="0" placeholder="cth: 50000">
                        </div>
                        <div class="col-md-4" id="pw-status-wrap">
                            <label class="form-label small fw-semibold mb-1">Status Pengerjaan</label>
                            <select id="pw-status" name="status_perawatan" class="form-select form-select-sm">
                                <option value="Selesai">Selesai (Unit Ready)</option>
                                <option value="Proses">Sedang Servis (Unit Masuk Bengkel)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1" id="pw-lbl-due">Jadwal Jatuh Tempo Berikutnya</label>
                            <input type="date" id="pw-due" name="tanggal_jatuh_tempo" class="form-control form-control-sm">
                            <small class="text-muted">Opsional, untuk pengingat di halaman ini.</small>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold mb-1">Catatan Tambahan</label>
                            <input type="text" id="pw-ket" name="keterangan" class="form-control form-control-sm" placeholder="No. polis asuransi, detail sparepart, atau catatan lainnya...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

