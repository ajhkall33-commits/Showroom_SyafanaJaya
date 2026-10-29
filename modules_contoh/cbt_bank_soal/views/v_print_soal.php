<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bank Soal CBT - <?=!empty($unit_info)?htmlspecialchars($unit_info['name_unit']):'Semua Unit'?> (<?=date('d-m-Y')?>)</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css')?>">
    <style>
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.35;
            color: #1e293b;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }
        .print-container {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 26px 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-radius: 8px;
        }

        /* Screen Action Bar */
        .no-print-bar {
            max-width: 1200px;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1e293b;
            padding: 12px 20px;
            border-radius: 8px;
            color: #fff;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn-print {
            background: #0284c7;
            color: #fff;
            border: none;
            padding: 8px 18px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-print:hover { background: #0369a1; }
        .btn-close {
            background: #475569;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-close:hover { background: #334155; }
        .toggle-kunci-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 12px;
            color: #e2e8f0;
            background: rgba(255,255,255,0.08);
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .toggle-kunci-label:hover { background: rgba(255,255,255,0.15); }

        /* Header Dokumen */
        .doc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 14px;
            gap: 15px;
        }
        .doc-header img {
            max-height: 48px;
            object-fit: contain;
        }
        .doc-title-box {
            text-align: right;
        }
        .doc-title {
            font-size: 17px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            color: #0f172a;
        }
        .doc-sub {
            font-size: 11px;
            color: #475569;
            margin: 3px 0 0 0;
        }

        /* Filter Meta Grid */
        .meta-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 14px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 8px 16px;
        }
        .meta-item {
            display: flex;
            flex-direction: column;
        }
        .meta-label {
            font-size: 9.5px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .meta-value {
            font-size: 11.5px;
            font-weight: 700;
            color: #0f172a;
        }

        /* KPI Mini Cards */
        .kpi-container {
            display: flex;
            gap: 10px;
            margin-bottom: 14px;
        }
        .kpi-card {
            flex: 1;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 12px;
            background: #f8fafc;
            text-align: center;
        }
        .kpi-title {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 2px;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }

        /* Table Styling */
        table.print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10.5px;
        }
        table.print-table th, table.print-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            vertical-align: top;
        }
        table.print-table th {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-size: 10px;
            padding: 7px 6px;
        }
        table.print-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        table.print-table tbody tr {
            page-break-inside: avoid;
        }

        /* Badges & Chips */
        .badge-unit {
            background: #e0f2fe;
            color: #0369a1;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 9.5px;
            font-weight: 600;
            margin: 1px 2px 1px 0;
            display: inline-block;
            border: 1px solid #bae6fd;
        }
        .badge-role {
            background: #fef3c7;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 9.5px;
            font-weight: 600;
            margin: 1px 2px 1px 0;
            display: inline-block;
            border: 1px solid #fde68a;
        }
        .badge-kunci {
            background: #dcfce7;
            color: #15803d;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 5px;
            border: 1px solid #bbf7d0;
            font-size: 11px;
            display: inline-block;
        }
        .badge-aktif {
            background: #dcfce7;
            color: #166534;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9.5px;
            display: inline-block;
        }
        .badge-nonaktif {
            background: #fee2e2;
            color: #991b1b;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9.5px;
            display: inline-block;
        }

        /* Opsi Grid */
        .opsi-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 8px;
            margin-top: 4px;
        }
        .opsi-row {
            font-size: 10px;
            line-height: 1.3;
            color: #334155;
            padding: 2px 4px;
            border-radius: 4px;
            display: flex;
            align-items: flex-start;
            gap: 4px;
            word-break: break-word;
        }
        .opsi-key {
            font-weight: 800;
            color: #475569;
            flex-shrink: 0;
        }
        .opsi-row.is-kunci {
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #166534;
            font-weight: 600;
        }
        .opsi-row.is-kunci .opsi-key {
            color: #16a34a;
        }
        .opsi-kunci-mark {
            font-size: 8.5px;
            background: #16a34a;
            color: #fff;
            padding: 0 4px;
            border-radius: 3px;
            margin-left: auto;
            flex-shrink: 0;
            font-weight: bold;
        }

        /* Hide Kunci Class */
        body.hide-kunci .opsi-row.is-kunci {
            background: transparent !important;
            border: none !important;
            color: #334155 !important;
            font-weight: normal !important;
        }
        body.hide-kunci .opsi-kunci-mark,
        body.hide-kunci .col-kunci-data {
            display: none !important;
        }

        /* Signatures */
        .sig-container {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 32%;
            text-align: center;
        }
        .sig-space {
            height: 55px;
        }
        .sig-name {
            font-weight: bold;
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            min-width: 170px;
            padding-bottom: 2px;
        }
        .sig-role {
            font-size: 10px;
            color: #475569;
            margin-top: 3px;
        }

        /* PRINT MEDIA */
        @media print {
            body {
                background: #fff;
                padding: 0;
                font-size: 9.5px;
            }
            .print-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print-bar {
                display: none !important;
            }
            @page {
                size: A4 landscape;
                margin: 8mm 10mm;
            }
        }
    </style>
</head>
<body>

    <!-- SCREEN ONLY ACTION BAR -->
    <div class="no-print-bar">
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <strong><i class="fa fa-file-text mr-1"></i> Preview Print Out Bank Soal CBT</strong>
            <label class="toggle-kunci-label">
                <input type="checkbox" id="cbToggleKunci" checked onchange="toggleKunci(this.checked)">
                <span>Tampilkan Kunci Jawaban</span>
            </label>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <button type="button" class="btn-close" onclick="window.close()"><i class="fa fa-times"></i> Tutup Tab</button>
            <button type="button" class="btn-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak / Simpan PDF</button>
        </div>
    </div>

    <!-- MAIN PRINT CONTAINER -->
    <div class="print-container">
        
        <!-- DOCUMENT HEADER -->
        <div class="doc-header">
            <div>
                <img src="<?=base_url('assets/ias_om_cgk.png')?>" alt="IAS Support" onerror="this.style.display='none'">
            </div>
            <div class="doc-title-box">
                <h1 class="doc-title">LAPORAN BANK SOAL CBT</h1>
                <p class="doc-sub">Sistem Manajemen Evaluasi &amp; Ujian Computer-Based Test</p>
                <p class="doc-sub">
                    Unit: <strong><?=!empty($unit_info) ? htmlspecialchars($unit_info['kode_unit'].' - '.$unit_info['name_unit']) : 'Semua Unit Kerja'?></strong>
                    | Role: <strong><?=!empty($role_info) ? htmlspecialchars($role_info['name_role']) : 'Semua Role / Jabatan'?></strong>
                </p>
            </div>
        </div>

        <!-- FILTER & METADATA INFO -->
        <div class="meta-box">
            <div class="meta-item">
                <span class="meta-label">Filter Unit Kerja</span>
                <span class="meta-value"><?=!empty($unit_info) ? htmlspecialchars($unit_info['name_unit']) : 'Semua Unit (Seluruh Unit Kerja)'?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Filter Role / Jabatan</span>
                <span class="meta-value"><?=!empty($role_info) ? htmlspecialchars($role_info['name_role']) : 'Semua Role (Seluruh Jabatan)'?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Kata Kunci Pencarian</span>
                <span class="meta-value"><?=!empty($search_soal) ? '"'.htmlspecialchars($search_soal).'"' : 'Tanpa Filter Kata Kunci'?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Tanggal Cetak</span>
                <span class="meta-value"><?=$tgl_cetak?> WIB</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Dicetak Oleh</span>
                <span class="meta-value"><?=htmlspecialchars($user_nama)?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Total Butir Soal</span>
                <span class="meta-value"><?=$total_soal?> Soal Terfilter</span>
            </div>
        </div>

        <!-- MINI KPI SUMMARY -->
        <div class="kpi-container">
            <div class="kpi-card">
                <div class="kpi-title">Total Soal Terfilter</div>
                <div class="kpi-value"><?=$total_soal?></div>
            </div>
            <div class="kpi-card" style="border-left: 3px solid #16a34a;">
                <div class="kpi-title">Soal Aktif</div>
                <div class="kpi-value" style="color: #16a34a;"><?=$total_aktif?></div>
            </div>
            <div class="kpi-card" style="border-left: 3px solid #dc2626;">
                <div class="kpi-title">Soal Nonaktif</div>
                <div class="kpi-value" style="color: #dc2626;"><?=$total_nonaktif?></div>
            </div>
            <div class="kpi-card" style="border-left: 3px solid #0284c7;">
                <div class="kpi-title">Total Bobot Nilai</div>
                <div class="kpi-value" style="color: #0284c7;"><?=$total_bobot?></div>
            </div>
        </div>

        <!-- DATA TABLE -->
        <table class="print-table">
            <thead>
                <tr>
                    <th style="width:30px;">No</th>
                    <th style="min-width:240px; text-align:left;">Pertanyaan &amp; Pilihan Jawaban</th>
                    <th class="col-kunci-data" style="width:60px;">Kunci</th>
                    <th style="width:50px;">Bobot</th>
                    <th style="min-width:140px; text-align:left;">Target Unit Kerja</th>
                    <th style="min-width:140px; text-align:left;">Target Role / Jabatan</th>
                    <th style="width:65px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($list)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:30px; color:#64748b;">
                        <em>Tidak ada butir soal yang sesuai dengan kriteria filter saat ini.</em>
                    </td>
                </tr>
                <?php else: ?>
                    <?php foreach ($list as $idx => $d): 
                        $ans = strtolower(trim($d['jawaban'] ?? ''));
                        
                        // Parse Unit List
                        $units = !empty($d['nama_unit_list']) ? explode(', ', $d['nama_unit_list']) : [];
                        // Parse Role List
                        $roles = !empty($d['nama_role_list']) ? explode(', ', $d['nama_role_list']) : [];
                    ?>
                    <tr>
                        <td style="text-align:center; font-weight:bold; color:#64748b;"><?=$idx + 1?></td>
                        <td>
                            <!-- Pertanyaan Text -->
                            <div style="font-weight:700; color:#0f172a; margin-bottom:6px; font-size:11px; white-space:pre-wrap; word-break:break-word;">
                                <?=htmlspecialchars($d['pertanyaan'])?>
                            </div>
                            
                            <!-- Opsi A B C D Grid -->
                            <div class="opsi-container">
                                <div class="opsi-row <?=$ans == 'a' ? 'is-kunci' : ''?>">
                                    <span class="opsi-key">A.</span>
                                    <span><?=htmlspecialchars($d['opsi_a'] ?? '-')?></span>
                                    <?=$ans == 'a' ? '<span class="opsi-kunci-mark">KUNCI</span>' : ''?>
                                </div>
                                <div class="opsi-row <?=$ans == 'b' ? 'is-kunci' : ''?>">
                                    <span class="opsi-key">B.</span>
                                    <span><?=htmlspecialchars($d['opsi_b'] ?? '-')?></span>
                                    <?=$ans == 'b' ? '<span class="opsi-kunci-mark">KUNCI</span>' : ''?>
                                </div>
                                <div class="opsi-row <?=$ans == 'c' ? 'is-kunci' : ''?>">
                                    <span class="opsi-key">C.</span>
                                    <span><?=htmlspecialchars($d['opsi_c'] ?? '-')?></span>
                                    <?=$ans == 'c' ? '<span class="opsi-kunci-mark">KUNCI</span>' : ''?>
                                </div>
                                <div class="opsi-row <?=$ans == 'd' ? 'is-kunci' : ''?>">
                                    <span class="opsi-key">D.</span>
                                    <span><?=htmlspecialchars($d['opsi_d'] ?? '-')?></span>
                                    <?=$ans == 'd' ? '<span class="opsi-kunci-mark">KUNCI</span>' : ''?>
                                </div>
                            </div>
                        </td>
                        <td class="col-kunci-data" style="text-align:center;">
                            <span class="badge-kunci"><?=strtoupper($ans)?></span>
                        </td>
                        <td style="text-align:center; font-weight:bold; color:#0284c7;">
                            <?=$d['bobot'] ?? 1?>
                        </td>
                        <td>
                            <?php if (!empty($units)): ?>
                                <?php foreach($units as $u): ?>
                                    <span class="badge-unit"><?=htmlspecialchars($u)?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span style="color:#64748b; font-style:italic;">Semua Unit</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($roles)): ?>
                                <?php foreach($roles as $r): ?>
                                    <span class="badge-role"><?=htmlspecialchars($r)?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span style="color:#64748b; font-style:italic;">Semua Role</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <?php if (($d['status'] ?? 1) == 1): ?>
                                <span class="badge-aktif">Aktif</span>
                            <?php else: ?>
                                <span class="badge-nonaktif">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- SIGNATURES BLOCK -->
        <div class="sig-container">
            <div class="sig-box">
                <div>Dicetak Oleh,</div>
                <div class="sig-space"></div>
                <div class="sig-name"><?=htmlspecialchars($user_nama)?></div>
                <div class="sig-role">Pengelola / Administrator CBT</div>
            </div>
            <div class="sig-box">
                <!-- Spacing center -->
            </div>
            <div class="sig-box">
                <div>Mengetahui / Menyetujui,</div>
                <div class="sig-space"></div>
                <div class="sig-name">...................................................</div>
                <div class="sig-role">Koordinator / Penanggung Jawab CBT</div>
            </div>
        </div>

    </div>

    <script>
        function toggleKunci(show) {
            if (show) {
                document.body.classList.remove('hide-kunci');
            } else {
                document.body.classList.add('hide-kunci');
            }
        }
    </script>
</body>
</html>
