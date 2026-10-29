<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Perintah Kerja Perbaikan</title>
    <style>
        /* Pengaturan Halaman Global - Dompdf mematuhinya lebih baik jika di luar media query */
        @page {
            size: 210mm 330mm; /* Standar F4 */
            margin-top: 25mm !important; /* Jarak yang lebih proporsional */
            margin-bottom: 20mm;
            margin-left: 15mm;
            margin-right: 15mm;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: normal;
            color: #000;
            padding: 0;
            margin: 0;
        }
        
        .container {
            width: 100%;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 2px solid #000;
            margin-bottom: -2px;
            page-break-inside: auto;
        }
        
        th, td {
            border: 2px solid #000;
            padding: 6px 5px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
            line-height: 1.2;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        
        .logo-table td {
            height: 90px;
            padding: 5px;
            border: 2px solid #000;
            background-color: #fff;
        }
        
        .logo {
            max-height: 80px;
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }
        
        .title-cell {
            text-align: center;
        }
        
        .title-cell h2 {
            font-size: 15px;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.3;
        }
        
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        
        /* Grid Foto Dokumentasi */
        .photo-box-inline {
            width: 200px;
            height: 270px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #fff;
        }
        
        .photo-box-inline img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Spacer Header agar tidak menabrak baris atas pada halaman baru */
        .table-spacer {
            border: none !important;
            height: 35px;
            background: transparent;
        }
        
        /* Signature */
        .ttd-section {
            margin-top: 15px;
            border-collapse: collapse;
            font-size: 11px;
            page-break-inside: avoid;
        }
        
        .ttd-section td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 15px 9px;
            border: 2px solid #000;
            font-weight: bold;
        }
        
        .ttd-placeholder {
            height: 60px;
        }
    </style>
</head>
<body>
    <!-- Script Header (NOMOR) halaman > 1 -->
    <script type="text/php">
      if (isset($pdf)) {
        $pdf->page_script('
            if ($PAGE_NUM > 1) {
                $font = $fontMetrics->get_font("Arial", "bold");
                $pdf->text(40, 20, "NOMOR : <?= $nomor ?>", $font, 10, array(0,0,0));
            }
        ');
      }
    </script>

    <div class="container">
        <!-- HEADER LOGO & JUDUL -->
        <table class="logo-table">
            <tr>
                <td width="20%">
                    <img src="<?= ImageLogo('1') ?>" class="logo" alt="Logo Kiri">
                </td>
                <td width="60%" class="title-cell" colspan="2">
                    <h2>PERINTAH KERJA</h2>
                    <h2>PEMELIHARAAN PERBAIKAN</h2>
                </td>
                <td width="20%">
                    <img src="<?= ImageLogo('2') ?>" class="logo" alt="Logo Kanan">
                </td>
            </tr>
            <!-- BARIS INFORMASI 1 -->
            <tr>
                <th width="25%">Nomor</th>
                <th width="25%">Kode Unit</th>
                <th width="25%">Nama Unit</th>
                <th width="25%">Tanggal</th>
            </tr>
            <tr>
                <td class="text-center"><?= $nomor ?? '-' ?></td>
                <td class="text-center"><?= $unit_kode ?? '-' ?></td>
                <td class="text-center"><?= $name_unit ?? '-' ?></td>
                <td class="text-center"><?= $tanggal ?? '-' ?></td>
            </tr>
            <!-- BARIS INFORMASI 2 -->
            <tr>
                <th colspan="1">Peralatan</th>
                <th colspan="2">Keterangan</th>
                <th colspan="1">Waktu</th>
            </tr>
            <tr>
                <td class="text-center" colspan="1"><?= $fasilitas ?? '-' ?></td>
                <td class="text-center" colspan="2"><?= $description ?? '-' ?></td>
                <td class="text-center" colspan="1"><?= $waktu ?? '-' ?></td>
            </tr>
            <!-- BARIS PERSONIL -->
            <tr>
                <th colspan="4">PERSONIL YANG MERAWAT</th>
            </tr>
            <tr>
                <td colspan="4" class="text-center" style="padding: 12px;">
                    <?php 
                        $personil_arr = explode(",", $pelaksana);
                        $formatted_personil = [];
                        foreach ($personil_arr as $p) {
                            if (trim($p) !== "") $formatted_personil[] = trim($p);
                        }
                        echo implode(" &nbsp; | &nbsp; ", $formatted_personil);
                    ?>
                </td>
            </tr>
        </table>

        <!-- BARIS INFORMASI 3: TABEL DETAIL -->
        <table>
            <thead>
                <tr>
                    <th width="25%">Alat</th>
                    <th width="35%">Permasalahan</th>
                    <th width="40%">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail)): ?>
                    <?php foreach ($detail as $item): ?>
                    <tr>
                        <td class="text-center"><?= $item['nama_perangkat'] ?? '-' ?></td>
                        <td><?= $item['nama_masalah'] ?? '-' ?></td>
                        <td><?= $item['description'] ?? '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                        <td class="text-center">-</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- BAGIAN DOKUMENTASI (3 Kolom Grid per Bagian) -->
        <?php
        function renderGrid($images, $title, $folder) {
            // Gunakan margin-top di luar tabel agar tidak merusak border-collapse
            $html = '<div style="margin-top: 20px;"></div>';
            $html .= '<table style="page-break-inside: avoid; border: 2px solid #000; border-collapse: collapse; width: 100%;">';
            
            $html .= '<thead>';
            $html .= '<tr><th colspan="3" style="font-size: 13px; background-color: #f0f0f0; border: 2px solid #000; padding: 10px; text-align: center;">'.$title.'</th></tr>';
            $html .= '</thead>';
            
            $html .= '<tbody>';
            if (empty($images)) {
                $html .= '<tr><td colspan="3" style="text-align: center; padding: 20px; color: #666; font-style: italic; border: 2px solid #000;">Tidak ada foto</td></tr>';
            } else {
                $chunks = array_chunk($images, 3);
                foreach ($chunks as $chunk) {
                    $html .= '<tr>';
                    for ($i = 0; $i < 3; $i++) {
                        if (isset($chunk[$i])) {
                            $img_path = base_url('upload/'.$folder.'/'.$chunk[$i]['nama']);
                            $html .= '<td style="width: 33.33%; padding: 6px; text-align: center; vertical-align: top; border: 2px solid #000;">
                                        <div class="photo-box-inline">
                                            <img src="'.$img_path.'" onerror="this.src=\''.base_url("assets/img/default.jpg").'\';">
                                        </div>
                                      </td>';
                        } else {
                            $html .= '<td style="width: 33.33%; border: 2px solid #000;"></td>';
                        }
                    }
                    $html .= '</tr>';
                }
            }
            $html .= '</tbody>';
            $html .= '</table>';
            return $html;
        }
        ?>

        <?= renderGrid($foto_before, 'FOTO BEFORE', 'dokumentasi_before') ?>
        <?= renderGrid($foto_proses, 'FOTO PROSES', 'dokumentasi_proses') ?>
        <?= renderGrid($foto_after, 'FOTO AFTER', 'dokumentasi_after') ?>

        <!-- TTD Pengawas / Koordinator -->
        <table class="ttd-section">
            <tr>
                <td>
                    <strong>DISETUJUI</strong><br>
                    <strong>PT ANGKASA PURA INDONESIA</strong><br>
                    <strong>PENGAWAS</strong>
                    <div class="ttd-placeholder"></div>
                    <p>_________________________</p>
                    <strong><?= strtoupper($approved_by ?? 'NAMA PENGAWAS') ?></strong>
                </td>
                <td>
                    <strong></strong><br>
                    <strong>PT IAS SUPPORT INDONESIA</strong><br>
                    <strong>KOORDINATOR</strong>
                    <div class="ttd-placeholder"></div>
                    <p>_________________________</p>
                    <strong><?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?></strong>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>