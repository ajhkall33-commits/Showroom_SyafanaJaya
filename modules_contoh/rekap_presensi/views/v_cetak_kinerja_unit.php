<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?> - <?=date('d-m-Y')?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Chart.js 3.5.1 (Identik dengan Dashboard) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            font-size: 11.5px;
            line-height: 1.4;
            padding: 20px 20px 80px 20px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .print-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .report-header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 14px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .header-left img {
            height: 60px;
            margin-bottom: 8px;
        }
        .header-left h2 {
            font-size: 19px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .header-left p {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        .header-right {
            text-align: right;
            font-size: 11px;
            color: #64748b;
        }
        .header-right strong {
            color: #0f172a;
        }

        /* ======================================================== */
        /* DIAGRAM BATANG KINERJA UNIT (IDENTIK DENGAN DASHBOARD)   */
        /* ======================================================== */
        .unit-chart-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .chart-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }
        .chart-title-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .badge-step {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            border-radius: 4px;
            color: #ffffff;
            font-weight: 800;
            font-size: 11px;
        }
        .badge-step-green { background-color: #10b981; }
        .badge-step-blue { background-color: #0284c7; }
        .badge-step-indigo { background-color: #4338ca; }

        .chart-title-text {
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
        }
        .chart-subtitle-text {
            font-size: 11px;
            color: #64748b;
            margin-left: 4px;
        }
        .badge-target {
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #475569;
            font-size: 10.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .chart-canvas-box {
            position: relative;
            height: 270px;
            width: 100%;
        }
        .chart-canvas-box.single-chart-view {
            height: 460px;
        }

        /* ======================================================== */
        /* FLOATING ACTION TOOLBAR (KHUSUS LAYAR, NO-PRINT)         */
        /* ======================================================== */
        .floating-action-bar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(8px);
            padding: 8px 14px;
            border-radius: 50px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .chart-tab-pills {
            display: inline-flex;
            background: rgba(255, 255, 255, 0.12);
            padding: 3px;
            border-radius: 30px;
            gap: 4px;
        }
        .chart-tab-pill-btn {
            background: transparent;
            border: none;
            color: #cbd5e1;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .chart-tab-pill-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
        }
        .chart-tab-pill-btn.active {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4);
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            font-size: 12.5px;
            font-weight: 700;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-print {
            background: #10b981;
            color: #ffffff;
        }
        .btn-print:hover {
            background: #059669;
            transform: translateY(-1px);
        }
        .btn-close {
            background: #475569;
            color: #ffffff;
        }
        .btn-close:hover {
            background: #334155;
            transform: translateY(-1px);
        }

        /* ======================================================== */
        /* PRINT STYLES                                             */
        /* ======================================================== */
        @media print {
            @page {
                size: landscape;
                margin: 8mm 10mm 8mm 10mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                font-size: 9.5pt !important;
            }
            .print-container {
                max-width: 100% !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .no-print, .floating-action-bar {
                display: none !important;
            }
            .unit-chart-section {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                margin-bottom: 16px !important;
            }
            .chart-canvas-box {
                height: 270px !important;
            }
            .chart-canvas-box.single-chart-view {
                height: 460px !important;
            }
        }

        /* Mobile Adjustments */
        @media (max-width: 767.98px) {
            body {
                padding: 10px 10px 80px 10px;
            }
            .print-container {
                padding: 15px;
            }
            .report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .header-right {
                text-align: left;
            }
            .floating-action-bar {
                width: 95%;
                flex-direction: column;
                border-radius: 16px;
                bottom: 10px;
                padding: 8px;
            }
            .chart-tab-pills {
                width: 100%;
                justify-content: center;
                overflow-x: auto;
            }
            .chart-tab-pill-btn {
                padding: 5px 8px;
                font-size: 11px;
            }
            .btn-action {
                width: 48%;
                justify-content: center;
                padding: 6px 10px;
                font-size: 11.5px;
            }
            .chart-canvas-box {
                height: 250px;
            }
        }
    </style>
</head>
<body>

    <!-- FLOATING ACTION & FILTER TOOLBAR (KHUSUS TAMPILAN SCREEN) -->
    <div class="floating-action-bar no-print">
        <div class="chart-tab-pills" id="printChartPills">
            <button type="button" class="chart-tab-pill-btn active" data-target="all" onclick="SwitchPrintChart('all')">
                <i class="fa fa-th-large"></i> Semua
            </button>
            <button type="button" class="chart-tab-pill-btn" data-target="hadir" onclick="SwitchPrintChart('hadir')">
                <i class="fa fa-check-circle text-success"></i> % Hadir
            </button>
            <button type="button" class="chart-tab-pill-btn" data-target="tepat" onclick="SwitchPrintChart('tepat')">
                <i class="fa fa-clock-o text-info"></i> % Tepat
            </button>
            <button type="button" class="chart-tab-pill-btn" data-target="total" onclick="SwitchPrintChart('total')">
                <i class="fa fa-trophy text-warning"></i> % Total
            </button>
        </div>
        <div style="display:flex; gap:8px;">
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fa fa-print"></i> Cetak / Simpan PDF
            </button>
            <button onclick="window.close()" class="btn-action btn-close">
                <i class="fa fa-times"></i> Tutup
            </button>
        </div>
    </div>

    <div class="print-container">
        <!-- HEADER KOP LAPORAN -->
        <div class="report-header">
            <div class="header-left">
                <img src="<?= base_url('assets/ias.png') ?>" alt="Logo IAS" onerror="this.style.display='none'">
                <h2>Presentase Presensi Unit</h2>
                <p>Persentase Kehadiran, Persentase Ketepatan Waktu, dan Total Skor Kehadiran dan Ketepatan Waktu</p>
            </div>
            <div class="header-right">
                <p>Periode: <strong>
                    <?php if(!empty($start_date) && !empty($end_date)): ?>
                        <?=date('d/m/Y', strtotime($start_date))?> s/d <?=date('d/m/Y', strtotime($end_date))?>
                    <?php elseif(!empty($start_date)): ?>
                        Mulai <?=date('d/m/Y', strtotime($start_date))?>
                    <?php elseif(!empty($end_date)): ?>
                        Sampai <?=date('d/m/Y', strtotime($end_date))?>
                    <?php else: ?>
                        Seluruh Periode
                    <?php endif; ?>
                </strong></p>
                <p>Dicetak Pada: <strong><?=date('d/m/Y H:i')?> WIB</strong></p>
                <p>Cakupan: <strong><?=$office_included ? '16 Unit (Termasuk Office)' : '15 Unit (14 Teknis + CG)'?></strong></p>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- DIAGRAM BATANG PERFORMA UNIT KERJA (IDENTIK DASHBOARD)   -->
        <!-- ======================================================== -->

        <!-- 1. DIAGRAM BATANG % HADIR -->
        <div class="unit-chart-section" id="wrap-print-hadir">
            <div class="chart-header-row">
                <div class="chart-title-wrap">
                    <span class="badge-step badge-step-green">1</span>
                    <span class="chart-title-text">Persentase Kehadiran (% Hadir)</span>
                    <span class="chart-subtitle-text">(Total Masuk / Hari Kerja Efektif) &times; 100%</span>
                </div>
            
            </div>
            <div class="chart-canvas-box" id="box-canvas-hadir">
                <canvas id="chartPrintHadir"></canvas>
            </div>
        </div>

        <!-- 2. DIAGRAM BATANG % TEPAT WAKTU -->
        <div class="unit-chart-section" id="wrap-print-tepat">
            <div class="chart-header-row">
                <div class="chart-title-wrap">
                    <span class="badge-step badge-step-blue">2</span>
                    <span class="chart-title-text">Persentase Ketepatan Waktu (% Tepat)</span>
                    <span class="chart-subtitle-text">((Total Masuk - Terlambat) / Total Masuk) &times; 100%</span>
                </div>
                
            </div>
            <div class="chart-canvas-box" id="box-canvas-tepat">
                <canvas id="chartPrintTepat"></canvas>
            </div>
        </div>

        <!-- 3. DIAGRAM BATANG % TOTAL SKOR -->
        <div class="unit-chart-section" id="wrap-print-total">
            <div class="chart-header-row">
                <div class="chart-title-wrap">
                    <span class="badge-step badge-step-indigo">3</span>
                    <span class="chart-title-text">Total Skor Kehadiran dan Ketepatan Waktu (% Total)</span>
                    <span class="chart-subtitle-text">(% Hadir + % Tepat Waktu) / 2</span>
                </div>

            </div>
            <div class="chart-canvas-box" id="box-canvas-total">
                <canvas id="chartPrintTotal"></canvas>
            </div>
        </div>
    </div>

    <!-- SCRIPT INITIALIZATION CHART.JS IDENTIK DENGAN DASHBOARD -->
    <script>
        // Data PHP ke JavaScript
        var unitData = <?= json_encode(!empty($unit_performance) ? array_values($unit_performance) : []) ?>;
        var initialViewTab = <?= json_encode(!empty($view_tab) ? $view_tab : 'all') ?>;

        // Custom Plugin untuk menggambar nilai persentase tebal di atas tiang batang
        var barValuePlugin = {
            id: 'barValuePlugin',
            afterDatasetsDraw: function(chart) {
                var ctx = chart.ctx;
                chart.data.datasets.forEach(function(dataset, i) {
                    var meta = chart.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                        var val = dataset.data[index];
                        if (val !== undefined && val !== null && !isNaN(val)) {
                            ctx.save();
                            ctx.font = 'bold 9.5px sans-serif';
                            ctx.fillStyle = '#1e293b';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.fillText(Number(val).toFixed(1) + '%', bar.x, bar.y - 3);
                            ctx.restore();
                        }
                    });
                });
            }
        };

        // Siapkan Labels dan Nilai
        var labels = [];
        var hadirData = [];
        var tepatData = [];
        var totalData = [];

        (unitData || []).forEach(function(u){
            labels.push(u.kode_unit || ('Unit ' + u.id_unit));
            hadirData.push(parseFloat(u.persen_kehadiran || 0));
            tepatData.push(parseFloat(u.persen_tepat_waktu || 0));
            totalData.push(parseFloat(u.persen_total || 0));
        });

        // Common Chart Options
        function getCommonOptions(tooltipTitlePrefix){
            return {
                animation: false, // Nonaktifkan animasi agar langsung siap 100% saat dicetak / PDF
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 108,
                        ticks: {
                            callback: function(v){ return v + '%'; },
                            font: { size: 10, weight: '600' }
                        },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10.5, weight: '700' },
                            color: '#1e293b',
                            maxRotation: 0,
                            minRotation: 0
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            };
        }

        // 1. Inisialisasi Chart Hadir (% Hadir - Hijau)
        var chartHadirInstance = null;
        var canvasHadir = document.getElementById('chartPrintHadir');
        if(canvasHadir){
            chartHadirInstance = new Chart(canvasHadir.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '% Hadir',
                        data: hadirData,
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        borderColor: '#059669',
                        borderWidth: 1.5,
                        borderRadius: 4
                    }]
                },
                plugins: [barValuePlugin],
                options: getCommonOptions('% Hadir')
            });
        }

        // 2. Inisialisasi Chart Tepat (% Tepat - Biru)
        var chartTepatInstance = null;
        var canvasTepat = document.getElementById('chartPrintTepat');
        if(canvasTepat){
            chartTepatInstance = new Chart(canvasTepat.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '% Tepat Waktu',
                        data: tepatData,
                        backgroundColor: 'rgba(2, 132, 199, 0.85)',
                        borderColor: '#0284c7',
                        borderWidth: 1.5,
                        borderRadius: 4
                    }]
                },
                plugins: [barValuePlugin],
                options: getCommonOptions('% Tepat Waktu')
            });
        }

        // 3. Inisialisasi Chart Total (% Total - Indigo)
        var chartTotalInstance = null;
        var canvasTotal = document.getElementById('chartPrintTotal');
        if(canvasTotal){
            chartTotalInstance = new Chart(canvasTotal.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '% Total Skor',
                        data: totalData,
                        backgroundColor: 'rgba(99, 102, 241, 0.85)',
                        borderColor: '#4f46e5',
                        borderWidth: 1.5,
                        borderRadius: 4
                    }]
                },
                plugins: [barValuePlugin],
                options: getCommonOptions('% Total Skor')
            });
        }

        // FUNGSI GANTI TAMPILAN GRAFIK (SEMUA / HADIR / TEPAT / TOTAL)
        function SwitchPrintChart(target){
            // Update tombol active di floating bar
            var buttons = document.querySelectorAll('#printChartPills .chart-tab-pill-btn');
            buttons.forEach(function(btn){
                if(btn.getAttribute('data-target') === target){
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            var wrapHadir = document.getElementById('wrap-print-hadir');
            var wrapTepat = document.getElementById('wrap-print-tepat');
            var wrapTotal = document.getElementById('wrap-print-total');
            var boxHadir  = document.getElementById('box-canvas-hadir');
            var boxTepat  = document.getElementById('box-canvas-tepat');
            var boxTotal  = document.getElementById('box-canvas-total');

            if(target === 'all'){
                wrapHadir.style.display = 'block';
                wrapTepat.style.display = 'block';
                wrapTotal.style.display = 'block';
                boxHadir.classList.remove('single-chart-view');
                boxTepat.classList.remove('single-chart-view');
                boxTotal.classList.remove('single-chart-view');
            } else if(target === 'hadir'){
                wrapHadir.style.display = 'block';
                wrapTepat.style.display = 'none';
                wrapTotal.style.display = 'none';
                boxHadir.classList.add('single-chart-view');
            } else if(target === 'tepat'){
                wrapHadir.style.display = 'none';
                wrapTepat.style.display = 'block';
                wrapTotal.style.display = 'none';
                boxTepat.classList.add('single-chart-view');
            } else if(target === 'total'){
                wrapHadir.style.display = 'none';
                wrapTepat.style.display = 'none';
                wrapTotal.style.display = 'block';
                boxTotal.classList.add('single-chart-view');
            }

            // Trigger redraw canvas agar proporsional
            setTimeout(function(){
                if(chartHadirInstance) chartHadirInstance.resize();
                if(chartTepatInstance) chartTepatInstance.resize();
                if(chartTotalInstance) chartTotalInstance.resize();
            }, 50);
        }

        // Terapkan filter awal sesuai sub-tab yang sedang aktif saat tombol Print diklik di dashboard
        window.addEventListener('DOMContentLoaded', function(){
            if(initialViewTab && initialViewTab !== 'all'){
                SwitchPrintChart(initialViewTab);
            } else {
                SwitchPrintChart('all');
            }
        });
    </script>
</body>
</html>
