

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
   .label-primary {
    background: #5daaff;
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
   .cemter-t{
      text-align: center;
   }
   
   table {
   
    border-spacing: 2px;
   }
  
   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
      vertical-align: middle;
      text-align: center;
   }

  

.t-formatP th{
   vertical-align: middle;
}

.center{
   vertical-align: middle;
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
               <?php 
                  // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
                  ?>
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
                        <form id="form-filter" class="row" onsubmit="return FilterData()">
                           <?php if (ses_role() == 'ADMINISTRATOR'): ?>
                           <div class="form-group col-md-3">
                              <div class="form-group row">
                                 <label class="col-sm-3 col-form-label">Direksi </label>
                                 <div class="col-sm-6">
                                    <select name="UNIT" class="select2 form-control"style="width: 100%" id="UNIT">
                                       <option value="">-- Pilih --</option>
                                       <?php foreach ($list_dir as $key => $value): ?>
                                          <option value="<?=$value['KODE_UNIT']?>"><?=$value['DESKRIPSI']?></option>
                                       <?php endforeach ?>
                                       
                                    </select>
                                 </div>
                              </div>
                           </div>   
                           
                           <?php endif ?>
                           <div class="form-group col-md-3">
                              <div class="form-group row">
                                 <label class="col-sm-3 col-form-label">Tahun </label>
                                 <div class="col-sm-6">
                                    <select name="TAHUN" class="select2 form-control"style="width: 100%" id="TAHUN">
                                       <option value="">-- Pilih --</option>
                                       <?php
                                          $y= date("Y");
                                          for ($x = 0; $x <=2; $x++) { ?>
                                       <option value="<?=$x+ $y?>"><?=$x+ $y?></option>
                                       <?php }?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-4 ">
                              <div class="form-group row">
                                 <label class="col-sm-3 col-form-label">Pencapaian </label>
                                 <div class="col-sm-6">
                                    <select name="PENCAPAIAN" class="select2 form-control"style="width: 100%" id="PENCAPAIAN">
                                       <option value="">ALL</option>
                                       <option value="HIJAU">HIJAU</option>
                                       <option value="KUNING">KUNING</option>
                                       <option value="MERAH">MERAH</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group col-md-2">
                           <button class="btn btn-primary" type="submit">Search</button>
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
                        <table class="table table-condensed table-striped table-bordered" id="tabel-data1">
                           <thead class="thead-blue">
                                 <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Jenis PM</th>
                                    <th class="cemter-t">Total Pekerjaan</th>
                                    <th class="cemter-t">Status</th>
                                    <th class="cemter-t">Action</th>
                                 </tr>
                           </thead>
                           <tbody id="Data-AP">
                            
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>

<div class="modal modal-fullscreen-xl" id="ModalDetailJob" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
   <form id="form-monitoring" class="row" onsubmit="return UpdateData(this)">
         <div class="modal-content">
            <div class="modal-header modal-black">
               <h5 class="modal-title modal-wt" id="exampleModalLabel">New message</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row mb-10 ">
                  <div class="col-md-3">Nama Pekerjaan </div>
                  <div class="col-md-6">
                     <input type="text" name="job_name" id="job_name" class="form-control" >
                  </div>
                  <div class="col-md-3">  <button class="btn btn-primary" type="submit" form="form-monitoring">Save</button> </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table class="table table-condensed  table-bordered" id="tabel-data-detail">
                        <thead class="thead-blue">
                                 <th class="cemter-t">No</th>
                                       <th class="cemter-t">Nama Pekerjaan</th>
                                       <th class="cemter-t">Status</th>
                                       <th class="cemter-t">Action</th>
                        </thead>
                        <tbody id="detail_ap">
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             
            </div>
         </div>
      </form>
   
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
  
      
   function show () {
      $("#spinner").addClass("show");
      
   }
   function hide () {
         $("#spinner").removeClass("show");
   }

   
   FilterData();
    function FilterData(){
      show();
        var formData = new FormData();
       
            var TAHUN      = $('#TAHUN').val();
            var PENCAPAIAN = $('#PENCAPAIAN').val();
         
        
       // var con_page = ( page != null ? "?page="+page:"");
        formData.append('TAHUN', TAHUN);
        formData.append('PENCAPAIAN', PENCAPAIAN);
         if ($('#UNIT').val() != null ) {

            var UNIT = $('#UNIT').val();
          formData.append('UNIT', UNIT);
         }
       
        
        $.ajax({
            url: "<?=base_url()?>job_pm/LoadData",
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,

            success: function(r){
                var json = JSON.parse(r);
                var row = "";
                var no =1;
                jQuery.each(json, function( i, val ) {
                  row +=`<tr >
                                       <td >`+(no++)+`</td>
                                       <td >`+val['name_pm']+`</td>
                                       <td >`+val['detail']+`</td>
                                       <td >`+(val['status'] == 0 ? 'Not Active': 'Active')+`</td>
                                       <td > <a class="btn btn-primary" onclick="ViewDetail(`+val['idpm_type']+`)"><i class="feather icon-eye"></i> </a>
                                       </td>
                                    </tr>`;   
                
                });
                $('#Data-AP').html(row);
               hide ();
            }, error: function(){
               hide ();
            }
        });
                
            return false;
    }


   function ViewDetail(id){
      show();
      $('#ModalDetailJob').find('form').attr('onsubmit','return SaveDetail(this,\''+id+'\')');
      $('#ModalDetailJob').modal('show');
      $('#ModalDetailJob').find('.modal-title').html('Detail Monitoring Action Plan');   
     
      DetailData(id);
   }
 
   function DetailData(id){
         show();
         $.ajax({
               url: "<?=base_url()?>job_pm/LoadDataDetail/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,
   
               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                 var no = 1;
                  jQuery.each(json, function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       <td >`+(no++)+`</td>
                                       <td >`+val['nama']+`</td>
                                       <td >`+(val['status'] == 0 ? 'Not Active': 'Active')+`</td>
                                       <td > 
                                       <a class="btn btn-danger" onclick="DeleteDetail(`+val['id_jobpm']+`,`+val['id_pmtype']+`)"><i class="feather icon-trash"></i> </a>
                                       </td>
                                    </tr>`;
                  });
                
                  $('#tabel-data-detail> tbody:last-child').html(header_table);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
   }

   function SaveDetail(f,id){
      show();
      var formData = new FormData($(f)[0]);
     
        $.ajax({
            url: "<?=base_url()?>job_pm/SaveDetail/"+id,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,

            success: function(r){
               // $('#ModakEditMonitoring').modal('hide');
               DetailData(id);
               hide ();
            }, error: function(){
               hide ();
            }
        });
                
            return false;
   }

 
    
   function DeleteDetail(id,idp){
      // show();
     
      $.ajax({
               url: "<?=base_url('job_pm/DeleteDetail/')?>"+id,
               success: function(r){
               console.log('tes');
                  DetailData(idp);
                  FilterData();
                  hide ();
               }, error: function(){
                 
               }
      });

    }
</script>