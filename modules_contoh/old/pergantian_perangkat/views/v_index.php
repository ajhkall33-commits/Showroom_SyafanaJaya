

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

.lg-stat {
	width: 15px;
	height: 15px;
	border-radius: 50%;
}

.align-middle {
	padding-top: 2px;

	padding-left: 10px;
}

.modal-black {
	background-color: #131a22;
}

.modal-wt {
	color: #fff;
}

.pd-2 {
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

td,
th {
	white-space: normal;
}

.table thead th {
	border: 1px solid #d6dde1;
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

.table-bordered td,
.table-bordered th {
	padding: 10px;
}

.table .thead-dark th {
	color: #fff;
	background-color: #878888b8;
	border-color: #878d93f5;
}

.putih {
	color: #fff;
}

.select2-container--bootstrap .select2-selection--single {
	width: 300px;
}

.select2-dropdown--scroll {
	max-height: 200px;
	overflow-y: auto;
}

.select2-dropdown--scroll::-webkit-scrollbar {
	width: 0;
	height: 0;
}

/* Show scrollbar on hover */
.select2-dropdown--scroll:hover::-webkit-scrollbar {
	width: 10px;
	height: 10px;
}

/* Track */
.select2-dropdown--scroll::-webkit-scrollbar-track {
	background: #f1f1f1;
}

/* Thumb */
.select2-dropdown--scroll::-webkit-scrollbar-thumb {
	background: #888;
}

/* Thumb on hover */
.select2-dropdown--scroll::-webkit-scrollbar-thumb:hover {
	background: #555;
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

.table td,
.table th {
	padding: .25rem 0.75rem;
}

.select2-container {
	width: 100%;
	border: 1px solid #ccc;
}

/* Css Modal Fullscrean */


.modal-header {
	background: #6598d9;
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
                                 <button type="button" class="btn btn-primary" onclick="AddData()"> Request Tiket</button>
                                 </div>
                              </div>
                           </div>
                       
                           <div class="table-responsive">   
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">No</th>
                                       <th class="cemter-t">Tanggal Pergantian</th>
                                       <th class="cemter-t">Lokasi</th>
                                       <th class="cemter-t">Sub Lokasi</th>
                                       <th class="cemter-t">Fasilitas</th>
                                       <th class="cemter-t">Keterangan</th>
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
               </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>


<!-- Modal Request Tiket -->

<div class="modal modal-fullscreen-xl" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">Request Tiket</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Form request -->
            <form method="post"  enctype="multipart" onsubmit="return SaveData(this)">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pembuat:</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="pembuat" name="pembuat" value="<?=sess()['nama']?>" disabled>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Fasilitas:</label>
                        <div class="col-sm-8">
                           <select class="form-control js-example-basic-single" id="id_fasilitas" name="id_fasilitas" required>
                              <!-- <option selected>Pilih Fasilitas</option> -->
                              <?php foreach ($fasilitas as $fasilitas): ?>
                              <option value="<?= $fasilitas['id_fasilitas'] ?>"><?= $fasilitas['nama_fasilitas'] ?>-<?= $fasilitas['ip_address'] ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal Pergantian:</label>
                        <div class="col-sm-3">
                           <input type="datetime-local" class="form-control" id="tanggal_pergantian" name="tanggal_pergantian" required>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alasan Pergantian Perangkat:</label>
                        <div class="col-sm-8">
                           <textarea class="form-control" id="keterangan" name="description" rows="4" placeholder="Masukkan keterangan tiket"></textarea>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Organik :</label>
                        <div class="col-sm-8">
                           <select class="form-control js-example-basic-single" id="id_organik" name="id_organik" required>
                              <!-- <option selected>Pilih Fasilitas</option> -->
                              
                           </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Team Leader :</label>
                        <div class="col-sm-8">
                           <select class="form-control js-example-basic-single" id="id_leader" name="id_leader" required>
                              <!-- <option selected>Pilih Fasilitas</option> -->
                             
                           </select>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Upload Leader :</label>
                        <div class="col-sm-8">
                           <input type="file" id="tes" name="tes"  accept=".jpg, .png, .jpeg">
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Maintenance Planner :</label>
                        <div class="col-sm-8">
                           <select class="form-control js-example-basic-single" id="id_planer" name="id_planer" required>
                              <!-- <option selected>Pilih Fasilitas</option> -->
                           </select>
                        </div>
                     </div>
                    
                  </div>
               </div>
               <hr>   <hr>
               <div class="row">
                  <div class="col-md-12">
                     <div class="row mb-10">
                        <div class="col-md-10">
                           <h6>Detail Fasilitas</h6>
                        </div>
                        <div class="col-md-2">
                           <a class="btn waves-effect waves-light btn-info btn-icon2" onclick="AddPerangkat()"><i class="feather icon-plus-circle"></i></a>
                          
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <table class="table table-condensed table-striped" id="tabel-perangkat">
                        <thead class ="thead-blue">
                           <tr>
                              <th rowspan="2" class="cemter-t">Jenis Perangkat</th>
                              <th colspan="2" class="cemter-t">Perangkat Lama</th>
                              <th colspan="2" class="cemter-t">Perangat Pengganti</th>
                              <th colspan="4" class="cemter-t">Documentasi</th>
                              <th rowspan="2" class="cemter-t">Action</th>
                           </tr>
                           <tr>
                              <th style="width:15%" class="cemter-t">Perangkat Awal</th>
                              <th style="width:10%" class="cemter-t">Keterangan Awal</th>
                              <th style="width:18%" class="cemter-t">Perangkat Pengganti</th>
                              <th style="width:10%" class="cemter-t">Keterangan Pengganti</th>
                              <th style="width:7%" class="cemter-t">Sebelum</th>
                              <th style="width:7%" class="cemter-t">Proses</th>
                              <th style="width:7%" class="cemter-t">SN Baru</th>
                              <th style="width:7%" class="cemter-t">Hasil</th>
                             
                           </tr>
                        </thead>
                        <tbody id="new_perangkat"></tbody>
                     </table>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                  <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  </div>
               </div>
               
            </form>
            
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>
<!-- End Modal Request tiket -->



<!-- Modal Pemberian Tanda Tangan -->
<div class="modal fade" id="TTDModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form onsubmit="return SaveGroup(this)">
            <div class="modal-body">
               
                  <div id="signArea" >
									<h2 class="tag-ingo">Put signature below,</h2>
									<div class="sig sigWrapper" style="height:auto;">
										<div class="typed"></div>
										<canvas class="sign-pad" id="sign-pad" width="900" height="600"></canvas>
									</div>
								</div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" id="clear">Reset</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
               </div>
            </div>
           
         </form>
         </div>
      </div>
   </div>
</div>


<!-- End Modal -->




<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


   
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<link href="<?=base_url()?>assets/sig/css/jquery.signaturepad.css" rel="stylesheet">
<script src="<?=base_url()?>assets/sig/js/numeric-1.2.6.min.js"></script> 
<script src="<?=base_url()?>assets/sig/js/bezier.js"></script>
<script src="<?=base_url()?>assets/sig/js/jquery.signaturepad.js"></script> 

<script type='text/javascript' src="<?=base_url()?>assets/sig/js/html2canvas.js"></script>

<script>
$(document).ready(function() {
		var tes =	$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:100});
      console.log(tes);
});
$(document).ready(function() {
    $('.js-example-basic-single').select2({
        theme: 'bootstrap',
        dropdownCssClass: 'select2-dropdown--scroll'
    });
});

var sig = 	$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:100});
    $('#clear').click(function(e) {
      const context = canvas.getContext('2d');
      context.clearRect(0, 0, canvas.width, canvas.height);
       
    });

    LoadData();

   function LoadData() {
      show();

      $.ajax({
         url: "<?=base_url()?>pergantian_perangkat/LoadData",
         type: 'post',
         contentType: false,
         processData: false,
         success: function (r) {
               var json = JSON.parse(r);
               var row = "";
               var no = 1;
               jQuery.each(json, function( i, val ) {
                  row +=`<tr >
                           <td>` +(no++) + `</td>
                           <td>` +val['tanggal_pergantian'] + `</td>
                           <td>` +val['lokasi'] + `</td>
                           <td>` +val['sub_lokasi'] + `</td>
                           <td>` +val['nama_fasilitas'] + `</td>
                           <td>` +val['description'] + `</td>
                           <td>
                           <a href="<?base_url()?>pergantian_perangkat/PrintData/`+val['id_change']+`" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>
                           <a href="<?base_url()?>pergantian_perangkat/PrintDataApproval/`+val['id_change']+`" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>
                           <a class="btn waves-effect waves-light btn-primary btn-icon" onclick="TTDFile()"><i class="fa fa-print"></i></a>
                           
                           </td>
                        </tr>`;
               });
               $('#tabel-data > tbody:last-child').html(row);
               hide();
         },
         error: function () {
               hide();
         }
      });
      return false;
   }




    function AddData(){
      // show();
      ResetFormModal();

      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Pergantian Perangkat');   
      $('#requestModal').find('form').attr('onsubmit','return SaveData(this)');
      $('#submitBtn').html('Save');
      
      LoadUser();
    }

    function LoadUser(id){
   
         show();
         $.ajax({
               url: "<?=base_url()?>pergantian_perangkat/LoadUser",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "<option value=''>Pilih User</option>";
                  jQuery.each(json['AP2'], function( i, val ) {
                     row +=` <option value="`+val['id']+`" >`+val['nama']+` - `+val['nik']+`</option>`;
                  });

                  jQuery.each(json['ASMEN'], function( i, val ) {
                     row +=` <option value="`+val['id']+`" >`+val['nama']+` - `+val['inikd']+`</option>`;
                  });
                  var row_lt = "<option value=''>Pilih User</option>";
                  jQuery.each(json['LT'], function( i, val ) {
                     row_lt +=` <option value="`+val['id']+`" >`+val['nama']+` - `+val['inikd']+`</option>`;
                  });

                  var row_MT = "<option value=''>Pilih User</option>";
                  jQuery.each(json['MT'], function( i, val ) {
                     row_MT +=` <option value="`+val['id']+`" >`+val['nama']+` - `+val['inikd']+`</option>`;
                  });
                
                  $('#id_organik').html(row);
                  $('#id_leader').html(row_lt);
                  $('#id_planer').html(row_MT);
                  
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    
    }

    function SaveData(f){
      show();
      var formData = new FormData($(f)[0]);
 
      $.ajax({
         url:  '<?=base_url('pergantian_perangkat/')?>SaveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            //  $(f)[0].reset(); 

            //  $('#requestModal').modal('hide');
          
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
            url: '<?= base_url('tiket/Delete/') ?>' + id,
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



function ResetFormModal() {
    //$('#pembuat').val('').prop('disabled', false);
    $('#unit').val('');  
    $('#id_fasilitas').val('');  
    $('#lokasi').val(''); 
    $('#sublokasi').val(''); 
    $('#date_start').val('').prop('disabled', false);
    $('#keterangan').val('');
    //$('#upload_before').val('');
    
}

function EditData(id){
    $('#requestModal').modal('show');
    $('#requestModal').find('.modal-title').html('Edit Menu');   
    $('#requestModal').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
    $('#submitBtn').html('Edit Request');
    LoadFasilits();
    
    $.ajax({
        url: "<?=base_url()?>tiket/EditData/"+id,
        type: 'post',
        success: function(r){
               var json = JSON.parse(r);
                  $('#pembuat').val(json['create_by']).prop('disabled', true);
                  $('#unit').val(json['kode_unit']);  
                  $('#id_unit').val(json['id_unit']); 
                  $('#id_fasilitas').val(json['id_fasilitas']);
                  $('#lokasi').val(json['nama_terminal']);  
                  $('#id_lokasi').val(json['id_lokasi']); 
                  $('#sublokasi').val(json['nama_sublokasi']); 
                  $('#id_sublokasi').val(json['id_sublokasi']); 
                  $('#date_start').val(json['create_date']).prop('disabled', true);
                  $('#keterangan').val(json['description']); 
                  LoadFasilits(json['id_fasilitas']); 

                  var label = document.querySelector('.custom-file-label');
                  label.textContent = json['foto_before'];

        },
        error: function(){
            hide();
        }
    });
    return false;
}

function ViewData(id){
    $('#requestModalView').modal('show');
    $('#requestModalView').find('.modal-title').html('Details');   
    //$('#requestModalView').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
    
    
    $.ajax({
        url: "<?=base_url()?>tiket/ViewData/"+id,
        type: 'post',
        success: function(r){
               var json = JSON.parse(r);
                  $('#pembuat1').text(json['create_by']);
                  $('#unit1').text(json['kode_unit']);  
                  $('#fasilitas1').text(json['nama_fasilitas']);  
                  $('#lokasi1').text(json['nama_lokasi']);  
                  $('#sublokasi1').text(json['nama_sublokasi']); 
                  $('#date_start1').text(json['create_date']);
                  $('#keterangan1').text(json['description']); 
                  //$('#upload_before').parent().parent().hide();
                  //$('#submitBtn').hide(); 
               
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
        url: "<?=base_url()?>tiket/UpdateData/"+id,  
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

$('#requestModalViewBanyak').on('hidden.bs.modal', function (e) {
    $('#dynamic_content').empty();
});

$('body').on('change','.jenisbefore', function() {
  
   if($(this).val() != ''){
         var id=$(this).val();
         Perangkat(id,'id_perangkatbefore'+$(this).data("id"),'','','');
         Perangkat(id,'id_perangkatafter'+$(this).data("id"),'','','');
   }
});


function AddPerangkat(){
      // var new_chq_no = parseInt($('#total_chq').val()) + 1;
      var rowCount =  $('#tabel-perangkat > tbody tr').length;
     
      JenisPerangkat('id_jenisbefore'+rowCount);
      JenisPerangkat('id_jenisafter'+rowCount);
     
      var new_input = ` 
      <tr >
         <td>
            <select class="form-control js-example-basic-single jenisbefore" id="id_jenisbefore`+rowCount+`" name="Newitems[`+rowCount+`][id_jenisbefore]" data-id="`+rowCount+`" aria-hidden="true" data-select2-id="id_lokasi">
               <option value=""></option>  
            </select>
         </td>
         <td>
            <select class="form-control js-example-basic-single perangkat_clas" id="id_perangkatbefore`+rowCount+`" name="Newitems[`+rowCount+`][id_perangkatbefore]" data-id="`+rowCount+`" aria-hidden="true" data-select2-id="id_lokasi">
               <option value=""></option>  
            </select>
         </td>
         <td>
            <textarea class="form-control" id="keterangan_before`+rowCount+`" name="Newitems[`+rowCount+`][keterangan_before]" rows="2" placeholder="Masukkan keterangan tiket"></textarea>
          
         </td>
         <td>
            <select class="form-control js-example-basic-single perangkat_clas" id="id_perangkatafter`+rowCount+`" name="Newitems[`+rowCount+`][id_perangkatafter]" data-id="`+rowCount+`" aria-hidden="true" data-select2-id="id_lokasi">
               <option value=""></option>  
            </select>
         </td>
         <td>
            <textarea class="form-control" id="keterangan_after`+rowCount+`" name="Newitems[`+rowCount+`][keterangan_after]" rows="2" placeholder="Masukkan keterangan tiket"></textarea>
          
         </td>
         <td>
            <input type="file" id="upload_before`+rowCount+`" name="Newitems[`+rowCount+`][upload_before]"  accept=".jpg, .png, .jpeg">
          
         </td>
         <td>
            <input type="file" id="proses`+rowCount+`" name="Newitems[`+rowCount+`][proses]"  accept=".jpg, .png, .jpeg">
          
         </td>
         <td>
            <input type="file" id="SN_new`+rowCount+`" name="Newitems[`+rowCount+`][SN_new]"  accept=".jpg, .png, .jpeg">
          
         </td>
         <td>
            <input type="file" id="upload_after`+rowCount+`" name="Newitems[`+rowCount+`][upload_after]"  accept=".jpg, .png, .jpeg">
          
         </td>
         <td>
            <a class="btn waves-effect waves-light btn-danger btn-icon2" onclick="RemovePerangkat(this,'')"  type=""><i class="feather icon-trash"></i></a>
         </td>
      </tr>
     `;
      $('#new_perangkat').append(new_input);
      $("#id_jenisbefore"+rowCount).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
      $("#id_perangkatbefore"+rowCount).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});

      $("#id_jenisafter"+rowCount).select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
      $(".perangkat_clas").select2({ theme: 'bootstrap', dropdownCssClass: 'select2-dropdown--scroll'});
            // $('#total_chq').val(new_chq_no);
}


   function hidden_input(e,t){
      return '<input type="hidden" name="'+e+'" value="'+t+'" >';
   }

   function RemovePerangkat (e,t) {
     
      $(e).parents("tr").addClass("animated fadeOut", function() {
        setTimeout(function() {
            $(e).parents("tr").remove()
        }, 50)
    }), t && 0 < $("#removed-items").append(hidden_input("removed_items[]", t))
  
   }

   function JenisPerangkat(id,id_edit){

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
                  if (id_edit == val['id_jenisperangkat']) {
               
                     row +=`<option value="`+val['id_jenisperangkat']+` " selected>`+val['nama']+`</option>`;
                  }else{
                     row +=`<option value="`+val['id_jenisperangkat']+`">`+val['nama']+`</option>`;
                  }
               
               });
              
               $('#'+id).html(row);
            }, error: function(){
               hide ();
            }
      });   


      return false;
   }

   function Perangkat(idjenis,id,idperangkat,namaperangkat,sn){
     
     $.ajax({
           url: "<?=base_url()?>fasilitas/LoadDataPerangkat/"+idjenis,
           type: 'post',
           // data: formData,
           contentType: false,
           processData: false,
           success: function(r){
              var row = `<option value=""></option>`;
              if (idperangkat != '') {
               row +=`<option value="`+idperangkat+`" selected>`+namaperangkat+` (`+sn+`)</option>` ;
              }else{
               console.log('kosong');
              }
             
              var json = JSON.parse(r);
             
              jQuery.each(json, function( i, val ) {
             
               //   if (id_edit == val['id_perangkat']) {
               //    //console.log(val['id_perangkat']+"|"+val['nama_perangkat']+"|"+val['serial_number']);
               //    row +=`<option value="`+val['id_perangkat']+`" selected>`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
               //   }else{
               //    row +=`<option value="`+val['id_perangkat']+`">`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
               //   }
                 row +=`<option value="`+val['id_perangkat']+`">`+val['nama_perangkat']+` (`+val['serial_number']+`)</option>`;
              });
              $('#'+id).html(row);
             console.log(id);
           }, error: function(){
              hide ();
           }
     });   

     return false;
}


function TTDFile(){
   $('#TTDModal').modal('show');
   $('#TTDModal').find('.modal-title').html('TTD Modal');   
}
</script>
