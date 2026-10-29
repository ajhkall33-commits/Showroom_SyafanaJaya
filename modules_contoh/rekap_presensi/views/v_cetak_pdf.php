<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?> - <?=date('d-m-Y')?></title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
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
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .print-container {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .report-header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 15px;
            margin-bottom: 18px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .header-left h2 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .header-left p {
            font-size: 13px;
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

        /* METADATA INFO */
        .meta-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 15px;
            margin-bottom: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .meta-item {
            font-size: 12px;
        }
        .meta-item label {
            color: #64748b;
            font-weight: 600;
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-item span {
            font-weight: 700;
            color: #1e293b;
        }

        /* TABLE STYLING */
        table.report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        table.report-table th, table.report-table td {
            border: 1px solid #cbd5e1;
            padding: 7px 8px;
            vertical-align: middle;
        }
        table.report-table th {
            background-color: #1e293b !important;
            color: #ffffff !important;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table.report-table th.th-green { background-color: #15803d !important; }
        table.report-table th.th-hadir-real { background-color: #059669 !important; }
        table.report-table th.th-red { background-color: #b91c1c !important; }
        table.report-table th.th-darkred { background-color: #991b1b !important; }
        table.report-table th.th-tap { background-color: #d97706 !important; }
        table.report-table th.th-orange { background-color: #c2410c !important; }
        table.report-table th.th-yellow { background-color: #b45309 !important; }
        table.report-table th.th-blue { background-color: #0369a1 !important; }
        table.report-table th.th-gray { background-color: #475569 !important; }
        table.report-table th.th-purple { background-color: #6d28d9 !important; }

        table.report-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table.report-table tfoot tr {
            background-color: #e2e8f0;
            font-weight: 700;
        }
        table.report-table td.text-center { text-align: center; }
        table.report-table td.text-right { text-align: right; }
        table.report-table td.font-bold { font-weight: 700; }

        /* BADGES */
        .badge-late {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            display: inline-block;
        }

        /* SIGNATURE SECTION */
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: center;
            width: 340px;
        }
        .signature-box .signature-title {
            margin-bottom: 2px;
            font-weight: 600;
            color: #475569;
            font-size: 12px;
        }
        .signature-box .signature-role {
            margin-bottom: 0;
            font-weight: 700;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.35;
        }
        .signature-box .signature-space {
            height: 65px;
        }
        .signature-box .signature-line {
            border-top: 1px solid #1e293b;
            padding-top: 4px;
            font-weight: 700;
            font-size: 12px;
            color: #0f172a;
        }

        /* FLOATING ACTION BAR */
        .floating-action-bar {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 9999;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: transform 0.2s;
            text-decoration: none;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .btn-print {
            background-color: #dc2626;
            color: #ffffff;
        }
        .btn-close {
            background-color: #475569;
            color: #ffffff;
        }

        .report-table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 20px;
        }

        /* MOBILE PREVIEW MEDIA QUERY (LAYAR HP) */
        @media screen and (max-width: 768px) {
            body {
                padding: 10px 8px 85px 8px !important;
            }
            .print-container {
                padding: 16px 12px !important;
                border-radius: 6px !important;
            }
            .report-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 8px !important;
                padding-bottom: 10px !important;
            }
            .header-left img {
                height: 50px !important;
                margin-bottom: 6px !important;
            }
            .header-left h2 {
                font-size: 16px !important;
            }
            .header-left p {
                font-size: 12px !important;
            }
            .header-right {
                text-align: left !important;
                font-size: 10.5px !important;
            }
            .meta-card {
                gap: 10px !important;
                padding: 10px !important;
            }
            .meta-item {
                flex: 1 1 45% !important;
            }
            .floating-action-bar {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                padding: 10px 14px !important;
                background: rgba(15, 23, 42, 0.92) !important;
                backdrop-filter: blur(8px) !important;
                -webkit-backdrop-filter: blur(8px) !important;
                display: flex !important;
                justify-content: space-between !important;
                border-radius: 0 !important;
                border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
                box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.25) !important;
                z-index: 99999 !important;
            }
            .floating-action-bar .btn-action {
                flex: 1 1 50% !important;
                justify-content: center !important;
                padding: 10px 12px !important;
                font-size: 13px !important;
                border-radius: 6px !important;
            }
            table.report-table {
                min-width: 980px !important;
            }
            .signature-section {
                justify-content: center !important;
                margin-top: 20px !important;
            }
            .signature-box {
                width: 100% !important;
                max-width: 320px !important;
            }
        }

        /* PRINT MEDIA QUERY */
        @media print {
            @page {
                size: landscape;
                margin: 10mm 10mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
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
            table.report-table th {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .report-table-responsive {
                overflow: visible !important;
            }
        }
    </style>
</head>
<body>

    <div class="floating-action-bar no-print">
        <button onclick="window.print()" class="btn-action btn-print">
            <i class="fa fa-print"></i> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn-action btn-close">
            <i class="fa fa-times"></i> Tutup
        </button>
    </div>

    <div class="print-container">
        <!-- HEADER -->
        <div class="report-header">
            <div class="header-left">
                <img src="<?= base_url('assets/ias.png') ?>" alt="Logo IAS" style="height: 80px; margin-bottom: 10px;">
                <h2>Laporan Rekapitulasi Presensi Karyawan</h2>
                <p>Ringkasan akumulasi kehadiran, keterlambatan, ketidakhadiran (TAP, A, UL), izin, sakit, dan day off</p>
            </div>
            <div class="header-right">
                <p>Dicetak Pada: <strong><?=date('d/m/Y H:i')?> WIB</strong></p>
                <p>Status Data: <strong>Aktif</strong></p>
            </div>
        </div>

        <!-- META FILTER INFO -->
        <div class="meta-card">
            <div class="meta-item">
                <label>Unit Kerja</label>
                <span><?=!empty($unit_info) ? ($unit_info['kode_unit'] . ' - ' . $unit_info['name_unit']) : 'Semua Unit Kerja'?></span>
            </div>
            <div class="meta-item">
                <label>Personil Terpilih</label>
                <span><?=!empty($user_info) ? ($user_info['nama'] . ' (' . $user_info['nik'] . ')') : 'Semua Personil'?></span>
            </div>
            <div class="meta-item">
                <label>Periode Tanggal</label>
                <span>
                    <?php if(!empty($start_date) && !empty($end_date)): ?>
                        <?=date('d/m/Y', strtotime($start_date))?> s/d <?=date('d/m/Y', strtotime($end_date))?>
                    <?php elseif(!empty($start_date)): ?>
                        Mulai <?=date('d/m/Y', strtotime($start_date))?>
                    <?php elseif(!empty($end_date)): ?>
                        Sampai <?=date('d/m/Y', strtotime($end_date))?>
                    <?php else: ?>
                        Seluruh Periode
                    <?php endif; ?>
                </span>
            </div>
            <div class="meta-item">
                <label>Total Karyawan</label>
                <span><?=count($list)?> Orang</span>
            </div>
        </div>

        <!-- STATUS EXPLANATION BANNER -->
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #16a34a; border-radius: 4px; padding: 7px 12px; font-size: 11px; margin-bottom: 15px; color: #166534; line-height: 1.4;">
            <strong><i class="fa fa-info-circle"></i> Ketentuan Status:</strong> 
            Kolom <strong>MASUK</strong> mencakup <em>Hadir Real (Fisik) + Cuti / Izin / Sakit + TAP</em>. 
            Kolom <strong>HADIR REAL</strong> adalah <em>Presensi Fisik Lengkap (H/T) Masuk &amp; Pulang</em>.
            Kolom <strong>CUTI</strong> menggabungkan <em>Cuti Resmi, Izin, dan Sakit</em>.
            Kolom <strong>TAP</strong> adalah <em>Tidak Absen Pulang (Dianggap Masuk)</em>.
            Kolom <strong>TDK HADIR</strong> khusus menghitung <em>Alpha (Mangkir) + UL (Unpaid Leave)</em>.
        </div>

        <!-- Petunjuk swipe layar HP -->
        <div class="no-print d-block d-md-none text-muted mb-2" style="font-size:11.5px; font-weight:500;">
            <i class="fa fa-arrows-h text-primary mr-1"></i> <em>Geser tabel ke samping untuk melihat seluruh kolom data</em>
        </div>

        <!-- TABLE WITH RESPONSIVE WRAPPER -->
        <div class="report-table-responsive">
        <table class="report-table">
            <thead>
                <tr>
                    <th width="25">NO</th>
                    <th width="55">UNIT</th>
                    <th width="65">NIK</th>
                    <th>NAMA KARYAWAN</th>
                    <th>JABATAN</th>
                    <th width="45">HARI</th>
                    <th width="50" class="th-green" title="Total Masuk: Hadir Real + Cuti + TAP">MASUK</th>
                    <th width="50" class="th-hadir-real" title="Kehadiran Fisik Murni (H/T)">HADIR REAL</th>
                    <th width="45" class="th-yellow" title="Cuti Resmi, Izin &amp; Sakit (Dianggap Masuk)">CUTI</th>
                    <th width="40" class="th-tap" title="Tidak Absen Pulang (Dianggap Masuk)">TAP</th>
                    <th width="55" class="th-darkred" title="Total Tidak Hadir: Alpha + UL">TDK HADIR</th>
                    <th width="45" class="th-gray" title="Alpha (Mangkir)">ALPHA</th>
                    <th width="35" class="th-orange" title="Unpaid Leave">UL</th>
                    <th width="40" class="th-purple" title="Day Off">OFF</th>
                    <th width="50" class="th-red" title="Jumlah Terlambat">TERLAMBAT</th>
                    <th width="55" style="background-color:#15803d; color:#fff;">% HADIR</th>
                    <th width="55" style="background-color:#0284c7; color:#fff;">% TEPAT</th>
                    <th width="55" style="background-color:#0f172a; color:#fff;">TOTAL %</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sum_records = 0;
                $sum_hadir = 0;
                $sum_hadir_real = 0;
                $sum_cuti = 0;
                $sum_tap = 0;
                $sum_tidak_hadir = 0;
                $sum_alpha = 0;
                $sum_ul = 0;
                $sum_off = 0;
                $sum_terlambat = 0;
                $sum_pct_hadir = 0;
                $sum_pct_tepat = 0;
                $sum_pct_total = 0;
                $total_personil = count($list);

                if (!empty($list)): 
                    $no = 1;
                    foreach ($list as $row): 
                        $t_rec = (int)$row['total_record'];
                        $t_hadir = (int)$row['total_hadir'];
                        $t_hadir_real = (int)($row['total_hadir_fisik'] ?? 0);
                        $t_cuti = (int)($row['total_cuti'] ?? ((int)($row['total_izin'] ?? 0) + (int)($row['total_sakit'] ?? 0)));
                        $t_tap = (int)($row['total_tap'] ?? 0);
                        $t_alpha = (int)($row['total_alpha'] ?? 0);
                        $t_ul = (int)($row['total_ul'] ?? 0);
                        $t_tidak_hadir = (int)($row['total_tidak_hadir'] ?? ($t_alpha + $t_ul));
                        $t_off = (int)($row['total_off'] ?? 0);
                        $t_late = (int)$row['total_terlambat'];

                        $pct_hadir = (float)($row['persen_kehadiran'] ?? 0);
                        $pct_tepat = (float)($row['persen_tepat_waktu'] ?? 0);
                        $pct_total = (float)($row['persen_total'] ?? 0);

                        $sum_records += $t_rec;
                        $sum_hadir += $t_hadir;
                        $sum_hadir_real += $t_hadir_real;
                        $sum_cuti += $t_cuti;
                        $sum_tap += $t_tap;
                        $sum_tidak_hadir += $t_tidak_hadir;
                        $sum_alpha += $t_alpha;
                        $sum_ul += $t_ul;
                        $sum_off += $t_off;
                        $sum_terlambat += $t_late;

                        $sum_pct_hadir += $pct_hadir;
                        $sum_pct_tepat += $pct_tepat;
                        $sum_pct_total += $pct_total;
                ?>
                <tr>
                    <td class="text-center font-bold"><?=$no++?></td>
                    <td class="font-bold"><?=$row['kode_unit'] ?? '-'?></td>
                    <td><?=$row['nik'] ?? '-'?></td>
                    <td class="font-bold"><?=$row['full_name'] ?? '-'?></td>
                    <td><?=$row['nama_jabatan'] ?? ($row['name_role'] ?? '-')?></td>
                    <td class="text-center font-bold"><?=$t_rec?></td>
                    <td class="text-center font-bold" style="color:#15803d; font-size:12px;"><?=$t_hadir?></td>
                    <td class="text-center font-bold" style="color:#059669;"><?=$t_hadir_real?></td>
                    <td class="text-center font-bold" style="color:#b45309;"><?=$t_cuti?></td>
                    <td class="text-center font-bold" style="color:#d97706;"><?=$t_tap?></td>
                    <td class="text-center font-bold" style="color:#991b1b; background-color:#fee2e2;">
                        <?php if ($t_tidak_hadir > 0): ?>
                            <span style="color:#991b1b; font-weight:800;"><?=$t_tidak_hadir?>x</span>
                        <?php else: ?>
                            <span style="color:#94a3b8; font-weight:700;">0</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center" style="color:#475569; font-weight:700;"><?=$t_alpha?></td>
                    <td class="text-center" style="color:#c2410c; font-weight:700;"><?=$t_ul?></td>
                    <td class="text-center font-bold" style="color:#6d28d9;"><?=$t_off?></td>
                    <td class="text-center">
                        <?php if ($t_late > 0): ?>
                            <span class="badge-late"><?=$t_late?>x</span>
                        <?php else: ?>
                            <span style="color:#15803d; font-weight:700;">0</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center font-bold" style="color:#15803d;"><?=number_format($pct_hadir, 1)?>%</td>
                    <td class="text-center font-bold" style="color:#0284c7;"><?=number_format($pct_tepat, 1)?>%</td>
                    <td class="text-center font-bold" style="color:#0f172a; background-color:#f1f5f9;"><?=number_format($pct_total, 1)?>%</td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="18" class="text-center" style="padding: 20px; color:#94a3b8;">
                        Tidak ada data rekapitulasi presensi yang sesuai dengan filter.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
            <?php if (!empty($list)): 
                $avg_pct_hadir = ($total_personil > 0) ? round($sum_pct_hadir / $total_personil, 1) : 0;
                $avg_pct_tepat = ($total_personil > 0) ? round($sum_pct_tepat / $total_personil, 1) : 0;
                $avg_pct_total = ($total_personil > 0) ? round($sum_pct_total / $total_personil, 1) : 0;
            ?>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right font-bold">TOTAL / RATA-RATA:</td>
                    <td class="text-center font-bold"><?=$sum_records?></td>
                    <td class="text-center font-bold" style="color:#15803d;"><?=$sum_hadir?></td>
                    <td class="text-center font-bold" style="color:#059669;"><?=$sum_hadir_real?></td>
                    <td class="text-center font-bold" style="color:#b45309;"><?=$sum_cuti?></td>
                    <td class="text-center font-bold" style="color:#d97706;"><?=$sum_tap?></td>
                    <td class="text-center font-bold" style="color:#991b1b; background-color:#fee2e2;"><?=$sum_tidak_hadir?></td>
                    <td class="text-center font-bold" style="color:#475569;"><?=$sum_alpha?></td>
                    <td class="text-center font-bold" style="color:#c2410c;"><?=$sum_ul?></td>
                    <td class="text-center font-bold" style="color:#6d28d9;"><?=$sum_off?></td>
                    <td class="text-center font-bold" style="color:#b91c1c;"><?=$sum_terlambat?></td>
                    <td class="text-center font-bold" style="color:#15803d;"><?=number_format($avg_pct_hadir, 1)?>%</td>
                    <td class="text-center font-bold" style="color:#0284c7;"><?=number_format($avg_pct_tepat, 1)?>%</td>
                    <td class="text-center font-bold" style="color:#0f172a; background-color:#e2e8f0;"><?=number_format($avg_pct_total, 1)?>%</td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
        </div>

        <!-- SIGNATURE -->
        <div class="signature-section">
            <div class="signature-box">
                <p class="signature-title">Mengetahui,</p>
                <p class="signature-role">IASS CENGKARENG OPERATION &amp; MAINTENANCE NON TERMINAL SENIOR MANAGER</p>
                <div class="signature-space"></div>
                <div class="signature-line">
                   Muh. Jupri
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
