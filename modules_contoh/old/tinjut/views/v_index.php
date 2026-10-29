

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
                                 <!-- <div class="pull-right putih mb-10">
                                 <button type="button" class="btn btn-primary" onclick="AddData()"> Request Tiket</button>
                                 </div> -->
                              </div>
                           </div>
                       
                           <div class="table-responsive">   
                           <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">Nomor Tiket</th>
                                       <th class="cemter-t">Lokasi</th>
                                       <th class="cemter-t">Fasilitas</th>
                                       <th class="cemter-t">Keterangan</th>
                                       <th class="cemter-t">Documentasi</th>
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
               </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>



<!-- Modal Request Tiket -->

<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabel">Request Tiket</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Form request -->
            <!-- Form request -->
            <form method="post" enctype="multipart/form-data" onsubmit="return SaveData(this)">
                <div class="modal-body">
                    <!-- ... (other form elements) ... -->
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- New input fields for pembuat dan nomor tiket -->

                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label" for="foto_after">Upload:</label>
                              <div class="col-sm-8">
                                 <div class="input-group">
                                    <div class="custom-file">
                                       <input type="file" class="custom-file-input" id="foto_after" name="foto_after" aria-describedby="inputGroupFileAddon01" accept=".jpg, .png, .jpeg">
                                       <label class="custom-file-label" id="foto_after" for="foto_after">Choose file</label>
                                    </div>
                                 </div>
                              </div>
                           </div>


                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Pembuat:</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" id="pembuat" name="pembuat">
                           </div>
                        </div>
                     

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Fasilitas:</label>
                        <div class="col-sm-8">
                           <input type="hidden" class="form-control" id="fasilitas" name="id_fasilitas" >
                           <input type="text" class="form-control" id="id_fasilitas" name="id_fasilitases" disabled>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="unit" name="unit" disabled>
                           <input type="hidden" class="form-control" id="id_unit" name="id_unit">
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Lokasi:</label>
                        <div class="col-sm-8">
                           <input type="text" class="form-control" id="lokasi" name="lokasi" disabled>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                            <input type="datetime-local" class="form-control" id="date_start" name="date_start">
                                <div class="input-group-append">
                                    <span> - </span>
                                </div>
                                <input type="datetime-local" class="form-control" id="update_date" name="update_date">
                            </div>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan:</label>
                        <div class="col-sm-8">
                           <textarea class="form-control" id="keterangan" name="description" rows="4" placeholder="Masukkan keterangan tiket" required></textarea>
                        </div>
                     </div>
                            <!-- End of new input fields -->
                        </div>
                        <div class="col-md-12">
                            <div class="row mb-10">
                            <div class="col-md-10">
                                <h6>Detail Permasalahan</h6>
                            </div>
                            <div class="col-md-2">
                                <a class="btn waves-effect waves-light btn-info btn-icon2"  id='btn-addperangkat'><i class="feather icon-plus-circle"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-condensed table-striped" id="tabel-perangkat">
                            <thead>
                                <tr>
                                    <th>Jenis Perangkat</th>
                                    <th>Jenis Permaslahaan</th>
                                    <th>Tindakan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="new_perangkat"></tbody>
                            </table>
                            <div id="removed-items"></div>
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
      </div>
   </div>
   <!-- [ page content ] end -->
</div>
<!-- End Modal Request tiket -->



<!-- Modal Request Tiket -->

<div class="modal fade" id="requestModalView" tabindex="-1" role="dialog" aria-labelledby="requestModalLabelView"
   aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="requestModalLabelView">View</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <!-- Form request -->
            <!-- Form request -->
            <form  onsubmit="return SaveData(this)">
                <div class="modal-body">
                    <!-- ... (other form elements) ... -->
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- New input fields for pembuat dan nomor tiket -->
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label">Pembuat:</label>
                              <div class="col-sm-8">
                                 <span id="pembuatt" name="pembuatt"></span>
                              </div>
                           </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Fasilitas:</label>
                        <div class="col-sm-8">
                           <span id="fasilitass" name="id_fasilitass"></span>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                           <span id="unitt"></span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="lokasii" name="id_lokasi"></span>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal:</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span id="date_startt" name="date_start"></span>
                                <div class="input-group-append">
                                    <span> - </span>
                                </div>
                                <span id="update_date" name="update_date"></span>
                            </div>
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan:</label>
                        <div class="col-sm-8">
                           <textarea class="form-control" id="keterangann" name="description" rows="4" placeholder="Masukkan keterangan tiket" disabled></textarea>
                        </div>
                     </div>
                            <!-- End of new input fields -->
                        </div>
                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>



            </div>
            </div>
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>
<!-- End Modal Request tiket -->




<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->


<script>

document.getElementById('foto_after').addEventListener('change', function () {
        var fileName = this.value.split('\\').pop(); 
        var label = document.querySelector('.custom-file-label');
        label.textContent = fileName; 
    });
    
    LoadData();

    function LoadData() {
    show();

    $.ajax({
        url: "<?=base_url()?>tinjut/LoadData",
        type: 'post',
        contentType: false,
        processData: false,
        success: function (r) {
            var json = JSON.parse(r);
            var row = "";

            jQuery.each(json, function (i, val) {
                var tinjutButton = '<button class="btn waves-effect waves-light btn-info btn-icon" title="Siap Tinjut!" onclick="Doit(' + val['id_tiket'] + ')"><i class="fa fa-check-circle"></i></button>';
                //var approveButton = '<button class="btn waves-effect waves-light btn-warning btn-icon" title="Approve" onclick="Approve(' + val['id_tiket'] + ')"><i class="fa fa-check"></i></button>';
                var editButton = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="Edit" onclick="EditData(' + val['id_tiket'] + ')"><i class="feather icon-edit"></i></button>';
                var viewButton = '<button class="btn waves-effect waves-light btn-primary btn-icon" title="View" onclick="ViewData(' + val['id_tiket'] + ')"><i class="feather icon-eye"></i></button>';
                var rejectButton = '<button class="btn waves-effect waves-light btn-danger btn-icon" title="Reject" onclick="Deleted(' + val['id_tiket'] + ')"><i class="fa fa-trash"></i></button>';
                var none = '<button class="btn waves-effect waves-light btn-disabled btn-icon"><i class="feather icon-slash"></i></button>';
                
                // Tambahkan kondisi untuk menyembunyikan tombol Waiting jika status sudah diapprove
                if (val['status'] === '3') {
                    editButton = '';
                   // approveButton = '';
                    rejectButton = '';
               
                } else if (val['status'] === '1') {
                    tinjutButton = ''; // Tombol Waiting akan kosong jika status sudah diapprove
                    rejectButton = '';
                    viewButton = '';

                } else if (val['status'] === '6') {
                    tinjutButton = ''; // Tombol Waiting akan kosong jika status sudah diapprove
                    rejectButton = '';
                    editButton = '';
                }
                

                row += `<tr>
                    <td>${val['no_tiket']}</td>
                    <td>${val['nama_terminal'] || ''}</td>
                    <td>${val['nama_fasilitas'] || ''}</td>
                    <td>${val['description'] || ''}</td>
                    <td>${val['foto_before'] ? `<img src="<?=base_url()?>./upload/${val['foto_before']}" alt="Foto Before" width="100" height="100" onclick="previewImage('<?=base_url()?>./upload/${val['foto_before']}')">` : ''}</td>
                    <td>${val['label_status'] || ''}</td>
                    <td>
                        ${editButton}
                        ${tinjutButton} 
                        ${rejectButton}
                        ${viewButton}
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
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Tambah Menu Baru');   
      $('#requestModal').find('form').attr('onsubmit','return SaveData(this)');

      LoadFasilits();
    }

    function LoadFasilits(){
   
         show();
         $.ajax({
               url: "<?=base_url()?>fasilitas/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var row = "<option selected>Pilih Fasilitas</option>";
                  jQuery.each(json['fasilitas'], function( i, val ) {
                    
                     row +=` <option value="`+val['id_fasilitas']+`">`+val['nama_fasilitas']+`</option>`;
                  });
                  
                
                  $('#fasilitas').html(row);
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
         url:  '<?=base_url('tinjut/')?>SaveData/',
       
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
            url: '<?= base_url('tinjut/Delete/') ?>' + id,
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

   function Waiting(id) {
      var confirmDelete = confirm("Apakah Anda yakin ingin Melanjutkan data ini?");

      if (confirmDelete) {
         $.ajax({
            url: '<?= base_url('tinjut/Waiting/') ?>' + id,
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

   function Approve(id, button) {
    var confirmApprove = confirm("Apakah Anda yakin ingin Menyetujui data ini?");

    if (confirmApprove) {
        $.ajax({
            url: '<?= base_url('tinjut/Approve/') ?>' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function (r) {

                LoadData();
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

    function Doit(id, button) {
        var confirmApprove = confirm("Apakah Anda yakin ingin Meninjut task ini?");

        if (confirmApprove) {
            $.ajax({
                url: '<?= base_url('tinjut/Doit/') ?>' + id,
                type: 'post',
                contentType: false,
                processData: false,
                success: function (r) {

                    LoadData();
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

function EditData(id){
    $('#requestModal').modal('show');
    $('#requestModal').find('.modal-title').html('Edit Menu');   
    $('#requestModal').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
    
    $.ajax({
        url: "<?=base_url()?>tinjut/EditData/"+id,
        type: 'post',
        success: function(r){
         
               var json = JSON.parse(r);
                  $('#pembuat').val(json['create_by']).prop('disabled', true);
                  $('#unit').val(json['kode_unit']);
                  $('#id_unit').val(json['id_unit']);
                  $('#fasilitas').val(json['id_fasilitas']); 
                  $('#id_fasilitas').val(json['nama_fasilitas']);
                  $('#lokasi').val(json['nama_terminal']);
                  $('#date_start').val(json['create_date']);
                  $('#update_date').val(json['update_date']);
                  $('#keterangan').val(json['description']).prop('disabled', true);  
                  $('#btn-addperangkat').attr('onclick', 'AddPerangkat('+json['id_fasilitas']+')');
        
        
               var label = document.querySelector('.custom-file-label');
               label.textContent = (json['foto_after'] && json['foto_after'] !== '') ? json['foto_after'] : 'Choose file';
        
               },
        
        error: function(){
            hide();
        }
    });
    return false;
}

function JenisPerangkat(id,param){
  
  
    $.ajax({
        url: "<?=base_url()?>fasilitas/LoadDataPerangkatByID/"+id,
        type: 'post',
        success: function(r){
               var json = JSON.parse(r);
               var row = '<option value=""></option>';
             
               jQuery.each(json, function( i, val ) {
                
                  row +=`<option value="`+val['detail']['id_jenisperangkat']+`" data-id = '`+val['id_jenisperangkat']+`'>`+val['detail']['nama_perangkat']+`</option>`;
               });
               $('#'+param).html(row);
        },
        error: function(){
            hide();
        }
    });
    return false;
}


// function UpdateData(f,id) {
//    var formData = new FormData($(f)[0]);
//     var id_fasilitas =  $('#fasilitas').val();
//     console.log(formData);
//   //  formData.append('id_fasilitas',  id_fasilitas);
    
//     $.ajax({
//         url: "<?=base_url()?>tinjut/UpdateData/"+id,  
//         type: 'post',
//         data: formData,
//         success: function(response) {
//             LoadData();  
         
//             $('#requestModal').modal('hide');
//         },
//         error: function(xhr, status, error) {
     
//             console.error("Error updating data");
//             console.log("Status: " + status);
//             console.log("Error: " + error);
//             console.log("Response Text: " + xhr.responseText);
//         }
//     });

//     return false;
// }

function UpdateData(f,id){
   
      var formData = new FormData($(f)[0]);
      var id_fasilitas =  $('#fasilitas').val();
      formData.append('id_fasilitas', id_fasilitas);
      $.ajax({
         url:  '<?=base_url('tinjut/UpdateData/')?>'+id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
            $('#requestModal').modal('hide');
            LoadData();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }


$('body').on('change','.jenis', function() {
  
  if($(this).val() != ''){
     var id=$(this).find(':selected').attr('data-id');
  
     JenisMasalah(id,'id'+$(this).attr("data-id"));
    
  }
});

$('body').on('change','#fasilitas', function() {
  
  if($(this).val() != ''){
     var id=$(this).val();
  
     $.ajax({
        url: '<?=base_url('fasilitas/')?>EditData/'+id,
        success: function(r){
           var json = JSON.parse(r);
        
         
           $('#unit').val(json['unit']);
           $('#id_unit').val(json['id_unit']);
        
        }, error(){
           
        }
     });   
  }
});

   // function JenisPerangkat(id){
        
   //      $.ajax({
   //            url: "<?=base_url()?>fasilitas/LoadDataJP",
   //            type: 'post',
   //            // data: formData,
   //            contentType: false,
   //            processData: false,

   //            success: function(r){
   //               var row = '<option value=""></option>';
   //               var json = JSON.parse(r);
               
                
   //               jQuery.each(json, function( i, val ) {
                    
   //                  row +=`<option value="`+val['id_jenisperangkat']+`">`+val['nama']+`</option>`;
   //               });
                 
   //               $('#'+id).html(row);
   //            }, error: function(){
   //               hide ();
   //            }
   //      });   

      
   //      return false;
   // }

     function JenisMasalah(id,param){
        
        $.ajax({
              url: "<?=base_url()?>jenis_masalah/LoadDataByid/"+id,
              type: 'post',
              // data: formData,
              contentType: false,
              processData: false,

              success: function(r){
                 var row = '<option value=""></option>';
                 var json = JSON.parse(r);
               
                
                 jQuery.each(json, function( i, val ) {
                    
                    row +=`<option value="`+val['id']+`">`+val['nama_masalah']+`</option>`;
                 });
             
                 $('#'+param).html(row);
              }, error: function(){
                 hide ();
              }
        });   

      
        return false;
     }

function AddPerangkat(id){
   // onclick="AddPerangkat()"
   
      // var new_chq_no = parseInt($('#total_chq').val()) + 1;
      var rowCount =  $('#tabel-perangkat > tbody tr').length;
      // console.log(rowCount);
     
      // JenisMasalah('id'+rowCount);
      JenisPerangkat(id,'id_jenisperangkat'+rowCount);
      var new_input = ` 
      <tr id ="act_`+rowCount+`">
         <td>
            <select class="form-control jenis" id="id_jenisperangkat`+rowCount+`" name="Newitems[`+rowCount+`][id_jenisperangkat]" data-id="`+rowCount+`">
               <option value=""></option>
               
            </select>
         </td>
         <td>
            <select class="form-control" id="id`+rowCount+`" name="Newitems[`+rowCount+`][id_jenismasalah]">
               <option value=""></option>+
            </select>
         </td>
         <td>
         <textarea class="form-control" id="descrpition`+rowCount+`" name="Newitems[`+rowCount+`][description]" rows="4" placeholder="Masukkan keterangan tindakan" required></textarea>
         </td>
         <td>
            <a class="btn waves-effect waves-light btn-danger btn-icon2" onclick="RemoveActionPlan('act_`+rowCount+`')"  type=""><i class="feather icon-trash"></i></a>
         </td>
      </tr>
     `;
      $('#new_perangkat').append(new_input);

      // $('#total_chq').val(new_chq_no);
   }

   function RemoveActionPlan(r,a) {
      // var last_chq_no = $('#total_chq').val();

      // if (last_chq_no > 1) {
      //    $('#'+ r).remove();
      //    $('#total_chq').val(last_chq_no - 1);
      // }
      $('#'+ r).remove();
      a && 0 < $("#removed-items").append(hidden_input("removed_items[]", a))
   }

   function ViewData(id){
    $('#requestModalView').modal('show');
    $('#requestModalView').find('.modal-title').html('Edit Menu');   
    $('#requestModalView').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
    
    $.ajax({
        url: "<?=base_url()?>tinjut/EditData/"+id,
        type: 'post',
        success: function(r){
               var json = JSON.parse(r);
                  $('#pembuatt').text(json['create_by']);
                  $('#unitt').text(json['kode_unit']);
                  $('#fasilitass').text(json['nama_fasilitas']); 
                  $('#lokasii').text(json['nama_terminal']);
                  $('#date_startt').text(json['create_date']);
                  $('#update_date').text(json['update_date']);
                  $('#keterangann').val(json['description']).prop('disabled', true);  
        },
        error: function(){
            hide();
        }
    });
    return false;
}


</script>
