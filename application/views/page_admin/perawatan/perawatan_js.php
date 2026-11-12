<script>
$(function() {
    const BASE_URL = "<?= base_url(); ?>";

    function escHtml(s) {
        return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function formatRp(n) {
        const num = Math.round(parseFloat(n) || 0);
        return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatNum(n) {
        const num = Math.round(parseFloat(n) || 0);
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatTgl(dateStr) {
        if (!dateStr || dateStr === '0000-00-00') return '-';
        const p = dateStr.split('-');
        if (p.length !== 3) return dateStr;
        return p[2] + '/' + p[1] + '/' + p[0];
    }

    function jenisBadge(jenis) {
        if (jenis === 'servis') return '<span class="badge bg-label-primary">Servis &amp; Oli</span>';
        if (jenis === 'asuransi') return '<span class="badge bg-label-info">Asuransi</span>';
        if (jenis === 'pajak') return '<span class="badge bg-label-warning">Pajak / KIR</span>';
        return '<span class="badge bg-label-secondary">Lainnya</span>';
    }

    function getFilterQuery() {
        return $.param({
            bulan: $('#filter-bulan').val(),
            jenis_biaya: $('#filter-jenis').val(),
            id_unit: $('#filter-unit').val(),
            status_perawatan: $('#filter-status').val(),
            search: $('#filter-search').val()
        });
    }

    function loadPerawatanData() {
        $.ajax({
            url: BASE_URL + 'Perawatan_unit/fetch',
            type: 'POST',
            dataType: 'json',
            data: {
                bulan: $('#filter-bulan').val(),
                jenis_biaya: $('#filter-jenis').val(),
                id_unit: $('#filter-unit').val(),
                status_perawatan: $('#filter-status').val(),
                search: $('#filter-search').val()
            },
            success: function(res) {
                if (!res || res.status !== 'success') return;
                const s = res.summary || {};
                $('#kpi-total-biaya').text(formatRp(s.total_biaya));
                $('#kpi-jumlah-item').text(s.jumlah_record || 0);
                $('#kpi-sedang-servis').text((s.sedang_servis || 0) + ' proses');
                $('#kpi-servis').text(formatRp(s.total_servis));
                $('#kpi-asuransi').text(formatRp(s.total_asuransi));
                $('#kpi-pajak').text(formatRp(s.total_pajak));
                $('#kpi-lainnya').text(formatRp(s.total_lainnya));

                renderDueBanner(res.upcoming_due || []);
                renderTable(res.rows || []);
            }
        });
    }

    function renderDueBanner(list) {
        const wrap = $('#perawatan-due-alert');
        if (!list || list.length === 0) {
            wrap.addClass('d-none');
            return;
        }
        wrap.removeClass('d-none');
        $('#due-count').text(list.length);
        let html = '';
        list.forEach(function(du) {
            const cls = du.due_days_left < 0 ? 'bg-danger' : 'bg-warning text-dark';
            const lbl = du.due_days_left < 0
                ? 'Lewat ' + Math.abs(du.due_days_left) + ' hr'
                : (du.due_days_left === 0 ? 'Hari Ini' : 'H-' + du.due_days_left);
            const plat = du.plat_nomor ? ' (' + escHtml(du.plat_nomor) + ')' : '';
            html += `<span class="badge ${cls} me-1 mb-1">${escHtml(du.nama_unit)}${plat} - ${escHtml(du.judul_biaya)} (${lbl})</span>`;
        });
        $('#due-badges-list').html(html);
    }

    function renderTable(rows) {
        const tbody = $('#perawatan-tbody');
        if (!rows || rows.length === 0) {
            tbody.html('<tr><td colspan="9" class="text-center py-4 text-muted">Belum ada catatan biaya perawatan unit untuk filter ini.</td></tr>');
            return;
        }
        let html = '';
        rows.forEach(function(r) {
            const kmHtml = (r.km_saat_ini || r.km_berikutnya)
                ? `<div class="small">${r.km_saat_ini ? formatNum(r.km_saat_ini) + ' km' : '-'}${r.km_berikutnya ? '<br><span class="text-muted">Next: ' + formatNum(r.km_berikutnya) + ' km</span>' : ''}</div>`
                : '<span class="text-muted small">-</span>';

            let dueHtml = '<span class="text-muted small">-</span>';
            if (r.tanggal_jatuh_tempo && r.tanggal_jatuh_tempo !== '0000-00-00') {
                let dueBadge = '';
                if (r.due_status === 'overdue') {
                    dueBadge = '<br><span class="badge bg-danger">Lewat Batas</span>';
                } else if (r.due_status === 'soon') {
                    dueBadge = '<br><span class="badge bg-warning text-dark">H-' + r.due_days_left + '</span>';
                }
                dueHtml = `<div class="small">${formatTgl(r.tanggal_jatuh_tempo)}${dueBadge}</div>`;
            }

            const statusBadge = r.status_perawatan === 'Proses'
                ? '<span class="badge bg-warning text-dark">Proses</span>'
                : '<span class="badge bg-success">Selesai</span>';

            const btnSelesai = r.status_perawatan === 'Proses'
                ? `<button type="button" class="btn btn-outline-success btn-selesai-pw" data-id="${r.id_perawatan}" title="Tandai Servis Selesai"><i class="bx bx-check"></i></button>`
                : '';

            html += `
                <tr>
                    <td class="small text-nowrap">${formatTgl(r.tanggal_transaksi)}</td>
                    <td>
                        <div class="fw-semibold text-dark">${escHtml(r.nama_unit)}</div>
                        ${r.plat_nomor ? `<span class="badge bg-label-secondary">${escHtml(r.plat_nomor)}</span>` : ''}
                    </td>
                    <td>${jenisBadge(r.jenis_biaya)}</td>
                    <td>
                        <div class="fw-semibold text-dark">${escHtml(r.judul_biaya)}</div>
                        <small class="text-muted">${escHtml(r.vendor_bengkel || '-')}${r.keterangan ? ' &bull; ' + escHtml(r.keterangan) : ''}</small>
                    </td>
                    <td>${kmHtml}</td>
                    <td>${dueHtml}</td>
                    <td class="text-end fw-bold text-danger">${formatRp(r.nominal)}</td>
                    <td class="text-center">${statusBadge}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            ${btnSelesai}
                            <button type="button" class="btn btn-outline-primary btn-edit-pw" data-id="${r.id_perawatan}" title="Edit"><i class="bx bx-edit"></i></button>
                            <button type="button" class="btn btn-outline-danger btn-hapus-pw" data-id="${r.id_perawatan}" title="Hapus"><i class="bx bx-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
        });
        tbody.html(html);
    }

    function syncJenisFormUi() {
        const jenis = $('#pw-jenis').val();
        if (jenis === 'servis') {
            $('#pw-km-row').removeClass('d-none');
            $('#pw-status-wrap').removeClass('d-none');
            $('#pw-lbl-judul').html('Judul / Rincian Pekerjaan <span class="text-danger">*</span>');
            $('#pw-judul').attr('placeholder', 'cth: Ganti Oli Mesin + Filter Oli');
            $('#pw-lbl-vendor').text('Bengkel / Mekanik');
            $('#pw-lbl-due').text('Jadwal Servis Berikutnya');
        } else if (jenis === 'asuransi') {
            $('#pw-km-row').addClass('d-none');
            $('#pw-lbl-judul').html('Nama Polis / Jenis Asuransi <span class="text-danger">*</span>');
            $('#pw-judul').attr('placeholder', 'cth: Polis All Risk Garda Oto 1 Tahun');
            $('#pw-lbl-vendor').text('Perusahaan Asuransi');
            $('#pw-lbl-due').text('Berakhir Polis / Jatuh Tempo');
        } else if (jenis === 'pajak') {
            $('#pw-km-row').addClass('d-none');
            $('#pw-lbl-judul').html('Jenis Pajak / Dokumen <span class="text-danger">*</span>');
            $('#pw-judul').attr('placeholder', 'cth: Pajak Tahunan STNK / Uji KIR');
            $('#pw-lbl-vendor').text('Samsat / Biro Jasa');
            $('#pw-lbl-due').text('Jatuh Tempo Pajak Berikutnya');
        } else {
            $('#pw-km-row').addClass('d-none');
            $('#pw-lbl-judul').html('Rincian Biaya <span class="text-danger">*</span>');
            $('#pw-judul').attr('placeholder', 'cth: Salon Mobil & Detailing');
            $('#pw-lbl-vendor').text('Vendor / Tempat');
            $('#pw-lbl-due').text('Jadwal Berikutnya (Opsional)');
        }
    }

    $('#pw-jenis').on('change', syncJenisFormUi);

    $('#pw-id-unit').on('change', function() {
        const nama = $(this).find(':selected').data('nama');
        if (nama) {
            $('#pw-nama-unit').val(nama);
        }
    });

    $('#btn-tambah-perawatan').on('click', function() {
        $('#form-perawatan')[0].reset();
        $('#pw-id').val('');
        $('#pw-tgl').val("<?= date('Y-m-d'); ?>");
        $('#pw-status').val('Selesai');
        $('#modal-perawatan-title').text('Catat Biaya Perawatan, Asuransi & Pajak');
        syncJenisFormUi();
        $('#modal-perawatan').modal('show');
    });

    $(document).on('click', '.btn-edit-pw', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Perawatan_unit/get_detail', { id_perawatan: id }, function(res) {
            if (!res || res.status !== 'success') return;
            const d = res.data;
            $('#pw-id').val(d.id_perawatan);
            $('#pw-id-unit').val(d.id_unit || '');
            $('#pw-nama-unit').val(d.nama_unit || '');
            $('#pw-plat').val(d.plat_nomor || '');
            $('#pw-jenis').val(d.jenis_biaya || 'servis');
            $('#pw-tgl').val(d.tanggal_transaksi || '');
            $('#pw-nominal').val(parseFloat(d.nominal) || 0);
            $('#pw-judul').val(d.judul_biaya || '');
            $('#pw-vendor').val(d.vendor_bengkel || '');
            $('#pw-km-now').val(d.km_saat_ini !== null ? d.km_saat_ini : '');
            $('#pw-km-next').val(d.km_berikutnya !== null ? d.km_berikutnya : '');
            $('#pw-status').val(d.status_perawatan || 'Selesai');
            $('#pw-due').val(d.tanggal_jatuh_tempo || '');
            $('#pw-ket').val(d.keterangan || '');
            $('#modal-perawatan-title').text('Edit Catatan Perawatan Unit');
            syncJenisFormUi();
            $('#modal-perawatan').modal('show');
        }, 'json');
    });

    $('#form-perawatan').on('submit', function(e) {
        e.preventDefault();
        const isEdit = $('#pw-id').val() !== '';
        const url = BASE_URL + (isEdit ? 'Perawatan_unit/update' : 'Perawatan_unit/simpan');
        $.post(url, $(this).serialize(), function(res) {
            if (res && res.status === 'success') {
                $('#modal-perawatan').modal('hide');
                Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1400, showConfirmButton: false });
                loadPerawatanData();
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: (res && res.message) ? res.message : 'Terjadi kesalahan.' });
            }
        }, 'json');
    });

    $(document).on('click', '.btn-selesai-pw', function() {
        const id = $(this).data('id');
        $.post(BASE_URL + 'Perawatan_unit/selesai', { id_perawatan: id }, function(res) {
            if (res && res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Selesai', text: res.message, timer: 1300, showConfirmButton: false });
                loadPerawatanData();
            }
        }, 'json');
    });

    $(document).on('click', '.btn-hapus-pw', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Catatan Biaya?',
            text: 'Data biaya perawatan ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then(function(r) {
            if (r.isConfirmed) {
                $.post(BASE_URL + 'Perawatan_unit/hapus', { id_perawatan: id }, function(res) {
                    if (res && res.status === 'success') {
                        loadPerawatanData();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: (res && res.message) || 'Gagal menghapus.' });
                    }
                }, 'json');
            }
        });
    });

    $('#filter-bulan, #filter-jenis, #filter-unit, #filter-status').on('change', loadPerawatanData);
    let searchTimer = null;
    $('#filter-search').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(loadPerawatanData, 250);
    });
    $('#btn-reset-filter').on('click', function() {
        $('#filter-bulan').val('');
        $('#filter-jenis').val('');
        $('#filter-unit').val('');
        $('#filter-status').val('');
        $('#filter-search').val('');
        loadPerawatanData();
    });

    $('#btn-cetak-laporan').on('click', function() {
        window.open(BASE_URL + 'Perawatan_unit/cetak_laporan?' + getFilterQuery(), '_blank');
    });
    $('#btn-export-excel').on('click', function() {
        window.location.href = BASE_URL + 'Perawatan_unit/export_excel?' + getFilterQuery();
    });

    loadPerawatanData();
});
</script>

