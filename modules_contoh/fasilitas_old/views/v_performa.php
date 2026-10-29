<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
   .radial-bar-ex-lg {
      width: 300px;
      height: 300px;
      font-size: 55px;
      }
      .radial-bar-ex-lg:after, .radial-bar-ex-lg > img {
      width: 200px;
      height: 200px;
      margin-left: 50px;
      margin-top: 50px;
      line-height: 200px;
      }

    .pointer {
        cursor: pointer;
    }
    .hiddenRow {
    padding: 0 !important;
   }
   .form-group {
      margin-bottom: 0.50em;
   }
   .mb-10 {
    margin-bottom: 10px;
   }
   .lg-stat{
      width: 15px;
      height: 15px;
      border-radius: 50%;
   }
   .align-middle {
      padding-top: 2px;
    
      padding-left: 10px;
   }
   .modal-black{
      background-color: #131a22;
   }
   .modal-wt {
      color: #fff;
   }
   .pd-2{
      padding-left: 5px;
      padding-right: 5px;
   }
   .label-primary {
    background: #4e79a7;
   }
   .label-success {
    background: #59a14f;
   }
   .label-danger {
    background: #e15759;
   }
   td, th {
    white-space: normal;
   }
   .btn.btn-icon2 {
      width: 35px;
      line-height: 20px;
      height: 35px;
      padding: 8px;
      text-align: center;
   }
   .table-bordered {
    border: 1px solid #EBEBEB;
   }
   table {
   
    border-spacing: 2px;
   }
   .table-bordered td, .table-bordered th {
      padding: 10px;
   }
   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
   }
   .putih{
      color: #fff;
   }

   @media (max-width: 575.98px) {
            .modal-fullscreen {
               padding: 0 !important;
            }
            .modal-fullscreen .modal-dialog {
               width: 100%;
               max-width: none;
               height: 100%;
               margin: 0;
            }
            .modal-fullscreen .modal-content {
               height: 100%;
               border: 0;
               border-radius: 0;
            }
            .modal-fullscreen .modal-body {
               overflow-y: auto;
            }
   }
         .modal-fullscreen-xl {
            padding: 0 !important;
         }
         .modal-fullscreen-xl .modal-dialog {
            width: 100%;
            max-width: none;
            height: 100%;
            margin: 0;
         }
         .modal-fullscreen-xl .modal-content {
            height: 100%;
            border: 0;
            border-radius: 0;
         }
         .modal-fullscreen-xl .modal-body {
               overflow-y: auto;
         }
       
         .btn-open-modal {
            margin-bottom: 0.5em;
         }

         .b-yellow{
            border: 1px solid #ffb64d;
         }
         
   /* End Css modal  */
            .b-yellow{
            border: 1px solid #ffb64d;
         }

         .progress-wrapper {
               display: flex;
               align-items: center;
         }

         .progress-bar-wrapper {
            flex-grow: 1;
            margin-left: 10px; /* Menambahkan jarak antara label dan progress bar */
         }

         .progress-label {
            margin-right: 10px; /* Menambahkan jarak antara progress bar dan label */
         }
         .mb-10{
            margin-botton: 40px;
         }
         .mt-10{
            margin-top: 10px;
         }

         .mb-10{
            margin-botton: 40px;
         }

         .modal-content img {
            max-width: 20%; /* Mengatur lebar maksimum gambar menjadi 100% dari lebar modal */
            max-height: 30; /* Mengatur tinggi maksimum gambar agar sesuai dengan tinggi viewport */
            display: block; /* Memastikan gambar ditampilkan sebagai blok */
            margin: auto; /* Menengahkan gambar */
         }

         .close {
            position: absolute;
            top: 15px;
            right: 15px; /* Mengatur posisi tombol close ke pojok kanan atas */
            color: #ffffff; /* Warna teks tombol close */
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            z-index: 9999; /* Memastikan tombol close tampil di atas gambar */
         }

         

</style>


<div id="cus-css"></div>



<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>
<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-home bg-c-blue"></i>
            <div class="d-inline">
               <h5><?=$title?></h5>
               <span><?=$title_des?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb">
            <!-- Tombol Kembali -->
            <a href="<?php echo base_url('fasilitas'); ?>" class="btn btn-primary float-right">
               <i class="fas fa-arrow-left"></i> Kembali
            </a>
         </div>
      </div>
   </div>
</div>




<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
            <div class="row">
            
            
            <div class="col-md-6">
               <div class="card">
                  <div class="card-body ">    
                        <div class="card-title text-center">
                           <h5>Performansi Fasilitas</h5>
                        </div>
                        <div class="form-group row ">
                           <div class="col-md-8 offset-md-2 text-center">
                              <img id="foto" src="<?=base_url()?>./upload/icon-image-not-found-free-vector.jpg" width="150" height="150" alt="foto" onclick="previewImage()">
                           </div>
                        </div>
                        <!-- Modal -->
                        <div id="previewModal" class="modal">
                           <div class="modal-content">
                              <span class="close" onclick="closeModal()">&times;</span> <!-- Tombol close -->
                              <img id="previewImg">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="nama_fasilitas" class="col-md-4 col-form-label">Nama Fasilitas</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="lokasi" class="col-md-4 col-form-label">Kategori</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="kategori" id="kategori" disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="kategori" class="col-md-4 col-form-label">Lokasi</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="lokasi" id="lokasi" disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="kategori" class="col-md-4 col-form-label">Sub Lokasi</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="sub_lokasi" id="sub_lokasi" disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="ip" class="col-md-4 col-form-label">IP Address</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" name="ip" id="ip" disabled>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="ip" class="col-md-4 col-form-label">Status</label>
                           <div class="col-md-8">
                              <label id="status" class="label label-success">ON</label>
                           </div>
                        </div>
                  </div>
               </div>
            </div>

            

            <div class="col-md-6">
               <div class="card">
                  <div class="card-body d-flex flex-column align-items-center justify-content-center">
                     <div class="card-title text-center ">
                        <h5>Performansi Fasilitas</h5>
                     </div>
                     <div class="row">
                        <div class="col-md12">
                           <div id="data-perform" data-label="60%" class="radial-bar  radial-bar-ex-lg radial-bar-default"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>


            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-block">
                        <div class="row" id="export">
                           <div class="col-md-12">
                           
                           </div>
                        </div>
                        <div id="complex-dt_wrapper" class="dataTables_wrapper dt-bootstrap4">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="dataTables_length" id="complex-dt_length">
                                    <label>
                                       Show 
                                       <select name="complex-dt_length" aria-controls="complex-dt" class="form-control input-sm" id="limitData">
                                          <option value="10">10</option>
                                          <option value="25">25</option>
                                          <option value="50">50</option>
                                          <option value="100">100</option>
                                          <option value="1000">1000</option>
                                       </select>
                                       entries
                                    </label>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div id="complex-dt_filter" class="dataTables_filter">
                                    <label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="srcData"></label>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">No</th>
                                       <th class="cemter-t">Foto</th>
                                       <th class="cemter-t">Nama Perangkat</th>
                                       <th class="cemter-t">Kategori</th>
                                       <th class="cemter-t">Jenis Perangkat</th>
                                       <th class="cemter-t">IP Address</th>
                                       <th class="cemter-t">Serial Number</th>
                                       <th class="cemter-t">Merk</th>
                                       <th class="cemter-t">Kondisi Aset</th>
                                       <th class="cemter-t">Last Maintenance</th>
                                       <th class="cemter-t">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody id="Data-AP">
                                 </tbody>
                              </table>
                           </div>
                           <div class="row" id="data-pag">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            
            <div class="row">
               <div class="col-xl-5 col-md-6">
                  <div class="card latest-update-card">
                     <div class="card-header">
                        <h5>History Log Maintenance</h5>
                        <div class="card-header-right">
                           <ul class="list-unstyled card-option">
                              <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                              <li><i class="feather icon-maximize full-card"></i></li>
                              <li><i class="feather icon-minus minimize-card"></i></li>
                              <li><i class="feather icon-refresh-cw reload-card"></i></li>
                              <li><i class="feather icon-trash close-card"></i></li>
                              <li><i class="feather icon-chevron-left open-card-option"></i></li>
                           </ul>
                        </div>
                     </div>


                     <div class="card-block">
                        <div class="scroll-widget">
                           <div class="latest-update-box" id="dataLogHistory">
                              <div class="row p-t-20 p-b-30">
                                 <div class="col-auto text-right update-meta p-r-0">
                                    <i class="b-primary update-icon ring"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6>Devlopment & Update</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit amet, <a href="#!" class="text-c-blue"> More</a></p>
                                 </div>
                              </div>
                              <div class="row p-b-30">
                                 <div class="col-auto text-right update-meta p-r-0">
                                    <i class="b-primary update-icon ring"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6>Showcases</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Lorem dolor sit amet, <a href="#!" class="text-c-blue"> More</a></p>
                                 </div>
                              </div>
                              <div class="row p-b-30">
                                 <div class="col-auto text-right update-meta p-r-0">
                                    <i class="b-success update-icon ring"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6>Miscellaneous</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit ipsum amet, <a href="#!" class="text-c-green"> More</a></p>
                                 </div>
                              </div>
                              <div class="row p-b-30">
                                 <div class="col-auto text-right update-meta p-r-0">
                                    <i class="b-danger update-icon ring"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6>Your Manager Posted.</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit amet, <a href="#!" class="text-c-red"> More</a></p>
                                 </div>
                              </div>
                              <div class="row p-b-30">
                                 <div class="col-auto text-right update-meta p-r-0">
                                    <i class="b-primary update-icon ring"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6>Showcases</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Lorem dolor sit amet, <a href="#!" class="text-c-blue"> More</a></p>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-auto text-right update-meta p-r-0">
                                    <i class="b-success update-icon ring"></i>
                                 </div>
                                 <div class="col p-l-5">
                                    <a href="#!">
                                       <h6>Miscellaneous</h6>
                                    </a>
                                    <p class="text-muted m-b-0">Lorem ipsum dolor sit ipsum amet, <a href="#!" class="text-c-green"> More</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>


               <div class="col-xl-7 col-md-6">
                  <!-- Kartu kedua -->
                  <div class="card">
                     <!-- Konten kartu kedua -->
                     <div class="card-header">
                        <h5>Presentase Indikasi Kerusakan</h5>
                        <span>consectetur adipisicing elit</span>
                     </div>
                     <div class="card-block">
                        <!-- Isi kartu kedua -->
                        <!-- Tempat untuk grafik -->
                        <div class="row" id="dataBar">
                           <div class="col-xl-12 col-md-6">
                              <h6>Mini PC</h6>
                              <h5 class="m-b-30 f-w-700">532<span class="text-c-green m-l-10">+1.69%</span></h5>
                              <div class="progress">
                                 <div class="progress-bar " style="width:25%"></div>
                              </div>
                           </div>
                           <div class="col-xl-12 col-md-6">
                              <h6>Monitor</h6>
                              <h5 class="m-b-30 f-w-700">4,569<span class="text-c-red m-l-10">-0.5%</span></h5>
                              <div class="progress">
                                 <div class="progress-bar " style="width:65%"></div>
                              </div>
                           </div>
                           <div class="col-xl-12 col-md-6">
                              <h6>Kamera CCTV</h6>
                              <h5 class="m-b-30 f-w-700">89%<span class="text-c-green m-l-10">+0.99%</span></h5>
                              <div class="progress">
                                 <div class="progress-bar " style="width:85%"></div>
                              </div>
                           </div>
                           <div class="col-xl-12 col-md-6">
                              <h6>Jaringan</h6>
                              <h5 class="m-b-30 f-w-700">365<span class="text-c-green m-l-10">+0.35%</span></h5>
                              <div class="progress">
                                 <div class="progress-bar " style="width:45%"></div>
                              </div>
                           </div>
                           <div class="col-xl-12 col-md-6" style="margin-top: 30px;">
                              <h6>Listrik</h6>
                              <h5 class="m-b-30 f-w-700">365<span class="text-c-green m-l-10">+0.35%</span></h5>
                              <div class="progress">
                                 <div class="progress-bar " style="width:45%"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>  
         </div>
      </div>
   </div>
</div>





<!-- [ page content ] start -->

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<!-- <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
   var start = "";
   var end = "";
   
      function show () {
         $("#spinner").addClass("show");
      
      }
      function hide () {
         $("#spinner").removeClass("show");
      }
      FilterData();
    

   function FilterData(id) {
     show();
     var formData = new FormData();
     formData.append('limit',  $('#limitData').val());
     formData.append('src',  $('#srcData').val());
     
      var id =(id == null ? 0: id);
     $.ajax({
         url: "<?=base_url()?>Perangkat/LoadDataAnl/"+<?=$id?>,
         type: 'post',
          data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
            
             var no =1;
            //  script untuk menampilkan data pada label perform fasilitas
             $('#nama_fasilitas').val(json['fasilitas']['nama_fasilitas']);
             $('#kategori').val(json['fasilitas']['nama_unit']);
             $('#lokasi').val(json['fasilitas']['nama_lokasi']);
             $('#sub_lokasi').val(json['fasilitas']['nama_sublokasi']); 
             $('#ip').val(json['fasilitas']['ip_address']);
             $('#status').val(json['fasilitas']['status']);
            
            
             

             
             
             jQuery.each(json['tabel-data'], function (i, val) {
                var opt = "";
                if (val['status_perangkat'] == 0) {
                    opt = `<a href="<?=base_url()?>/perangkat/performPerangkat/${val['id_perangkat']}"><button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(${val['id_perangkat']})"><i class="feather icon-eye"></i></button></a>`;
                } else {
                    opt = `<button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(${val['id_perangkat']})"><i class="feather icon-eye"></i></button>`;
                }
                row += `<tr>
                            <td>${no++}</td>
                            <td>${val['foto'] || 'foto'}</td>
                            <td>${val['nama_perangkat'] || ''}</td>
                            <td>${val['kode_unit'] || ''}</td>
                            <td>${val['nama_jp'] || ''}</td>
                            <td>${val['ip_address'] || ''}</td>
                            <td>${val['serial_number'] || ''}</td>
                            <td>${val['merk_nama'] || ''}</td>   
                            <td>${val['status'] || ''}</td>                     
                            <td>${val['create_date'] || ''}</td>   
                            <td>
                                <div class="btn-group" role="group" data-toggle="tooltip" data-placement="top" title="" data-original-title=".btn-xlg">
                                    ${opt}
                                </div>
                            </td>
                        </tr>`;
            });
            DataChart(json['perfomChart']);
            DataProgress(json['ProgressData']);
            HistoryLog(json['LogHistory']);
            $('#tabel-data > tbody:last-child').html(row);

            hide();
        },
        error: function () {
            hide();
        }
    });
    return false;
}

   function LoadDataDetail(id){
      $.ajax({
         url: "<?=base_url()?>perangkat/LoadDataDetail/"+id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
             jQuery.each(json['detail'], function(i, val) {
                 
               row += `<tr >
                        <td>` + val['property'] + `</td>
                        <td>` + (val['nama'] == null ? '' : val['nama']) + `</td>
                                       
                           <td>
                                         
                                          <button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditDataDetail(` + val['id_perangkat'] + `)"><i class="feather icon-edit"></i></button>
                                          <button class="btn waves-effect waves-light btn-danger btn-icon" onclick="DeleteDetail(` + val['id_perangkat'] + `)"><i class="fa fa-trash"></i></button>
                                       
                                       </td>
                                    </tr>`;
             });

             $('#tabel-data-detail > tbody:last-child').html(row);
         },
         error: function() {
             hide();
         }
     });
     return false;
   }
    
   function ViewDetail(id) {
   //   show();
    

      $('#m-detailperangkat').modal('show');
      $('#m-detailperangkat').find('.modal-title').html('Tambah Detail Perangkat');   
      $('#m-detailperangkat').find('form').attr('onsubmit','return SaveDataDetail(this,\''+id+'\')');
      LoadDataDetail(id);
     $.ajax({
         url: "<?=base_url()?>perangkat/LoadDataByid/"+id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
             $('#jenis_perangkat').html(json['perangkat']['id_jenisperangkat']);  
             $('#nama_perangkat').html(json['perangkat']['nama_perangkat']);  
             $('#SN_perangkat').html(json['perangkat']['serial_number']);
             MasterDetailPerangkat(json['perangkat']['id_jenisperangkat']);
               var row = '<option value=""></option>';
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id_jenisperangkat']+`">`+val['nama']+`</option>`;
                 });
                 
                 $('#id_jenisperangkat').html(row);
             hide();
         },
         error: function() {
             hide();
         }
     });
     return false;
   }
     



    function JenisPerangkat(){
        
        $.ajax({
              url: "<?=base_url()?>Fasilitas/LoadDataJP",
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id_jenisperangkat']+`">`+val['nama']+`</option>`;
                 });
                 
                 $('#id_jenisperangkat').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }
   function MasterDetailPerangkat(id){
        
        $.ajax({
              url: "<?=base_url()?>perangkat/Loadmasterdetail/"+id,
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['idmaster_detail_perangkat']+`">`+val['nama']+`</option>`;
                 });
                 
                 $('#idmaster_detail_perangkat').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }


 



   $('body').on('change','#limitData', function() {
   
      FilterData();
   });

   $( "#srcData" ).on( "keypress", function() {
      FilterData();
     
   } );



   function DataChart(data){ 
     
      if (data['Performa']>= 50) {
         var star = 270;
         var param = ( (data['Performa']- 50) * 3.5)+star;
         $("#data-perform").prop('style', ' background-image: linear-gradient('+param+'deg, #e53935 50%, transparent 50%, transparent), linear-gradient(270deg, #e53935 50%, #d6d6d6 50%, #d6d6d6');
      }else{
         var star = 90;
         var param = ( data['Performa'] * 3.5)+star;
         $("#data-perform").prop('style', 'background-image: linear-gradient(90deg, #d6d6d6 50%, transparent 50%, transparent), linear-gradient('+param+'deg, #FE8A7D 50%, #d6d6d6 50%, #d6d6d6)');
      }
      
      $('#data-perform').attr('data-label', data['Performa']+'%');
   }




function HistoryLog(data) {
   var row='';
   if (data.length === 0) {
      
    // strValue was empty string, false, 0, null, undefined, ...
    row +=                 `<div class="row p-t-20 p-b-30">
                              <div class="col-12 text-center"> <!-- Menggunakan class text-center -->
                                 <p class="text-muted m-b-0">Belum Ada History</p>
                              </div>
                           </div>`;
   
               }else{   
                 
                           jQuery.each(data, function( i, val ) {
                    
                    row +=`<div class="row p-t-20 p-b-30">
                                            <div class="col-auto text-right update-meta p-r-0">
                                            <i class="feather icon-briefcase bg-c-red update-icon"></i>
                                            </div>
                                            <div class="col p-l-5">
                                               <a href="#!">
                                                  <h6>`+val['tittle']+`</h6>
                                               </a>
                                               <p class="text-muted m-b-0">`+val['note']+`</p>
                                               <small class="text-muted m-b-0">`+val['create_date']+`</small>
                                            </div>
                                         </div>`;
                               });
                 
               }         
                 $('#dataLogHistory').html(row);
   
   
}




function DataProgress(data) {
    var row = '';
    jQuery.each(data, function(i, val) {
        row += `<div class="col-xl-12 col-md-6 mb-10 mt-10">
                    <h5 class="m-b-10 f-w-500"><span class="text-c-black m-l-8" style="font-size: 15px;">` + val['name'] + `</span></h5>
                
                    <div class="progress">
                        <div class="progress-bar ` + val['class'] + `" style="width:` + val['value'] + `%"></div><span class="text-c-black m-l-10">` + val['value'] + `%</span>
                    </div>
                </div>`;
    });
    $('#dataBar').html(row);
}


function previewImage() {
    var modal = document.getElementById("previewModal");
    var img = document.getElementById("foto");
    var modalImg = document.getElementById("previewImg");

    modal.style.display = "block";
    modalImg.src = img.src;
}

function closeModal() {
    var modal = document.getElementById("previewModal");
    modal.style.display = "none";
}



   // function DigBatang(data){
   //    var ctx = document.getElementById('myChart').getContext('2d');
      

   //       // Data untuk grafik
   //       var data = {
   //          labels: data['label'],
   //          datasets: [{
   //                label: 'Presentase',
   //                data:data['data'], // Ubah data presentase di sini
   //                backgroundColor: [
   //                   'rgba(255, 99, 132, 0.2)',
   //                   'rgba(54, 162, 235, 0.2)',
   //                   'rgba(255, 206, 86, 0.2)',
   //                   'rgba(75, 192, 192, 0.2)',
   //                   'rgba(0, 128, 0, 0.2)',
   //                ],
   //                borderColor: [
   //                   'rgba(255, 99, 132, 1)',
   //                   'rgba(54, 162, 235, 1)',
   //                   'rgba(255, 206, 86, 1)',
   //                   'rgba(75, 192, 192, 1)',
   //                   'rgba(0, 128, 0, 1)',
   //                ],
   //                borderWidth: 1,
                 
                  
   //          }]
   //       };

   //       // Konfigurasi grafik
   //       var options = {
   //          indexAxis: 'y',
   //          scales: {
   //                y: {
   //                   beginAtZero: true,
   //                   align: 'end',
   //                   // position: 'right'
   //                }
                  
   //          },
            
   //       };

   //       // Buat grafik batang
   //       var myChart = new Chart(ctx, {
   //          type: 'bar',
   //          data: data,
   //          options: options
   //       });
   // }
</script>