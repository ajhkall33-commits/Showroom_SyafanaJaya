<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
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

   .center{
   vertical-align: middle;
   text-align: center;
}

   #deleteItemNama{
   color: red;
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
                       
                              <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">Nama Lokasi</th>
                                       <th class="cemter-t">Parent</th>
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
<div class="modal fade" id="m-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                   <label class="col-sm-2 col-form-label">Nama Menu</label>
                   <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_terminal" id="nama_terminal" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Parent</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="parent_id"  id="parent_id">
                         <option value=""></option>
                      </select>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Status</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="status"  id="status">
                         <option value="1">Active</option>
                         <option value="2">Inactive</option>
                      </select>
                   </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button class="btn btn-primary" onclick="Delete()">YA</button>
             </div>
          </form>
       </div>
    </div>
 </div>

  <!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            Apakah Anda yakin ingin menghapus <span id="deleteItemNama"></span>?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" id="btnConfirmDelete">Ya</button>
         </div>
      </div>
   </div>
</div>

<!-- Modal Notifikasi Item Dihapus -->
<div class="modal fade" id="NotifModal" tabindex="-1" role="dialog" aria-labelledby="deletedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletedModalLabel">Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
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
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
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
       
         $.ajax({
               url: "<?=base_url()?>master_lokasi/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var pag= "";
                  jQuery.each(json, function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                      
                                       <td class="center">`+val['nama_terminal']+`</td>
                                       <td class="center">`+(val['parent_id'] == null ? '': val['parent_id'])+`</td>
                                       <td class="center">`+ (val['label_status'] == null ? '' : val['label_status']) + `</td>
                                       <td class="center">
                                          <button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(`+val['id']+`)"><i class="feather icon-edit"></i></button>
                                          <button class="btn waves-effect waves-light btn-danger btn-icon" onclick="confirmDelete(`+val['id']+`, '` + val['nama_terminal'] + `')"><i class="fa fa-trash"></i></button>
                                       
                                       </td>
                                    </tr>`;
                  });
                
                  $('#tabel-data > tbody:last-child').html(header_table);

                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
    
      function MenuParent(){
         $.ajax({
               url: "<?=base_url()?>master_lokasi/LoadDataParent",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                
                  var row = ` <option value=""></option>`;
                  jQuery.each(json['m_lokasi'], function( i, val ) {

                     row +=`  <option value="`+val['id']+`">`+val['nama_terminal']+`</option>`;
                  });
                  $('#parent_id').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
  
    
    function AddData(){
      // show();
      $('#m-menu').modal('show');
      $('#m-menu').find('.modal-title').html('Tambah Menu Baru');   
      $('#m-menu').find('form').attr('onsubmit','return SaveData(this)');
      MenuParent();

    }

    function EditData(id){
      // show();
      MenuParent();
      $('#m-menu').modal('show');
      $('#m-menu').find('.modal-title').html('Edit Menu');   
      $('#m-menu').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      $.ajax({
               url: "<?=base_url()?>master_lokasi/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                
                  var json = JSON.parse(r);
                  $('#nama_terminal').val(json['nama_terminal']);  
                  $('#parent_id').val(json['parent_id']); 
                  $('#status').val(json['status']); 
                  
               
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
         url:  '<?=base_url('master_lokasi/')?>Delete/'+id,
       
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
         url:  '<?=base_url('master_lokasi/')?>Update/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
             $(f)[0].reset(); 
             $('#m-menu').modal('hide');

           FilterData();

           $('#NotifModal').modal('show');
           $('#NotifModal').find('.modal-body').html('Data berhasil diubah');
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
         url:  '<?=base_url('master_lokasi/')?>SaveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            $('#m-menu').modal('hide');
          
           FilterData();
           MenuParent();
         
           $('#NotifModal').modal('show');
           $('#NotifModal').find('.modal-body').html('Data berhasil ditambahkan');
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });

      return false;
   }


   function confirmDelete(id, nama_terminal) {
      $('#confirmModal').modal('show');
      $('#deleteItemNama').text(nama_terminal);

      // Fungsi untuk mengeksekusi delete jika tombol "Ya" ditekan
      $('#btnConfirmDelete').click(function() {
         $('#confirmModal').modal('hide');
         Delete(id);
         $('#NotifModal').modal('show');
         $('#NotifModal').find('.modal-body').html('Data berhasil dihapus');
      });
   }


</script>