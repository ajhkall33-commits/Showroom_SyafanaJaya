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
</style>


<body>

<div id="spinner" class="">
   <div class="loader is-loading">
      <div class="lds-dual-ring"></div>
   </div>
</div>

<div class="page-header card">
   <div class="row align-items-end">
      <div class="col-lg-8">
         <div class="page-header-title">
            <i class="feather icon-briefcase bg-c-blue"></i>
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
            <div class="container mt-5">

          <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" onclick="addwo(); addwo2(); addunit();" >
            INPUT WORK ORDER
         </button>

        <!-- Modal -->
        <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestModalLabel">WORK ORDER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                    <!-- Form Work Order -->
                    <form method="post" action="<?= base_url('wo/save_data'); ?>" enctype="multipart/form-data">
                     <div class="row">
                     <div class="col-md-12">

                        

                     <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Pembuat :</label>
                           <div class="col-sm-8">
                              <input class="form-control" name="id_pembuat" id="id_pembuat"  placeholder="" disabled></textarea>
                           </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="unit" id="unit" required>
                                    <option selected>--Pilih Unit--</option>
                                    <?php foreach ($lokasi_options as $unit): ?>
                                        <option value="<?= $unit->id ?>"><?= $master_lokasi->kode_unit ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>


                     <!-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Unit:</label>
                            <div class="col-sm-8">
                                <div class="dropdown">
                                    <select class="form-control" name="unit" id="unit" >
                                        <option selected>--Pilih Unit--</option>
                                        <option value="PC">PSIT</option>
                                        <option value="PC">SSIT</option>
                                        <option value="monitor">BHS</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Fasilitas:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="namafasilitas" id="namafasilitas" required>
                                    <option selected>--Pilih Fasilitas--</option>
                                    <?php foreach ($lokasi_options as $master_lokasi): ?>
                                        <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Lokasi:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="lokasi" id="lokasi" required>
                                    <option selected>--Pilih Lokasi--</option>
                                    <?php foreach ($lokasi_options as $master_lokasi): ?>
                                        <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->fasilitas ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Tanggal:</label>
                           <div class="col-sm-8">
                              <input type="datetime-local" class="form-control" name="tanggal" id="tanggal">
                           </div>
                        </div>
                    
                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Keterangan:</label>
                           <div class="col-sm-8">
                              <textarea class="form-control" name="keterangan" id="keterangan" rows="4" placeholder="Masukkan keterangan tiket" required></textarea>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="form-group row mb-3">
                     <div class="col-sm-4">
                        <label>Upload:</label>
                     </div>
                     <div class="col-sm-8">
                        <div class="input-group">
                           <div class="custom-file">
                           <form action="your_upload_action" method="post" enctype="multipart/form-data">
                           <input type="file" name="gambar" id="fileInput" onchange="displayFileName()" />
                           <label for="fileInput" id="fileLabel"></label>
                           </div>
                        </div>
                     </div>
                  </div>

                     
                  
                  
                        <div class="container">
                           <button type="submit" class="btn btn-primary">💾 Save</button>
                           <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">&times;Close</button>
                           
                        </div>
                           
                           
                        <!-- <button onclick="goBack()" class="btn btn-primary">Kembali</button> -->
                        <!-- <script> -->
                              <!-- // Fungsi untuk kembali ke halaman sebelumnya -->
                              <!-- function goBack() { -->
                              <!-- // Menggunakan metode history.back() -->
                              <!-- window.history.back();} -->
                        <!-- </script> -->


               </form>
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



<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<!-- <script src="<?= base_url("assets") ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
4<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script>


function addunit(){
      // show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#requestModal').find('form').attr('onsubmit','return UploadData(this)');
      
      loadunit();
    }

    function loadunit(){
      $.ajax({
         url:  '<?=base_url('wo/')?>loadunit/',
         type: 'post',
        
         success: function(r){

            var json = JSON.parse(r);
            var row = `<option value="">--Pilih Lokasi Fasilitas--</option>`;
            jQuery.each(json, function( i, val ) {
               row+=`<option value="`+val['id_unit']+`">`+val['kode_unit']+`</option>`;
            });


            $('#unit').html(row);
            // 
         }, error: function(){
           
         }
      });
      return false;
    }

   
   function addwo(){
      // show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#requestModal').find('form').attr('onsubmit','return UploadData(this)');
      
      loadlokasi();
    }

    function loadlokasi(){
      $.ajax({
         url:  '<?=base_url('wo/')?>loadlokasi/',
         type: 'post',
        
         success: function(r){

            var json = JSON.parse(r);
            var row = `<option value="">--Pilih Lokasi Fasilitas--</option>`;
            jQuery.each(json, function( i, val ) {
               row+=`<option value="`+val['id']+`">`+val['lokasi']+`</option>`;
            });


            $('#lokasi').html(row);
            // 
         }, error: function(){
           
         }
      });
      return false;
    }



    function addwo2(){
      // show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#requestModal').find('form').attr('onsubmit','return UploadData(this)');
      
      loadnamafasilitas();
    }

    function loadnamafasilitas(){
      $.ajax({
         url:  '<?=base_url('wo/')?>loadnamafasilitas/',
         type: 'post',
        
         success: function(r){

            var json = JSON.parse(r);
            var row = `<option value="">--Pilih Lokasi Fasilitas--</option>`;
            jQuery.each(json, function( i, val ) {
               row+=`<option value="`+val['id']+`">`+val['lokasi']+`</option>`;
            });


            $('#namafasilitas').html(row);
            // 
         }, error: function(){
           
         }
      });
      return false;
    }



// fungsi untuk menampilkan nama file ketika akan upload di form
// function displayFileName() {
//     // Mendapatkan elemen input file
//     var fileInput = document.getElementById('fileInput');

//     // Mendapatkan elemen label
//     var fileLabel = document.getElementById('fileLabel');

//     // Menampilkan nama file yang dipilih di dalam label
//     fileLabel.innerHTML = fileInput.files[0].name;
// }
</script>

</body>
</html>
   


    

    
</script>
</body>

</html>
