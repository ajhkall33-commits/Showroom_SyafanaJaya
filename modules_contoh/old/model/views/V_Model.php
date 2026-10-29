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
    text-align: center; 
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

   .image-preview-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .image-preview-modal img {
        max-width: 90%;
        max-height: 90%;
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
            <i class="icon feather icon-home bg-c-blue"></i>
               <div class="d-inline">
               <h5><?=$title?></h5>
               <span><?=$title_des?></span>
               </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title breadcrumb-padding">
               <li class="breadcrumb-item">
               <a href="<?=base_url()?>"><i class="feather icon-home"></i></a>
               </li>
               <li class="breadcrumb-item">
               <a><?=$title?></a>
               </li>
            </ul>
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
                                 <div class="pull-right m-b-10">
                                 <button type="button" class="btn btn-primary btn-round waves-effect waves-light m-b-10 m-r-20" data-action="expand-all" onclick="AddData()">Tambah Model</button>
                                    
                              </div>
                              </div>
                           </div>
                       
                              <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">id</th>
                                       <th class="cemter-t">Model</th>
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



<!-- Modal Request Tiket -->

<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">Request Tiket</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Form request -->
            <div class="container">
               <form method="post"  enctype="multipart" onsubmit="return saveData(this)">
                  <div class="mb-3">
				    <label>Merk :</label>
                    <select name="select" class="form-select form-control form-control-default">
						<option value="opt1">Pilih Merk 1</option>
						<option value="opt2">Pilih Merk 2</option>
					</select>
                  </div>
				  <div class="mb-3">
				    <label>Jenis Perangkat :</label>
                    <select name="select" class="form-select form-control form-control-default">
						<option value="opt1">Perangkat 1</option>
						<option value="opt2">Perangkat 2</option>
					</select>
                  </div>
				  <div class="mb-3">
                     <label>Model / Tipe Perangkat :</label>
                     <input type="text" class="form-control form-control-round" id="nama" name="nama" required>
                  </div>
                  <div>
                  <button type="submit" class="btn btn-primary btn-round pull-right">Submit</button>
                  </div>
               </form>
            </div>
            </div>
            </div>
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>
<!-- End Modal Request tiket -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

LoadData();

   function LoadData() {
      show();

      $.ajax({
         url: "<?=base_url()?>model/LoadData/",
         type: 'post',
         contentType: false,
         processData: false,

         success: function (r) {
               var json = JSON.parse(r);
               var row = "";

               jQuery.each(json, function (i, val) {
                  row += `<tr>
                     <td>` + (val['id'] == null ? '' : val['id']) + `</td>
                     <td>` + (val['nama'] == null ? '' : val['nama']) + `</td>
                     <td>
                           <button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(` + val['id'] + `)"><i class="feather icon-edit"></i></button>
                           <button class="btn waves-effect waves-light btn-danger btn-icon" onclick="Deleted(` + val['id'] + `)"><i class="fa fa-trash"></i></button>
                     </td>
                  </tr>`;
               });

               $('#tabel-data > tbody:last-child').html(row);

               // Initialize DataTables with pagination
               $('#tabel-data').DataTable();

               hide();
         },
         error: function (error) {
               console.error("Error fetching data:", error);
               hide();
         }
      });

      return false;
   }

   function AddData(){
      // show();
      $('#nama').val('');
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Tambah Model');   
      $('#requestModal').find('form').attr('onsubmit','return saveData(this)');

   }

   function saveData(f){
      show();
      var formData = new FormData($(f)[0]);
 
      $.ajax({
         url:  '<?=base_url()?>model/saveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
             $(f)[0].reset(); 

             $('#requestModal').modal('hide');
          
            LoadData();
         
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }
   
   function Deleted(id) {

      var confirmDelete = confirm("Apakah Anda yakin ingin menghapus data ini?");

      if (confirmDelete) {
         $.ajax({
            url: '<?= base_url('model/Delete/') ?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
            LoadData();
            hide();
            }, error: function(){
            hide();
            }
         });
      } else {
         return false;
      }
   }

   function EditData(id){
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Edit Menu');   
      $('#requestModal').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      
      $.ajax({
         url: "<?=base_url()?>model/EditData/"+id,
         type: 'post',
         success: function(r){
                  var json = JSON.parse(r);
                     $('#id').val(json['id']).prop('disabled', true);
                     $('#nama').val(json['nama']);  
         },
         error: function(){
               hide();
         }
      });
      return false;
   }

   function UpdateData(form,id) {
      var formData = $(form).serialize();

      $.ajax({
         url: "<?=base_url()?>model/UpdateData/"+id,  
         type: 'post',
         data: formData,
         success: function(response) {
               LoadData();  
            
               $('#requestModal').modal('hide');
         },
         error: function(xhr, status, error) {
      
               console.error("Error updating data");
               console.log("Status: " + status);
               console.log("Error: " + error);
               console.log("Response Text: " + xhr.responseText);
         }
      });

      return false;
   }

</script>
