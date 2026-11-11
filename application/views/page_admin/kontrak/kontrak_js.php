<!-- Modal Tambah / Edit Kontrak -->
<div class="modal fade" id="modal-kontrak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-kontrak-title">Buat Surat Perjanjian Kontrak Sewa Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-kontrak">
                <input type="hidden" id="kontrak-id" name="id_kontrak" value="">
                <div class="modal-body">
                    <!-- Pilihan Alur Pembuatan Kontrak -->
                    <div id="wrap-mode-sumber" class="mb-3 p-2 bg-light rounded border">
                        <label class="form-label small fw-bold d-block mb-1">Alur Pembuatan Kontrak</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode_sumber" id="mode-kontrak-dulu" value="kontrak_dulu" checked>
                                <label class="form-check-label small fw-semibold" for="mode-kontrak-dulu">
                                    Buat Kontrak Dulu (Instansi / Tagihan Menyusul)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode_sumber" id="mode-existing" value="existing">
                                <label class="form-check-label small fw-semibold" for="mode-existing">
                                    Hubungkan ke Transaksi / Invoice yang Sudah Ada
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Tanggal Surat Kontrak <span class="text-danger">*</span></label>
                            <input type="date" id="kontrak-tanggal" name="tanggal_kontrak" class="form-control form-control-sm" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-8" id="wrap-existing-select">
                            <label class="form-label small fw-semibold mb-1">Pilih Transaksi Sewa / Invoice <span class="text-danger">*</span></label>
                            <select id="kontrak-id-sewa" name="id_sewa" class="form-select form-select-sm">
                                <option value="">-- Pilih Transaksi Sewa --</option>
                                <?php foreach ($sewa_options as $so) : ?>
                                <option value="<?= $so->id_sewa; ?>">
                                    <?= htmlspecialchars($so->no_invoice); ?> - <?= htmlspecialchars($so->nama_user); ?> (<?= (int)$so->jumlah_unit; ?> Unit: <?= htmlspecialchars($so->daftar_unit); ?>) [<?= $so->status; ?>]<?= ((int)$so->sudah_kontrak > 0) ? ' *Sudah ada kontrak' : ''; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div id="kontrak-sewa-preview" class="alert alert-primary py-2 small d-none mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div><strong>Penyewa:</strong> <span id="prev-k-user">-</span></div>
                                <div><strong>Unit:</strong> <span id="prev-k-unit">-</span></div>
                            </div>
                            <div class="col-md-6">
                                <div><strong>Periode:</strong> <span id="prev-k-periode">-</span></div>
                                <div><strong>Nilai Sewa:</strong> <span id="prev-k-total">-</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Sumber Kontrak Dulu (Objek Sewa & Jangka Waktu tanpa Invoice dulu) -->
                    <div id="section-kontrak-dulu" class="border rounded p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold text-primary mb-0">Pasal 1 &amp; 2: Objek Kendaraan &amp; Jangka Waktu Kontrak</h6>
                            <button type="button" id="btn-add-k-unit" class="btn btn-xs btn-outline-primary">
                                <i class="bx bx-plus"></i> Tambah Unit
                            </button>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold mb-1">Tanggal Mulai Sewa <span class="text-danger">*</span></label>
                                <input type="date" id="baru-tgl-mulai" name="baru_tanggal_mulai" class="form-control form-control-sm" value="<?= date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold mb-1">Tanggal Berakhir Sewa <span class="text-danger">*</span></label>
                                <input type="date" id="baru-tgl-selesai" name="baru_tanggal_selesai" class="form-control form-control-sm" value="<?= date('Y-m-d', strtotime('+29 days')); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold mb-1">Total Nilai Kontrak (Otomatis)</label>
                                <input type="text" id="k-total-nilai-preview" class="form-control form-control-sm bg-white fw-bold text-primary" value="Rp5.500.000" readonly>
                            </div>
                        </div>
                        <div id="k-units-container"></div>
                    </div>

                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2">Data PIHAK KEDUA (Penyewa / Instansi)</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Nama Instansi / Perusahaan (Opsional)</label>
                            <input type="text" id="kontrak-perusahaan" name="nama_perusahaan" class="form-control form-control-sm" placeholder="cth: PT Artatama Cipta Mandiri">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Penanggung Jawab / Nama Penyewa <span class="text-danger">*</span></label>
                            <input type="text" id="kontrak-pj" name="penanggung_jawab" class="form-control form-control-sm" placeholder="cth: Satriadi Widya Nugroho, ST,MM" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">No. HP / WA</label>
                            <input type="text" id="kontrak-hp" name="no_hp" class="form-control form-control-sm" placeholder="08...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">NIK / No. KTP (Opsional)</label>
                            <input type="text" id="kontrak-nik" name="nik_ktp" class="form-control form-control-sm" placeholder="Opsional untuk instansi">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label small fw-semibold mb-1">Alamat Kantor / Lokasi <span class="text-danger">*</span></label>
                            <input type="text" id="kontrak-alamat" name="alamat_penyewa" class="form-control form-control-sm" placeholder="Alamat lengkap..." required>
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2">Detail Pasal 2 &amp; Pasal 3 serta Penandatangan</h6>
                    <div class="row g-2 mb-2">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Jangka Waktu (Pasal 2 &amp; 3)</label>
                            <input type="text" id="kontrak-jangka-waktu" name="jangka_waktu_label" class="form-control form-control-sm" placeholder="cth: 1 (satu) bulan">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold mb-1">Skema Pembayaran (Pasal 3 Ayat 2)</label>
                            <input type="text" id="kontrak-skema" name="skema_pembayaran" class="form-control form-control-sm" value="Pembayaran biaya sewa dilakukan oleh PIHAK KEDUA langsung di awal sejumlah tersebut.">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Penandatangan Pihak Pertama</label>
                            <input type="text" id="kontrak-pihak-1" name="pihak_pertama_nama" class="form-control form-control-sm" value="Anggun Suryo Adi Nugroho">
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold mb-1">Bank</label>
                            <input type="text" id="kontrak-bank" name="bank_nama" class="form-control form-control-sm" value="BCA">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Nomor Rekening</label>
                            <input type="text" id="kontrak-norek" name="bank_no_rek" class="form-control form-control-sm" value="2222 333 033">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold mb-1">Atas Nama</label>
                            <input type="text" id="kontrak-an" name="bank_atas_nama" class="form-control form-control-sm" value="GRAHA TRANSPORT CV">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold mb-1">Status Kontrak</label>
                            <select id="kontrak-status" name="status_kontrak" class="form-select form-select-sm">
                                <option value="Aktif">Aktif</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan Kontrak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Terbitkan Tagihan / Invoice dari Kontrak -->
<div class="modal fade" id="modal-buat-tagihan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success bg-opacity-10">
                <h5 class="modal-title text-dark"><i class="bx bx-receipt text-success me-1"></i> Buat Tagihan / Invoice dari Kontrak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-buat-tagihan">
                <input type="hidden" id="tagihan-id-kontrak" name="id_kontrak">
                <div class="modal-body">
                    <div class="p-2 bg-light rounded border mb-3 small">
                        <div><strong>Nomor Kontrak:</strong> <span id="tg-no-kontrak">-</span></div>
                        <div><strong>Penyewa / Instansi:</strong> <span id="tg-penyewa">-</span></div>
                        <div><strong>Periode:</strong> <span id="tg-periode">-</span> | <strong>Nilai Kontrak:</strong> <span id="tg-nilai" class="fw-bold text-primary">Rp0</span></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold mb-1">Tentukan Asal Unit (Internal Garasi / Unit Luar untuk Laporan Laba)</label>
                        <div id="tg-units-list"></div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold mb-1">Status Pembayaran</label>
                            <select id="tg-status-bayar" name="status_pembayaran" class="form-select form-select-sm">
                                <option value="Belum Lunas">Belum Lunas (Tagih ke Instansi)</option>
                                <option value="DP">DP (Uang Muka)</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-none" id="tg-wrap-dp">
                            <label class="form-label small fw-semibold mb-1">Nominal DP (Rp)</label>
                            <input type="number" name="jumlah_dp" class="form-control form-control-sm" min="0" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-check me-1"></i> Terbitkan Tagihan &amp; Masuk Manajemen Sewa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<datalist id="tg-vendor-list">
    <?php foreach ($vendor_list as $v) : ?>
    <option value="<?= htmlspecialchars($v->nama_unit_asal); ?>"></option>
    <?php endforeach; ?>
</datalist>

<script>
$(document).ready(function() {
    const BASE_URL = "<?= base_url(); ?>";
    const TODAY = "<?= date('Y-m-d'); ?>";
    const PRESELECT_SEWA = <?= (int) $preselect_sewa; ?>;
    const GARASI_LIST = <?php
        $gopts = array();
        foreach ($unit_garasi as $ug) {
            $gopts[] = array('id_unit' => (int) $ug->id_unit, 'nama_unit' => $ug->nama_unit);
        }
        echo json_encode($gopts);
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
        return 'Rp' + Math.abs(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatTgl(dateStr) {
        if (!dateStr || dateStr === '0000-00-00') return '-';
        const p = dateStr.split('-');
        if (p.length !== 3) return dateStr;
        return p[2] + '/' + p[1] + '/' + p[0];
    }

    // ===== Builder Unit pada Mode Kontrak Dulu =====
    function addKontrakUnitRow(u) {
        const d = u || {};
        const tipe = d.tipe_unit || '';
        const plat = d.plat_nomor || '';
        const warna = d.warna || 'Hitam';
        const nilai = (d.nilai_sewa !== undefined) ? parseFloat(d.nilai_sewa) : ((d.total_masuk !== undefined) ? parseFloat(d.total_masuk) : 5500000);

        const html = `
            <div class="row g-2 align-items-end mb-2 k-unit-row border-bottom pb-2">
                <div class="col-md-4">
                    <label class="form-label small mb-1">Jenis / Merk Kendaraan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm k-u-tipe" value="${escHtml(tipe)}" placeholder="cth: Toyota Avanza CVT">
                </div>
                <div class="col-md-3">
                    <label class="form-label small mb-1">Nomor Polisi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm text-uppercase k-u-plat" value="${escHtml(plat)}" placeholder="cth: H 1580 EV">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Warna</label>
                    <input type="text" class="form-control form-control-sm k-u-warna" value="${escHtml(warna)}" placeholder="Hitam">
                </div>
                <div class="col-md-2">
                    <label class="form-label small mb-1">Nilai Sewa (Rp)</label>
                    <input type="number" class="form-control form-control-sm k-u-nilai" min="0" value="${nilai}">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-xs btn-outline-danger btn-del-k-unit" title="Hapus"><i class="bx bx-trash"></i></button>
                </div>
            </div>
        `;
        $('#k-units-container').append(html);
        reindexKontrakUnits();
    }

    function reindexKontrakUnits() {
        const rows = $('#k-units-container .k-unit-row');
        let total = 0;
        rows.each(function(idx) {
            const r = $(this);
            r.find('.k-u-tipe').attr('name', `k_units[${idx}][tipe_unit]`);
            r.find('.k-u-plat').attr('name', `k_units[${idx}][plat_nomor]`);
            r.find('.k-u-warna').attr('name', `k_units[${idx}][warna]`);
            r.find('.k-u-nilai').attr('name', `k_units[${idx}][nilai_sewa]`);
            r.find('.btn-del-k-unit').toggleClass('d-none', rows.length <= 1);
            total += parseFloat(r.find('.k-u-nilai').val() || 0);
        });
        $('#k-total-nilai-preview').val(formatRp(total));
    }

    $(document).on('input', '.k-u-nilai', reindexKontrakUnits);
    $('#btn-add-k-unit').on('click', function() {
        addKontrakUnitRow({ nilai_sewa: 0 });
    });
    $(document).on('click', '.btn-del-k-unit', function() {
        if ($('#k-units-container .k-unit-row').length <= 1) return;
        $(this).closest('.k-unit-row').remove();
        reindexKontrakUnits();
    });

    function toggleModeSumber() {
        const mode = $('input[name="mode_sumber"]:checked').val();
        if (mode === 'kontrak_dulu') {
            $('#wrap-existing-select').addClass('d-none');
            $('#kontrak-sewa-preview').addClass('d-none');
            $('#section-kontrak-dulu').removeClass('d-none');
            $('#kontrak-id-sewa').prop('required', false);
            $('#baru-tgl-mulai, #baru-tgl-selesai').prop('required', true);
            updateJangkaWaktuBaru();
        } else {
            $('#wrap-existing-select').removeClass('d-none');
            $('#section-kontrak-dulu').addClass('d-none');
            $('#kontrak-id-sewa').prop('required', true);
            $('#baru-tgl-mulai, #baru-tgl-selesai').prop('required', false);
        }
    }

    function updateJangkaWaktuBaru() {
        const s = $('#baru-tgl-mulai').val();
        const e = $('#baru-tgl-selesai').val();
        if (s && e && e >= s) {
            const diff = Math.round((new Date(e + 'T00:00:00') - new Date(s + 'T00:00:00')) / 86400000) + 1;
            if (diff >= 28 && diff <= 31) {
                $('#kontrak-jangka-waktu').val('1 (satu) bulan');
            } else {
                $('#kontrak-jangka-waktu').val(diff + ' hari');
            }
        }
    }

    $('input[name="mode_sumber"]').on('change', toggleModeSumber);
    $('#baru-tgl-mulai, #baru-tgl-selesai').on('change', updateJangkaWaktuBaru);

    function loadKontrak() {
        $.post(BASE_URL + 'Kontrak/fetch', {
            status_kontrak: $('#filter-status-kontrak').val(),
            search: $('#filter-search-kontrak').val()
        }, function(res) {
            const tbody = $('#kontrak-tbody');
            if (!res || res.status !== 'success' || !res.rows || res.rows.length === 0) {
                tbody.html('<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data kontrak sewa.</td></tr>');
                return;
            }

            let html = '';
            res.rows.forEach(function(k) {
                let badge = 'bg-label-primary';
                if (k.status_kontrak === 'Aktif') badge = 'bg-success';
                else if (k.status_kontrak === 'Selesai') badge = 'bg-secondary';
                else if (k.status_kontrak === 'Dibatalkan') badge = 'bg-danger';

                const unitCount = parseInt(k.jumlah_unit || 1);
                const unitDisplay = unitCount > 1
                    ? `<span class="badge bg-label-primary mb-1">${unitCount} Unit</span><div class="small fw-semibold">${escHtml(k.daftar_unit || k.tipe_unit)}</div>`
                    : `<div class="fw-semibold">${escHtml(k.tipe_unit || '-')}</div><span class="badge bg-label-dark">${escHtml(k.plat_nomor || '-')}</span><div class="small text-muted">Warna: ${escHtml(k.warna || k.warna_unit || '-')}</div>`;
                const totalTagihan = k.total_tagihan_booking || k.nilai_kontrak || k.total_masuk;

                const namaDisplay = k.nama_perusahaan
                    ? `<div class="fw-semibold">${escHtml(k.nama_perusahaan)}</div><small class="text-muted">PJ: ${escHtml(k.penanggung_jawab || k.nama_user)}</small>`
                    : `<div class="fw-semibold">${escHtml(k.penanggung_jawab || k.nama_user)}</div>`;

                const tagihanBadge = k.sudah_tagihan
                    ? `<small class="text-primary fw-semibold">${escHtml(k.no_invoice)}</small>`
                    : `<span class="badge bg-label-warning">Belum Ada Tagihan</span>`;

                const actionTagihan = k.sudah_tagihan
                    ? `<a href="${BASE_URL}Sewa_mobil/cetak_invoice/${k.id_sewa}" target="_blank" class="btn btn-xs btn-outline-primary" title="Cetak Invoice PDF"><i class="bx bx-receipt"></i> Invoice</a>`
                    : `<button type="button" class="btn btn-xs btn-success btn-buat-tagihan" data-id="${k.id_kontrak}" title="Buat Tagihan / Invoice"><i class="bx bx-receipt"></i> Buat Tagihan</button>`;

                html += `
                    <tr>
                        <td>
                            <div class="fw-bold">${escHtml(k.no_kontrak)}</div>
                            <small class="text-muted">Tgl: ${formatTgl(k.tanggal_kontrak)}</small><br>
                            ${tagihanBadge}
                        </td>
                        <td>
                            ${namaDisplay}
                            ${k.nik_ktp ? `<br><small class="text-muted">NIK: ${escHtml(k.nik_ktp)}</small>` : ''}
                            ${k.no_hp ? `<br><small class="text-muted">HP: ${escHtml(k.no_hp)}</small>` : ''}
                        </td>
                        <td>${unitDisplay}</td>
                        <td class="small">
                            <div>${formatTgl(k.tanggal_mulai)} &rarr; ${formatTgl(k.tanggal_selesai)}</div>
                            <div><span class="badge bg-label-info">${escHtml(k.jangka_waktu_label || (k.hari + ' Hari'))}</span></div>
                            <div class="fw-bold text-primary mt-1">${formatRp(totalTagihan)}</div>
                        </td>
                        <td class="small">
                            <div><strong>Bank:</strong> ${escHtml(k.bank_nama || 'BCA')}</div>
                            <div class="text-muted">${escHtml(k.bank_no_rek || '')}</div>
                        </td>
                        <td><span class="badge ${badge}">${escHtml(k.status_kontrak)}</span></td>
                        <td class="text-center text-nowrap">
                            <div class="d-inline-flex gap-1">
                                <a href="${BASE_URL}Kontrak/cetak_pdf/${k.id_kontrak}" target="_blank" class="btn btn-xs btn-danger" title="Cetak Surat Kontrak PDF">
                                    <i class="bx bxs-file-pdf"></i> Kontrak
                                </a>
                                ${actionTagihan}
                                <button type="button" class="btn btn-xs btn-outline-primary btn-edit-kontrak" data-id="${k.id_kontrak}" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-outline-danger btn-hapus-kontrak" data-id="${k.id_kontrak}" title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
            tbody.html(html);
        }, 'json');
    }

    function loadSewaPreview(idSewa, fillEmptyFields) {
        if (!idSewa) {
            $('#kontrak-sewa-preview').addClass('d-none');
            return;
        }
        $.post(BASE_URL + 'Kontrak/get_sewa_info', { id_sewa: idSewa }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            const b = res.booking;
            $('#prev-k-user').text(d.nama_user + (d.no_hp_user ? ' (' + d.no_hp_user + ')' : ''));
            if (b && b.items && b.items.length > 1) {
                const listUnit = b.items.map(function(u) { return u.tipe_unit + ' [' + u.plat_nomor + ']'; }).join(', ');
                $('#prev-k-unit').text(b.items.length + ' Unit: ' + listUnit);
                $('#prev-k-periode').text(formatTgl(d.tanggal_mulai) + ' s/d ' + formatTgl(d.tanggal_selesai));
                $('#prev-k-total').text(formatRp(b.total_tagihan) + ' (' + b.status_pembayaran + ')');
            } else {
                $('#prev-k-unit').text(d.tipe_unit + ' - ' + d.plat_nomor);
                $('#prev-k-periode').text(formatTgl(d.tanggal_mulai) + ' s/d ' + formatTgl(d.tanggal_selesai) + ' (' + d.hari + ' Hari)');
                $('#prev-k-total').text(formatRp(d.total_masuk) + ' (' + d.status_pembayaran + ')');
            }
            $('#kontrak-sewa-preview').removeClass('d-none');

            if (fillEmptyFields) {
                if (!$('#kontrak-pj').val()) $('#kontrak-pj').val(d.nama_user);
                if (!$('#kontrak-hp').val() && d.no_hp_user) $('#kontrak-hp').val(d.no_hp_user);
                if (!$('#kontrak-alamat').val() && d.alamat_user) $('#kontrak-alamat').val(d.alamat_user);
                if (res.jangka_waktu_default) $('#kontrak-jangka-waktu').val(res.jangka_waktu_default);
            }
        }, 'json');
    }

    $('#kontrak-id-sewa').on('change', function() {
        loadSewaPreview($(this).val(), true);
    });

    function openTambahKontrak(idSewaPreselect) {
        $('#form-kontrak')[0].reset();
        $('#kontrak-id').val('');
        $('#wrap-mode-sumber').removeClass('d-none');
        $('#k-units-container').empty();

        $('#modal-kontrak-title').text('Buat Surat Perjanjian Kontrak Sewa Kendaraan');
        $('#kontrak-tanggal').val(TODAY);
        $('#baru-tgl-mulai').val(TODAY);
        const dtEnd = new Date();
        dtEnd.setDate(dtEnd.getDate() + 29);
        $('#baru-tgl-selesai').val(dtEnd.toISOString().split('T')[0]);
        $('#kontrak-pihak-1').val('Anggun Suryo Adi Nugroho');
        $('#kontrak-skema').val('Pembayaran biaya sewa dilakukan oleh PIHAK KEDUA langsung di awal sejumlah tersebut.');
        $('#kontrak-bank').val('BCA');
        $('#kontrak-norek').val('2222 333 033');
        $('#kontrak-an').val('GRAHA TRANSPORT CV');
        $('#kontrak-sewa-preview').addClass('d-none');

        addKontrakUnitRow({});

        if (idSewaPreselect > 0) {
            $('#mode-existing').prop('checked', true);
            toggleModeSumber();
            $('#kontrak-id-sewa').val(idSewaPreselect);
            loadSewaPreview(idSewaPreselect, true);
        } else {
            $('#mode-kontrak-dulu').prop('checked', true);
            toggleModeSumber();
        }
        $('#modal-kontrak').modal('show');
    }

    $('#btn-tambah-kontrak').on('click', function() {
        openTambahKontrak(0);
    });

    $(document).on('click', '.btn-edit-kontrak', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Kontrak/get_detail', { id_kontrak: id }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            $('#kontrak-id').val(d.id_kontrak);
            $('#wrap-mode-sumber').addClass('d-none');
            $('#modal-kontrak-title').text('Edit Kontrak (' + d.no_kontrak + ')');
            $('#kontrak-tanggal').val(d.tanggal_kontrak);
            $('#kontrak-perusahaan').val(d.nama_perusahaan);
            $('#kontrak-pj').val(d.penanggung_jawab || d.nama_user);
            $('#kontrak-pihak-1').val(d.pihak_pertama_nama || 'Anggun Suryo Adi Nugroho');
            $('#kontrak-nik').val(d.nik_ktp);
            $('#kontrak-hp').val(d.no_hp);
            $('#kontrak-alamat').val(d.alamat_penyewa);
            $('#kontrak-jangka-waktu').val(d.jangka_waktu_label);
            $('#kontrak-skema').val(d.skema_pembayaran || 'Pembayaran biaya sewa dilakukan oleh PIHAK KEDUA langsung di awal sejumlah tersebut.');
            $('#kontrak-bank').val(d.bank_nama || 'BCA');
            $('#kontrak-norek').val(d.bank_no_rek || '2222 333 033');
            $('#kontrak-an').val(d.bank_atas_nama || 'GRAHA TRANSPORT CV');
            $('#kontrak-status').val(d.status_kontrak);

            if (d.sudah_tagihan) {
                $('#mode-existing').prop('checked', true);
                toggleModeSumber();
                $('#kontrak-id-sewa').val(d.id_sewa);
                loadSewaPreview(d.id_sewa, false);
            } else {
                $('#mode-kontrak-dulu').prop('checked', true);
                toggleModeSumber();
                $('#baru-tgl-mulai').val(d.tanggal_mulai || d.tanggal_kontrak);
                $('#baru-tgl-selesai').val(d.tanggal_selesai || d.tanggal_kontrak);
                $('#k-units-container').empty();
                if (d.units && d.units.length > 0) {
                    d.units.forEach(function(u) { addKontrakUnitRow(u); });
                } else {
                    addKontrakUnitRow({});
                }
            }
            $('#modal-kontrak').modal('show');
        }, 'json');
    });

    $('#form-kontrak').on('submit', function(e) {
        e.preventDefault();
        const isEdit = $('#kontrak-id').val() !== '';
        const url = BASE_URL + (isEdit ? 'Kontrak/update' : 'Kontrak/simpan');
        $.post(url, $(this).serialize(), function(res) {
            if (res.status === 'success') {
                $('#modal-kontrak').modal('hide');
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1600, showConfirmButton: false }).then(function() {
                    loadKontrak();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    // ===== Buat Tagihan / Invoice dari Kontrak =====
    $(document).on('click', '.btn-buat-tagihan', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Kontrak/get_detail', { id_kontrak: id }, function(res) {
            if (res.status !== 'success') return;
            const d = res.data;
            $('#tagihan-id-kontrak').val(d.id_kontrak);
            $('#tg-no-kontrak').text(d.no_kontrak);
            $('#tg-penyewa').text((d.nama_perusahaan ? d.nama_perusahaan + ' (' + d.penanggung_jawab + ')' : d.penanggung_jawab));
            $('#tg-periode').text(formatTgl(d.tanggal_mulai) + ' s/d ' + formatTgl(d.tanggal_selesai));
            $('#tg-nilai').text(formatRp(d.total_tagihan_booking || d.nilai_kontrak));
            $('#tg-status-bayar').val('Belum Lunas').trigger('change');

            let uHtml = '';
            const units = (d.units && d.units.length > 0) ? d.units : [];
            units.forEach(function(u, idx) {
                let gOpts = '<option value="">-- Pilih Armada Garasi (Opsional) --</option>';
                GARASI_LIST.forEach(function(g) {
                    gOpts += `<option value="${g.id_unit}">${escHtml(g.nama_unit)}</option>`;
                });
                uHtml += `
                    <div class="border rounded p-2 mb-2 bg-light tg-unit-box">
                        <div class="fw-bold small mb-2">${idx + 1}. ${escHtml(u.tipe_unit)} (${escHtml(u.plat_nomor)}) &mdash; Nilai: ${formatRp(u.total_masuk)}</div>
                        <input type="hidden" name="tagihan_units[${idx}][nilai_sewa]" value="${parseFloat(u.total_masuk)}">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small mb-1">Asal Unit</label>
                                <select name="tagihan_units[${idx}][asal_unit]" class="form-select form-select-sm tg-asal">
                                    <option value="garasi">Garasi (Milik Sendiri)</option>
                                    <option value="luar">Unit Luar (Rental Lain)</option>
                                </select>
                            </div>
                            <div class="col-md-8 tg-wrap-garasi">
                                <label class="form-label small mb-1">Armada Garasi</label>
                                <select name="tagihan_units[${idx}][id_unit]" class="form-select form-select-sm">${gOpts}</select>
                            </div>
                            <div class="col-md-8 tg-wrap-luar d-none">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small mb-1">Nama Rental / Vendor <span class="text-danger">*</span></label>
                                        <input type="text" list="tg-vendor-list" name="tagihan_units[${idx}][nama_unit_asal]" class="form-control form-control-sm tg-vendor" placeholder="Nama vendor">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small mb-1">Total Rent to Rent (Rp)</label>
                                        <input type="number" name="tagihan_units[${idx}][rent_to_rent]" class="form-control form-control-sm" min="0" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('#tg-units-list').html(uHtml);
            $('#modal-buat-tagihan').modal('show');
        }, 'json');
    });

    $(document).on('change', '.tg-asal', function() {
        const box = $(this).closest('.tg-unit-box');
        const isLuar = $(this).val() === 'luar';
        box.find('.tg-wrap-garasi').toggleClass('d-none', isLuar);
        box.find('.tg-wrap-luar').toggleClass('d-none', !isLuar);
        box.find('.tg-vendor').prop('required', isLuar);
    });

    $('#tg-status-bayar').on('change', function() {
        $('#tg-wrap-dp').toggleClass('d-none', $(this).val() !== 'DP');
    });

    $('#form-buat-tagihan').on('submit', function(e) {
        e.preventDefault();
        $.post(BASE_URL + 'Kontrak/buat_tagihan', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                $('#modal-buat-tagihan').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Tagihan Diterbitkan!',
                    text: res.message,
                    showCancelButton: true,
                    confirmButtonText: 'Cetak Invoice PDF',
                    cancelButtonText: 'Tutup'
                }).then(function(r) {
                    if (r.isConfirmed && res.id_sewa) {
                        window.open(BASE_URL + 'Sewa_mobil/cetak_invoice/' + res.id_sewa, '_blank');
                    }
                    loadKontrak();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    $(document).on('click', '.btn-hapus-kontrak', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Kontrak?',
            text: 'Data kontrak ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.post(BASE_URL + 'Kontrak/hapus', { id_kontrak: id }, function(res) {
                    if (res.status === 'success') {
                        loadKontrak();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                }, 'json');
            }
        });
    });

    $('#filter-status-kontrak').on('change', loadKontrak);
    let t = null;
    $('#filter-search-kontrak').on('input', function() {
        clearTimeout(t);
        t = setTimeout(loadKontrak, 250);
    });
    $('#btn-reset-kontrak').on('click', function() {
        $('#filter-status-kontrak').val('');
        $('#filter-search-kontrak').val('');
        loadKontrak();
    });

    loadKontrak();
    if (PRESELECT_SEWA > 0) {
        openTambahKontrak(PRESELECT_SEWA);
    }
});
</script>
