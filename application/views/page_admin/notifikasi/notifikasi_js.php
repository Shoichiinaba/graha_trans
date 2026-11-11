<script>
$(document).ready(function() {
    const BASE_URL = "<?= base_url(); ?>";
    const VAPID_PUBLIC_KEY = <?= json_encode((string) $setting->vapid_public_key); ?>;
    const SW_URL = BASE_URL + "sw.js";

    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    function arrayBufferToBase64Url(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return window.btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
    }

    async function checkPushState() {
        const box = $('#push-status-box');
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            box.removeClass('alert-secondary alert-success').addClass('alert-warning')
                .html('Browser/origin ini belum mendukung Web Push (pastikan akses menggunakan <b>HTTPS</b> atau <code>localhost</code>). Untuk pengujian lewat IP lokal HTTP, gunakan channel <b>ntfy</b> atau <b>Telegram</b> di sebelah kanan.');
            $('#btn-enable-push').prop('disabled', true);
            return;
        }

        if (!VAPID_PUBLIC_KEY) {
            box.removeClass('alert-secondary').addClass('alert-danger').text('VAPID Key gagal dibuat di server.');
            return;
        }

        try {
            const reg = await navigator.serviceWorker.register(SW_URL);
            const sub = await reg.pushManager.getSubscription();
            if (sub && Notification.permission === 'granted') {
                box.removeClass('alert-secondary alert-warning alert-danger').addClass('alert-success')
                    .html('<i class="bx bx-check-circle me-1"></i> <b>Aktif!</b> Perangkat ini sudah terdaftar menerima notifikasi push realtime.');
                $('#btn-enable-push').html('<i class="bx bx-refresh me-1"></i> Perbarui Langganan Perangkat Ini');
                $('#btn-disable-push').removeClass('d-none');
            } else {
                box.removeClass('alert-success').addClass('alert-info')
                    .html('Perangkat ini belum mengaktifkan notifikasi push. Klik tombol di bawah untuk mengizinkan.');
                $('#btn-disable-push').addClass('d-none');
            }
        } catch (err) {
            box.removeClass('alert-secondary').addClass('alert-warning')
                .text('Service Worker belum aktif: ' + err.message);
        }
    }

    $('#btn-enable-push').on('click', async function() {
        try {
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                Swal.fire({ icon: 'warning', title: 'Izin Ditolak', text: 'Mohon izinkan notifikasi pada pengaturan browser Chrome Anda.' });
                return;
            }
            const reg = await navigator.serviceWorker.register(SW_URL);
            await navigator.serviceWorker.ready;

            let sub = await reg.pushManager.getSubscription();
            if (!sub) {
                sub = await reg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(VAPID_PUBLIC_KEY)
                });
            }

            const p256dh = arrayBufferToBase64Url(sub.getKey('p256dh'));
            const auth = arrayBufferToBase64Url(sub.getKey('auth'));

            $.post(BASE_URL + 'Notifikasi/subscribe', {
                endpoint: sub.endpoint,
                p256dh: p256dh,
                auth: auth
            }, function(res) {
                if (res.status === 'success') {
                    $('#active-subs-count').text(res.active_subs);
                    Swal.fire({ icon: 'success', title: 'Aktif!', text: res.message, timer: 1600, showConfirmButton: false });
                    checkPushState();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                }
            }, 'json');
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Gagal Mengaktifkan Push', text: err.message });
        }
    });

    $('#btn-disable-push').on('click', async function() {
        try {
            const reg = await navigator.serviceWorker.getRegistration(SW_URL);
            if (reg) {
                const sub = await reg.pushManager.getSubscription();
                if (sub) {
                    const endpoint = sub.endpoint;
                    await sub.unsubscribe();
                    $.post(BASE_URL + 'Notifikasi/unsubscribe', { endpoint: endpoint }, function(res) {
                        $('#active-subs-count').text(res.active_subs);
                        checkPushState();
                    }, 'json');
                }
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
        }
    });

    $('#form-notif-setting').on('submit', function(e) {
        e.preventDefault();
        $.post(BASE_URL + 'Notifikasi/save_settings', $(this).serialize(), function(res) {
            if (res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Tersimpan', text: res.message, timer: 1500, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    $('#btn-test-push').on('click', function() {
        $.post(BASE_URL + 'Notifikasi/test_push', {}, function(res) {
            if (res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Tes Terkirim', text: res.message });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
            }
        }, 'json');
    });

    $('#btn-cek-sekarang').on('click', function() {
        $.post(BASE_URL + 'Notifikasi/cek_sekarang', {}, function(res) {
            if (res.status === 'success') {
                Swal.fire({ icon: 'info', title: 'Hasil Pengecekan', text: res.message }).then(function() {
                    location.reload();
                });
            }
        }, 'json');
    });

    $('#btn-copy-cron').on('click', function() {
        const input = document.getElementById('cron-url-input');
        input.select();
        document.execCommand('copy');
        Swal.fire({ icon: 'success', title: 'Disalin', text: 'URL Cron Job disalin ke clipboard.', timer: 1200, showConfirmButton: false });
    });

    checkPushState();
});
</script>

