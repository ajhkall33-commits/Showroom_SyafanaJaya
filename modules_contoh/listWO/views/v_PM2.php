<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perintah Kerja PM</title>
    <style>
        /* Reset margin dan padding untuk semua elemen */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    width: 210mm; /* Lebar kertas F4 */
    height: 297mm; /* Tinggi kertas F4 */
    font-size: 11pt;
    line-height: 1.4;
    display: flex;
    justify-content: center; /* Centering horizontally */
    align-items: center; /* Centering vertically */
    height: 100vh; /* Full viewport height */
    text-align: center; /* Center text */
}
        
        .container {
    width: 100%;
    max-width: 200mm; /* Maksimal lebar container agar tidak terlalu lebar di kertas F4 */
    margin: auto; /* Untuk center konten jika ada spasi */
}
        
       table {
    width: 100%;
    max-width: 200mm; /* Membatasi lebar agar tetap pada kertas F4 */
    border-collapse: collapse;
    margin: 0 auto; /* Centering tabel secara horizontal */
}
        
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 11px;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .logo {
            max-height: 70px;
            width: auto;
        }
        
        .signature-area {
            margin-top: 80px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 180px;
            margin: 0 auto;
            padding-top: 5px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        tr {
            page-break-inside: avoid;
        }
        
        .job-container {
            margin-bottom: 8px;
            padding-bottom: 8px;
        }
        
        .job-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
            color: #333;
            text-align: left;
        }
        
        .job-status {
            margin-bottom: 8px;
            padding-left: 3px;
            text-align: left;
            margin-top: 8px;
        }
        
        .job-notes {
            padding-left: 3px;
            text-align: left;
            font-size: 11px;
            margin-top: 8px;
        }
        
        .divider {
            border: 0.5px solid #ccc;
            margin-top: 12px;
            margin-bottom: 12px;
        }
        
        .image-cell {
            width: 33.33%;
            padding: 6px;
            vertical-align: top;
        }
        
        .image-container {
            height: 140px;
            text-align: center;
        }
        
        .image-name {
            text-align: center;
            font-weight: bold;
            margin-top: 8px;
            font-size: 11px;
        }
        
        .image-facility {
            text-align: center;
            font-size: 10px;
            margin-top: 4px;
        }
        
        .no-margin {
            margin: 0;
        }
        
        .compact-table {
            margin-bottom: 5px;
        }
        
        .centered-content {
            text-align: center;
            margin: 0 auto;
        }
        
        @media print {
            body {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                padding: 5mm;
                font-size: 11pt;
            }
            
            .page-break {
                page-break-after: always;
            }
            
            table {
                page-break-inside: avoid;
            }
            
            tr {
                page-break-inside: avoid;
            }
        }
        /* CSS untuk menghilangkan jarak yang tidak diinginkan */
/* Reset dasar untuk tabel compact */
/* Reset margin dan padding untuk semua elemen */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 5mm;
    width: 210mm;
    font-size: 11pt;
    line-height: 1.4;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

/* Menghilangkan jarak pada table, tr, td */
table, th, td {
    border: 1px solid #000;
    padding: 0; /* Mengurangi padding untuk semua elemen table */
    margin: 0; /* Menghilangkan margin */
}

/* Mengatur jarak antar cell */
td, th {
    padding: 4px; /* padding untuk mengatur jarak dalam cell */
    text-align: center;
    vertical-align: middle;
    font-size: 11px;
}

/* Memastikan header tabel tidak memiliki padding yang terlalu besar */
th {
    background-color: #f2f2f2;
    font-weight: bold;
}

/* Menjaga agar tr tetap rapat tanpa spasi */
tr {
    line-height: 1; /* Memastikan baris tetap rapat */
}

/* Spesifik untuk tabel yang ingin jaraknya rapat */
.table-spacing-fix {
    border-collapse: collapse;
    width: 100%;
}

.table-spacing-fix td, .table-spacing-fix th {
    padding: 2px 4px !important; /* Memperkecil padding */
    margin: 0 !important; /* Menghilangkan margin */
    vertical-align: top !important; /* Menjaga elemen di atas */
}

/* Untuk teks di dalam td atau th jika ada elemen lain seperti p, ol, div */
.table-spacing-fix td p,
.table-spacing-fix td ol,
.table-spacing-fix td div {
    margin: 0;
    padding: 0;
    line-height: 1;
}

/* Gaya untuk menambahkan garis pemisah setelah setiap baris */
hr.divider {
    border: 0.5px solid #ccc;
    margin-top: 12px;
    margin-bottom: 12px;
}


    </style>
</head>
<body>
<div class="container">

<!-- KOP SURAT START -->
<table style="width:100%; border-collapse: collapse; margin-bottom: 10px;">
  <tr style="height: 75px;">
    <!-- Logo Kiri -->
    <td colspan="2"style="width:-60%; border:1px solid #000; padding:4px; text-align:center; vertical-align:middle;">
        <img class="logo" src="<?=ImageLogo('1')?>" alt="Logo Kiri" style ="height:60%;" />
    </td>
    
    <!-- Teks Tengah -->
    <td colspan="3"style="width:60%; border:1px solid #000; padding:4px 8px; text-align:center; vertical-align:middle;">
      <p style="font-size:13px; font-weight:bold; margin:2px 0; text-transform:uppercase;">PERINTAH KERJA</p>
      <p style="font-size:13px; font-weight:bold; margin:2px 0; text-transform:uppercase;">PEMELIHARAAN PENCEGAHAN</p>
    </td>
    
    <!-- Logo Kanan -->
    <td colspan="2"style="width:20%; border:1px solid #000; padding:4px; text-align:center; vertical-align:middle;">
        <img class="logo" src="<?=ImageLogo('2')?>" alt="Logo Kanan" />
    </td>
  </tr>


<!-- DATA UTAMA -->

    <!-- HEADER DATA -->
   <thead>
    <tr>
      <th style="width:14%; ">Kode Unit</th>
      <th style="width:14%; ">Kode</th>
      <th style="width:20%; ">Klasifikasi</th>
      <th colspan="2" style="width:24%; ">Nomor</th>
      <th colspan="2" style="width:28%; ">Tanggal</th>
    </tr>
  </thead>
  <tbody>
        <tr>
            <td style="width:14%;"><?= sess()['unit_kode'] ?></td>
            <td style="width:14%;"><?=$pm_type['kode']?></td>
            <td style="width:20%;">Preventive Maintenance</td>
            <td colspan="2" style="width:14%;"><?=$no_wo?></td>
            <td colspan="2" style="width:14%;"><?=$harisplit?> <?=$tanggal?></td>
        </tr>
    
    <!-- PERSONIL -->
    <thead>
        <tr>
            <th colspan="7" style="padding:4px; text-align: center;">PERSONIL YANG DITUGASKAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7" style="padding:4px;">
                <ol style="margin:0; padding-left: 20px; text-align: left;">
                    <?php 
                        $personil = explode(",", $pelaksana);
                        foreach ($personil as $nama) {
                        echo '<li style="padding:2px 0;">' . trim($nama) . '</li>';
                        }
                    ?>
                </ol>
            </td>
        </tr>
    </tbody>
    
    <!-- PERALATAN -->
    <thead>
        <tr>
            <th colspan="4" style="padding:4px; text-align: center;">NAMA PERALATAN</th>
            <th colspan="3" style="padding:4px; text-align: center;">LOKASI</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($fasilitas as $item): ?>
        <tr>
            <td colspan="4" style="padding:4px;"><?= $item['nama_fasilitas'] ?></td>
            <td colspan="3" style="padding:4px;"><?= $item['lokasi'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

    <!-- CEKLIST PEKERJAAN - Halaman 1 (8 item) -->

    <thead>
        <tr>
            <th colspan="7" style="padding:5px; text-align:center; font-size:12px; background-color:#f2f2f2;">CEKLIST PEKERJAAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7" style="padding:8px;">
                <div style="text-align: left;">
                    <?php if (!empty($job)): ?>
                        <?php 
                        $job_count = count($job);
                        $first_page_jobs = array_slice($job, 0, 8);
                        $second_page_jobs = array_slice($job, 8, 10);
                        ?>
                        
                        <?php foreach ($first_page_jobs as $index => $job_item): ?>
                        <div class="job-container">
                            <!-- Judul Pekerjaan -->
                            <div class="job-title">
                                <?= $index + 1 ?>. <?= htmlspecialchars($job_item['nama_job'] ?? 'Pekerjaan') ?>
                            </div>   
                            
                            <!-- Status Pekerjaan -->
                            <div class="job-status">
                                <div style="display: flex; align-items: center; margin-top: -8px;">
                                    <input style= "margin-top: -8px;"type="checkbox" id="status_selesai_<?= $index ?>" name="status[<?= $index ?>]" 
                                        value="selesai" checked style="margin-right: 8px; transform: scale(1.1);">. <label for="status_selesai_<?= $index ?>" style="font-weight: bold;">
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selesai
                                    </label>
                                   
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="job-notes">
                                <span style="font-weight: bold;">Catatan :</span>
                                <span style="margin-left: 5px;">
                                    ...........................
                                </span>
                            </div>

                            <!-- Garis Pemisah Setelah Catatan -->
                            <?php if ($index < 7): ?>
                            <hr class="divider">
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 15px; color: #666; font-style: italic;">
                            <p>Tidak ada data pekerjaan yang tersedia</p>
                        </div>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<!-- Page Break -->
<div class="page-break"></div>

<!-- CEKLIST PEKERJAAN - Halaman 2 (10 item) -->
<?php if (!empty($second_page_jobs)): ?>
<table style="width:100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
        <tr>
            <th colspan="7" style="padding:5px; text-align:center; font-size:12px; background-color:#f2f2f2;">CEKLIST PEKERJAAN (Lanjutan)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7" style="padding:8px;">
                <div style="text-align: left;">
                    <?php foreach ($second_page_jobs as $index => $job_item): ?>
                    <div class="job-container">
                        <!-- Judul Pekerjaan -->
                        <div class="job-title">
                            <?= $index + 9 ?>. <?= htmlspecialchars($job_item['nama_job'] ?? 'Pekerjaan') ?>
                        </div>   
                        
                        <!-- Status Pekerjaan -->
                        <div class="job-status">
                            <div style="display: flex; align-items: center; margin-top: -8px;">
                                    <input style= "margin-top: -8px;"type="checkbox" id="status_selesai_<?= $index ?>" name="status[<?= $index ?>]" 
                                        value="selesai" checked style="margin-right: 8px; transform: scale(1.1);">. <label for="status_selesai_<?= $index ?>" style="font-weight: bold;">
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selesai
                                    </label>
                                   
                                </div>
                        </div>

                        <!-- Catatan -->
                        <div class="job-notes">
                            <span style="font-weight: bold;">Catatan :</span>
                            <span style="margin-left: 5px;">
                                ...........................
                            </span>
                        </div>

                        <!-- Garis Pemisah Setelah Catatan -->
                        <?php if ($index < count($second_page_jobs) - 1): ?>
                        <hr class="divider">
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div class="page-break"></div>

<?php endif; ?>

<!-- TUGAS YANG DIBERIKAN -->
<table style="width:100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
        <tr>
            <th colspan="7" style="padding:6px; text-align:center; font-size:13px;">TUGAS YANG DIBERIKAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7" style="padding:0;">
                <table style="border-collapse:collapse; margin:0; padding:0; width:100%;">
                <?php if (!empty($dock)): ?>
                    <?php 
                    $count = 0;
                    $first_page_images = 12;
                    $total_images = 0;
                    
                    foreach ($dock as $job_id => $job) {
                        $total_images += count($job['files']);
                    }
                    
                    $image_count = 0;
                    foreach ($dock as $job_id => $job):
                        foreach ($job['files'] as $file):
                            if ($image_count >= $first_page_images) break;
                            
                            $image_path = 'upload/pm/'.$file['documentasi'];
                            $full_path = base_url($image_path);
                            
                            if ($count % 3 == 0) {
                                echo '<tr style="page-break-inside: avoid;">';
                            }
                    ?>
                            <td class="image-cell">
                                <div class="image-container">
                                    <img src="<?= $full_path ?>" 
                                         style="height:140px; max-width:140px; width:auto;"
                                         onerror="this.src='<?= base_url('assets/img/default.jpg') ?>'">
                                </div>
                                
                                <div class="image-name">
                                    <?= htmlspecialchars($job['nama']) ?>
                                </div>
                                
                                <div class="image-facility">
                                    <?= htmlspecialchars($file['nama_fasilitas'] ?? '-') ?>
                                </div>
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
                            echo '<td class="image-cell"></td>';
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
    </tbody>
</table>

<!-- Page Break untuk gambar berikutnya -->
<div class="page-break"></div>

<!-- TUGAS YANG DIBERIKAN - Halaman 2 (9 gambar) -->
<?php if (!empty($dock) && $total_images > 6): ?>
<table style="width:100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
        <tr>
            <th colspan="7" style="padding:6px; text-align:center; font-size:13px;">TUGAS YANG DIBERIKAN (Lanjutan)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7" style="padding:0;">
                <table style="border-collapse:collapse; margin:0; padding:0; width:100%;">
                    <?php 
                    $count = 0;
                    $image_count = 0;
                    $second_page_images = 12;
                    
                    foreach ($dock as $job_id => $job):
                        foreach ($job['files'] as $file):
                            if ($image_count < 12) {
                                $image_count++;
                                continue;
                            }
                            
                            if ($image_count >= 12 + $second_page_images) break;
                            
                            $image_path = 'upload/pm/'.$file['documentasi'];
                            $full_path = base_url($image_path);
                            
                            if ($count % 3 == 0) {
                                echo '<tr style="page-break-inside: avoid;">';
                            }
                    ?>
                            <td class="image-cell">
                                <div class="image-container">
                                    <img src="<?= $full_path ?>" 
                                         style="height:140px; max-width:140px; width:auto;"
                                         onerror="this.src='<?= base_url('assets/img/default.jpg') ?>'">
                                </div>
                                
                                <div class="image-name">
                                    <?= htmlspecialchars($job['nama']) ?>
                                </div>
                                
                                <div class="image-facility">
                                    <?= htmlspecialchars($file['nama_fasilitas'] ?? '-') ?>
                                </div>
                            </td>
                    <?php
                            $count++;
                            $image_count++;
                            
                            if ($count % 3 == 0) {
                                echo '</tr>';
                            }
                        endforeach;
                        if ($image_count >= 12 + $second_page_images) break;
                    endforeach;
                    
                    if ($count % 3 != 0) {
                        while ($count % 3 != 0) {
                            echo '<td class="image-cell"></td>';
                            $count++;
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            </td>
        </tr>
    </tbody>

    <?php endif; ?>

    <!-- Catatan Perawatan -->

    <thead>
        <tr>
            <th colspan="7" style="padding:5px; text-align: center;">CATATAN PERAWATAN</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $catatan_perawatan = array_filter(array_column($fasilitas, 'catatan_perawatan')); 
        ?>
        
        <?php if(!empty($catatan_perawatan)): ?>
            <?php foreach($catatan_perawatan as $catatan): ?>
            <tr>
                <td colspan="7" style="padding:5px;">
                    • <?= nl2br(htmlspecialchars($catatan)) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="padding:5px; text-align: center;">
                    Tidak ada catatan perawatan
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Signature Section -->
<div class="signature-area">
    <table style="width: 100%; border-collapse: collapse; margin: 0; padding: 0; border: none;">
        <tr>
            <td style="width: 50%; text-align: center; vertical-align: top; border: none; padding-top: 5px;">
                <p style="font-weight: bold; margin: 0 0 8px 0; font-size: 12px; text-transform: uppercase;">PENGAWAS</p>
                <br><br><br><br>
                <div class="signature-line"></div>
                <p style="margin: 5px 0 0 0; font-weight: bold; font-size: 11px;"><?= strtoupper($pengawas ?? 'NAMA PENGAWAS') ?></p>
            </td>
            
            <td style="width: 50%; text-align: center; vertical-align: top; border: none; padding-top: 5px;">
                <p style="font-weight: bold; margin: 0 0 8px 0; font-size: 12px; text-transform: uppercase;">KOORDINATOR</p>
                <br><br><br><br>
                <div class="signature-line"></div>
                <p style="margin: 5px 0 0 0; font-weight: bold; font-size: 11px;"><?= strtoupper($nama_koordinator ?? 'NAMA PETUGAS') ?></p>
            </td>
        </tr>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const name = this.getAttribute('name');
                const sameNameCheckboxes = document.querySelectorAll(`input[name="${name}"]`);
                
                if (this.checked) {
                    sameNameCheckboxes.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });
    });
</script>
</div>
</body>
</html>