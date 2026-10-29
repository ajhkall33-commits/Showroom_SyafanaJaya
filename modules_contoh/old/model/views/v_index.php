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
                        <div class="row" id="export">
                           <div class="col-md-12">
                              <div class="pull-right putih mb-10">
                                 <a class="btn btn-primary" onclick="AddData()"><i class="fa fa-file-excel-o "></i> Tambah</a>
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
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                              <thead class="thead-blue">
                                 <tr>
                                    <th class="cemter-t">No </th>
                                    <th class="cemter-t">Merk </th>
                                    <th class="cemter-t">Model / Tipe </th>
                                    <th class="cemter-t">Tahun </th>
                                    <th class="cemter-t">Jenis Perangkat</th>
                                    <th class="cemter-t">Status</th>
                                    <th class="cemter-t">Action</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
                              </tbody>
                           </table>
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
   <div class="modal-dialog modal-l" role="document">
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
                  <div class="col-md-12">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Merk</label>
                        <div class="col-md-8">
                           <select class="form-control" id="merk_id" name="merk_id">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-12">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Tipe / Model</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="nama_perangkat" id="nama_perangkat" >
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-12">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Tahun</label>
                        <div class="col-md-8">
                           <input type="text" class="form-control" name="tahun" id="tahun">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-12">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Jenis Perangkat</label>
                        <div class="col-md-8">
                           <select class="form-control" id="id_jenisperangkat" name="id_jenisperangkat">
                              <option value=""></option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>              
              
                   <div id="input_detail">
                    
                  </div>
              
               
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
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
                        <label class="col-sm-5 col-form-label">Jenis Perangkat</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="jenis_detail">-</label>
                     </div>  
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Nama Perangkat</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="nama_detail">-</label>
                     </div> 
                     <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Tahun</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label" id="tahun_model">-</label>
                     </div> 
                  </div>
                  <div class="col-md-6" id="ViewInfo">

                  </div>
               </div>
               
              
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
               </div>
         </form>
         </div>
      </div>
   </div>
</div>
<!-- End Modal View Perangkat -->
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
   
   function show () {$("#spinner").addClass("show");}
   function hide () {$("#spinner").removeClass("show");}
   FilterData();
   JenisPerangkat();
   MerkPerangkat()
   function FilterData(id) {
      show();
      var formData = new FormData();
      formData.append('limit',  $('#limitData').val());
      formData.append('src',  $('#srcData').val());
     
      var id =(id == null ? 0: id);
      $.ajax({
         url: "<?=base_url()?>model/LoadData/"+id,
         type: 'post',
          data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
             var pag = "";
             var no =json['pag']['start'];
          
             jQuery.each(json['perangkat'], function(i, val) {
              var opt = "";
              if (val['status'] == 0) {
               opt = `  <button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(` + val['id_perangkat'] + `)"><i class="feather icon-eye"></i></button>
                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="EditData(` + val['id_perangkat'] + `)"><i class="feather icon-edit"></i></button>
                        <button class="btn waves-effect waves-light btn-danger btn-outline-danger btn-icon" onclick="Delete(` + val['id_perangkat'] + `)"><i class="fa fa-trash"></i></button>
                                       `;
              }else{
               opt=`
               <button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(` + val['id_perangkat'] + `)"><i class="feather icon-eye"></i></button>`;
              }
                 row += `<tr >
                                       <td>` +(no++) + `</td>
                                       <td>` + val['merk'] + `</td>
                                       <td>` + val['nama_perangkat'] + `</td>
                                       <td>` + (val['tahun'] == null ? '' : val['tahun']) + `</td>
                                       <td>` + (val['jenis_perangkat'] == null ? '' : val['jenis_perangkat']) + `</td>
                                       <td>` + (val['status'] == null ? '' : val['status']) + `</td>
                                       <td>
                                       <div class="btn-group " role="group" data-toggle="tooltip" data-placement="top" title="" data-original-title=".btn-xlg">`+
                                       opt+ 
                                       `</div>
                                         
                                       </td>
                                    </tr>`;
             });

             $('#tabel-data > tbody:last-child').html(row);
             $('#data-pag').html(json['pag']['label']);
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
      $('#m-viewperangkat').find('.modal-title').html('Info Detail Perangkat');   
    
     $.ajax({
         url: "<?=base_url()?>model/ViewDetail/"+id,
         type: 'post',
         // data: formData,
         contentType: false,
         processData: false,

         success: function(r) {
             var json = JSON.parse(r);
             var row = "";
             $('#jenis_detail').html(json['id_jenisperangkat']);  
             $('#nama_detail').html(json['nama_perangkat']); 
             $('#tahun_model').html(json['tahun']);  
            
               var row = '';
                 jQuery.each(json['detail'], function( i, val ) {
                    
                    row +=`<div class="form-group row">
                        <label class="col-sm-5 col-form-label">`+val['property']+`</label>
                        <label class="col-sm-1 col-form-label">:</label>
                        <label class="col-sm-6 col-form-label">`+val['value']+`</label>
                     </div>  `;
                 });
                 
                 $('#ViewInfo').html(row);
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
      $('#m-detailperangkat').find('.modal-title').html('Tambah Tipe / Model');   
      $('#m-detailperangkat').find('form').attr('onsubmit','return SaveData(this)');
      

    }

    function EditData(id){
      // show();
      $('#m-detailperangkat').modal('show');
      $('#m-detailperangkat').find('.modal-title').html('Edit Model / Tipe');   
      $('#m-detailperangkat').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      $.ajax({
               url: "<?=base_url()?>model/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row =  `<hr class="hr" />
			      <div class="row"> <div class="col-md-10">
                                 <h6>Spesifikasi Perangkat</h6>
                              </div>`;
                     jQuery.each(json['detail'], function( i, val ) {
                     
                        row +=`  <div class="col-md-12">
                                    <div class="form-group row">
                                       <label class="col-md-4 col-form-label">`+val['property']+`</label>
                                       <div class="col-md-8">
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
                  $('#merk_id').val(json['merk_id']);  
                  $('#tahun').val(json['tahun']); 
                
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
                  var row =  `<hr class="hr" />
			      <div class="row"> <div class="col-md-10">
                                 <h4 class="sub-title">Spesifikasi Perangkat</h4>
                              </div>`;
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`  
                    
                    
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-md-4 col-form-label">`+val['nama']+`</label>
                           <div class="col-md-8">
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


   function Delete(id){
      // show();
      // $('#m-menu').modal('show');
      // $('#m-menu').find('.modal-title').html('Infomation Realisasi Kinerja');   
      // $('#Mm-menu').find('form').attr('onsubmit','return SaveData(this)');
      // MenuParent();
      $.ajax({
         url:  '<?=base_url('model/')?>Delete/'+id,
       
         type: 'post',
         //data: formData,
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


    function UpdateData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('model/')?>UpdateData/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            $('#m-detailperangkat').modal('hide');
          
           FilterData();
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
         url:  '<?=base_url('model/')?>SaveData',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            $('#m-detailperangkat').modal('hide');
          
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

   $( "#srcData" ).on( "keyup", function() {
      FilterData();
   
   } );

   $('body').on('change','#id_jenisperangkat', function() {
      MasterDetailPerangkat( $(this).val());

   });
</script>