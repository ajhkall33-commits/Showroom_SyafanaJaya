<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .radial-bar-ex-lg {
        width: 300px;
        height: 300px;
        font-size: 55px;
    }
    .radial-bar-ex-lg:after,
    .radial-bar-ex-lg > img {
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
        margin-bottom: 0.5em;
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
        border: 1px solid #ebebeb;
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
        margin-left: 10px; /* Menambahkan jarak antara label dan progress bar */
    }

    .progress-label {
        margin-right: 10px; /* Menambahkan jarak antara progress bar dan label */
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
                 <a href="<?= base_url('') ?>"class="btn btn-primary float-right"><i class="fas fa-arrow-left"></i> Kembali</a>
                <a href="<?= base_url('fasilitas') ?>" class="btn btn-danger float-right"><i class="fas fa-arrow-left"></i> Kembali ke Peralatan</a>
            </div>
        </div>
    </div>
</div>

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <!-- Kartu Pertama (Donut Chart dan Nama Fasilitas) -->
                    <div class="col-md-6">
                        <div class="card d-flex flex-column" style="height: 100%;">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <div class="card-title text-center">
                                    <h5>Persentase Performa Peralatan</h5>
                                </div>
                                <div id="namaFasilitas" style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;"></div>

                                <div class="form-group row d-flex align-items-center justify-content-center">
                                    <label for="ip" class="col-form-label">Status</label>
                                    <label id="status" class="label label-success ml-2">ON</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Canvas untuk menampilkan Donut Chart -->
                                        <canvas id="myDonutChart" width="300" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kartu Kedua (Daftar Perangkat) -->
                    <div class="col-md-6">
                        <div class="card d-flex flex-column" style="height: 100%;">
                            <div class="card-header">
                                <h4>Daftar Alat yang terhubung dengan Peralatan ini</h4>
                                 <h3><span class="badge bg-info" id="jumlahPerangkat">alat</span></h3>
                            </div>
                            <div class="card-body scroll-data" style="flex-grow: 1;">
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 without-header">
                                        <tbody id="perangkatList">
                                            <!-- Data perangkat akan dimuat di sini melalui AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Ketiga (Riwayat Perbaikan) -->
                <div class="row mt-4">
                    <!-- Menambahkan margin atas untuk menurunkan kartu ketiga -->
                    <div class="col-md-12">
                        <div class="card latest-update-card">
                            <div class="card-header">
                                <h5>Riwayat Perbaikan</h5>
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
                                <div class="card-body scroll-data" style="overflow: hidden; width: auto; height: 290px;">
                                    <div class="latest-update-box" id="dataLogHistory"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                             url: "<?=base_url()?>fasilitas/LoadDataAnl/"+<?=$id?>,
                             type: 'post',
                              data: formData,
                             contentType: false,
                             processData: false,

                             success: function(r) {
                                 var json = JSON.parse(r);
                                 var row = "";

                                 var no =1;
                               $('#namaFasilitas').text(json['fasilitas']['nama_fasilitas']);  // Menampilkan nama fasilitas di elemen dengan ID 'namaFasilitas'
                                 
                                 // Menampilkan data lainnya (status, lokasi, dll) di form input
                                 $('#nama_fasilitas').val(json['fasilitas']['nama_fasilitas']);
                                 $('#kategori').val(json['fasilitas']['nama_unit']);
                                 $('#lokasi').val(json['fasilitas']['nama_lokasi']);
                                 $('#sub_lokasi').val(json['fasilitas']['nama_sublokasi']);
                                 $('#ip').val(json['fasilitas']['ip_address']);
                                 $('#status').val(json['fasilitas']['status']);
                                 jQuery.each(json['tabel-data'], function (i, val) {
                                    var opt = "";
                                   //  if (val['status_perangkat'] == 0) {
                                   //      opt = `<a href="<?=base_url()?>/perangkat/performPerangkat/${val['id_perangkat']}"><button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(${val['id_perangkat']})"><i class="feather icon-eye"></i></button></a>`;
                                   //  } else {
                                   //      opt = ``;
                                   //  }
                                   //  if(val['id_perangkat'] == '-2' || val['id_perangkat'] == '-1'){

                                   //    //console.log("asdasd");
                                   //  }
                                   opt = `<a href="<?=base_url()?>/perangkat/performPerangkat/${val['id_perangkat']}"><button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" ><i class="feather icon-eye"></i></button></a>`;
                                    row += `<tr>
                                                <td>${no++}</td>
                                                <td>${val['foto'] || ''}</td>
                                                <td>${val['nama_jp'] || ''}</td>
                                                <td>${val['serial_number'] || ''}</td>
                                                <td>${val['merk_nama'] || ''}</td>
                                                <td>sdsd</td>
                                                <td>asdsd</td>
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
                                  url: "<?=base_url()?>fasilitas/LoadDataJP",
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




    function DataChart(performanceData)
    {
            var performaFasilitas = performanceData.Performa;  // Ambil nilai performa_fasilitas dari controller


            // Debugging: Memastikan nilai yang diterima
            console.log('Performa Fasilitas:', performaFasilitas);

            // Pastikan performaFasilitas adalah angka
            performaFasilitas = parseFloat(performaFasilitas);  // Pastikan menjadi angka

            if (isNaN(performaFasilitas)) {
                console.error('Invalid performa_fasilitas value:', performaFasilitas);
                return;  // Keluar jika nilai performa tidak valid
            }

            // Mendapatkan konteks dari canvas
            var ctx = document.getElementById('myDonutChart').getContext('2d');

            // Membuat donut chart dengan Chart.js
            var myDonutChart = new Chart(ctx, {
                type: 'doughnut',  // Tipe chart adalah donut
                data: {
                    labels: ['Performa Fasilitas', 'Sisa Waktu'],  // Label untuk donut chart
                    datasets: [{
                        label: 'Performa Fasilitas',
                        data: [performaFasilitas, 100 - performaFasilitas],  // Data performa fasilitas dan sisa 100%
                        backgroundColor: ['#e53935', '#e0e0e0'],  // Warna untuk performa fasilitas (merah) dan sisa waktu (abu-abu)
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    cutoutPercentage: 80,  // Menentukan ukuran 'lubang' di tengah donut
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
                    id: 'center-label',  // Plugin untuk menampilkan teks di tengah donut chart
                    beforeDraw(chart) {
                        const { width, height } = chart;
                        const ctx = chart.ctx;

                        // Format performaFasilitas menjadi persen (pastikan performaFasilitas adalah angka)
                        const percentageText = performaFasilitas.toFixed(2) + '%';  // Teks untuk persentase performa fasilitas

                        ctx.save();
                        ctx.font = 'bold 30px Arial';  // Ukuran font untuk persentase
                        ctx.fillStyle = '#FF0000';  // Warna teks (merah)
                        ctx.textBaseline = 'middle';
                        ctx.textAlign = 'center';

                        // Menampilkan persentase di tengah donut chart
                        ctx.fillText(percentageText, width / 2, height / 2);  // Posisi di tengah chart

                        ctx.restore();
                    }
                }]
            });
    }


                // function untuk mengambil peralatan yang terhubung dengan alat
                $(document).ready(function() {
                    var fasilitas_id = window.location.pathname.split('/').pop();

                    $.ajax({
                        url: "<?= base_url('fasilitas/GetDiviceProblem') ?>",
                        type: 'POST',
                        dataType: 'json',
                        data: { fasilitas_id: fasilitas_id },
                        success: function(response) {
                            var htmlOutput = '';

                            if(response.status === 'success' && response.perangkat.length > 0) {
                                // Tampilkan jumlah perangkat
                                $('#jumlahPerangkat').text(response.jumlah_perangkat);
                                $.each(response.perangkat, function(index, perangkat) {
                                    htmlOutput += `
                                    <tr>
                                        <td>
                                            <div class="d-inline-block align-middle">
                                                <div class="d-inline-block">
                                                    <!-- Membuat nama perangkat menjadi link -->
                                                    <a href="<?= base_url() ?>perangkat/performPerangkat/${perangkat.id_perangkat}">
                                                        <h6>${perangkat.nama_perangkat}</h6>
                                                    </a>
                                                    <p class="text-muted mb-0">SN: ${perangkat.serial_number}</p>
                                                </div>
                                            </div>
                                        </td>
                                     <td class="text-end">
                                                 ${perangkat.perform_percentage < 50
                                                ? `<h3><span class="badge bg-danger ">${perangkat.perform_percentage}%</span></h3>`
                                                : perangkat.perform_percentage <= 100 && perangkat.perform_percentage >= 50
                                                ? `<h3><span class="badge bg-success ">${perangkat.perform_percentage}%</span></h3>`
                                                : `<h3><span class="badge bg-secondary ">${perangkat.perform_percentage}%</span></h3>`}
                                    </td>
                                    </tr>`;
                                });
                            } else {
                                htmlOutput = `<tr><td colspan="2" class="text-center text-muted">${response.message || 'Tidak ada perangkat terhubung'}</td></tr>`;
                                  $('#jumlahPerangkat').text(0); // Jika gagal atau kosong
                            }

                            $('#perangkatList').html(htmlOutput);
                        },
                        error: function(xhr, status, error) {
                            $('#perangkatList').html('<tr><td colspan="2" class="text-center text-danger">Gagal memuat data perangkat</td></tr>');
                        }
                    });
                });

                   
                    function HistoryLog(data) {
                       var row='';
                       if (data.length === 0) {

                        // strValue was empty string, false, 0, null, undefined, ...
                        row +=                 `<div class="row p-t-20 p-b-10">
                                                  <div class="col-12 text-center"> <!-- Menggunakan class text-center -->
                                                     <p class="text-muted m-b-0">Belum Ada History</p>
                                                  </div>
                                               </div>`;

                                   }else{

                                               jQuery.each(data, function( i, val ) {
                                             row +=`<div class="row p-t-20 p-b-10">
                                                                <div class="col-auto text-right update-meta p-r-0">
                                                                <i class="feather icon-briefcase bg-c-red update-icon"></i>
                                                                </div>
                                                                <div class="col p-l-5">
                                                                   <a onclick="DetailLog()">
                                                                     <h6>Corrective Maintenance</h6>
                                                                      <h6>Nama Peralatan : `+val['nama_fasilitas']+`</h6>
                                                                      
                                                                      <h6>Jenis Alat : `+val['nama_jenis_perangkat']+`</h6>
                                                                   </a>
                                                                   <p class="text-muted m-b-0"> Alat : `+val['nama_perangkat']+`</p>
                                                                   <p class="text-muted m-b-0"> Nama Masalah : `+val['nama_masalah_tinjut']+`</p>
                                                                   <p class="text-muted m-b-0"> Keterangan : `+val['description']+`</p>
                                                                    <small class="text-muted m-b-0">
                                                                        Hari: ${
                                                                        (() => {
                                                                            const date = new Date(val['create_date']);
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


                       $(function(){
                          $('#dataLogHistory').slimScroll({
                             height: '950px'
                          });
                       });
    </script>
</div>
