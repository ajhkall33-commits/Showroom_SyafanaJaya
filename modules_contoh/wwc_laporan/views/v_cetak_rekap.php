<?php
if (!function_exists('indo_date_wwc')) {
    function indo_date_wwc($date) {
        if (empty($date) || $date == '0000-00-00') return '-';
        $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $dt = new DateTime($date);
        return $dt->format('d') . ' ' . $bulan[(int)$dt->format('m')] . ' ' . $dt->format('Y');
    }
}
function wwc_predikat($pct) {
    if ($pct >= 85)     return ['label' => 'Istimewa',    'color' => '#155724', 'bg' => '#d4edda'];
    elseif ($pct >= 70) return ['label' => 'Kompeten',    'color' => '#155724', 'bg' => '#d4edda'];
    elseif ($pct >= 55) return ['label' => 'Cukup',       'color' => '#856404', 'bg' => '#fff3cd'];
    else                return ['label' => 'Perlu Dibina', 'color' => '#721c24', 'bg' => '#f8d7da'];
}
$list   = $list   ?? [];
$filter = $filter ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan WWC</title>
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
        .page { page-break-after: always; padding-bottom: 40px; margin-bottom: 40px; }
        .page:last-child { page-break-after: auto; margin-bottom: 0; padding-bottom: 0; }

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
        .page-header-text h2 { margin: 0 0 3px 0; font-size: 20px; color: var(--primary); text-transform: uppercase; }
        .page-header-text p { margin: 0; font-size: 12px; color: #555; }

        /* ---- COVER TABLE ---- */
        .cover-meta { margin-bottom: 18px; font-size: 13px; }
        .cover-meta span { font-weight: 700; color: var(--primary); }

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

        /* ---- INFO BOX ---- */
        .info-box {
            background: #f4f7fc;
            border: 1px solid #dce4f0;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 16px;
        }
        .info-grid { display: flex; gap: 30px; }
        .info-table { flex: 1; border-collapse: collapse; font-size: 13px; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td:first-child { width: 130px; font-weight: 600; color: var(--primary); }
        .info-table td:nth-child(2) { width: 14px; }

        /* ---- STATS ---- */
        .stats-row { display: flex; gap: 10px; margin-bottom: 16px; }
        .stat-card { flex: 1; border-radius: 8px; padding: 12px 8px; text-align: center; border: 1px solid #ddd; }
        .stat-card .val { font-size: 22px; font-weight: 700; margin-bottom: 2px; }
        .stat-card .lbl { font-size: 10px; text-transform: uppercase; letter-spacing: 0.4px; color: #666; }
        .stat-blue { background: #e8f0fe; border-color: #b3c9fd; color: #1a56db; }

        /* ---- SECTION TITLE ---- */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 1px solid #dce4f0;
            padding-bottom: 5px;
            margin: 14px 0 10px 0;
        }

        /* ---- ASSESSOR ---- */
        .assessor-item {
            border: 1px solid #e0e7f3;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 8px;
            break-inside: avoid;
        }
        .assessor-item.best { border-left: 4px solid #11998e; }
        .progress-bar { height: 6px; background: #e0e0e0; border-radius: 4px; overflow: hidden; margin-top: 4px; }
        .progress-fill { height: 100%; border-radius: 4px; }
        .fill-green  { background: linear-gradient(90deg, #11998e, #38ef7d); }
        .fill-yellow { background: linear-gradient(90deg, #f39c12, #f1c40f); }
        .fill-red    { background: linear-gradient(90deg, #e74c3c, #c0392b); }

        /* ---- REKOM ---- */
        .rekom-item {
            background: #f8f9fa;
            border-left: 3px solid var(--accent);
            padding: 8px 12px;
            margin-bottom: 6px;
            border-radius: 0 6px 6px 0;
            font-size: 12px;
        }
        .rekom-item strong { color: var(--primary); display: block; margin-bottom: 2px; }

        /* ---- TTD ---- */
        .ttd-area { display: flex; gap: 24px; margin-top: 24px; break-inside: avoid; }
        .ttd-box { flex: 1; border: 1px solid #ccc; border-radius: 6px; padding: 10px 14px; text-align: center; font-size: 11px; }
        .ttd-box .ttd-label { font-weight: 700; color: var(--primary); margin-bottom: 50px; }
        .ttd-box .ttd-line { border-top: 1px solid #333; padding-top: 4px; color: #555; }

        /* ---- PRINT ---- */
        .btn-print { padding: 9px 20px; background: var(--primary); color: #fff; border: none; border-radius: 5px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-back { padding: 9px 20px; background: #6c757d; color: #fff; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; margin-right: 8px; text-decoration: none; }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <!-- Toolbar -->
    <div class="no-print" style="margin-bottom: 18px; display: flex; gap: 10px;">
        <a href="javascript:history.back()" class="btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn-print">🖨 Cetak / Simpan PDF</button>
    </div>

    <!-- ===== HALAMAN COVER / REKAP GLOBAL ===== -->
    <div class="page">
        <div class="page-header">
            <img src="<?= base_url('assets/ias.png') ?>" alt="Logo">
            <div class="page-header-text">
                <h2>Rekapitulasi Laporan Wawancara Kompetensi</h2>
                <p>Seluruh Peserta &bull; Dicetak: <?= date('d F Y, H:i') ?></p>
            </div>
        </div>

        <div class="cover-meta">
            <span>Filter:</span>
            Unit: <?= !empty($filter['id_unit']) ? $filter['id_unit'] : 'Semua Unit' ?> &bull;
            Periode: <?= !empty($filter['tgl_dari']) ? indo_date_wwc($filter['tgl_dari']) : '-' ?> s/d <?= !empty($filter['tgl_sampai']) ? indo_date_wwc($filter['tgl_sampai']) : '-' ?> &bull;
            Total Data: <strong><?= count($list) ?> form</strong>
        </div>

        <table class="report-table">
            <thead>
                <tr>
                    <th class="center" style="width:5%">No</th>
                    <th style="width:22%">Nama Peserta</th>
                    <th style="width:12%">NIK</th>
                    <th style="width:15%">Unit</th>
                    <th style="width:13%">Jabatan</th>
                    <th style="width:10%">Tanggal</th>
                    <th class="center" style="width:8%">Assessor</th>
                    <th class="center" style="width:8%">Rata %</th>
                    <th class="center" style="width:10%">Predikat</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($list as $row):
                    $pct = floatval($row['rata_persentase'] ?? 0);
                    $pr  = wwc_predikat($pct);
                ?>
                <tr>
                    <td class="center"><?= $no ?></td>
                    <td><strong><?= htmlspecialchars($row['nama_peserta'] ?? '-') ?></strong><br><small style="color:#888;"><?= htmlspecialchars($row['kode_form'] ?? '') ?></small></td>
                    <td><?= htmlspecialchars($row['nik'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['name_unit'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['name_role'] ?? '-') ?></td>
                    <td><?= indo_date_wwc($row['tanggal_penilaian'] ?? '') ?></td>
                    <td class="center"><?= intval($row['jumlah_penilaian']) ?>/<?= intval($row['jumlah_assessor']) ?></td>
                    <td class="center" style="font-weight:700; color:<?= $pr['color'] ?>;"><?= number_format($pct, 1) ?>%</td>
                    <td class="center">
                        <span style="background:<?= $pr['bg'] ?>;color:<?= $pr['color'] ?>;padding:3px 10px;border-radius:10px;font-weight:700;font-size:11px;"><?= $pr['label'] ?></span>
                    </td>
                </tr>
                <?php $no++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- END COVER PAGE -->

    <!-- ===== HALAMAN PER PESERTA ===== -->
    <?php foreach ($list as $row):
        $pct    = floatval($row['rata_persentase'] ?? 0);
        $val    = floatval($row['rata_nilai'] ?? 0);
        $pr     = wwc_predikat($pct);
        $pl     = $row['penilaian_list'] ?? [];
        $ri_list = $row['rekap_indikator'] ?? [];
        $max_p  = !empty($pl) ? max(array_column($pl, 'total_nilai') ?: [0]) : 0;
        $has_rekom = array_filter($pl, function($p) { return !empty($p['rekomendasi']); });
    ?>
    <div class="page">

        <!-- Header -->
        <div class="page-header">
            <img src="<?= base_url('assets/ias.png') ?>" alt="Logo">
            <div class="page-header-text">
                <h2>Laporan Wawancara Kompetensi</h2>
                <p><?= htmlspecialchars($row['kode_form'] ?? '') ?> &bull; <?= indo_date_wwc($row['tanggal_penilaian'] ?? '') ?></p>
            </div>
        </div>

        <!-- Info Peserta -->
        <div class="info-box">
            <div class="info-grid">
                <table class="info-table">
                    <tr><td>Nama Peserta</td><td>:</td><td><strong><?= htmlspecialchars($row['nama_peserta'] ?? '-') ?></strong></td></tr>
                    <tr><td>NIK</td><td>:</td><td><?= htmlspecialchars($row['nik'] ?? '-') ?></td></tr>
                    <tr><td>Jabatan</td><td>:</td><td><?= htmlspecialchars($row['name_role'] ?? '-') ?></td></tr>
                    <tr><td>Unit</td><td>:</td><td><?= htmlspecialchars($row['name_unit'] ?? '-') ?></td></tr>
                </table>
                <table class="info-table">
                    <tr><td>Kode Form</td><td>:</td><td><?= htmlspecialchars($row['kode_form'] ?? '-') ?></td></tr>
                    <tr><td>Nama Form</td><td>:</td><td><?= htmlspecialchars($row['nama_form'] ?? '-') ?></td></tr>
                    <tr><td>Tanggal</td><td>:</td><td><?= indo_date_wwc($row['tanggal_penilaian'] ?? '') ?></td></tr>
                    <tr><td>Lokasi</td><td>:</td><td><?= htmlspecialchars($row['lokasi'] ?? '-') ?></td></tr>
                </table>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card stat-blue">
                <div class="val"><?= number_format($val, 2) ?></div>
                <div class="lbl">Rata-rata Nilai</div>
            </div>
            <div class="stat-card stat-blue">
                <div class="val"><?= number_format($pct, 1) ?>%</div>
                <div class="lbl">Rata-rata %</div>
            </div>
            <div class="stat-card stat-blue">
                <div class="val"><?= intval($row['jumlah_penilaian']) ?>/<?= intval($row['jumlah_assessor']) ?></div>
                <div class="lbl">Assessor Selesai</div>
            </div>
            <div class="stat-card" style="background:<?= $pr['bg'] ?>;border-color:<?= $pr['color'] ?>;color:<?= $pr['color'] ?>;">
                <div class="val"><?= $pr['label'] ?></div>
                <div class="lbl">Predikat</div>
            </div>
        </div>

        <!-- Rekap Indikator -->
        <div class="section-title">📋 Rekap Nilai per Indikator</div>
        <?php if (empty($ri_list)): ?>
            <p style="color:#888;text-align:center;padding:10px;">Tidak ada data indikator.</p>
        <?php else: $total_skor = 0; ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th class="center" style="width:5%">No</th>
                    <th style="width:18%">Kriteria</th>
                    <th>Indikator</th>
                    <th class="center" style="width:9%">Bobot</th>
                    <th class="center" style="width:11%">Avg Nilai</th>
                    <th class="center" style="width:11%">Avg Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php $no2 = 1; foreach ($ri_list as $ri):
                    $total_skor += floatval($ri['avg_skor']);
                    $sp = floatval($ri['bobot']) > 0 ? (floatval($ri['avg_skor']) / floatval($ri['bobot'])) * 100 : 0;
                    $sc = $sp >= 70 ? '#155724' : ($sp >= 55 ? '#856404' : '#721c24');
                ?>
                <tr>
                    <td class="center"><?= $no2 ?></td>
                    <td style="font-size:11px;"><?= htmlspecialchars($ri['nama_kriteria']) ?></td>
                    <td><strong style="font-size:12px;">[<?= htmlspecialchars($ri['kode_indikator']) ?>] <?= htmlspecialchars($ri['nama_indikator']) ?></strong></td>
                    <td class="center"><span style="background:#e8f0fe;color:#1a56db;padding:2px 6px;border-radius:8px;font-weight:700;font-size:11px;"><?= number_format($ri['bobot'], 1) ?>%</span></td>
                    <td class="center" style="color:<?= $sc ?>;font-weight:700;"><?= number_format($ri['avg_nilai'] ?? 0, 2) ?></td>
                    <td class="center" style="color:<?= $sc ?>;font-weight:700;"><?= number_format($ri['avg_skor'] ?? 0, 2) ?></td>
                </tr>
                <?php $no2++; endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;font-weight:700;background:#e8f0fe;color:var(--primary);">Total Skor</td>
                    <td></td>
                    <td class="center" style="background:#e8f0fe;font-weight:700;color:<?= $pr['color'] ?>;"><?= number_format($total_skor, 2) ?></td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>

        <!-- Penilaian per Assessor -->
        <div class="section-title">👥 Penilaian per Assessor</div>
        <?php if (empty($pl)): ?>
            <p style="color:#888;text-align:center;padding:10px;">Belum ada penilaian.</p>
        <?php else: foreach ($pl as $p):
            $ppct = floatval($p['persentase']);
            $isBest = floatval($p['total_nilai']) == floatval($max_p) && floatval($max_p) > 0;
            if ($ppct >= 70) { $fcls = 'fill-green'; $pc = '#155724'; }
            elseif ($ppct >= 55) { $fcls = 'fill-yellow'; $pc = '#856404'; }
            else { $fcls = 'fill-red'; $pc = '#721c24'; }
        ?>
        <div class="assessor-item <?= $isBest ? 'best' : '' ?>">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                <div>
                    <strong style="font-size:13px;"><?= htmlspecialchars($p['nama_assessor']) ?></strong>
                    <small style="color:#888;margin-left:6px;"><?= htmlspecialchars($p['nik_assessor']) ?></small>
                    <?php if ($isBest): ?><span style="background:#11998e;color:#fff;padding:1px 7px;border-radius:8px;font-size:10px;font-weight:700;margin-left:6px;">Tertinggi</span><?php endif; ?>
                </div>
                <strong style="color:<?= $pc ?>;font-size:15px;"><?= number_format($ppct, 2) ?>% <small style="font-size:11px;color:#888;">(<?= number_format($p['total_nilai'], 2) ?>)</small></strong>
            </div>
            <div class="progress-bar">
                <div class="progress-fill <?= $fcls ?>" style="width:<?= min($ppct, 100) ?>%"></div>
            </div>
            <?php if (!empty($p['kesimpulan'])): ?>
            <p style="margin:6px 0 0 0;font-size:11px;color:#555;"><em><?= htmlspecialchars($p['kesimpulan']) ?></em></p>
            <?php endif; ?>
        </div>
        <?php endforeach; endif; ?>

        <!-- Rekomendasi -->
        <?php if (!empty($has_rekom)): ?>
        <div class="section-title">💡 Rekomendasi</div>
        <?php foreach ($pl as $p): if (!empty($p['rekomendasi'])): ?>
        <div class="rekom-item">
            <strong><?= htmlspecialchars($p['nama_assessor']) ?></strong>
            <?= nl2br(htmlspecialchars($p['rekomendasi'])) ?>
        </div>
        <?php endif; endforeach; endif; ?>

        <!-- TTD -->
        <div class="ttd-area">
            <div class="ttd-box">
                <div class="ttd-label">Peserta</div>
                <div class="ttd-line"><?= htmlspecialchars($row['nama_peserta'] ?? '...') ?></div>
            </div>
            <?php foreach ($pl as $p): ?>
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

        <p style="text-align:center;color:#aaa;font-size:10px;margin-top:14px;">
            Dokumen ini dicetak secara otomatis dari sistem MPS &bull; <?= date('d F Y, H:i:s') ?>
        </p>

    </div>
    <!-- END PAGE PESERTA -->
    <?php endforeach; ?>

    <?php if (empty($list)): ?>
    <div style="text-align:center;padding:60px 20px;background:#f8f9fa;border-radius:10px;border:1px dashed #ccc;">
        <h3 style="color:#888;">Tidak ada data yang ditemukan.</h3>
        <p style="color:#aaa;">Coba ubah filter dan coba lagi.</p>
    </div>
    <?php endif; ?>

</body>
</html>
