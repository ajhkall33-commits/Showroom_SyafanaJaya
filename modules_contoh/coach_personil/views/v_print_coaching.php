<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Coaching Personil - <?=$coaching['nama_personil'] ?? 'Personil'?> (<?=$coaching['nik'] ?? '-'?>)</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css')?>">
    <style>
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #111827;
            background: #f1f5f9;
            margin: 0;
            padding: 20px;
        }
        .print-container {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        /* Action Bar (Screen Only) */
        .no-print-bar {
            max-width: 850px;
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

        /* Section Styling */
        .doc-section {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 12px;
            font-weight: 800;
            background: #f1f5f9;
            color: #0f172a;
            padding: 6px 10px;
            border-left: 4px solid #0284c7;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        /* Table Styling */
        table.print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }
        table.print-table th, table.print-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            vertical-align: middle;
        }
        table.print-table th {
            background-color: #f8fafc;
            color: #0f172a;
            font-weight: 700;
            text-align: left;
        }
        table.table-identity td {
            border: none;
            padding: 4px 6px;
        }

        /* Score Boxes */
        .score-grid {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .score-box {
            flex: 1;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px;
            text-align: center;
            background: #f8fafc;
        }
        .score-box .score-val {
            font-size: 16px;
            font-weight: 800;
            margin-top: 4px;
            color: #0f172a;
        }

        /* Photo Gallery */
        .photo-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 8px;
        }
        .photo-item {
            width: calc(33.333% - 8px);
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 4px;
            text-align: center;
            page-break-inside: avoid;
        }
        .photo-item img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Signatures */
        .sig-container {
            margin-top: 24px;
            display: flex;
            justify-content: space-around;
            page-break-inside: avoid;
        }
        .sig-box {
            width: 40%;
            text-align: center;
        }
        .sig-space {
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sig-name {
            font-weight: bold;
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            min-width: 160px;
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
                font-size: 11px;
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
                size: A4;
                margin: 12mm 15mm;
            }
        }
    </style>
</head>
<body>

    <!-- SCREEN ONLY TOP BAR -->
    <div class="no-print-bar">
        <div>
            <strong><i class="fa fa-file-text-o mr-1"></i> Preview Cetak Native PDF</strong> - Formulir Coaching Personil
        </div>
        <div>
            <a href="javascript:window.history.back()" class="btn-back"><i class="fa fa-arrow-left"></i> Kembali</a>
            <button type="button" class="btn-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak / Simpan PDF</button>
        </div>
    </div>

    <!-- DOCUMENT CONTAINER -->
    <div class="print-container">
        
        <?php 
            $is_presensi = ($coaching['perihal'] == 'Evaluasi Presensi');
        ?>
        <!-- HEADER -->
        <div class="doc-header">
            <div>
                <img src="<?= base_url('assets/ias.png') ?>" alt="Logo IAS" style="height: 75px; max-width: 220px; object-fit: contain; margin-bottom: 5px;">
            </div>
            <div class="doc-title-box">
                <h1 class="doc-title"><?=$is_presensi ? 'FORMULIR EVALUASI PRESENSI PERSONIL' : 'FORMULIR COACHING PERSONIL'?></h1>
                <p class="doc-sub"><?=$is_presensi ? 'Program Evaluasi Kehadiran & Pembinaan Disiplin Karyawan' : 'Program Pembinaan & Peningkatan Kinerja Karyawan'?></p>
                <p class="doc-sub">No. Dokumen: <strong>DOC-CP-<?=str_pad($coaching['id_coaching'], 5, '0', STR_PAD_LEFT)?></strong> | Tanggal: <strong><?=$coaching['tanggal_coaching']?></strong></p>
            </div>
        </div>

        <!-- 1. IDENTITAS PERSONIL -->
        <div class="doc-section">
            <div class="section-title">1. Informasi Personil &amp; Sesi Coaching</div>
            <table class="table-identity" style="width:100%;">
                <tr>
                    <td width="18%"><strong>NIK</strong></td>
                    <td width="2%">:</td>
                    <td width="30%"><?=$coaching['nik'] ?? '-'?></td>
                    <td width="18%"><strong>Periode Dokumen</strong></td>
                    <td width="2%">:</td>
                    <td width="30%"><?=$coaching['semester']?> <?=$coaching['tahun']?></td>
                </tr>
                <tr>
                    <td><strong>Nama Karyawan</strong></td>
                    <td>:</td>
                    <td><strong><?=$coaching['nama_personil'] ?? '-'?></strong></td>
                    <td><strong>Perihal</strong></td>
                    <td>:</td>
                    <td><?=$coaching['perihal'] ?? '-'?></td>
                </tr>
                <tr>
                    <td><strong>Unit Kerja</strong></td>
                    <td>:</td>
                    <td><?=$coaching['kode_unit']?> - <?=$coaching['name_unit']?></td>
                    <td><strong>Periode Evaluasi</strong></td>
                    <td>:</td>
                    <td><?=$coaching['periode_start']?> s/d <?=$coaching['periode_end']?></td>
                </tr>
                <tr>
                    <td><strong>Jabatan</strong></td>
                    <td>:</td>
                    <td><?=$coaching['jabatan'] ?? '-'?></td>
                    <td><strong>Atasan / Coach</strong></td>
                    <td>:</td>
                    <td><strong><?=$coaching['nama_atasan'] ?? '-'?></strong></td>
                </tr>
            </table>

            <?php if($coaching['perihal'] == 'Hasil Asesmen' && ($coaching['nilai_akhir'] !== null || $coaching['nilai_cbt'] !== null || $coaching['nilai_wawancara'] !== null)): ?>
            <!-- SNAPSHOT HASIL ASESMEN -->
            <div style="margin-top: 10px;">
                <strong style="font-size:11px; display:block; margin-bottom:4px;">Snapshot Nilai Asesmen:</strong>
                <div class="score-grid">
                    <div class="score-box">
                        <small style="color:#64748b;">Nilai CBT</small>
                        <div class="score-val"><?=($coaching['nilai_cbt'] !== null && $coaching['nilai_cbt'] !== '') ? number_format((float)$coaching['nilai_cbt'], 1) : '-'?></div>
                    </div>
                    <div class="score-box">
                        <small style="color:#64748b;">Nilai Wawancara</small>
                        <div class="score-val"><?=($coaching['nilai_wawancara'] !== null && $coaching['nilai_wawancara'] !== '') ? number_format((float)$coaching['nilai_wawancara'], 1) : '-'?></div>
                    </div>
                    <div class="score-box">
                        <small style="color:#64748b;">Skor Presensi</small>
                        <div class="score-val"><?=($coaching['nilai_presensi'] !== null && $coaching['nilai_presensi'] !== '') ? number_format((float)$coaching['nilai_presensi'], 1).'%' : '-'?></div>
                    </div>
                    <div class="score-box" style="background:#fee2e2; border-color:#fca5a5;">
                        <small style="color:#991b1b; font-weight:bold;">Nilai Akhir Asesmen</small>
                        <div class="score-val" style="color:#b91c1c;"><?=($coaching['nilai_akhir'] !== null && $coaching['nilai_akhir'] !== '') ? number_format((float)$coaching['nilai_akhir'], 1) . ' (' . ($coaching['kategori_nilai'] ?? 'Perlu Coaching') . ')' : '-'?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- 2. IDENTIFIKASI PERFORMANCE GAP / EVALUASI PRESENSI -->
        <div class="doc-section">
            <div class="section-title"><?=$is_presensi ? '2. Catatan & Temuan Evaluasi Presensi' : '2. Identifikasi Performance Gap (Kesenjangan Kinerja)'?></div>
            <?php if($is_presensi): 
                $presensi_gap = $gaps[0] ?? ['area_gap' => 'Presensi', 'status_gap' => 'Perlu Perbaikan', 'catatan' => '-'];
            ?>
            <table class="print-table">
                <tr>
                    <td width="25%" style="background:#f8fafc;"><strong>Area Evaluasi</strong></td>
                    <td><strong><?=$presensi_gap['area_gap'] ?? 'Presensi'?></strong></td>
                </tr>
                <tr>
                    <td style="background:#f8fafc;"><strong>Status Kepatuhan</strong></td>
                    <td><strong><?=$presensi_gap['status_gap'] ?? 'Perlu Perbaikan'?></strong></td>
                </tr>
                <tr>
                    <td style="background:#f8fafc; vertical-align:top;"><strong>Catatan / Temuan Spesifik</strong></td>
                    <td style="line-height:1.6; white-space:pre-line;"><?=nl2br(htmlspecialchars($presensi_gap['catatan'] ?: '-'))?></td>
                </tr>
            </table>
            <?php else: ?>
            <table class="print-table">
                <thead>
                    <tr style="text-align:center;">
                        <th width="30" style="text-align:center;">NO</th>
                        <th width="240">AREA KOMPETENSI / KINERJA</th>
                        <th width="120" style="text-align:center;">STATUS GAP</th>
                        <th>CATATAN / TEMUAN SPESIFIK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($gaps)): foreach($gaps as $idx => $g): ?>
                    <tr>
                        <td style="text-align:center;"><?=$idx+1?></td>
                        <td><strong><?=$g['area_gap']?></strong></td>
                        <td style="text-align:center;">
                            <strong><?=$g['status_gap']?></strong>
                        </td>
                        <td><?=$g['catatan'] ? $g['catatan'] : '-'?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" style="text-align:center; color:#64748b;">Tidak ada temuan performance gap.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <?php if(!$is_presensi): ?>
        <!-- 3. AKAR MASALAH -->
        <div class="doc-section">
            <div class="section-title">3. Akar Masalah (Root Cause Analysis)</div>
            <table class="print-table">
                <thead>
                    <tr>
                        <th width="30" style="text-align:center;">NO</th>
                        <th width="250">FAKTOR PENYEBAB UTAMA</th>
                        <th>URAIAN PENJELASAN AKAR MASALAH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($root_causes)): foreach($root_causes as $rIdx => $rc): ?>
                    <tr>
                        <td style="text-align:center;"><?=$rIdx+1?></td>
                        <td><strong><?=$rc['root_cause']?></strong></td>
                        <td><?=$rc['catatan'] ? $rc['catatan'] : '-'?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="3" style="text-align:center; color:#64748b;">Tidak ada faktor penyebab khusus.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- 4. RENCANA AKSI PERBAIKAN -->
        <div class="doc-section">
            <div class="section-title">4. Rencana Aksi Perbaikan (Action Plan)</div>
            <table class="print-table">
                <thead>
                    <tr style="text-align:center;">
                        <th width="30" style="text-align:center;">NO</th>
                        <th>SASARAN PERBAIKAN</th>
                        <th width="130">TARGET</th>
                        <th>INDIKATOR KEBERHASILAN</th>
                        <th width="85" style="text-align:center;">DEADLINE</th>
                        <th width="140">DUKUNGAN ATASAN</th>
                        <th width="80" style="text-align:center;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($action_plans)): foreach($action_plans as $aIdx => $ap): ?>
                    <tr>
                        <td style="text-align:center;"><?=$aIdx+1?></td>
                        <td><strong><?=$ap['sasaran_perbaikan']?></strong></td>
                        <td><?=$ap['target'] ?? '-'?></td>
                        <td><?=$ap['indikator_keberhasilan'] ?? '-'?></td>
                        <td style="text-align:center;"><?=$ap['deadline'] ?? '-'?></td>
                        <td><?=$ap['dukungan_atasan'] ?? '-'?></td>
                        <td style="text-align:center;"><strong><?=$ap['status'] ?? 'Proses'?></strong></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="7" style="text-align:center; color:#64748b;">Belum ada rencana aksi perbaikan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- 5. KOMITMEN & DUKUNGAN PEMBINAAN -->
        <div class="doc-section">
            <div class="section-title">5. Komitmen Karyawan &amp; Dukungan Pembinaan Atasan</div>
            <table class="print-table">
                <tr>
                    <td width="25%" style="background:#f8fafc;"><strong>Pernyataan Komitmen Karyawan</strong></td>
                    <td><em>"<?=$commitment['komitmen_karyawan'] ?? '-'?>"</em></td>
                </tr>
                <tr>
                    <td style="background:#f8fafc;"><strong>Arahan &amp; Pengarahan Atasan</strong></td>
                    <td><?=$commitment['arahan'] ? $commitment['arahan'] : '-'?></td>
                </tr>
                <tr>
                    <td style="background:#f8fafc;"><strong>Pendampingan (Mentoring)</strong></td>
                    <td><?=$commitment['pendampingan'] ? $commitment['pendampingan'] : '-'?></td>
                </tr>
                <tr>
                    <td style="background:#f8fafc;"><strong>Pelatihan yang Direkomendasikan</strong></td>
                    <td><?=$commitment['pelatihan'] ? $commitment['pelatihan'] : '-'?></td>
                </tr>
                <tr>
                    <td style="background:#f8fafc;"><strong>Mekanisme Monitoring</strong></td>
                    <td>Mingguan: <?=$commitment['monitoring_mingguan'] ? $commitment['monitoring_mingguan'] : '-'?> | Bulanan: <?=$commitment['monitoring_bulanan'] ? $commitment['monitoring_bulanan'] : '-'?></td>
                </tr>
            </table>
        </div>

        <!-- 6. MONITORING PROGRES & EVALUASI -->
        <?php if(!empty($monitorings) || !empty($evaluation)): ?>
        <div class="doc-section">
            <div class="section-title">6. Monitoring Progres &amp; Evaluasi Akhir</div>
            
            <?php if(!empty($monitorings)): ?>
            <strong style="font-size:11px; display:block; margin-bottom:4px;">Catatan Monitoring:</strong>
            <table class="print-table">
                <thead>
                    <tr style="text-align:center;">
                        <th width="30" style="text-align:center;">NO</th>
                        <th width="85" style="text-align:center;">TANGGAL</th>
                        <th>PROGRES PERBAIKAN</th>
                        <th>KENDALA</th>
                        <th>TINDAK LANJUT</th>
                        <th width="120">PARAF / ATASAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($monitorings as $mIdx => $m): ?>
                    <tr>
                        <td style="text-align:center;"><?=$mIdx+1?></td>
                        <td style="text-align:center;"><?=$m['tanggal']?></td>
                        <td><?=$m['progres'] ?? '-'?></td>
                        <td><?=$m['kendala'] ?? '-'?></td>
                        <td><?=$m['tindak_lanjut'] ?? '-'?></td>
                        <td><?=$m['paraf_atasan'] ?? $m['nama_created_by'] ?? '-'?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <?php if(!empty($evaluation)): ?>
            <strong style="font-size:11px; display:block; margin: 8px 0 4px 0;">Hasil Evaluasi Akhir:</strong>
            <table class="print-table">
                <tr>
                    <td width="20%"><strong>Target Tercapai:</strong> <?=$evaluation['target_tercapai'] ?? '-'?></td>
                    <td width="25%"><strong>Peningkatan Kinerja:</strong> <?=$evaluation['ada_peningkatan'] ?? '-'?></td>
                    <td width="25%"><strong>Coaching Lanjutan:</strong> <?=$evaluation['coaching_lanjutan'] ?? '-'?></td>
                    <td width="30%"><strong>Pelatihan Tambahan:</strong> <?=$evaluation['perlu_pelatihan'] ?? '-'?></td>
                </tr>
                <tr>
                    <td colspan="4"><strong>Kesimpulan &amp; Catatan:</strong> <?=$evaluation['catatan_evaluasi'] ? $evaluation['catatan_evaluasi'] : '-'?></td>
                </tr>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <?php if($is_presensi): ?>
        <!-- 3. KOMITMEN KARYAWAN & CATATAN PEMBINAAN (KHUSUS EVALUASI PRESENSI) -->
        <div class="doc-section">
            <div class="section-title">3. Komitmen Karyawan &amp; Catatan Pembinaan Atasan</div>
            <table class="print-table">
                <tr>
                    <td width="28%" style="background:#f8fafc;"><strong>Pernyataan Komitmen Kehadiran</strong></td>
                    <td style="line-height:1.6; font-style:italic;">
                        "<?=$commitment['komitmen_karyawan'] ? htmlspecialchars($commitment['komitmen_karyawan']) : 'Saya berkomitmen untuk meningkatkan kedisiplinan kehadiran kerja, datang tepat waktu, dan mematuhi peraturan presensi yang berlaku.'?>"
                    </td>
                </tr>
                <?php if(!empty($commitment['catatan_atasan']) || !empty($commitment['arahan'])): ?>
                <tr>
                    <td style="background:#f8fafc;"><strong>Arahan / Catatan Khusus Atasan</strong></td>
                    <td style="line-height:1.6; white-space:pre-line;"><?=nl2br(htmlspecialchars($commitment['catatan_atasan'] ?: ($commitment['arahan'] ?: '-')))?></td >
                </tr>
                <?php endif; ?>
            </table>
        </div>
        <?php endif; ?>

        <!-- BUKTI FOTO DOKUMENTASI -->
        <?php 
            $all_photos = [];
            if(!empty($coaching['foto_dokumentasi'])){
                $all_photos[] = $coaching['foto_dokumentasi'];
            }
            if(!empty($dokumentasi)){
                foreach($dokumentasi as $d){
                    if(empty($coaching['foto_dokumentasi']) || $d['file_path'] != $coaching['foto_dokumentasi']){
                        $all_photos[] = $d['file_path'];
                    }
                }
            }
        ?>
        <?php if(!empty($all_photos)): ?>
        <div class="doc-section">
            <div class="section-title"><?=$is_presensi ? '4. Foto Bukti Dokumentasi Kegiatan Evaluasi' : '7. Foto Bukti Dokumentasi Kegiatan Coaching'?></div>
            <div class="photo-grid">
                <?php foreach($all_photos as $pPath): ?>
                <div class="photo-item">
                    <img src="<?=base_url($pPath)?>" alt="Bukti Coaching">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- 8. LEMBAR PENGESAHAN / TANDA TANGAN -->
        <div class="sig-container">
            <div class="sig-box">
                <div>Karyawan yang Bersangkutan,</div>
                <div class="sig-space">
                    <?php if(!empty($coaching['ttd_peserta'])): ?>
                    <img src="<?=base_url($coaching['ttd_peserta'])?>" alt="TTD Karyawan" style="max-height:60px; max-width:140px; object-fit:contain;">
                    <?php endif; ?>
                </div>
                <div class="sig-name"><?=$coaching['nama_personil'] ?? '.........................................'?></div>
                <div class="sig-role">NIK: <?=$coaching['nik'] ?? '-'?></div>
            </div>

            <div class="sig-box">
                <div>Atasan Langsung / Coach,</div>
                <div class="sig-space">
                    <?php if(!empty($coaching['ttd_coach'])): ?>
                    <img src="<?=base_url($coaching['ttd_coach'])?>" alt="TTD Coach" style="max-height:60px; max-width:140px; object-fit:contain;">
                    <?php endif; ?>
                </div>
                <div class="sig-name"><?=$coaching['nama_atasan'] ?? '.........................................'?></div>
                <div class="sig-role">Coach / Atasan</div>
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
