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

    /* Mobile Responsiveness Optimizations */
    @media (max-width: 767px) {
        .card { height: auto !important; margin-bottom: 15px; }
        .card-body { padding: 15px !important; }
        #namaFasilitas { font-size: 18px !important; margin-bottom: 15px !important; }
        .radial-bar-ex-lg { width: 220px !important; height: 220px !important; }
        #myDonutChart { max-width: 100%; height: auto !important; }
        .page-header-title i { display: none; }
        .page-header-title div { padding-left: 0 !important; }
        .float-right { float: none !important; width: 100%; margin-bottom: 5px; }
        .btn-group { display: flex; width: 100%; }
        .btn-group .btn { flex: 1; }
        .scroll-data { height: auto !important; max-height: 400px; overflow-y: auto; }
        .latest-update-card .card-body { height: auto !important; }
    }
    /* History PM Styles */
    .history-pm-card { margin-top: 20px; }
    .history-pm-scroll {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .history-pm-scroll::-webkit-scrollbar { width: 5px; }
    .history-pm-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

    .pm-history-item {
        display: flex;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
        align-items: flex-start;
    }
    .pm-history-item:last-child { border-bottom: none; }

    .pm-history-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 15px;
        color: #fff;
    }
    .pm-history-body { flex: 1; min-width: 0; }
    .pm-history-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 4px;
    }
    .pm-history-title { font-weight: 700; font-size: 13px; margin: 0; }
    .pm-history-date  { font-size: 12px; color: #888; white-space: nowrap; }

    .pm-history-meta { font-size: 12px; color: #555; line-height: 1.7; }
    .pm-history-meta span { margin-right: 12px; }
    .pm-history-meta i { margin-right: 4px; }

    .badge-pm {
        display: inline-block;
        padding: 2px 9px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        margin-right: 6px;
    }
    .badge-pm-2M { background: #3380ff; }
    .badge-pm-1B { background: #59a14f; }
    .badge-pm-3B { background: #9467bd; }
    .badge-pm-6B { background: #f27b05; }
    .badge-pm-T  { background: #e15759; }
    .badge-pm-default { background: #6c757d; }

    @media (max-width: 575px) {
        .pm-history-item { gap: 10px; }
        .pm-history-icon { width: 32px; height: 32px; font-size: 13px; }
        .pm-history-title { font-size: 12px; width: 100%; }
        .pm-history-date { width: 100%; margin-top: 2px; }
        .pm-history-meta span { display: block; margin-bottom: 4px; }
    }

    #history-pm-spinner { display:none; text-align:center; padding: 24px 0; }
    .history-pm-empty   { text-align:center; color:#aaa; padding: 30px 0; font-size:13px; }
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
                <!-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card d-flex flex-column h-100">
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
                                        <canvas id="myDonutChart" width="300" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card d-flex flex-column h-100">
                            <div class="card-header">
                                <h4>Daftar Alat yang terhubung dengan Peralatan ini</h4>
                                 <h3><span class="badge bg-info" id="jumlahPerangkat">alat</span></h3>
                            </div>
                            <div class="card-body scroll-data" style="flex-grow: 1; overflow-y: auto;">
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 without-header">
                                        <tbody id="perangkatList">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card latest-update-card">
                            <div class="card-header">
                                <h5>Riwayat Perbaikan (Corrective)</h5>
                            </div>
                            <div class="card-block">
                                <div class="card-body scroll-data" style="overflow-y: auto; width: auto; min-height: 200px; max-height: 400px;">
                                    <div class="latest-update-box" id="dataLogHistory"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="card d-flex flex-column h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                              
                                <div id="namaFasilitas" style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 10px;">Memuat...</div>
                                <div style="font-size: 14px; text-align: center; margin-bottom: 5px;"><i class="feather icon-map-pin text-primary"></i> Lokasi: <span id="lokasiFasilitas" class="font-weight-bold">-</span></div>
                                <div style="font-size: 14px; text-align: center; margin-bottom: 20px;"><i class="feather icon-box text-warning"></i> Kategori/Jenis: <span id="jenisPerangkat" class="font-weight-bold">-</span></div>

                                <div class="form-group row d-flex align-items-center justify-content-center">
                                    <label for="status" class="col-form-label">Status : </label>
                                    <label id="status" class="label label-success ml-2">ON</label>
                                </div>
                            </div>
                </div>

                <!-- ========== HISTORY KERUSAKAN PER-FASILITAS ========== -->
                <div class="row history-kerusakan-card mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                                <h5 class="mb-0">
                                    <i class="feather icon-alert-triangle text-danger" style="margin-right:6px;"></i>
                                    Riwayat Kerusakan (Corrective Maintenance)
                                </h5>
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <label class="mb-0" style="font-size:13px;font-weight:600;">Filter Bulan:</label>
                                    <select id="filter_bulan_kerusakan" class="form-control form-control-sm" style="width:160px;">
                                        <option value="">-- Semua Bulan --</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <button class="btn btn-sm btn-danger" onclick="LoadHistoryKerusakan()">
                                        <i class="feather icon-refresh-cw"></i> Muat Ulang
                                    </button>
                                </div>
                            </div>

                            <div class="card-body" style="padding: 16px;">
                                <div id="history-kerusakan-spinner">
                                    <div class="spinner-border text-danger" role="status" style="width:2rem;height:2rem;"></div>
                                    <p class="mt-2 text-muted" style="font-size:13px;">Memuat riwayat kerusakan...</p>
                                </div>
                                <div id="history-kerusakan-content">
                                    <div class="history-pm-scroll" id="history-kerusakan-list">
                                        <!-- Diisi via AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========== HISTORY PM PER-FASILITAS ========== -->
                <div class="row history-pm-card">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap" style="gap:10px;">
                                <h5 class="mb-0">
                                    <i class="feather icon-clock text-success" style="margin-right:6px;"></i>
                                    Riwayat Perawatan (Preventive Maintenance)
                                </h5>
                                <div class="d-flex align-items-center" style="gap:8px;">
                                    <label class="mb-0" style="font-size:13px;font-weight:600;">Filter Bulan:</label>
                                    <select id="filter_bulan_history" class="form-control form-control-sm" style="width:160px;">
                                        <option value="">-- Semua Bulan --</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <button class="btn btn-sm btn-success" onclick="LoadHistoryPM()">
                                        <i class="feather icon-refresh-cw"></i> Muat Ulang
                                    </button>
                                </div>
                            </div>

                            <div class="card-body" style="padding: 16px;">
                                <div id="history-pm-spinner">
                                    <div class="spinner-border text-success" role="status" style="width:2rem;height:2rem;"></div>
                                    <p class="mt-2 text-muted" style="font-size:13px;">Memuat riwayat perawatan...</p>
                                </div>
                                <div id="history-pm-content">
                                    <div class="history-pm-scroll" id="history-pm-list">
                                        <!-- Diisi via AJAX -->
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

                    // Load info fasilitas (Nama, Lokasi, Kategori)
                    $.ajax({
                        url: "<?= base_url('fasilitas/GetInfoFasilitas') ?>/" + fasilitas_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success' && response.data) {
                                $('#namaFasilitas').text(response.data.nama_fasilitas || 'Fasilitas Tidak Diketahui');
                                $('#lokasiFasilitas').text(response.data.lokasi || '-');
                                $('#jenisPerangkat').text(response.data.jenis_perangkat || '-');

                                if (response.data.status == 1) {
                                    $('#status').text('ON').removeClass('label-danger').addClass('label-success');
                                } else {
                                    $('#status').text('OFF').removeClass('label-success').addClass('label-danger');
                                }
                            }
                        }
                    });

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
                                                    <!-- Membuat nama perangkat menjadi link (tab baru) -->
                                                    <a href="<?= base_url() ?>perangkat/performPerangkat/${perangkat.id_perangkat}" target="_blank">
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

                   
                    function formatDateIndo(dateStr) {
                        if (!dateStr || dateStr === '-') return '-';
                        const date = new Date(dateStr);
                        if (isNaN(date.getTime())) return dateStr;
                        
                        const day = String(date.getDate()).padStart(2, '0');
                        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        const seconds = String(date.getSeconds()).padStart(2, '0');
                        
                        return `${day} ${month} ${year} ${hours}:${minutes}:${seconds}`;
                    }

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
                                             row +=`<div class="row p-t-20 p-b-10" style="border-bottom: 1px solid #eee;">
                                                                <div class="col-auto text-right update-meta p-r-0">
                                                                <i class="feather icon-briefcase bg-c-red update-icon"></i>
                                                                </div>
                                                                <div class="col p-l-5">
                                                                   <a onclick="DetailLog()">
                                                                     <h6 class="text-primary">Corrective Maintenance</h6>
                                                                   </a>
                                                                   <div class="row">
                                                                       <div class="col-md-6">
                                                                           <p class="m-b-0"><strong>Ref. Temuan :</strong> [${val['id_temuan'] || '-'}] - ${val['nama_fasilitas'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Nomor WO :</strong> ${val['nomor'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Tanggal Temuan :</strong> ${formatDateIndo(val['tanggal_temuan'])}</p>
                                                                           <p class="m-b-0"><strong>Nama Peralatan :</strong> ${val['nama_fasilitas'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Jenis Alat :</strong> ${val['nama_jenis_perangkat'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Lokasi :</strong> ${val['lokasi'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Keterangan :</strong> ${val['description'] || '-'}</p>
                                                                       </div>
                                                                       <div class="col-md-6">
                                                                           <p class="m-b-0"><strong>Tanggal Tinjut Mulai :</strong> ${formatDateIndo(val['tanggal_mulai'])}</p>
                                                                           <p class="m-b-0"><strong>Tanggal Tinjut Selesai :</strong> ${formatDateIndo(val['tanggal_selesai'])}</p>
                                                                           <p class="m-b-0"><strong>Alat :</strong> ${val['nama_perangkat'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Klasifikasi Masalah :</strong> ${val['nama_masalah_tinjut'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Komponen :</strong> ${val['nama_komponen'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Tindakan :</strong> ${val['tindakan'] || '-'}</p>
                                                                           <p class="m-b-0"><strong>Waktu Mati :</strong> <span class="badge badge-danger">${val['downtime_menit'] || '0'} Menit</span></p>
                                                                       </div>
                                                                   </div>
                                                                </div>
                                                             </div>`;
                                                   });
                                                   row += '<div style="text-align:right;font-size:11px;color:#aaa;margin-top:6px;">Total: ' + data.length + ' record</div>';
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

    // ========== SCRIPT HISTORY PM PER-FASILITAS ==========
    $(document).ready(function () {
        LoadHistoryPM();
        $('#filter_bulan_history').on('change', function () {
            LoadHistoryPM();
        });

        LoadHistoryKerusakan();
        $('#filter_bulan_kerusakan').on('change', function () {
            LoadHistoryKerusakan();
        });
    });

    var pmColors = {
        '2M': '#3380ff', '1B': '#59a14f', '3B': '#9467bd', '6B': '#f27b05', 'T' : '#e15759'
    };

    function hitungDurasi(jamMulai, jamSelesai) {
        if (!jamMulai || !jamSelesai) return '';
        try {
            var parts1 = jamMulai.split(':');
            var parts2 = jamSelesai.split(':');
            var m1 = parseInt(parts1[0]) * 60 + parseInt(parts1[1]);
            var m2 = parseInt(parts2[0]) * 60 + parseInt(parts2[1]);
            var diff = m2 - m1;
            if (diff <= 0) return '';
            var j = Math.floor(diff / 60);
            var m = diff % 60;
            return (j > 0 ? j + 'j ' : '') + (m > 0 ? m + 'm' : '');
        } catch(e) { return ''; }
    }

    function LoadHistoryPM() {
        var id_fasilitas = <?= $id ?>;
        var bulan = $('#filter_bulan_history').val();

        $('#history-pm-spinner').show();
        $('#history-pm-content').hide();

        $.ajax({
            url: '<?= base_url() ?>fasilitas/history_pm_fasilitas/' + id_fasilitas,
            type: 'POST',
            data: { bulan: bulan },
            success: function (r) {
                var json = typeof r === 'string' ? JSON.parse(r) : r;
                $('#history-pm-spinner').hide();
                $('#history-pm-content').show();

                if (json.code !== '200' || !json.data || json.data.length === 0) {
                    $('#history-pm-list').html('<div class="history-pm-empty"><i class="feather icon-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Belum ada riwayat PM untuk peralatan ini.</div>');
                    return;
                }

                var html = '';
                json.data.forEach(function (item) {
                    var kode = (item.kode_pm || 'default').trim().toUpperCase();
                    var warna = pmColors[kode] || '#6c757d';
                    var badgeClass = 'badge-pm-' + kode;
                    if (!pmColors[kode]) badgeClass = 'badge-pm-default';

                    var durasi = hitungDurasi(item.jam_mulai, item.jam_selesai);
                    var waktu = (item.jam_mulai || '--:--') + ' - ' + (item.jam_selesai || '--:--');
                    if (durasi) waktu += ' <span style="color:#aaa;">(' + durasi + ')</span>';

                    var devices = item.daftar_perangkat 
                        ? '<span><i class="feather icon-settings"></i> <strong>Alat Terkait</strong> : <span class="text-primary">' + item.daftar_perangkat + '</span></span>' 
                        : '';

                    html += `
                        <div class="pm-history-item">
                            <div class="pm-history-icon" style="background:${warna};">
                                <i class="feather icon-tool"></i>
                            </div>
                            <div class="pm-history-body">
                                <div class="pm-history-top">
                                    <div class="pm-history-title">
                                        <span class="badge-pm ${badgeClass}">${kode}</span>
                                        ${item.nama_pm_type || 'PM'}
                                    </div>
                                    <span class="pm-history-date"><i class="feather icon-calendar" style="margin-right:4px;"></i>${item.tanggal_pm_fmt || item.tanggal_pm}</span>
                                </div>
                                <div class="pm-history-meta">
                                    <span><i class="feather icon-clock"></i> <strong>Waktu</strong> : ${waktu}</span>
                                    <span><i class="feather icon-file-text"></i> <strong>Nomor WO</strong> : ${item.nomor_wo || '-'}</span>
                                    <br>
                                    ${devices}
                                    <br>
                                    <span><i class="feather icon-user"></i> <strong>Pelaksana</strong> : ${item.pelaksana || '-'}</span>
                                </div>
                                ${item.catatan_perawatan ? '<div style="margin-top:4px;font-size:11px;color:#888;font-style:italic;"><i class="feather icon-message-square"></i> ' + item.catatan_perawatan + '</div>' : ''}
                            </div>
                        </div>`;
                });
                $('#history-pm-list').html(html);
            },
            error: function () {
                $('#history-pm-spinner').hide();
                $('#history-pm-content').show();
                $('#history-pm-list').html('<div class="history-pm-empty text-danger"><i class="feather icon-alert-triangle"></i> Gagal memuat data.</div>');
            }
        });
    }

    function LoadHistoryKerusakan() {
        var id_fasilitas = <?= $id ?>;
        var bulan = $('#filter_bulan_kerusakan').val();

        $('#history-kerusakan-spinner').show();
        $('#history-kerusakan-content').hide();

        $.ajax({
            url: '<?= base_url() ?>fasilitas/LoadHistoryKerusakan',
            type: 'POST',
            data: { id_fasilitas: id_fasilitas, bulan: bulan },
            success: function (r) {
                var json = typeof r === 'string' ? JSON.parse(r) : r;
                $('#history-kerusakan-spinner').hide();
                $('#history-kerusakan-content').show();

                if (json.status !== 'success' || !json.data || json.data.length === 0) {
                    $('#history-kerusakan-list').html('<div class="history-pm-empty"><i class="feather icon-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Belum ada riwayat kerusakan untuk peralatan ini.</div>');
                    return;
                }

                var html = '';
                json.data.forEach(function (item) {
                    var warna = '#e74c3c'; // red for kerusakan

                    var devices = '<span><i class="feather icon-settings"></i> <strong>Alat Terkait</strong> : <span class="text-primary">' + (item.nama_perangkat !== '-' ? item.nama_perangkat : '-') + '</span></span><br>';
                    
                    var masalah = '<span><i class="feather icon-alert-circle"></i> <strong>Jenis Masalah</strong> : <span class="text-danger">' + (item.jenis_masalah !== '-' ? item.jenis_masalah : '-') + '</span></span><br>';
                    
                    var komponen = '<span><i class="feather icon-box"></i> <strong>Komponen Diganti</strong> : ' + (item.komponen_pcs !== '-' ? item.komponen_pcs : '- pcs : -') + '</span><br>';

                    html += `
                        <div class="pm-history-item">
                            <div class="pm-history-icon" style="background:${warna};">
                                <i class="feather icon-alert-triangle"></i>
                            </div>
                            <div class="pm-history-body">
                                <div class="pm-history-top">
                                    <div class="pm-history-title">
                                        ${item.status_label}
                                    </div>
                                    <span class="pm-history-date"><i class="feather icon-calendar" style="margin-right:4px;"></i>${item.tanggal}</span>
                                </div>
                                <div class="pm-history-meta">
                                    <span><i class="feather icon-file-text"></i> <strong>Nomor WO</strong> : ${item.nomor}</span>
                                    <br>
                                    <span><i class="feather icon-calendar"></i> <strong>Tanggal Temuan</strong> : ${item.tanggal}</span>
                                    <br>
                                    <span><i class="feather icon-alert-octagon"></i> <strong>Kondisi Awal</strong> : ${item.kondisi}</span>
                                    <br>
                                    ${devices}
                                    ${masalah}
                                    ${komponen}
                                    <span><i class="feather icon-clock"></i> <strong>Tanggal Mulai Tinjut</strong> : ${item.tanggal_mulai || '-'}</span>
                                    <br>
                                    <span><i class="feather icon-check-circle"></i> <strong>Tanggal Selesai Tinjut</strong> : ${item.tanggal_selesai || '-'}</span>
                                    <br>
                                    <span><i class="feather icon-activity"></i> <strong>Keterangan Waktu </strong> : <span class="text-danger fw-bold">${item.ket_waktu}</span></span>
                                    <br>
                                    <span><i class="feather icon-user"></i> <strong>Pelaksana</strong> : ${item.pelaksana || '-'}</span>
                                </div>
                                <div style="margin-top:8px;font-size:12px;color:#333;font-weight:600;"><i class="feather icon-message-square"></i> Uraian Kejadian:</div>
                                <div style="font-size:12px;color:#555;margin-bottom:6px;">${item.uraian_kejadian}</div>
                                <div style="font-size:12px;color:#333;font-weight:600;"><i class="feather icon-check-square"></i> Tindakan:</div>
                                <div style="font-size:12px;color:#555;">${item.tindakan}</div>
                            </div>
                        </div>`;
                });
                
                // Footer total record
                html += '<div style="text-align:right;font-size:11px;color:#aaa;margin-top:6px;">' +
                   'Total: ' + json.data.length + ' record' +
                   '</div>';
                   
                $('#history-kerusakan-list').html(html);
            },
            error: function () {
                $('#history-kerusakan-spinner').hide();
                $('#history-kerusakan-content').show();
                $('#history-kerusakan-list').html('<div class="history-pm-empty text-danger"><i class="feather icon-alert-triangle"></i> Gagal memuat data kerusakan.</div>');
            }
        });
    }
    </script>
</div>
