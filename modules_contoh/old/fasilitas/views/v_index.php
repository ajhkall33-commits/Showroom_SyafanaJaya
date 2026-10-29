<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<link href="<?=base_url()?>assets_v2/plugins/select2/css/select2.min.css" rel="stylesheet" />
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
   .center-t{
      text-align: center;
   }
   
   /* Css Modal Fullscrean */
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
   /* End Css modal  */
   /* CSS Select2 */
   
   .select2-container {
      width: 100%;
      border: 1px solid #ccc;
   }

   .select2-container--bootstrap .select2-selection--single {
            width: 300px;
        }
   .select2-dropdown--scroll {
        max-height: 200px; 
        overflow-y: auto; 
    }

    .select2-dropdown--scroll::-webkit-scrollbar {
    width: 0;
    height: 0;
   }

  
   .select2-dropdown--scroll:hover::-webkit-scrollbar {
      width: 10px;
      height: 10px;
   }

   
   .select2-dropdown--scroll::-webkit-scrollbar-track {
      background: #f1f1f1;
   }

  
   .select2-dropdown--scroll::-webkit-scrollbar-thumb {
      background: #888;
   }

  
   .select2-dropdown--scroll::-webkit-scrollbar-thumb:hover {
      background: #555;
   }
   .ct-l{
            line-height: 1;
            padding-top: calc(0.6rem + 1px);
            padding-bottom: calc(0.375rem + 1px);
         }
 /* CSS Select2 */
   
 .select2-container {
      width: 100%;
      border: 1px solid #ccc;
   }

   .select2-container--bootstrap .select2-selection--single {
            width: 300px;
        }
   .select2-dropdown--scroll {
        max-height: 200px; 
        overflow-y: auto; 
    }

    .select2-dropdown--scroll::-webkit-scrollbar {
    width: 0;
    height: 0;
   }

  
   .select2-dropdown--scroll:hover::-webkit-scrollbar {
      width: 10px;
      height: 10px;
   }

   
   .select2-dropdown--scroll::-webkit-scrollbar-track {
      background: #f1f1f1;
   }

  
   .select2-dropdown--scroll::-webkit-scrollbar-thumb {
      background: #888;
   }

  
   .select2-dropdown--scroll::-webkit-scrollbar-thumb:hover {
      background: #555;
   }
   .ct-l{
            line-height: 1;
            padding-top: calc(0.6rem + 1px);
            padding-bottom: calc(0.375rem + 1px);
         }
  .center-t{
   text-align: center;
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
                           <div class="row" >
                              <div class="col-md-12">
                                 <div class="card prod-p-card card-blue">
                                    <div class="card-body">
                                       <div class="row align-items-center m-b-30">
                                          <div class="col">
                                             <h6 class="m-b-5 text-white center-t" >Total Fasilitas </h6>
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
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <div class="row" id="export">
                           <div class="col-md-12">
                           <div class="pull-right putih mb-10">
                              <a class="btn btn-primary" onclick="Upload()"><i class="feather icon-plus-circle"></i> Tambah Fasilitas</a>
                           </div>
                           </div>
                           
                        </div>
                        <div id="complex-dt_wrapper" class="dataTables_wrapper dt-bootstrap4">
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-sm-12 col-md-6">
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
                              <div class="col-xs-12 col-sm-12 col-md-6">
                                 <div id="complex-dt_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="complex-dt" id="srcData"></label></div>
                              </div>
                           </div>
                           <div class="row">
                              <table class="table table-condensed table-striped table-bordered" id="tabel-data-fasilitas">
                                 <thead class="thead-blue">
                                 
                                    <tr>
                                       <th class="center-t">No</th>
                                       <th class="center-t">Foto</th>
                                       <th class="center-t">Nama Fasilitas</th>
                                       <th class="center-t">Terminal</th>
                                       <th class="center-t">Lokasi</th>
                                       <th class="center-t">IP</th>
                                       <th class="center-t">Status</th>
                                    </tr>
                                 </thead>
                                 <tbody id="Data-AP">
                                 
                                 </tbody>
                              </table>
                           </div>
                           <div class="row"  id="data-pag">

                           </div>
                        </div>
                        <!-- <form id="form-monitoring" class="row" onsubmit="return UpdateData(this)">
                           
                           <div class="card-footer text-muted" id="btn-updatedata">
                              
                           </div>
                        </form> -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="m-Fasilitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Fasilitas</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" >
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">IP Address</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="ip_address" id="ip_address" >
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <div class="row ">
                        <label class="col-md-4 col-form-label"> Lokasi</label>
                        <div class="col-md-8">
                           <select class="form-control jenis select2Data" id="id_lokasi" name="id_lokasi">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Sub Lokasi</label>
                        <div class="col-md-8">
                           <select class="form-control jenis select2Data" id="id_sublokasi" name="id_sublokasi">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="row">
                  <div class="col-md-12">
                     <div class="row mb-10">
                        <div class="col-md-10">
                           <h6>Detail Fasilitas</h6>
                        </div>
                        <div class="col-md-2">
                           <a class="btn waves-effect waves-light btn-info btn-icon2" onclick="AddPerangkat()" ><i class="feather icon-plus-circle"></i></a>
                          
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <table class="table table-condensed table-striped" id="tabel-perangkat">
                        <thead>
                           <tr>
                              <th style="width:40%">Jenis Perangkat</th>
                              <th style="width:30%">Perangkat</th>
                              <th style="width:10%">Tanggal Penggunaan</th>
                              <th style="width:20%">Action</th>
                           </tr>
                        </thead>
                        <tbody id="new_perangkat">
                        
                        </tbody>
                     </table>
                     <div id="removed-items"></div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- modal untuk view detail fasilitas -->
<div class="modal fade" id="m-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return Update()">
            <div class="modal-body">
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nama Fasilitas</label>
                  <span class="col-md-8 f-w-700 ct-l" id="fasilitas-detail">aaasd asd sad</span>
               </div>
               <div class="form-group row">
               <label class="col-md-4 col-form-label">IP Address</label>
                        <span class="col-md-8 f-w-700 ct-l" id="ip-detail">aaasd asd sad</span>
               </div>
               <div class="form-group row">
               <label class="col-md-4 col-form-label"> Lokasi</label>
                        <span class="col-md-8 f-w-700 ct-l" id="lokasi-detail">aaasd asd sad</span>
               </div>
               <div class="form-group row">
               <label class="col-md-4 col-form-label">Sub Lokasi</label>
                        <span class="col-md-8 f-w-700 ct-l" id="sublokasi-detail">aaasd asd sad</span>
               </div>

             
               <div class="row">
                  <div class="col-md-12">
                     <div class="row mb-10">
                        <div class="col-md-10">
                           <h6>Perangkat Yan melekat pada Fasilitas</h6>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <table class="table table-condensed table-striped" id="tabel-ViewDetail">
                        <thead>
                           <tr>
                              <th>Jenis Perangkat</th>
                              <th>Perangkat</th>
                              <th>Tanggal Penggunaan</th>
                             
                           </tr>
                        </thead>
                        <tbody id="detail_perangkat">
                           
                        </tbody>
                     </table>
                    
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             
            </div>
         </form>
      </div>
   </div>
</div>
<!-- end modal view fasilitas -->


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
<script src="<?=base_url()?>assets_v2/plugins/select2/js/select2.full.min.js"></script>
<script>
   var start = "";
   var end = "";
   function xxx(){
      $example.select2();
   }
   function yyy(){
      $example.select2("destroy");
   }
   function show () {
      $("#spinner").addClass("show");
   }

   function hide () {
      $("#spinner").removeClass("show");
   }
   var $example = $(".select2Data").select2({
        theme: 'bootstrap',
        dropdownCssClass: 'select2-dropdown--scroll'
    });
 
   
   FilterData();
    
   function FilterData(id){
         show();
         var formData = new FormData();
         formData.append('limit',  $('#limitData').val());
         formData.append('src',  $('#srcData').val());
         var id =(id == null ? 0: id);
         $.ajax({
               url: "<?=base_url()?>fasilitas/LoadData/"+id,
               type: 'post',
               data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                
                  var no =json['pag']['start'];
                  jQuery.each(json['fasilitas'], function( i, val ) {
          
                     header_table +=`<tr >
                                       <td>` +(no++) + `</td>
				       <td ></td>
                                       <td >`+val['nama_fasilitas']+`</td>
                                       <td class="center-t">`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                       <td class="center-t">`+(val['sublokasi'] == null ? '': val['sublokasi'])+`</td>
                                       <td >`+(val['ip_address'] == null ? '': val['ip_address'])+`</td>
                                       <td id='status-`+val['id']+`'>
                                          <div class="btn-group " role="group" data-toggle="tooltip" data-placement="top" title="" data-original-title=".btn-xlg"> 
                                             <a  onclick="ViewDetail(`+val['id_fasilitas']+`)" class="btn waves-effect waves-light btn-primary  btn-outline-primary  btn-icon"><i class="feather icon-eye"></i></a>   
                                             <!--<button class="btn waves-effect waves-light btn-success btn-outline-success btn-icon" onclick="CekIP(`+val['id_fasilitas']+`)"><i class="fa fa-wifi"></i></button>-->
                                             <a href="<?=base_url('fasilitas/performa/')?>`+val['id_fasilitas']+`"  class="btn waves-effect waves-light btn-success btn-outline-success btn-icon"><i class="fa fa-line-chart"></i></a>
                                             <button class="btn waves-effect waves-light btn-warning  btn-outline-warning  btn-icon" onclick="EditData(`+val['id_fasilitas']+`)"><i class="feather icon-edit"></i></button>
                                             <button class="btn waves-effect waves-light btn-danger btn-outline-danger btn-icon" onclick="DeleteData(`+val['id_fasilitas']+`)"><i class="fa fa-trash"></i></button>
                                          </div>
                                       
                                       </td>
                                    </tr>`;
                  });

                 
                
                  $('#tabel-data-fasilitas > tbody:last-child').html(header_table);
                  $('#data-pag').html(json['pag']['label']);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
   }

   function JenisPerangkat(id,id_edit){

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
                     if (id_edit == val['id_jenisperangkat']) {
                    
                        row +=`<option value="`+val['id_jenisperangkat']+` " selected>`+val['nama']+`</option>`;
                     }else{
                        row +=`<option value="`+val['id_jenisperangkat']+`">`+val['nama']+`</option>`;
                     }
                   
                  });
                  
                  $('#'+id).html(row);
               }, error: function(){
                  hide ();
               }
         });   

       
         return false;
   }

   function DataLokasi(id){
        
        $.ajax({
              url: "<?=base_url()?>fasilitas/GetLokasi",
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    if (id != '' && id ==val['id']) {
                     row +=`<option value="`+val['id']+`" selected>`+val['nama_terminal']+`</option>`;
                    }else{
                     row +=`<option value="`+val['id']+`">`+val['nama_terminal']+`</option>`;
                    }
                   
                 });
                 
                 $('#id_lokasi').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
   }

    
   function Perangkat(idjenis,id,idperangkat,namaperangkat,sn){
     show();
        $.ajax({
              url: "<?=base_url()?>fasilitas/LoadDataPerangkat/"+idjenis,
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,
              success: function(r){
                 var row = `<option value=""></option>`;
                 if (idperangkat != '') {
                     if (sn == null) {
                        row +=`<option value="`+idperangkat+`" selected>`+namaperangkat+` </option>` ; 
                     }else{
                        row +=`<option value="`+idperangkat+`" selected>`+namaperangkat+` (`+sn+`)</option>` ;
                     }
                
                 }else{
                  console.log('kosong');
                 }
                
                 var json = JSON.parse(r);
                
                 jQuery.each(json, function( i, val ) {
                
                  //   if (id_edit == val['id_perangkat']) {
                  //    //console.log(val['id_perangkat']+"|"+val['nama_perangkat']+"|"+val['serial_number']);
                  //    row +=`<option value="`+val['id_perangkat']+`" selected>`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
                  //   }else{
                  //    row +=`<option value="`+val['id_perangkat']+`">`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
                  //   }
                    row +=`<option value="`+val['id_perangkat']+`">`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
                 });
                 $('#'+id).html(row);
                 hide ();
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
         url:  '<?=base_url('fasilitas/')?>UpdateData/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            $('#m-Fasilitas').modal('hide');
          
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
      $('#m-Fasilitas').modal('show');
      $('#m-Fasilitas').find('.modal-title').html('Tambah Fasilitas');   
      $('#m-Fasilitas').find('form').attr('onsubmit','return SaveData(this)');
      $('#new_perangkat').html('');
      DataLokasi();
      clear_form();
   }

  
   function  clear_form(){
      
      $('#nama_fasilitas').val("");
      $('#ip_address').val("");  
      $("#id_lokasi ").val("");
      $('#id_sublokasi').val("");    
              
              
   }

   function SaveData(f){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url:  '<?=base_url('fasilitas/')?>SaveData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            $('#m-Fasilitas').modal('hide');
           FilterData();
           
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }

   


   function AddPerangkat(){
      // var new_chq_no = parseInt($('#total_chq').val()) + 1;
      var rowCount =  $('#tabel-perangkat > tbody tr').length;
     
      JenisPerangkat('id_jenisperangkat'+rowCount);
     
      var new_input = ` 
      <tr >
         <td>
            <select class="form-control jenis select2Data" id="id_jenisperangkat`+rowCount+`" name="Newitems[`+rowCount+`][id_jenisperangkat]" data-id="`+rowCount+`" aria-hidden="true" data-select2-id="id_lokasi">
               <option value=""></option>  
            </select>
         </td>
         <td>
            <select class="form-control select2Data" id="id_perangkat`+rowCount+`" name="Newitems[`+rowCount+`][id_perangkat]">
               <option value=""></option>
            </select>
         </td>
         <td>
            <input type="date" class="form-control" id="nama_fasilitas`+rowCount+`" name="Newitems[`+rowCount+`][tanggal_pemasangan]" >
         </td>
         <td>
            <a class="btn waves-effect waves-light btn-danger btn-icon2" onclick="RemovePerangkat(this,'')"  type=""><i class="feather icon-trash"></i></a>
         </td>
      </tr>
     `;
      $('#new_perangkat').append(new_input);
      $("#id_jenisperangkat"+rowCount).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
      $("#id_perangkat"+rowCount).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
            // $('#total_chq').val(new_chq_no);
   }

   function RemovePerangkat (e,t) {
      // var last_chq_no = $('#total_chq').val();

      // if (last_chq_no > 1) {
      //    $('#'+ r).remove();
      //    $('#total_chq').val(last_chq_no - 1);
      // }
   
      // $('#'+ r).remove();
      // a && 0 < $("#removed-items").append(hidden_input("removed_items[]", a))
      $(e).parents("tr").addClass("animated fadeOut", function() {
        setTimeout(function() {
            $(e).parents("tr").remove()
        }, 50)
    }), t && 0 < $("#removed-items").append(hidden_input("removed_items[]", t))
  
   }

   function hidden_input(e,t){
      return '<input type="hidden" name="'+e+'" value="'+t+'" >';
   }
   function EditData(id){
      show();
      $('#m-Fasilitas').modal('show');
      $('#m-Fasilitas').find('.modal-title').html('Edit Fasilitas');   
      $('#m-Fasilitas').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
    
      $.ajax({
         url: "<?=base_url()?>fasilitas/EditData/"+id,
         type: 'post',
         success: function(r){
        
               var json = JSON.parse(r);
               $('#nama_fasilitas').val(json['nama_fasilitas']);
               $('#ip_address').val(json['ip_address']);  
               DataLokasi(json['id_lokasi']);
               
               // $("#id_lokasi  option[value='" + json['id_lokasi'] + "']").attr("selected","selected");
               $('#id_sublokasi').append('<option value="'+json['id_sublokasi']+'" selected>'+json['sub_lokasi']+'</option>');
               var rowCount =  $('#tabel-perangkat > tbody tr').length;
               var row='';
               const nilai_i =[] ;
               jQuery.each(json['detail'], function( i, val ) {
                
                  const   perangkat = [];
                  JenisPerangkat('id_jenisperangkat'+i,val['id_jenisperangkat']);
                  Perangkat(val['id_jenisperangkat'],'id_perangkat'+i,val['id_perangkat'],val['nama_perangkat'],val['serial_number']);
               
                   row += ` 
                     <tr>
                        <td>
                           <select class="form-control jenis" id="id_jenisperangkat`+i+`" name="Items[`+i+`][id_jenisperangkat]" data-id="`+i+`">
                              <option value=""></option>
                              <option value="`+val['id_perangkat']+`" selected>`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>
                              
                           </select>
                        </td>
                        <td>
                           <select class="form-control" id="id_perangkat`+i+`" name="Items[`+i+`][id_perangkat]">
                              <option value=""></option>
                           </select>
                        </td>
                        <td>
                           <input type="date" class="form-control" id="nama_fasilitas`+i+`" name="Items[`+i+`][tanggal_pemasangan]" value="">
                           <input type="hidden" class="form-control" id="idfasilitas_detail`+i+`" name="Items[`+i+`][idfasilitas_detail]" value="`+val['idfasilitas_detail']+`">
                        </td>
                        <td>
                           <a class="btn waves-effect waves-light btn-danger btn-icon2" onclick="RemovePerangkat(this,'`+val['idfasilitas_detail']+`')"  type=""><i class="feather icon-trash"></i></a>
                        </td>
                     </tr>`;
                     nilai_i.push(i)
                    
               });
              
               $('#tabel-perangkat > tbody:last-child').html(row);
               for (let i = 0; i < nilai_i.length; i++) {
                  $("#id_jenisperangkat"+i).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
                  $("#id_perangkat"+i).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
               }
              
              hide();
         },
         error: function(){
               hide();
         }
      });
      return false;
   }
   
   
   $('body').on('change','#limitData', function() {
   
    FilterData();
   });

   $( "#srcData" ).on( "keyup", function() {
      FilterData();
   } );
   
   $('body').on('change','#id_lokasi', function() {
  
      if($(this).val() != ''){
         var id=$(this).val();
      
         $.ajax({
            url: '<?=base_url('fasilitas/')?>GetArea/'+id,
            success: function(r){
               var json = JSON.parse(r);
            
               var row = `<option value="">-- Pilih --</option>`;
               jQuery.each(json, function( i, val ) {
                  row+=`<option value="`+val['id']+`">`+val['nama_terminal']+`</option>`;
               });
               $('#id_sublokasi').html(row);
               
            }, error(){
            
         }
      });   
      }
   });

   $('body').on('change','.jenis', function() {
      if($(this).val() != ''){
         var id=$(this).val();
         Perangkat(id,'id_perangkat'+$(this).data("id"),'','','');
      }
   });

   function DeleteData(){

   }

   function ViewDetail(id){
      $('#m-detail').modal('show');
      $('#m-detail').find('.modal-title').html('Detail Fasilitas');   
   
      $.ajax({
         url: "<?=base_url()?>fasilitas/ViewDetail/"+id,
         type: 'post',
         success: function(r){
        
               var json = JSON.parse(r);
               $('#fasilitas-detail').html(json['nama_fasilitas']);
               $('#ip-detail').html(json['ip_address']);
               $('#lokasi-detail').html(json['lokasi']);
               $('#sublokasi-detail').html(json['sub_lokasi']);
               
               
               var rowCount =  $('#tabel-perangkat > tbody tr').length;

               var row='';
               jQuery.each(json['detail'], function( i, val ) {
                  row +=   `<tr>
                              <td>`+val['jenis_perangkat']+`</td>
                              <td>`+val['nama_perangkat']+`</td>
                              <td>`+(val['tanggal_penggunaan'] == null ? '' : val['tanggal_penggunaan'])+`</td>
                           </tr>`;
                 
               });
             
               $('#tabel-ViewDetail > tbody:last-child').html(row);
               // LoadFasilits(json['id_fasilitas']);
         },
         error: function(){
               hide();
         }
      });
      return false;
   }
   LoadSumFasilitas();

   function LoadSumFasilitas(){
      $.ajax({
         url: "<?=base_url()?>fasilitas/summary",
         type: 'post',
         success: function(r){
               var json = JSON.parse(r);
               var row='';
               jQuery.each(json['sum'], function( i, val ) {
                   row += `   <div class="col-md-4">
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

               console.log(json['all']['total']);
               $('#AllDataFasilitas').text(json['all']['total']);
            
               $('#sum-perangkat').html(row);
         },
         error: function(){
               hide();
         }
      });
      return false;
   }

   function CekIP(id){
      show();
      $.ajax({
         url:  '<?=base_url('fasilitas/')?>CekIp/'+id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            if (json['status']== 0)  {
               alert("Request Time Out");
            }else{
               alert("Replay");
            }
           
            // CekIP();
            // setInterval(CekIP(), 100000);
            hide();
         }, error: function(){
          
         }
      });
      return false;
    }
</script>