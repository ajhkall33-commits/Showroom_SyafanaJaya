<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css"> -->
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css"> -->

<style>
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

   /* Memaksa tabel overflow dan menampilkan scrollbar */
   .table-responsive {
      display: block;
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin-bottom: 1rem;
   }

   .table-responsive td,
   .table-responsive th {
      white-space: nowrap;
   }

   /* Styling Scrollbar Horizontal agar lebih jelas terlihat */
   .table-responsive::-webkit-scrollbar {
      height: 10px; /* Tinggi scrollbar */
   }
   .table-responsive::-webkit-scrollbar-track {
      background: #f1f1f1; 
      border-radius: 5px;
   }
   .table-responsive::-webkit-scrollbar-thumb {
      background: #888; 
      border-radius: 5px;
   }
   .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #555; 
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
   .responsive {
  max-width: 100%;

  max-width: 100px;
  height: auto;
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}

.container-chek {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container-chek input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container-chek:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container-chek input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container-chek input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container-chek .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
   /* end css chekbox */

</style>
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
         </div>
      </div>
   </div>
</div>
<div class="pcoded-inner-content">
   <div class="main-body">
      <div class="page-wrapper">
         <div class="page-body">
         <div class="row">
               <div class="col-md-12">
                  <div class="card " id="stats-top" style="display: none;">
                     <div class="card-block">
                           <div class="row" >
                              <div class="col-md-12">
                                 <div class="card prod-p-card card-blue">
                                    <div class="card-body">
                                       <div class="row align-items-center m-b-30">
                                          <div class="col">
                                             <h6 class="m-b-5 text-white center-t" >Total Alat </h6>
                                             <h3 class="m-b-0 f-w-700 text-white center-t" id="AllDataFasilitas">e3</h3>
                                          </div>
                                       
                                       </div>
                                    
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row" id="sum-perangkat">
                           
                           </div>
                       
                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] start -->
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <div class="row" id="export">
                           <div class="col-md-12">
                              <div class="pull-right putih mb-10 btn-group ">
                              <a  class="btn  btn-primary btn-with-tooltip invoices-total initialized" onclick="slideToggle('#stats-top'); return false;" data-toggle="tooltip" title="" data-original-title="View Quick Stats" aria-describedby="tooltip784963"><i class="fa fa-bar-chart"></i></a>
                              <button class="btn waves-effect waves-light btn-success btn-outline-success btn-round"  onclick="ExportToExcel()"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                              <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary  btn-round"  onclick="PrintQrCode()"><i class="fa fa-print"></i> QRCode</button> -->
                              <button class="btn waves-effect waves-light btn-primary btn-outline-success btn-round"  onclick="AddData()"><i class="fa fa-plus"></i> Tambah</button>
                              <!-- <button class="btn waves-effect waves-light btn-primary btn-outline-primary  btn-round"  onclick="UploadFile()"><i class="fa fa-cloud-upload"></i> Upload</button> -->
                              

                              </div>
                           </div>
                        </div>
                        <div id="complex-dt_wrapper" class="dataTables_wrapper dt-bootstrap4">
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 mb-2">
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
                              <?php if (is_sk_manager()): ?>
                              <div class="col-xs-12 col-sm-12 col-md-3 mb-2">
                                 <div class="dataTables_length">
                                    <label>
                                       Unit
                                       <?= render_unit_filter_select('filter_unit', 'FilterData(0)', 'form-control input-sm') ?>
                                    </label>
                                 </div>
                              </div>
                              <?php endif; ?>
                              <div class="col-xs-12 col-sm-12 <?= is_sk_manager() ? 'col-md-3' : 'col-md-4' ?> mb-2">
                                 <div class="dataTables_length" id="complex-dt_length">
                                    <label>
                                       Filter By 
                                       <select name="complex-dt_length" aria-controls="complex-dt" class="form-control " id="jenis_perangkat">
                                          
                                       </select>
                                      
                                    </label>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 <?= is_sk_manager() ? 'col-md-4' : 'col-md-6' ?> mb-2">
                                 <div id="complex-dt_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="srcData"></label></div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12 table-responsive">
                                 <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                    <thead class="thead-blue">
                                       <tr>
                                          <th class="cemter-t">No </th>
                                          <th class="cemter-t">Nama Alat </th>
                                           <th class="cemter-t">Nama Peralatan </th>
                                          <th class="cemter-t">Lokasi</th>
                                          <th class="cemter-t">SN</th>                                 
                                          <th class="cemter-t">Jenis Alat</th>
                                          <th class="cemter-t">Status</th>
                                          <th class="cemter-t">Action</th>
                                       </tr>
                                    </thead>
                                    <tbody id="Data-AP">
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row"  id="data-pag">

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>

<!-- Modal Detail Perangkat --> 
<div class="modal fade" id="m-detailperangkat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return SaveGroup(this)">
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jenis Alat</label>
                  <div class="col-md-10">
                     <select class="form-control" id="id_jenisperangkat" name="id_jenisperangkat">
                        <option value=""></option>
                     </select>
                  </div>
               </div>

               <!-- <div class="form-group row">
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Merk</label>
                        <div class="col-md-8">
                           <select class="form-control" id="merk_id" name="merk_id">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Model</label>
                        <div class="col-md-8">
                           <select class="form-control" id="id_model" name="id_model">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div> -->
               <div class="form-group row">
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Nama Alat</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="nama_perangkat" id="nama_perangkat" >
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label"> SN</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="serial_number" id="serial_number" >
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                        <div class="row">
                                 <label class="col-md-4 col-form-label">Status</label>
                                 <div class="col-md-8">
                                    <select class="form-control jenis select2Data" id="status" name="status">
                                       <option value="0">Stock</option>
                                       <option value="1">Used</option>
                                    </select>
                                 </div>
                           </div>
                        </div>
                  </div>
               </div>
              
              
                   <div id="input_detail">
                    
                  </div>
              
               
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  
               </div>
            </div>
           
         </form>
         </div>
      </div>
   </div>
</div>
<!-- End Modal Detail Perangkat -->
<!-- Modal View Detail Perangkat -->
<div class="modal fade" id="m-viewperangkat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return Update()">
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Nama Alat</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="nama_alat_detail"></label>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Jenis Alat</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="jenis_detail"></label>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">SN</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="SN_detail"></label>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Nama Peralatan</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="fasilitas_detail"></label>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Lokasi</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="lokasi_detail"></label>
                     </div>
                  </div>
                  <div class="col-md-6" id="ViewInfo">
                  </div>
                  
                  <div class="col-md-12 text-center" id="img-qrcode">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
               </div>
         
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">Approve</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Form request -->
            <form method="post"   onsubmit="return SaveData(this)">
            <div class="row">
                  <div class="col-md-12">
                     <button type="submit" id="submitBtn" class="btn btn-primary">Request Approve</button>
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  </div>
               </div>
               
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered" id="tabel-Qr">
                           <thead class="thead-blue">
                              <tr>
                                 <th class="cemter-t">
                                    <label class="container-chek">
                                    <input type="checkbox" class="check-form" onclick= 'checkUncheck(this)'>
                           
                                    <span class="checkmark"></span>
                           </label></th>
                                 <th class="cemter-t">Alat</th>
                              </tr>
                           </thead>
                           <tbody >
                           </tbody>
                        </table>
                     </div>
                  
                  </div>
                  
               </div>
               <div class="row"  id="data-pag-QR">
               </div>
               
            </form>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="m-uploader" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Menambahkan File Loader</h5>
         </div>
         <form onsubmit="return UploaderData(this)">
            <div class="modal-body p-0">
              
               
               <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setUploader(this)" accept=".xls,.xlsx"/>
               <div class="p-4" id="input_group">
                 
                  <div class="row mt-s">
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label" >Jenis Alat</label>
                           <div class="col-sm-10">
                                 <select class="form-control" name="upload_jenis" id="upload_jenis">
                                 <option ></option>
                                 
                                 </select>
                              
                           </div>
                        </div>
                     </div>
                     
                  </div>
                  <div class="row ">
                     <div class="col-md-12">
                        <div class="row">
                       
                           <label class="col-sm-2 control-label">File</label>
                           <div class="col-sm-8">
                              <input type="text" readonly class="form-control" placeholder="File" id="name_file"> 
                              <div class="btn-group mt-s ">
                                 <button type="button" onclick="$('#inputFile').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                 <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
                                 <a onclick="DownloadFormat()" > <span class="sm-hide">Download Format </span></a>
                              </div>
                           </div>
                        
                        </div>
                        
                     </div>
                     
                     <br>
                  </div>
                 
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- End Modal View Perangkat -->
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
<script>
   var start = "";
   var end = "";
   
   function show () {$("#spinner").addClass("show");}
   function hide () {$("#spinner").removeClass("show");}
   FilterData();
   JenisPerangkat();
   MerkPerangkat();

   function ExportToExcel() {
      var src = $('#srcData').val();
      var jenis = $('#jenis_perangkat').val() == null ? '' : $('#jenis_perangkat').val();
      var url = "<?=base_url('perangkat/ExportExcel')?>?src=" + encodeURIComponent(src) + "&jenis_perangkat=" + encodeURIComponent(jenis);
      window.open(url, '_blank');
   }
   
   function FilterData(id) {
      show();
      var formData = new FormData();
      formData.append('limit',  $('#limitData').val());
      formData.append('src',  $('#srcData').val());
      var jenis =($('#jenis_perangkat').val() == null ? '': $('#jenis_perangkat').val());
      formData.append('jenis_perangkat',  jenis);
      formData.append('filter_unit', $('#filter_unit').val() || '');
     
      var id =(id == null ? 0: id);
      $.ajax({
         url: "<?=base_url()?>perangkat/LoadData/"+id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
             var cards_html = "";
             var no = json['pag']['start'];
          
             if (!json['perangkat'] || json['perangkat'].length === 0) {
                 row = '<tr><td colspan="8" class="text-center py-4 text-muted"><i class="feather icon-inbox mr-1"></i> Tidak ada data alat / perangkat</td></tr>';
                 cards_html = renderEmptyCardHtml('Tidak Ada Alat', 'Belum ada data perangkat yang sesuai dengan filter atau pencarian Anda.');
             } else {
                 jQuery.each(json['perangkat'], function(i, val) {
                     var idPer = val['id_perangkat'];
                     var namaPer = val['nama_perangkat'] || '-';
                     var namaFas = val['nama_fasilitas'] || '-';
                     var lokasi = val['lokasi'] || '-';
                     var sn = val['serial_number'] || '-';
                     var jenis = val['jenis_perangkat'] || '-';
                     var statusBadge = (val['status'] == 1 || val['status'] === '1')
                         ? '<span class="rv-badge rv-badge-success"><i class="fa fa-check-circle"></i> Used</span>'
                         : ((val['status'] == 0 || val['status'] === '0')
                             ? '<span class="rv-badge rv-badge-info"><i class="fa fa-cubes"></i> Stock</span>'
                             : '<span class="rv-badge rv-badge-secondary">-</span>');

                     var opt = "";
                     var cardActions = "";
                     if (val['status'] == 0 || val['status'] == 1) {
                         opt = `
                             <button type="button" class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(${idPer})" data-toggle="tooltip" title="Lihat Detail"><i class="feather icon-eye"></i></button>
                             <a href="<?=base_url('perangkat/performPerangkat/')?>${idPer}" class="btn waves-effect waves-light btn-success btn-outline-success btn-icon" data-toggle="tooltip" title="Performa"><i class="fa fa-line-chart"></i></a>
                             <button type="button" class="btn waves-effect waves-light btn-warning btn-outline-warning btn-icon" onclick="EditData(${idPer})" data-toggle="tooltip" title="Edit"><i class="feather icon-edit"></i></button>
                             <button type="button" class="btn waves-effect waves-light btn-danger btn-outline-danger btn-icon" onclick="ConfirmData(${idPer})" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></button>
                         `;
                         cardActions = `
                             <button type="button" class="btn btn-rv btn-outline-primary" onclick="ViewDetail(${idPer})"><i class="feather icon-eye"></i> Detail</button>
                             <a href="<?=base_url('perangkat/performPerangkat/')?>${idPer}" class="btn btn-rv btn-outline-success"><i class="fa fa-line-chart"></i> Performa</a>
                             <button type="button" class="btn btn-rv btn-outline-warning" onclick="EditData(${idPer})"><i class="feather icon-edit"></i> Edit</button>
                             <button type="button" class="btn btn-rv btn-outline-danger" onclick="ConfirmData(${idPer})"><i class="fa fa-trash"></i> Hapus</button>
                         `;
                     } else {
                         opt = `
                             <button type="button" class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(${idPer})" data-toggle="tooltip" title="Lihat Detail"><i class="feather icon-eye"></i></button>
                             <a href="<?=base_url('perangkat/performPerangkat/')?>${idPer}" class="btn waves-effect waves-light btn-success btn-outline-success btn-icon" data-toggle="tooltip" title="Performa"><i class="fa fa-line-chart"></i></a>
                         `;
                         cardActions = `
                             <button type="button" class="btn btn-rv btn-outline-primary" onclick="ViewDetail(${idPer})"><i class="feather icon-eye"></i> Detail</button>
                             <a href="<?=base_url('perangkat/performPerangkat/')?>${idPer}" class="btn btn-rv btn-outline-success"><i class="fa fa-line-chart"></i> Performa</a>
                         `;
                     }

                     row += `<tr>
                         <td class="text-center">${no++}</td>
                         <td class="font-weight-bold text-dark">${namaPer}</td>
                         <td>${namaFas}</td>
                         <td class="center-t">${lokasi}</td>
                         <td class="center-t"><code>${sn}</code></td>
                         <td class="center-t"><span class="rv-badge rv-badge-secondary">${jenis}</span></td>
                         <td class="center-t">${statusBadge}</td>
                         <td class="center-t">
                             <div class="btn-group" role="group">
                                 ${opt}
                             </div>
                         </td>
                     </tr>`;

                     cards_html += `<div class="rv-card-item">
                         <div class="rv-card-header">
                             <div class="rv-card-header-main">
                                 <h6 class="rv-card-title">${namaPer}</h6>
                                 <p class="rv-card-subtitle"><i class="fa fa-tag text-muted"></i> ${jenis}</p>
                             </div>
                             <div>${statusBadge}</div>
                         </div>
                         <div class="rv-card-body">
                             <div class="rv-card-field">
                                 <span class="rv-card-field-label"><i class="fa fa-barcode"></i> Serial Number</span>
                                 <span class="rv-card-field-value"><code>${sn}</code></span>
                             </div>
                             <div class="rv-card-field">
                                 <span class="rv-card-field-label"><i class="fa fa-map-marker"></i> Lokasi</span>
                                 <span class="rv-card-field-value">${lokasi}</span>
                             </div>
                             <div class="rv-card-field col-span-2">
                                 <span class="rv-card-field-label"><i class="fa fa-desktop"></i> Peralatan Induk</span>
                                 <span class="rv-card-field-value font-weight-bold">${namaFas}</span>
                             </div>
                         </div>
                         <div class="rv-card-footer">
                             ${cardActions}
                         </div>
                     </div>`;
                 });
             }

             $('#tabel-data > tbody:last-child').html(row);
             $('#card-data').html(cards_html);
             $('#data-pag').html(json['pag']['label']);
             if (typeof setViewMode === 'function') {
                setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false);
             }
             hide();
         },
         error: function() {
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
                                         
                                          <button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditDataDetail(` + val['id_perangkat'] +`)"><i class="feather icon-edit"></i></button>
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
      $('#m-viewperangkat').modal('show');
      $('#m-viewperangkat').find('.modal-title').html('Info Detail Alat');   
    
     $.ajax({
         url: "<?=base_url()?>perangkat/ViewDetail/"+id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
             $('#nama_alat_detail').html(json['nama_perangkat']);
             $('#jenis_detail').html(json['jenis']);  
             $('#SN_detail').html(json['serial_number']); 
             $('#fasilitas_detail').html(json['nama_fasilitas']);
             $('#lokasi_detail').html(json['terminal']);
			 
               var row = '';
                 jQuery.each(json['detail'], function( i, val ) {
                    
                    row +=`<div class="form-group row">
                        <label class="col-sm-5 col-form-label">`+val['property']+`</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label">`+val['value']+`</label>
                     </div>  `;
                 });
                 
                 $('#ViewInfo').html(row);
                 $('#img-qrcode').html(`<img src="<?= base_url('doc/QRCode/')?>`+json['QRCODE']+`"  style="width: 100%; max-width: 450px; display: block; margin: 20px auto;" class="responsive">`);
               
             hide();
         },
         error: function() {
             hide();
         }
     });
     return false;
   }
     
    function AddData(){
      // show();
      $('#m-detailperangkat').modal('show');
      $('#m-detailperangkat').find('.modal-title').html('Tambah Alat Baru');   
      $('#m-detailperangkat').find('form').attr('onsubmit','return SaveData(this)');
      

    }

    function EditData(id){
      // show();
      $('#m-detailperangkat').modal('show');
      $('#m-detailperangkat').find('.modal-title').html('Edit Alat');   
      $('#m-detailperangkat').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      $.ajax({
               url: "<?=base_url()?>perangkat/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row =  ` <div class="row"> <div class="col-md-12">
                                 <h6>Spesifikasi Perangkat</h6>
                              </div>`;
                     jQuery.each(json['detail'], function( i, val ) {
                     
                        row +=`  <div class="col-md-12">
                                    <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">`+val['property']+`</label>
                                       <div class="col-md-6">
                                          <input type="hidden" class="form-control" name="edit[`+i+`][id_perangkat_detail]"  value='`+val['id_perangkat_detail']+`'>
                                          <input type="hidden" class="form-control" name="edit[`+i+`][idmaster_detail_perangkat]"  value='`+val['idmaster_detail_perangkat']+`'>
                                          <input type="text" class="form-control" name="edit[`+i+`][nilai]"  value='`+val['value']+`'>
                                          
                                       </div>
                                    </div>
                                 </div>
                              `;
                  });
                 row  += '</div>';
                  $('#input_detail').html(row);
                  $('#id_jenisperangkat').val(json['id_jenisperangkat']);  
                  $('#nama_perangkat').val(json['nama_perangkat']); 
                  // $('#merk_id').val(json['merk_id']);  
                  $('#serial_number').val(json['serial_number']);
                  $('#status').val(json['status']);  
                  LoadModel(json['merk_id'],json['id_jenisperangkat']);
                
               }, error: function(){
                  hide ();
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
                 $('#upload_jenis').html(row);
                 $('#jenis_perangkat').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }
   function MerkPerangkat(){
        
        $.ajax({
              url: "<?=base_url()?>merk/LoadData",
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id']+`">`+val['nama']+`</option>`;
                 });
                 
                 $('#merk_id').html(row);
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
                 var row =  ` <div class="row"> <div class="col-md-12">
                                 <h6>Spesifikasi Alat</h6>
                              </div>`;
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`  
                    
                    
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label">`+val['nama']+`</label>
                           <div class="col-md-6">
                              <input type="hidden" class="form-control" name="master[`+i+`][idmaster_detail_perangkat]"  value='`+val['idmaster_detail_perangkat']+`'>
                              <input type="text" class="form-control" name="master[`+i+`][nilai]"  >
                           </div>
                        </div>
                     </div>
                  `;
                 });
                 row  += '</div>';
                 
                 $('#input_detail').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }

    function UpdateData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('perangkat/')?>UpdateData/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            
            var json = JSON.parse(r);
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
          
           FilterData();
           NF(json);
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   function SaveData(f){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('perangkat/')?>SaveData',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            $('#MasterIndikator').modal('hide');
          
           FilterData();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   function SaveDataDetail(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('perangkat/')?>SaveDataDetail/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
            LoadDataDetail(id);
           FilterData();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   $('body').on('change','#limitData', function() {
      FilterData();
   });

   $('body').on('change','#jenis_perangkat', function() {
      FilterData();
   });

   $( "#srcData" ).on( "keyup", function() {
      FilterData();
   
   } );

   $('body').on('change','#id_jenisperangkat', function() {
      MasterDetailPerangkat( $(this).val());
   });

   $('body').on('change','#merk_id', function() {
      if ($(this).val() !='' && $('#id_jenisperangkat').val() != '') {
         LoadModel($(this).val(),$('#id_jenisperangkat').val());
      }
   });

   
   $('body').on('change','#id_model', function() {
      if ($(this).val() !='') {
         LoadModelSpek($(this).val());
      }
   });

   
   function LoadModel(idMerk,id_jenis){
      var formData = new FormData();
      formData.append('id_merk',  idMerk);
      formData.append('id_jenisperangkat',  id_jenis);
        $.ajax({
              url: "<?=base_url()?>model/LoadDataBy",
              type: 'post',
               data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row =  ` <option value=""></option>`;
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id_perangkat']+`">`+val['nama_perangkat']+`</option>`;
                 });
              
                 
                 $('#id_model').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }

   function LoadModelSpek(id){
      var formData = new FormData();
      formData.append('id',  id);
        $.ajax({
              url: "<?=base_url()?>model/LoadModelSpek",
              type: 'post',
              data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row =  ` <div class="row"> <div class="col-md-12">
                                 <hr>
                                 <h6>Spesifikasi Perangkat</h6>
                                 <hr>
                              </div>`;
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`  
                    
                    
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label">`+val['nama']+`</label>
                           <div class="col-md-6">
                              <input type="hidden" class="form-control" name="master[`+i+`][idmaster_detail_perangkat]"  value='`+val['idmaster_detail_perangkat']+`'>
                              <input type="text" class="form-control" name="master[`+i+`][nilai]" value='`+val['nilai']+`'>
                           </div>
                        </div>
                     </div>
                  `;
                 });
                 row  += '</div>';
                 
                 $('#input_detail').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }
   function PrintQrCode(id){
      show();
      $('#requestModal').modal('show');
         $('#requestModal').find('.modal-title').html('Print QrCode Alat');   
         $('#requestModal').find('form').attr('onsubmit','return PrintListQR(this)');
         $('#submitBtn').html('Print Data');

      var formData = new FormData();
      formData.append('limit',  $('#limitData').val());
      formData.append('src',  $('#srcData').val());
      var jenis =($('#jenis_perangkat').val() == null ? '': $('#jenis_perangkat').val());
      formData.append('jenis_perangkat',  jenis);
     
      var id =(id == null ? 0: id);
         $.ajax({
               url: "<?=base_url()?>perangkat/LoadPerangkat/"+id,
               type: 'post',
                data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "";

                  jQuery.each(json['perangkat'], function( i, val ) {
                     var rowCount = i;
                     row +=` <tr>
                           <td>
                           <label class="container-chek">
                              <input type="checkbox" class="check-form" name="newdata[`+rowCount+`][id_perangkat]" value="${val['id_perangkat']}">
                                 <span class="checkmark"></span>
                                 </label>
                           </td>
                           <td>
                              <label>${val['nama_perangkat']}-${val['serial_number']}</label>
                            
                           </td>
                          
                        </tr>`;
                  });


                
                  $('#tabel-Qr > tbody:last-child').html(row);
                  $('#data-pag-QR').html(json['pag']['label']);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
   }
   function PrintListQR(f){
       show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('perangkat/')?>PrintListQr/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            if (json['code'] == '200') {
               window.open("<?=base_url('doc/file/')?>"+json['file']);
            }else{
               NF(json)
            }
           
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }
   function checkUncheck(checkBox) {
      get = document.getElementsByClassName('check-form');
      for(var i=0; i<get.length; i++) {
         get[i].checked = checkBox.checked;
      }

   }

   function UploadFile(){

      $('#m-uploader').modal('show');
      $('#m-uploader').find('.modal-title').html('Upload Data Alat');   
      $('#m-uploader').find('form').attr('onsubmit','return UploadData(this)');
     
   }

   function DownloadFormat(){
    
      window.open("<?=base_url('perangkat/DownloadFormat/')?>")
      
   }

   function UploadData(f){
      show();
      var formData = new FormData($(f)[0]);
      
      $.ajax({
         url:  '<?=base_url('perangkat/UploadData')?>',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r); 
            if (json['STATUS'] !=200) {
               window.open("<?=base_url()?>"+json['PATH'], "_blank");
            }
           
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }
   function setUploader(input){
        if (!window.FileReader) {
          alert('Browser yang Anda gunakan tidak support fitur ini.');
        }else{
          if(input.files && input.files[0]){
            if(input.files[0].type.match('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')){
                  $dropzone.hide(); $('#input_group').show(300);
                $dropzone.removeClass('dropping');
                $('.dizabled').removeClass('dizabled');

                var reader = new FileReader();
                reader.onload = function(event){
                  file_data = event.target.result;
                  $dropimg.css('background-image', 'url(' + event.target.result + ')');

                  reader.src = event.target.result;
                };
                
                $('#name_file').val(input.files[0].name);
               //  $('#m-uploader').find('input:text').val(input.files[0].name);
                reader.readAsDataURL(input.files[0]);

                file_exist = false;
            }else{
              alert("Format file tidak valid"+input.files[0].type);
            }
           
          }
        }

   }


   var $dropzone = $('.image_picker'),
          $dropinput = $('#inputFile'),
          $dropimg = $('.image_preview');

      $dropzone.on('dragover', function() {
        $dropzone.addClass('dropping');
        return false;
      }).on('dragend dragleave', function() {
        $dropzone.removeClass('dropping');
        return false;
      });
      LoadSumPerangkat();

   function LoadSumPerangkat(){
      $.ajax({
         url: "<?=base_url()?>perangkat/summary",
         type: 'post',
         success: function(r){
               var json = JSON.parse(r);
               var row='';
               jQuery.each(json['sum'], function( i, val ) {
                   row += `   <div class="col-md-4 " onclick="DetailSummary(${val['id_lokasi']})">
                                 <div class="card prod-p-card card-blue">
                                    <div class="card-body">
                                       <div class="row align-items-center m-b-30">
                                          <div class="col">
                                             <h6 class="m-b-5 text-white center-t">`+val['nama_terminal']+`</h6>
                                             <h3 class="m-b-0 f-w-700 text-white center-t">`+val['total']+`</h3>
                                          </div>
                                       
                                       </div>
                                    
                                    </div>
                                 </div>
                              </div>
                  `; 
               });
               $('#AllDataFasilitas').text(json['all']['total']);
            
               $('#sum-perangkat').html(row);
         },
         error: function(){
               hide();
         }
      });
      return false;
   }

   function DetailSummary (id){
      $.ajax({
         url: "<?=base_url()?>perangkat/DetailSummary/"+id,
         type: 'post',
         success: function(r){
               var json = JSON.parse(r);
               var row='';
               jQuery.each(json['sum'], function( i, val ) {
                  //  row += `   <div class="col-md-4 " onclick="DetailSummary(${val['id_lokasi']})">
                  //                <div class="card prod-p-card card-blue">
                  //                   <div class="card-body">
                  //                      <div class="row align-items-center m-b-30">
                  //                         <div class="col">
                  //                            <h6 class="m-b-5 text-white center-t">`+val['nama_terminal']+`</h6>
                  //                            <h3 class="m-b-0 f-w-700 text-white center-t">`+val['total']+`</h3>
                  //                         </div>
                                       
                  //                      </div>
                                    
                  //                   </div>
                  //                </div>
                  //             </div>
                  // `; 
               });
               // $('#AllDataFasilitas').text(json['all']['total']);
            
               // $('#sum-perangkat').html(row);
         },
         error: function(){
               hide();
         }
      });
      return false;
   }

   function ConfirmData(id, tipe = 'delete') {  // Default value
         console.log('ConfirmData called with:', {id: id, tipe: tipe});
         
         var tit = '';
         var des = '';
         
         if (tipe == 'proses') {
            tit = "Proses Data";
            des = "Apakah Data Sudah Benar Untuk Diproses Lebih Lanjut?";
         } else if (tipe == 'delete') {
            tit = 'Hapus Data';
            des = "Apakah Sudah Yakin untuk Menghapus Data ini?";
         }
         
         cuteAlert({
            type: "question",
            title: tit,
            message: des,
            confirmText: "Okay",
            cancelText: "Cancel"
         }).then((e) => {
            if (e == "confirm") {
               (tipe == 'proses' ? ProsesData(id) : DeleteData(id));
            }
         });
      }
      function DeleteData(id) {
      
         $.ajax({
               url: '<?=base_url('perangkat/')?>Delete/' + id,
               type: 'post',
               contentType: false,
               processData: false,
               success: function (r) {
                  var json = JSON.parse(r);
                  NF(json);
                  LoadData();
               },
               error: function (xhr, status, error) {
               
                  window.location.href = "<?=site_url('perangkat/index')?>";
               }
         });
      
      return false;
      }
</script>