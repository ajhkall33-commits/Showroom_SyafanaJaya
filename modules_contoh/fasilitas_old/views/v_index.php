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
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Nama Fasilitas</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Terminal</th>
                                    <th class="cemter-t">IP</th>
                                    <th class="cemter-t">Status</th>
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
                           <select class="form-control" id="id_lokasi" name="id_lokasi">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Sub Lokasi</label>
                        <div class="col-md-8">
                           <select class="form-control" id="id_sublokasi" name="id_sublokasi">
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
                              <th>Jenis Perangkat</th>
                              <th>Perangkat</th>
                              <th>Tanggal Penggunaan</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody id="new_perangkat">
                           <div id="removed-items"></div>
                        </tbody>
                     </table>
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
    
      function FilterData(id){
         show();
         var formData = new FormData();
         formData.append('limit',  $('#limitData').val());
         formData.append('src',  $('#srcData').val());
         var id =(id == null ? 0: id);
         $.ajax({
               url: "<?=base_url()?>Fasilitas/LoadData/"+id,
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
                                       <td >`+val['nama_fasilitas']+`</td>
                                       <td >`+(val['lokasi'] == null ? '': val['lokasi'])+`</td>
                                       <td >`+(val['terminal'] == null ? '': val['terminal'])+`</td>
                                       <td >`+(val['ip_address'] == null ? '': val['ip_address'])+`</td>
                                       <td id='status-`+val['id']+`'><a href="<?=base_url('Fasilitas/performa/')?>`+val['id_fasilitas']+`"<button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(2)"><i class="feather icon-eye"></i></a></td>
                                    </tr>`;
                  });

                  $('#RTO').html(json['rto']);
                  $('#replay').html(json['replay']);
                
                  $('#tabel-data-fasilitas > tbody:last-child').html(header_table);
                  $('#data-pag').html(json['pag']['label']);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
      function JenisPerangkat(id){
        
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
                  
                  $('#'+id).html(row);
               }, error: function(){
                  hide ();
               }
         });   

       
         return false;
      }

      function DataLokasi(){
        
        $.ajax({
              url: "<?=base_url()?>Fasilitas/GetLokasi",
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id']+`">`+val['nama_terminal']+`</option>`;
                 });
                 
                 $('#id_lokasi').html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
     }

    
      function Perangkat(idjenis,id){
        
        $.ajax({
              url: "<?=base_url()?>Fasilitas/LoadDataPerangkat/"+idjenis,
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id_perangkat']+`">`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
                 });
                 
                 $('#'+id).html(row);
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
      $('#m-Fasilitas').modal('show');
      $('#m-Fasilitas').find('.modal-title').html('Tambah Fasilitas');   
      $('#m-Fasilitas').find('form').attr('onsubmit','return SaveData(this)');
      
      DataLokasi();
   }

  
  
   function SaveData(f){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url:  '<?=base_url('Fasilitas/')?>SaveData/',
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

   $('body').on('change','#id_lokasi', function() {
  
      if($(this).val() != ''){
         var id=$(this).val();
      
         $.ajax({
            url: '<?=base_url('Fasilitas/')?>GetArea/'+id,
            success: function(r){
               var json = JSON.parse(r);
            
               var row = `<option value="">-- Pilih --</option>`;
               jQuery.each(json, function( i, val ) {
               
               
                  row+=`<option value="`+val['id']+`">`+val['nama_terminal']+`</option>`;
               });
               $('#id_sublokasi').html(row);
               console.log(row);
            }, error(){
            
         }
      });   
      }
   });

   $('body').on('change','.jenis', function() {
  
      if($(this).val() != ''){
         var id=$(this).val();
       
         Perangkat(id,'id_perangkat'+$(this).data("id"));
        
      }
   });


   function AddPerangkat(){
      // var new_chq_no = parseInt($('#total_chq').val()) + 1;
      var rowCount =  $('#tabel-perangkat > tbody tr').length;
      // console.log(rowCount);
      JenisPerangkat('id_jenisperangkat'+rowCount);
     
      var new_input = ` 
      <tr id ="act_`+rowCount+`">
         <td>
            <select class="form-control jenis" id="id_jenisperangkat`+rowCount+`" name="Newitems[`+rowCount+`][id_jenisperangkat]" data-id="`+rowCount+`">
               <option value=""></option>
               
            </select>
         </td>
         <td>
            <select class="form-control" id="id_perangkat`+rowCount+`" name="Newitems[`+rowCount+`][id_perangkat]">
               <option value=""></option>
            </select>
         </td>
         <td>
            <input type="date" class="form-control" id="nama_fasilitas`+rowCount+`" name="Newitems[`+rowCount+`][tanggal_pemasangan]" >
         </td>
         <td>
            <a class="btn waves-effect waves-light btn-danger btn-icon2" onclick="RemoveActionPlan('act_`+rowCount+`')"  type=""><i class="feather icon-trash"></i></a>
         </td>
      </tr>
     `;
      $('#new_perangkat').append(new_input);

      // $('#total_chq').val(new_chq_no);
   }

   function RemoveActionPlan(r,a) {
      // var last_chq_no = $('#total_chq').val();

      // if (last_chq_no > 1) {
      //    $('#'+ r).remove();
      //    $('#total_chq').val(last_chq_no - 1);
      // }
      $('#'+ r).remove();
      a && 0 < $("#removed-items").append(hidden_input("removed_items[]", a))
   }

   
   $('body').on('change','#limitData', function() {
   
    FilterData();
   });

   $( "#srcData" ).on( "keypress", function() {
      FilterData();
   
   } );
</script>