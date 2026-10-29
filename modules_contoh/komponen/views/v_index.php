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

   /* Memaksa tabel overflow dan menampilkan scrollbar */
   .table-responsive {
      display: block;
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin-bottom: 1rem;
   }

   .table-responsive td,
   .table-responsive th {
      white-space: nowrap;
   }

   /* Styling Scrollbar Horizontal agar lebih jelas terlihat */
   .table-responsive::-webkit-scrollbar {
      height: 10px; /* Tinggi scrollbar */
   }
   .table-responsive::-webkit-scrollbar-track {
      background: #f1f1f1; 
      border-radius: 5px;
   }
   .table-responsive::-webkit-scrollbar-thumb {
      background: #888; 
      border-radius: 5px;
   }
   .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #555; 
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

   .center{
   vertical-align: middle;
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
                           <div class="row align-items-center mb-3">
                              <div class="col-12 col-md-6 mb-2">
                                 <a href="<?= base_url('komponen_masuk') ?>" target="_blank" class="btn btn-info btn-sm mr-1 mb-1"><i class="feather icon-download"></i> Log Masuk</a>
                                 <a href="<?= base_url('komponen_terpakai') ?>" target="_blank" class="btn btn-warning btn-sm text-white mb-1"><i class="feather icon-upload"></i> Log Terpakai</a>
                              </div>
                              <div class="col-12 col-md-6 text-md-right mb-2">
                                 <a class="btn btn-primary btn-sm mb-1" onclick="AddData()"><i class="fa fa-plus"></i> Tambah</a>
                              </div>
                           </div>
                           <form id="formFilter" onsubmit="return FilterData(event)">
                              <div class="row">
                                  <div class="col-12 col-md-2 mb-2">
                                     <label>Bulan</label>
                                     <select name="bulan" id="filter_bulan" class="form-control">
                                        <option value="">Semua Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                     </select>
                                  </div>
                                  <div class="col-12 col-md-2 mb-2">
                                     <label>Tahun</label>
                                     <select name="tahun" id="filter_tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                     </select>
                                  </div>
                                  <?php if (is_sk_manager()): ?>
                                  <div class="col-12 col-md-3 mb-2">
                                     <label>Unit</label>
                                     <?= render_unit_filter_select('unit', 'FilterData()', 'form-control') ?>
                                  </div>
                                  <?php endif; ?>
                                  <div class="col-12 col-md-3 mb-2">
                                     <label>Nama Komponen</label>
                                     <input type="text" name="nama_komponen" id="filter_nama" class="form-control" placeholder="Cari nama komponen...">
                                  </div>
                                  <div class="col-12 col-md-2 mb-2 d-flex align-items-end">
                                     <button type="submit" class="btn btn-info w-100"><i class="fa fa-search"></i> Terapkan</button>
                                  </div>
                              </div>
                           </form>
                           <hr>
                               <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                   <div class="rv-view-switcher">
                                      <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                                      <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                                   </div>
                                </div>
                                <div class="rv-table-view-container">
                                   <div class="table-responsive rv-table-wrapper mt-3">
                                  <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                     <thead class="thead-blue">
                                        <tr>
                                           <th class="cemter-t">Nama Komponen</th>
                                           <th class="cemter-t">Jenis Perangkat</th>
                                           <th class="cemter-t">Stok Awal</th>
                                           <th class="cemter-t">Masuk</th>
                                           <th class="cemter-t">Terpakai</th>
                                           <th class="cemter-t">Stok Akhir</th>
                                           <th class="cemter-t">Status</th>
                                           <th class="cemter-t">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Data-AP">
                                    </tbody>
                                 </table>
                                 
                              </div>
                                </div>
                                <div class="rv-card-view-container" style="display:none;">
                                   <div class="rv-cards-grid" id="card-data"></div>
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
<div class="modal fade" id="m-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                   <label class="col-sm-2 col-form-label">Nama Komponen</label>
                   <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_komponen" id="nama_komponen" required>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Jenis Perangkat</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="id_jenisperangkat"  id="id_jenisperangkat" required>
                         <option value=""></option>
                      </select>
                   </div>
                </div>
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Status</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="status"  id="status" required>
                         <option value="1">Active</option>
                         <option value="2">Inactive</option>
                      </select>
                   </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button class="btn btn-primary" onclick="Delete()">YA</button>
             </div>
          </form>
       </div>
    </div>
 </div>

 <!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Notifikasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            Apakah Anda yakin ingin menghapus <span id="deleteItemNama"></span>?
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" id="btnConfirmDelete">Ya</button>
         </div>
      </div>
   </div>
</div>

<!-- Modal Notifikasi Item Dihapus -->
<div class="modal fade" id="NotifModal" tabindex="-1" role="dialog" aria-labelledby="deletedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletedModalLabel">Notifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
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
   var start = "";
   var end = "";
   
      function show () {
         $("#spinner").addClass("show");
      
      }
      function hide () {
         $("#spinner").removeClass("show");
      }
      FilterData();
    
      function FilterData(e){
         if(e) e.preventDefault();
         show();
         
         var formData = new FormData();
         formData.append('bulan', $('#filter_bulan').val());
         formData.append('tahun', $('#filter_tahun').val());
         formData.append('nama_komponen', $('#filter_nama').val());
         if ($('#unit').length > 0) {
            formData.append('unit', $('#unit').val());
         }

         $.ajax({
               url: "<?=base_url()?>komponen/LoadData",
               type: 'post',
               data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var cards_html = "";
                  jQuery.each(json['data'], function( i, val ) {
                     var row = "";
                     if (val['id_unit'] != "0") {
                        row = `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="confirmDelete(`+val['id_komponen']+`, '` + (val['nama_komponen'] || '').replace(/"/g, '&quot;') + `')" title="Hapus"><i class="fa fa-trash"></i></button>`;
                     }else{
                        row ='';
                     }
                     var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(`+val['id_komponen']+`)" title="Edit"><i class="feather icon-edit"></i></button>`;

                     header_table +=`<tr>
                                       <td class="center font-weight-bold text-primary">`+val['nama_komponen']+`</td>
                                       <td class="center"><span class="badge badge-light">`+(val['nama'] == null ? '-': val['nama'])+`</span></td>
                                       <td class="center"><span class="badge badge-secondary" style="font-size: 13px;">`+val['stok_awal']+`</span></td>
                                       <td class="center"><span class="badge badge-info" style="font-size: 13px;">`+val['masuk_periode']+`</span></td>
                                       <td class="center"><span class="badge badge-warning" style="font-size: 13px; color: #fff;">`+val['terpakai_periode']+`</span></td>
                                       <td class="center"><span class="badge badge-success" style="font-size: 13px;">`+val['stok_akhir']+`</span></td>
                                       <td class="center">`+(val['label_status'])+`</td>
                                       <td class="center">
                                          `+editBtn+`
                                          `+row+`
                                       </td>
                                    </tr>`;

                     cards_html += `
                     <div class="rv-card-item">
                        <div class="rv-card-header">
                           <div>
                              <span class="rv-card-title text-primary"><i class="feather icon-cpu mr-1"></i> ${val['nama_komponen'] || '-'}</span>
                              <div class="small text-muted mt-1">Jenis: <span class="badge badge-light">${val['nama'] || '-'}</span></div>
                           </div>
                           <div>${val['label_status'] || ''}</div>
                        </div>
                        <div class="rv-card-body">
                           <div class="row text-center my-2 p-2 bg-light rounded mx-0">
                              <div class="col-3 px-1"><small class="text-muted d-block" style="font-size:10px;">Awal</small><span class="badge badge-secondary">${val['stok_awal']}</span></div>
                              <div class="col-3 px-1"><small class="text-muted d-block" style="font-size:10px;">Masuk</small><span class="badge badge-info">${val['masuk_periode']}</span></div>
                              <div class="col-3 px-1"><small class="text-muted d-block" style="font-size:10px;">Pakai</small><span class="badge badge-warning text-white">${val['terpakai_periode']}</span></div>
                              <div class="col-3 px-1"><small class="text-muted d-block" style="font-size:10px;">Akhir</small><span class="badge badge-success">${val['stok_akhir']}</span></div>
                           </div>
                        </div>
                        <div class="rv-card-footer d-flex justify-content-end" style="gap:5px;">
                           ${editBtn}
                           ${row}
                        </div>
                     </div>`;
                  });
                
                  // Hancurkan DataTable jika sudah ada
                  if (typeof $.fn.DataTable !== 'undefined' && $.fn.DataTable.isDataTable('#tabel-data')) {
                     $('#tabel-data').DataTable().clear().destroy();
                  } else if (typeof $.fn.dataTable !== 'undefined' && $.fn.dataTable.isDataTable('#tabel-data')) {
                     $('#tabel-data').dataTable().fnDestroy();
                  }

                  $('#tabel-data > tbody:last-child').html(header_table);
                  if (cards_html === "") {
                     $('#card-data').html(renderEmptyCard("Tidak ada data komponen"));
                  } else {
                     $('#card-data').html(cards_html);
                  }

                  // Inisialisasi DataTable dengan paging
                  if (typeof $.fn.DataTable !== 'undefined') {
                     $('#tabel-data').DataTable({
                        "paging": true,
                        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                        "pageLength": 10,
                        "searching": false, // Kita sudah buat filter nama manual di atas
                        "bInfo" : true
                     });
                  } else if (typeof $.fn.dataTable !== 'undefined') {
                     $('#tabel-data').dataTable({
                        "paging": true,
                        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                        "pageLength": 10,
                        "searching": false, // Kita sudah buat filter nama manual di atas
                        "bInfo" : true
                     });
                  }

                  if (typeof setViewMode === 'function') {
                     setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false);
                  }
               },
               error: function(){
                  console.error('AJAX error loading komponen');
               },
               complete: function(){
                  hide();
               }
         });   
         return false;
      }
    
      function MenuParent(){
         $.ajax({
               url: "<?=base_url()?>komponen/LoadDataParent",
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                
                  var row = ` <option value=""></option>`;
                  jQuery.each(json['perangkat'], function( i, val ) {

                     row +=`  <option value="`+val['id_jenisperangkat']+`">`+val['nama']+`</option>`;
                  });
                  $('#id_jenisperangkat').html(row);
                  hide ();
               }, error: function(){
                  hide ();
               }
         });   
         return false;
      }
  
    
    function AddData(){
      // show();
      $('#m-menu').modal('show');
      $('#m-menu').find('.modal-title').html('Tambah Komponen Baru');   
      $('#m-menu').find('form').attr('onsubmit','return SaveData(this)');
      MenuParent();

    }

    function EditData(id){
      // show();
      $('#m-menu').modal('show');
      $('#m-menu').find('.modal-title').html('Edit Komponen');   
      $('#m-menu').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      $.ajax({
               url: "<?=base_url()?>komponen/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  MenuParent();
                  var json = JSON.parse(r);
                  $('#nama_komponen').val(json['nama_komponen']);  
                  $('#id_jenisperangkat').val(json['id_jenisperangkat']);  
                  console.log(json);  
               
               }, error: function(){
                  hide ();
               }
         }); 
         return false;
    }

    function Delete(id){
      // show();
      // $('#m-menu').modal('show');
      // $('#m-menu').find('.modal-title').html('Infomation Realisasi Kinerja');   
      // $('#Mm-menu').find('form').attr('onsubmit','return SaveData(this)');
      // MenuParent();
      $.ajax({
         url:  '<?=base_url('komponen/')?>Delete/'+id,
       
         type: 'post',
         //data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
            
            FilterData();
            // ViewDetail(id,date);
            hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
    }


    function UpdateData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('komponen/')?>Update/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
             $(f)[0].reset(); 
             $('#m-menu').modal('hide');
             $('#NotifModal').modal('show');
             $('#NotifModal').find('.modal-body').html('Data berhasil diubah');

           FilterData();;
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
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
         url:  '<?=base_url('komponen/')?>SaveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            // $(f)[0].reset(); 
            $('#m-menu').modal('hide');
            $('#NotifModal').modal('show');
            $('#NotifModal').find('.modal-body').html('Data berhasil ditambahkan');
           FilterData();
           MenuParent();
            // ViewDetail(id,date);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });

      return false;
   }


   function confirmDelete(id, nama_komponen) {
      $('#confirmModal').modal('show');
      $('#deleteItemNama').text(nama_komponen);

      // Fungsi untuk mengeksekusi delete jika tombol "Ya" ditekan
      $('#btnConfirmDelete').click(function() {
         $('#confirmModal').modal('hide');
         Delete(id);
         $('#NotifModal').modal('show');
         $('#NotifModal').find('.modal-body').html('Data berhasil dihapus');
      });
   }


</script>