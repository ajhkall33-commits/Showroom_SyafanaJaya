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
   .ct-l{
   line-height: 1;
   padding-top: calc(0.6rem + 1px);
   padding-bottom: calc(0.375rem + 1px);
   }
   .center-t{
   text-align: center;
   }
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
   background-color: #dee2e6;
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
               <h3><?=$title?></h3>
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
                           <button type="button" class="btn btn-primary" onclick="AddData()">Buat Perbaikan</button>
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
                        <div class="table-responsive">
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                              <thead class="thead-blue">
                                 <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">Tanggal</th>
                                    <th class="cemter-t">Jumlah Tinjutan</th>
                                    <th class="cemter-t">Status</th>
                                    <th class="cemter-t">Action</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
                              </tbody>
                           </table>
                           <div>
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
            <form method="post"   onsubmit="return SaveData(this)">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Team</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="team" name="team" required>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pelaksana Pekerjaan</label>
                        <div class="col-sm-8">
                           <select class="js-example-basic-multiple js-states form-control" id="id_user" name="id_user[]" multiple="multiple" required style="width: 80%;">
                              <option value=""></option>
                              <?php foreach ($pelaksana as $pelaksana): ?>
                              <option value="<?=$pelaksana['nama']?>"><?=$pelaksana['nama']?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal:</label>
                        <div class="col-sm-8">
                           <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <table class="table table-condensed table-striped table-bordered" id="tabel-CM">
                        <thead class="thead-blue">
                           <tr>
                              <th class="cemter-t">Pilih</th>
                              <th class="cemter-t">Peralatan</th>
                           </tr>
                        </thead>
                        <tbody >
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- End Modal Request tiket -->
<!-- modal untuk view  -->
<div class="modal fade" id="m-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-group row">
               <label class="col-sm-4 col-form-label">Hari/Tanggal</label>
               <span class="col-md-8 f-w-700 ct-l" id="v_tanggal">aaasd asd sad</span>
            </div>
            <div class="form-group row">
               <label class="col-md-4 col-form-label">Shift Kerja</label>
               <span class="col-md-8 f-w-700 ct-l" id="v_shift">aaasd asd sad</span>
            </div>
            <div class="form-group row">
               <label class="col-md-4 col-form-label">Team</label>
               <span class="col-md-8 f-w-700 ct-l" id="v_team">aaasd asd sad</span>
            </div>
            <div class="form-group row">
               <label class="col-md-4 col-form-label">Lokasi</label>
               <span class="col-md-8 f-w-700 ct-l" id="v_lokasi">aaasd asd sad</span>
            </div>
            <div class="form-group row">
               <label class="col-md-4 col-form-label">Jam Mulai</label>
               <span class="col-md-8 f-w-700 ct-l" id="v_jam">aaasd asd sad</span>
            </div>
            <div class="form-group row">
               <label class="col-md-4 col-form-label">Pelaksana Pekerjaan </label>
               <ol id="v_pelaksana">
               </ol>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <table class="table table-condensed table-striped" id="tabel-ViewDetail">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Waktu</th>
                           <th>Lokasi</th>
                           <th>Masalah</th>
                           <th>Penyelesaian</th>
                        </tr>
                     </thead>
                     <tbody >
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
      </div>
   </div>
</div>
<!-- end modal view  -->
<script>
   $(document).ready(function() {
      $('.js-example-basic-single').select2({
         theme: 'bootstrap',
         dropdownCssClass: 'select2-dropdown--scroll'
      });
   });
   $(document).ready(function() {
      $('.js-example-basic-multiple').select2({
         theme: 'bootstrap',
         dropdownCssClass: 'select2-dropdown--scroll'
      });
   });
   FilterData();
   function FilterData(id) {
         show();
         var formData = new FormData();
         formData.append('limit',  $('#limitData').val());
         formData.append('src',  $('#srcData').val());
         var id =(id == null ? 0: id);
         $.ajax({
         url: "<?=base_url()?>tiket/LoadData/"+id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (r) {
               var json = JSON.parse(r);
               var row = "";
               var no =1;
               jQuery.each(json['data'], function (i, val) {
                  var BTN ='';
                  var waitingButton = `<button class="btn waves-effect waves-light btn-info btn-icon" title="Send Request" onclick="Waiting(` + val['id_tiket'] + `)"><i class="fa fa-check-circle"></i></button>`;
                  //var approveButton = '<button class="btn waves-effect waves-light btn-warning btn-icon" title="Approve" onclick="Approve(' + val['id_tiket'] + ')"><i class="fa fa-check"></i></button>';
                  var editButton    = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData(`+ val['id_tiket'] +`)"><i class="feather icon-edit"></i></button>`;
                  var rejectButton  = `<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="Deleted(`+ val['id_tiket'] + `)"><i class="fa fa-trash"></i></button>`;
                  var viewData      = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="View" onclick="ViewData(`+ val['id_tiket'] + `)"><i class="feather icon-eye"></i></button>`;
                  var viewData2     = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="View" onclick="ViewData2(`+ val['id_tiket'] + `)"><i class="feather icon-eye"></i></button>`;
                  var prosesData    = `<button class="btn waves-effect waves-light btn-primary btn-icon" title="Proses Data" onclick="ConfirmData(`+ val['id_tiket'] +`,'proses')"><i class="fa fa-gear"></i></button>`;
                  var delBtn        = `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmData(`+val['id_tiket']+`,'delete')"><i class="fa fa-trash"></i></button>`;
                  var print         = '<a href="<?=base_url()?>tiket/PrintTiket/' + val['id_tiket'] + '" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>';
                  // Tambahkan kondisi untuk menyembunyikan tombol Waiting jika status sudah diapprove
                  if (val['status'] === '0') {
                     BTN = editButton+prosesData+delBtn;
                  }else if (val['status'] === '9') {
                     BTN = viewData+print; 
                  } else if (val['status'] === '1') {
                     BTN = viewData; 
                  } else if (val['status'] === '2') {
                  
                  }else if (val['status'] === '0'){
                     BTN = editButton+prosesData;
                  }
                  row += `<tr>
                     <td>${no}</td>
                     <td>${val['tanggal_label'] || ''}</td>
                      <td>${val['jumlah'] || ''}</td>
                     <td>${val['status_label'] || ''}</td>
                     <td>
                           ${BTN}
                           
                     </td>
                  </tr>`;
                  no++;
               });
               $('#data-pag').html(json['pag']['label']);
               $('#tabel-data > tbody:last-child').html(row);
               hide();
         },
         error: function () {
               hide();
         }
         });
      return false;
   }
   
   
   function ResetFormModal() {
      //$('#pembuat').val('').prop('disabled', false);
      $('#tanggal').val('');  
      
      //$('#upload_before').val('');
      
   }
   
   
   function AddData(){
         // show();
         ResetFormModal();
   
         $('#requestModal').modal('show');
         $('#requestModal').find('.modal-title').html('Buat Tiket Baru');   
         $('#requestModal').find('form').attr('onsubmit','return SaveData(this)');
         $('#submitBtn').html('Request Tiket');
      
         LoadCM('');
   }
   
   function LoadCM(id){
      $.ajax({
         url: "<?=base_url()?>Tindaklanjut/GetDataTinjut/"+id,
         type: 'post',
         success: function(r){
            var json = JSON.parse(r);
            var row ='';
            jQuery.each(json, function (i, val) {
               row +=`  <tr>
                           <td>
                              <label class="container">
                                    <input type="checkbox" class="check-form" name="newdata[`+i+`][id_tinjut]" value="`+val['id_tinjut']+`" `+(val['checked']==1 ? 'checked': '')+`>
                                    <span class="checkmark"></span>
                              </label>
                              
                           </td>
                           <td>
                              <label>`+val['fasilitas']+`</label>
                           
                           </td>
                        </tr>`
   
            });
   
            $('#tabel-CM > tbody:last-child').html(row);
         
         },
         error: function(){
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
            url:  '<?=base_url('tiket/')?>SaveData',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r){
               var json = JSON.parse(r);
               NF(json);
               hide(); 
               $('#requestModal').modal('hide');
               ResetFormModal();
               $('#tabel-CM > tbody:last-child').html("");
               FilterData();
            }, error: function(){
               hide(); 
            }
         });
         return false;
   }
   
   
   
   function ConfirmData(id,tipe){
      var tit = '';
      var des = '';
      if (tipe == 'proses') {
         tit = "Proses Data";
         des = "Apakah Data Sudah Benar Untuk Diproses Lebih Lanjut?";
      }else if (tipe == 'delete'){
         tit = 'Hapus Data'
         des = "Apakah Sudah Yakin untuk Menghapus Data ini?";
      }
      cuteAlert({
         type: "question",
         title: tit,
         message: des,
         confirmText: "Okay",
         cancelText: "Cancel"
      }).then((e)=>{
         if ( e == ("confirm")){
            // ProsesData(id);
            (tipe =='proses' ? ProsesData(id): DeleteData(id))
         } 
               
      })
   }
   
   function UpdateData(f,id){
      show();
         var formData = new FormData($(f)[0]);
         // formData.append('id', id);
         $.ajax({
            url:  '<?=base_url('tiket/')?>UpdateData/'+id,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(r){
               var json = JSON.parse(r);
               NF(json);
              
               $('#requestModal').modal('hide');
               ResetFormModal();
               $('#tabel-CM > tbody:last-child').html("");
               FilterData();
               hide(); 
            }, error: function(){
               hide(); 
            }
         });
         return false;
   }
   
   
   function EditData(id){
       show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Edit Tiket');   
      $('#requestModal').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
     
      $.ajax({
               url: "<?=base_url()?>Tiket/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,
   
               success: function(r){
                
                  var json = JSON.parse(r);
                  var row  ='';
                  $('#tanggal').val(json['tanggal']);  
                  LoadCM(id);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         
         return false;
   }
   
   function ProsesData(id){
   
      $.ajax({
         url: '<?= base_url('Tiket/ProsesData/') ?>' + id,
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            NF(json);
            FilterData();
         }, error: function(){
         hide();
         }
      });
   
   }
   
   function DeleteData(id){
   
      $.ajax({
         url: '<?= base_url('Tiket/DeleteData/') ?>' + id,
         type: 'post',
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            NF(json);
            FilterData();
         }, error: function(){
         hide();
         }
      });
   
   }
   
   function ViewData(id){
   
      $('#m-detail').modal('show');
      $('#m-detail').find('.modal-title').html('Detail Perbaikan');   
   
      $.ajax({
         url: "<?=base_url()?>Tiket/ViewData/"+id,
         type: 'post',
         success: function(r){
      
               var json = JSON.parse(r);
               $('#v_tanggal').html(json['data']['tanggal']);
               $('#v_shift').html(json['data']['shift_l']['name']);
               $('#v_team').html(json['data']['team']);
               $('#v_lokasi').html('');
               $('#v_jam').html(json['data']['shift_l']['jam']);
              
               var ol = '';
               jQuery.each(json['data']['pelaksana'], function( i, val ) {
                  ol +=   `<li>`+val+`</li>`;
              
               });
               $('#v_pelaksana').html( ol);// 
   
               var row='';
               var no=1;
               jQuery.each(json['data']['detail'], function( i, val ) {
                  row +=   `<tr>
                              <td>${no}</td>
                              <td>`+val['waktu']+`</td>
                              <td>`+val['nama_terminal']+`</td>
                              <td>`+val['nama_masalah']+`</td>
                              <td>`+val['penyelesaian']+`</td>
                           </tr>`;
               no++;
               });
               
               $('#tabel-ViewDetail > tbody:last-child').html(row);
               console.log(row);
                // LoadFasilits(json['id_fasilitas']);
         },
         error: function(){
               hide();
         }
      });
   
   
      return false;
   }
</script>