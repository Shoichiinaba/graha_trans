<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
            <h4 class="fw-bold mb-1"><i class="bx bx-bell text-primary me-1"></i> Notifikasi Realtime HP Android</h4>
            <p class="text-muted mb-0 small">Peringatan otomatis ke HP Android &amp; panel admin saat unit melewati masa sewa dan belum dikembalikan.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="btn-cek-sekarang" class="btn btn-warning btn-sm">
                <i class="bx bx-radar me-1"></i> Cek Unit Lewat Batas Sekarang
            </button>
            <button type="button" id="btn-test-push" class="btn btn-outline-primary btn-sm">
                <i class="bx bx-send me-1"></i> Kirim Tes Notifikasi
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- Web Push Android / Browser -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-mobile-alt text-primary me-1"></i> Push Notifikasi HP Android (Chrome / PWA)</h6>
                    <span class="badge bg-label-primary"><span id="active-subs-count"><?= (int) $active_subs; ?></span> Perangkat Terdaftar</span>
                </div>
                <div class="card-body">
                    <div id="push-status-box" class="alert alert-secondary small py-2 mb-3">
                        Memeriksa dukungan push notifikasi browser...
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button type="button" id="btn-enable-push" class="btn btn-primary btn-sm">
                            <i class="bx bx-bell-plus me-1"></i> Aktifkan Notifikasi di HP / Browser Ini
                        </button>
                        <button type="button" id="btn-disable-push" class="btn btn-outline-danger btn-sm d-none">
                            <i class="bx bx-bell-off me-1"></i> Nonaktifkan di Perangkat Ini
                        </button>
                    </div>

                    <div class="small text-muted">
                        <strong>Cara Pakai di HP Android:</strong>
                        <ol class="mb-0 ps-3 mt-1">
                            <li>Buka halaman admin ini di <b>Google Chrome Android</b> (<code>https://grahatransport.web.id</code>).</li>
                            <li>Ketuk tombol <b>Aktifkan Notifikasi di HP / Browser Ini</b> lalu pilih <b>Izinkan (Allow)</b>.</li>
                            <li>Opsional: Ketuk menu Chrome (⋮) &rarr; <b>Tambahkan ke Layar Utama (Install App)</b>.</li>
                            <li>Notifikasi akan muncul di bar notifikasi HP Android secara realtime meski browser ditutup.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Channel Alternatif & Cron Otomatis -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-cog text-primary me-1"></i> Channel Push Tambahan &amp; Jadwal Otomatis</h6>
                </div>
                <div class="card-body">
                    <form id="form-notif-setting">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold mb-1">Interval Pengingat Ulang (Jam)</label>
                            <input type="number" name="reminder_interval_hours" class="form-control form-control-sm" min="1" max="168" value="<?= (int) $setting->reminder_interval_hours; ?>">
                            <small class="text-muted">Mencegah spam: setiap unit terlambat akan mengirim notifikasi ulang maksimal setiap N jam hingga dikembalikan/diperpanjang.</small>
                        </div>

                        <!-- ntfy.sh -->
                        <div class="border rounded p-2 mb-2 bg-light">
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="ntfy_enabled" name="ntfy_enabled" value="1" <?= !empty($setting->ntfy_enabled) ? 'checked' : ''; ?>>
                                <label class="form-check-label fw-semibold small" for="ntfy_enabled">Aplikasi Android <b>ntfy</b> (Gratis &amp; jalan walau masih localhost HTTP)</label>
                            </div>
                            <input type="text" name="ntfy_topic" class="form-control form-control-sm" value="<?= htmlspecialchars((string) $setting->ntfy_topic); ?>" placeholder="cth: graha-transport-sewa-2026">
                            <small class="text-muted">Install app <b>ntfy</b> di Play Store &rarr; Subscribe topik yang sama.</small>
                        </div>

                        <!-- Telegram -->
                        <div class="border rounded p-2 mb-2 bg-light">
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="telegram_enabled" name="telegram_enabled" value="1" <?= !empty($setting->telegram_enabled) ? 'checked' : ''; ?>>
                                <label class="form-check-label fw-semibold small" for="telegram_enabled">Telegram Bot</label>
                            </div>
                            <div class="row g-2">
                                <div class="col-7">
                                    <input type="text" name="telegram_bot_token" class="form-control form-control-sm" value="<?= htmlspecialchars((string) $setting->telegram_bot_token); ?>" placeholder="Bot Token">
                                </div>
                                <div class="col-5">
                                    <input type="text" name="telegram_chat_id" class="form-control form-control-sm" value="<?= htmlspecialchars((string) $setting->telegram_chat_id); ?>" placeholder="Chat ID">
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Fonnte -->
                        <div class="border rounded p-2 mb-3 bg-light">
                            <div class="form-check form-switch mb-1">
                                <input class="form-check-input" type="checkbox" id="fonnte_enabled" name="fonnte_enabled" value="1" <?= !empty($setting->fonnte_enabled) ? 'checked' : ''; ?>>
                                <label class="form-check-label fw-semibold small" for="fonnte_enabled">WhatsApp Alert (Fonnte API)</label>
                            </div>
                            <div class="row g-2">
                                <div class="col-7">
                                    <input type="text" name="fonnte_token" class="form-control form-control-sm" value="<?= htmlspecialchars((string) $setting->fonnte_token); ?>" placeholder="Token Fonnte">
                                </div>
                                <div class="col-5">
                                    <input type="text" name="fonnte_target" class="form-control form-control-sm" value="<?= htmlspecialchars((string) $setting->fonnte_target); ?>" placeholder="0812...">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm w-100">
                            <i class="bx bx-save me-1"></i> Simpan Pengaturan Notifikasi
                        </button>
                    </form>

                    <hr class="my-3">
                    <label class="form-label small fw-semibold mb-1">URL Cron Job Otomatis (cPanel / Server)</label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="cron-url-input" class="form-control" value="<?= site_url('Notifikasi_cron/run?token=' . $setting->cron_token); ?>" readonly>
                        <button type="button" id="btn-copy-cron" class="btn btn-outline-secondary">Salin</button>
                    </div>
                    <small class="text-muted">Pasang di cPanel Cron Job (misal tiap 15 menit: <code>*/15 * * * * curl -s "URL" &gt;/dev/null 2&gt;&amp;1</code>) agar notif HP terkirim otomatis 24 jam.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Unit Perlu Ditindaklanjuti Saat Ini -->
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-danger"><i class="bx bx-error-circle me-1"></i> Unit Perlu Ditindaklanjuti Saat Ini (<?= count($overdue_list); ?>)</h6>
            <a href="<?= site_url('Sewa_mobil'); ?>" class="btn btn-xs btn-danger">Kelola di Manajemen Sewa</a>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice / Penyewa</th>
                        <th>Unit &amp; Plat</th>
                        <th>Jadwal Selesai</th>
                        <th>Terlambat</th>
                        <th class="text-end">Tagihan Berjalan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($overdue_list)) : ?>
                    <tr><td colspan="5" class="text-center py-3 text-muted">Tidak ada unit yang melewati batas sewa saat ini.</td></tr>
                    <?php else : ?>
                    <?php foreach ($overdue_list as $ov) : ?>
                    <tr>
                        <td><b><?= htmlspecialchars($ov->nama_user); ?></b><br><small class="text-muted"><?= htmlspecialchars($ov->no_invoice); ?></small></td>
                        <td><?= htmlspecialchars($ov->tipe_unit); ?> <span class="badge bg-dark"><?= htmlspecialchars($ov->plat_nomor); ?></span></td>
                        <td class="text-danger fw-bold"><?= format_tanggal_id($ov->tanggal_selesai); ?></td>
                        <td><span class="badge bg-danger">+<?= (int) $ov->hari_terlambat; ?> Hari</span></td>
                        <td class="text-end fw-bold text-danger"><?= format_rupiah($ov->tagihan_berjalan); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Log Riwayat Notifikasi -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="mb-0 fw-bold"><i class="bx bx-history me-1"></i> Riwayat Pengiriman Notifikasi</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>Judul &amp; Pesan</th>
                        <th>Channel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)) : ?>
                    <tr><td colspan="3" class="text-center py-3 text-muted">Belum ada riwayat notifikasi.</td></tr>
                    <?php else : ?>
                    <?php foreach ($logs as $lg) : ?>
                    <tr>
                        <td class="small text-nowrap"><?= htmlspecialchars($lg->sent_at); ?></td>
                        <td class="small">
                            <div class="fw-bold"><?= htmlspecialchars($lg->judul); ?></div>
                            <div class="text-muted"><?= htmlspecialchars($lg->pesan); ?></div>
                        </td>
                        <td><span class="badge bg-label-info"><?= htmlspecialchars($lg->channel); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

