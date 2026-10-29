<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Laporan Pemeliharaan Pencegahan (<?= $no_wo?>)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11pt;
    }
    
    @media print {
      @page {
        size: 215.9mm 330.2mm; /* F4 / Folio */
        margin-top: 5mm;      /* ~ 0.19" */
        margin-bottom: 13mm;  /* ~ 0.5" */
        margin-left: 10mm;    /* ~ 0.39" */
        margin-right: 10mm;   /* ~ 0.39" */
      }
      body {
        margin: 0 !important;
        padding: 0 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
      .no-print {
        display: none !important;
      }
      tr, td, th {
        page-break-inside: avoid;
      }
      .print-header {
        position: fixed;
        top: -10mm;
        left: 0;
        font-weight: bold;
        font-size: 14px;
        z-index: 9999;
      }
      .wo-info {
        position: fixed !important;
        bottom: 5mm !important;
        left: 15mm !important;
        margin: 0 !important;
        z-index: 9999;
        font-size: 9px !important;
        background: #fff !important;
        display: block !important;
      }
    }
    
    @media screen {
      .print-header {
        display: none;
      }
    }

    .container {
      max-width: 210mm;
      margin: 0 auto;
    }

    .kop-wo-tgl {
      border: 2px solid #000;
      border-radius: 4px;
      width: 210px;
      margin-bottom: 7px;
      margin-top: 6px;
      padding: 2px 12px;
      background: #f9f9f9;
      font-size: 12px;
      text-align: left;
      font-weight: bold;
    }

    /* Tabel utama */
    .main-table {
      border-collapse: collapse;
      width: 100%;
      font-size: 11px;
      margin-bottom: 13px;
      text-align: center;
    }

    .main-table th,
    .main-table td {
      border: 2px solid #000;
      padding: 6px 5px;
      vertical-align: middle;
    }

    .main-table th {
      background: #f0f0f0;
      font-weight: bold;
      text-align: center;
    }

    /* Personil & Peralatan */
    .block-title {
      background: #f0f0f0;
      font-weight: bold;
      font-size: 15px;
      border: 2px solid #000;
      padding: 6px;
      text-align: center;
    }

    .center {
      text-align: center;
    }

    .left {
      text-align: left;
    }

    .block-sub {
      padding: 10px 13px;
      font-size: 11px;
    }

    /* Border semua bagian - seragam */
    .wo-info {
      font-size: 10px;
      font-weight: bold;
      border: 2px solid #000;
      display: inline-block;
      background: #fff;
      padding: 2px 8px;
      margin-bottom: 8px;
      margin-top: 6px;
    }

    /* Pengukuran dan Catatan */
    .ceklist-table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 0;
      table-layout: fixed;
      font-size: 12px;
    }

    .ceklist-table th,
    .ceklist-table td {
      border: 2px solid #000;
      padding: 12px 8px;
      text-align: left;
      vertical-align: middle;
    }

    .ceklist-table th {
      background: #f0f0f0;
      font-weight: bold;
      text-align: center;
    }

    .ceklist-status {
      width: 110px;
      text-align: center;
      vertical-align: middle;
    }

    .tugas-table {
      border-collapse: collapse;
      width: 100%;
      table-layout: fixed;
      font-size: 12px;
    }

    .tugas-table th,
    .tugas-table td {
      border: 2px solid #000;
      text-align: center;
      vertical-align: top;
      background: #fff;
    }

    .tugas-table th {
      background: #f0f0f0;
      font-weight: bold;
      font-size: 13px;
      vertical-align: middle;
      padding: 8px 6px;
    }

    .tugas-table td {
      padding: 16px 6px 4px 6px;
      width: 33.3%;
      height: 145px;
      position: relative;
    }

    .tugas-img {
      display: block;
      max-width: 100px;
      margin: 0 auto 8px auto;
    }

    .image-container {
      text-align: center;
      margin-bottom: 8px;
    }

    .text-container {
      text-align: center;
    }

    .image-nama {
      margin-bottom: 4px;
      font-weight: bold;
    }

    .image-facility {
      font-size: 10pt;
      color: #555;
    }

    /* Gambar Pengukuran */
    .gambar-pengukuran-section {
      margin-top: 20px;
      page-break-before: always;
    }

    .gambar-pengukuran-title {
      background: #f0f0f0;
      font-weight: bold;
      font-size: 15px;
      border: 2px solid #000;
      padding: 10px;
      text-align: center;
      margin-bottom: 15px;
    }

    .gambar-pengukuran-table {
      border-collapse: collapse;
      width: 100%;
      table-layout: fixed;
      font-size: 12px;
      margin-bottom: 20px;
    }

    .gambar-pengukuran-table th,
    .gambar-pengukuran-table td {
      border: 2px solid #000;
      text-align: center;
      vertical-align: top;
      background: #fff;
    }

    .gambar-pengukuran-table th {
      background: #f0f0f0;
      font-weight: bold;
      font-size: 13px;
      vertical-align: middle;
      padding: 10px 6px;
    }

    .gambar-pengukuran-table td {
      padding: 15px 6px 10px 6px;
      width: 33.3%;
      height: 160px;
    }

    .gambar-pengukuran-img {
      display: block;
      max-width: 120px;
      max-height: 100px;
      margin: 0 auto 8px auto;
      object-fit: contain;
    }

    .gambar-pengukuran-nama {
      font-weight: bold;
      margin-bottom: 5px;
      font-size: 11px;
    }

    .gambar-pengukuran-fasilitas {
      font-size: 10px;
      color: #555;
      margin-bottom: 3px;
    }

    .gambar-pengukuran-lokasi {
      font-size: 9px;
      color: #777;
      font-style: italic;
    }

    .page-break {
      page-break-after: always;
      height: 18px;
    }

    /* TTD */
    .ttd-section {
      width: 100%;
      margin-top: 8px;
      border-collapse: collapse;
      font-size: 12px;
    }

    .ttd-section td {
      width: 50%;
      text-align: center;
      vertical-align: top;
      padding: 22px 9px;
      border: 2px solid #000;
      font-weight: bold;
    }

    .ttd-placeholder {
      height: 45px;
    }

    .logo-img {
      max-height: 60px;
      width: auto;
      display: block;
      margin: 0 auto;
    }

    /* Header dan Footer Halaman */
    @media print {
      @page {
        size: 215.9mm 330.2mm; 
        margin: 5mm 10mm 13mm 10mm;
      }

      .page-header {
        position: fixed;
        top: -80px;
        left: 0;
        right: 0;
        height: 50px;
        text-align: center;
        border-bottom: 1px solid #000;
        background: white;
        z-index: 1000;
      }

      .page-footer {
        position: fixed;
        bottom: -30px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 12px;
        z-index: 1000;
      }
    }

    .no-wo-header {
      font-size: 12px;
      font-weight: bold;
      margin-bottom: 5px;
      padding-top: 10px;
    }

    .halaman-number {
      font-size: 12px;
      color: #333;
    }
  </style>
</head>

<body>
<div style="position: fixed; bottom: 6mm; left: 10mm; right: 10mm; text-align: right; font-size: 10px; font-weight: bold; z-index: 9999;" class="print-footer">
  <?= $no_wo ?? '-' ?>| Dicetak pada: <?= date('d-m-Y H:i:s')?>
</div>

  <div class="container">

    <!-- 2. TABEL KOP + INFO HEADER -->
    <table class="main-table"
      style="border-collapse: collapse; width: 100%; font-size: 11px; text-align: center; margin-bottom: 13px;">
      <tr>
        <td colspan="2" style="width:25%; height:55px; background:#fff; text-align:center; vertical-align:middle; padding:5px; border: 2px solid #000;">
          <img class="logo-img" src="<?= base_url('assets/injourney.png') ?>" alt="Logo Kiri" style="margin-top:10px;margin-left:20px;height:40px; text-align:center; vertical-align:middle;" onerror="this.style.display='none'">
        </td>
        <td colspan="6"
          style="width:75%; font-weight:bold; font-size:16px; text-align:center; background:#fff; vertical-align:middle; padding:10px; border: 2px solid #000;">
          PERINTAH KERJA<br />PEMELIHARAAN PENCEGAHAN
        </td>
      </tr>

      <!-- INFO UNIT SECTION -->
      <?php
      // Mendapatkan ID unit dari session atau dari data yang dikirim
      $unit_id = sess()['unit'];
      $atc_units = [14, 15, 16, 17];
      $is_atc = in_array($unit_id, $atc_units);
      ?>

      <?php if ($is_atc): ?>
        <!-- ATC VERSION (8 COLUMNS: 2-1-1-1-1-2) -->
        <tr style="background:#f0f0f0; font-weight:bold;">
          <th colspan="2" style="width:25%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Nomor WO</th>
          <th colspan="1" style="width:12.5%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Kode</th>
          <th colspan="1" style="width:12.5%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Unit</th>
          <th colspan="1" style="width:12.5%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Klasifikasi</th>
          <th colspan="1" style="width:12.5%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">ATC</th>
          <th colspan="2" style="width:25%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Tanggal</th>
        </tr>
        <tr>
          <td colspan="2" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($no_wo) ? $no_wo : '' ?></td>
          <td colspan="1" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($pm_type['kode']) ? $pm_type['kode'] : '' ?></td>
          <td colspan="1" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= sess()['unit_kode'] ?></td>
          <td colspan="1" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;">Preventive Maintenance</td>
          <td colspan="1" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($atc) ? $atc : '' ?></td>
          <td colspan="2" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($tanggal) ? $tanggal : '' ?></td>
        </tr>

      <?php else: ?>
        <!-- NON-ATC VERSION (8 COLUMNS: 2-1-2-1-2) -->
        <tr style="background:#f0f0f0; font-weight:bold;">
          <th colspan="2" style="width:25%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Nomor WO</th>
          <th colspan="1" style="width:12.5%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Kode</th>
          <th colspan="2" style="width:25%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Unit</th>
          <th colspan="1" style="width:12.5%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Klasifikasi</th>
          <th colspan="2" style="width:25%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Tanggal</th>
        </tr>
        <tr>
          <td colspan="2" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($no_wo) ? $no_wo : '' ?></td>
          <td colspan="1" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($pm_type['kode']) ? $pm_type['kode'] : '' ?></td>
          <td colspan="2" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= sess()['unit_kode'] ?></td>
          <td colspan="1" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;">Preventive Maintenance</td>
          <td colspan="2" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($tanggal) ? $tanggal : '' ?></td>
        </tr>
      <?php endif; ?>

      <?php if ($is_atc): ?>
        <tr style="background:#f0f0f0; font-weight:bold;">
          <th colspan="4" style="width:50%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Avsec Masuk</th>
          <th colspan="4" style="width:50%; border:2px solid #000; text-align:center; vertical-align:middle; padding:6px;">Avsec Keluar</th>
        </tr>
        <tr>
          <td colspan="4" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($avsec_masuk) ? $avsec_masuk : '-' ?></td>
          <td colspan="4" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;"><?= isset($avsec_keluar) ? $avsec_keluar : '-' ?></td>
        </tr>
      <?php endif; ?>

      <!-- JENIS TUGAS -->
      <tr>
        <th colspan="8"
          style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
          JENIS KEGIATAN
        </th>
      </tr>
      <tr>
        <td colspan="8"
          style="border:2px solid #000; text-align:left; vertical-align:top; padding:12px; font-size:13px; min-height:150px;">
          <div
            style="white-space: pre-wrap; word-wrap: break-word; line-height: 1.5; max-height: 140px; overflow-y: auto;">
            <?= !empty($deskripsi) ? htmlspecialchars($deskripsi) : '-' ?>
          </div>
        </td>
      </tr>

      <!-- PERSONIL: 8 kolom -->
      <tr>
        <th colspan="8"
          style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
          PERSONIL YANG MERAWAT
        </th>
      </tr>
      <tr>
        <td colspan="8" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:15px;">
          <div style="display:inline-block; text-align:left; max-width:600px; width:100%;">
            <?php 
            $no = 1;
            foreach (explode(",", $pelaksana) as $p) {
              $p = trim($p);
              if ($p !== "") {
                echo '<div style="font-size:14px; line-height:1.6;">' . $no++ . '. ' . $p . '</div>';
              }
            }
            ?>
          </div>
        </td>
      </tr>

      <!-- PERALATAN & LOKASI: 4+4=8 kolom -->
      <tr>
        <th colspan="4"
          style="width:50%; background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
          PERALATAN YANG DIRAWAT
        </th>
        <th colspan="4"
          style="width:50%; background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
          LOKASI KEGIATAN
        </th>
      </tr>
      <?php if (!empty($unique_fasilitas)): ?>
        <?php foreach ($unique_fasilitas as $item): ?>
          <tr>
            <td colspan="4" style="width:50%; border:2px solid #000; text-align:left; vertical-align:top; padding:8px 12px;">
               <?php echo htmlspecialchars($item['nama_fasilitas']); ?>
            </td>
            <td colspan="4" style="width:50%; border:2px solid #000; text-align:left; vertical-align:top; padding:8px 12px;">
              <?= htmlspecialchars($item['lokasi']) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" style="width:50%; border:2px solid #000; text-align:left; padding:12px;">
            <em style="color:#999;">-</em>
          </td>
          <td colspan="4" style="width:50%; border:2px solid #000; text-align:left; padding:12px;">
            <em style="color:#999;">-</em>
          </td>
        </tr>
      <?php endif; ?>

      <!-- Pengukuran -->
      <!-- <tr>
    <th colspan="7" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      PENGUKURAN PERALATAN
    </th>
  </tr>
  <tr>
    <td colspan="7" style="border:2px solid #000; height:35px; padding:8px; text-align:center;">
      <?php $pengukuran = array_filter(array_column($fasilitas, 'pengukuran'));
      if (!empty($pengukuran)):
        foreach ($pengukuran as $pengukur) {
          echo '<div>• ' . nl2br(htmlspecialchars($pengukur)) . '</div>';
        }
      else:
        echo '<div style="padding:8px 0;text-align:center;">Tidak ada data pengukuran</div>';
      endif; ?>
    </td>
  </tr> -->

      <!-- Catatan Perawatan -->
      <tr>
        <th colspan="8"
          style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
          CATATAN PERAWATAN
        </th>
      </tr>
      <tr>
        <td colspan="8" style="border:2px solid #000; min-height:45px; padding:12px; text-align:left; vertical-align:top;">
          <?php if (!empty($grouped_notes)): ?>
            <?php foreach ($grouped_notes as $group): ?>
              <div style="margin-bottom:6px; font-size:13px; line-height:1.4;">
                • <strong><?= htmlspecialchars($group['name']) ?>:</strong>
                <?php if (!empty($group['notes'])): ?>
                  <?php if (count($group['notes']) > 1): ?>
                    <ol style="margin-top:2px; margin-bottom:0; padding-left: 20px;">
                      <?php foreach ($group['notes'] as $note): ?>
                        <li><?= nl2br(htmlspecialchars($note)) ?></li>
                      <?php endforeach; ?>
                    </ol>
                  <?php else: ?>
                    <?= nl2br(htmlspecialchars($group['notes'][0])) ?>
                  <?php endif; ?>
                <?php else: ?>
                  -
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div style="text-align:center; color:#999; padding:5px 0;">-</div>
          <?php endif; ?>
        </td>
      </tr>
    </table>


    <!-- TTD Pengawas / Koordinator -->
    <table class="ttd-section">
      <tr>
        <td>
          <strong>DISETUJUI</strong><br>
          <strong>PT ANGKASA PURA INDONESIA</strong><br>
          <strong>PENGAWAS</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_api_file = $ttd_api ?? null;
              $ttd_api_path = FCPATH . 'doc/ttd_preventive/' . ($id_unit ?? '') . '/API/' . $ttd_api_file;
              if (!empty($ttd_api_file) && file_exists($ttd_api_path)):
            ?>
              <img src="<?= base_url('doc/ttd_preventive/' . ($id_unit ?? '') . '/API/' . $ttd_api_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD API">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></strong>
        </td>
        <td>
          <strong></strong><br>
          <strong>PT IAS SUPPORT INDONESIA</strong><br>
          <strong>KOORDINATOR</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_krd_file = $ttd_koordinator ?? null;
              $ttd_krd_path = FCPATH . 'doc/ttd_preventive/' . ($id_unit ?? '') . '/IASS/Koordinator/' . $ttd_krd_file;
              if (!empty($ttd_krd_file) && file_exists($ttd_krd_path)):
            ?>
              <img src="<?= base_url('doc/ttd_preventive/' . ($id_unit ?? '') . '/IASS/Koordinator/' . $ttd_krd_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Koordinator">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?></strong>
        </td>
      </tr>
    </table>

    <!-- DIV untuk page break -->
    <div class="page-break"></div>

    <div style="width: 100%;margin-bottom: 20px;">

      <!-- CEKLIST PEKERJAAN -->
      <table style="width: 100%; border-collapse: collapse; border: 2px solid #000; margin-top: 30px;">

        <tr>
          <th colspan="3"
            style="padding: 12px; border: 1px solid #000; background-color: #f0f0f0; text-align: left; font-size: 14px;">
            CEKLIST PEKERJAAN
          </th>
        </tr>

        <!-- Sub Header -->
        <tr>
          <th
            style="width:60%; padding: 10px; border-bottom: 1px solid #000; background-color: #f8f8f8; text-align: left; font-size: 12px;">
            PEKERJAAN
          </th>
          <th
            style="width:20%; padding: 10px; border-bottom: 1px solid #000; background-color: #f8f8f8; text-align: center; font-size: 12px;">
            PERALATAN
          </th>
          <th
            style="width:20%; padding: 10px; border-bottom: 1px solid #000; background-color: #f8f8f8; text-align: center; font-size: 12px;">
            STATUS
          </th>
        </tr>

        <?php if (!empty($job)):
          foreach ($job as $idx => $job_item): ?>
            <tr>
              <td style="padding: 8px 10px; border-bottom: 1px solid #ddd; font-size: 12px;">
                <?= ($idx + 1) ?>. <?= htmlspecialchars($job_item['nama_job']) ?>
              </td>
              <td style="padding: 8px 10px; border-bottom: 1px solid #ddd; font-size: 12px; text-align: center;">
                <?= htmlspecialchars($job_item['peralatan'] ?? '-') ?>
              </td>
              <td style="padding: 8px 10px; border-bottom: 1px solid #ddd; text-align: center; font-size: 12px;">
                <input type="checkbox" checked style="transform: scale(1.1); margin-right:5px;">
                <span>Selesai</span>
              </td>
            </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="3" style="padding: 15px; text-align: center; font-size: 12px;">
              <em>Tidak ada ceklist pekerjaan.</em>
            </td>
          </tr>
        <?php endif; ?>
      </table>

      <!-- DOKUMENTASI -->
      <table style="width: 100%; border-collapse: collapse; border: 2px solid #000;">
        <tr>
          <th colspan="3"
            style="padding: 8px; border: 1px solid #000; text-align: center; font-size: 16px; background-color: #f0f0f0;">
            Dokumentasi
          </th>
        </tr>
        <?php
        $all_images = [];

        // Ambil gambar dari dock (dokumentasi tugas) - path: upload/pm/
        if (!empty($dock)) {
          foreach ($dock as $job_id => $job) {
            foreach ($job['files'] as $file) {
              if (!empty($file['documentasi'])) {
                $all_images[] = [
                  'image' => $file['documentasi'],
                  'nama' => $job['nama'] ?? 'N/A',
                  'fasilitas' => $file['nama_fasilitas'] ?? '-',
                  'path' => 'upload/pm/', // Path untuk dokumentasi tugas
                  'type' => 'Tugas'
                ];
              }
            }
          }
        }

        // Ambil gambar dari dokumentasi_gambar_perawatan - path: upload/dokumentasi_gambar_perawatan/
        if (!empty($fasilitas)) {
          foreach ($fasilitas as $pm) {
            if (!empty($pm['dokumentasi_gambar_perawatan'])) {
              foreach ($pm['dokumentasi_gambar_perawatan'] as $gambar) {
                if (!empty($gambar['nama_dokumentasi_gambar_perawatan'])) {
                  $all_images[] = [
                    'image' => $gambar['nama_dokumentasi_gambar_perawatan'],
                    'nama' => 'Dokumentasi Perawatan',
                    'fasilitas' => $pm['nama_fasilitas'] ?? '-',
                    'path' => 'upload/dokumentasi_gambar_perawatan/', // Path untuk dokumentasi perawatan
                    'type' => 'Perawatan'
                  ];
                }
              }
            }
          }
        }

        // Tampilkan gambar jika ada
        if (!empty($all_images)) {
          $count = 0;
          $rows = [];

          // Group images by 3 per row
          foreach ($all_images as $image_data) {
            if ($count % 3 == 0) {
              $rows[] = [];
            }
            $rows[count($rows) - 1][] = $image_data;
            $count++;
          }

          // Display rows
          foreach ($rows as $rowIndex => $row) {
            echo '<tr>';
            for ($i = 0; $i < 3; $i++) {
              if (isset($row[$i])) {
                $image_path = $row[$i]['path'] . $row[$i]['image'];
                $full_path = base_url($image_path);

                echo '<td style="width: 33.33%; padding: 5px; border: 1px solid #000; vertical-align: top; text-align: center;">
            <div style="width: 200px; height: 270px; margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center;">
              <img src="' . $full_path . '" 
                   style="width: 100%; height: 100%; object-fit: cover;"
                   onerror="this.src=\'' . base_url("assets/img/default.jpg") . '\';" 
                   alt="Dokumentasi" />
            </div>
            <div style="text-align: center; margin-top: 3px;">
              <div style="font-weight: bold; font-size: 13px; line-height: 1.1;">
                ' . htmlspecialchars($row[$i]['nama']) . '
              </div>
              <div style="font-size: 11px; color: #333; line-height: 1.1; margin-top: 1px;">
                ' . htmlspecialchars($row[$i]['fasilitas']) . '
              </div>
            
            </div>
          </td>';
              } else {
                echo '<td style="width: 33.33%; padding: 5px; border: 1px solid #000; vertical-align: top;"></td>';
              }
            }
            echo '</tr>';
          }
        } else {
          // Jika tidak ada gambar sama sekali
          echo '<tr>
            <td colspan="3" style="padding: 15px; text-align: center; border: 1px solid #000;">
              <em>Tidak ada dokumentasi.</em>
            </td>
          </tr>';
        }
        ?>
      </table>

    </div>

    <!-- TTD Pengawas & Pelaksana -->
    <!-- TTD Pengawas / Koordinator -->
    <table class="ttd-section">
      <tr>
        <td>
          <strong>PT ANGKASA PURA INDONESIA</strong><br>
          <strong>PENGAWAS I/II</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_api_file = $ttd_api ?? null;
              $ttd_api_path = FCPATH . 'doc/ttd_preventive/' . ($id_unit ?? '') . '/API/' . $ttd_api_file;
              if (!empty($ttd_api_file) && file_exists($ttd_api_path)):
            ?>
              <img src="<?= base_url('doc/ttd_preventive/' . ($id_unit ?? '') . '/API/' . $ttd_api_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD API">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></strong>
        </td>
        <td>
          <strong>Hari / tanggal : <?= $tanggal ?></strong><br>
          <strong>PELAKSANA</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_pel_file = $ttd_pelaksana ?? null;
              $ttd_pel_path = FCPATH . 'doc/ttd_preventive/' . ($id_unit ?? '') . '/IASS/Pelaksana/' . $ttd_pel_file;
              if (!empty($ttd_pel_file) && file_exists($ttd_pel_path)):
            ?>
              <img src="<?= base_url('doc/ttd_preventive/' . ($id_unit ?? '') . '/IASS/Pelaksana/' . $ttd_pel_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Pelaksana">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong> <?= strtoupper($nama_pelaksana_yang_ttd ?? 'NAMA PELAKSANA') ?></strong>
        </td>
      </tr>
    </table>






    <!-- GAMBAR PENGUKURAN -->
    <?php
    // Cek apakah ada gambar pengukuran
    $hasGambarPengukuran = false;
    $allGambar = [];

    // Kumpulkan semua gambar dari semua fasilitas
    foreach ($fasilitas as $item) {
      if (!empty($item['gambar_pengukuran'])) {
        foreach ($item['gambar_pengukuran'] as $gambar) {
          $allGambar[] = [
            'gambar' => $gambar['nama_gambar_pengukuran'],
            'nama_fasilitas' => !empty($gambar['nama_fasilitas']) ? $gambar['nama_fasilitas'] : $item['nama_fasilitas'],
            'fasilitas_id' => $item['id_fasilitas'] ?? null
          ];
        }
        $hasGambarPengukuran = true;
      }
    }

    if ($hasGambarPengukuran):
      // 1 gambar per halaman
      $gambarPerHalaman = 1;
      $totalHalaman = ceil(count($allGambar) / $gambarPerHalaman);

      for ($halaman = 1; $halaman <= $totalHalaman; $halaman++):
        $startIndex = ($halaman - 1) * $gambarPerHalaman;
        $endIndex = min($startIndex + $gambarPerHalaman, count($allGambar));
        ?>
        <div class="gambar-pengukuran-section" style="margin-top: 10px; page-break-before: always;">

          <table class="gambar-pengukuran-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
              <th colspan="1" style="text-align: center; padding: 20px; font-size: 18px; border-radius: 0;">
                DOKUMENTASI HASIL PENGUKURAN
              </th>
            </tr>

            <?php
            // Loop melalui gambar - SATU GAMBAR PER HALAMAN
            for ($i = $startIndex; $i < $endIndex; $i++):
              if (isset($allGambar[$i])):
                $gambar = $allGambar[$i];
                $image_path = 'upload/gambar_pengukuran/' . $gambar['gambar'];
                $full_path = base_url($image_path);
                ?>
                <tr class="gambar-item">
                  <td class="gambar-cell"
                    style="width: 100%; padding: 20px; vertical-align: top; border: none; page-break-inside: avoid; page-break-after: always;">
                    <div class="gambar-container"
                      style="text-align: center; margin: 0 auto; border: 2px solid #000; border-radius: 0; padding: 0; width: 100%; max-width: 30cm;">
                      <div tyle="margin: 0; padding: 0;">
                        <img src="<?php echo $full_path; ?>" style="width: 34cm; height: 24cm; 
                                    border: none; border-radius: 0; padding: 0;
                                    background-color: white; display: block; 
                                    max-width: 100%; object-fit: contain;"
                          onerror="this.src='<?php echo base_url('assets/img/default.jpg'); ?>';"
                          alt="Gambar Pengukuran - <?php echo htmlspecialchars($gambar['nama_fasilitas']); ?>" />
                      </div>
                    </div>
                  </td>
                </tr>
                <?php
              endif;
            endfor;
            ?>

          </table>


        </div>
      <?php
      endfor; // End loop halaman
    else:
      ?>
      <div style="text-align: center; padding: 50px; color: #999;">
        <em style="font-size: 16px;"></em>
      </div>
    <?php endif; ?>






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