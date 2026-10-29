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

   .tombol{
      width: 100px;
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
            <i class="feather icon-flag bg-c-blue"></i>
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
                                 <a href="<?=base_url()?>listWO/AddData" class="btn btn-primary"><i class="fa fa-file-excel-o "></i> Tambah</a>
                              
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
                                       <th class="cemter-t">Tiket </th>
                                       <th class="cemter-t">Tanggal</th>
                                       <th class="cemter-t">Keterangan</th>
                                       <th class="cemter-t">Status</th>
                                       <th class="cemter-t">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody id="Data">
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
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="m-Detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <div class="col-md-6">
                     <div class="row ">
                       <label class="col-sm-4 col-form-label">No WO</label>
                        <label class="col-sm-4 col-form-label">: <span></span></label>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="row ">
                       <label class="col-sm-4 col-form-label">Tanggal</label>
                        <label class="col-sm-4 col-form-label">:  <span></span></label>
                     </div>
                     <div class="row ">
                       <label class="col-sm-4 col-form-label">STATUS</label>
                        <label class="col-sm-4 col-form-label">: DRAFT <span></span></label>
                     </div>
                     
                  </div>
               </div>
               <div class="form-group row">
                  <div class="col-md-6">
                     <div class="row">
                        <label class="col-md-4 col-form-label">Note</label>
                        <label class="col-sm-4 col-form-label">: <span></span></label>
                     </div>
                  </div>
               </div>
               <div class="row">
                  
                  <div class="col-md-12">
                     <table class="table table-condensed table-striped" id="tabel-perangkat">
                        <thead>
                           <tr>
                              <th>Fasilitas</th>
                              <th>Terdampak</th>
                              <th>Keterangan</th>
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
               <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
      </div>
   </div>
</div>



<div class="modal fade" id="m-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog  modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          
         </div>
      
         <form onsubmit="return ProsesData(this)">
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save</button>
            </div>
         </form>
        
      </div>
   </div>
</div>

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

<script>
   var start = "";
   var end = "";
   FilterData();
      function show () {
         $("#spinner").addClass("show");
      }
      function hide () {
         $("#spinner").removeClass("show");
      }
     
    
      function FilterData(){
         show();
       
         $.ajax({
               url: "<?=base_url()?>ListWO/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "";
                  var no =json['pag']['start'];
                  jQuery.each(json['wo'], function( i, val ) {
                     var opt = "";
                     if (val['status'] == 0) {
                        opt = ` <button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(` + val['id_wo'] + `)"><i class="feather icon-eye"></i></button>
                        <button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ConfirmProsesData(` + val['id_wo'] + `)"><i class="fa fa-gear"></i></button>
                                                   <button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="EditData(` + val['id_wo'] + `)"><i class="feather icon-edit"></i></button>
                                                   <button class="btn waves-effect waves-light btn-danger btn-outline-danger btn-icon" onclick="ConfirmDeleteData(` + val['id_wo'] + `)"><i class="fa fa-trash"></i></button>
                                                `;
                     }else{
                        opt=`<button class="btn waves-effect waves-light btn-primary btn-outline-primary btn-icon" onclick="ViewDetail(` + val['id_wo'] + `)"><i class="feather icon-eye"></i></button>`;
                     }
                     row +=`<tr >
                                       <td >`+(no++)+`</td>
                                      
                                       <td >`+(val['tanggal'] == null ? '': val['tanggal'])+`</td>
                                       <td >`+(val['tanggal'] == null ? '': val['tanggal'])+`</td>
                                       <td >`+(val['keterangan'] == null ? '': val['keterangan'])+`</td>
                                      
                                       <td id='status-`+val['status']+`'>`+(val['status'] ==1 ? 'Pending': 'Done')+`</td>
                                       <td >
                                       <div class="btn-group " role="group" data-toggle="tooltip" data-placement="top" title="" data-original-title=".btn-xlg">`
                                       +opt+
                                       `</div></td>
                                       </tr>`;
                  });
                
                  $('#tabel-data > tbody:last-child').html(row);
                  $('#data-pag').html(json['pag']['label']);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }
    
   $('body').on('change','#limitData', function() {
      FilterData();
   });

  
  

   
   function ViewDetail(id){
      $('#m-Detail').modal('show');
      $('#m-Detail').find('.modal-title').html('Overview Work Order');   
      $('#m-Detail').find('form').attr('onsubmit','return SaveData(this)');
      
   }

   function ConfirmProsesData(id){
      $('#m-confirm').modal('show');
      $('#m-confirm').find('.modal-title').html('Yakin Untuk Memproses Data ini!!');   
      $('#m-confirm').find('form').attr('onsubmit','return ProsesData(this,'+id+')');
     
   }

   function ConfirmDeleteData(id){
      $('#m-confirm').modal('show');
      $('#m-confirm').find('.modal-title').html('Yakin Untuk Menghapus Data ini!!');   
      $('#m-confirm').find('form').attr('onsubmit','return DeleteData(this,'+id+')');
     
   }

   function ProsesData(f,id){
      $.ajax({
               url: "<?=base_url()?>ListWO/ProsesData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
               
                  var json = JSON.parse(r);
                  $('#m-confirm').modal('hide');
                  FilterData();
               }, error: function(){
                  hide ();
               }
         });   

       
      return false;
   
   }

   function DeleteData(f,id){
      $.ajax({
               url: "<?=base_url()?>ListWO/DeleteData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
               
                  var json = JSON.parse(r);
                  $('#m-confirm').modal('hide');
                  FilterData();
               }, error: function(){
                  hide ();
               }
         });   

       
      return false;
   
  
  }
</script>