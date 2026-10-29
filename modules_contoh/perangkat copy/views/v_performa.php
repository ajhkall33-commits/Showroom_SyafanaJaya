

<style>
   .radial-bar-ex-lg {
      width: 300px;
      height: 300px;
      font-size: 55px;
   }

   .radial-bar-ex-lg:after,
   .radial-bar-ex-lg>img {
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

   .lg-stat {
      width: 15px;
      height: 15px;
      border-radius: 50%;
   }

   .align-middle {
      padding-top: 2px;

      padding-left: 10px;
   }

   .modal-black {
      background-color: #131a22;
   }

   .modal-wt {
      color: #fff;
   }

   .pd-2 {
      padding-left: 5px;
      padding-right: 5px;
   }

   .pt-10 {
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

   td,
   th {
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

   .table-bordered td,
   .table-bordered th {
      padding: 10px;
   }

   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
   }

   .putih {
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

   .b-yellow {
      border: 1px solid #ffb64d;
   }

   /* End Css modal  */
   .b-yellow {
      border: 1px solid #ffb64d;
   }

   .progress-wrapper {
      display: flex;
      align-items: center;
   }

   .progress-bar-wrapper {
      flex-grow: 1;
      margin-left: 10px;
      /* Menambahkan jarak antara label dan progress bar */
   }

   .progress-label {
      margin-right: 10px;
      /* Menambahkan jarak antara progress bar dan label */
   }

   .mb-10 {
      margin-botton: 40px;
   }

   .mt-10 {
      margin-top: 10px;
   }

   .mb-10 {
      margin-botton: 40px;
   }

   .modal-content img {
      max-width: 20%;
      /* Mengatur lebar maksimum gambar menjadi 100% dari lebar modal */
      max-height: 30;
      /* Mengatur tinggi maksimum gambar agar sesuai dengan tinggi viewport */
      display: block;
      /* Memastikan gambar ditampilkan sebagai blok */
      margin: auto;
      /* Menengahkan gambar */
   }

   .close {
      position: absolute;
      top: 15px;
      right: 15px;
      /* Mengatur posisi tombol close ke pojok kanan atas */
      color: #ffffff;
      /* Warna teks tombol close */
      font-size: 30px;
      font-weight: bold;
      cursor: pointer;
      z-index: 9999;
      /* Memastikan tombol close tampil di atas gambar */
   }

   .bt-0 {
      margin-bottom: 0.0em;
   }

   .ct-l {
      line-height: 1;
      padding-top: calc(0.375rem + 1px);
      padding-bottom: calc(0.375rem + 1px);
   }

   .col-form-label {
      line-height: 1;
   }

   .pt-10 {
      padding-top: 10px;
   }

   .pb-10 {
      padding-bottom: 10px;
   }
   #myDonutChart {
    width: 300x;
    height: 300px;
}

#myPieChart {
    width: 300px;
    height: 300px;
}
.row {
  display: flex;
  align-items: stretch; /* Biar kolom tinggi sama */
}


</style>
<style>
 
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
               <h5><?= $title ?></h5>
               <span><?= $title_des ?></span>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb">
            <!-- Tombol Kembali -->
             <a href="<?= base_url() ?>" class="btn btn-primary float-right"><i class="fa fa-arrow-left"></i> Kembali</a>
              <a href="<?= base_url() ?>/perangkat" class="btn btn-danger float-right"><i class="fa fa-arrow-left"></i> Kembali ke Alat</a><break>
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
                  <div class="card"style="height: 93%;">
                     <div class="card-header">
                        <h5>Detail Alat</h5>
                     </div>
                     <div class="card-body ">
                        <div class="row pt-10">
                           <div class="col-md-12">
                           <div class="form-group row bt-0">
                                 <label class="col-md-4 col-form-label">Nama Alat</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="nama_perangkat"></span>
                              </div>
                              <div class="form-group row bt-0">
                                 <label class="col-md-4 col-form-label">Serial Number</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="SN"></span>
                              </div>
                              <div class="form-group row">
                                 <label class="col-md-4 col-form-label">Peralatan</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="fasilitas"></span>
                              </div>
                              <div class="form-group row bt-0">
                                 <label class="col-md-4 col-form-label">Jenis</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="jenis"></span>
                              </div>
                              <!-- <div class="form-group row">
                                 <label class="col-md-4 col-form-label">Merek</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="merek"></span>
                              </div> -->
                              <!-- <div class="form-group row">
                                 <label class="col-md-4 col-form-label">Model / Tipe</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="model"></span>
                              </div> -->
                              <!-- <div class="form-group row">
                                 <label class="col-md-4 col-form-label">Garansi</label>
                                 <span class="col-md-8 f-w-700 ct-l" id="garansi"></span>
                              </div> -->
                              
                              <div class="form-group row">
                                 <label class="col-md-4 col-form-label">Status</label>
                                 <div class="col-md-8">
                                    <label id="status" class="label label-success">Digunakan</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <hr class="hr" />
                        <div class="row">
                           <div class="col-md-12">
                              <div id="detail-perangkat"></div>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <div class="col-xl-7 col-md-6">
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
               </div> -->
               <div class="col-xl-6 col-md-6">
                  <div class="card" style="height: 400px;">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-title text-center ">
                           <h5>Performa Alat</h5>
                        </div>
                        <div class="row">
                           <div class="col-md-12"style="height: 300px;">
                              <!-- <input data-width="210" data-height="210" data-min="0" data-max="100" class="knob" value="0" rel="80.1"> -->
                              <canvas id="myDonutChart"></canvas>
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
                        <h5> Log Aktivitas Perbaikan</h5>
                     </div>
                     <div class="card-block scroll-data">
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
               <div class="col-xl-6 col-md-6">
                  <div class="card "style="height: 410px;">
                     <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div class="card-title text-center">
                           <h5>Masalah Kerusakan</h5>
                        </div>
                        <canvas id="myPieChart"></canvas>
                      
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
<!-- <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/jquery.knob.js"></script>
<script src="<?= base_url() ?>assets_v2/pages/chart/knob/knob-custom-chart.js"></script>
<script>
   var start = "";
   var end = "";

   function show() {
      $("#spinner").addClass("show");

   }

   function hide() {
      $("#spinner").removeClass("show");
   }
   FilterData(<?= $id ?>);


   function FilterData(id) {
    show();
    var formData = new FormData();
    formData.append('filter_bulan', $('#filter_bulan').val());
    formData.append('filter_tahun', $('#filter_tahun').val());

    var id = (id == null ? 0 : id);
    $.ajax({
        url: "<?= base_url() ?>perangkat/LoadDataAnl/" + id,
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(r) {
            var json = JSON.parse(r);
            var row = "";

            var no = 1;
            $('#nama_perangkat').html(" : " + (json['perangkat']?.['nama_perangkat'] ?? '-'));$('#nama_perangkat').html(" : " + json['perangkat']['nama_perangkat']);
            $('#SN').html(" : " + json['perangkat']['serial_number']);
            $('#jenis').html(" : " + json['perangkat']['jenis_perangkat']);
            $('#garansi').html(" : " + "");
            $('#merek').html(" : " + json['perangkat']['merk']);
            $('#model').html(" : " + "");
            $('#fasilitas').html(" : " + json['perangkat']['nama_fasilitas']);
            DetailPerangkat(json['perangkat']);
            DataChart(json['perfomChart']);  // Ganti dengan DataChart untuk donut chart
            DataChart3(json['ProgressData']);  // Ganti dengan DataChart3 untuk pie chart
            HistoryLog(json['LogHistory']);
            hide();
        },
        error: function() {
            hide();
        }
    });
    return false;
}







   function DetailPerangkat(data) {
      var row = '';
      jQuery.each(data['detail'], function(i, val) {
         row += ` <div class="form-group row bt-0">
                                 <label for="nama_fasilitas" class="col-md-4 col-form-label"> ` + val['property_name'] + `</label>
                                 <span  class="col-md-8 f-w-700 ct-l" > : ` + val['nama'] + `</span>
                  </div>`;
      });
      $('#detail-perangkat').html(row);

   }

   function DataChart3(progressData) {
    var performValue = progressData.Performa; // Nilai performa dari controller
    var performPercentage = parseFloat(performValue).toFixed(2); // Pembulatan ke 2 angka desimal

    // Debugging: Memastikan nilai yang dibulatkan

    var ctx = document.getElementById('myPieChart').getContext('2d'); // Mendapatkan konteks dari canvas

    var myPieChart = new Chart(ctx, {
        type: 'pie', // Tipe chart adalah pie
        data: {
            labels: progressData['lebel'], // Label untuk setiap bagian pie
            datasets: [{
                data: progressData['value'], // Data untuk setiap bagian
                backgroundColor: progressData['color'], // Warna untuk setiap bagian
            }]
        },
        options: {
            responsive: false,
            
            plugins: {
                tooltip: {
                    enabled: true // Menampilkan tooltip saat hover
                },
                legend: {
                    position: 'top', // Posisi legend di atas chart
                }
            }
        }
    });
}

   //  Menambahkan teks persentase di tengah chart pie
   //  var canvas = document.getElementById('myPieChart');
   //  var ctx = canvas.getContext('2d');
   //  ctx.font = 'bold 18px Arial';
   //  ctx.fillStyle = '#000'; 
   //  ctx.textAlign = 'center';
   //  ctx.textBaseline = 'middle';

   //  Menambahkan teks persentase
   //  var percentageText = performPercentage + '%';
   //  ctx.fillText(percentageText, canvas.width / 2, canvas.height / 2); // Menambahkan teks di tengah chart




// function DataPie(data) {
//     var data = {
//         labels: data['lebel'],
//         datasets: [{
//             data: data['value'],
//             backgroundColor: data['color']
//         }]
//     };

//     var options = {
//         responsive: false,
//         plugins: {
//             labels: {
//                 render: 'percentage',
//                 fontColor: 'black',
//                 precision: 2
//             }
//         }
//     };

//     var ctx = document.getElementById('myPie').getContext('2d');

//     var myDoughnutChart = new Chart(ctx, {
//         type: 'pie',
//         data: data,
//         options: options
//     });
// }



   function HistoryLog(data) {
      var row = '';
      jQuery.each(data, function(i, val) {
         row += `<div class="row p-t-20 p-b-30">
                  <div class="col-auto text-right update-meta p-r-0">
                     <i class="feather icon-briefcase bg-c-red update-icon"></i>
                  </div>
                  <div class="col p-l-5">
                     <a href="#!">
                       <h6>Nama Alat : ` + val['nama_perangkat'] + `</h6>
                        <h6>Masalah : ` + val['nama_masalah'] + `</h6>
                     </a>
                     <p class="text-muted m-b-0">keterangan : ` + val['description'] + `</p>
                    <small class="text-muted m-b-0">
                     Hari: ${
                        (() => {
                           const date = new Date(val['tanggal']);
                           const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date.getDay()];
                           const tanggal = date.getDate();
                           const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][date.getMonth()];
                           const tahun = date.getFullYear();
                           return `${hari}, ${tanggal} ${bulan} ${tahun}`;
                        })()
                     }
                  </small><br>
       
                      <small class="text-muted m-b-0">Jam: `+val['start_time']+` sampai `+val['end_time']+`</small>
                  </div>
               </div>`;
      });

      $('#dataLogHistory').html(row);


   }



   $('body').on('change', '#filter_bulan', function() {

      // FilterData(0);
      console.log($('#filter_bulan').val());
   });

   $('body').on('change', '#filter_tahun', function() {

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

   function DataChart(performanceData) {
    var performValue = performanceData.Performa; // Nilai performa dari controller
    var performPercentage = performValue; // Pembulatan ke 2 angka desimal

    console.log('Perform Value:', performPercentage); // Debugging: Memastikan nilai yang dibulatkan

    var ctx = document.getElementById('myDonutChart').getContext('2d'); // Mendapatkan konteks dari canvas

    var myDonutChart = new Chart(ctx, {
        type: 'doughnut', // Tipe chart adalah donut
        data: {
            labels: ['Performa'], // Label untuk donut chart
            datasets: [{
                label: 'Performa',
                data: [performValue, 100 - performValue], // Data performa dan sisa 100%
                backgroundColor: ['#3380ff', '#e0e0e0'], // Warna untuk performa dan latar belakang
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutoutPercentage: 80, // Menentukan ukuran 'lubang' di tengah donut
            plugins: {
                tooltip: {
                    enabled: false  // Menonaktifkan tooltip agar hanya teks yang muncul
                },
                legend: {
                    display: false  // Menonaktifkan legend
                }
            },
            animation: {
                animateRotate: true,  // Menambahkan animasi rotasi
                animateScale: true    // Menambahkan animasi skala
            }
        },
        plugins: [{
            id: 'center-label', // Plugin custom untuk menampilkan teks di tengah
            beforeDraw(chart) {
                const { width, height } = chart;
                const ctx = chart.ctx;
                const percentageText = performPercentage + '%'; // Teks untuk persentase

                ctx.save();
                ctx.font = 'bold 30px Arial'; // Ukuran font untuk persentase
                ctx.fillStyle = '#0000FF'; // Warna biru untuk font
                ctx.textBaseline = 'middle';
                ctx.textAlign = 'center';

                // Menampilkan persentase di tengah donut chart
                ctx.fillText(percentageText, width / 2, height / 2); // Posisi di tengah chart

                ctx.restore();
            }
        }]
    });
}





</script>