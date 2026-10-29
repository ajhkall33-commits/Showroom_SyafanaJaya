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
  <div class="page-break"></div>

  <!-- Ceklist pekerjaan -->
  <!-- <span class="wo-info">
    WO: <?= $no_wo ?><br/>Tgl: <?= $tanggal ?>
  </span> -->
  <table class="ceklist-table">
    <tr>
      <th style="width:80%;">CEKLIST PEKERJAAN</th>
      <th class="ceklist-status" style="width:20%;">STATUS</th>
    </tr>
    <?php if (!empty($job)): foreach ($job as $idx => $job_item): ?>
    <tr>
      <td class="left">
        <?= ($idx+1) ?>. <?= htmlspecialchars($job_item['nama_job']) ?>
      </td>
      <td class="ceklist-status">
        <input type="checkbox" checked style="transform: scale(1.2); margin-right:6px;"> 
        <span>Selesai</span>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr>
      <td colspan="2" class="center"><em>Tidak ada ceklist pekerjaan.</em></td>
    </tr>
    <?php endif; ?>
  </table>

  <!-- Tugas yang diberikan -->
  <table class="tugas-table">
    <tr>
      <th colspan="3">TUGAS YANG DIBERIKAN</th>
    </tr>
    <?php
    if (!empty($dock)) {
      $count = 0;
      foreach ($dock as $job_id => $job) {
        foreach ($job['files'] as $file) {
          if($count % 3 == 0) echo '<tr>';
          $image_path = 'upload/pm/'.$file['documentasi'];
          $full_path = base_url($image_path);
          echo '<td>
            <div class="image-container">
              <img src="'.$full_path.'" class="tugas-img" onerror="this.src=\''.base_url("assets/img/default.jpg").'\';" />
            </div>
            <br><br><br><br><br><br><br>
            <div class="text-container">
              <div class="image-nama">'.htmlspecialchars($job['nama'] ?? 'N/A').'</div>
              <div class="image-facility">'.htmlspecialchars($file['nama_fasilitas'] ?? '-').'</div>
            </div>
          </td>';
          $count++;
          if($count % 3 == 0) echo '</tr>';
        }
      }
      if($count % 3 != 0) {
        while($count % 3 != 0) { echo '<td></td>'; $count++; }
        echo '</tr>';
      }
    } else {
      echo '<tr><td colspan="3" class="center"><em>Tidak ada dokumentasi tugas.</em></td></tr>';
    }
    ?>
  </table>

  <!-- TTD Pengawas & Pelaksana (bawah tugas) -->
  <table class="ttd-section">
    <tr>
      <td>
        <strong>PENGAWAS</strong>
        <div class="ttd-placeholder"></div>
        <p>_________________________</p>
        <strong><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></strong>
      </td>
      <td>
        <strong>PELAKSANA</strong>
        <div class="ttd-placeholder"></div>
        <p>_________________________</p>
        <strong><?= strtoupper($nama_pelaksana_yang_ttd ?? 'NAMA PELAKSANA') ?></strong>
      </td>
    </tr>
  </table>

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
  <div class="gambar-pengukuran-section">
    <!-- <div class="wo-info">
      WO: <?= $no_wo ?><br/>Tgl: <?= $tanggal ?>
    </div> -->
    
    <div class="gambar-pengukuran-title">GAMBAR PENGUKURAN</div>
    
    <table class="gambar-pengukuran-table">
      <tr>
        <th colspan="3">DOKUMENTASI HASIL PENGUKURAN</th>
      </tr>
      <?php
      $totalGambar = 0;
      
      // Loop melalui semua fasilitas
      foreach ($fasilitas as $item) {
        if (!empty($item['gambar_pengukuran'])) {
          foreach ($item['gambar_pengukuran'] as $gambar) {
            if($totalGambar % 3 == 0) echo '<tr>';
            
            $image_path = 'upload/gambar_pengukuran/'.$gambar['nama_gambar_pengukuran'];
            $full_path = base_url($image_path);
            
            echo '<td>
              <div class="image-container">
                <img src="'.$full_path.'" class="gambar-pengukuran-img" 
                     onerror="this.src=\''.base_url("assets/img/default.jpg").'\';" 
                     alt="Gambar Pengukuran" />
              </div>
              <div class="text-container">
                <div class="gambar-pengukuran-nama">'.htmlspecialchars($item['nama_fasilitas'] ?? '-').'</div>
                <div class="gambar-pengukuran-fasilitas">Lokasi: '.htmlspecialchars($item['lokasi'] ?? '-').'</div>
                <div class="gambar-pengukuran-lokasi">'.htmlspecialchars($gambar['nama_gambar_pengukuran'] ?? '').'</div>
              </div>
            </td>';
            
            $totalGambar++;
            if($totalGambar % 3 == 0) echo '</tr>';
          }
        }
      }
      
      // Tambah sel kosong jika perlu
      if($totalGambar % 3 != 0) {
        while($totalGambar % 3 != 0) { 
          echo '<td></td>'; 
          $totalGambar++; 
        }
        echo '</tr>';
      }
      
      // Jika tidak ada gambar sama sekali
      if($totalGambar == 0): ?>
      <tr>
        <td colspan="3" class="center">
          <em>Tidak ada gambar pengukuran</em>
        </td>
      </tr>
      <?php endif; ?>
    </table>
    
    <!-- TTD tambahan untuk halaman gambar pengukuran -->
    <table class="ttd-section">
      <tr>
        <td>
          <strong>PENGAWAS</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></strong>
        </td>
        <td>
          <strong>PELAKSANA</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pelaksana_yang_ttd ?? 'NAMA PELAKSANA') ?></strong>
        </td>
      </tr>
    </table>
  </div>
  <?php endif; ?>

</div>
</body>
</html>