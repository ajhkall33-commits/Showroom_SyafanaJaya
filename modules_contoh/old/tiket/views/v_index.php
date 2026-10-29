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
   .center-t{
      text-align: center;
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
   /* CSS Select2 */
   
   .select2-container {
      width: 100%;
      border: 1px solid #ccc;
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

  
   .select2-dropdown--scroll:hover::-webkit-scrollbar {
      width: 10px;
      height: 10px;
   }

   
   .select2-dropdown--scroll::-webkit-scrollbar-track {
      background: #f1f1f1;
   }

  
   .select2-dropdown--scroll::-webkit-scrollbar-thumb {
      background: #888;
   }

  
   .select2-dropdown--scroll::-webkit-scrollbar-thumb:hover {
      background: #555;
   }
   .ct-l{
            line-height: 1;
            padding-top: calc(0.6rem + 1px);
            padding-bottom: calc(0.375rem + 1px);
         }
  .center-t{
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
                                       <th class="cemter-t">Nomor Tiket</th>
                                       <th class="cemter-t">Lokasi</th>
                                       <th class="cemter-t">Area</th>
                                       <th class="cemter-t">Fasilitas</th>
                                       <th class="cemter-t">Keterangan</th>
                                       <th class="cemter-t">Foto Before</th>
                                       <th class="cemter-t">Foto After</th>
                                       <th class="cemter-t">Status</th>
                                       <th class="cemter-t">Action</th>
                                 </tr>
                              </thead>
                              <tbody id="Data-AP">
                               
                              </tbody>
                           </table>
                           </div>
                           <div class="row"  id="data-pag">

                           </div>
                        </div>
                        <!-- <form id="form-monitoring" class="row" onsubmit="return UpdateData(this)">
                           
                           <div class="card-footer text-muted" id="btn-updatedata">
                              
                           </div>
                        </form> -->
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
                              <?php foreach ($fasilitas_options as $fasilitas): ?>
                              <option value="<?= $fasilitas->id ?>"><?= $fasilitas->fasilitas ?>-<?= $fasilitas->ip_address ?></option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="unit" readonly>
                           <input type="hidden" class="form-control" id="id_unit" name="id_unit" >
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Lokasi:</label>
                        <div class="col-sm-8">
                           <input class="form-control" id="lokasi" readonly>
                           <input type="hidden" class="form-control" id="id_lokasi" name="id_lokasi">
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Area:</label>
                        <div class="col-sm-8">
                           <input class="form-control" id="sublokasi" readonly>
                           <input type="hidden" class="form-control" id="id_sublokasi" name="id_sublokasi">
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal:</label>
                        <div class="col-sm-8">
                           <input type="datetime-local" class="form-control" id="date_start" name="date_start" required>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan:</label>
                        <div class="col-sm-8">
                           <textarea class="form-control" id="keterangan" name="description" rows="4" placeholder="Masukkan keterangan tiket"></textarea>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label" for="upload_before">Upload:</label>
                        <div class="col-sm-8">
                           <div class="input-group">
                              <div class="custom-file">
                                 <input type="file" class="custom-file-input" id="upload_before" name="upload_before" aria-describedby="inputGroupFileAddon01" accept=".jpg, .png, .jpeg">
                                 <label class="custom-file-label" id="upload_before" for="upload_before">Choose file</label>
                              </div>
                           </div>
                           <small class="text-muted" style="font-style: italic; color: red !important;">*Allowed file type: .jpg, .png, .jpeg</small>
                        </div>
                     </div>
                     <button type="submit" id="submitBtn" class="btn btn-primary">Request Tiket</button>
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
            </form>
            </div>
            </div>
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>
<!-- End Modal Request tiket -->


<div class="modal fade" id="requestModalView" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabelView">View Request Tiket</h5>
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
                           <span id="pembuat1" name="pembuat"></span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Fasilitas:</label>
                        <div class="col-sm-8">
                           <span id="fasilitas1">
                              </span>
                        </div>
                     </div>


                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                           <span id="unit1"></span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="lokasi1"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Sub Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="sublokasi1"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal:</label>
                        <div class="col-sm-8">
                           <span  id="date_start1"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan:</label>
                        <div class="col-sm-8">
                           <span  id="keterangan1"></span>
                        </div>
                     </div>


                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            </form>
            </div>
            </div>
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>

<div class="modal fade" id="requestModalViewBanyak" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
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
            <form>
               <div class="row">
                  <div class="col-md-12">

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No Tiket:</label>
                        <div class="col-sm-8">
                           <span id="no_tiket2"></span>
                        </div>
                     </div>
                    
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pembuat:</label>
                        <div class="col-sm-8">
                           <span id="pembuat2"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                           <span id="unit2">
                           </span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Fasilitas:</label>
                        <div class="col-sm-8">
                           <span id="fasilitas2"></span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="lokasi2">
                           </span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Sub Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="sublokasi2">
                           </span>
                        </div>
                     </div>

                     <div id="dynamic_content">

                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan Before:</label>
                        <div class="col-sm-8">
                           <span id="keterangan2">
                           </span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal Mulai:</label>
                        <div class="col-sm-8">
                           <span id="date_before">
                           </span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal Selesai:</label>
                        <div class="col-sm-8">
                           <span id="date_after">
                           </span>
                        </div>
                     </div>

                     <!-- <button type="submit" id="submitBtn" class="btn btn-primary">Request Tiket</button> -->
                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            </form>
            </div>
            </div>
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>




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

$(document).ready(function() {
    $('.js-example-basic-single').select2({
        theme: 'bootstrap',
        dropdownCssClass: 'select2-dropdown--scroll'
    });
});

    document.getElementById('upload_before').addEventListener('change', function () {
        var fileName = this.value.split('\\').pop(); 
        var label = document.querySelector('.custom-file-label');
        label.textContent = fileName; 
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

            jQuery.each(json['data'], function (i, val) {
                var waitingButton = '<button class="btn waves-effect waves-light btn-info btn-icon" title="Send Request" onclick="Waiting(' + val['id_tiket'] + ')"><i class="fa fa-check-circle"></i></button>';
                //var approveButton = '<button class="btn waves-effect waves-light btn-warning btn-icon" title="Approve" onclick="Approve(' + val['id_tiket'] + ')"><i class="fa fa-check"></i></button>';
                var editButton = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData(' + val['id_tiket'] + ')"><i class="feather icon-edit"></i></button>';
                var rejectButton = '<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="Deleted(' + val['id_tiket'] + ')"><i class="fa fa-trash"></i></button>';
                var none = '<button class="btn waves-effect waves-light btn-disabled btn-icon"><i class="feather icon-slash"></i></button>';
                var viewData = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="View" onclick="ViewData(' + val['id_tiket'] + ')"><i class="feather icon-eye"></i></button>';
                var viewData2 = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="View" onclick="ViewData2(' + val['id_tiket'] + ')"><i class="feather icon-eye"></i></button>';

                // Tambahkan kondisi untuk menyembunyikan tombol Waiting jika status sudah diapprove
                if (val['status'] === '3') {
                    waitingButton = ''; 
                    editButton = viewData;
                   // approveButton = '';
                    rejectButton = '';
               
                } else if (val['status'] === '6' || val['status'] === '5' || val['status'] === '9') {
                    waitingButton = ''; 
                    editButton = viewData2;
                    rejectButton = '';

                } else if (val['status'] === '9') {
                    waitingButton = ''; 
                    editButton = viewData;

                } else if (val['status'] === '1') {
                    waitingButton = ''; 
                    editButton = viewData;
                    rejectButton = '';
                } else if (val['status'] === '2') {
                    waitingButton = ''; 
                    editButton = viewData;
                    rejectButton = '';
                }
                row += `<tr>
                    <td>${val['no_tiket']}</td>
                    <td>${val['nama_lokasi'] || ''}</td>
                    <td>${val['nama_sublokasi'] || ''}</td>
                    <td>${val['nama_fasilitas'] || ''}</td>
                    <td>${val['description'] || ''}</td>
                    <td>${val['foto_before'] ? `<img src="<?=base_url()?>./upload/${val['foto_before']}" alt="Foto Before" width="100" height="100" onclick="previewImage('<?=base_url()?>./upload/${val['foto_before']}')">` : ''}</td>
                    <td>${val['foto_after'] ? `<img src="<?=base_url()?>./upload/${val['foto_after']}" alt="Foto After" width="100" height="100" onclick="previewImage('<?=base_url()?>./upload/${val['foto_after']}')">` : ''}</td>
                    <td>${val['label_status'] || ''}</td>
                    <td>
                        ${editButton}
                        ${waitingButton} 
                        ${rejectButton}
                    </td>
                </tr>`;
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



      function previewImage(imageUrl) {
         var modal = document.createElement('div');
         modal.className = 'image-preview-modal';
         
         var modalContent = document.createElement('img');
         modalContent.src = imageUrl;
         
         modal.appendChild(modalContent);
         
         document.body.appendChild(modal);
         
         modal.addEventListener('click', function() {
            document.body.removeChild(modal);
         });
      }

    function AddData(){
      // show();
      ResetFormModal();

      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Tambah Menu Baru');   
      $('#requestModal').find('form').attr('onsubmit','return SaveData(this)');
      $('#submitBtn').html('Request Tiket');
      $('#upload_before').val('');

      var label = document.querySelector('.custom-file-label');
      label.textContent = 'Choose file';

      LoadFasilits();
    }

    function LoadFasilits(id){
   
         show();
         $.ajax({
               url: "<?=base_url()?>fasilitas/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "<option value=''>Pilih Fasilitas</option>";
                  jQuery.each(json['fasilitas'], function( i, val ) {
                    if (val['id_fasilitas'] == id){
                     row +=` <option value="`+val['id_fasilitas']+`" selected>`+val['nama_fasilitas']+` - `+val['ip_address']+`</option>`;
                    }else{
                     row +=` <option value="`+val['id_fasilitas']+`">`+val['nama_fasilitas']+` - `+val['ip_address']+`</option>`;
                    }
                  
                  });
                  
                
                  $('#id_fasilitas').html(row);
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
         url:  '<?=base_url('tiket/')?>SaveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
             $(f)[0].reset(); 

             $('#requestModal').modal('hide');
          
             FilterData();
         
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
               FilterData();
            hide();
            }, error: function(){
            hide();
            }
         });
      } else {
         return false;
      }
   }

   function Waiting(id) {
      var confirmDelete = confirm("Apakah Anda yakin ingin Melanjutkan data ini?");

      if (confirmDelete) {
         $.ajax({
            url: '<?= base_url('tiket/Waiting/') ?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function(r){
               FilterData();
            hide();
            }, error: function(){
            hide();
            }
         });
      } else {
         return false;
      }
   }

   function Approve(id, button) {
    var confirmApprove = confirm("Apakah Anda yakin ingin Menyetujui data ini?");

    if (confirmApprove) {
        $.ajax({
            url: '<?= base_url('tiket/Approve/') ?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function (r) {

               FilterData();
                hide();
            },
            error: function () {
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

function ViewData2(id){
    $('#requestModalViewBanyak').modal('show');
    $('#requestModalViewBanyak').find('.modal-title').html('Details');   
    //$('#requestModalView').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
    
    
    $.ajax({
        url: "<?=base_url()?>list_approval_leader/EditData/"+id,
        type: 'post',
        success: function(r){
               var json = JSON.parse(r);
                  $('#no_tiket2').text(json['no_tiket']);
                  $('#pembuat2').text(json['create_by']);
                  $('#unit2').text(json['kode_unit']);
                  $('#fasilitas2').text(json['nama_fasilitas']);
                  $('#lokasi2').text(json['nama_lokasi']);
                  $('#sublokasi2').text(json['nama_sublokasi']);
                  $('#JP2').text(json['nama']);
                  $('#JM2').text(json['nama_masalah']);
                  $('#keterangan2').text(json['description']);
                  $('#keteranganNew').text(json['description']);
                  $('#date_before').text(json['date_start']);
                  $('#date_after').text(json['update_date']);

                  for (var i = 1; i <= json['count']; i++) {
                     $('#dynamic_content').append(
                        '<div class="form-group row">' +
                        '<label class="col-sm-4 col-form-label">Jenis Perangkat ' + i + ':</label>' +
                        '<div class="col-sm-8">' +
                        '<span id="JP' + i + '"></span>' +
                        '</div>' +
                        '</div>' +

                        '<div class="form-group row">' +
                        '<label class="col-sm-4 col-form-label">Jenis Masalah ' + i + ':</label>' +
                        '<div class="col-sm-8">' +
                        '<span id="JM'+ i +'"></span>' +
                        '</div>' +
                        '</div>' +

                        '<div class="form-group row">' +
                        '<label class="col-sm-4 col-form-label">Keterangan ' + i + ':</label>' +
                        '<div class="col-sm-8">' +
                        '<span id="KT'+ i +'"></span>' +
                        '</div>' +
                        '</div>'
                     );

                     $('#JP'+i).text(json[i-1]['nama_JP']);
                     $('#JM'+i).text(json[i-1]['nama_masalah']);
                     $('#KT'+i).text(json[i-1]['ket']);
                  }
               
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
         FilterData();  
         
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

$('body').on('change','#id_fasilitas', function() {
  
  if($(this).val() != ''){
     var id=$(this).val();
  
     $.ajax({
        url: '<?=base_url('tiket/')?>GetData/'+id,
        success: function(r){
           var json = JSON.parse(r);
        
         
           $('#unit').val(json['unit']);
           $('#id_unit').val(json['id_unit']);
           $('#lokasi').val(json['nama_lokasi']);
           $('#id_lokasi').val(json['id_lokasi']);
           $('#sublokasi').val(json['nama_sublokasi']);
           $('#id_sublokasi').val(json['id_sublokasi']);
        
        }, error(){
           
        }
});
}
});


$('body').on('change','#limitData', function() {
   
   FilterData();
  });

  $( "#srcData" ).on( "keyup", function() {
     FilterData();
  
  } );

</script>
