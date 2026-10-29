

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
                                 <button type="button" class="btn btn-primary" onclick="AddData()"> Buat Persetujuan Pergantian Alat</button>
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
                                       <th class="cemter-t">Peralatan</th>
                                       <th class="cemter-t">Keterangan</th>
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
               </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>



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
                     <!-- <canvas class="sign-pad" id="sign-pad" ></canvas> -->
                     <canvas class="sign-pad" id="sign-pad" width="750" height="300"></canvas>
                  </div>
                  <div class="modal-footer ">
                     <a href="#clear" class="btn btn-secondary clearButton" >Reset</a>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
               </div>
            </div>
         </form>
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

   var sig = 	$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:250});
   

   LoadData();

   function LoadData() {
      show();

      $.ajax({
         url: "<?=base_url()?>approvalpergantian/LoadData",
         type: 'post',
         contentType: false,
         processData: false,
         success: function (r) {
               var json = JSON.parse(r);
               var row = "";
               var no = 1;
               jQuery.each(json, function( i, val ) {

                  var approveButton = '<button class="btn waves-effect waves-light btn-warning btn-icon" title="Approve" onclick="Approve(' + val['id_change'] + ')"><i class="fa fa-check"></i></button>';
                  var viewButton = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="View" onclick="ViewData(' + val['id_change'] + ')"><i class="feather icon-eye"></i></button>';
                  var deleteButton = '<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="Deleted(' + val['id_change'] + ')"><i class="fa fa-trash"></i></button>';
                  var none = '<button class="btn waves-effect waves-light btn-disabled btn-icon"><i class="feather icon-slash"></i></button>';
                  var printbtn =`<a href="<?=base_url()?>pergantian_perangkat/PrintData/${val['id_change']}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>`;
                  var prinapproval =` <a href="<?=base_url()?>pergantian_perangkat/PrintDataApproval/${val['id_change']}" target="_blank" class="btn waves-effect waves-light btn-primary btn-icon"><i class="fa fa-print"></i></a>`;
                  var ttdbtn=`<a class="btn waves-effect waves-light btn-primary btn-icon" onclick="TTDFile('${val['id_change']}')"><i class="fa fa-print"></i></a>`;
                  
              
                  var btn = '';

                  if (val['status'] === '1') {
                     console.log(val['status']);
                     btn =ttdbtn+deleteButton;
                  }else if (val['status'] ==='9') {
                     btn =viewButton+printbtn+prinapproval;
                  }else{
                     btn ='<label class="label label-info">Menunggu Approval</label>';
                     console.log("sudah ttd");
                  }
                  row +=`<tr >
                           <td>` +(no++) + `</td>
                           <td>` +val['tanggal_pergantian'] + `</td>
                           <td>` +val['lokasi'] + `</td>
                           <td>` +val['sub_lokasi'] + `</td>
                           <td>` +val['nama_fasilitas'] + `</td>
                           <td>` +val['description'] + `</td>
                           <td>
                            ${btn}
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


   function TTDFile(id){
      $('#TTDModal').modal('show');
      $('#TTDModal').find('.modal-title').html('TTD Modal');   
      $('#TTDModal').find('form').attr('onsubmit','return SaveTTD(this,\''+id+'\')');
      
   }

   function SaveTTD(f,id){
      // show();
      
      html2canvas([document.getElementById('sign-pad')], {
               onrendered: function (canvas) {
                  var canvas_img_data = canvas.toDataURL('image/png');
                  var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
                  
                  // ajax call to save image inside folder
                  $.ajax({
                     url:  '<?=base_url('approvalpergantian/')?>SaveTTD/',
                     data: { img_data:img_data,id: id},
                     type: 'post',
                     dataType: 'json',
                     success: function (response) {
                        // window.location.reload();
                     }
                  });
               }
            });
         return false;
   }
</script>
