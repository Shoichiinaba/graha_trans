<!-- Modal Tambah / Edit Transaksi Sewa (Support Multi-Unit per Penyewa) -->
<div class="modal fade" id="modal-sewa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-sewa-title">Tambah Transaksi Sewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-sewa">
                <input type="hidden" id="sewa-id-booking" name="id_booking" value="">
                <input type="hidden" id="sewa-id" name="id_sewa" value="">
                <div class="modal-body">
                    <!-- Data Penyewa & Pembayaran -->
                    <div class="p-3 bg-light rounded border mb-3">
                        <h6 class="fw-bold text-primary mb-2"><i class="bx bx-user me-1"></i> Data Penyewa &amp; Pembayaran</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold mb-1">Nama User / Penyewa <span class="text-danger">*</span></label>
                                <input type="text" id="sewa-nama-user" name="nama_user" class="form-control form-control-sm" placeholder="cth: Samudra" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold mb-1">No. HP / WhatsApp</label>
                                <input type="text" id="sewa-no-hp" name="no_hp_user" class="form-control form-control-sm" placeholder="0812...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold mb-1">Alamat Penyewa</label>
                                <input type="text" id="sewa-alamat" name="alamat_user" class="form-control form-control-sm" placeholder="Alamat singkat...">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold mb-1">Status Pembayaran</label>
                                <select id="sewa-status-bayar" name="status_pembayaran" class="form-select form-select-sm">
                                    <option value="Belum Lunas">Belum Lunas</option>
                                    <option value="DP">DP (Uang Muka)</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>
                            <div class="col-md-3" id="wrap-jumlah-dp">
                                <label class="form-label small fw-semibold mb-1">Nominal DP / Dibayar (Rp)</label>
                                <input type="number" id="sewa-dp" name="jumlah_dp" class="form-control form-control-sm" min="0" value="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold mb-1">Catatan Transaksi</label>
                                <input type="text" id="sewa-catatan" name="catatan" class="form-control form-control-sm" placeholder="Catatan tambahan (opsional)">
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Unit yang Disewa -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold text-primary mb-0">
                            <i class="bx bx-car me-1"></i> Daftar Unit Disewa (<span id="unit-count-label">1</span> Unit)
                        </h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-unit-row">
                            <i class="bx bx-plus me-1"></i> Tambah Unit Lain
                        </button>
                    </div>

                    <div id="unit-items-container"></div>

                    <!-- Live Preview Keuangan Semua Unit -->
                    <div class="alert alert-primary py-2 mb-0 d-flex flex-wrap justify-content-between align-items-center small mt-2">
                        <span>Total Unit: <strong id="prev-unit-count">1 Unit</strong></span>
                        <span>Total Masuk: <strong id="prev-total-masuk">Rp400.000</strong></span>
                        <span>Total Rent to Rent: <strong id="prev-rtr">Rp0</strong></span>
                        <span>Unit Garasi: <strong id="prev-garasi">Rp400.000</strong></span>
                        <span>Unit Luar (Margin): <strong id="prev-luar">Rp0</strong></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan-sewa">
                        <i class="bx bx-save me-1"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template Option Garasi & Datalist Vendor (untuk dipakai berulang) -->
<datalist id="vendor-suggestions">
    <?php foreach ($vendor_list as $v) : ?>
    <option value="<?= htmlspecialchars($v->nama_unit_asal); ?>"></option>
    <?php endforeach; ?>
</datalist>

<!-- Modal Perpanjang Sewa -->
<div class="modal fade" id="modal-perpanjang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning bg-opacity-10">
                <h5 class="modal-title text-dark"><i class="bx bx-time-five text-warning me-1"></i> Perpanjang Masa Sewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-perpanjang">
                <input type="hidden" id="ext-id-sewa" name="id_sewa">
                <input type="hidden" id="ext-tgl-lama-raw">
                <input type="hidden" id="ext-total-lama-raw">
                <input type="hidden" id="ext-hari-lama-raw">
                <input type="hidden" id="ext-asal-raw">
                <div class="modal-body">
                    <div class="p-2 bg-light rounded border mb-3 small">
                        <div><strong>Penyewa:</strong> <span id="ext-nama-user">-</span></div>
                        <div><strong>Unit:</strong> <span id="ext-unit-info">-</span></div>
                        <div><strong>Jadwal Selesai Sebelumnya:</strong> <span id="ext-tgl-lama" class="text-danger fw-bold">-</span> (<span id="ext-hari-lama">0</span> Hari | <span id="ext-total-lama">Rp0</span>)</div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tanggal Selesai Baru <span class="text-danger">*</span></label>
                            <input type="date" id="ext-tgl-baru" name="tanggal_selesai_baru" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tarif User / Hari (Rp)</label>
                            <input type="number" id="ext-harga-user" name="harga_user_harian" class="form-control form-control-sm" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3 d-none" id="ext-wrap-rtr">
                        <label class="form-label small fw-semibold">Tarif Rent to Rent / Hari (Rp)</label>
                        <input type="number" id="ext-rtr-harian" name="rent_to_rent_harian" class="form-control form-control-sm" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Keterangan Perpanjangan</label>
                        <input type="text" id="ext-keterangan" name="keterangan" class="form-control form-control-sm" placeholder="cth: Penyewa konfirmasi perpanjang via WA">
                    </div>

                    <div class="alert alert-warning py-2 small mb-2">
                        <div>Tambahan Hari: <strong id="ext-prev-tambah-hari">0 Hari</strong></div>
                        <div>Tambahan Tagihan: <strong id="ext-prev-tambah-biaya">Rp0</strong></div>
                        <div>Total Tagihan Baru (Status tetap Open): <strong id="ext-prev-total-baru" class="text-primary">Rp0</strong></div>
                    </div>

                    <div id="ext-history-box" class="small text-muted d-none">
                        <strong>Riwayat Perpanjangan Sebelumnya:</strong>
                        <ul id="ext-history-list" class="mb-0 ps-3"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bx bx-check-circle me-1"></i> Simpan Perpanjangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Selesai (Pengembalian Unit) -->
<div class="modal fade" id="modal-selesai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success bg-opacity-10">
                <h5 class="modal-title text-dark"><i class="bx bx-check-double text-success me-1"></i> Selesaikan Sewa (Unit Dikembalikan)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-selesai">
                <input type="hidden" id="fin-id-sewa" name="id_sewa">
                <input type="hidden" id="fin-tgl-selesai-raw">
                <input type="hidden" id="fin-harga-raw">
                <div class="modal-body">
                    <div class="p-2 bg-light rounded border mb-3 small">
                        <div><strong>Penyewa:</strong> <span id="fin-nama-user">-</span></div>
                        <div><strong>Unit:</strong> <span id="fin-unit-info">-</span></div>
                        <div><strong>Jadwal Selesai:</strong> <span id="fin-tgl-selesai">-</span> | <strong>Tagihan Saat Ini:</strong> <span id="fin-total-saat-ini" class="fw-bold">Rp0</span></div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-7">
                            <label class="form-label small fw-semibold">Tanggal Pengembalian Unit <span class="text-danger">*</span></label>
                            <input type="date" id="fin-tgl-kembali" name="tanggal_kembali" class="form-control form-control-sm" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-5">
                            <label class="form-label small fw-semibold">Jam Pengembalian <span class="text-danger">*</span></label>
                            <input type="time" id="fin-jam-kembali" name="jam_kembali" class="form-control form-control-sm" value="<?= date('H:i'); ?>" required>
                        </div>
                    </div>

                    <div id="fin-grace-box" class="alert alert-warning py-2 small d-none">
                        <div class="fw-bold mb-1"><i class="bx bx-time me-1"></i> Dalam Masa Toleransi (s/d 06:00 WIB)</div>
                        <div id="fin-grace-detail"></div>
                    </div>

                    <div id="fin-overdue-box" class="alert alert-danger py-2 small d-none">
                        <div class="fw-bold mb-1"><i class="bx bx-error me-1"></i> Melewati Batas Toleransi 06:00 WIB!</div>
                        <div id="fin-overdue-detail" class="mb-2"></div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="fin-hitung-overdue" name="hitung_overdue" value="1" checked>
                            <label class="form-check-label fw-semibold" for="fin-hitung-overdue">
                                Akumulasi tambahan tagihan harian (lewat jam 06:00 WIB)
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bx bx-info-circle me-1"></i> Setelah seluruh unit pada invoice ini kembali (<b>Selesai</b>), status pembayaran otomatis berubah menjadi <b>Lunas</b>.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-check me-1"></i> Konfirmasi Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="modal-bayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-bayar">
                <input type="hidden" id="pay-id-sewa" name="id_sewa">
                <div class="modal-body">
                    <div class="mb-2 small">Total Tagihan Invoice: <strong id="pay-total-tagihan">Rp0</strong></div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Status Pembayaran</label>
                        <select id="pay-status" name="status_pembayaran" class="form-select form-select-sm">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="DP">DP (Uang Muka)</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="mb-2" id="pay-dp-wrap">
                        <label class="form-label small fw-semibold">Nominal DP (Rp)</label>
                        <input type="number" id="pay-dp" name="jumlah_dp" class="form-control form-control-sm" min="0" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary w-100">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const BASE_URL = "<?= base_url(); ?>";
    const TODAY = "<?= date('Y-m-d'); ?>";
    const GARASI_OPTIONS = <?php
        $opts = array();
        foreach ($unit_garasi as $ug) {
            $tarif = ((int)$ug->price < 10000) ? ((int)$ug->price * 1000) : (int)$ug->price;
            $opts[] = array(
                'id_unit' => (int)$ug->id_unit,
                'nama_unit' => $ug->nama_unit,
                'status' => strtoupper($ug->status),
                'harga' => $tarif
            );
        }
        echo json_encode($opts);
    ?>;

    function escHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatRp(num) {
        const n = Math.round(parseFloat(num || 0));
        const sign = n < 0 ? '-Rp' : 'Rp';
        return sign + Math.abs(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatTgl(dateStr) {
        if (!dateStr || dateStr === '0000-00-00') return '-';
        const p = dateStr.split('-');
        if (p.length !== 3) return dateStr;
        return p[2] + '/' + p[1] + '/' + p[0];
    }

    function diffDaysInclusive(startStr, endStr) {
        if (!startStr || !endStr) return 1;
        const s = new Date(startStr + 'T00:00:00');
        const e = new Date(endStr + 'T00:00:00');
        if (e < s) return 1;
        return Math.round((e - s) / 86400000) + 1;
    }

    function getFilterQueryString() {
        return $.param({
            bulan: $('#filter-bulan').val(),
            minggu: $('#filter-minggu').val(),
            asal_unit: $('#filter-asal').val(),
            status: $('#filter-status').val(),
            search: $('#filter-search').val()
        });
    }

    function loadSewaData() {
        $.ajax({
            url: BASE_URL + 'Sewa_mobil/fetch',
            type: 'POST',
            dataType: 'json',
            data: {
                bulan: $('#filter-bulan').val(),
                minggu: $('#filter-minggu').val(),
                asal_unit: $('#filter-asal').val(),
                status: $('#filter-status').val(),
                search: $('#filter-search').val()
            },
            success: function(res) {
                if (res.status !== 'success') return;
                renderKpi(res.summary);
                renderOverdue(res.overdue);
                renderOperationalTable(res.rows);
                renderLaporanSheet(res.grouped, res.periode_label);
            }
        });
    }

    function renderKpi(s) {
        $('#kpi-total-transaksi').text(s.total_transaksi || 0);
        $('#kpi-open').text((s.total_open || 0) + ' Open');
        $('#kpi-selesai').text((s.total_selesai || 0) + ' Selesai');
        $('#kpi-total-masuk').text(formatRp(s.total_masuk));
        $('#kpi-rtr').text(formatRp(s.total_rent_to_rent));
        $('#kpi-unit-garasi').text(formatRp(s.total_unit_garasi));
        $('#kpi-unit-luar').text(formatRp(s.total_unit_luar));
        $('#kpi-nett').text(formatRp(s.total_nett));
    }

    function renderOverdue(list) {
        if (typeof window.gtRenderOverdueBell === 'function') {
            window.gtRenderOverdueBell(list || []);
        }
        const container = $('#overdue-alert-container');
        const tbody = $('#overdue-tbody');
        if (!list || list.length === 0) {
            container.addClass('d-none');
            tbody.empty();
            return;
        }
        container.removeClass('d-none');
        $('#overdue-count').text(list.length);

        let html = '';
        list.forEach(function(r) {
            const asalBadge = r.asal_unit === 'garasi'
                ? '<span class="badge bg-label-warning">Garasi</span>'
                : '<span class="badge bg-label-info">' + escHtml(r.nama_unit_asal) + '</span>';
            const terlambatBadge = r.in_grace_period
                ? '<span class="badge bg-warning text-dark">Toleransi s/d 06:00</span>'
                : '<span class="badge bg-danger">+' + r.hari_terlambat + ' Hari (Lewat 06:00)</span>';
            html += `
                <tr>
                    <td>
                        <div class="fw-bold">${escHtml(r.nama_user)}</div>
                        <small class="text-muted">${escHtml(r.no_invoice)}</small>
                    </td>
                    <td>
                        <div class="fw-semibold">${escHtml(r.tipe_unit)}</div>
                        <span class="badge bg-dark">${escHtml(r.plat_nomor)}</span>
                    </td>
                    <td>${asalBadge}</td>
                    <td class="text-danger fw-bold">${formatTgl(r.tanggal_selesai)}</td>
                    <td>${terlambatBadge}</td>
                    <td>${formatRp(r.total_masuk)}</td>
                    <td>
                        <div class="fw-bold text-danger">${formatRp(r.tagihan_berjalan)}</div>
                        <small class="text-muted">(+${formatRp(r.estimasi_tambahan)})</small>
                    </td>
                    <td class="text-center text-nowrap">
                        <button type="button" class="btn btn-xs btn-warning btn-perpanjang me-1" data-id="${r.id_sewa}">
                            <i class="bx bx-time-five"></i> Perpanjang
                        </button>
                        <button type="button" class="btn btn-xs btn-success btn-selesai" data-id="${r.id_sewa}">
                            <i class="bx bx-check"></i> Selesai
                        </button>
                    </td>
                </tr>
            `;
        });
        tbody.html(html);
    }

    function renderOperationalTable(rows) {
        const tbody = $('#sewa-tbody');
        if (!rows || rows.length === 0) {
            tbody.html('<tr><td colspan="9" class="text-center py-4 text-muted">Belum ada transaksi sewa pada filter ini.</td></tr>');
            return;
        }

        let html = '';
        rows.forEach(function(r) {
            const trClass = r.is_overdue ? 'row-overdue' : '';
            const asalBadge = r.asal_unit === 'garasi'
                ? '<span class="badge bg-label-warning">Garasi</span>'
                : '<span class="badge bg-label-info">Luar: ' + escHtml(r.nama_unit_asal) + '</span>';

            const profitLabel = r.asal_unit === 'garasi'
                ? '<span class="text-warning fw-bold">' + formatRp(r.unit_garasi) + '</span><br><small class="text-muted">Garasi</small>'
                : '<span class="text-success fw-bold">' + formatRp(r.unit_luar) + '</span><br><small class="text-muted">Setor: ' + formatRp(r.rent_to_rent) + '</small>';

            let statusHtml = '';
            if (r.status === 'Open') {
                statusHtml = '<span class="badge bg-danger">Open</span>';
                if (r.is_overdue) {
                    if (r.in_grace_period) {
                        statusHtml += '<div class="mt-1"><span class="badge bg-label-warning"><i class="bx bx-time"></i> Toleransi s/d 06:00</span></div>';
                    } else {
                        statusHtml += '<div class="mt-1"><span class="badge bg-label-danger"><i class="bx bx-error-circle"></i> Akumulasi +' + r.hari_terlambat + ' hr</span></div>';
                    }
                }
            } else {
                statusHtml = '<span class="badge bg-success">Selesai</span>';
                if (r.tanggal_kembali) {
                    const jamStr = r.jam_kembali ? (' ' + escHtml(String(r.jam_kembali).substring(0, 5))) : '';
                    statusHtml += '<br><small class="text-muted">Kembali: ' + formatTgl(r.tanggal_kembali) + jamStr + '</small>';
                }
            }

            let payBadge = 'bg-label-danger';
            if (r.status_pembayaran === 'Lunas') payBadge = 'bg-label-success';
            else if (r.status_pembayaran === 'DP') payBadge = 'bg-label-warning';

            const jmlUnit = parseInt(r.jumlah_unit_booking || 1);
            const multiBadge = jmlUnit > 1
                ? ' <span class="badge bg-label-primary">' + jmlUnit + ' Unit</span>'
                : '';

            const kontrakBtn = parseInt(r.jumlah_kontrak || 0) > 0
                ? '<a href="' + BASE_URL + 'Kontrak/cetak_pdf/' + r.id_kontrak + '" target="_blank" class="btn btn-xs btn-outline-info" title="Cetak Kontrak PDF"><i class="bx bx-file"></i></a>'
                : '<a href="' + BASE_URL + 'Kontrak?id_sewa=' + r.id_sewa + '" class="btn btn-xs btn-outline-secondary" title="Buat Kontrak"><i class="bx bx-file-blank"></i></a>';

            const openActions = r.status === 'Open' ? `
                <button type="button" class="btn btn-xs btn-warning btn-perpanjang" data-id="${r.id_sewa}" title="Perpanjang Sewa"><i class="bx bx-time-five"></i></button>
                <button type="button" class="btn btn-xs btn-success btn-selesai" data-id="${r.id_sewa}" title="Unit Kembali / Selesai"><i class="bx bx-check"></i></button>
            ` : '';

            html += `
                <tr class="${trClass}">
                    <td>
                        <div class="fw-bold small">${escHtml(r.no_invoice)}${multiBadge}</div>
                        <button type="button" class="btn btn-xs ${payBadge} btn-bayar mt-1" data-id="${r.id_sewa}">${escHtml(r.status_pembayaran)}</button>
                    </td>
                    <td class="small text-nowrap">
                        <div>${formatTgl(r.tanggal_mulai)} &rarr; ${formatTgl(r.tanggal_selesai)}</div>
                        <span class="badge bg-label-primary">${r.hari} Hari</span>
                    </td>
                    <td>
                        <div class="fw-semibold">${escHtml(r.nama_user)}</div>
                        <small class="text-muted">${escHtml(r.no_hp_user || '-')}</small>
                    </td>
                    <td>
                        <div class="fw-semibold">${escHtml(r.tipe_unit)}</div>
                        <span class="badge bg-label-dark">${escHtml(r.plat_nomor)}</span>
                    </td>
                    <td>${asalBadge}</td>
                    <td class="text-end">
                        <div class="fw-bold">${formatRp(r.total_masuk)}</div>
                        <small class="text-muted">${formatRp(r.harga_user)}/hr</small>
                        ${r.is_overdue ? '<div class="small text-danger fw-bold">Berjalan: ' + formatRp(r.tagihan_berjalan) + '</div>' : ''}
                    </td>
                    <td class="text-end">${profitLabel}</td>
                    <td>${statusHtml}</td>
                    <td class="text-center text-nowrap">
                        <div class="d-inline-flex gap-1">
                            ${openActions}
                            <a href="${BASE_URL}Sewa_mobil/cetak_invoice/${r.id_sewa}" target="_blank" class="btn btn-xs btn-outline-danger" title="Cetak Invoice PDF"><i class="bx bxs-file-pdf"></i></a>
                            ${kontrakBtn}
                            <button type="button" class="btn btn-xs btn-outline-primary btn-edit" data-id="${r.id_sewa}" title="Edit / Tambah Unit"><i class="bx bx-edit"></i></button>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-hapus" data-id="${r.id_sewa}" title="Hapus Unit Ini"><i class="bx bx-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });
        tbody.html(html);
    }

    function renderLaporanSheet(grouped, periodeLabel) {
        $('#sheet-periode-label').text(periodeLabel || 'Semua Periode');
        const container = $('#laporan-sheet-container');

        if (!grouped || grouped.length === 0) {
            container.html('<div class="alert alert-info mb-0">Tidak ada data transaksi pada periode yang dipilih.</div>');
            return;
        }

        let html = '';
        let grandMasuk = 0;
        let grandGarasi = 0;
        let grandLuar = 0;

        grouped.forEach(function(grp) {
            const labaHarian = parseFloat(grp.total_unit_garasi || 0) + parseFloat(grp.total_unit_luar || 0);
            grandMasuk += parseFloat(grp.total_masuk || 0);
            grandGarasi += parseFloat(grp.total_unit_garasi || 0);
            grandLuar += parseFloat(grp.total_unit_luar || 0);

            html += `
                <table class="table table-bordered table-laporan-sheet mb-4">
                    <thead>
                        <tr>
                            <th colspan="14" class="sheet-day-header">${escHtml(grp.tanggal_label)}</th>
                        </tr>
                        <tr class="sheet-col-header">
                            <th>No</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Hari</th>
                            <th>Nama User</th>
                            <th>Tipe Unit</th>
                            <th>Plat Nomor</th>
                            <th>Harga User</th>
                            <th>Total Masuk</th>
                            <th>Unit</th>
                            <th>Rent to Rent</th>
                            <th>Status</th>
                            <th>Unit Garasi</th>
                            <th>Unit Luar</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            grp.items.forEach(function(item, idx) {
                const statusCell = item.status === 'Open'
                    ? '<span class="status-open-text">Open</span>'
                    : '<span class="text-success fw-semibold">Selesai</span>';

                html += `
                    <tr>
                        <td class="text-center bg-light">${idx + 1}</td>
                        <td class="col-tgl">${formatTgl(item.tanggal_mulai)}</td>
                        <td class="col-tgl">${formatTgl(item.tanggal_selesai)}</td>
                        <td class="col-user text-center">${item.hari}</td>
                        <td class="col-user">${escHtml(item.nama_user)}</td>
                        <td class="col-unit-info">${escHtml(item.tipe_unit)}</td>
                        <td class="col-unit-info text-center">${escHtml(item.plat_nomor)}</td>
                        <td class="col-harga">${formatRp(item.harga_user)}</td>
                        <td class="col-harga fw-semibold">${formatRp(item.total_masuk)}</td>
                        <td class="col-asal text-center">${escHtml(item.nama_unit_asal)}</td>
                        <td class="col-asal text-end">${formatRp(item.rent_to_rent)}</td>
                        <td class="text-center bg-white">${statusCell}</td>
                        <td class="col-garasi-luar">${formatRp(item.unit_garasi)}</td>
                        <td class="col-garasi-luar">${formatRp(item.unit_luar)}</td>
                    </tr>
                `;
            });

            const labaHarianRow = parseFloat(grp.total_unit_garasi || 0) + parseFloat(grp.total_unit_luar || 0);
            html += `
                        <tr>
                            <td colspan="12" class="sheet-total-label">TOTAL</td>
                            <td class="sheet-total-garasi">${formatRp(grp.total_unit_garasi)}</td>
                            <td class="sheet-total-luar">${formatRp(grp.total_unit_luar)}</td>
                        </tr>
                        <tr>
                            <td colspan="12" class="text-end fw-bold text-white" style="background-color:#274e13 !important;">TOTAL LABA HARIAN (Unit Garasi + Unit Luar)</td>
                            <td colspan="2" class="text-center fw-bold" style="background-color:#b6d7a8 !important;">${formatRp(labaHarianRow)}</td>
                        </tr>
                    </tbody>
                </table>
            `;
        });

        const grandLaba = grandGarasi + grandLuar;
        html += `
            <table class="table table-bordered table-laporan-sheet mb-0">
                <tbody>
                    <tr style="background-color:#eaf0f8;">
                        <td class="text-end fw-bold">REKAPITULASI (${escHtml(periodeLabel || 'Semua Periode')})</td>
                        <td class="text-end fw-bold">Total Masuk: ${formatRp(grandMasuk)}</td>
                        <td class="text-end fw-bold" style="background-color:#ffd966 !important;">Unit Garasi: ${formatRp(grandGarasi)}</td>
                        <td class="text-end fw-bold" style="background-color:#f6b26b !important;">Unit Luar: ${formatRp(grandLuar)}</td>
                        <td class="text-end fw-bold text-white" style="background-color:#38761d !important;">TOTAL LABA: ${formatRp(grandLaba)}</td>
                    </tr>
                </tbody>
            </table>
        `;

        container.html(html);
    }

    // ===== Multi-Unit Builder in Modal Sewa =====
    function buildGarasiSelectOptions(selectedId) {
        let opts = '<option value="">-- Pilih Unit Garasi atau Isi Manual --</option>';
        GARASI_OPTIONS.forEach(function(ug) {
            const sel = (String(ug.id_unit) === String(selectedId || '')) ? 'selected' : '';
            opts += `<option value="${ug.id_unit}" data-nama="${escHtml(ug.nama_unit)}" data-harga="${ug.harga}" ${sel}>${escHtml(ug.nama_unit)} (${ug.status} - Ref: ${formatRp(ug.harga)}/hr)</option>`;
        });
        return opts;
    }

    function addUnitCard(data) {
        const d = data || {};
        const asal = (d.asal_unit === 'luar') ? 'luar' : 'garasi';
        const tglMulai = d.tanggal_mulai || TODAY;
        const tglSelesai = d.tanggal_selesai || TODAY;
        const hargaUser = (d.harga_user !== undefined && d.harga_user !== null) ? parseFloat(d.harga_user) : 400000;
        const rtrHarian = (d.rent_to_rent_harian !== undefined && d.rent_to_rent_harian !== null) ? parseFloat(d.rent_to_rent_harian) : 0;
        const rtrTotal = (d.rent_to_rent !== undefined && d.rent_to_rent !== null) ? parseFloat(d.rent_to_rent) : 0;
        const status = d.status || 'Open';

        const cardHtml = `
            <div class="card border mb-3 unit-item-card shadow-none">
                <div class="card-header py-2 px-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark unit-card-title">Unit #1</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-label-primary unit-subtotal-badge">Rp0</span>
                        <button type="button" class="btn btn-xs btn-outline-danger btn-remove-unit" title="Hapus unit ini">
                            <i class="bx bx-trash"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <input type="hidden" class="u-id-sewa" value="${d.id_sewa || ''}">
                    <div class="row g-2 mb-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Asal Unit <span class="text-danger">*</span></label>
                            <select class="form-select form-select-sm u-asal">
                                <option value="garasi" ${asal === 'garasi' ? 'selected' : ''}>Garasi (Milik Sendiri)</option>
                                <option value="luar" ${asal === 'luar' ? 'selected' : ''}>Unit Luar (Rental Lain)</option>
                            </select>
                        </div>
                        <div class="col-md-9 u-wrap-garasi ${asal === 'luar' ? 'd-none' : ''}">
                            <label class="form-label small mb-1">Pilih Armada Garasi (Opsional untuk isi otomatis)</label>
                            <select class="form-select form-select-sm u-id-unit">
                                ${buildGarasiSelectOptions(d.id_unit)}
                            </select>
                        </div>
                        <div class="col-md-9 u-wrap-luar ${asal === 'luar' ? '' : 'd-none'}">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small mb-1">Nama Rental / Vendor <span class="text-danger">*</span></label>
                                    <input type="text" list="vendor-suggestions" class="form-control form-control-sm u-vendor" value="${asal === 'luar' ? escHtml(d.nama_unit_asal || '') : ''}" placeholder="cth: Pak Teguh">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small mb-1">Setor Vendor / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm u-rtr-harian" min="0" value="${rtrHarian}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small mb-1">Total Rent to Rent (Rp)</label>
                                    <input type="number" class="form-control form-control-sm u-rtr-total" min="0" value="${rtrTotal}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm u-tgl-mulai" value="${tglMulai}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm u-tgl-selesai" value="${tglSelesai}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Durasi</label>
                            <input type="text" class="form-control form-control-sm bg-light fw-bold u-hari-preview" value="1 Hari" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Status Unit</label>
                            <select class="form-select form-select-sm u-status">
                                <option value="Open" ${status === 'Open' ? 'selected' : ''}>Open (Sedang Disewa)</option>
                                <option value="Selesai" ${status === 'Selesai' ? 'selected' : ''}>Selesai (Sudah Kembali)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Tipe Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm u-tipe-unit" value="${escHtml(d.tipe_unit || '')}" placeholder="cth: Reborn, Veloz" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Plat Nomor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm text-uppercase u-plat" value="${escHtml(d.plat_nomor || '')}" placeholder="cth: H 1463 EV" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Warna</label>
                            <input type="text" class="form-control form-control-sm u-warna" value="${escHtml(d.warna || '')}" placeholder="Hitam">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Harga User / Hari (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm u-harga-user" min="0" value="${hargaUser}" required>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#unit-items-container').append(cardHtml);
        reindexUnitCards();
        recalcAllUnits(false);
    }

    function reindexUnitCards() {
        const cards = $('#unit-items-container .unit-item-card');
        const totalCards = cards.length;
        $('#unit-count-label').text(totalCards);
        $('#prev-unit-count').text(totalCards + ' Unit');

        cards.each(function(idx) {
            const card = $(this);
            card.find('.unit-card-title').text('Unit #' + (idx + 1));
            card.find('.btn-remove-unit').toggleClass('d-none', totalCards <= 1);

            card.find('.u-id-sewa').attr('name', `units[${idx}][id_sewa]`);
            card.find('.u-asal').attr('name', `units[${idx}][asal_unit]`);
            card.find('.u-id-unit').attr('name', `units[${idx}][id_unit]`);
            card.find('.u-vendor').attr('name', `units[${idx}][nama_unit_asal]`);
            card.find('.u-rtr-harian').attr('name', `units[${idx}][rent_to_rent_harian]`);
            card.find('.u-rtr-total').attr('name', `units[${idx}][rent_to_rent]`);
            card.find('.u-tgl-mulai').attr('name', `units[${idx}][tanggal_mulai]`);
            card.find('.u-tgl-selesai').attr('name', `units[${idx}][tanggal_selesai]`);
            card.find('.u-status').attr('name', `units[${idx}][status]`);
            card.find('.u-tipe-unit').attr('name', `units[${idx}][tipe_unit]`);
            card.find('.u-plat').attr('name', `units[${idx}][plat_nomor]`);
            card.find('.u-warna').attr('name', `units[${idx}][warna]`);
            card.find('.u-harga-user').attr('name', `units[${idx}][harga_user]`);
        });
    }

    function recalcCard(card, recalcRtrFromHarian) {
        const tglMulai = card.find('.u-tgl-mulai').val();
        const tglSelesai = card.find('.u-tgl-selesai').val();
        const hari = diffDaysInclusive(tglMulai, tglSelesai);
        card.find('.u-hari-preview').val(hari + ' Hari');

        const hargaUser = parseFloat(card.find('.u-harga-user').val() || 0);
        const totalMasuk = hari * hargaUser;
        const asal = card.find('.u-asal').val();

        let rtrTotal = 0;
        let garasi = 0;
        let luar = 0;

        if (asal === 'garasi') {
            garasi = totalMasuk;
            card.find('.u-rtr-harian').val(0);
            card.find('.u-rtr-total').val(0);
        } else {
            const rtrHarian = parseFloat(card.find('.u-rtr-harian').val() || 0);
            if (recalcRtrFromHarian && rtrHarian > 0) {
                rtrTotal = hari * rtrHarian;
                card.find('.u-rtr-total').val(rtrTotal);
            } else {
                rtrTotal = parseFloat(card.find('.u-rtr-total').val() || 0);
                if (rtrTotal === 0 && rtrHarian > 0) {
                    rtrTotal = hari * rtrHarian;
                    card.find('.u-rtr-total').val(rtrTotal);
                }
            }
            luar = totalMasuk - rtrTotal;
        }

        card.find('.unit-subtotal-badge').text(
            formatRp(totalMasuk) + (asal === 'luar' ? ' (Margin: ' + formatRp(luar) + ')' : ' (Garasi)')
        );

        return { totalMasuk: totalMasuk, rtrTotal: rtrTotal, garasi: garasi, luar: luar };
    }

    function recalcAllUnits(recalcRtrFromHarian) {
        let sumMasuk = 0;
        let sumRtr = 0;
        let sumGarasi = 0;
        let sumLuar = 0;

        $('#unit-items-container .unit-item-card').each(function() {
            const res = recalcCard($(this), recalcRtrFromHarian);
            sumMasuk += res.totalMasuk;
            sumRtr += res.rtrTotal;
            sumGarasi += res.garasi;
            sumLuar += res.luar;
        });

        $('#prev-total-masuk').text(formatRp(sumMasuk));
        $('#prev-rtr').text(formatRp(sumRtr));
        $('#prev-garasi').text(formatRp(sumGarasi));
        $('#prev-luar').text(formatRp(sumLuar));
    }

    $(document).on('change', '.u-asal', function() {
        const card = $(this).closest('.unit-item-card');
        const isLuar = $(this).val() === 'luar';
        card.find('.u-wrap-garasi').toggleClass('d-none', isLuar);
        card.find('.u-wrap-luar').toggleClass('d-none', !isLuar);
        card.find('.u-vendor').prop('required', isLuar);
        recalcAllUnits(true);
    });

    $(document).on('change', '.u-id-unit', function() {
        const card = $(this).closest('.unit-item-card');
        const opt = $(this).find('option:selected');
        const nama = opt.data('nama');
        const harga = opt.data('harga');
        if (nama) card.find('.u-tipe-unit').val(nama);
        if (harga) card.find('.u-harga-user').val(harga);
        recalcAllUnits(true);
    });

    $(document).on('input change', '.u-tgl-mulai, .u-tgl-selesai, .u-harga-user, .u-rtr-harian', function() {
        const card = $(this).closest('.unit-item-card');
        recalcCard(card, true);
        recalcAllUnits(false);
    });

    $(document).on('input', '.u-rtr-total', function() {
        const card = $(this).closest('.unit-item-card');
        const hari = diffDaysInclusive(card.find('.u-tgl-mulai').val(), card.find('.u-tgl-selesai').val());
        const total = parseFloat($(this).val() || 0);
        if (hari > 0) {
            card.find('.u-rtr-harian').val(Math.round(total / hari));
        }
        recalcCard(card, false);
        recalcAllUnits(false);
    });

    $('#btn-add-unit-row').on('click', function() {
        const firstCard = $('#unit-items-container .unit-item-card').first();
        const defMulai = firstCard.length ? firstCard.find('.u-tgl-mulai').val() : TODAY;
        const defSelesai = firstCard.length ? firstCard.find('.u-tgl-selesai').val() : TODAY;
        addUnitCard({ tanggal_mulai: defMulai, tanggal_selesai: defSelesai });
    });

    $(document).on('click', '.btn-remove-unit', function() {
        if ($('#unit-items-container .unit-item-card').length <= 1) return;
        $(this).closest('.unit-item-card').remove();
        reindexUnitCards();
        recalcAllUnits(false);
    });

    $('#sewa-status-bayar').on('change', function() {
        if ($(this).val() === 'DP') {
            $('#wrap-jumlah-dp').removeClass('d-none');
        } else {
            $('#wrap-jumlah-dp').addClass('d-none');
        }
    }).trigger('change');

    // Open Add Modal
    $('#btn-tambah-sewa').on('click', function() {
        $('#form-sewa')[0].reset();
        $('#sewa-id-booking').val('');
        $('#sewa-id').val('');
        $('#modal-sewa-title').text('Tambah Transaksi Sewa (1 atau Banyak Unit)');
        $('#sewa-status-bayar').val('Belum Lunas').trigger('change');
        $('#unit-items-container').empty();
        addUnitCard({});
        $('#modal-sewa').modal('show');
    });

    // Edit Booking (memuat seluruh unit milik penyewa pada invoice tersebut)
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Sewa_mobil/get_detail', { id_sewa: id }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            const b = res.booking;

            $('#sewa-id').val(d.id_sewa);
            $('#sewa-id-booking').val(b ? b.id_booking : (d.id_booking || ''));
            $('#modal-sewa-title').text('Edit / Tambah Unit Booking (' + (b ? b.no_invoice : d.no_invoice) + ')');

            $('#sewa-nama-user').val(b ? b.nama_user : d.nama_user);
            $('#sewa-no-hp').val(b ? b.no_hp_user : d.no_hp_user);
            $('#sewa-alamat').val(b ? b.alamat_user : d.alamat_user);
            $('#sewa-status-bayar').val(b ? b.status_pembayaran : d.status_pembayaran).trigger('change');
            $('#sewa-dp').val(parseFloat(b ? b.jumlah_dp : d.jumlah_dp));
            $('#sewa-catatan').val(b ? b.catatan : d.catatan);

            $('#unit-items-container').empty();
            const items = (b && b.items && b.items.length > 0) ? b.items : [d];
            items.forEach(function(it) {
                addUnitCard(it);
            });
            recalcAllUnits(false);
            $('#modal-sewa').modal('show');
        }, 'json');
    });

    // Save Add / Edit
    $('#form-sewa').on('submit', function(e) {
        e.preventDefault();
        const isEdit = $('#sewa-id-booking').val() !== '' || $('#sewa-id').val() !== '';
        const url = BASE_URL + (isEdit ? 'Sewa_mobil/update' : 'Sewa_mobil/simpan');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    $('#modal-sewa').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1400, showConfirmButton: false });
                    loadSewaData();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server.' });
            }
        });
    });

    // Open Perpanjang Modal
    function updatePerpanjangPreview() {
        const oldEnd = $('#ext-tgl-lama-raw').val();
        const newEnd = $('#ext-tgl-baru').val();
        const totalLama = parseFloat($('#ext-total-lama-raw').val() || 0);
        const rate = parseFloat($('#ext-harga-user').val() || 0);

        let tambahHari = 0;
        if (oldEnd && newEnd && newEnd > oldEnd) {
            tambahHari = Math.round((new Date(newEnd + 'T00:00:00') - new Date(oldEnd + 'T00:00:00')) / 86400000);
        }
        const tambahan = tambahHari * rate;
        const totalBaru = totalLama + tambahan;

        $('#ext-prev-tambah-hari').text(tambahHari + ' Hari');
        $('#ext-prev-tambah-biaya').text(formatRp(tambahan));
        $('#ext-prev-total-baru').text(formatRp(totalBaru));
    }

    $(document).on('click', '.btn-perpanjang', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Sewa_mobil/get_detail', { id_sewa: id }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            $('#ext-id-sewa').val(d.id_sewa);
            $('#ext-tgl-lama-raw').val(d.tanggal_selesai);
            $('#ext-total-lama-raw').val(d.total_masuk);
            $('#ext-hari-lama-raw').val(d.hari);
            $('#ext-asal-raw').val(d.asal_unit);

            $('#ext-nama-user').text(d.nama_user);
            $('#ext-unit-info').text(d.tipe_unit + ' (' + d.plat_nomor + ')');
            $('#ext-tgl-lama').text(formatTgl(d.tanggal_selesai));
            $('#ext-hari-lama').text(d.hari);
            $('#ext-total-lama').text(formatRp(d.total_masuk));
            $('#ext-harga-user').val(parseFloat(d.harga_user));
            $('#ext-keterangan').val('');

            if (d.asal_unit === 'luar') {
                $('#ext-wrap-rtr').removeClass('d-none');
                const rtrRate = parseFloat(d.rent_to_rent_harian) > 0 ? parseFloat(d.rent_to_rent_harian) : Math.round(parseFloat(d.rent_to_rent) / Math.max(1, parseInt(d.hari)));
                $('#ext-rtr-harian').val(rtrRate);
            } else {
                $('#ext-wrap-rtr').addClass('d-none');
                $('#ext-rtr-harian').val(0);
            }

            let defaultNew = TODAY;
            if (TODAY <= d.tanggal_selesai) {
                const dt = new Date(d.tanggal_selesai + 'T00:00:00');
                dt.setDate(dt.getDate() + 1);
                defaultNew = dt.toISOString().split('T')[0];
            }
            $('#ext-tgl-baru').val(defaultNew);

            if (res.perpanjangan && res.perpanjangan.length > 0) {
                let hHtml = '';
                res.perpanjangan.forEach(function(p) {
                    hHtml += `<li>${formatTgl(p.tanggal_selesai_lama)} &rarr; ${formatTgl(p.tanggal_selesai_baru)} (+${p.tambah_hari} hr, +${formatRp(p.tambahan_tagihan)})</li>`;
                });
                $('#ext-history-list').html(hHtml);
                $('#ext-history-box').removeClass('d-none');
            } else {
                $('#ext-history-box').addClass('d-none');
            }

            updatePerpanjangPreview();
            $('#modal-perpanjang').modal('show');
        }, 'json');
    });

    $('#ext-tgl-baru, #ext-harga-user').on('input change', updatePerpanjangPreview);

    $('#form-perpanjang').on('submit', function(e) {
        e.preventDefault();
        $.post(BASE_URL + 'Sewa_mobil/perpanjang', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                $('#modal-perpanjang').modal('hide');
                Swal.fire({ icon: 'success', title: 'Diperpanjang', text: res.message, timer: 1600, showConfirmButton: false });
                loadSewaData();
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    // Open Selesai Modal
    function updateSelesaiOverduePreview() {
        const tglSelesai = $('#fin-tgl-selesai-raw').val();
        const tglKembali = $('#fin-tgl-kembali').val();
        const jamKembali = $('#fin-jam-kembali').val() || '00:00';
        const harga = parseFloat($('#fin-harga-raw').val() || 0);

        $('#fin-grace-box').addClass('d-none');
        $('#fin-overdue-box').addClass('d-none');

        if (tglKembali && tglSelesai && tglKembali > tglSelesai) {
            const dayDiff = Math.round((new Date(tglKembali + 'T00:00:00') - new Date(tglSelesai + 'T00:00:00')) / 86400000);
            const extraDays = (jamKembali > '06:00') ? dayDiff : Math.max(0, dayDiff - 1);

            if (extraDays === 0) {
                $('#fin-grace-detail').html(`Pengembalian pukul <b>${escHtml(jamKembali)} WIB</b> masih dalam toleransi hingga pukul <b>06:00 WIB</b> (Tambahan biaya: <b>Rp0</b>).`);
                $('#fin-grace-box').removeClass('d-none');
            } else {
                const extraFee = extraDays * harga;
                $('#fin-overdue-detail').html(`Pengembalian melewati batas toleransi 06:00 WIB: akumulasi <b>+${extraDays} hari</b>. Tambahan tagihan: <b>${formatRp(extraFee)}</b>.`);
                $('#fin-overdue-box').removeClass('d-none');
            }
        }
    }

    $(document).on('click', '.btn-selesai', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Sewa_mobil/get_detail', { id_sewa: id }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            const now = new Date();
            const hh = String(now.getHours()).padStart(2, '0');
            const mm = String(now.getMinutes()).padStart(2, '0');

            $('#fin-id-sewa').val(d.id_sewa);
            $('#fin-tgl-selesai-raw').val(d.tanggal_selesai);
            $('#fin-harga-raw').val(d.harga_user);
            $('#fin-nama-user').text(d.nama_user);
            $('#fin-unit-info').text(d.tipe_unit + ' (' + d.plat_nomor + ')');
            $('#fin-tgl-selesai').text(formatTgl(d.tanggal_selesai) + ' (24:00)');
            $('#fin-total-saat-ini').text(formatRp(d.total_masuk));
            $('#fin-tgl-kembali').val(TODAY);
            $('#fin-jam-kembali').val(hh + ':' + mm);
            $('#fin-hitung-overdue').prop('checked', true);
            updateSelesaiOverduePreview();
            $('#modal-selesai').modal('show');
        }, 'json');
    });

    $('#fin-tgl-kembali, #fin-jam-kembali').on('input change', updateSelesaiOverduePreview);

    $('#form-selesai').on('submit', function(e) {
        e.preventDefault();
        $.post(BASE_URL + 'Sewa_mobil/selesai', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                $('#modal-selesai').modal('hide');
                Swal.fire({ icon: 'success', title: 'Selesai', text: res.message, timer: 1500, showConfirmButton: false });
                loadSewaData();
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    // Pembayaran Modal (berdasarkan total invoice seluruh unit)
    $(document).on('click', '.btn-bayar', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Sewa_mobil/get_detail', { id_sewa: id }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            const b = res.booking;
            const totalInv = b ? b.total_tagihan : d.total_masuk;
            $('#pay-id-sewa').val(d.id_sewa);
            $('#pay-total-tagihan').text(formatRp(totalInv));
            $('#pay-status').val(b ? b.status_pembayaran : d.status_pembayaran).trigger('change');
            $('#pay-dp').val(parseFloat(b ? b.jumlah_dp : d.jumlah_dp));
            $('#modal-bayar').modal('show');
        }, 'json');
    });

    $('#pay-status').on('change', function() {
        if ($(this).val() === 'DP') {
            $('#pay-dp-wrap').removeClass('d-none');
        } else {
            $('#pay-dp-wrap').addClass('d-none');
        }
    });

    $('#form-bayar').on('submit', function(e) {
        e.preventDefault();
        $.post(BASE_URL + 'Sewa_mobil/update_pembayaran', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                $('#modal-bayar').modal('hide');
                loadSewaData();
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    // Delete
    $(document).on('click', '.btn-hapus', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Unit Transaksi?',
            text: 'Unit ini akan dihapus dari daftar transaksi sewa.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'Sewa_mobil/hapus', { id_sewa: id }, function(res) {
                    if (res.status === 'success') {
                        loadSewaData();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                }, 'json');
            }
        });
    });

    // Filters & Exports
    $('#filter-bulan, #filter-minggu, #filter-asal, #filter-status').on('change', loadSewaData);
    let searchTimer = null;
    $('#filter-search').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(loadSewaData, 250);
    });
    $('#btn-reset-filter').on('click', function() {
        $('#filter-bulan').val('');
        $('#filter-minggu').val('');
        $('#filter-asal').val('');
        $('#filter-status').val('');
        $('#filter-search').val('');
        loadSewaData();
    });

    $('#btn-cetak-laporan').on('click', function() {
        window.open(BASE_URL + 'Sewa_mobil/cetak_laporan?' + getFilterQueryString(), '_blank');
    });
    $('#btn-export-excel').on('click', function() {
        window.location.href = BASE_URL + 'Sewa_mobil/export_excel?' + getFilterQueryString();
    });

    loadSewaData();
});
</script>
