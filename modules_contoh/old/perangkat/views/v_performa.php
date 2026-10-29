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
   .pt-10{
      margin-top: 20px;
      
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
         .bt-0{
            margin-bottom: 0.0em;
         }
         .ct-l{
            line-height: 1;
            padding-top: calc(0.375rem + 1px);
            padding-bottom: calc(0.375rem + 1px);
         }
         .col-form-label{
            line-height: 1;
         }
         .pt-10{
            padding-top: 10px;
         }
         .pb-10{
            padding-bottom: 10px;
         }
</style>




<div id="cus-css">

</div>

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
            <a  onclick="window.history.go(-1); return false;" class="btn btn-primary float-right mb-3">
               <!-- Tambahkan mb-3 -->
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
               <div class="col-xl-5 col-md-6">
                  <div class="card">
					 <div class="card-header">
                        <h5>Detail Perangkat</h5>
                     </div>
                     <div class="card-body ">
                        <div class="row pt-10">
                           <div class="col-md-12">
                              <div class="form-group row bt-0">
                                 <label for="nama_fasilitas" class="col-md-4 col-form-label">Serial Number</label>
                                 <span  class="col-md-8 f-w-700 ct-l" id="SN"></span>
                              </div>
                              <div class="form-group row bt-0">
                                 <label for="lokasi" class="col-md-4 col-form-label">Jenis</label>
                                 <span  class="col-md-8 f-w-700 ct-l" id="jenis"></span>
                              </div>
                              <div class="form-group row">
                                 <label for="kategori" class="col-md-4 col-form-label">Merek</label>
                                 <span  class="col-md-8 f-w-700 ct-l" id="merek"></span>
                              </div>                              
							  <div class="form-group row">
                                 <label for="kategori" class="col-md-4 col-form-label">Model / Tipe</label>
                                 <span  class="col-md-8 f-w-700 ct-l" id="model"></span>
                              </div>
                              <div class="form-group row">
                                 <label for="ip" class="col-md-4 col-form-label">Garansi</label>
                                 <span  class="col-md-8 f-w-700 ct-l" id="garansi"></span>
                              </div>
                              <div class="form-group row">
                                 <label for="ip" class="col-md-4 col-form-label">Fasilitas</label>
                                 <span  class="col-md-8 f-w-700 ct-l" id="fasilitas"></span>
                              </div>
							  <div class="form-group row">
                                 <label for="ip" class="col-md-4 col-form-label">Status</label>
                                 <div class="col-md-8">
                                    <label id="status" class="label label-success">Digunakan</label>
                                 </div>
                              </div>
                           </div>
                        </div>
						<hr class="hr" />
                        <div class="row">
                           <div class="col-md-12" >
                              <div id="detail-perangkat"></div>

                           </div>
                        </div>                    
                     </div>
                  </div>
               </div>
               <div class="col-xl-7 col-md-6">
                  <div class="card" style="height: 435px;">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-title text-center ">
                           <h5>Performansi Perangkat</h5>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div id="data-perform"  class="radial-bar  radial-bar-ex-lg radial-bar-default"></div>
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
                        <h5>Maintenance Log Activity</h5>
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
                  <div class="card ">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-title text-center">
                           <h5>Persentase Jenis Kerusakan</h5>
                        </div>
                        <canvas id="myPie" width="295" height="295" ></canvas>
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
      FilterData(<?=$id?>);
    

   function FilterData(id) {
     show();
     var formData = new FormData();
       formData.append('filter_bulan',  $('#filter_bulan').val());
      formData.append('filter_tahun',  $('#filter_tahun').val());
   //   formData.append('limit',  $('#limitData').val());
   //   formData.append('src',  $('#srcData').val());
     
   
      var id =(id == null ? 0: id);
      $.ajax({
         url: "<?=base_url()?>perangkat/LoadDataAnl/"+id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
            
             var no =1;
            
            //  script untuk menampilkan data pada l  $abel perform fasilitas
            
            

               $('#SN').html(" : "+json['perangkat']['serial_number']);
               $('#jenis').html(" : "+json['perangkat']['jenis_perangkat']);
               $('#garansi').html(" : "+"");
               $('#merek').html(" : "+json['perangkat']['merk']);
			      $('#model').html(" : "+"");
               $('#fasilitas').html(" : "+json['perangkat']['nama_fasilitas']);
               DetailPerangkat(json['perangkat']);
               DataChart(json['perfomChart']);
               DataPie(json['perfomPie']);
               DataProgress(json['ProgressData']);
               HistoryLog(json['LogHistory']);
           
             hide();
         },
         error: function() {
             hide();
         }
     });
     return false;
   }

   function DetailPerangkat(data){ 
      var row='';
      jQuery.each(data['detail'], function( i, val ) {
         row +=` <div class="form-group row bt-0">
                                 <label for="nama_fasilitas" class="col-md-4 col-form-label"> `+val['property_name']+`</label>
                                 <span  class="col-md-8 f-w-700 ct-l" > : `+val['nama']+`</span>
                  </div>`;
      });
      $('#detail-perangkat').html(row);
     
   }



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


   function DataPie(data){
      var data = {
               labels: ['Display OFF', 'HDMI','Kamera Rusak', 'Listrik OFF', 'Jaringan Bermasalah' ],
               datasets: [{
                     data: [data['Display OFF'], data['HDMI'], data['Kamera Rusak'], data['Listrik OFF'], data['Jaringan Bermasalah']],
                     backgroundColor: ['#1ABC9C', '#2ECC71', '#3498DB', '#34495E', '#BDc3C7']
                           }]
                  };

                                    // Mengatur opsi chart
                                    var options = {
                                       responsive: false,
                                       plugins: {
                                          labels: {
                                                render: 'percentage',
                                                fontColor:'black',
                                                precision: 2
                                          }
                                       }
                                    };

                                    // Mendapatkan elemen canvas
                                 
                                    var ctx = document.getElementById('myPie').getContext('2d');
                                    
                                    // Membuat chart lingkaran
                                    var myDoughnutChart = new Chart(ctx, {
                                       type: 'pie',
                                       data: data,
                                       options: options
                                    });
   }


   function HistoryLog(data) {
      var row='';
      jQuery.each(data, function( i, val ) {
         row +=`<div class="row p-t-20 p-b-30">
                  <div class="col-auto text-right update-meta p-r-0">
                     <i class="feather icon-briefcase bg-c-red update-icon"></i>
                  </div>
                  <div class="col p-l-5">
                     <a href="#!">
                        <h6>`+val['description']+`</h6>
                     </a>
                     <p class="text-muted m-b-0">`+val['note']+`</p>
                     <small class="text-muted m-b-0">`+val['date_start']+`</small>
                  </div>
               </div>`;
         });
                  
      $('#dataLogHistory').html(row);
      
      
   }




   function DataProgress(data) {
      var row='';
      jQuery.each(data, function( i, val ) {
         row +=` <div class="col-xl-12 col-md-6 mb-10 mt-10">
                     <h5 class="m-b-10 f-w-500"><span class="text-c-black m-l-8" style="font-size: 15px;">`+val['name']+`</span></h5>
                 
                     <div class="progress">
                        <div class="progress-bar `+val['class']+`" style="width:`+val['value']+`%"></div><span class="text-c-black m-l-10">`+val['value']+`</span>
                     </div>
                  </div>`

      });
      $('#dataBar').html(row);
   
   
}

$('body').on('change','#filter_bulan', function() {
   
   // FilterData(0);
   console.log($('#filter_bulan').val());
});

$('body').on('change','#filter_tahun', function() {
   
   // FilterData(0);
   console.log($('#filter_tahun').val());
});


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