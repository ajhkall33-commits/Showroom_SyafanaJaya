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
   
.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}

.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}

.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
}

.modal-header {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 50px;
  padding: 10px;
  background: #6598d9;
  border: 0;
}

.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: #fff;
  line-height: 30px;
}

.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
}

.modal-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  height: 60px;
  padding: 10px;
  background: #f1f3f5;
}
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
   /* css  chekbok*/
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
   /* end css chekbox */
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
                          
                       
                              <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">No</th>
                                       <th class="cemter-t">Role Pengguna</th>
                                       <th class="cemter-t">Status</th>
                                       <th class="cemter-t">Aksi</th>
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
<div class="modal modal-fullscreen-xl" id="m-Role" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title cemter-t">Modal Full</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return SaveGroup(this)">
         <div class="modal-body">
        
        
            <div class="row">
               <div class="col-md-12">
                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label">Centang Semua</label>
                     <div class="col-sm-6">
                        <label class="container">
                           <input type="checkbox" class="check-form" onclick= 'checkUncheck(this)'>
                         
                                 <span class="checkmark"></span>
                        </label>
                     
                     </div>
                    
                  </div>
                 
               </div>
               <div class="col-md-12">
                  <table class="table table-condensed  table-bordered" id="t_role_menu">
                     <thead class="thead-blue">
                        <tr>
                           <th>Daftar Menu</th>
                           <th>Buat <input type="checkbox" id="create_modul" class="form-check-input check_group_column" module="create1"></th>
                           <th>Baca <input type="checkbox" id="read_modul" class="form-check-input check_group_column" module="read1"></th>
                           <th>Ubah <input type="checkbox" id="updaet_modul" class="form-check-input check_group_column" module="update1"></th>
                           <th>Hapus <input type="checkbox" id="dekete_modul" class="form-check-input check_group_column" module="delete1"></th>
                        </tr>
                     </thead>

                    
                     <tbody >
                       
                     </tbody>
                  </table>
               </div>
        
            </div>                     
           
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-success text-right">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          
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
    
      function FilterData(){
         show();
       
         $.ajax({
               url: "<?=base_url()?>role_user/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var no= "1";
                  jQuery.each(json['role'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                      
                                       <td>`+(no++)+`</td>
                                       <td>`+(val['name_role'] == null ? '': val['name_role'])+`</td>
                                       <td>`+(val['status'] == null ? '': val['status'])+`</td>
                                      
                                       <td>
                                          <button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(`+val['id']+`)"><i class="feather icon-edit"></i></button>
                                          <button class="btn waves-effect waves-light btn-danger btn-icon" onclick="Delete(`+val['id']+`)"><i class="fa fa-trash"></i></button>
                                       
                                       </td>
                                    </tr>`;
                  });
                
                  $('#tabel-data > tbody:last-child').html(header_table);
                  console.log(header_table);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
    
      // function MenuParent(){
      //    $.ajax({
      //          url: "<?=base_url()?>menu_aplikasi/LoadDataParent",
      //          type: 'post',
      //          // data: formData,
      //          contentType: false,
      //          processData: false,

      //          success: function(r){
      //             var json = JSON.parse(r);
                
      //             var row = ` <option value=""></option>`;
      //             jQuery.each(json['ms'], function( i, val ) {

      //                row +=`  <option value="`+val['idmenu']+`">`+val['name']+`</option>`;
      //             });
      //             $('#parent').html(row);
      //             hide ();
      //          }, error: function(){
      //             hide ();
      //          }
      //    });   
      //    return false;
      // }
  
    
    function EditData(id){
      // show();
      $('#m-Role').modal('show');
      $('#m-Role').find('.modal-title').html('Akses Pengguna');   
      $('#m-Role').find('form').attr('onsubmit','return SaveData(this,'+id+')');
      LoadMenu(id);

    }
   function LoadMenu(id){
      $.ajax({
               url: "<?=base_url()?>role_user/LoadMenu/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "";

                  jQuery.each(json, function( i, val ) {
                     var rowCount = i;
                     row +=` <tr>
                           <td>
                              <label>`+val['name']+`</label>
                              <input type="hidden" name="newdata[`+rowCount+`][idmenu]" value="`+val['idmenu']+`">
                           </td>
                           <td>
                              <label class="container">
                                 <input type="checkbox" class="check-form" name="newdata[`+rowCount+`][create]" value="1" `+(val['controle_create']==1 ? 'checked': '')+`>
                                 <span class="checkmark"></span>
                              </label>
                             
                           </td>
                           <td>
                              <label class="container">
                                 <input type="checkbox" class="check-form" name="newdata[`+rowCount+`][read]" value="1" `+(val['controle_read']==1 ? 'checked': '')+`>
                                 <span class="checkmark"></span>
                              </label>
                             
                           </td>
                           <td>
                              <label class="container">
                                 <input type="checkbox" class="check-form" name="newdata[`+rowCount+`][update]" value="1" `+(val['controle_update']==1 ? 'checked': '')+`>
                                 <span class="checkmark"></span>
                              </label>
                            
                           </td>
                           <td>
                              <label class="container">
                                 <input type="checkbox" class="check-form" name="newdata[`+rowCount+`][delete]" value="1" `+(val['controle_delete']==1 ? 'checked': '')+`>
                                 <span class="checkmark"></span>
                              </label>
                              
                           </td>
                        </tr>`;
                  });


                
                  $('#t_role_menu > tbody:last-child').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
   }
   function checkUncheck(checkBox) {
      get = document.getElementsByClassName('check-form');
      for(var i=0; i<get.length; i++) {
         get[i].checked = checkBox.checked;
      }

   }

   function SaveData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('role_user/')?>SaveData/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            $(f)[0].reset(); 
            $('#m-Role').modal('hide');
            NF(json);
           FilterData();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }


</script>