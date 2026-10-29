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
         margin-left: 30%;
         margin-right: 30%;
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
                  <p class="p-label">KEGIATAN PEMELIHARAAN PERBAIKAN HARIAN</p>
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
               <p> Nomor Work Order</p>
            </td>
            <td style="width:1%">  : </td>
            <td style="width:74%"> </td>
         </tr>
         <tr>
            <td style="width:25%;margin-left: 10px;">
               <p>Tanggal/ Bulan/ Tahun</p>
            </td>
            <td style="width:1%">  : </td>
            <td style="width:74%"> <?=tgl($tanggal_pm,"l")?></td>
         </tr>
         <tr>
            <td>
               <p> Lokasi </p>
            </td> 
            <td>  : </td>
            <td> Terminal 1,2,3 & Non Terminal (Skytrain, Integrasi Building, TOD) </td>
         </tr>
         <tr>
            <td>
               <p> Fasilitas </p>
            </td>
            <td>: </td>
            <td> <?=$fasilitas?> </td>
         </tr>
         <tr>
            <td>
               <p> Bagian Peralatan</p>
            </td>
            <td>: </td>
            <td><?=sess()['unit_device']?></td>
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
      <?php foreach ($job as $key => $value) :  ?>      
      <tr>
                        <td style="width:30%">
                           <div class="  border-name pb-30">
                              <div class="row center" style="height: 12em">
                                 <img style="display:flex;"
                                    height="150px" 
                                    width="120px"
                                    src="<?=base_url('upload/pm/')?><?=$value['documentasi']?>" >
                              </div>
                              <hr>
                              <p class="tulisan_tengah pd"><?=$value['nama_job']?></p>
                           </div>
                        </td>
                        
                     </tr>
                  <?php  endforeach ?>
                  </table>
      <!-- Modal for PDF preview -->
   </body>
</html>