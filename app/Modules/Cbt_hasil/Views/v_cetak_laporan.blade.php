<?php
if(!function_exists('indo_date_time')) {
    function indo_date_time($date) {
        if(empty($date) || $date == '0000-00-00 00:00:00') return '-';
        $bulan = array (
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $hari = array('Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu');
        
        $dt = new DateTime($date);
        $dayName = $hari[$dt->format('l')];
        $day = $dt->format('d');
        $month = $bulan[(int)$dt->format('m')];
        $year = $dt->format('Y');
        $time = $dt->format('H:i:s');
        return $dayName . ', ' . $day . ' ' . $month . ' ' . $year . ' ' . $time;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan CBT</title>
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
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            background: #fff; 
            margin: 0; 
            padding: 20px 40px; 
            font-size: 14px; 
            color: #333;
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
        }
        .page { 
            page-break-after: always; 
            margin-bottom: 40px; 
            padding-bottom: 40px;
        }
        .page:last-child { 
            page-break-after: auto; 
            margin-bottom: 0; 
            padding-bottom: 0; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 3px solid #2c3e50; 
            padding-bottom: 15px; 
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 24px;
            color: #2c3e50;
            letter-spacing: 1px;
        }
        .header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: normal;
            color: #555;
            text-transform: uppercase;
        }
        
        /* Layout Info Peserta */
        .info-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
            gap: 25px;
        }
        .foto-awal { 
            width: 130px; 
            height: 170px; 
            object-fit: cover; 
            border: 2px solid #ecf0f1; 
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .foto-placeholder {
            width: 130px; 
            height: 170px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            background: #f8f9fa; 
            border: 2px dashed #ddd;
            border-radius: 8px;
            color: #aaa;
        }
        .info-details {
            flex-grow: 1;
        }
        .info-table { 
            width: 100%; 
            margin-bottom: 15px; 
            font-size: 15px;
        }
        .info-table td { 
            padding: 6px 0; 
            vertical-align: top; 
        }
        .info-table td:first-child {
            width: 140px;
            font-weight: 600;
            color: #2c3e50;
        }
        .info-table td:nth-child(2) {
            width: 15px;
        }
        
        /* Stats Boxes */
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }
        .stat-box { 
            flex: 1;
            min-width: 90px;
            padding: 12px 10px; 
            border-radius: 8px; 
            text-align: center; 
            border: 1px solid #ddd; 
            background-color: #fff;
        }
        .stat-box span {
            display: block;
            font-size: 12px;
            margin-bottom: 4px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
        }
        .stat-box b {
            font-size: 20px;
        }
        
        /* Colors for stat boxes */
        .stat-box.benar { background-color: var(--color-benar); border-color: #c3e6cb; color: var(--color-benar-text); }
        .stat-box.benar span { color: var(--color-benar-text); }
        
        .stat-box.salah { background-color: var(--color-salah); border-color: #f5c6cb; color: var(--color-salah-text); }
        .stat-box.salah span { color: var(--color-salah-text); }
        
        .stat-box.kosong { background-color: var(--color-kosong); border-color: #d6d8db; color: var(--color-kosong-text); }
        .stat-box.kosong span { color: var(--color-kosong-text); }
        
        .stat-box.nilai { background-color: var(--color-nilai); border-color: #b8daff; color: var(--color-nilai-text); }
        .stat-box.nilai span { color: var(--color-nilai-text); }
        
        .stat-box.lulus { background-color: var(--color-lulus); border-color: #1e7e34; color: #fff; }
        .stat-box.lulus span { color: #e9ecef; }
        
        .stat-box.gagal { background-color: var(--color-tdklulus); border-color: #bd2130; color: #fff; }
        .stat-box.gagal span { color: #e9ecef; }

        /* Review soal CSS */
        .review-soal-item { border:1px solid #dee2e6; border-radius:8px; padding:12px 16px; margin-bottom:10px; break-inside: avoid; }
        .review-soal-item.benar { border-color:#27ae60; background:#f0fdf4; }
        .review-soal-item.salah { border-color:#e74c3c; background:#fff5f5; }
        .review-soal-item.kosong{ border-color:#aaa; background:#f9f9f9; }
        .opsi-review { display:inline-block; padding:3px 10px; border-radius:6px; font-weight:700; font-size:13px; margin:0 4px; }
        .opsi-user  { background:#d1e7ff; color:#1565C0; }
        .opsi-kunci { background:#d1fae5; color:#065f46; }
        .badge-primary { background:#007bff; color:white; padding:3px 6px; border-radius:4px; font-size:11px; }
        .badge-success { background:#28a745; color:white; padding:3px 6px; border-radius:4px; font-size:11px; }
        .row-soal { display: flex; flex-wrap: wrap; margin-top: 8px; font-size: 13px; }
        .col-soal { width: 50%; margin-bottom: 6px; box-sizing: border-box; padding-right: 10px; }

        /* Pelanggaran Table */
        .section-title {
            margin: 0 0 12px 0; 
            border-bottom: 2px solid #ecf0f1; 
            padding-bottom: 8px;
            font-size: 16px;
            color: #2c3e50;
            font-weight: bold;
        }
        .pelanggaran-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            font-size: 13px;
        }
        .pelanggaran-table th, .pelanggaran-table td { 
            border: 1px solid #bdc3c7; 
            padding: 10px; 
        }
        .pelanggaran-table th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: 600;
        }
        .pelanggaran-table td {
            vertical-align: middle;
        }
        .foto-bukti { 
            width: 140px; 
            height: auto; 
            border: 1px solid #ddd; 
            border-radius: 4px;
        }
        .status-aman {
            display: inline-block;
            padding: 10px 15px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            font-weight: 600;
            width: 100%;
            box-sizing: border-box;
        }
        .btn-print { 
            padding: 10px 20px; 
            font-size: 16px; 
            cursor: pointer; 
            background: #3498db; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-print:hover {
            background: #2980b9;
        }
        @media print {
            body { padding: 0; }
            .page { border-bottom: none; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body onload="setTimeout(function(){ window.print(); }, 500);">
    <div style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" class="btn-print">Print Laporan</button>
    </div>
    
    <?php foreach($hasil_list as $h): ?>
    <div class="page">
        <div class="header">
            <h2>HASIL UJIAN ASESMEN (CBT)</h2>
        </div>
        
        <div class="info-container">
            <div>
                <?php if(!empty($h['foto_awal'])): 
                    $foto_awal_url = (strpos($h['foto_awal'], 'upload/') === 0) ? url($h['foto_awal']) : url('upload/foto_awal_ujian/' . $h['foto_awal']);
                ?>
                    <img src="<?= $foto_awal_url ?>" class="foto-awal" alt="Foto Peserta">
                <?php else: ?>
                    <div class="foto-placeholder">Tidak Ada Foto</div>
                <?php endif; ?>
            </div>
            
            <div class="info-details">
                <table class="info-table">
                    <tr><td>Nama Peserta</td><td>:</td><td><?= htmlspecialchars($h['nama_peserta'] ?? '-') ?></td></tr>
                    <tr><td>NIK</td><td>:</td><td><?= htmlspecialchars($h['nik'] ?? '-') ?></td></tr>
                    <tr><td>Jabatan</td><td>:</td><td><?= htmlspecialchars($h['jabatan'] ?? '-') ?></td></tr>
                    <tr><td>Unit</td><td>:</td><td><?= htmlspecialchars($h['name_unit'] ?? '-') ?></td></tr>
                    <?php
                        $start = new DateTime($h['tanggal_mulai']);
                        $end = new DateTime($h['tanggal_selesai']);
                        $diff = $start->diff($end);
                        $durasi = '';
                        if($diff->h > 0) $durasi .= $diff->h . ' Jam ';
                        if($diff->i > 0) $durasi .= $diff->i . ' Menit ';
                        if($diff->s > 0) $durasi .= $diff->s . ' Detik';
                        if(empty($durasi)) $durasi = '-';
                    ?>
                    <tr><td>Waktu Mulai</td><td>:</td><td><?= indo_date_time($h['tanggal_mulai']) ?></td></tr>
                    <tr><td>Waktu Selesai</td><td>:</td><td><?= indo_date_time($h['tanggal_selesai']) ?></td></tr>
                    <tr><td>Durasi Pengerjaan</td><td>:</td><td><?= $durasi ?></td></tr>
                </table>
                
                <div class="stats-container">
                    <div class="stat-box benar">
                        <span>Benar</span>
                        <b><?= $h['jumlah_benar'] ?></b>
                    </div>
                    <div class="stat-box salah">
                        <span>Salah</span>
                        <b><?= $h['jumlah_selesai'] - $h['jumlah_benar'] ?></b>
                    </div>
                    <div class="stat-box kosong">
                        <span>Kosong</span>
                        <b><?= $h['jumlah_kosong'] ?></b>
                    </div>
                    <div class="stat-box nilai">
                        <span>Nilai Akhir</span>
                        <b><?= number_format($h['nilai'], 2) ?></b>
                    </div>
                    <?php $lulus = $h['nilai'] >= 75; ?>
                    <div class="stat-box <?= $lulus ? 'lulus' : 'gagal' ?>">
                        <span>Status</span>
                        <b><?= $lulus ? 'LULUS' : 'TIDAK LULUS' ?></b>
                        <div style="font-size: 11px; margin-top: 5px; opacity: 0.9;">Passing Grade: 75</div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="section-title">Rekapitulasi Jawaban</h4>
        <?php if(!empty($h['detail'])): ?>
            <?php foreach($h['detail'] as $i => $d): ?>
                <?php
                $statusClass = $d['benar_persoal'] == 1 ? 'benar' : ($d['jawaban_user'] ? 'salah' : 'kosong');
                $statusIcon  = $d['benar_persoal'] == 1 ? '✅' : ($d['jawaban_user'] ? '❌' : '—');
                ?>
                <div class="review-soal-item <?= $statusClass ?>">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:4px;">
                        <strong><?= ($i+1) ?>. <?= htmlspecialchars($d['pertanyaan']) ?></strong>
                        <span style="margin-left:8px; font-size:16px;"><?= $statusIcon ?></span>
                    </div>
                    <div class="row-soal">
                        <?php foreach(['a','b','c','d'] as $k): ?>
                            <?php
                            $klass = '';
                            if ($d['jawaban_user'] === $k) $klass .= ' opsi-user';
                            if ($d['kunci'] === $k) $klass .= ' opsi-kunci';
                            $badge = $d['jawaban_user'] === $k ? ' <small class="badge-primary">Jawaban Anda</small>' : '';
                            $kunciBadge = $d['kunci'] === $k ? ' <small class="badge-success">Kunci</small>' : '';
                            ?>
                            <div class="col-soal">
                                <span class="opsi-review<?= $klass ?>"><?= strtoupper($k) ?></span> 
                                <?= htmlspecialchars($d['opsi_'.$k]) ?>
                                <?= $badge ?><?= $kunciBadge ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if($d['nilai_diperoleh_persoal'] > 0): ?>
                        <div style="text-align:right; margin-top:4px;">
                            <small style="color:#28a745; font-weight:bold;">+<?= $d['nilai_diperoleh_persoal'] ?> poin</small>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding:15px; border:1px dashed #ccc; text-align:center; margin-bottom:20px;">
                Belum ada data detail jawaban.
            </div>
        <?php endif; ?>
        
        <h4 class="section-title">Rekapitulasi Pelanggaran (Proctoring)</h4>
        
        <?php if(empty($h['pelanggaran'])): ?>
            <div class="status-aman">✔ Tidak ada pelanggaran terdeteksi selama ujian berlangsung.</div>
        <?php else: ?>
            <table class="pelanggaran-table">
                <thead>
                    <tr>
                        <th width="40" style="text-align:center;">No</th>
                        <th width="140">Waktu</th>
                        <th width="180">Jenis Pelanggaran</th>
                        <th>Keterangan</th>
                        <th width="150" style="text-align:center;">Foto Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($h['pelanggaran'] as $i => $p): ?>
                    <tr>
                        <td style="text-align:center;"><?= $i+1 ?></td>
                        <td><?= htmlspecialchars($p['created_at']) ?></td>
                        <td><strong><?= htmlspecialchars($p['jenis']) ?></strong></td>
                        <td><?= htmlspecialchars($p['keterangan']) ?></td>
                        <td style="text-align:center;">
                            <?php if(!empty($p['foto_bukti'])): 
                                $foto_bukti_url = (strpos($p['foto_bukti'], 'upload/') === 0) ? url($p['foto_bukti']) : url('upload/log_pelanggaran_ujian/' . $p['foto_bukti']);
                            ?>
                                <img src="<?= $foto_bukti_url ?>" class="foto-bukti" alt="Bukti">
                            <?php else: ?>
                                <span style="color:#7f8c8d; font-style:italic;">Tidak ada foto</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    
    <?php if(empty($hasil_list)): ?>
        <div style="text-align:center; padding: 50px; background: #f8f9fa; border-radius: 8px; border: 1px dashed #ccc;">
            <h3 style="color:#7f8c8d;">Data tidak ditemukan.</h3>
        </div>
    <?php endif; ?>
</body>
</html>
