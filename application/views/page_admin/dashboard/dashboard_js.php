<script>
(function() {
    const CHART_API = "<?= site_url('Dashboard/chart_data'); ?>";
    const INITIAL_TREND_6M = <?= json_encode($trend_6m); ?>;
    const INITIAL_DAILY = <?= json_encode($daily_cmp); ?>;
    const FLEET_COUNTS = [<?= (int)$unit_ready; ?>, <?= (int)$unit_rental; ?>, <?= (int)$unit_service; ?>];
    const COMP_LABA = [<?= (float)$sewa_summary['total_unit_garasi']; ?>, <?= (float)$sewa_summary['total_unit_luar']; ?>];
    const COMP_UNIT = [<?= (int)$comp_counts['garasi']; ?>, <?= (int)$comp_counts['luar']; ?>];

    function formatRpShort(val) {
        const n = Math.round(parseFloat(val) || 0);
        if (n >= 1000000) {
            return 'Rp' + (n / 1000000).toFixed(1).replace(/\.0$/, '') + 'jt';
        }
        if (n >= 1000) {
            return 'Rp' + Math.round(n / 1000) + 'rb';
        }
        return 'Rp' + n;
    }

    function formatRpFull(val) {
        const n = Math.round(parseFloat(val) || 0);
        return 'Rp' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // 1. Live WIB clock
    function updateClock() {
        const el = document.getElementById('gt-live-clock');
        if (!el) return;
        try {
            const now = new Date();
            const str = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
            el.textContent = str.replace(/\./g, ':') + ' WIB';
        } catch (e) {}
    }
    updateClock();
    setInterval(updateClock, 1000);

    if (typeof ApexCharts === 'undefined') return;

    // 2. Fleet Readiness Donut Chart
    const fleetEl = document.querySelector('#gt-fleet-donut');
    if (fleetEl) {
        const totalFleet = FLEET_COUNTS[0] + FLEET_COUNTS[1] + FLEET_COUNTS[2];
        new ApexCharts(fleetEl, {
            chart: { type: 'donut', height: 170, fontFamily: 'Public Sans, sans-serif' },
            series: totalFleet > 0 ? FLEET_COUNTS : [1, 0, 0],
            labels: ['Tersedia (Ready)', 'Disewa (Rental)', 'Maintenance'],
            colors: ['#10b981', '#f59e0b', '#ef4444'],
            legend: { show: false },
            dataLabels: { enabled: false },
            stroke: { width: 3, colors: ['#ffffff'] },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Unit',
                                fontSize: '11px',
                                color: '#64748b',
                                formatter: function() { return totalFleet; }
                            },
                            value: {
                                fontSize: '20px',
                                fontWeight: 700,
                                color: '#0f172a'
                            }
                        }
                    }
                }
            }
        }).render();
    }

    // 3. Composition Donut (Garasi vs Unit Luar)
    let compChart = null;
    const compEl = document.querySelector('#gt-comp-donut');
    function renderCompChart(mode) {
        if (!compEl) return;
        const isLaba = (mode === 'laba');
        const series = isLaba ? COMP_LABA : COMP_UNIT;
        const sumVal = series[0] + series[1];

        const opts = {
            chart: { type: 'donut', height: 245, fontFamily: 'Public Sans, sans-serif' },
            series: sumVal > 0 ? series : [0, 0],
            labels: ['Unit Garasi', 'Unit Luar (Vendor)'],
            colors: ['#f59e0b', '#0ea5e9'],
            legend: { position: 'bottom', fontSize: '12px' },
            dataLabels: {
                enabled: true,
                formatter: function(val) { return Math.round(val) + '%'; }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return isLaba ? formatRpFull(val) : val + ' unit disewa';
                    }
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '66%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: isLaba ? 'Total Laba' : 'Total Sewa',
                                fontSize: '11px',
                                color: '#64748b',
                                formatter: function() {
                                    return isLaba ? formatRpShort(sumVal) : sumVal + ' Unit';
                                }
                            },
                            value: {
                                fontSize: '15px',
                                fontWeight: 700,
                                formatter: function(v) {
                                    return isLaba ? formatRpShort(v) : v + ' Unit';
                                }
                            }
                        }
                    }
                }
            }
        };

        if (compChart) {
            compChart.destroy();
        }
        compChart = new ApexCharts(compEl, opts);
        compChart.render();
    }
    renderCompChart('laba');

    document.querySelectorAll('.gt-comp-mode').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.gt-comp-mode').forEach(function(b) {
                b.classList.remove('btn-success', 'active');
                b.classList.add('btn-outline-success');
            });
            btn.classList.remove('btn-outline-success');
            btn.classList.add('btn-success', 'active');
            renderCompChart(btn.getAttribute('data-comp'));
        });
    });

    // 4. Main Interactive Trend & Monthly Comparison Chart
    let mainChart = null;
    let cache12M = null;
    let currentDaily = INITIAL_DAILY;
    let activeMode = '6m';
    let activeDailyMetric = 'omset';

    const mainEl = document.querySelector('#gt-main-chart');
    const subTitleEl = document.getElementById('gt-main-chart-subtitle');
    const dailyMetricWrap = document.getElementById('gt-daily-metric-wrap');

    function renderMonthlyComboChart(trend, monthCount) {
        if (!mainEl || !trend) return;
        if (subTitleEl) {
            subTitleEl.textContent = 'Perbandingan omset, laba bersih, & jumlah unit tersewa ' + monthCount + ' bulan terakhir';
        }

        const opts = {
            chart: {
                height: 330,
                type: 'line',
                stacked: false,
                toolbar: { show: true, tools: { download: true, selection: false, zoom: false, zoomin: false, zoomout: false, pan: false, reset: false } },
                fontFamily: 'Public Sans, sans-serif'
            },
            series: [
                { name: 'Omset (Rp)', type: 'column', data: trend.omset },
                { name: 'Laba Bersih Akhir (Rp)', type: 'column', data: trend.laba_bersih_akhir || trend.laba },
                { name: 'Biaya Perawatan (Rp)', type: 'column', data: trend.biaya_perawatan || [] },
                { name: 'Unit Tersewa', type: 'line', data: trend.jumlah_unit }
            ],
            colors: ['#1A44B2', '#10b981', '#ef4444', '#f59e0b'],
            stroke: { width: [0, 0, 0, 3], curve: 'smooth' },
            plotOptions: {
                bar: { columnWidth: '54%', borderRadius: 5 }
            },
            markers: { size: [0, 0, 0, 5], hover: { size: 7 } },
            xaxis: { categories: trend.labels },
            yaxis: [
                {
                    seriesName: 'Omset (Rp)',
                    title: { text: 'Nominal (Rp)', style: { fontSize: '11px', color: '#64748b' } },
                    labels: { formatter: function(val) { return formatRpShort(val); } }
                },
                {
                    seriesName: 'Omset (Rp)',
                    show: false
                },
                {
                    seriesName: 'Omset (Rp)',
                    show: false
                },
                {
                    opposite: true,
                    seriesName: 'Unit Tersewa',
                    min: 0,
                    forceNiceScale: true,
                    title: { text: 'Unit Tersewa', style: { fontSize: '11px', color: '#f59e0b' } },
                    labels: { formatter: function(val) { return Math.round(val) + ' Unit'; } }
                }
            ],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(val, ctx) {
                        if (ctx.seriesIndex === 3) return Math.round(val) + ' unit tersewa';
                        return formatRpFull(val);
                    }
                }
            },
            legend: { position: 'top', horizontalAlign: 'left' },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
        };

        if (mainChart) mainChart.destroy();
        mainChart = new ApexCharts(mainEl, opts);
        mainChart.render();
    }

    function renderDailyComparisonChart(daily, metric) {
        if (!mainEl || !daily) return;
        const isOmset = (metric === 'omset');
        if (subTitleEl) {
            subTitleEl.textContent = 'Perbandingan harian (' + (isOmset ? 'Omset' : 'Jumlah Unit Tersewa') + '): ' + daily.current_label + ' vs ' + daily.prev_label;
        }

        const opts = {
            chart: {
                height: 330,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Public Sans, sans-serif'
            },
            series: [
                { name: daily.current_label + ' (Bulan Ini)', data: isOmset ? daily.current_omset : daily.current_unit },
                { name: daily.prev_label + ' (Bulan Lalu)', data: isOmset ? daily.prev_omset : daily.prev_unit }
            ],
            colors: ['#1A44B2', '#94a3b8'],
            stroke: { width: [3, 2], curve: 'smooth', dashArray: [0, 5] },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.04, stops: [0, 95, 100] }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: daily.days,
                title: { text: 'Tanggal dalam Bulan', style: { fontSize: '11px', color: '#64748b' } }
            },
            yaxis: {
                min: 0,
                forceNiceScale: true,
                labels: {
                    formatter: function(val) {
                        return isOmset ? formatRpShort(val) : Math.round(val) + ' unit';
                    }
                }
            },
            tooltip: {
                shared: true,
                y: {
                    formatter: function(val) {
                        return isOmset ? formatRpFull(val) : Math.round(val) + ' unit tersewa';
                    }
                }
            },
            legend: { position: 'top', horizontalAlign: 'left' },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
        };

        if (mainChart) mainChart.destroy();
        mainChart = new ApexCharts(mainEl, opts);
        mainChart.render();
    }

    renderMonthlyComboChart(INITIAL_TREND_6M, 6);

    document.querySelectorAll('.gt-chart-mode').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const mode = btn.getAttribute('data-mode');
            activeMode = mode;

            document.querySelectorAll('.gt-chart-mode').forEach(function(b) {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-primary');
            });
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary', 'active');

            if (dailyMetricWrap) {
                dailyMetricWrap.classList.toggle('d-none', mode !== 'daily');
            }

            if (mode === '6m') {
                renderMonthlyComboChart(INITIAL_TREND_6M, 6);
            } else if (mode === 'daily') {
                renderDailyComparisonChart(currentDaily, activeDailyMetric);
            } else if (mode === '12m') {
                if (cache12M) {
                    renderMonthlyComboChart(cache12M, 12);
                } else if (typeof window.jQuery !== 'undefined') {
                    window.jQuery.getJSON(CHART_API, { months: 12 }, function(res) {
                        if (res && res.status === 'success') {
                            cache12M = res.trend;
                            currentDaily = res.daily || currentDaily;
                            if (activeMode === '12m') {
                                renderMonthlyComboChart(cache12M, 12);
                            }
                        }
                    });
                }
            }
        });
    });

    document.querySelectorAll('.gt-daily-metric').forEach(function(btn) {
        btn.addEventListener('click', function() {
            activeDailyMetric = btn.getAttribute('data-metric');
            document.querySelectorAll('.gt-daily-metric').forEach(function(b) {
                b.classList.remove('btn-info', 'active');
                b.classList.add('btn-outline-info');
            });
            btn.classList.remove('btn-outline-info');
            btn.classList.add('btn-info', 'active');
            if (activeMode === 'daily') {
                renderDailyComparisonChart(currentDaily, activeDailyMetric);
            }
        });
    });
})();
</script>
