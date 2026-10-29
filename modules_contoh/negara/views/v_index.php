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
                                       <th class="cemter-t">ID  </th>
                                       <th class="cemter-t">Nama Negara</th>
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
                        
                        </div>
                     </div>
                  </div>
               </div>
            <!-- [ page content ] end -->
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="m-negara" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                   <label class="col-sm-2 col-form-label">Nama Negara</label>
                   <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_negara" id="nama_negara" >
                   </div>
                </div>

                <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>


 

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
      LoadData();
    


      function LoadData(){
         show();
       
         $.ajax({
               url: "<?=base_url()?>negara/LoadData",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var pag= "";
                  jQuery.each(json['negara'], function( i, val ) {
                     var row = "";
                     header_table +=`<tr >
                                       
                                       <td style="text-align: center;">`+(val['id_negara'] == null ? '': val['id_negara'])+`</td>
                                       <td style="text-align: center;">`+(val['nama_negara'] == null ? '': val['nama_negara'])+`</td>
                                       <td style="text-align: center;">`+(val['label_status'] == null ? '': val['label_status'])+`</td>
                                       <td style="text-align: center;">
                                          <button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(`+val['id_negara']+`)"><i class="feather icon-edit"></i></button>
                                          <button class="btn waves-effect waves-light btn-danger btn-icon" onclick="Delete(`+val['id_negara']+`)"><i class="fa fa-trash"></i></button>
                                       </td>
                                    </tr>`;
                  });
                
                  $('#tabel-data > tbody:last-child').html(header_table);
                  $('#data-pag').html(json['pag']['label']);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
    

      // Fungsi action sava data
   function SaveData(f) {
    show();

    var formData = new FormData(f);

    $.ajax({
        url: '<?= base_url('negara/SaveData/') ?>',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Reset formulir setelah berhasil
            // $(f).trigger('reset');
            
            // Perbarui data setelah penyimpanan berhasil
            hide();

            // Sembunyikan loading indicator setelah operasi selesai
            hide();

            // Tampilkan alert ketika operasi berhasil
            alert('Data berhasil disimpan.');
            window.location.href = "<?=site_url('Negara/index')?>";
        },
        error: function () {
            // Sembunyikan loading indicator jika terjadi kesalahan
            hide();
            
            // Tampilkan alert ketika terjadi kesalahan
            alert('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            window.location.href = "<?=site_url('Negara/index')?>";
        }
    });

    return false;
}



      //  Fungsi action edit data
    function EditData(id){
      // show();
      $('#m-negara').modal('show');
      $('#m-negara').find('.modal-title').html('Edit Negara');   
      $('#m-negara').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      $.ajax({
               url: "<?=base_url()?>negara/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  // MenuParent();
                  var json = JSON.parse(r);
                  $('#id_negara').val(json['id_negara']);  
                  $('#nama_negara').val(json['nama_negara']);  
                   
               
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }




      function UpdateData(form, id) {
      show();

      var formData = new FormData(form);

      $.ajax({
         url: '<?= base_url('negara/UpdateData/') ?>' + id,
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function (response) {
               // Sembunyikan modal setelah data berhasil diubah
               $('#m-negara').modal('hide');

               // Tampilkan alert ketika operasi berhasil
               alert('Data berhasil diubah.');
               window.location.href = "<?=site_url('Negara/index')?>";

               // Anda mungkin ingin melakukan tindakan lain, seperti memperbarui tampilan
               // atau menyegarkan data setelah berhasil mengubah data.
         },
         error: function () {
               // Tampilkan alert ketika terjadi kesalahan
               alert('Terjadi kesalahan saat mengubah data. Silakan coba lagi.');
               window.location.href = "<?=site_url('Negara/index')?>";
         },
         complete: function () {
               hide();
         }
      });

      return false;
   }




    // Fungsi action delete data
   function Delete(id) {
    // Menampilkan dialog konfirmasi sebelum menghapus
    var isConfirmed = confirm('Apakah Anda yakin ingin menghapus data?');

    // Melanjutkan hanya jika pengguna mengonfirmasi
    if (isConfirmed) {
        $.ajax({
            url: '<?=base_url('negara/')?>Delete/' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function (response) {
                // Tambahkan pemeriksaan respons dari server
                if (response && response.success) {
                    FilterData();
                    hide();
                    // Menampilkan alert ketika operasi berhasil
                    alert('Gagal menghapus data. Silakan coba lagi');
                    // Redirect ke halaman yang diinginkan setelah penghapusan berhasil
                    window.location.href = "<?=site_url('Negara/index')?>";
                } else {
                    // Handle respons yang tidak sesuai dengan harapan
                    console.error('Error respons dari server:', response);
                    // Menampilkan alert ketika operasi gagal
                    alert('Data berhasil dihapus..');
                    window.location.href = "<?=site_url('Negara/index')?>";
                }
            },
            error: function (xhr, status, error) {
                // Handle kesalahan permintaan AJAX
                console.error('Error permintaan AJAX:', status, error);
                // Menampilkan alert ketika terjadi kesalahan AJAX
                alert('Terjadi kesalahan saat menghubungi server. Silakan coba lagi.');
                window.location.href = "<?=site_url('Negara/index')?>";
            }
        });
    }

    return false;
}




//  Fungsi action modul tambah
function AddData(){
      // show();
      $('#m-negara').modal('show');
      $('#m-negara').find('.modal-title').html('Tambah Negara Baru');   
      $('#m-negara').find('form').attr('onsubmit','return SaveData(this)');
      // MenuParent()
    }



      // function MenuParent(){
      //    $.ajax({
      //          url: "<?=base_url()?>negara/LoadDataParent",
      //          type: 'post',
      //          // data: formData,
      //          contentType: false,
      //          processData: false,

      //          success: function(r){
      //             var json = JSON.parse(r);
                
      //             var row = ` <option value=""></option>`;
      //             jQuery.each(json['ms'], function( i, val ) {

      //                row +=`  <option value="`+val['id_negara']+`">`+val['nama_negara']+`</option>`;
      //             });
      //             $('#parent').html(row);
      //             hide ();
      //          }, error: function(){
      //             hide ();
      //          }
      //    });   
      //    return false;
      // }
  


   

   

    
   //  function Delete(id){
   //    $.ajax({
   //       url: '<?=base_url('Negara/')?>Delete/'+id,
   //       type: 'post',
   //       contentType: false,
   //       processData: false,
   //       success: function(r){
   //          FilterData();
          
   //        hide(); 
   //       }, error: function(){
   //          hide(); 
   //       }
   //    });
   //    return false;
   // }
   

   

   


   //  function UpdateData(f,id){
   //    show();
   //    var formData = new FormData($(f)[0]);
   //    // formData.append('id', id);
   //    $.ajax({
   //       url:  '<?=base_url('Negara/')?>UpdateData/'+id,
       
   //       type: 'post',
   //       data: formData,
   //       contentType: false,
   //       processData: false,
   //       success: function(r){
   //          // $(f)[0].reset(); 
   //          // $('#m-menu').modal('hide');
   //         FilterData();
          
   //        hide(); 
   //       }, error: function(){
   //          hide(); 
   //       }
   //    });
   //    return false;
   // }

   // function SaveData(f){
   //    show();
   //    var formData = new FormData($(f)[0]);
   //    // formData.append('id', id);
   //    $.ajax({
   //       url:  '<?=base_url('Negara/')?>SaveData/',
       
   //       type: 'post',
   //       data: formData,
   //       contentType: false,
   //       processData: false,
   //       success: function(r){
   //          // $(f)[0].reset(); 
   //          // $('#MasterIndikator').modal('hide');
          
   //         FilterData();
   //          // ViewDetail(id,date);
   //        hide(); 
   //       }, error: function(){
   //          hide(); 
   //       }
   //    });
   //    return false;
   // }

   
  
// Fungsi agar data tersimpan setelah di edit

   // function ViewDetail(id) {
   // //   show();
    
   //  }
</script>