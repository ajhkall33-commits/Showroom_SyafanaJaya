<?php
if (!function_exists('indo_date_wwc')) {
    function indo_date_wwc($date) {
        if (empty($date) || $date == '0000-00-00') return '-';
        $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $dt = new DateTime($date);
        return $dt->format('d') . ' ' . $bulan[(int)$dt->format('m')] . ' ' . $dt->format('Y');
    }
}
$form            = $form ?? [];
$penilaian_list  = $penilaian_list ?? [];
$rekap_indikator = $rekap_indikator ?? [];
$summary         = $summary ?? [];

$avg_pct = floatval($summary['avg_persentase'] ?? 0);
$avg_val = floatval($summary['avg_total'] ?? 0);
if ($avg_pct >= 85)     { $pred = 'Istimewa';    $pred_color = '#11998e'; $pred_bg = '#d4edda'; }
elseif ($avg_pct >= 70) { $pred = 'Kompeten';    $pred_color = '#11998e'; $pred_bg = '#d4edda'; }
elseif ($avg_pct >= 55) { $pred = 'Cukup';       $pred_color = '#b8860b'; $pred_bg = '#fff3cd'; }
else                    { $pred = 'Perlu Dibina'; $pred_color = '#c0392b'; $pred_bg = '#f8d7da'; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan WWC - <?= htmlspecialchars($form['nama_peserta'] ?? '') ?></title>
    <style>
        :root { --primary: #0f3460; --accent: #1a73e8; }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            margin: 0;
            padding: 20px 36px;
            font-size: 13px;
            color: #222;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        /* ---- HEADER ---- */
        .page-header {
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .page-header img { height: 70px; }
        .page-header-text h2 {
            margin: 0 0 3px 0;
            font-size: 20px;
            color: var(--primary);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .page-header-text p { margin: 0; font-size: 12px; color: #555; }

        /* ---- INFO PESERTA ---- */
        .info-box {
            background: #f4f7fc;
            border: 1px solid #dce4f0;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 18px;
        }
        .info-grid { display: flex; gap: 30px; }
        .info-table { flex: 1; border-collapse: collapse; font-size: 13px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td:first-child { width: 130px; font-weight: 600; color: var(--primary); }
        .info-table td:nth-child(2) { width: 14px; }

        /* ---- STATS ROW ---- */
        .stats-row {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }
        .stat-card {
            flex: 1;
            border-radius: 8px;
            padding: 14px 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .stat-card .val { font-size: 26px; font-weight: 700; margin-bottom: 2px; }
        .stat-card .lbl { font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; color: #666; }
        .stat-blue   { background: #e8f0fe; border-color: #b3c9fd; color: #1a56db; }
        .stat-green  { background: #d4edda; border-color: #b8dac3; color: #155724; }
        .stat-yellow { background: #fff3cd; border-color: #ffdF7e; color: #856404; }
        .stat-red    { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }

        /* ---- SECTION TITLE ---- */
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 2px solid #e0e7f3;
            padding-bottom: 6px;
            margin: 18px 0 12px 0;
        }

        /* ---- TABLE ---- */
        table.report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 12px;
        }
        table.report-table th {
            background: var(--primary);
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
        }
        table.report-table th.center, table.report-table td.center { text-align: center; }
        table.report-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        table.report-table tr:nth-child(even) td { background: #f8f9fa; }
        table.report-table tfoot td {
            background: #e8f0fe !important;
            font-weight: 700;
            color: var(--primary);
            border-top: 2px solid #b3c9fd;
        }

        /* ---- ASSESSOR CARDS ---- */
        .assessor-item {
            border: 1px solid #e0e7f3;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 10px;
            break-inside: avoid;
        }
        .assessor-item.best { border-left: 4px solid #11998e; }
        .assessor-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
        .progress-bar { height: 7px; background: #e0e0e0; border-radius: 4px; overflow: hidden; margin-top: 4px; }
        .progress-fill { height: 100%; border-radius: 4px; }
        .fill-green  { background: linear-gradient(90deg, #11998e, #38ef7d); }
        .fill-yellow { background: linear-gradient(90deg, #f39c12, #f1c40f); }
        .fill-red    { background: linear-gradient(90deg, #e74c3c, #c0392b); }

        /* ---- REKOMENDASI ---- */
        .rekom-item {
            background: #f8f9fa;
            border-left: 3px solid var(--accent);
            padding: 10px 14px;
            margin-bottom: 8px;
            border-radius: 0 6px 6px 0;
            font-size: 12px;
        }
        .rekom-item strong { color: var(--primary); display: block; margin-bottom: 3px; }

        /* ---- PREDIKAT BADGE ---- */
        .predikat-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 13px;
        }

        /* ---- TTD AREA ---- */
        .ttd-area {
            display: flex;
            gap: 30px;
            margin-top: 30px;
            break-inside: avoid;
        }
        .ttd-box {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 12px 16px;
            text-align: center;
            font-size: 12px;
        }
        .ttd-box .ttd-label { font-weight: 600; color: var(--primary); margin-bottom: 60px; }
        .ttd-box .ttd-line { border-top: 1px solid #333; margin-top: 8px; padding-top: 4px; color: #555; }

        /* ---- PRINT ---- */
        .btn-print {
            padding: 9px 20px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-back {
            padding: 9px 20px;
            background: #6c757d;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin-right: 8px;
            text-decoration: none;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <!-- Toolbar (hidden on print) -->
    <div class="no-print" style="margin-bottom: 18px; display: flex; gap: 10px;">
        <a href="javascript:history.back()" class="btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn-print">🖨 Cetak / Simpan PDF</button>
    </div>

    <!-- ===== HEADER ===== -->
    <div class="page-header">
        <img src="<?= base_url('assets/ias.png') ?>" alt="Logo">
        <div class="page-header-text">
            <h2>Laporan Wawancara Kompetensi</h2>
            <p>Rekap Hasil Penilaian &bull; Dicetak: <?= date('d F Y, H:i') ?></p>
        </div>
    </div>

    <!-- ===== INFO PESERTA ===== -->
    <div class="info-box">
        <div class="info-grid">
            <table class="info-table">
                <tr><td>Nama Peserta</td><td>:</td><td><strong><?= htmlspecialchars($form['nama_peserta'] ?? '-') ?></strong></td></tr>
                <tr><td>NIK</td><td>:</td><td><?= htmlspecialchars($form['nik'] ?? '-') ?></td></tr>
                <tr><td>Jabatan</td><td>:</td><td><?= htmlspecialchars($form['jabatan'] ?? '-') ?></td></tr>
                <tr><td>Unit</td><td>:</td><td><?= htmlspecialchars($form['name_unit'] ?? '-') ?></td></tr>
            </table>
            <table class="info-table">
                <tr><td>Kode Form</td><td>:</td><td><?= htmlspecialchars($form['kode_form'] ?? '-') ?></td></tr>
                <tr><td>Nama Form</td><td>:</td><td><?= htmlspecialchars($form['nama_form'] ?? '-') ?></td></tr>
                <tr><td>Tanggal</td><td>:</td><td><?= indo_date_wwc($form['tanggal_penilaian'] ?? '') ?></td></tr>
                <tr><td>Lokasi</td><td>:</td><td><?= htmlspecialchars($form['lokasi'] ?? '-') ?></td></tr>
            </table>
        </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="val"><?= number_format($avg_val, 2) ?></div>
            <div class="lbl">Rata-rata Nilai</div>
        </div>
        <div class="stat-card stat-blue">
            <div class="val"><?= number_format($avg_pct, 1) ?>%</div>
            <div class="lbl">Rata-rata %</div>
        </div>
        <div class="stat-card stat-blue">
            <div class="val"><?= intval($summary['jumlah_assessor'] ?? 0) ?></div>
            <div class="lbl">Assessor</div>
        </div>
        <div class="stat-card" style="background:<?= $pred_bg ?>; border-color:<?= $pred_color ?>; color:<?= $pred_color ?>;">
            <div class="val"><?= $pred ?></div>
            <div class="lbl">Predikat Akhir</div>
        </div>
    </div>

    <!-- ===== REKAP INDIKATOR ===== -->
    <div class="section-title">📋 Rekap Nilai per Indikator</div>
    <?php if (empty($rekap_indikator)): ?>
        <p style="color:#888; text-align:center; padding:16px;">Belum ada data indikator.</p>
    <?php else:
        $total_skor = 0;
        $prev_kriteria = '';
    ?>
    <table class="report-table">
        <thead>
            <tr>
                <th class="center" style="width:5%">No</th>
                <th style="width:18%">Kriteria</th>
                <th>Indikator</th>
                <th class="center" style="width:9%">Bobot</th>
                <th class="center" style="width:11%">Avg Nilai</th>
                <th class="center" style="width:11%">Avg Skor</th>
                <th class="center" style="width:8%">Min</th>
                <th class="center" style="width:8%">Max</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($rekap_indikator as $ri):
                $total_skor += floatval($ri['avg_skor']);
                $skor_pct = floatval($ri['bobot']) > 0 ? (floatval($ri['avg_skor']) / floatval($ri['bobot'])) * 100 : 0;
                if ($skor_pct >= 70) $sc = '#155724'; elseif ($skor_pct >= 55) $sc = '#856404'; else $sc = '#721c24';
            ?>
            <tr>
                <td class="center"><?= $no ?></td>
                <td style="font-size:11px;"><?= htmlspecialchars($ri['nama_kriteria']) ?></td>
                <td>
                    <strong style="font-size:12px;">[<?= htmlspecialchars($ri['kode_indikator']) ?>] <?= htmlspecialchars($ri['nama_indikator']) ?></strong>
                </td>
                <td class="center"><span style="background:#e8f0fe;color:#1a56db;padding:2px 8px;border-radius:10px;font-weight:700;font-size:11px;"><?= floatval($ri['bobot'] ?? 1) ?></span></td>
                <td class="center" style="color:<?= $sc ?>;font-weight:700;"><?= number_format($ri['avg_nilai'] ?? 0, 2) ?></td>
                <td class="center" style="color:<?= $sc ?>;font-weight:700;"><?= number_format($ri['avg_skor'] ?? 0, 2) ?></td>
                <td class="center" style="color:#888;"><?= $ri['min_nilai'] ?? '-' ?></td>
                <td class="center" style="color:#888;"><?= $ri['max_nilai'] ?? '-' ?></td>
            </tr>
            <?php $no++; endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;">Total Skor Rata-rata</td>
                <td></td>
                <td class="center" style="color:<?= $pred_color ?>;"><?= number_format($total_skor, 2) ?></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>

    <!-- ===== PENILAIAN PER ASSESSOR ===== -->
    <div class="section-title">👥 Penilaian per Assessor</div>
    <?php if (empty($penilaian_list)): ?>
        <p style="color:#888; text-align:center; padding:16px;">Belum ada penilaian dari assessor.</p>
    <?php else:
        $max_val_list = max(array_column($penilaian_list, 'total_nilai') ?: [0]);
        foreach ($penilaian_list as $idx => $p):
            $pct = floatval($p['persentase']);
            $isBest = floatval($p['total_nilai']) == floatval($max_val_list) && floatval($max_val_list) > 0;
            if ($pct >= 70) { $fcls = 'fill-green'; $pc = '#155724'; }
            elseif ($pct >= 55) { $fcls = 'fill-yellow'; $pc = '#856404'; }
            else { $fcls = 'fill-red'; $pc = '#721c24'; }
    ?>
    <div class="assessor-item <?= $isBest ? 'best' : '' ?>">
        <div class="assessor-header">
            <div>
                <strong style="font-size:13px;"><?= htmlspecialchars($p['nama_assessor']) ?></strong>
                <small style="color:#888; margin-left:6px;"><?= htmlspecialchars($p['nik_assessor']) ?></small>
                <?php if ($isBest): ?><span style="background:#11998e;color:#fff;padding:2px 8px;border-radius:10px;font-size:10px;font-weight:700;margin-left:6px;">Tertinggi</span><?php endif; ?>
            </div>
            <div style="text-align:right;">
                <strong style="color:<?= $pc ?>; font-size:16px;"><?= number_format($pct, 2) ?>%</strong>
                <small style="display:block;color:#888;">Nilai: <?= number_format($p['total_nilai'], 2) ?></small>
            </div>
        </div>
        <div class="progress-bar">
            <div class="progress-fill <?= $fcls ?>" style="width:<?= min($pct, 100) ?>%"></div>
        </div>
        <?php if (!empty($p['kesimpulan'])): ?>
        <p style="margin:8px 0 0 0; font-size:12px; color:#555;"><em>Kesimpulan: <?= htmlspecialchars($p['kesimpulan']) ?></em></p>
        <?php endif; ?>
    </div>
    <?php endforeach; endif; ?>

    <!-- ===== REKOMENDASI ===== -->
    <?php $has_rekom = array_filter($penilaian_list, function($p) { return !empty($p['rekomendasi']); }); ?>
    <?php if (!empty($has_rekom)): ?>
    <div class="section-title">💡 Rekomendasi Assessor</div>
    <?php foreach ($penilaian_list as $p): if (!empty($p['rekomendasi'])): ?>
    <div class="rekom-item">
        <strong><?= htmlspecialchars($p['nama_assessor']) ?></strong>
        <?= nl2br(htmlspecialchars($p['rekomendasi'])) ?>
    </div>
    <?php endif; endforeach; ?>
    <?php endif; ?>

    <!-- ===== CATATAN FORM ===== -->
    <?php if (!empty($form['catatan'])): ?>
    <div class="section-title">📝 Catatan</div>
    <div style="background:#f8f9fa;border:1px solid #e0e7f3;border-radius:6px;padding:12px 16px;font-size:12px;color:#444;">
        <?= nl2br(htmlspecialchars($form['catatan'])) ?>
    </div>
    <?php endif; ?>

    <!-- ===== AREA TANDA TANGAN ===== -->
    <div class="ttd-area">
        <div class="ttd-box">
            <div class="ttd-label">Peserta</div>
            <div class="ttd-line"><?= htmlspecialchars($form['nama_peserta'] ?? '...') ?></div>
        </div>
        <?php foreach ($penilaian_list as $p): ?>
        <div class="ttd-box">
            <div class="ttd-label">Assessor</div>
            <div class="ttd-line"><?= htmlspecialchars($p['nama_assessor'] ?? '...') ?></div>
        </div>
        <?php endforeach; ?>
        <div class="ttd-box">
            <div class="ttd-label">Mengetahui</div>
            <div class="ttd-line">( ................................ )</div>
        </div>
    </div>

    <p style="text-align:center; color:#aaa; font-size:10px; margin-top:20px;">
        Dokumen ini dicetak secara otomatis dari sistem MPS &bull; <?= date('d F Y, H:i:s') ?>
    </p>

</body>
</html>
