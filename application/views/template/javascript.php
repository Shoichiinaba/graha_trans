<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<script src="<?= base_url('assets'); ?>/js/ui-popover.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/libs/jquery/jquery.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/libs/popper/popper.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/js/bootstrap.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/js/menu.js"></script>

<!-- Vendors JS -->
<script src="<?= base_url('assets'); ?>/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="<?= base_url('assets'); ?>/js/main.js"></script>

<!-- Page JS -->
<script src="<?= base_url('assets'); ?>/js/dashboards-analytics.js"></script>

<!-- Global Realtime Overdue Notification Poller -->
<script>
(function() {
    const BASE_URL = "<?= base_url(); ?>";
    const SEWA_URL = "<?= site_url('Sewa_mobil'); ?>";
    const POLL_URL = "<?= site_url('Notifikasi/poll'); ?>";

    function esc(s) {
        return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function formatBellDate(val) {
        const s = String(val || '');
        if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
            const p = s.split('-');
            return p[2] + '/' + p[1] + '/' + p[0];
        }
        return s || '-';
    }

    function formatBellMoney(val) {
        if (typeof val === 'number' || /^\d+(\.\d+)?$/.test(String(val || '').trim())) {
            const n = Math.round(parseFloat(val) || 0);
            return 'Rp' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        return String(val || 'Rp0');
    }

    function renderOverdueBell(items) {
        const list = Array.isArray(items) ? items : [];
        const count = list.length;

        const badge = document.getElementById('nav-notif-badge');
        const headerCount = document.getElementById('nav-notif-header-count');
        const sideBadge = document.getElementById('sidebar-overdue-badge');
        const listEl = document.getElementById('nav-notif-list');

        if (badge) {
            badge.textContent = count;
            badge.classList.toggle('d-none', count === 0);
        }
        if (headerCount) {
            headerCount.textContent = count;
        }
        if (sideBadge) {
            sideBadge.textContent = count;
            sideBadge.classList.toggle('d-none', count === 0);
        }

        if (listEl) {
            if (count === 0) {
                listEl.innerHTML = '<div class="p-3 text-center text-muted small">Tidak ada unit melewati batas sewa.</div>';
            } else {
                let html = '';
                list.forEach(function(it) {
                    const badgeText = it.in_grace_period
                        ? '<span class="badge bg-warning text-dark ms-1">Toleransi 06:00</span>'
                        : '<span class="badge bg-danger ms-1">+' + (parseInt(it.hari_terlambat, 10) || 0) + ' hr</span>';
                    html += `
                        <a href="${SEWA_URL}" class="dropdown-item border-bottom py-2 px-3" style="white-space:normal;">
                            <div class="d-flex justify-content-between align-items-start">
                                <strong class="small text-danger">${esc(it.nama_user)}</strong>
                                ${badgeText}
                            </div>
                            <div class="small text-dark">${esc(it.tipe_unit)} (${esc(it.plat_nomor)})</div>
                            <div class="small text-muted">Selesai: ${esc(formatBellDate(it.tanggal_selesai))} &bull; Tagihan: ${esc(formatBellMoney(it.tagihan_berjalan))}</div>
                        </a>
                    `;
                });
                listEl.innerHTML = html;
            }
        }
    }

    window.gtRenderOverdueBell = renderOverdueBell;

    function showRealtimeBrowserAlert(items) {
        if (!items || items.length === 0) return;

        let alertedIds = [];
        try {
            alertedIds = JSON.parse(sessionStorage.getItem('gt_alerted_overdue') || '[]');
        } catch (e) { alertedIds = []; }

        const freshItems = items.filter(function(it) {
            return alertedIds.indexOf(parseInt(it.id_sewa, 10)) === -1;
        });

        if (freshItems.length === 0) return;

        freshItems.forEach(function(it) { alertedIds.push(parseInt(it.id_sewa, 10)); });
        try {
            sessionStorage.setItem('gt_alerted_overdue', JSON.stringify(alertedIds));
        } catch (e) {}

        const first = freshItems[0];
        const statusDesc = first.in_grace_period
            ? `belum kembali (toleransi s/d 06:00 WIB)`
            : `lewat batas 06:00 WIB (+${first.hari_terlambat} hari, tagihan ${formatBellMoney(first.tagihan_berjalan)})`;
        const msg = freshItems.length === 1
            ? `${first.nama_user} - ${first.tipe_unit} (${first.plat_nomor}) ${statusDesc}.`
            : `${freshItems.length} unit melewati batas sewa dan belum dikembalikan.`;

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'Unit Perlu Ditindaklanjuti!',
                text: msg,
                showConfirmButton: true,
                confirmButtonText: 'Lihat',
                timer: 8000,
                timerProgressBar: true
            }).then(function(r) {
                if (r.isConfirmed) {
                    window.location.href = SEWA_URL;
                }
            });
        }

        if ('Notification' in window && Notification.permission === 'granted' && 'serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistration(BASE_URL + 'sw.js').then(function(reg) {
                if (reg && reg.showNotification) {
                    reg.showNotification('Unit Perlu Ditindaklanjuti!', {
                        body: msg,
                        icon: BASE_URL + 'assets/img/logo/logo.png',
                        badge: BASE_URL + 'assets/img/logo/A.png',
                        tag: 'gt-realtime-alert',
                        renotify: true,
                        vibrate: [200, 100, 200],
                        data: { url: SEWA_URL }
                    });
                }
            }).catch(function() {});
        }
    }

    function pollOverdue() {
        if (typeof window.jQuery === 'undefined') return;
        window.jQuery.ajax({
            url: POLL_URL,
            type: 'GET',
            data: { _t: Date.now() },
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (!res || res.status !== 'success') return;
                renderOverdueBell(res.overdue_items || []);
                showRealtimeBrowserAlert(res.overdue_items || []);
            }
        });
    }

    window.gtPollOverdue = pollOverdue;

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register(BASE_URL + 'sw.js').catch(function() {});
    }

    function initNotifPoller() {
        const bellBtn = document.getElementById('nav-notif-dropdown-toggle');
        if (bellBtn) {
            bellBtn.addEventListener('click', pollOverdue);
        }
        pollOverdue();
        setInterval(pollOverdue, 20000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNotifPoller);
    } else {
        initNotifPoller();
    }
})();
</script>
