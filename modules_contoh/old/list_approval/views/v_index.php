

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
   .label-primary {
    background: #5daaff;
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
   .cemter-t{
      text-align: center;
   }
   
   table {
   
    border-spacing: 2px;
   }
  
   .table .thead-dark th {
      color: #fff;
      background-color: #878888b8;
      border-color: #878d93f5;
      vertical-align: middle;
      text-align: center;
   }

  .warnaBarisAwal{
   background-color: #80b4fc;
   color: white;
  }

  .warnaBG{
   background-color: #80b4fc;
  }

.t-formatP th{
   vertical-align: middle;
}

.center{
   vertical-align: middle;
   text-align: center;
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
   max-width: 70%;
   max-height: 70%;
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
            <form onsubmit="return FilterData()" method="post">
               <div class="form-group row">
                  <div class="col-md-9">
                     <input class="form-control" type="text" id="contohSearch" name="keyword" placeholder="cari id tiket atau nama fasilitas">
                  </div>
                  <div class="col-md-2">
                     <button class="btn btn-primary" type="submit">Cari</button>
                  </div>
               </div>
            </form>
            <div class="row">
               <div class="col-md-12">
                  <div class="card ">
                     <div class="card-block">
                        <table class="table table-responsive table-condensed table-striped table-bordered" id="tabel-data1">
                           <thead class="thead-blue">
                              <tr>
                                    <th class="cemter-t">No</th>
                                    <th class="cemter-t">ID Tiket</th>
                                    <th class="cemter-t">Lokasi</th>
                                    <th class="cemter-t">Fasilitas</th>
                                    <th class="cemter-t">Waktu</th>
                                    <th class="cemter-t">Keterangan</th>
                                    <th class="cemter-t">Dokumentasi</th>
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


<div class="modal fade" id="ModalApprove" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header warnaBarisAwal">
        <h4 class="modal-title text-center cemter ">Notifikasi</h4>
      </div>
      <div class="modal-body modal-title text-center fw-semibold fs-3">
        Berhasil diapprove
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="Approve()">YA</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">TIDAK</button>
      </div> -->
    </div>
  </div>
</div>

<div class="modal fade" id="ModalReject" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header warnaBarisAwal">
        <h4 class="modal-title text-center">Notifikasi</h4>
      </div>
      <div class="modal-body modal-title text-center fw-semibold fs-3">
        Berhasil direject
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header warnaBarisAwal">
            <h5 class="modal-title" id="confirmModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" id="btnConfirm">Ya</button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header warnaBarisAwal">
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
                        <label class="col-sm-4 col-form-label">Nomor Tiket:</label>
                        <div class="col-sm-8">
                           <span id="no_tiket" name="no_tiket"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pembuat:</label>
                        <div class="col-sm-8">
                           <span id="pembuat" name="pembuat"></span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Fasilitas:</label>
                        <div class="col-sm-8">
                           <span id="fasilitas">
                              </span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Unit:</label>
                        <div class="col-sm-8">
                           <span id="unit"></span>
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="lokasi"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Sub Lokasi:</label>
                        <div class="col-sm-8">
                           <span id="sublokasi"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal:</label>
                        <div class="col-sm-8">
                           <span  id="date_start"></span>
                        </div>
                     </div>

                     <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan:</label>
                        <div class="col-sm-8">
                           <span  id="keterangan"></span>
                        </div>
                     </div>

                     <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
            </form>
            </div>
            </div>
         </div>
      </div>
   </div>
   <!-- [ page content ] end -->
</div>



<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->


<!--<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
 <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
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
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />-->
<script>
  
      
   function show () {
      $("#spinner").addClass("show");
      
   }
   function hide () {
         $("#spinner").removeClass("show");
   }

   
   FilterData();

    function FilterData(){
      show();
      //var x = document.getElementById("contohSearch");
      
        $.ajax({
            url: "<?=base_url()?>list_approval/LoadTiket/",
            type: 'post',
          
            contentType: false,
            processData: false,

            success: function(r){
                var json = JSON.parse(r);
                var row = "";
                var no =1;
                jQuery.each(json, function( i, val ) {
                  if(val['status'] == 2){
                      row +=`<tr >
                                       <td class="center">`+(no++)+`</td>
                                       <td class="center">`+val['no_tiket']+`</td>
                                       <td class="center">`+val['nama_terminal']+`</td>
                                       <td class="center">`+val['nama_fasilitas']+`</td>
                                       <td class="center">`+val['create_date']+`</td>
                                       <td class="center">`+val['description']+`</td>
                                       <td class="center"><a class="btn btn-link" onclick="previewImage('<?=base_url()?>upload/` + val['foto_before'] +` ')"><img src="<?=base_url()?>upload/` +val['foto_before']+ `" width="120" height="80" class="img-fluid" id="gambar"</a></td>
                                       <td class="center">
                                            <a class="btn btn-primary" onclick="Approve(`+val['id_tiket']+`)"><i class="feather icon-check-circle"></i> </a>
                                            <a class="btn btn-danger" onclick="Reject(`+val['id_tiket']+`)"><i class="feather icon-slash"></i> </a>
                                            <a class="btn btn-success" onclick="ViewData(`+val['id_tiket']+`)"><i class="feather icon-eye"></i> </a>
                                       </td>
                              </tr>`;   
                  }
                  else{
                     row +=`<tr >
                                       <td class="center">`+(no++)+`</td>
                                       <td class="center">`+val['no_tiket']+`</td>
                                       <td class="center">`+val['nama_terminal']+`</td>
                                       <td class="center">`+val['nama_fasilitas']+`</td>
                                       <td class="center">`+val['create_date']+`</td>
                                       <td class="center">`+val['description']+`</td>
                                       <td class="center"><a class="btn btn-link" onclick="previewImage('<?=base_url()?>upload/` + val['foto_before'] +` ')"><img src="<?=base_url()?>upload/` +val['foto_before']+ `" width="120" height="80" class="img-fluid" id="gambar"</a></td>
                                       <td class="center">`+val['label_status']+`</td>                              
                              </tr>`; 
                  };


                });
                $('#Data-AP').html(row);
               hide ();
            }, error: function(){
               hide ();
            }
        });
                
            return false;
    }

   function ResponseApprove(){
      show();
      $('#ModalApprove').modal('show');
      //$('#ModalApprove').find('.modal-title').html('Berhasil diapprove');

   }


   function ResponseReject(){
      show();
      $('#ModalReject').modal('show');
      //$('#ModalApprove').find('.modal-title').html('Berhasil direject');
   }

   function Approve(id) {
      $('#confirmModal').modal('show');
      $('#confirmModal').find('.modal-body').html('Apakah anda yakin akan menyetujui work order nomor ' +id+ ' tersebut ?');

      // Fungsi untuk mengeksekusi delete jika tombol "Ya" ditekan
      $('#btnConfirm').click(function() {
         $.ajax({
            url: "<?=base_url()?>list_approval/ProsesApprove/"+id,
            type: 'post',

            success: function(r) {
               $('#confirmModal').modal('hide');
                FilterData();
                ResponseApprove();
            },
            error: function() {
                // Handle error
            }
        });
      });

    return false;
}

   function Reject(id) {
      $('#confirmModal').modal('show');
      $('#confirmModal').find('.modal-body').html('Apakah anda yakin akan menyetujui work order nomor ' +id+ ' tersebut ?');

      // Fungsi untuk mengeksekusi delete jika tombol "Ya" ditekan
      $('#btnConfirm').click(function() {
         $.ajax({
            url: "<?=base_url()?>list_approval/ProsesReject/"+id,
            type: 'post',

            success: function(r) {
               $('#confirmModal').modal('hide');
                FilterData();
                ResponseReject();
            },
            error: function() {
                // Handle error
            }
        });
      });
    

    return false;
}


   function previewImage(imageUrl) {
      // Buat elemen modal
      var modal = document.createElement('div');
      modal.className = 'image-preview-modal';
    
      // Buat elemen gambar dalam modal
      var modalContent = document.createElement('img');
      modalContent.src = imageUrl;
    
      // Tambahkan gambar ke dalam modal
      modal.appendChild(modalContent);
    
      // Tambahkan modal ke dalam body
      document.body.appendChild(modal);
    
      // Tambahkan event listener untuk menutup modal saat gambar di-klik
      modal.addEventListener('click', function() {
      document.body.removeChild(modal);
    });
}


function ViewData(id){
    $('#requestModal').modal('show');
    $('#requestModal').find('.modal-title').html('Details');   
    
    
    $.ajax({
        url: "<?=base_url()?>list_approval/EditData/"+id,
        type: 'post',
        success: function(r){
               var json = JSON.parse(r);
                  $('#no_tiket').text(json['no_tiket']);
                  $('#pembuat').text(json['create_by']);
                  $('#unit').text(json['kode_unit']);  
                  $('#fasilitas').text(json['id_fasilitas']);  
                  $('#lokasi').text(json['nama_lokasi']);  
                  $('#sublokasi').text(json['nama_sublokasi']); 
                  $('#date_start').text(json['create_date']);
                  $('#keterangan').text(json['description']); 
        },
        error: function(){
            hide();
        }
    });
    return false;
}



</script>