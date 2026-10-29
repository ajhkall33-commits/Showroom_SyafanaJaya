<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Hasil Coaching Personil - <?=$semester?> <?=$tahun?></title>
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
            line-height: 1.3;
            color: #111827;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }
        .print-container {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        /* Action Bar (Screen Only) */
        .no-print-bar {
            max-width: 1100px;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1e293b;
            padding: 12px 20px;
            border-radius: 8px;
            color: #fff;
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
        }
        .btn-print:hover { background: #0369a1; }
        .btn-back {
            background: #475569;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
        }
        .btn-back:hover { background: #334155; }

        /* Document Header */
        .doc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .doc-header img {
            max-height: 45px;
            object-fit: contain;
        }
        .doc-title-box {
            text-align: right;
        }
        .doc-title {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            color: #0f172a;
        }
        .doc-sub {
            font-size: 11px;
            color: #475569;
            margin: 2px 0 0 0;
        }

        /* KPI Stat Cards */
        .kpi-container {
            display: flex;
            gap: 12px;
            margin-bottom: 18px;
        }
        .kpi-card {
            flex: 1;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 14px;
            background: #f8fafc;
            text-align: center;
        }
        .kpi-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 20px;
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
            vertical-align: middle;
        }
        table.print-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.print-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge-status-yes {
            background: #dcfce7;
            color: #15803d;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 12px;
            display: inline-block;
            font-size: 10px;
        }
        .badge-status-no {
            background: #fee2e2;
            color: #b91c1c;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 12px;
            display: inline-block;
            font-size: 10px;
        }

        /* Signatures */
        .sig-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 30%;
            text-align: center;
        }
        .sig-space {
            height: 65px;
        }
        .sig-name {
            font-weight: bold;
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            min-width: 180px;
            padding-bottom: 2px;
        }
        .sig-role {
            font-size: 11px;
            color: #475569;
            margin-top: 4px;
        }

        /* PRINT MEDIA */
        @media print {
            body {
                background: #fff;
                padding: 0;
                font-size: 10px;
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
                margin: 10mm 12mm;
            }
        }
    </style>
</head>
<body>

    <!-- SCREEN ONLY TOP BAR -->
    <div class="no-print-bar">
        <div>
            <strong><i class="fa fa-file-text-o mr-1"></i> Preview Laporan Rekapitulasi Coaching Personil</strong> (Native Web PDF)
        </div>
        <div>
            <a href="javascript:window.history.back()" class="btn-back"><i class="fa fa-arrow-left"></i> Kembali</a>
            <button type="button" class="btn-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak / Simpan PDF</button>
        </div>
    </div>

    <!-- DOCUMENT CONTAINER -->
    <div class="print-container">
        
        <!-- HEADER -->
        <div class="doc-header">
            <div>
                <img src="<?=base_url('assets/ias_om_cgk.png')?>" alt="IAS Support">
            </div>
            <div class="doc-title-box">
                <h1 class="doc-title">LAPORAN REKAPITULASI COACHING PERSONIL</h1>
                <p class="doc-sub">Monitoring &amp; Evaluasi Pembinaan Karyawan<?=($perihal == 'Hasil Asesmen' && !empty($ada_asesmen)) ? ' (Nilai Akhir &lt; 41)' : ''?></p>
                <p class="doc-sub">
                    Periode: <strong><?=$semester?> <?=$tahun?></strong> 
                    (<?=$periode_start?> s/d <?=$periode_end?>) 
                    | Unit: <strong><?=$unit_info ? $unit_info['kode_unit'].' - '.$unit_info['name_unit'] : 'Semua Unit Kerja'?></strong>
                    | Dicetak: <strong><?=date('d-m-Y H:i')?></strong>
                </p>
            </div>
        </div>

        <!-- KPI SUMMARY CARDS -->
        <?php 
            if (!empty($is_automated)) {
                $target_denominator = $total_all;
            } else {
                $target_denominator = $total_target;
            }
            $persen_selesai = ($target_denominator > 0) ? round(($total_sudah / $target_denominator) * 100, 1) : 0;
        ?>
        <div class="kpi-container">
            <?php if(!empty($is_automated)): ?>
            <div class="kpi-card">
                <div class="kpi-title">Total Perlu Coaching</div>
                <div class="kpi-value text-dark"><?=$total_all?></div>
            </div>
            <?php else: ?>
            <div class="kpi-card">
                <div class="kpi-title">Total Personil Unit</div>
                <div class="kpi-value text-dark"><?=$total_all?></div>
            </div>
            <div class="kpi-card" style="background:#fffbeb; border-color:#fcd34d;">
                <div class="kpi-title" style="color:#92400e;">Terkena Coaching (Target)</div>
                <div class="kpi-value" style="color:#b45309;"><?=$total_target?></div>
            </div>
            <?php endif; ?>
            <div class="kpi-card" style="background:#f0fdf4; border-color:#86efac;">
                <div class="kpi-title" style="color:#166534;">Sudah di-Coaching</div>
                <div class="kpi-value" style="color:#15803d;"><?=$total_sudah?></div>
            </div>
            <div class="kpi-card" style="background:#fef2f2; border-color:#fca5a5;">
                <div class="kpi-title" style="color:#991b1b;">Belum di-Coaching</div>
                <div class="kpi-value" style="color:#b91c1c;"><?=$total_belum?></div>
            </div>
            <div class="kpi-card" style="background:#eff6ff; border-color:#93c5fd;">
                <div class="kpi-title" style="color:#1e40af;">Persentase Capaian (%)</div>
                <div class="kpi-value" style="color:#1d4ed8;"><?=$persen_selesai?>%</div>
            </div>
        </div>

        <!-- COMPREHENSIVE TABLE -->
        <table class="print-table">
            <thead>
                <tr>
                    <th width="30">NO</th>
                    <th width="100">NIK</th>
                    <th>NAMA PERSONIL</th>
                    <th width="70">UNIT</th>
                    <th>JABATAN</th>
                    <?php if($perihal == 'Hasil Asesmen' && !empty($ada_asesmen)): ?>
                    <th width="55">CBT</th>
                    <th width="55">WWC</th>
                    <th width="65">PRESENSI</th>
                    <th width="65">NILAI AKHIR</th>
                    <?php endif; ?>
                    <?php if(empty($is_automated)): ?>
                    <th width="100">STATUS TARGET</th>
                    <?php endif; ?>
                    <th width="110">STATUS COACHING</th>
                    <th width="85">TGL COACH</th>
                    <th>COACH / ATASAN</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)): foreach($list as $i => $item): ?>
                <tr>
                    <td style="text-align:center; font-weight:bold; color:#64748b;"><?=$i+1?></td>
                    <td style="font-weight:bold;"><?=$item['nik'] ?? '-'?></td>
                    <td><strong><?=$item['nama_peserta'] ?? '-'?></strong></td>
                    <td style="text-align:center;"><strong><?=$item['kode_unit'] ?? '-'?></strong></td>
                    <td><?=$item['nama_jabatan'] ?? '-'?></td>
                    
                    <?php if($perihal == 'Hasil Asesmen' && !empty($ada_asesmen)): ?>
                    <td style="text-align:center;"><?=isset($item['nilai_cbt']) ? number_format((float)$item['nilai_cbt'], 1) : '-'?></td>
                    <td style="text-align:center;"><?=isset($item['nilai_wwc']) ? number_format((float)$item['nilai_wwc'], 1) : '-'?></td>
                    <td style="text-align:center;"><?=isset($item['skor_presensi']) ? number_format((float)$item['skor_presensi'], 1).'%' : '-'?></td>
                    <td style="text-align:center; font-weight:bold; color:#b91c1c;"><?=isset($item['nilai_akhir']) ? number_format((float)$item['nilai_akhir'], 1) : '-'?></td>
                    <?php endif; ?>

                    <?php if(empty($is_automated)): ?>
                    <td style="text-align:center;">
                        <?php if(!empty($item['is_target'])): ?>
                        <span class="badge-status-no" style="background:#fee2e2; color:#991b1b; border:1px solid #fca5a5;">Terkena Coaching</span>
                        <?php else: ?>
                        <span style="color:#64748b; font-size:10.5px;">Tidak Terkena</span>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>

                    <td style="text-align:center;">
                        <?php if($item['is_coached']): ?>
                        <span class="badge-status-yes">Sudah di-Coaching</span>
                        <?php else: ?>
                            <?php if(!empty($item['is_target']) || !empty($is_automated)): ?>
                            <span class="badge-status-no">Belum di-Coaching</span>
                            <?php else: ?>
                            <span style="color:#94a3b8; font-size:10.5px;">Tidak Perlu</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;"><?=$item['tanggal_coaching'] ?? '-'?></td>
                    <td><?=$item['nama_atasan'] ?? '-'?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="<?=($perihal == 'Hasil Asesmen' && !empty($ada_asesmen)) ? 12 : 9?>" style="text-align:center; padding:20px; color:#64748b;">
                        Tidak ada data personil pada kriteria filter ini.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- SIGNATURE BLOCK -->
        <div class="sig-container">
            <div class="sig-box">
                <div>Dibuat Oleh (PIC / Coach),</div>
                <div class="sig-space"></div>
                <div class="sig-name"><?=sess()['nama'] ?? '.........................................'?></div>
                <div class="sig-role">Supervisor / Unit Coach</div>
            </div>

            <div class="sig-box">
                <div>Diperiksa Oleh,</div>
                <div class="sig-space"></div>
                <div class="sig-name">................................................</div>
                <div class="sig-role">HRD / Penilai Kinerja</div>
            </div>

            <div class="sig-box">
                <div>Mengetahui &amp; Menyetujui,</div>
                <div class="sig-space"></div>
                <div class="sig-name">................................................</div>
                <div class="sig-role">Manager / Head of Department</div>
            </div>
        </div>

    </div>

    <script>
        // Auto trigger print dialog on page load
        window.onload = function() {
            setTimeout(function(){
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
