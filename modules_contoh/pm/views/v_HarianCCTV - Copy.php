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
                  <p class="p-label">PREVENTIVE MAINTENANCE</p>
                  <p class="p-label">PERALATAN KAMERA CCTV</p>
                  <p class="p-label">BANDARA SOEKARNO - HATTA</p>
               </th>
               <td   class=" tulisan_tengah" style="width:25%">
                  <img style="display:flex;" width="70%"  src="<?=base_url()?>/assets/asp.png" />
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  <table >
                     <tr>
                        <td>
                           <table   class="ps-10 pt-10 pb-10">
                              <tr>
                                 <td style="width:25%">
                                    <p> Nomor WorK Order</p>
                                 </td>
                                 <td style="width:1%">  : </td>
                                 <td style="width:74%"> </td>
                              </tr>
                              <tr>
                                 <td>
                                    <p> Fasilitas</p>
                                 </td>
                                 <td>  : </td>
                                 <td> </td>
                              </tr>
                              <tr>
                                 <td>
                                    <p> Nama Pelaksana</p>
                                 </td>
                                 <td>: </td>
                                 <td></td>
                              </tr>
                              
                           </table>
                        </td>
                        <td style="width:50%">
                           <table   class="ps-10 pt-10 pb-10">
                              <tr >
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
                                    <p> Waktu Mulai Kerja</p>
                                 </td>
                                 <td>: </td>
                                 <td></td>
                              </tr>
                              <tr>
                                 <td>
                                    <p> Waktu Selesai Kerja</p>
                                 </td>
                                 <td>: </td>
                                 <td></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
                  <table border ="1" class="ps-10 pt-10 pb-10">
                     <tr>
                        <td>No </td>
                        <td>ID</td>
                        <td>Type</td>
                        <td>Nama Camera CCTV</td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  
                  <table border ="1" class="ps-10 pt-10 pb-10">
                     <tr>
                        <td colspan="4">
                           Safety Check
                        </td>
                     </tr>
                     <tr>
                        <td>1. </td>
                        <td> Pemeriksaan Tampilan Aplikasi</td>
                        <td> Normal</td>
                        <td>Tidak</td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  
                  <table border ="1" class="ps-10 pt-10 pb-10">
                     <tr>
                        <td colspan="4">
                           Pemeriksaan Supply Voltage
                        </td>
                     </tr>
                     <tr>
                        <td>1. </td>
                        <td> Pemeriksaan Tampilan Aplikasi</td>
                        <td> Normal</td>
                        <td>Tidak</td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  
                  
               </td>
            </tr>
           
            <tr>
               <td  colspan="3">
                  
                  <table>
                     <tr>
                        <td style="width:50%">
                           <div class=" tulisan_tengah border-name pt-30 pb-30">
                              <p>SPV SSIT API</p>
                              <hr>
                              <div class="row" style="height: 10em"></div>
                              <p>()</p>
                           </div>
                        </td>
                        <td>
                           <div class=" tulisan_tengah border-name pt-30 pb-30">
                              <p>SHIFT LEADER OM IAS SUPPORT</p>
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
                  <p class="p-label">KEGIATAN PEMELIHARAAN PERBAIKAN HARIAN</p>
                  <p class="p-label">PERALATAN {SESSION}</p>
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
            <td style="width:74%"> </td>
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
            <td> </td>
         </tr>
         <tr>
            <td>
               <p> Bagian Peralatan</p>
            </td>
            <td>: </td>
            <td></td>
         </tr>
         <tr>
            <td>
               <p> Jam</p>
            </td>
            <td>: </td>
            <td> </td>
         </tr>
      </table>
      <br>
      <table >
         <tr>
            <td>
               
            </td>
         </tr>
      </table>
      <!-- Modal for PDF preview -->
   </body>
</html>