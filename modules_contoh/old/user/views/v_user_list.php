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

   .mt-s {
      margin-top: 15px;
   }
   /* css upload */


.image_picker {
    height: 150px;
    width: 100%;
    border: 1px #ddd solid;
    border-radius: 0px;
    background: #f5f5f5;
    text-align: center;
    display: table;
    color: #999;
    transition: .3s;
}
.image_picker i {
    font-size: 40px;
}
.image_picker div {
    display: table-cell;
    text-align: center;
    vertical-align: middle;
}
.d-none {
    display: none!important;
}

/* end css upload */
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
                                    <a class="btn btn-primary" onclick="Upload()"><i class="fa fa-file-excel-o "></i> Upload Data</a>
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
                                       <td>NO</td>
                                       <td>UNIT</td>
                                       <td>USERNAME</td>
                                       <td>NAMA</td>
                                       <td>EMAIL</td>
                                       <td>NIK</td>
                                       <td>ROLE</td>
                                       <td>STATUS</td>
                                       <td>ACTION</td>
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


<div class="modal fade" id="m-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                   <label class="col-sm-2 col-form-label">Username </label>
                   <div class="col-sm-6">
                      <input type="text" class="form-control" name="username" id="username" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Password </label>
                   <div class="col-sm-6">
                      <input type="password" class="form-control" name="password" id="password" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Nama </label>
                   <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama" id="nama" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">nik</label>
                   <div class="col-sm-10">
                      <input type="text" class="form-control" name="nik" id="nik" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">email</label>
                   <div class="col-sm-10">
                      <input type="text" class="form-control" name="email" id="email" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Contak Phone</label>
                   <div class="col-sm-10">
                      <input type="text" class="form-control" name="no_hp" id="no_hp" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">tanggal_lahir</label>
                   <div class="col-sm-10">
                      <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" >
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Unit</label>
                   <div class="col-sm-10">
                        <select class="form-control" name="unit_kerja"  id="unit_kerja">
                        <?php foreach ($units as $key => $value): ?>
                           <option value="<?=$value['id_unit']?>"><?=$value['kode_unit']?></option>
                        <?php endforeach ?>
                        </select>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">type_user</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="type_user"  id="type_user">
                         <option value="1">Organik</option>
                         <option value="2">OM</option>
                      </select>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Unit</label>
                   <div class="col-sm-10">
                        <select class="form-control" name="status" id="STATUS">
                          <option value="1">ACTIVE</option>
                          <option value="0">INACTIVE</option>
                        </select>
                       
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
<div class="modal fade" id="m-uploader" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Menambahkan File Loader</h5>
         </div>
         <form onsubmit="return UploaderData(this)">
            <div class="modal-body p-0">
               <!-- CROP PANEL -->
               <div class="crop-panel" style="display:none">
                  <div class="text-center">
                     <div class="p-4 btn-group">
                        <button type="button" onclick="cancel_crop()" class="no-otl btn btn-pill btn-sm btn-secondary"> <i class="fe fe-x"></i> Batal </button>
                     </div>
                  </div>
               </div>
               <!--/ CROP PANEL -->
               <div class="image_picker" onclick="$('#inputFile').click()">
                  <div> <i class="fa fa-fw fa-cloud-upload"></i> <br>
                     Klik untuk memilih file <br> Atau seret dan lepaskan file loader disini 
                  </div>
               </div>
               <input id="inputFile" name="filelampiran" type="file" class="d-none" onchange="setUploader(this)" accept=".xls,.xlsx"/>
               <div class="p-4" id="input_group" style="display:none">
                  <div class="row ">
                     <div class="col-md-12">
                        <div class="row">
                       
                           <label class="col-sm-2 control-label">File</label>
                           <div class="col-sm-8">
                              <input type="text" readonly class="form-control" placeholder="File" id="name_file">
                              <div class="btn-group mt-s ">
                                 <button type="button" onclick="$('#inputFile').click()" class="btn btn-sm btn-info no-otl"><i class="fa fa-folder-o fa-fw"></i><span class="sm-hide">Pilih File</span> </button>
                                 <button type="button" onclick="remove_photo()" class="btn btn-sm btn-warning no-otl"><i class="fa fa-trash fa-fw"></i> <span class="sm-hide">Delete File</span> </button>
                              </div>
                           </div>
                        
                        </div>
                        
                     </div>
                     
                     <br>
                  </div>
                  <div class="row mt-s">
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label" >Unit</label>
                           <div class="col-sm-10">
                           
                                 <select class="form-control" name="id_unit" id="id_unit">
                                    <?php foreach ($units as $key => $value): ?>
                                    <option value="<?=$value['id_unit']?>"><?=$value['kode_unit']?></option>
                                    <?php endforeach ?>
                                 </select>
                              
                           </div>
                        </div>
                     </div>
                     
                  </div>
                  <div class="row mt-s">
                     <div class="col-md-12">
                        <div class="form-group row">
                           <label class="col-sm-2 col-form-label" >User Type</label>
                           <div class="col-sm-10">
                                 <select class="form-control" name="type_user" id="type_user">
                                 <option value="1">Organik</option>
                                 <option value="2">OM</option>
                                 </select>
                              
                           </div>
                        </div>
                     </div>
                     
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
               url: "<?=base_url()?>user/LoadData/"+id,
               type: 'post',
               data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "";
                  jQuery.each(json['data'], function( i, val ) {
                     console.log(val['name_role']);
                     row +=`<tr >
                                       <td >`+val['id']+`</td>
                                       <td >`+val['unit']+`</td>
                                       <td >`+(val['username'] == null  ? '': val['username'])+`</td>
                                       <td >`+(val['nama'] == null      ? '': val['nama'])+`</td>
                                       <td >`+(val['email'] == null     ? '': val['email'])+`</td>
                                       <td >`+(val['nik'] == null       ? '': val['nik'])+`</td>
                                       <td >`+(val['name_role'] ==null  ? '': val['name_role'])+`</td>
                                       <td >`+(val['status'] ==1 ? '<span style="color:#40e540"><i class="fa fa-circle" style="font-size: 10px;" aria-hidden="true"></i>&nbsp;ACTIVE</span>': 'RTO')+`</td>
                                       
                                       <td >
                                          <a title="View/assign role" class="btn btn-success btn-sm btn-view" onclick="ViewData()"><i class="fa fa-eye"></i></a>
                                        <a title=\"Edit\" class=\"btn btn-primary btn-sm btn-edit\" onclick="EditData(`+val['id']+`)"><i class=\"fa fa-pencil\"></i></a>
                                        <a title=\"Hapus\" class=\"btn btn-danger btn-sm btn-delete\" onclick="DeleteData()"><i class=\"fa fa-trash\"></i></a></td>
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
   
    
    
    function AddData(){
      // show();
      $('#m-user').modal('show');
      $('#m-user').find('.modal-title').html('3');   
      $('#m-user').find('form').attr('onsubmit','return SaveData(this)');
      LoadRole();
    }

    function Upload(){
      // show();
      $('#m-uploader').modal('show');
      $('#m-uploader').find('.modal-title').html('Upload Data User');   
      $('#m-uploader').find('form').attr('onsubmit','return UploadData(this)');
      LoadRole();
    }

    function UploadData(f){
      show();
      var formData = new FormData($(f)[0]);
      $.ajax({
         url:  '<?=base_url('user/')?>UploadData/',
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }
    function EditData(id){
      // show();
      $('#m-user').modal('show');
      $('#m-user').find('.modal-title').html('Edit User');   
      $('#m-user').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      $.ajax({
               url: "<?=base_url()?>user/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){

                  var json = JSON.parse(r);
                  $('#username').val(json['username']);  
                  $('#nama').val(json['nama']);  
                  $('#nik').val(json['nik']);  
                  $('#email').val(json['email']);  
                  $('#no_hp').val(json['no_hp']);  
                  LoadRole();
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

    }


    function UpdateData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('user/')?>UpdateData/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            $('#m-user').modal('hide');
          
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
         url:  '<?=base_url('user/')?>SaveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
          
            FilterData()
            // ViewDetail(id,date);
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

function LoadUnit(){

   $.ajax({
               url: "<?=base_url()?>Unit/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "";
                  jQuery.each(json['ms'], function( i, val ) {
                     
                     row +=`<option value="`+val['id_unit']+`">`+val['kode_unit']+`</option>`;
                  });
                
                  $('#id_unit').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
}
function remove_photo(){
   $dropzone.fadeIn(300); $('#input_group').hide(0); $('input:file').val('');
   file_exist = false; $('.part-1').addClass('dizabled');
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
   // var confirm = document.getElementById("confirm");
   function Delete(id){
      cuteAlert({
         type: "question",
         title: "Confirm Title",
         message: "Confirm Message",
         confirmText: "Okay",
         cancelText: "Cancel"
      }).then((e)=>{
       
         if ( e == ("confirm")){
           
            DeleteAki(id);
         } 
      });
   }
      

   function LoadRole(){
      // show();
     
      $.ajax({
               url: "<?=base_url()?>role_user/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){

                  var json = JSON.parse(r);
                  var row = "";
                  jQuery.each(json['role'], function( i, val ) {
                     
                     row +=`<option value="`+val['id']+`">`+val['name_role']+`</option>`;
                  });
                  $('#type_user').html(row);
                
               }, error: function(){
                  hide ();
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
</script>