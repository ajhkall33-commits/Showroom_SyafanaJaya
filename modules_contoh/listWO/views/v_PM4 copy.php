<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <title>Perintah Kerja PM</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 11pt;
    }
    .container { max-width: 210mm; margin: 0 auto; }
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
    .main-table th, .main-table td {
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
    .ceklist-table th, .ceklist-table td {
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
    .tugas-table th, .tugas-table td {
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
    .gambar-pengukuran-table th, .gambar-pengukuran-table td {
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
  </style>
</head>
<body>
<div class="container">

  <!-- 1. KOP: Box WO/Tanggal untuk halaman utama -->
  <!-- <div class="wo-info">
    WO: <?= $no_wo ?><br/>Tgl: <?= $tanggal ?>
  </div> -->

  <!-- 2. TABEL KOP + INFO HEADER -->
<table class="main-table" style="border-collapse: collapse; width: 100%; font-size: 11px; text-align: center; margin-bottom: 13px;">
  <tr>
    <td colspan="2" style="width:20%; height:55px; background:#fff; border: 2px solid #000; text-align:center; vertical-align:middle;">
      <img class="logo-img" src="<?= ImageLogo('1') ?>" alt="Logo Kiri" style="height:44px;">
    </td>
    <td colspan="3" style="font-weight:bold; font-size:13px; width:60%; text-align:center; background:#fff; border: 2px solid #000; vertical-align:middle;">
      PERINTAH KERJA<br/>PEMELIHARAAN PENCEGAHAN
    </td>
    <td colspan="2" style="width:20%; background:#fff; border: 2px solid #000; text-align:center; vertical-align:middle;">
      <img class="logo-img" src="<?= ImageLogo('2') ?>" alt="Logo Kanan" style="height:44px;">
    </td>
  </tr>
  <tr style="background:#f0f0f0; font-weight:bold; border: 2px solid #000;">
    <th style="border: 2px solid #000; text-align:center; vertical-align:middle;">Kode Unit</th>
    <th style="border: 2px solid #000; text-align:center; vertical-align:middle;">Kode</th>
    <th style="border: 2px solid #000; text-align:center; vertical-align:middle;">Klasifikasi</th>
    <th colspan="2" style="border: 2px solid #000; text-align:center; vertical-align:middle;">Nomor</th>
    <th colspan="2" style="border: 2px solid #000; text-align:center; vertical-align:middle;">Tanggal</th>
  </tr>
  <tr style="border: 2px solid #000;">
    <td style="border: 2px solid #000; text-align:center; vertical-align:middle;"><?= sess()['unit_kode'] ?></td>
    <td style="border: 2px solid #000; text-align:center; vertical-align:middle;"><?= $pm_type['kode'] ?></td>
    <td style="border: 2px solid #000; text-align:center; vertical-align:middle;">Preventive Maintenance</td>
    <td colspan="2" style="border: 2px solid #000; text-align:center; vertical-align:middle;"><?= $no_wo ?></td>
    <td colspan="2" style="border: 2px solid #000; text-align:center; vertical-align:middle;"><?= $tanggal ?></td>
  </tr>
  <tr>
    <th colspan="7" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      JENIS / TUGAS YANG DIBERIKAN
    </th>
  </tr>
  <tr>
  <td colspan="7" style="border:2px solid #000; text-align:left; vertical-align:top; padding:12px; font-size:13px; min-height:150px;">
  <div style="white-space: pre-wrap; word-wrap: break-word; line-height: 1.5; max-height: 140px; overflow-y: auto;">
    <?= !empty($deskripsi) ? htmlspecialchars($deskripsi) : '-' ?>
  </div>
</td>
  </tr>
  <!-- Personil -->
  <tr>
    <th colspan="7" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      PERSONIL YANG DITUGASKAN
    </th>
  </tr>
  <tr>
  <td colspan="7" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;">
  <div style="display:inline-block; text-align:left; max-width:400px; width:100%;">
    <ol style="margin:0; padding-left:15px; font-size:14px;">
      <?php foreach (explode(",",$pelaksana) as $p) {
        if(trim($p)!=="") echo '<li>'.trim($p).'</li>';
      } ?>
    </ol>
  </div>
</td>


  </tr>

  <!-- Lokasi/Peralatan -->
  <tr>
    <th colspan="4" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      PERALATAN
    </th>
    <th colspan="3" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      LOKASI
    </th>
  </tr>
  <tr>
   <td colspan="4" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;">
  <div style="display:inline-block; text-align:left; max-width:400px; margin: 0 auto;">
    <ul style="margin:0; padding-left:15px; font-size:14px;">
      <?php foreach($fasilitas as $item): ?>
        <li><?= $item['nama_fasilitas'] ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</td>

 <td colspan="3" style="border:2px solid #000; text-align:center; vertical-align:middle; padding:8px;">
  <div style="display:inline-block; text-align:left; max-width:400px; margin: 0 auto;">
    <ul style="margin:0; padding-left:15px; font-size:14px;">
      <?php foreach($fasilitas as $item): ?>
        <li><?= $item['lokasi'] ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</td>

  </tr>

  <!-- Pengukuran -->
  <!-- <tr>
    <th colspan="7" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      PENGUKURAN PERALATAN
    </th>
  </tr>
  <tr>
    <td colspan="7" style="border:2px solid #000; height:35px; padding:8px; text-align:center;">
      <?php $pengukuran = array_filter(array_column($fasilitas, 'pengukuran'));
      if(!empty($pengukuran)): foreach($pengukuran as $pengukur)
        { echo '<div>• '.nl2br(htmlspecialchars($pengukur)).'</div>'; }
      else: echo '<div style="padding:8px 0;text-align:center;">Tidak ada data pengukuran</div>';
      endif; ?>
    </td>
  </tr> -->

  <!-- Catatan Perawatan -->
  <tr>
    <th colspan="7" style="background:#f0f0f0; font-weight:bold; font-size:15px; border:2px solid #000; padding:6px; text-align:center;">
      CATATAN PERAWATAN
    </th>
  </tr>
  <tr>
    <td colspan="7" style="border:2px solid #000; height:35px; padding:8px; text-align:center;">
      <?php $catatan_perawatan = array_filter(array_column($fasilitas, 'catatan_perawatan'));
      if(!empty($catatan_perawatan)): foreach($catatan_perawatan as $catatan)
        { echo '<div>• '.nl2br(htmlspecialchars($catatan)).'</div>'; }
      else: echo '<div style="padding:8px 0;text-align:center;">Tidak ada catatan perawatan</div>';
      endif; ?>
    </td>
  </tr>
</table>


  <!-- TTD Pengawas / Koordinator -->
  <table class="ttd-section">
    <tr>
      <td>
        <strong>PENGAWAS</strong>
        <div class="ttd-placeholder"></div>
        <p>_________________________</p>
        <strong><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></strong>
      </td>
      <td>
        <strong>KOORDINATOR</strong>
        <div class="ttd-placeholder"></div>
        <p>_________________________</p>
        <strong><?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?></strong>
      </td>
    </tr>
  </table>
  <!-- <div class="page-break"></div> -->

<!-- GAMBAR PENGUKURAN -->
<?php
// Cek apakah ada gambar pengukuran
$hasGambarPengukuran = false;
foreach ($fasilitas as $item) {
  if (!empty($item['gambar_pengukuran'])) {
    $hasGambarPengukuran = true;
    break;
  }
}

if ($hasGambarPengukuran): ?>
<div class="gambar-pengukuran-section"style =" border: 1px solid #000000;">
  <style>
    @media print {
      .gambar-pengukuran-section {
        page-break-inside: avoid;
      }
      .gambar-pengukuran-table td {
        page-break-inside: avoid;
      }
    }
  </style>
  
  <table class="gambar-pengukuran-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
      <th style="text-align: center; padding: 20px;  font-size: 18px; border-radius: 0;">
        DOKUMENTASI HASIL PENGUKURAN
      </th>
    </tr>
    <?php
    $totalGambar = 0;
    
    // Loop melalui semua fasilitas
    foreach ($fasilitas as $item) {
      if (!empty($item['gambar_pengukuran'])) {
        foreach ($item['gambar_pengukuran'] as $gambar) {
          // 1 gambar per baris
          if($totalGambar % 1 == 0) echo '<tr>';
          
          $image_path = 'upload/gambar_pengukuran/'.$gambar['nama_gambar_pengukuran'];
          $full_path = base_url($image_path);
          
          echo '<td style="width: 100%; padding: 30px 0; vertical-align: top; border: none; page-break-inside: avoid;">
                  <div style="text-align: center; margin: 0 auto; border: 2px solid #000; border-radius: 0; padding: 0;">
                    <div style="margin: 0; padding: 0;">
                      <img src="'.$full_path.'" 
                           style="width: 100%; height: auto; 
                                  border: none; border-radius: 0; padding: 0;
                                  background-color: white; display: block;"
                           onerror="this.src=\''.base_url("assets/img/default.jpg").'\';" 
                           alt="Gambar Pengukuran" />
                    </div>
                    <div style="padding: 15px; margin: 0; background-color: white; border-radius: 0; border-top: 2px solid #000; text-align: left;">
                      <div style="font-weight: bold; font-size: 18px; margin-bottom: 5px; color: #000;">
                        '.htmlspecialchars($item['nama_fasilitas'] ?? '-').'
                      </div>
                      <div style="font-size: 15px; color: #000; margin-bottom: 5px;">
                        <strong>Lokasi:</strong> '.htmlspecialchars($item['lokasi'] ?? '-').'
                      </div>
                      <div style="font-size: 14px; color: #333; padding-top: 8px; border-top: 1px solid #ccc;">
                        '.htmlspecialchars($gambar['nama_gambar_pengukuran'] ?? '').'
                      </div>
                    </div>
                  </div>
                </td>';
          
          $totalGambar++;
          if($totalGambar % 1 == 0) echo '</tr>';
        }
      }
    }
    
    // Jika tidak ada gambar sama sekali
    if($totalGambar == 0): ?>
    <tr>
      <td style="text-align: center; padding: 50px; color: #999; border: none;">
        <em style="font-size: 16px;">Tidak ada gambar pengukuran</em>
      </td>
    </tr>
    <?php endif; ?>
  </table>
</div>
<?php endif; ?>

 <div class="page-break"></div>


<div style="width: 100%; border: 2px solid #000; margin-bottom: 20px;">
  
  <!-- CEKLIST PEKERJAAN -->
  <table style="width: 100%; border-collapse: collapse; border-bottom: 2px solid #000;">
    <!-- Header Ceklist -->
    <tr>
      <th colspan="3" style="padding: 12px; border-bottom: 1px solid #000; background-color: #f0f0f0; text-align: left; font-size: 14px;">
        CEKLIST PEKERJAAN
      </th>
    </tr>
    
    <!-- Sub Header -->
    <tr>
      <th style="width:60%; padding: 10px; border-bottom: 1px solid #000; background-color: #f8f8f8; text-align: left; font-size: 12px;">
        PEKERJAAN
      </th>
      <th style="width:20%; padding: 10px; border-bottom: 1px solid #000; background-color: #f8f8f8; text-align: center; font-size: 12px;">
        PERALATAN
      </th>
      <th style="width:20%; padding: 10px; border-bottom: 1px solid #000; background-color: #f8f8f8; text-align: center; font-size: 12px;">
        STATUS
      </th>
    </tr>
    
    <?php if (!empty($job)): foreach ($job as $idx => $job_item): ?>
    <tr>
      <td style="padding: 8px 10px; border-bottom: 1px solid #ddd; font-size: 12px;">
        <?= ($idx+1) ?>. <?= htmlspecialchars($job_item['nama_job']) ?>
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
  <table style="width: 100%; border-collapse: collapse;">
    <tr>
      <th colspan="3" style="padding: 15px; border-bottom: 2px solid #000; text-align: center; font-size: 16px; background-color: #f0f0f0;">
        Dokumentasi
      </th>
    </tr>
    <?php
    if (!empty($dock)) {
      $count = 0;
      $rows = [];
      
      // Group images by 3 per row
      foreach ($dock as $job_id => $job) {
        foreach ($job['files'] as $file) {
          if($count % 3 == 0) {
            $rows[] = [];
          }
          $rows[count($rows)-1][] = [
            'image' => $file['documentasi'],
            'nama' => $job['nama'] ?? 'N/A',
            'fasilitas' => $file['nama_fasilitas'] ?? '-'
          ];
          $count++;
        }
      }
      
      // Display rows
      foreach ($rows as $rowIndex => $row) {
        echo '<tr>';
        for ($i = 0; $i < 3; $i++) {
          if (isset($row[$i])) {
            $image_path = 'upload/pm/'.$row[$i]['image'];
            $full_path = base_url($image_path);
           echo '<td style="width: 33.33%; padding: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: top; text-align: center; ' . ($i == 2 ? 'border-right: none;' : '') . '">
        <div style="margin-bottom: 30px; height: 60vh; display: flex; align-items: center; justify-content: center;">
          <img src="'.$full_path.'" 
               style="max-width:95%;max-height:90%;width:auto;height:auto;object-fit:contain;display:block;"
               onerror="this.src=\''.base_url("assets/img/default.jpg").'\';" 
               alt="Dokumentasi" />
        </div>
        <div style="text-align: center;">
          <div style="font-weight: bold; font-size: 14px; margin-bottom: 5px;">
            '.htmlspecialchars($row[$i]['nama']).'
          </div>
          <div style="font-size: 12px; color: #333;">
            '.htmlspecialchars($row[$i]['fasilitas']).'
          </div>
        </div>
      </td>';

          } else {
            echo '<td style="width: 33.33%; padding: 20px; border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: top; ' . ($i == 2 ? 'border-right: none;' : '') . '"></td>';
          }
        }
        echo '</tr>';
      }
      
      // Jika tidak ada data sama sekali
      if ($count == 0) {
        echo '<tr>
                <td colspan="3" style="padding: 40px; text-align: center;">
                  <em>Tidak ada dokumentasi tugas.</em>
                </td>
              </tr>';
      }
    } else {
      echo '<tr>
              <td colspan="3" style="padding: 40px; text-align: center;">
                <em>Tidak ada dokumentasi tugas.</em>
              </td>
            </tr>';
    }
    ?>
  </table>
  
</div>

<!-- TTD Pengawas & Pelaksana -->
<table style="width: 100%; border-collapse: collapse; margin-top: 40px;">
  <tr>
    <td style="width: 50%; padding: 20px; text-align: center; vertical-align: top;">
      <div style="margin-bottom: 15px;">
        <strong>PENGAWAS</strong>
      </div>
      <div style="height: 60px; margin-bottom: 10px;"></div>
      <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
        <?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?>
      </div>
    </td>
    <td style="width: 50%; padding: 20px; text-align: center; vertical-align: top;">
      <div style="margin-bottom: 15px;">
        <strong>PELAKSANA</strong>
      </div>
      <div style="height: 60px; margin-bottom: 10px;"></div>
      <div style="border-top: 1px solid #000; width: 200px; margin: 0 auto; padding-top: 5px;">
        <?= strtoupper($nama_pelaksana_yang_ttd ?? 'NAMA PELAKSANA') ?>
      </div>
    </td>
  </tr>
</table>
 
</div>
</body>
</html>