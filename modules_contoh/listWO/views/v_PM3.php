<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perintah Kerja PM</title>
    <style type="text/css">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            font-size: 11pt;
            line-height: 1.4;
        }
        
        .container {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
        }
        
        .main-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;
            table-layout: fixed;
        }
        
        .main-table th, .main-table td {
            border: 1px solid black;
            padding: 6px 4px;
            vertical-align: top;
            text-align: center;
        }
        
        .main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .tg-center { text-align: center; }
        .tg-left { text-align: left; }
        
        .logo-img {
            max-height: 60px;
            width: auto;
            display: block;
            margin: 0 auto;
        }
        
        .job-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
            text-align: left;
        }
        
        .job-status {
            padding-left: 3px;
            text-align: left;
            margin: 8px 0;
        }
        
        .job-notes {
            padding-left: 3px;
            text-align: left;
            font-size: 11px;
            margin-top: 8px;
        }
        
        .divider {
            border: 0.5px solid #ccc;
            margin: 12px 0;
        }
        
        .image-cell {
            width: 33.33%;
            padding: 4px;
            vertical-align: top;
        }
        
        .image-container {
            height: 120px;
            text-align: center;
        }
        
        .image-name {
            text-align: center;
            font-weight: bold;
            margin-top: 6px;
            font-size: 10px;
        }
        
        .image-facility {
            text-align: center;
            font-size: 9px;
            margin-top: 2px;
        }
        
        .ttd-section {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        .ttd-section td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 15px;
        }
        
        .ttd-placeholder {
            height: 80px;
            margin-bottom: 5px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .section-spacer {
            height: 10px;
            border: none !important;
        }
        
        @media print {
            body {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                padding: 5mm;
            }
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
<div class="container">

<!-- TABEL UTAMA YANG MENYATUKAN SEMUA -->
<table class="main-table">
  <!-- ===== HALAMAN 1 ===== -->
  <!-- KOP SURAT -->
  <tr>
    <td colspan="2" style="height:75px; width:20%;">
        <img class="logo-img" src="<?=ImageLogo('1')?>" alt="Logo Kiri" />
    </td>
    <td colspan="3" style="font-weight:bold; font-size:13px; width:60%;">
      PERINTAH KERJA<br />PEMELIHARAAN PENCEGAHAN
    </td>
    <td colspan="2" style="width:20%;">
        <img class="logo-img" src="<?=ImageLogo('2')?>" alt="Logo Kanan" />
    </td>
  </tr>

  <!-- HEADER DATA -->
  <tr>
    <th style="width:14%;">Kode Unit</th>
    <th style="width:14%;">Kode</th>
    <th style="width:20%;">Klasifikasi</th>
    <th colspan="2" style="width:24%;">Nomor</th>
    <th colspan="2" style="width:28%;">Tanggal</th>
  </tr>
  
  <tr>
    <td><?= sess()['unit_kode'] ?></td>
    <td><?=$pm_type['kode']?></td>
    <td>Preventive Maintenance</td>
    <td colspan="2"><?=$no_wo?></td>
    <td colspan="2"><?=$harisplit?> <?=$tanggal?></td>
  </tr>
  
  <!-- PERSONIL -->
  <tr>
    <th colspan="7">PERSONIL YANG DITUGASKAN</th>
  </tr>
  
  <tr>
    <td colspan="7" class="tg-left">
        <ol style="margin:0; padding-left: 20px;">
            <?php 
                $personil = explode(",", $pelaksana);
                foreach ($personil as $nama) {
                    echo '<li style="padding:2px 0;">' . trim($nama) . '</li>';
                }
            ?>
        </ol>
    </td>
  </tr>
  
  <!-- PERALATAN -->
  <tr>
    <th colspan="4">NAMA PERALATAN</th>
    <th colspan="3">LOKASI</th>
  </tr>
  
  <?php foreach($fasilitas as $item): ?>
  <tr>
    <td colspan="4" class="tg-left"><?= $item['nama_fasilitas'] ?></td>
    <td colspan="3" class="tg-left"><?= $item['lokasi'] ?></td>
  </tr>
  <?php endforeach; ?>

  <!-- SPACER -->
  <tr class="section-spacer">
    <td colspan="7" style="border: none; height: 10px;"></td>
  </tr>

  <!-- CEKLIST PEKERJAAN - Halaman 1 -->
  <tr>
    <th colspan="7">CEKLIST PEKERJAAN</th>
  </tr>
  
  <tr>
    <td colspan="7" class="tg-left">
        <div style="padding:8px;">
            <?php if (!empty($job)): ?>
                <?php 
                $first_page_jobs = array_slice($job, 0, 8);
                ?>
                
                <?php foreach ($first_page_jobs as $index => $job_item): ?>
                <div>
                    <div class="job-title">
                        <?= $index + 1 ?>. <?= htmlspecialchars($job_item['nama_job'] ?? 'Pekerjaan') ?>
                    </div>   
                    
                    <div class="job-status">
                        <input type="checkbox" checked style="transform: scale(1.1); margin-right: 8px;">
                        <label style="font-weight: bold;">Selesai</label>
                    </div>

                    <div class="job-notes">
                        <span style="font-weight: bold;">Catatan :</span>
                        <span>...........................</span>
                    </div>

                    <?php if ($index < 7): ?>
                    <hr class="divider">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 15px;">
                    Tidak ada data pekerjaan
                </div>
            <?php endif; ?>
        </div>
    </td>
  </tr>

  <!-- ===== HALAMAN 2 ===== -->
  <!-- CEKLIST PEKERJAAN LANJUTAN -->
  <?php 
  $second_page_jobs = array_slice($job, 8, 10);
  if (!empty($second_page_jobs)): 
  ?>
  <tr class="page-break">
    <th colspan="7">CEKLIST PEKERJAAN (Lanjutan)</th>
  </tr>
  
  <tr>
    <td colspan="7" class="tg-left">
        <div style="padding:8px;">
            <?php foreach ($second_page_jobs as $index => $job_item): ?>
            <div>
                <div class="job-title">
                    <?= $index + 9 ?>. <?= htmlspecialchars($job_item['nama_job'] ?? 'Pekerjaan') ?>
                </div>   
                
                <div class="job-status">
                    <input type="checkbox" checked style="transform: scale(1.1); margin-right: 8px;">
                    <label style="font-weight: bold;">Selesai</label>
                </div>

                <div class="job-notes">
                    <span style="font-weight: bold;">Catatan :</span>
                    <span>...........................</span>
                </div>

                <?php if ($index < count($second_page_jobs) - 1): ?>
                <hr class="divider">
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </td>
  </tr>
  <?php endif; ?>

  <!-- SPACER -->
  <tr class="section-spacer">
    <td colspan="7" style="border: none; height: 10px;"></td>
  </tr>

  <!-- ===== HALAMAN 3 ===== -->
  <!-- TUGAS YANG DIBERIKAN - Halaman 1 -->
  <tr class="page-break">
    <th colspan="7">TUGAS YANG DIBERIKAN</th>
  </tr>
  
  <tr>
    <td colspan="7" style="padding:0;">
        <table style="width:100%; border-collapse:collapse; border:none;">
        <?php if (!empty($dock)): ?>
            <?php 
            $count = 0;
            $first_page_images = 9;
            $total_images = 0;
            
            foreach ($dock as $job_id => $job) {
                $total_images += count($job['files']);
            }
            
            $image_count = 0;
            foreach ($dock as $job_id => $job):
                foreach ($job['files'] as $file):
                    if ($image_count >= $first_page_images) break;
                    
                    if ($count % 3 == 0) {
                        echo '<tr style="border:none;">';
                    }
                    
                    $image_path = 'upload/pm/'.$file['documentasi'];
                    $full_path = base_url($image_path);
            ?>
                    <td class="image-cell" style="border:1px solid black;">
                        <div class="image-container">
                            <img src="<?= $full_path ?>" 
                                 style="height:120px; max-width:120px; width:auto; object-fit:contain; display:block; margin:0 auto;"
                                 onerror="this.src='<?= base_url('assets/img/default.jpg') ?>'">
                        </div>
                        <div class="image-name"><?= htmlspecialchars($job['nama'] ?? 'N/A') ?></div>
                        <div class="image-facility"><?= htmlspecialchars($file['nama_fasilitas'] ?? '-') ?></div>
                    </td>
            <?php
                    $count++;
                    $image_count++;
                    
                    if ($count % 3 == 0) {
                        echo '</tr>';
                    }
                endforeach;
                if ($image_count >= $first_page_images) break;
            endforeach;
            
            if ($count % 3 != 0) {
                while ($count % 3 != 0) {
                    echo '<td class="image-cell" style="border:1px solid black;"></td>';
                    $count++;
                }
                echo '</tr>';
            }
            ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center; padding:15px;">
                    Tidak ada data dokumentasi
                </td>
            </tr>
        <?php endif; ?>
        </table>
    </td>
  </tr>

  <!-- ===== HALAMAN 4 ===== -->
  <!-- TUGAS YANG DIBERIKAN - Halaman 2 -->
  <?php if (!empty($dock) && $total_images > 9): ?>
  <tr class="page-break">
    <th colspan="7">TUGAS YANG DIBERIKAN (Lanjutan)</th>
  </tr>
  
  <tr>
    <td colspan="7" style="padding:0;">
        <table style="width:100%; border-collapse:collapse; border:none;">
            <?php 
            $count = 0;
            $image_count = 0;
            
            foreach ($dock as $job_id => $job):
                foreach ($job['files'] as $file):
                    if ($image_count < 9) {
                        $image_count++;
                        continue;
                    }
                    
                    if ($count % 3 == 0) {
                        echo '<tr style="border:none;">';
                    }
                    
                    $image_path = 'upload/pm/'.$file['documentasi'];
                    $full_path = base_url($image_path);
            ?>
                    <td class="image-cell" style="border:1px solid black;">
                        <div class="image-container">
                            <img src="<?= $full_path ?>" 
                                 style="height:120px; max-width:120px; width:auto; object-fit:contain; display:block; margin:0 auto;"
                                 onerror="this.src='<?= base_url('assets/img/default.jpg') ?>'">
                        </div>
                        <div class="image-name"><?= htmlspecialchars($job['nama'] ?? 'N/A') ?></div>
                        <div class="image-facility"><?= htmlspecialchars($file['nama_fasilitas'] ?? '-') ?></div>
                    </td>
            <?php
                    $count++;
                    $image_count++;
                    
                    if ($count % 3 == 0) {
                        echo '</tr>';
                    }
                endforeach;
            endforeach;
            
            if ($count % 3 != 0) {
                while ($count % 3 != 0) {
                    echo '<td class="image-cell" style="border:1px solid black;"></td>';
                    $count++;
                }
                echo '</tr>';
            }
            ?>
        </table>
    </td>
  </tr>
  <?php endif; ?>

  <!-- ===== HALAMAN TERAKHIR ===== -->
  <!-- CATATAN PERAWATAN -->
  <tr class="page-break">
    <th colspan="7">CATATAN PERAWATAN</th>
  </tr>
  
  <?php 
  $catatan_perawatan = array_filter(array_column($fasilitas, 'catatan_perawatan')); 
  if(!empty($catatan_perawatan)): 
      foreach($catatan_perawatan as $catatan): 
  ?>
      <tr>
          <td colspan="7" class="tg-left">• <?= nl2br(htmlspecialchars($catatan)) ?></td>
      </tr>
  <?php endforeach; else: ?>
      <tr>
          <td colspan="7">Tidak ada catatan perawatan</td>
      </tr>
  <?php endif; ?>

</table>

<!-- TTD SECTION (Terpisah karena tanpa border) -->
<table class="ttd-section">
    <tr>
        <td>
            <p><strong>PENGAWAS</strong></p>
            <div class="ttd-placeholder"></div>
            <p>_________________________</p>
            <strong><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></strong>
        </td>
        <td>
            <p><strong>KOORDINATOR</strong></p>
            <div class="ttd-placeholder"></div>
            <p>_________________________</p>
            <strong><?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?></strong>
        </td>
    </tr>
</table>

</div>
</body>
</html>