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
          size: 215.9mm 330.2mm; /* F4 / Folio */
          margin-top: 5mm;
          margin-bottom: 13mm;
          margin-left: 10mm;
          margin-right: 10mm;
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

.gambar-pengukuran-table td,
.gambar-pengukuran-table th {
    text-align: center !important;
    vertical-align: middle !important;
  }

    </style>
  </head>
  <body>
<div style="position: fixed; bottom: 6mm; left: 10mm; right: 10mm; text-align: right; font-size: 10px; font-weight: bold; z-index: 9999;" class="print-footer">
  <?= $nomor ?? '-' ?>
</div>
  <script type="text/php">
    if (isset($pdf)) {
      // Inject the script securely to draw header on all pages > 1
      $pdf->page_script('
          if ($PAGE_NUM > 1) {
              $font = $fontMetrics->get_font("Arial", "bold");
              $pdf->text(40, 40, "NOMOR : <?= $nomor ?>", $font, 9, array(0,0,0));
          }
      ');
    }
  </script>
  <div class="container">

</br>
 <!-- 1. KOP SURAT -->
<table class="main-table" style="border-collapse: collapse; width: 100%; font-size: 11px; text-align: center; margin-bottom: 13px; border: 2px solid #000;">

<!-- HEADER -->
<tr colspan="8">
    <td colspan="2" style="width:25%; height:55px; background:#fff; text-align:center; vertical-align:middle; padding:5px; border: 2px solid #000;">
        <img class="logo-img" src="<?= base_url('assets/injourney.png') ?>" alt="Logo API" style="margin-top:10px;height:40px; text-align:center; vertical-align:middle;" onerror="this.style.display='none'">
    </td>
    <td colspan="4" style="width:50%; font-weight:bold; font-size:16px; text-align:center; background:#fff; border: 2px solid #000; vertical-align:middle; padding:5px;">
        LAPORAN OPERASIONAL<br/>
    </td>
    <td colspan="2" style="width:25%; height:55px; background:#fff; text-align:center; vertical-align:middle; padding:5px; border: 2px solid #000;">
        <img class="logo-img" src="<?= base_url('assets/ias.png') ?>" alt="Logo IASS" style="margin-top:10px;height:50px; text-align:center; vertical-align:middle;" onerror="this.style.display='none'">
    </td>
</tr>

<!-- INFO UNIT -->
<tr colspan="8" style="background:#f0f0f0; font-weight:bold;">
    
    <td colspan="2" style="width:25%; border: 2px solid #000; padding:5px;">Nomor WO</td>
    <td colspan="1" style="width:12.5%; border: 2px solid #000; padding:5px;">Kode Unit</td>
    <td colspan="3" style="width:37.5%; border: 2px solid #000; padding:5px;">Nama Unit</td>
    <td colspan="2" style="width:25%; border: 2px solid #000; padding:5px;">Tanggal</td>
    

</tr>
<tr colspan="8">
    <td colspan="2" style="width:25%; border: 2px solid #000; padding:5px;"><?= !empty($nomor) ? $nomor : '-' ?></td>
    <td colspan="1" style="width:12.5%; border: 2px solid #000; padding:5px;"><?= !empty($kode_unit) ? $kode_unit : '-' ?></td>
    <td colspan="3" style="width:37.5%; border: 2px solid #000; padding:5px;"><?= !empty($nama_unit) ? $nama_unit : '-' ?></td>
    <td colspan="2" style="width:25%; border: 2px solid #000; padding:5px;"><?= !empty($tanggal_formatted) ? $tanggal_formatted : '-' ?></td>
   

</tr>

<!-- PERSONIL -->
<tr>
    <td colspan="8" style="background:#e6e6e6; font-weight:bold; padding:8px; border: 2px solid #000;">PERSONIL OPERASIONAL</td>
</tr>
<tr style="background:#f0f0f0; font-weight:bold;">
    <td colspan="4" style="width:50%; border: 2px solid #000; padding:5px;">PERSONIL OM IASS</td>
    <td colspan="4" style="width:50%; border: 2px solid #000; padding:5px;">PERSONIL API</td>
</tr>
<tr>
    <td colspan="4" style="width:50%; border: 2px solid #000; vertical-align:top; padding:10px;">
        <?php if(!empty($nama_pelaksana_list)): ?>
            <ol style="margin:0; padding-left:15px; font-size:12px;">
                <?php foreach($nama_pelaksana_list as $pelaksana): ?>
                    <li><?= htmlspecialchars($pelaksana) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php else: ?>
            <div style="text-align:center; padding:10px; color:#999;">Tidak ada data Personil OM IASS</div>
        <?php endif; ?>
    </td>
    <td colspan="4" style="width:50%; border: 2px solid #000; vertical-align:top; padding:10px;">
        <?php if(!empty($nama_api_list)): ?>
            <ol style="margin:0; padding-left:15px; font-size:12px;">
                <?php foreach($nama_api_list as $api): ?>
                    <li><?= htmlspecialchars($api) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php else: ?>
            <div style="text-align:center; padding:10px; color:#999;">Tidak ada data Personil API</div>
        <?php endif; ?>
    </td>
</tr>

<!-- DETAIL KEGIATAN -->
<tr>
    <td colspan="8" style="background:#e6e6e6; font-weight:bold; padding:8px; border: 2px solid #000;">DETAIL KEGIATAN OPERASIONAL</td>
</tr>
<tr style="background:#f0f0f0; font-weight:bold;">
    
    <td colspan="2" style="width:25%; border: 2px solid #000; padding:5px;">WAKTU PEKERJAAN</td>
    <td colspan="6" style="width:75%; border: 2px solid #000; padding:5px;">TINDAKAN KEGIATAN</td>
    

    
</tr>
<?php if(!empty($operasional_detail) && $c_detail > 0): ?>
    <?php foreach($operasional_detail as $detail): ?>
    <tr>
        
                <td colspan="2" style="border: 2px solid #000; padding:5px;"><?= !empty($detail['jam_mulai']) ? $detail['jam_mulai'] . ' - ' . $detail['jam_selesai'] : '-' ?></td>
        <td colspan="6" style="border: 2px solid #000; padding:8px; text-align:left;"><?= !empty($detail['deskripsi']) ? nl2br(htmlspecialchars($detail['deskripsi'])) : '-' ?></td>
        
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" style="border: 2px solid #000; text-align:center; padding:15px; color:#999;">
            <em>Tidak ada detail kegiatan operasional</em>
        </td>
    </tr>
<?php endif; ?>
</table>




    <!-- TTD Halaman 1 -->
    <table class="ttd-section">
      <tr>
        <td>
          <strong>DISETUJUI</strong><br>
          <strong>PT ANGKASA PURA INDONESIA</strong><br>
          <strong>PENGAWAS</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_api_file = $ttd_api ?? null;
              $ttd_api_path = FCPATH . 'doc/ttd_operasional/' . ($id_unit ?? '') . '/API/' . $ttd_api_file;
              if (!empty($ttd_api_file) && file_exists($ttd_api_path)):
            ?>
              <img src="<?= base_url('doc/ttd_operasional/' . ($id_unit ?? '') . '/API/' . $ttd_api_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Pengawas">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pengawas_yang_ttd) ?></strong>
        </td>
        <td>
          <strong>&nbsp;</strong><br>
          <strong>PT IAS SUPPORT INDONESIA</strong><br>
          <strong>KOORDINATOR</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_kor_file = $ttd_koordinator ?? null;
              $ttd_kor_path = FCPATH . 'doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Koordinator/' . $ttd_kor_file;
              if (!empty($ttd_kor_file) && file_exists($ttd_kor_path)):
            ?>
              <img src="<?= base_url('doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Koordinator/' . $ttd_kor_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Koordinator">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_koordinator ?? 'NAMA KOORDINATOR') ?></strong>
        </td>
        <td>
          <strong>&nbsp;</strong><br>
          <strong>Hari / tanggal : <?= $tanggal ?? '' ?></strong><br>
          <strong>PELAKSANA</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_pel_file = $ttd_iass ?? null;
              $ttd_pel_path = FCPATH . 'doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Pelaksana/' . $ttd_pel_file;
              if (!empty($ttd_pel_file) && file_exists($ttd_pel_path)):
            ?>
              <img src="<?= base_url('doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Pelaksana/' . $ttd_pel_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Pelaksana">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pelaksana_yang_ttd ?? 'NAMA PELAKSANA') ?></strong>
        </td>
      </tr>
    </table>

    <div class="page-break"></div>

    <!-- Header untuk halaman dokumentasi -->
      <!-- Header untuk setiap halaman -->
 
    <!-- 5. DOKUMENTASI BUKTI (GAMBAR) -->
    <?php if(!empty($dock_bukti)): ?>
    <div style="margin-top: 60px;">
      <table class="dok-table">

        <tr>
          <th colspan="3">DOKUMENTASI PEKERJAAN</th>
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
          <strong>PT ANGKASA PURA INDONESIA</strong><br>
          <strong>PENGAWAS </strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_api_file = $ttd_api ?? null;
              $ttd_api_path = FCPATH . 'doc/ttd_operasional/' . ($id_unit ?? '') . '/API/' . $ttd_api_file;
              if (!empty($ttd_api_file) && file_exists($ttd_api_path)):
            ?>
              <img src="<?= base_url('doc/ttd_operasional/' . ($id_unit ?? '') . '/API/' . $ttd_api_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Pengawas">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pengawas_yang_ttd) ?></strong>
        </td>
        <td>
          <strong>PT IAS SUPPORT INDONESIA</strong><br>
          <strong>KOORDINATOR</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_kor_file = $ttd_koordinator ?? null;
              $ttd_kor_path = FCPATH . 'doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Koordinator/' . $ttd_kor_file;
              if (!empty($ttd_kor_file) && file_exists($ttd_kor_path)):
            ?>
              <img src="<?= base_url('doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Koordinator/' . $ttd_kor_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Koordinator">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_koordinator ?? 'NAMA KOORDINATOR') ?></strong>
        </td>
        <td>
          <strong>Hari / tanggal : <?= $tanggal ?? '' ?></strong><br>
          <strong>PELAKSANA</strong>
          <div class="ttd-placeholder" style="display:flex; align-items:center; justify-content:center; height:80px;">
            <?php
              $ttd_pel_file = $ttd_iass ?? null;
              $ttd_pel_path = FCPATH . 'doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Pelaksana/' . $ttd_pel_file;
              if (!empty($ttd_pel_file) && file_exists($ttd_pel_path)):
            ?>
              <img src="<?= base_url('doc/ttd_operasional/' . ($id_unit ?? '') . '/IASS/Pelaksana/' . $ttd_pel_file) ?>" style="max-height:75px; max-width:180px; object-fit:contain;" alt="TTD Pelaksana">
            <?php else: ?>
              &nbsp;
            <?php endif; ?>
          </div>
          <p>_________________________</p>
          <strong><?= strtoupper($nama_pelaksana_yang_ttd ?? 'NAMA PELAKSANA') ?></strong>
        </td>
      </tr>
    </table>
     <div class="page-break"></div>


<?php
// CEK gambar pengukuran -> ambil dari $dock_pengukuran_operasional
$hasGambar = !empty($dock_pengukuran_operasional) || !empty($dock_bukti_sisa);

$allGambar = [];
if (!empty($dock_pengukuran_operasional)):
    foreach ($dock_pengukuran_operasional as $item) {
        // Kolom di DB: nama_dokumentasi_pengukuran
        $nama_file = $item['nama_dokumentasi_pengukuran'] ?? null;
        if (!empty($nama_file)) {
            $allGambar[] = [
                'gambar'  => $nama_file,
                'path'    => 'upload/dokumentasi_pengukuran_operasional/',
                'info'    => $nama_file ?: 'Dokumentasi Pengukuran',
                'tanggal' => !empty($item['tanggal']) 
                    ? date('d-m-Y H:i', strtotime($item['tanggal'])) 
                    : '-'
            ];
        }
    }
endif;

if (!empty($dock_bukti_sisa)):
    foreach ($dock_bukti_sisa as $item) {
        $nama_file = $item['nama_dokumentasi'] ?? null;
        if (!empty($nama_file)) {
            $allGambar[] = [
                'gambar'  => $nama_file,
                'path'    => 'upload/dokumentasi_bukti_operasional/',
                'info'    => $nama_file ?: 'Dokumentasi Bukti',
                'tanggal' => !empty($item['tanggal']) 
                    ? date('d-m-Y H:i', strtotime($item['tanggal'])) 
                    : '-'
            ];
        }
    }
endif;

// 1 gambar per halaman
$gambarPerHalaman = 1;
$totalHalaman = empty($allGambar) ? 0 : ceil(count($allGambar) / $gambarPerHalaman);

if ($totalHalaman > 0):
    for ($halaman = 1; $halaman <= $totalHalaman; $halaman++):
        $startIndex = ($halaman - 1) * $gambarPerHalaman;
        $endIndex   = min($startIndex + $gambarPerHalaman, count($allGambar));
?>
<div class="gambar-pengukuran-section" style="margin-top: 10px;">

    <style>
        @media print {
            .gambar-pengukuran-section {
                page-break-before: always;
            }
        }
    </style>

    <table class="gambar-pengukuran-table" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr>
             <th colspan="1" style="text-align: center; font-size: 16px; border-radius: 0; padding: 10px; border: 2px solid #000;">
              DOKUMENTASI HASIL PENGUKURAN OPERASIONAL
             </th>
        </tr>

        <?php
        for ($i = $startIndex; $i < $endIndex; $i++):
            if (!isset($allGambar[$i])) continue;

            $gambar   = $allGambar[$i];
            $img_path = $gambar['path'] . $gambar['gambar'];
            $full_path = base_url($img_path);
        ?>
        <tr class="gambar-item">
            <td class="gambar-cell" style="width: 100%; padding: 15px; vertical-align: top; border: none; page-break-inside: avoid;">
                <div style="text-align: center; margin: 0 auto; border: 2px solid #000; border-radius: 0; padding: 5px; width: 100%; max-width: 30cm;">
                    <div style="margin: 0; padding: 0; display:flex; justify-content:center; align-items:center;">
                      <img src="<?php echo $full_path; ?>" 
                             style="max-width: 100%; max-height: 23cm; object-fit: contain; border: none; background: #fff; display: block; margin: 0 auto;"
                             onerror="this.src='<?= base_url('assets/img/default.jpg') ?>'; this.style.objectFit='contain';"
                             alt="Dokumentasi Pengukuran <?= htmlspecialchars($gambar['info']) ?>" />
                    </div>

                  
                </div>
            </td>
           
        </tr>
        <?php if ($i < count($allGambar) - 1): ?>
        <div class="page-break"></div>
        <?php endif; ?>
        <?php endfor; ?>
         
    </table>
</div>
<?php
    endfor;
else:
?>
<div style="text-align: center; padding: 50px; color: #999;">
    <em style="font-size: 16px;"></em>
</div>
<?php endif; ?>



  </div>
  <script>
      window.onload = function() {
          window.print();
      };
  </script>
  </body>
  </html>