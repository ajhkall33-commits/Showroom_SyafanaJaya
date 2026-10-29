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
            margin: 70px;
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
      </style>
   </head>
   <body>
     
   <div class="body-info">
      <table class="mb-1"  border="1" style="heightL"  width="100%">
         <tr>
            <td  class=" tulisan_tengah" style="width:25%">
               <img style="display:flex;" width="70%"  src="<?=base_url()?>/assets/ap2.png" />  
            </td>
            <th  class=" " style="width:50%">
               <p class="p-label">PERINTAH KERJA </p>
               <p class="p-label">KEGIATAN PEMELIHARAAN PENCEGAHAN</p>
               <p class="p-label">(PREVENTIVE MAINTENANCE)</p>
               <p class="p-label">PERALATAN <?=sess()['unit_device']?> - BULANAN</p>
            </th>
            <td   class=" tulisan_tengah" style="width:25%">
               <img style="display:flex;" width="70%"  src="<?=base_url()?>/assets/asp.png" />
            </td>
         </tr>
         <tr>
            <td colspan="3" >
               <table   class="ps-10 pt-10 pb-10">
                  <tr>
                     <td style="width:25%">
                        <p> Hari / Tanggal</p>
                     </td>
                     <td style="width:1%">  : </td>
                     <td style="width:74%"> 2</td>
                  </tr>
                  <tr>
                     <td>
                        <p> Shift Kerja</p>
                     </td>
                     <td>  : </td>
                     <td> </td>
                  </tr>
                  <tr>
                     <td>
                        <p> Team</p>
                     </td>
                     <td>: </td>
                     <td></td>
                  </tr>
                  <tr>
                     <td>
                        <p> Lokasi</p>
                     </td>
                     <td>: </td>
                     <td></td>
                  </tr>
                  <tr>
                     <td>
                        <p> Jam Mulai</p>
                     </td>
                     <td>: </td>
                     <td></td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td  colspan="3">
            <?php
            $no = 1;
            foreach ($job as $key => $value) :
            ?>
            <div class="mb-4">
               <h5 class="font-bold">
                   <?= $no.' '.$value['nama_job']?>
               </h5>
               <div class="items-center mb-2">
                  <span>Status Pekerjaan</span>
                  <div class="flex items-center ml-4">
                     <input class="mr-2" type="checkbox">
                     <span class="ml-4">Selesai</span>
                  </div>
                 
               </div>
               <div>
                  <span>
                  Catatan :
                  </span>
                  <div class="border-b border-gray-300 mt-2">
                  </div>
               </div>
            </div>
            <?php $no++; endforeach; ?>
               <p>
               (Checklist item dan foto dokumentasi terlampir)
               </p>
               <table>
                  <tr>
                     <td style="width:50%">
                        <div class=" tulisan_tengah border-name pt-30 pb-30">
                           <p>PT ANGKASA PURA II</p>
                           <hr>
                           <div class="row" style="height: 10em"></div>
                           <p>()</p>
                        </div>
                     </td>
                     <td>
                        <div class=" tulisan_tengah border-name pt-30 pb-30">
                           <p>PT ANGKASA PURA SOLUSI</p>
                           <hr>
                           <div class="row" style="height: 10em"></div>
                           <p>()</p>
                        </div>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </div>
   <div style="clear:both;"></div>
   <div class="container">
         <!-- KOP SURAT START -->
         <table width="100%" >
            <thead>
               <tr style="">
                  <td  class=" tulisan_tengah" style="width:25%;border-bottom: 1px solid #000;  ">
                     <img style="display:flex; margin-left: 25px;" width="70%"  src="<?=base_url()?>/assets/ap2.png" />  
                  </td>
                  <td  class=" tulisan_tengah" style="border-bottom: 1px solid #000;width:50%;border-left: 1px solid #000;border-right: 1px solid #000;" style="">
                     <p class="p-label">DOKUMENTASI LAPORAN </p>
                     <p class="p-label">PEMELIHARAAN PERBAIKAN</p>
                     <p class="p-label">(CORRECTIVE MAINTENANCE)</p>
                     <p class="p-label">PERALATAN <?=sess()['unit_device']?></p>
                  </td>
                  <td   class=" tulisan_tengah" style="border-bottom: 1px solid #000;width:25%">
                     <img style=" margin-left: 13%;" width="70%"  src="<?=base_url()?>/assets/asp.png" />
                  </td>
               </tr>
            </thead>
         </table>
         <!-- KOP SURAT END -->
         <table   class="ps-10 pt-25">
            <tr>
               <td style="width:25%;margin-left: 10px;">
                  <p> Hari / Tanggal</p>
               </td>
               <td style="width:1%">  : </td>
               <td style="width:74%"> </td>
            </tr>
            <tr>
               <td>
                  <p> Shift Kerja</p>
               </td>
               <td>  : </td>
               <td> </td>
            </tr>
            <tr>
               <td>
                  <p> Team</p>
               </td>
               <td>: </td>
               <td> </td>
            </tr>
            <tr>
               <td>
                  <p> Lokasi</p>
               </td>
               <td>: </td>
               <td>Terminal 1,2,3 & Non Terminal (Skytrain, Integrasi Building, TOD) </td>
            </tr>
            <tr>
               <td>
                  <p> Jam Mulai</p>
               </td>
               <td>: </td>
               <td> </td>
            </tr>
         </table>
         <br>
         <table >
            <tr>
               <td>
                  <table  border="1"  class="table-mid mg-5 mt-5">
                     <tr>
                        <td rowspan="2">NO</td>
                        <td  rowspan="2"> LOKASI </td>
                        <td colspan="<?=count($job)?>" >CHECKLIST </td>
                        
                        <td  rowspan="2"> Note</td>
                     </tr>
                     <tr>
                       
                        <?php 
                       foreach ($job as $key => $value) :
                        ?>
                        
                        <td>  <?=$value['nama_job']?> </td>
                       
                        <?php endforeach;?>
                        
                     </tr>
                     
                  </table> 
                 
                  
               </td>
            </tr>
         </table>
       
      <!-- Modal for PDF preview -->
   </body>
</html>