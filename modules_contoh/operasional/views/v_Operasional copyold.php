  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8"/>
    <title>Laporan Operasional</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 11pt;
        margin: 0;
        padding: 0;
      }
      .container { 
        max-width: 210mm; 
        margin: 0 auto; 
        padding: 10px;
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
      
      .ttd-section {
        width: 100%;
        margin-top: 40px;
        border-collapse: collapse;
        font-size: 12px;
      }
      .ttd-section td {
        width: 33.33%;
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
      
      /* Detail Tabel */
      .detail-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 10px;
        margin-bottom: 10px;
      }
      .detail-table th, .detail-table td {
        border: 1px solid #000;
        padding: 4px 3px;
        vertical-align: middle;
      }
      .detail-table th {
        background: #f0f0f0;
        font-weight: bold;
      }
      
      /* Dokumentasi */
      .dok-table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #000;
        margin-top: 15px;
      }
      .dok-table th {
        padding: 8px;
        border: 1px solid #000;
        text-align: center;
        font-size: 16px;
        background-color: #f0f0f0;
      }
      .dok-table td {
        padding: 5px;
        border: 1px solid #000;
        vertical-align: top;
        text-align: center;
        width: 33.33%;
      }
      
      .dok-img-container {
        width: 200px;
        height: 200px;
        margin: 0 auto;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
      }
      .dok-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
      
      /* Page break */
      .page-break {
        page-break-after: always;
      }
      
      @media print {
        @page {
          margin-top: 100px;
          margin-bottom: 50px;
        }
        
        .page-header {
          position: fixed;
          top: -80px;
          left: 0;
          right: 0;
          height: 50px;
          text-align: center;
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
      
      .no-operasional-header {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
        padding-top: 10px;
      }
      
      .halaman-number {
        font-size: 12px;
        color: #333;
      }
      .dok-preview-container {
  height: 200px;
  display: flex;
  flex-direction: column;
}

.dok-preview-wrapper {
  flex: 1;
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: hidden;
  background: #f8f9fa;
  position: relative;
}

.dok-preview {
  width: 100%;
  height: 100%;
  border: none;
  display: block;
}

.pdf-preview::-webkit-scrollbar,
.office-preview::-webkit-scrollbar {
  display: none; /* Hide scrollbar iframe */
}

.image-preview {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.dok-download {
  display: block;
  width: 100%;
  height: 100%;
  text-decoration: none;
  color: inherit;
  display: flex;
  align-items: center;
  justify-content: center;
}

.dok-unknown {
  text-align: center;
  padding: 20px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 5px;
  font-weight: bold;
}

.dok-error {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  color: #999;
  font-style: italic;
}

    </style>
  </head>
  <body>
  <div class="container">

    <!-- Header untuk halaman utama -->
    <!-- <div class="page-header" style="position: fixed; top: 0; left: 0; right: 0; text-align: center; background: white; padding: 10px 0;">
      <div class="no-operasional-header">NOMOR OPERASIONAL : <?= !empty($data['nomor']) ? $data['nomor'] : '-' ?></div>
      <div style="font-size: 11px; color: #666;"><?= !empty($data['tanggal']) ? date('d F Y', strtotime($data['tanggal'])) : '' ?></div>
    </div> -->
</br>
    <!-- 1. KOP SURAT -->
  <table class="main-table" style="border-collapse: collapse; width: 100%; font-size: 11px; text-align: center; margin-bottom: 13px;">
  <!-- HEADER LOGO (7 kolom total: 2+3+2) -->
  <tr>
    <td colspan="2" style="width:20%; height:55px; background:#fff; border: 2px solid #000; text-align:center; vertical-align:middle;">
      <img class="logo-img" src="<?= base_url('assets/injourney.png') ?>" alt="Logo Kiri" style="height:44px;" onerror="this.style.display='none'">
    </td>
    <td colspan="3" style="font-weight:bold; font-size:16px; width:60%; text-align:center; background:#fff; border: 2px solid #000; vertical-align:middle;">
      LAPORAN OPERASIONAL<br/>
      UNIT <?= !empty($nama_unit) ? strtoupper($nama_unit) : 'OPERASIONAL' ?>
    </td>
    <td colspan="2" style="width:20%; background:#fff; border: 2px solid #000; text-align:center; vertical-align:middle;">
      <img class="logo-img" src="<?= base_url('assets/ias.png') ?>" alt="Logo Kanan" style="height:44px;" onerror="this.style.display='none'">
    </td>
  </tr>
  
  <!-- INFO UNIT (7 kolom: 1 + 2 + 2 + 2) -->
  <tr style="background:#f0f0f0; font-weight:bold;">
    <th style="width:10%; border: 1px solid #000;">Kode Unit</th>
    <th colspan="2" style="width:25%; border: 1px solid #000;">Nama Unit</th>
    <th colspan="2" style="width:30%; border: 1px solid #000;">Nomor Operasional</th>
    <th colspan="2" style="width:35%; border: 1px solid #000;">Tanggal</th>
  </tr>
  <tr style="border: 1px solid #000;">
    <td style="width:10%;"><?= !empty($kode_unit) ? $kode_unit : '-' ?></td>
    <td colspan="2" style="width:25%;"><?= !empty($nama_unit) ? $nama_unit : '-' ?></td>
    <td colspan="2" style="width:30%;"><?= !empty($nomor) ? $nomor : '-' ?></td>
    <td colspan="2" style="width:35%;"><?= !empty($tanggal_formatted) ? $tanggal_formatted : '-' ?></td>
  </tr>
</table>


    <!-- 2. PERSONIL -->
    <table class="main-table" style="width:100%; table-layout:fixed;">
  <tr>
    <th colspan="2" class="block-title">PERSONIL OPERASIONAL</th>
  </tr>
  <tr>
    <th style="width:50%;">PELAKSANA</th>
    <th style="width:50%;">PERSONIL API</th>
  </tr>
  <tr>
    <td style="width:50%; vertical-align:top; padding:10px;">
      <?php if(!empty($nama_pelaksana_list)): ?>
        <ol style="margin:0; padding-left:15px; font-size:12px;">
          <?php foreach($nama_pelaksana_list as $pelaksana): ?>
            <li><?= htmlspecialchars($pelaksana) ?></li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <div style="text-align:center; padding:10px; color:#999;">Tidak ada data pelaksana</div>
      <?php endif; ?>
    </td>
    <td style="width:50%; vertical-align:top; padding:10px;">
      <?php if(!empty($nama_api_list)): ?>
        <ol style="margin:0; padding-left:15px; font-size:12px;">
          <?php foreach($nama_api_list as $api): ?>
            <li><?= htmlspecialchars($api) ?></li>
          <?php endforeach; ?>
        </ol>
      <?php else: ?>
        <div style="text-align:center; padding:10px; color:#999;">Tidak ada data pengawas</div>
      <?php endif; ?>
    </td>
  </tr>
</table>


    <!-- 3. DETAIL KEGIATAN OPERASIONAL -->
   <table class="main-table" style="width:100%; table-layout:fixed;">
  <tr>
    <th colspan="4" class="block-title">DETAIL KEGIATAN OPERASIONAL</th>
  </tr>
  <tr>
    <th style="width:20%;">Tanggal</th>
    <th style="width:15%;">Waktu</th>
    <th style="width:55%;">Deskripsi Kegiatan</th>
    <th style="width:10%;">Unit</th>
  </tr>
  <?php if(!empty($operasional_detail) && $c_detail > 0): ?>
    <?php foreach($operasional_detail as $detail): ?>
      <tr>
        <td style="text-align:center;"><?= !empty($detail['tanggal']) ? date('d-m-Y', strtotime($detail['tanggal'])) : '-' ?></td>
        <td style="text-align:center;"><?= !empty($detail['waktu']) ? $detail['waktu'] : '-' ?></td>
        <td style="text-align:left; padding:8px;"><?= !empty($detail['deskripsi']) ? nl2br(htmlspecialchars($detail['deskripsi'])) : '-' ?></td>
        <td style="text-align:center;"><?= !empty($detail['nama_unit']) ? $detail['nama_unit'] : '-' ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="4" style="text-align:center; padding:15px; color:#999;">
        <em>Tidak ada detail kegiatan operasional</em>
      </td>
    </tr>
  <?php endif; ?>
</table>


    <!-- TTD Halaman 1 -->
    <table class="ttd-section">
      <tr>
        <td>
          <strong>PENGAWAS</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pengawas_yang_ttd) ?></strong>
        </td>
        <td>
          <strong>KOORDINATOR</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_koordinator) ?></strong>
        </td>
        <!-- <td>
          <strong>PELAKSANA OPERASIONAL</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pelaksana_yang_ttd) ?></strong>
        </td> -->
      </tr>
    </table>

    <div class="page-break"></div>

    <!-- Header untuk halaman dokumentasi -->
      <!-- Header untuk setiap halaman -->
  <div class="page-header" style="position: fixed; top: 0; left: 0; right: 0; text-align: center; background: white; padding: 10px 0;">
    <div class="no-wo-header">NOMOR : <?= $nomor ?></div>
  </div>

    <!-- 5. DOKUMENTASI BUKTI (GAMBAR) -->
    <?php if(!empty($dock_bukti)): ?>
    <div style="margin-top: 60px;">
      <table class="dok-table">
        <tr>
          <th colspan="3">DOKUMENTASI BUKTI OPERASIONAL</th>
        </tr>
        <?php 
        $rows_bukti = [];
        $count_bukti = 0;
        
        // Group images by 3 per row
        foreach ($dock_bukti as $item) {
          if($count_bukti % 3 == 0) {
            $rows_bukti[] = [];
          }
          $rows_bukti[count($rows_bukti)-1][] = [
            'nama' => $item['nama_dokumentasi'] ?? 'Dokumentasi',
            'tanggal' => !empty($item['tanggal']) ? date('d-m-Y H:i', strtotime($item['tanggal'])) : '-'
          ];
          $count_bukti++;
        }
        
        // Display rows
        foreach ($rows_bukti as $rowIndex => $row) {
          echo '<tr>';
          for ($i = 0; $i < 3; $i++) {
            if (isset($row[$i])) {
              $image_path = 'upload/dokumentasi_bukti_operasional/'.$row[$i]['nama'];
              $full_path = base_url($image_path);
              echo '<td>
                <div class="dok-img-container">
                  <img src="'.$full_path.'" 
                      class="dok-img"
                      onerror="this.src=\''.base_url("assets/img/default.jpg").'\';" 
                      alt="Dokumentasi Bukti" />
                </div>
                <div style="text-align: center; margin-top: 8px;">
                  <div style="font-weight: bold; font-size: 11px;">
                    '.htmlspecialchars($row[$i]['nama']).'
                  </div>
                  <div style="font-size: 10px; color: #333; margin-top: 2px;">
                    '.$row[$i]['tanggal'].'
                  </div>
                </div>
              </td>';
            } else {
              echo '<td></td>';
            }
          }
          echo '</tr>';
        }
        ?>
      </table>
    </div>
    <?php else: ?>
      <div style="text-align: center; padding: 50px; margin-top: 60px; color: #999;">
        <em style="font-size: 16px;">Tidak ada dokumentasi bukti operasional</em>
      </div>
    <?php endif; ?>

    <!-- TTD Halaman 2 -->
    <table class="ttd-section" style="margin-top: 30px;">
      <tr>
        <td>
          <strong>PENGAWAS</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pengawas_yang_ttd) ?></strong>
        </td>
        <!-- <td>
          <strong>KOORDINATOR UNIT</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_koordinator) ?></strong>
        </td> -->
        <td>
          <strong>PELAKSANA</strong>
          <div class="ttd-placeholder"></div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pelaksana_yang_ttd) ?></strong>
        </td>
      </tr>
    </table>

 <?php if(!empty($dock_pengukuran_operasional)): ?>
<div style="margin-top: 30px;">
 <table class="dok-table">
   <tr>
     <th colspan="3">DOKUMENTASI PENGUKURAN OPERASIONAL</th>
   </tr>
   <?php 
   $rows_pengukuran = [];
   $count_pengukuran = 0;
   
   foreach ($dock_pengukuran_operasional as $item) {
     if($count_pengukuran % 3 == 0) {
       $rows_pengukuran[] = [];
     }
     $rows_pengukuran[count($rows_pengukuran)-1][] = [
       'nama' => $item['nama_dokumentasi'] ?? 'Pengukuran',
       'tanggal' => !empty($item['tanggal']) ? date('d-m-Y H:i', strtotime($item['tanggal'])) : '-',
       'preview' => $item['preview_text'] ?? 'File Dokumentasi'
     ];
     $count_pengukuran++;
   }
   
   foreach ($rows_pengukuran as $rowIndex => $row) {
     echo '<tr>';
     for ($i = 0; $i < 3; $i++) {
       if (isset($row[$i])) {
         $file_ext = strtolower(pathinfo($row[$i]['nama'], PATHINFO_EXTENSION));
         echo '<td style="vertical-align: top; padding: 12px;">
           <div style="border: 1px solid #ddd; border-radius: 4px; padding: 8px; height: 140px; display: flex; flex-direction: column;">
             <div style="font-weight: bold; font-size: 10px; margin-bottom: 6px; color: #2c3e50; word-break: break-all; flex-shrink: 0;">
               '.htmlspecialchars($row[$i]['nama']).'
             </div>
             <div style="font-size: 9px; color: #007bff; background: #f0f8ff; padding: 6px; border-radius: 3px; margin-bottom: 6px; line-height: 1.3; flex: 1; overflow: hidden;">
               '.htmlspecialchars($row[$i]['preview']).'
             </div>
             <div style="font-size: 8px; color: #666; margin-bottom: 2px; flex-shrink: 0;">
               <span style="background: #e9ecef; padding: 2px 6px; border-radius: 12px; font-weight: bold;">'.strtoupper($file_ext).'</span>
               <span style="margin-left: 8px;">'.$row[$i]['tanggal'].'</span>
             </div>
           </div>
         </td>';
       } else {
         echo '<td></td>';
       }
     }
     echo '</tr>';
   }
   ?>
 </table>
</div>
<?php else: ?>
<div style="text-align: center; padding: 30px; color: #999;">
 <em style="font-size: 16px;">Tidak ada dokumentasi pengukuran operasional</em>
</div>
<?php endif; ?>



  </div>
  </body>
  </html>