<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-file text-primary me-1"></i> Kontrak Sewa Kendaraan</h4>
            <p class="text-muted mb-0 small">Kelola surat perjanjian sewa kendaraan, identitas penyewa, serah terima unit, dan cetak dokumen kontrak PDF.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" id="btn-tambah-kontrak">
                <i class="bx bx-plus me-1"></i> Buat Kontrak Baru
            </button>
            <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-outline-secondary">
                <i class="bx bx-receipt me-1"></i> Manajemen Sewa
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-3 col-6">
                    <label class="form-label small fw-semibold mb-1">Status Kontrak</label>
                    <select id="filter-status-kontrak" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label small fw-semibold mb-1">Cari Kontrak</label>
                    <input type="text" id="filter-search-kontrak" class="form-control form-control-sm" placeholder="No. Kontrak, Invoice, Nama Penyewa, NIK, Plat Nomor...">
                </div>
                <div class="col-md-3 col-6">
                    <button type="button" id="btn-reset-kontrak" class="btn btn-sm btn-outline-secondary w-100">
                        <i class="bx bx-refresh me-1"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Kontrak -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Kontrak &amp; Tgl</th>
                        <th>Penyewa &amp; Identitas</th>
                        <th>Unit &amp; Plat</th>
                        <th>Periode &amp; Total</th>
                        <th>Kondisi Awal &amp; Jaminan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="kontrak-tbody">
                    <tr><td colspan="7" class="text-center py-4 text-muted">Memuat data kontrak...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

