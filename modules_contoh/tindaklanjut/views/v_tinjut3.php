<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <title>Perintah Kerja CM</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11pt;
      margin: 0;
      padding: 0;
    }
    
    /* Pengaturan Margin Halaman PDF */
    @page {
      size: 215.9mm 330.2mm; /* F4 / Folio */
      margin-top: 5mm;      /* ~ 0.19" */
      margin-bottom: 13mm;  /* ~ 0.5" */
      margin-left: 10mm;    /* ~ 0.39" */
      margin-right: 10mm;   /* ~ 0.39" */
    }
    
    .container { max-width: 210mm; margin: 0 auto; }
    
    /* Tabel utama */
    .main-table {
      border-collapse: collapse;
      width: 100%;
      font-size: 12px;
      margin-bottom: 0px; 
      text-align: center;
      table-layout: fixed; 
    }
    .main-table th, .main-table td {
      border: 2px solid #000;
      padding: 8px 6px;
      vertical-align: middle;
      word-wrap: break-word;
    }
    .main-table th {
      background: #f0f0f0;
      font-weight: bold;
      text-align: center;
      font-size: 12px;
    }
    
    .block-title {
      background: #f0f0f0 !important;
      font-weight: bold !important;
      font-size: 14px !important;
      padding: 10px !important;
      text-transform: uppercase;
      border: 2px solid #000 !important;
      text-align: center !important;
    }
    
    .ttd-placeholder {
      height: 60px;
    }
    .logo-img {
      max-height: 55px;
      width: auto;
      display: block;
      margin: 0 auto;
    }
    
    .info-cell {
      text-align: left;
      vertical-align: top;
      padding: 10px;
    }
    
    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-bold { font-weight: bold; }
    
    /* Page Break for Documentation */
    .page-break {
        page-break-before: always;
    }
    
    @media print {
        @page {
            size: 215.9mm 330.2mm; 
            margin: 5mm 10mm 13mm 10mm;
        }
        .page-break { page-break-before: always; }
        html, body {
            width: 210mm;
            height: 330mm;
            background: white;
            margin: 0;
            padding: 0;
        }
    }
  </style>
</head>
<body>
<div style="position: fixed; bottom: 6mm; left: 10mm; right: 10mm; text-align: right; font-size: 10px; font-weight: bold; z-index: 9999;" class="print-footer">
  <?= $nomor ?? '-' ?> | Dicetak pada: <?= date('d-m-Y H:i:s') ?>
</div>
<div class="container">

    <table class="main-table">
        <!-- 20-COLUMN GRID DEFINITION -->
        <tr style="visibility: collapse; line-height: 0; height: 0;">
            <?php for($i=0; $i<20; $i++): ?><td style="width: 5%; padding: 0; border: none;"></td><?php endfor; ?>
        </tr>

        <!-- HEADER & KOP -->
        <tr>
            <td colspan="5" style="width:25%; height:55px; background:#fff; text-align:center; vertical-align:middle; padding:5px; border: 2px solid #000;">
                <img class="logo-img" src="<?= base_url('assets/ias.png') ?>" alt="Logo Kiri" style="margin-bottom:30px;margin-left:25px;height:57px; text-align:center; vertical-align:middle;" onerror="this.style.display='none'">
            </td>
            <td colspan="15" style="font-weight:bold; font-size:16px; text-align:center; background:#fff; vertical-align:middle; padding:10px;">
                PERINTAH KERJA<br>
                PEMELIHARAAN PERBAIKAN
            </td>
        </tr>

        <!-- INFORMASI UMUM -->
        <tr>
            <th colspan="5">NOMOR</th>
            <th colspan="3">KODE UNIT</th>
            <th colspan="5">UNIT</th>
            <th colspan="7">TANGGAL</th>
        </tr>
        <tr>
            <td colspan="5" class="text-center"><?= $nomor ?? '-' ?></td>
            <td colspan="3" class="text-center"><?= $unit_kode ?? '-' ?></td>
            <td colspan="5" class="text-center"><?= $nama_unit ?? '-' ?></td>
            <td colspan="7" class="text-center"><?= isset($tgl_mulai_f) && $tgl_mulai_f !== '-' ? preg_replace('/\s+\d{2}:\d{2}(:\d{2})?$/', '', $tgl_mulai_f) : '-' ?></td>
        </tr>

        <?php $max_rows = max(count($perangkat_detail ?? []), count($masalah_detail ?? []), count($komponen_detail ?? [])); ?>
        <!-- PERALATAN YANG DIPERBAIKI -->
        <tr>
            <th colspan="20" class="block-title">PERALATAN YANG DIPERBAIKI</th>
        </tr>
        <tr>
            <th colspan="5">PERALATAN</th>
            <th colspan="8">ALAT</th>
            <th colspan="7">KETERANGAN PERBAIKAN</th>
        </tr>
        <?php if ($max_rows > 0): ?>
            <?php for ($i = 0; $i < $max_rows; $i++): ?>
                <?php $row_perangkat = isset($perangkat_detail[$i]) ? $perangkat_detail[$i]['nama_perangkat'] : '-'; ?>
                <tr>
                    <?php if ($i == 0): ?>
                    <td colspan="5" rowspan="<?= $max_rows ?>" class="text-center"><?= $nama_fasilitas ?? '-' ?></td>
                    <?php endif; ?>
                    <td colspan="8" class="text-center"><?= $row_perangkat ?></td>
                    <?php if ($i == 0): ?>
                    <td colspan="7" rowspan="<?= $max_rows ?>" class="text-center"><?= nl2br($tindakan ?? '-') ?></td>
                    <?php endif; ?>
                </tr>
            <?php endfor; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center"><?= $nama_fasilitas ?? '-' ?></td>
                <td colspan="8" class="text-center">-</td>
                <td colspan="7" class="text-center"><?= nl2br($tindakan ?? '-') ?></td>
            </tr>
        <?php endif; ?>

        <!-- DETAIL PEKERJAAN -->
        <tr>
            <th colspan="20" class="block-title">DETAIL PEKERJAAN</th>
        </tr>
        <tr>
            <th colspan="10">PERMASALAHAN</th>
            <th colspan="10">PERGANTIAN KOMPONEN</th>
        </tr>
        <?php if (empty($masalah_detail) && empty($komponen_detail)): ?>
            <tr>
                <td colspan="20" class="text-center" style="padding: 15px; color: #777;">- Tidak ada detail pekerjaan -</td>
            </tr>
        <?php else: ?>
            <?php 
                if (!empty($masalah_detail)) {
                    $str_masalah = "<ul style='margin: 0; padding-left: 20px; text-align: left;'>";
                    foreach ($masalah_detail as $m) {
                        $str_masalah .= "<li style='padding-bottom: 3px;'>" . htmlspecialchars($m['nama_masalah']) . "</li>";
                    }
                    $str_masalah .= "</ul>";
                } else {
                    $str_masalah = '-';
                }

                if (!empty($komponen_detail)) {
                    $str_komponen = "<ul style='margin: 0; padding-left: 20px; text-align: left;'>";
                    foreach ($komponen_detail as $k) {
                        $str_komponen .= "<li style='padding-bottom: 3px;'>Sparepart: " . htmlspecialchars($k['nama_komponen']) . " (" . $k['satuan_terpakai'] . " pcs)</li>";
                    }
                    $str_komponen .= "</ul>";
                } else {
                    $str_komponen = '-';
                }
            ?>
            <tr>
                <td colspan="10" style="vertical-align: top; padding: 10px;"><?= $str_masalah ?></td>
                <td colspan="10" style="vertical-align: top; padding: 10px;"><?= $str_komponen ?></td>
            </tr>
        <?php endif; ?>

        <!-- PERSONIL PERBAIKAN -->
        <tr>
            <th colspan="20" class="block-title">PERSONIL PERBAIKAN</th>
        </tr>
        <tr>
            <td colspan="20" style="padding: 15px 30px; text-align: left;">
                <?php 
                    $pelaksana_val = $pelaksana ?? '';
                    $personil_arr = explode(",", $pelaksana_val);
                    $formatted_personil = array_filter(array_map('trim', $personil_arr));
                    if (!empty($formatted_personil)) {
                        echo "<ol style='margin: 0; padding-left: 20px; font-size: 12px;'>";
                        foreach ($formatted_personil as $p) {
                            echo "<li style='padding-bottom: 5px;'>" . htmlspecialchars($p) . "</li>";
                        }
                        echo "</ol>";
                    } else {
                        echo "<div class='text-center'>-</div>";
                    }
                ?>
            </td>
        </tr>

    </table>

    <!-- TANDA TANGAN (Separate table) -->
    <table class="main-table" style="margin-top: 15px;">
        <tr>
            <td colspan="10" style="text-align: center; vertical-align: top; padding: 20px 10px; font-weight: bold;">
                DISETUJUI<br>
                PT ANGKASA PURA INDONESIA<br>
                PENGAWAS
                <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
                    <?php
                        $ttd_api_file = $ttd_api ?? null;
                        $ttd_api_path = FCPATH . 'doc/ttd_corrective/' . ($id_unit ?? '') . '/API/' . $ttd_api_file;
                        if (!empty($ttd_api_file) && file_exists($ttd_api_path)):
                    ?>
                        <img src="<?= base_url('doc/ttd_corrective/' . ($id_unit ?? '') . '/API/' . $ttd_api_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD API">
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </div>
                <p style="margin: 0;">_________________________</p>
                <?= strtoupper($approved_by ?? 'NAMA PENGAWAS') ?>
            </td>
            <td colspan="10" style="text-align: center; vertical-align: top; padding: 20px 10px; font-weight: bold;">
                <br>
                PT IAS SUPPORT INDONESIA<br>
                KOORDINATOR
                <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
                    <?php
                        $ttd_file = $ttd_iass ?? null;
                        $ttd_path = FCPATH . 'doc/ttd_corrective/' . ($id_unit ?? '') . '/IASS/' . $ttd_file;
                        if (!empty($ttd_file) && file_exists($ttd_path)):
                    ?>
                        <img src="<?= base_url('doc/ttd_corrective/' . ($id_unit ?? '') . '/IASS/' . $ttd_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD IASS">
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </div>
                <p style="margin: 0;">_________________________</p>
                <?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?>
            </td>
        </tr>
    </table>

    <!-- FOTO DOKUMENTASI -->
    <div class="page-break"></div>

    <?php
    if (!function_exists('renderGrid')) {
        function renderGrid($images, $title, $folder) {
            $html = '<table class="main-table" style="margin-top: 10px; page-break-inside: avoid;">';
            $html .= '<thead>';
            $html .= '<tr><th colspan="3" class="block-title">'.$title.'</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            if (empty($images)) {
                $html .= '<tr><td colspan="3" style="text-align: center; padding: 20px; color: #777; font-style: italic;">Tidak ada foto</td></tr>';
            } else {
                $chunks = array_chunk($images, 3);
                foreach ($chunks as $chunk) {
                    $html .= '<tr>';
                    for ($i = 0; $i < 3; $i++) {
                        if (isset($chunk[$i])) {
                            $img_name = isset($chunk[$i]['nama_dokumentasi_temuan']) ? $chunk[$i]['nama_dokumentasi_temuan'] : $chunk[$i]['nama'];
                            $img_path = base_url('upload/'.$folder.'/'.$img_name);
                            $html .= '<td style="width: 33.33%; padding: 10px; text-align: center; vertical-align: middle; border: 2px solid #000;">
                                        <div style="width: 190px; height: 260px; margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #fff; border: 1px solid #ddd;">
                                            <img src="'.$img_path.'" style="width: 100%; height: 100%; object-fit: contain;" onerror="this.src=\''.base_url("assets/img/default.jpg").'\';">
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
    }
    ?>

    <?php if(!empty($id_temuan)): ?>
        <?= renderGrid($temuan_foto_arr ?? [], 'FOTO TEMUAN', 'dokumentasi_temuan') ?>
    <?php endif; ?>
    <?= renderGrid($foto_before_arr ?? [], 'FOTO BEFORE', 'dokumentasi_before') ?>
    <?= renderGrid($foto_proses_arr ?? [], 'FOTO PROSES', 'dokumentasi_proses') ?>
    <?= renderGrid($foto_after_arr ?? [], 'FOTO AFTER', 'dokumentasi_after') ?>

</div>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>