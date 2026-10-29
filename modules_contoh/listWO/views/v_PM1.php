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
         height: 950px;
         border: 1px solid #000;
         margin: 0px;
         /* padding: 20px; */
         page-break-inside: avoid; /* Avoid breaking the container */
         }
         table {
         /* margin-left: 5px; */
         border-spacing: 0px;
         border-collapse: collapse;
         width: 100%;
         }
         .table-pekerjaan {
         margin-left: 50px;
         border-spacing: 5px;
         border-collapse: collapse;
         width: 75%;
         }
         .table-mid{
         width: 100%;
         object-fit: contain;
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
         margin-left: 40px;
         margin-right: 40px;
         }
         .mt-5{
         margin-top: 10px;
         }
         td{
         }
         table.fs  td {
         padding-top: 10px;
         padding-bottom: 10px;
         font-size: 6px;
         text-align: center;
         }
         table.fs  th {
         font-size: 8px;
         text-align: center;
         }
         .mg-50{
         margin-left: 50px;
         margin-right: 50px;
         }
         .mg-10{
         margin-left: 10px;
         margin-right: 10px;
         }
         .pdt-5{
         /* margin-top: 10px; */
         margin-left: 10px;
         }
         .pd-status{
         /* margin-left: 10px; */
         margin-top: 10px;
         }
         table.pd-t  td {
         padding-bottom: 10px;
         }
         .text-i{
         font-style: italic;
         }
         .pd-sig{
         margin-top: 250px;
         }
         .pd-ceklist{
         margin-top: 40px;
         }
         .text-right{
         float: right;
         margin-right: 30px;
         }
         .dot{
         border-bottom-style: dotted;
         margin-bottom: 25px;
         }
      </style>
   </head>
   <body>
      <div class="body-info">
         <table class="mb-1"  border="1" style="heightL"  width="100%">
            <tr>
               <td  class=" tulisan_tengah" style="width:25%">
                  <img style="display:flex;" width="70%"  src="<?=ImageLogo('1')?>" />  
               </td>
               <th  class=" " style="width:50%">
                  <p class="p-label">PERINTAH KERJA </p>
                  <p class="p-label">KEGIATAN PEMELIHARAAN PENCEGAHAN</p>
                  <p class="p-label">(PREVENTIVE MAINTENANCE)</p>
                  <p class="p-label">PERALATAN <?=sess()['unit_name']?> <?=$pm_type['name_pm']?></p>
               </th>
               <td   class=" tulisan_tengah" style="width:25%">
                  <img style="display:flex;" width="70%"  src="<?=ImageLogo('2')?>" />
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  <table class="ps-10 pt-10 pb-10">
                      <tr>
                        <td>
                           <p> No. WO</p>
                        </td>
                        <td>: </td>
                        <td> <?=$no_wo?></td>
                     </tr>
                     <tr>
                        <td style="width:25%">
                           <p> Hari / Tanggal</p>
                        </td>
                        <td style="width:1%">  : </td>
                        <td style="width:74%"> <?=$tanggal?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Shift Kerja</p>
                        </td>
                        <td>  : </td>
                        <td><?=$shift_l['name']?> </td>
                     </tr>
                     <tr>
                        <td>
                           <p> Team</p>
                        </td>
                        <td>: </td>
                        <td> <?=$team?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Pelaksana</p>
                        </td>
                        <td>: </td>
                        <td> <?=$pelaksana?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Pengawas</p>
                        </td>
                        <td>: </td>
                        <td> <?=$pengawas?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Lokasi</p>
                        </td>
                        <td>: </td>
                        <td><?= $lokasi ?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Jam Mulai</p>
                        </td>
                        <td>: </td>
                        <td><?=$shift_l['jam']?> </td>
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
                  <br>
                  <table class="table-pekerjaan ">
                     <tr>
                        <td colspan="3"><?= $no.'. '.$value['nama_job']?></td>
                     </tr>
                     <tr>
                        <td>Status Pekerjaan</td>
                        <td style="width:1%">  <input type="checkbox" checked="checked" class="pdt-5"></td>
                        <td style="width:5%"><span class="ml-4 mg-10">Selesai</span></td>
                     </tr>
                     <tr>
                        <td colspan="3">
                           <p class="text-i dot" >Catatan :</p>
                        </td>
                     </tr>
                  </table>
                  <?php $no++; endforeach; ?>
                  <div class="pd-sig">
                  </div>
                  <p class="text-i text-right">
                     (Checklist item dan foto dokumentasi terlampir)
                  </p>
                  <table>
                     <tr>
                        <td style="width:50%">
                           <div class=" tulisan_tengah border-name pt-30 pb-30">
                              <p>ANGKASA PURA INDONESIA</p>
                              <hr>
                              <div class="row" style="height: 10em"></div>
                              <p>(<?=$ttd['organik']['nama']?>)</p>
                           </div>
                        </td>
                        <td>
                           <div class=" tulisan_tengah border-name pt-30 pb-30">
                              <p>IAS SUPPORT INDONESIA</p>
                              <hr>
                              <div class="row" style="height: 10em"></div>
                              <p>( <?=$ttd['leder']['nama']?> )</p>
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
         <table width="100%"  style="height:300px;"  >
            <tr style="">
               <td  class=" tulisan_tengah" style="width:25%;border-bottom: 1px solid #000;  ">
                  <img style="display:flex; margin-left: 25px;" width="70%"  src="<?=ImageLogo('1')?>" />  
               </td>
               <td  class=" tulisan_tengah" style="border-bottom: 1px solid #000;width:50%;border-left: 1px solid #000;border-right: 1px solid #000;" style="">
                  <p class="p-label">DOKUMENTASI LAPORAN </p>
                  <p class="p-label">PEMELIHARAAN PERBAIKAN</p>
                  <p class="p-label">(CORRECTIVE MAINTENANCE)</p>
                  <p class="p-label">PERALATAN {SESSION}</p>
               </td>
               <td   class=" tulisan_tengah" style="border-bottom: 1px solid #000;width:25%">
                  <img style=" margin-left: 13%;" width="70%"  src="<?=ImageLogo('2')?>" />
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  <table   class="ps-10 pt-25">
                     <tr>
                        <td style="width:25%;margin-left: 10px;">
                           <p> Hari / Tanggal</p>
                        </td>
                        <td style="width:1%">  : </td>
                        <td style="width:74%"> <?=$tanggal?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Shift Kerja</p>
                        </td>
                        <td>  : </td>
                        <td> <?=$shift_l['name']?></td>
                     </tr>
                     <tr>
                        <td>
                           <p> Team</p>
                        </td>
                        <td>: </td>
                        <td> <?=$team?></td>
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
                        <td> <?=$shift_l['jam']?>  </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td colspan="3" >
                  <table >
                     <tr>
                        <td>
                           <table   border="1"  class="table-mid mg-5 mt-5 fs" >
                              <tr>
                                 <th rowspan="2" >NO</th>
                                 <th  rowspan="2">LOKASI</th>
                                 <th colspan="<?=count($job)?>" >CHECKLIST</th>
                                 <th  rowspan="2"> Note</th>
                              </tr>
                              <tr>
                                 <?php 
                                    foreach ($job as $key => $value) :
                                    ?>
                                 <th>  <?=$value['nama_job']?> </th>
                                 <?php endforeach;?>
                              </tr>
                              <?php 
                                 $x=1;
                                 foreach ($fasilitas as $key => $value) :
                                 ?>
                              <tr>
                                 <td ><?= $x?></td>
                                 <td > <?=$value['nama_fasilitas']?> </td>
                                 <?php 
                                    foreach ($job as $key => $value) :
                                    ?>
                                 <td> </td>
                                 <?php endforeach;?>
                                 <td >DONE </td>
                              </tr>
                              <?php 
                                 $x++;endforeach;?>
                              <!-- <?php 
                                 // $limit = 18-$c_fasilitas;
                                 // for($x=1;$x<=$limit;$x++) {
                                 ?>
                              <tr>
                                 <td>12</td>
                                 <td> Arrival Samping Informasi Kanan T2E </td>
                                 <td> </td>
                                 <td> </td>
                                 <td> </td>
                                 <td>DONE </td>
                              </tr>
                              <?php //}?> --> 
                           </table>
                        </td>
                     </tr>
                  </table>
                  <div class="pd-ceklist">
                  </div>
                  <p class="text-right">(Checklist item dan foto dokumentasi terlampir)</p>
               </td>
            </tr>
         </table>
      </div>
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
                     <p class="p-label">PEMELIHARAAN PERBAIKAN</p>
                     <p class="p-label">(CORRECTIVE MAINTENANCE)</p>
                     <p class="p-label">PERALATAN {SESSION}</p>
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
                  <p> Hari / Tanggal</p>
               </td>
               <td style="width:1%">  : </td>
               <td style="width:74%"> <?=$tanggal?></td>
            </tr>
            <tr>
               <td>
                  <p> Shift Kerja</p>
               </td>
               <td>  : </td>
               <td> <?=$shift_l['name']?></td>
            </tr>
            <tr>
               <td>
                  <p> Team</p>
               </td>
               <td>: </td>
               <td><?=$team?> </td>
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
               <td><?=$shift_l['jam']?> </td>
            </tr>
         </table>
         <br>
         <table >
            <tr>
               <td>
                  <?php $nodok =1;foreach ($dock as $key => $value) :?>
                  <table  >
                     <tr>
                        <?php   foreach ($value['file'] as $key2 => $val) : ?>
                        <td style="width:50%">
                           <div class="  border-name pb-30">
                              <div class="row center" style="height: 16em">
                                 <img style="display:flex;"
                                    height="<?=scaleIMG(base_url('upload/pm/').$val['documentasi'],'1')['h']?>" 
                                    width="<?=scaleIMG(base_url('upload/pm/').$val['documentasi'],'1')['w']?>"
                                    src="<?=base_url('upload/pm/')?><?=$val['documentasi']?>" >
                              </div>
                              <hr>
                              <p class="tulisan_tengah pd"> <?=$value['nama']?></p>
                           </div>
                        </td>
                        <?php endforeach;?>
                     </tr>
                  </table>
                  <?php   endforeach;?>
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>