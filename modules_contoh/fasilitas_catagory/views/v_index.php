
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
                               <?php if (is_sk_manager()): ?>
                               <div class="col-md-4 mb-2">
                                  <div class="form-group">
                                     <label>Unit</label>
                                     <?= render_unit_filter_select('filter_unit', 'FilterData()', 'form-control') ?>
                                  </div>
                               </div>
                               <?php endif; ?>
                               <div class="<?= is_sk_manager() ? 'col-md-8' : 'col-md-12' ?>">
                                  <div class="pull-right putih mb-10">
                                     <a class="btn btn-primary" onclick="AddData()"><i class="fa fa-file-excel-o "></i> Tambah</a>
                                  </div>
                               </div>
                            </div>
                       
                              <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                   <div class="rv-view-switcher">
                                      <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-view-table" onclick="setViewMode('table')"><i class="feather icon-list"></i> Table</button>
                                      <button type="button" class="btn btn-sm btn-outline-primary" id="btn-view-card" onclick="setViewMode('card')"><i class="feather icon-grid"></i> Card</button>
                                   </div>
                                </div>
                                <div class="rv-table-view-container">
                                   <div class="table-responsive rv-table-wrapper">
                                      <table class="table table-condensed table-striped table-bordered" id="tabel-data">
                                 <thead class="thead-blue">
                                    <tr>
                                       <th class="cemter-t">Nama Kategori Peralatan </th>
                                       <th class="cemter-t">Unit </th>
                                       <th class="cemter-t">Status</th>
                                       <th class="cemter-t">Action</th>
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
                   <label class="col-sm-2 col-form-label">Nama Kategori Peralatan</label>
                   <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama" id="nama" >
                   </div>
                </div>
                
                <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Unit</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="id_unit"  id="id_unit">
                         <option value=""></option>
                      </select>
                   </div>
                </div>
             </div>
             <div class="modal-footer">
             <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                
             </div>
          </form>
       </div>
    </div>
 </div>


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
    
      function FilterData(){
         show();
         var formData = new FormData();
         formData.append('filter_unit', $('#filter_unit').val() || '');
       
         $.ajax({
               url: "<?=base_url()?>fasilitas_catagory/LoadData",
               type: 'post',
               data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                  var json = JSON.parse(r);
                  var header_table = "";
                  var cards_html = "";
                  var pag = "";
                  jQuery.each(json['ms'], function( i, val ) {
                     var editBtn = `<button class="btn waves-effect waves-light btn-primary btn-icon" onclick="EditData(${val['id_catagory']})" title="Edit"><i class="feather icon-edit"></i></button>`;
                     var delBtn = `<button class="btn waves-effect waves-light btn-danger btn-icon" onclick="ConfirmData(${val['id_catagory']}, 'delete')" title="Hapus"><i class="fa fa-trash"></i></button>`;

                     header_table +=`<tr>
                                        <td class="font-weight-bold text-primary">${val['nama'] || '-'}</td>
                                        <td><span class="badge badge-light">${val['nama_unit'] || '-'}</span></td>
                                        <td><span class="badge badge-info">${val['status'] || '-'}</span></td>
                                        <td>
                                           ${editBtn}
                                           ${delBtn}
                                        </td>
                                     </tr>`;

                     cards_html += `
                     <div class="rv-card-item">
                        <div class="rv-card-header">
                           <div>
                              <span class="rv-card-title text-primary"><i class="feather icon-tag mr-1"></i> ${val['nama'] || '-'}</span>
                           </div>
                           <span class="badge badge-info">${val['status'] || '-'}</span>
                        </div>
                        <div class="rv-card-body">
                           <div class="rv-card-field">
                              <span class="rv-card-label">Unit</span>
                              <span class="rv-card-val"><span class="badge badge-light">${val['nama_unit'] || '-'}</span></span>
                           </div>
                        </div>
                        <div class="rv-card-footer d-flex justify-content-end" style="gap:5px;">
                           ${editBtn}
                           ${delBtn}
                        </div>
                     </div>`;
                  });
                
                  $('#tabel-data > tbody:last-child').html(header_table);
                  if (cards_html === "") {
                     $('#card-data').html(renderEmptyCard("Belum ada kategori fasilitas"));
                  } else {
                     $('#card-data').html(cards_html);
                  }
                  if (typeof setViewMode === "function") {
                     if (typeof setViewMode === 'function') { setViewMode(typeof MPS_VIEW_MODE !== 'undefined' ? MPS_VIEW_MODE : 'table', false); }
                  }
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
      $('#m-menu').find('.modal-title').html('Tambah Kategori Peralatan');   
      $('#m-menu').find('form').attr('onsubmit','return SaveData(this)');
      LoadUnit();

    }

    function EditData(id){
      // show();
      $('#m-menu').modal('show');
      $('#m-menu').find('.modal-title').html('Ubah Kategori Peralatan');   
      $('#m-menu').find('form').attr('onsubmit','return UpdateData(this,\''+id+'\')');
      LoadUnit();
      $.ajax({
               url: "<?=base_url()?>fasilitas_catagory/EditData/"+id,
               type: 'post',
               // data: formData,
               contentType: false,
               processData: false,

               success: function(r){
                
                  var json = JSON.parse(r);
                  $('#nama').val(json['nama']);  
                  $('#id_unit').val(json['id_unit']);  
               
               }, error: function(){
                  hide ();
               }
         });   
         return false;
    }


    function UpdateData(f,id){
      show();
      var formData = new FormData($(f)[0]);
      // formData.append('id', id);
      $.ajax({
         url:  '<?=base_url('fasilitas_catagory/')?>Update/'+id,
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            $(f)[0].reset(); 
            $('#m-menu').modal('hide');
           FilterData();
           NF(json);
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
         url:  '<?=base_url('fasilitas_catagory/')?>SaveData/',
       
         type: 'post',
         data: formData,
         contentType: false,
         processData: false,
         success: function(r){
            var json = JSON.parse(r);
            // $(f)[0].reset(); 
            // $('#MasterIndikator').modal('hide');
            $('#m-menu').modal('hide');
          
           FilterData();
            // ViewDetail(id,date);
            NF(json);
          hide(); 
         }, error: function(){
            hide(); 
         }
      });
      return false;
   }


   function LoadUnit(){

      $.ajax({
            url: "<?=base_url()?>unit/ListData",
            type: 'post',
            // data: formData,
            contentType: false,
            processData: false,

            success: function(r){
               var json = JSON.parse(r);
               var row = "";
               jQuery.each(json, function( i, val ) {
                  
                  row +=`<option value="`+val['id_unit']+`">`+val['kode_unit']+`</option>`;
               });
            
               $('#id_unit').html(row);
               hide ();
            }, error: function(){
               hide ();
            }
      });   
      return false;
      }

      function DeleteData(id) {
    
         $.ajax({
            url: '<?=base_url('fasilitas_catagory/')?>Delete/' + id,
            type: 'post',
            contentType: false,
            processData: false,
            success: function (r) {
               var json = JSON.parse(r);
               NF(json);
               FilterData();  
            },
            error: function (xhr, status, error) {
               
                  window.location.href = "<?=site_url('Unit/index')?>";
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
</script>