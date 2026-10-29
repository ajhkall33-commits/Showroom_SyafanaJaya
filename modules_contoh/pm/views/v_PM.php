<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport " content="width=device-width, initial-scale=1.0">
      <title>Laporan Pemeliharaan Perbaikan</title>
      <style>
         .page-break{
         page-break-after:always;
         } 
         /* Reset CSS */
         * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         }
         .col img {
         width: 200px;
         margin: 20px;
         }
         .colsub {
         border-right: 1px solid #000;
         border-left: 1px solid #000;
         padding: 30px;
         }
         body {
         font-family: Arial, sans-serif;
         margin: 40px;
         }
         .container {
         border: 1px solid #000;
         margin: 0px;
         /* padding: 20px; */
         page-break-inside: avoid; /* Avoid breaking the container */
         }
         .header {
         text-align: center;
         margin-bottom: 20px;
         border-bottom: 1px solid #000;
         flex-wrap: nowrap;
         flex-direction: row;
         /* display: flex; */
         /* justify-content: space-between; */
         align-items: center;
         page-break-inside: avoid; /* Avoid breaking the header */
         }
         .header div {
         /* display: inline-block; */
         }
         .infos {
         width: 100%;
         max-width: 800px;
         margin: 50px;
         border-collapse: collapse;
         page-break-inside: avoid; /* Avoid breaking the infos */
         }
         .infos-row {
         /* display: flex; */
         border-bottom: 1px solid #ddd;
         padding: 5px 0;
         }
         .infos-col {
         padding: 5px;
         }
         .inforow {
         /* display: flex; */
         margin-bottom: 10px;
         }
         .col-label {
         flex: 0 0 25%;
         font-weight: bold;
         }
         .colabel {
         flex: 0 0 15%;
         font-weight: bold;
         }
         .col-separator, .colseparator {
         flex: 0 0 5%;
         text-align: center;
         }
         .col-value, .colvalue {
         flex: 1;
         }
         .sesi1 {
         margin: 50px;
         page-break-inside: avoid; /* Avoid breaking session content */
         }
         .boximg {
         /* display: flex; */
         justify-content: space-between;
         }
         .box {
         width: 45%;
         height: 350px;
         border: 1px solid #000;
         margin-bottom: 10px;
         padding: 20px;
         /* display: inline-block; */
         vertical-align: top;
         text-align: center;
         box-sizing: border-box;
         }
         .box img {
         max-width: 100%;
         max-height: 100%;
         width: auto;
         height: auto;
         object-fit: contain;
         margin: auto;
         /* display: block; */
         }
         table {
         /* margin-left: 5px; */
         border-spacing: 0px;
         border-collapse: collapse;
         width: 100%;
         }
         .table-mid{
         width: 90%;object-fit: contain;
         }
         .t-center{
         margin-left: auto;
         margin-right: auto;
         }
         .border-name{
         border:1px solid black;
         margin-left: 10%;
         margin-right: 10%;
         margin-top: 10px;
         margin-bottom: 10px;
         }
         .p-label {
         font-size: 14px;
         font-weight: 900;
         }
         .tulisan_tengah{
         text-align: center;
         }
         .body-info{
         -ms-flex: 0 0 100%;
         flex: 0 0 100%;
         max-width: 100%;
         margin: 3   0px;
         }
         .mb-1, .my-1 {
         margin-bottom: .25rem!important;
         }
         td {
         font-size: 12px;
         }
         .textmid {
         vertical-align: middle;
         padding-top: 15px;
         padding-bottom: 15px;
         padding-left: 2px;
         padding-right: 2px;
         }
         .body-surat{
         margin: 30px;
         }
         .center {
         text-align: center;
         padding-top: 15px;
         padding-bottom: 15px;
         }
         .center img {
         display: block;
         }
         .ps-10{
         padding-left: 30px;
         padding-right: 30px;
         }
         .pt-10{
         margin-top: 10px;
         /* margin-left: 5px; */
         }
         .pt-30{
         margin-top: 30px;
         /* margin-left: 5px; */
         }
         .pt-25{
         margin-top: 25px;
         /* margin-left: 5px; */
         }
         .pb-10{
         margin-bottom: 10px;
         }
         .pb-30{
         margin-bottom: 30px;
         }
         .pd{
         padding-top: 10px;
         padding-bottom: 10px;
         }
         .mg-5{
         margin-left: 5%;
         }
         .mt-5{
         margin-top: 10px;
         }
         .tg  {border-collapse:collapse;border-spacing:0;}
         .tg td{
            border-color:black;
            border-style:solid;
            border-width:1px;
            font-family:Arial, sans-serif;
            font-size:10px;
            overflow:hidden;
            padding:2px 5px;
            word-break:normal;
         }
         .tg th{
            border-color:black;
            border-style:solid;
            border-width:1px;
            font-family:Arial, sans-serif;
            font-size:10px;
            font-weight:normal;
            overflow:hidden;
            padding:5px 5px;
            word-break:normal;
         }
         .tg .tg-9wq8{
            border-color:inherit;
            text-align:center;
            vertical-align:middle
         }
         .tg .tg-nrix{
            text-align:center;
            vertical-align:middle
         }
         tr.tinggi {  line-height: 70px; }
         td.tg-9wq8 {vertical-align: top;}
         span {
            position: absolute;
            top: 0;
            right: 0;
         }
         ol{ padding-top: 0px; padding-left: px}
         .tb  {border-collapse:collapse;border-spacing:0;}
         .tb td{
            font-family:Arial, sans-serif;
            font-size:10px;
            overflow:hidden;
            padding:2px 5px;
            word-break:normal;
         }
         .tb th{
            font-family:Arial, sans-serif;
            font-size:10px;
            font-weight:normal;
            overflow:hidden;
            padding:10px 5px;
            word-break:normal;
         }
         .tb .tg-9wq8{
         border-color:inherit;
         }
         .tb .tg-nrix{
         }
         .box-kanan{
         float: right;
         }
         .box-kiri{
         float: left;
         }
         .tg td .tb td{
            border-width: 0px;
            padding: 0px 5px;
         }

         
         hr.temuan {
         border-bottom: 1px solid black;
         margin-top: 15px;
         }
         .temuan-box{
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
         /* border: 3px solid #73AD21; */
         }
      </style>
   </head>
   <body>
      <div class="container">
      <!-- KOP SURAT START -->
      <table width="100%" >
         <thead>
            <tr style="">
               <td  class=" tulisan_tengah" style="width:25%;border-bottom: 1px solid #000;  ">
                  <img style="display:flex; margin-left: 25px;" width="70%"  src="<?=ImageLogo('1')?>" />  
               </td>
               <td  class=" tulisan_tengah" style="border-bottom: 1px solid #000;width:50%;border-left: 1px solid #000;border-right: 1px solid #000;" style="">
                  <p class="p-label">DOKUMENTASI LAPORAN </p>
                  <p class="p-label">KEGIATAN PERAWATAN</p>
                    <p class="p-label"><?=$pm_type['name_pm']?></p>
                  <p class="p-label">PERALATAN <?=sess()['unit_name']?></p>
               </td>
               <td   class=" tulisan_tengah" style="border-bottom: 1px solid #000;width:25%">
                  <img style=" margin-left: 13%;" width="70%"  src="<?=ImageLogo('2')?>" />
               </td>
            </tr>
         </thead>
      </table>
      <!-- KOP SURAT END -->
      <table   class="ps-10 pt-25">
         <tr>
            <td style="width:25%;margin-left: 10px;">
               <!-- <p> Nomor Work Order</p> -->
            </td>
            <td style="width:1%">  </td>
            <td style="width:74%"> </td>
         </tr>
         <tr>
            <td style="width:25%;margin-left: 10px;">
               <p>Hari </p>
            </td>
            <td style="width:1%">  : </td>
            <td style="width:74%"> <?=$tanggal?></td>
         </tr>
         <tr>
            <td>
               <p> Lokasi </p>
            </td>
            <td>  : </td>
            <td> <?=$terminal?></td>
         </tr>
         <tr>
            <td>
               <p> Peralatan </p>
            </td>
            <td>: </td>
            <td> <?=$fasilitas?> </td>
         </tr>
         <?php if (isset($devices) && !empty($devices)) : ?>
         <tr>
            <td>
               <p> Alat/Perangkat </p>
            </td>
            <td>: </td>
            <td> 
                <?php 
                $device_names = array();
                foreach ($devices as $d) {
                    $device_names[] = $d['nama_perangkat'];
                }
                echo implode(', ', $device_names);
                ?> 
            </td>
         </tr>
         <?php endif; ?>
         <tr>
            <td>
               <p> Kategori Jenis Peralatan</p>
            </td>
            <td>: </td>
            <td><?=$catagory?></td>
         </tr>
         <tr>
            <td>
               <p> Jam</p>
            </td>
            <td>: </td>
            <td> <?=$waktu?></td>
         </tr>
      </table>
      <table  >
         <?php $count = 0; foreach ($job as $key => $value) : ?>
            <?php if ($count % 3 == 0) : ?>
               <tr>
            <?php endif; ?>

            <td style="width:33%; text-align: center;">
               <div class="border-name" style="padding-bottom: 10px;">
                     <div style="height: 12em; display: flex; justify-content: center; align-items: center;">
                        <img 
                           height="150px" 
                           width="120px"
                           src="<?= base_url('upload/pm/') . $value['documentasi'] ?>">
                     </div>
                     <hr style="margin: 5px 0;">
                     <p class="tulisan_tengah pd"><?= $value['nama_job'] ?></p>
               </div>
            </td>
            <?php $count++; if ($count % 3 == 0) : ?>
            </tr>
            <?php endif; ?>
         <?php endforeach; ?>

            <!-- Tutup baris terakhir jika sisa kurang dari 3 -->
            <?php if ($count % 3 != 0) : ?>
               </tr>
            <?php endif; ?>
      </table>
      
<!-- TAMBAHKAN GAMBAR PENGUKURAN DI SINI -->
<?php if (isset($gambar_pengukuran) && !empty($gambar_pengukuran)): ?>
<table style="width: 100%; margin-top: 30px;">
    <tr>
        <td style="text-align: center; font-weight: bold; padding: 10px;">
            GAMBAR PENGUKURAN
        </td>
    </tr>
</table>
<table>
    <?php $count_gp = 0; foreach ($gambar_pengukuran as $key => $gambar): ?>
        <?php if ($count_gp % 3 == 0): ?>
            <tr>
        <?php endif; ?>
        
        <td style="width:33%; text-align: center;">
            <div class="border-name" style="padding-bottom: 10px;">
                <div style="height: 12em; display: flex; justify-content: center; align-items: center;">
                    <!-- PERBAIKI PATH INI -->
                    <img 
                        height="150px" 
                        width="120px"
                        src="<?= base_url('upload/gambar_pengukuran/') . $gambar['nama_gambar_pengukuran'] ?>">
                </div>
                <?php if (!empty($gambar['keterangan'])): ?>
                    <hr style="margin: 5px 0;">
                    <p class="tulisan_tengah pd"><?= $gambar['keterangan'] ?></p>
                <?php endif; ?>
            </div>
        </td>
        
        <?php 
        $count_gp++; 
        if ($count_gp % 3 == 0): ?>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    
    <?php if ($count_gp % 3 != 0): ?>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?>
<!-- AKHIR GAMBAR PENGUKURAN -->

<!-- TAMBAHKAN GAMBAR DOKUMENTASI PERAWATAN DI SINI -->
<?php if (isset($dokumentasi_gambar_perawatan) && !empty($dokumentasi_gambar_perawatan)): ?>
<table style="width: 100%; margin-top: 30px;">
    <tr>
        <td style="text-align: center; font-weight: bold; padding: 10px; background-color: #f0f0f0; border: 1px solid #ddd;">
            GAMBAR DOKUMENTASI PERAWATAN
        </td>
    </tr>
</table>
<table style="width: 100%; border-collapse: collapse;">
    <?php 
    $count_gp = 0; 
    foreach ($dokumentasi_gambar_perawatan as $key => $gambar):   // ← PAKAI VARIABEL YANG SAMA!
    ?>
        <?php if ($count_gp % 3 == 0): ?>
            <tr>
        <?php endif; ?>
        
        <td style="width:33.33%; text-align: center; padding: 10px; vertical-align: top;">
            <div style="border: 1px solid #ddd; border-radius: 5px; padding: 10px; background-color: #fff;">
                <div style="height: 150px; display: flex; justify-content: center; align-items: center; background-color: #fafafa;">
                    <img 
                        style="max-height: 140px; max-width: 100%; object-fit: contain;"
                        src="<?= base_url('upload/dokumentasi_gambar_perawatan/') . $gambar['nama_dokumentasi_gambar_perawatan'] ?>"
                        alt="Dokumentasi Perawatan">
                </div>
                <?php if (!empty($gambar['keterangan'])): ?>
                    <hr style="margin: 5px 0;">
                    <p style="text-align: center; margin: 5px; padding: 5px;"><?= $gambar['keterangan'] ?></p>
                <?php endif; ?>
            </div>
        </td>
        
        <?php 
        $count_gp++; 
        if ($count_gp % 3 == 0): ?>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    
    <?php if ($count_gp % 3 != 0): ?>
        <?php for ($i = $count_gp % 3; $i < 3; $i++): ?>
            <td style="width:33.33%; padding: 10px;"></td>
        <?php endfor; ?>
        </tr>
    <?php endif; ?>
</table>
<?php endif; ?>
<!-- AKHIR GAMBAR DOKUMENTASI PERAWATAN -->


      
<br><br><br>
<table style="width: 100%; text-align: center; margin-top: 50px;">
   <tr>
      <td style="width: 33%;">
         <p>Mengetahui</p>
         <br><br><br><br>
         <p>(__________________)</p>
      </td>
      <td style="width: 33%;">
         <p>Disetujui</p>
         <br><br><br><br>
         <p>(__________________)</p>
      </td>
      <td style="width: 33%;">
         <p>Dibuat Oleh</p>
         <br><br><br><br>
         <p>(__________________)</p>
      </td>
   </tr>
</table>
   </body>
</html>