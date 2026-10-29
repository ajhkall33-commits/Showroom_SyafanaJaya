<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">



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
        <button type="button" class="btn btn-primary" onclick="addgperangkat(); addidfasilitas(); addgperangkatlama();">Ganti Perangkat</button>
     

        <!-- Modal -->
        <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestModalLabel">Ganti Perangkat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                    <!-- Form Work Order -->
                    <form method="post" action="<?= base_url('gperangkat/save_data') ?>" enctype="multipart/form-data">
                  <div class="row">
                     <div class="col-md-12">
                                              
                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Fasilitas :</label>
                           <div class="col-sm-8">
                              <input class="form-control" id="idfasilitas" name="idfasilitas" placeholder="" value="<?= $id_fasilitas ?>" readonly></textarea>
                           </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">No Tiket Ref :</label>
                           <div class="col-sm-8">
                              <input class="form-control" id="id_tiket" name="id_tiket" placeholder="" value="<?= $no_tiket ?>" readonly></textarea>
                           </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Perangkat Awal :</label>
                           <div class="col-sm-8">
                              <input class="form-control" id="perangkat_awal" name="perangkat_awal" placeholder="" value="<?= $id_lokasi ?>" readonly></textarea>
                           </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Perangkat Baru :</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="pbaru" id="pbaru" required>
                                    <option selected>Pilih Lokasi Fasilitas</option>
                                    <?php foreach ($lokasi_options as $master_lokasi): ?>
                                        <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Lokasi Penyimpanan Perangkat Lama :</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="plama" id="plama" required>
                                    <option selected>Pilih Lokasi Fasilitas</option>
                                    <?php foreach ($lokasi_options as $master_lokasi): ?>
                                        <option value="<?= $master_lokasi->id ?>"><?= $master_lokasi->lokasi ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Jam Mulai:</label>
                           <div class="col-sm-8">
                              <input type="datetime-local" class="form-control" name= "tanggal_mulai" id="tanggal">
                           </div>
                        </div>

                        <div class="form-group row">
                           <label class="col-sm-4 col-form-label">Jam Selesai:</label>
                           <div class="col-sm-8">
                              <input type="datetime-local" class="form-control" name= "tanggal_selesai" id="tanggal">
                           </div>
                        </div>
                        

                        <!-- <div class="form-group row"> -->
                           <!-- <label class="col-sm-4 col-form-label">Tanggal:</label> -->
                           <!-- <div class="col-sm-8"> -->
                              <!-- <input type="datetime-local" class="form-control" id="tanggal"> -->
                           <!-- </div> -->
                        <!-- </div> -->
                    
                        <!-- <div class="form-group row"> -->
                           <!-- <label class="col-sm-4 col-form-label">Keterangan:</label> -->
                           <!-- <div class="col-sm-8"> -->
                              <!-- <textarea class="form-control" id="keterangan" rows="4" placeholder="Masukkan keterangan tiket" required></textarea> -->
                           <!-- </div> -->
                        <!-- </div> -->
                     <!-- </div> -->
                  <!-- </div> -->

                  <div class="form-group row mb-3">
                     <div class="col-sm-4">
                        <label>Foto Sebelum :</label>
                     </div>
                     <div class="col-sm-8">
                        <div class="input-group">
                           <div class="custom-file">
                           <form action="your_upload_action" method="post" enctype="multipart/form-data">
                           <input type="file" name="foto_sebelum" id="fileInput" onchange="displayFileName()" />
                           <label for="fileInput" id="fileLabel"></label>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="form-group row mb-3">
                     <div class="col-sm-4">
                        <label>Foto Sesudah :</label>
                     </div>
                     <div class="col-sm-8">
                        <div class="input-group">
                           <div class="custom-file">
                           <form action="your_upload_action" method="post" enctype="multipart/form-data">
                           <input type="file" name="foto_sesudah" id="fileInput" onchange="displayFileName()" />
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
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<script>
   function addgperangkat(){
      // show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#requestModal').find('form').attr('onsubmit','return UploadData(this)');
      
      loadpbaru();
    }

    
    function loadpbaru(){
      $.ajax({
         url:  '<?=base_url('Ganti_perangkat/')?>loadpbaru/',
         type: 'post',
        
         success: function(r){

            var json = JSON.parse(r);
            var row = `<option value="">--Pilih Lokasi Fasilitas--</option>`;
            jQuery.each(json, function( i, val ) {
               row+=`<option value="`+val['id']+`">`+val['lokasi']+`</option>`;
            });


            $('#pbaru').html(row);
            // 
         }, error: function(){
           
         }
      });
      return false;
    }





    function addgperangkatlama(){
      // show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#requestModal').find('form').attr('onsubmit','return UploadData(this)');
      
      loadplama();
    }

    function loadplama(){
      $.ajax({
         url:  '<?=base_url('Ganti_perangkat/')?>loadplama/',
         type: 'post',
        
         success: function(r){

            var json = JSON.parse(r);
            var row = `<option value="">--Pilih Lokasi Fasilitas--</option>`;
            jQuery.each(json, function( i, val ) {
               row+=`<option value="`+val['id']+`">`+val['lokasi']+`</option>`;
            });


            $('#plama').html(row);
            // 
         }, error: function(){
           
         }
      });
      return false;
    }



   function addidfasilitas(){
      // show();
      $('#requestModal').modal('show');
      $('#requestModal').find('.modal-title').html('Infomation Realisasi Kinerja');   
      $('#requestModal').find('form').attr('onsubmit','return UploadData(this)');
      
      loadidfasilitas();
    }
   
    
    function loadidfasilitas(){
      $.ajax({
         url:  '<?=base_url('Ganti_perangkat/')?>loadidfasilitas/',
         type: 'post',
        
         success: function(r){

            var json = JSON.parse(r);
            var row = `<option value="">--Pilih Lokasi Fasilitas--</option>`;
            jQuery.each(json, function( i, val ) {
               row+=`<option value="`+val['id']+`">`+val['id_fasilitas']+`</option>`;
            });


            $('#idfasilitas').html(row);
            // 
         }, error: function(){
           
         }
      });
      return false;
    }
   
</script>
</body>

</html>
