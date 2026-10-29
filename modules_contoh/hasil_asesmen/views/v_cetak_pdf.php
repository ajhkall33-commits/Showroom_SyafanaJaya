<?php
if(!function_exists('indo_date_time_asesmen')) {
    function indo_date_time_asesmen($date) {
        if(empty($date) || $date == '0000-00-00 00:00:00' || $date == '0000-00-00') return '-';
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        
        $dt = new DateTime($date);
        $dayName = $hari[$dt->format('l')] ?? '';
        $day = $dt->format('d');
        $month = $bulan[(int)$dt->format('m')] ?? '';
        $year = $dt->format('Y');
        $time = $dt->format('H:i:s');
        return ($dayName ? $dayName . ', ' : '') . $day . ' ' . $month . ' ' . $year . ($time != '00:00:00' ? ' ' . $time : '');
    }
}

$p = $peserta ?? [];
$pres = $presensi_summary ?? [];
$score_cbt = (float)($avg_nilai_cbt ?? 0);
$score_wwc = (float)($avg_nilai_wwc ?? 0);
$score_pres = (float)($pres['skor_presensi'] ?? 0);
$total_skor = (float)($total_asesmen ?? 0);
$pred = $predikat ?? 'Cukup';

if ($total_skor >= 85) {
    $pred_color = '#15803d'; $pred_bg = '#dcfce7'; $pred_border = '#86efac';
} elseif ($total_skor >= 70) {
    $pred_color = '#1d4ed8'; $pred_bg = '#dbeafe'; $pred_border = '#93c5fd';
} elseif ($total_skor >= 55) {
    $pred_color = '#b45309'; $pred_bg = '#fef3c7'; $pred_border = '#fde68a';
} else {
    $pred_color = '#b91c1c'; $pred_bg = '#fee2e2'; $pred_border = '#fca5a5';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Asesmen - <?= htmlspecialchars($p['nama_peserta'] ?? '') ?></title>
    <style>
        :root {
            --color-benar: #d4edda;
            --color-benar-text: #155724;
            --color-salah: #f8d7da;
            --color-salah-text: #721c24;
            --color-kosong: #e2e3e5;
            --color-kosong-text: #383d41;
            --color-nilai: #cce5ff;
            --color-nilai-text: #004085;
            --color-lulus: #28a745;
            --color-tdklulus: #dc3545;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 24px 36px;
            font-size: 12px;
            color: #1e293b;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* HEADER */
        .report-header {
            display: flex;
            align-items: center;
            border-bottom: 3px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 18px;
            gap: 16px;
        }
        .report-header img {
            height: 65px;
            width: auto;
        }
        .report-header-text {
            flex: 1;
        }
        .report-header-text h2 {
            margin: 0 0 3px 0;
            font-size: 19px;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .report-header-text p {
            margin: 0;
            font-size: 12px;
            color: #475569;
        }

        /* BIODATA & OVERALL SCORE BOX */
        .hero-section {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }
        .biodata-card {
            flex: 1.4;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 12px 16px;
        }
        .biodata-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .biodata-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .biodata-table td.lbl {
            width: 110px;
            font-weight: 700;
            color: #334155;
        }
        .biodata-table td.sep { width: 10px; }
        .biodata-table td.val { font-weight: 600; color: #0f172a; }

        .score-summary-card {
            flex: 1.6;
            display: flex;
            gap: 8px;
        }
        .score-box {
            flex: 1;
            border-radius: 6px;
            padding: 10px 6px;
            text-align: center;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .score-box .val {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 2px;
            line-height: 1;
        }
        .score-box .lbl {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
        }
        .score-cbt { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
        .score-wwc { background: #f0fdfa; border-color: #99f6e4; color: #0f766e; }
        .score-pres { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .score-final {
            background: <?= $pred_bg ?>;
            border-color: <?= $pred_border ?>;
            color: <?= $pred_color ?>;
        }

        /* SECTION TITLE */
        .section-header {
            background: #0f172a;
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            padding: 6px 12px;
            border-radius: 4px;
            margin: 20px 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* CBT STATS BOXES */
        .stats-container {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .stat-box { 
            flex: 1;
            padding: 10px; 
            border-radius: 6px; 
            text-align: center; 
            border: 1px solid #cbd5e1; 
            background-color: #ffffff;
        }
        .stat-box span {
            display: block;
            font-size: 11px;
            margin-bottom: 4px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
        }
        .stat-box b { font-size: 18px; font-weight: 800; }
        .stat-box.benar { background-color: var(--color-benar); border-color: #c3e6cb; color: var(--color-benar-text); }
        .stat-box.benar span { color: var(--color-benar-text); }
        .stat-box.salah { background-color: var(--color-salah); border-color: #f5c6cb; color: var(--color-salah-text); }
        .stat-box.salah span { color: var(--color-salah-text); }
        .stat-box.kosong { background-color: var(--color-kosong); border-color: #d6d8db; color: var(--color-kosong-text); }
        .stat-box.kosong span { color: var(--color-kosong-text); }
        .stat-box.nilai { background-color: var(--color-nilai); border-color: #b8daff; color: var(--color-nilai-text); }
        .stat-box.nilai span { color: var(--color-nilai-text); }
        .stat-box.lulus { background-color: var(--color-lulus); border-color: #1e7e34; color: #ffffff; }
        .stat-box.lulus span { color: #f0fdf4; }
        .stat-box.gagal { background-color: var(--color-tdklulus); border-color: #bd2130; color: #ffffff; }
        .stat-box.gagal span { color: #fef2f2; }

        /* CBT QUESTION BOXES */
        .review-soal-item {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 10px;
            break-inside: avoid;
            background: #ffffff;
        }
        .review-soal-item.benar { border-color: #86efac; background: #f0fdf4; }
        .review-soal-item.salah { border-color: #fca5a5; background: #fef2f2; }
        .review-soal-item.kosong { border-color: #cbd5e1; background: #f8fafc; }
        
        .badge-user {
            background: #0284c7;
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 4px;
        }
        .badge-kunci {
            background: #16a34a;
            color: #ffffff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 4px;
        }
        .row-soal { display: flex; flex-wrap: wrap; margin-top: 8px; font-size: 12px; }
        .col-soal { width: 50%; margin-bottom: 5px; box-sizing: border-box; padding-right: 10px; }

        /* TABLES */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 11px;
        }
        .table-data th, .table-data td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
        }
        .table-data th {
            background: #1e293b;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
        }
        .table-data td.text-center { text-align: center; }
        .table-data td.text-right { text-align: right; }
        .table-data td.font-bold { font-weight: 700; }

        /* PRESENSI REPORT TABLE */
        .report-table-presensi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 11px;
        }
        .report-table-presensi th, .report-table-presensi td {
            border: 1px solid #cbd5e1;
            padding: 7px 6px;
            text-align: center;
            vertical-align: middle;
        }
        .report-table-presensi th {
            background: #1e293b;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
        }
        .report-table-presensi th.th-green { background: #16a34a; color: #fff; }
        .report-table-presensi th.th-red { background: #dc2626; color: #fff; }
        .report-table-presensi th.th-darkred { background: #991b1b; color: #fff; }
        .report-table-presensi th.th-tap { background: #b91c1c; color: #fff; }
        .report-table-presensi th.th-gray { background: #4b5563; color: #fff; }
        .report-table-presensi th.th-orange { background: #d97706; color: #fff; }
        .report-table-presensi th.th-yellow { background: #ca8a04; color: #fff; }
        .report-table-presensi th.th-blue { background: #0284c7; color: #fff; }
        .report-table-presensi th.th-purple { background: #7c3aed; color: #fff; }

        .banner-presensi {
            background-color: #f0fdf4; 
            border: 1px solid #bbf7d0; 
            border-left: 4px solid #16a34a; 
            border-radius: 4px; 
            padding: 7px 12px; 
            font-size: 11px; 
            margin-bottom: 12px; 
            color: #166534; 
            line-height: 1.4;
        }

        /* SIGNATURE SECTION */
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 320px;
            text-align: center;
            font-size: 11px;
        }
        .signature-space { height: 60px; }
        .signature-name {
            font-weight: 800;
            border-bottom: 1px solid #0f172a;
            padding-bottom: 2px;
            margin-bottom: 3px;
        }
        .signature-role { font-size: 10px; color: #475569; }

        /* RUNNING FOOTER ON EVERY PRINTED PAGE */
        @page {
            size: A4;
            margin: 10mm 12mm 14mm 12mm;
        }

        .print-running-footer {
            margin-top: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            font-size: 9px;
            color: #64748b;
        }

        @media print {
            body { 
                padding: 0; 
                margin-bottom: 10mm;
            }
            .no-print { display: none !important; }

            .print-running-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                margin-top: 0;
                border-top: 1px solid #94a3b8;
                padding-top: 4px;
                font-size: 8px;
                color: #475569;
                background: #ffffff;
                z-index: 9999;
            }
        }
    </style>
</head>
<body>

    <!-- REPORT HEADER -->
    <div class="report-header">
        <img src="<?= base_url('assets/ias.png') ?>" alt="Logo IAS">
        <div class="report-header-text">
            <h2>RAPOR ASESMEN</h2>
            <p>Rekapitulasi Komprehensif Ujian Komputer (CBT), Wawancara Kompetensi, dan Kedisiplinan Presensi</p>
            <div style="display:inline-block; background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; padding:3px 10px; border-radius:4px; font-weight:700; font-size:11px; margin-top:5px;">
                Periode Asesmen: <?= indo_date_time_asesmen($start_date) ?> s/d <?= indo_date_time_asesmen($end_date) ?>
            </div>
        </div>
    </div>

    <!-- BIODATA & OVERALL SCORE ROW -->
    <div class="hero-section">
        <div class="biodata-card">
            <table class="biodata-table">
                <tr>
                    <td class="lbl">Nama Peserta</td>
                    <td class="sep">:</td>
                    <td class="val"><?= htmlspecialchars($p['nama_peserta'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="lbl">NIK</td>
                    <td class="sep">:</td>
                    <td class="val"><?= htmlspecialchars($p['nik'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="lbl">Unit Kerja</td>
                    <td class="sep">:</td>
                    <td class="val"><?= htmlspecialchars($p['kode_unit'] ?? '-') ?> - <?= htmlspecialchars($p['name_unit'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="lbl">Jabatan</td>
                    <td class="sep">:</td>
                    <td class="val"><?= htmlspecialchars($p['nama_jabatan'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="lbl">Periode Asesmen</td>
                    <td class="sep">:</td>
                    <td class="val"><strong><?= indo_date_time_asesmen($start_date) ?></strong> s/d <strong><?= indo_date_time_asesmen($end_date) ?></strong></td>
                </tr>
                <tr>
                    <td class="lbl">Tgl Laporan</td>
                    <td class="sep">:</td>
                    <td class="val"><?= indo_date_time_asesmen(date('Y-m-d')) ?></td>
                </tr>
            </table>
        </div>

        <div class="score-summary-card">
            <div class="score-box score-cbt">
                <div class="val"><?= number_format($score_cbt, 1) ?></div>
                <div class="lbl">Nilai CBT</div>
            </div>
            <div class="score-box score-wwc">
                <div class="val"><?= number_format($score_wwc, 1) ?></div>
                <div class="lbl">Nilai Wawancara</div>
            </div>
            <div class="score-box score-pres">
                <div class="val"><?= number_format($score_pres, 1) ?>%</div>
                <div class="lbl">Skor Presensi</div>
            </div>
            <div class="score-box score-final">
                <div class="val"><?= number_format($total_skor, 1) ?></div>
                <div class="lbl">Nilai Akhir (<?= $pred ?>)</div>
            </div>
        </div>
    </div>

    <!-- BAGIAN 1: HASIL UJIAN CBT -->
    <div class="section-header">
        Bagian I: Hasil Ujian Asesmen (CBT) (Periode: <?= indo_date_time_asesmen($start_date) ?> s/d <?= indo_date_time_asesmen($end_date) ?>)
    </div>
    <?php if (!empty($cbt_list)): ?>
        <?php foreach ($cbt_list as $cbt): 
            $jml_benar = (int)($cbt['jumlah_benar'] ?? 0);
            $jml_kosong = (int)($cbt['jumlah_kosong'] ?? 0);
            $jml_soal = (int)($cbt['jumlah_soal'] ?? count($cbt['detail_jawaban'] ?? []));
            $jml_salah = max(0, $jml_soal - $jml_benar - $jml_kosong);
            $nilai_cbt = (float)($cbt['nilai'] ?? 0);
            $is_lulus = ($nilai_cbt >= 75);
        ?>
        <!-- CBT STATS BOXES -->
        <div class="stats-container">
            <div class="stat-box benar">
                <span>BENAR</span>
                <b><?= $jml_benar ?></b>
            </div>
            <div class="stat-box salah">
                <span>SALAH</span>
                <b><?= $jml_salah ?></b>
            </div>
            <div class="stat-box kosong">
                <span>KOSONG</span>
                <b><?= $jml_kosong ?></b>
            </div>
            <div class="stat-box nilai">
                <span>NILAI AKHIR</span>
                <b><?= number_format($nilai_cbt, 2) ?></b>
            </div>
            <div class="stat-box <?= $is_lulus ? 'lulus' : 'gagal' ?>">
                <span>STATUS</span>
                <b><?= $is_lulus ? 'LULUS' : 'TIDAK LULUS' ?></b>
                <div style="font-size:9px; opacity:0.9; margin-top:2px;">Passing Grade: 75</div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="background:#f8fafc; border:1px dashed #cbd5e1; padding:8px 12px; font-size:11px; color:#64748b; margin-bottom:12px;">
            <em>Belum ada data riwayat ujian CBT untuk personil ini pada periode terpilih.</em>
        </div>
    <?php endif; ?>

    <!-- BAGIAN 2: HASIL WAWANCARA KOMPETENSI (WWC) -->
    <div class="section-header">
        Bagian II: Hasil Penilaian Wawancara Kompetensi (WWC) (Periode: <?= indo_date_time_asesmen($start_date) ?> s/d <?= indo_date_time_asesmen($end_date) ?>)
    </div>
    
    <!-- DAFTAR ASESOR & KESIMPULAN REKOMENDASI -->
    <div style="margin-bottom:12px;">
        <div style="font-size:12px; color:#1e293b; background:#f8fafc; border:1px solid #e2e8f0; border-radius:4px; padding:6px 12px; margin-bottom:8px;">
            <strong><i class="fa fa-users"></i> Daftar Asesor Penilai:</strong> 
            <span style="color:#0f766e; font-weight:700;"><?= !empty($daftar_assessor) ? htmlspecialchars($daftar_assessor) : '-' ?></span>
        </div>

        <?php if (!empty($wwc_penilaian)): ?>
            <?php foreach ($wwc_penilaian as $wp): ?>
                <div style="background:#ffffff; border:1px solid #cbd5e1; border-left:4px solid #0f766e; border-radius:4px; padding:8px 12px; margin-bottom:6px;">
                    <div style="font-weight:700; color:#0f172a; font-size:12px; margin-bottom:4px; display:flex; justify-content:space-between; align-items:center;">
                        <span><i class="fa fa-user-circle text-info"></i> <?= htmlspecialchars($wp['nama_assessor'] ?? 'Asesor') ?> <small style="color:#64748b; font-weight:normal;">(<?= htmlspecialchars($wp['nik_assessor'] ?? '-') ?> - <?= htmlspecialchars($wp['jabatan_assessor'] ?? 'Asesor') ?>)</small></span>
                        <span style="color:#0f766e; font-size:12px; background:#f0fdfa; padding:2px 8px; border-radius:4px; border:1px solid #ccfbf1;">
                            Nilai Wawancara: <strong><?= number_format((float)$wp['total_nilai'], 2) ?></strong> (<?= number_format((float)$wp['persentase'], 1) ?>%)
                        </span>
                    </div>
                    <div style="font-size:11.5px; color:#334155; margin-bottom:3px; line-height:1.4;">
                        <strong>Kesimpulan Asesor:</strong> <?= !empty(trim($wp['kesimpulan'] ?? '')) ? htmlspecialchars($wp['kesimpulan']) : '-' ?>
                    </div>
                    <div style="font-size:11.5px; color:#334155; line-height:1.4;">
                        <strong>Rekomendasi Asesor:</strong> <?= !empty(trim($wp['rekomendasi'] ?? '')) ? htmlspecialchars($wp['rekomendasi']) : '-' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="background:#f8fafc; border:1px dashed #cbd5e1; padding:8px 12px; font-size:11px; color:#64748b; margin-bottom:12px;">
                <em>Belum ada data penilaian wawancara untuk personil ini pada periode terpilih.</em>
            </div>
        <?php endif; ?>
    </div>

    <!-- BAGIAN 3: REKAPITULASI PRESENSI & KEDISIPLINAN -->
    <div class="section-header">
        Bagian III: Rekapitulasi Presensi &amp; Kedisiplinan Kerja (Periode: <?= indo_date_time_asesmen($start_date) ?> s/d <?= indo_date_time_asesmen($end_date) ?>)
    </div>
    
    <!-- STATUS EXPLANATION BANNER -->
    <div class="banner-presensi">
        <strong>Ketentuan Status:</strong> 
        Kolom <strong>MASUK (HADIR)</strong> mencakup <em>Hadir Fisik + Izin/Cuti Resmi + Sakit</em> (dianggap <u>MASUK</u> karena memiliki izin yang sah). 
        Kolom <strong>TIDAK HADIR</strong> khusus menghitung <em>TAP (Tidak Check Out) + A (Alpha) + UL (Unpaid Leave)</em>.
    </div>

    <table class="report-table-presensi">
        <thead>
            <tr>
                <th width="30">NO</th>
                <th width="50">UNIT</th>
                <th width="90">NIK</th>
                <th>NAMA KARYAWAN</th>
                <th>JABATAN</th>
                <th width="45">TOTAL</th>
                <th width="50" class="th-green" title="Total Masuk (Hadir Fisik + Cuti + Sakit)">MASUK</th>
                <th width="45" class="th-red">TELAT</th>
                <th width="55" class="th-darkred" title="Total Tidak Hadir: TAP + Alpha + UL">TDK HADIR</th>
                <th width="40" class="th-tap" title="Tidak Absen Pulang (Tidak Hadir)">TAP</th>
                <th width="35" class="th-gray" title="Absence (Tidak Hadir)">A</th>
                <th width="35" class="th-orange" title="Unpaid Leave (Tidak Hadir)">UL</th>
                <th width="45" class="th-yellow" title="Cuti & Izin Resmi (Dianggap Masuk)">IZIN</th>
                <th width="45" class="th-blue" title="Izin Sakit (Dianggap Masuk)">SAKIT</th>
                <th width="40" class="th-purple">OFF</th>
                <th width="55" style="background-color:#15803d; color:#fff;">% HADIR</th>
                <th width="55" style="background-color:#0284c7; color:#fff;">% TEPAT</th>
                <th width="55" style="background-color:#0f172a; color:#fff;">TOTAL %</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-bold">1</td>
                <td class="font-bold text-primary"><?= htmlspecialchars($p['kode_unit'] ?? '-') ?></td>
                <td><?= htmlspecialchars($p['nik'] ?? '-') ?></td>
                <td style="text-align:left; font-weight:700;"><?= htmlspecialchars($p['nama_peserta'] ?? '-') ?></td>
                <td style="text-align:left;"><?= htmlspecialchars($p['nama_jabatan'] ?? '-') ?></td>
                <td class="font-bold"><?= $pres['total_record'] ?? 0 ?></td>
                <td class="font-bold" style="background-color:#f0fdf4; color:#15803d;"><?= $pres['total_hadir'] ?? 0 ?></td>
                <td class="font-bold" style="background-color:#fef2f2; color:#dc2626;"><?= $pres['total_terlambat'] ?? 0 ?><?= ($pres['total_terlambat'] > 0) ? 'x' : '' ?></td>
                <td class="font-bold" style="background-color:#fee2e2; color:#991b1b;"><?= $pres['total_tidak_hadir'] ?? 0 ?></td>
                <td style="color:#b91c1c; font-weight:600;"><?= $pres['total_tap'] ?? 0 ?></td>
                <td style="color:#4b5563; font-weight:600;"><?= $pres['total_alpha'] ?? 0 ?></td>
                <td style="color:#d97706; font-weight:600;"><?= $pres['total_ul'] ?? 0 ?></td>
                <td style="color:#b45309; font-weight:600;"><?= $pres['total_izin'] ?? 0 ?></td>
                <td style="color:#0284c7; font-weight:600;"><?= $pres['total_sakit'] ?? 0 ?></td>
                <td style="color:#7c3aed; font-weight:600;"><?= $pres['total_off'] ?? 0 ?></td>
                <td class="font-bold" style="background-color:#dcfce7; color:#15803d;"><?= number_format((float)($pres['persen_kehadiran'] ?? 0), 1) ?>%</td>
                <td class="font-bold" style="background-color:#e0f2fe; color:#0369a1;"><?= number_format((float)($pres['persen_tepat'] ?? 0), 1) ?>%</td>
                <td class="font-bold" style="background-color:#0f172a; color:#ffffff;"><?= number_format((float)($pres['skor_presensi'] ?? 0), 1) ?>%</td>
            </tr>
        </tbody>
    </table>

    <!-- SIGNATURE SECTION -->
    <div class="signature-section">
        <div class="signature-box">
            <p style="margin-bottom:4px;">Tangerang, <?= indo_date_time_asesmen(date('Y-m-d')) ?></p>
            <p style="margin:0 0 4px 0; font-weight:700;">Mengetahui,</p>
            <p class="signature-role" style="font-weight:700; margin:0;">IASS CENGKARENG OPERATION &amp; MAINTENANCE NON TERMINAL SENIOR MANAGER</p>
            <div class="signature-space"></div>
            <div class="signature-name">Muh. Jupri</div>
        </div>
    </div>

    <!-- RUNNING FOOTER (MUNCUL DI SETIAP HALAMAN CETAK) -->
    <div class="print-running-footer">
        <div>
            &bull; <?= htmlspecialchars($p['nama_peserta'] ?? '-') ?> (NIK: <?= htmlspecialchars($p['nik'] ?? '-') ?>) &bull; <strong>Periode:</strong> <?= indo_date_time_asesmen($start_date) ?> s/d <?= indo_date_time_asesmen($end_date) ?>
        </div>
        <div>
            Tanggal Cetak: <strong><?= indo_date_time_asesmen(date('Y-m-d')) ?> <?= date('H:i:s') ?> WIB</strong>
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
