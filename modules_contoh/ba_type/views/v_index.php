

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
                     <div class="row" id="export">
                           <div class="col-md-12">
                           <div class="pull-right putih mb-10">
                              <a class="btn btn-primary" onclick="New()"><i class="fa fa-file-excel-o "></i> Tambah BA</a>
                           </div>
                           </div>
                           
                        </div>
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
                            <?php
                            foreach ($isi as $key => $value) {

                              ?>
                           <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t"><?=$value['nama_ba'] ?></th>
                                    <th class="cemter-t">Total Pekerjaan</th>
                                    <th class="cemter-t">Status</th>
                                    <th class="cemter-t">Action</th>
                                 </tr>
                              <?php
                          }
                            ?>
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

<div class="modal modal-fullscreen-xl" id="MasterBA" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
   <form id="form-monitoring" class="row" onsubmit="return SaveDetail(this)">
         <div class="modal-content">
            <div class="modal-header modal-black">
               <h5 class="modal-title modal-wt" id="exampleModalLabel">New message</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row mb-10 ">
                  <div class="col-md-3">Nama Berita Acara </div>
                  <div class="col-md-6">
                     <input type="text" name="job_name" id="job_name" class="form-control" >
                  </div>
                  <div class="col-md-3">  </div>
               </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-primary" type="submit" form="form-monitoring">Save</button>
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

   function New(){
      // show();
      $('#MasterBA').modal('show');
      $('#MasterBA').find('.modal-title').html('Tambah Jenis Berita Acara');   
      $('#MasterBA').find('form').attr('onsubmit','return SaveDetail(this)');
      

   }

   function show () {
      $("#spinner").addClass("show");
      
   }
   function hide () {
         $("#spinner").removeClass("show");
   }

   
   function SaveDetail(f,id){
      
      var formData = new FormData($(f)[0]);
     
        $.ajax({
            url: "<?=base_url()?>ba_type/Save/"+id,
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

 
</script>