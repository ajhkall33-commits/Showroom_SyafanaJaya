<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
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
            <!-- [ page content ] start -->
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <form id="form-filter" class="col-md-12 row" onsubmit="return FilterData()">
                          
                          
                        <div class="card">
                           <div class="card-header">
                              RTO
                           </div>
                           <div class="card-body">
                              
                                 <p id="RTO">A well-known quote, contained in a blockquote element.</p>
                                
                              </blockquote>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header">
                              Replay
                           </div>
                           <div class="card-body">
                             
                                 <p id="replay">A well-known quote, contained in a blockquote element.</p>
                                 
                            
                           </div>
                        </div>
                           
                          
<!--                            
                           <div class="form-group col-md-4">
                              <div class="form-group row">
                                 <label class="col-sm-6 col-form-label">Korp/Div/Unit/AP </label>
                                 <div class="col-sm-6">
                                    <select name="jenis" class="select2 form-control"style="width: 100%" id="jenis">
                                       <option value="">-- Pilih --</option>
                                       <option value="KORPORAT">Korporat</option>
                                       <option value="DIREKTORAT">Direksi </option>
                                       <option value="UNIT">Unit</option>
                                       <option value="ANAK_PERUSAHAAN">Anak Perusahan</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-5 ">
                              <div class="form-group row">
                                 <label class="col-sm-6 col-form-label">Nama Korp/Div/Unit/AP </label>
                                 <div class="col-sm-6">
                                    <select name="unit_detail" class="select2 form-control"style="width: 100%" id="unit_detail">
                                      
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-1" >
                              <button class="btn btn-primary" type="submit">Search</button>
                           </div> -->
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <div class="row" id="export">
                           <div class="col-md-12">
                           <div class="pull-right putih mb-10">
                              <a class="btn btn-primary" onclick="Upload()"><i class="fa fa-file-excel-o "></i> Upload</a>
                           </div>
                           </div>
                           
                        </div>
                        <form id="form-monitoring" class="row" onsubmit="return UpdateData(this)">
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                              <thead class="thead-blue">
                                
                                 <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Nama Perangkat</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Terminal</th>
                                    <th class="cemter-t">IP</th>
                                    <th class="cemter-t">Status</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
                               
                              </tbody>
                           </table>
                           <div class="card-footer text-muted" id="btn-updatedata">
                              
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="MasterIndikator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return SaveGroup(this)">
            <input type="file" id="perangkat" class="form-control" name="perangkat" required /><br />
            <input type="submit" name="submit" class="brn btn-sm btn-success" value="Import" /><br/>
         </form>
      </div>
   </div>
</div>



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
    
      function FilterData(){
         show();
         // var formData = new FormData();
         
         // if (tahun != null && jen!= null) {
         //       var tahun = tahun;
         //       var jenis = jenis;
         //       var unit = unit_detail;
         // }else{
         //       var tahun = $('#tahun').val();
         //       var jenis = $('#jenis').val();
         //       var unit = $('#unit_detail').val();
         // }
      
         // formData.append('tahun', tahun);
         // formData.append('jenis', jenis);
         // formData.append('unit_detail', unit);
       
         $.ajax({
               url: "<?=base_url()?>jadwal_pm/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var pag= "";
                  jQuery.each(json['perangkat'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td >`+val['id']+`</td>
                                       <td >`+val['nama_perangkat']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                       <td >`+(val['terminal'] == null ? '': val['terminal'])+`</td>
                                       <td >`+(val['ip'] == null ? '': val['ip'])+`</td>
                                       <td id='status-`+val['id']+`'>`+(val['status'] ==1 ? 'Replay': 'RTO')+`</td>
                                    </tr>`;
                  });
                  $('#RTO').html(json['rto']);
                  $('#replay').html(json['replay']);
                  $('#btn-updatedata').html('<button class="btn btn-primary" type="submit">Save</button>');
                  $('#tabel-data > tbody:last-child').html(header_table);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }
    
  
    function UpdateData(f){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('ms_target_indikator/')?>Update/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
          
           FilterData();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

    
    function Upload(){
      // show();
      $('#MasterIndikator').modal('show');
      $('#MasterIndikator').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#MasterIndikator').find('form').attr('onsubmit','return UploadData(this)');
      

    }

  
    function UploadData(f){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url:  '<?=base_url('jadwal_pm/')?>UploadData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
          
           FilterData();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }


   $('body').on('change','#jenis', function() {
 
      if($(this).val() != ''){
         var id=$(this).val();
      
         $.ajax({
         url: '<?=base_url('ms_target_indikator/')?>get'+id,
         success: function(r){
            var json = JSON.parse(r);
         
            var row = `<option value="">-- Pilih --</option>`;
            jQuery.each(json['jenis'], function( i, val ) {
            
            
               row+=`<option value="`+val['KODE_UNIT']+`">`+val['DESKRIPSI']+`</option>`;
            });
            $('#unit_detail').html(row);
            console.log(row);
         }, error(){
            
         }
      });   
      }
   });
</script>